<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id_alumno = (isset($_POST['id_alumno'])) ? $_POST['id_alumno'] : '';
$id_nivel = (isset($_POST['id_nivel'])) ? $_POST['id_nivel'] : '';
$id_etapa = (isset($_POST['id_etapa'])) ? $_POST['id_etapa'] : '';
$id_reg = (isset($_POST['id_reg'])) ? $_POST['id_reg'] : '';
$id_objetivo = (isset($_POST['id_objetivo'])) ? $_POST['id_objetivo'] : '';



$consulta = "UPDATE evalgeneral SET valor='0',activo='1' WHERE id_alumno='$id_alumno' and id_nivel='$id_nivel' and id_etapa='$id_etapa' and id_objetivo='$id_objetivo'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "UPDATE w_promocion SET estado_prom='0' WHERE id_reg='$id_reg'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    

$data=1;


    







print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
