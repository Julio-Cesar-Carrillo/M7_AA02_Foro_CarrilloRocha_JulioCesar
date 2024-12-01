<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register - MagtimusPro</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="./assets/js/validacion.js"></script>

    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>

    <main>

        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form action="./procesos/login.php" method="post" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($_GET['nick'] ?? ''); ?>">
                    <span class="error"></span>
                    <input type="password" name="pwd" placeholder="Contraseña" value="<?php echo htmlspecialchars($_GET['pwd'] ?? ''); ?>">
                    <span class="error"><?php echo isset($_GET['nick']) && isset($_GET['pwd']) ? 'Usuario o contraseña incorrectos' : ''; ?></span>
                    <button>Entrar</button>
                </form>

                <!--Register-->
                <form action="./procesos/registro.php" method="post" class="formulario__register">
                    <h2>Regístrarse</h2>
                    <input type="text" name="nick" placeholder="Nick/Apodo" value="<?php echo htmlspecialchars($_GET['nick'] ?? ''); ?>">
                    <span class="error"></span>
                    <input type="text" name="username" placeholder="Usuario" value="<?php echo htmlspecialchars($_GET['username'] ?? ''); ?>">
                    <span class="error"></span>
                    <input type="text" name="email" placeholder="Correo Electrónico" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
                    <span class="error"></span>
                    <input type="password" name="pwd" placeholder="Contraseña">
                    <span class="error"><?php echo htmlspecialchars($_GET['register'] ? 'Intenta con otro usuario o correo' : ''); ?></span>
                    <button>Regístrarse</button>
                </form>
            </div>
        </div>

    </main>

    <script src="assets/js/script.js"></script>
</body>

</html>