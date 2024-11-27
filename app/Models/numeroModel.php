<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class numeroModel extends Model
{
    use HasFactory;

    protected $table = 'numeros';
    public $timestamps = false;
    protected $primaryKey = 'numero_id';

    protected $fillable = [                   
        'numero',
        'localidad_id'
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
