<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuarioModel extends Model
{

    protected $table = 'usuarios';
    protected $primaryKey = 'idusuario';
    protected $fillable = ['nombre_usuario', 'contrasenia'];

    public $timestamps = false;

    public function sesiones(){
        return $this->hasMany(sesionesModel::class, 'usuario', 'idusuario');
    }

    public function createUsuario($data)
    {

        if (!isset($data['nombre_usuario']) || !isset($data['contrasenia'])) {
            throw new \Exception('Los campos nombre_usuario y contrasenia son obligatorios.');
        }

        return self::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'contrasenia' => bcrypt($data['contrasenia']),
        ]);
    }

    public function updateUsuario($id, $data)
    {

        $usuario = self::find($id);

        if (!$usuario) {
            throw new \Exception('Usuario no encontrado.');
        }

        if (isset($data['nombre_usuario'])) {
            $usuario->nombre_usuario = $data['nombre_usuario'];
        }

        if (isset($data['contrasenia'])) {
            $usuario->contrasenia = bcrypt($data['contrasenia']);
        }

        $usuario->save();

        return $usuario;
    }

    public function deleteUsuario($id)
    {

        $usuario = self::find($id);

        if (!$usuario) {
            throw new \Exception('Usuario no encontrado.');
        }

        $usuario->delete();

        return true;
    }

    public function validateUsuario($credentials)
    {
        if (!isset($credentials['nombre_usuario']) || !isset($credentials['contrasenia'])) {
            throw new \Exception('Los campos nombre_usuario y contraseña son obligatorios.');
        }

        $usuario = self::where('nombre_usuario', $credentials['nombre_usuario'])->first();

        if (!$usuario) {
            return false;
        }


        if (!password_verify($credentials['contrasenia'], $usuario->contrasenia)) {
            return false;
        }

        return $usuario;
    }

}
