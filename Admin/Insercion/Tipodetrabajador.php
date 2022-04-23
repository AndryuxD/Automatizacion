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
    <title>Tipo de Trabajador</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>
<body>
    
<header>
        
    </header>

<br>
    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Tipo de Tabajadores</h1>
        <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12" style="margin-top: 10px;">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Registro de tipos de Trabajadores</h4>
                    </div>
                    <div class="card-body">
                        <form action="Insert/RegistrarTipodetrabajador.php" method="post">
                            <input type="text" name="rol" class="form-control" maxlength="30" placeholder="Rol" required>  
                            <br> 
                            <input type="text" name="puesto" class="form-control" maxlength="30" placeholder="Puesto" required>        
                            <br><br>
                            <input type="submit" value="Registrar" class="btn btn-outline-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 10px;">
                
                <?php 
                    require('../../conexion.php');
                    $querySelect = "SELECT * FROM tbl_tipo_de_trabajador";
                    $resbb = mysqli_query($Conexion, $querySelect);?>

                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th>Clave</th>
                                <th>Rol</th>
                                <th>Puesto</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['clv_tipo_trabajador'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_rol'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_puesto'] ?> </td>
                                <td align="center"> 
                                    <a href="Update/EditarTipoDeTrabajador.php?id=<?php echo $Fila['clv_tipo_trabajador']?>" class="btn btn-small btn-warning">Editar</a>
                                    <a href="Delete/EliminarTipodetrabajador.php?id=<?php echo $Fila['clv_tipo_trabajador']?>" class="btn btn-small btn-danger">Eliminar</a>
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