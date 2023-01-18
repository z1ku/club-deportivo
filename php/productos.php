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
    <title>Productos</title>
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
            <h1>Listado de Productos</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_producto" value="Buscar">
                    <a href="productos.php">Reset</a>
                </form>
                <?php
                    if($tipo_usu=="admin"){
                        echo '<form action="panel_productos.php" method="post">
                            <input type="submit" name="nuevo_producto" value="Nuevo producto">
                        </form>';
                    }
                ?>
            </div>
            <?php
                require_once "funciones.php";
                $con=conectarServidor();

                $productos=$con->query("select * from producto order by nombre asc");

                if($productos->num_rows==0){
                    echo "<p>No hay productos en la base de datos</p>";
                }else if(isset($_POST['buscar_producto'])){
                    $cadena=$_POST['cadena'];
                    $param="%$cadena%";

                    $buscar=$con->prepare("select * from producto where nombre like ? or precio like ? order by nombre asc");
                    $buscar->bind_result($id,$nombre,$precio);
                    $buscar->bind_param("ss",$param,$param);
                    $buscar->execute();
                    $buscar->store_result();
                    
                    if($buscar->num_rows==0){
                        echo "<p>No se han encontrado coincidencias</p>";
                    }else{
                        echo "<table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>";
                                if($tipo_usu=="admin"){
                                    echo"<th>Editar</th>
                                    <th>Eliminar</th>";
                                }
                        echo"</tr>
                        </thead>
                        <tbody>";
                        while($buscar->fetch()){
                            echo "<tr>
                                <td>$nombre</td>
                                <td>$precio €</td>";
                                if($tipo_usu=="admin"){
                                    echo "<td>
                                        <form action=\"panel_productos.php\" method=\"post\">
                                            <input type=\"hidden\" name=\"id_producto\" value=\"$id\">
                                            <input type=\"submit\" name=\"editar_producto\" value=\"Editar\" class=\"btn-editar\">
                                        </form>
                                    </td>
                                    <td>
                                        <form action=\"editar_producto.php\" method=\"post\">
                                            <input type=\"hidden\" name=\"id_producto\" value=\"$id\">
                                            <input type=\"submit\" name=\"eliminar_producto\" value=\"Eliminar\" class=\"btn-borrar\">
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
                            <th>Nombre</th>
                            <th>Precio</th>";
                            if($tipo_usu=="admin"){
                                echo"<th>Editar</th>
                                <th>Eliminar</th>";
                            }
                        echo "</tr>
                    </thead>
                    <tbody>";
                    while($fila_productos=$productos->fetch_array(MYSQLI_ASSOC)){
                        echo "<tr>
                            <td>$fila_productos[nombre]</td>
                            <td>$fila_productos[precio] €</td>";
                            if($tipo_usu=="admin"){
                                echo "<td>
                                    <form action=\"panel_productos.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_producto\" value=\"$fila_productos[id]\">
                                        <input type=\"submit\" name=\"editar_producto\" value=\"Editar\" class=\"btn-editar\">
                                    </form>
                                </td>
                                <td>
                                    <form action=\"editar_producto.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"id_producto\" value=\"$fila_productos[id]\">
                                        <input type=\"submit\" name=\"eliminar_producto\" value=\"Eliminar\" class=\"btn-borrar\">
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