<?php 
    session_start();
    if (empty($_SESSION['Trabajador'])) {
        header('Location: ../../login.html');
    }

    require('../../conexion.php');
    $clv_trabajador=$_SESSION['Trabajador'];
    $consultaTrabajador = " CALL sp_SelectSession($clv_trabajador)";
    $resultado=mysqli_query($Conexion, $consultaTrabajador);
    $num_filas = $resultado->num_rows;
    if ($num_filas==0){
        header("Location: ../../login.html");
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
    <title>Horas</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body>
    
<header>
        
    </header>

<br>
    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Horas</h1>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12" style="margin-top: 10px;">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Registro de Horas</h4>
                    </div>
                    <div class="card-body">
                        <form action="Insert/RegistrarHoras.php" method="post">
                            Inicio de la hora:
                            <input type="time" name="inicio" class="form-control" required>
                            <br>
                            Final de la hora:
                            <input type="time" name="final" class="form-control" required>
                            <br>
                            Turno:
                            <select name="cmb" size="1" class="form-control">
                                <option class="form-control" value="1">Matutino</option>
                                <option class="form-control" value="2">Vespertino</option>
                            </select>
                            <br><br>
                            <input type="submit" value="Registrar" class="btn btn-outline-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 10px;">
                
                <?php 
                    require('../../conexion.php');
                    $querySelect = "SELECT * FROM tbl_horas";
                    $resbb = mysqli_query($Conexion, $querySelect);?>

                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th>Clave</th>
                                <th>Rango</th>
                                <th>Turno</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['clv_hora'] ?> </td>
                                <td align="center"> <?php echo $Fila['time_inicio'].'-'.$Fila['time_final'] ?> </td>
                                <td align="center"> <?php echo $Fila['clv_turno'] ?> </td>
                                <td align="center"> 
                                    <a href="Update/EditarHoras.php?id=<?php echo $Fila['clv_hora']?>" class="btn btn-small btn-warning">Editar</a>
                                    <a href="Delete/EliminarHoras.php?id=<?php echo $Fila['clv_hora']?>" class="btn btn-small btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
            </div>
        </>
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
    <script type="text/javascript" src="../../css/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="../../css/popper.min.js"></script>
    <script type="text/javascript" src="../../css/bootstrap.min.js"></script>


</body>
</html>