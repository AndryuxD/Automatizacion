<?php 
    session_start();
    if (empty($_SESSION['Trabajador'])) {
        header('Location: ../../../login.html');
    }

    require('../../../conexion.php');
    $clv_trabajador=$_SESSION['Trabajador'];
    $consultaTrabajador = " CALL sp_SelectSession($clv_trabajador)";
    $resultado=mysqli_query($Conexion, $consultaTrabajador);
    $num_filas = $resultado->num_rows;
    if ($num_filas==0){
        header("Location: ../../../login.html");
    }
    $row=mysqli_fetch_array($resultado);
    
    mysqli_free_result($resultado);
    mysqli_close($Conexion);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horas</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php   
        require('../../../conexion.php');
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_horas WHERE clv_hora=$id";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);
    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Horas</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Horas</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div align="left">Hora de inicio</div>
                            <input type="time" name="inicio" value="<?php echo $row['time_inicio'] ?>" class="form-control" required>
                            <br>
                            <div align="left">Hora de final</div>
                            <input type="time" name="final" value="<?php echo $row['time_final'] ?>" class="form-control" required>
                            <br>
                            <div align="left">Turno</div>
                            <?php 

                            if ($row['clv_turno']==1){ ?>

                                <select name="cmb" size="1" class="form-control">
                                    <option class="form-control" selected value="1">Matutino</option>
                                    <option class="form-control" value="2">Vespertino</option>
                                </select>
                            <?php
                            }else{?>
                                <select name="cmb" size="1" class="form-control">
                                    <option class="form-control" value="1">Matutino</option>
                                    <option class="form-control" selected value="2">Vespertino</option>
                                </select>
                            <?php } ?>
                            <br><br>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <button class="btn btn-outline-info btn-block" onclick="goBack()">Volver atras</button>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <input type="submit" value="Editar" class="btn btn-outline-primary btn-block">
                                </div>
                            </div class="row">
                        </form>
                    </div>
                </div>
            </div>
            <?php 
                if ($_POST){
                    require('../../../conexion.php');
                    $inicio=$_POST['inicio'].':00';
                    $final=$_POST['final'].':00';
                    $turno=$_POST['cmb'];
                    $strQuerybb="UPDATE tbl_horas 
                                SET time_inicio='$inicio', time_final='$final', clv_turno=$turno 
                                WHERE clv_hora=$id";
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Horas.php');
                }
            ?>
    </div> 
    <script src="../vue.js"></script>
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
    <script type="text/javascript" src="../../../css/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="../../../css/popper.min.js"></script>
    <script type="text/javascript" src="../../../css/bootstrap.min.js"></script>


    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>