<?php
    function conectarServidor(){
        $con=new mysqli('localhost', 'root', '', 'club');
        $con->set_charset('utf8');

        return $con;
    }

?>