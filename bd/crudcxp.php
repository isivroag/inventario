<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fecha_limite = (isset($_POST['fechal'])) ? $_POST['fechal'] : '';

$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$id_partida = (isset($_POST['id_partida'])) ? $_POST['id_partida'] : '';
$id_subpartida = (isset($_POST['id_subpartida'])) ? $_POST['id_subpartida'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$facturado = (isset($_POST['facturado'])) ? $_POST['facturado'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';




$data = 0;

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO w_cxp (fecha,fecha_limite,id_prov,id_partida,id_subpartida,concepto,facturado,referencia,subtotal,iva,total,saldo,usuario) VALUES ('$fecha','$fecha_limite','$id_prov','$id_partida','$id_subpartida','$concepto',$facturado,'$referencia','$subtotal','$iva','$total','$saldo','$usuario')";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = 1;
        } else {
            $data = 0;
        }


        break;
    case 2:
        $consulta = "UPDATE w_cxp SET fecha='$fecha',fecha_limite='$fecha_limite',id_prov='$id_prov',id_partida='$id_partida',id_subpartida='$id_subpartida',concepto='$concepto',facturado='$facturado',referencia='$referencia',subtotal='$subtotal',iva='$iva',total='$total',saldo='$total',usuario='$usuario' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
       
        if ($resultado->execute()) {
            $data = 1;
        } else {
            $data = 0;
        }


        break;
    case 3:
        $consulta = "UPDATE w_cxp SET estado_cxp='0' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
       
        if ($resultado->execute()) {
            $data = 1;
        } else {
            $data = 0;
        }
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
