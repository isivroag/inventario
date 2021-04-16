<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$furl = "";

$consulta = "SELECT furl FROM requisicion WHERE folio_req ='$id'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
    foreach ($data as $reg) {
        $furl = $reg['furl'];

    }
    print json_encode($furl, JSON_UNESCAPED_UNICODE);
}
else
{
    
    print json_encode($furl, JSON_UNESCAPED_UNICODE);
}

$conexion = NULL;
