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
    <title>Panel Socios</title>
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
        <section id="panel_socios" class="panel_admin">
            <h1>Panel Socios</h1>
            <a href="socios.php">Volver</a>
            <?php
                if(isset($_POST["editar_socio"])){

                    require_once "funciones.php";

                    $id_socio=$_POST['id_socio'];

                    $con=conectarServidor();
                    $datos=$con->query("select * from socio where id=$id_socio");
                    $socio=$datos->fetch_array(MYSQLI_ASSOC);

                    echo "<h2>Editar Socio</h2>";
                    echo "<form action=\"editar_socio.php\" method=\"post\" enctype=\"multipart/form-data\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$socio[id]\" readonly>
                    </div>
                    <div>
                        <label for=\"nombre\">Nombre:</label>
                        <input type=\"text\" name=\"nombre\" value=\"$socio[nombre]\" maxlength=\"50\" required>
                    </div>
                    <div>
                        <label for=\"edad\">Edad:</label>
                        <input type=\"number\" name=\"edad\" value=\"$socio[edad]\" min=\"0\" max=\"99\" required>
                    </div>
                    <div>
                        <label for=\"usuario\">Usuario:</label>
                        <input type=\"text\" name=\"usuario\" value=\"$socio[usuario]\" maxlength=\"15\" required>
                        <input type=\"hidden\" name=\"usuario_antiguo\" value=\"$socio[usuario]\">
                    </div>
                    <div>
                        <label for=\"pass\">Contraseña:</label>
                        <input type=\"password\" name=\"pass\" value=\"\" maxlength=\"15\">
                    </div>
                    <div>
                        <label for=\"telefono\">Telefono:</label>
                        <input type=\"number\" name=\"telefono\" value=\"$socio[telefono]\" min=\"0\" max=\"999999999\" required>
                    </div>
                    <div>
                        <label for=\"foto\">Subir foto en jpg:</label>
                        <input type=\"file\" name=\"foto\" accept=\"image/jpeg\">
                    </div>
                    <input type=\"submit\" name=\"editar_socio\" value=\"Guardar\">
                    </form>";
                    
                    $con->close();
                }else if(isset($_POST["nuevo_socio"])){
                    
                    require_once "funciones.php";
                    $con=conectarServidor();

                    $sentencia="select auto_increment from information_schema.tables where table_schema='club' and table_name='socio'";
                    $resultado=$con->query($sentencia);

                    $fila=$resultado->fetch_array(MYSQLI_NUM);
                    $id=$fila[0];
                    
                    echo "<h2>Nuevo Socio</h2>";
                    echo "<form action=\"editar_socio.php\" method=\"post\" enctype=\"multipart/form-data\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$id\" readonly>
                    </div>
                    <div>
                        <label for=\"nombre\">Nombre:</label>
                        <input type=\"text\" name=\"nombre\" maxlength=\"50\" required>
                    </div>
                    <div>
                        <label for=\"edad\">Edad:</label>
                        <input type=\"number\" name=\"edad\" min=\"0\" max=\"99\" required>
                    </div>
                    <div>
                        <label for=\"usuario\">Usuario:</label>
                        <input type=\"text\" name=\"usuario\" maxlength=\"15\" required>
                    </div>
                    <div>
                        <label for=\"pass\">Contraseña:</label>
                        <input type=\"password\" name=\"pass\" maxlength=\"15\" required>
                    </div>
                    <div>
                        <label for=\"telefono\">Telefono:</label>
                        <input type=\"number\" name=\"telefono\" min=\"0\" max=\"999999999\" required>
                    </div>
                    <div>
                        <label for=\"foto\">Subir foto en jpg:</label>
                        <input type=\"file\" name=\"foto\" accept=\"image/jpeg\" required>
                    </div>
                    <input type=\"submit\" name=\"insertar_socio\" value=\"Guardar\">
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