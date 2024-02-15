<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class State extends Model
{
    use LogsActivity;
    use HasFactory;


    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
             ->useLogName('State')
            ->logExcept(['created_at', 'updated_at','deleted_at']);
    }

}
