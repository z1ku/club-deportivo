<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Socio</title>
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
        <section id="seccionModificarSocio">
            <h1>Modificar Socio</h1>
            <?php
                if(isset($_POST["modificar_socio"])){
                    require_once "funciones.php";

                    $id_socio=$_POST['id_socio'];

                    $con=conectarServidor();
                    $datos=$con->query("select * from socio where id=$id_socio");
                    $socio=$datos->fetch_array(MYSQLI_ASSOC);

                    echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">
                    <div>
                        <label for=\"id\">ID:</label>
                        <input type=\"number\" name=\"id\" value=\"$socio[id]\" disabled>
                    </div>
                    <div>
                        <label for=\"nombre\">Nombre:</label>
                        <input type=\"text\" name=\"nombre\" placeholder=\"$socio[nombre]\">
                    </div>
                    <div>
                        <label for=\"edad\">Edad:</label>
                        <input type=\"number\" name=\"edad\" placeholder=\"$socio[edad]\">
                    </div>
                    <div>
                        <label for=\"usuario\">Usuario:</label>
                        <input type=\"text\" name=\"usuario\" placeholder=\"$socio[usuario]\">
                    </div>
                    <div>
                        <label for=\"pass\">Contraseña:</label>
                        <input type=\"password\" name=\"pass\">
                    </div>
                    <div>
                        <label for=\"telefono\">Telefono:</label>
                        <input type=\"number\" name=\"telefono\" placeholder=\"$socio[telefono]\" min=\"0\">
                    </div>
                    <div>
                        <label for=\"foto\">Subir foto en jpg:</label>
                        <input type=\"file\" name=\"foto\" accept=\"image/jpeg\">
                    </div>
                    <input type=\"submit\" name=\"modificar\" value=\"Guardar\">
                    </form>";
                    
                    if(isset($_POST['modificar'])){
                        if(trim($_POST['nombre']=="")){
                            $nombre=$socio['nombre'];
                        }else{
                            $nombre=trim($_POST['nombre']);
                        }
                        
                        if($_POST['edad']==""){
                            $edad=$socio['edad'];
                        }else{
                            if($_POST['edad']>0){
                                $edad=$_POST['edad'];
                            }else{
                                
                            }
                        }

                        if(trim($_POST['usuario']=="")){
                            $usuario=$socio['usuario'];
                        }else{
                            $usuario=trim($_POST['usuario']);
                        }

                        if(trim($_POST['pass']=="")){
                            $pass=$socio['pass'];
                        }else{
                            $pass=trim($_POST['pass']);
                        }

                        if($_POST['telefono']==""){
                            $telefono=$socio['telefono'];
                        }else{
                            if(preg_match("`[6789][0-9]{8}`", $_POST['telefono'])){
                                $telefono=$_POST['telefono'];
                            }else{
                                
                            }
                        }


                    }


                    $con->close();
                }else{
                    echo "<p>Usa el botón Modificar en socios</p>";
                    header("refresh:3; url=socios.php");
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