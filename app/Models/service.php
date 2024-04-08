<?php

namespace App\Models;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $fillable=[
        'titleservice',
        'description',
        'photo',
        'cost',
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }
}
