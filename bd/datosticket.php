<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();



$consulta = "SELECT folio_ti,cliente_ti,apertura_ti,clausura_ti,descripcion_ti,costo_ti,estado_ti FROM ticket WHERE estado_ti<>0 ORDER BY folio_ti";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
