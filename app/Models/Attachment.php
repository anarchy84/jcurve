<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'path',
        'mime',
        'size',
    ];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
