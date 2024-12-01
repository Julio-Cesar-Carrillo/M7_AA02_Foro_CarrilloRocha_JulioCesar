<?php
session_start();
if (isset($_SESSION['id_user'])) {
    $id = $_SESSION['id_user'];
}
include './procesos/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png">
    <title>CodeCraft</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.7/dist/sweetalert2.min.css">

</head>

<body>
    <header>
        <img src="../img/logo.png" alt="CodeCraft" class="logo">
        <div class="header-forms">
            <form action="./index.php" method="post" id="formbusquedapregunta">
                <input type="hidden" name="mispreguntas" value="<?php if (!empty($_POST['mispreguntas'])) {
                                                                    echo "1";
                                                                } ?>">
                <input type="hidden" name="user" value="<?php if (!empty($_POST['user'])) {
                                                            echo htmlspecialchars(trim($_POST['user']));
                                                        } ?>">
                <input type="text" name="pregunta" id="inputPregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                                    echo htmlspecialchars(trim($_POST['pregunta']));
                                                                                } ?>" placeholder="Pregunta">
            </form>
            <form action="./index.php">
                <button>borrar filtros</button>
            </form>
        </div>
        <div>
            <?php
            if (isset($_SESSION['id_user'])) {
                echo '<h3>' . $_SESSION["nick_user"] . '</h3>';
                echo '<a href="./procesos/logout.php">Salir</a>';
            } else {
                echo '<a href="../index.php">Iniciar sesion</a>';
                echo '<a href="../registro.php">Regitrarse</a>';
            }
            ?>
        </div>
    </header>
    <div class="container">
        <div class="form-column">
            <?php
            if (isset($_SESSION['id_user'])) {
            ?>
                <button id="mostrarFormulario">Hacer una pregunta</button>
                <form action="./index.php" method="post" id="formmispreguntas">
                    <label for="mispreguntasCheckbox">Mis preguntas</label>
                    <input type="checkbox" name="mispreguntas" id="mispreguntasCheckbox" <?php if (!empty($_POST['mispreguntas'])) {
                                                                                                echo "checked";
                                                                                            } ?>>
                    <input type="hidden" name="user" value="<?php if (!empty($_POST['user'])) {
                                                                echo htmlspecialchars(trim($_POST['user']));
                                                            } ?>">
                    <input type="hidden" name="pregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                    echo htmlspecialchars(trim($_POST['pregunta']));
                                                                } ?>">
                </form>
            <?php
            }
            ?>
            <div>
                <p>¿Buscas a alguien?</p>
                <form action="./index.php" method="post" id="buscarusuario">
                    <input type="hidden" name="mispreguntas" value="<?php if (!empty($_POST['mispreguntas'])) {
                                                                        echo "1";
                                                                    } ?>">
                    <input type="text" name="user" id="inputUser" value="<?php if (!empty($_POST['user'])) {
                                                                                echo htmlspecialchars(trim($_POST['user']));
                                                                            } ?>" placeholder="Usuario">
                    <input type="hidden" name="pregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                    echo htmlspecialchars(trim($_POST['pregunta']));
                                                                } ?>">
                </form>
                <?php
                $sql = "SELECT nick_user FROM tbl_usuarios
                WHERE rol_user <> 1";
                if (isset($_SESSION['id_user'])) {
                    $sql .= " AND id_user <> :id_user";
                }
                if (!empty($_POST['user'])) {
                    $sql .= " AND nick_user LIKE :filtrouser";
                }
                $sql .= " LIMIT 3";
                $sql = $pdo->prepare($sql);
                if (isset($_SESSION['id_user'])) {
                    $filtrouser = '%' .  $id . '%';
                    $sql->bindParam(":id_user", $id, PDO::PARAM_INT);
                }

                if (!empty($_POST['user'])) {
                    $filtrouser = '%' . htmlspecialchars(trim($_POST['user'])) . '%';
                    $sql->bindParam(":filtrouser", $filtrouser, PDO::PARAM_STR_CHAR);
                }
                $sql->execute();
                $usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
                echo "<p>Resultados:</p>";
                foreach ($usuarios as $usuario) {
                ?>
                    <p><?php echo htmlspecialchars($usuario['nick_user']); ?></p>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="questions-column">
            <?php
            $sql = "SELECT p.*, u.nick_user FROM tbl_preguntas p 
                INNER JOIN tbl_usuarios u ON p.usuario_preg = u.id_user 
                WHERE 1=1";
            // if (!empty($_POST['user'])) {
            //     $sql .= " AND u.nick_user LIKE :filtrouser";
            // }
            if (!empty($_POST['pregunta'])) {
                $sql .= " AND titulo_preg LIKE :filtropregunta";
            }
            if (isset($_SESSION['id_user'])) {
                if (!empty($_POST['mispreguntas'])) {
                    $sql .= " AND usuario_preg = :usuario_preg";
                }
            }

            $sql = $pdo->prepare($sql);
            // if (!empty($_POST['user'])) {
            //     $filtrouser = '%' . $_POST['user'] . '%';
            //     $sql->bindParam(":filtrouser", $filtrouser, PDO::PARAM_STR_CHAR);
            // }
            if (!empty($_POST['pregunta'])) {
                $filtropregunta = '%' . $_POST['pregunta'] . '%';
                $sql->bindParam(":filtropregunta", $filtropregunta, PDO::PARAM_STR_CHAR);
            }
            if (isset($_SESSION['id_user'])) {
                if (!empty($_POST['mispreguntas'])) {
                    $filtromispreguntas =  $id;
                    $sql->bindParam(":usuario_preg", $filtromispreguntas, PDO::PARAM_INT);
                }
            }

            $sql->execute();
            $preguntas = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($preguntas as $pregunta) {
            ?>
                <div class="preguntas-respuestas">
                    <div class="pregunta">
                        <h1><?php echo htmlspecialchars($pregunta['titulo_preg']); ?></h1>
                        <div class="pregunta-details">
                            <div class="pregunta-info">
                                <p>Creado el <?php
                                                $originalDate = $pregunta['fecha_preg'];
                                                $newDate = date("d/m/Y", strtotime($originalDate));
                                                echo $newDate;
                                                ?></p>
                                <p>Autor: <?php echo htmlspecialchars($pregunta['nick_user']); ?></p>
                            </div>
                            <div>
                                <?php
                                if (isset($_SESSION['id_user'])) {
                                    if ($id == $pregunta['usuario_preg']) {
                                ?>
                                        <div class="button-group">
                                            <button class="abrirModalEditar" data-id="<?php echo (int)$pregunta['id_preg']; ?>" data-titulo="<?php echo htmlspecialchars($pregunta['titulo_preg']); ?>" data-texto="<?php echo htmlspecialchars($pregunta['text_preg']); ?>">Editar</button>

                                            <form action="./procesos/eliminar.php" method="post" id="formEliminar">
                                                <input type="hidden" name="mispreguntas" value="<?php if (!empty($_POST['mispreguntas'])) {
                                                                                                    echo "1";
                                                                                                } ?>">
                                                <input type="hidden" name="user" value="<?php if (!empty($_POST['user'])) {
                                                                                            echo htmlspecialchars(trim($_POST['user']));
                                                                                        } ?>">
                                                <input type="hidden" name="pregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                                                echo htmlspecialchars(trim($_POST['pregunta']));
                                                                                            } ?>">
                                                <input type="hidden" name="id" value="<?php echo (int)$pregunta['id_preg']; ?>">
                                                <button type="button" class="btneliminar" data-titulo="<?php echo htmlspecialchars($pregunta['titulo_preg']); ?>">Eliminar</button>
                                            </form>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <p><?php echo htmlspecialchars($pregunta['text_preg']); ?></p>
                    </div>
                    <!-- Respuestas en un div separado -->
                    <div class="respuestas">
                        <?php
                        $sqlResp = $pdo->prepare("SELECT r.*, u.nick_user FROM tbl_respuestas r
                            INNER JOIN tbl_usuarios u ON r.usuario_resp = u.id_user
                            WHERE r.preg_resp = :id_preg ORDER BY id_resp DESC");
                        $sqlResp->bindParam(":id_preg", $pregunta['id_preg'], PDO::PARAM_INT);
                        $sqlResp->execute();
                        $respuestas = $sqlResp->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($respuestas)) {
                            foreach ($respuestas as $respuesta) {
                        ?>
                                <div class="respuesta">
                                    <p><?php echo htmlspecialchars($respuesta['resp_resp']); ?></p>
                                    <div class="respuesta-info">
                                        <p><?php echo htmlspecialchars($respuesta['nick_user']); ?></p>
                                        <p><?php
                                            $originalDate = $respuesta['fecha_resp'];
                                            $newDate = date("d/m/Y", strtotime($originalDate));
                                            echo $newDate;
                                            ?></p>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p>Aun no hay respuestas.</p>";
                        }
                        ?>
                        <div>
                            <?php
                            if (isset($_SESSION['id_user'])) {
                                if ($id != $pregunta['usuario_preg']) {
                            ?>
                                    <form action="./procesos/respuesta.php" method="post">
                                        <input type="hidden" name="preg_resp" value="<?php echo (int)$pregunta['id_preg'] ?>">
                                        <input type="hidden" name="usuario_resp" value="<?php echo (int)$_SESSION['id_user']; ?>">
                                        <textarea id="editor" name="resp_resp" placeholder="Escribe aquí..."></textarea>
                                        <button>Responder</button>
                                    </form>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- formulario que aparece para crear una pregunta -->
    <div id="modalFormulario" style="display: none;">
        <div class="modal-content">
            <h2>Crear Pregunta</h2>
            <form action="./procesos/crear.php" method="post" id="formularioPregunta">
                <input type="hidden" name="mispreguntas" value="<?php if (!empty($_POST['mispreguntas'])) {
                                                                    echo "1";
                                                                } ?>">
                <input type="hidden" name="user" value="<?php if (!empty($_POST['user'])) {
                                                            echo htmlspecialchars(trim($_POST['user']));
                                                        } ?>">
                <input type="hidden" name="pregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                echo htmlspecialchars(trim($_POST['pregunta']));
                                                            } ?>">
                <label for="titulo_preg">Título:</label>
                <input type="text" name="titulo_preg" id="titulo" placeholder="Título de tu pregunta">
                <label for="text_preg">Pregunta:</label>
                <textarea name="text_preg" id="texto" placeholder="Escribe los detalles de tu pregunta"></textarea>
                <button type="submit">Confirmar</button>
                <button type="button" id="cerrarModal">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- formulario que aparece para editar una pregunta -->
    <div id="modalEditarPregunta" style="display: none;">
        <div class="modal-content">
            <h2>Editar Pregunta</h2>
            <form action="./procesos/editar_pregunta.php" method="post" id="formularioEditarPregunta">
                <input type="hidden" name="mispreguntas" value="<?php if (!empty($_POST['mispreguntas'])) {
                                                                    echo "1";
                                                                } ?>">
                <input type="hidden" name="user" value="<?php if (!empty($_POST['user'])) {
                                                            echo htmlspecialchars(trim($_POST['user']));
                                                        } ?>">
                <input type="hidden" name="pregunta" value="<?php if (!empty($_POST['pregunta'])) {
                                                                echo htmlspecialchars(trim($_POST['pregunta']));
                                                            } ?>">
                <input type="hidden" name="id_pregunta" id="idPregunta">
                <label for="titulo_preg">Título:</label>
                <input type="text" name="titulo_preg" id="tituloEditar">
                <label for="text_preg">Pregunta:</label>
                <textarea name="text_preg" id="textoEditar"></textarea>
                <button type="submit">Confirmar</button>
                <button type="button" id="cerrarModalEditar">Cancelar</button>
            </form>
        </div>
    </div>

</body>
<script src="./formularios.js"></script>
<!-- SweetAlert2 JS -->


</html>