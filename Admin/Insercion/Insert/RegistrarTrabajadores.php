<?php
    require('../../../conexion.php');

    $vchdocente= $_POST['nombre'];
    $TipoDeDocente= $_POST['cmbxd'];
    $pass= $_POST['pass'];

    $Insert="INSERT INTO tbl_trabajadores(vch_nombre_trabajador,clv_tipo_trabajador,vch_password) 
                VALUES('$vchdocente',$TipoDeDocente,'$pass')";
    $ResInsert=mysqli_query($Conexion, $Insert);
    echo 'Insert:'.$Insert.'<br/>';
    $Select="SELECT MAX(clv_trabajador) FROM tbl_trabajadores";
    $ResSelect = mysqli_query($Conexion,$Select);
    $row=mysqli_fetch_array($ResSelect);
    $id=$row['MAX(clv_trabajador)'];

    $tipo=$_FILES['img']['type'];
    $arrayxd = str_split($tipo,6);
    $NombreIMG="Trabajador_".$id.'_'.$vchdocente.'.'.$arrayxd[1];

    $TMPIMG=$_FILES['img']['tmp_name'];
    $URLDestino="../ImagenesTrabajadores/".$NombreIMG;

    if (is_uploaded_file($TMPIMG)){
        copy($TMPIMG,$URLDestino);
    }
    $Update="UPDATE tbl_trabajadores SET vch_foto='$NombreIMG' WHERE clv_trabajador=$id";
    echo 'Update:'.$Update.'<br/>';
    $res=mysqli_query($Conexion, $Update);
    header("Location: ../Trabajadores.php");
    

