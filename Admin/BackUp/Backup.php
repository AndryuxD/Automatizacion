<?php
    $db_Host = 'localhost';
    $db_Name = 'escuela';
    $db_User = 'root';
    $db_Pass = ''; 
    
    $Hora=strftime("%H");
    $horaxd=$Hora-7;
    $fecha = strftime("%Y-%m-%d_$horaxd:%M:%S");
    $salida_sql = $db_Name.'_'.$fecha.'.sql';


    $dump = "mysqldump -h$db_Host -u$db_User -p$db_Pass --opt $db_Name > $salida_sql";
    system($dump, $output);
    //echo $dump;
    header('Location: ../index.php');

    //$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
    //exec($command,$output=array(),$worked);
    
?>