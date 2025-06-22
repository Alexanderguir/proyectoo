<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Verifica si el formulario fue enviado mediante método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Captura los datos enviados desde el formulario HTML
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $genero = $_POST["genero"];
    $violencia = $_POST["violencia"];
    $lugar = $_POST["lugar"];
    $agresor = $_POST["agresor"];
    $consciente = $_POST["consciente"];
    $fecha = $_POST["fecha"];

    // Inicializa variable para el nombre del archivo de evidencia
    $evidencia_nombre = null;

    // Verifica si se subió un archivo sin errores
    if (isset($_FILES["evidencia"]) && $_FILES["evidencia"]["error"] === 0) {
        // Guarda el nombre original del archivo
        $evidencia_nombre = basename($_FILES["evidencia"]["name"]);

        // Define la ruta de destino donde se almacenará el archivo
        $ruta_destino = "../evidencias/" . $evidencia_nombre;

        // Mueve el archivo cargado desde la carpeta temporal a la de destino
        move_uploaded_file($_FILES["evidencia"]["tmp_name"], $ruta_destino);
    }

    // Prepara la consulta SQL para insertar los datos en la tabla
    $sql = "INSERT INTO formulario_violencia 
            (nombre, edad, telefono, email, genero, violencia, lugar, agresor, consciente, fecha_suceso, evidencia_nombre)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepara la sentencia para evitar inyecciones SQL
    $stmt = $conn->prepare($sql);

    // Asocia los parámetros recibidos con la consulta
    $stmt->bind_param("sisssssssss", $nombre, $edad, $telefono, $email, $genero, $violencia, $lugar, $agresor, $consciente, $fecha, $evidencia_nombre);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Obtiene el ID de la denuncia recién registrada (autoincremental)
        $id_insertado = $stmt->insert_id;

        // Muestra un mensaje emergente con el número de denuncia
        echo "<script>alert('Formulario enviado correctamente. Tu número de denuncia es: $id_insertado'); window.location.href='../formularios2.0.html';</script>";
    } else {
        // Si hubo error en la ejecución, lo muestra
        echo "Error: " . $stmt->error;
    }

    // Cierra la sentencia y la conexión
    $stmt->close();
    $conn->close();
}
?>
