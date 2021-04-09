<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$tarea = (isset($_POST['tarea'])) ? $_POST['tarea'] : '';
$tareadesc = (isset($_POST['tareadesc'])) ? $_POST['tareadesc'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

date_default_timezone_set('America/Mexico_City');
$fechaact = date("Y-m-d H:i:s");

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO tarea (folio_ti,nombre_ta,desc_ta,fecha_ta) VALUES('$folio','$tarea','$tareadesc','$fechaact')";
        $resultado = $conexion->prepare($consulta);

        if ($resultado->execute()) {
            $data = 1;
        }

        break;
    case 2: //modificación
        $consulta = "UPDATE w_partida SET nom_partida='$nombre' WHERE id_partida='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT id_partida,nom_partida FROM w_partida WHERE id_partida='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "DELETE FROM w_partida WHERE id_partida='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = 1;
        break;
    case 5:
        $consulta = "SELECT * FROM tarea WHERE folio_ti='$folio' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
