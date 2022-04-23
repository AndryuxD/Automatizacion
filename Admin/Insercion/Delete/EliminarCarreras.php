<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_carreras WHERE clv_carrera=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Carreras.php");
    
