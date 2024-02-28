<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';
    protected $primaryKey = 'id_task';

    protected $fillable = [
        'id_project',
        'id_product',
        'id_directory',
        'id_guide',
        'id_location',
        'id_practice',
        'id_senior_consultant',
        'id_consultant',
        'id_lds',
        'id_coordinator',
        'name',
        'year',
        'agreed_deadline',
        'deadline',
        'confirmed',
        'deleted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function statushistory()
    {
        return $this->hasMany(StatusHistory::class, 'element_id', 'id_task')->where('active', 1);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function directory()
    {
        return $this->belongsTo(Directory::class, 'id_directory', 'id_directory');
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'id_guide', 'id_guide');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id_location');
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'id_practice', 'id_practice');
    }

    public function sc()
    {
        return $this->belongsTo(User::class, 'id_senior_consultant', 'id_user');
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'id_consultant', 'id_user');
    }

    public function lds()
    {
        return $this->belongsTo(User::class, 'id_lds', 'id_user');
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'id_coordinator', 'id_user');
    }
}
