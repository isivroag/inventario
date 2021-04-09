<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id_alumno = (isset($_POST['id_alumno'])) ? $_POST['id_alumno'] : '';
$id_nivel = (isset($_POST['id_nivel'])) ? $_POST['id_nivel'] : '';
$id_etapa = (isset($_POST['id_etapa'])) ? $_POST['id_etapa'] : '';
$id_objetivo = (isset($_POST['id_objetivo'])) ? $_POST['id_objetivo'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';


$consulta = "UPDATE evalgeneral SET valor='1',activo='0',logro='$fecha' WHERE id_alumno='$id_alumno' and id_nivel='$id_nivel' and id_etapa='$id_etapa' and id_objetivo='$id_objetivo'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * FROM evalgeneral WHERE id_alumno='$id_alumno' and id_nivel='$id_nivel' and id_etapa='$id_etapa' and activo='1'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado->rowCount()>0){
    /*Todavia hay objetivos activos de esta etapa */
    $data=1;
}else{
    $data=2;
}

    







print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
