function validarRegistro() {
  // Define una función llamada 'validarRegistro'. Esta función está diseñada para verificar la validez de los datos de un formulario de registro antes de su envío.

  const nombre = document.getElementById("nombre_usuario").value.trim();
  // Obtiene el elemento HTML con el ID "nombre_usuario" (probablemente un campo de entrada de texto).
  // Luego, obtiene su 'value' (el texto que el usuario ha introducido).
  // Finalmente, usa '.trim()' para eliminar los espacios en blanco al principio y al final del valor, y lo asigna a la constante 'nombre'.

  const email = document.getElementById("email").value.trim();
  // Similar a la anterior, obtiene el valor del campo con ID "email", lo recorta y lo asigna a la constante 'email'.

  const pass = document.getElementById("contraseña").value;
  // Obtiene el valor del campo con ID "contraseña" y lo asigna a la constante 'pass'.
  // Nota: No se usa '.trim()' aquí, ya que los espacios en las contraseñas suelen ser significativos.

  const confirmarPass = document.getElementById("confirmar_contraseña").value;
  // Obtiene el valor del campo con ID "confirmar_contraseña" y lo asigna a la constante 'confirmarPass'.

  const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;
  // Define una expresión regular llamada 'soloLetras'.
  // `^`: coincide con el inicio de la cadena.
  // `[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+`: coincide con una o más letras (mayúsculas, minúsculas, con tildes, 'ñ'/'Ñ') o espacios en blanco.
  // `$`: coincide con el final de la cadena.
  // Esta expresión se usará para asegurar que un campo solo contenga letras y espacios.

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  // Define una expresión regular llamada 'emailRegex' para validar el formato de una dirección de correo electrónico.
  // Esta es una expresión común para una validación básica de email (aunque no es exhaustiva para todos los casos complejos).

  // Validar nombre sin números
  // Comentario que indica el inicio de la validación para el nombre de usuario.
  if (!soloLetras.test(nombre)) {
    // Usa el método `.test()` de la expresión regular `soloLetras` para comprobar si el valor de 'nombre' *no* cumple con el patrón (es decir, contiene números o caracteres especiales).
    alert("El nombre de usuario no debe contener números ni caracteres especiales.");
    // Si la validación falla, muestra una alerta al usuario.
    return false;
    // La función devuelve 'false', lo que generalmente detiene el envío del formulario.
  }

  // Validar correo electrónico
  // Comentario que indica el inicio de la validación para el correo electrónico.
  if (!emailRegex.test(email)) {
    // Comprueba si el valor de 'email' *no* coincide con el patrón de correo electrónico válido.
    alert("Por favor, introduce un correo electrónico válido.");
    // Si la validación falla, muestra una alerta.
    return false;
    // La función devuelve 'false'.
  }

  // Validar longitud de la contraseña
  // Comentario que indica el inicio de la validación para la longitud de la contraseña.
  if (pass.length < 6) {
    // Comprueba si la longitud de la cadena 'pass' es menor a 6 caracteres.
    alert("La contraseña debe tener al menos 6 caracteres.");
    // Si es demasiado corta, muestra una alerta.
    return false;
    // La función devuelve 'false'.
  }

  // Confirmar contraseña
  // Comentario que indica la validación para la confirmación de la contraseña.
  if (pass !== confirmarPass) {
    // Compara si el valor de 'pass' es estrictamente diferente al valor de 'confirmarPass'.
    alert("Las contraseñas no coinciden.");
    // Si no coinciden, muestra una alerta.
    return false;
    // La función devuelve 'false'.
  }

  return true;
  // Si todas las validaciones anteriores pasan (es decir, ninguna devuelve 'false'), la función llega a este punto y devuelve 'true', lo que permite el envío del formulario.
}

// Mostrar/ocultar contraseña
// Comentario que indica el inicio de la función para mostrar/ocultar contraseñas.
function togglePassword(idCampo) {
  // Define una función llamada 'togglePassword' que toma un argumento 'idCampo' (el ID del campo de entrada de contraseña).

  const input = document.getElementById(idCampo);
  // Obtiene el elemento HTML del campo de entrada usando el 'idCampo' proporcionado.

  input.type = input.type === "password" ? "text" : "password";
  // Esta es una expresión ternaria para cambiar el tipo del campo de entrada.
  // Si `input.type` es actualmente "password", lo cambia a "text" (para mostrar la contraseña).
  // Si `input.type` no es "password" (es decir, ya es "text"), lo cambia de nuevo a "password" (para ocultarla).
}