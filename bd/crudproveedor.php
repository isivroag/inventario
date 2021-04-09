<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$calle = (isset($_POST['calle'])) ? $_POST['calle'] : '';
$col = (isset($_POST['col'])) ? $_POST['col'] : '';
$num = (isset($_POST['num'])) ? $_POST['num'] : '';
$cp = (isset($_POST['cp'])) ? $_POST['cp'] : '';
$cd = (isset($_POST['cd'])) ? $_POST['cd'] : '';
$edo = (isset($_POST['edo'])) ? $_POST['edo'] : '';
$tel = (isset($_POST['tel'])) ? $_POST['tel'] : '';
$cel = (isset($_POST['cel'])) ? $_POST['cel'] : '';
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$nombre = $nombre;
$calle = $calle;
$col = $col;
$cd = $cd;
$edo = $edo;



$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_proveedor (rfc,nombre,correo, calle, col, num, cp,cd,edo,tel,cel) VALUES('$rfc','$nombre','$correo', '$calle', '$col','$num','$cp','$cd','$edo','$tel','$cel') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id_prov, nombre,rfc,correo,calle,col,num,cp,cd,edo,tel,cel FROM w_proveedor ORDER BY id_prov DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE w_proveedor SET rfc='$rfc',nombre='$nombre',correo='$correo', calle='$calle', col='$col', num='$num', cp='$cp', cd='$cd', edo='$edo', tel='$tel', cel='$cel' WHERE id_prov='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id_prov, nombre,rfc,correo,calle,col,num,cp,cd,edo,tel,cel FROM w_proveedor WHERE id_prov='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM w_proveedor WHERE id_prov='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
