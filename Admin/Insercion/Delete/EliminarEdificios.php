<?php
require('../../../conexion.php');

    $id= $_GET['id'];

    
    $QueryUnlink="SELECT * FROM tbl_edificios WHERE clv_edificio=$id";
    $resbb=mysqli_query($Conexion, $QueryUnlink);
    $row=mysqli_fetch_array($resbb);
    $Ruta="../ImagenesEdificios/".$row['vch_imagen'];

    $Queryxd="DELETE FROM tbl_edificios WHERE clv_edificio=$id";
    $res=mysqli_query($Conexion, $Queryxd);

    if ($res){
        if (file_exists($Ruta)  && $row['vch_imagen']!='')
            unlink($Ruta);
    }

    header("Location: ../Edificios.php");
    
