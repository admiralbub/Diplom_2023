<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhotoMember;
use App\Project;
class PhotoMemberController extends Controller
{
    public function index()
    {
        $photo_member = PhotoMember::where('user_id', auth()->user()->id)->get();
        $project = Project::where('user_id', auth()->user()->id)->get();
        return view('project_members',['photo_members'=>$photo_member,'projects'=>$project]);
    }

    public function AddMemberForm(Request $request) {
        $this->validate($request, [
          'name' => 'required',
         
       ]);
      
      $project_t = new PhotoMember;
  
      $project_t->name = $request->input('name');  
      $project_t->project_id = $request->input('project_id');  
      $project_t->user_id = $request->input('user_id');  


      if ($request->hasFile('img')) {
        $img = $request->file('img');
        $filename = time() . '_' . $img->getClientOriginalName();
        $img->move(public_path('images/members'), $filename);
        $project_t->img = $filename;
      }
   
      


      $project_t->save();
      return back()->with('success', 'Your form has been submitted.');

    }
    public function delete($id) {
         $delete = PhotoMember::find($id);
        $delete->delete();
         return back()->with('success', 'You have successfully deleted the categories.');
    }

     public function show($id) {
         $photo_members = PhotoMember::where('project_id', $id)->get();
        
         return view('show_project_members',['photo_members'=>$photo_members]);
    }


}
