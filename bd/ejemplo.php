<?php
    $usuario="ivan";
    $pass="casa";
        setcookie("usuario", "$usuario");
    setcookie("pass", $pass);

    echo $_COOKIE['usuario']. " ". $_COOKIE['pass']
?>