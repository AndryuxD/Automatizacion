<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_dispositivos WHERE clv_dispositivo=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Dispositivos.php");
    
