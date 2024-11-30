<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer pregunta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <img src="../img/logo.png" alt="CodeCraft" class="logo">
        <div class="header-forms">
            <form action="" method="post" id="formbusquedapregunta">
                <input type="hidden" name="mispreguntas" value="<?php if (!empty($_POST['mispreguntas'])) {
                                                                    echo "1";
                                                                } ?>">
                <input type="hidden" name="user" value="<?php if (!empty($_POST['user'])) {
                                                            echo htmlspecialchars(trim($_POST['user']));
                                                        } ?>">
                <input type="text" name="pregunta" id="inputPregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                                    echo htmlspecialchars(trim($_POST['pregunta']));
                                                                                } ?>" placeholder="Pregunta">
            </form>
            <form action="">
                <button>borrar filtros</button>
            </form>
        </div>
        <div>
            <h3><?php echo $_SESSION['nick_user']; ?></h3>
            <a href="./index.php">Volver</a>
            <a href="./procesos/logout.php">Salir</a>
        </div>
    </header>
    <div>
        <form action="./procesos/crear.php" method="post">
            <div>
                <label for="titulo_preg">titulo_preg</label>
                <input type="text" name="titulo_preg">
            </div>
            <div>
                <label for="text_preg">text_preg</label>
                <input type="text" name="text_preg">
            </div>
            <button type="submit">Crear</button>
            <button><a href="./index.php">Volver</a></button>
        </form>
    </div>

</body>

</html>