// JavaScript Document
//*************************************************************************************

function btGenCurp( frm, tipoAsp )
{
    var curp;
    let nombre = $("#nombre").val();
    let apellidoPaterno = $("#apellido_paterno").val();
    let apellidoMaterno = $("#apellido_materno").val();
    let fechaNac = $("#fecha_nacimiento").val();
    let genero = $("#genero").val();
    let entidad = $("#estado").val();
    let whcurp = $("#curp").val();


	if (!validaNombrePaternoMaterno(nombre,apellidoPaterno,apellidoMaterno,tipoAsp)) return;
	if (!validaFechaGeneroEstado()) return;
	
	curp=GeneraCURP(nombre,apellidoPaterno,apellidoMaterno,
        fechaNac,genero,entidad);
	if ( curp!= 'x' ){
		whCurp=curp;
		//alert('Verifica que la CURP sea correcta.');
	}
    $("#curp").val(curp);

    
}
//*************************************************************************************

function curp()
{
        var Vcurp = $("#icurp").contents().find("#whCurp").val();
        jQuery("#curp").val(Vcurp);
        var VFecha = $("#icurp").contents().find("#whFecNac").val();
        jQuery("#birth").val(VFecha);

	//alert(mensajeTXT);
}
//*************************************************************************************
function botonIdentificar( frm, tipoAsp )
{var curp1, curp2;

	if (!validaNombrePaternoMaterno(nombre,apellidoPaterno,apellidoMaterno,tipoAsp)) return;
	if (!validaFechaGeneroEstado()) return;
	
	curp1=utrim(frm.whCurp.value);
	frm.whCurp.value=curp1;
	if (curp1.length!=18){
		if (curp1=='')
			alert('Esribe tu CURP por favor');
		else
			alert('La longitud del CURP es incorrecto');
		frm.whCurp.focus();
		return;
	}
	
	curp2=GeneraCURP(nombre,apellidoPaterno,apellidoMaterno,
        fechaNac,genero,entidad);	

	if ( curp1.substring(0,10) != curp2.substring(0,10) )
	{
		alert('La CURP no corresponde con los datos proporcionados.');
		frm.whCurp.focus();
		return;
	}
	if ( curp1 != curp2 )
	{
		if ( !confirm('Alguno de los ultimos caracteres de la CURP \n' +
					  'no parecen corresponder con los datos proporcionados.\n�Desea continuar de todos modos?') )
		{
			frm.whCurp.focus();
			return;
		}
	}
	frm.action='datosgenerales.asp';
	frm.submit();
}
//*************************************************************************************
//*************************************************************************************
function btTerminar()
{
	window.close();
	location='http://www.admision.ipn.mx';
}
//*************************************************************************************
//*************************************************************************************
function validaNombrePaternoMaterno( nombre,apellidoPaterno,apellidoMaterno, tipoAsp )
{
	nombre = utrim(nombre);
	apellidoPaterno = utrim(apellidoPaterno);
	apellidoMaterno = utrim(apellidoMaterno);
	if (tipoAsp!='3') 
		return true;
	if ( !validaNombre(nombre) )
	{
		if(nombre=='')
			alert('Escribe tu nombre por favor');
		else
			alert('El campo nombre solo acepta letras (A-Z), el espacio y el punto.\nNo se aceptan caracteres acentuados ni dieresis.');
            nombre.focus();
		return false;
	}
	if ( !validaNombre(apellidoPaterno) )
	{
		if(apellidoPaterno=='')
			alert('Escribe tu apellido paterno por favor.\nSi solo tienes un apellido, escribelo aqu�.');
		else
			alert('El campo de apellido paterno solo acepta letras (A-Z), el espacio y el punto.\nNo se aceptan caracteres acentuados ni dieresis.');
            apellidoPaterno.focus();
		return false;
	}
	if ( !validaNombre(apellidoMaterno) )
	{
		if(apellidoMaterno=='')
		{
			if (confirm('�Deseas dejar el campo de apellido materno en blanco?'))
				return true;
		}
		else
			alert('El campo apellido materno solo acepta letras (A-Z), el espacio y el punto.\nNo se aceptan caracteres acentuados ni dieresis.');
            apellidoMaterno.focus();
		return false;
	}
	return true;
}
//*************************************************************************************
//*************************************************************************************
function validaFechaGeneroEstado()
{
    fechaNaci = trim($("#fecha_nacimiento").val());
    genero = $("#genero").val();
    entNac = $("#estado").val();
	if ( fechaNaci=='' ) {
		alert('Debes elegir tu fecha de nacimiento.')
		fechaNaci.focus();
		return false;
	}
	// if (tipoAsp=='3') {
	// 	frm.whFecNacCfr.value=trim(frm.whFecNacCfr.value)
	// 	if ( frm.whFecNacCfr.value=='')	{
	// 		alert('Confirma tu fecha de nacimiento.');
	// 		frm.whFecNacCfr.focus();
	// 		return false;
	// 	}
	// 	if ( frm.whFecNacCfr.value!=frm.whFecNac.value) {
	// 		alert('La confirmaci�n de tu fecha de nacimiento es incorrecta.');
	// 		frm.whFecNacCfr.focus();
	// 		return false;
	// 	}
		
	// }
	if (genero==0) {
		alert('Selecciona tu genero.')
		genero.focus();
		return false;
	}
	if ( entNac==0)	{
		alert('Elije tu lugar de nacimiento');
		entNac.focus();
		return false;
	}
	return true;
}
//*************************************************************************************
//*************************************************************************************
function validaNombre( cmp )
{var c, i;
	cmp=trim(cmp)
	if ( cmp.length==0 ) return false;
	for (i=0; i<cmp.length; i++)
	{
		c=cmp.charAt(i);
		if ( !( ( 'A'<=c && c<='Z' ) || c=='�' || c=='.' || c==' ' ) )
			return false;
	}
	return true;	
}

function isNull( cadena )
{
	if ( cadena == null ) return true;
	if ( typeof (cadena) == 'undefined' ) return true;
	if ( cadena == "" ) return true;
	return false;
}

function trimRight ( cadena )
{var lg, cad, r = "";
	cad = new String(cadena);
	if ( isNull(cad) ) return r;

	lg = cad.length - 1;
  	while ((lg >= 0) && (cad.charAt(lg) == " ")) lg--; 			
  	r = cad.substring(0, lg + 1);
  	  	
  	return r;  	
	
}

function trimLeft( cadena ) 
{var i, lg, cad, r="";

	cad = new String(cadena);
	if ( isNull(cad) ) return r;

	i=0;
	lg = cad.length;		
  	while ((i < lg) && (cad.charAt(i) == " ")) i++;
  	r = cad.substring(i, lg);
  	
  	return r;
}

function trim ( cadena )
{
	return trimLeft( trimRight ( cadena ) );
}

function utrim ( cadena )
{
	return trim( cadena ).toUpperCase().replace('�','�');;
}

// JavaScript Document
function GeneraCURP( nom, pat, mat, fechaEnFormatoOriginal, genero, edo )
{var quitar, nombres, curp;

	const fechaOriginal = new Date(fechaEnFormatoOriginal + 'T00:00:00Z');

	// Obtener los componentes de la fecha
	const dia = fechaOriginal.getUTCDate();
	const mes = fechaOriginal.getUTCMonth() + 1; // ¡Recuerda que los meses en JavaScript comienzan desde 0!
	const anio = fechaOriginal.getUTCFullYear();

	// Crear el nuevo formato '30/11/1995'
	const fecha = `${dia}/${mes}/${anio}`;

	nom=nom.toUpperCase();
	pat=pat.toUpperCase();
	mat=mat.toUpperCase();
	genero=genero.toUpperCase();
	
	quitar= new RegExp(/^(DE |DEL |LO |LOS |LA |LAS )+/);
	nombres=new RegExp(/^(MARIA |JOSE )/);
	nom=nom.replace(quitar,'');
	nom=nom.replace(nombres,'');
	nom=nom.replace(quitar,'');
	pat=pat.replace(quitar,'');
	mat=mat.replace(quitar,'');
	if (mat=='') mat='X';
	
	curp  = pat.substring(0,1) + buscaVocal( pat )+ mat.substring(0,1) + nom.substring(0,2);
	curp  = cambiaPalabra( curp );
	curp += fecha.substring(8,10) + fecha.substring(3,5) + fecha.substring(0,2);
	curp += (genero=='M'?'H':'M') + estado( edo );
	curp += buscaConsonante( pat ) + buscaConsonante( mat ) + buscaConsonante( nom ) ;
	curp += fecha.substring(6,8)=='19'?'0':'A';
	curp += ultdig( curp );
	return curp;	
}

function buscaVocal( str )
{var vocales='AEIOU';
var i, c;
	for(i=1; i<str.length; i++)	{
		c=str.charAt(i);
		if ( vocales.indexOf(c)>=0 ){
			return c;
		}		
	}
	return 'X';
}

function buscaConsonante( str )
{var vocales='AEIOU ��.';
var i, c;
	for(i=1; i<str.length; i++)	{
		c=str.charAt(i);
		if ( vocales.indexOf(c)<0 ){
			return c;
		}		
	}
	return 'X';
}

function cambiaPalabra( str )
{var pal1=new RegExp(/BUEI|BUEY|CACA|CACO|CAGA|CAGO|CAKA|CAKO|COGE|COJA|COJE|COJI|COJO|CULO|FETO|GUEY/);
 var pal2=new RegExp(/JOTO|KACA|KACO|KAGA|KAGO|KOGE|KOJO|KAKA|KULO|LOCA|LOCO|MAME|MAMO|MEAR|MEAS|MEON/);
 var pal3=new RegExp(/MION|MOCO|MULA|PEDA|PEDO|PENE|PUTA|PUTO|QULO|RATA|RUIN/);
 var val;
 
 	str=str.substring(0,4);
	
 	val = pal1.test( str ) || pal2.test( str );
 	val = pal3.test( str ) || val;

	if ( val ) 
		return str.substring(0,1) + 'X' + str.substring(2,4);
		
	return str;
	
}

function estado( edo )
{var edo;
var vestado = new Array ( 'DF','AS','BC','BS','CC','CL','CM','CS','CH','DG','GT','GR','HG','JC','MC','MN',
				'MS','NT','NL','OC','PL','QT','QR','SP','SL','SR','TC','TS','TL','VZ','YN','ZS','NE');	
	return vestado[edo];
}


function tabla(i, x ){
if(i >= '0' && i<= '9') return x-48;
else if (i>= 'A' && i<= 'N') return x-55;
else if (i>= 'O' && i<= 'Z') return x-54;
else return 0;
}

function ultdig( curp ) 
{var i, c, dv = 0;
//en este punto, la variable curp tiene todo excepto el ultimo digito verificador
//ejemplo: JIRA0302024MVZMVNA
	for(i=0; i<curp.length; i++) 
	{
		c=tabla(curp.charAt(i), curp.charCodeAt(i));
		dv += c * (18-i);
	}
	dv%=10;
	return dv==0?0:10-dv;
}




	