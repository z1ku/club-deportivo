<?php
    session_start();

    if(isset($_POST['editar_socio'])){

        if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
            echo "<p>La foto no es un jpg</p>";
            header("refresh:2; url=socios.php");
        }else if(!preg_match("`[6789][0-9]{8}`", $_POST['telefono'])){
            echo "<p>No es un número de teléfono válido</p>";
            header("refresh:2; url=socios.php");
        }else if($_POST['nombre']=="" || $_POST['edad']=="" || $_POST['usuario']=="" || $_POST['telefono']==""){
            echo "<p>No pueden haber campos vacios</p>";
            header("refresh:2; url=socios.php");
        }else if(strlen($_POST['nombre'])>50){
            echo "<p>Nombre no puede ser mayor a 50</p>";
            header("refresh:2; url=socios.php");
        }else if($_POST['edad']<0 || $_POST['edad']>99){
            echo "<p>Edad no válida</p>";
            header("refresh:2; url=socios.php");
        }else if(strlen($_POST['usuario'])>15){
            echo "<p>Usuario no puede ser mayor de 15</p>";
            header("refresh:2; url=socios.php");
        }else if(strlen($_POST['pass'])>15){
            echo "<p>Pass no puede ser mayor de 15</p>";
            header("refresh:2; url=socios.php");
        }else{
            require_once "funciones.php";

            $con=conectarServidor();

            $id=$_POST['id'];
            $nombre=$_POST['nombre'];
            $edad=$_POST['edad'];
            $usuario=$_POST['usuario'];

            if($_POST['pass']!=""){
                $pass=md5(md5($_POST['pass']));
            }else{
                $buscar_pass=$con->query("select pass from socio where id=$id");
                $fila_pass=$buscar_pass->fetch_array(MYSQLI_ASSOC);
                $pass=$fila_pass['pass'];
            }

            $telefono=$_POST['telefono'];
            $foto=$usuario.".jpg";

            $usuario_antiguo=$_POST['usuario_antiguo'];

            $buscar=$con->prepare("select count(id) from socio where usuario=?");
            $buscar->bind_param("s", $usuario);
            $buscar->execute();
            $buscar->bind_result($num);
            $buscar->fetch();

            $buscar->close();

            if($num>0 && $usuario!=$usuario_antiguo){
                echo "<p>Ese nombre de usuario ya existe</p>";
            }else{
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
            }

            $con->close();
            header("refresh:2; url=socios.php");
        }

    }else if(isset($_POST['insertar_socio'])){

        if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
            echo "<p>La foto no es un jpg</p>";
            header("refresh:2; url=socios.php");
        }else if(!preg_match("`[6789][0-9]{8}`", $_POST['telefono'])){
            echo "<p>No es un número de teléfono válido</p>";
            header("refresh:2; url=socios.php");
        }else if($_POST['nombre']=="" || $_POST['edad']=="" || $_POST['usuario']=="" || $_POST['pass']=="" || $_POST['telefono']==""){
            echo "<p>No pueden haber campos vacios</p>";
            header("refresh:2; url=socios.php");
        }else if(strlen($_POST['nombre'])>50){
            echo "<p>Nombre no puede ser mayor a 50</p>";
            header("refresh:2; url=socios.php");
        }else if($_POST['edad']<0 || $_POST['edad']>99){
            echo "<p>Edad no válida</p>";
            header("refresh:2; url=socios.php");
        }else if(strlen($_POST['usuario'])>15){
            echo "<p>Usuario no puede ser mayor de 15</p>";
            header("refresh:2; url=socios.php");
        }else if(strlen($_POST['pass'])>15){
            echo "<p>Pass no puede ser mayor de 15</p>";
            header("refresh:2; url=socios.php");
        }else if(!is_uploaded_file($_FILES['foto']['tmp_name'])){
            echo "<p>Debes subir una foto jpg</p>";
            header("refresh:2; url=socios.php");
        }else{
            require_once "funciones.php";

            $nombre=$_POST['nombre'];
            $edad=$_POST['edad'];
            $usuario=$_POST['usuario'];
            $pass=md5(md5($_POST['pass']));
            $telefono=$_POST['telefono'];
            $foto=$usuario.".jpg";

            $con=conectarServidor();

            $buscar=$con->prepare("select count(id) from socio where usuario=?");
            $buscar->bind_param("s", $usuario);
            $buscar->execute();
            $buscar->bind_result($num);
            $buscar->fetch();

            $buscar->close();

            if($num>0){
                echo "<p>Ese nombre de usuario ya existe</p>";
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
            
            $con->close();
        }

        header("refresh:2; url=socios.php");
    }else if(isset($_POST['editar_mis_datos'])){

        if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
            echo "<p>La foto no es un jpg</p>";
            header("refresh:2; url=datos_personales.php");
        }else if(!preg_match("`[6789][0-9]{8}`", $_POST['telefono'])){
            echo "<p>No es un número de teléfono válido</p>";
            header("refresh:2; url=datos_personales.php");
        }else if($_POST['nombre']=="" || $_POST['edad']=="" || $_POST['usuario']=="" || $_POST['telefono']==""){
            echo "<p>No pueden haber campos vacios</p>";
            header("refresh:2; url=datos_personales.php");
        }else if(strlen($_POST['nombre'])>50){
            echo "<p>Nombre no puede ser mayor a 50</p>";
            header("refresh:2; url=datos_personales.php");
        }else if($_POST['edad']<0 || $_POST['edad']>99){
            echo "<p>Edad no válida</p>";
            header("refresh:2; url=datos_personales.php");
        }else if(strlen($_POST['usuario'])>15){
            echo "<p>Usuario no puede ser mayor de 15</p>";
            header("refresh:2; url=datos_personales.php");
        }else if(strlen($_POST['pass'])>15){
            echo "<p>Pass no puede ser mayor de 15</p>";
            header("refresh:2; url=datos_personales.php");
        }else{
            require_once "funciones.php";

            $con=conectarServidor();

            $id=$_POST['id'];
            $nombre=$_POST['nombre'];
            $edad=$_POST['edad'];
            $usuario=$_POST['usuario'];
            
            if($_POST['pass']!=""){
                $pass=md5(md5($_POST['pass']));
                $_SESSION['pass']=$pass;
            }else{
                $buscar_pass=$con->query("select pass from socio where id=$id");
                $fila_pass=$buscar_pass->fetch_array(MYSQLI_ASSOC);
                $pass=$fila_pass['pass'];
            }

            $telefono=$_POST['telefono'];
            $foto=$usuario.".jpg";

            $usuario_antiguo=$_POST['usuario_antiguo'];

            $buscar=$con->prepare("select count(id) from socio where usuario=?");
            $buscar->bind_param("s", $usuario);
            $buscar->execute();
            $buscar->bind_result($num);
            $buscar->fetch();

            $buscar->close();

            if($num>0 && $usuario!=$usuario_antiguo){
                echo "<p>Ese nombre de usuario ya existe</p>";
            }else{
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
                    echo "<p>Datos personales editados correctamente</p>";
                }else{
                    echo "<p>ERROR:</p> " . $sentencia->error;
                }

                $sentencia->close();
            }

            $con->close();
            header("refresh:2; url=datos_personales.php");
        }
    }else{
        header("Location:../index.php");
    }
?>