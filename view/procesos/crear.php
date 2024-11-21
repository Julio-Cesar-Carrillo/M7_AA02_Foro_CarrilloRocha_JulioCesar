<?php

include './conexion.php';
session_start();
$id = $_SESSION['id_user'];
$titulo_preg = htmlspecialchars($_POST['titulo_preg']);
$text_preg = htmlspecialchars($_POST['text_preg']);

try {
    $sql = $pdo->prepare("INSERT INTO tbl_preguntas (titulo_preg, text_preg, usuario_preg) VALUES (:titulo_preg, :text_preg, :usuario_preg)");
    $sql->bindParam(":titulo_preg", $titulo_preg, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":text_preg", $text_preg, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":usuario_preg", $id, PDO::PARAM_INT);
    $sql->execute();
    header('location:../index.php');
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
