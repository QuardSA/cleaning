<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderstatus extends Model
{
    protected $fillable = [
        'titlestatus'
    ];

    public function orderstatus_order(){
        return $this->HasMany(Order::class, 'status', 'id');
    }
}
