<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'balance','name', 'email', 'password', 'role', 'phone', 'actions', 'client_id', 'employee_id'
    ];
    
}
