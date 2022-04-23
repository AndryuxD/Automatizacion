<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_horas WHERE clv_hora=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Horas.php");
    

