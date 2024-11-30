<?php

include './conexion.php';
session_start();

$id_usuario = (int)$_SESSION['id_user'];
$id_pregunta = (int)$_POST['id_pregunta'];
$titulo_preg = htmlspecialchars($_POST['titulo_preg']);
$text_preg = htmlspecialchars($_POST['text_preg']);

try {
    $sql = $pdo->prepare("UPDATE tbl_preguntas SET titulo_preg = :titulo_preg, text_preg = :text_preg, fecha_preg = NOW()
        WHERE id_preg = :id_preg ");
    $sql->bindParam(":titulo_preg", $titulo_preg, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":text_preg", $text_preg, PDO::PARAM_STR_CHAR);
    $sql->bindParam(":id_preg", $id_pregunta, PDO::PARAM_INT);
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
    // Manejo de errores
    echo "Error al actualizar la pregunta: " . $e->getMessage();
}
