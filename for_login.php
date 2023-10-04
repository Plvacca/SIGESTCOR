<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estiloformularios.css">
    <title>FormularioLogin</title>
</head>
<body>
    <section class="form_login">
        <h2>Bienvenido</h2>
        <?php
            include "controladores/controladorlogin.php";
        ?>
        
        <div class="container_logo1">
            <img src="images/carta_logo.png" alt="logo" class="logo1">
        </div>
        <form name="loginForm" action="" method="POST">
            <div>
                <label for="usuario">Usuario</label>
                <input class="Controls" type="text" name="usuario"><br>
                <label for="contraseña">Contraseña</label>
                <input class="Controls" type="password" name="password"><br>
                <button name="Bntingresar" class="Buttons" type="submit">Ingresar</button>
            </div>
        </form>
        <p><a href="preregistro.php">Regístrate</a></p>
        <p><a href="pagprincipal.html">Inicio</a></p>
    </section>
</body>
</html>
