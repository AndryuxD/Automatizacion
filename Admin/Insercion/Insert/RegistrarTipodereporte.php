<?php
    require('../../../conexion.php');

    $tipo= $_POST['tipo'];

    $Queryxd="INSERT INTO tbl_tipo_de_reporte(vch_tipo_reporte) VALUES('$tipo')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Tipodereporte.php");
    

