<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LessonItems extends Eloquent {

    protected $collection = 'lesson_items';

    protected $connection = 'mongodb';
}