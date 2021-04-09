<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
date_default_timezone_set('America/Mexico_City');
$fechacan=date("Y-m-d H:i:s");

        $consulta = "UPDATE ticket SET estado_ti='$estado',clausura_ti='$fechacan' WHERE folio_ti='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    

        $consulta = "SELECT * FROM ticket WHERE folio_ti ='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
