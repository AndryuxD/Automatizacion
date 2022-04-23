<?php 
    session_start();
    if (empty($_SESSION['Trabajador'])) {
        header('Location: ../login.html');
    }

    require('../conexion.php');

    $clv_trabajador=$_SESSION['Trabajador'];

    $consultaTrabajador = "CALL sp_SelectSession($clv_trabajador)";
    $resultado=mysqli_query($Conexion, $consultaTrabajador);
    $num_filas = $resultado->num_rows;
    if ($num_filas==0){
        header("Location: ../login.html");
    }
    $row=mysqli_fetch_array($resultado);
    
    mysqli_free_result($resultado);
    mysqli_close($Conexion);
    require('../conexion.php');
    
                        
    $queryEdificio="SELECT * FROM tbl_edificios";
    $resEdificio=mysqli_query($Conexion,$queryEdificio);


    $queryAulaControl="SELECT * FROM tbl_aulas, tbl_clima, tbl_edificios, tbl_estado_aulas,
                        tbl_trabajadores, tbl_tipo_de_trabajador
                            WHERE tbl_aulas.`clv_edificio` = tbl_edificios.`clv_edificio`
                            AND tbl_aulas.`clv_aula` = tbl_clima.`clv_aula`
                            AND tbl_estado_aulas.`clv_aula` = tbl_aulas.`clv_aula`
                            AND tbl_trabajadores.`clv_tipo_trabajador` = tbl_tipo_de_trabajador.`clv_tipo_trabajador`
                            AND tbl_trabajadores.`clv_trabajador` = tbl_estado_aulas.`clv_ultimo_trabajador`";
    $resAulaControl=mysqli_query($Conexion,$queryAulaControl);

    
    $queryAulaInformacion="SELECT * FROM tbl_aulas, tbl_estado_aulas
                            WHERE tbl_estado_aulas.`clv_aula` = tbl_aulas.`clv_aula`";
    $resAulaInformacion=mysqli_query($Conexion,$queryAulaInformacion);

    $queryclvHoraActual="SELECT * FROM tbl_horas
                            WHERE tbl_horas.`time_inicio` < NOW()
                            AND tbl_horas.`time_final` > NOW()";
    $resclvHoraActual=mysqli_query($Conexion,$queryclvHoraActual);
    $clvHoraActual='';
    if ($rowHoraActual=mysqli_fetch_array($resclvHoraActual)){
        $clvHoraActual=$rowHoraActual['clv_hora'];
    }
    mysqli_free_result($resclvHoraActual);
    mysqli_close($Conexion);
    require('../conexion.php');
    $Estado=0;
    $EdificioCookie='Mapa';
    $AulaCookie='';
    if (!empty($_GET['E'])) {
        $EdificioCookie=$_GET['E'];
    }
    if (!empty($_GET['A'])) {
        $AulaCookie=$_GET['A'];
    }
    include('Header.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Mapa.css">
</head>
<body>
    
    <header>
    </header>

    <br>
    <div id="aplicacion" class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12" >
                <!--****************************************CONTROL**************************************************************************-->
            
                <div >
                    <?php while ($FilaControl = mysqli_fetch_array($resAulaControl)){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" v-if="SelectAula=='<?php echo $FilaControl['vch_aula'] ?>'" >
                        <div class="card border-primary mb-3" style="max-width: 30rem;" v-if="SelectCI=='Control'">
                            <div class="card-header" align="center">
                                <h4 class="card-title text-dark">Control del Aula <?php echo $FilaControl['vch_aula'] ?></h4>
                            </div>
                            <div class="card-body">
                                <h5>Iluminacion: </h5>
                                <center>
                                    <a href="Control/ControlIluminacion.php?estado=<?php echo $FilaControl['vch_iluminacion'].'&id='.$FilaControl['clv_aula'] ?>">
                                        <img src="ImagenesLocales/Bombilla<?php echo $FilaControl['vch_iluminacion'] ?>.png" width="50" weight="50" alt="Bombilla <?php echo $FilaControl['vch_iluminacion'] ?>.png">
                                    </a>
                                    <br>
                                    <?php 
                                        echo $FilaControl['vch_iluminacion'];
                                    ?>
                                </center>
                                <br>
                                <h5>Clima:</h5>
                                <center>
                                    <a href="Control/ControlClima.php?estado=<?php echo $FilaControl['vch_estado'].'&id='.$FilaControl['clv_aula'] ?>">
                                        <img src="ImagenesLocales/Clima<?php echo $FilaControl['vch_estado'] ?>.png" width="50" weight="50" alt="Clima <?php echo $FilaControl['vch_estado'] ?>.png">
                                    </a>
                                    <br>
                                    <?php 
                                        echo $FilaControl['vch_estado'];
                                        echo '<br/>';
                                    ?>
                                    Temperatura: <?php echo $FilaControl['vch_temperatura'].'°C'; ?>
                                </center>
                                <br>
                                <h5>Puerta:</h5>
                                <center>
                                    <a href="Control/ControlPuerta.php?estado=<?php echo $FilaControl['vch_puerta'].'&id='.$FilaControl['clv_aula'] ?>">
                                        <img src="ImagenesLocales/Puerta<?php echo $FilaControl['vch_puerta'] ?>.png" width="100" weight="100" alt="Puerta <?php echo $FilaControl['vch_puerta'] ?>.png">
                                    </a>
                                    <br>
                                    <?php 
                                        echo $FilaControl['vch_puerta'];
                                    ?>
                                </center>
                                <br><br>
                                <button class="btn btn-block btn-outline-info" @click="mtdUpdateCI('Informacion')">
                                    Informacion del Aula
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php 
                        mysqli_free_result($resAulaControl);
                        mysqli_close($Conexion);
                        require('../conexion.php');
                        $i=0;
                    ?>
                    <!--************************************INFORMACION***************************************************************-->
                    <?php while ($FilaInfo = mysqli_fetch_array($resAulaInformacion)){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;" v-if="SelectAula=='<?php echo $FilaInfo['vch_aula'] ?>'" >
                        <div class="card border-primary mb-3" style="max-width: 30rem;" v-if="SelectCI=='Informacion'">
                            <div class="card-header" align="center">
                                <h4 class="card-title text-dark">Informacion del Aula <?php echo $FilaInfo['vch_aula'] ?></h4>
                            </div>
                            <div class="card-body">
                                <h5>Estado del Aula: </h5>
                                <center>
                                    <!--<a href="Control/ControlIluminacion.php?estado=<?php //echo $FilaInfo['vch_iluminacion'] ?>">
                                        <img src="ImagenesLocales/Bombilla<?php //echo $Fila['vch_iluminacion'] ?>.png" width="50" weight="50" alt="Bombilla <?php echo $Fila['vch_iluminacion'] ?>.png">
                                    </a>
                                    <br>-->
                                    <?php 
                                        echo $FilaInfo['vch_estado_aula'];
                                    ?>
                                </center>
                                <br>
                                <?php
                                    if($FilaInfo['vch_estado_aula']!='Disponible'){
                                ?>
                                    <h5> Ultimo Trabajador en el Aula:</h5> 
                                <?php }else{?>
                                    <h5> Trabajador dentro del Aula:</h5> 
                                <?php } ?>
                                <?php 
                                    $querySelectTrabajador = "SELECT * FROM tbl_trabajadores, tbl_tipo_de_trabajador 
                                                                WHERE tbl_trabajadores.`clv_tipo_trabajador` = tbl_tipo_de_trabajador.`clv_tipo_trabajador`
                                                                AND tbl_trabajadores.`clv_trabajador`=".$FilaInfo['clv_ultimo_trabajador'];
                                    $resSelectTrabajador = mysqli_query($Conexion,$querySelectTrabajador);
                                    $rowSelectTrabajador = mysqli_fetch_array($resSelectTrabajador);
                                ?>
                                <center>
                                <?php 
                                    if (file_exists("Insercion/ImagenesTrabajadores/".$rowSelectTrabajador['vch_foto'])){
                                ?>
                                        <img src="Insercion/ImagenesTrabajadores/<?php echo $rowSelectTrabajador['vch_foto'] ?>" width="50" weight="50" alt="<?php echo $rowSelectTrabajador['vch_foto'] ?>">
                                    <?php }else{ ?>
                                        <img src="ImagenesLocales/No_Image_Available.png" width="50" weight="50" alt="<?php echo $rowSelectTrabajador['vch_foto'] ?>">

                                    <?php }?>
                                    <br>
                                    <?php 
                                        echo 'Nombre: ';
                                        echo $rowSelectTrabajador['vch_nombre_trabajador'];
                                        echo '<br/>';
                                        echo 'Puesto: ';
                                        echo $rowSelectTrabajador['vch_puesto'];
    
                                    ?>
                                </center>
                                
                                <br><br>
                                <button class="btn btn-block btn-outline-info" @click="mtdUpdateCI('Control')">
                                    Control del Aula
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!--***************************************************************************************************-->
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12">
                <div class="mapa" v-if="SelectEdificio=='Mapa'">
                    <?php 
                        require('../conexion.php');
                        while ($rowEd=mysqli_fetch_array($resEdificio)){
                    ?>
                            <button class="BBP <?php echo $rowEd['vch_nombre_edificio']?>" 
                                    @click="mtdUpdateEdificio('<?php echo $rowEd['vch_nombre_edificio']?>')">
                                    <h3>
                                        <?php echo $rowEd['vch_nombre_edificio']?>
                                    </h3>
                            </button>
                    <?php }?>
                </div>
                
                <?php 
                    require('../conexion.php');
                    
                    $resEdificio2=mysqli_query($Conexion,$queryEdificio);
                    while ($rowEd2=mysqli_fetch_array($resEdificio2)){
                        
                        $queryAulas="SELECT * FROM tbl_edificios, tbl_aulas, tbl_estado_aulas
                        WHERE tbl_edificios.`clv_edificio` = tbl_aulas.`clv_edificio`
                        AND tbl_aulas.`clv_aula` = tbl_estado_aulas.`clv_aula`
                        AND tbl_edificios.`clv_edificio` = ".$rowEd2['clv_edificio'];
                        $resAulas=mysqli_query($Conexion,$queryAulas);
                        ?>
                        <div v-if="SelectEdificio=='<?php echo $rowEd2['vch_nombre_edificio'] ?>'">
                            <center class="row">
                            
                                <button class="btn btn-sm btn-outline-primary" v-if="SelectEdificio!='Mapa'" @click="mtdUpdateEdificio('Mapa')" >
                                    Regresar al MAPA
                                </button>
                                <h1 class="col-lg-5 col-md-12 col-sm-12">Edificio <?php echo $rowEd2['vch_nombre_edificio'] ?></h1>
                            </center>
                            <div class="Edificio edificio<?php echo $rowEd2['vch_nombre_edificio'] ?>">
                                <?php    
                                    while ($rowAulas=mysqli_fetch_array($resAulas)){ ?>

                                        <button class="aula <?php echo $rowAulas['vch_estado_aula'].' '. $rowAulas['vch_aula'] ?>" @click="mtdUpdateAula('<?php echo $rowAulas['vch_aula'] ?>')">
                                            <div>
                                                <?php echo $rowAulas['vch_aula'] ?>
                                            </div>
                                            <div>
                                                
                                                <img src="ImagenesLocales/Bombilla<?php echo $rowAulas['vch_iluminacion'] ?>.png" width="40px" height="40px" alt="Bombilla <?php echo $rowAulas['vch_iluminacion'] ?>.png">
                                            </div>
                                        </button>
                                        
                                <?php 
                                    } ?>
                            </div>
                        </div>
                <?php
                    }?>
                    
                
                    <center>
                    </center>
            </div>
            
            <center class="col-lg-3 col-md-12 col-sm-12" v-if="SelectEdificio!='Mapa'">
                <br>
                <div align="left">
                    <h3>Estados del aula</h3>
                </div>
                <br>
                <div align="left">
                    <label class=" btn-sm btn btn-success"></label>
                    <label >Disponible</label>
                </div>
                <div align="left">
                    <label class=" btn-sm btn btn-info"></label>
                    <label >Limpieza</label>
                </div>
                <div align="left">
                    <label class=" btn-sm btn btn-warning"></label>
                    <label >Mantenimiento</label>
                </div>
                <div align="left">
                    <label class=" btn-sm btn btn-danger"></label>
                    <label >Ocupada</label>
                </div>
                <br>
                <!--While de imagenes de edificios con el V-IF -->
                <?php 
                
                    $queryImgEd="SELECT * FROM tbl_edificios";
                    $resImgEd=mysqli_query($Conexion,$queryImgEd);
                    while ($rowImgEd=mysqli_fetch_array($resImgEd)){?>

                        <div align="left">
                            <h3 >Edificio <?php echo $rowImgEd['vch_nombre_edificio'] ?></h3>
                        </div>
                        
                        <?php 
                            if (file_exists("Insercion/ImagenesEdificios/".$rowImgEd['vch_imagen'])){
                        ?>
                                <img src="Insercion/ImagenesEdificios/<?php echo $rowImgEd['vch_imagen'] ?>" 
                                    width="300" height="300" 
                                    alt="Edificio <?php echo $rowImgEd['vch_nombre_edificio'] ?>"
                                    v-if="SelectEdificio=='<?php echo $rowImgEd['vch_nombre_edificio']?>'">
                        <?php 
                            }else{ ?>
                                <img src="ImagenesLocales/No_Image_Available.png" width="300" weight="300" alt="<?php echo $rowSelectTrabajador['vch_foto'] ?>">
                        <?php 
                            }?>
                
                <?php
                     }?>
            </center>
            </div>
        </div>
    </div>

     
    
    
    <script type="text/javascript" src="../css/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="../css/popper.min.js"></script>
    <script type="text/javascript" src="../css/bootstrap.min.js"></script>

    <script src="./vue.js"></script>
    <script>
        var app= new Vue({
            el: '#aplicacion',
            data: {
                SelectAula:"<?php echo $AulaCookie?>",
                SelectEdificio:"<?php echo $EdificioCookie?>",
                SelectCI:'Control'
            },
            methods:{
                mtdUpdateAula: function(strAula) {
                    this.SelectAula=strAula
                    //this.SelectCI='Control'
                },
                mtdUpdateEdificio: function(strEdificio){
                    this.SelectEdificio=strEdificio
                    if (strEdificio=='Mapa'){
                        this.SelectCI='Control'
                        this.SelectAula=''
                    }
                },
                mtdUpdateCI: function(strCI){
                    this.SelectCI=strCI
                }
                
            }
        })   
    </script>

</body>
</html>