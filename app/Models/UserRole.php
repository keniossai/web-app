<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'user_role';
    protected $primaryKey = 'id_userrole';

    protected $fillable = [
        'id_user',
        'id_role',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }
}
