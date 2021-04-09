<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id_alumno = (isset($_POST['id_alumno'])) ? $_POST['id_alumno'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';


$consulta = "INSERT INTO w_promocion (id_alumno,fecha) VALUES ('$id_alumno','$fecha')";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$resp=1;


print json_encode($resp, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
