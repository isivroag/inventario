<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';





$consulta = "UPDATE evalregistro SET fecha='$fecha',estado='1' WHERE folio='$folio'";

$resultado = $conexion->prepare($consulta);

    $resultado->execute();
    $data=1;







print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
