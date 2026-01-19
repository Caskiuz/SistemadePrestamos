<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FotoHelper
{
    public static function subirFoto(UploadedFile $foto, string $carpeta = 'equipos_fotos'): string
    {
        // Generar nombre único
        $nombreArchivo = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
        
        // Guardar en storage/app/public
        $ruta = $foto->storeAs($carpeta, $nombreArchivo, 'public');
        
        return $ruta;
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
        return Storage::disk('public')->delete($ruta);
    }
    
    public static function obtenerUrlFoto(string $ruta): string
    {
        return asset('storage/' . $ruta);
    }
}