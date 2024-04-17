<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;
use App\Http\Requests\StorePayrollRequest;
use App\Models\Collaborator;
use App\Models\Request as PayrollRequest;
use App\Models\RequestDetails;
use App\Models\Notification;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\EnterpriseConfig;
use App\Mail\reverseMail;
use App\Mail\RequestToDesperse;
use App\Mail\RequestDecline;
use App\Mail\RequestReverse; //correo al colaborador

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $mesActual = Carbon::now()->month;
        $payrollRequests = PayrollRequest::select('requests.*')
        ->where('enterprise_id', Auth::user()->collaborator->enterprise_id)
        ->join('collaborators', 'collaborators.id', '=', 'requests.collaborator_id')
        ->whereMonth('requests.created_at', $mesActual)
        ->orderBy('requests.created_at', 'ASC')
        ->paginate(10);
       
        if($request->id){
            Notification::where('id', $request->id)
            ->update(['status' => 1]);
        }
        
        return view('requests.index', compact('payrollRequests'));
    }


    public function create()
    {
        // 
    }

    public function myRequests()
    {
        $requests = PayrollRequest::where('collaborator_id', Auth::user()->collaborator->id)->orderBy('created_at', 'DESC')->paginate(10);

        return view('requests.myRequests', compact('requests'));
    }

    public function store(StorePayrollRequest $request)
    {
        $today = now()->toImmutable();
        $startsIn = Carbon::parse($request->period_start_date);
        $collaborator = Collaborator::where('id', $request->collaborator_id)->where('is_currently', 1)->first();

        $payrollRequests = PayrollRequest::where('collaborator_id', $collaborator->id)
            ->where('resolution', true)
            ->where('dispersed', true)
            ->whereBetween('created_at', [$request->period_start_date, $request->period_end_date])
            ->orderBy('id', 'ASC')
            ->get();

        $requestsToPay = $collaborator->requestPayments()
            ->whereDate('paydate_limit', '<', $today)
            ->where('to_liquidate', '>', 0)
            ->where('its_paid', FALSE)
            ->where('status', '!=', 'COMPLETADO')
            ->get();

        $primaryBankAccount = BankAccount::where('collaborator_id', $collaborator->id)
            ->where('is_primary', TRUE)->first();

        $enterpriseConfig = EnterpriseConfig::where('enterprise_id', $collaborator->enterprise_id)->first();
        $salaryLimit = 0;
        $daysWorked = $startsIn->diffInDays($today);
        $untilNow = ($daysWorked * $collaborator->daily_salary);
        $availableSalary = $request->available_salary;
        $applyUntil = $request->apply_until;
        $canAdvancePayroll = false;
        $advanceSalary = 0;

        if (count($payrollRequests) > 0) {
            foreach ($payrollRequests as $payrollRequest) {
                $advanceSalary += $payrollRequest->details->total_amount;
            }
        }

        if ($enterpriseConfig->set_limit) {
            $forAmount = $enterpriseConfig->max_amount_request;
            $forPercent = $enterpriseConfig->max_percent_request;

            switch (true) {
                case $forAmount: // Por Monto
                    $salaryLimit = $forAmount;
                    
                    break;

                case $forPercent: // Por Porcentaje
                    $salaryLimit = $collaborator->current_salary * ($forPercent / 100);

                    break;
                
                default:
                    $salaryLimit = $collaborator->current_salary;
                    
                    break;
            }

            if ($availableSalary + $advanceSalary >= $salaryLimit) {
                $availableSalary = ($salaryLimit - $advanceSalary);
            }
        }

        if (!is_null($collaborator) &&
            // $availableDays > 0 &&
            $request->total_amount <= $availableSalary &&
            count($payrollRequests) < 3 &&
            count($requestsToPay) == 0 &&
            $today < $applyUntil &&
            $request->request_amount >= 200 &&
            !is_null($primaryBankAccount)
        ) {
            $canAdvancePayroll = true;
        }
        
        if ($canAdvancePayroll) {
            try {
                DB::beginTransaction();
                $payrollRequest = PayrollRequest::create([
                    'status' => 'PENDIENTE',
                    'resolution' => NULL,
                    'dispersed' => FALSE,
                    'notice_privacy_accepted' => TRUE,
                    'salary_retention_accepted' => TRUE
                ]);
                $collaborator->payrollRequests()->save($payrollRequest);

                PayrollRequest::where('id', $payrollRequest->id)->update([
                    'invoice' => $collaborator->id .
                        $payrollRequest->id .
                        $payrollRequest->created_at->format('dmyhi')
                ]);

                $payrollRequestDetails = RequestDetails::create([
                    // 'request_days' => $request->request_days,
                    'period_start_date' => $request->period_start_date,
                    'period_end_date' => $request->period_end_date,
                    'request_amount' => $request->request_amount,
                    'comission' => $request->comission,
                    'tax' => $request->tax,
                    'total_amount' => $request->total_amount,
                    'payment_date' => $request->payment_date
                ]);
                $payrollRequest->details()->save($payrollRequestDetails);
                    
                DB::afterCommit(function () use($collaborator, $payrollRequestDetails) {
                    $usersToSend = User::where('state', 1)->whereHas('roles', function ($role) {
                        $role->where('name', 'Tesorero');
                    })->get();           

                    $notification = Notification::create([
                        'role_name' => 'Tesorero',
                        'title' => 'Dispersión de Adelanto de Nómina',
                        'content' => $collaborator->getFullName() . ' ha solicitado un adelanto de $' . number_format($payrollRequestDetails->request_amount, 2) . ' MXN.',
                        'type' => 'Solicitud',
                        'redirect_to' => 'dispersed',
                        'status' => 0,
                    ]);
                    
                    foreach ($usersToSend as $user) {
                        Mail::to($user)->send(new RequestToDesperse($collaborator, $payrollRequestDetails, $user));
                    }
                });

                DB::commit();

                return redirect()->route('requests.my-requests')->with('success', 'Tu solicitud ha sido realizada correctamente.');
    
            } catch (Throwable $e) {
                DB::rollback();
                
                return redirect()->route('home')->with('error', $e);
            }
        } else {
            return redirect()->route('home')->with('error', 'Parece que no cumples con los requisitos mínimos para poder disponer de un adelanto.');
       
        }
    }

    public function destroy($id)
    {
        //
    }

    public function calculate(Request $request)
    {
        $collaborator = Auth::user()->collaborator;
        // $dailySalary = $collaborator->daily_salary;
        // $requestDays = $request->request_days;
        $requestAmount = $request->request_amount;
        $comission = $requestAmount * 0.08;
        $tax = $comission * 0.16;
        $totalAmount = $requestAmount + $comission + $tax;

        return response()->json([
            // 'days' => $requestDays,
            'amount' => $requestAmount,
            'comission' => $comission,
            'tax' => $tax,
            'totalAmount' => $totalAmount,
        ], 200);
    }


    public function startProcess($id)
    {

      $requests = PayrollRequest::find($id);

        if($requests) {
            $requests->status = 'EN PROCESO';
            $requests->updated_by = Auth::user()->id;
            $requests->save();
        }
    
        return redirect()->back()->with('success', 'Has tomado la solicitud con Folio: '.$id.', termina el proceso.'); // Redireccionar a la misma página
    }

    public function reverse($id)
    {

      $requests = PayrollRequest::find($id);
        if($requests) {
            $requests->status = 'PENDIENTE';
            $requests->resolution = null;
            $requests->updated_by = null;
            $requests->dispersed = '0';
            $requests->save();
        }
    
        //si ya esta dispersada, y reversa. notificacion para empresa, colaborador y correo para colaborador
        return redirect()->back()->with('success', 'La solicitud con Folio: '.$id.', fue Reversada con éxito.'); // Redireccionar a la misma página
    }

    public function decline(Request $request)
    {    
        
        // dd($payrollRequest);
        $payrollRequest = PayrollRequest::findOrFail($request->idRequestsDecline);
        $collaborator = Collaborator::where('id', $payrollRequest->collaborator_id)->where('is_currently', 1)->first();

      
        $payrollRequest->status = 'RECHAZADA';
        $payrollRequest->resolution = '0';
        $payrollRequest->dispersed = '0';
        $payrollRequest->updated_by = Auth::user()->id;
        $payrollRequest->save();

        RequestDetails::where('request_id', $request->idRequestsDecline)->update([
            'observation' => mb_strtoupper($request->observation, 'UTF-8')
        ]);
                 
        //Notificacion y mandar correo al colaborador
        Mail::to($payrollRequest->collaborator->user->email)->send(new RequestDecline($collaborator, $payrollRequest));

        $new_notification = Notification::create([
            'title' => 'Resolución de Solicitud',
            'content' => 'Lo sentimos tu solicitud fue Rechazada',
            'status' => '0',
            'role_name' => 'Colaborador',
            'user_id' => $payrollRequest->collaborator->user->id,
            'tipo' => 'Solicitud',
            'redirect_to' => 'requests.my-requests',
        ]);
        
        // Notificacion a la empresa 
        $new_notification_enterprise = Notification::create([
            'title' => 'Resolución de Solicitud',
            'content' => 'La solicitud de: ' . $collaborator->getFullName() .' fue Rechazada',
            'status' => '0',
            'role_name' => 'Manager',
            'enterprise_id' => $payrollRequest->collaborator->enterprise_id,
            'tipo' => 'Solicitud',
            'redirect_to' => 'requests',
        ]);        
       
        return redirect()->back()->with('success', 'Datos actualizados correctamente');

    }

    public function dispersedReverse(Request $request)
    {

      $payrollRequest = PayrollRequest::find($request->idRequestsReverse);
      $collaborator = Collaborator::where('id', $payrollRequest->collaborator_id)->where('is_currently', 1)->first();

        if($payrollRequest) {
            $payrollRequest->status = 'PENDIENTE';
            $payrollRequest->resolution = null;
            $payrollRequest->updated_by = null;
            $payrollRequest->dispersed = '0';
            $payrollRequest->updated_by = Auth::user()->id;
            $payrollRequest->save();
        }
    
        RequestDetails::where('request_id', $request->idRequestsReverse)->update([
            'observation' => mb_strtoupper($request->observation, 'UTF-8')
        ]);

        //notificacion y correo para colaborador
        $new_notification = Notification::create([
            'title' => 'Dispersión Reversada',
            'content' => 'Lo sentimos tu solicitud fue Reversada, revisa tu correo electronico',
            'status' => '0',
            'role_name' => 'Colaborador',
            'user_id' => $payrollRequest->collaborator->user->id,
            'tipo' => 'Solicitud',
            'redirect_to' => 'requests.my-requests',
        ]);
        
        Mail::to($payrollRequest->collaborator->user->email)->send(new RequestReverse($collaborator,$payrollRequest));

        //Notificacion y correo a la empresa
         $new_notification_enterprise = Notification::create([
            'title' => 'Dispersión Reversada',
            'content' => 'La solicitud de: ' . $collaborator->getFullName() .' fue Reversada, revisa tu correo electronico',
            'status' => '0',
            'role_name' => 'Manager',
            'enterprise_id' => $payrollRequest->collaborator->enterprise_id,
            'tipo' => 'Solicitud',
            'redirect_to' => 'requests',
        ]);             
        Mail::to($payrollRequest->collaborator->enterprise->collaboratorInCharge->email)->send(new reverseMail($payrollRequest));


        
        return redirect()->back()->with('success', 'La solicitud con Folio: '.$request->idRequestsReverse.', fue Reversada con éxito.'); // Redireccionar a la misma página
    }

    public function allRequests()
    {
        $allRequests = PayrollRequest::orderBy('created_at', 'DESC')->paginate(10);

        return view('requests.allRequests', compact('allRequests'));
    }
}