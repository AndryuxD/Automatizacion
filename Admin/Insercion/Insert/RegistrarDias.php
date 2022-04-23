<?php
    require('../../../conexion.php');

    $vchdia= $_POST['dia'];

    $Queryxd="INSERT INTO tbl_dias(vch_dia) VALUES('$vchdia')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Dias.php");
    

