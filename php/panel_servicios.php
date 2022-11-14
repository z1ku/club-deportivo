<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Servicios</title>
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
        <section id="panel_servicios">
            <h1>Panel Servicios</h1>
            <?php
                if(isset($_POST["editar_servicio"])){

                    require_once "funciones.php";

                    $id_servicio=$_POST['id_servicio'];
                    
                    $con=conectarServidor();
                    $datos=$con->query("select * from servicio where id=$id_servicio");
                    $servicio=$datos->fetch_array(MYSQLI_ASSOC);

                    echo "<h2>Editar Servicio</h2>";
                    echo "<form action=\"editar_servicio.php\" method=\"post\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$servicio[id]\" readonly>
                    </div>
                    <div>
                        <label for=\"descripcion\">Descripción:</label>
                        <input type=\"text\" name=\"descripcion\" value=\"$servicio[descripcion]\">
                    </div>
                    <div>
                        <label for=\"duracion\">Duración:</label>
                        <input type=\"number\" name=\"duracion\" value=\"$servicio[duracion]\" min=\"0\">
                    </div>
                    <div>
                        <label for=\"precio\">Precio:</label>
                        <input type=\"number\" name=\"precio\" value=\"$servicio[precio]\" min=\"0\" step=\"0.01\">
                    </div>
                    <input type=\"submit\" name=\"editar_servicio\" value=\"Guardar\">
                    </form>";
                    
                    $con->close();
                }else if(isset($_POST["nuevo_servicio"])){
                    
                    require_once "funciones.php";
                    $con=conectarServidor();

                    $sentencia="select auto_increment from information_schema.tables where table_schema='club' and table_name='servicio'";
                    $resultado=$con->query($sentencia);

                    $fila=$resultado->fetch_array(MYSQLI_NUM);
                    $id=$fila[0];
                    
                    echo "<h2>Nuevo servicio</h2>";
                    echo "<form action=\"editar_servicio.php\" method=\"post\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$id\" readonly>
                    </div>
                    <div>
                        <label for=\"descripcion\">Descripción:</label>
                        <input type=\"text\" name=\"descripcion\" required>
                    </div>
                    <div>
                        <label for=\"duracion\">Duración:</label>
                        <input type=\"number\" name=\"duracion\" min=\"0\" required>
                    </div>
                    <div>
                        <label for=\"precio\">Precio:</label>
                        <input type=\"number\" name=\"precio\" min=\"0\" step=\"0.01\" required>
                    </div>
                    <input type=\"submit\" name=\"insertar_servicio\" value=\"Guardar\">
                    </form>";

                    $con->close();
                }else{
                    header("Location:servicios.php");
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