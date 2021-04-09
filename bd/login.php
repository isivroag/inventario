<?php
session_start();
include_once 'conexion.php';
$objeto = new conn();



$conexion = $objeto->connect();
if ($conexion != null) {
    //recepcion de los datos en el medodo post desde ajax code 
    $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';
    $recordar = (isset($_POST['recordar'])) ? $_POST['recordar'] : '';

    $pass = md5($password);
    $consulta = "SELECT * FROM w_usuario WHERE username='$usuario' AND password='$pass'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    if ($resultado->rowCount() >= 1) {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['s_usuario'] = $usuario;
        foreach ($data as $row) {

            $_SESSION['s_id_usuario'] = $row['id_usuario'];
            $_SESSION['s_nombre'] = $row['nombre'];
            $_SESSION['s_rol'] = $row['rol_usuario'];
            
        }
        if ($recordar==1){
                
            setcookie("usuario", $usuario,time () + 604800,"/");
            setcookie("pass", $pass,time () + 604800,"/");
        }
        else{
            setcookie("usuario",'',time()-100,"/");
            setcookie("pass",'',time()-100,"/");
        }

       
    } else {
        $_SESSION['s_id_usuario'] = null;
        $_SESSION['s_usuario'] = null;
        $_SESSION['s_nombre'] = null;
        $_SESSION['s_rol'] = $row = null;
        $data = 1;
    }
    print json_encode($data);
    $conexion = null;
} else {
    $data = 0;
    print json_encode($data);
    $conexion = null;
}
