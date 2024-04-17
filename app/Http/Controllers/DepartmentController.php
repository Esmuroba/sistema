<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \Throwable;
use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $enterpriseId = Auth::user()->collaborator->enterprise_id;
        $name =  mb_strtoupper($request->get('name'), 'UTF-8');
        $departments = Department::name($name)->where('enterprise_id', $enterpriseId)->paginate(10);

        return view('myCompany.departments.index', compact('departments' ,'name' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $departments = Department::where('enterprise_id',Auth::user()->collaborator->enterprise->id)->get();
        return view('myCompany.departments.register', compact('departments'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $departments = new Department();
        $departments->enterprise_id = Auth::user()->collaborator->enterprise->id;
        $departments->name = mb_strtoupper($request->input('name'), 'UTF-8');
        $departments->phone = $request->input('phone');
        $departments->ext = $request->ext;
        $departments->status = 'Activo';
        $departments->save();

        return redirect()->route('my-company.departments')->with('success', 'Departamento guardado exitosamente');
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

        $departments = Department::where('id', $id)->first();
        return view('myCompany.departments.edit', compact('departments'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDepartmentRequest $request, $id)
    {
        Department::where('id', $id)->update([
            'name' => mb_strtoupper($request->name, 'UTF-8'),
            'phone' => $request->phone,
            'ext' => $request->ext
        ]);
        return redirect()->route('my-company.departments')->with('success', 'Departamento actualizados exitosamente');

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
