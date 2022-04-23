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
    require('../../../conexion.php');

    $QueryCuatri = "SELECT * FROM tbl_cuatrimestre";
    $QueryCarrera = "SELECT * FROM tbl_carreras";
    $ResCuatri = mysqli_query($Conexion,$QueryCuatri);
    $ResCarrera = mysqli_query($Conexion,$QueryCarrera);
    $id=$_GET['id'];

?>

<?php 
    if ($_POST){
        require('../../../conexion.php');
        $materia=$_POST['materia'];
        $HS=$_POST['HS'];
        $cu=$_POST['cmbCu'];
        $ca=$_POST['cmbCa'];

        $strQuerybb="UPDATE tbl_materias 
                        SET vch_materia='$materia',
                        vch_horassemana='$HS',
                        clv_cuatrimestre=$cu,
                        clv_carrera=$ca
                        WHERE clv_materia=$id";
        $resultado2=mysqli_query($Conexion,$strQuerybb);
        header('Location: ../Materias.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php 
        require('../../../conexion.php');
        $querySelect = "SELECT * FROM tbl_materias WHERE clv_materia=$id";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);


    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Materias</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Materias</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div align="left">Materia</div>
                            <input type="text" name="materia" value="<?php echo $row['vch_materia'] ?>" class="form-control" maxlength="40" placeholder="Materia" required>
                            <br>
                            <div align="left">Horas semana</div>
                            <input type="number" name="HS" value="<?php echo $row['vch_horassemana'] ?>" class="form-control" min="0" max="20" placeholder="Horas Semana" required>
                            <br>
                            <div align="left">Cuatrimestre</div>
                            <select name="cmbCu" size="1" class="form-control">
                                <?php while ($rowCuatrimestre = mysqli_fetch_array($ResCuatri)) { ?>
                                    <option  <?php if ($rowCuatrimestre['clv_cuatrimestre']==$row['clv_cuatrimestre']) 
                                                    echo 'selected'?> 
                                        value="<?php echo $rowCuatrimestre['clv_cuatrimestre']?>">
                                            <?php echo $rowCuatrimestre['vch_cuatrimestre']?>
                                    </option>
                                <?php }?>
                            </select>
                            <br>
                            <div align="left">Carrera</div>
                            <select name="cmbCa" size="1" class="form-control">
                                <?php while ($rowCarrera = mysqli_fetch_array($ResCarrera)) { ?>
                                    <option  <?php 
                                    if ($rowCarrera['clv_carrera']==$row['clv_carrera']) 
                                        echo 'selected' 
                                    ?> value="<?php echo $rowCarrera['clv_carrera']?>"><?php echo $rowCarrera['vch_carrera']?></option>
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