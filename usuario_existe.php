<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="css/error.css">
    <link rel="stylesheet" href="css/login.css">
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
            <li class="btn" id="donarBtn"><a href="dashboard.php"><b> MI CUENTA </b></a></li>
        </ul>
    </header>

    <div id="contenido">
        <div class="cajas_texto">
            <h1>¡ERROR!</h1>
            <?php
            session_start();
            //mostrar mensaje de error
            if (isset($_SESSION['error_message'])) {
                echo '<p class="texto">' . $_SESSION['error_message'] . '</p>';
                unset($_SESSION['error_message']); 
            }
            ?>
            <div><ul><li class="bye"><a href="registro.html"><b> Volver </b></a></li></ul></div>
        </div>

        
    </div>

    <script>
        document.getElementById("donarBtn").addEventListener("click", function (event) {
            fetch('check_session.php')
                .then(response => response.json())
                .then(data => {
                    if (data.loggedIn) {
                        console.log("Usuario inició sesión, permitir donación.");
                    } else {
                        event.preventDefault();
                        alert("Debes iniciar sesión para donar.");
                        window.location.href = "login.html";
                    }
                })
                .catch(error => console.error('Error al verificar sesión:', error));
        });
    </script>

    
</body>
</html>