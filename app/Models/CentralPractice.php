<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentralPractice extends Model
{
    use HasFactory;

    protected $table = 'central_practice';
    protected $primaryKey = 'id_central_practice';

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'last_updated_at',
        'last_updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];
}
