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

// Consulta SQL para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Mostrar los usuarios en una tabla
if ($result->num_rows > 0) {
    echo "<table style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: blue; color: white;'>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Nombre</th>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Apellido</th>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Email</th>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Fecha de Nacimiento</th>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Matrícula</th>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Género</th>";
    echo "<th style='border: 1px solid white; padding: 8px;'>Acción</th>"; // Nueva columna para el botón de cargar foto
    echo "</tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $row["nombre"] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $row["apellido"] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $row["email"] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $row["fecha_nacimiento"] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $row["identificacion"] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'>" . $row["genero"] . "</td>";
        echo "<td style='border: 1px solid black; padding: 8px;'><a href='cargar_foto.php?usuario_id=" . $row["id"] . "'><button>Cargar Foto</button></a></td>"; // Botón de cargar foto con enlace a cargar_foto.php y pasando el ID del usuario como parámetro
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay usuarios registrados.";
}

// Cerrar conexión
$conn->close();
?>