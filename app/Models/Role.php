<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    protected $fillable=['titlerole'];

    public function role_user(){
        return $this->hasMany(User::class, 'role', 'id');
    }
}
