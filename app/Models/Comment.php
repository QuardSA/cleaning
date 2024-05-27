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
    public static function averageRating($decimals = 2)
    {
        $average = self::avg('rating');
        return round($average, $decimals);
    }
}
