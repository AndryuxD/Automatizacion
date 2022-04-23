<?php
    require('../../../conexion.php');

    $vchedificio= $_POST['nombre'];

    $Insert="INSERT INTO tbl_edificios(vch_nombre_edificio) VALUES('$vchedificio')";
    $ResInsert=mysqli_query($Conexion, $Insert);

    $Select="SELECT MAX(clv_edificio) FROM tbl_edificios";
    $ResSelect = mysqli_query($Conexion,$Select);
    $row=mysqli_fetch_array($ResSelect);
    $id=$row['MAX(clv_edificio)'];

    $TMPIMG=$_FILES['img']['tmp_name'];
    
    $tipo=$_FILES['img']['type'];
    $arrayxd = str_split($tipo,6);
    $NombreIMG="Edificio_".$id.'_'.$vchedificio.'.'.$arrayxd[1];

    $URLDestino="../ImagenesEdificios/".$NombreIMG;

    if (is_uploaded_file($TMPIMG)){
        copy($TMPIMG,$URLDestino);
    }

    $Insert2="UPDATE tbl_edificios SET vch_imagen='$NombreIMG' WHERE clv_edificio=$id";
    $ResInsert2=mysqli_query($Conexion, $Insert2);
    //echo $Insert2;
    header("Location: ../Edificios.php");
    
