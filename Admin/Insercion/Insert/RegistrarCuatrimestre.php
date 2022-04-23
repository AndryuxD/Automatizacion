<?php
    require('../../../conexion.php');

    $vchcuatrimestre= $_POST['cuatri'];

    $Queryxd="INSERT INTO tbl_cuatrimestre(vch_cuatrimestre) VALUES('$vchcuatrimestre')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Cuatrimestre.php");
    

