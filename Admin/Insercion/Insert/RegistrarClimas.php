<?php
    require('../../../conexion.php');

    $mod= $_POST['modelo'];
    $mar= $_POST['marca'];
    $cap= $_POST['capacidad'];
    $vol= $_POST['voltaje'];
    $aula= $_POST['cmb'];

    $Queryxd="INSERT INTO tbl_clima(vch_modelo, vch_marca, vch_capacidad, vch_voltaje,
                            date_ingreso, clv_aula, vch_estado, vch_tiempo_enc) 
                VALUES('$mod','$mar','$cap','$vol',NOW(),$aula,'Apagado','00:00:00')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Climas.php");
    

