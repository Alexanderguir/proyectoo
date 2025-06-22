<?php
// Abre el bloque de código PHP.

include("conexion.php");
// Incluye el archivo 'conexion.php'. Este archivo es esencial porque contiene la lógica para establecer la conexión a tu base de datos ($conexion). Sin él, el script no podría interactuar con la base de datos.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Inicia un bloque condicional que verifica si la solicitud HTTP que llegó a este script fue de tipo POST. Esto es crucial para asegurar que el código de procesamiento del formulario solo se ejecute cuando se envía un formulario.

    $id = $_POST["id"];
    // Obtiene el valor del campo 'id' enviado a través del método POST y lo asigna a la variable `$id`. Este 'id' probablemente identifica el registro que se va a actualizar en la base de datos.

    $nombre = $_POST["nombre"];
    // Obtiene el valor del campo 'nombre' enviado por POST y lo asigna a `$nombre`.

    $edad = $_POST["edad"];
    // Obtiene el valor del campo 'edad' enviado por POST y lo asigna a `$edad`.

    $telefono = $_POST["telefono"];
    // Obtiene el valor del campo 'telefono' enviado por POST y lo asigna a `$telefono`.

    $email = $_POST["email"];
    // Obtiene el valor del campo 'email' enviado por POST y lo asigna a `$email`.

    $genero = $_POST["genero"];
    // Obtiene el valor del campo 'genero' enviado por POST y lo asigna a `$genero`.

    $violencia = $_POST["violencia"];
    // Obtiene el valor del campo 'violencia' (tipo de violencia) enviado por POST y lo asigna a `$violencia`.

    $lugar = $_POST["lugar"];
    // Obtiene el valor del campo 'lugar' (dónde ocurrió el suceso) enviado por POST y lo asigna a `$lugar`.

    $agresor = $_POST["agresor"];
    // Obtiene el valor del campo 'agresor' (información sobre el agresor) enviado por POST y lo asigna a `$agresor`.

    $consciente = $_POST["consciente"];
    // Obtiene el valor del campo 'consciente' (si la víctima fue consciente) enviado por POST y lo asigna a `$consciente`.

    $fecha = $_POST["fecha_suceso"];
    // Obtiene el valor del campo 'fecha_suceso' (fecha del suceso) enviado por POST y lo asigna a `$fecha`.

    $sql = "UPDATE formulario_violencia SET nombre=?, edad=?, telefono=?, email=?, genero=?, violencia=?, lugar=?, agresor=?, consciente=?, fecha_suceso=? WHERE id=?";
    // Define la consulta SQL de actualización. La cláusula `UPDATE` se usa para modificar registros existentes. Los signos de interrogación `?` son marcadores de posición para los valores que se insertarán de forma segura, previniendo inyecciones SQL. La condición `WHERE id=?` asegura que solo se actualice el registro específico.

    $stmt = $conn->prepare($sql);
    // Prepara la consulta SQL para su ejecución. Esto es un paso de seguridad y eficiencia importante en las bases de datos. Devuelve un objeto de declaración (`$stmt`) que luego se usará para vincular parámetros y ejecutar la consulta.

    $stmt->bind_param("sissssssssi", $nombre, $edad, $telefono, $email, $genero, $violencia, $lugar, $agresor, $consciente, $fecha, $id);
    // Vincula los valores de las variables a los marcadores de posición en la consulta preparada. La cadena "sissssssssi" especifica los tipos de datos de los parámetros en el orden en que aparecen:
    // 's' para string (cadena de texto), 'i' para integer (número entero).
    // Aquí, se asume que 'nombre', 'telefono', 'email', 'genero', 'violencia', 'lugar', 'agresor', 'consciente', 'fecha_suceso' son strings, y 'edad' e 'id' son integers.

    if ($stmt->execute()) {
    // Ejecuta la declaración preparada con los parámetros ya vinculados. Si la ejecución es exitosa (es decir, el registro se actualiza en la base de datos), este bloque `if` se cumple.

        echo "<script>alert('Denuncia actualizada correctamente.'); window.location.href='../formularios2.0.html';</script>";
        // Muestra un mensaje de alerta JavaScript al usuario confirmando que la denuncia se actualizó correctamente y luego redirige el navegador a la página 'formularios2.0.html' (asumiendo que está un directorio arriba).
    } else {
    // Si la ejecución de la consulta `$stmt->execute()` falla, este bloque `else` se activa.

        echo "Error al actualizar: " . $stmt->error;
        // Muestra un mensaje de error detallado, incluyendo el error específico devuelto por la declaración (`$stmt->error`). Esto es útil para la depuración.
    }

    $stmt->close();
    // Cierra la declaración preparada. Esto libera los recursos asociados con la consulta.

    $conn->close();
    // Cierra la conexión a la base de datos. Es una buena práctica liberar los recursos de la base de datos una vez que ya no son necesarios.
}
?>