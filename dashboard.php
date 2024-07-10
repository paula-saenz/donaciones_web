<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <header id="header">
        <a href="index.html">
            <img src="imagenes/logo.png" class="logo" >
        </a> 
        <input type="checkbox" id="menu" />
        <label for="menu">
            <img src="imagenes/menu.png" alt="menu desplegable" class="menu-icono">
        </label>
        <ul class="menu">
            <li class="item"><a href="index.html"> <b>Inicio</b> </a></li>
            <li class="item"><a href="quienes_somos.html"> <b>Quienes somos</b> </a></li>
            <li class="item"><a href="login.html"> <b>Login</b> </a></li>
            <li class="btn"><a href="dashboard.php"><b> DONAR AHORA </b></a></li>
        </ul>
    </header>

    <div id="contenido">
        <div class="cajas_texto">
            <h1>Tus donaciones</h1>
            <?php
            session_start(); 

            define("DB_SERVER", "localhost");
            define("DB_USER", "root");
            define("DB_PASS", "");
            define("DB_NAME", "donaciones");

            $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

            if (mysqli_connect_errno()) {
                die("La conexión con la BBDD ha fallado: " .
                    mysqli_connect_error() .
                    " (" . mysqli_connect_errno() . ")"
                );
            }           
            $usuario = $_SESSION['username'];
            $query_info = "SELECT SUM(cantidad_donada) AS total_donado FROM donaciones WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE username = '$usuario')";
            $result_info = mysqli_query($connection, $query_info);
            $usuario_info = mysqli_fetch_assoc($result_info);
            $porcentaje_donado = ($usuario_info['total_donado'] * 100) / 2000;
            $arboles_donados = ($usuario_info['total_donado']/2);

            if ($usuario_info && $usuario_info['total_donado'] != 0) {
                $total_donado = $usuario_info['total_donado'];
                echo "<p class='texto'>Has donado un total de $total_donado euros. <br> ¡¡¡Eso significa que has ayudado a 
                plantar $arboles_donados árboles!!!! <br> <br> ¡Gracias por tu apoyo! <br> <br>
                Has ayudado en un $porcentaje_donado% a acercarnos a nuestro objetivo de 2.000€</p>";
            } else {
                echo "<p class='texto'>¡Bienvenido a tu panel de donaciones! <br>  Aún no has realizado donaciones. ¡Únete y contribuye a nuestra causa! <br>
                necesitamos 2.000€ </p>";
            }
            ?>
            
            <div><ul><li class="bye1"> <a  href="perfil.php"><b> Configuración </b></a></li></ul></div>  
            <p></p> 
            <div><ul><li class="bye"> <a  href="cerrar_sesion.php"><b> Cerrar Sesión </b></a></li></ul></div>   


        </div>

        <div>
        <div>
                <h2 class="donar"><a href="donar.html">QUIERO DONAR</a></h2>
        </div>
        </div>

    </div> 

</body>
</html>