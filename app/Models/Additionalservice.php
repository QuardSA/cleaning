<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Additionalservice extends Model
{
    protected $fillable = ['titleadditionalservices', 'work_time', 'cost'];

    public function additionalServices_order()
    {
        return $this->hasMany(Order::class, 'order');
    }
}
