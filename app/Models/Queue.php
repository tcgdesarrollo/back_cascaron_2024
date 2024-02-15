<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class Queue extends Model
{
    use LogsActivity;
    use HasFactory;
    use SoftDeletes;


    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'to' => 'array',
        'extra' => 'object'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->useLogName('Queue')
            ->logExcept(['created_at', 'updated_at', 'deleted_at']);
    }


}
