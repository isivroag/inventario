<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$solicitante = (isset($_POST['solicitante'])) ? $_POST['solicitante'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fraccionamiento = (isset($_POST['fraccionamiento'])) ? $_POST['fraccionamiento'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';

$res=0;
$consulta = "UPDATE tmp_req SET solicitante='$solicitante',fecha_req='$fecha',fraccionamiento='$fraccionamiento',obs_req='$obs' WHERE folio_req='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $res = 1;
} else {
    $res = 0;
}






print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
