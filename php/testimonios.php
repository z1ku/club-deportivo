<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonios</title>
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
        <section class="seccionTestimonios seccion">
            <h1>Listado de Testimonios</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="panel_testimonios.php" method="post">
                    <input type="submit" name="nuevo_testimonio" value="Nuevo testimonio">
                </form>
            </div>
            <?php
                require_once "funciones.php";
                $con=conectarServidor();

                $testimonios=$con->query("select nombre,contenido,fecha from testimonio,socio where autor=socio.id order by fecha desc");
                
                if($testimonios->num_rows==0){
                    echo "<p>No hay testimonios en la base de datos</p>";
                }else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th>Autor</th>
                            <th>Contenido</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_testimonios=$testimonios->fetch_array(MYSQLI_ASSOC)){
                        $fecha=date("d-m-Y",strtotime($fila_testimonios['fecha']));
                        
                        echo "<tr>
                            <td>$fila_testimonios[nombre]</td>
                            <td>$fila_testimonios[contenido]</td>
                            <td>$fecha</td>
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