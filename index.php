<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="./procesos/login.php" method="post">
        <div>
            <label for="username">username</label>
            <input type="text" name="username" value="julio">
        </div>
        <div>
            <label for="pwd">password</label>
            <input type="password" name="pwd" value="asdASD123">
        </div>
        <button type="submit">Login</button>
        <a type="button" href="./registro.php">Registrase</a>
    </form>
</body>

</html>