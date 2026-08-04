<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    public $timestamps = false;

    protected $table = 'seo_meta';

    protected $fillable = [
        'path',
        'meta_title',
        'meta_description',
        'og_image',
        'canonical',
        'robots',
    ];
}
