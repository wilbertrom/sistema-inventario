<?php
require_once 'vendor/autoload.php';

echo "<h2>MPDF está instalado</h2>";
echo "Versión: " . (class_exists('Mpdf\Mpdf') ? 'OK' : 'No encontrado');

// Probar creación simple
try {
    $mpdf = new \Mpdf\Mpdf();
    echo "<br>✅ Mpdf se puede instanciar correctamente";
} catch (Exception $e) {
    echo "<br>❌ Error: " . $e->getMessage();
}
