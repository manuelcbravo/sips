<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria
use App\Http\Traits\Uuids;


class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellidos',
        'activado',
        'email',
        'password',
        'password_plain',
        'rol',
        'api_token',
        'imagen_perfil',
        'telefono',
        'telefono_oficina',
        'celular',
        'celular2',
        'titulo',
        'titulo_presenta',
        'direccion_principal',
        'id_sucursal'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(cat_role::class)->withTimestamps();
    }

    public function authorizeRoles($roles)
    {
        abort_unless($this->hasAnyRole($roles), 401);
        return true;
    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasAnyRoleId($roles)
    {
        if (is_array($roles)) {
            
            if(auth()->user()->rol == 0){
                return true;
            }

            foreach ($roles as $role) {
                if ($this->hasRoleId($role)) {
                    return true;
                }
            }

        } else {

            if ($this->hasRole($roles)) {
                return true;
            }

        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('nombre', $role)->first()) {
            return true;
        }
        return false;
    }

    public function hasRoleId($role)
    {
        if ($role == 0) {
            return true;
        }

        if ($this->roles()->where('cat_role_id', $role)->first()) {
            return true;
        }

        return false;
    }
}
