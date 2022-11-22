<?php
    if(isset($_POST['insertar_testimonio'])){
        require_once "funciones.php";

        $autor=$_POST['autor'];
        $contenido=$_POST['contenido'];
        $fecha=date('Y-m-d');

        $con=conectarServidor();

        $insertar=$con->prepare("insert into testimonio values(null,?,?,?)");
        $insertar->bind_param("iss",$autor,$contenido,$fecha);

        if($insertar->execute()){
            echo "<p>Testimonio nuevo insertado correctamente</p>";
        }else{
            echo "<p>ERROR:</p> " . $insertar->error;
        }
        
        $insertar->close();
        $con->close();
        header("refresh:2; url=testimonios.php");
    }else{
        header("Location:testimonios.php");
    }
?>