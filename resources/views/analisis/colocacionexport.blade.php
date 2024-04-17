
<table>
    <tr>
        <td>Sucursal o Ruta</td>
        <td>Asociado</td>
        <td>Nombre Cliente</td>
        <td>Fecha Desembolso</td>
        <td>Frecuencia</td>
        <td>Plazo</td>
        <td>Cuota</td>
        <td>Total Capital</td>
        <td>Total Intereses</td>
        <td>Intereses sin IVA</td>
        <td>IVA de Interes</td>
        <td>Pendiente</td>
        <td>Comisión</td>
        <td>Total</td>
    </tr>
    @php
        $cont = 0;
    @endphp
    @foreach($data as $colocacion)
            @php
                $monto_autorizado = (str_replace(",","",$colocacion->monto_autorizado));
                $tasa = $colocacion->tasa; ////40
                $porcentaje = $tasa * (1/100);
                $interes = ($monto_autorizado * $porcentaje);
                $capital = $monto_autorizado;
                $interesSIva = $interes / 1.16;
                $IvadInteres = $interesSIva * 0.16;
            @endphp
            <tr>
                <td>{{ $colocacion->solicitud->asociado->ruta->nombre_ruta}}</td>
                <td>{{ $colocacion->solicitud->asociado->getFullName()}}</td>
                <td>{{ $colocacion->solicitud->cliente->getFullName()}}</td>
                <td>{{ date('d/m/Y', strtotime( $colocacion->solicitud->fecha_desembolso))}}</td>
                <td>{{ $colocacion->solicitud->frecuencia_pago}}</td>
                <td>{{ $colocacion->solicitud->plazo}}</td>
                <td>{{ $colocacion->solicitud->cuota}}</td>
                <td>{{ $capital}}</td>
                <td>{{number_format($interes, 2, '.', '')}}</td>
                <td>{{number_format($interesSIva, 2, '.', '')}}</td>
                <td>{{number_format($IvadInteres, 2, '.', '')}}</td>
                <td>{{number_format($colocacion->deduccion, 2, '.', '')}}</td>
                <td>{{number_format($colocacion->comision, 2, '.', '')}}</td>
                <td>{{number_format($colocacion->total_pagado, 2, '.', '')}}</td>
            </tr>
           
    @endforeach
   
</table>
