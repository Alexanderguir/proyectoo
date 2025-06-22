<?php
// Incluye el archivo que contiene la conexión a la base de datos
include("conexion.php");

// Verifica si el formulario fue enviado por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene el nombre de usuario y la contraseña enviados desde el formulario
    $usuario = $_POST["nombre_usuario"];
    $contraseña = $_POST["contraseña"];

    // Prepara una consulta para buscar al usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);  // 's' significa que se espera una cadena
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si se encuentra exactamente un usuario con ese nombre
    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();  // Obtiene los datos del usuario

     

        //  usar password_verify
        if (password_verify($contraseña, $fila["contraseña"])) {

            // Si la contraseña es correcta, prepara la eliminación del usuario
            $sqlEliminar = "DELETE FROM usuarios WHERE nombre_usuario = ?";
            $stmtEliminar = $conn->prepare($sqlEliminar);
            $stmtEliminar->bind_param("s", $usuario);

            // Ejecuta la eliminación y muestra mensaje correspondiente
            if ($stmtEliminar->execute()) {
                echo "<script>alert('Cuenta eliminada correctamente.'); window.location.href='../registro.html';</script>";
            } else {
                echo "Error al eliminar la cuenta.";
            }

        } else {
            // Si la contraseña no coincide
            echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
        }
    } else {
        // Si el usuario no existe
        echo "<script>alert('Usuario no encontrado.'); window.history.back();</script>";
    }

    // Cierra las conexiones
    $stmt->close();
    $conn->close();
}
?>
