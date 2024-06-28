<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use App\Enums\UserType;
use App\Enums\Brand;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'asana_id',
        'number',
        'disaster_support',
        'brands',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'brands' => 'array',
            'user_type' => UserType::class,
        ];
    }

     /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'asana_id' => '',
        'number' => '',
        'disaster_support' => false,
        'brands' => [Brand::SHG],
        'user_type' => UserType::ADMIN
    ];
}
