DROP DATABASE IF EXISTS db_foro;

CREATE DATABASE db_foro;

USE db_foro;

CREATE TABLE tbl_roles(
    id_rol INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nom_rol VARCHAR(25) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE tbl_usuarios(
    id_user INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nick_user VARCHAR(25) NOT NULL,
    nom_user VARCHAR(25) NOT NULL,
    email_user VARCHAR(100) NOT NULL,
    pwd_user VARCHAR(100) NOT NULL,
    rol_user INT NOT NULL,
    FOREIGN KEY (rol_user) REFERENCES tbl_roles(id_rol)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE tbl_preguntas(
    id_preg INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    titulo_preg VARCHAR(50) NOT NULL,
    text_preg VARCHAR(100) NOT NULL,
    usuario_preg INT NOT NULL,
    fecha_preg DATE NOT NULL,
    FOREIGN KEY (usuario_preg) REFERENCES tbl_usuarios(id_user)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE tbl_respuestas(
    id_resp INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    preg_resp INT NOT NULL,
    resp_resp VARCHAR(100) NOT NULL,
    usuario_resp INT NOT NULL,
    fecha_resp DATE NOT NULL,
    FOREIGN KEY (preg_resp) REFERENCES tbl_preguntas(id_preg),
    FOREIGN KEY (usuario_resp) REFERENCES tbl_usuarios(id_user)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

INSERT INTO tbl_roles (nom_rol) VALUES
('Administrador'),
('Usuario');

-- INSERT INTO tbl_usuarios VALUES
-- (NULL,'Darckfer','julio','julio@gmail.com','$2y$10$9YAaDvpj8IDI7WRNVxVq6uYzMnCaUWDGMlU6LS.jv6dgpWcmqcswS',1);

INSERT INTO tbl_usuarios (nick_user, nom_user, email_user, pwd_user, rol_user) VALUES
('admin1', 'Administrador Uno', 'admin1@example.com', '$2y$10$9YAaDvpj8IDI7WRNVxVq6uYzMnCaUWDGMlU6LS.jv6dgpWcmqcswS', 1),
('usuario1', 'Usuario Uno', 'usuario1@example.com', '$2y$10$9YAaDvpj8IDI7WRNVxVq6uYzMnCaUWDGMlU6LS.jv6dgpWcmqcswS', 2),
('usuario2', 'Usuario Dos', 'usuario2@example.com', '$2y$10$9YAaDvpj8IDI7WRNVxVq6uYzMnCaUWDGMlU6LS.jv6dgpWcmqcswS', 2);

INSERT INTO tbl_preguntas (titulo_preg, text_preg, usuario_preg, fecha_preg) VALUES
('¿Cómo instalar MySQL?', 'Necesito ayuda para instalar MySQL en Windows 10.', 2, '2024-11-19'),
('Error en conexión PHP', 'Estoy obteniendo un error al intentar conectar PHP con MySQL.', 3, '2024-11-16'),
('Diferencias entre JOINs', '¿Cuál es la diferencia entre INNER JOIN y LEFT JOIN?', 2, '2024-11-19');

INSERT INTO tbl_respuestas (preg_resp, resp_resp, usuario_resp, fecha_resp) VALUES
(1, 'Descarga el instalador desde el sitio oficial.', 3, '2024-11-21'),
(1, 'Asegúrate de agregar MySQL al PATH del sistema.', 2, '2024-11-20'),
(2, 'Revisa las credenciales de conexión en el archivo de configuración.', 2, '2024-11-21'),
(3, 'INNER JOIN devuelve solo coincidencias, LEFT JOIN incluye filas sin coincidencias.', 3, '2024-11-19');
