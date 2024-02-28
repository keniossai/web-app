<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'name',
        'picture',
        'general_info',
        'phone',
        'website',
        'owner',
        'director',
        'deleted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner', 'id_user');
    }

    public function getPicture()
    {
        $picture = URL::asset('/assets/media/logos/ka.png');
        if(isset($this->picture))
        {
            $picture = URL::asset('/files/clients/'.$this->picture);
        }

        return $picture;
    }

    public function directorUser()
    {
        return $this->belongsTo(User::class, 'director', 'id_user');
    }
}
