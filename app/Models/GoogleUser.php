<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class GoogleUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'recovery_email',
        'is_recovery_enable',
        'is_logo_enable',
        'email',
        'password',
        'plain_password',
        'profile_id',
        'page_url',
        'barcode_url'
    ];


    public function getCreatedAtAttribute($value)
    {
        return $value != '' ? date('Y-m-d', strtotime($value)) : '';
    }
}
