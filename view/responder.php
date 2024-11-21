<?php

session_start();

$id = $_POST['id'];
$titulopregunta = $_POST['pregunta'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulopregunta; ?></title>
</head>

<body>
    <div>
        <div>
            <?php
            include './procesos/conexion.php';
            $sql = "SELECT * FROM tbl_preguntas WHERE id_preg=:id_preg";
            $sql = $pdo->prepare($sql);
            $sql->bindParam(":id_preg", $id, PDO::PARAM_INT);
            $sql->execute();
            $preguntas = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($preguntas as $pregunta) {
            ?>
                <p>Titulo: <?php echo $pregunta['titulo_preg']; ?></p>
                <p><?php echo $pregunta['text_preg']; ?></p>
            <?php
            }
            ?>
        </div>
        <div>
            <form action="./procesos/respuesta.php" method="post">
                <div>
                    <input type="hidden" name="preg_resp" value="<?php echo $id; ?>">
                    <input type="hidden" name="usuario_resp" value="<?php echo $_SESSION['id_user']; ?>">
                    <label for="resp_resp">Escribe una respuesta:</label>
                    <br>
                    <!-- <input type="text" name="resp_resp" placeholder="Puedes probar a..."> -->
                    <br>
                    <textarea name="resp_resp" placeholder="Puedes probar a..." rows="6" cols="50"></textarea>
                </div>
                <button>Responder</button>
            </form>
        </div>
    </div>
</body>

</html>