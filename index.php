<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav>
            <a href="index.php"><img src="img/logo.png" alt="" id="logo"></a>
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
            <form action="" method="post">
                <div>
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario">
                </div>
                <div>
                    <label for="pass">Contraseña:</label>
                    <input type="password" name="pass">
                </div>
                <input type="submit" name="enviar" id="btn-login">
            </form>
        </div>
    </header>
    <main>
        <section id="bienvenida">
            <h1>Olympia Gym</h1>
            <span>El mejor club deportivo de tu ciudad</span>
            <button>Únete ahora</button>
        </section>
        <section>
            <h2>Últimas noticias</h2>
            <?php
                //para sacar las 3 ultimas noticias
                //select * from noticia where .... limit 3,2

            ?>
        </section>
        <section>
            <h2>Testimonios</h2>
            <?php
                require_once "php/funciones.php";
                $con=conectarServidor();

                $consulta=$con->query("select count(id) from testimonio");
                $num=$consulta->fetch_array(MYSQLI_NUM);

                $id=mt_rand(1,$num[0]);

                $datos=$con->query("select * from testimonio where id=$id");
                $fila=$datos->fetch_array(MYSQLI_ASSOC);
                
                if($num[0]>0){
                    echo "<div class=\"testimonio_random\">
                        <p>\"$fila[contenido]\"</p>
                        <p>$fila[autor]</p>
                    </div>";
                }else{
                    echo "<p>Aún no hay testimonios en la base de datos</p>";
                }
                
                $con->close();
            ?>
        </section>
        <section>
            <h2>Contacto</h2>
            <form action="" method="post">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre">
                </div>
                <div>
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo">
                </div>
                <label for="mensaje">Mensaje:</label>
                <textarea name="mensaje" cols="30" rows="10"></textarea>
                <input type="submit" name="enviar">
            </form>
        </section>
    </main>
    <footer>
        <div>
            <a href="#">Política de privacidad</a>
            <a href="#">Condiciones</a>
            <a href="#">Contacto</a>
        </div>
        <span>DESARROLLADO POR RICARDO ROMERO BUSTOS</span>
    </footer>
</body>
</html>