<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $table = 'action';
    protected $primaryKey = 'id_action';

    protected $fillable = [
        'module',
        'name',
        'description',
        'active',
        'created_at',
        'updated_at'
    ];

}
