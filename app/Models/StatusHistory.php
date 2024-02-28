<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $table = 'status_history';
    protected $primaryKey = 'id_status_history';

    protected $fillable = [
        'id_status',
        'element_id',
        'description',
        'active',
        'created_at',
        'updated_at',
        'created_by'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status', 'id_status');
    }
}
