<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    protected $guarded = ['id'];


    public function accounting_plan(): HasMany
    {
        return $this->hasMany(AccountingPlan::class);
    }
}
