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
                <input type="submit" name="enviar" id="btn-login" value="Login">
            </form>
        </div>
    </header>
    <main>
        <section class="seccionCitas seccion">
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

                $con=conectarServidor();

                setlocale(LC_ALL, "es-ES.UTF-8");

                if($_GET){
                    $m=$_GET["nuevo_mes"];
                    $a=$_GET["nuevo_ano"];
                }else{
                    $marca=time();

                    $m=date('m', $marca);
                    $a=date('Y', $marca);
                }

                //PRIMER DIA DEL MES
                $marca_start=mktime(0,0,0,$m,1,$a);
                $start=date('N', $marca_start);

                //NOMBRE DEL MES
                $nom_mes=strftime('%B', $marca_start);
                
                //NUMERO DE DIAS DEL MES
                $max_dias=date('t', $marca_start);

                //NUMERO DE SEMANAS DEL MES
                $num_filas=ceil($max_dias/7);

                //CONTADOR PARA LOS DIAS
                $dias=1;

                //SUMO +1 A FILAS SI NECESITO MAS FILAS
                if($start==6 and $max_dias>30){
                    $num_filas+=1;
                }else if($start==7 and $max_dias>=30){
                    $num_filas+=1;
                }else if($start>=3 and $max_dias<=28){
                    $num_filas+=1;
                }
                
                //CALCULO EL MES Y EL AÑO DEL MES ANTERIOR
                $mes_anterior=$m-1;
                $ano_anterior=$a;
                if($mes_anterior==0){
                    $ano_anterior--;
                    $mes_anterior=12;
                }

                //CALCULO EL MES Y EL AÑO DEL MES SIGUIENTE
                $mes_siguiente=$m+1;
                $ano_siguiente=$a;
                if($mes_siguiente==13){
                    $ano_siguiente++;
                    $mes_siguiente=1;
                }

                $fechas=$con->query("select distinct fecha from citas,servicio,socio where socio=socio.id and servicio=servicio.id and fecha like '%$a-$m-%'");

                $tiene_citas=false;

                while($fila_fechas=$fechas->fetch_array(MYSQLI_ASSOC)){
                    $marca_dia=strtotime($fila_fechas['fecha']);
                    $dias_con_cita[]=date('d', $marca_dia);
                    $tiene_citas=true;
                }

                echo "<table class=\"calendario\">
                <caption>
                    <a href=\"citas.php?nuevo_mes=$mes_anterior&nuevo_ano=$ano_anterior\">&laquo</a>
                    $nom_mes de $a
                    <a href=\"citas.php?nuevo_mes=$mes_siguiente&nuevo_ano=$ano_siguiente\">&raquo</a>
                </caption>
                <thead>
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sabado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>";
                for($filas=0;$filas<$num_filas;$filas++){
                    echo "<tr>";
                    for($cols=0;$cols<7;$cols++){
                        if($dias<=$max_dias && $dias>=$start){
                            if($tiene_citas){
                                if(in_array($dias, $dias_con_cita)){
                                    echo "<td class=\"dia_cita\">$dias</td>";
                                }else{
                                    echo "<td>$dias</td>";
                                }
                                $dias++;
                            }else{
                                echo "<td>$dias</td>";
                                $dias++;
                            }
                        }else{
                            echo "<td></td>";
                            $start--;
                        }
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

                $citas=$con->query("select distinct socio,servicio,nombre,descripcion,telefono,fecha,hora from citas,servicio,socio where socio=socio.id and servicio=servicio.id and fecha like '%$a-$m-%'");

                //MUESTRO LAS CITAS DEL MES SI LAS HUBIERA
                if($citas->num_rows>0){
                    echo "<h2>Tus citas</h2>";
                    echo "<table>
                    <thead>
                        <tr>
                            <th>Socio</th>
                            <th>Servicio</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_citas2=$citas->fetch_array(MYSQLI_ASSOC)){
                        echo "<tr>
                            <td>$fila_citas2[nombre]</td>
                            <td>$fila_citas2[descripcion]</td>
                            <td>$fila_citas2[telefono]</td>
                            <td>$fila_citas2[fecha]</td>
                            <td>$fila_citas2[hora]</td>
                            <td>
                                <form action=\"editar_citas.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_socio\" value=\"$fila_citas2[socio]\">
                                    <input type=\"hidden\" name=\"id_servicio\" value=\"$fila_citas2[servicio]\">
                                    <input type=\"hidden\" name=\"fecha\" value=\"$fila_citas2[fecha]\">
                                    <input type=\"submit\" name=\"borrar_cita\" value=\"Borrar\" class=\"btn-borrar\">
                                </form>
                            </td>
                        </tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                
                //BUSCAR CITAS
                if(isset($_POST['buscar_cita'])){
                    $cadena=$_POST['cadena'];
                    $param="%$cadena%";

                    $buscar=$con->prepare("select distinct socio,servicio,nombre,descripcion,telefono,fecha,hora from citas,servicio,socio where socio=socio.id and servicio=servicio.id and (nombre like ? or descripcion like ? or fecha like ?)");
                    $buscar->bind_result($socio,$servicio,$nombre,$descripcion,$telefono,$fecha,$hora);
                    $buscar->bind_param("sss",$param,$param,$param);
                    $buscar->execute();
                    $buscar->store_result();

                    if($buscar->num_rows==0){
                        echo "<h2>Citas encontradas</h2>";
                        echo "<p>No se han encontrado coincidencias</p>";
                    }else{
                        echo "<h2>Citas encontradas</h2>";
                        echo "<table>
                        <thead>
                            <tr>
                                <th>Socio</th>
                                <th>Servicio</th>
                                <th>Teléfono</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Borrar</th>
                            </tr>
                        </thead>
                        <tbody>";
                        while($buscar->fetch()){
                            echo "<tr>
                                <td>$nombre</td>
                                <td>$descripcion</td>
                                <td>$telefono</td>
                                <td>$fecha</td>
                                <td>$hora</td>
                                <td>
                                    <form action=\"editar_citas.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_socio\" value=\"$socio\">
                                        <input type=\"hidden\" name=\"id_servicio\" value=\"$servicio\">
                                        <input type=\"hidden\" name=\"fecha\" value=\"$fecha\">
                                        <input type=\"submit\" name=\"borrar_cita\" value=\"Borrar\" class=\"btn-borrar\">
                                    </form>
                                </td>
                            </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }

                    $buscar->close();
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