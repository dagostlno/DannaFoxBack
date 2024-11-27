<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clienteModel extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    public $timestamps = false;
    protected $primaryKey = 'cliente_id';

    protected $fillable = [                   
        'razon_social',
        'cuil_cuit',
        'apellido',
        'nombre',
        'telefono',
        'email'
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
