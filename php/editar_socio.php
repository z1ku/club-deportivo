<?php
    if(isset($_POST['editar_socio'])){

        if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
            echo "<p>La foto no es un jpg</p>";
            header("refresh:2; url=socios.php");
        }else if(!preg_match("`[6789][0-9]{8}`", $_POST['telefono'])){
            echo "<p>No es un número de teléfono válido</p>";
            header("refresh:2; url=socios.php");
        }else{
            require_once "funciones.php";

            $id=$_POST['id'];
            $nombre=$_POST['nombre'];
            $edad=$_POST['edad'];
            $usuario=$_POST['usuario'];
            $pass=$_POST['pass'];
            $telefono=$_POST['telefono'];
            $foto=$usuario.".jpg";

            $usuario_antiguo=$_POST['usuario_antiguo'];

            if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                if(file_exists("../img/socios/$usuario_antiguo.jpg")){
                    unlink("../img/socios/$usuario_antiguo.jpg");
                }
                move_uploaded_file($_FILES['foto']['tmp_name'], "../img/socios/$usuario.jpg");
            }else{
                rename("../img/socios/$usuario_antiguo.jpg", "../img/socios/$usuario.jpg");
            }

            $con=conectarServidor();
            $sentencia=$con->prepare("update socio set nombre=?, edad=?, usuario=?, pass=?, telefono=?, foto=? where id=?");

            $sentencia->bind_param("sissisi",$nombre,$edad,$usuario,$pass,$telefono,$foto,$id);

            if($sentencia->execute()){
                echo "<p>Socio editado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $con->error;
            }

            $sentencia->close();
            $con->close();
            header("refresh:2; url=socios.php");
        }
    }else if(isset($_POST['eliminar_socio'])){
        require_once "funciones.php";

        $id=$_POST['id_socio'];
        $foto=$_POST['foto_socio'];

        $con=conectarServidor();
        $sentencia="delete from socio where id=$id";

        if($con->query($sentencia)){
            echo "<p>Socio eliminado correctamente</p>";
            unlink("../img/socios/$foto");
        }else{
            echo "<p>ERROR:</p> " . $con->error;
        }

        $con->close();
        header("refresh:2; url=socios.php");
    }else{
        header("Location:socios.php");
    }
?>