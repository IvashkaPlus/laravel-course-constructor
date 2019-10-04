<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HybridRelations;

    public function lessons(){
        return $this->hasMany('App\CourseLesson');
    }

}
