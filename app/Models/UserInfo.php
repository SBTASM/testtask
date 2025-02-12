<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * @property int $id
 *
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 *
 * @property int $age
 *
 * @property string $country
 * @property string $city
 * @property Date $date
 */
class UserInfo extends Model
{
    /** @use HasFactory<\Database\Factories\UserInfoFactory> */
    use HasFactory;

    protected $table = 'user_info';

    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'age',
        'country',
        'city',
        'date'
    ];

    public $timestamps = false;
}
