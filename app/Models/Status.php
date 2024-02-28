<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $primaryKey = 'id_status';

    protected $fillable = [
        'element_type',
        'status_type',
        'name',
        'description',
        'html_color',
        'order',
        'is_default',
        'deleted',
        'created_at',
        'updated_at'
    ];
}
