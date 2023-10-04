<?php
session_start();

$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "sigestcor";

$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

if (isset($_SESSION["nombre"]) && isset($_SESSION["rol"])) {
    $nombreUsuario = $_SESSION["nombre"];
    $rolUsuario = $_SESSION["rol"];
    if ($rolUsuario !== "Administrador") {
        header("Location: acceso_denegado.php");
        exit();
    }
} else {
    header("Location: for_login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fechaSolicitud = $_POST["fechaSolicitud"];
    $deptoOrigen = $_POST["deptoOrigen"];
    $deptoDestino = $_POST["deptoDestino"];
    $observaciones = $_POST["observaciones"];

    // You can add more validation and sanitization here

    // Insert data into the database
    $sql = "INSERT INTO solicitudinterna (FechaSolicitud, DepartamentoOrigen, DepartamentoDestino, Descripcion) 
            VALUES ('$fechaSolicitud', '$deptoOrigen', '$deptoDestino', '$observaciones')";

    if ($conexion->query($sql) === true) {
        // Data inserted successfully
        header("Location: solicitudes_admin.php"); // Redirect to the page after successful submission
        exit();
    } else {
        // Error in SQL query
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

$conexion->close();
?>
