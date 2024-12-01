<?php

include './conexion.php';

$username = htmlspecialchars($_POST['username']);
$pwd = htmlspecialchars($_POST['pwd']);
try {
    $sql = $pdo->prepare("SELECT * FROM tbl_usuarios WHERE nick_user = :nick_user");
    $sql->bindParam(":nick_user", $username, PDO::PARAM_STR_CHAR);
    $sql->execute();
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if ($usuario &&  password_verify($pwd, $usuario['pwd_user'])) {
        session_start();
        $_SESSION['id_user'] = $usuario['id_user'];
        $_SESSION['nom_user'] = $usuario['nom_user'];
        $_SESSION['nick_user'] = $usuario['nick_user'];
        header("location: ../view/index.php");
        exit();
    } else {
        header("location: ../index.php?nick=" . $username . "&pwd=" . $pwd);
        exit();
    }
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
