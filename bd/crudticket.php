<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$fin = (isset($_POST['fin'])) ? $_POST['fin'] : '';
$cliente = (isset($_POST['cliente'])) ? $_POST['cliente'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
date_default_timezone_set('America/Mexico_City');
$fechacan=date("Y-m-d H:i:s");

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO ticket (cliente_ti,apertura_ti,clausura_ti,usuario_ti,descripcion_ti,costo_ti) VALUES('$cliente','$inicio','$fin','$usuario','$descripcion','$costo')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM ticket ORDER BY folio_ti DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE ticket SET cliente_ti='$cliente',descripcion_ti='$descripcion',costo_ti='$costo',estado_ti='$estado' WHERE folio_ti='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    

        $consulta = "SELECT * FROM ticket WHERE folio_ti ='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE ticket SET estado_ti=0,fecha_can='$fecha',usuario_can='$usuario' WHERE folio_ti='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=1;                 
        break;    
    case 4:
        $consulta = "UPDATE ticket SET estado_ti='2',clausura_ti='$fecha' WHERE folio_ti='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    

        $consulta = "SELECT * FROM ticket WHERE folio_ti ='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
    case 5:
        $consulta = "SELECT folio_ti,cliente_ti,apertura_ti,clausura_ti,descripcion_ti,costo_ti,estado_ti FROM ticket WHERE estado_ti<>0 ORDER BY folio_ti";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
    break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
