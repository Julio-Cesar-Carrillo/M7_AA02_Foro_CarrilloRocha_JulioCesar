<?php

include './conexion.php';

$nick = htmlspecialchars($_POST['nick']);
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$pwd = htmlspecialchars($_POST['pwd']);
$encript = password_hash($pwd, PASSWORD_BCRYPT);

try {
    $sql = $pdo->prepare("INSERT INTO tbl_usuarios (nick_user, nom_user, email_user, pwd_user, rol_user) VALUES (:nick_user, :nom_user, :email_user, :pwd_user, 1)");
    $sql->bindParam(":nick_user", $nick, PDO::PARAM_STR);
    $sql->bindParam(":nom_user", $username, PDO::PARAM_STR);
    $sql->bindParam(":email_user", $email, PDO::PARAM_STR);
    $sql->bindParam(":pwd_user", $encript, PDO::PARAM_STR);
    $sql->execute();
    header('location:../index.php');
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
