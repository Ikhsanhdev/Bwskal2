<?php

namespace App\Models;

use AyatKyo\Klorovel\Core\Traits\ModelTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ModelTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'fullname',
        'email',
        'password',
        'role',
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
    
    //  Role List
    const ROLE_SUPERMIN = "supermin";
    const ROLE_ADMIN = "admin";

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function getRoleList()
    {
        return [
            //  Internal
            self::ROLE_SUPERMIN => 'Super Admin',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Non-Aktif',
        ];
    }

    public function getRoleKataAttribute()
    {
        try {
            return $this->getRoleList()[$this->role];
        } catch (\Throwable $th) {}

        //  Fallback ke tanggal hari ini
        return now()->isoFormat('dddd, DD MMMM YYYY');
    }
    
    public function getAvatarImageAttribute()
    {
        return get_avatar_by_file($this->avatar);
    }
}
