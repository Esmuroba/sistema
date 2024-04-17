function downloadFileGet({el,url,fileName,msj_finished,logs="No"}){
    makeLoader({el:el,msj_loader: "",status:'loader'})
//alert(logs);

    $result =  fetch(url,{
        method:'GET',
        headers: {
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
    })
    if(logs == "No"){
        $result.then(resp => resp.blob())
        .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        // the filename you want
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        //alert('your file has downloaded!'); // or you know, something with better UX...
        makeLoader({el:el,msj_finished : msj_finished,status:'finished'})
        })
        .catch(error =>{ 
            makeLoader({el:el,msj_finished : msj_finished,status:'finished'})
            console.log(error);
            alert('oh no!')});
    }/* else{
      $result.then(resp => {
          console.log(resp)
          makeLoader({el:el,msj_finished : msj_finished,status:'finished'})
      }
      )
    } */
    //makeLoader({el:el,msj_finished : msj_finished,status:'finished'})
    
}

function limpiaForm(miForm) {
    // recorremos todos los campos que tiene el formulario
    $(':input', miForm).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        //limpiamos los valores de los campos…
        if (type == 'text' || type == 'number' || type == 'password' || tag == 'textarea' || type == 'hidden')
        this.value = '';
        // excepto de los checkboxes y radios, le quitamos el checked
        // pero su valor no debe ser cambiado
        else if (type == 'checkbox' || type == 'radio')
        this.checked = false;
        // los selects le ponesmos el indice a -
        else if (tag == 'select')
        this.selectedIndex = "";
        else if (type == 'file')
        this.value = '';
    });
}
function limpiaFormFATO(miForm) {
    // recorremos todos los campos que tiene el formulario
    $(':input', miForm).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        //limpiamos los valores de los campos…
        if (type == 'text' || type == 'password' || tag == 'textarea')
        this.value = '';
        // excepto de los checkboxes y radios, le quitamos el checked
        // pero su valor no debe ser cambiado
        else if (type == 'checkbox' || type == 'radio')
        this.checked = false;
        // los selects le ponesmos el indice a -
        else if (tag == 'select')
        this.selectedIndex = "";
        else if (type == 'file')
        this.value = '';
        location.reload();
    });
}

function clearForm(miForm) {
    // recorremos todos los campos que tiene el formulario
    $(':input', miForm).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        //limpiamos los valores de los campos…
        if (type == 'text' || type == 'password' || tag == 'textarea' || tag == 'number')
        this.value = '';
        // excepto de los checkboxes y radios, le quitamos el checked
        // pero su valor no debe ser cambiado
        else if (type == 'checkbox' || type == 'radio')
        this.checked = false;
        // los selects le ponesmos el indice a -
        else if (type == 'file')
        this.value = '';
    });
    console.log(miForm);
}


function mostrar(){
    $('#myModal').modal('toggle');
}

function esconder(){
    $('#myModal').modal('show');
}

function nose(){
    $('#myModal').modal('hide');
}

function handleUpdate(){
    $('#myModal').modal('handleUpdate');
}

function error(){
        //una notificación de error
	alertify.error("Usuario o constraseña incorrecto/a."); 
	return false; 
}

// function copyToClipboard(elemento) {
//     var aux = document.createElement("input");
//     aux.setAttribute("value", document.getElementById(elemento).textContent);
//     document.body.appendChild(aux);
//     aux.select();
//     document.execCommand("copy");
//     document.body.removeChild(aux);
//     console.log("COPIADO !!!");
//     alertify.log('<i class="fa fa-check-circle fa-lg" aria-hidden="true"></i> Copiado ... '+document.getElementById(elemento).textContent);
// }

function convertir(numero){

    if(numero.indexOf("$") >= 0){
        numero = numero.substring(1);   
    }
    
    while (numero.toString().indexOf(',') != -1){
        numero = numero.toString().replace(',',''); 
    }   
    
    numero = parseFloat(numero);
    return numero;
}

function formato_numero(numero, decimales, separador_decimal, separador_miles){ // v2007-08-06
    //$("#v_montoDispo").val(formato_numero(dispo,2,'.',','));
    numero=parseFloat(numero);
        if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}
