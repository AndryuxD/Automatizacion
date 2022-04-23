<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_dias WHERE clv_dia=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Dias.php");
    
