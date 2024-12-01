document.getElementById('mispreguntasCheckbox').addEventListener('change', function () {
    document.getElementById('formmispreguntas').submit();
});


preguntaactual = document.getElementById('inputPregunta').value.trim();

document.getElementById('inputPregunta').addEventListener('blur', function () {
    preguntanueva = this.value.trim();

    if (preguntanueva !== preguntaactual) {
        preguntaactual = preguntanueva;
        document.getElementById('formbusquedapregunta').submit();
    }
});


usuarioactual = document.getElementById('inputUser').value.trim();

document.getElementById('inputUser').addEventListener('blur', function () {
    usuarionuevo = this.value.trim();

    if (usuarionuevo !== usuarioactual) {
        usuarioactual = usuarionuevo;
        document.getElementById('buscarusuario').submit();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const mostrarFormularioBtn = document.getElementById("mostrarFormulario");
    const modalFormulario = document.getElementById("modalFormulario");
    const cerrarModalBtn = document.getElementById("cerrarModal");

    // Mostrar el modal al hacer clic en el botón
    mostrarFormularioBtn.addEventListener("click", function () {
        modalFormulario.style.display = "flex";
    });

    // Ocultar el modal al hacer clic en el botón de cerrar
    cerrarModalBtn.addEventListener("click", function () {
        modalFormulario.style.display = "none";
    });

    // Botón para cerrar el modal
    document.getElementById('cerrarModal').addEventListener('click', function () {
        document.getElementById('modalFormulario').style.display = 'none';
    });
});

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
    });
});

// Botón para cerrar el modal
document.getElementById('cerrarModalEditar').addEventListener('click', function () {
    document.getElementById('modalEditarPregunta').style.display = 'none';
});


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
