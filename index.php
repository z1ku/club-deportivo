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
                <input type="submit" name="enviar" id="btn-login" value="Login">
            </form>
        </div>
    </header>
    <main>
        <section id="bienvenida">
            <h1>Olympia Gym</h1>
            <span>El mejor club deportivo de tu ciudad</span>
            <button>Únete ahora</button>
        </section>
        <section id="descripcion">
            <h2>Gimnasio de Última Generación</h2>
            <div class="contenedorDescripcion">
                <div>
                    <p>
                        Olympia Gym – Gimnasio en Armilla. Un club situado en el centro comercial Nevada Shopping.
                    </p>
                    <p>
                        Más de 2.400 m2 a tu disposición con actividades y servicios como Musculación guiada y libre, Cardio Conectado, Cycle Park, Clases Colectivas con Coach o virtuales, espacio Cross Training, espacio BURNING PARK dedicado a actividades de alta intensidad o HIIT, plataforma vibratoria Power Plate, área de hidratación de bebidas YANGA... así como un espacio destinado al boxeo, FIGHT PARK con ring y sacos.
                    </p>
                    <p>
                        ¿Problemas con los horarios? Nuestro gym está abierto los 7 días de la semana de 6:00 am a 1:00 am los 365 días del año! ¡No tendrás excusas!
                    </p>
                </div>
                <video src=""></video>
            </div>
        </section>
        <section id="ultimas_noticias">
            <h2>Últimas noticias</h2>
            <?php
                require_once "php/funciones.php";

                $con=conectarServidor();

                $fecha_actual=date('Y-m-d');

                $consulta=$con->query("select * from noticia where fecha_publicacion<='$fecha_actual' order by fecha_publicacion desc limit 0, 3");

                echo '<div class="contenedor_ultimas_noticias">';
                while($noticia=$consulta->fetch_array(MYSQLI_ASSOC)){
                    $contenido_short=substr($noticia['contenido'], 0, 50);

                    echo "<div>
                        <img src=\"img/noticias/$noticia[imagen]\">
                        <h3>$noticia[titulo]</h3>
                        <p>$contenido_short</p>
                        <p>Fecha de publicación: $noticia[fecha_publicacion]</p>
                        <form action=\"php/noticia_completa.php\" method=\"post\">
                            <input type=\"hidden\" name=\"id_noticia\" value=\"$noticia[id]\">
                            <input type=\"submit\" name=\"ver_noticia\" value=\"Ver\">
                        </form>
                    </div>";
                }
                echo '</div>';

                $con->close();
            ?>
        </section>
        <section id="testimonio_random">
            <?php
                require_once "php/funciones.php";

                $con=conectarServidor();

                $consulta=$con->query("select count(id) from testimonio");
                $num=$consulta->fetch_array(MYSQLI_NUM);

                $id=mt_rand(1,$num[0]);

                $datos=$con->query("select nombre,contenido from testimonio,socio where autor=socio.id and testimonio.id=$id");
                $fila=$datos->fetch_array(MYSQLI_ASSOC);
                
                if($num[0]>0){
                    echo "<div>
                        <p>\"$fila[contenido]\"</p>
                        <p>$fila[nombre]</p>
                    </div>";
                }else{
                    echo "<p>Aún no hay testimonios en la base de datos</p>";
                }
                
                $con->close();
            ?>
        </section>
        <section id="contacto">
            <h2>Contacto</h2>
            <div class="contenedorContacto">
                <div class="preguntas_y_respuestas">
                    <h3>Preguntas y Respuestas</h3>
                    <details>
                        <summary>¿Cuál es el precio?</summary>
                        <p>
                            14’95€ el primer mes y 24’95€ los siguientes meses con permanencia flexible de 12 meses.
                        </p>
                    </details>
                    <details>
                        <summary>¿Cuál es el horario?</summary>
                        <p>
                            Abrimos los 365 días del año de 6am a 1am con domingos y festivos incluidos.(Horario especial el 25 de diciembre y los días 1 y 6 de enero)
                        </p>
                    </details>
                    <details>
                        <summary>¿Cómo funciona la permanencia?</summary>
                        <p>
                            Nuestra permanencia flexible de 12 meses permite la suspensión temporal de tu abono por motivos médicos, laborales y vacacionales. Para hacer efectiva dicha suspensión es necesario enviar un correo al mail del club adjuntando un justificante válido. La suspensión tiene un periodo mínimo de 1 mes completo, avisando siempre con 7 días de antelación.
                        </p>
                    </details>
                    <details>
                        <summary>¿Puedo ir a probar el club?</summary>
                        <p>
                            Puedes venir un día a entrenar por 10€ y acceder tantas veces como quieras en el mismo día. En un futuro, esos importes se descontarán del precio de la matricula.
                        </p>
                    </details>
                </div>
                <form action="" method="post">
                    <div>
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre">
                    </div>
                    <div>
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo">
                    </div>
                    <div>
                        <label for="mensaje">Mensaje:</label>
                        <textarea name="mensaje" cols="30" rows="10"></textarea>
                    </div>
                    <input type="submit" name="enviar">
                </form>
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