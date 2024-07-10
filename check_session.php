<?php
session_start();

// Verificar si el usuario ha iniciado sesión
$response = array('loggedIn' => false);

if (isset($_SESSION['username'])) {
    $response['loggedIn'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
