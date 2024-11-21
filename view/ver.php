<?php
include './procesos/conexion.php';

$id = $_POST['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuestas</title>
</head>

<body>
    <div>
        <div>
            <?php
            $sql = $pdo->prepare("SELECT p.*, u.nick_user, r.id_resp, r.resp_resp, r.fecha_resp, ur.nick_user AS resp_user, r.fecha_resp AS resp_fecha
                                  FROM tbl_preguntas p 
                                  INNER JOIN tbl_usuarios u ON p.usuario_preg = u.id_user
                                  LEFT JOIN tbl_respuestas r ON p.id_preg = r.preg_resp
                                  LEFT JOIN tbl_usuarios ur ON r.usuario_resp = ur.id_user
                                  WHERE p.id_preg = :id_preg
                                  ORDER BY r.fecha_resp DESC");
            $sql->bindParam(":id_preg", $id, PDO::PARAM_INT);
            $sql->execute();
            $preguntasrespuestas = $sql->fetchAll(PDO::FETCH_ASSOC);

            $pregunta = null;
            $respuestas = [];

            foreach ($preguntasrespuestas as $preguntasrespuesta) {
                if (!$pregunta) {
                    $pregunta = $preguntasrespuesta;
                }

                if (!empty($preguntasrespuesta['resp_resp']) || !empty($preguntasrespuesta['resp_user'])) {
                    $respuestas[] = $preguntasrespuesta;
                }
            }
            ?>

            <?php if ($pregunta) { ?>
                <h2><?php echo $pregunta['titulo_preg']; ?></h2>
                <p><?php echo $pregunta['text_preg']; ?></p>
            <?php } ?>
        </div>

        <div>
            <h1>Respuestas</h1>
            <?php if (!empty($respuestas)) { ?>
                <?php foreach ($respuestas as $respuesta): ?>
                    <p>De: <?php echo $respuesta['resp_user']; ?></p>
                    <p><?php echo $respuesta['resp_resp']; ?></p>
                <?php endforeach; ?>
            <?php } else { ?>
                <p>No hay respuestas</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>