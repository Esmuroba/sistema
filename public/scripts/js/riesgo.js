

function calculoTotal(){
    let monto_solicitado = convertir($("#txt_monto_solicitado").val());
    let ingreso_mensual = convertir($("#txt_ingreso_mensual").val());
    let gasto_mensual = convertir($("#txt_gasto_mensual").val());
    let tasa = $("#txt_tasa").val();
    let plazo = $("#txt_plazo").val();
    let porcentaje = tasa * (1/100);

    if (isNaN(monto_solicitado) || isNaN(tasa) || isNaN(plazo)) {
        $("#txt_total").val("")
    }else{   
        let formulaTotal = ((monto_solicitado * porcentaje) + monto_solicitado);
        let fPagoSemanal = formulaTotal / plazo
        let fCapPago = (ingreso_mensual - gasto_mensual) / formulaTotal
        $("#txt_total").html(formato_numero(formulaTotal,2,'.',','))
        $("#txt_total_val").val(formato_numero(formulaTotal,2,'.',','))
        $("#txt_pago_semanal").html(formato_numero(fPagoSemanal,2,'.',','))
        $("#txt_pago_val").val(formato_numero(fPagoSemanal,2,'.',','))
        $("#txt_cap_pago").html(fCapPago.toFixed(4))
        $("#txt_cal_capPago").val(fCapPago.toFixed(4))
    }

}

function capacidadPago(){
    let ingreso = convertir($("#txt_ingreso_mensual").val());
    let gasto_mensual = convertir($("#txt_gasto_mensual").val());
    let monto_solic = convertir($("#txt_monto_solicitado").val());
    if (isNaN(ingreso) || isNaN(gasto_mensual) || isNaN(monto_solic)) {
        $("#txt_capacidad_pago").val("")
    }else{   
        let formula = ((ingreso - gasto_mensual) / monto_solic) * 100
        let resultado = formula.toFixed(2)
        $("#txt_capacidad_pago").val(resultado)
    }

}

function cuota(){
    let monto_solicitado = convertir($("#txt_monto_solicitado").val());
    let tasa = $("#txt_tasa").val();
    let plazo = $("#txt_plazo").val();
    let porcentaje = tasa * (1/100);

    if (isNaN(monto_solicitado) || isNaN(tasa) || isNaN(plazo)) {
        $("#txt_cuota").val("")
    }else{   
        let formulaCuota = ((monto_solicitado * porcentaje) + monto_solicitado) / plazo
        let saldoPendiente= ((monto_solicitado * porcentaje) + monto_solicitado)
        let resultado2 = formulaCuota.toFixed(2)
        $("#txt_cuota").val(resultado2)
    }

}

function calcularTablaAmortizacionRiesgo(){
    
    let cuota = document.getElementById("txt_cuota").value;
    let plazo = document.getElementById("txt_plazo").value;
    let tasa = document.getElementById("txt_tasa").value;
    let frecuencia_pago = document.getElementById("txt_frecuencia_pago").value;
    let monto_solicitado = document.getElementById("txt_monto_solicitado").value;
    let monto_autorizado = document.getElementById("txt_monto_autorizado").value;
    let fecha_desembolso = document.getElementById("txt_fdesembolso").value;
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/detalleTablaAmortizacion',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            monto_solicitado : monto_solicitado,
            monto_autorizado : monto_autorizado,
            fecha_desembolso : fecha_desembolso,
            cuota : cuota,
            plazo : plazo,
            tasa : tasa,
            frecuencia_pago : frecuencia_pago,
        },
        
        success:function(data){
            console.log(data);
            vistaTablaAmortizacion(data);
        }
    });

}

function vistaTablaAmortizacion(tabla) {
    let html = '';
    tabla.forEach(fila =>  {
        
        html += '<tr><td>'+fila.mes+'</td><td>'+moment(fila.fecha_pago).utc().format('DD/MM/YYYY')+'</td><td>'+fila.cuota+'</td><td>'+fila.capital+'</td><td>'+fila.interes+'</td><td class="text-center">'+fila.saldo+'</td><td>'+fila.gasto_por_cobranza+'</td></tr>'
    })
    $("#tablaAmortizacion").html(html);
}

function variablesDeRiesgoEdad(){
    let variable = document.getElementById("txt_var_edad").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion').html(data[0].calificacion);
            $('#txt_cal_edad').val(data[0].calificacion);
            $('#txt_beta').html(data[0].beta);
            $('#txt_severidad').html(data[0].var);
            $('#txt_zeta_edad').val(data[0].zeta);
            $('#txt_z_edad').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });

}

function variablesDeRiesgoGenero(){
    let variable = document.getElementById("txt_var_sexo").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_sex').html(data[0].calificacion);
            $('#txt_cal_genero').val(data[0].calificacion);
            $('#txt_beta_sex').html(data[0].beta);
            $('#txt_severidad_sex').html(data[0].var);
            $('#txt_zeta_sex').val(data[0].zeta);
            $('#txt_z_sex').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });
}

function variablesDeRiesgoVivienda(){
    let variable = document.getElementById("txt_var_vivienda").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_viv').html(data[0].calificacion);
            $('#txt_cal_viv').val(data[0].calificacion);
            $('#txt_beta_viv').html(data[0].beta);
            $('#txt_severidad_viv').html(data[0].var);
            $('#txt_zeta_viv').val(data[0].zeta);
            $('#txt_z_viv').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });
}

function variablesDeRiesgoEdoCivil(){
    let variable = document.getElementById("txt_var_edo_civil").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_civil').html(data[0].calificacion);
            $('#txt_cal_edcivil').val(data[0].calificacion);
            $('#txt_beta_civil').html(data[0].beta);
            $('#txt_severidad_civil').html(data[0].var);
            $('#txt_zeta_civil').val(data[0].zeta);
            $('#txt_z_civil').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });
}

function variablesDeRiesgoDepEc(){
    let variable = document.getElementById("txt_var_depEc").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_dep').html(data[0].calificacion);
            $('#txt_cal_dep').val(data[0].calificacion);
            $('#txt_beta_dep').html(data[0].beta);
            $('#txt_severidad_dep').html(data[0].var);
            $('#txt_zeta_dep').val(data[0].zeta);
            $('#txt_z_dep').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });
}

function variablesDeRiesgoEsc(){
    let variable = document.getElementById("txt_var_esc").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_esc').html(data[0].calificacion);
            $('#txt_cal_escol').val(data[0].calificacion);
            $('#txt_beta_esc').html(data[0].beta);
            $('#txt_severidad_esc').html(data[0].var);
            $('#txt_zeta_esc').val(data[0].zeta);
            $('#txt_z_esc').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });
}

function variablesDeRiesgoCiclo(){
    let variable = document.getElementById("txt_var_ciclo").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_ciclo').html(data[0].calificacion);
            $('#txt_cal_ciclo').val(data[0].calificacion);
            $('#txt_beta_ciclo').html(data[0].beta);
            $('#txt_severidad_ciclo').html(data[0].var);
            $('#txt_zeta_ciclo').val(data[0].zeta);
            $('#txt_z_ciclo').html(data[0].zeta);

            calculoScore();
            calculoZ();
        }
    });
}

function variablesDeRiesgoIngreso(){
    let variable = document.getElementById("txt_var_ingreso").value;    
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: '/admin/analisis_credito/variableRiesgo',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            variable : variable
        },
        
        success:function(data){
            console.log(data);
            $('#txt_calificacion_ingreso').html(data[0].calificacion);
            $('#txt_cal_ingreso').val(data[0].calificacion);
            $('#txt_beta_ingreso').html(data[0].beta);
            $('#txt_severidad_ingreso').html(data[0].var);
            $('#txt_zeta_ingreso').val(data[0].zeta);
            $('#txt_z_ingreso').html(data[0].zeta);

            calculoScore();
            calculoZ();
            calculoIndiceSev();
        }
    });
}

function calculoScore(){
    let califEdad = $("#txt_cal_edad").val();
    let califGenero = $("#txt_cal_genero").val();
    let califViv = $("#txt_cal_viv").val();
    let califEdoCivil = $("#txt_cal_edcivil").val();
    let califDep = $("#txt_cal_dep").val();
    let califEsc = $("#txt_cal_escol").val();
    let califCiclo = $("#txt_cal_ciclo").val();
    let califIngreso = $("#txt_cal_ingreso").val();
    let califCapPago = $("#txt_cal_capPago").val();

    let formulaScore = (parseFloat(califEdad) + parseFloat(califGenero) + parseFloat(califViv) + parseFloat(califEdoCivil) + parseFloat(califDep) + parseFloat(califEsc) + parseFloat(califCiclo)  + parseFloat(califIngreso)  + parseFloat(califCapPago))

    if (isNaN(formulaScore)) {
        $("#txt_score").html("--")
    }else{   
        $("#txt_score").html(formulaScore.toFixed(4))
        $("#txt_score_val").val(formulaScore.toFixed(4))
    }

}

function calculoZ(){
    let zetaEdad = $("#txt_zeta_edad").val();
    let zetaGenero = $("#txt_zeta_sex").val();
    let zetaViv = $("#txt_zeta_viv").val();
    let zetaEdoCivil = $("#txt_zeta_civil").val();
    let zetaDep = $("#txt_zeta_dep").val();
    let zetaEsc = $("#txt_zeta_esc").val();
    let zetaCiclo = $("#txt_zeta_ciclo").val();
    let zetaIngreso = $("#txt_zeta_ingreso").val();

    let formulaZ = - parseFloat( 1.9411) +((parseFloat(zetaEdad) + parseFloat(zetaGenero) + parseFloat(zetaViv) + parseFloat(zetaEdoCivil) + parseFloat(zetaDep) + parseFloat(zetaEsc) + parseFloat(zetaCiclo)  + parseFloat(zetaIngreso)) - parseFloat(zetaEsc))

    if (isNaN(formulaZ)) {
        $("#txt_z").html("--")
    }else{   
        $("#txt_z").html(formulaZ.toFixed(4))
        $("#txt_zeta_val").val(formulaZ.toFixed(4))
        calcularProbabilidad()
    }
   
}

function calcularProbabilidad(){
    let zeta = $("#txt_zeta_val").val();

    let formulaProbabilidad = (parseFloat(1) / (parseFloat(1) + Math.pow(parseFloat(2.7183), - parseFloat(zeta))))
    
    if (isNaN(formulaProbabilidad)) {
        $("#txt_probabilidad_incumplimiento").html("--")
    }else{   
        $("#txt_probabilidad_incumplimiento").html((formulaProbabilidad *= 100).toFixed(4))
        $("#txt_incumplimi_val").val((formulaProbabilidad *= 100).toFixed(4))
        calculoVar();
    }
    
}

function calculoIndiceSev(){
    let zetaSeveridad = $("#txt_zeta_ingreso").val();

    let resultZetaSev = parseFloat(zetaSeveridad);
    
    if (isNaN(resultZetaSev)) {
        $("#txt_indice_sev").html("--")
    }else{   
        $("#txt_indice_val").val(resultZetaSev.toFixed(4))
        $("#txt_indice_sev").html(resultZetaSev.toFixed(4))
        calculoSeveridad();
    }
}

function calculoSeveridad(){
    let indiceSev = $("#txt_indice_val").val();
    let monto_solic = convertir($("#txt_monto_solicitado").val());
    let resultCalculoSev = 1 - (parseFloat(indiceSev) / parseFloat(monto_solic));
    
    if (isNaN(resultCalculoSev)) {
        $("#txt_calculo_sev").html("--")
    }else{   
        $("#txt_calculo_sev").html(resultCalculoSev.toFixed(4))
        $("#txt_calculo_val").val(resultCalculoSev.toFixed(4))
        calculoPerdidaEsperada();
    }
    
}

function calculoPerdidaEsperada(){
   
    let incumplimiento = $("#txt_incumplimi_val").val();
    let calculoSev = $("#txt_calculo_val").val();
    let monto_solic = convertir($("#txt_monto_solicitado").val());
    let incumplimientoPorc = parseFloat(incumplimiento) /100;
    incumplimientoPorc = incumplimientoPorc /100;
    let resultPerdida = (parseFloat(incumplimientoPorc) * parseFloat(calculoSev) * monto_solic );
   
    if (isNaN(resultPerdida)) {
        $("#txt_perdida_esperada").html("--")
    }else{   
        $("#txt_perdida_val").val(resultPerdida.toFixed(2))
        $("#txt_perdida_esperada").html(resultPerdida.toFixed(2))
    }
    
}

function calculoVar(){
   
    let incumplimiento = $("#txt_incumplimi_val").val();
    let monto_solic = convertir($("#txt_monto_solicitado").val());
    let incumplimientoPorc = parseFloat(incumplimiento) /100;
    incumplimientoPorc = incumplimientoPorc /100;
    let resultVar = (parseFloat(incumplimientoPorc) * monto_solic );
   
    if (isNaN(resultVar)) {
        $("#txt_var_rsult").html("--")
    }else{   
        $("#txt_var_val").val(resultVar.toFixed(2))
        $("#txt_var_rsult").html(resultVar.toFixed(2))
    }
    
}

function verMontoAutorizado(){
    let monto_autorizado = $("#txt_monto_autorizado").val();
    $("#txt_monto_aprobado").html(monto_autorizado);  
}