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
    if ($num_filas==0)
        header("Location: ../login.html");

    $row=mysqli_fetch_array($resultado);
    mysqli_free_result($resultado);
    mysqli_close($Conexion);
    //require('../conexion.php');
    include('Header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    
    <header id="Header uwu">
    </header>
<br>
    <div class="container-fluid" id="aplicacion">
                        <h1>Inicio</h1>
        <br>
        <div>
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div align="center">
                        <h2>Reportes</h2>
                    </div>
                </div>
                <!--<div class="col-lg-2 col-md-12 col-sm-12">
                    <div align="right">
                    <select v-model="select" size="1" class="form-control" >
                        <option>Hoy</option>
                        <option>La semana</option>
                        <option>El mes</option>
                    </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12">
                    <button @click="seleccionar" class="btn btn-block btn-primary">
                        Seleccionar
                    </button>
                <div>-->
            </div >
            <br>
            <?php
            require('../conexion.php');
            $querySelect = "CALL sp_ListaDeReportes()";
            $resbb = mysqli_query($Conexion, $querySelect) or die('Error: '.mysqli_error($Conexion));
            while ($Fila = mysqli_fetch_array($resbb)) {

                $edificio=$Fila['vch_nombre_edificio'];
                $aula=$Fila['vch_aula'];
                $docente=$Fila['vch_nombre_trabajador'];
                $dia=$Fila['date_fecha'];
                $hora=$Fila['time_hora'];
                $reporte=$Fila['vch_descripcion'];

                ?>                        
                <div align="center">
                    <div class="col-lg-10 col-md-12 col-sm-12" style="margin-top: 10px;">
                        <div class="card border-dark mb-3">
                            <div class="card-header " class="row" align="left">
                                <h4 class="title"><?php echo "Aula: ".$aula ?></h4>
                                <h4 class="title"><?php echo "Edificio: ".$edificio ?></h4>
                                <h4 class="title"><?php echo "Docente: ".$docente ?></h4>
                            </div>
                            <div class="card-body">
                                <form>
            
                                    <div align="center" class="row">
                                        <label class="form-control col-lg-2 col-md-12 col-sm-12"> <?php echo "Fecha: ".$dia ?> </label>
                                        <label class="form-control col-lg-2 col-md-12 col-sm-12"> <?php echo "Hora: ".$hora ?> </label>
                                    </div>
                                    <br>
                                    <p align="left">
                                        <?php echo $reporte ?>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php
            }
            ?>
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