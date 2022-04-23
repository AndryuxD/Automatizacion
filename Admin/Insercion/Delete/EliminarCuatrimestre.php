<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_cuatrimestre WHERE clv_cuatrimestre=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Cuatrimestre.php");
    
