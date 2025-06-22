<?php
// Inicia el bloque de código PHP.

$host = "localhost";
// Define una variable '$host' y le asigna el valor "localhost".
// "localhost" es la dirección del servidor de la base de datos cuando se encuentra en la misma máquina que el servidor web.

$user = "root";
// Define una variable '$user' y le asigna el valor "root".
// "root" es el nombre de usuario por defecto para MySQL, a menudo utilizado en entornos de desarrollo. En producción, deberías usar un usuario con menos privilegios.

$password = "";
// Define una variable '$password' y le asigna una cadena vacía "".
// Esta es la contraseña para el usuario 'root' de la base de datos. Una contraseña vacía es común en entornos de desarrollo local, pero es extremadamente insegura para entornos de producción.

$database = "login_db";
// Define una variable '$database' y le asigna el valor "login_db".
// Este es el nombre de la base de datos a la que el script intentará conectarse.

$conn = new mysqli($host, $user, $password, $database);
// Crea una nueva instancia de la clase 'mysqli' y la asigna a la variable '$conn'.
// Esta línea intenta establecer la conexión a la base de datos utilizando los parámetros definidos anteriormente: host, usuario, contraseña y nombre de la base de datos.
// Si la conexión es exitosa, $conn será un objeto de conexión a la base de datos.

if ($conn->connect_error) {
// Comprueba si hubo un error durante el intento de conexión a la base de datos.
// '$conn->connect_error' contiene el mensaje de error si la conexión falla.

    die("Conexión fallida: " . $conn->connect_error);
    // Si la conexión falla, la función 'die()' detiene la ejecución del script por completo.
    // Además, imprime un mensaje de "Conexión fallida:" seguido del error específico devuelto por MySQLi, lo cual es útil para depuración.
}
// Si no hay un error de conexión, el script continuará ejecutándose después de este bloque 'if'.
// La variable $conn contendrá el objeto de conexión activa y lista para ser usada en otras operaciones de base de datos.

?>
