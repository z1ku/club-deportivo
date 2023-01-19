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
    <title>Panel Productos</title>
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
        <section id="panel_productos" class="panel_admin">
            <h1>Panel Productos</h1>
            <a href="productos.php">Volver</a>
            <?php
                if(isset($_POST["editar_producto"])){

                    require_once "funciones.php";

                    $id_producto=$_POST['id_producto'];
                    
                    $con=conectarServidor();
                    $datos=$con->query("select * from producto where id=$id_producto");
                    $producto=$datos->fetch_array(MYSQLI_ASSOC);

                    echo "<h2>Editar Producto</h2>";
                    echo "<form action=\"editar_producto.php\" method=\"post\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$producto[id]\" readonly>
                    </div>
                    <div>
                        <label for=\"nombre\">Nombre:</label>
                        <input type=\"text\" name=\"nombre\" value=\"$producto[nombre]\" maxlength=\"50\" required>
                    </div>
                    <div>
                        <label for=\"precio\">Precio:</label>
                        <input type=\"number\" name=\"precio\" value=\"$producto[precio]\" min=\"0\" max=\"999\" step=\"0.01\" required>
                    </div>
                    <input type=\"submit\" name=\"editar_producto\" value=\"Guardar\">
                    </form>";
                    
                    $con->close();
                }else if(isset($_POST["nuevo_producto"])){
                    
                    require_once "funciones.php";
                    $con=conectarServidor();

                    $sentencia="select auto_increment from information_schema.tables where table_schema='club' and table_name='producto'";
                    $resultado=$con->query($sentencia);

                    $fila=$resultado->fetch_array(MYSQLI_NUM);
                    $id=$fila[0];
                    
                    echo "<h2>Nuevo Producto</h2>";
                    echo "<form action=\"editar_producto.php\" method=\"post\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$id\" readonly>
                    </div>
                    <div>
                        <label for=\"nombre\">Nombre:</label>
                        <input type=\"text\" name=\"nombre\" maxlength=\"50\" required>
                    </div>
                    <div>
                        <label for=\"precio\">Precio:</label>
                        <input type=\"number\" name=\"precio\" min=\"0\" max=\"999\" step=\"0.01\" required>
                    </div>
                    <input type=\"submit\" name=\"insertar_producto\" value=\"Guardar\">
                    </form>";

                    $con->close();
                }else{
                    header("Location:../index.php");
                }
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