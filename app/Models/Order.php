<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'square', 'service', 'cost', 'work_time', 'phone', 'address', 'status', 'start_time', 'end_time', 'user', 'name', 'email'
    ];

    protected $dates = ['start_time', 'end_time'];

    public function additionalServices()
    {
        return $this->belongsToMany(AdditionalService::class, 'order_additional_service');
    }

    public function order_orderstatus()
    {
        return $this->belongsTo(Orderstatus::class, 'status', 'id');
    }

    public function order_user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function order_service()
    {
        return $this->belongsTo(Service::class, 'service', 'id');
    }
}
