<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ProjectCategories;
use Carbon\Carbon;
use App\Complaint;
use App\CommentsProject;
use App\ComplaintComment;
class ManagerController extends Controller
{
    public function project_manager()
    {
        $project = Project::all();
        $mytime = Carbon::now();
        $mytime->toDateTimeString(); 
        return view('manager.project_manager',['projects'=>$project,'mytime'=>$mytime]);
    }

    public function showProject($id) {
         $project = Project::where('id',$id)->get();
         $category = ProjectCategories::all();
         return view('manager.projectmanager_edit',['project'=>$project,'categories'=>$category]);
    }
    public function update_project($id, Request $request) {
        $this->validate($request, [
          'title' => 'required|min:5',
          'categories_id' => 'required',
          'annotation'=>'required|min:10',
          'amount'=>'required',
          
          'body' => 'required|min:10',
          'started_at' => 'required',
          'started_end' => 'required',
       ]);
       
      
          $project = Project::find($id);
          if ($request->hasFile('img')) {
            $img = $request->file('img');
            $filename = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('images/project'), $filename);
            $project->img = $filename;
          }

          $project->website = $request->input('website');
          $project->facebook = $request->input('facebook');
          $project->telegram = $request->input('telegram');
          $project->instagram = $request->input('instagram');
          $project->twitter = $request->input('twitter');

          $project->title = $request->input('title');
          $project->categories_id = $request->input('categories_id');
          $project->annotation = $request->input('annotation');
          $project->body = $request->input('body');
          $project->amount = $request->input('amount');
          $project->started_at = $request->input('started_at');
          $project->started_end = $request->input('started_end');
          $project->save();
          return back()->with('success', 'Your form has been submitted.');
    }
    public function destroy_project($id)
    {
        $delete = Project::find($id);
        $delete->delete();
        $delete_donation = Donation::where('project_id',$id)->get();
        $delete_donation = Donation::where('project_id',$id)->get();
        if(count($delete_donation)>0) {
            $delete_donation->delete();
        }
        return back()->with('success', 'You have successfully deleted the project.');

    }
    public function categoriesmanager_show()
    {
        $category = ProjectCategories::all();
         return view('manager.categoriesmanager_show',['categories'=>$category]);
    }

    public function categoriesmanager_edit($id) {
        $project_edit = ProjectCategories::find($id);
         return view('manager.categoriesmanager_edit',['project_edit'=>$project_edit]);
    }   

    public function complaintmanager_show() {
        $complaint_show = Complaint::orderBy("id","DESC")->get();
         return view('manager.complaintmanager_show',['complaints'=>$complaint_show]);
    }   

    public function commentsmanager_show() {
        $commentsadmin_show = CommentsProject::orderBy("id","DESC")->get();
        return view('manager.commentsmanager_show',['comments'=>$commentsadmin_show]);
    }

    public function categoriesmanager_create(Request $request) {
        $this->validate($request, [
          'name_categories' => 'required',
       ]);
       $category_project = new ProjectCategories();
       $category_project->name_categories =  $request->input('name_categories');
       $category_project->save();
       return back()->with('success', 'Your form has been submitted.');
    }

    public function categoriesmanager_update($id,Request $request) {
        $this->validate($request, [
          'name_categories' => 'required',
       ]);
       $project_categories = ProjectCategories::find($id);
       $project_categories->name_categories = $request->input('name_categories');
       $project_categories->save();
       return back()->with('success', 'You have successfully deleted the categories.');

    }


    public function destroy_categories($id) {
         $delete = ProjectCategories::find($id);
        $delete->delete();
         return back()->with('success', 'You have successfully deleted the categories.');
    }

    public function complaintcommentsmanager_show() {
        $complaintcommentsmanager_show = ComplaintComment::orderBy("id","DESC")->get();
        return view('manager.complaintcomments_show',['complaint_comments'=>$complaintcommentsmanager_show]);
    }

}
