<?php
// Inicia el bloque de código PHP.

require 'conexion.php';
// Incluye el archivo 'conexion.php'. Este archivo es crucial porque contiene la configuración y el código para establecer la conexión a tu base de datos (por ejemplo, define una variable $conn).
// Es fundamental para que el script pueda realizar operaciones en la base de datos. Si no puede encontrar o incluir este archivo, el script detendrá su ejecución.

$nombre_usuario = $_GET['nombre_usuario'];
// Obtiene el valor del parámetro 'nombre_usuario' de la cadena de consulta de la URL (usando el método GET).
// Por ejemplo, si la URL es 'mi_script.php?nombre_usuario=juan', la variable $nombre_usuario contendrá "juan".

$sql = "SELECT id, nombre_usuario, email FROM usuarios WHERE nombre_usuario LIKE ?";
// Define la consulta SQL que se va a ejecutar.
// Esta consulta seleccionará las columnas 'id', 'nombre_usuario' y 'email' de la tabla 'usuarios'.
// La cláusula 'WHERE nombre_usuario LIKE ?' se utiliza para buscar nombres de usuario que coincidan parcialmente con el texto proporcionado. El signo de interrogación (?) es un marcador de posición para un valor que se vinculará más tarde (parte de las sentencias preparadas).

$stmt = $conn->prepare($sql);
// Prepara la sentencia SQL para su ejecución. El método 'prepare()' del objeto de conexión ($conn) devuelve un objeto de sentencia ($stmt).
// Utilizar sentencias preparadas es una práctica de seguridad esencial, ya que ayuda a prevenir ataques de inyección SQL al separar la lógica de la consulta de los datos de entrada.

$busqueda = "%$nombre_usuario%";
// Crea la cadena de búsqueda añadiendo caracteres comodín de porcentaje (%) al inicio y al final del valor de $nombre_usuario.
// Los comodines % en SQL significan "cero o más caracteres de cualquier tipo".
// Esto permite que la búsqueda 'LIKE' encuentre coincidencias parciales (por ejemplo, si $nombre_usuario es "juan", $busqueda será "%juan%", lo que coincidirá con "juanito", "Don Juan", etc.).

$stmt->bind_param("s", $busqueda);
// Vincula el valor de la variable '$busqueda' al primer (y único) marcador de posición (?) en la sentencia preparada.
// "s" indica que el tipo de dato del parámetro que se está vinculando es una cadena de texto (string).

$stmt->execute();
// Ejecuta la sentencia preparada en la base de datos. En este punto, la consulta se envía al servidor de la base de datos con los parámetros ya seguros.

$result = $stmt->get_result();
// Obtiene el conjunto de resultados de la consulta ejecutada. Este método es útil cuando se usa MySQLi con sentencias preparadas y se necesita trabajar con los resultados como un objeto de resultados.

if ($result->num_rows > 0) {
// Comprueba si el número de filas devueltas por la consulta es mayor que cero.
// Esto significa que se encontraron uno o más usuarios que coinciden con el criterio de búsqueda.

    while ($fila = $result->fetch_assoc()) {
    // Inicia un bucle 'while' que se ejecutará mientras haya filas de resultados para procesar.
    // '$result->fetch_assoc()' recupera la siguiente fila del conjunto de resultados como un array asociativo, donde las claves del array son los nombres de las columnas de la tabla (ej. 'id', 'nombre_usuario', 'email').

        echo "ID: " . $fila["id"] . "<br>";
        // Imprime el valor de la columna 'id' de la fila actual, seguido de un salto de línea HTML.

        echo "Usuario: " . $fila["nombre_usuario"] . "<br>";
        // Imprime el valor de la columna 'nombre_usuario' de la fila actual, seguido de un salto de línea HTML.

        echo "Email: " . $fila["email"] . "<br><br>";
        // Imprime el valor de la columna 'email' de la fila actual, seguido de dos saltos de línea HTML para separar visualmente cada usuario.
    }
} else {
// Si el número de filas devueltas es 0.
// Esto significa que no se encontró ningún usuario que coincida con el nombre de búsqueda.

    echo "No se encontraron resultados.";
    // Imprime un mensaje indicando que no se encontraron usuarios.
}

$stmt->close();
// Cierra el objeto de la sentencia preparada. Esto libera los recursos de memoria y del servidor de la base de datos asociados con esta consulta específica. Es una buena práctica para optimizar el rendimiento.

$conn->close();
// Cierra la conexión a la base de datos. Esto libera los recursos generales de la conexión.
// Siempre es recomendable cerrar la conexión a la base de datos una vez que todas las operaciones se han completado para evitar el agotamiento de recursos del servidor.

?>
