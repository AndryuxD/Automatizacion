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
    <title>Tipo de Reporte</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php   
        require('../../../conexion.php');
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_tipo_de_reporte";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);
    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Tipo de Reporte</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Tipo de Reporte</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div align="left">Tipo</div>
                            <input type="text" name="tipo" value="<?php echo $row['vch_tipo_reporte'] ?>" class="form-control" maxlength="50" placeholder="Tipo" required>
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
                    $tipo=$_POST['tipo'];

                    $strQuerybb="UPDATE tbl_tipo_de_reporte SET vch_tipo_reporte='$tipo'
                                WHERE clv_tipo_reporte=$id";
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Tipodereporte.php');
                }
            ?>
    </div> 
    
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