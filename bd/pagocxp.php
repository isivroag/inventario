<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio_cxp = (isset($_POST['folio_cxp'])) ? $_POST['folio_cxp'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$nota = (isset($_POST['nota'])) ? $_POST['nota'] : '';
$id_cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';
$monto = (isset($_POST['monto'])) ? $_POST['monto'] : '';
$saldofin= (isset($_POST['saldofin'])) ? $_POST['saldofin'] : '';
$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$consulta = "INSERT INTO w_pagocxp (folio_cxp,fecha,id_cuenta,nota,monto,saldo_ini,saldo_fin,metodo,usuario) VALUES ('$folio_cxp','$fecha','$id_cuenta','$nota','$monto','$saldo','$saldofin','$metodo','$usuario')";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    $res=1;
}
else{
    $res=0;
}




print json_encode($res, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>