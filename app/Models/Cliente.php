<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombres',
        'documento',
        'celular',
        'email'
    ];

    public function billetera()
    {
        return $this->hasOne(Billetera::class, 'cliente_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'cliente_id');
    }
}
