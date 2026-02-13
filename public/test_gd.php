<?php
echo "<h3>GD Test</h3>";
echo "PHP Version: " . phpversion() . "<br>";

if (extension_loaded('gd')) {
    echo "✅ GD está instalado<br>";
    $gd_info = gd_info();
    echo "GD Version: " . $gd_info['GD Version'] . "<br>";
    echo "JPEG Support: " . ($gd_info['JPEG Support'] ? "✅" : "❌") . "<br>";
    echo "PNG Support: " . ($gd_info['PNG Support'] ? "✅" : "❌") . "<br>";
    echo "GIF Support: " . ($gd_info['GIF Read Support'] ? "✅" : "❌") . "<br>";
    
    // Probar Intervention Image
    if (class_exists('Intervention\Image\ImageManager')) {
        echo "Intervention Image: ✅ Disponible<br>";
        try {
            $manager = new Intervention\Image\ImageManager(['driver' => 'gd']);
            echo "GD Driver: ✅ Funciona correctamente";
        } catch (Exception $e) {
            echo "GD Driver: ❌ Error: " . $e->getMessage();
        }
    }
} else {
    echo "❌ GD NO está instalado<br>";
    
    // Mostrar todas las extensiones cargadas
    echo "<h4>Extensiones cargadas:</h4>";
    $extensions = get_loaded_extensions();
    sort($extensions);
    echo implode(", ", $extensions);
}
