<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Solicitud;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Referencia;
use App\Models\TablaAmortizacion;
use App\Models\Empresa;
use DateTime;
use Carbon\Carbon;
use PDF;


class SolicitudController extends Controller
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
            $solicitudes = Solicitud::select('solicituds.*')->where('solicituds.estatus', $request->estatus) ->name($name)
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


        return view('solicitudes.index', compact('solicitudes','name','statePendiente','stateProceso','statePre','stateTerminado','stateRechazado'));
    }

 
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::all();
        $today = Carbon::now();
        $fdesembolso = strtotime ( '+2 day' , strtotime($today));
        $fdesembolso = date ( 'd/m/Y' , $fdesembolso );
        $fprimerPago = strtotime ( '+9 day' , strtotime($today));
        $fprimerPago = date ( 'd/m/Y' , $fprimerPago );
        $fvencimiento = strtotime ( '100 day' , strtotime($today));
        $fvencimiento = date ( 'd/m/Y' , $fvencimiento );
        // dd($date);
        return view('solicitudes.register', compact('clientes','today', 'fdesembolso','fprimerPago','fvencimiento','productos'));
    }

    public function store(Request $request)
    {
        //  dd($request);
        $solicitud = new Solicitud();
        $solicitud->users_id = auth()->user()->id;
        $solicitud->asociado_id = $request->input('idAsociado');
        $solicitud->cliente_id = $request->input('idCliente');
        $solicitud->tipo_negocio = mb_strtoupper($request->input('tipo_negocio'), 'UTF-8');
        $solicitud->tipo_solicitud = mb_strtoupper($request->input('tipo_cliente'), 'UTF-8');
        $solicitud->direccion_negocio = mb_strtoupper($request->input('direccion_ref'), 'UTF-8');
        $solicitud->entre_calles = mb_strtoupper($request->input('entre_calle'), 'UTF-8');
        $solicitud->cp = mb_strtoupper($request->input('codigo_postal'), 'UTF-8');
        $solicitud->colonia = mb_strtoupper($request->input('txt_colonia'), 'UTF-8');
        $solicitud->ciudad = mb_strtoupper($request->input('txt_ciudad'), 'UTF-8');
        $solicitud->estado = mb_strtoupper($request->input('txt_estado'), 'UTF-8');
        $solicitud->antiguedad_negocio = mb_strtoupper($request->input('antiguedad_negocio'), 'UTF-8');
        $solicitud->num_hijos = mb_strtoupper($request->input('num_hijos'), 'UTF-8');
        $solicitud->anios_exp = mb_strtoupper($request->input('anios_exp'), 'UTF-8');
        $solicitud->tipo_establecimiento = $request->input('establecimiento');
        $solicitud->garantias = mb_strtoupper($request->input('garantia'), 'UTF-8');
        $solicitud->dependientes_economicos = $request->input('dependientes_economicos');
        $solicitud->producto_id = $request->input('producto');
        $solicitud->ingreso_mensual = $request->input('ingreso_mensual');
        $solicitud->gasto_mensual = $request->input('gasto_mensual');
        $solicitud->monto_solicitado = $request->input('monto_solicitado');
        $solicitud->ciclo = $request->input('ciclo');
        $solicitud->plazo = $request->input('plazo');
        $solicitud->tasa = $request->input('tasa');
        $solicitud->capacidad_pago = $request->input('capacidad_pago');
        $solicitud->cuota = $request->input('cuota');
        $solicitud->frecuencia_pago = $request->input('frecuencia_pago');
        $solicitud->fecha_solicitud = $request->input('fsolicitud');
        $solicitud->fecha_desembolso = $request->input('fdesembolso');
        $solicitud->fecha_primer_pago = $request->input('fprimer_pago');
        $solicitud->fecha_vencimiento = $request->input('fvencimiento');
        $solicitud->estatus = 'Pendiente';
        $solicitud->save();

        // Cliente::where('id', $request->input('idCliente'))->update([
        //     'tipo_cliente' => $request->input('tipo_cliente'),
        // ]);
        
        return redirect()->route('admin.solicitud.index');
    }


    public function obtenerDetallesCliente($id){
        $cliente = Cliente::where('id', $id)->first();         
        $asociado = $cliente->asociados;
        $operador = $asociado->operadores;
        return response()->json(["cliente" => $cliente, "asociado" => $asociado, "operador" => $operador]);
    }

    public function verProductos($id){
        $products = Producto::where('id', $id)->first();
        return response()->json(["products" => $products]);
    }
    

    public function pdfSolicitud($id){
        $solicitud = Solicitud::where('id', $id)->get();
        $empresa = Empresa::where('status', 'Activo')->first();
        $tablaAmortizacion = TablaAmortizacion::where('solicituds_id', $id)->get();
        $referencia_familiar = Referencia::where('clientes_id',$solicitud[0]->cliente_id)->where('tipo_referencia', 'FAMILIAR')->first();
        $referencia_comercial = Referencia::where('clientes_id',$solicitud[0]->cliente_id)->where('tipo_referencia', 'COMERCIAL')->first();
        $pdf_name = "SOLICITUD".$id.".PDF";
        return PDF::loadView('pdfs.solicitudCliente', compact('solicitud','empresa','tablaAmortizacion','referencia_familiar','referencia_comercial'))->setPaper('letter', 'portrait')->stream($pdf_name);
    }

    public function pdfContrato($id){
        $pdf_name = "CONTRATO.PDF";
        return PDF::loadView('pdfs.contratoCliente')->setPaper('letter', 'portrait')->stream($pdf_name);
    }
}
