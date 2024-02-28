<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'name',
        'order',
        'description',
        'created_by',
        'last_updated_by',
        'last_updated_at',
        'created_at',
        'updated_at'
    ];



}
