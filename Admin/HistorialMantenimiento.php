<?php 
    session_start();
    if (empty($_SESSION['Trabajador'])) {
        header('Location: ../login.html');
    }

    require('../conexion.php');
    $clv_trabajador=$_SESSION['Trabajador'];
    $consultaTrabajador = " CALL sp_SelectSession($clv_trabajador)";
    $resultado=mysqli_query($Conexion, $consultaTrabajador);
    $num_filas = $resultado->num_rows;
    if ($num_filas==0){
        header("Location: ../login.html");
    }
    $row=mysqli_fetch_array($resultado);
    
    mysqli_free_result($resultado);
    mysqli_close($Conexion);
    include('Header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento de Climas</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    
    <header>
       
    </header>

    <br>
    <div class="container-fluid" id="aplicacion">
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div align="center">
                    <h1>Mantenimiento de Climas</h1>
                </div>
            </div>
            <br>
            <?php
                    
            require('../conexion.php');
            $querySelect = "SELECT * FROM tbl_mantenimiento,  tbl_aulas, tbl_tipo_de_mantenimiento, tbl_trabajadores
                                WHERE tbl_mantenimiento.`clv_aula` = tbl_aulas.`clv_aula`
                                AND tbl_tipo_de_mantenimiento.`clv_tipo_mantenimiento` = tbl_mantenimiento.`clv_tipo_mantenimiento`
                                AND tbl_trabajadores.`clv_trabajador` = tbl_mantenimiento.`clv_trabajador`
                                ORDER BY clv_mantenimiento DESC";
            $resbb = mysqli_query($Conexion, $querySelect);
            
            ?>
             <div class="row">
                <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th style="width: 150px;">Tipo</th>
                                <th style="width: 150px;">Aula</th>
                                <th style="width: 300px;">Trabajador ID/Nombre</th>
                                <th style="width: 200px;">Fecha</th>
                                <th>Observacion</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['vch_tipo'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_aula'] ?> </td>
                                <td align="center"> <?php echo $Fila['clv_trabajador'].' '.$Fila['vch_nombre_trabajador'] ?> </td>
                                <td align="center"> <?php echo $Fila['date_fecha'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_observacion'] ?> </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
    </div> 
    
    <script src="vue.js"></script>
    <script>
        var app= new Vue({
            el: '#aplicacion',
            data: {
                tipoUser:'1',
                titulo:'',
                pregunta:'',
                mostrar: false,
                select:null,
            },
            methods:{
                    if(select='Hoy'){
                        <?php $diasSelect='Hoy' ?>
                    }else if (select='La semana'){
                        <?php $diasSelect='La semana' ?>
                    }else{
                        <?php $diasSelect='El mes' ?>
                    }
                }
            }
        })   
    </script>
    <script type="text/javascript" src="../css/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="../css/popper.min.js"></script>
    <script type="text/javascript" src="../css/bootstrap.min.js"></script>


</body>
</html>