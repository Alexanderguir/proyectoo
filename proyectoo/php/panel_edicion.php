<?php
session_start(); // Inicia la sesión PHP para acceder o almacenar variables de sesión.
require 'conexion.php'; // Incluye el archivo 'conexion.php', que probablemente contiene la lógica para conectar a la base de datos.

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) { // Comprueba si la variable de sesión 'usuario_id' no está establecida.
    echo "<script>alert('Debes iniciar sesión.'); window.location.href='../acceso.html';</script>"; // Muestra una alerta JavaScript y redirige al usuario a 'acceso.html' si no ha iniciado sesión.
    exit(); // Termina la ejecución del script.
}

// Obtener los datos del usuario desde la base de datos
$id = $_SESSION['usuario_id']; // Asigna el ID del usuario de la sesión a la variable $id.
$sql = "SELECT * FROM usuarios WHERE id=?"; // Prepara una consulta SQL para seleccionar todos los datos del usuario donde el ID coincida.
$stmt = $conn->prepare($sql); // Prepara la declaración SQL para evitar inyecciones SQL.
$stmt->bind_param("i", $id); // Vincula el parámetro ID (como entero 'i') a la declaración preparada.
$stmt->execute(); // Ejecuta la declaración preparada.
$resultado = $stmt->get_result(); // Obtiene el resultado de la consulta.
$usuario = $resultado->fetch_assoc(); // Recupera la fila de resultados como un array asociativo.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <title>Editar Datos</title> <link rel="icon" href="imagenes/logo.jpg" type="image/png"> <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;600&display=swap" rel="stylesheet"> <style>
        /* Reset básico */
        * {
            margin: 0; /* Elimina el margen predeterminado de todos los elementos. */
            padding: 0; /* Elimina el padding predeterminado de todos los elementos. */
            box-sizing: border-box; /* Establece el modelo de caja a 'border-box' para incluir padding y borde en el ancho/alto total. */
            font-family: 'Montserrat Alternates', sans-serif; /* Aplica la fuente 'Montserrat Alternates' a todos los elementos. */
        }

        body {
            background-image: url("/proyectoo/imagenes/fondo.jpg"); /* Establece una imagen de fondo para el cuerpo de la página. */
            background-attachment: fixed; /* Mantiene la imagen de fondo fija mientras se desplaza la página. */
            background-size: cover; /* Ajusta la imagen de fondo para cubrir todo el elemento. */
            background-position: center; /* Centra la imagen de fondo. */
            min-height: 100vh; /* Establece la altura mínima del cuerpo al 100% de la altura de la ventana. */
            display: flex; /* Usa flexbox para el diseño. */
            justify-content: center; /* Centra horizontalmente los elementos hijos. */
            align-items: center; /* Centra verticalmente los elementos hijos. */
        }

        .form-container {
            background: rgba(0, 0, 0, 0.7); /* Establece un fondo semitransparente oscuro para el contenedor del formulario. */
            padding: 40px; /* Añade padding interno al contenedor del formulario. */
            border-radius: 15px; /* Redondea las esquinas del contenedor del formulario. */
            box-shadow: 0 8px 16px rgba(0,0,0,0.5); /* Añade una sombra al contenedor del formulario. */
            width: 90%; /* Establece el ancho del contenedor del formulario al 90% del contenedor padre. */
            max-width: 400px; /* Establece el ancho máximo del contenedor del formulario. */
            color: #fff; /* Establece el color del texto a blanco. */
            text-align: center; /* Centra el texto dentro del contenedor del formulario. */
        }

        .form-container h2 {
            margin-bottom: 20px; /* Añade un margen inferior al título H2. */
            font-size: 26px; /* Establece el tamaño de la fuente del título H2. */
            color: #ffffff; /* Establece el color del título H2 a blanco. */
            text-shadow: 1px 1px 5px rgba(0,0,0,0.7); /* Añade una sombra al texto del título H2. */
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%; /* Establece el ancho de los campos de entrada al 100% del contenedor padre. */
            padding: 12px; /* Añade padding interno a los campos de entrada. */
            margin: 10px 0 20px; /* Añade margen superior, inferior y a los lados a los campos de entrada. */
            border: none; /* Elimina el borde de los campos de entrada. */
            border-radius: 8px; /* Redondea las esquinas de los campos de entrada. */
            background: rgba(255,255,255,0.1); /* Establece un fondo semitransparente claro para los campos de entrada. */
            color: #fff; /* Establece el color del texto de los campos de entrada a blanco. */
            font-size: 16px; /* Establece el tamaño de la fuente de los campos de entrada. */
        }

        .form-container input[type="submit"] {
            background-color: #00c3ff; /* Establece el color de fondo del botón de envío. */
            color: #fff; /* Establece el color del texto del botón de envío a blanco. */
            border: none; /* Elimina el borde del botón de envío. */
            padding: 12px 20px; /* Añade padding interno al botón de envío. */
            border-radius: 25px; /* Redondea las esquinas del botón de envío. */
            font-size: 16px; /* Establece el tamaño de la fuente del botón de envío. */
            cursor: pointer; /* Cambia el cursor a un puntero cuando se pasa sobre el botón. */
            transition: 0.3s ease; /* Añade una transición suave a los cambios de propiedades del botón. */
        }

        .form-container input[type="submit"]:hover {
            background-color: #009ecf; /* Cambia el color de fondo del botón de envío al pasar el ratón por encima. */
        }

        .form-container a {
            color: #00c3ff; /* Establece el color de los enlaces. */
            display: inline-block; /* Hace que los enlaces se comporten como bloques en línea. */
            margin-top: 15px; /* Añade un margen superior a los enlaces. */
            text-decoration: none; /* Elimina el subrayado de los enlaces. */
            transition: 0.3s; /* Añade una transición suave a los cambios de propiedades de los enlaces. */
        }

        .form-container a:hover {
            text-decoration: underline; /* Subraya los enlaces al pasar el ratón por encima. */
            color: #fff; /* Cambia el color de los enlaces a blanco al pasar el ratón por encima. */
        }
    </style>
</head>
<body>

    <div class="form-container"> <h2>Editar Información de Cuenta</h2> <form action="actualizar.php" method="POST"> <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>"> <input type="text" name="nombre_usuario" placeholder="Usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required> <input type="email" name="email" placeholder="Correo Electrónico" value="<?php echo $usuario['email']; ?>" required> <input type="password" name="nueva_contraseña" placeholder="Nueva Contraseña"> <input type="submit" value="Actualizar Datos"> </form>
        <a href="cerrar_sesion.php">Cerrar Sesión</a> </div>

</body>
</html>