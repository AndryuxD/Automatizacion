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

    $queryCarrera="SELECT * FROM tbl_carreras";
    $resCarrera=mysqli_query($Conexion,$queryCarrera);
    $queryCuatrimestre="SELECT * FROM tbl_cuatrimestre";
    $resCuatrimestre=mysqli_query($Conexion,$queryCuatrimestre);
    include('Header.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body>
    
<header>
         
    </header>

<br>
    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Materias</h1>
        <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12" style="margin-top: 10px;">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Registro de Materias</h4>
                    </div>
                    <div class="card-body">
                        <form action="Insert/RegistrarMaterias.php" method="post">
                            <input type="text" name="materia" class="form-control" maxlength="40" placeholder="Materia" required> 
                            <br>
                            <input type="number" name="hsemana" class="form-control" max="20" min="0" placeholder="Horas semana" required> 
                            <br>
                            Cuatrimestre
                            <select name="cmbCu" size="1" class="form-control">
                                <?php
                                require('../../conexion.php');
                                while ($rowCuatrimestre = mysqli_fetch_array($resCuatrimestre)) { ?>
                                    <option value="<?php echo $rowCuatrimestre['clv_cuatrimestre']?>">
                                        <?php echo $rowCuatrimestre['vch_cuatrimestre']?>
                                    </option>
                                <?php }?>
                            </select>
                            <br>
                            Carrera
                            <select name="cmbCa" size="1" class="form-control">
                                <?php while ($rowCarrera = mysqli_fetch_array($resCarrera)) { ?>
                                    <option value="<?php echo $rowCarrera['clv_carrera']?>">
                                        <?php echo $rowCarrera['vch_carrera']?>
                                    </option>
                                <?php }?>
                            </select>
                            <br><br>
                            <input type="submit" value="Registrar" class="btn btn-outline-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 10px;">
                
                <?php $querySelect = "SELECT * FROM tbl_materias,tbl_cuatrimestre,tbl_carreras 
                                        WHERE tbl_materias.`clv_carrera` = tbl_carreras.`clv_carrera`
                                        AND tbl_materias.`clv_cuatrimestre` = tbl_cuatrimestre.`clv_cuatrimestre`";
                    $resbb = mysqli_query($Conexion, $querySelect);?>

                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th style="width: 80px">Clave</th>
                                <th>Materia</th>
                                <th style="width: 100px">Horas semana</th>
                                <th style="width: 200px">Cuatrimestre</th>
                                <th>Carrera</th>
                                <th style="width: 200px">Opciones</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['clv_materia'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_materia'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_horassemana'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_cuatrimestre'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_carrera'] ?> </td>
                                <td align="center"> 
                                    <a href="Update/EditarMaterias.php?id=<?php echo $Fila['clv_materia']?>" class="btn btn-small btn-warning">Editar</a>
                                    <a href="Delete/EliminarMaterias.php?id=<?php echo $Fila['clv_materia']?>" class="btn btn-small btn-danger">Eliminar</a>
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