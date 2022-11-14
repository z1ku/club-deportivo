<?php
    if(isset($_POST['editar_servicio'])){
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
        header("refresh:2; url=servicios.php");
    }else if(isset($_POST['insertar_servicio'])){
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
        header("refresh:2; url=servicios.php");
    }else{
        header("Location:servicios.php");
    }
?>