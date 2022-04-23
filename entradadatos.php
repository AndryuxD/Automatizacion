<?php
    require_once('conexion.php');

   $id = $_GET['id'];
   $puerta = $_GET['puerta'];
   $iluminacion = $_GET['iluminacion'];
   $Temperatura = $_GET['Temperatura'];
   $MAC = $_GET['MAC'];
   
   //mac address: 80:7D:3A:6E:6B:3A
    //Consulta del salon con la MAC*********************************************************
    $Consulta="SELECT * from tbl_dispositivos
                WHERE vch_mac_dispositivo='$MAC'";
    $ResultadoConsulta = mysqli_query($Conexion,$Consulta);
    $Row=mysqli_fetch_array($ResultadoConsulta);
    $clv_aula=$Row['clv_aula'];

    //Update de los valores de los sensores del salon***************************************
    $Update="UPDATE tbl_estado_aulas 
                SET clv_ultimo_trabajador='$id', 
                    vch_puerta='$puerta',  
                    vch_iluminacion='$iluminacion', 
                    vch_temperatura='$Temperatura'    
                WHERE clv_aula=$clv_aula";
    $ResultadoUpdate = mysqli_query($Conexion,$Update);
    
    if ($ResultadoUpdate)
    echo 'yesss';
    else
    echo'neeel';

?>
