<?php
session_start();
if (empty($_SESSION['Trabajador'])) {
    header('Location: ../../login.html');
}

require('../../conexion.php');
$clv_trabajador = $_SESSION['Trabajador'];
$consultaTrabajador = " CALL sp_SelectSession($clv_trabajador)";
$resultado = mysqli_query($Conexion, $consultaTrabajador);
$num_filas = $resultado->num_rows;
if ($num_filas == 0) {
    header("Location: ../../login.html");
}
$row = mysqli_fetch_array($resultado);

mysqli_free_result($resultado);
mysqli_close($Conexion);
include('Header.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edificios</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>

    <header>

    </header>

    <br>
    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Edificios</h1>
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12" style="margin-top: 10px;">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Registro de Edificios</h4>
                    </div>
                    <div class="card-body">
                        <form action="Insert/RegistrarEdificio.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="nombre" class="form-control" maxlength="30" placeholder="Edificio" required>
                            <br>
                            Imagen
                            <input type="file" class="form-control" name="img" id="img">
                            <br><br>
                            <input type="submit" value="Registrar" class="btn btn-outline-success btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12" style="margin-top: 10px;">

                <?php
                require('../../conexion.php');
                $querySelect = "SELECT * FROM tbl_edificios";
                $resbb = mysqli_query($Conexion, $querySelect); ?>

                <table class="table table-bordered table-hover table-condensed order-table">
                    <thead align="center">
                        <tr class="table-primary">
                            <th>Clave</th>
                            <th>Edificio</th>
                            <th>Imagen</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <?php
                    while ($Fila = mysqli_fetch_array($resbb)) {
                    ?>
                        <tr>
                            <td align="center"> <?php echo $Fila['clv_edificio'] ?> </td>
                            <td align="center"> <?php echo $Fila['vch_nombre_edificio'] ?> </td>
                            <td align="center">
                                <?php if ($Fila['vch_imagen'] == "" || !file_exists("ImagenesEdificios/" . $Fila['vch_imagen'])) { ?>
                                    <img src="../ImagenesLocales/No_Image_Available.png" width="80" height="80">
                                <?php } else { ?>
                                    <img src="ImagenesEdificios/<?php echo $Fila['vch_imagen'] ?>" width="80" height="80">
                                <?php } ?>

                            </td>
                            <td align="center">
                                <a href="Update/EditarEdificios.php?id=<?php echo $Fila['clv_edificio'] ?>" class="btn btn-small btn-warning">Editar</a>
                                <a href="Delete/EliminarEdificios.php?id=<?php echo $Fila['clv_edificio'] ?>" class="btn btn-small btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <script src="../vue.js"></script>
        <script>
            var app = new Vue({
                el: '#aplicacion',
                data: {
                    tipoUser: '1',
                    titulo: '',
                    pregunta: '',
                    mostrar: false,
                    select: null,
                },
                methods: {
                    if (select = 'Hoy') {
                        <?php $diasSelect = 'Hoy' ?>
                    } else if (select = 'La semana') {
                        <?php $diasSelect = 'La semana' ?>
                    } else {
                        <?php $diasSelect = 'El mes' ?>
                    }
                }

            })
        </script>
        <script type="text/javascript" src="../../css/jquery-3.2.1.slim.min.js"></script>
        <script type="text/javascript" src="../../css/popper.min.js"></script>
        <script type="text/javascript" src="../../css/bootstrap.min.js"></script>


</body>

</html>