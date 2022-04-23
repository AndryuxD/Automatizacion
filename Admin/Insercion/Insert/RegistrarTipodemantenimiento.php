<?php
    require('../../../conexion.php');

    $tipo= $_POST['tipo'];

    $Queryxd="INSERT INTO tbl_tipo_de_mantenimiento(vch_tipo) VALUES('$tipo')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Tipodemantenimiento.php");
    

