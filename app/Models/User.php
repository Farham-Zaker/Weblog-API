<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasUlids, HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "username",
        "email",
        "password",
        "reg_ip",
        "last_ip",
        "last_login"
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
