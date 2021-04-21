<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = date("Y-m-d");
$entregado = 0;
$consulta = "SELECT * from detalle_req WHERE folio_req='$folio'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        $idprod = $row['id_prod'];
        $cantidad = $row['cantidad'];

        $consultainv = "SELECT * FROM producto WHERE id_prod='$idprod'";
        $resultadoinv = $conexion->prepare($consultainv);
        if ($resultadoinv->execute()) {
            $datap = $resultadoinv->fetchAll(PDO::FETCH_ASSOC);

            $inicial = 0;
            foreach ($datap as $rowp) {
                $inicial = $rowp['cant_prod'];
            }

            $final = $inicial - $cantidad;
            $nota = "Requisicion de Material #" . $folio;

            $consultamov = "INSERT INTO mov_prod(id_prod,fecha_movp,descripcion,tipo_movp,saldoini,cantidad,saldofin,folio_req) VALUES('$idprod','$fecha','$nota','Salida','$inicial','$cantidad','$final','$folio')";
            $resultadomov = $conexion->prepare($consultamov);

            if ($resultadomov->execute()) {
                $consultamov = "UPDATE producto SET cant_prod='$final' WHERE id_prod='$idprod'";
                $resultadomov = $conexion->prepare($consultamov);
                if ($resultadomov->execute()) {
                    $res = 0;
                    $consultamov = "UPDATE requisicion SET entregado = 1 WHERE folio_req='$folio'";
                    $resultadomov = $conexion->prepare($consultamov);
                    if ($resultadomov->execute()) {
                        $entregado = 1;
                    } else {
                        $entregado = 0;
                    }
                }
            }




            // buscar el folio del mov
            /*$consultamov="SELECT id_movp from mov_prod where folio_req='$folio' order by id_movp desc limit 1";
            $resultadomov = $conexion->prepare($consultamov);
            if ($resultadomov->execute()){
                $datamov= $resultadomov->fetchAll(PDO::FETCH_ASSOC);
                foreach($datamov as $rowmov){
                    $idmov=$rowmov['id_movp'];
                }
            }*/
            //termina buscar el folio del mov


        }
    }
}





print json_encode($entregado, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
