<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class localidadModel extends Model
{
    use HasFactory;

    protected $table = 'localidades';
    public $timestamps = false;
    protected $primaryKey = 'localidad_id';

    protected $fillable = [                   
        'localidad'
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function localidad()
    {
      return $this->belongsTo(campanias_localidadesModel::class);
    }
}
