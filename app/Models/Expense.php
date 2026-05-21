<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Expense extends Model
{
    //
    protected $fillable = [
        'title',
        'amount',
        'category',
        'date',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
