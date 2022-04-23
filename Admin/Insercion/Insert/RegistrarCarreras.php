<?php
    require('../../../conexion.php');

    $vchcarrera= $_POST['carrera'];

    $Queryxd="INSERT INTO tbl_carreras(vch_carrera) VALUES('$vchcarrera')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Carreras.php");
    

