<?php 
    $estado='Disponible';
    if ($EAULA=='Movimiento') {
        $SelectQueryxd="SELECT * FROM tbl_trabajadores, tbl_tipo_de_trabajador
                        WHERE tbl_trabajadores.`clv_tipo_trabajador` = tbl_tipo_de_trabajador.`clv_tipo_trabajador`
                        AND tbl_trabajadores.`clv_trabajador`=$id";
        $SelectResxd=mysqli_query($Conexion,$SelectQueryxd);
        $Rowuwu=mysqli_fetch_array($SelectResxd);
        switch ($Rowuwu['vch_puesto']){
            case 'Docente':
                $estado='Ocupada';
            break;
            case 'Mantenimiento':
                $estado='Mantenimiento';
            break;
            case 'Limpieza':
                $estado='Limpieza';
            break;
            default:
                $estado='Ocupada';
            break;
        }
    }
    