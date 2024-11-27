<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class campaniaModel extends Model
{
    use HasFactory;

    protected $table = 'campanias';
    public $timestamps = false;
    protected $primaryKey = 'campania_id';

    protected $fillable = [                   
        'cliente_id',
        'texto_SMS',
        'localidad_id',
        'cantidad_mensajes',
        'nombre_campania',
        'estado',
        'fecha_inicio',                
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }

     public function campania_localidad() : HasMany
    {
       return $this->hasMany(campanias_localidadesModel::class,'id_campania');
    }

    public function campanias() 
    {      
       return $this->belongsToMany(campaniaModel::class);
    }
}
