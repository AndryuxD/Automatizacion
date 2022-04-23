<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_grupos WHERE clv_grupo=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Grupos.php");
    
