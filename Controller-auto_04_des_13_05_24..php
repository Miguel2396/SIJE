<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj     = 	new objects;
$bd	   =	new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $id            		= $_GET['id'];
    
    $ViewFormTareaUs	= '<div class="list-group">';
    
    $sql = "select *
              from tce.ad_causas
             where id_causa = ".$bd->sqlvalue_inyeccion($id,true)."  
             order by id_causa";
 
    $stmt_nivel1= $bd->ejecutar($sql);
    
    /*
    , fecha, fecha_sorteo, fecha_actuacion,
    accionante, accionado, tipo_causa, origen, actuacion,    novedad,  fecha_modifica , 
    */
 
    while ($x=$bd->obtener_fila($stmt_nivel1)){
    	
        $detalle = '<b>No.Caso: '. trim($x['causa']).'  </b><br>Tipo Causa: '.trim($x['tipo_causa']) .' <br>Origen: '.trim($x['origen']).' <br>Proceso: '.trim($x['actuacion']).' <br>';
        $detalle .= trim($x['accionante']).' / '.trim($x['accionado']).'<br>';
        $detalle .= 'Descripcion/Novedad: '.trim($x['novedad']).'<br>';
        
        $ViewFormTareaUs .= '<a href="#" class="list-group-item"><h4 class="list-group-item-heading">'. $detalle.'</h4></a>';
   
        echo '<script>$("#causa_var").val("'.$x['tipo_causa'].'")</script>';
    }
    



     
 
    $ViewFormTareaUs .= '</div> 
             <button type="button" class="btn btn-success" title="Visualizar historial de registro de causas"  onclick="ver_datos('.$id.')"  data-toggle="modal" data-target="#myModalProducto">Resumen Causa</button>

             <button type="button" title="Registra el seguimiento de la causa seleccionada" class="btn btn-info" onclick="LimpiarSeg()" data-toggle="modal" data-target="#VentanaProcesoSeg">Seguimiento</button>

             <button type="button" class="btn btn-danger"  title="Actualizacion de informacion de analisis de causas"  onclick="LimpiarNovedad()" data-toggle="modal" data-target="#VentanaProceso">Extracto Sentencia</button>

             <button type="button" id="button39" class="btn btn-warning" "="" onclick="EnvieNotificacion()" title="Notificar Tramite por Correo Electronico">
                                                <i class="glyphicon glyphicon-envelope"></i>  
                                    </button>

             <button type="button" class="btn btn-default" onclick="ImpresionCausa()" >Resumen Causa</button>

 
            <div class="col-md-12" style="padding: 7px">'; 
    
    echo $ViewFormTareaUs ;
    
    unidades_tarea($bd,$id,$id,$obj);
    
    
    echo '</div> ';
   
  //-----------------------------------------------
  
    function unidades_tarea($bd,$id,$idtarea,$obj){
        
         
        $sql = " SELECT *
                FROM tce.view_causad
                where id_causa = ".$bd->sqlvalue_inyeccion($idtarea,true).' order by fecha asc' ;
 
        $resultado  = $bd->ejecutar($sql);  
            
        
        $tabla_cabecera =  '<table width="100%"  border="0" cellspacing="0" cellpadding="0"> ';
        
        $numero2         = 1;
        
        
        echo $tabla_cabecera;
        
        echo '<tr>
            <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Nro.</td>
            <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha</td>
            <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Proceso</td>
            <td class="derecha" width="40%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Accion Ejecutada</td>
            <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Alerta</td>
            <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Acción</td></tr>';
                
        
        while ($x=$bd->obtener_fila($resultado)){
            
 
            
            $fecha = $bd->_fecha_dia($x['fecha']);
            
            $actuacion   = trim($x['actuacion']);
            
           // $comentario    = trim($x['comentario']);
            $observacion   = trim($x['observacion']);
            
              
            if ($x['cumplio'] == 'N'){
                $imagen = ' <img src="../../kimages/m_rojo.png" align="absmiddle" >';
                $dias =  trim($x['dias_alerta']);
                
                if ( $dias < 0 ){
                    if ( abs($dias) > 3 ){
                        $dias = ' <span style="color: #0509B6"> '.abs($dias).' </span>';
                    }else{
                        $dias = ' <span style="color: #0509B6"> <b>'.abs($dias).' </b></span>';
                    }
                  
                }else {
                    $dias = ' <span style="color: #FC0004"> '.$dias.' </span>';
                }
               
 
            }else{
                $imagen = ' <img src="../../kimages/m_verde.png" align="absmiddle" >';
                $dias =  trim($x['dias_cumplio']);
            }
            
             
            $fecha_recepcion =  trim($x['fecha_alerta']);

            $causa =  trim($x['causa']);
            
            $fecha_recepcion = $bd->_fecha_dia($x['fecha_alerta']);
            
            
            $id_causanov     =  $x['id_causanov'];
            
 
            $clic2 = ' ';
            $evento3 ='';

            if (  $causa  == 'DESPACHOS'){
                $clic2 = ' onclick="goeliminar('.$id_causanov.')" ';
                $evento3 = '<a href="#" '.$clic2.' class="btn btn-danger btn-xs" role="button"><i class="glyphicon glyphicon-trash"></i></a>';
            }
            
            
           
            $archivo_cau =  trim($x['archivo_cau']);

            if ( empty( $archivo_cau)){
                $actuacion = $actuacion;
            }else{
                $actuacion =  '<a title= "VISUALIZAR ARCHIVO DE SENTENCIA/NOTIFICACION" href="'. $archivo_cau.'" target="_blank"><b>'.$actuacion.'</b></a>';
            }
            
          
             
             
            echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero2.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$fecha.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$imagen.' '.$actuacion.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'. $observacion.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$fecha_recepcion.'</td>
                <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$evento3.'</td>
             </tr>';
            
            $numero2 ++;
        }
        
        
        
        echo '</table>';
    
    }  
    
?>
