<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use App\category;
class category extends Model
{
            public function recipies()
    {
        return $this->hasMany('App\recipe');
    }
}
