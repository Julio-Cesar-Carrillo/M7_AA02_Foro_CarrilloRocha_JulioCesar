<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('location:../');
}

$preg_resp = htmlspecialchars($_POST['preg_resp']);
$resp_resp = htmlspecialchars($_POST['resp_resp']);
$id = $_SESSION['id_user'];
$fecha_resp = date('Y-m-d');

include './conexion.php';

try {
    $sql = $pdo->prepare("INSERT INTO tbl_respuestas (preg_resp, resp_resp, usuario_resp, fecha_resp) 
    VALUES (:preg_resp, :resp_resp, :usuario_resp, :fecha_resp)");
    $sql->bindParam(":preg_resp", $preg_resp, PDO::PARAM_INT);
    $sql->bindParam(":resp_resp", $resp_resp, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":usuario_resp", $id, PDO::PARAM_INT);
    $sql->bindParam(":fecha_resp", $fecha_resp, PDO::PARAM_STR_CHAR);
    $sql->execute();
    header('location:../index.php');
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
