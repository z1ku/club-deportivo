<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <img src="img/logo.png" alt="" id="logo">
        <nav>
            <a href="">Socios</a>
            <a href="">Productos</a>
            <a href="">Servicios</a>
            <a href="">Testimonios</a>
            <a href="">Noticias</a>
            <a href="">Citas</a>
        </nav>
    </header>
    <main>
        <section>
            <h1>Bienvenido a Olympia Gym</h1>  
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
                // require_once "php/funciones.php";
                // $con=conectarServidor();

                // $max=$con->query("select count(id) from testimonio");
                // $random=mt_rand(0,$max);
                
                // $resultado=$con->query("select * from testimonio where id=$random");
                
                // $fila=$resultado->fetch_array(MYSQLI_ASSOC);

                // echo "<div>
                //     <p>$fila[contenido]</p>
                //     <p>$fila[autor]</p>
                // </div>";
                
                // $con->close();
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
        <span>DESARROLLADO POR RICARDO ROMERO BUSTOS</span>
    </footer>
</body>
</html>