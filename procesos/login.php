<?php

include './conexion.php';

$username = $_POST['username'];
echo $username;
$pwd = $_POST['pwd'];

try {
    $sql = $pdo->prepare("SELECT * FROM tbl_usuarios WHERE nom_user = :user");
    $sql->bindParam(":user", $username, PDO::PARAM_STR);
    $sql->execute();
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if ($usuario &&  password_verify($pwd, $usuario['pwd_user'])) {
        session_start();
        $_SESSION['id_user'] = $usuario['id_user'];
        $_SESSION['nom_user'] = $usuario['nom_user'];
        $_SESSION['nick_user'] = $usuario['nick_user'];
        header("location: ../view");
        exit();
    } else {
        header("location: ../index.php?nom=" . $username . "&pwd=" . $pwd);
        exit();
    }
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
