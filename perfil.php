<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html"); 
    exit();
}

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "donaciones");

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$connection) {
    die("La conexión con la BBDD ha fallado: " . mysqli_connect_error());
}

//recuperamos el username para hacer la consulta 
$username = $_SESSION['username'];

$query = "SELECT nombre, apellidos, edad, direccion FROM usuarios WHERE username = '$username' LIMIT 1";
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    $nombre = $row['nombre'];
    $apellidos = $row['apellidos'];
    $edad = $row['edad'];
    $direccion = $row['direccion'];
} else {
    die("Error en la consulta: " . mysqli_error($connection));
}

mysqli_close($connection);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/perfil.css">
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
            <li class="btn" id="donarBtn"><a href="dashboard.php"><b> DONAR AHORA </b></a></li>
        </ul>
    </header>
    <div id="contenido">
        <div class="cajas_texto">
            <h1>Bienvenido, <?php echo $nombre . " " . $apellidos; ?> </h1>
            <div class= "datos">
                <p>Nombre: <?php echo $nombre; ?></p>
                <p>Apellidos: <?php echo $apellidos; ?></p>
                <p>Edad: <?php echo $edad; ?></p>
                <p>Dirección: <?php echo $direccion; ?></p>
                <p>Nombre de usuario: <?php echo $username; ?></p>
            </div>
<p></p>


            <div><ul><li class="bye"><a href="modificacion.html">Modificar datos</a></li></ul></div>
            <p></p>
            <div><ul><li class="bye1"><a href="dashboard.php">Volver</a></li></ul></div>

        </div>   
    </div>
   
</body>
</html>
