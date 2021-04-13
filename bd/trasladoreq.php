<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = "";
$usuario = "";
$solicitante = "";
$fecha = "";
$fraccionamiento = "";
$obs = "";




$consulta = "SELECT * FROM tmp_req WHERE folio_req='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($dt as $row) {
    $tokenid = $row['tokenid'];
    $solicitante = $row['solicitante'];
    $fecha = $row['fecha_req'];
    $fraccionamiento = $row['fraccionamiento'];
    $obs = $row['obs_req'];
    $usuario=$row['usuario'];

}

$consulta = "UPDATE tmp_req SET estado_req=2 WHERE folio_req='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "INSERT INTO requisicion (solicitante,fecha_req,fraccionamiento,obs_req,usuario,folio_tmp) VALUES('$solicitante','$fecha','$fraccionamiento','$obs','$usuario','$folio')";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * FROM requisicion ORDER BY folio_req DESC LIMIT 1";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $rw) {
    $folioreq = $rw['folio_req'];
}



$consulta = "SELECT * FROM detalle_tmp WHERE folio_req='$folio'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dt = $resultado->fetchAll(PDO::FETCH_ASSOC);


foreach ($dt as $row) {

    $id_prod = $row['id_prod'];
    $nom_prod = $row['nom_prod'];
    $cantidad = $row['cantidad'];
    $umedida = $row['umedida'];
    

    $consultain = "INSERT INTO detalle_req (folio_req,id_prod,nom_prod,cantidad,umedida) VALUES ('$folioreq','$id_prod','$nom_prod','$cantidad','$umedida')";
    $resultadoin = $conexion->prepare($consultain);
    $resultadoin->execute();
}




print json_encode($folioreq, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
