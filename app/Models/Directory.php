<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;

    protected $table = 'directory';
    protected $primaryKey = 'id_directory';

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
