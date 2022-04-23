<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_clima WHERE clv_serie=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Climas.php");
    
