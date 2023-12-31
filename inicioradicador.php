<?php
session_start();
if (isset($_SESSION["nombre"]) && isset($_SESSION["rol"])) {
    $nombreUsuario = $_SESSION["nombre"];
    $rolUsuario = $_SESSION["rol"];
    if ($rolUsuario === "Radicador") {
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
  <link rel="stylesheet" href="css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/script.js"></script>
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
      $query = "SELECT CONCAT(Pnombre, ' ', Snombre, ' ', Papellido, ' ', Sapellido) AS NombreCompleto FROM persona WHERE IdRol = 3"; // Reemplaza "3" con el ID del usuario actual
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
      $query = "SELECT Descripcion FROM rol WHERE IdRol = 3"; // Reemplaza "3" con el ID del usuario actual
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
            <li><a href="inicioradicador.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="solicitudesradicador.php"><i class="fas fa-tasks"></i> Solicitudes</a></li>
            <li><a href="entrantesradicador.php"><i class="fas fa-download"></i> Entrantes</a></li>
            <li><a href="corresp_radicador.php"><i class="fas fa-upload"></i> Correspondencia</a></li>
            <li><a href="radicados.php"><i class="fas fa-file-alt"></i> Radicados</a></li>
         <br><br><br>
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
        <div class="main-content">
            <h2>Estadísticas</h2>
            <div class="statistics-container">
              <div class="statistics-card card-solicitudes">
                <h3>5</h3> 
                <h3>Solicitudes</h3>
              </div>
              <div class="statistics-card card-entrantes">
                <h3>10 </h3>
                <h3>Entrantes</h3>
              </div>
              <div class="statistics-card card-salientes">
                <h3>8</h3> 
                <h3>Salientes</h3>
              </div>
              <div class="statistics-card card-pendientes">
                <h3>2</h3> 
                <h3>Respuestas Pendientes</h3>
              </div>
              
              <div class="chart-container">
                <canvas id="line-chart"></canvas>
              </div>

              <table class="correspondence-table">
                <tr>
                  <td><i class="fas fa-download" alt="Entrantes"></td>
                  <td>Correspondencia Recibida</td>
                  <td>07/06/2023</td>
                </tr>
                <tr>
                  <td><i class="fas fa-upload" alt="Salientes"></i></td>
                  <td>Correspondencia Saliente</td>
                  <td>05/06/2023</td>
                </tr>
                <tr>
                  <td><i class="fas fa-tasks" alt="Solicitudes"></i></td>
                  <td>Solicitud de Trámite</td>
                  <td>03/06/2023</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="content-fila">
          <!--<div class="chart-container">
            <canvas id="line-chart"></canvas>
          </div>-->

        </div>
      </div>
</body>

</html>
