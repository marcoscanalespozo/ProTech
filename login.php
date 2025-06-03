<?php
session_start();
$conn = new mysqli("localhost", "root", "", "computadoras_db");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $result = $conn->query("SELECT * FROM usuarios WHERE usuario = '$usuario'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($clave, $row['clave'])) {
            $_SESSION['user'] = $usuario;
            header("Location: index.php");
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <form method="POST" class="login-form">
        <h2>Iniciar Sesión</h2>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p><a href="register.php">¿No tienes cuenta? Regístrate</a></p>
    </form>
</div>
</body>
</html>
