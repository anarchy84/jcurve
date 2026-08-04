<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsightCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function insights(): HasMany
    {
        return $this->hasMany(Insight::class, 'category_id');
    }
}
