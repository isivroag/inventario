<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_concepto = (isset($_POST['idprod'])) ? $_POST['idprod'] : '';
$nom_prod = (isset($_POST['nomprod'])) ? $_POST['nomprod'] : '';
$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detalle_tmp (folio_req,id_prod,nom_prod,umedida,cantidad) VALUES ('$folio','$id_concepto','$nom_prod','$umedida','$cantidad')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM detalle_tmp WHERE folio_req='$folio' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        

        break;
        case 2:
            $consulta = "DELETE FROM detalle_tmp WHERE id_reg='$id' ";		
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data=1;
    
        
    
        
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
