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
    <section class="seccionProductos">
            <h1>Listado de Productos</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_producto" value="Buscar">
                    <a href="productos.php">Reset</a>
                </form>
                <form action="panel_productos.php" method="post">
                    <input type="submit" name="nuevo_producto" value="Nuevo producto">
                </form>
            </div>
            <?php
                require_once "funciones.php";
                $con=conectarServidor();

                $productos=$con->query("select * from producto");

                if($productos->num_rows==0){
                    echo "<p>No hay productos en la base de datos</p>";
                }else if(isset($_POST['buscar_producto'])){
                    $cadena=$_POST['cadena'];
                    $param="%$cadena%";

                    $buscar=$con->prepare("select * from producto where nombre like ? or precio like ?");
                    $buscar->bind_result($id,$nombre,$precio);
                    $buscar->bind_param("ss",$param,$param);
                    $buscar->execute();
                    $buscar->store_result();
                    
                    if($buscar->num_rows==0){
                        echo "<p>No se han encontrado coincidencias</p>";
                    }else{
                        echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>";
                        while($buscar->fetch()){
                            echo "<tr>
                                <td>$id</td>
                                <td>$nombre</td>
                                <td>$precio €</td>
                                <td>
                                    <form action=\"panel_productos.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_producto\" value=\"$id\">
                                        <input type=\"submit\" name=\"editar_producto\" value=\"Editar\">
                                    </form>
                                </td>
                                <td>
                                    <form action=\"editar_producto.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_producto\" value=\"$id\">
                                        <input type=\"submit\" name=\"eliminar_producto\" value=\"Eliminar\">
                                    </form>
                                </td>
                            </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }

                    $buscar->close();
                }else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_productos=$productos->fetch_array(MYSQLI_ASSOC)){
                        echo "<tr>
                            <td>$fila_productos[id]</td>
                            <td>$fila_productos[nombre]</td>
                            <td>$fila_productos[precio] €</td>
                            <td>
                                <form action=\"panel_productos.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_producto\" value=\"$fila_productos[id]\">
                                    <input type=\"submit\" name=\"editar_producto\" value=\"Editar\">
                                </form>
                            </td>
                            <td>
                                <form action=\"editar_producto.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_producto\" value=\"$fila_productos[id]\">
                                    <input type=\"submit\" name=\"eliminar_producto\" value=\"Eliminar\">
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