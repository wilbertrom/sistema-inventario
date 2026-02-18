<?php
echo "<h2>Diagnóstico Completo</h2>";

echo "<h3>1. Archivo de controlador:</h3>";
$controller = 'application/controllers/ProgramaAnual.php';
if (file_exists($controller)) {
    echo "✅ Archivo existe: $controller<br>";
    echo "Tamaño: " . filesize($controller) . " bytes<br>";
    echo "Última modificación: " . date("Y-m-d H:i:s", filemtime($controller)) . "<br>";
    
    // Leer primeras líneas
    $content = file_get_contents($controller);
    if (strpos($content, 'class ProgramaAnual') !== false) {
        echo "✅ Clase 'ProgramaAnual' encontrada<br>";
    } else {
        echo "❌ Clase 'ProgramaAnual' NO encontrada<br>";
    }
} else {
    echo "❌ Archivo NO existe<br>";
}

echo "<h3>2. Archivo de rutas:</h3>";
$routes = 'application/config/routes.php';
if (file_exists($routes)) {
    include $routes;
    echo "Ruta 'programa-anual' = " . (isset($route['programa-anual']) ? $route['programa-anual'] : 'NO DEFINIDA') . "<br>";
} else {
    echo "❌ routes.php no encontrado<br>";
}

echo "<h3>3. Archivo .htaccess:</h3>";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess existe<br>";
    echo "<pre>" . htmlspecialchars(file_get_contents('.htaccess')) . "</pre>";
} else {
    echo "❌ .htaccess NO existe<br>";
}

echo "<h3>4. URLs de prueba:</h3>";
$base = 'http://' . $_SERVER['HTTP_HOST'] . '/sistema_inventario/';
echo "<a href='{$base}index.php/programa-anual' target='_blank'>Con index.php</a><br>";
echo "<a href='{$base}programa-anual' target='_blank'>Sin index.php</a><br>";