<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Course;
class CourseController extends Controller
{
    /**
     * index.
     *
     * @return void
     */
    public function index()
    {
        $courses= Course::all();
        return $this->createSuccessResponse($courses, 200);
        //return response()->json(['data'=>$courses],200);
    }
   
    /**
     * show.
     *
     * @return void
     */
    public function show($id)
    {
        $course= Course::find($id);
        if($course)
        {
             return $this->createSuccessResponse($course, 200);
            
        }else {
             return $this->createErrorMessage("The course with id {$id}, doesnot exist", 204);
             //with 204 status code the error body won't be displayed so use 200 if you want to display the messgage
             
        }
        
        //return response()->json(['data'=>$course],200);
    }
    
    //
}