<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Asociado;
use App\Models\Cliente;
use App\Models\EstadoNacimiento;
use App\Models\Cuenta;
use App\Models\Aval;
use App\Models\Referencia;
use Excel;
use DateTime;
use Carbon\Carbon;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ClienteController = new ClienteController();
        $name =  mb_strtoupper($request->get('txt_name'), 'UTF-8');
        // $asociados = Asociado::all(); 

        if($request->estatus){
            $clientes = Cliente::where('estatus', $request->estatus)->name($name)->paginate(10);
        }else{
            $clientes = Cliente::name($name)->paginate(10);
        }

        return view('clientes.index', compact('clientes','name'));
    }

 
    public function create()
    {
        $cuentas = Cuenta::all();
        $asociados = Asociado::all();
        $avales = Aval::all();
        $estados_nac = EstadoNacimiento::all();
        return view('clientes.register', compact('avales','asociados','cuentas','estados_nac'));
    }

    public function store(Request $request)
    {
        //  dd($request);
        $fechaNacimiento = $request->fecha_nacimiento;
        $fechaNacimiento = new Carbon($fechaNacimiento);
        $fechaActual = Carbon::now();
        $edad = $fechaNacimiento->diffInYears($fechaActual);

        $cliente = new Cliente();
        $cliente->user_id = auth()->user()->id;
        $cliente->nombre = mb_strtoupper($request->input('nombre'), 'UTF-8');
        $cliente->apellido_paterno = mb_strtoupper($request->input('apellido_paterno'), 'UTF-8');
        $cliente->apellido_materno = mb_strtoupper($request->input('apellido_materno'), 'UTF-8');
        $cliente->fecha_nacimiento = $request->input('fecha_nacimiento');
        $cliente->tipo_cliente = 'NUEVO';
        $cliente->edad = $edad;
        $cliente->genero = $request->input('genero');
        $cliente->ciudad_nacimiento = mb_strtoupper($request->input('ciudad'), 'UTF-8');
        $cliente->nacionalidad = mb_strtoupper($request->input('nacionalidad'), 'UTF-8');
        $cliente->estados_nacimientos_clave = mb_strtoupper($request->input('estado'), 'UTF-8');
        $cliente->rfc = mb_strtoupper($request->input('rfc'), 'UTF-8');
        $cliente->curp = mb_strtoupper($request->input('curp'), 'UTF-8');
        $cliente->celular = $request->input('celular');
        $cliente->tipo_vivienda = mb_strtoupper($request->input('vivienda'), 'UTF-8');
        $cliente->direccion = mb_strtoupper($request->input('direccion'), 'UTF-8');
        $cliente->anios_residencia = mb_strtoupper($request->input('residencia'), 'UTF-8');
        $cliente->referencia = mb_strtoupper($request->input('referencias'), 'UTF-8');
        $cliente->cp = $request->input('cp');
        $cliente->colonia = mb_strtoupper($request->input('txt_colonia'), 'UTF-8');
        $cliente->ciudad = mb_strtoupper($request->input('txt_ciudad'), 'UTF-8');
        $cliente->estado = mb_strtoupper($request->input('txt_estado'), 'UTF-8');
        $cliente->fecha_alta = $request->input('fecha_alta');
        $cliente->escolaridad = mb_strtoupper($request->input('escolaridad'), 'UTF-8');
        $cliente->profesion = mb_strtoupper($request->input('profesion'), 'UTF-8');
        $cliente->religion = mb_strtoupper($request->input('religion'), 'UTF-8');
        $cliente->estado_civil = mb_strtoupper($request->input('estado_civil'), 'UTF-8');
        $cliente->clave_elector = mb_strtoupper($request->input('clave_elector'), 'UTF-8');
        $cliente->anio_vencimiento_ine = $request->input('vencimiento');
        $cliente->folio_ine = mb_strtoupper($request->input('folio_ine'), 'UTF-8');
        $cliente->ocr = mb_strtoupper($request->input('ocr'), 'UTF-8');
        $cliente->numero_tarjeta = $request->input('num_tarjeta');
        $cliente->numero_cuenta = $request->input('num_cuenta');
        $cliente->clave_interbancaria = $request->input('clabe_interbancaria');
        $cliente->banco = mb_strtoupper($request->input('banco'), 'UTF-8');
        // $cliente->tipo_cliente = mb_strtoupper($request->input('txt_tipo_cliente'), 'UTF-8');
        $cliente->asociado_id = $request->input('asociado');
        $cliente->aval_id = $request->input('aval');
        $cliente->cuentas_id = $request->input('cuenta');
        $cliente->tipo_vialidad = $request->input('vialidad');
        $cliente->entre_calles = mb_strtoupper($request->input('entre_calles'), 'UTF-8');
        $cliente->save();
        $idCliente= $cliente["id"];
        return redirect()->route('admin.cliente.edit',[$idCliente])->with('mensaje', 'Registro exitoso');

    }

    public function edit($id)
    {
        $ClienteController = new ClienteController();
        $cliente = Cliente::where('id', $id)->first();
        $asociados = Asociado::all(); 
        $personAsociado = "N/A";
        if($cliente->asociados()->first('id') != null){
            $personAsociado = $cliente->asociados()->first('id')->id;
        }

        $avales = Aval::all(); 
        $personAval = "N/A";
        if($cliente->aval()->first('id') != null){
            $personAval = $cliente->aval()->first('id')->id;
        }
        $cuentas = Cuenta::all();
        $opcionCuenta = "N/A";
        if($cliente->cuentas()->first('id') != null){
            $opcionCuenta = $cliente->cuentas()->first('id')->id;
        }

        $estados_nac = EstadoNacimiento::all(); 
        $opcionEstado = "N/A";
        if($cliente->estadoNac()->first('clave') != null){
            $opcionEstado = $cliente->estadoNac()->first('clave')->clave;
        }
        $referencias = Referencia::where('clientes_id',$id)->get();

        return view('clientes.edit', compact('cliente', 'asociados','personAsociado','cuentas','opcionCuenta','avales','personAval','estados_nac','opcionEstado','referencias'));
    }

    public function verReferencia($id){
        $referencia = Referencia::where('id', $id)->first();
        return response()->json(["referencia" => $referencia]);
    }

    public function guardarReferencias(Request $request, $idCliente){
        //    dd($request);
           $referencia = new Referencia();
           if($request->idReferencia == 0){
                $referencia->clientes_id = $idCliente;
                $referencia->nombre = mb_strtoupper($request->input('nombre_ref'), 'UTF-8');
                $referencia->apellido_paterno = mb_strtoupper($request->input('apellido_paterno_ref'), 'UTF-8');
                $referencia->apellido_materno = mb_strtoupper($request->input('apellido_materno_ref'), 'UTF-8');
                $referencia->parentesco = mb_strtoupper($request->input('parentesco_ref'), 'UTF-8');
                $referencia->telefono = $request->input('celular_ref');
                $referencia->tipo_referencia = mb_strtoupper($request->input('tipo_ref'), 'UTF-8');
                $referencia->direccion = mb_strtoupper($request->input('direccion_ref'), 'UTF-8');
                $referencia->referencia = mb_strtoupper($request->input('referencia_ref'), 'UTF-8');
                $referencia->cp = $request->input('cp_ref');
                $referencia->colonia = mb_strtoupper($request->input('txt_colonia_ref'), 'UTF-8');
                $referencia->ciudad = mb_strtoupper($request->input('txt_ciudad_ref'), 'UTF-8');
                $referencia->estado = mb_strtoupper($request->input('txt_estado_ref'), 'UTF-8');
                $referencia->entre_calles = mb_strtoupper($request->input('entre_calles_ref'), 'UTF-8');
                $referencia->save();
           }else{
                Referencia::where('id', $request->idReferencia)->update([
                    'nombre' => mb_strtoupper($request->nombre_ref , 'UTF-8'),
                    'apellido_paterno' => mb_strtoupper($request->apellido_paterno_ref, 'UTF-8'),
                    'apellido_materno' => mb_strtoupper($request->apellido_materno_ref , 'UTF-8'),
                    'parentesco' => mb_strtoupper($request->parentesco_ref , 'UTF-8'),
                    'telefono' => $request->celular_ref,
                    'tipo_referencia' => mb_strtoupper($request->tipo_ref,'UTF-8'),
                    'direccion' => mb_strtoupper($request->direccion_ref,'UTF-8'),
                    'entre_calles' => mb_strtoupper($request->entre_calles_ref,'UTF-8'),
                    'referencia' => mb_strtoupper($request->referencia_ref,'UTF-8'),
                    'cp' => mb_strtoupper($request->cp_ref,'UTF-8'),
                    'colonia' => mb_strtoupper($request->txt_colonia_ref,'UTF-8'),
                    'ciudad' => mb_strtoupper($request->txt_ciudad_ref,'UTF-8'),
                    'estado' => mb_strtoupper($request->txt_estado_ref,'UTF-8'),
                ]);
                $idCliente = $request->idClienteRef;
           }
           
           return redirect()->route('admin.cliente.edit',[$idCliente])->with('mensaje', 'Referencia agregada');
        }
}
