<?php
    require('../../../conexion.php');

    $inicio=$_POST['inicio'].':00';
    $final=$_POST['final'].':00';
    $turno= $_POST['cmb'];

    $Queryxd="INSERT INTO tbl_horas(time_inicio,time_final,clv_turno) VALUES('$inicio','$final',$turno)";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Horas.php");
    

