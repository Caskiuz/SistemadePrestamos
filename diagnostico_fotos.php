<?php

use App\Models\FotoEquipo;
use App\Models\Producto;

echo "=== DIAGNÓSTICO DE FOTOS ===\n\n";

echo "1. Fotos en base de datos:\n";
$fotos = FotoEquipo::all();
foreach($fotos as $foto) {
    echo "ID: {$foto->id} | Producto: {$foto->equipo_id} | Ruta: {$foto->ruta}\n";
    $rutaCompleta = public_path($foto->ruta);
    echo "   Archivo existe: " . (file_exists($rutaCompleta) ? "SÍ" : "NO") . "\n";
    echo "   Ruta completa: {$rutaCompleta}\n\n";
}

echo "2. Productos con fotos:\n";
$productos = Producto::with('fotos')->get();
foreach($productos as $producto) {
    if($producto->fotos->count() > 0) {
        echo "Producto ID: {$producto->id} | Nombre: {$producto->nombre} | Fotos: {$producto->fotos->count()}\n";
    }
}

echo "\n3. Archivos físicos en public/fotos:\n";
$archivos = glob(public_path('fotos/*'));
foreach($archivos as $archivo) {
    if(is_file($archivo)) {
        echo basename($archivo) . " (" . filesize($archivo) . " bytes)\n";
    }
}