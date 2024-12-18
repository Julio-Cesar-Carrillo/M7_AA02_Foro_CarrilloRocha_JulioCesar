<?php

include './conexion.php';
session_start();
$id = (int)$_SESSION['id_user'];
$titulo_preg = htmlspecialchars($_POST['titulo_preg']);
$text_preg = htmlspecialchars($_POST['text_preg']);

try {
    $sql = $pdo->prepare("INSERT INTO tbl_preguntas (titulo_preg, text_preg, usuario_preg,fecha_preg) VALUES (:titulo_preg, :text_preg, :usuario_preg,NOW())");
    $sql->bindParam(":titulo_preg", $titulo_preg, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":text_preg", $text_preg, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":usuario_preg", $id, PDO::PARAM_INT);
    $sql->execute();
?>
    <form action="../index.php" method="POST" name="formulario">
        <input type="text" name="mispreguntas" value="<?php echo htmlspecialchars($_POST['mispreguntas']); ?>">
        <input type="text" name="user" value="<?php echo htmlspecialchars($_POST['user']); ?>">
        <input type="text" name="pregunta" value="<?php echo htmlspecialchars($_POST['pregunta']); ?>">
    </form>
    <script language="JavaScript">
        document.formulario.submit();
    </script>
<?php
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
