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
?>
    <form action="../index.php" method="POST" name="formulario">
        <input type="hidden" name="mispreguntas" value="<?php echo htmlspecialchars($_POST['mispreguntas']); ?>">
        <input type="hidden" name="user" value="<?php echo htmlspecialchars($_POST['user']); ?>">
        <input type="hidden" name="pregunta" value="<?php echo htmlspecialchars($_POST['pregunta']); ?>">
    </form>
    <script language="JavaScript">
        document.formulario.submit();
    </script>
<?php
} catch (PDOException $e) {
    echo "conexion fallida" . $e->getMessage();
}
