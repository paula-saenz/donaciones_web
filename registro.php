<?php

session_start();

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "donaciones");

// 1. Crear conexión con la BBDD
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Verificar la conexión
if (!$connection) {
    die("La conexión con la BBDD ha fallado: " . mysqli_connect_error());
}

function find_user_by_username($username, $connection)
{
    $safe_username = mysqli_real_escape_string($connection, $username);

    $query  = "SELECT * ";
    $query .= "FROM usuarios ";
    $query .= "WHERE username = '$safe_username'";
    $query .= " LIMIT 1";

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

function attempt_login($username, $connection)
{
    $user = find_user_by_username($username, $connection);
    return ($user) ? $user : false;
}

if (isset($_POST['name'], $_POST['apellidos'], $_POST['edad'], $_POST['direccion'], $_POST['username'], $_POST['password'])) {
    $name = $_POST["name"];
    $apellidos = $_POST["apellidos"];
    $edad = $_POST["edad"];
    $direccion = $_POST["direccion"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verificar si el usuario ya existe
    $found_user = attempt_login($username, $connection);

    if ($found_user) {
        $_SESSION['error_message'] = "El usuario ya existe. Por favor, elige otro nombre de usuario.";
        header("Location: usuario_existe.php");
        exit();
    } else {
        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $query  = "INSERT INTO usuarios (nombre, apellidos, edad, direccion, username, contrasena)";
        $query .= " VALUES ('$name', '$apellidos', $edad, '$direccion', '$username', '$hashed_password')";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header("Location: dashboard.php");
            exit();
        } else {
            die("Database query failed. " . mysqli_error($connection));
        }
    }
}

// 5. Cerrar conexión con la base de datos
mysqli_close($connection);
?>
