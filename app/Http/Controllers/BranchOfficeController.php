<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\BranchOffice;
use App\Models\Enterprise;
use \Throwable;
use Illuminate\Support\Facades\Validator;


class BranchOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $enterpriseId = Auth::user()->collaborator->enterprise_id;
        $name_branch =  mb_strtoupper($request->get('name_branch'), 'UTF-8');
        $branchOffices = BranchOffice::name($name_branch)->where('enterprise_id', $enterpriseId)->paginate(10);
        return view('myCompany.branchOffices.index', compact('branchOffices','name_branch'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $enterprises = Enterprise::all();

        return view('myCompany.branchOffices.register', compact('enterprises'));
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
            'name_branch' => 'required|string',
            'street' => 'required|string',
            'phone' => 'required|regex:/^[0-9]{10}$/',

        ];

        //mensajes personalizados para las reglas de validación
        $mensajes = [
            'name_branch.required' => 'El campo Nombre de Sucursal es obligatorio.',
            'street.required' => 'El campo Calle es obligatorio.',
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

        // dd($request);
        $branchOffice = new BranchOffice();
        $branchOffice->enterprise_id = $request->input('enterprise');
        $branchOffice->name = mb_strtoupper($request->input('name_branch'), 'UTF-8');
        $branchOffice->phone = $request->input('phone');
        $branchOffice->ext = $request->input('ext');
        $branchOffice->street = mb_strtoupper($request->input('street'), 'UTF-8');
        $branchOffice->cp = $request->input('cp');
        $branchOffice->city = mb_strtoupper($request->input('city'), 'UTF-8');
        $branchOffice->suburb = mb_strtoupper($request->input('suburb'), 'UTF-8');
        $branchOffice->state = mb_strtoupper($request->input('state'), 'UTF-8');
        $branchOffice->out_num = $request->input('num_ext');
        $branchOffice->int_num = $request->input('num_int');
        $branchOffice->status = 'Activo';
        $branchOffice->save();
        return redirect()->route('my-company.branch-offices')->with('mensaje', 'Sucursal guardada exitosamente');

        
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

        $branchOffice = BranchOffice::where('id', $id)->first();

        $enterprises = Enterprise::all();

        $opcion = "N/A";
        if($branchOffice->enterprise()->first('id') != null){
            $opcion = $branchOffice->enterprise()->first('id')->id;
        }

        return view('myCompany.branchOffices.edit', compact('branchOffice','enterprises','opcion'));

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
        BranchOffice::where('id', $id)->update([
            'name' => mb_strtoupper($request->name_branch, 'UTF-8'),
            'phone' => $request->phone,
            'ext' => $request->ext,
            'street' => mb_strtoupper($request->street, 'UTF-8'),
            'out_num' => $request->num_ext,
            'int_num' => $request->num_int,
            'cp' => $request->cp,
            'city' => $request->city,
            'state' => $request->state,
            'suburb' => $request->suburb,
         
        ]);
        return redirect()->route('my-company.edit',[$id])->with('mensaje', 'Datos actualizados exitosamente');

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
