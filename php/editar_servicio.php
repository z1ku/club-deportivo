<?php
    if(isset($_POST['editar_servicio'])){
        if($_POST['descripcion']=="" || $_POST['duracion']=="" || $_POST['precio']==""){
            echo "<p>No puede haber campos vacíos</p>";
        }else if(strlen($_POST['descripcion'])>80){
            echo "<p>Descripción no puede ser mayor a 80</p>";
        }else if($_POST['duracion']<0 || $_POST['duracion']>999){
            echo "<p>Duración no válida</p>";
        }else if($_POST['precio']<0 || $_POST['precio']>999.99){
            echo "<p>Precio no válido</p>";
        }else{
            require_once "funciones.php";

            $id=$_POST['id'];
            $descripcion=$_POST['descripcion'];
            $duracion=$_POST['duracion'];
            $precio=$_POST['precio'];

            $con=conectarServidor();
            $sentencia=$con->prepare("update servicio set descripcion=?, duracion=?, precio=? where id=$id");
            $sentencia->bind_param("sid", $descripcion,$duracion,$precio);

            if($sentencia->execute()){
                echo "<p>Servicio editado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $sentencia->error;
            }
            
            $sentencia->close();
            $con->close();
        }

        header("refresh:2; url=servicios.php");
    }else if(isset($_POST['insertar_servicio'])){
        if($_POST['descripcion']=="" || $_POST['duracion']=="" || $_POST['precio']==""){
            echo "<p>No puede haber campos vacíos</p>";
        }else if(strlen($_POST['descripcion'])>80){
            echo "<p>Descripción no puede ser mayor a 80</p>";
        }else if($_POST['duracion']<0 || $_POST['duracion']>999){
            echo "<p>Duración no válida</p>";
        }else if($_POST['precio']<0 || $_POST['precio']>999.99){
            echo "<p>Precio no válido</p>";
        }else{
            require_once "funciones.php";

            $descripcion=$_POST['descripcion'];
            $duracion=$_POST['duracion'];
            $precio=$_POST['precio'];

            $con=conectarServidor();

            $insertar=$con->prepare("insert into servicio values(null,?,?,?)");
            $insertar->bind_param("sid", $descripcion,$duracion,$precio);

            if($insertar->execute()){
                echo "<p>Servicio nuevo insertado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $insertar->error;
            }

            $insertar->close();
            $con->close();
        }
        
        header("refresh:2; url=servicios.php");
    }else{
        header("Location:../index.php");
    }
?>