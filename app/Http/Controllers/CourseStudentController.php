<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Course;
use App\Student;
class CourseStudentController extends Controller
{
    
    public function __construct() {
        $this->middleware('oauth',['except'=>['index']]);
    }
    
    /**
     * index.
     *
     * @return void
     */
    public function index($courseid)
    {
        $course  = Course::find($courseid);
       if($course){
           $students=$course->students;
            return $this->createSuccessResponse($students, 200); 
       }
       return $this->createErrorMessage("the course with id {$courseid} does not exist", 404);
    }
    /**
     * store.
     *
     * @return void
     */
    public function store($courseid, $studentid)
    {
        $course  = Course::find($courseid);
       if($course){
          $student  = Student::find($studentid);
       if($student){
          if($course->students()->find($studentid)){
             return $this->createErrorMessage("the student with id {$studentid} already  registered for the course", 409);//409 is a conflict  
             
          }
          $course->students()->attach($studentid);
           return $this->createSuccessResponse("The student with id {$studentid} is added to the course with course id {$courseid}", 201); //201 as it creates an entry in pivot table course_student
          
       }
       return $this->createErrorMessage("the student with id {$studentid} does not exist", 404);
       }
       return $this->createErrorMessage("the course with id {$courseid} does not exist", 404);
    }
      /**
     * we are detaching the student from the course if the student is registerd for the course.
     *
     * @return void
     */

     public function destroy($courseid, $studentid)
    {
            $course  = Course::find($courseid);
       if($course){
          $student  = Student::find($studentid);
       if($student){
          if(!$course->students()->find($studentid)){
             return $this->createErrorMessage("the student with id {$studentid} is not  registered for the course", 404);//  
             
          }
          $course->students()->detach($studentid);
           return $this->createSuccessResponse("The student with id {$studentid} is removed from the course with course id {$courseid}", 200); 
          
       }
       return $this->createErrorMessage("the student with id {$studentid} does not exist", 404);
       }
       return $this->createErrorMessage("the course with id {$courseid} does not exist", 404);
    }

    //
}