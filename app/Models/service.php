<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $fillable = [
        'titleservice',
        'description',
        'photo',
        'cost',
    ];

    public function service()
    {
        return $this->hasMany(Order::class, 'service', 'id');
    }

    public function additionalServices()
    {
        return $this->belongsToMany(Additionalservice::class, 'service_additional_service');
    }

}
