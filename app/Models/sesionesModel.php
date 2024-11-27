<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sesionesModel extends Model
{
    //
    protected $table = 'sesiones';
    protected $primaryKey = 'idsesion';
    protected $fillable = ['usuario', 'token', 'inicio', 'expires_in'];

    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(usuarioModel::class, 'usuario', 'idusuario');
    }

    public function createToken($user)
    {
        $secret_key = env('APP_KEY');

        $header = json_encode([
            "alg" => "HS256",
            "typ" => "JWT"
        ]);

        $header = $this->base64urlEncode($header);

        $payload = [
            "id" => $user['id'],
            "name" => $user["name"],
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $payload = $this->base64urlEncode($payload);

        $signature = hash_hmac("sha256", $header . "." . $payload, $secret_key, true);
        $signature = $this->base64urlEncode($signature);

        $token = $header . "." . $payload . "." . $signature;

        self::create([
            "usuario" => $user['id'],
            "token" => $token,
            "expires_in" => 3600,
            "inicio" => date('Y-m-d H:i:s', time())
        ]);

        return $token;
    }

    public function authToken($token)
    {
        $this->removeOldTokens();

        $tokenData = self::where('token', $token)->first();

        if (!$tokenData) {
            return false;
        }

        return true;
    }

    public function removeOldTokens()
    {
        $tokens = self::all();

        $currentTime = time();

        foreach ($tokens as $tokenData) {

            $inicioTimestamp = strtotime($tokenData->inicio);

            if (($inicioTimestamp + 3600) <= $currentTime) {
                $tokenData->delete();
            }
        }
    }


    public function base64urlEncode($data)
    {
        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
        }
        $data = (string) $data;

        $base64 = base64_encode($data);
        $base64Url = rtrim(strtr($base64, '+/', '-_'), '=');

        return $base64Url;
    }

}
