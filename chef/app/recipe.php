<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
use app\category;
use app\steps;
use app\Challenge; 

class recipe extends Model
{
                public function steps()
    {
        return $this->hasMany('App\steps');
    }

           public function challenges()
    {
        return $this->hasMany('App\Challenge');
    }

        public function category()
    {
        return $this->belongsTo('App\category');
    }
}
