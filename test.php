<?php
echo "<h2>Diagnóstico del Sistema</h2>";

echo "<h3>1. Directorio actual:</h3>";
echo getcwd() . "<br>";

echo "<h3>2. Archivos en controllers:</h3>";
$controllers = glob('application/controllers/*.php');
if (empty($controllers)) {
    echo "❌ No hay controladores en application/controllers/<br>";
} else {
    foreach($controllers as $c) {
        echo "✅ " . basename($c) . "<br>";
    }
}

echo "<h3>3. Configuración:</h3>";
require_once 'application/config/config.php';
echo "Base URL: " . (isset($config['base_url']) ? $config['base_url'] : '❌ NO DEFINIDA') . "<br>";
echo "Index Page: " . (isset($config['index_page']) ? $config['index_page'] : '❌ NO DEFINIDA') . "<br>";

echo "<h3>4. Archivo .htaccess:</h3>";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess existe<br>";
    echo "<pre>" . htmlspecialchars(file_get_contents('.htaccess')) . "</pre>";
} else {
    echo "❌ .htaccess NO existe<br>";
}

echo "<h3>5. Enlaces de prueba:</h3>";
echo '<a href="' . $config['base_url'] . 'index.php/login">Con index.php</a><br>';
echo '<a href="' . $config['base_url'] . 'login">Sin index.php</a><br>';