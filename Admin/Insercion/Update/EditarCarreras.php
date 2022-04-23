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
    <title>Carreras</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php
        require('../../../conexion.php');   
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_carreras WHERE clv_carrera=$id";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);
    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Carreras</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Carreras</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div align="left">Carrera</div>
                            <input type="text" name="carrera" value="<?php echo $row['vch_carrera'] ?>" class="form-control" maxlength="20" placeholder="Carrera" required>
                            
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
                    $carrera=$_POST['carrera'];

                    $strQuerybb="UPDATE tbl_carreras SET vch_carrera='$carrera' WHERE clv_carrera=$id";
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Carreras.php');
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