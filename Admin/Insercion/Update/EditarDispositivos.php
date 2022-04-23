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
    <title>Dispositivos</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php   
        require('../../../conexion.php');
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_aulas, tbl_dispositivos 
                        WHERE clv_dispositivo=$id 
                        AND tbl_dispositivos.`clv_aula` = tbl_aulas.`clv_aula`";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);

        $queryA = "SELECT * FROM tbl_aulas";
        $resA = mysqli_query($Conexion,$queryA);
    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Dispositivos</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Dispositivos</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div align="left">Dispositivo</div>
                            <input type="text" name="dispositivo" value="<?php echo $row['vch_dispositivo'] ?>" class="form-control" maxlength="50" placeholder="Dispositivo" required>
                            <br>
                            <div align="left">MAC</div>
                            <input type="text" name="MAC" value="<?php echo $row['vch_mac_dispositivo'] ?>" class="form-control" maxlength="50" placeholder="MAC" required>
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
                    $dispositivo=$_POST['dispositivo'];
                    $MAC=$_POST['MAC'];
                    $aula=$_POST['cmb'];

                    $strQuerybb="UPDATE tbl_dispositivos SET vch_dispositivo='$dispositivo',vch_mac_dispositivo='$MAC', clv_aula=$aula WHERE clv_dispositivo=$id";
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Dispositivos.php');
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