<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $table = 'guide';
    protected $primaryKey = 'id_guide';

    protected $fillable = [
        'id_directory',
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
