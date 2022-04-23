<?php
    require('../../../conexion.php');

    $rol= $_POST['rol'];
    $puesto= $_POST['puesto'];

    $Queryxd="INSERT INTO tbl_tipo_de_trabajador(vch_rol,vch_puesto) VALUES('$rol','$puesto')";
    $res=mysqli_query($Conexion, $Queryxd);
    header("Location: ../Tipodetrabajador.php");
    

