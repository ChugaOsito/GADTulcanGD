<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\AsignarContraseña;
use App\Models\Position;
class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getIsAdminAttribute()
    {
        return $this->rol ==0;

    }
    public function getIsSuperadminAttribute()
    {
        return $this->rol ==-1;

    }
    public function getIsDepartamentBossAttribute()
    {
        $position=Position::find(auth()->user()->position_id);
        return $position->representative ==1;

    }
    //relacion muchos a muchos
    public function documents()
    {
        return $this->belongsToMany('App\Models\Document');
    }
    
    public function sendPasswordResetNotification($token)
{
    

    $this->notify(new AsignarContraseña($token));
}
}
