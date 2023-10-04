<?php
// obtener_datos_tabla.php

// Establece la conexión a la base de datos (ajusta los datos de conexión según tu configuración)
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "sigestcor";

$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Realiza una consulta SQL para obtener los datos de la tabla solicitudinterna
$query = "SELECT * FROM solicitudinterna";
$resultado = $conexion->query($query);

if ($resultado) {
    $data = array();

    while ($fila = $resultado->fetch_assoc()) {
        // Agrega cada fila como un elemento en el arreglo $data
        $data[] = $fila;
    }

    // Devuelve los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'Error en la consulta SQL: ' . $conexion->error));
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
