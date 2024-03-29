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
    <title>Socios</title>
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
        <section class="seccionSocios seccion">
            <h1>Listado de Socios</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_socio" value="Buscar">
                    <a href="socios.php">Reset</a>
                </form>
                <form action="panel_socios.php" method="post">
                    <input type="submit" name="nuevo_socio" value="Nuevo socio">
                </form>
            </div>
            <?php
                require_once "funciones.php";
                $con=conectarServidor();

                $socios=$con->query("select * from socio");

                if($socios->num_rows==0){
                    echo "<p>No hay socios en la base de datos</p>";
                }else if(isset($_POST['buscar_socio'])){
                    $cadena=$_POST['cadena'];
                    $param="%$cadena%";

                    $buscar=$con->prepare("select * from socio where nombre like ? or telefono like ?");
                    $buscar->bind_result($id,$nombre,$edad,$usuario,$pass,$telefono,$foto);
                    $buscar->bind_param("ss",$param,$param);
                    $buscar->execute();
                    $buscar->store_result();
                    
                    if($buscar->num_rows==0){
                        echo "<p>No se han encontrado coincidencias</p>";
                    }else{
                        echo "<table>
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Usuario</th>
                                <th>Contraseña</th>
                                <th>Telefono</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>";
                        while($buscar->fetch()){
                            if($id>0){
                                echo "<tr>
                                <td><img src=\"../img/socios/$foto\"></td>
                                <td>$nombre</td>
                                <td>$edad</td>
                                <td>$usuario</td>
                                <td>$pass</td>
                                <td>$telefono</td>
                                <td>
                                    <form action=\"panel_socios.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_socio\" value=\"$id\">
                                        <input type=\"submit\" name=\"editar_socio\" value=\"Editar\" class=\"btn-editar\">
                                    </form>
                                </td>
                                </tr>";
                            }
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }

                    $buscar->close();
                }else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Telefono</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>";
                    while($fila_socios=$socios->fetch_array(MYSQLI_ASSOC)){
                        if($fila_socios['id']>0){
                            echo "<tr>
                            <td><img src=\"../img/socios/$fila_socios[foto]\"></td>
                            <td>$fila_socios[nombre]</td>
                            <td>$fila_socios[edad]</td>
                            <td>$fila_socios[usuario]</td>
                            <td>$fila_socios[pass]</td>
                            <td>$fila_socios[telefono]</td>
                            <td>
                                <form action=\"panel_socios.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id_socio\" value=\"$fila_socios[id]\">
                                    <input type=\"submit\" name=\"editar_socio\" value=\"Editar\" class=\"btn-editar\">
                                </form>
                            </td>
                            </tr>";
                        }
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