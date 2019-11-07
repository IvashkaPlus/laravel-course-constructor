<?php

//Route::get('/', function () {return view('welcome');});

Route::get('/', 'ConstructorController@index')->name('home');


Route::group(['prefix' => 'constructor'], function (){

    Route::get('/course/id{id}', 'ConstructorController@constructor')->name('constructor');

    Route::post('/create-course', 'ConstructorController@createCourse');
    Route::post('/update-course', 'ConstructorController@updateCourse');
    Route::post('/delete-course', 'ConstructorController@deleteCourse');
    Route::post('/get-course', 'ConstructorController@getCourse');

    Route::post('/create-lesson', 'ConstructorController@createLesson');
    Route::post('/update-lesson', 'ConstructorController@updateLesson');
    Route::post('/delete-lesson', 'ConstructorController@deleteLesson');

    Route::post('/create-lesson-item', 'ConstructorController@createLessonItem');
    Route::post('/update-lesson-item', 'ConstructorController@updateLessonItem');
    Route::post('/delete-lesson-item', 'ConstructorController@deleteLessonItem');
    Route::post('/get-lesson-item', 'ConstructorController@getLessonItem');

    Route::get('/quiz/id_{id}', 'ConstructorController@quizConstructor');

    Route::post('/create-question', 'ConstructorController@createQuestion');
    Route::post('/update-question', 'ConstructorController@updateQuestion');
    Route::post('/delete-question', 'ConstructorController@deleteQuestion');
    Route::post('/get-question',    'ConstructorController@getQuestion');

    Route::post('/create-answer', 'ConstructorController@createAnswer');
    Route::post('/update-answer', 'ConstructorController@updateAnswer');
    Route::post('/delete-answer', 'ConstructorController@deleteAnswer');
    Route::post('/get-answer',    'ConstructorController@getAnswer');
});
