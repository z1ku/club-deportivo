<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <section id="seccionLogin" class="panel_admin">
            <h1>Acceder</h1>
            <?php
                require_once "funciones.php";

                if(isset($_POST['logearse'])){
                    $con=conectarServidor();

                    $usuario=$_POST['usu'];
                    $pass=$_POST['pass'];

                    $buscar=$con->prepare("select id from socio where usuario=? and pass=?");
                    $buscar->bind_result($id);
                    $buscar->bind_param("ss",$usuario,$pass);
                    $buscar->execute();
                    $buscar->store_result();

                    if($buscar->num_rows>0){
                        $_SESSION['usuario']=$usuario;
                        $_SESSION['pass']=$pass;

                        if($id==0){
                            $_SESSION['admin']=true;
                        }else{
                            $_SESSION['admin']=false;
                        }

                        if(isset($_POST['recordar'])){
                            $datos=session_encode();
                            setcookie('sesion', $datos);
                        }

                        echo "<p>Bienvenido $usuario</p>";
                    }else{
                        echo "<p>Usuario o contraseña incorrectos.</p>";
                    }
                    
                    $buscar->close();
                    $con->close();
                }

                echo "<form action=\"#\" method=\"post\">
                <div>
                    <label for=\"usu\">Usuario:</label>
                    <input type=\"text\" name=\"usu\" value=\"\" required>
                </div>
                <div>
                    <label for=\"pass\">Constraseña:</label>
                    <input type=\"password\" name=\"pass\"required>
                </div>
                <label for=\"recordar\">
                    <input type=\"checkbox\" name=\"recordar\">Recuerdame
                </label>
                <input type=\"submit\" name=\"logearse\" value=\"Enviar\">
                </form>";
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