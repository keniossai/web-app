<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDetail extends Model
{
    use HasFactory;

    protected $table = 'group_detail';
    protected $primaryKey = 'id_groupdetail';

    protected $fillable = [
        'id_group',
        'id_user',
        'is_admin',
        'deleted',
        'created_at',
        'updated_at'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
