<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'description',
        'user'
    ];
    public function comments_user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
