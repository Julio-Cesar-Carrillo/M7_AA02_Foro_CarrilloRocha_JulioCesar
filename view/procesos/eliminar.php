<?php

$id = htmlspecialchars($_POST['id']);

include './conexion.php';

try {

    $stmt = $pdo->prepare("DELETE FROM tbl_respuestas WHERE preg_resp =:preg_resp");
    $stmt->bindParam(':preg_resp', $id, PDO::PARAM_INT);
    $stmt->execute();

    $stmt = $pdo->prepare("DELETE FROM tbl_preguntas WHERE id_preg =:id_preg");
    $stmt->bindParam(':id_preg', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('location:../index.php');
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
