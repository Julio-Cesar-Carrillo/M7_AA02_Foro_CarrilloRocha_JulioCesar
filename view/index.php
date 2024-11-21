<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('location:../');
    exit();
}
$id = $_SESSION['id_user'];
include './procesos/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>
    <div>
        <p>Bienvenido <?php echo $_SESSION['nom_user']; ?> </p>
    </div>
    <div>
        <h2>Preguntas de la comunidad</h2>
        <div>
            <form action="" method="post">
                <div>
                    <label for="user">user</label>
                    <input type="text" name="user" value="<?php if (!empty($_POST['user'])) {
                                                                echo  $_POST['user'];
                                                            } ?>">
                </div>
                <div>
                    <label for="pregunta">pregunta</label>
                    <input type="text" name="pregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                    echo  $_POST['pregunta'];
                                                                } ?>">
                </div>
                <button>Buscar</button>
                <button><a href="./">Borrar filtros</a></button>
                <button><a href="./crear_pregunta.php">Crear pregunta</a></button>
            </form>
        </div>

        <table border="1px">
            <thead>
                <tr>
                    <th>Nick</th>
                    <th>Pregunta</th>
                    <th>Fecha</th>
                    <th>Responder</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, u.nick_user FROM tbl_preguntas p 
                    INNER JOIN tbl_usuarios u ON p.usuario_preg = u.id_user 
                    WHERE p.usuario_preg != :usuario_preg";
                if (!empty($_POST['user'])) {
                    $sql .= " AND u.nick_user LIKE :filtrouser";
                }
                if (!empty($_POST['pregunta'])) {
                    $sql .= " AND titulo_preg LIKE :filtropregunta";
                }
                $sql = $pdo->prepare($sql);
                $sql->bindParam(":usuario_preg", $id, PDO::PARAM_INT);
                if (!empty($_POST['user'])) {
                    $filtrouser = '%' . $_POST['user'] . '%';
                    $sql->bindParam(":filtrouser", $filtrouser, PDO::PARAM_STR);
                }
                if (!empty($_POST['pregunta'])) {
                    $filtropregunta = '%' . $_POST['pregunta'] . '%';
                    $sql->bindParam(":filtropregunta", $filtropregunta, PDO::PARAM_STR);
                }
                $sql->execute();
                $preguntas = $sql->fetchAll(PDO::FETCH_ASSOC);
                // $preguntas = $sql->fetch(PDO::FETCH_ASSOC);
                foreach ($preguntas as $pregunta) {
                ?>
                    <tr>
                        <td><?php echo $pregunta['nick_user']; ?></td>
                        <td><?php echo $pregunta['titulo_preg']; ?></td>
                        <td><?php echo $pregunta['fecha_preg']; ?></td>
                        <td>
                            <form action="./responder.php" method="post">
                                <input type="hidden" name="pregunta" value="<?php echo $pregunta['titulo_preg']; ?>">
                                <input type="hidden" name="id" value="<?php echo $pregunta['id_preg']; ?>">
                                <button>Responder</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div>
        <h2>Tus Preguntas</h2>
        <table border="1px">
            <thead>
                <tr>
                    <!-- <th>nick_user</th> -->
                    <th>Prgunta</th>
                    <th>respuesta</th>
                    <th>respuesta</th>
                    <th>total respuestas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $pdo->prepare("SELECT p.*, u.nick_user, r.id_resp, r.resp_resp, r.fecha_resp, ur.nick_user AS resp_user, r.fecha_resp AS resp_fecha
                    FROM tbl_preguntas p 
                    INNER JOIN tbl_usuarios u ON p.usuario_preg = u.id_user
                    LEFT JOIN tbl_respuestas r ON p.id_preg = r.preg_resp
                    LEFT JOIN tbl_usuarios ur ON r.usuario_resp = ur.id_user
                    WHERE p.usuario_preg = :usuario_preg
                    ORDER BY p.id_preg DESC, r.fecha_resp DESC");
                $sql->bindParam(":usuario_preg", $id, PDO::PARAM_INT);
                $sql->execute();
                $respuestas = $sql->fetchAll();
                // $preguntas = $sql->fetch(PDO::FETCH_ASSOC);
                $total = 0;
                foreach ($respuestas as $respuesta) {
                    if ($respuesta['titulo_preg'] == $respuesta['titulo_preg']) {
                        $total = $total + 1;
                    }
                ?>
                    <tr>
                        <!-- <td><?php echo $respuesta['nick_user']; ?></td> -->
                        <td><?php echo $respuesta['titulo_preg']; ?></td>
                        <td><?php echo $respuesta['resp_resp']; ?></td>
                        <td><?php echo $respuesta['fecha_resp']; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <form action="./ver.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $respuesta['id_preg']; ?>">
                                <button>Ver</button>
                            </form>
                            <form action="./procesos/eliminar.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $respuesta['id_preg']; ?>">
                                <button>Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>