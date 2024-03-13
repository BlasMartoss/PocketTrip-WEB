<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="shortcut icon" href="images/small_icon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="code.js"></script>
    <title>Pocket Trip</title>

</head>

<header>

</header>

<body>
    <div id="main_container1">

        <div id="buttons_div">
            <div id="volver_div">
                <a href="index.html">
                    <div id="back_btn">Volver</div>
                </a>
            </div>
            <div id="div_container">
                <button id="account_button1">Iniciar Sesión</button>
                <button id="account_button2" ><a href="register.php">Crear Cuenta</a>   </button>
            </div>
        </div>
        <div id="main_container">
            <div id="second_container">
                <div>
                    <a href="index.html"><img id="big_container" src="images/big_icon.png" alt=""></a>
                </div>

                <form id="loginForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div id="container_email_2">
                        <img class="icons" src="images/emailIcon.png" alt="Icon de persona">
                        <input type="text" id="login_email" class="inputs" name="emailLogin" placeholder="Email"
                            required>
                    </div>
                    <div id="container_password_2">
                        <img class="icons" src="images/candado.png" alt="Icon de candado">
                        <input type="password" id="login_password" class="inputs" name="passwordLogin"
                            placeholder="Contraseña" required>
                    </div>
                    <div id="error_login">
                        <p>Credenciales Incorrectas</p>
                    </div>
                    <div id="password_change">
                        <a href="" onclick="changePassword()">¿Has olvidado tu contraseña?</a>
                    </div>

                    <div id="button_login">
                        <button id="btn2" type="submit">Iniciar Sesión</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (isset($_POST['emailLogin']) && isset($_POST['passwordLogin'])) {
        loginAccount();
    }

    function loginAccount()
    {
        // Variables para obtener la conexión a la base de datos
        $host = "localhost";
        $port = 5432;
        $dbname = "PocketTrip";
        $user = "postgres";
        $password_db = "12345";

        try {
            // Recibir datos del formulario 
            $email = $_POST['emailLogin'];
            $raw_password = $_POST['passwordLogin'];

            // Conectar a la base de datos
            $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password_db");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consultar si el correo electrónico existe
            $consulta = $conexion->prepare("SELECT * FROM users WHERE email = ?");
            $consulta->execute([$email]);
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($consulta->rowCount() > 0 && password_verify($raw_password, $usuario['password'])) {
                // Añadir las variables del local storage con su respectivo numero
                echo '<script>';
                echo 'var Logged = "1";';
                echo 'localStorage.setItem("Logged", Logged);';
                echo 'localStorage.setItem("idUser", ' . $usuario['id_user'] . ');';
                echo 'window.location.href = "index.html";';
                echo '</script>';
                exit();
            } else {
                // Mostrar mensaje de error y redirigir a la misma pagina
                echo '<script>';
                echo 'showErrorMessage();'; // Llama a tu función personalizada
                echo '</script>';
                exit();
            }
        } catch (PDOException $e) {
            // Mostrar error
            echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
        }
    }
    ?>

</body>


</html>