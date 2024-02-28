<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'group';
    protected $primaryKey = 'id_group';

    protected $fillable = [
        'name',
        'role',
        'description',
        'created_by',
        'deleted',
        'created_at',
        'updated_at'
    ];

    public function groupdetail()
    {
        return $this->hasMany(GroupDetail::class,'id_group')->where('deleted', 0);
    }
}
