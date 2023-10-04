<?php
// obtener_registro.php

// Establece la conexión a la base de datos (ajusta los datos de conexión según tu configuración)
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "sigestcor";

// Establecer conexión a la base de datos (verificar que esté correcta)
$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Realiza una consulta SQL para obtener los datos del registro por ID
    $query = "SELECT FechaSolicitud, DepartamentoOrigen, DepartamentoDestino, EstadoSolicitud, Descripcion FROM solicitudinterna WHERE IdSolicitud_interna = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fechaSolicitud, $deptoOrigen, $deptoDestino, $estado, $descripcion);

    if ($stmt->fetch()) {
        // Devuelve los datos en formato JSON
        echo json_encode([
            'FechaSolicitud' => $fechaSolicitud,
            'DepartamentoOrigen' => $deptoOrigen,
            'DepartamentoDestino' => $deptoDestino,
            'EstadoSolicitud' => $estado,
            'Descripcion' => $descripcion
        ]);
    } else {
        echo json_encode(['error' => 'Registro no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
