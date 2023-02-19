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
    <script type="text/javascript" defer src="../js/noticias.js"></script>
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
            
            <h3>Cambiar de página</h3>
            <div class="paginacionjs">
                <a id="prev" class="pagina-btn" href="">Anterior</a>
                <a id="next" class="pagina-btn" href="">Siguiente</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Titulo</th>
                        <th>Contenido</th>
                        <th>Fecha publicación</th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody id="contenedor_api">

                </tbody>
            </table>

            <div id="cargando">
                <h3>Cargando datos</h3>    
                <progress max="100">Cargando datos</progress>
            </div>

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