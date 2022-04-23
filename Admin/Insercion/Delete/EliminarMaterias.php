<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_materias WHERE clv_materia=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Materias.php");
    
