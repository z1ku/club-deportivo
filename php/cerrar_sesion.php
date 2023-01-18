<?php
    if(isset($_POST['desconectar'])){
        session_start();
        session_destroy();
        setcookie('sesion', null, -1, '/');
        header("Location:../index.php");
    }else{
        header("Location:../index.php");
    }
?>