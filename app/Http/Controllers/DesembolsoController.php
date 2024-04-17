<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Banco;
use App\Models\Articulo;
use App\Models\Analisis_credito;
// use App\Models\DetalleDesembolso;
use App\Models\Cuenta;
use App\Models\MovimientoGasto;

class DesembolsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $creditos = Analisis_credito::paginate(10);
        $name =  mb_strtoupper($request->get('txt_name'), 'UTF-8');

        if($request->estatus){
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->where('analisis_credito.estatus', 'Autorizado')
            ->where('analisis_credito.desembolso', $request->estatus)
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else if($name){
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->name($name)
            ->where('analisis_credito.estatus', 'Autorizado')
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else{
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->where('analisis_credito.estatus', 'Autorizado')
            ->where('analisis_credito.desembolso', 'Pendiente')
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }
        
        $statePendiente = Analisis_credito::where('desembolso', 'Pendiente')->get();
        $stateDsembolsado = Analisis_credito::where('desembolso', 'Desembolsado')->get();

        return view('desembolsos.index', compact('creditos','name','statePendiente','stateDsembolsado'));
    }


    public function edit($id)
    {
        \DB::statement("SET SQL_MODE=''");
        $cuentasCaja = Caja::all();
        $bancos = Banco::all();
        $cuentaActivo = Articulo::where('tipo_producto','ACTIVO')->get();
        $credito = Analisis_credito::find($id);
        $idCliente = $credito->solicitud->cliente->id;

        $pagosP = Analisis_credito::selectRaw('SUM(tabla_amortizacion.pago) as monto')
        ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
        ->join('tabla_amortizacion', 'tabla_amortizacion.analisis_credito_id', '=', 'analisis_credito.id')
        ->where('solicituds.cliente_id', $idCliente)
        ->where('analisis_credito.id','!=', $id)
        ->where('analisis_credito.estatus_credito','!=','Pagado')
        ->where('solicituds.estatus','!=','Rechazado')
        ->where('tabla_amortizacion.estatus','=','No cobrado')
        ->get();
        
        return view('desembolsos.desembolso', compact('pagosP','credito','cuentaActivo','cuentasCaja','bancos'));
    }


    public function store(Request $request)
    {
        $desembolso = new MovimientoGasto();
        $desembolso->analisis_credito_id = $request->input('idAnalisisCred');
        if($request->input('tipo_pago') == 'Efectivo'){
            $desembolso->cuentas_id = $request->input('cuenta_efectivo');
        }else if($request->input('tipo_pago') == 'Transferencia'){
            $desembolso->cuentas_id = $request->input('cuenta_transferencia');
        }else if($request->input('tipo_pago') == 'Cheque'){
            $desembolso->cuentas_id = $request->input('cuenta_cheque');
        }else if($request->input('tipo_pago') == 'Especie'){
            $desembolso->cuentas_id = $request->input('cuenta_especie');
        }
        $desembolso->tipo_pago = $request->input('tipo_pago');
        $desembolso->fecha_pago = $request->input('fdesembolso');
        $desembolso->observaciones = mb_strtoupper($request->input('observaciones'), 'UTF-8');
        $desembolso->bandera = 'Desembolso';

        $desembolso->save();

        $creditos = Analisis_credito::where('estatus', 'Autorizado')->paginate(10);
        Analisis_credito::where('id', $request->input('idAnalisisCred'))->update([
            'desembolso' => 'Desembolsado',
            'deduccion' => $request->input('deduccion'),
            'comision' => $request->comision,
            'total_pagado' => (str_replace(",","",$request->hidentotalDesembolso)),
        ]);
        // return redirect()->route('admin.desembolso.index',[$id]);
        return redirect()->route('admin.desembolso.show', [$request->input('idAnalisisCred')]);

    }

    public function show($id)
    {
        $credito = Analisis_credito::find($id);
        $detalle = MovimientoGasto::where('analisis_credito_id', $id)->first();
        $producto = Analisis_credito::where('id',$id)->first()->solicitud->producto;
    
        return view('desembolsos.detalles', compact('credito','detalle','producto'));
    }

}
