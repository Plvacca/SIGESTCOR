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
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilos.css">
  <link rel="stylesheet" href="css/estilosadmin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/jsadmin.js"></script>
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
          <span class="badge">0</span>
        </div>
      </div>

      <div class="crud-container">
      
        <div class="crud-card">
          <i class="fas fa-users"></i>
          <h2>Usuarios</h2>
          <p>Administra usuarios</p>
          <button class="crud-button" id="user-admin-btn">Administrar</button>
    
          <div id="user-admin-area" style="display: none;">
           
            <div class="button-area">
              <button class="crud-button" id="create-user-btn">Asignar</button>
              <button class="crud-button" id="user-consult-btn">Consultar</button>
              <button class="crud-button" id="user-update-btn">Actualizar</button>
              <button class="crud-button" id="delete-user-btn">Eliminar</button>
            </div>

           
            <div id="user-create-form" style="display: none;">
              <form action="" method="post">
                <h2>Asignar Usuario</h2>
                <?php include_once "controladores/acontroladorAsignar.php"; ?>
                <div class="form-group">
                  <label for="numero-documento">Número de Documento:</label>
                  <select name="numero-documento" required>
                    <option value="">Selecciona un documento</option>
                    <?php
                    
                    $cedulasPreregistradas = obtenerCedulasPreregistradas();
                    foreach ($cedulasPreregistradas as $cedula) {
                      echo "<option value='$cedula'>$cedula</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="nombre-usuario">Nombre de Usuario:</label>
                  <input type="text" id="nombre-usuario" name="nombre-usuario" required>
                </div>
                <div class="form-group">
                  <label for="contrasena">Contraseña:</label>
                  <input type="password" id="contrasena" name="contrasena" required>
                </div>
                <div class="form-group">
                  <label for="rol">Rol del Usuario:</label>
                  <select name="rol" required>
                    <option value="">Seleccione el Rol</option>
                    <option value="1">Administrador</option>
                    <option value="2">Funcionario</option>
                    <option value="3">Radicador</option>
                  </select>
                </div>
                <button type="submit" class="btn-submit">Guardar</button>
              </form>
            </div>
            
            <div id="user-consult-form" style="display: none;">
              <form action="" method="post">
                <h2>Consultar Usuarios</h2>
                <?php include_once "controladores/consultar.php"; ?>
              </form>
            </div>
            
            <div id="user-update-form" style="display: none;">
              <form action="" method="post">
                <h2>Actualizar Usuario</h2>
                <?php include_once "controladores/ActualizarUsuario.php"; ?>
                <div class="form-group">
                  <label for="cedulas-activas">Cédulas Activas:</label>
                  <select id="cedulas-activas" name="numero-documento-actualizar" required>
                    <option value="">Selecciona una cédula</option>
                    <?php
                    // lista desplegable
                    $cedulasPreregistradas = obtenerCedulas();
                    foreach ($cedulasPreregistradas as $cedula) {
                      echo "<option value='$cedula'>$cedula</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="nombre-usuario-actualizar">Nuevo Nombre de Usuario:</label>
                  <input type="text" id="nombre-usuario-actualizar" name="nombre-usuario-actualizar" required>
                </div>
                <div class="form-group">
                  <label for="contrasena-actualizar">Nueva Contraseña:</label>
                  <input type="password" id="contrasena-actualizar" name="contrasena-actualizar" required>
                </div>
                <div class="form-group">
                  <label for="rol-actualizar">Nuevo Rol:</label>
                  <select id="rol-actualizar" name="rol-actualizar" required>
                    <option value="">Seleccione el Rol</option>
                    <option value="1">Administrador</option>
                    <option value="2">Funcionario</option>
                    <option value="3">Radicador</option>
                  </select>
                </div>
                <button type="submit" class="btn-submit">Actualizar</button>
              </form>
            </div>
            
            <div id="user-delete-details" style="display: none;">
              <h3>Eliminar Usuario</h3>
              <?php include_once "controladores/eliminar_usuario.php";?>
              <form action="" method="post">
                  <h2>Buscar Usuario</h2>
                  <div class="form-group">
                      <label for="numeroDocumento">Número de Documento:</label>
                      <input type="text" id="numeroDocumento" name="numeroDocumento" required>
                  </div>
                  <button type="submit" name="buscar-usuario">Buscar</button>
                  
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</body>
</html>
