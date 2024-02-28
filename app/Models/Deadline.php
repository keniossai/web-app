<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    use HasFactory;

    protected $table = 'deadline';
    protected $primaryKey = 'id_deadline';

    protected $fillable = [
        'id_deadline_header',
        'id_guide',
        'id_location',
        'id_practice',
        'directory_status',
        'deadline',
        'confirmed',
        'created_by',
        'updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];
}
