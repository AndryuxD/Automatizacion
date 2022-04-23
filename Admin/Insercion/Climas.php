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
    require('../../conexion.php');

    $queryAula="SELECT * FROM tbl_aulas";
    $resAula=mysqli_query($Conexion,$queryAula);
    include('Header.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Climas</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body>
    
    <header>
        
    </header>

<br>
    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Climas</h1>
        <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12" style="margin-top: 10px;">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Registro de Climas</h4>
                    </div>
                    <div class="card-body">
                        <form action="Insert/RegistrarClimas.php" method="post">
                            <input type="text" name="modelo" class="form-control" maxlength="50" placeholder="Modelo" required> 
                            <br>
                            <input type="text" name="marca" class="form-control" maxlength="25" placeholder="Marca" required> 
                            <br>
                            <input type="text" name="capacidad" class="form-control" maxlength="25" placeholder="Capacidad" required> 
                            <br>
                            <input type="text" name="voltaje" class="form-control" maxlength="25" placeholder="Voltaje" required> 
                            <br>
                            Aula
                            <select name="cmb" size="1" class="form-control">
                                <?php 
                                    require('../../conexion.php');
                                    while ($rowAula = mysqli_fetch_array($resAula)) { ?>
                                        <option value="<?php echo $rowAula['clv_aula']?>">
                                            <?php echo $rowAula['vch_aula']?>
                                        </option>
                                <?php }?>
                            </select>

                            </select>        
                            <br><br>
                            <input type="submit" value="Registrar" class="btn btn-outline-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 10px;">
                
                <?php 
                    $querySelect = "SELECT * FROM tbl_clima, tbl_aulas
                                    WHERE tbl_clima.`clv_aula`=tbl_aulas.`clv_aula`";
                    $resbb = mysqli_query($Conexion, $querySelect);?>

                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th>Modelo</th>
                                <th>Marca</th>
                                <th>Capacidad</th>
                                <th>Voltaje</th>
                                <th>Aula</th>
                                <th style="width: 150px">Tiempo total de encendido</th>
                                <th style="width: 200px">Opciones</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['vch_modelo'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_marca'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_capacidad'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_voltaje'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_aula'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_tiempo_enc'] ?> </td>
                                <td align="center"> 
                                    <a href="Update/EditarClimas.php?id=<?php echo $Fila['clv_serie']?>" class="btn btn-small btn-warning">Editar</a>
                                    
                                    <a href="Delete/EliminarClimas.php?id=<?php echo $Fila['clv_serie']?>" class="btn btn-small btn-danger">Eliminar</a>
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