<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia esto por la dirección de tu servidor de base de datos
$username = "root"; // Cambia esto por tu nombre de usuario de la base de datos
$password = ""; // Cambia esto por tu contraseña de la base de datos
$database = "formulario"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$identificacion = $_POST['identificacion'];
$genero = $_POST['genero'];

// Archivo de la foto
$target_dir = "uploads/"; // Directorio donde se guardarán las fotos
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Verificar si el archivo de la foto es una imagen real o una imagen falsa
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen válida.";
        $uploadOk = 0;
    }
}

// Verificar si el archivo de la foto ya existe
if (file_exists($target_file)) {
    echo "Lo siento, el archivo de la foto ya existe.";
    $uploadOk = 0;
}

// Verificar el tamaño máximo del archivo de la foto (en bytes)
if ($_FILES["foto"]["size"] > 500000) {
    echo "Lo siento, el archivo de la foto es demasiado grande.";
    $uploadOk = 0;
}

// Permitir ciertos formatos de archivo de la foto
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    $uploadOk = 0;
}

// Verificar si $uploadOk está configurado en 0 por un error
if ($uploadOk == 0) {
    echo "Lo siento, tu foto no fue subida.";

// Si todo está bien, intenta subir el archivo de la foto
} else {
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "El archivo ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " ha sido subido.";

        // Insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellido, email, fecha_nacimiento, identificacion, genero, foto)
        VALUES ('$nombre', '$apellido', '$email', '$fecha_nacimiento', '$identificacion', '$genero', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso.";
            header("Location: index.html?success=true"); // Redirigir al usuario a la página principal con un mensaje de éxito
        } else {
            echo "Error al registrar el usuario: " . $conn->error;
        }
    } else {
        echo "Lo siento, hubo un error al subir tu archivo de foto.";
    }
}

// Cerrar conexión
$conn->close();
?>
