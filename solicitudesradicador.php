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
    if ($rolUsuario === "Radicador") {
    } else {
        header("Location: acceso_denegado.php");
        exit();
    }
} else {
    header("Location: for_login.php");
    exit();
}

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
            <h2><?php echo obtenerNombreUsuario($conexion); ?></h2>
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

        <button id="btnCrear">Crear</button>
        <div id="formularioCrear" style="display: none;">
        <fieldset>
    <form method="POST" action="guardar_registro.php">
    <label for="fechaSolicitud">Fecha de Solicitud:</label>
    <input type="date" id="fechaSolicitud" name="fechaSolicitud" required><br>

    <label for="deptoOrigen">Departamento de Origen:</label>
    <input type="text" id="deptoOrigen" name="deptoOrigen" required><br>

    <label for="deptoDestino">Departamento de Destino:</label>
    <input type="text" id="deptoDestino" name="deptoDestino" required><br>

    <label for="observaciones">Observaciones:</label>
    <textarea id="observaciones" name="observaciones"></textarea><br>

    <label for="archivos">Archivos:</label>
    <input type="file" id="archivos" name="archivos" multiple><br><br>

    <input type="submit" value="Guardar">
  </form>
</fieldset>
</div>

                   
        <table id="miTabla" class="display">
          <thead>
              <tr>
                  <th>Número de Correspondencia</th>
                  <th>Fecha de Solicitud</th>                  
                  <th>Dpto Origen</th>
                  <th>Dpto Destino</th>
                  <th>Estado</th>
                  <th>Descripción</th>
                  <th></th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
          <?php
                $sql = "SELECT * FROM solicitudinterna";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["IdSolicitud_interna"] . "</td>";
                        echo "<td>" . $row["FechaSolicitud"] . "</td>";
                        echo "<td>" . $row["DepartamentoOrigen"] . "</td>";
                        echo "<td>" . $row["DepartamentoDestino"] . "</td>";
                        echo "<td>" . $row["EstadoSolicitud"] . "</td>";
                        echo "<td>" . $row["Descripcion"] . "</td>";
                        echo "<td><button class='editarBtn' data-id='" . $row["IdSolicitud_interna"] . "'>Editar</button></td>";
                        echo "<td><button class='verBtn' data-id='" . $row["IdSolicitud_interna"] . "'>Ver</button></td>";
                        echo "</tr>";
                    }
                }
                ?>            
          </tbody>
      </table>
        
      <div id="formularioEditar" style="display: none;">
      <form id="formEditar" class="editarForm" method="POST" action="actualizar_registro.php">
    <input type="hidden" id="id" name="id" value="">
    <label for="fechaSolicitudEdit">Fecha de Solicitud:</label>
    <input type="date" id="fechaSolicitudEdit" name="fechaSolicitudEdit" required><br>

    <label for="deptoOrigenEdit">Departamento de Origen:</label>
    <input type="text" id="deptoOrigenEdit" name="deptoOrigenEdit" required><br>

    <label for="deptoDestinoEdit">Departamento de Destino:</label>
    <input type="text" id="deptoDestinoEdit" name="deptoDestinoEdit" required><br>

    <label for="deptoOrigenEdit">Estado:</label>
    <input type="text" id="estadoEdit" name="estadoEdit" required><br>

    <label for="deptoOrigenEdit">Descripción:</label>
    <input type="text" id="descripcionEdit" name="descripcionEdit" required><br>

    <label for="archivosEdit">Archivos:</label>
    <input type="file" id="archivosEdit" name="archivosEdit" multiple><br><br>

    <button type="submit">Guardar Cambios</button>
  </form>
</div>
<div id="exitoMensaje" style="display: none;">
  <p>¡Los cambios se guardaron exitosamente!</p>
</div>

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



$('#miTabla').on('click', '.editarBtn', function() {
      var solicitudId = $(this).data('id');

      $.ajax({
        type: 'GET',
        url: 'obtener_registro.php',
        data: { id: solicitudId },
        dataType: 'json',
        success: function(data) {
          // Rellenar el formulario con los datos obtenidos
          $('#fechaSolicitudEdit').val(data.FechaSolicitud);
          $('#deptoOrigenEdit').val(data.DepartamentoOrigen);
          $('#deptoDestinoEdit').val(data.DepartamentoDestino);
          $('#estadoEdit').val(data.EstadoSolicitud);
          $('#descripcionEdit').val(data.Descripcion);
          

          $('#id').val(solicitudId);
        },
        error: function() {
          alert('Error al obtener los datos del registro.');
        }
      });

      // Mostrar el formulario de edición
      $('#formularioEditar').show();
    });

    // Evitar la recarga de la página al enviar el formulario de edición
    $('#formularioEditar form').submit(function(e) {
      e.preventDefault();
    });

    // Manejar la respuesta del formulario de edición
$('#formEditar').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
      type: 'POST',
      url: 'actualizar_registro.php',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        if (response.success) {
          // Actualizar la fila de la tabla con los nuevos datos
          actualizarFilaEnTabla(response.data);

          // Recargar la página después de 2 segundos para mostrar los cambios en la tabla
          setTimeout(function() {
            location.reload();
          }, 2000);
        } else {
          alert('Error al actualizar el registro.');
        }
      },
      error: function() {
        alert('Error al enviar el formulario de edición.');
      }
    });
  });

function actualizarFilaEnTabla(data) {
    var solicitudId = data.IdSolicitud_interna;
    var fila = $('#miTabla').find('tr[data-id="' + solicitudId + '"]');
    fila.find('td:eq(1)').text(data.FechaSolicitud);
    fila.find('td:eq(2)').text(data.DepartamentoOrigen);
    fila.find('td:eq(3)').text(data.DepartamentoDestino);
    fila.find('td:eq(4)').text(data.EstadoSolicitud);
    fila.find('td:eq(5)').text(data.Descripcion);
}

  
    


    </script>


    
    
</body>
</html>