<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class importanteModel extends Model
{
    use HasFactory;
    protected $table = "importante";
    protected $filable = [
        "id_importante",
        "importante"
    ];
    public $timestamps = false;
    protected $primaryKey = "id_importante";
}
