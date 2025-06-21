document.addEventListener("DOMContentLoaded", () => {
  // Añade un "escuchador de eventos" al documento que se activa cuando el DOM (Document Object Model) ha sido completamente cargado y parseado.
  // Esto asegura que todo el HTML está disponible antes de que el script intente manipularlo. La función flecha '() => {}' es el callback que se ejecuta.

  const form = document.querySelector("form");
  // Selecciona el primer elemento <form> que encuentra en el documento y lo almacena en la constante 'form'.

  const nombreInput = form.elements["nombre"];
  // Accede al elemento del formulario (input, textarea, select) que tiene el atributo 'name="nombre"' y lo asigna a 'nombreInput'.

  const edadInput = form.elements["edad"];
  // Accede al elemento del formulario con 'name="edad"' y lo asigna a 'edadInput'.

  const telefonoInput = form.elements["telefono"];
  // Accede al elemento del formulario con 'name="telefono"' y lo asigna a 'telefonoInput'.

  const agresorInput = form.elements["agresor"];
  // Accede al elemento del formulario con 'name="agresor"' y lo asigna a 'agresorInput'.

  const errorNombre = document.getElementById("error-nombre");
  // Obtiene el elemento HTML con el ID "error-nombre". Este elemento probablemente se usa para mostrar mensajes de error relacionados con el campo 'nombre'.

  const errorEdad = document.getElementById("error-edad");
  // Obtiene el elemento HTML con el ID "error-edad" para mostrar errores de 'edad'.

  const errorTelefono = document.getElementById("error-telefono");
  // Obtiene el elemento HTML con el ID "error-telefono" para mostrar errores de 'telefono'.

  const errorAgresor = document.getElementById("error-agresor");
  // Obtiene el elemento HTML con el ID "error-agresor" para mostrar errores de 'agresor'.

  form.addEventListener("submit", function (e) {
    // Añade un "escuchador de eventos" al formulario que se activa cuando se intenta enviar el formulario (evento 'submit').
    // La función que se ejecuta recibe el objeto de evento 'e'.

    let valido = true;
    // Declara una variable booleana 'valido' e la inicializa en 'true'. Esta variable controlará si el formulario debe enviarse o no.

    // Validar que nombre no tenga números
    // Comentario que indica el inicio de la validación para el campo 'nombre'.
    if (/\d/.test(nombreInput.value)) {
      // Usa una expresión regular (/\d/) para verificar si el valor del campo 'nombreInput' contiene algún dígito numérico.
      // `.test()` devuelve 'true' si encuentra un número, 'false' en caso contrario.
      errorNombre.textContent = "El nombre no puede contener números.";
      // Si se encuentran números, establece el texto de error para el campo 'nombre'.
      valido = false;
      // Establece 'valido' a 'false', lo que impedirá el envío del formulario.
    } else {
      // Si no se encuentran números en el nombre, significa que es válido para esta regla.
      errorNombre.textContent = "";
      // Borra cualquier mensaje de error previo para el campo 'nombre'.
    }

    // Validar que agresor no tenga números
    // Comentario que indica el inicio de la validación para el campo 'agresor'.
    if (/\d/.test(agresorInput.value)) {
      // Verifica si el valor del campo 'agresorInput' contiene algún dígito numérico.
      errorAgresor.textContent = "La descripción no puede contener números.";
      // Si se encuentran números, establece el texto de error para el campo 'agresor'.
      valido = false;
      // Establece 'valido' a 'false'.
    } else {
      // Si no se encuentran números en 'agresor'.
      errorAgresor.textContent = "";
      // Borra el mensaje de error para 'agresor'.
    }

    // Validar que edad solo tenga números enteros
    // Comentario que indica el inicio de la validación para el campo 'edad'.
    if (!/^\d+$/.test(edadInput.value)) {
      // Usa una expresión regular (/^\d+$/) para verificar si el valor del campo 'edadInput' *no* consiste solo en uno o más dígitos.
      // `^` significa inicio de la cadena, `\d+` significa uno o más dígitos, `$` significa fin de la cadena. El `!` al inicio invierte el resultado.
      errorEdad.textContent = "La edad debe contener solo números.";
      // Si no es un número entero válido, establece el texto de error para 'edad'.
      valido = false;
      // Establece 'valido' a 'false'.
    } else {
      // Si 'edad' solo contiene números enteros.
      errorEdad.textContent = "";
      // Borra el mensaje de error para 'edad'.
    }

    // Validar que teléfono solo tenga 10 dígitos
    // Comentario que indica el inicio de la validación para el campo 'telefono'.
    if (!/^\d{10}$/.test(telefonoInput.value)) {
      // Usa una expresión regular (/^\d{10}$/) para verificar si el valor del campo 'telefonoInput' *no* consiste exactamente en 10 dígitos.
      // `\d{10}` significa exactamente 10 dígitos.
      errorTelefono.textContent = "El teléfono debe tener exactamente 10 dígitos.";
      // Si no tiene 10 dígitos, establece el texto de error para 'telefono'.
      valido = false;
      // Establece 'valido' a 'false'.
    } else {
      // Si 'telefono' tiene exactamente 10 dígitos.
      errorTelefono.textContent = "";
      // Borra el mensaje de error para 'telefono'.
    }

    if (!valido) {
      // Si la variable 'valido' es 'false' (es decir, alguna validación falló).
      e.preventDefault(); // Evita que se envíe el formulario
      // Llama a `preventDefault()` en el objeto de evento. Esto detiene el comportamiento predeterminado del evento 'submit', que es enviar el formulario al servidor, permitiendo que el usuario corrija los errores.
    }
  });

  // Evita que se escriban números en nombre o agresor
  // Comentario que indica el inicio de funciones para bloquear la entrada de caracteres en tiempo real.
  function bloquearNumeros(e) {
    // Define una función llamada 'bloquearNumeros' que toma un objeto de evento de teclado 'e'.
    if (/\d/.test(e.key)) {
      // Verifica si la tecla presionada ('e.key') es un dígito numérico.
      e.preventDefault();
      // Si es un número, previene el comportamiento predeterminado de la tecla (escribir el carácter), lo que impide que el número aparezca en el campo.
    }
  }

  // Evita que se escriban letras en edad o teléfono
  // Comentario que indica el inicio de funciones para bloquear la entrada de caracteres.
  function bloquearLetras(e) {
    // Define una función llamada 'bloquearLetras' que toma un objeto de evento de teclado 'e'.
    if (/[^\d]/.test(e.key)) {
      // Verifica si la tecla presionada ('e.key') *no* es un dígito numérico (`[^\d]`).
      e.preventDefault();
      // Si es una letra o cualquier otro carácter que no sea un dígito, previene su escritura en el campo.
    }
  }

  nombreInput.addEventListener("keypress", bloquearNumeros);
  // Añade un "escuchador de eventos" al campo 'nombreInput' que llama a 'bloquearNumeros' cada vez que se presiona una tecla (evento 'keypress').

  agresorInput.addEventListener("keypress", bloquearNumeros);
  // Añade un "escuchador de eventos" al campo 'agresorInput' que llama a 'bloquearNumeros' cada vez que se presiona una tecla.

  edadInput.addEventListener("keypress", bloquearLetras);
  // Añade un "escuchador de eventos" al campo 'edadInput' que llama a 'bloquearLetras' cada vez que se presiona una tecla.

  telefonoInput.addEventListener("keypress", bloquearLetras);
  // Añade un "escuchador de eventos" al campo 'telefonoInput' que llama a 'bloquearLetras' cada vez que se presiona una tecla.
});
// Cierra el bloque del evento "DOMContentLoaded".