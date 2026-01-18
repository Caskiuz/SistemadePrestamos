<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FotoHelper
{
    public static function subirFoto(UploadedFile $foto, string $carpeta = 'equipos_fotos'): string
    {
        // Generar nombre único
        $nombreArchivo = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
        
        // Ruta completa
        $rutaCompleta = public_path($carpeta);
        
        // Crear directorio si no existe
        if (!file_exists($rutaCompleta)) {
            mkdir($rutaCompleta, 0755, true);
        }
        
        // Mover archivo
        $foto->move($rutaCompleta, $nombreArchivo);
        
        return $carpeta . '/' . $nombreArchivo;
    }
    
    public static function subirMultiplesFotos(array $fotos, string $carpeta = 'equipos_fotos'): array
    {
        $rutasFotos = [];
        
        foreach ($fotos as $foto) {
            if ($foto instanceof UploadedFile && $foto->isValid()) {
                $rutasFotos[] = self::subirFoto($foto, $carpeta);
            }
        }
        
        return $rutasFotos;
    }
    
    public static function eliminarFoto(string $ruta): bool
    {
        $rutaCompleta = public_path($ruta);
        
        if (file_exists($rutaCompleta)) {
            return unlink($rutaCompleta);
        }
        
        return false;
    }
    
    public static function obtenerUrlFoto(string $ruta): string
    {
        return asset($ruta);
    }
}