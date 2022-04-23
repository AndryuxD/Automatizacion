<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $Queryxd="DELETE FROM tbl_aulas WHERE clv_aula=$id";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Aulas.php");
    
