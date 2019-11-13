<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class StudentBook extends Eloquent
{
    protected $collection = 'student_book';
    protected $connection = 'mongodb';

    public function user()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
}
