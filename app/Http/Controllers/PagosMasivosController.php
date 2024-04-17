<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PagosImport;
use App\Http\Requests\StoreCollaboratorFromExcelRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use \Throwable;
use Carbon\Carbon;

use App\Models\PagosMasivos;

class PagosMasivosController extends Controller
{
   
    public function index(Request $request)
    {
        $name =  mb_strtoupper($request->get('name'), 'UTF-8');
        $hoy = Carbon::today();

        if($name){
            $pagos = PagosMasivos::select('pagos_masivos.*')
            ->name($name)
            ->where('pagos_masivos.estatus', 'Pendiente')
            ->join('solicituds', 'solicituds.id', '=', 'pagos_masivos.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else{
            $pagos = PagosMasivos::select('pagos_masivos.*')
            ->name($name)
            ->where('pagos_masivos.estatus', 'Pendiente')
            ->join('solicituds', 'solicituds.id', '=', 'pagos_masivos.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }
        return view('pagos_masivos.index', compact('pagos','name'));
    }

    public function importFromExcel(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $importFile = $request->file('import_file');
            $importClass = new PagosImport();
            $collabsImport = Excel::import($importClass, $importFile);

            DB::commit();

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollback();
            $failures = $e->failures();

            return redirect()->back()->with('errors', $failures);

        }

        return redirect()->back()->with('mensaje', $importClass->insertedRowsCount() . ' Pagos importados correctamente.');

    }

    
}
