<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
/*
 *
 *  
 */
class StudentController extends Controller
{
    
     public function __construct() {
        $this->middleware('oauth',['except'=>['index','show']]);
    }
    /**
     * index.
     *
     * @return void
     */
    public function index()
    {
        $students= Student::all();
        return $this->createSuccessResponse($students, 200);
    }
    /**
     * store.
     *
     * @return void
     */
    public function store(Request $request)
    {
         $this->validateRequest($request);
         $student=Student::create($request->all());
         return $this->createSuccessResponse("The student with id {$student->id} has been created", 201);
         //201 means opeartion was successful
    }
    /**
     * show.
     *
     * @return void
     */
    public function show($id)
    {
         $student= Student::find($id);
        if($student)
        {
             return $this->createSuccessResponse($student, 200);
            
        }else {
             return $this->createErrorMessage("The student with id {$id}, doesnot exist", 404);
             //with 204 status code the error body won't be displayed so use 200 if you want to display the messgage
             
        }
        
        //return response()->json(['data'=>$course],200);
    }
     /**
     * update.
     *
     * @return void
     */
     public function update(Request $request , $id)
    {
       $student  = Student::find($id);
       if($student){
           $this->validateRequest($request);
           $student->name=$request->get('name');
           $student->phone=$request->get('phone');
            $student->address=$request->get('address');
             $student->career=$request->get('career');
             $student->save();
             
           return $this->createSuccessResponse("The student with id {$id} has been updated", 200);
       }
       return $this->createErrorMessage("the student with id {$id} does not exist", 404);
    
    }
     /**
     * destroy.
     *
     * @return void
     */
     public function destroy($id)
    {
       $student  = Student::find($id);
       if($student){
           $student->courses()->detach();//removes all the rows from the pivot table 
       
           $student->delete();
           return $this->createSuccessResponse("The student with id {$id} has been deleted", 200);
       }
       return $this->createErrorMessage("the student with id {$id} does not exist", 404);
    }
    
    public function validateRequest($request){
         $rules=
                [
                    'name'=>'required',
                    'phone'=>'required|numeric',
                    'address'=>'required',
                    'career'=>'required|in:Java,PHP,Python'
                 ];
         $this->validate($request, $rules);
    }
    //
}