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
    <title>Servicios</title>
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
                headerSocio($usuario);
                $tipo_usu="socio";
            }
        }else{
            headerGuest();
        }
    ?>
    <main>
        <section class="seccion_productos_servicios seccion">
            <h1>Listado de Servicios</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_servicio" value="Buscar">
                    <a href="servicios.php">Reset</a>
                </form>
                <?php
                    if($tipo_usu=="admin"){
                        echo '<form action="panel_servicios.php" method="post">
                            <input type="submit" name="nuevo_servicio" value="Nuevo servicio">
                        </form>';
                    }
                ?>
    
            </div>
            <?php
                require_once "funciones.php";
                $con=conectarServidor();

                $servicios=$con->query("select * from servicio order by descripcion asc");
                
                if($servicios->num_rows==0){
                    echo "<p>No hay servicios en la base de datos</p>";
                }else if(isset($_POST['buscar_servicio'])){
                    $cadena=$_POST['cadena'];
                    $param="%$cadena%";

                    $buscar=$con->prepare("select * from servicio where descripcion like ? order by descripcion asc");
                    $buscar->bind_result($id,$descripcion,$duracion,$precio);
                    $buscar->bind_param("s",$param);
                    $buscar->execute();
                    $buscar->store_result();
                    
                    if($buscar->num_rows==0){
                        echo "<p>No se han encontrado coincidencias</p>";
                    }else{
                        echo "<table>
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Duración</th>
                                <th>Precio</th>";
                                if($tipo_usu=="admin"){
                                    echo "<th>Editar</th>";
                                }
                            echo "</tr>
                        </thead>
                        <tbody>";
                        while($buscar->fetch()){
                            echo "<tr>
                                <td>$descripcion</td>
                                <td>$duracion mins</td>
                                <td>$precio €</td>";
                                if($tipo_usu=="admin"){
                                    echo "<td>
                                        <form action=\"panel_servicios.php\" method=\"post\">
                                            <input type=\"hidden\" name=\"id_servicio\" value=\"$id\">
                                            <input type=\"submit\" name=\"editar_servicio\" value=\"Editar\" class=\"btn-editar\">
                                        </form>
                                    </td>";
                                }
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }

                    $buscar->close();
                }else{
                    echo "<table>
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Precio</th>";
                            if($tipo_usu=="admin"){
                                echo "<th>Editar</th>";
                            }
                        echo "</tr>
                    </thead>
                    <tbody>";
                    while($fila_servicios=$servicios->fetch_array(MYSQLI_ASSOC)){
                        echo "<tr>
                            <td>$fila_servicios[descripcion]</td>
                            <td>$fila_servicios[duracion] mins</td>
                            <td>$fila_servicios[precio] €</td>";
                            if($tipo_usu=="admin"){
                                echo "<td>
                                    <form action=\"panel_servicios.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_servicio\" value=\"$fila_servicios[id]\">
                                        <input type=\"submit\" name=\"editar_servicio\" value=\"Editar\" class=\"btn-editar\">
                                    </form>
                                </td>";
                            }
                        echo "</tr>";
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