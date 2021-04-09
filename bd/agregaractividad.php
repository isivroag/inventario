<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$actividad = (isset($_POST['actividad'])) ? $_POST['actividad'] : '';

$opc = (isset($_POST['opc'])) ? $_POST['opc'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';


switch ($opc) {
    case 1: //alta
        $consulta = "INSERT INTO evalactreg (folio,actividad) VALUES ('$folio','$actividad')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM evalactreg WHERE folio='$folio' ORDER BY reg_act DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        

        break;
        case 2:
            $consulta = "DELETE FROM evalactreg WHERE reg_act='$id' ";		
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            /*CAMBIO IVA INCLUIDO EN TODOS LOS PRECIOS */
            
            $data=1;
   
        
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
