<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_objetivo = (isset($_POST['id_objetivo'])) ? $_POST['id_objetivo'] : '';
$objetivo = (isset($_POST['objetivo'])) ? $_POST['objetivo'] : '';
$opc = (isset($_POST['opc'])) ? $_POST['opc'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';


switch ($opc) {
    case 1: //alta
        $consulta = "INSERT INTO evalobjreg (folio,id_objetivo,descripcion) VALUES ('$folio','$id_objetivo','$objetivo')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM evalobjreg WHERE folio='$folio' ORDER BY registro DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        

        break;
        case 2:
            $consulta = "DELETE FROM evalobjreg WHERE registro='$id' ";		
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            /*CAMBIO IVA INCLUIDO EN TODOS LOS PRECIOS */
            
            $data=1;
   
        
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
