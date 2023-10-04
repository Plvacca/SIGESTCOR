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
    if ($rolUsuario === "Administrador") {
    } else {
        header("Location: acceso_denegado.php");
        exit();
    }
} else {
    header("Location: for_login.php");
    exit();
}
$nombre_completo = $_SESSION['nombre_completo'];
?>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/datatable.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/estilosadmin.css">
    <link rel="stylesheet" href="css/estilosformsolicitud.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.pdf.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <title>SIGESTCOR</title>
</head>
<body>
<?php
$host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_de_datos = "sigestcor";

    $conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Funciones para obtener el nombre y el rol del usuario desde la base de datos.
    function obtenerNombreUsuario($conexion) {
      // Ejemplo de consulta a la base de datos para obtener el nombre completo
      $query = "SELECT CONCAT(Pnombre, ' ', Snombre, ' ', Papellido, ' ', Sapellido) AS NombreCompleto FROM persona WHERE IdRol = 1"; // Reemplaza "3" con el ID del usuario actual
      $resultado = $conexion->query($query);
  
      if ($resultado !== false && $resultado->num_rows > 0) {
          $fila = $resultado->fetch_assoc();
          return $fila["NombreCompleto"];
      } else {
          return "Nombre Completo de Usuario no encontrado";
      }
  }
  

    function obtenerRolUsuario($conexion) {
      // Ejemplo de consulta a la base de datos
      $query = "SELECT Descripcion FROM rol WHERE IdRol = 1"; // Reemplaza "3" con el ID del usuario actual
      $resultado = $conexion->query($query);
  
      if ($resultado !== false && $resultado->num_rows > 0) {
          $fila = $resultado->fetch_assoc();
          return $fila["Descripcion"];
      } else {
          return "Rol de Usuario no encontrado";
      }
  }
    ?>
    <div class="dashboard">
        <div class="sidebar">
          <div class="user-profile">
            <div class="profile-image">
            <img src="images/user.png" alt="User Image">
            </div>
            <h2><?php echo $nombre_completo; ?></h2>
                <p><?php echo obtenerRolUsuario($conexion); ?></p>
            </div>
          <ul class="menu">
            <li><a href="inicioadmin.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="solicitudes_admin.php"><i class="fas fa-tasks"></i> Solicitudes</a></li>
            <li><a href="entrantesadmin.php"><i class="fas fa-download"></i> Entrantes</a></li>
            <li><a href="corresp_admin.php"><i class="fas fa-upload"></i> Correspondencia</a></li>
            <li><a href="administracion.php"><i class="fas fa-cog"></i> Administración</a></li>
            <li><a href="for_login.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
          </ul>
        </div>
    <div class="content">
        <div class="navbar">
          <div class="logo">
            <img src="images/carta_logo.png" alt="Logo">
            <img src="images/letra_sigestcor.png" alt="letra logo" style="width: 100px; height: 20px;">
          </div>
          <div class="notifications">
            <i class="fas fa-bell"></i>
            <span class="badge">5</span>
          </div>
        </div>

                   
        <table id="miTabla" class="display">
          <thead>
              <tr>
                  <th>Número de Correspondencia</th>
                  <th>Fecha de Recibido</th>                  
                  <th>Remitente</th>
                  <th>Destinatario</th>
                  <th>Dirección</th>
                  <th>Observaciones</th>
              </tr>
          </thead>
          <tbody>
          <?php
                $sql = "SELECT * FROM ficha_entrada";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["NumCorrespondencia"] . "</td>";
                        echo "<td>" . $row["Fecha_Recibido"] . "</td>";
                        echo "<td>" . $row["Remitente"] . "</td>";
                        echo "<td>" . $row["Destinatario"] . "</td>";
                        echo "<td>" . $row["DireccionQuienEnvia"] . "</td>";
                        echo "<td>" . $row["ObservacionesEntrada"] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
             

          </tbody>
      </table>
        
    </div>
    </div>

    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.2/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
  $(document).ready(function() {
    // Initialize DataTable with Buttons extension
    var table = $('#miTabla').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Configura el idioma a español
        },
        "searching": true,
        "dom": 'Bfrtip', // Buttons extension configuration
        "buttons": [
            {
                extend: 'csv',
                className: 'dt-button' // Add class for styling
            },
            {
                extend: 'pdf',
                className: 'dt-button' // Add class for styling
            },
            {
                extend: 'excel',
                className: 'dt-button' // Add class for styling
            }
        ]
    });

    $('#btnCrear').click(function() {
        $('#formularioCrear').toggle();
    });
});

    </script>


    
    
</body>
</html>