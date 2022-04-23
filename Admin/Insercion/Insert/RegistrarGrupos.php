<?php
    require('../../../conexion.php');

    $grupo= $_POST['grupo'];
    $turno= $_POST['cmbturno'];
    $cuatri= $_POST['cmbCu'];
    $carrera= $_POST['cmbCa'];
    
    $Select = "SELECT * FROM tbl_carreras WHERE clv_carrera = $carrera";
    $RespuestaS = mysqli_query($Conexion,$Select);
    $Row = mysqli_fetch_array($RespuestaS);
    $Ordinal='';
    switch ($cuatri){
        case 1: 
            $Ordinal='ero';
        break;
        case 2: 
            $Ordinal='do';
        break;
        case 3: 
            $Ordinal='ero';
        break;
        case 4: 
            $Ordinal='to';
        break;
        case 5: 
            $Ordinal='to';
        break;
        case 6: 
            $Ordinal='to';
        break;
        case 7: 
            $Ordinal='mo';
        break;
        case 8: 
            $Ordinal='vo';
        break;
        case 9: 
            $Ordinal='no';
        break;
        case 10: 
            $Ordinal='mo';
        break;
        case 11: 
            $Ordinal='vo';
        break;
    };
    $Mix = $cuatri.$Ordinal.' '.$grupo.' '.$Row['vch_carrera'];

    $Queryxd="INSERT INTO tbl_grupos(vch_grupo,clv_turno,clv_cuatrimestre,clv_carrera) VALUES('$Mix',$turno,$cuatri,$carrera)";
    
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Grupos.php");
    

