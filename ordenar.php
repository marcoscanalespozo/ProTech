<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "computadoras_db");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$producto_id = $_POST['producto_id'];
$conn->query("INSERT INTO pedidos (producto_id, usuario) VALUES ($producto_id, '{$_SESSION['user']}')");
$conn->close();
header("Location: index.php");
?>