<?php
    require('../../../conexion.php');

    $aula= $_POST['nombre'];
    $clvedificio= $_POST['cmb'];

    $Queryxd="INSERT INTO tbl_aulas(vch_aula,clv_edificio) VALUES('$aula',$clvedificio)";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Aulas.php");
    

