<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Aval;


class AvalController extends Controller
{
    public function index(Request $request)
    {
        $name =  mb_strtoupper($request->get('txt_name'), 'UTF-8');
        if($request->estatus){
            $avales = Aval::where('state', $request->estatus)->name($name)->paginate(10);
        }else{
            $avales = Aval::name($name)->paginate(10);
        }
        return view('avales.index', compact('avales','name'));
    }

    public function create()
    {
        $avales = Aval::all();
        return view('avales.register', compact('avales'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $aval = new Aval();
        $aval->users_id = auth()->user()->id;
        $aval->nombre = mb_strtoupper($request->input('nombre'), 'UTF-8');
        $aval->apellido_paterno = mb_strtoupper($request->input('apellido_paterno'), 'UTF-8');
        $aval->apellido_materno = mb_strtoupper($request->input('apellido_materno'), 'UTF-8');
        $aval->fecha_nacimiento = $request->input('fecha_nacimiento');
        // $aval->edad = $request->input('edad');
        $aval->genero = mb_strtoupper($request->input('genero'), 'UTF-8');
        $aval->ciudad_nacimiento = mb_strtoupper($request->input('ciudad'), 'UTF-8');
        $aval->nacionalidad = mb_strtoupper($request->input('nacionalidad'), 'UTF-8');
        $aval->estado_nacimiento = mb_strtoupper($request->input('estado'), 'UTF-8');
        $aval->rfc = mb_strtoupper($request->input('rfc'), 'UTF-8');
        $aval->curp = mb_strtoupper($request->input('curp'), 'UTF-8');
        $aval->parentesco = $request->input('parentesco');
        $aval->celular = $request->input('celular');
        $aval->tipo_vivienda = mb_strtoupper($request->input('tipo_vivienda'), 'UTF-8');
        $aval->direccion = mb_strtoupper($request->input('direccion'), 'UTF-8');
        $aval->anios_residencia = mb_strtoupper($request->input('residencia'), 'UTF-8');
        $aval->referencia = mb_strtoupper($request->input('referencias'), 'UTF-8');
        $aval->cp = $request->input('cp');
        $aval->colonia = mb_strtoupper($request->input('txt_colonia'), 'UTF-8');
        $aval->ciudad = mb_strtoupper($request->input('txt_ciudad'), 'UTF-8');
        $aval->estado = mb_strtoupper($request->input('txt_estado'), 'UTF-8');
        $aval->fecha_alta = $request->input('fecha_alta');
        $aval->escolaridad = mb_strtoupper($request->input('escolaridad'), 'UTF-8');
        $aval->profesion = mb_strtoupper($request->input('profesion'), 'UTF-8');
        $aval->religion = mb_strtoupper($request->input('religion'), 'UTF-8');
        $aval->estado_civil = mb_strtoupper($request->input('estado_civil'), 'UTF-8');
        $aval->clave_elector = mb_strtoupper($request->input('clave_elector'), 'UTF-8');
        $aval->anio_vencimiento_ine = $request->input('vencimiento');
        $aval->folio_ine = mb_strtoupper($request->input('folio_ine'), 'UTF-8');
        $aval->ocr = mb_strtoupper($request->input('ocr'), 'UTF-8');
        $aval->numero_tarjeta = $request->input('num_tarjeta');
        $aval->numero_cuenta = $request->input('num_cuenta');
        $aval->clave_interbancaria = $request->input('clabe_interbancaria');
        $aval->banco = mb_strtoupper($request->input('banco'), 'UTF-8');
        $aval->save();
        return redirect()->route('admin.aval.index');
    }

    public function edit($id)
    {
        $aval = Aval::where('id', $id)->first();
        return view('avales.edit', compact('aval'));
    }

    public function update(Request $request, $id)
    {
        Aval::where('id', $id)->update([
            'nombre' => mb_strtoupper($request->nombre , 'UTF-8'),
            'apellido_paterno' => mb_strtoupper($request->apellido_paterno, 'UTF-8'),
            'apellido_materno' => mb_strtoupper($request->apellido_materno , 'UTF-8'),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            // 'edad' => $request->edad,
            'genero' => mb_strtoupper($request->genero,'UTF-8'),
            'ciudad_nacimiento' => mb_strtoupper($request->ciudad_nacimiento,'UTF-8'),
            'nacionalidad' => mb_strtoupper($request->nacionalidad, 'UTF-8'),
            'estado_nacimiento' => mb_strtoupper($request->estado_nacimiento,'UTF-8'),
            'rfc' => mb_strtoupper($request->rfc,'UTF-8'),
            'curp' => mb_strtoupper($request->curp,'UTF-8'),
            'parentesco' => $request->parentesco,
            'celular' => $request->celular,
            'tipo_vivienda' => mb_strtoupper($request->tipo_vivienda,'UTF-8'),
            'direccion' => mb_strtoupper($request->direccion,'UTF-8'),
            'anios_residencia' => mb_strtoupper($request->residencia,'UTF-8'),
            'referencia' => mb_strtoupper($request->referencias,'UTF-8'),
            'cp' => mb_strtoupper($request->cp,'UTF-8'),
            'colonia' => mb_strtoupper($request->txt_colonia,'UTF-8'),
            'ciudad' => mb_strtoupper($request->txt_ciudad,'UTF-8'),
            'estado' => mb_strtoupper($request->txt_estado,'UTF-8'),
            'fecha_alta' => $request->fecha_alta,
            'escolaridad' => mb_strtoupper($request->escolaridad,'UTF-8'),
            'profesion' => mb_strtoupper($request->profesion,'UTF-8'),
            'religion' => mb_strtoupper($request->religion,'UTF-8'),
            'estado_civil' => mb_strtoupper($request->estado_civil,'UTF-8'),
            'clave_elector' => mb_strtoupper($request->clave_elector,'UTF-8'),
            'anio_vencimiento_ine' => mb_strtoupper($request->vencimiento_ine,'UTF-8'),
            'folio_ine' => mb_strtoupper($request->folio_ine,'UTF-8'),
            'ocr' => mb_strtoupper($request->ocr,'UTF-8'),
            'numero_tarjeta' => $request->num_tarjeta,
            'numero_cuenta' => $request->num_cuenta,
            'clave_interbancaria' => $request->clabe_interbancaria,
            'banco' => mb_strtoupper($request->banco,'UTF-8')
        ]);
        return redirect()->route('admin.aval.edit',[$id])->with('mensaje', 'Se editaron los datos correctamente');
    }
}
