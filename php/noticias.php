<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
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
        <section class="seccionNoticias">
            <h1>Listado de Noticias</h1>
            <div class="contenedor_nueva_noticia">
                <form action="panel_noticias.php" method="post">
                    <input type="submit" name="nueva_noticia" value="Nueva noticia">
                </form>
            </div>
            <?php
                require_once "funciones.php";

                $con=conectarServidor();

                $noticiasPorPagina=4;
                $pagina=1;

                if(isset($_GET['pagina'])){
                    $pagina=$_GET['pagina'];
                }

                $limit=$noticiasPorPagina;
                $offset = ($pagina - 1) * $noticiasPorPagina;

                $sentencia=$con->query("select count(id) from noticia");
                $num=$sentencia->fetch_array(MYSQLI_NUM);
                $conteo=$num[0];

                $paginas=ceil($conteo/$noticiasPorPagina);

                $noticias=$con->query("select * from noticia limit $limit offset $offset");

                if($noticias->num_rows==0){
                    echo "<p>No hay noticias en la base de datos</p>";
                }else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Titulo</th>
                            <th>Contenido</th>
                            <th>Fecha</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_noticias=$noticias->fetch_array(MYSQLI_ASSOC)){

                        $contenido_short=substr($fila_noticias['contenido'], 0, 50);

                        echo "<tr>
                            <td>$fila_noticias[id]</td>
                            <td>$fila_noticias[imagen]</td>
                            <td>$fila_noticias[titulo]</td>
                            <td>$contenido_short</td>
                            <td>$fila_noticias[fecha]</td>
                            <td>
                                <form action=\"noticia_completa.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_noticia\" value=\"$fila_noticias[id]\">
                                    <input type=\"submit\" name=\"ver_noticia\" value=\"Ver\">
                                </form>
                            </td>
                        </tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";

                    echo "<nav>
                        <div class=\"row\">
                            <div class=\"col-xs-12 col-sm-6\">
                                <p>Mostrando $noticiasPorPagina de $conteo productos disponibles</p>
                            </div>
                            <div class=\"col-xs-12 col-sm-6\">
                                <p>Página $pagina de $paginas</p>
                            </div>
                        </div>
                        <ul class=\"pagination\">";
                    if($pagina!=1){
                        echo '<li class="page-item">
                            <a class="page-link" href="index.php?page='.($pagina-1).'"><span aria-hidden="true">&laquo;</span></a>
                        </li>';
                    }
                    for($i=1;$i<=$paginas;$i++){
                        if($i==$pagina){
                            echo '<li class="page-item active">
                                <a class="page-link" href="#">'.$pagina.'</a>
                            </li>';
                        }else{
                            echo '<li class="page-item">
                                <a class="page-link" href="index.php?page='.$i.'">'.$i.'</a>
                            </li>';
                        }
                    }
                    if($pagina!=$paginas){
                        echo '<li class="page-item"><a class="page-link" href="index.php?page='.($pagina+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
                    }
                    echo "</ul>";
                    echo "</nav>";
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