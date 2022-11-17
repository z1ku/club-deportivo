<?php
    require_once "funciones.php";

    if(isset($_POST['insertar_cita'])){
        $id_usuario=$_POST['usuario'];
        $id_servicio=$_POST['servicio'];
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];

        $marca=strtotime($fecha);
        $dia=date('d', $marca);
        $mes=date('m', $marca);
        $anio=date('Y', $marca);

        $fecha_actual=date('Y-m-d');

        if(!checkdate($mes, $dia, $anio)){
            echo "<p>Fecha incorrecta</p>";
        }else if($fecha<$fecha_actual){
            echo "<p>La fecha no puede ser anterior a hoy</p>";
        }else{
            $con=conectarServidor();

            $insertar=$con->prepare("insert into citas values(?,?,?,?)");
            $insertar->bind_param("iiss",$id_usuario,$id_servicio,$fecha,$hora);

            if($insertar->execute()){
                echo "<p>Cita nueva insertada correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $insertar->error;
            }

            $insertar->close();
            $con->close();
        }
        
        header("refresh:2; url=citas.php");
    }else{
        header("Location:citas.php");
    }
?>