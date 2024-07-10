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

$update_fields = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
    if (isset($_POST["name"])) {
        $update_fields[] = "nombre='" . mysqli_real_escape_string($connection, $_POST["name"]) . "'";
    }

    if (isset($_POST["apellidos"])) {
        $update_fields[] = "apellidos='" . mysqli_real_escape_string($connection, $_POST["apellidos"]) . "'";
    }

    if (isset($_POST["edad"])) {
        $update_fields[] = "edad=" . intval($_POST["edad"]);
    }

    if (isset($_POST["direccion"])) {
        $update_fields[] = "direccion='" . mysqli_real_escape_string($connection, $_POST["direccion"]) . "'";
    }

    if (isset($_POST["username"])) {
        $newUsername = $_POST["username"];

        if ($newUsername !== $_SESSION['username']) {
            $checkUsername = "SELECT username FROM usuarios WHERE username = '$newUsername'";
            $checkResult = mysqli_query($connection, $checkUsername);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            echo "Error: El nuevo nombre de usuario ya está en uso. Por favor, elige otro.";
            exit();
        }

        $update_fields[] = "username='$newUsername'";
    }

    if (isset($_POST["password"])) {
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $update_fields[] = "contrasena='$hashed_password'";
    }
}

}

if (!empty($update_fields)) {
    $username = $_SESSION['username'];

    $query = "UPDATE usuarios SET " . implode(", ", $update_fields) . " WHERE username='$username'";

    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: perfil.php");
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($connection);
    }
} else {
    echo "No se proporcionaron datos para la actualización.";
}

// Cerrar la conexión con la base de datos
mysqli_close($connection);
?>
