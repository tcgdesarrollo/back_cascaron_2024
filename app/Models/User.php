<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;


class User extends Model
{
    use LogsActivity;
    use HasFactory;
    use SoftDeletes;

    use HasApiTokens, Notifiable, HasRoles, HasPermissions;

    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'password'];
    protected $appends = ['rolesNames'];

    protected $with = ['roles'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->useLogName('User')
            ->logExcept(['created_at', 'updated_at', 'deleted_at']);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');

    }

    public function getrolesNamesAttribute()
    {
        $names = $this->roles()->pluck('name')->toArray();

        return array_map(fn($value): string => Str::lower($value), $names);

    }

}
