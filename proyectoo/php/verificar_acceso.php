<?php
// Abre el bloque de código PHP.

session_start();
// Inicia o reanuda una sesión de PHP. Esto es crucial para manejar el estado de la sesión del usuario, como determinar si ha iniciado sesión.

require 'conexion.php';
// Incluye el archivo 'conexion.php'. Este archivo es vital ya que contiene la configuración y el código para establecer la conexión a tu base de datos ($conn). Sin esta conexión, el script no puede interactuar con la base de datos para verificar el usuario.

$usuario = $_POST['nombre_usuario'];
// Obtiene el valor enviado a través del método POST desde un formulario HTML para el campo 'nombre_usuario' y lo guarda en la variable `$usuario`.

$clave = $_POST['contraseña'];
// Obtiene el valor enviado a través del método POST desde un formulario HTML para el campo 'contraseña' y lo guarda en la variable `$clave`.

$sql = "SELECT * FROM usuarios WHERE nombre_usuario=?";
// Define la consulta SQL para seleccionar todos los datos (`*`) de la tabla `usuarios` donde la columna `nombre_usuario` coincida con un valor específico. El `?` es un marcador de posición para un valor que se insertará de forma segura.

$stmt = $conn->prepare($sql);
// Prepara la consulta SQL para su ejecución. La función `prepare()` es una medida de seguridad importante contra la inyección SQL y devuelve un objeto de declaración (`$stmt`).

$stmt->bind_param("s", $usuario);
// Vincula el valor de la variable `$usuario` al marcador de posición `?` en la consulta preparada. La "s" indica que `$usuario` es de tipo cadena (string).

$stmt->execute();
// Ejecuta la consulta preparada contra la base de datos.

$resultado = $stmt->get_result();
// Obtiene los resultados de la consulta ejecutada como un objeto de resultados. Este objeto permite acceder a las filas devueltas por la base de datos.

if ($resultado->num_rows === 1) {
// Comprueba si la consulta devolvió exactamente una fila. Si es así, significa que se encontró un usuario con el nombre de usuario proporcionado.

    $fila = $resultado->fetch_assoc();
    // Recupera la fila de resultados como un array asociativo, donde las claves del array son los nombres de las columnas de la base de datos. Por ejemplo, `$fila['contraseña']` contendría el hash de la contraseña almacenada.

    if (password_verify($clave, $fila['contraseña'])) {
    // Verifica si la contraseña proporcionada por el usuario (`$clave`) coincide con el hash de contraseña almacenado en la base de datos (`$fila['contraseña']`).
    // `password_verify()` es la función segura recomendada para comparar una contraseña de texto plano con un hash generado por `password_hash()`.

        $_SESSION['usuario_id'] = $fila['id'];
        // Si la contraseña coincide, almacena el `id` del usuario en la variable de sesión `usuario_id`. Esto establece que el usuario ha iniciado sesión.

        header("Location: panel_edicion.php");
        // Redirige al navegador del usuario a la página `panel_edicion.php`. Esta función debe llamarse antes de que cualquier otra salida (HTML, espacios en blanco, etc.) sea enviada al navegador.

        exit();
        // Termina la ejecución del script inmediatamente después de la redirección. Esto es importante para asegurar que no se ejecute ningún código adicional y para que la redirección sea efectiva.
    }
}

echo "<script>alert('Datos incorrectos'); window.location.href='../acceso.html';</script>";
// Si el nombre de usuario no fue encontrado, o si la contraseña no coincidió con el hash, este código se ejecuta.
// Muestra una ventana de alerta de JavaScript al usuario con el mensaje "Datos incorrectos".
// Luego, redirige el navegador a la página `acceso.html`, que probablemente es el formulario de inicio de sesión.