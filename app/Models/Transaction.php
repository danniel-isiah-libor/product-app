<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'carts',
        'phone_number',
        'billing_address',
        'card_number',
        'card_expiry',
        'card_name',
        'message',
    ];

    protected $casts = [
        'carts' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
