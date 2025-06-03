<?php
session_start();
$conn = new mysqli("localhost", "root", "", "computadoras_db");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $verificar = $conn->query("SELECT * FROM usuarios WHERE usuario = '$usuario'");
    if ($verificar->num_rows > 0) {
        $error = "El usuario ya existe.";
    } else {
        $conn->query("INSERT INTO usuarios (usuario, clave) VALUES ('$usuario', '$clave')");
        $_SESSION['user'] = $usuario;
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <form method="POST" class="login-form">
        <h2>Registro</h2>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p><a href="login.php">¿Ya tienes cuenta? Inicia sesión</a></p>
    </form>
</div>
</body>
</html>
