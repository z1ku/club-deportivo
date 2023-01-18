<?php
    //FUNCION PARA CONECTAR A LA BASE DE DATOS
    function conectarServidor(){
        $con=new mysqli('localhost', 'root', '', 'club');
        $con->set_charset('utf8');

        return $con;
    }

    // FUNCIONES PARA HEADER
    ////////////////////////////////////////////////////////////////////
    //HEADER INDEX INVITADO
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
                <form action="php/login.php" method="post">
                    <input type="submit" name="enviar" id="btn-login" value="Login">
                </form>
            </div>
        </header>';
    }

    //HEADER INDEX ADMIN
    function headerIndexAdmin(){
        echo '<header>
            <nav>
                <a href="index.php"><img src="img/logo.png" alt="" id="logo"></a>
                <a href="index.php">Inicio</a>
                <a href="php/socios.php">Socios</a>
                <a href="php/productos.php">Productos</a>
                <a href="php/servicios.php">Servicios</a>
                <a href="php/testimonios.php">Testimonios</a>
                <a href="php/noticias.php">Noticias</a>
                <a href="php/citas.php">Citas</a>
            </nav>
            <div class="rrss">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="login">
                <form action="php/cerrar_sesion.php" method="post">
                    <input type="submit" name="desconectar" id="btn-login" value="Cerrar sesión de Administrador">
                </form>
            </div>
        </header>';
    }

    //HEADER INDEX SOCIO
    function headerIndexSocio($usuario){
        echo '<header>
            <nav>
                <a href="index.php"><img src="img/logo.png" alt="" id="logo"></a>
                <a href="index.php">Inicio</a>
                <a href="php/productos.php">Productos</a>
                <a href="php/servicios.php">Servicios</a>
                <a href="php/datos_personales.php">Mis datos personales</a>
                <a href="php/mis_citas.php">Mis citas</a>
            </nav>
            <div class="rrss">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="login">
                <form action="php/cerrar_sesion.php" method="post">
                    <input type="submit" name="desconectar" id="btn-login" value="Cerrar sesión de '.$usuario.'">
                </form>
            </div>
        </header>';
    }

    //HEADER DEFAULT INVITADO
    function headerGuest(){
        echo '<header>
            <nav>
                <a href="../index.php"><img src="img/logo.png" alt="" id="logo"></a>
                <a href="../index.php">Inicio</a>
                <a href="productos.php">Productos</a>
                <a href="servicios.php">Servicios</a>
            </nav>
            <div class="rrss">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="login">
                <form action="login.php" method="post">
                    <input type="submit" name="enviar" id="btn-login" value="Login">
                </form>
            </div>
        </header>';
    }

    //HEADER DEFAULT ADMIN
    function headerAdmin(){
        echo '<header>
            <nav>
                <a href="../index.php"><img src="img/logo.png" alt="" id="logo"></a>
                <a href="../index.php">Inicio</a>
                <a href="socios.php">Socios</a>
                <a href="productos.php">Productos</a>
                <a href="servicios.php">Servicios</a>
                <a href="testimonios.php">Testimonios</a>
                <a href="noticias.php">Noticias</a>
                <a href="citas.php">Citas</a>
            </nav>
            <div class="rrss">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="login">
                <form action="cerrar_sesion.php" method="post">
                    <input type="submit" name="desconectar" id="btn-login" value="Cerrar sesión de Administrador">
                </form>
            </div>
        </header>';
    }

    //HEADER DEFAULT SOCIO
    function headerSocio($usuario){
        echo '<header>
            <nav>
                <a href="../index.php"><img src="img/logo.png" alt="" id="logo"></a>
                <a href="../index.php">Inicio</a>
                <a href="productos.php">Productos</a>
                <a href="servicios.php">Servicios</a>
                <a href="datos_personales.php">Mis datos personales</a>
                <a href="mis_citas.php">Mis citas</a>
            </nav>
            <div class="rrss">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="login">
                <form action="cerrar_sesion.php" method="post">
                    <input type="submit" name="desconectar" id="btn-login" value="Cerrar sesión de '.$usuario.'">
                </form>
            </div>
        </header>';
    }




?>