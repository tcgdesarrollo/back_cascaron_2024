<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    use LogsActivity;
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at','pivot'];
    protected $casts = [
        'is_eu' => 'boolean'
    ];
    protected $cascadeDeletes = ['location', 'subdivision'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->useLogName('Country')
            ->logExcept(['created_at', 'updated_at']);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function subdivisions(): HasMany
    {
        return $this->hasMany(Subdivision::class);
    }
}
