<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $enterpriseId = Auth::user()->collaborator->enterprise_id;
        $name_area =  mb_strtoupper($request->get('name_area'), 'UTF-8');
        $areas = Area::name($name_area)->where('enterprise_id', $enterpriseId)->paginate(10);

        return view('myCompany.areas.index', compact('areas','name_area'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $departments = Department::where('enterprise_id',Auth::user()->collaborator->enterprise->id)->get();
        return view('myCompany.areas.register', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'name_area' => 'required|string',
            'departments' => 'required|int',
            'phone' => 'required|regex:/^[0-9]{10}$/',

        ];

        //mensajes personalizados para las reglas de validación
        $mensajes = [
            'name_area.required' => 'El campo Nombre de Area es obligatorio.',
            'departments.required' => 'El campo departamento es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.regex' => 'El formato del número de teléfono no es válido.',
        ];

        // Ejecuta la validación
        $validador = Validator::make($request->all(), $reglas, $mensajes);

        // Verifica si la validación ha fallado
        if ($validador->fails()) {
            return redirect()->back()
                ->withErrors($validador)
                ->withInput(); // Para repoblar los campos del formulario con los valores anteriores
        }

        $enterpriseId = Auth::user()->collaborator->enterprise_id;

        $area = new Area();
        $area->enterprise_id = $enterpriseId;
        $area->department_id = $request->input('departments');
        $area->name = mb_strtoupper($request->input('name_area'), 'UTF-8');
        $area->phone = $request->input('phone');
        $area->ext = $request->input('ext');
        $area->status = 'Activo';
        $area->save();
        return redirect()->route('my-company.areas')->with('mensaje', 'Área guardada exitosamente');

        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $area = Area::where('id', $id)->first();
        $departments = Department::where('enterprise_id',Auth::user()->collaborator->enterprise->id)->get();

        $opcion = "N/A";
        if($area->departments()->first('id') != null){
            $opcion = $area->departments()->first('id')->id;
        }

        return view('myCompany.areas.edit', compact('area','departments','opcion'));

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
        Area::where('id', $id)->update([
            'departments_id' => $request->departments,
            'name' => mb_strtoupper($request->name_area, 'UTF-8'),
            'phone' => $request->phone,
            'ext' => $request->ext,
        ]);
        return redirect()->route('my-company.areas.edit',[$id])->with('mensaje', 'Datos actualizados exitosamente');

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
}
