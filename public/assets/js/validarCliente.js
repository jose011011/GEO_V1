document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registroClienteForm");

    if (!form) return;

    const nombre = document.getElementById("nombre");
    const apellido = document.getElementById("apellido");
    const correo = document.getElementById("correo");
    const celular = document.getElementById("celular");
    const zona = document.getElementById("zona");
    const direccion = document.getElementById("direccion_referencia");
    const password = document.getElementById("password");
    const confirmarPassword = document.getElementById("confirmar_password");

    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const celularRegex = /^[0-9]{7,15}$/;
    const mayuscula = /[A-Z]/;
    const minuscula = /[a-z]/;
    const numero = /[0-9]/;
    const especial = /[!@#$%^&*.,;:_\-]/;

    function setError(input, mensaje) {
        input.classList.remove("input-success");
        input.classList.add("input-error");

        const error = document.getElementById(input.id + "_error");
        if (error) error.innerText = mensaje;
    }

    function setSuccess(input) {
        input.classList.remove("input-error");
        input.classList.add("input-success");

        const error = document.getElementById(input.id + "_error");
        if (error) error.innerText = "";
    }

    function validarNombre() {
        const valor = nombre.value.trim();

        if (valor === "") {
            setError(nombre, "El nombre es obligatorio.");
            return false;
        }

        if (!soloLetras.test(valor)) {
            setError(nombre, "Solo se permiten letras. No use números ni símbolos.");
            return false;
        }

        const partes = valor.split(/\s+/);

        if (partes.length > 3) {
            setError(nombre, "Máximo se permiten tres nombres.");
            return false;
        }

        if (valor.length < 2) {
            setError(nombre, "El nombre debe tener al menos 2 letras.");
            return false;
        }

        setSuccess(nombre);
        return true;
    }

    function validarApellido() {
    const valor = apellido.value.trim();

    // 1. Validar que no esté vacío
    if (valor === "") {
        setError(apellido, "Los dos apellidos son obligatorios. Ejemplo: Mamani Quispe.");
        return false;
    }

    // 2. Validar que existan exactamente dos palabras (un espacio inter```


    // Usamos una expresión regular que permita letras y tildes
    const regexDosApellidos = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+ [a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/;

    if (!regexDosApellidos.test(valor)) {
        setError(apellido, "Ingrese sus dos apellidos (Paterno y Materno) separados por un espacio.");
        return false;
    }

    // 3. Validar longitud mínima (opcional, pero recomendado)
    if (valor.length < 5) { // Ajustado porque ahora son dos apellidos
        setError(apellido, "El nombre completo de apellidos es muy corto.");
        return false;
    }

    setSuccess(apellido);
    return true;
}
    function validarCorreo() {
        const valor = correo.value.trim();

        if (valor === "") {
            setError(correo, "El correo electrónico es obligatorio.");
            return false;
        }

        if (!correoRegex.test(valor)) {
            setError(correo, "Ingrese un correo válido. Ejemplo: usuario@gmail.com");
            return false;
        }

        setSuccess(correo);
        return true;
    }

    function validarCelular() {
        const valor = celular.value.trim();

        if (valor === "") {
            setError(celular, "El celular es obligatorio.");
            return false;
        }

        if (!celularRegex.test(valor)) {
            setError(celular, "El celular debe tener solo números y entre 7 a 15 dígitos.");
            return false;
        }

        setSuccess(celular);
        return true;
    }

    function validarZona() {
        const valor = zona.value.trim();

        if (valor === "") {
            setError(zona, "La zona es obligatoria para ubicar mejor el servicio.");
            return false;
        }

        if (valor.length < 3) {
            setError(zona, "La zona debe tener al menos 3 caracteres.");
            return false;
        }

        setSuccess(zona);
        return true;
    }

    function validarDireccion() {
        const valor = direccion.value.trim();

        if (valor === "") {
            setError(direccion, "La dirección de referencia es obligatoria.");
            return false;
        }

        if (valor.length < 8) {
            setError(direccion, "Ingrese una referencia más clara. Ejemplo: cerca de la plaza, avenida, calle.");
            return false;
        }

        setSuccess(direccion);
        return true;
    }

    function validarPassword() {
        const valor = password.value;

        if (valor === "") {
            setError(password, "La contraseña es obligatoria.");
            return false;
        }

        if (valor.length < 8) {
            setError(password, "Debe tener al menos 8 caracteres.");
            return false;
        }

        if (!mayuscula.test(valor)) {
            setError(password, "Debe contener al menos una letra mayúscula.");
            return false;
        }

        if (!minuscula.test(valor)) {
            setError(password, "Debe contener al menos una letra minúscula.");
            return false;
        }

        if (!numero.test(valor)) {
            setError(password, "Debe contener al menos un número.");
            return false;
        }

        if (!especial.test(valor)) {
            setError(password, "Debe contener al menos un carácter especial. Ejemplo: @, #, *, _");
            return false;
        }

        setSuccess(password);
        return true;
    }

    function validarConfirmarPassword() {
        if (confirmarPassword.value === "") {
            setError(confirmarPassword, "Debe confirmar la contraseña.");
            return false;
        }

        if (password.value !== confirmarPassword.value) {
            setError(confirmarPassword, "Las contraseñas no coinciden.");
            return false;
        }

        setSuccess(confirmarPassword);
        return true;
    }

    nombre.addEventListener("input", validarNombre);
    apellido.addEventListener("input", validarApellido);
    correo.addEventListener("input", validarCorreo);
    celular.addEventListener("input", validarCelular);
    zona.addEventListener("input", validarZona);
    direccion.addEventListener("input", validarDireccion);
    password.addEventListener("input", function () {
        validarPassword();
        validarConfirmarPassword();
    });
    confirmarPassword.addEventListener("input", validarConfirmarPassword);

    form.addEventListener("submit", function (e) {
        let valido = true;

        if (!validarNombre()) valido = false;
        if (!validarApellido()) valido = false;
        if (!validarCorreo()) valido = false;
        if (!validarCelular()) valido = false;
        if (!validarZona()) valido = false;
        if (!validarDireccion()) valido = false;
        if (!validarPassword()) valido = false;
        if (!validarConfirmarPassword()) valido = false;

        if (!valido) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
});