<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./procesos/registro.php" method="post">
        <div>
            <label for="nick">Nick</label>
            <input type="text" name="nick">
        </div>
        <div>
            <label for="username">Nombre</label>
            <input type="text" name="username">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" name="email">
        </div>
        <div>
            <label for="pwd">password</label>
            <input type="password" name="pwd">
        </div>
        <button type="submit">Registrarme</button>
        <a type="button" href="./index.php">Ya tengo cuenta</a>
    </form>
</body>

</html>