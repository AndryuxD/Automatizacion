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
    <title>Climas</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php   
        require('../../../conexion.php');
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_aulas, tbl_clima
                        WHERE clv_serie=$id 
                        AND tbl_clima.`clv_aula` = tbl_aulas.`clv_aula`";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);

        $queryA = "SELECT * FROM tbl_aulas";
        $resA = mysqli_query($Conexion,$queryA);
    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Climas</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Climas</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div align="left">Modelo</div>
                            <input type="text" name="modelo" value="<?php echo $row['vch_modelo'] ?>" class="form-control" maxlength="50" placeholder="Modelo" required>
                            <br>
                            <div align="left">Marca</div>
                            <input type="text" name="marca" value="<?php echo $row['vch_marca'] ?>" class="form-control" maxlength="25" placeholder="Marca" required>
                            <br>
                            <div align="left">Capacidad</div>
                            <input type="text" name="capacidad" value="<?php echo $row['vch_capacidad'] ?>" class="form-control" maxlength="25" placeholder="Capacidad" required>
                            <br>
                            <div align="left">Voltaje</div>
                            <input type="text" name="voltaje" value="<?php echo $row['vch_voltaje'] ?>" class="form-control" maxlength="25" placeholder="Voltaje" required>
                            <br>
                            <div align="left">
                                Aula
                            </div>
                            <select name="cmb" size="1" class="form-control">
                                <?php while ($rowA = mysqli_fetch_array($resA)){ ?>
                                    <option class="form-control" <?php 
                                    if ($rowA['clv_aula']==$row['clv_aula']) 
                                        echo 'selected' 
                                    ?> value="<?php echo $rowA['clv_aula']?>"><?php echo $rowA['vch_aula']?></option>
                                <?php }?>
                            </select>
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
                    $mod=$_POST['modelo'];
                    $mar=$_POST['marca'];
                    $cap=$_POST['capacidad'];
                    $vol=$_POST['voltaje'];
                    $aula=$_POST['cmb'];

                    $strQuerybb="UPDATE tbl_clima 
                                SET vch_modelo='$mod',
                                vch_marca='$mar',
                                vch_capacidad='$cap',
                                vch_voltaje='$vol',
                                clv_aula=$aula WHERE clv_serie=$id";
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Climas.php');
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