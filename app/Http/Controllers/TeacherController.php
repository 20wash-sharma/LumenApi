<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
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
        $teachers= Teacher::all();
        return $this->createSuccessResponse($teachers, 200);
    }
    /**
     * store.
     *
     * @return void
     */
    public function store(Request $request)
    {
         $this->validateRequest($request);
         $teacher=Teacher::create($request->all());
         return $this->createSuccessResponse("The teacher with id {$teacher->id} has been created", 201);
         //201 means opeartion was successful
    }
    /**
     * show.
     *
     * @return void
     */
    public function show($id)
    {
          $teacher= Teacher::find($id);
        if($teacher)
        {
             return $this->createSuccessResponse($teacher, 200);
            
        }else {
             return $this->createErrorMessage("The course with id {$id}, doesnot exist", 204);
             //with 204 status code the error body won't be displayed so use 200 if you want to display the messgage
             
        }
        
        //return response()->json(['data'=>$course],200);
    }
     /**
     * update.
     *
     * @return void
     */
     public function update(Request $request, $id)
    {
         $teacher  = Teacher::find($id);
       if($teacher){
           $this->validateRequest($request);
           $teacher->name=$request->get('name');
           $teacher->phone=$request->get('phone');
            $teacher->address=$request->get('address');
             $teacher->profession=$request->get('profession');
             $teacher->save();
             
           return $this->createSuccessResponse("The teacher with id {$id} has been updated", 200);
       }
       return $this->createErrorMessage("the teacher with id {$id} does not exist", 404);
    }
     /**
     * destroy.
     *
     * @return void
     */
     public function destroy($id)
    {
       $teacher  = Teacher::find($id);
       if($teacher){
           $courses= $teacher->courses;
           if(sizeof($courses)>0)
           {
              return $this->createErrorMessage("you can't delete a teacher with active courses.Please delete those course first ", 409);  
              //409 means a conflict with the request
           }
                  
           $teacher->delete();
           return $this->createSuccessResponse("The teacher with id {$id} has been deleted", 200);
       }
       return $this->createErrorMessage("the teacher with id {$id} does not exist", 404);
    }
    
     public function validateRequest($request){
         $rules=
                [
                    'name'=>'required',
                    'phone'=>'required|numeric',
                    'address'=>'required',
                    'profession'=>'required|in:Java,PHP,Python'
                 ];
         $this->validate($request, $rules);
    }

    //
}