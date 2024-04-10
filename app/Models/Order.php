<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user',
        'service',
        'status',
        'cost',
        'square',
        'phone',
        'address',
        'date'
    ];

    public function order_orderstatus(){
        return $this->belongsTo(Orderstatus::class, 'status', 'id');
    }

    public function order_user(){
        return $this->belongsTo(User::class, 'user','id');
    }

    public function order_service(){
        return $this->belongsTo(Service::class, 'service', 'id');
    }

}
