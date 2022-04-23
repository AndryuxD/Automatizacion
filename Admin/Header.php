
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active " >
                        <label class="nav-link">Bienvenido <?php echo $row['vch_nombre_trabajador'] ?></label>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <!--<li class="nav-item ">
                        <a class="nav-link" href="Control.php">Control</a>
                    </li>-->
                    <li class="nav-item ">
                        <a class="nav-link" href="Mapa.php">Mapa</a>
                    </li>
                    <li class="nav-item ">
                        <div class="dropdown">
                            <a class=" nav-link dropdown-toggle" role="button" href="" id="dropInsercion" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                Historial
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropInsercion">
                                <a href="HistorialDocentes.php" class="dropdown-item ">Asistencia de Docentes</a>
                                
                                <div class="dropdown-divider"></div>

                                <a href="HistorialMantenimiento.php" class="dropdown-item" >Mantenimiento de Climas</a>
                                <div class="dropdown-divider"></div>

                                <a href="HistorialReportes.php" class="dropdown-item" >Reportes del Aula</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <div class="dropdown">
                            <a class=" nav-link dropdown-toggle" role="button" href="" id="dropInsercion" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                Insercion de datos
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropInsercion">
                                <a href="Insercion/Edificios.php" class="dropdown-item ">Edificios</a>

                                <a href="Insercion/Aulas.php" class="dropdown-item" >Aulas</a>

                                <a href="Insercion/Tipodereporte.php" class="dropdown-item" >Tipo de Reporte</a>

                                <a href="Insercion/Dispositivos.php" class="dropdown-item" >Dispositivos</a>
                                <div class="dropdown-divider"></div>

                                <a href="Insercion/Climas.php" class="dropdown-item" >Climas</a>

                                <a href="Insercion/Tipodemantenimiento.php" class="dropdown-item" >Tipo de Mantenimiento</a>
                                <div class="dropdown-divider"></div>


                                <a href="Insercion/Trabajadores.php" class="dropdown-item" >Trabajadores</a>

                                <a href="Insercion/Tipodetrabajador.php" class="dropdown-item" >Tipo de Trabajador</a>
                                <div class="dropdown-divider"></div>

                                <a href="Insercion/Materias.php" class="dropdown-item" >Materias</a>

                                <a href="Insercion/Carreras.php" class="dropdown-item" >Carreras</a>

                                <a href="Insercion/Cuatrimestre.php" class="dropdown-item" >Cuatrimestre</a>

                                <a href="Insercion/Grupos.php" class="dropdown-item" >Grupos</a>
                                <div class="dropdown-divider"></div>

                                <a href="Insercion/Horas.php" class="dropdown-item" >Horas</a>

                                <a href="Insercion/Dias.php" class="dropdown-item" >Dias</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" >
                            Base de datos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="Bitacora.php" class="dropdown-item">Bitacora</a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li>
                                <a href="BackUp/Backup.php" class="dropdown-item" >BackUp</a>
                            </li>
                        </ul>
                        <div  aria-labelledby="dropBD">
                        </div>
                    </li>

                </ul>
                <ul class="nav navbar-nav pull-xs-right">
                    <li class="nav-item ">
                    <a class="nav-link" href="../cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </nav>