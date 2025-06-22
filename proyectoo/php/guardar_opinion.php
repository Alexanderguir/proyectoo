<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php"); // Asegúrate que "conexion.php" establece correctamente $conn

// Verifica si el formulario fue enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Captura los datos enviados desde el formulario HTML
    $sitio = $_POST["sitio"]; // Respuesta a "¿Te gustó el sitio?"
    $mejoras = $_POST["mejoras"]; // Comentario general de mejora
    $parte_mejorar = $_POST["parte_mejorar"]; // Parte específica a mejorar
    $satisfaccion = $_POST["satisfaccion"]; // Nivel de satisfacción

    // Prepara la consulta SQL usando prepared statements para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO opiniones (sitio, mejoras, parte_mejorar, satisfaccion) VALUES (?, ?, ?, ?)");

    // Enlaza los parámetros con los valores del formulario
    $stmt->bind_param("ssss", $sitio, $mejoras, $parte_mejorar, $satisfaccion);

    // Ejecuta la consulta y verifica si fue exitosa
    if ($stmt->execute()) {
        // Si se guarda correctamente, muestra un mensaje y redirige
        echo "<script>alert('Gracias por tu opinión.'); window.location.href = '../cecy.html';</script>";
    } else {
        // Si ocurre un error, lo muestra
        echo "Error al guardar la opinión: " . $stmt->error;
    }

    // Cierra el statement y la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>
