<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$id_nivel = (isset($_POST['id_nivel'])) ? $_POST['id_nivel'] : '';
$id_etapa = (isset($_POST['id_etapa'])) ? $_POST['id_etapa'] : '';




$consulta = "SELECT * FROM evalgeneral where id_alumno='" . $id . "' and id_nivel='" . $id_nivel . "' and id_etapa='" . $id_etapa . "'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>