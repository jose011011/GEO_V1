document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registroProfesionalForm");
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
  const tipoArchivo = document.getElementById("tipo_documento_archivo");
  const archivo = document.getElementById("documento_tecnico");
  const password = document.getElementById("password");
  const confirmarPassword = document.getElementById("confirmar_password");

  const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
  const soloApellido = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]+$/;
  const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const celularRegex = /^[0-9]{7,15}$/;
  const soloNumeros = /^[0-9]+$/;
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
    if (valor === "")
      return (
        setError(nombre, "El nombre es obligatorio. Ejemplo: Juan Carlos."),
        false
      );
    if (!soloLetras.test(valor))
      return (
        setError(
          nombre,
          "Solo se permiten letras. No escriba números ni símbolos.",
        ),
        false
      );
    if (valor.length < 2)
      return (
        setError(nombre, "El nombre debe tener al menos 2 letras."),
        false
      );
    if (valor.split(/\s+/).length > 3)
      return (setError(nombre, "Máximo se permiten tres nombres."), false);
    setSuccess(nombre);
    return true;
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
    if (valor === "")
      return (
        setError(
          correo,
          "El correo es obligatorio. Ejemplo: tecnico@gmail.com.",
        ),
        false
      );
    if (valor.length > 120)
      return (
        setError(
          correo,
          "El correo es demasiado largo. Máximo 120 caracteres.",
        ),
        false
      );
    if (!correoRegex.test(valor))
      return (
        setError(correo, "Ingrese un correo válido. Debe tener @ y dominio."),
        false
      );
    setSuccess(correo);
    return true;
  }

  function validarCelular() {
    const valor = celular.value.trim();
    if (valor === "")
      return (
        setError(celular, "El celular es obligatorio. Ejemplo: 76543210."),
        false
      );
    if (!soloNumeros.test(valor))
      return (
        setError(
          celular,
          "El celular solo debe tener números. No use letras ni espacios.",
        ),
        false
      );
    if (!celularRegex.test(valor))
      return (
        setError(celular, "El celular debe tener entre 7 y 15 dígitos."),
        false
      );
    setSuccess(celular);
    return true;
  }

  function validarCategoria() {
    if (categoria.value === "")
      return (
        setError(categoria, "Debe seleccionar una categoría técnica."),
        false
      );
    setSuccess(categoria);
    return true;
  }

  function validarTipoIdentidad() {
    if (tipoIdentidad.value === "")
      return (setError(tipoIdentidad, "Debe seleccionar CI o NIT."), false);
    setSuccess(tipoIdentidad);
    return true;
  }

  function validarNumeroDocumento() {
    const valor = numeroDocumento.value.trim();
    const tipo = tipoIdentidad.value;

    if (tipo === "")
      return (setError(numeroDocumento, "Primero seleccione CI o NIT."), false);
    if (valor === "")
      return (
        setError(numeroDocumento, "El número de documento es obligatorio."),
        false
      );
    if (!soloNumeros.test(valor))
      return (
        setError(numeroDocumento, "El documento solo debe contener números."),
        false
      );

    if (tipo === "CI" && (valor.length < 5 || valor.length > 12)) {
      return (
        setError(numeroDocumento, "El CI debe tener entre 5 y 12 dígitos."),
        false
      );
    }

    if (tipo === "NIT" && (valor.length < 7 || valor.length > 15)) {
      return (
        setError(numeroDocumento, "El NIT debe tener entre 7 y 15 dígitos."),
        false
      );
    }

    setSuccess(numeroDocumento);
    return true;
  }

  function validarExperiencia() {
    const valor = experiencia.value.trim();
    if (valor === "")
      return (
        setError(
          experiencia,
          "Ingrese años de experiencia. Si no tiene, escriba 0.",
        ),
        false
      );
    if (!soloNumeros.test(valor))
      return (
        setError(experiencia, "La experiencia debe ser un número entero."),
        false
      );
    if (parseInt(valor) < 0 || parseInt(valor) > 60)
      return (
        setError(experiencia, "La experiencia debe estar entre 0 y 60 años."),
        false
      );
    setSuccess(experiencia);
    return true;
  }

  function validarZona() {
    const valor = zona.value.trim();
    if (valor === "")
      return (setError(zona, "La zona de trabajo es obligatoria."), false);
    if (valor.length < 3)
      return (
        setError(zona, "La zona debe tener al menos 3 caracteres."),
        false
      );
    setSuccess(zona);
    return true;
  }

  function validarDescripcion() {
    const valor = descripcion.value.trim();
    if (valor === "")
      return (
        setError(descripcion, "Debe describir qué servicios realiza."),
        false
      );
    if (valor.length < 30)
      return (
        setError(
          descripcion,
          "La descripción debe tener al menos 30 caracteres.",
        ),
        false
      );
    if (valor.length > 500)
      return (
        setError(
          descripcion,
          "La descripción no debe superar los 500 caracteres.",
        ),
        false
      );
    setSuccess(descripcion);
    return true;
  }

  function validarTipoArchivo() {
    if (tipoArchivo.value === "")
      return (
        setError(
          tipoArchivo,
          "Seleccione qué tipo de documento está subiendo.",
        ),
        false
      );
    setSuccess(tipoArchivo);
    return true;
  }

  function validarArchivo() {
    const file = archivo.files[0];
    const preview = document.getElementById("documento_preview");
    if (preview) preview.innerHTML = "";

    if (!file) return (setError(archivo, "Debe subir un documento."), false);

    const permitidos = ["application/pdf", "image/jpeg", "image/png"];
    const maximo = 2 * 1024 * 1024;

    if (!permitidos.includes(file.type)) {
      archivo.value = "";
      return (setError(archivo, "Solo se permiten PDF, JPG o PNG."), false);
    }

    if (file.size > maximo) {
      archivo.value = "";
      return (setError(archivo, "El archivo no debe superar los 2 MB."), false);
    }

    setSuccess(archivo);

    if (preview) {
      const info = document.createElement("p");
      info.className = "success-message";
      info.innerText = "Archivo seleccionado: " + file.name;
      preview.appendChild(info);

      if (file.type === "image/jpeg" || file.type === "image/png") {
        const img = document.createElement("img");
        img.className = "preview-img";
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      } else {
        const pdf = document.createElement("p");
        pdf.className = "help-message";
        pdf.innerText = "PDF cargado correctamente.";
        preview.appendChild(pdf);
      }
    }

    return true;
  }

  function validarPassword() {
    const valor = password.value;
    if (valor === "")
      return (setError(password, "La contraseña es obligatoria."), false);
    if (valor.length < 8)
      return (setError(password, "Debe tener mínimo 8 caracteres."), false);
    if (!mayuscula.test(valor))
      return (setError(password, "Debe tener al menos una mayúscula."), false);
    if (!minuscula.test(valor))
      return (setError(password, "Debe tener al menos una minúscula."), false);
    if (!numero.test(valor))
      return (setError(password, "Debe tener al menos un número."), false);
    if (!especial.test(valor))
      return (
        setError(password, "Debe tener un símbolo. Ejemplo: @, #, *, _."),
        false
      );
    setSuccess(password);
    return true;
  }

  function validarConfirmarPassword() {
    if (confirmarPassword.value === "")
      return (
        setError(confirmarPassword, "Debe repetir la contraseña."),
        false
      );
    if (password.value !== confirmarPassword.value)
      return (
        setError(confirmarPassword, "Las contraseñas no coinciden."),
        false
      );
    setSuccess(confirmarPassword);
    return true;
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
  tipoArchivo.addEventListener("change", validarTipoArchivo);
  archivo.addEventListener("change", validarArchivo);
  password.addEventListener("input", function () {
    validarPassword();
    if (confirmarPassword.value !== "") validarConfirmarPassword();
  });
  confirmarPassword.addEventListener("input", validarConfirmarPassword);

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
    if (!validarTipoArchivo()) valido = false;
    if (!validarArchivo()) valido = false;
    if (!validarPassword()) valido = false;
    if (!validarConfirmarPassword()) valido = false;

    if (!valido) {
      e.preventDefault();
      e.stopPropagation();
      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  });
});
