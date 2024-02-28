<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'name',
        'code',
        'description',
        'active',
        'created_at',
        'updated_at'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'id_role');
    }

    public function is_allowed($action)
    {
        foreach($this->permissions as $permission)
        {
            if($permission->action->name == $action) return true;
        }

        return false;
    }

    public function users()
    {
        return $this->hasMany(UserRole::class, 'id_role', 'id_role');
    }
}


