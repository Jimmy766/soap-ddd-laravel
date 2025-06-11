<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billetera extends Model
{
    protected $table = 'billeteras';

    protected $fillable = [
        'cliente_id',
        'saldo'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
