<?php
// Establece el encabezado Content-Type para indicar que la respuesta será en formato JSON.
header('Content-Type: application/json');

// Incluye el archivo de conexión a la base de datos.
// Se espera que este archivo contenga la lógica para establecer la conexión a la base de datos,
// probablemente configurando una variable llamada $conexion para el enlace de la base de datos.
include("conexion.php");

// Verifica si el parámetro 'id' ha sido enviado a través de una solicitud POST.
if (isset($_POST['id'])) {
    // Sanea la entrada 'id' convirtiéndola a un entero.
    // Esto ayuda a prevenir ataques de inyección SQL.
    $id = intval($_POST['id']);

    // Prepara una sentencia SQL SELECT para recuperar todas las columnas (*)
    // de la tabla 'formulario_violencia' donde el 'id' coincida con el ID proporcionado.
    // El '?' es un marcador de posición para la sentencia preparada.
    $sql = "SELECT * FROM formulario_violencia WHERE id = ?";
    $stmt = $conn->prepare($sql); // Prepara la sentencia SQL para su ejecución.

    // Verifica si la sentencia se preparó correctamente.
    if ($stmt) {
        // Vincula el parámetro 'id' (entero) a la sentencia preparada.
        // La "i" indica que el parámetro es un entero.
        $stmt->bind_param("i", $id);
        $stmt->execute(); // Ejecuta la sentencia preparada.

        // Obtiene el conjunto de resultados de la sentencia ejecutada.
        $resultado = $stmt->get_result();

        // Verifica si se devolvió alguna fila de la consulta.
        if ($resultado->num_rows > 0) {
            // Si se encuentra un registro, lo recupera como un array asociativo
            // y lo codifica en formato JSON, luego lo imprime (output).
            echo json_encode($resultado->fetch_assoc());
        } else {
            // Si no se encuentra ningún registro con el ID dado, devuelve un mensaje de error JSON.
            echo json_encode(["error" => "No se encontró una denuncia con ese ID."]);
        }

        // Cierra la sentencia preparada para liberar recursos.
        $stmt->close();
    } else {
        // Si hubo un error al preparar la sentencia SQL, devuelve un error JSON.
        echo json_encode(["error" => "Error al preparar la consulta."]);
    }
} else {
    // Si no se proporcionó el parámetro 'id' en la solicitud POST, devuelve un error JSON.
    echo json_encode(["error" => "ID no proporcionado."]);
}

// Buena práctica: Cierra la conexión a la base de datos cuando todas las operaciones hayan terminado.
$conn->close();
?>