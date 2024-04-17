<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Throwable;
use App\Models\Enterprise;
use App\Models\Collaborator;
use App\Models\Manager;
use App\Models\User;
use App\Models\Catalog;
use App\Models\EnterpriseConfig;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\userCredentials;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePreferencesRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreConfigRequest;


class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $nameEnterprise =  mb_strtoupper($request->get('name_enterprise'), 'UTF-8');
        // $enterprises = Enterprise::name($nameEnterprise)->paginate();
        $enterprises = Enterprise::/* where('id', '!=', 1)-> */paginate(10);

        return view('clients.enterprises.index', compact('enterprises','nameEnterprise'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $payments_schemes = Catalog::where('code','CAT_PAY_SCHEME')->first()->catItems()->get();
        return view('clients.enterprises.register',compact('payments_schemes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $reglas = [
                'name_enterprise' => 'required|string',
                'rfc' => 'required|string',
                'phone' => 'required|regex:/^[0-9]{10}$/',
                'street' => 'required|string',
    
            ];
    
            //mensajes personalizados para las reglas de validación
            $mensajes = [
                'name_enterprise.required' => 'El campo Nombre de Empresa es obligatorio.',
                'rfc.required' => 'El campo RFC es obligatorio.',
                'phone.required' => 'El campo teléfono es obligatorio.',
                'phone.regex' => 'El formato del número de teléfono no es válido.',
                'street.required' => 'El campo Calle es obligatorio.',

            ];
    
            // Ejecuta la validación
            $validador = Validator::make($request->all(), $reglas, $mensajes);
    
            // Verifica si la validación ha fallado
            if ($validador->fails()) {
                return redirect()->back()
                    ->withErrors($validador)
                    ->withInput(); // Para repoblar los campos del formulario con los valores anteriores
            }

            
            $enterprise = new Enterprise();
            // $enterprise->payment_scheme_id = $request->payment_scheme;
            $enterprise->name = mb_strtoupper($request->input('name_enterprise'), 'UTF-8');
            $enterprise->rfc = mb_strtoupper($request->input('rfc'), 'UTF-8');
            $enterprise->phone = $request->input('phone');
            $enterprise->ext = $request->input('ext');
            $enterprise->street = mb_strtoupper($request->input('street'), 'UTF-8');
            $enterprise->out_num = $request->input('out_num');
            $enterprise->int_num = $request->input('int_num');
            $enterprise->cp = $request->input('cp');
            $enterprise->status = 'ACTIVO';
            $enterprise->city = mb_strtoupper($request->input('city'), 'UTF-8');
            $enterprise->suburb = mb_strtoupper($request->input('suburb'), 'UTF-8');
            $enterprise->state = mb_strtoupper($request->input('state'), 'UTF-8');
            $enterprise->save();

            EnterpriseConfig::create([
                'enterprise_id' => $enterprise->id,
                'payment_scheme_id' => $request->payment_scheme
            ]);

            $collaborator = Collaborator::create([
                'first_name' => mb_strtoupper($request->first_name, 'UTF-8'),
                'second_name' => mb_strtoupper($request->second_name, 'UTF-8'),
                'first_surname' => mb_strtoupper($request->first_surname, 'UTF-8'),
                'last_surname' => mb_strtoupper($request->last_surname, 'UTF-8'),
                'curp' => mb_strtoupper($request->curp, 'UTF-8'),
                'phone' => $request->phone_employee,
                'enterprise_id' => $enterprise->id,
                'status' => 'ACTIVO'
            ]);

            $enterprise->manager_id = $collaborator->id;
            $enterprise->save();

            $password = Str::random(8);
            $user = User::create([
                'collaborator_id' => $collaborator->id,
                'email' => $request->email,
                'password' => Hash::make($password),
                'state' => 1
            ]);

            $role = Role::where('name', 'Manager')->first();
            $user->assignRole($role);

            Mail::to($user->email)->send(new userCredentials($user, $password));

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            
            return redirect()->route('clients.enterprises.register')->with('error', $e->getMessage()/* 'Ha ocurrido un error y no hemos podido registrar la empresa' */);
        }

        return redirect()->route('clients.enterprises')->with('message', 'Empresa guardada exitosamente');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(/* $id */)
    {
        return view('clients.enterprises.details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $enterprise = Enterprise::where('id', $id)->first();
        $payments_schemes = Catalog::where('code','CAT_PAY_SCHEME')->first()->catItems()->get();
        return view('clients.enterprises.edit', compact('enterprise', 'payments_schemes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Enterprise::where('id', $id)->update([
            'payment_scheme_id' => $request->payment_scheme,
            'name' => mb_strtoupper($request->name_enterprise, 'UTF-8'),
            'rfc' => mb_strtoupper($request->rfc, 'UTF-8'),
            'phone' => $request->phone,
            'ext' => $request->ext,
            'street' => mb_strtoupper($request->street, 'UTF-8'),
            'out_num' => $request->out_num,
            'int_num' => $request->int_num,
            'cp' => $request->cp,
            'city' => $request->city,
            'state' => $request->state,
            'suburb' => $request->suburb,
        ]);

        return redirect()->route('clients.enterprises')->with('message', 'Empresa actualizada exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function preferences()
    {   
        $enterprise = Enterprise::findOrFail(Auth::user()->collaborator->enterprise_id);
        $payments_schemes = Catalog::where('code','CAT_PAY_SCHEME')->first()->catItems()->get();
        return view('myCompany.preferences.index', compact('enterprise', 'payments_schemes'));
    }

    public function updatePreferences(StorePreferencesRequest $request, $id)
    {
        Enterprise::where('id', $id)->update([
            'payment_scheme_id' => $request->payment_scheme,
            'phone' => $request->phone,
            'ext' => $request->ext,
            'street' => mb_strtoupper($request->street, 'UTF-8'),
            'out_num' => $request->out_num,
            'int_num' => $request->int_num,
            'cp' => $request->cp,
            'city' => $request->city,
            'state' => $request->state,
            'suburb' => $request->suburb
        ]);

        if ($request->allCollabs) {
            Collaborator::where('enterprise_id', $id)->where('payment_scheme_id', '!=', null)
                ->update(['payment_scheme_id' => null]);
        }

        return redirect()->route('my-company.preferences')->with('message', 'Datos actualizados exitosamente');

    }

    public function config($id)
    {
        $enterprise = Enterprise::where('id', $id)->first();

        return view('clients.enterprises.config', compact('enterprise'));
    }

    public function updateConfig(StoreConfigRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $enterpriseConfig = EnterpriseConfig::where('enterprise_id', $id)
                ->update([
                    'set_limit' => $request->set_limit,
                    'is_max_amount' => $request->is_max_amount,
                    'max_amount_request' => $request->max_amount_request,
                    'is_max_percent' => $request->is_max_percent,
                    'max_percent_request' => $request->max_percent_request
                ]);

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Ocurrió un error, y no hemos podido guardar la configuración.');
        }

        return redirect()->back()->with('success', 'Configuración actualizada correctamente.');
    }

    public function search(Request $request)
    {
        $query = trim($request->data);
        $enterprises = Enterprise::join('collaborators', 'enterprises.manager_id', 'collaborators.id')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->select('enterprises.id', 'name', 'logo', 'first_name', 'second_name', 
                'first_surname', 'last_surname', 'enterprises.status')
            ->get();
        
        return response()->json(['enterprises' => $enterprises], 200);
    }
}
