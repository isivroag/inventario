<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$id_partida = (isset($_POST['id_partida'])) ? $_POST['id_partida'] : '';

$consulta = "SELECT * FROM w_subpartida WHERE id_partida='$id_partida' ORDER BY id_subpartida";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
?>