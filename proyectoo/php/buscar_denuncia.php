<?php
// Inicia el bloque de código PHP.

include("conexion.php");
// Incluye el archivo "conexion.php". Este archivo es fundamental porque contiene el código necesario para establecer la conexión a tu base de datos (por ejemplo, define la variable $conn).
// A diferencia de 'require', 'include' solo emitirá una advertencia si el archivo no se encuentra, pero el script intentará continuar.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Comprueba si la solicitud HTTP actual se realizó utilizando el método POST.
// Esto asegura que el script solo procese datos cuando son enviados desde un formulario POST.

    if (isset($_POST['id_denuncia']) && is_numeric($_POST['id_denuncia'])) {
    // Inicia una condición anidada:
    // 'isset($_POST['id_denuncia'])' verifica si la variable 'id_denuncia' existe en los datos enviados por POST.
    // 'is_numeric($_POST['id_denuncia'])' verifica si el valor de 'id_denuncia' es un número, para asegurar que es un ID válido.

        $id = intval($_POST['id_denuncia']);
        // Convierte el valor de 'id_denuncia' a un entero usando 'intval()'.
        // Esto es una buena práctica de seguridad para asegurar que el ID sea tratado como un número y evitar posibles inyecciones.

        // Consulta preparada usando $conn
        // Comentario que indica el inicio de la sección de la consulta a la base de datos.

        $sql = "SELECT * FROM formulario_violencia WHERE id = ?";
        // Define la consulta SQL para seleccionar todas las columnas (*) de la tabla 'formulario_violencia'.
        // El 'WHERE id = ?' es un marcador de posición para el ID de la denuncia, parte de una sentencia preparada.

        $stmt = $conn->prepare($sql);
        // Prepara la sentencia SQL para su ejecución. El método 'prepare()' del objeto de conexión ($conn) devuelve un objeto de sentencia ($stmt).
        // Las sentencias preparadas son cruciales para prevenir ataques de inyección SQL, ya que separan la consulta de los datos.

        if ($stmt) {
        // Comprueba si la preparación de la sentencia fue exitosa (es decir, si $stmt no es falso).
        // Si hay un error al preparar la consulta, $stmt sería falso.

            $stmt->bind_param("i", $id);
            // Vincula el valor de la variable '$id' al marcador de posición (?) en la sentencia preparada.
            // "i" indica que el tipo de dato del parámetro es un entero (integer).

            $stmt->execute();
            // Ejecuta la sentencia preparada en la base de datos.

            $resultado = $stmt->get_result();
            // Obtiene el conjunto de resultados de la consulta ejecutada.

            if ($resultado->num_rows > 0) {
            // Comprueba si el número de filas devueltas por la consulta es mayor que cero.
            // Esto significa que se encontró al menos una denuncia con el ID proporcionado.

                while ($fila = $resultado->fetch_assoc()) {
                // Inicia un bucle 'while' para iterar sobre cada fila de resultados.
                // 'fetch_assoc()' obtiene la siguiente fila como un array asociativo (clave-valor, donde la clave es el nombre de la columna).

                    echo "<h2>Denuncia #{$fila['id']}</h2>";
                    // Imprime un encabezado H2 con el ID de la denuncia.

                    echo "<p><strong>Nombre:</strong> {$fila['nombre']}</p>";
                    // Imprime un párrafo con el nombre de la persona denunciante.

                    echo "<p><strong>Edad:</strong> {$fila['edad']}</p>";
                    // Imprime un párrafo con la edad.

                    echo "<p><strong>Teléfono:</strong> {$fila['telefono']}</p>";
                    // Imprime un párrafo con el número de teléfono.

                    echo "<p><strong>Correo:</strong> {$fila['email']}</p>";
                    // Imprime un párrafo con el correo electrónico.

                    echo "<p><strong>Género:</strong> {$fila['genero']}</p>";
                    // Imprime un párrafo con el género.

                    echo "<p><strong>Violencia:</strong> {$fila['violencia']}</p>";
                    // Imprime un párrafo con el tipo de violencia.

                    echo "<p><strong>Lugar:</strong> {$fila['lugar']}</p>";
                    // Imprime un párrafo con el lugar donde ocurrió la violencia.

                    echo "<p><strong>Agresor:</strong> {$fila['agresor']}</p>";
                    // Imprime un párrafo con información sobre el agresor.

                    echo "<p><strong>Consciente:</strong> {$fila['consciente']}</p>";
                    // Imprime un párrafo indicando si la persona es consciente de la situación.

                    echo "<p><strong>Fecha del suceso:</strong> {$fila['fecha_suceso']}</p>";
                    // Imprime un párrafo con la fecha en que ocurrió el suceso.

                    echo "<p><strong>Evidencia:</strong> {$fila['evidencia_nombre']}</p>";
                    // Imprime un párrafo con el nombre de la evidencia.
                }
            } else {
            // Si el número de filas es 0, significa que no se encontró ninguna denuncia.

                echo "<p style='color:red;'>❌ No se encontró ninguna denuncia con ese ID.</p>";
                // Muestra un mensaje de error en rojo al usuario.
            }

            $stmt->close();
            // Cierra el objeto de sentencia preparada. Esto libera los recursos de memoria asociados con la consulta.
            // Es una buena práctica liberar estos recursos una vez que la operación ha terminado.

        } else {
        // Si la preparación de la sentencia falló ($stmt fue falso).

            echo "<p style='color:red;'>❌ Error al preparar la consulta: " . $conn->error . "</p>";
            // Muestra un mensaje de error indicando que hubo un problema al preparar la consulta, incluyendo el error específico de la conexión ($conn->error).
        }
    } else {
    // Si la variable 'id_denuncia' no fue enviada o no es un número válido.

        echo "<p style='color:red;'>⚠️ El ID ingresado no es válido.</p>";
        // Muestra un mensaje de advertencia al usuario.
    }

    $conn->close();
    // Cierra la conexión a la base de datos.
    // Es importante cerrar la conexión cuando ya no se necesita para liberar recursos del servidor.

} else {
// Si la solicitud HTTP no fue un método POST.

    echo "<p style='color:red;'>❌ Método no permitido.</p>";
    // Muestra un mensaje de error indicando que el script solo acepta solicitudes POST.
}
?>
