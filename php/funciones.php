<?php
    function conectarServidor(){
        $con=new mysqli('localhost', 'root', '', 'club');
        $con->set_charset('utf8');

        return $con;
    }

    // FUNCIONES PARA HEADER
    function headerIndexGuest(){
        echo '<header>
            <nav>
                <a href="index.php"><img src="img/logo.png" alt="" id="logo"></a>
                <a href="index.php">Inicio</a>
                <a href="php/productos.php">Productos</a>
                <a href="php/servicios.php">Servicios</a>
            </nav>
            <div class="rrss">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="login">
                <form action="" method="post">
                    <input type="submit" name="enviar" id="btn-login" value="Login">
                </form>
            </div>
        </header>';
    }
?>