document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.formulario__login');
    const registerForm = document.querySelector('.formulario__register');
    const btnLogin = document.querySelector('#btn__iniciar-sesion');
    const btnRegister = document.querySelector('#btn__registrarse');

    // Alternar entre formularios y limpiar errores
    btnLogin.addEventListener('click', () => {
        clearErrors(loginForm);
        clearErrors(registerForm);
    });

    btnRegister.addEventListener('click', () => {
        clearErrors(loginForm);
        clearErrors(registerForm);
    });

    // Validación para el formulario de inicio de sesión
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const username = loginForm.querySelector('input[name="username"]');
        const password = loginForm.querySelector('input[name="pwd"]');
        const usernameError = username.nextElementSibling;
        const passwordError = password.nextElementSibling;

        clearErrors(loginForm);

        let isValid = true;

        if (!username.value.trim()) {
            usernameError.textContent = 'El nombre de usuario es obligatorio.';
            isValid = false;
        }

        if (!password.value.trim()) {
            passwordError.textContent = 'La contraseña es obligatoria.';
            isValid = false;
        }

        if (isValid) {
            loginForm.submit(); // Envía el formulario si todo es válido
        }
    });

    // Validación para el formulario de registro
    registerForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const nick = registerForm.querySelector('input[name="nick"]');
        const email = registerForm.querySelector('input[name="email"]');
        const username = registerForm.querySelector('input[name="username"]');
        const password = registerForm.querySelector('input[name="pwd"]');

        clearErrors(registerForm);

        let isValid = true;

        if (!nick.value.trim()) {
            nick.nextElementSibling.textContent = 'El apodo es obligatorio.';
            isValid = false;
        }


        if (!username.value.trim()) {
            username.nextElementSibling.textContent = 'El usuario es obligatorio.';
            isValid = false;
        }

        if (!email.value.trim()) {
            email.nextElementSibling.textContent = 'El correo electrónico es obligatorio.';
            isValid = false;
        } else if (!validateEmail(email.value)) {
            email.nextElementSibling.textContent = 'Ingresa un correo electrónico válido.';
            isValid = false;
        }

        if (!password.value.trim()) {
            password.nextElementSibling.textContent = 'La contraseña es obligatoria.';
            isValid = false;
        } else if (password.value.length < 6) {
            password.nextElementSibling.textContent = 'La contraseña debe tener al menos 6 caracteres.';
            isValid = false;
        }

        if (isValid) {
            registerForm.submit(); // Envía el formulario si todo es válido
        }
    });

    // Función para validar correos electrónicos
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Función para limpiar errores
    function clearErrors(form) {
        const errorSpans = form.querySelectorAll('.error');
        errorSpans.forEach(span => {
            span.textContent = '';
        });
    }
});
