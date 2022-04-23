<?php 
    session_start();
    if (empty($_SESSION['Trabajador'])) {
        header('Location: ../login.html');
    }

    require('../conexion.php');
    $clv_trabajador=$_SESSION['Trabajador'];
    $consultaTrabajador = " CALL sp_SelectSession($clv_trabajador)";
    $resultado=mysqli_query($Conexion, $consultaTrabajador);
    $num_filas = $resultado->num_rows;
    if ($num_filas==0){
        header("Location: ../login.html");
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
    <title>Asistencia de Docentes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    
    <header>
       
    </header>

    <br>
    <div class="container-fluid" id="aplicacion">
        <br>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div align="center">
                    <h1>Asistencias de Docentes</h1>
                </div>
            </div>
            <br>
            <?php
                    
            require('../conexion.php');
            $querySelect = "SELECT * FROM tbl_historial_asistencia_docentes, tbl_horarios, tbl_aulas, tbl_trabajadores, tbl_dias, tbl_horas,
                                tbl_materias, tbl_grupos, tbl_carreras
                                    WHERE tbl_historial_asistencia_docentes.`clv_horario` = tbl_horarios.`clv_horario`
                                    AND tbl_horarios.`clv_aula` = tbl_aulas.`clv_aula`
                                    AND tbl_trabajadores.`clv_trabajador` = tbl_horarios.`clv_trabajador`
                                    AND tbl_dias.`clv_dia` = tbl_horarios.`clv_dia`
                                    AND tbl_horas.`clv_hora` = tbl_horarios.`clv_hora`
                                    AND tbl_materias.`clv_materia` = tbl_horarios.`clv_materia`
                                    AND tbl_grupos.`clv_grupo` = tbl_horarios.`clv_grupo`
                                    AND tbl_grupos.`clv_carrera` = tbl_carreras.`clv_carrera`
                                    ORDER BY clv_historial DESC";
            $resbb = mysqli_query($Conexion, $querySelect);
            
            ?>
             <div class="row">
                <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-bordered table-hover table-condensed order-table">
                        <thead align="center">
                            <tr class="table-primary">
                                <th>Docente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Aula</th>
                                <th>Bloque</th>
                                <th>Dia de la semana</th>
                                <th>Materia</th>
                                <th>Grupo</th>
                            </tr>
                        </thead>
                        <?php
                        while ($Fila = mysqli_fetch_array($resbb)) {
                            ?>
                            <tr>
                                <td align="center"> <?php echo $Fila['vch_nombre_trabajador'] ?> </td>
                                <td align="center"> <?php echo $Fila['date_dia'] ?> </td>
                                <td align="center"> <?php echo $Fila['time_hora'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_aula'] ?> </td>
                                <td align="center"> <?php echo $Fila['time_inicio'].' - '.$Fila['time_final'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_dia'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_materia'] ?> </td>
                                <td align="center"> <?php echo $Fila['vch_grupo'] ?> </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
    </div> 
    
    <script src="vue.js"></script>
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
    <script type="text/javascript" src="../css/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="../css/popper.min.js"></script>
    <script type="text/javascript" src="../css/bootstrap.min.js"></script>


</body>
</html>