<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socios</title>
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
        <section class="seccionSocios">
            <h1>Listado de Socios</h1>
            <?php
                require_once "funciones.php";
                $con=conectarServidor();

                $socios=$con->query("select * from socio");

                if($socios->num_rows==0){
                    echo "<p>Aún no hay socios en la base de datos</p>";
                }else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Telefono</th>
                            <th>Modificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_socios=$socios->fetch_array(MYSQLI_ASSOC)){
                        echo "<tr>
                            <td>$fila_socios[id]</td>
                            <td><img src=\"../img/socios/$fila_socios[foto]\"></td>
                            <td>$fila_socios[nombre]</td>
                            <td>$fila_socios[edad]</td>
                            <td>$fila_socios[usuario]</td>
                            <td>$fila_socios[pass]</td>
                            <td>$fila_socios[telefono]</td>
                            <td>
                                <form action=\"panel_socios.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_socio\" value=\"$fila_socios[id]\">
                                    <input type=\"submit\" name=\"editar_socio\" value=\"Editar\">
                                </form>
                            </td>
                            <td>
                                <form action=\"editar_socio.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_socio\" value=\"$fila_socios[id]\">
                                    <input type=\"hidden\" name=\"foto_socio\" value=\"$fila_socios[foto]\">
                                    <input type=\"submit\" name=\"eliminar_socio\" value=\"Eliminar\">
                                </form>
                            </td>
                        </tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                
                $con->close();
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