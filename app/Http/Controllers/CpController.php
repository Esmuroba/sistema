<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpClient\HttpClient;//eso se puso para resolver el error en checkcp 

class CpController extends Controller
{
    public function checkCp(Request $request) {
        $cp = $request->cp;
        $json = array();
        //declaramos los campos que contendra el array y el orden de los campos estaba diferente
        $head = [1 => 'Asentamiento', 2 => 'Tipo de Asentamiento', 3 => 'Código Postal', 4 => 'Municipio', 5 => 'Estado', 6 => 'Ciudad', 7 => 'Zona', ];
        $datos = array();
        // $client = new Client();
        //$client = new \Goutte\Client();//esto estaba antes, por luis, pero puse lo de a bajo porque me salía el error ssl chek...
        // $client = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_TIMEOUT => 60,CURLOPT_SSL_VERIFYPEER => false),));

        $client = new \Goutte\Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
        $crawler = $client->request('GET', 'https://micodigopostal.org/buscarcp.php?buscar=' . $cp);

        try {
            //revisamos el numero de campos obtenidos para hacer un recorrido, tbl antes tenia tblSearch
            $numerodefilas = $crawler->filter('#tbl > tbody ')->each(function ($data) {
                foreach ($data as $domElement) {
                    return $domElement->childNodes->length;
                }
            });
            $contador = 1;
            //recorremos todos los datos de la tabla
            while ($contador <= $numerodefilas[0]) {
                $cont = 1;
                $temp = array();
                while ($cont <= 7) {
                    $temp[$head[$cont]] = $crawler->filter('#tbl > tbody > tr:nth-child(' . $contador . ') > td:nth-child(' . $cont . ')')->each(function ($node) {
                        if ($node->text() !== '(adsbygoogle = window.adsbygoogle || []).push({});') { //omitimos la publicidad incrustada en la pagina
                            return mb_convert_encoding($node->text(), 'UTF-8');
                        }
                    });
                    if (sizeof($temp) === 7) {
                        $datos[$contador] = $temp;
                    }
                    $cont++;
                }
                $contador++;
            }
        } catch (\Exception $e) {
            $datos[] = "Resultado no encontrado";
        }
        $asentamientos =[];
        if(isset($datos[0])){
            if($datos[0] == 'Resultado no encontrado'){
                return 'Resultado no encontrado';
            }

        }
        foreach($datos as $value){
            if($value['Asentamiento'][0] !==null){
                $asentamientos[]=$value['Asentamiento'][0];
            }
        }
        $response = ["cp" => $datos[1]['Código Postal'][0], "Asentamiento" => $asentamientos, "Municipio" => $datos[1]['Municipio'][0], "Estado" => $datos[1]['Estado'][0], "Ciudad" => $datos[1]['Ciudad'][0]];
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
