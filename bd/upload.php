<?php

$folioreq=$_POST['folioreq'];
$fecha=date("YmdHis");
$nombre=$_FILES['file']['name'];
$extencion =explode(".", $nombre);
$extencion=end($extencion);


if (is_array($_FILES) && count($_FILES) > 0) {
    if (($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/gif")) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../archivos/".$folioreq.$fecha.".".$extencion)) {
            //more code here...
            $archivo= "archivos/".$folioreq.$fecha.".".$extencion;

            include_once 'conexion.php';
            $objeto = new conn();
            $conexion = $objeto->connect();
            $consulta = "UPDATE requisicion set furl='$archivo' WHERE folio_req='$folioreq'";
            $resultado = $conexion->prepare($consulta); 
            if ($resultado->execute()) {
                echo 1;
            } else {
                echo 0;
            }


        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}


