<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model
{
    use LogsActivity;
    use HasFactory;
    use SoftDeletes;


    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
             ->useLogName('User')
            ->logExcept(['created_at', 'updated_at','deleted_at']);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'user_roles');

    }

}
