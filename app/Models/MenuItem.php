<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_item';
    protected $primaryKey = 'id_menuitem';

    protected $fillable = [
        'name',
        'icon',
        'father_id_menuitem',
        'id_action',
        'order',
        'active',
        'created_at',
        'updated_at'
    ];

    public function father_item()
    {
        return $this->belongsTo(MenuItem::class, 'father_id_menuitem');
    }

    public function action()
    {
        return $this->hasOne(Action::class, 'id_action','id_action');
    }

}
