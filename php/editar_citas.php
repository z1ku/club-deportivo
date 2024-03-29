<?php
    require_once "funciones.php";

    if(isset($_POST['insertar_cita'])){
        
        if($_POST['fecha']=="" || $_POST['hora']==""){
            echo "<p>Debes rellenar todos los campos</p>";
        }else{
            $id_usuario=$_POST['usuario'];
            $id_servicio=$_POST['servicio'];
            $fecha=$_POST['fecha'];
            $hora=$_POST['hora'];

            $marca=strtotime($fecha);
            $dia=date('d', $marca);
            $mes=date('m', $marca);
            $anio=date('Y', $marca);

            $fecha_actual=date('Y-m-d');

            $con=conectarServidor();

            $buscar=$con->prepare("select count(*) from citas where socio=? and fecha=? and hora=?");
            $buscar->bind_param("iss",$id_usuario,$fecha,$hora);
            $buscar->execute();
            $buscar->bind_result($num);
            $buscar->fetch();

            $buscar->close();

            if(!checkdate($mes, $dia, $anio)){
                echo "<p>Fecha incorrecta</p>";
            }else if($fecha<$fecha_actual){
                echo "<p>La fecha no puede ser anterior a hoy</p>";
            }else if($num>0){
                echo "<p>Ese usuario ya tiene una cita ese dia a esa hora</p>";
            }else{
                $insertar=$con->prepare("insert into citas values(?,?,?,?)");
                $insertar->bind_param("iiss",$id_usuario,$id_servicio,$fecha,$hora);

                if($insertar->execute()){
                    echo "<p>Cita nueva insertada correctamente</p>";
                }else{
                    echo "<p>ERROR:</p> " . $insertar->error;
                }

                $insertar->close();
            }

            $con->close();
        }

        header("refresh:2; url=citas.php");

    }else if(isset($_POST['borrar_cita'])){
        $socio=$_POST['id_socio'];
        $servicio=$_POST['id_servicio'];
        $fecha=$_POST['fecha'];

        $fecha_actual=date('Y-m-d');

        if($fecha<$fecha_actual){
            echo "<p>No se pueden borrar citas ya pasadas</p>";
        }else if($fecha==$fecha_actual){
            echo "<p>No se pueden borrar citas sin antelacion (1dia)</p>";
        }else{
            $con=conectarServidor();

            if($con->query("delete from citas where socio=$socio and servicio=$servicio and fecha='$fecha'")){
                echo "<p>Cita borrada con éxito</p>";
            }else{
                echo "<p>ERROR: </p>" . $con->error;
            }
            
            $con->close();
        }
        
        header("refresh:2; url=citas.php");
    }else{
        header("Location:../index.php");
    }
?>