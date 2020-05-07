<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\recipe;
class steps extends Model
{
                public function recipe()
    {
        return $this->belongsTo('App\recipe');
    }
}
