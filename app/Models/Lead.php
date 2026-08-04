<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'service_interest',
        'message',
        'utm',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'utm' => 'array',
        ];
    }
}
