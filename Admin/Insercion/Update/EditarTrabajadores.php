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
    $QueryTipoDT = "SELECT * FROM tbl_tipo_de_trabajador";
    $ResTipoDT = mysqli_query($Conexion,$QueryTipoDT);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajadores</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php   
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_trabajadores,tbl_tipo_de_trabajador WHERE clv_trabajador=$id";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);


    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Trabajadores</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Trabajadores</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div align="left">Nombre</div>

                            <input type="text" name="trabajador" value="<?php echo $row['vch_nombre_trabajador'] ?>" class="form-control" maxlength="50" placeholder="Trabajador" required>
                            <br>
                            <div align="left">Tipo de trabajador</div>
                            <select name="cmbTipoDT" size="1" class="form-control">
                                <?php while ($rowTipoDT = mysqli_fetch_array($ResTipoDT)) { ?>
                                    <option  <?php 
                                    if ($rowTipoDT['clv_tipo_trabajador']==$id) 
                                        echo 'selected' 
                                    ?> value="<?php echo $rowTipoDT['clv_tipo_trabajador']?>"><?php echo $rowTipoDT['vch_puesto']?></option>
                                <?php }?>
                            </select>
                            <br>
                            <div align="left">Password</div>
                            <input type="password"  name="password"  class="form-control" maxlength="64" minlength="8" placeholder="[Sin cambios]" >
                            <br>
                            <div align="left">Foto</div>
                            
                            <input type="file" name="img" id="img" class="form-control"> 
                            <br>
                            <div align="left">Foto actual:</div>
                            <br>
                                <img src="../ImagenesTrabajadores/<?php echo $row['vch_foto'] ?>" width="200" height="200"> 
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
                    $trabajadorxd=$_POST['trabajador'];
                    $cmb=$_POST['cmbTipoDT'];
                    $pass=$_POST['password'];
                    $TMPIMG=$_FILES['img']['tmp_name'];

                    $ArraTemporal=explode('.',$row['vch_foto']);
                    $TipoTemporal=$ArraTemporal[1];

                    $NombreIMG='Trabajador_'.$id.'_'.$trabajadorxd.'.'.$TipoTemporal;

                    $URLDestino="../ImagenesTrabajadores/".$NombreIMG;
                    $URLTemporal="../ImagenesTrabajadores/".$row['vch_foto'];

                    if (is_uploaded_file($TMPIMG)){
                        $tipo=$_FILES['img']['type'];
                        $arrayxd = explode('/',$tipo);

                        $NombreIMG="Trabajador_".$id.'_'.$trabajadorxd.'.'.$arrayxd[1];
                        $URLDestino="../ImagenesTrabajadores/".$NombreIMG;

                        if (file_exists($URLTemporal) && $row['vch_foto']!='') 
                            unlink($URLTemporal);
                        copy($TMPIMG,$URLDestino);
                    }

                    rename($URLTemporal,$URLDestino);
                    
                    if ($pass==""){
                        $strQuerybb="UPDATE tbl_trabajadores 
                                        SET vch_nombre_trabajador='$trabajadorxd', 
                                        clv_tipo_trabajador=$cmb,
                                        vch_foto='$NombreIMG'
                                        WHERE clv_trabajador=$id";
                    }else{
                        $strQuerybb="UPDATE tbl_trabajadores 
                                        SET vch_nombre_trabajador='$trabajadorxd', 
                                        clv_tipo_trabajador=$cmb,
                                        vchpassword = $pass ,
                                        vch_foto='$NombreIMG'
                                        WHERE clv_trabajador=$id";
                    }
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Trabajadores.php');
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