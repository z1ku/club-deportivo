<?php
    if(isset($_POST['insertar_noticia'])){

        if($_POST['titulo']=="" || $_POST['contenido']=="" || $_POST['fecha']==""){
            echo "<p>Debes de rellenar todos los campos y subir una imagen jpeg</p>";
        }else if(!is_uploaded_file($_FILES['imagen']['tmp_name'])){
            echo "<p>Debes subir una imagen jpg</p>";
        }else if(strlen($_POST['titulo'])>80){
            echo "<p>Titulo no puede ser mayor de 80</p>";
        }else if(strlen($_POST['contenido'])>800){
            echo "<p>Contenido no puede ser mayor de 800</p>";
        }else{
            $fecha=$_POST['fecha'];
            $marca=strtotime($fecha);
            $dia=date('d', $marca);
            $mes=date('m', $marca);
            $anio=date('Y', $marca);

            $fecha_actual=date('Y-m-d');

            if(!checkdate($mes, $dia, $anio)){
                echo "<p>Fecha incorrecta</p>";
                header("refresh:2; url=noticias.php");
            }

            if($_FILES['imagen']['type']!="image/jpeg"){
                echo "<p>Debes subir una imagen jpg</p>";
            }else if($fecha<$fecha_actual){
                echo "<p>La fecha no puede ser anterior a hoy</p>";
            }else{
                require_once "funciones.php";

                $con=conectarServidor();

                $titulo=$_POST['titulo'];
                $contenido=$_POST['contenido'];
                $imagen=$_POST['id'].".jpg";

                $insertar=$con->prepare("insert into noticia values(null,?,?,?,?)");
                $insertar->bind_param("ssss", $titulo,$contenido,$imagen,$fecha);

                if($insertar->execute()){
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../img/noticias/$imagen");
                    echo "<p>Noticia nueva insertada correctamente</p>";
                }else{
                    echo "<p>ERROR:</p> " . $insertar->error;
                }

                $insertar->close();
                $con->close();
            }
        }
        
        header("refresh:2; url=noticias.php");
    }else{
       header("Location:../index.php");
    }
?>