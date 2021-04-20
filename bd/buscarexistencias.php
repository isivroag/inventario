<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id = (isset($_POST['idprod'])) ? $_POST['idprod'] : '';

$cantidad = 0;

$consulta = "SELECT cant_prod FROM producto WHERE id_prod ='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($data as $reg) {
        $cantidad = $reg['cant_prod'];

    }
    print json_encode($cantidad, JSON_UNESCAPED_UNICODE);
}
else
{
    
    print json_encode($cantidad, JSON_UNESCAPED_UNICODE);
}

$conexion = NULL;
