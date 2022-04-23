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
    <title>Edificios</title>
    <link rel="stylesheet" href="../../../css/bootstrap.min.css">
</head>
<body>

    <?php   
        require('../../../conexion.php');
        $id=$_GET['id'];
        $querySelect = "SELECT * FROM tbl_edificios WHERE clv_edificio=$id";
        $resbb = mysqli_query($Conexion, $querySelect);
        $row=mysqli_fetch_array($resbb);
        mysqli_free_result($resbb);
        mysqli_close($Conexion);
    ?>

<br>

    <div class="container-fluid" id="aplicacion">
        <h1 align="center">Edificios</h1>
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" align="center">
                <div class="card border-primary mb-3" style="max-width: 25rem;">
                    <div class="card-header" align="center">
                        <h4 class="card-title text-dark">Editar Edificios</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data"> 
                            <div align="left">
                            Edificio:
                            </div>
                            <input type="text" name="edificio" value="<?php echo $row['vch_nombre_edificio'] ?>" class="form-control" maxlength="30" placeholder="Edificio" required>
                            
                            <br>
                            <div align="left">
                            Imagen:
                            </div>
                            <input type="file" class="form-control" name="img" id="img">
                            <br>
                            <div align="left">Imagen actual:</div> 
                            <br>
                                <img src="../ImagenesEdificios/<?php echo $row['vch_imagen'] ?>" width="200" height="200"> 
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
                    require('../../../conexion.php');
                    $edificio=$_POST['edificio'];
                    $TMPIMG=$_FILES['img']['tmp_name'];

                    $ArraTemporal=explode('.',$row['vch_imagen']);
                    $TipoTemporal=$ArraTemporal[1];

                    $NombreIMG='Edificio_'.$id.'_'.$edificio.'.'.$TipoTemporal;

                    $URLDestino="../ImagenesEdificios/".$NombreIMG;
                    $URLTemporal="../ImagenesEdificios/".$row['vch_imagen'];

                    if (is_uploaded_file($TMPIMG)){
                        $tipo=$_FILES['img']['type'];
                        $arrayxd = explode('/',$tipo);

                        $NombreIMG="Edificio_".$id.'_'.$edificio.'.'.$arrayxd[1];
                        $URLDestino="../ImagenesEdificios/".$NombreIMG;

                        if (file_exists($URLTemporal) && $row['vch_imagen']!='') 
                            unlink($URLTemporal);
                        copy($TMPIMG,$URLDestino);
                    }
                    
                    rename($URLTemporal,$URLDestino);

                    $strQuerybb="UPDATE tbl_edificios SET vch_nombre_edificio='$edificio', vch_imagen='$NombreIMG' WHERE clv_edificio=$id";
                    
                    $resultado2=mysqli_query($Conexion,$strQuerybb);
                    header('Location: ../Edificios.php');
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