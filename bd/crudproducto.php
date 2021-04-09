<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$umedida = (isset($_POST['umedida'])) ? $_POST['umedida'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO producto (clave_prod,nom_prod,umedida,precio_prod) VALUES('$clave','$nombre','$umedida','$precio') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM producto ORDER BY id_prod DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE producto SET nom_prod='$nombre',clave_prod='$clave',umedida='$umedida',precio_prod='$precio' WHERE id_prod='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM producto WHERE id_prod='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE producto SET estado_prod=0 WHERE id_prod='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
