<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_tipo_de_trabajador WHERE clv_tipo_trabajador=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Tipodetrabajador.php");
    
