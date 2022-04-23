<?php
$host="localhost";
$base="escuela";
$usu="root";
$pass="";

$Conexion = new mysqli($host,$usu,$pass,$base);

if($Conexion->connect_errno){
    echo '<h1>'.'Error de conexion uwu'.'</h1>';
}
