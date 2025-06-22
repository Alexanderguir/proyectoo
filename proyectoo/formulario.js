
document.addEventListener("DOMContentLoaded", function() {  
    // Espera a que la página se cargue completamente antes de ejecutar el código  
    document.getElementById("violenciaForm").addEventListener("submit", function(event) {  
        event.preventDefault(); // Evita que el formulario se envíe automáticamente  
        
        let esValido = true; // Variable que indica si el formulario es válido  

        // Limpiar mensajes de error previos  
        document.getElementById("errorNombre").innerText = "";
        document.getElementById("errorEdad").innerText = "";
        document.getElementById("errorTelefono").innerText = "";
        document.getElementById("errorEmail").innerText = "";
        document.getElementById("errorViolencia").innerText = "";
        document.getElementById("errorLugar").innerText = "";
        document.getElementById("errorAgresor").innerText = "";
        document.getElementById("errorConsciente").innerText = "";
        document.getElementById("errorFecha").innerText = "";

        // Obtener los valores ingresados en el formulario  
        let nombre = document.getElementById("nombre").value.trim(); // Obtiene el nombre y elimina espacios en blanco  
        let edad = document.getElementById("edad").value.trim(); // Obtiene la edad  
        let telefono = document.getElementById("telefono").value.trim(); // Obtiene el teléfono  
        let email = document.getElementById("email").value.trim(); // Obtiene el email  
        let violencia = document.querySelector('input[name="violencia"]:checked'); // Verifica si se seleccionó una opción  
        let lugar = document.getElementById("lugar").value.trim(); // Obtiene el lugar  
        let agresor = document.getElementById("agresor").value.trim(); // Obtiene la descripción del agresor  
        let consciente = document.querySelector('input[name="consciente"]:checked'); // Verifica si se seleccionó una opción  
        let fecha = document.getElementById("fecha").value.trim(); // Obtiene la fecha  

        // Definir expresiones regulares para validaciones  
        let nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/; // Solo permite letras y espacios  
        let telefonoRegex = /^\d{10}$/; // Debe contener exactamente 10 dígitos  
        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Formato válido de correo electrónico  

        // Validar que el nombre solo contenga letras y espacios  
        if (!nombreRegex.test(nombre)) {  
            document.getElementById("errorNombre").innerText = "El nombre solo puede contener letras y espacios.";  
            esValido = false;  
        }  

        // Validar que la edad sea un número entero positivo  
        if (edad === "" || isNaN(edad) || edad <= 0) {  
            document.getElementById("errorEdad").innerText = "Ingrese una edad válida (número entero).";  
            esValido = false;  
        }  

        // Validar que el teléfono tenga exactamente 10 dígitos  
        if (!telefonoRegex.test(telefono)) {  
            document.getElementById("errorTelefono").innerText = "El teléfono debe tener exactamente 10 dígitos numéricos.";  
            esValido = false;  
        }  

        // Validar que el correo electrónico tenga un formato correcto  
        if (!emailRegex.test(email)) {  
            document.getElementById("errorEmail").innerText = "Ingrese un correo electrónico válido.";  
            esValido = false;  
        }  

        // Validar que se haya seleccionado si sufrió violencia  
        if (!violencia) {  
            document.getElementById("errorViolencia").innerText = "Debe seleccionar si ha sufrido violencia.";  
            esValido = false;  
        }  

        // Validar que se haya ingresado un lugar  
        if (lugar === "") {  
            document.getElementById("errorLugar").innerText = "Seleccione un lugar donde ocurrió el suceso.";  
            esValido = false;  
        }  

        // Validar que se haya ingresado una descripción del agresor  
        if (agresor === "") {  
            document.getElementById("errorAgresor").innerText = "Describa al agresor.";  
            esValido = false;  
        }  

        // Validar que se haya indicado si era consciente del suceso  
        if (!consciente) {  
            document.getElementById("errorConsciente").innerText = "Debe indicar si era consciente del suceso.";  
            esValido = false;  
        }  

        // Validar que se haya ingresado una fecha  
        if (fecha === "") {  
            document.getElementById("errorFecha").innerText = "Seleccione la fecha del suceso.";  
            esValido = false;  
        }  

        // Si todas las validaciones pasaron, se envía el formulario  
        if (esValido) {  
            alert("Formulario enviado correctamente.");  
            this.submit();  
        }  
    });  
});
