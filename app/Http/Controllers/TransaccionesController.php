<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Banco;
use App\Models\Articulo;
use App\Models\TablaAmortizacion;
use App\Models\Transacciones;
use App\Models\PagosMasivos;
use App\Models\Analisis_credito;
use Carbon\Carbon;
use App\Exports\CarteraClientesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name =  mb_strtoupper($request->get('name'), 'UTF-8');
        $hoy = Carbon::today();

        if($name){
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->name($name)
            ->where('analisis_credito.estatus', 'Autorizado')
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }else{
            $creditos = Analisis_credito::select('analisis_credito.*')
            ->where('analisis_credito.estatus_credito', 'Vigente')
            ->where('analisis_credito.estatus', 'Autorizado')
            ->name($name)
            ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
            ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id')
            ->paginate(10);
        }
        $cuentasCaja = Caja::all();
        $bancos = Banco::all();
        $cuentaActivo = Articulo::where('tipo_producto','ACTIVO')->get();

        return view('transacciones.index', compact('creditos','name','bancos','cuentasCaja','cuentaActivo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'monto_pago' => 'required',
            'tipo_pago' => 'required',
            'fecha_pago' => 'required',
            // Otras reglas de validación
        ];

        $messages = [
            'monto_pago.required' => 'El Monto es obligatorio.',
            'tipo_pago.required' => 'El Tipo de Cobro es obligatorio.',
            'fecha_pago.required' => 'La Fecha de Cobro es obligatoria.',
        ];
        
        $this->validate($request, $rules, $messages);

        $pagoNoCobrado = TablaAmortizacion::where('solicituds_id',$request->idSolicitud)->where('estatus','No cobrado')->orderBy('num_pago', 'asc')->first();
        if($pagoNoCobrado){
            $transaccion = new Transacciones();
            $transaccion->solicituds_id = $request->input('idSolicitud');
            $transaccion->tabla_amortizacion_id = $pagoNoCobrado->id;
            $transaccion->fecha_aplicacion = $request->input('fecha_pago');
            $transaccion->tipo = $request->input('tipo_pago');
            $transaccion->monto = (str_replace(",","",$request->input('monto_pago')));
            if($request->input('tipo_pago') == 'Efectivo'){
                $transaccion->cuentas_id = $request->input('cuenta_efectivo');
            }else if($request->input('tipo_pago') == 'Transferencia'){
                $transaccion->cuentas_id = $request->input('cuenta_transferencia');
            }else if($request->input('tipo_pago') == 'Cheque'){
                $transaccion->cuentas_id = $request->input('cuenta_cheque');
            }else if($request->input('tipo_pago') == 'Especie'){
                $transaccion->cuentas_id = $request->input('cuenta_especie');
            }
            $transaccion->referencia = mb_strtoupper($request->input('referencia'), 'UTF-8');
            $transaccion->observaciones = mb_strtoupper($request->input('concepto'), 'UTF-8');

            $transaccion->save();
            $idTransaccion= $transaccion["id"];

        }
        
        $rowTrans = Transacciones::where('id',$idTransaccion)->latest()->first();

        if($pagoNoCobrado->pago_aplicado){ //ya trae un movimiento
            $pago_aplicado = $pagoNoCobrado->pago_aplicado + $rowTrans->monto;
        }else{
            $pago_aplicado = $rowTrans->monto;  
        }

        // dd($pago_aplicado);
        $saldo1 = TablaAmortizacion::where('solicituds_id',$request->idSolicitud)
        ->where('saldo_actual', '>', 0)
        ->orderBy('id', 'desc')
        ->latest('updated_at')->first();

        if($saldo1){
            $ultimo_saldo = $saldo1->saldo_actual;  ////1
            $ultimo_amort = $saldo1->saldo_amortizaciones;  ////1
        }else{
            $ultimo_saldo = 0;  ///2
            $ultimo_amort = 0;  ///2
        }


        $this->calculo($rowTrans->monto,$pago_aplicado, $pagoNoCobrado->pago, $pagoNoCobrado->id,$request->idSolicitud,$ultimo_saldo, $ultimo_amort);
       

        // return redirect()->route('admin.transacciones.index');
        return redirect()->back()->with('success', 'Pago aplicado correctamente.');

    }


    public function calculo($monto_recibido,$pago_aplicado, $monto_exigible, $idAmortizacion, $idSolicitud,$ultimo_saldo, $ultimo_amort)
    {
        DB::beginTransaction();
        try {
        $saldoPendiente = TablaAmortizacion::where('solicituds_id',$idSolicitud)->where('estatus','Cobrado')->orderBy('num_pago', 'asc')->latest('num_pago')->first();
       
        $saldo1 = TablaAmortizacion::where('solicituds_id',$idSolicitud)
        ->where('saldo_actual', '>', 0)
        ->orderBy('num_pago', 'desc')
        ->latest('num_pago')->first();
        
        if($saldoPendiente){
            $pago_aplicado = $pago_aplicado + $saldo1->saldo_pago;
        }
        if($saldo1){
            if($saldo1->estatus == 'No cobrado'){
                $pago_aplicado = $saldo1->pago_aplicado + $monto_recibido; 
            }
        }else{
            $pago_aplicado;
        }

        $saldoPago = $pago_aplicado - $monto_exigible;

        if($saldoPendiente == '' || $saldoPendiente == null){
            // dd('aqui.. 1');
            $sumaMonto = TablaAmortizacion::where('solicituds_id',$idSolicitud)->where('estatus','No cobrado')->sum('pago');
            $saldo = $sumaMonto;
            $saldo_amort = $sumaMonto;
        }else{
            // dd('aqui.. 2');

            $saldo = $ultimo_saldo;
            $saldo_amort = $ultimo_amort;
        }
        
        if($saldoPago < 0){ // no tiene movimientos y es menor al saldo exigible
            // dd('entra 1');
            $pteAmortizar = $monto_exigible - $pago_aplicado;
            if($saldoPago > 0){
                dd('entra 2');
                // $saldo_amortizacion = $saldo_amort - $pago_aplicado - $saldoPago;
                // $saldo_actual = $saldo - $pago_aplicado;


            }else{
                // dd('entra 3');
                if($saldo1){
                    $resultado = $monto_recibido + $saldo1->saldo_pago;
                            
                    if($resultado >= $monto_exigible){ ///este si funciona con un saldo igual y mayor al monto exigible

                        $saldo_actual = $saldo - $monto_exigible;
                        $saldo_amortizacion = $saldo  - $monto_exigible;

                    }else{
                    
                        if($saldo1->pte_amortizar  > 0.00){
                            // dd($saldo_amort);
                            $saldo_actual = $saldo1->saldo_actual - $monto_recibido;
                            $saldo_amortizacion = $saldo1->saldo_actual  - $monto_recibido;
                        }else{
                            // dd('nuevo else 1');

                            $saldo_actual = $ultimo_amort - $monto_recibido;
                            $saldo_amortizacion = $ultimo_amort  - $monto_recibido;
                        }
                    }
                }else{// no tiene movimientos y el monto es menor al exigible
                    $saldo_amortizacion = $saldo_amort - $monto_recibido ; /// el monto es menor al pago 150
                    $saldo_actual = $saldo - $monto_recibido;
                }
                
                

            }
        }else{
            // dd('entra 4');

            $pteAmortizar = 0;
            
            $row = TablaAmortizacion::where('solicituds_id',$idSolicitud)
            ->where('saldo_actual', '>', 0)
            ->orderBy('num_pago', 'desc')
            ->latest('num_pago')->first();

           
            if($monto_recibido == $monto_exigible){
                 if($row){
                    if($row->pte_amortizar > 0.00){
                        // dd('entra 6');
                        $saldo_actual = $ultimo_amort - $row->pte_amortizar;
                        $saldo_amortizacion = $ultimo_amort  - $row->pte_amortizar;

             
                        
                    }else{
                         //cubre el monto exigible con saldo a favor
                        $saldo_actual = $ultimo_saldo - $monto_exigible;
                        $saldo_amortizacion = $ultimo_saldo  - $monto_exigible;
                    }
                 }else{
                    $saldo_actual = $saldo - $monto_exigible;
                    $saldo_amortizacion = $saldo  - $monto_exigible;
                 }
                

            }else{

                if($row){
                    if($row->pte_amortizar >= 0.00){ ///este ya esta bien cuando el pago es menor o igual
                        if($monto_recibido > $monto_exigible){

                            if($row->pago_aplicado > $monto_exigible){
                                 //funciona con pago mayor al exigible y con saldo a favor
                                $saldo_actual = $saldo - $monto_exigible;
                                $saldo_amortizacion = $saldo  - $monto_recibido - $row->saldo_pago;
                            }else{
                            
                                if($row->pte_amortizar > 0.00){
                                    // dd('entra 13');
                                    $saldo_actual = $ultimo_amort - $row->pte_amortizar;
                                    $saldo_amortizacion = $ultimo_amort  - $row->pte_amortizar;
                                }else{
                                    // ya esta bien, cuando el pago es mayor y no tiene saldo a favor
                                    $saldo_actual = $saldo - $monto_exigible;
                                    $saldo_amortizacion = $saldo  - $monto_recibido;
                                }
                            }
                           
                           
                        }else{
                            $resultado = $monto_recibido + $row->saldo_pago;
                            
                            if($resultado >= $monto_exigible){ ///este si funciona con un saldo igual y mayor al monto exigible
                                $saldo_actual = $saldo - $monto_exigible;
                                $saldo_amortizacion = $saldo  - $monto_exigible;

                            }else{
                                if($row->pte_amortizar > 0.00){
                                    //funciona completando monto exigible con saldo a favor
                                    $saldo_actual = $ultimo_amort - $row->pte_amortizar;
                                    $saldo_amortizacion = $ultimo_amort  - $row->pte_amortizar;
                                }else{
                                    dd('entra 19');
                                    // $saldo_actual = $ultimo_amort - $monto_recibido;
                                    // $saldo_amortizacion = $ultimo_amort  - $monto_recibido;
                                }
                                
                            }
                           
                        }
                       
        
                    }elseif($row->pte_amortizar < 0.00){
                        dd('entra 20');
                        // $saldo_actual = $saldo - $monto_exigible;
                        // $saldo_amortizacion = $saldo  - $monto_recibido;
                    }else{
                        dd('entra 21');
                        // $saldo_actual = $row->saldo_actual - $row->pte_amortizar;
                        // $saldo_amortizacion = $row->saldo_actual  - $row->pte_amortizar;
                    }
                }else{
                    //este ya esta bien con un monto mayor al exigible
                    $saldo_actual = $saldo - $monto_exigible;
                    $saldo_amortizacion = $saldo  - $monto_recibido;
                }
                
            }
            
            TablaAmortizacion::where('id', $idAmortizacion)->update([
                'estatus' => 'Cobrado',
            ]);

            
        }


      
            TablaAmortizacion::where('id', $idAmortizacion)->update([
                'pago_aplicado' => $pago_aplicado,
                'saldo_pago' => $saldoPago,
                'pte_amortizar' => $pteAmortizar,
                'saldo_actual' => $saldo_actual,
                'saldo_amortizaciones' => $saldo_amortizacion,
            ]);
    
            $newSaldo = TablaAmortizacion::where('solicituds_id',$idSolicitud)
            ->where('saldo_actual', '>', 0)
            ->orderBy('num_pago', 'desc')
            ->latest('num_pago')->first();
    
            
            if($newSaldo){
                if($monto_recibido <= $monto_exigible){
                    if($newSaldo->saldo_pago > 0){
                        if($newSaldo->saldo_pago < $monto_exigible){ 
                            $saldo_amortizacion = $newSaldo->saldo_amortizaciones - $newSaldo->saldo_pago;
                            TablaAmortizacion::where('id', $idAmortizacion)->update([
                                'saldo_amortizaciones' => $saldo_amortizacion,
                            ]);
                        }
                    }
                }
                
            }
    
            $numPagos = TablaAmortizacion::where('solicituds_id', $idSolicitud)->where('estatus','No cobrado')->count();
            if($numPagos == 0){
                Analisis_credito::where('solicituds_id', $idSolicitud)->update([
                    'estatus_credito' => 'Pagado',
                ]);
            }
    
            $this->revisarSaldo($saldoPago,$idSolicitud,$monto_recibido,$saldo_actual,$ultimo_amort);

            DB::commit();
        } catch (\Exception $e) {
            // Si se lanza una excepción, la operación falló, entonces puedes hacer un rollback
            DB::rollback();
            
            // Puedes manejar el error de alguna manera, por ejemplo, registrándolo o lanzando una excepción
            Log::error('Ocurrió un error al actualizar el estatus de la solicitud: '.$idSolicitud . $e->getMessage());

             // Actualizar registros que han generado errores
            $registrosConError = PagosMasivos::where('solicituds_id', '=', $idSolicitud)->latest()->first();
            PagosMasivos::where('id', $registrosConError->id)->update([
                'estatus' => 'Error',
            ]);
        }
        
    }

    public function revisarSaldo($saldoPago,$idSolicitud,$monto_recibido,$ultimo_saldo,$ultimo_amort)
    {
        $rowPago = TablaAmortizacion::where('solicituds_id',$idSolicitud)->where('estatus','No cobrado')->orderBy('num_pago', 'asc')->first();
        if($rowPago){
            if($saldoPago >= $rowPago->pago ){
                $this->calculoDos($saldoPago, $rowPago->pago,$rowPago->id, $idSolicitud,$monto_recibido,$ultimo_saldo,$ultimo_amort);
            }
        }
    }


    public function calculoDos($pago_aplicado, $monto_exigible, $idAmortizacion, $idSolicitud,$monto_recibido,$ultimo_saldo,$ultimo_amort)
    {
        // dd('segunda funcion');
        $saldoPago = $pago_aplicado - $monto_exigible;


        if($saldoPago < 0){
            $pteAmortizar = $monto_exigible - $pago_aplicado;
            $saldo_actual = $ultimo_saldo - $pago_aplicado;
    
            if($saldoPago > 0){
                $saldo_amortizacion = $ultimo_amort - $pago_aplicado - $saldoPago;

            }else{
                $saldo_amortizacion = $ultimo_amort - $pago_aplicado;

            }
        }else{

            $pteAmortizar = 0;
            $saldo_actual = $ultimo_saldo - $monto_exigible - $pteAmortizar;

            $newSaldo = TablaAmortizacion::where('solicituds_id',$idSolicitud)
            ->where('saldo_actual', '>', 0)
            ->orderBy('num_pago', 'desc')
            ->latest('num_pago')->first();

            if($newSaldo->saldo_pago != '0.00'){
                if($newSaldo->saldo_pago < $monto_exigible){
                    $saldo_amortizacion = $ultimo_saldo - $monto_exigible - $pteAmortizar - $saldoPago;
                }else{
                    $saldo_amortizacion = $ultimo_saldo - $monto_exigible - $pteAmortizar;

                }
                
            }else{

                $saldo_amortizacion = $ultimo_saldo - $monto_exigible - $pteAmortizar;

            }

         

            TablaAmortizacion::where('id', $idAmortizacion)->update([
                'estatus' => 'Cobrado',
            ]);
        }
        TablaAmortizacion::where('id', $idAmortizacion)->update([
            'pago_aplicado' => $pago_aplicado,
            'saldo_pago' => $saldoPago,
            'pte_amortizar' => $pteAmortizar,
            'saldo_actual' => $saldo_actual,
            'saldo_amortizaciones' => $saldo_amortizacion,

        ]);

      

        $saldoPendiente = TablaAmortizacion::where('solicituds_id',$idSolicitud)
                        ->where('saldo_actual', '>', 0)
                        ->orderBy('num_pago', 'desc')
                        ->latest('num_pago')->first();

        // $saldoPendiente = TablaAmortizacion::where('estatus','Cobrado')->latest('saldo_actual')->first();

        if($saldoPendiente){
            if($saldoPendiente->saldo_pago < $monto_exigible){
                $saldo_amortizacion = $saldoPendiente->saldo_amortizaciones - $saldoPendiente->saldo_pago;
                TablaAmortizacion::where('id', $idAmortizacion)->update([
                    'saldo_amortizaciones' => $saldo_amortizacion,
                ]);
            }
        }

        $numPagos = TablaAmortizacion::where('solicituds_id',$idSolicitud)->where('estatus','No cobrado')->count();
        if($numPagos == 0){
            Analisis_credito::where('solicituds_id', $idSolicitud)->update([
                'estatus_credito' => 'Pagado',
            ]);
        }
        
        $this->revisarSaldo($saldoPendiente->saldo_pago,$idSolicitud,$saldoPendiente->pago_aplicado,$saldoPendiente->saldo_actual, $saldoPendiente->saldo_amortizaciones);
    }

    
    public function show($id)
    {
        $creditos = Analisis_credito::where('solicituds_id',$id)->first();
        $transacciones = Transacciones::where('solicituds_id',$id)->paginate(6);
        $abonado = Transacciones::where('solicituds_id', $id)->sum('monto');
        $cuentasCaja = Caja::all();
        $bancos = Banco::all();
        $cuentaActivo = Articulo::where('tipo_producto','ACTIVO')->get();
        return view('transacciones.details', compact('creditos','transacciones','abonado','cuentasCaja','bancos','cuentaActivo'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuentasCaja = Caja::all();
        $bancos = Banco::all();
        $cuentaActivo = Articulo::where('tipo_producto','ACTIVO')->get();
        $vencimiento = TablaAmortizacion::where('solicituds_id',$id)->get();
        return view('admin.transacciones.transaccion', compact('vencimiento','cuentaActivo','cuentasCaja','bancos'));
    }

    public function procesarDatos()
    {
        $datos = PagosMasivos::select('pagos_masivos.*')
        ->where('pagos_masivos.estatus','Pendiente')
        ->where('solicituds.estatus','!=', 'Pendiente')
        ->join('solicituds', 'solicituds.id', '=', 'pagos_masivos.solicituds_id')
        ->get();
        if($datos->isEmpty()){
            return redirect()->route('admin.pagos_masivos.index')->with('error', 'No hay pagos para procesar');

        }else{
            $count = 0;
            // Realiza alguna lógica con los datos, por ejemplo, enviarlos a una función existente.
            foreach ($datos as $dato) {
                $count ++;
                $nuevoModelo = new PagosMasivos;
                $nuevoModelo->idSolicitud = $dato->solicituds_id;
                $nuevoModelo->fecha_pago = $dato->fecha_pago;
                $nuevoModelo->tipo_pago = $dato->tipo_pago;
                $nuevoModelo->monto_pago = $dato->monto_pago;
                $nuevoModelo->concepto = $dato->observaciones;
                $nuevoModelo->referencia = $dato->referencia;
                $nuevoModelo->cuentas_id = $dato->cuentas_id;
                PagosMasivos::where('id', $dato->id)->update([
                    'estatus' => 'Procesado',
                ]);
                $this->storeMasivo($nuevoModelo);
    
            }
    
            // Devuelve una respuesta, si es necesario.
            // return response()->json(['message' => $count]);
            return redirect()->route('admin.pagos_masivos.index')->with('mensaje', 'Se procesaron '.$count.' Pagos exitosamente');
    
        }
        
    }

    public function storeMasivo($pagosMasivos)
    {
        

        $pagoNoCobrado = TablaAmortizacion::where('solicituds_id',$pagosMasivos->idSolicitud)->where('estatus','No cobrado')->orderBy('num_pago', 'asc')->first();
        if($pagoNoCobrado){
            if($pagoNoCobrado){

                $transaccion = new Transacciones();
    
                $transaccion->solicituds_id = $pagosMasivos->idSolicitud;
                $transaccion->tabla_amortizacion_id = $pagoNoCobrado->id;
                $transaccion->fecha_aplicacion = $pagosMasivos->fecha_pago;
                $transaccion->tipo = $pagosMasivos->tipo_pago;
                $transaccion->monto = (str_replace(",","",$pagosMasivos->monto_pago));
                $transaccion->cuentas_id = $pagosMasivos->cuentas_id;
                $transaccion->referencia = mb_strtoupper($pagosMasivos->referencia, 'UTF-8');
                $transaccion->observaciones = mb_strtoupper($pagosMasivos->concepto, 'UTF-8');
    
                $transaccion->save();
                $idTransaccion= $transaccion["id"];
    
            }
            $rowTrans = Transacciones::where('id',$idTransaccion)->latest()->first();
    
            if($pagoNoCobrado->pago_aplicado){ //ya trae un movimiento
                $pago_aplicado = $pagoNoCobrado->pago_aplicado + $rowTrans->monto;
            }else{
                $pago_aplicado = $rowTrans->monto;  
            }
    
            // dd($pago_aplicado);
            $saldo1 = TablaAmortizacion::where('solicituds_id',$pagosMasivos->idSolicitud)
            ->where('saldo_actual', '>', 0)
            ->orderBy('num_pago', 'desc')
            ->latest('num_pago')->first();
    
            if($saldo1){
                $ultimo_saldo = $saldo1->saldo_actual;  ////1
                $ultimo_amort = $saldo1->saldo_amortizaciones;  ////1
            }else{
                $ultimo_saldo = 0;  ///2
                $ultimo_amort = 0;  ///2
            }
    
    
            $this->calculo($rowTrans->monto,$pago_aplicado, $pagoNoCobrado->pago, $pagoNoCobrado->id,$pagosMasivos->idSolicitud,$ultimo_saldo, $ultimo_amort);
           
        }
       

        return redirect()->route('admin.transacciones.index');

    }

    public function reporteCartera(){
        $data = Analisis_credito::select('analisis_credito.*')
        ->join('solicituds', 'solicituds.id', '=', 'analisis_credito.solicituds_id')
        ->join('clientes', 'clientes.id', '=', 'solicituds.cliente_id');

        return Excel::download(new CarteraClientesExport($data->get()), 'detalles'. '.xlsx');
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
        //
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
