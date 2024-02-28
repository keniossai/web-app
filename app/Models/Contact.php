<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';
    protected $primaryKey = 'id_contact';

    protected $fillable = [
        'id_user',
        'profile_pic',
        'name',
        'last_name',
        'type',
        'email',
        'phone',
        'description',
        'no_contact',
        'job_title',
        'deleted',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function getProfilePic()
    {
        $picture = URL::asset('/assets/media/logos/ka.png');
        if(isset($this->profile_pic))
        {
            $picture = URL::asset('/files/user/'.$this->profile_pic);
        }

        return $picture;
    }

    public function getName()
    {
        return $this->last_name ? ($this->name.' '.$this->last_name) : $this->name;
    }
}
