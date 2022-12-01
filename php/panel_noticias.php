<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Noticias</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav>
            <a href="../index.php"><img src="../img/logo.png" alt="" id="logo"></a>
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
            <form action="" method="post">
                <input type="submit" name="enviar" id="btn-login" value="Login">
            </form>
        </div>
    </header>
    <main>
        <section id="panel_noticias" class="panel_admin">
            <h1>Panel Noticias</h1>
            <a href="noticias.php">Volver</a>
            <?php
                if(isset($_POST["nueva_noticia"])){
                    require_once "funciones.php";
                    $con=conectarServidor();

                    $sentencia="select auto_increment from information_schema.tables where table_schema='club' and table_name='noticia'";
                    $resultado=$con->query($sentencia);

                    $fila=$resultado->fetch_array(MYSQLI_NUM);
                    $id=$fila[0];
                    
                    echo "<h2>Nueva noticia</h2>";
                    echo "<form action=\"editar_noticia.php\" method=\"post\" enctype=\"multipart/form-data\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$id\" readonly>
                    </div>
                    <div>
                        <label for=\"titulo\">Titulo:</label>
                        <input type=\"text\" name=\"titulo\" maxlength=\"80\" required>
                    </div>
                    <div>
                        <label for=\"contenido\">Contenido:</label>
                        <textarea name=\"contenido\" cols=\"50\" rows=\"30\" maxlength=\"800\" required></textarea>
                    </div>
                    <div>
                        <label for=\"fecha\">¿A partir de que fecha quieres que se publique?</label>
                        <input type=\"date\" name=\"fecha\" required>
                    </div>
                    <div>
                        <label for=\"imagen\">Subir imagen en jpg:</label>
                        <input type=\"file\" name=\"imagen\" accept=\"image/jpeg\" required>
                    </div>
                    <input type=\"submit\" name=\"insertar_noticia\" value=\"Guardar\">
                    </form>";
                    
                    $con->close();
                }else{
                    header("Location:noticias.php");
                }
            ?>
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