<?php
session_start();
if (isset($_SESSION["nombre"]) && isset($_SESSION["rol"])) {
    $nombreUsuario = $_SESSION["nombre"];
    $rolUsuario = $_SESSION["rol"];
    if ($rolUsuario === "Funcionario") {
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
  <link rel="stylesheet" href="css/estilossolicitudesfuncionario.css">
  <link rel="stylesheet" href="css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
  <script>
    window.onload = function () {
        window.history.forward();
    };

    window.onbeforeunload = function () {
        return "¿Estás seguro de que quieres abandonar esta página?";
    };
  </script>
  <title>SIGESTCOR</title>
</head>
<body>
  <div class="dashboard">
    <div class="sidebar">
      <div class="user-profile">
        <div class="profile-image">
          <img src="images/user.png" alt="User Image">
        </div>
        <?php  echo "<h2>$nombreUsuario</h2>";
              echo "<p>$rolUsuario</p>";
        ?>
      </div>
      <ul class="menu">
            <li><a href="iniciofuncionario.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="solicitudesfuncionario.php"><i class="fas fa-tasks"></i> Solicitudes</a></li>
            <li><a href="entrantesfuncionario.php"><i class="fas fa-download"></i> Entrantes</a></li>
            <li><a href="correspfuncionario.php"><i class="fas fa-upload"></i> Correspondencia</a></li>
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

      <div class="main-content" style="flex-grow: 1;">
        <div>
          <!-- Botón "Crear" para abrir el formulario -->
          <button onclick="openCreateForm()" class="create-button"> Nueva Correspondencia </button>
        </div>

        <!-- Formulario para crear una nueva entrada (inicialmente oculto) -->
        <div id="createFormContainer">
          <div id="createForm">
            <h2>Crear Correspondencia</h2>
            <form>
              <label for="fecha">Fecha:</label>
              <input type="date" id="fecha" name="fecha" required>

              <label for="origen">Empresa Destino</label>
              <input type="text" id="origen" name="origen" required>

              <label for="observaciones">Observaciones:</label>
              <textarea id="observaciones" name="observaciones" rows="4" required></textarea>

              <label for="adjuntar">Adjuntar Archivo:</label>
              <input type="file" id="adjuntar" name="adjuntar">

              <button type="submit">Enviar</button>
              <button type="button" onclick="closeCreateForm()">Cancelar</button>

            </form>
          </div>
        </div>

        <table id="miTabla" class="display">
          <thead>
              <tr>
                <th>Número de Correspondencia</th>
                <th>Fecha Salida</th>                  
                <th>Empresa Destinatario</th>
                <th>Observaciones</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>001</td>
                  <td>Nombre del Destinatario 1</td>
                  <td>2023-09-15</td>
                  <td>Asunto 1</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
                  <td></td>
                  <td></td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              <tr>
                  <td>002</td>
                  <td>Nombre del Destinatario 2</td>
                  <td>2023-09-16</td>
                  <td>Asunto 2</td>
              </tr>
              
          </tbody>
        </table>
        <button id="visualizarBtn">Visualizar</button>
        <button id="exportarBtn">Exportar a Excel</button>

          
      </div>
    </div>
  </div>

  <script>
    var registrosSeleccionados = [];
    var miTabla;

    $(document).ready(function () {
      // Inicializa DataTables en la tabla
      miTabla = $('#miTabla').DataTable();

      // Maneja la selección de registros en la tabla
      $('#miTabla tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
        var registro = miTabla.row(this).data(); // Obtiene los datos de la fila
        if ($(this).hasClass('selected')) {
          registrosSeleccionados.push(registro);
        } else {
          var index = registrosSeleccionados.indexOf(registro);
          if (index !== -1) {
            registrosSeleccionados.splice(index, 1);
          }
        }
      });
    });

    // Función para visualizar registros seleccionados
    function visualizarRegistros() {
      // Haz algo con los registros seleccionados, por ejemplo, muestra una ventana modal con los detalles
      console.log(registrosSeleccionados);
    }

    // Función para exportar registros seleccionados a Excel
    function exportarRegistros() {
      // Exporta registrosSeleccionados a Excel utilizando la biblioteca xlsx.js
      if (registrosSeleccionados.length > 0) {
        var datos = [['Columna 1', 'Columna 2', 'Columna 3']]; // Encabezados
        registrosSeleccionados.forEach(function (registro) {
          // Agrega los datos de cada registro
          datos.push([registro[0], registro[1], registro[2]]);
        });

        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(datos);
        XLSX.utils.book_append_sheet(wb, ws, 'Registros');

        // Descargar el archivo Excel
        XLSX.writeFile(wb, 'registros.xlsx');
      } else {
        alert('No se han seleccionado registros para exportar.');
      }
    }

    // Función para abrir el formulario (agrega tu lógica aquí)
function openCreateForm() {
  document.getElementById("createFormContainer").style.display = "flex";
}

// Función para cerrar el formulario
function closeCreateForm() {
  document.getElementById("createFormContainer").style.display = "none";
}
document.getElementById("createFormContainer").addEventListener("click", function (event) {
  if (event.target === this) {
    closeCreateForm();
  }
});
  </script>
</body>
</html>