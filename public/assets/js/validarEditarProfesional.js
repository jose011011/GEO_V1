document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formEditarProfesional");
    if (!form) return;

    const nombre = document.getElementById("nombre");
    const apellido = document.getElementById("apellido");
    const correo = document.getElementById("correo");
    const celular = document.getElementById("celular");
    const categoria = document.getElementById("id_categoria");
    const tipoIdentidad = document.getElementById("tipo_documento_identidad");
    const numeroDocumento = document.getElementById("numero_documento");
    const experiencia = document.getElementById("experiencia_anios");
    const zona = document.getElementById("zona_trabajo");
    const descripcion = document.getElementById("descripcion_servicio");

    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const soloApellido = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]+$/;
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const celularRegex = /^[0-9]{7,15}$/;
    const soloNumeros = /^[0-9]+$/;

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
        if (valor === "") return setError(nombre, "El nombre es obligatorio."), false;
        if (!soloLetras.test(valor)) return setError(nombre, "Solo se permiten letras."), false;
        if (valor.split(/\s+/).length > 3) return setError(nombre, "Máximo tres nombres."), false;
        setSuccess(nombre); return true;
    }

  function validarApellido() {
    const valor = apellido.value.trim();

    // 1. Validar que no esté vacío
    if (valor === "") {
      setError(
        apellido,
        "Los dos apellidos son obligatorios. Ejemplo: Mamani Quispe.",
      );
      return false;
    }

    // 2. Validar que existan exactamente dos palabras (un espacio inter```

    // Usamos una expresión regular que permita letras y tildes
    const regexDosApellidos = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+ [a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/;

    if (!regexDosApellidos.test(valor)) {
      setError(
        apellido,
        "Ingrese sus dos apellidos (Paterno y Materno) separados por un espacio.",
      );
      return false;
    }

    // 3. Validar longitud mínima (opcional, pero recomendado)
    if (valor.length < 5) {
      // Ajustado porque ahora son dos apellidos
      setError(apellido, "El nombre completo de apellidos es muy corto.");
      return false;
    }

    setSuccess(apellido);
    return true;
  }

    function validarCorreo() {
        const valor = correo.value.trim();
        if (valor === "") return setError(correo, "El correo es obligatorio."), false;
        if (!correoRegex.test(valor)) return setError(correo, "Ingrese un correo válido."), false;
        setSuccess(correo); return true;
    }

    function validarCelular() {
        const valor = celular.value.trim();
        if (valor === "") return setError(celular, "El celular es obligatorio."), false;
        if (!celularRegex.test(valor)) return setError(celular, "Debe tener entre 7 y 15 dígitos."), false;
        setSuccess(celular); return true;
    }

    function validarCategoria() {
        if (categoria.value === "") return setError(categoria, "Debe seleccionar una categoría."), false;
        setSuccess(categoria); return true;
    }

    function validarTipoIdentidad() {
        if (tipoIdentidad.value === "") return setError(tipoIdentidad, "Debe seleccionar CI o NIT."), false;
        setSuccess(tipoIdentidad); return true;
    }

    function validarNumeroDocumento() {
        const valor = numeroDocumento.value.trim();
        const tipo = tipoIdentidad.value;

        if (tipo === "") return setError(numeroDocumento, "Primero seleccione CI o NIT."), false;
        if (valor === "") return setError(numeroDocumento, "El documento es obligatorio."), false;
        if (!soloNumeros.test(valor)) return setError(numeroDocumento, "Solo se permiten números."), false;

        if (tipo === "CI" && (valor.length < 5 || valor.length > 12)) {
            return setError(numeroDocumento, "El CI debe tener entre 5 y 12 dígitos."), false;
        }

        if (tipo === "NIT" && (valor.length < 7 || valor.length > 15)) {
            return setError(numeroDocumento, "El NIT debe tener entre 7 y 15 dígitos."), false;
        }

        setSuccess(numeroDocumento); return true;
    }

    function validarExperiencia() {
        const valor = experiencia.value.trim();
        if (valor === "") return setError(experiencia, "Ingrese años de experiencia. Si no tiene, escriba 0."), false;
        if (!soloNumeros.test(valor)) return setError(experiencia, "Solo números enteros."), false;
        if (parseInt(valor) < 0 || parseInt(valor) > 60) return setError(experiencia, "Debe estar entre 0 y 60."), false;
        setSuccess(experiencia); return true;
    }

    function validarZona() {
        const valor = zona.value.trim();
        if (valor === "") return setError(zona, "La zona es obligatoria."), false;
        if (valor.length < 3) return setError(zona, "La zona debe tener al menos 3 caracteres."), false;
        setSuccess(zona); return true;
    }

    function validarDescripcion() {
        const valor = descripcion.value.trim();
        if (valor === "") return setError(descripcion, "La descripción es obligatoria."), false;
        if (valor.length < 30) return setError(descripcion, "Mínimo 30 caracteres."), false;
        if (valor.length > 500) return setError(descripcion, "Máximo 500 caracteres."), false;
        setSuccess(descripcion); return true;
    }

    nombre.addEventListener("input", validarNombre);
    apellido.addEventListener("input", validarApellido);
    correo.addEventListener("input", validarCorreo);
    celular.addEventListener("input", validarCelular);
    categoria.addEventListener("change", validarCategoria);
    tipoIdentidad.addEventListener("change", function () {
        validarTipoIdentidad();
        if (numeroDocumento.value !== "") validarNumeroDocumento();
    });
    numeroDocumento.addEventListener("input", validarNumeroDocumento);
    experiencia.addEventListener("input", validarExperiencia);
    zona.addEventListener("input", validarZona);
    descripcion.addEventListener("input", validarDescripcion);

    form.addEventListener("submit", function (e) {
        let valido = true;

        if (!validarNombre()) valido = false;
        if (!validarApellido()) valido = false;
        if (!validarCorreo()) valido = false;
        if (!validarCelular()) valido = false;
        if (!validarCategoria()) valido = false;
        if (!validarTipoIdentidad()) valido = false;
        if (!validarNumeroDocumento()) valido = false;
        if (!validarExperiencia()) valido = false;
        if (!validarZona()) valido = false;
        if (!validarDescripcion()) valido = false;

        if (!valido) {
            e.preventDefault();
            e.stopPropagation();
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    });
});