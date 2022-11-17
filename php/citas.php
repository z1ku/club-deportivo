<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
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
        <section class="seccionCitas">
            <h1>Citas</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_cita" value="Buscar">
                    <a href="citas.php">Reset</a>
                </form>
                <form action="panel_citas.php" method="post">
                    <input type="submit" name="nueva_cita" value="Nueva cita">
                </form>
            </div>
            <?php
                require_once "funciones.php";

                setlocale(LC_ALL, "es-ES.UTF-8");

                $marca=time();

                //NOMBRE DEL MES
                $nom_mes=strftime('%B', $marca);

                //PRIMER DIA DEL MES
                $m=date('m', $marca);
                $a=date('Y', $marca);
                $marca_start=mktime(0,0,0,$m,1,$a);
                $start=date('N', $marca_start);

                //NUMERO DE DIAS DEL MES
                $max_dias=date('t', $marca);

                //NUMERO DE SEMANAS DEL MES
                $num_filas=ceil($max_dias/7);

                //CONTADOR PARA LOS DIAS
                $dias=1;

                //SUMO +1 A FILAS SI NECESITO MAS FILAS
                if($start>=6){
                    $num_filas+=1;
                }

                echo "<table border>
                <caption>
                    <form action=\"#\" method=\"post\">
                        <input type=\"submit\" value=\"&laquo;\" name=\"atras\">
                    </form>
                    $nom_mes
                    <form action=\"#\" method=\"post\">
                        <input type=\"submit\" value=\"&raquo;\" name=\"atras\">
                    </form>
                </caption>
                <tr>
                    <td>Lunes</td>
                    <td>Martes</td>
                    <td>Miercoles</td>
                    <td>Jueves</td>
                    <td>Viernes</td>
                    <td>Sabado</td>
                    <td>Domingo</td>
                </tr>";
                for($filas=0;$filas<$num_filas;$filas++){
                    $posicion_semana=1;
                    echo "<tr>";
                    for($cols=0;$cols<7;$cols++){
                        if($dias<=$max_dias && $dias>=$start){
                            echo "<td>$dias</td>";
                            $dias++;
                            $posicion_semana++;
                        }else{
                            echo "<td></td>";
                            $start--;
                            $posicion_semana++;
                        }
                    }
                    echo "</tr>";
                }
                echo "</table>";

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