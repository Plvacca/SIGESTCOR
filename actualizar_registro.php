<?php
// Establece la conexión a la base de datos (ajusta los datos de conexión según tu configuración)
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "sigestcor";

// Establecer conexión a la base de datos (verificar que esté correcta)
$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si se recibieron los datos esperados del formulario
if (isset($_POST['id']) && isset($_POST['fechaSolicitudEdit']) && isset($_POST['deptoOrigenEdit']) && isset($_POST['deptoDestinoEdit']) && isset($_POST['estadoEdit']) && isset($_POST['descripcionEdit'])) {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $fechaSolicitudEdit = $_POST['fechaSolicitudEdit'];
    $deptoOrigenEdit = $_POST['deptoOrigenEdit'];
    $deptoDestinoEdit = $_POST['deptoDestinoEdit'];
    $estadoEdit = $_POST['estadoEdit'];
    $descripcionEdit = $_POST['descripcionEdit'];

    // Ejecutar la consulta SQL para actualizar el registro en la base de datos
    $sql = "UPDATE solicitudinterna SET FechaSolicitud = ?, DepartamentoOrigen = ?, DepartamentoDestino = ?, EstadoSolicitud = ?, Descripcion = ? WHERE IdSolicitud_interna = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssi", $fechaSolicitudEdit, $deptoOrigenEdit, $deptoDestinoEdit, $estadoEdit, $descripcionEdit, $id);
        if ($stmt->execute()) {
            // La actualización fue exitosa
            $response = [
                'success' => true,
                'message' => 'Registro actualizado exitosamente'
                // Puedes agregar otros datos actualizados aquí
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error al ejecutar la consulta SQL: ' . $stmt->error
            ];
        }
        $stmt->close();
    } else {
        $response = [
            'success' => false,
            'message' => 'Error en la preparación de la consulta SQL: ' . $conexion->error
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Datos del formulario incompletos o incorrectos'
    ];
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión a la base de datos
$conexion->close();
?>
