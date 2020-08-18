<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Travel extends Eloquent
{
    protected $fillable = [
        'title',
        'started_at',
        'ended_at',
        'description',
        'destinations',
        'user_id'
    ];
}
