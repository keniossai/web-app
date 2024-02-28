<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeadlineHeader extends Model
{
    use HasFactory;

    protected $table = 'deadline_header';
    protected $primaryKey = 'id_deadline_header';

    protected $fillable = [
        'id_directory',
        'year',
        'description',
        'created_by',
        'updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];

    public function directory()
    {
        return $this->belongsTo(Directory::class, 'id_directory', 'id_directory');
    }
}
