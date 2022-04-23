<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_tipo_de_reporte WHERE clv_tipo_reporte=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Tipodereporte.php");
    
