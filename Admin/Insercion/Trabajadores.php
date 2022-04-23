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

    $stringTipoDeTrabajador = "SELECT * FROM `tbl_tipo_de_trabajador`";
    $resTipoDT=mysqli_query($Conexion, $stringTipoDeTrabajador);
    include('Header.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajadores</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body>
    
<header>
         
    </header>

<br>
    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Trabajadores</h1>
        <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12" style="margin-top: 10px;">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Registro de Trabajadores</h4>
                    </div>
                    <div class="card-body">
                        <form action="Insert/RegistrarTrabajadores.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="nombre" class="form-control" maxlength="50" placeholder="Nombre" required> 
                            <br>
                            Puesto:
                            <select name="cmbxd" size="1" class="form-control">
                            <?php
                                require('../../conexion.php');
                                while ($Fila1 = mysqli_fetch_array($resTipoDT)) {?>
                                <option value="<?php echo $Fila1['clv_tipo_trabajador'] ?>">
                                    <?php echo $Fila1['vch_puesto'] ?>
                                </option>
                                <?php }
                                    mysqli_free_result($resTipoDT);
                                    mysqli_close($Conexion);?>
                            </select>   
                            <br>
                            <input type="password" class="form-control" required name="pass" minlength="8" maxlength="64" placeholder="Password">
                            <br>
                            Foto:
                            <input type="file" name="img" id="img" class="form-control">
                            <br><br>
                            <input type="submit" value="Registrar" class="btn btn-outline-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 10px;">
                
                <?php
                    
                    require('../../conexion.php'); 
                    $querySelect = "SELECT * FROM tbl_trabajadores, tbl_tipo_de_trabajador WHERE 
                                        tbl_tipo_de_trabajador.`clv_tipo_trabajador`=tbl_trabajadores.`clv_tipo_trabajador`";
                    $resbb = mysqli_query($Conexion, $querySelect);?>

                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th>Clave</th>
                                <th>Nombre</th>
                                <th>Puesto</th>
                                <th>Foto</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['clv_trabajador'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_nombre_trabajador'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_puesto'] ?> </td>
                                <td align="center"> 
                                    <img src="ImagenesTrabajadores/<?php echo $Fila['vch_foto']?>" width="100" height="100" alt="<?php echo $Fila['vch_foto']?>"> 
                                </td>
                                <td align="center"> 
                                    <a href="Update/EditarTrabajadores.php?id=<?php echo $Fila['clv_trabajador']?>" class="btn btn-small btn-warning">Editar</a>
                                    <a href="Delete/EliminarTrabajadores.php?id=<?php echo $Fila['clv_trabajador']?>" class="btn btn-small btn-danger">Eliminar</a>
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