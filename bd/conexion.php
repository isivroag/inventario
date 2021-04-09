<?php
    class conn{
        
        function connect(){
        
            define('servidor','localhost');
            define('bd_nombre','tecniemc_inventario');
            define('usuario','root');
            define('password','tecniem');

            $opciones=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try{
                $conexion=new PDO("mysql:host=".servidor.";dbname=".bd_nombre, usuario,password, $opciones);
                return $conexion;
            }catch(Exception $e){
                return null;
            }
        }
    }
?>