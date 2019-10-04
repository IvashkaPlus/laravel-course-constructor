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

    //CUD Courses

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
        $course = Course::where('id', $request['courseId']);
        $this->constructor($request['courseId']);
    }
    public function deleteCourse(){
        $request = request()->all();
        $lessons = CourseLesson::where('course_id', $request->courseId);
        foreach ($lessons as $lesson){
            $lessonItems = LessonItems::where('lesson_id', $lesson->id);
            $lessonItems->delete();
        }
        $lessons->delete();
        Course::delete()->where('id', $request['courseId']);
        return redirect('/');
    }

    //CUD Lessons

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
                $lessonItem->questions = $request['questions'];
                break;
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

}

