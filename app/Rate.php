<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Rate extends Eloquent
{
    protected $fillable = [
        'title', 'rate'
    ];


}
