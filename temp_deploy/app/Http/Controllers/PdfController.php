<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    // Generación de PDF para boleta, recibos, contratos
    public function boleta($prestamoId) {
        // Lógica para generar PDF de boleta de empeño
    }
    public function recibo($pagoId) {
        // Lógica para generar PDF de recibo
    }
    public function contrato($prestamoId) {
        // Lógica para generar PDF de contrato personalizado
    }
}
