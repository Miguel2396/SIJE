<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

     
 
    $bd	   =	new Db ;
    $obj     = 	new objects;
    
 
    $sesion 	 =  trim($_SESSION['email']);
   
    $hoy 	     =     date("Y-m-d"); 
    
 
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    
    $id_causa            =  $_POST['id_causa'] ;
    $id_causa_ana        =  $_POST['id_causa_ana'] ;

    $accion                      = trim($_POST["accion"]);
    $resumen_ana1                = trim($_POST['resumen_ana']);
    $extracto_ana1               = trim($_POST['extracto_ana']);
    $argumento_accionante1       = trim($_POST['argumento_accionante']);
    $argumento_accionado1        = trim($_POST['argumento_accionado']);
    $ratio_deci1                 = trim($_POST['ratio_deci']); 
 
  
    
    

    $datos = $bd->query_array('tce.ad_causas','tipo_causa,categoria,juez',
             'id_causa='.$bd->sqlvalue_inyeccion($id_causa,true) 
    );

    if (   $id_causa_ana > 0 ){

    }else{
         $tipo_causa_ana = trim($datos['tipo_causa']);
         $categoria      = trim($datos['categoria']);
         $juez_ana       = trim($datos['juez']);
         $argumento_vcon       = 'Actualizar';
         $argumento_vsal       = 'Actualizar';
         $criterio       = 'Actualizar';
         $sentencias       = 'Actualizar';
         $cambio_pre       = 'Actualizar';
         $sentencia_pre       = 'Actualizar';
         $precedente_contra       = 'Actualizar';
         $sentencia_pre1       = 'Actualizar';
         $acto_fin       = '--';
         $consagra_ju       = '--';
         $citadas_tce       = '--';
         $decision_relevante       = '--';
         $impacto_mediatico       = 'N';
         $cita_concepto       = '--';
         $ratio_deci       = '--';
         $palabra_clave       = '--';
         $comentarios       = '--';
         $argumento_accionante  = '--';
         $resumen_ana  = '--';
         $extracto_ana  = '--';
         $argumento_accionado  = '--';
         $link  = '--';
         $link_aclara  = '--';

    }

  

 $Tabla = array(
            array( campo => 'id_causa_ana',tipo => 'NUMBER',id => '0',              add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_causa',tipo => 'NUMBER',id => '1',                  add => 'S', edit => 'N', valor => $id_causa, key => 'N'),
            array( campo => 'tipo_causa_ana',tipo => 'VARCHAR2',id => '2',          add => 'S', edit => 'N', valor => $tipo_causa_ana, key => 'N'),
            array( campo => 'categoria_ana',tipo => 'VARCHAR2',id => '3',           add => 'S', edit => 'N', valor => $categoria_ana, key => 'N'),
            array( campo => 'juez_ana',tipo => 'VARCHAR2',id => '4',                add => 'S', edit => 'N', valor => $juez_ana, key => 'N'),
            array( campo => 'resumen_ana',tipo => 'VARCHAR2',id => '5',             add => 'S', edit => 'N', valor => $resumen_ana, key => 'N'),
            array( campo => 'extracto_ana',tipo => 'VARCHAR2',id => '6',            add => 'S', edit => 'N', valor => $extracto_ana, key => 'N'),
            array( campo => 'argumento_vcon',tipo => 'VARCHAR2',id => '7',          add => 'S', edit => 'N', valor => $argumento_vcon  , key => 'N'),
            array( campo => 'argumento_vsal',tipo => 'VARCHAR2',id => '8',          add => 'S', edit => 'N', valor => $argumento_vsal, key => 'N'),
            array( campo => 'criterio',tipo => 'VARCHAR2',id => '9',                add => 'S', edit => 'N', valor => $criterio, key => 'N'),
            array( campo => 'sentencias',tipo => 'VARCHAR2',id => '10',             add => 'S', edit => 'N', valor => $sentencias, key => 'N'),
            array( campo => 'cambio_pre',tipo => 'VARCHAR2',id => '11',             add => 'S', edit => 'N', valor =>$cambio_pre, key => 'N'),
            array( campo => 'sentencia_pre',tipo => 'VARCHAR2',id => '12',          add => 'S', edit => 'N', valor =>$sentencia_pre , key => 'N'),
            array( campo => 'precedente_contra',tipo => 'VARCHAR2',id => '13',      add => 'S', edit => 'N', valor =>$precedente_contra, key => 'N'),
            array( campo => 'sentencia_pre1',tipo => 'VARCHAR2',id => '14',         add => 'S', edit => 'N', valor => $sentencia_pre1, key => 'N'),
            array( campo => 'acto_fin',tipo => 'VARCHAR2',id => '15',               add => 'S', edit => 'N', valor => $acto_fin, key => 'N'),
            array( campo => 'consagra_ju',tipo => 'VARCHAR2',id => '16',            add => 'S', edit => 'N', valor =>$consagra_ju, key => 'N'),
            array( campo => 'argumento_accionante',tipo => 'VARCHAR2',id => '17',   add => 'S', edit => 'N', valor => $argumento_accionante, key => 'N'),
            array( campo => 'argumento_accionado',tipo => 'VARCHAR2',id => '18',    add => 'S', edit => 'N', valor =>$argumento_accionado, key => 'N'),
            array( campo => 'citadas_tce',tipo => 'VARCHAR2',id => '19',            add => 'S', edit => 'N', valor => $citadas_tce, key => 'N'),
            array( campo => 'decision_relevante',tipo => 'VARCHAR2',id => '20',     add => 'S', edit => 'N', valor =>$decision_relevante, key => 'N'),
            array( campo => 'impacto_mediatico',tipo => 'VARCHAR2',id => '21',      add => 'S', edit => 'N', valor =>$impacto_mediatico, key => 'N'),
            array( campo => 'cita_concepto',tipo => 'VARCHAR2',id => '22',          add => 'S', edit => 'N', valor =>$cita_concepto, key => 'N'),
            array( campo => 'ratio_deci',tipo => 'VARCHAR2',id => '23',             add => 'S', edit => 'N', valor => $ratio_deci, key => 'N'),
            array( campo => 'palabra_clave',tipo => 'VARCHAR2',id => '24',          add => 'S', edit => 'N', valor => $palabra_clave, key => 'N'),
            array( campo => 'comentarios',tipo => 'VARCHAR2',id => '25',            add => 'S', edit => 'N', valor =>$comentarios, key => 'N'),
            array( campo => 'link',tipo => 'VARCHAR2',id => '26',                   add => 'S', edit => 'N', valor =>$link, key => 'N'),
            array( campo => 'link_aclara',tipo => 'VARCHAR2',id => '27',            add => 'S', edit => 'N', valor =>$link_aclara, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '28',                 add => 'S', edit => 'S', valor =>$sesion, key => 'N'),
            array( campo => 'fecha_creacion',tipo => 'DATE',id => '29',             add => 'S', edit => 'S', valor =>  $hoy, key => 'N')  ,   
            array( campo => 'resumen_ana1',tipo => 'VARCHAR2',id => '30',           add => 'S', edit => 'S', valor =>$resumen_ana1, key => 'N'),
            array( campo => 'extracto_ana1',tipo => 'VARCHAR2',id => '31',          add => 'S', edit => 'S', valor =>$extracto_ana1, key => 'N'),
            array( campo => 'argumento_accionante1',tipo => 'VARCHAR2',id => '32',  add => 'S', edit => 'S', valor =>$argumento_accionante1, key => 'N'),
            array( campo => 'argumento_accionado1',tipo => 'VARCHAR2',id => '33',   add => 'S', edit => 'S', valor =>$argumento_accionado1, key => 'N'),
            array( campo => 'ratio_deci1',tipo => 'VARCHAR2',id => '34',            add => 'S', edit => 'S', valor =>$ratio_deci1, key => 'N'),
    );

 
 
    if (  $accion  == 'visor'){
 
        $qquery = array( 
                 array( campo => 'id_causa',valor => $id_causa ,filtro => 'S', visor => 'N'),
                 array( campo => 'id_causa_ana',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'resumen_ana1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'extracto_ana1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'argumento_accionante1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'argumento_accionado1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'ratio_deci1',valor => '-',filtro => 'N', visor => 'S'),
                 );

             $bd->JqueryArrayVisorObj('tce.ad_causas_ana',$qquery,0 );

             $result_Doc = 'VARIFIQUE LA INFORMACION '.$id_causa_ana;


    }elseif( $accion  == 'editar' ) {

          $result_Doc = '<b> DATOS ACTUALIZADOS REFERENCIA '.$id_causa.'/'.$id_causa_ana.'</b>';
          $bd->_UpdateSQL('tce.ad_causas_ana',$Tabla,$id_causa_ana);
 

     }elseif( $accion  == 'eliminar' ) {
        
        $result_Doc = 'Datos actualizados '.$id_causa_ana;
        
        $sql       = "DELETE
                        FROM tce.ad_causas_ana
                        WHERE id_causa_ana = ".$bd->sqlvalue_inyeccion( $id_causanov, true) ;
        
        
        // $bd->ejecutar($sql);
         
    }elseif( $accion  == 'add' ) {
            $result_Doc = ' <b> DATOS ACTUALIZADOS CORRECTAMENTE</b>';
            $bd->_InsertSQL('tce.ad_causas_ana',$Tabla,'tce.ad_causas_ana_id_causa_ana_seq'); 
      
        }
     elseif( $accion  == 'anio_causa' ) {

                $anio            =  $_POST['anio'] ;
                $causa_var        =  $_POST['causa_var'] ;
            
                $tipo = $bd->retorna_tipo();

                $sql = "select causa,  categoria, novedad ,accionante ||' '|| accionado as actores
                from tce.view_causa
                where anio = ".$bd->sqlvalue_inyeccion($anio, true).    
                 " order by causa asc";
 

                $resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO

                while ($fetch = $bd->obtener_fila($resultado)){
 
              		
              		$output[] = array (
              				trim($fetch['causa']),
                              $fetch['categoria'],
              				' <b>'.$fetch['novedad'].'</b>',
               				$fetch['actores'] 
              		);
               	}
              	
              	      	echo json_encode($output);
      
        }   
    
               
    
    
    
    echo $result_Doc;
 
?>
 
  