<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    protected $table = 'peoples';
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'is_recovery_enable',
        'is_logo_enable',
        'recovery_email',
        'email',
        'profile_id',
        'password',
        'username',
        'date_of_birth',
        'plain_password',
        'page_url',
        'barcode_url',
        'q1',
        'a1',
        'q2',
        'a2',
        'q3',
        'a3'
    ];


    public function getCreatedAtAttribute($value)
    {
        return $value != '' ? date('Y-m-d', strtotime($value)) : '';
    }

    // public function setDateOfBirthAttribute($value)
    // {
    //     return $value != '' ? Carbon::parse($value) : '';
    // }
}
