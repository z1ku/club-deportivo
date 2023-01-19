<?php
    require_once "funciones.php";

    session_start();

    if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
    }

    $tipo_usu="";
?>

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
    <?php
        if(isset($_SESSION['usuario']) && isset($_SESSION['pass'])){
            $usuario=$_SESSION['usuario'];
            $pass=$_SESSION['pass'];

            $esAdmin=comprobarAdmin($usuario,$pass);
            
            if($esAdmin){
                headerAdmin();
                $tipo_usu="admin";
            }else{
                header("Location:../index.php");
            }
        }else{
            header("Location:../index.php");
        }
    ?>
    <main>
        <section class="seccionNoticias seccion">
            <h1>Listado de Noticias</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="panel_noticias.php" method="post">
                    <input type="submit" name="nueva_noticia" value="Nueva noticia">
                </form>
            </div>
            <?php
                require_once "funciones.php";

                $con=conectarServidor();

                $total=$con->query("select * from noticia");
                $num_total_rows=$total->num_rows;

                if($num_total_rows==0){
                    echo "<p>No hay noticias en la base de datos</p>";
                }else{
                    $page=false;
                    $noticiasPorPagina=4;

                    if(isset($_GET["page"])){
                        $page=$_GET["page"];
                    }

                    if(!$page){
                        $start=0;
                        $page=1;
                    }else{
                        $start=($page-1)*$noticiasPorPagina;
                    }

                    $total_pages=ceil($num_total_rows/$noticiasPorPagina);

                    $noticias=$con->query("select * from noticia limit $start, $noticiasPorPagina");

                    echo '<p>Número de noticias totales: '.$num_total_rows.'</p>';
                    echo '<p>En cada página se muestran '.$noticiasPorPagina.' noticias.</p>';
                    echo '<p>Mostrando la página '.$page.' de ' .$total_pages.' páginas.</p>';

                    echo "<table>
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Titulo</th>
                            <th>Contenido</th>
                            <th>Fecha publicación</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_noticias=$noticias->fetch_array(MYSQLI_ASSOC)){

                        $contenido_short=substr($fila_noticias['contenido'], 0, 50);
                        $fecha=date("d-m-Y",strtotime($fila_noticias['fecha_publicacion']));

                        echo "<tr>
                            <td><img src=\"../img/noticias/$fila_noticias[imagen]\"></td>
                            <td>$fila_noticias[titulo]</td>
                            <td>$contenido_short</td>
                            <td>$fecha</td>
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
                    
                    echo '<nav>';
                    echo '<ul class="paginacion">';
                    if($total_pages>1){
                        if($page!=1){
                            echo '<li><a href="noticias.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
                        }
                        for($i=1;$i<=$total_pages;$i++){
                            if($page == $i){
                                echo '<li><a href="#">'.$page.'</a></li>';
                            }else{
                                echo '<li><a href="noticias.php?page='.$i.'">'.$i.'</a></li>';
                            }
                        }
                        if($page != $total_pages){
                            echo '<li><a href="noticias.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
                        }
                    }
                    echo '</ul>';
                    echo '</nav>';
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