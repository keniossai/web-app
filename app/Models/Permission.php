<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permission';
    protected $primaryKey = 'id_permission';

    protected $fillable = [
        'id_action',
        'id_role',
        'active',
        'created_at',
        'updated_at'
    ];

    public function action()
    {
        return $this->hasOne(Action::class, 'id_action', 'id_action');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }
}
