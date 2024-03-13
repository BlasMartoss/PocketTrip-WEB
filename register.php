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
                <button id="account_button3"><a href="login.php">Iniciar Sesión</a></button>
                <button id="account_button4">Crear Cuenta</button>
            </div>
        </div>
        <div id="main_container">
            <div id="second_container">
                <div>
                    <a href="index.html"><img id="big_container" src="images/big_icon.png" alt=""></a>
                </div>


                <form id="registroForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                    <div id="container_name">
                        <img class="icons" src="images/icon_person.png" alt="Icon de nombre">
                        <input type="text" id="inputs_nombre" class="inputs" name="nombre" placeholder="Nombre"
                            required>
                    </div>
                    <div id="container_dni">
                        <img class="icons" src="images/name_icon.png" alt="Icon de dni">
                        <input type="text" id="inputs_dni" class="inputs" name="dni" placeholder="DNI" required>
                    </div>
                    <div id="error_dni_existente">
                        <p>El DNI utilizado ya existe en la base de datos.</p>
                    </div>
                    <div id="container_email_1">
                        <img class="icons" src="images/emailIcon.png" alt="Icon de persona">
                        <input type="text" id="inputs_email" class="inputs" name="email" placeholder="Email" required>
                    </div>
                    <div id="error_email">
                        <p>El formato del correo electrónico no es válido. Ejemplo: ejemplo@gmail.com.</p>
                    </div>
                    <div id="error_email_existente">
                        <p>El email utiliado ya existe en la base de datos.</p>
                    </div>
                    <div id="container_password_1">
                        <img class="icons" src="images/candado.png" alt="Icon de candado">
                        <input type="password" id="inputs_password" class="inputs" name="password"
                            placeholder="Contraseña" required>
                    </div>
                    <div id="container_password_3">
                        <img class="icons" src="images/candado.png" alt="Icon de candado">
                        <input type="password" id="inputs_password" class="inputs" name="password_repeated"
                            placeholder="Repetir Contraseña" required>
                    </div>
                    <div id="error_password">
                        <p>Las contraseñas no coinciden</p>
                    </div>
                    <div id="label_div">
                        <label for="acepta_terminos">
                            <input type="checkbox" id="acepta_terminos" name="acepta_terminos" required>
                            ¿Está de acuerdo con los términos de servicio?
                        </label>
                    </div>
                    <div id="button_container">
                        <button id="btn" type="submit">Crear Cuenta</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    </div>

<?php
    if (isset($_POST['nombre']) && isset($_POST['dni']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeated']) && isset($_POST['acepta_terminos']))  {
            createAccount();
        }

        function createAccount(){
                // Variables para obtener la conexión a la base de datos
                $host = "localhost";
                $port = 5432;
                $dbname = "PocketTrip";
                $user = "postgres";
                $password_db = "12345";

                try {
                    // Recibir datos del formulario mediante POST
                    $dni = $_POST['dni'];
                    $name = $_POST['nombre'];
                    $email = $_POST['email'];
                    $raw_password = $_POST['password'];
                    $raw_password2 = $_POST['password_repeated'];
                    // Hash de la contraseña
                    $password = password_hash($raw_password, PASSWORD_DEFAULT);
                    // Conectar a la base de datos
                    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password_db");
                    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consultar si el DNI ya existe
                    $consultaDNI = $conexion->prepare("SELECT dni FROM users WHERE dni = ?");
                    $consultaDNI->execute([$dni]);

                    // Consultar si el correo electrónico ya existe
                    $consultaEmail = $conexion->prepare("SELECT email FROM users WHERE email = ?");
                    $consultaEmail->execute([$email]);
                    echo '<script>';
                    echo 'showErrorDNI(false);'; 
                    echo '</script>';
                    echo '<script>';
                    echo 'showErrorEmailExistente(false);'; 
                    echo '</script>';
                    echo '<script>';
                    echo 'showErrorEmail(false);';
                    echo '</script>';
                    echo '<script>';
                    echo 'showErrorPassword(false);';
                    echo '</script>';
                    if($raw_password != $raw_password2){
                        // Validar que las 2 contraseñas sean iguales
                        echo '<script>';
                        echo 'showErrorPassword(true);';
                        echo '</script>';

                    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        // Validar el formato del correo electrónico (debe contener '@' y '.')
                        echo '<script>';
                        echo 'showErrorEmail(true);';
                        echo '</script>';
                    }elseif ($consultaDNI->rowCount() > 0) {
                        // Verificar si el DNI ya existe
                        echo '<script>';
                        echo 'showErrorDNI(true);'; 
                        echo '</script>';
                    
                    }elseif($consultaEmail->rowCount() > 0) {
                        // Verificar si el correo electrónico ya existe
                        echo '<script>';
                        echo 'showErrorEmailExistente(true);'; 
                        echo '</script>';
                    
                    } else{
                        // Si el DNI y el correo electrónico no existen, insertar el nuevo usuario
                        $insertarUsuario = $conexion->prepare("INSERT INTO users (dni, name, email, password) VALUES (?, ?, ?, ?)");
                        $insertarUsuario->execute([$dni, $name, $email, $password]);

                        // Verificar si la inserción fue exitosa
                        if ($insertarUsuario->rowCount() > 0) {
                            // Después de insertar el usuario, realizar una nueva consulta para obtener su id_user
                            $consultaUsuarioInsertado = $conexion->prepare("SELECT id_user FROM users WHERE email = ?");
                            $consultaUsuarioInsertado->execute([$email]);
                            $usuarioInsertado = $consultaUsuarioInsertado->fetch(PDO::FETCH_ASSOC);

                            // Verificar si la consulta fue exitosa
                            if ($consultaUsuarioInsertado->rowCount() > 0) {
                                // Establecer valor en localStorage y redirigir a index.html
                                echo '<script>';
                                echo 'var Logged = "1";';
                                echo 'localStorage.setItem("Logged", Logged);';
                                echo 'localStorage.setItem("idUser", ' . $usuarioInsertado['id_user'] . ');';
                                echo 'window.location.href = "index.html";';
                                echo '</script>';
                                exit();
                            } else {
                                echo '<script>alert("Error: No se pudo obtener el id_user del usuario recién insertado.");</script>';
                            }
                        } else {
                            echo '<script>alert("Error: No se pudo insertar el usuario.");</script>';
                        }
                    }
                    
                } catch (PDOException $e) {
                    // Enviar un mensaje de error al cliente
                    echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
                }
        }
?>
</body>


</html>