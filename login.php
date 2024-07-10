<?php
session_start();

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "donaciones");

// 1. Crear conexión con la BBDD
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Si hay un error, imprimimos la descripción del error y el número de error generado.
if (mysqli_connect_errno()) {
    die("La conexión con la BBDD ha fallado: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")"
    );
}

function find_user_by_username($username, $connection)
{
    $safe_username = mysqli_real_escape_string($connection, $username);
    $query  = "SELECT * ";
    $query .= "FROM usuarios ";
    $query .= "WHERE username = '$safe_username' ";
    $query .= "LIMIT 1";

    $user_set = mysqli_query($connection, $query);

    if (!$user_set) {
        die("Database query failed.");
    }

    if ($user = mysqli_fetch_assoc($user_set)) {
        return $user;
    } else {
        return null;
    }
}

function attempt_login($username, $password, $connection)
{
    $user = find_user_by_username($username, $connection);
    if ($user) {
        // user encontrado
        return $user;
    } else {
        // user not found
        return false;
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $found_user = attempt_login($username, $password, $connection);

    if ($found_user) {
        if (password_verify($password, $found_user["contrasena"])) {
            // Configurar variable de sesión
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // redireccionar a dashboard.php
            exit();
        } else {
            header("Location: error_login.html");
            exit();
        }
    } else {
        header("Location: error_login.html");
        exit();
    }
}

// 5. Cerrar conexión con la base de datos
mysqli_close($connection);
?>
