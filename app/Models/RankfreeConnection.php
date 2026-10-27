<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankfreeConnection extends Model
{
    protected $guarded = ['*'];

    protected $hidden = ['credential_ciphertext'];
}
