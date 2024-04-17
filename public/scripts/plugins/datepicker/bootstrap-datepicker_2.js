            var defaults = $.fn.datepicker2.defaults = {
		autoclose: false,
		beforeShowDay: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		daysOfWeekDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'dd/mm/yyyy',
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		multidate: false,
		multidateSeparator: ',',
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		weekStart: 0
	};
            
            
            var today = new Date();
            var bkDate = new Date();
            var dayOfMonth = bkDate.getDate();
            bkDate.setDate(dayOfMonth - 9);


            function parseDMY(value) {
                var date = value.split("/");
                var d = parseInt(date[0], 10),
                    m = parseInt(date[1], 10),
                    y = parseInt(date[2], 10);
                return new Date(y, m - 1, d);
            }
            
            
            var authorValidator = $("#itemAuthorForm").validate({
                rules: {
                    dateOfBirth: {
                        required: false,
                        dateITA: true,
                        dateLessThan: '#expiredDate'
                    },
                    expiredDate: {
                        required: false,
                        dateITA: true,
                        dateGreaterThan: "#dateOfBirth"
                    }
                },
                onfocusout: function (element) {
                    if ($(element).val()) {
                        $(element).valid();
                    }
                }
            });

            var dateOptionsDOE = {
                 closeText: 'Cerrar',
                 prevText: '< Ant',
                 nextText: 'Sig >',
                 currentText: 'Hoy',
                 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                 maxDate: today,
                 minDate: bkDate,
                 dateFormat: "dd/mm/yy",
                 changeMonth: true,
                 changeYear: true,
                onClose: function (selectedDate) {
                    $("#dateOfBirth").datepicker2("option", "maxDate", selectedDate);
                }
            };
            
            var gmDt = '';
            var bkDate2 = new Date();
            var dayOfMonth = bkDate2.getDate();
            
            $('#fech_gestion').on('change',function(){
                    gmDt = $('#fech_gestion').val();
                    //alert('gmDt->'+gmDt);
                    gmDt = parseDMY(gmDt);
                    //alert('gmDt-->'+gmDt);
                    ms = Date.parse(gmDt);
                    fecha = new Date(ms);
                    //alert('fecha-->'+fecha);
                    var diasDif = today.getTime() - fecha.getTime();
                    var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
                    
                    var hora = today.getHours();
                    var min = today.getMinutes();
                    //alert(hora+':'+min);
                    if(hora >=12 && min >=00){dias = (dias-1);}
                    //alert(dias);
                    //alert("dias de diferencia: " + dias);
                    bkDate2.setDate(dayOfMonth - dias);
                    //alert('bkDate2->'+bkDate2);
                    //alert('today->'+today);    
            });
            
            var dateOptionsDOB = {
                maxDate: today, 
               minDate:  bkDate2,
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                onClose: function (selectedDate) {
                    $("#expiredDate").datepicker2("option", "minDate", selectedDate);
                }
            };
            
            var dateOptionsDOP = {
                
                minDate:  today,
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                onClose: function (selectedDate) {
                    $("#expiredDate").datepicker2("option", "minDate", selectedDate);
                }
            };
            
            var dateOptionsRFD = {
                
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                onClose: function (selectedDate) {
                    $("#expiredDate").datepicker2("option", "minDate", selectedDate);
                }
            };
            
            var dateOptionsRSD = {
               
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                onClose: function (selectedDate) {
                    $("#expiredDate").datepicker2("option", "minDate", selectedDate);
                }
            };

            jQuery.validator.addMethod("dateGreaterThan",

            function (value, element, params) {
                var theDate = parseDMY(value);
                var paramDate = parseDMY($(params).val());
                if ($(params).val() === "") return true;

                if (!/Invalid|NaN/.test(theDate)) {
                    return theDate > paramDate;
                }
                return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
                }, 'Must be greater than {0}.');

            jQuery.validator.addMethod("dateLessThan",

            function (value, element, params) {
                var theDate = parseDMY(value);
                var paramDate = parseDMY($(params).val());
                if ($(params).val() === "") return true;

                if (!/Invalid|NaN/.test(theDate)) {
                    return theDate < paramDate;
                }

                return isNaN(value) && isNaN($(params).val()) || (Number(value) < Number($(params).val()));
                }, 'Must be less than {0}.');

            $("#expiredDate").datepicker2($.extend({}, dateOptionsDOE));
            $("#dateOfBirth").datepicker2($.extend({}, $.datepicker2.regional['es'], dateOptionsDOB));