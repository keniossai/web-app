<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRel extends Model
{
    use HasFactory;

    protected $table = 'contact_rel';
    protected $primaryKey = 'id_contact_rel';

    protected $fillable = [
        'id_contact',
        'element_id',
        'type_rel',
        'type_element',
        'created_by',
        'updated_by',
        'deleted',
        'created_at',
        'updated_at'
    ];
}
