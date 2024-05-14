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

    $accion       = trim($_POST["accion"]);


    $citadas_tce = $_POST['citadas_tce'];

    $sentencia_pre      = trim($_POST['sentencia_pre']);
    $precedente_contra  = trim($_POST['precedente_contra']);
    $sentencia_pre1     = trim($_POST['sentencia_pre1']);
    $sentencias         = trim($_POST['sentencias']);
    $cita_concepto      = trim($_POST['cita_concepto']);
    $cambio_pre = trim($_POST['cambio_pre']);

    $acto_fin = trim($_POST['acto_fin']);
    $consagra_ju = trim($_POST['consagra_ju']);
    $argumento_accionante  = trim($_POST['argumento_accionante']);
    $argumento_accionado  = trim($_POST['argumento_accionado']);
    $decision_relevante  = trim($_POST['decision_relevante']);
    $impacto_mediatico  = trim($_POST['impacto_mediatico']);
    $ratio_deci  = trim($_POST['ratio_deci']);
    $palabra_clave  = trim($_POST['palabra_clave']);
    $comentarios  = trim($_POST['comentarios']);
    $link  = trim($_POST['link']);
    $link_aclara  = trim($_POST['link_aclara']);

    $fundador  = trim($_POST['fundador']);
    $confirmadora  = trim($_POST['confirmadora']);
    
    
    if (empty($fundador)){
        $fundador = '--';
    }

    if (empty($confirmadora)){
        $confirmadora = '--';
    }
 

    if (empty($citadas_tce)){
        $citadas_tce = 'No Existe';
    }
    
    if (empty($precedente_contra)){
        $precedente_contra = 'No Existe';
    }
    
    if (empty($sentencia_pre)){
        $sentencia_pre = 'No Existe';
    }
    
    if (empty($sentencia_pre1)){
        $sentencia_pre1 = 'No Existe';
    }
    
    if (empty($sentencias)){
        $sentencias = 'No Existe';
    }

    if (empty($cita_concepto)){
        $cita_concepto = '--';
    }
    if (empty($cambio_pre)){
        $cambio_pre = '--';
    }

    if (empty($link)){
        $link = 'http://';
    }
    if (empty($link_aclara)){
        $link_aclara = 'http://';
    }

    if (empty($palabra_clave)){
        $palabra_clave = 'Lista Catalogo';
    }



  if (  $accion == 'add'){

        if ($id_causa_ana > 0 ){

        }else{       
            $datos_valida = $bd->query_array(
                'tce.ad_causas_ana',
                'id_causa_ana',
                'id_causa='.$bd->sqlvalue_inyeccion(trim($id_causa),true) 
                );

                if ( $datos_valida['id_causa_ana'] > 0 ){
                        $id_causa_ana        =  $datos_valida['id_causa_ana'] ;
                        $accion              = 'editar';
                }
        }   
    }
       
  


/*
    $acto_fin = trim($_POST['acto_fin']);
    $consagra_ju = trim($_POST['consagra_ju']);
    $argumento_accionante  = trim($_POST['argumento_accionante']);
    $argumento_accionado  = trim($_POST['argumento_accionado']);
    $decision_relevante  = trim($_POST['decision_relevante']);
    $impacto_mediatico  = trim($_POST['impacto_mediatico']);
    $ratio_deci  = trim($_POST['ratio_deci']);
    $palabra_clave  = trim($_POST['palabra_clave']);
    $comentarios  = trim($_POST['comentarios']);
    $link  = trim($_POST['link']);
    $link_aclara  = trim($_POST['link_aclara']);

*/

 $Tabla = array(
            array( campo => 'id_causa_ana',tipo => 'NUMBER',id => '0',       add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_causa',tipo => 'NUMBER',id => '1',          add => 'S', edit => 'N', valor => $id_causa, key => 'N'),
            array( campo => 'tipo_causa_ana',tipo => 'VARCHAR2',id => '2',  add => 'S', edit => 'S', valor => $_POST['tipo_causa_ana'], key => 'N'),
            array( campo => 'categoria_ana',tipo => 'VARCHAR2',id => '3',   add => 'S', edit => 'S', valor => $_POST['categoria_ana'], key => 'N'),
            array( campo => 'juez_ana',tipo => 'VARCHAR2',id => '4',        add => 'S', edit => 'S', valor => $_POST['juez_ana'], key => 'N'),
            array( campo => 'resumen_ana',tipo => 'VARCHAR2',id => '5',     add => 'S', edit => 'S', valor => $_POST['resumen_ana'], key => 'N'),
            array( campo => 'extracto_ana',tipo => 'VARCHAR2',id => '6',    add => 'S', edit => 'S', valor => $_POST['extracto_ana'], key => 'N'),
            array( campo => 'argumento_vcon',tipo => 'VARCHAR2',id => '7',  add => 'S', edit => 'S', valor => $_POST['argumento_vcon'], key => 'N'),
            array( campo => 'argumento_vsal',tipo => 'VARCHAR2',id => '8',  add => 'S', edit => 'S', valor => $_POST['argumento_vsal'], key => 'N'),
            array( campo => 'criterio',tipo => 'VARCHAR2',id => '9',        add => 'S', edit => 'S', valor => $_POST['criterio'], key => 'N'),
            array( campo => 'sentencias',tipo => 'VARCHAR2',id => '10',     add => 'S', edit => 'S', valor => $sentencias, key => 'N'),
            array( campo => 'cambio_pre',tipo => 'VARCHAR2',id => '11',     add => 'S', edit => 'S', valor =>$cambio_pre, key => 'N'),
            array( campo => 'sentencia_pre',tipo => 'VARCHAR2',id => '12',      add => 'S', edit => 'S', valor =>$sentencia_pre, key => 'N'),
            array( campo => 'precedente_contra',tipo => 'VARCHAR2',id => '13',  add => 'S', edit => 'S', valor =>$precedente_contra, key => 'N'),
            array( campo => 'sentencia_pre1',tipo => 'VARCHAR2',id => '14',     add => 'S', edit => 'S', valor => $sentencia_pre1, key => 'N'),
            array( campo => 'acto_fin',tipo => 'VARCHAR2',id => '15',           add => 'S', edit => 'S', valor => $_POST['acto_fin'], key => 'N'),
            array( campo => 'consagra_ju',tipo => 'VARCHAR2',id => '16',        add => 'S', edit => 'S', valor =>$_POST['consagra_ju'], key => 'N'),
            array( campo => 'argumento_accionante',tipo => 'VARCHAR2',id => '17',   add => 'S', edit => 'S', valor => $_POST['argumento_accionante'], key => 'N'),
            array( campo => 'argumento_accionado',tipo => 'VARCHAR2',id => '18',    add => 'S', edit => 'S', valor =>$_POST['argumento_accionado'], key => 'N'),
            array( campo => 'citadas_tce',tipo => 'VARCHAR2',id => '19',            add => 'S', edit => 'S', valor => $citadas_tce, key => 'N'),
            array( campo => 'decision_relevante',tipo => 'VARCHAR2',id => '20',     add => 'S', edit => 'S', valor =>$_POST['decision_relevante'], key => 'N'),
            array( campo => 'impacto_mediatico',tipo => 'VARCHAR2',id => '21',      add => 'S', edit => 'S', valor =>$_POST['impacto_mediatico'], key => 'N'),
            array( campo => 'cita_concepto',tipo => 'VARCHAR2',id => '22',          add => 'S', edit => 'S', valor =>$cita_concepto, key => 'N'),
            array( campo => 'ratio_deci',tipo => 'VARCHAR2',id => '23',             add => 'S', edit => 'S', valor => $_POST['ratio_deci'], key => 'N'),
            array( campo => 'palabra_clave',tipo => 'VARCHAR2',id => '24',          add => 'S', edit => 'S', valor =>$palabra_clave, key => 'N'),
            array( campo => 'comentarios',tipo => 'VARCHAR2',id => '25',            add => 'S', edit => 'S', valor =>$_POST['comentarios'], key => 'N'),
            array( campo => 'link',tipo => 'VARCHAR2',id => '26',                   add => 'S', edit => 'S', valor =>$link, key => 'N'),
            array( campo => 'link_aclara',tipo => 'VARCHAR2',id => '27',            add => 'S', edit => 'S', valor =>$link_aclara, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '28',                 add => 'S', edit => 'S', valor =>$sesion, key => 'N'),
            array( campo => 'fecha_creacion',tipo => 'DATE',id => '29',             add => 'S', edit => 'S', valor =>  $hoy, key => 'N')   ,  
            array( campo => 'fundador',tipo => 'VARCHAR2',id => '30',               add => 'S', edit => 'S', valor => $fundador, key => 'N'),
            array( campo => 'confirmadora',tipo => 'VARCHAR2',id => '31',           add => 'S', edit => 'S', valor => $confirmadora, key => 'N'),
    );

 

 
    if (  $accion  == 'visor'){

 
        $qquery = array( 
                array( campo => 'id_causa',valor => $id_causa ,filtro => 'S', visor => 'N'),
                array( campo => 'id_causa_ana',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'tipo_causa_ana',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'categoria_ana',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'juez_ana',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'resumen_ana',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'extracto_ana',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'argumento_vcon',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'argumento_vsal',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'criterio',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'sentencias',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'cambio_pre',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'sentencia_pre',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'precedente_contra',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'sentencia_pre1',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'acto_fin',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'consagra_ju',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'argumento_accionante',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'argumento_accionado',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'citadas_tce',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'decision_relevante',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'impacto_mediatico',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'cita_concepto',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'ratio_deci',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'palabra_clave',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'comentarios',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'link',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'link_aclara',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'fundador',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'confirmadora',valor => '-',filtro => 'N', visor => 'S')
                );
           
              

             $datos =  $bd->JqueryArrayVisorObj('tce.ad_causas_ana',$qquery,0 );

             $id_causa_ana = $datos['id_causa_ana'];

             $result_Doc = '<b> INFORMACION REFERENCIA '.$id_causa.'/'.$id_causa_ana.'</b>';


    }elseif( $accion  == 'editar' ) {

          $result_Doc = 'Datos actualizados '.$id_causa_ana;
          $bd->_UpdateSQL('tce.ad_causas_ana',$Tabla,$id_causa_ana);
 
          $result_Doc = '<b> DATOS ACTUALIZADOS REFERENCIA '.$id_causa.'/'.$id_causa_ana.'</b>';

     }elseif( $accion  == 'eliminar' ) {
        
        $result_Doc = 'Datos actualizados '.$id_causa_ana;
        
        $sql       = "DELETE
                        FROM tce.ad_causas_ana
                        WHERE id_causa_ana = ".$bd->sqlvalue_inyeccion( $id_causanov, true) ;
        
        
        $bd->ejecutar($sql);
         
    }elseif( $accion  == 'add' ) {

            $result_Doc = ' <b> DATOS AGREGADOS CORRECTAMENTE</b>';
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
 
  