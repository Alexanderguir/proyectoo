<?php
// Inicia un bloque de código PHP.

require 'conexion.php';
// Incluye el archivo 'conexion.php'. Este archivo es donde se establece la conexión a tu base de datos (por ejemplo, con mysqli_connect o PDO).
// Es fundamental para que el script pueda interactuar con la base de datos. Si no se encuentra, el script se detendrá.

$id = $_POST['id'];
// Obtiene el valor del campo 'id' enviado a través del método POST desde un formulario HTML.
// Este 'id' se usa para identificar al usuario específico que se va a modificar en la base de datos.

$nombre_usuario = $_POST['nombre_usuario'];
// Obtiene el valor del campo 'nombre_usuario' enviado por POST.
// Este es el nuevo nombre de usuario que se desea asignar.

$email = $_POST['email'];
// Obtiene el valor del campo 'email' enviado por POST.
// Esta es la nueva dirección de correo electrónico del usuario.

$nueva_contraseña = $_POST['nueva_contraseña'];
// Obtiene el valor del campo 'nueva_contraseña' enviado por POST.
// Esta variable contendrá la posible nueva contraseña que el usuario ha ingresado.

if (!empty($nueva_contraseña)) {
// Inicia una condición: comprueba si la variable '$nueva_contraseña' NO está vacía.
// Esto significa que el usuario ha proporcionado una nueva contraseña y desea actualizarla.

    $nueva_contraseña = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
    // Si la contraseña no está vacía, la **cifra (hashea)** usando la función 'password_hash()'.
    // 'PASSWORD_DEFAULT' indica a PHP que use el algoritmo de hash de contraseña predeterminado y más seguro (actualmente bcrypt).
    // Esta es una **medida de seguridad crucial**: nunca guardes contraseñas en texto plano en la base de datos.

    $sql = "UPDATE usuarios SET nombre_usuario=?, email=?, contraseña=? WHERE id=?";
    // Define la consulta SQL para **ACTUALIZAR** un registro en la tabla 'usuarios'.
    // Los signos de interrogación (?) son marcadores de posición para los valores que se insertarán después, lo cual es parte de las sentencias preparadas.
    // Esta consulta actualizará el nombre de usuario, el email y la contraseña.

    $stmt = $conn->prepare($sql);
    // Prepara la sentencia SQL para su ejecución. El método 'prepare()' devuelve un objeto de sentencia ($stmt).
    // Las sentencias preparadas son esenciales para **prevenir inyecciones SQL**.

    $stmt->bind_param("sssi", $nombre_usuario, $email, $nueva_contraseña, $id);
    // Vincula los valores de las variables a los marcadores de posición (?) en la sentencia preparada.
    // "sssi" es una cadena de tipos que especifica el tipo de datos de cada parámetro en orden:
    // 's' = string (cadena de texto) para $nombre_usuario
    // 's' = string para $email
    // 's' = string para $nueva_contraseña (la versión hasheada)
    // 'i' = integer (entero) para $id

} else {
// Si la variable '$nueva_contraseña' ESTÁ vacía (es decir, el usuario no ingresó una nueva contraseña).
// Esto indica que el usuario no desea cambiar su contraseña actual.

    $sql = "UPDATE usuarios SET nombre_usuario=?, email=? WHERE id=?";
    // Define una consulta SQL alternativa para ACTUALIZAR el registro.
    // En este caso, solo se actualizarán el nombre de usuario y el email, dejando la contraseña sin cambios.

    $stmt = $conn->prepare($sql);
    // Prepara esta nueva sentencia SQL.

    $stmt->bind_param("ssi", $nombre_usuario, $email, $id);
    // Vincula los parámetros para esta sentencia:
    // 's' = string para $nombre_usuario
    // 's' = string para $email
    // 'i' = integer para $id

}

if ($stmt->execute()) {
// Ejecuta la sentencia preparada ($stmt) contra la base de datos.
// Si la ejecución es exitosa (la base de datos se actualizó correctamente)...

    echo "<script>alert('Datos actualizados'); window.location.href='../cecy.html';</script>";
    // Muestra una ventana de alerta en el navegador con el mensaje "Datos actualizados".
    // Después, redirige al usuario a la página '../cecy.html'. 'window.location.href' cambia la URL actual.

} else {
// Si la ejecución de la sentencia falló (por ejemplo, por un error en la base de datos)...

    echo "<script>alert('Error al actualizar'); window.history.back();</script>";
    // Muestra una ventana de alerta con el mensaje "Error al actualizar".
    // Luego, 'window.history.back()' hace que el navegador regrese a la página web anterior.

}

$stmt->close();
// Cierra el objeto de sentencia preparada. Esto libera los recursos de memoria asociados con la consulta.
// Es una buena práctica liberar estos recursos una vez que la operación ha terminado.

$conn->close();
// Cierra la conexión a la base de datos. Libera los recursos de la conexión.
// Es importante cerrar la conexión cuando ya no se necesita para optimizar el uso de recursos del servidor.

?>
// Cierra el bloque de código PHP.