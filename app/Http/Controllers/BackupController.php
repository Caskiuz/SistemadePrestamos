<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backup;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::orderBy('created_at', 'desc')->paginate(15);
        return view('modules.sistema.backups', compact('backups'));
    }

    public function generar()
    {
        \Artisan::call('backup:generar', ['--tipo' => 'manual']);
        return redirect()->back()->with('success', 'Backup generado exitosamente');
    }
}