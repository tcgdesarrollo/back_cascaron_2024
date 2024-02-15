<?php

namespace App\Http\Controllers;

use App\Models\Queue;

class QueueController extends Controller
{

    public function store(string $type, $to, array $extra = [], bool $is_urgent = false, $language = 'es'): void
    {
        Queue::create([
            'type' => $type,
            'to' => $to,
            'is_urgent' => $is_urgent,
            'extra' => $extra,
            'language' => $language
        ]);
    }


}
