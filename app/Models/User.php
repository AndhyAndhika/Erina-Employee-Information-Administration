<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_number',
        'name',
        'role',
        'email',
        'password',
        'created_by',
        'updated_by',
        'is_active',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* Generate Employee Number */
    public static function generateEmployeeNumber()
    {
        $latestEmployee = self::orderBy('employee_number', 'desc')->first();

        if (!$latestEmployee) {
            return '00001';
        }

        $latestNumber = intval($latestEmployee->employee_number);
        $newNumber = $latestNumber + 1;

        return str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }


    /* relational to userdetails */
    public function userDetails()
    {
        return $this->hasOne(UserDetails::class, 'employee_number', 'employee_number');
    }

    /* get badge status */
    public function getBadgeStatus()
    {
        if ($this->is_active == 1) {
            return '<span class="badge text-center text-bg-success p-2 fs-6">Active</span>';
        } else {
            return '<span class="badge text-center text-bg-danger p-2 fs-6">Disabled</span>';
        }
    }
}
