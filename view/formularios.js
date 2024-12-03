document.addEventListener("DOMContentLoaded", function () {
    // Filtro de preguntas
    const misPreguntasCheckbox = document.getElementById('mispreguntasCheckbox');
    const formMisPreguntas = document.getElementById('formmispreguntas');

    misPreguntasCheckbox.addEventListener('change', function () {
        // Si las validaciones pasan, se envía el formulario de mis preguntas
        formMisPreguntas.submit();
        validarFormularioPregunta()
        validarFormularioEditarPregunta()
    });

    // Validación de campos de búsqueda
    let preguntaactual = document.getElementById('inputPregunta').value.trim();
    document.getElementById('inputPregunta').addEventListener('blur', function () {
        const preguntanueva = this.value.trim();
        if (preguntanueva !== preguntaactual) {
            preguntaactual = preguntanueva;
            if (validarCamposBusqueda(preguntaactual, usuarioactual)) {
                document.getElementById('formbusquedapregunta').submit();
            }
        }
    });

    let usuarioactual = document.getElementById('inputUser').value.trim();
    document.getElementById('inputUser').addEventListener('blur', function () {
        const usuarionuevo = this.value.trim();
        if (usuarionuevo !== usuarioactual) {
            usuarioactual = usuarionuevo;
            if (validarCamposBusqueda(preguntaactual, usuarioactual)) {
                document.getElementById('buscarusuario').submit();
            }
        }
    });

    // Validación de campos de búsqueda
    function validarCamposBusqueda(pregunta, usuario) {
        let isValid = true;

        // Validar pregunta
        if (pregunta === "") {
            document.getElementById('errorPregunta').style.display = "inline";
            document.getElementById('errorPregunta').innerHTML = "La pregunta no puede estar vacía.";
            isValid = false;
        } else {
            document.getElementById('errorPregunta').style.display = "none";
        }

        // Validar usuario
        if (usuario === "") {
            document.getElementById('errorUsuario').style.display = "inline";
            document.getElementById('errorUsuario').innerHTML = "El usuario no puede estar vacío.";
            isValid = false;
        } else {
            document.getElementById('errorUsuario').style.display = "none";
        }

        return isValid;
    }

    // Mostrar y cerrar modal de formulario
    const mostrarFormularioBtn = document.getElementById("mostrarFormulario");
    const modalFormulario = document.getElementById("modalFormulario");
    const cerrarModalBtn = document.getElementById("cerrarModal");

    mostrarFormularioBtn.addEventListener("click", function () {
        modalFormulario.style.display = "flex";
        limpiarErrores();
        // Validación del formulario de pregunta
        const formularioPregunta = document.getElementById("formularioPregunta");

        formularioPregunta.addEventListener("submit", function (event) {
            let isValid = true;
            const tituloPregunta = document.getElementById("tituloPregunta").value.trim();
            const textoPregunta = document.getElementById("textoPregunta").value.trim();

            // Validar título
            if (tituloPregunta === "") {
                document.getElementById("errorTitulo").textContent = "El título no puede estar vacío.";
                document.getElementById("errorTitulo").style.display = "inline";
                isValid = false;
            } else if (tituloPregunta.length > 100) {
                document.getElementById("errorTitulo").textContent = "El título debe tener menos de 100 caracteres.";
                document.getElementById("errorTitulo").style.display = "inline";
                isValid = false;
            }

            // Validar pregunta
            if (textoPregunta === "") {
                document.getElementById("errorePregunta").textContent = "El campo no puede estar vacío.";
                document.getElementById("errorePregunta").style.display = "inline";
                isValid = false;
            } else if (textoPregunta.length > 500) {
                document.getElementById("errorePregunta").textContent = "Has alcanzado el límite de 500 caracteres.";
                document.getElementById("errorePregunta").style.display = "inline";
                isValid = false;
            }

            // Evitar el envío si no es válido
            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    cerrarModalBtn.addEventListener("click", function () {
        modalFormulario.style.display = "none";
        limpiarErrores();
    });

    // Abrir modal para editar pregunta
    document.querySelectorAll('.abrirModalEditar').forEach(button => {
        button.addEventListener('click', function () {
            const idPregunta = this.getAttribute('data-id');
            const titulo = this.getAttribute('data-titulo');
            const texto = this.getAttribute('data-texto');

            // Configura los valores en el modal de edición
            document.getElementById('idPregunta').value = idPregunta;
            document.getElementById('tituloEditar').value = titulo;
            document.getElementById('textoEditar').value = texto;

            // Muestra el modal
            document.getElementById('modalEditarPregunta').style.display = 'flex';

            // Validación de la edición de la pregunta
            const formularioEditarPregunta = document.getElementById("formularioEditarPregunta");

            formularioEditarPregunta.addEventListener("submit", function (event) {
                let isValid = true;
                const tituloEditar = document.getElementById("tituloEditar").value.trim();
                const textoEditar = document.getElementById("textoEditar").value.trim();

                // Validar título
                if (tituloEditar === "") {
                    document.getElementById("errorTituloPregunta").textContent = "El título no puede estar vacío.";
                    document.getElementById("errorTituloPregunta").style.display = "inline";
                    isValid = false;
                } else if (tituloEditar.length > 100) {
                    document.getElementById("errorTituloPregunta").textContent = "El título no puede tener más de 100 caracteres.";
                    document.getElementById("errorTituloPregunta").style.display = "inline";
                    isValid = false;
                }

                // Validar pregunta
                if (textoEditar === "") {
                    document.getElementById("erroreditarpregunta").textContent = "La pregunta no puede estar vacía.";
                    document.getElementById("erroreditarpregunta").style.display = "inline";
                    isValid = false;
                } else if (textoEditar.length > 500) {
                    document.getElementById("erroreditarpregunta").textContent = "Has alcanzado el límite de 500 caracteres.";
                    document.getElementById("erroreditarpregunta").style.display = "inline";
                    isValid = false;
                }

                // Evitar el envío si no es válido
                if (!isValid) {
                    event.preventDefault();
                }
            });

        });
    });

    // Cerrar modal de edición
    document.getElementById('cerrarModalEditar').addEventListener('click', function () {
        document.getElementById('modalEditarPregunta').style.display = 'none';
        limpiarErrores();
    });

    // Confirmación de eliminación
    document.querySelectorAll('.btneliminar').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            var tituloPregunta = this.getAttribute('data-titulo');
            Swal.fire({
                title: '¿Estás seguro de eliminar?',
                text: tituloPregunta,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = this.closest('form');
                    form.submit();
                }
            });
        });
    });

    // Validación de textarea en respuesta
    const textarea = document.getElementById("editor");
    const maxMessage = document.getElementById("max-message");
    const form = document.getElementById("frmresponder");

    textarea.addEventListener("keyup", function () {
        if (textarea.value.trim() === "") {
            maxMessage.innerHTML = "El campo no puede estar vacío.";
            maxMessage.style.display = "inline";
        }
        if (textarea.value.length >= 500) {
            maxMessage.style.display = "inline";
        } else {
            maxMessage.style.display = "none";
        }
    });

    form.addEventListener("submit", function (event) {
        if (textarea.value.trim() === "") {
            maxMessage.innerHTML = "El campo no puede estar vacío.";
            maxMessage.style.display = "inline";
            event.preventDefault();
        }
        if (textarea.value.length > 500) {
            event.preventDefault();
        }
    });




    // Limpiar errores
    function limpiarErrores() {
        const errorTitulo = document.getElementById("errorTitulo");
        const errorePregunta = document.getElementById("errorePregunta");
        const errorTituloPregunta = document.getElementById("errorTituloPregunta");
        const erroreditarpregunta = document.getElementById("erroreditarpregunta");

        if (errorTitulo) errorTitulo.style.display = "none";
        if (errorePregunta) errorePregunta.style.display = "none";
        if (errorTituloPregunta) errorTituloPregunta.style.display = "none";
        if (erroreditarpregunta) erroreditarpregunta.style.display = "none";
    }
});
