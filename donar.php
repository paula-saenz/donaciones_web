<?php
session_start();

// Configuración de conexión a la base de datos
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "donaciones");

// Intentar establecer conexión
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Verificar la conexión
if (!$connection) {
    die("La conexión con la BBDD ha fallado: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad_donada = $_POST['cantidad_donada'];
    $usuario = $_SESSION['username'];

    if (!is_numeric($cantidad_donada) || $cantidad_donada <= 0) {
        echo "La cantidad donada no es válida.";
        exit;
    }

    // Obtener el ID del usuario
    $query_get_user_id = "SELECT id_usuario FROM usuarios WHERE username = '$usuario'";
    $result_user_id = mysqli_query($connection, $query_get_user_id);

    if ($result_user_id && mysqli_num_rows($result_user_id) > 0) {
        $row = mysqli_fetch_assoc($result_user_id);
        $id_usuario = $row['id_usuario'];

        // Insertar la donación en la tabla donaciones
        $query_insert_donation = "INSERT INTO donaciones (id_usuario, cantidad_donada) VALUES ($id_usuario, $cantidad_donada)";
        $result_insert_donation = mysqli_query($connection, $query_insert_donation);

        if ($result_insert_donation) {
            header("Location: success.html");
        } else {
            header("Location: error.html");
        }
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "Método de solicitud no válido.";
}

// Cerrar conexión
mysqli_close($connection);
?>
