<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $primaryKey = 'id_project';

    protected $fillable = [
        'id_client',
        'id_status',
        'id_product',
        'name',
        'description',
        'year',
        'owner',
        'agreed_deadline',
        'deleted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id_product', 'id_product');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner', 'id_user');
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'id_project', 'id_project');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }

}
