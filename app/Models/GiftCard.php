<?php

namespace App\Models\GiftCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'value',
        'expiration_date',
        'is_active',
    ];

    /**
     * Exemplo de relacionamento
     * (adicione outros relacionamentos se precisar)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}