<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Solicitud;
use App\Models\Cliente;
use App\Models\VariablesRiesgo;
use App\Models\Analisis_credito;
use App\Models\TablaAmortizacion;
use DateTime;
use Carbon\Carbon;
use App\Exports\ColocacionExport;
use Maatwebsite\Excel\Facades\Excel;


class AnalisisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name =  mb_strtoupper($request->get('txt_name'), 'UTF-8');

        if($request->estatus){
            $solicitudes = Solicitud::select('solicituds.*')
            ->where('solicituds.estatus', $request->estatus)->name($name)
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else if($name){
            $solicitudes = Solicitud::select('solicituds.*')
            ->name($name)
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else{
            $solicitudes = Solicitud::select('solicituds.*')
            ->name($name)
            ->where('solicituds.estatus', 'Pendiente')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }

        $statePendiente = Solicitud::where('estatus', 'Pendiente')->get();
        $stateProceso = Solicitud::where('estatus', 'Proceso')->get();
        $stateTerminado = Solicitud::where('estatus', 'Autorizado')->get();
        $statePre = Solicitud::where('estatus', 'Pre-autorizado')->get();
        $stateRechazado = Solicitud::where('estatus', 'Rechazado')->get();

       
        return view('analisis.index', compact('solicitudes','name','statePendiente','stateProceso','statePre','stateTerminado','stateRechazado'));
    }

 
    public function edit($id)
    {
        // dd($id);
        $solicitud = Solicitud::find($id);
        $clientes = Cliente::all();
        $opcionCliente = "N/A";
        if($solicitud->cliente()->first('id') != null){
            $opcionCliente = $solicitud->cliente()->first('id')->id;
        }
        if($solicitud->estatus != 'Pre-autorizado'){
            Solicitud::where('id', $id)->update([
                'estatus' => 'Proceso',
                'users_id_analisis' => auth()->user()->id,
            ]);
        }
      
        return view('analisis.analisisRiesgo', compact('solicitud','clientes','opcionCliente'));
    }

    public function store(Request $request)
    {
        if($request->estatus_analisis == 'Autorizado' || $request->estatus_analisis == 'Rechazado'){
            Cliente::where('id', $request->input('cliente_id'))->update([
                'banco' => mb_strtoupper($request->banco,'UTF-8'),
                'numero_tarjeta' => $request->input('num_tarjeta'),
                'clave_interbancaria' => $request->input('clabe'),
                'numero_cuenta' => $request->input('num_cuenta'),
            ]);

            Analisis_credito::where('solicituds_id',$request->input('idSolicitud'))->update([
                'estatus' => $request->input('estatus_analisis'),
            
            ]);

            Solicitud::where('id', $request->input('idSolicitud'))->update([
                'estatus' => $request->input('estatus_analisis'),
            ]);
        }else{
            $analisis = new Analisis_credito();
            $analisis->solicituds_id = $request->input('idSolicitud');
            $analisis->users_id = auth()->user()->id;
            $analisis->monto_solicitado = (str_replace(",","",$request->input('monto_solicitado')));
            $analisis->monto_autorizado = (str_replace(",","",$request->input('monto_autorizado')));
            $analisis->total = (str_replace(",","",$request->input('total')));
            $analisis->pago_semanal = (str_replace(",","",$request->input('pago_semanal')));
            $analisis->capacidad_pago = $request->input('capPago');
            $analisis->estatus = 'Pre-autorizado';
            $analisis->save();
            $idAnalis= $analisis["id"];
            $dateD =  str_replace('/', '-', $request->input('fdesembolso'));
            $dateP =  str_replace('/', '-', $request->input('fprimer_pago'));
            $dateV =  str_replace('/', '-', $request->input('fvencimiento'));


            Solicitud::where('id', $request->input('idSolicitud'))->update([
                'estatus' => 'Pre-autorizado',
                'fecha_desembolso' => date('Y-m-d', strtotime($dateD)),
                'fecha_primer_pago' => date('Y-m-d', strtotime($dateP)),
                'fecha_vencimiento' => date('Y-m-d', strtotime($dateV)),
            ]);
            
            $this->guardarTablaAmortizacion($request,$idAnalis);
        }
        // $this->guardarTablaAmortizacion($request);
        return redirect()->route('admin.analisis_credito.index');
    }

    public function show($id)
    {
        //
    }
    
    public function guardarTablaAmortizacion(Request $request,$idAnalis)
    {
        $plazo = $request->plazo;
        $frecuencia_pago = $request->frecuencia_pago;
        $monto_solicitado = (str_replace(",","",$request->monto_solicitado));
        $monto_autorizado = (str_replace(",","",$request->monto_autorizado));
        $tasa = $request->tasa; ////40
        $iva = (($request->tasa_iva / 100) * $tasa);
        $tasaInteres = $tasa + $iva;

        $porcentaje = $tasaInteres * (1/100);

        $saldo = (($monto_autorizado * $porcentaje) + $monto_autorizado); ////3500
        $capital = $monto_autorizado / $plazo; //178.77;
        $cuota = $saldo / $plazo; // 250;
        $interes = ($monto_autorizado * $porcentaje) / $plazo;
        $plazo = range(1,$plazo);
        $gasto_por_cobranza = '10.00';
        $dateS =  str_replace('/', '-', $request->fdesembolso);
        $fecha_desembolso = date('Y-m-d', strtotime($dateS));
        $fecha_pago = Carbon::parse($fecha_desembolso);
        $count = 0;

        $fecha_proporcionada = $fecha_desembolso; // Fecha proporcionada en formato "año-mes-día"
        $numero_dia_semana = date('N', strtotime($fecha_proporcionada));
        if($numero_dia_semana == 1){
            $dias = 5;
        }else if($numero_dia_semana == 2){
            $dias = 4;
        }else if($numero_dia_semana == 3){
            $dias = 3;
        }else if($numero_dia_semana == 4){
            $dias = 2;
        }else if($numero_dia_semana == 5){
            $dias = 8;
        }else if($numero_dia_semana == 6){
            $dias = 7;
        }
        
    
        $datos= [
            'mes' => "",
            'cuota' => "-- --",
            'saldo' => number_format($saldo, 2),
            'capital' => "-- --",
            'interes' => "-- --",
            'gasto_por_cobranza' => $gasto_por_cobranza,
            'fecha_pago' => $fecha_pago,
        ];
        $tabla[] = $datos;

        foreach($plazo as $plazos) {
            $count ++ ;
            $tablaAmort = new TablaAmortizacion();
            if (empty($mes_anterior)) {
                // primero
                $saldo = $saldo - $cuota;
                $dateS =  str_replace('/', '-', $request->txt_fdesembolso);
                $fecha_desembolso = date('Y-m-d', strtotime($dateS));
                $fecha_pago = Carbon::parse($fecha_desembolso);
                $fecha_pago->addDays($dias)->format('d/m/Y');
                $calculo_mes = [
                    'mes' => $plazos,
                    'cuota' => number_format($cuota, 2),
                    'saldo' => number_format($saldo, 2),
                    'capital' => round($capital, 2),
                    'interes' => round($interes, 2),
                    'gasto_por_cobranza' => $gasto_por_cobranza,
                    'fecha_pago' => $fecha_pago,
                ];
                $tablaAmort->analisis_credito_id = $idAnalis;
                $tablaAmort->solicituds_id = $request->input('idSolicitud');
                $tablaAmort->fecha_pago = $fecha_pago;
                $tablaAmort->pago = $cuota;
                $tablaAmort->capital = $capital;
                $tablaAmort->interes = $interes;
                $tablaAmort->saldo_pendiente = $saldo;
                $tablaAmort->gasto_x_cobranza = $gasto_por_cobranza;
                $tablaAmort->num_pago = $count;
                $tablaAmort->save(); 

                $tabla[] = $calculo_mes;
            } else {
                // calcular
                $saldo = $saldo - $cuota;
                $fecha_pago = Carbon::parse($mes_anterior['fecha_pago']);
                if($frecuencia_pago == 'DIARIO'){
                    $fecha_pago->addDays(1)->format('d/m/Y');
                }else if($frecuencia_pago == 'SEMANAL'){
                    $fecha_pago->addDays(7)->format('d/m/Y');
                }else if($frecuencia_pago == 'QUINCENAL'){
                    $fecha_pago->addDays(15)->format('d/m/Y');
                }else if($frecuencia_pago == 'MENSUAL'){
                    $fecha_pago->addDays(30)->format('d/m/Y');
                }else{
                    $fecha_pago->addDays(7)->format('d/m/Y');
                }
                // if ($saldo < $cuota) {
                //     $cuota = $saldo;
                // }

                $calculo_mes = [
                    'mes' => $plazos,
                    'cuota' => number_format($cuota, 2),
                    'saldo' => number_format($saldo, 2),
                    'capital' => round($capital, 2),
                    'interes' => round($interes, 2),
                    'gasto_por_cobranza' => $gasto_por_cobranza,
                    'fecha_pago' => $fecha_pago,
                ];
                $tablaAmort->analisis_credito_id = $idAnalis;
                $tablaAmort->solicituds_id = $request->input('idSolicitud');
                $tablaAmort->fecha_pago = $fecha_pago;
                $tablaAmort->pago = $cuota;
                $tablaAmort->capital = $capital;
                $tablaAmort->interes = $interes;
                $tablaAmort->saldo_pendiente = $saldo;
                $tablaAmort->gasto_x_cobranza = $gasto_por_cobranza;
                $tablaAmort->num_pago = $count;
                $tablaAmort->save(); 
                $tabla[] = $calculo_mes;
            }
            $mes_anterior = $calculo_mes;
        }
    }

    public function tablaAmortizacion(Request $request)
    {
        $plazo = $request->plazo;
        $frecuencia_pago = $request->frecuencia_pago;
        $monto_solicitado = (str_replace(",","",$request->monto_solicitado));
        $monto_autorizado = (str_replace(",","",$request->monto_autorizado));
        $tasa = $request->tasa; ////40
        $iva = (($request->tasaIva / 100) * $tasa);
        $tasaInteres = $tasa + $iva;

        $porcentaje = $tasaInteres * (1/100);
        $saldo = (($monto_autorizado * $porcentaje) + $monto_autorizado); ////3500
        $capital = $monto_autorizado / $plazo; //178.77;
        $cuota = $saldo / $plazo; // 250;
        $interes = ($monto_autorizado * $porcentaje) / $plazo;
        $tabla = [];
        $mes_anterior = [];
        $plazo = range(1,$plazo);
        $gasto_por_cobranza = '10.00';
        $dateS =  str_replace('/', '-', $request->fecha_desembolso);
        $fecha_desembolso = date('Y-m-d', strtotime($dateS));
        $fecha_pago = Carbon::parse($fecha_desembolso);
        

        $datos= [
            'mes' => "",
            'cuota' => "-- --",
            'saldo' => number_format($saldo, 2),
            'capital' => "-- --",
            'interes' => "-- --",
            'gasto_por_cobranza' => $gasto_por_cobranza,
            'fecha_pago' => $fecha_pago,
        ];
        $tabla[] = $datos;

        foreach($plazo as $plazos) {
            if (empty($mes_anterior)) {
                // primero
                $saldo = $saldo - $cuota;
                $dateS =  str_replace('/', '-', $request->fecha_desembolso);
                $fecha_desembolso = date('Y-m-d', strtotime($dateS));
                $fecha_pago = Carbon::parse($fecha_desembolso);
                $fecha_pago->addDays(7)->format('d/m/Y');
                $calculo_mes = [
                    'mes' => $plazos,
                    'cuota' => number_format($cuota, 2),
                    'saldo' => number_format($saldo, 2),
                    'capital' => round($capital, 2),
                    'interes' => round($interes, 2),
                    'gasto_por_cobranza' => $gasto_por_cobranza,
                    'fecha_pago' => $fecha_pago,
                ];
                $tabla[] = $calculo_mes;
            } else {
                // calcular
                $saldo = $saldo - $cuota;
                $fecha_pago = Carbon::parse($mes_anterior['fecha_pago']);
                if($frecuencia_pago == 'DIARIO'){
                    $fecha_pago->addDays(1)->format('d/m/Y');
                }else if($frecuencia_pago == 'SEMANAL'){
                    $fecha_pago->addDays(7)->format('d/m/Y');
                }else if($frecuencia_pago == 'QUINCENAL'){
                    $fecha_pago->addDays(15)->format('d/m/Y');
                }else if($frecuencia_pago == 'MENSUAL'){
                    $fecha_pago->addDays(30)->format('d/m/Y');
                }else{
                    $fecha_pago->addDays(7)->format('d/m/Y');
                }

                $calculo_mes = [
                    'mes' => $plazos,
                    'cuota' => number_format($cuota, 2),
                    'saldo' => number_format($saldo, 2),
                    'capital' => round($capital, 2),
                    'interes' => round($interes, 2),
                    'gasto_por_cobranza' => $gasto_por_cobranza,
                    'fecha_pago' => $fecha_pago,
                ];
                $tabla[] = $calculo_mes;
            }
            $mes_anterior = $calculo_mes;
        }
        return json_encode($tabla);
    }

    public function autorizacion(Request $request)
    {
        // dd($request);
        if($request->has('Rechazado') === true) {
            // Lógica si se presiona el botón "Guardar"
            Analisis_credito::where('solicituds_id',$request->input('idSolicitud'))->update([
                'estatus' => 'Rechazado',
                'comentarios' => $request->observaciones,
            
            ]);

            Solicitud::where('id', $request->input('idSolicitud'))->update([
                'estatus' => 'Rechazado',
            ]);
        }elseif ($request->has('Autorizado') == true) {
            // Lógica si se presiona el botón "Guardar y Enviar"
            Analisis_credito::where('solicituds_id',$request->input('idSolicitud'))->update([
                'estatus' => 'Autorizado',
                'comentarios' => $request->observaciones,
            ]);

            Solicitud::where('id', $request->input('idSolicitud'))->update([
                'estatus' => 'Autorizado',
            ]);
        }
        return redirect()->route('admin.analisis_credito.index');

    }

    public function colocacionClientes(Request $request){
        $f1 = Carbon::parse($request->fecha_inicial);
        $f2 = Carbon::parse($request->fecha_final);

        $data = Analisis_credito::where('desembolso','=','Desembolsado')
        ->whereBetween(('solicituds.fecha_desembolso'), [$f1, $f2])
        ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
        ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
        ->get(); 
        return Excel::download(new ColocacionExport($data), 'colocacion'. '.xlsx');
     }
}
