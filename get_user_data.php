<?php
// Variables para obtener la conexión a la base de datos
$host = "localhost";
$port = 5432;
$dbname = "PocketTrip";
$user = "postgres";
$password_db = "12345";

try {
    // Obtener el id del usuario guardado en el localStorage
    $id_user = $_GET['id_user'];

    // Conectar a la base de datos
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password_db");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar los datos del usuario por su id
    $consulta = $conexion->prepare("SELECT * FROM users WHERE id_user = ?");
    $consulta->execute([$id_user]);
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    // Retornar los datos del usuario como un JSON
    header('Content-Type: application/json');
    echo json_encode($usuario);
} catch (PDOException $e) {
    // Mostrar mensaje de error
    echo json_encode(['error' => $e->getMessage()]);
}
?>