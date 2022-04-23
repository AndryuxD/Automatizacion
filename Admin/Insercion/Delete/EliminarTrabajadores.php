<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    $QueryUnlink="SELECT * FROM tbl_trabajadores WHERE clv_trabajador=$id";
    $resbb=mysqli_query($Conexion, $QueryUnlink);
    $row=mysqli_fetch_array($resbb);
    $Ruta="../ImagenesTrabajadores/".$row['vch_foto'];

    $Queryxd="DELETE FROM tbl_trabajadores WHERE clv_trabajador =$id";
    $res=mysqli_query($Conexion, $Queryxd);
    if ($res){
        if (file_exists($Ruta)  && $row['vch_foto']!='')
            unlink($Ruta);
    }
    header("Location: ../Trabajadores.php");
    
