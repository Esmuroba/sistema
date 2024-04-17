<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Area;
use \Throwable;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $enterpriseId = Auth::user()->collaborator->enterprise_id;
        $name_job =  mb_strtoupper($request->get('name_job'), 'UTF-8');
        $jobs = Job::name($name_job)->where('enterprise_id', $enterpriseId)->paginate(10);

        return view('myCompany.jobs.index', compact('jobs','name_job'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $areas = Area::where('enterprise_id', Auth::user()->collaborator->enterprise_id)
        // ->join('departments', 'departments.id', '=', 'areas.departments_id')
        ->get();

        return view('myCompany.jobs.register', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $reglas = [
            'name_job' => 'required|string',

        ];

        //mensajes personalizados para las reglas de validación
        $mensajes = [
            'name_job.required' => 'El campo Nombre de Puesto es obligatorio.',
        ];

        // Ejecuta la validación
        $validador = Validator::make($request->all(), $reglas, $mensajes);

        // Verifica si la validación ha fallado
        if ($validador->fails()) {
            return redirect()->back()
                ->withErrors($validador)
                ->withInput(); // Para repoblar los campos del formulario con los valores anteriores
        }

        $job = new Job();
        $job->area_id = $request->input('areas');
        $job->name = mb_strtoupper($request->input('name_job'), 'UTF-8');
        $job->enterprise_id = Auth::user()->collaborator->enterprise->id;
        $job->status = 'ACTIVO';
        $job->save();
        return redirect()->route('my-company.jobs')->with('mensaje', 'Puesto guardado exitosamente');

        
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

        $jobs = Job::where('id', $id)->first();
        $areas = Area::select('areas.*')
        ->where('areas.enterprise_id',Auth::user()->collaborator->enterprise->id)
        ->join('departments', 'departments.id', '=', 'areas.department_id')
        ->get();

        $opcion = "N/A";
        if($jobs->area()->first('id') != null){
            $opcion = $jobs->area()->first('id')->id;
        }

        return view('myCompany.jobs.edit', compact('jobs','areas','opcion'));

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
        Job::where('id', $id)->update([
            'area_id' => $request->areas,
            'name' => mb_strtoupper($request->name_job, 'UTF-8'),
        ]);
        return redirect()->route('my-company.jobs.edit',[$id])->with('mensaje', 'Datos actualizados exitosamente');

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
