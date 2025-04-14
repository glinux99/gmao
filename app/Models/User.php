<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'post_name',
        'nickname',
        'number',
        'pointure',
        'category',
        'level',
        'type',
        'size',
        'status',
        'address',
        'contrat',
        'avatar',
        'token_email',
        'function',
        'provider',
        'region_id'

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    public function connections()
    {
        return $this->hasMany(Connection::class);
    }
    public function getSessionTimeAttribute()
    {
        return now()->diffInSeconds($this->updated_at);
    }
    public function maintenances()
    {
        return $this->belongsToMany(Maintenance::class, 'maintenance_techniciens', 'user_id', 'maintenance_id');
    }
    public function teams(): BelongsToMany
{
    return $this->belongsToMany(Team::class);
}

}
