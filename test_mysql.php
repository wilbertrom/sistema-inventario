<?php
// Crea: C:\xampp\htdocs\sistema_inventario\test_mysql.php
$mysqli = new mysqli("localhost", "sistemainvuser", "Sistemainvuser27_");
if ($mysqli->connect_error) {
    die("Error: " . $mysqli->connect_error);
} else {
    echo "✅ MySQL conectado!";
    $mysqli->select_db("sistemainv") or die("❌ Error seleccionando BD: " . $mysqli->error);
    echo "<br>✅ Base de datos seleccionada!";
}
?>