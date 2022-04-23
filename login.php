<?php

require('conexion.php');

$clv=$_POST['clv'];
$pass=$_POST['password'];

$strQuery = "CALL sp_Login($clv,'$pass')";

/*if (strlen($pass)>64){
    $strQuery = "SELECT * FROM tbltipodetrabajador, tbltrabajadores WHERE tbltrabajadores.clvtrabajador=$clv AND 
                    tbltrabajadores.vchpassword=$pass AND tbltipodetrabajador.vchrol='Administrador' AND 
                    tbltipodetrabajador.`clvtipodetrabajador` = tbltrabajadores.`clvtipodetrabajador`";
}*/
$resultado=mysqli_query($Conexion, $strQuery);
$num_filas = $resultado->num_rows;

if ($num_filas>0){
    $row = mysqli_fetch_array($resultado);
    session_start();
    $_SESSION['Trabajador']= $row['clv_trabajador']; 
    header("Location: Admin/index.php");
}else{
    header("Location: Login.html?1=$clvDocente&2=$pass");
}
?>