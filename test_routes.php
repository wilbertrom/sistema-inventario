<?php
echo "<h2>Diagnóstico de Rutas</h2>";

echo "<h3>Controlador existe:</h3>";
$controller = 'application/controllers/ProgramaAnual.php';
if (file_exists($controller)) {
    echo "✅ ProgramaAnual.php existe<br>";
    include $controller;
    if (class_exists('ProgramaAnual')) {
        echo "✅ Clase ProgramaAnual existe<br>";
    } else {
        echo "❌ Clase ProgramaAnual NO existe en el archivo<br>";
    }
} else {
    echo "❌ ProgramaAnual.php NO existe<br>";
}

echo "<h3>Vistas existen:</h3>";
$views = [
    'application/views/programa_anual/index.php',
    'application/views/programa_anual/editar.php',
    'application/views/programa_anual/pdf_nuevo.php'
];
foreach ($views as $v) {
    echo (file_exists($v) ? '✅' : '❌') . " $v<br>";
}

echo "<h3>Rutas definidas:</h3>";
include 'application/config/routes.php';
echo "Ruta programa-anual: " . (isset($route['programa-anual']) ? 'DEFINIDA' : 'NO DEFINIDA') . "<br>";
echo "Valor: " . ($route['programa-anual'] ?? 'no existe') . "<br>";