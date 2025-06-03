<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Computadoras</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Computadoras ProTech</h1>
        <nav>
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="login.php">Login</a>
            <?php else: ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2>Catálogo</h2>
        <div class="catalogo">
            <?php
            $conn = new mysqli("localhost", "root", "", "computadoras_db");
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM productos";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='producto'>
                        <h3>{$row['nombre']}</h3>
                        <p>{$row['descripcion']}</p>
                        <p class='precio'>\${$row['precio']}</p>
                        <form method='POST' action='ordenar.php'>
                            <input type='hidden' name='producto_id' value='{$row['id']}'>
                            <button type='submit'>Comprar</button>
                        </form>
                      </div>";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Computadoras ProTech</p>
    </footer>
</body>
</html>
