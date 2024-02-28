<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'location';
    protected $primaryKey = 'id_location';

    protected $fillable = [
        'name',
        'description',
        'lat',
        'long',
        'created_by',
        'last_updated_at',
        'last_updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];
}
