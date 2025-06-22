<?php
// Abre el bloque de código PHP. Todo el código dentro de este bloque será ejecutado por el servidor.

require 'conexion.php';
// Incluye y evalúa el archivo 'conexion.php'. Este archivo es fundamental porque contiene la configuración y el código para establecer la conexión a tu base de datos (representada por la variable `$conn`). Si este archivo no se encuentra o la conexión falla, el script no podrá continuar.

$nombre_usuario = $_POST['nombre_usuario'];
// Recupera el valor del campo 'nombre_usuario' enviado a través del método HTTP POST desde un formulario HTML y lo asigna a la variable `$nombre_usuario`.

$email = $_POST['email'];
// Recupera el valor del campo 'email' enviado a través del método HTTP POST y lo asigna a la variable `$email`.

$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptamos
// Recupera el valor del campo 'contraseña' enviado por POST.
// Luego, utiliza la función `password_hash()` para **encriptar (hashear) la contraseña**.
// `PASSWORD_DEFAULT` indica que se debe usar el algoritmo de hash predeterminado y más seguro disponible en PHP (actualmente bcrypt), el cual incluye automáticamente una "sal" (salt) para mayor seguridad.
// El resultado de este hash se almacena en la variable `$contraseña`.

$sql = "INSERT INTO usuarios (nombre_usuario, email, contraseña) VALUES (?, ?, ?)";
// Define la consulta SQL para insertar un nuevo registro en la tabla `usuarios`.
// Se especifican las columnas `nombre_usuario`, `email` y `contraseña`.
// Los signos de interrogación `?` son **marcadores de posición**. Se utilizan en lugar de los valores directos para prevenir ataques de inyección SQL, ya que los valores se pasarán de forma segura por separado.

$stmt = $conn->prepare($sql);
// Prepara la consulta SQL para su ejecución usando el objeto de conexión a la base de datos (`$conn`).
// La función `prepare()` devuelve un objeto de declaración (`$stmt`) si la preparación es exitosa. Este objeto es lo que se usará para vincular los valores y ejecutar la consulta.

$stmt->bind_param("sss", $nombre_usuario, $email, $contraseña);
// Vincula los valores de las variables a los marcadores de posición en la consulta preparada (`$stmt`).
// La cadena "sss" especifica los tipos de datos de los parámetros en el orden en que aparecen:
// - El primer 's' indica que `$nombre_usuario` es una **cadena (string)**.
// - El segundo 's' indica que `$email` es una **cadena (string)**.
// - El tercer 's' indica que `$contraseña` (el hash) es una **cadena (string)**.

if ($stmt->execute()) {
// Ejecuta la declaración preparada (`$stmt`) con los valores ya vinculados.
// La función `execute()` devuelve `true` si la inserción en la base de datos fue exitosa; de lo contrario, devuelve `false`.

    echo "<script>alert('Registro exitoso'); window.location.href='../iniciores.html';</script>";
    // Si el registro fue exitoso, muestra una ventana de alerta de JavaScript con el mensaje "Registro exitoso".
    // Luego, redirige el navegador a la página `iniciores.html`. El `../` indica que debe buscar la página en el directorio padre.
} else {
// Si `$stmt->execute()` devuelve `false`, significa que hubo un error al insertar el registro.

    echo "<script>alert('Error: usuario ya registrado o problema en la BD'); window.history.back();</script>";
    // Muestra una ventana de alerta de JavaScript con un mensaje de error genérico, sugiriendo que el usuario ya podría estar registrado o que hubo un problema con la base de datos.
    // Luego, usa `window.history.back()` para hacer que el navegador regrese a la página anterior (probablemente el formulario de registro), permitiendo al usuario corregir la entrada o reintentar.
}

$stmt->close();
// Cierra la declaración preparada. Esto libera los recursos del servidor asociados con esa consulta específica. Es una buena práctica liberar estos recursos cuando ya no son necesarios.

$conn->close();
// Cierra la conexión a la base de datos. Esto libera todos los recursos de la base de datos asociados con la conexión. También es una buena práctica cerrar la conexión cuando todas las operaciones con la base de datos han terminado.

?>