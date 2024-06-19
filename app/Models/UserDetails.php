<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = []; /* Agar semua data bisa diisi */

    /* create relations to user*/
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_number', 'employee_number');
    }
}
