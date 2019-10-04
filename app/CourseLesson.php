<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class CourseLesson extends Model
{
    use HybridRelations;

    protected $table = 'course_lessons';

    public $timestamps = false;
}
