<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer pregunta</title>
</head>

<body>
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
</body>

</html>