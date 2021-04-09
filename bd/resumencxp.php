<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$consulta = "SELECT * FROM w_resumencxp ORDER BY folio_cxp";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
