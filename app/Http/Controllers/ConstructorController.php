<?php namespace App\Http\Controllers;

use App\CourseLesson;
use App\LessonItems;
use App\Course;



class ConstructorController extends Controller
{
    public function index(){
        $courses = Course::select('id', 'title', 'description')->get();
        return view('index', ['courses' => $courses]);
    }

    // Constructor loading

    public function constructor($course_id){
        $course = Course::with('lessons')->where('id', $course_id)->first();
        $items_array = array();
        foreach($course->lessons as $lesson){
            $lesson_items = LessonItems::where('lesson_id', $lesson->id)->orderBy('priority')->get();
            $items_array[$lesson->id] = $lesson_items;
        }
        return view('constructor', ['course'=>$course, 'lesson_items'=>$items_array]);
    }

    //CRUD Courses

    public function createCourse(){
        $new_course_data = request()->all();

        $course = new Course();
        $course->title = $new_course_data['name'];
        $course->description = $new_course_data['low_desc'];
        $course->full_description = $new_course_data['full_desc'];
        $course->status = 0;
        $course->author_id = 0;

//        $image = request()->file('picture');
//        if($image){
//            $new_course = $course->save();
//            Storage::putFileAs('public/course_avatars', $image, $new_course->id + '.jpg');
//        }
//        else {
//            $course->save();
//        }

        $course->save();
        return redirect('/');
    }
    public function updateCourse(){
        $request = request()->all();
        $course = Course::where('id', $request['courseId'])->first();
        $course->title = $request['courseTitle'];
        $course->description = $request['courseLowDesc'];
        $course->full_description = $request['courseFullDesc'];
        $course->save();
    }
    public function deleteCourse(){
        $request = request()->all();
        $lessons = CourseLesson::where('course_id', $request['courseId'])->get();
        foreach ($lessons as $lesson){
            $lessonItems = LessonItems::where('lesson_id', $lesson->id);
            $lessonItems->delete();
        }
        CourseLesson::where('course_id', $request['courseId'])->delete();
        Course::where('id', $request['courseId'])->delete();
        return redirect('/');
    }
    public function getCourse(){
        $request = request()->all();
        $course = Course::where('id', $request["courseId"])->first();
        return $course;
    }

    //CRUD Lessons

    public function createLesson(){
        $request = request()->all();
        $lesson = new CourseLesson();
        $lesson->title = $request['lessonTitle'];
        $lesson->course_id = $request['courseId'];
        $lessonCount = CourseLesson::where('course_id', $request['courseId'])->count();
        $lesson->priority = $lessonCount + 1;
        $lesson->save();
    }
    public function updateLesson(){
        $request = request()->all();
        $lesson = CourseLesson::where('id', $request['lessonId'])->get();
        $lesson->title = $request->lessonTitle;
        $lesson->save();
    }
    public function deleteLesson(){
        $request = request()->all();
        $lesson = CourseLesson::where('id', $request['lessonId']);
        $lessonItems = LessonItems::where('lesson_id', (int)$request['lessonId']);
        $lesson->delete();
        $lessonItems->delete();
        $lessons = CourseLesson::where('course_id', $request['courseId'])->orderBy('priority')->get();
        $this->priorityRefactor($lessons);
    }

    //CRUD Lesson items

    public function createLessonItem(){
        $request = request()->all();
        $lessonItem = new LessonItems();
        $lessonItemCount = LessonItems::where('lesson_id', (int)$request['lessonId'])->count();
        $lessonItem->type = $request['lessonItemType'];
        $lessonItem->title = $request['lessonItemTitle'];
        $lessonItem->priority = $lessonItemCount + 1;
        $lessonItem->html = $request['html'];
        $lessonItem->lesson_id = (int)$request['lessonId'];
        switch ($request['lessonItemType']){
            case "Видео":
                $lessonItem->url = $request['url'];
                break;
            case "Тестирование":
                $lessonItem->questions = [];
                $lessonItem->course_id = (int)$request['courseId'];
                $lessonItem->save();
                return $lessonItem->_id;
        }
        $lessonItem->save();
    }
    public function updateLessonItem(){
        $request = request()->all();
        $lessonItem = LessonItems::where('_id', $request['lessonItemId'])->first();
        $lessonItem->title = $request['lessonItemTitle'];
        $lessonItem->html = $request['html'];
        switch ($request['lessonItemType']) {
            case "Видео":
                $lessonItem->url = $request['url'];
                break;
        }
        $lessonItem->save();
    }
    public function deleteLessonItem(){
        $request = request()->all();
        LessonItems::destroy($request['lessonItemId']);
        $lessonItems = LessonItems::where('lesson_id', (int)$request['lessonId'])->orderBy('priority')->get();
        $this->priorityRefactor($lessonItems);
    }
    public function getLessonItem(){
        $request = request()->all();
        $lessonItem =  LessonItems::where('_id', $request['lessonItemId'])->first();
        return $lessonItem;
    }


    // Priority refactor after editing Lesson or LessonItem lists

    private function priorityRefactor($details){
        for($i = 0; $i < $details->count(); $i++){
            $details[$i]->priority = $i + 1;
            $details[$i]->save();
        }
    }

    //Quiz Constructor

    public function quizConstructor($quiz_id){
        $quiz = LessonItems::where('_id', $quiz_id)->first();
        return view('quiz-constructor', ['quiz'=>$quiz]);
    }
    public function saveQuiz(){

    }

    //CRUD Questions

    public function createQuestion(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $tempQuest = array(
           "title" => $request['lessonTitle'],
           "answers" => []
        );
        $temp_questions = $current_quiz->questions;
        if(empty($temp_questions)){
            $temp_questions[0] = (object) $tempQuest;
            $current_quiz->questions = $temp_questions;
        }
        else {
            $question_count = count($temp_questions);
            $temp_questions[$question_count] = (object)$tempQuest;
        }
        $current_quiz->questions = $temp_questions;
        $current_quiz->save();
        return count($current_quiz->questions);
    }
    public function updateQuestion(){

    }
    public function deleteQuestion(){

    }
    public function getQuestion(){

    }

    //CRUD Answers
    public function createAnswer(){

    }
    public function updateAnswer(){

    }
    public function deleteAnswer(){

    }
    public function getAnswer(){

    }
}

