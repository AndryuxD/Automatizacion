<?php
    require('../../conexion.php');

    $estado = $_GET['estado'];
    $id = $_GET['id'];
    
    $estado = ($estado=='Encendido')? 'Apagado':'Encendido';

    $UpdateQuery = "UPDATE tbl_clima SET vch_estado='$estado'
                    WHERE clv_aula=$id";
    $UpdateResultado = mysqli_query($Conexion,$UpdateQuery);
    
    $SelectQuery = "SELECT * FROM tbl_aulas, tbl_edificios 
                    WHERE tbl_aulas.`clv_edificio`=tbl_edificios.`clv_edificio`
                    AND tbl_aulas.`clv_aula`=".$id;
    $SelectResultado = mysqli_query($Conexion,$SelectQuery);
    $SelectRow = mysqli_fetch_array($SelectResultado);
    
    header('Location: ../Mapa.php?E='.$SelectRow['vch_nombre_edificio'].'&A='.$SelectRow['vch_aula']);