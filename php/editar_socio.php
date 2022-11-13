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

            $con=conectarServidor();
            $sentencia=$con->prepare("update socio set nombre=?, edad=?, usuario=?, pass=?, telefono=?, foto=? where id=?");

            $sentencia->bind_param("sissisi",$nombre,$edad,$usuario,$pass,$telefono,$foto,$id);

            if($sentencia->execute()){
                if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                    if(file_exists("../img/socios/$usuario_antiguo.jpg")){
                        unlink("../img/socios/$usuario_antiguo.jpg");
                    }
                    move_uploaded_file($_FILES['foto']['tmp_name'], "../img/socios/$usuario.jpg");
                }else{
                    rename("../img/socios/$usuario_antiguo.jpg", "../img/socios/$usuario.jpg");
                }
                echo "<p>Socio editado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $sentencia->error;
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
            unlink("../img/socios/$foto");
            echo "<p>Socio eliminado correctamente</p>";
        }else{
            echo "<p>ERROR:</p> " . $con->error;
        }

        $con->close();
        header("refresh:2; url=socios.php");

    }else if(isset($_POST['insertar_socio'])){
        require_once "funciones.php";

        $nombre=$_POST['nombre'];
        $edad=$_POST['edad'];
        $usuario=$_POST['usuario'];
        $pass=$_POST['pass'];
        $telefono=$_POST['telefono'];
        $foto=$usuario.".jpg";

        $con=conectarServidor();

        $buscar=$con->prepare("select count(id) from socio where usuario=?");
        $buscar->bind_param("s", $usuario);
        $buscar->execute();
        $buscar->bind_result($num);
        $buscar->fetch();

        if($num>0){
            echo "<p>Ese nombre de usuario ya existe</p>";
        }else if($_FILES['foto']['type']!="image/jpeg"){
            echo "<p>La foto no es un jpg</p>";
        }else if(!preg_match("`[6789][0-9]{8}`", $_POST['telefono'])){
            echo "<p>No es un número de teléfono válido</p>";
        }else{
            $insertar=$con->prepare("insert into socio values(null,?,?,?,?,?,?)");
            $insertar->bind_param("sissis", $nombre,$edad,$usuario,$pass,$telefono,$foto);

            if($insertar->execute()){
                move_uploaded_file($_FILES['foto']['tmp_name'], "../img/socios/$usuario.jpg");
                echo "<p>Socio nuevo insertado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $insertar->error;
            }

            $insertar->close();
        }
        
        $buscar->close();
        $con->close();
        header("refresh:2; url=socios.php");
    }else{
        header("Location:socios.php");
    }
?>