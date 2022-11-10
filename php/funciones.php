<?php
    function conectarServidor(){
        $con=new mysqli('localhost', 'root', '', 'club');
        $con->set_charset('utf8');

        return $con;
    }

    //PARA SABER CUAL ES EL PROXIMO ID QUE SE VA A CREAR
    //select auto_increment from information_schema.tables
    //where table_schema='nombre_base_datos' and table_name='nombre_tabla';

?>