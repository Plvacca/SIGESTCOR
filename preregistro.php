<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estiloformularios.css">
    <title>FomularioRegistro</title>
</head>
<body>
    <center>
    <section class="From_Registro">
        <h3>Registro</h3>
         <?php include"controladores/registro.php";
         ?>
         <div class="container_logo2">
            <img src="images/carta_logo.png" alt="logo" class="logo2">
         </div>
         <form  method="POST" >
            <div class="From_Registro__Columna">
                <div class="From_Registro__Fila">
                    <label for="tipoDocumento">Tipo de documento:</label>
                    <select id="tipoDocumento" name="tipoDocumento">
                        <option value="CC">Cedula de Ciudadania</option>
                        <option value="pasaporte">Pasaporte</option>
                        <option value="Cedula de Extr
                        angería">Cedula de Extrangería</option>
                        <option value="Permiso Especial de Permanecia">Permiso Especial de Permanecia</option>
                    </select>
                </div>
                <div class="From_Registro__Fila">
                    <label for="documento">Numero de documento:</label>
                    <input class="Controls1" type="text" id="documento" name="documento" pattern="[0-9]+" maxlength="13" required>
                </div>
                <div class="From_Registro__Fila">
                    <label for="primerNombre">Primer Nombre:</label>
                    <input class="Controls1" type="text" id="primerNombre" name="primerNombre" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" required>
                </div>
                <div class="From_Registro__Fila">
                    <label for="segundoNombre">Segundo Nombre:</label>
                    <input class="Controls1" type="text" id="segundoNombre" name="segundoNombre" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" >
                </div>
            </div>
            <div class="From_Registro__Columna">
                <div class="From_Registro__Fila">
                    <label for="PrimerApellido">Primer Apellido:</label>
                    <input class="Controls1" type="text" id="PrimerApellido" name="PrimerApellido" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" required>
                </div>
                <div class="From_Registro__Fila">
                    <label for="SegundoApellido">Segundo Apellido: (opcional) </label>
                    <input class="Controls1" type="text" id="SegundoApellido" name="SegundoApellido" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                </div>
                <div class="From_Registro__Fila">
                    <label for="email">Email:</label>
                    <input class="Controls1" type="email" name="email" required>
                </div>
                <div class="From_Registro__Fila">
                    <label for="telefono">Teléfono:</label>
                    <input class="Controls1" type="text" id="telefono" name="telefono" pattern="[0-9]+" maxlength="10" required>
                </div>
            </div>
            <button class="Buttons1" type="submit">Registrar</button>
            
        </form>
        
        <p><a href="for_login.php">Ya tengo Cuenta</a></p>
        <p><a href="principal.html">Inicio</a></p>

    </section>
     
</center>


</body>
</html>
