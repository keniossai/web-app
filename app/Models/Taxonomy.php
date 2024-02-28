<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;

    protected $table = 'taxonomy';
    protected $primaryKey = 'id_taxonomy';

    protected $fillable = [
        'id_directory',
        'id_guide',
        'id_location',
        'id_practice',
        'created_by',
        'last_updated_at',
        'last_updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];

    public function directory()
    {
        return $this->belongsTo(Directory::class, 'id_directory', 'id_directory');
    }
}
