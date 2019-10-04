<?php

//Route::get('/', function () {return view('welcome');});

Route::get('/', 'ConstructorController@index');


Route::group(['prefix' => 'constructor'], function (){

    Route::get('/course/id{id}', 'ConstructorController@constructor')->name('constructor');

    Route::post('/create-course', 'ConstructorController@createCourse');
    Route::post('/update-course', 'ConstructorController@updateCourse');
    Route::post('/delete-course', 'ConstructorController@deleteCourse');

    Route::post('/create-lesson', 'ConstructorController@createLesson');
    Route::post('/update-lesson', 'ConstructorController@updateLesson');
    Route::post('/delete-lesson', 'ConstructorController@deleteLesson');

    Route::post('/create-lesson-item', 'ConstructorController@createLessonItem');
    Route::post('/update-lesson-item', 'ConstructorController@updateLessonItem');
    Route::post('/delete-lesson-item', 'ConstructorController@deleteLessonItem');
    Route::post('/get-lesson-item', 'ConstructorController@getLessonItem');
});
