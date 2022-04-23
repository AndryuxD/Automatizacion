<?php
    require('../../../conexion.php');

    $dispositivo= $_POST['dispositivo'];
    $MAC= $_POST['MAC'];
    $aula= $_POST['cmb'];

    $Queryxd="INSERT INTO tbl_dispositivos(vch_dispositivo,vch_MAC_dispositivo,clv_aula) VALUES('$dispositivo','$MAC',$aula)";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Dispositivos.php");
    

