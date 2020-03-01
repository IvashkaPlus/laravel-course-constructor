<?php

namespace App\Http\Controllers;

use App\Course;
use App\LessonItems;
use App\StudentBook;

class CleverCourseController extends Controller
{
    public function checkStudent(){
        $request = request()->all();
        $course = Course::where('id', $request['courseId'])->first();
        $check_student = StudentBook::where('course_id', (int) $request["courseId"])
            ->where("student_id", (int) $request["studentId"])
            ->get();
        if($check_student != null){
            return 1;
        } else if ($course->is_close == 0) {
            $student_book = new StudentBook();
            $student_book->student_id = (int)  $request["student_id"];
            $student_book->course_id = (int) $request['courseId'];
            $student_book->status = 0;
            $student_book->final_grade = 0;
            $student_book->save();
            return 1;
        } else {
            return 0;
        }
    }

    public function learnCourse($course_id){
        $student_id = 1;
        $student_on_course = StudentBook::where('course_id', (int) $course_id)
            ->where("student_id", (int) $student_id)
            ->first();
        if($student_on_course == []){
            return redirect()->route("course-access-denied");
        } else {
            $course = Course::with('lessons')->where('id', $course_id)->first();
            $items_array = array();
            foreach($course->lessons as $lesson){
                $lesson_items = LessonItems::where('lesson_id', $lesson->id)->orderBy('priority')->get();
                $items_array[$lesson->id] = $lesson_items;
            }
            switch ($student_on_course->status){
                case 0:
                    $student_on_course->status = 1;
                    $student_on_course->last_material = $items_array[$course->lessons[0]->id][0]->_id;
                    $temp_path_array = $student_on_course->course_path;
                    foreach($course->lessons as $lesson){
                        foreach ($items_array[$lesson->id] as $item){
                            $temp_material_info = array
                            (
                                "lesson_id" => $lesson->id,
                                "material_id" => $item->_id,
                                "material_type" => $item->type,
                                "path_status" => 0
                            );
                            if (empty($temp_material_info)){
                                $temp_path_array[0] = (object) $temp_material_info;
                            } else {
                                $path_count = count($temp_path_array);
                                $temp_path_array[$path_count] = (object) $temp_material_info;
                            }
                        }
                    }
                    $student_on_course->course_path = $temp_path_array;
                    $student_on_course->save();
                    return view('course-studying', [
                        'course'=>$course,
                        'lesson_items'=>$items_array,
                        'student_book'=>$student_on_course,
                    ]);
                    break;
                case 1:
                    return view('course-studying', [
                        'course'=>$course,
                        'lesson_items'=>$items_array,
                        'student_book'=>$student_on_course
                    ]);
                    break;
            }
        }
    }
}

