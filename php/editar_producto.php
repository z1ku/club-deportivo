<?php
    if(isset($_POST['editar_producto'])){
        if(strlen($_POST['nombre'])>50){
            echo "<p>Nombre no puede ser mayor a 50</p>";
        }else if($_POST['precio']<0 || $_POST['precio']>999.99){
            echo "<p>Precio inválido</p>";
        }else if($_POST['precio']=="" || $_POST['nombre']==""){
            echo "<p>Debes rellenar todos los campos</p>";
        }else{
            require_once "funciones.php";

            $id=$_POST['id'];
            $nombre=$_POST['nombre'];
            $precio=$_POST['precio'];

            $con=conectarServidor();
            $sentencia=$con->prepare("update producto set nombre=?, precio=? where id=?");
            $sentencia->bind_param("sdi", $nombre,$precio,$id);

            if($sentencia->execute()){
                echo "<p>Producto editado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $sentencia->error;
            }

            $sentencia->close();
            $con->close();
        }

        header("refresh:2; url=productos.php");
    }else if(isset($_POST['eliminar_producto'])){
        require_once "funciones.php";

        $id=$_POST['id_producto'];

        $con=conectarServidor();

        $sentencia="delete from producto where id=$id";

        if($con->query($sentencia)){
            echo "<p>Producto eliminado correctamente</p>";
        }else{
            echo "<p>ERROR:</p> " . $con->error;
        }

        $con->close();
        header("refresh:2; url=productos.php");
    }else if(isset($_POST['insertar_producto'])){
        if(strlen($_POST['nombre'])>50){
            echo "<p>Nombre no puede ser mayor a 50</p>";
        }else if($_POST['precio']<0 || $_POST['precio']>999.99){
            echo "<p>Precio inválido</p>";
        }else if($_POST['precio']=="" || $_POST['nombre']==""){
            echo "<p>Debes rellenar todos los campos</p>";
        }else{
            require_once "funciones.php";

            $nombre=$_POST['nombre'];
            $precio=$_POST['precio'];

            $con=conectarServidor();

            $insertar=$con->prepare("insert into producto values(null,?,?)");
            $insertar->bind_param("sd", $nombre,$precio);

            if($insertar->execute()){
                echo "<p>Producto nuevo insertado correctamente</p>";
            }else{
                echo "<p>ERROR:</p> " . $insertar->error;
            }

            $insertar->close();
            $con->close();
        }
        
        header("refresh:2; url=productos.php");
    }else{
        header("Location:productos.php");
    }
?>