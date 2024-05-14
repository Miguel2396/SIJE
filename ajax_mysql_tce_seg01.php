<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


header('Content-Type: text/html; charset=utf-8');


$codigo = valida_causa( $bd );

/** 
SERVICIO QUE TRAE LAS ACTUACIONES DE LAS CAUSAS...
**/

$url = "http://172.16.0.208:8080/RRHH/ListadoCausasActuacionesAnio?codigo=".$codigo;

 
 
 
$json = file_get_contents($url );

 
$array = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true);
 
//print_r($array);

$i= 1;
foreach($array as $key => $val){
 
  
          agregar( $bd, $val );

 


   $i++;
 


}

echo 'Datos Procesados... '. $i 	;


function actuacion_texto( $tipo_actuacion) 
{

   
  
    $tipo_actuacion= str_replace("Ó","O",$tipo_actuacion);

    if ( $tipo_actuacion == 'SENTENCIAS'){
       $tipo_actuacion = 'SENTENCIA';
    }

    if ( $tipo_actuacion == 'AUTO DE ACUMULACIÓN (CAUSA ACUMULADORA)'){
       $tipo_actuacion = 'ACUMULACION';
    }

    if ( $tipo_actuacion == 'AUTO DE ACUMULACIN (CAUSA ACUMULADORA)'){
        $tipo_actuacion = 'ACUMULACION';
     }


    if ( $tipo_actuacion == 'AUTO DE ACUMULACIÓN (CAUSA ACUMULATIVA)'){
       $tipo_actuacion = 'ACUMULACION';
    }

    if ( $tipo_actuacion == 'AUTO DE ACUMULACIN (CAUSA ACUMULATIVA)'){
        $tipo_actuacion = 'ACUMULACION';
     }

    if ( $tipo_actuacion == 'RESOLUCIÓN INCIDENTE DE RECUSACIÓN'){
       $tipo_actuacion = 'RESOLUCION INCIDENTE DE RECUSACION';
    }

    if ( $tipo_actuacion == 'RESOLUCIN INCIDENTE DE RECUSACIN'){
        $tipo_actuacion = 'RESOLUCION INCIDENTE DE RECUSACION';
     }
 

    if ( $tipo_actuacion == 'AUTO DE ARCHIVO'){
       $tipo_actuacion = 'AUTO ARCHIVO';
    }

    if ( $tipo_actuacion == 'AUTO DE SUSTANCIACIN'){
        $tipo_actuacion = 'AUTO SUSTANCIACION';
     }

     if ( $tipo_actuacion == 'AUTO DE SUSTANCIACIÓN'){
        $tipo_actuacion = 'AUTO SUSTANCIACION';
     }
 


   
   return $tipo_actuacion;
}

//-----------------------------------------
function acentos( $cadena) 
{

   
  
   $cadena= str_replace("Ã³","ó",$cadena);

   $cadena= str_replace("Ã±","ñ",$cadena);
   
   $cadena= str_replace("Ã­","í",$cadena);

   $cadena= str_replace("Ã¡","á",$cadena);


   $cadena= str_replace("Ãº­","ú",$cadena);
   
   $cadena= str_replace("Ã­","Ó",$cadena);

   $cadena= str_replace("Ã©","é",$cadena);

   $cadena= str_replace("Ãº","Ú",$cadena);
  
   $cadena= str_replace("Ã","ó",$cadena);
   
   return $cadena;
}
//----------------------------------------------------
function valida_causa( $bd ){


    $datos = $bd->query_array('tce.ad_causas_nov',
                              'max(id_enlace) as id_enlace ', 
                              '1='.$bd->sqlvalue_inyeccion(1,true)
            )  ;
 

    $id_enlace = $datos['id_enlace'] ;

 
    return  $id_enlace ;
}     
//-------------
function agregar($bd	, $Row  ){
 
    /*	
       0	serial_cau
       1	 accionante_cau
       2	 accionado_cau
       3	 orgPolitica_cau
       4	xxxx
       5	 noCausa_cau
       6	 fechaIngreso_cau
       7	 estado_cau
       8	 archivo_cau
       9	 tipoDocumento_cau
       10	 fecha_actuacion_cau
       11	 tipo_cau
       12	 ano_cau
       13	 cartelera_cau
       14	 tipoNotSent
       15	tipo_actuacion


   */

   $tabla 	  	  = 'tce.ad_causas_nov';
   $secuencia 	  = 'tce.ad_causas_nov_id_causanov_seq';

   $sesion 	 =     trim($_SESSION['email']);
    $hoy 	 =     date("Y-m-d");    

    $nro_causa = trim(  $Row['noCausa_cau'] ) ;

    $anio_causa = trim(  $Row['ano_cau'] ) ;

    $input = str_pad($nro_causa, 3, "0", STR_PAD_LEFT);
    $causa = $input.'-'. $anio_causa.'-TCE';


    $fecha_causa = trim(  $Row['fecha_actuacion_cau'] ) ;

    $tipo_actuacion = trim(  $Row['tipo_actuacion'] ) ;

    $tipo_actuacion = actuacion_texto( $tipo_actuacion) ;


    echo $tipo_actuacion.'<br>';
 
    $archivo_cau = trim(  $Row['archivo_cau'] ) ;

    $tipodocumento_cau= trim(  $Row['tipoDocumento_cau'] ) ;

    $estado_archivo = trim(  $Row['estado_cau'] ) ;
    
    $enlace = trim(  $Row['serial_cau'] ) ;


    $datos = $bd->query_array(
       'tce.ad_causas_nov',
       'count(*) as nn',
       'coalesce(id_enlace,0)='.$bd->sqlvalue_inyeccion(trim($enlace),true)  
       );

      
       $comentario  = $estado_archivo.' - '.$tipodocumento_cau;

       $observacion = $tipodocumento_cau. ' emitida mediante la plataforma web '. $fecha_causa. ' '.$estado_archivo;

       if ( $datos['nn'] > 0){

       }else{

           $datos_analisis = $bd->query_array(
                'tce.ad_causas' 	,
               'id_causa',
               'causa='.$bd->sqlvalue_inyeccion(trim($causa),true) 
               );
               echo ' <br>';

               if (  $datos_analisis['id_causa'] > 0 ){
                  
                   $id_causa =  $datos_analisis['id_causa'] ;
                   
                       $Tabla = array(
                           array( campo => 'id_causanov',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                           array( campo => 'id_causa',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => $id_causa, key => 'N'),
                           array( campo => 'comentario',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>$comentario, key => 'N'),
                           array( campo => 'observacion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => $observacion, key => 'N'),
                           array( campo => 'actuacion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor =>$tipo_actuacion, key => 'N'),
                           array( campo => 'sesion',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor =>$sesion , key => 'N'),
                           array( campo => 'fecha_creacion',tipo => 'DATE',id => '6',add => 'S', edit => 'N', valor =>   $hoy, key => 'N'),
                           array( campo => 'causa',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'ENLACE', key => 'N'),
                           array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor =>$fecha_causa, key => 'N'),
                           array( campo => 'fecha_alerta',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor =>$fecha_causa, key => 'N'),
                           array( campo => 'fecha_inicio',tipo => 'DATE',id => '10',add => 'S', edit => 'S', valor =>$fecha_causa, key => 'N'),
                           array( campo => 'fecha_cumplio',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor =>$fecha_causa, key => 'N'),
                           array( campo => 'archivo_cau',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$archivo_cau, key => 'N'),
                           array( campo => 'id_enlace',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor =>$enlace, key => 'N'),
                           array( campo => 'tipodocumento_cau',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor =>$tipodocumento_cau, key => 'N'),
                       );

                       

                       $datos_valida = $bd->query_array(
                               'tce.ad_causas_nov',
                               'count(*) as nn,max(id_causanov) id_causanov',
                               'actuacion='.$bd->sqlvalue_inyeccion(trim($tipo_actuacion),true) .' and 
                               fecha='.$bd->sqlvalue_inyeccion(trim($fecha_causa),true).' and 
                               id_causa='.$bd->sqlvalue_inyeccion(trim($id_causa),true)
                               );

                       $id_causanov = $datos_valida['id_causanov'];

                       if (  $datos_valida['id_causanov'] > 0 )    {
                           $bd->_UpdateSQL('tce.ad_causas_nov',$Tabla,$id_causanov);
                       }else{
                           $bd->_InsertSQL('tce.ad_causas_nov',$Tabla,'tce.ad_causas_nov_id_causanov_seq'); 
                       }


               }

       }


}
 
?>
 
  