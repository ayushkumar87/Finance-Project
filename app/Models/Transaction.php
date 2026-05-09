<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'title', 'amount', 'type', 'transaction_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
