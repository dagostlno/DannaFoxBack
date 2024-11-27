<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class campanias_localidadesModel extends Model
{
    //
    use HasFactory;
    protected $table = 'campanias_localidades';

    protected $fillable = [                   
        'id_campania',
        'id_localidad'
    ];

    protected $hidden = [
      'created_at', 'updated_at'
  ];

    public function campania()
    {
      return $this->belongsTo(campaniaModel::class);
    }

    public function localidades() 
    {      
       return $this->belongsToMany(localidadModel::class);
    }
}
