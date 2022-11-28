<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Citas</title>
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
        <section id="panel_citas" class="panel_admin">
            <h1>Panel Citas</h1>
            <?php
                if(isset($_POST["nueva_cita"])){
                    require_once "funciones.php";
                    $con=conectarServidor();

                    $sentencia="select auto_increment from information_schema.tables where table_schema='club' and table_name='citas'";
                    $resultado=$con->query($sentencia);

                    $fila=$resultado->fetch_array(MYSQLI_NUM);
                    $id=$fila[0];

                    $socios=$con->query("select id,usuario from socio");
                    $servicios=$con->query("select id,descripcion from servicio");
                    
                    echo "<h2>Nueva cita</h2>";
                    echo "<form action=\"editar_citas.php\" method=\"post\">
                    <div>
                        <label for=\"usuario\">Usuario:</label>
                        <select name=\"usuario\" required>";
                        while($fila_socios=$socios->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value=\"$fila_socios[id]\">$fila_socios[usuario]</option>";
                        }
                    echo "</select>
                    </div>
                    <div>
                        <label for=\"servicio\">Servicio:</label>
                        <select name=\"servicio\" required>";
                        while($fila_servicios=$servicios->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value=\"$fila_servicios[id]\">$fila_servicios[descripcion]</option>";
                        }
                    echo "</select>
                    </div>
                    <div>
                        <label for=\"fecha\">Fecha:</label>
                        <input type=\"date\" name=\"fecha\" required>
                    </div>
                    <div>
                        <label for=\"hora\">Hora:</label>
                        <input type=\"time\" name=\"hora\" required>
                    </div>
                    <input type=\"submit\" name=\"insertar_cita\" value=\"Guardar\">
                    </form>";
                    
                    $con->close();
                }else{
                    header("Location:citas.php");
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