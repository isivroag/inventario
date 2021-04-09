<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$id_alumno = (isset($_POST['id_alumno'])) ? $_POST['id_alumno'] : '';
$id_nivel = (isset($_POST['id_nivel'])) ? $_POST['id_nivel'] : '';
$id_etapa = (isset($_POST['id_etapa'])) ? $_POST['id_etapa'] : '';
$id_objetivo = (isset($_POST['id_objetivo'])) ? $_POST['id_objetivo'] : '';
$id_reg = (isset($_POST['id_reg'])) ? $_POST['id_reg'] : '';

$resp=0;


/* Buscar los datos del ultimo objetivo logrado */
$consulta = "SELECT * FROM evalgeneral WHERE id_alumno='$id_alumno' and id_nivel='$id_nivel' and id_etapa='$id_etapa' and id_objetivo='$id_objetivo'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $reg) {
    $nivel = $reg['id_nivel'];
    $etapa = $reg['id_etapa'];
    $resp+=1;
}
/* Obtener los datos del agrupador y el numerador del objetivo para mantenerme en el mismo nivel*/
$consulta = "SELECT * FROM objetivo where id_nivel='$nivel' and id_etapa='$etapa' and id_objetivo='$id_objetivo'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $reg) {
    $numerador = $reg['numerador'];
    $agrupador = $reg['agrupador'];
    $resp+=1;
}
/* incrementar el objetivo */
$numerador+= 1;

/* buscar el nuevo nivel y etapa */
$consulta = "SELECT * FROM objetivo where agrupador='$agrupador' and numerador='$numerador'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() > 0) {
    $resp+=1;

    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $reg) {
        $snivel = $reg['id_nivel'];
        $setapa = $reg['id_etapa'];
    }
    /* Actualizar el nivel y la etapa*/
    $consulta = "UPDATE datoseval SET id_nivel='$snivel',id_etapa='$setapa' WHERE id_alumno='$id_alumno'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    /*Actualizar los objetivos */
    $consulta = "UPDATE evalgeneral SET activo='1' WHERE id_alumno='$id_alumno' and id_etapa='$setapa' and id_nivel='$snivel'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $resp += 1;

    $consulta = "UPDATE w_promocion SET estado_prom='0' WHERE id_reg='$id_reg'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $resp += 1;


} else {
    /* Data 0 significa que ya termino el programa completo */
    $resp = 0;
}

print json_encode($resp, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;











