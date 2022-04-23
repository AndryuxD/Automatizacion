<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_tipo_de_mantenimiento WHERE clv_tipo_mantenimiento=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Tipodemantenimiento.php");
    
