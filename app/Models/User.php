<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'email',
        'password',
        'position',
        'provider_id',
        'impersonated_by',
        'timezone',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }

    public function userRole()
    {
        return $this->hasMany(UserRole::class, 'id_user', 'id_user');
    }

    public function MenuElements()
    {
        $ids_action = Permission::whereIn('id_role', $this->userRole->pluck('id_role'))->where('active', 1)->pluck('id_action');
        $menuItems = MenuItem::whereIn('id_action', $ids_action)->orderBy('order', 'ASC')->whereNull('father_id_menuitem')->get();
        $menuItemsModules = MenuItem::whereNull('father_id_menuitem')->whereNull('id_action')->orderBy('order', 'ASC')->get();

        $submenuItemsModules = MenuItem::whereIn('id_action', $ids_action)->whereIn('father_id_menuitem', $menuItemsModules->pluck('id_menuitem'))->orderBy('order', 'ASC')->get();

        $modules['modules'] = $menuItems ?? null;

        $modules['menuModules'] = $menuItemsModules ? $menuItemsModules->whereIn('id_menuitem', $submenuItemsModules->pluck('father_id_menuitem')) : null;
        $modules['submenuModules'] = $submenuItemsModules ?? null;

        $checkUser = false;
        foreach($this->userRole as $item){
            if($item->role->code == 'admin'){
                $checkUser = true;
            }
        }
        if ($checkUser) {
            $modules['menuModules'] = $menuItemsModules ?? null;
            $modules['submenuModules'] = $submenuItemsModules ?? null;
        }
        return $modules;
    }

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id_user', 'id_user');
    }

    public function groupdetail()
    {
        return $this->belongsTo(GroupDetail::class, 'id_user', 'id_user');
    }
}
