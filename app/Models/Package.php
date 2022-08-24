<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracking_code',
        'shipping_price',
        'price',
        'category',
        'first_name',
        'last_name',
        'phone_number',
        'email',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
