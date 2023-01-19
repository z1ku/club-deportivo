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
    <title>Mis citas</title>
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
                header("Location:../index.php");
            }else{
                headerSocio($usuario);
                $tipo_usu="socio";
            }
        }else{
            header("Location:../index.php");
        }
    ?>
    <main>
        <section class="seccionCitas seccion">
            <h1>Mis citas</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_cita" value="Buscar">
                    <a href="mis_citas.php">Reset</a>
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

                $fechas=$con->query("select distinct fecha from citas,servicio,socio where socio=socio.id and servicio=servicio.id and fecha like '%$a-$m-%' and usuario='$usuario' and pass='$pass'");

                $tiene_citas=false;

                while($fila_fechas=$fechas->fetch_array(MYSQLI_ASSOC)){
                    $marca_dia=strtotime($fila_fechas['fecha']);
                    $dias_con_cita[]=date('d', $marca_dia);
                    $tiene_citas=true;
                }

                echo "<div id=\"cabecera_calendario\">
                    <a href=\"mis_citas.php?nuevo_mes=$mes_anterior&nuevo_ano=$ano_anterior\">&laquo</a>
                    <span>$nom_mes de $a</span>
                    <a href=\"mis_citas.php?nuevo_mes=$mes_siguiente&nuevo_ano=$ano_siguiente\">&raquo</a>
                </div>";
                
                echo "<table class=\"calendario\">
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
                                    echo "<td class=\"dia_cita\">
                                        <form action=\"#\" method=\"post\">
                                            <input type=\"hidden\" name=\"dia_buscado\" value=\"$dias\">
                                            <input type=\"submit\" name=\"cita_calendario\" value=\"$dias\" class=\"btn-dia-cita\">
                                        </form>
                                    </td>";
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


                if(isset($_POST['buscar_cita'])){
                    $cadena=$_POST['cadena'];
                    $param="%$cadena%";

                    $buscar=$con->prepare("select distinct socio,servicio,nombre,descripcion,telefono,fecha,hora from citas,servicio,socio where socio=socio.id and servicio=servicio.id and (nombre like ? or descripcion like ? or fecha like ?) and usuario=? and pass=?");
                    $buscar->bind_result($socio,$servicio,$nombre,$descripcion,$telefono,$fecha,$hora);
                    $buscar->bind_param("sssss",$param,$param,$param,$usuario,$pass);
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
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>";
                        while($buscar->fetch()){
                            $fecha_formateada2=date("d-m-Y",strtotime($fecha));

                            echo "<tr>
                                <td>$descripcion</td>
                                <td>$fecha_formateada2</td>
                                <td>$hora</td>
                            </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }

                    $buscar->close();
                }else if(isset($_POST['cita_calendario'])){
                    $dia_buscado=$_POST['dia_buscado'];

                    $citas=$con->query("select distinct socio,servicio,nombre,descripcion,telefono,fecha,hora from citas,servicio,socio where socio=socio.id and servicio=servicio.id and fecha='$a-$m-$dia_buscado'");
                    
                    if($citas->num_rows>0){
                        echo "<h2>Citas del día</h2>";
                        echo "<table>
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>";
                        while($fila_citas=$citas->fetch_array(MYSQLI_ASSOC)){
                            $fecha_formateada=date("d-m-Y",strtotime($fila_citas['fecha']));

                            echo "<tr>
                                <td>$fila_citas[descripcion]</td>
                                <td>$fecha_formateada</td>
                                <td>$fila_citas[hora]</td>
                            </tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }
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