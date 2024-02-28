<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;

    protected $table = 'allocation';
    protected $primaryKey = 'id_allocation';

    protected $fillable = [
        'id_entity_parent',
        'id_contact',
        'type',
        'relationship',
        'created_by',
        'updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];
}
