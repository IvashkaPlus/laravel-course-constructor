<?php namespace App\Http\Controllers;

use App\Course;
use App\CourseLesson;
use App\LessonItems;
use App\StudentBook;
use App\User;


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

    // CRUD Courses

    public function createCourse(){
        $new_course_data = request()->all();

        $course = new Course();
        $course->title = $new_course_data['name'];
        $course->description = $new_course_data['low_desc'];
        $course->full_description = $new_course_data['full_desc'];
        $course->author = 0;

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

    // CRUD Lessons

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

    // CRUD Lesson items

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
                $lessonItem->goal_condition = null;
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

    // Quiz Constructor

    public function quizConstructor($quiz_id){
        $quiz = LessonItems::where('_id', $quiz_id)->first();
        return view('quiz-constructor', ['quiz'=>$quiz]);
    }

    // CRUD Questions

    public function createQuestion(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $tempQuest = array(
           "title" => $request['questTitle'],
           "answers" => []
        );
        $temp_questions = $current_quiz->questions;
        if(empty($temp_questions)){
            $temp_questions[0] = (object) $tempQuest;
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
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_id = $request['questionId'];
        $current_questions = $current_quiz['questions'];
        $current_questions[$quest_id]['title'] = $request['questTitle'];
        $current_quiz->questions = $current_questions;
        $current_quiz->save();
    }
    public function deleteQuestion(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_id = $request['questionId'];
        $current_questions = $current_quiz['questions'];
        unset($current_questions[$quest_id]);
        $current_quiz->questions = array_values($current_questions);
        $current_quiz->save();
    }
    public function getQuestion(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_title = $current_quiz->questions[$request['questionId']];
        return $quest_title["title"];
    }

    public function getQuestionCount(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        return count($current_quiz->questions);
    }

    // CRUD Answers

    public function createAnswer(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_id = $request['questionId'];
        $current_questions = $current_quiz['questions'];
        $tempAnswer = array("title" => $request['answerTitle']);
        if ($request['correctness'] == 'true'){
            $tempAnswer["correctness"] = True;
        } else {
            $tempAnswer["correctness"] = False;
        }
        if(empty($current_questions[$quest_id]['answers'])){
            $current_questions[$quest_id]['answers'][0] = (object)$tempAnswer;
        } else {
            $answers_count = count($current_questions[$quest_id]['answers']);
            $current_questions[$quest_id]['answers'][$answers_count] = (object)$tempAnswer;
        }
        $current_quiz->questions = $current_questions;
        $current_quiz->save();
        return $current_questions;
    }
    public function updateAnswer(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_id = $request['questionId'];
        $current_questions = $current_quiz['questions'];
        $tempAnswer = array("title" => $request['answerTitle']);
        if ($request['correctness'] == 'true'){
            $tempAnswer["correctness"] = True;
        } else {
            $tempAnswer["correctness"] = False;
        }
        $answer_id = $request['answerId'];
        $current_questions[$quest_id]['answers'][$answer_id] = (object)$tempAnswer;
        $current_quiz->questions = $current_questions;
        $current_quiz->save();
    }
    public function deleteAnswer(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_id = $request['questionId'];
        $answer_id = $request['answerId'];
        $current_questions = $current_quiz['questions'];
        unset($current_questions[$quest_id]['answers'][$answer_id]);
        $current_questions[$quest_id]['answers'] = array_values($current_questions[$quest_id]['answers']);
        $current_quiz->questions = $current_questions;
        $current_quiz->save();
    }
    public function getAnswer(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $quest_id = $request['questionId'];
        $answer_id = $request['answerId'];
        $target_answer =  $current_quiz->questions[$quest_id]['answers'][$answer_id];
        return $target_answer;
    }

    public function editGoalCondition(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $goal_condition = array(
            'gc5' => (int) $request['cond5'],
            'gc4' => (int) $request['cond4'],
            'gc3' => (int) $request['cond3'],
        );
        $current_quiz->goal_condition = (object) $goal_condition;
        $current_quiz->save();
    }

    public function deleteGoalCondition(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        $current_quiz->goal_condition = null;
        $current_quiz->save();
    }

    public function getGoalCondition(){
        $request = request()->all();
        $current_quiz = LessonItems::where('_id', $request['quizId'])->first();
        return $current_quiz->goal_condition;
    }

    //Student List and Student Book

    public function setCourseTo(){
        $request = request()->all();
        $student_array = $request['studentsArray'];
        $added_students = [];
        foreach($student_array as $student){
            $student_book = new StudentBook();
            $student_book->student_id = (int) $student;
            $student_book->course_id = (int) $request['courseId'];
            $student_book->status = 0;
            $student_book->final_grade = 0;
            $student_book->save();
            $current_student = User::where('id', $student)->first();
            array_push($added_students, $current_student);
        }
        return $added_students;
    }

    public function getCandidatesForCourse(){
        $request = request()->all();
        $users = User::where('second', 'like', $request['ln_query']."%")->take(5)->get();
        return $users;
    }

    public function getStudentList($course_id){
        $course = Course::where('id', $course_id)->first();
        $student_list = StudentBook::where('course_id', (int) $course_id)->get();
//        dd($student_list);
        return view('course-student-list', ['course'=>$course, 'students'=>$student_list]);
    }

}

