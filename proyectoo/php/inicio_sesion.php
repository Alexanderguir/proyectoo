<?php
// Abre el bloque de PHP. Todo el código dentro de este bloque se ejecutará como PHP.

session_start();
// Inicia una nueva sesión o reanuda una existente. Esto es necesario para almacenar datos del usuario (como el estado de inicio de sesión) a través de diferentes páginas.

require 'conexion.php';
// Incluye y evalúa el archivo especificado 'conexion.php'. Este archivo probablemente contiene los detalles de conexión a la base de datos y establece la conexión ($conn). Si el archivo no se encuentra, ocurrirá un error fatal.

ini_set('display_errors', 1);
// Establece la opción de configuración de PHP 'display_errors' a 1 (activado). Esto hace que los errores de PHP sean visibles directamente en el navegador, lo cual es útil para la depuración, pero debe deshabilitarse en un entorno de producción por seguridad.

error_reporting(E_ALL);
// Establece el nivel de reporte de errores a E_ALL, lo que significa que se reportarán todos los errores y advertencias de PHP. Esto funciona en conjunto con `display_errors` para mostrar mensajes de error detallados.

$nombre_usuario = $_POST['nombre_usuario'];
// Recupera el valor del campo 'nombre_usuario' de la solicitud HTTP POST y lo asigna a la variable `$nombre_usuario`. Esto asume que los datos se envían desde un formulario HTML usando el método POST.

$contraseña = $_POST['contraseña'];
// Recupera el valor del campo 'contraseña' (password) de la solicitud HTTP POST y lo asigna a la variable `$contraseña`.

$sql = "SELECT id, contraseña FROM usuarios WHERE nombre_usuario = ?";
// Define la cadena de la consulta SQL. Selecciona las columnas 'id' y 'contraseña' (hash de la contraseña) de la tabla 'usuarios' donde 'nombre_usuario' coincide con un marcador de posición '?'. Usar un marcador de posición ayuda a prevenir la inyección SQL.

$stmt = $conn->prepare($sql);
// Prepara la declaración SQL para su ejecución. Esto devuelve un objeto de declaración ($stmt) si tiene éxito, permitiendo el enlace de parámetros y la ejecución.

$stmt->bind_param("s", $nombre_usuario);
// Vincula los parámetros a la declaración preparada. 's' indica que `$nombre_usuario` es una cadena. Esto reemplaza el '?' en la consulta SQL con el valor real del nombre de usuario, nuevamente por seguridad.

$stmt->execute();
// Ejecuta la declaración preparada. Esto envía la consulta a la base de datos.

$stmt->store_result();
// Transfiere el conjunto de resultados del servidor de la base de datos al cliente. Esto es necesario antes de usar `num_rows` o `bind_result` al recuperar resultados.

if ($stmt->num_rows > 0) {
// Comprueba si la consulta devolvió alguna fila. Si `$stmt->num_rows` es mayor que 0, significa que se encontró un usuario con el nombre de usuario dado.

    $stmt->bind_result($id, $hash);
    // Vincula las columnas del conjunto de resultados a las variables PHP. La columna 'id' se almacenará en `$id`, y la 'contraseña' (contraseña hash) se almacenará en `$hash`.

    $stmt->fetch();
    // Recupera los resultados de la declaración vinculada en las variables `$id` y `$hash`. Esto recupera una fila de datos.

    if (password_verify($contraseña, $hash)) {
    // Verifica la contraseña de texto plano proporcionada (`$contraseña`) contra la contraseña hash almacenada (`$hash`) usando `password_verify()`. Esta función es segura ya que maneja correctamente diferentes algoritmos de hash y sales.

        $_SESSION['usuario_id'] = $id;
        // Si la contraseña coincide, almacena el ID del usuario en la variable de sesión 'usuario_id'. Esto indica que el usuario ha iniciado sesión.

        $_SESSION['nombre_usuario'] = $nombre_usuario;
        // Almacena el nombre de usuario en la variable de sesión 'nombre_usuario'.

        // Redirección con JavaScript por si header() falla
        // Un comentario que explica que la redirección JavaScript se utiliza como respaldo si la función `header()` falla (por ejemplo, si ya se ha enviado una salida al navegador).

        echo "<script>
            alert('Inicio de sesión exitoso');
            window.location.href='../formularios2.0.html';
        </script>";
        // Muestra un mensaje de alerta de JavaScript indicando un inicio de sesión exitoso y luego redirige el navegador a la página 'formularios2.0.html' (un directorio arriba del script actual).

        exit();
        // Termina la ejecución del script después de la redirección. Esto es crucial para evitar que se ejecute más código y potencialmente envíe más salida antes de que ocurra la redirección.
    } else {
    // Este bloque se ejecuta si `password_verify()` devuelve falso, lo que significa que la contraseña proporcionada no coincide con el hash almacenado.

        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
        // Muestra una alerta de JavaScript indicando una contraseña incorrecta y luego usa `window.history.back()` para que el navegador regrese a la página anterior (probablemente el formulario de inicio de sesión).
    }
} else {
// Este bloque se ejecuta si `$stmt->num_rows` es 0, lo que significa que no se encontró ningún usuario con el nombre de usuario proporcionado en la base de datos.

    echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
    // Muestra una alerta de JavaScript indicando que el usuario no fue encontrado y hace que el navegador regrese a la página anterior.
}

$stmt->close();
// Cierra la declaración preparada. Esto libera los recursos asociados con la declaración.

$conn->close();
// Cierra la conexión a la base de datos. Esto libera los recursos asociados con la conexión a la base de datos.

?>