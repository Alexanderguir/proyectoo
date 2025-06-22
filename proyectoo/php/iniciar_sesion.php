<?php
// Inicia el bloque de código PHP.

session_start();
// Inicia o reanuda una sesión PHP. Es crucial llamar a esta función al principio de cualquier script que necesite usar variables de sesión (como $_SESSION).

require 'conexion.php';
// Incluye el archivo 'conexion.php'. Este archivo es donde se establece la conexión a tu base de datos (por ejemplo, define la variable $conn).
// Es fundamental para interactuar con la base de datos. Si no se puede incluir, el script detendrá su ejecución con un error fatal.

ini_set('display_errors', 1);
// Configura PHP para mostrar errores en la salida del script.
// '1' significa que se mostrarán los errores. Esto es útil para la depuración, pero debe desactivarse en un entorno de producción por razones de seguridad.

error_reporting(E_ALL);
// Establece qué tipos de errores de PHP deben ser reportados.
// 'E_ALL' significa que se reportarán todos los errores, advertencias y avisos posibles. También es útil para la depuración.

$nombre_usuario = $_POST['nombre_usuario'];
// Obtiene el valor del campo 'nombre_usuario' enviado a través del método POST desde un formulario HTML.

$contraseña = $_POST['contraseña'];
// Obtiene el valor del campo 'contraseña' (la contraseña en texto plano) enviado a través del método POST.

$sql = "SELECT id, contraseña FROM usuarios WHERE nombre_usuario = ?";
// Define la consulta SQL para seleccionar el 'id' y la 'contraseña' (hasheada) de la tabla 'usuarios'.
// La cláusula 'WHERE nombre_usuario = ?' se utiliza para buscar un usuario específico por su nombre. El signo de interrogación (?) es un marcador de posición para una sentencia preparada, lo cual es vital para la seguridad.

$stmt = $conn->prepare($sql);
// Prepara la sentencia SQL para su ejecución. El método 'prepare()' del objeto de conexión ($conn) devuelve un objeto de sentencia ($stmt).
// Las sentencias preparadas son una característica de seguridad esencial que ayuda a prevenir ataques de inyección SQL.

$stmt->bind_param("s", $nombre_usuario);
// Vincula el valor de la variable '$nombre_usuario' al marcador de posición (?) en la sentencia preparada.
// "s" indica que el tipo de dato del parámetro es una cadena de texto (string).

$stmt->execute();
// Ejecuta la sentencia preparada en la base de datos. En este punto, la consulta se envía al servidor de la base de datos.

$stmt->store_result();
// Almacena el conjunto de resultados de la consulta en el lado del cliente (en memoria).
// Esto es necesario antes de poder usar 'num_rows' y 'bind_result()' con MySQLi.

if ($stmt->num_rows > 0) {
// Comprueba si el número de filas devueltas por la consulta es mayor que cero.
// Si es así, significa que se encontró un usuario con el 'nombre_usuario' proporcionado.

    $stmt->bind_result($id, $hash);
    // Vincula las columnas 'id' y 'contraseña' del resultado de la consulta a las variables PHP '$id' y '$hash', respectivamente.
    // '$hash' contendrá la contraseña hasheada almacenada en la base de datos.

    $stmt->fetch();
    // Obtiene los valores de las columnas y los coloca en las variables vinculadas ($id y $hash).

    if (password_verify($contraseña, $hash)) {
    // Verifica si la contraseña en texto plano proporcionada por el usuario ($contraseña) coincide con el hash almacenado en la base de datos ($hash).
    // 'password_verify()' es la función segura para comparar contraseñas hasheadas.

        $_SESSION['usuario_id'] = $id;
        // Si la contraseña es correcta, almacena el ID del usuario en la variable de sesión 'usuario_id'.
        // Esto permite que el ID del usuario esté disponible en otras páginas después de iniciar sesión.

        $_SESSION['nombre_usuario'] = $nombre_usuario;
        // Almacena el nombre de usuario en la variable de sesión 'nombre_usuario'.
        // Esto también permite usar el nombre de usuario en otras páginas para personalizar la experiencia.

        // Redirección con JavaScript por si header() falla
        // Comentario que indica que se usa JavaScript como un respaldo para la redirección.

        echo "<script>
            alert('Inicio de sesión exitoso');
            window.location.href='../formulario2.0.html';
        </script>";
        // Muestra una ventana de alerta en el navegador con el mensaje "Inicio de sesión exitoso".
        // Luego, redirige al usuario a la página '../formulario2.0.html' utilizando JavaScript. Esta es una alternativa a 'header()' si ya se ha enviado alguna salida HTML.

        exit();
        // Termina la ejecución del script PHP inmediatamente. Es una buena práctica después de una redirección para asegurar que no se ejecute ningún otro código.

    } else {
    // Si 'password_verify()' devuelve falso, significa que la contraseña ingresada es incorrecta.

        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
        // Muestra una ventana de alerta con el mensaje "Contraseña incorrecta" y redirige al usuario a la página anterior en su historial de navegación.

    }
} else {
// Si '$stmt->num_rows' es 0, significa que no se encontró ningún usuario con el 'nombre_usuario' proporcionado.

    echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
    // Muestra una ventana de alerta con el mensaje "Usuario no encontrado" y redirige al usuario a la página anterior.
}

$stmt->close();
// Cierra el objeto de sentencia preparada. Libera los recursos de memoria asociados con la consulta.

$conn->close();
// Cierra la conexión a la base de datos. Libera los recursos generales de la conexión.
// Es una buena práctica cerrar la conexión cuando ya no se necesita.

?>
