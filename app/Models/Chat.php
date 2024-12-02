<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_owner_id', 'user_interested_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function userOwner()
    {
        return $this->belongsTo(User::class, 'user_owner_id');
    }

    public function userInterested()
    {
        return $this->belongsTo(User::class, 'user_interested_id');
    }
}

