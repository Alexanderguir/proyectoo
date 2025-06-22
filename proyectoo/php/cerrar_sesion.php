<?php
// Inicia el bloque de código PHP.

session_start();
// Inicia o reanuda una sesión PHP existente.
// Esto es necesario para poder manipular las variables de sesión, como las que se almacenan al iniciar sesión un usuario.

session_destroy();
// Destruye todos los datos registrados en la sesión actual.
// Esto elimina todas las variables de sesión y efectivamente "cierra la sesión" del usuario en el servidor.
// Es una función crucial para la seguridad al cerrar la sesión.

header("Location: ../iniciores.html");
// Envía un encabezado HTTP de "Location" al navegador del cliente.
// Esto le indica al navegador que debe redirigir al usuario a la URL especificada: "../iniciores.html".
// La ruta '../' significa que el navegador debe ir un directorio arriba desde la ubicación actual del script.

exit();
// Termina la ejecución del script PHP inmediatamente.
// Es una buena práctica usar 'exit()' después de una redirección con 'header()' para asegurar que no se ejecute ningún otro código PHP no deseado después de que la redirección ha sido enviada al navegador.

?>