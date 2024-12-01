<?php

include './conexion.php';

// Variables del formulario
$nick = htmlspecialchars($_POST['nick']);
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$pwd = htmlspecialchars($_POST['pwd']);
$encript = password_hash($pwd, PASSWORD_BCRYPT);

try {
    // Verificar si el username o el email ya existen
    $checkSql = $pdo->prepare("SELECT COUNT(*) as count FROM tbl_usuarios WHERE nick_user = :nick_user OR email_user = :email_user");
    $checkSql->bindParam(":nick_user", $nick, PDO::PARAM_STR_CHAR);
    $checkSql->bindParam(":email_user", $email, PDO::PARAM_STR_CHAR);
    $checkSql->execute();
    $result = $checkSql->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // header("location: ../index.php?register=true");
        header("location: ../index.php?register=true&nick=" . urlencode($nick) . "&username=" . urlencode($username) . "&email=" . urlencode($email));
        exit();

        exit();
    } else {
        $sql = $pdo->prepare("INSERT INTO tbl_usuarios (nick_user, nom_user, email_user, pwd_user, rol_user) 
        VALUES (:nick_user, :nom_user, :email_user, :pwd_user, 2)");
        $sql->bindParam(":nick_user", $nick, PDO::PARAM_STR_CHAR);
        $sql->bindParam(":nom_user", $username, PDO::PARAM_STR_CHAR);
        $sql->bindParam(":email_user", $email, PDO::PARAM_STR_CHAR);
        $sql->bindParam(":pwd_user", $encript, PDO::PARAM_STR_CHAR);
        $sql->execute();
?>
        <form action="./login.php" method="POST" name="formulario">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="pwd" value="<?php echo htmlspecialchars($pwd); ?>">
        </form>
        <script language="JavaScript">
            document.formulario.submit();
        </script>
<?php
    }
} catch (PDOException $e) {
    // Si hay error en la base de datos, mostramos un mensaje de error
    $mensajeError = "Error al registrar usuario: " . $e->getMessage();
}
?>