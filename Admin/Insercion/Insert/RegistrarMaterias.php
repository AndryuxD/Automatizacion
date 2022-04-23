<?php
    require('../../../conexion.php');

    $materia= $_POST['materia'];
    $hsemana= $_POST['hsemana'];
    $cuatri= $_POST['cmbCu'];
    $carrera= $_POST['cmbCa'];

    $Queryxd="INSERT INTO tbl_materias(vch_materia,vch_horassemana,clv_cuatrimestre,clv_carrera) VALUES('$materia','$hsemana','$cuatri','$carrera')";
    echo $Queryxd;
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Materias.php");
    

