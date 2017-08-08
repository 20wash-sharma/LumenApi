<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Teacher;
use App\Course;
use Illuminate\Http\Request;
/*
 * Nested Resource controller
 *  
 */
class TeacherCourseController extends Controller
{
     public function __construct() {
        $this->middleware('oauth',['except'=>['index']]);
    }
    
    /**
     * index.
     *
     * @return void
     */
    public function index($teacherid)
    {
         $teacher  = Teacher::find($teacherid);
       if($teacher){
           $courses=$teacher->courses;
            return $this->createSuccessResponse($courses, 200); 
       }
       return $this->createErrorMessage("the teacher with id {$teacherid} does not exist", 404);
    }
    /**
     * store.
     *
     * @return void
     */
    public function store(Request $request, $teacherid)
    {
           $teacher  = Teacher::find($teacherid);
       if($teacher){
           $this->validateRequest($request);
          $course= Course::create([
               'title'=>$request->title,
               'description'=>$request->description,
               'value'=>$request->value,
               'teacher_id'=>$teacherid,
           ]);
          return $this->createSuccessResponse("The course with an id {$course->id} is associated with teacher with an id {$teacherid}", 201); 
       }
       return $this->createErrorMessage("the teacher with id {$teacherid} does not exist", 404);
       
    }
   
     /**
     * update.
     *
     * @return void
     */
     public function update(Request $request, $teacherid, $courseid)
    {
        $teacher  = Teacher::find($teacherid);
       if($teacher){
            $course  = Course::find($courseid);
       if($course){
           $this->validateRequest($request);
          $course->title=$request->title;
            $course->description=$request->description;
              $course->value=$request->value;
                $course->teacher_id=$teacherid;
             $course->save();
              return $this->createSuccessResponse("The course with an id {$course->id} is successfully updated with a teacher with an id {$teacherid}", 200); 
    
           }
       return $this->createErrorMessage("the course with id {$courseid} does not exist", 404);
        
           }
       return $this->createErrorMessage("the teacher with id {$teacherid} does not exist", 404);
         
    }
     /**
     * removes the course if the teacher id is associated with the course
     *
     * @return void
     */
     public function destroy($teacherid, $courseid)
    {
         $teacher  = Teacher::find($teacherid);
       if($teacher){
            $course  = Course::find($courseid);
       if($course){
          if($teacher->courses()->find($courseid))
          {
              $course->students()->detach();
              $course->delete();
              return $this->createSuccessResponse("The course with an id {$course->id} is successfully removed", 200); 
     
          }
           return $this->createErrorMessage("the course  with id {$courseid} is not associated with teacher with id {$teacherid} ", 409);
             
           }
       return $this->createErrorMessage("the course with id {$courseid} does not exist", 404);
        
           }
       return $this->createErrorMessage("the teacher with id {$teacherid} does not exist", 404);
    }
    
      public function validateRequest($request){
         $rules=
                [
                    'title'=>'required',
                    'description'=>'required',
                    'value'=>'required|numeric',
                   
                 ];
         $this->validate($request, $rules);
    }

    //
}