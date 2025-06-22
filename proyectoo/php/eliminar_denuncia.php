<?php
// Inicia el bloque de código PHP.

include("conexion.php");
// Incluye el archivo "conexion.php". Este archivo es fundamental porque contiene el código necesario para establecer la conexión a tu base de datos (por ejemplo, define la variable $conn).
// Si este archivo no se encuentra o hay un problema en la conexión, el script podría generar advertencias o errores.

if (isset($_POST['id_denuncia']) && is_numeric($_POST['id_denuncia'])) {
// Inicia una condición que verifica dos cosas:
// 1. 'isset($_POST['id_denuncia'])': Comprueba si la variable 'id_denuncia' existe en los datos enviados a través del método POST.
// 2. 'is_numeric($_POST['id_denuncia'])': Verifica si el valor de 'id_denuncia' es un número. Esto es una validación importante para asegurar que el ID es válido.

    $id = intval($_POST['id_denuncia']);
    // Convierte el valor de 'id_denuncia' a un número entero usando 'intval()'.
    // Esto es una buena práctica de seguridad para asegurar que el ID es tratado estrictamente como un número y prevenir posibles manipulaciones.

    $sql = "DELETE FROM formulario_violencia WHERE id = ?";
    // Define la consulta SQL para **eliminar** un registro de la tabla 'formulario_violencia'.
    // La cláusula 'WHERE id = ?' especifica que solo se eliminará la fila cuyo 'id' coincida con el valor que se proporcionará. El signo de interrogación (?) es un marcador de posición para una sentencia preparada.

    $stmt = $conn->prepare($sql);
    // Prepara la sentencia SQL para su ejecución. El método 'prepare()' del objeto de conexión ($conn) devuelve un objeto de sentencia ($stmt).
    // Usar sentencias preparadas es una **medida de seguridad crucial** para prevenir ataques de inyección SQL, ya que separa la consulta de los datos.

    if ($stmt) {
    // Comprueba si la preparación de la sentencia fue exitosa (es decir, si $stmt es un objeto válido y no es falso).
    // Si hay un error de sintaxis en la consulta SQL o un problema con la conexión, 'prepare()' podría devolver falso.

        $stmt->bind_param("i", $id);
        // Vincula el valor de la variable '$id' al marcador de posición (?) en la sentencia preparada.
        // "i" indica que el tipo de dato del parámetro es un entero (integer).

        if ($stmt->execute()) {
        // Ejecuta la sentencia preparada en la base de datos.
        // Comprueba si la ejecución de la consulta de eliminación fue exitosa.

            echo "<p style='color:green;'>Denuncia eliminada correctamente.</p>";
            // Si la eliminación fue exitosa, imprime un mensaje de confirmación en color verde.

        } else {
        // Si la ejecución de la sentencia falla (por ejemplo, por un error en la base de datos durante la eliminación).

            echo "<p style='color:red;'>Error al eliminar: " . $stmt->error . "</p>";
            // Imprime un mensaje de error en color rojo, incluyendo el mensaje de error específico devuelto por la sentencia ($stmt->error).

        }
        $stmt->close();
        // Cierra el objeto de sentencia preparada. Esto libera los recursos de memoria y del servidor de la base de datos asociados con esta consulta específica. Es una buena práctica para la gestión de recursos.

    } else {
    // Si la preparación de la sentencia falló (es decir, $stmt fue falso).

        echo "<p style='color:red;'>Error al preparar la consulta: " . $conn->error . "</p>";
        // Imprime un mensaje de error en rojo, indicando que hubo un problema al preparar la consulta, y muestra el error específico de la conexión ($conn->error).

    }
} else {
// Si 'id_denuncia' no fue proporcionado en la solicitud POST o no era un número válido.

    echo "<p style='color:red;'>No se proporcionó un ID válido.</p>";
    // Imprime un mensaje de error en rojo al usuario.
}
// Es importante notar que $conn->close() no está explícitamente aquí, pero en muchos entornos PHP, la conexión se cierra automáticamente al finalizar la ejecución del script.

?>
