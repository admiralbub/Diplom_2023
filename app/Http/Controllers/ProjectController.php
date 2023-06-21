<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Project;
use App\ProjectCategories;
use App\Donation;
use App\CommentsProject;
class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::where('user_id', auth()->user()->id)->get();
        $category = ProjectCategories::all();
        $mytime = Carbon::now();
        $mytime->toDateTimeString(); 
        return view('project',['projects'=>$project,'categories'=>$category,'mytime'=>$mytime]);
    }


    public function ProjectForm(Request $request) {
        $this->validate($request, [
          'title' => 'required',
          'categories_id' => 'required',
          'annotation'=>'required',
          'amount'=>'required',
          'image'=>'required',
          'body' => 'required',
          'started_at' => 'required',
          'started_end' => 'required',
       ]);
      
      $project_t = new Project;
      $project_t->title = $request->input('title');
      $project_t->user_id = $request->input('user_id');
      $project_t->categories_id = $request->input('categories_id');
      $project_t->annotation = $request->input('annotation');
      $project_t->body = $request->input('body');
      $project_t->amount = $request->input('amount');
      $project_t->started_at = $request->input('started_at');
      $project_t->started_end = $request->input('started_end');

      if ($request->hasFile('image')) {
        $img = $request->file('image');
        $filename = time() . '_' . $img->getClientOriginalName();
        $img->move(public_path('images/project'), $filename);
        $project_t->img = $filename;
      }
   
      if($request->file('video')) {
        $video = $request->file('video');
        $filename = time() . '_' . $video->getClientOriginalName();
        $video->move(public_path('video/project'), $filename);
        $project_t->video = $filename;
      }
      


      $project_t->save();
      return back()->with('success', 'Your form has been submitted.');

    }


    public function update(Request $request,$id) {
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
      if($request->file('video')) {
        $video = $request->file('video');
        $filename = time() . '_' . $video->getClientOriginalName();
        $video->move(public_path('video/project'), $filename);
        $project_t->video = $filename;
      }
      



      $project->title = $request->input('title');
      $project->categories_id = $request->input('categories_id');
      $project->annotation = $request->input('annotation');
      $project->body = $request->input('body');
      $project->amount = $request->input('amount');
      $project->started_at = $request->input('started_at');
      $project->started_end = $request->input('started_end');

      $project->website = $request->input('website');
      $project->facebook = $request->input('facebook');
      $project->telegram = $request->input('telegram');
      $project->instagram = $request->input('instagram');
      $project->twitter = $request->input('twitter');
      
      $project->save();
      return back()->with('success', 'Your form has been submitted.');

    }

    public function categories_show($id) {
        $projects = Project::where('categories_id', $id)->get();
  
        $name_category = ProjectCategories::where('id', $id)->get();
        $category = ProjectCategories::all();
        return view('project_categories',['projects_incategories'=>$projects,'categories'=>$category,'name_category'=>$name_category]);
    }

    public function show_creativeproject($slug) {
        $mytime = Carbon::now();
        $mytime->toDateTimeString(); 
        $project = Project::where('slug', $slug)->get();

        $project_id = Project::where('slug', $slug)->firstOrFail();
        $project_id = $project_id->id;

        $donation_total =  Donation::where('project_id',$project_id)->sum('amount');

        $comment = CommentsProject::where('project_id',$project_id)->get();

        if (auth()->user()) {
  
            $donation = Donation::where('user_id', auth()->user()->id)
                    ->where('project_id',$project_id)
                    ->where('check',1)
                    ->get();
            return view('show_creativeproject',['project'=>$project,'mytime'=>$mytime,'donation'=>$donation,'donation_total'=>$donation_total,'comments'=>$comment]);    
           
        } else {
            return view('show_creativeproject',['project'=>$project,'donation_total'=>$donation_total,'donation'=>"",'comments'=>$comment]);       
        }
          

    }


    public function allproject() {
        $project = Project::orderBy('id', 'DESC')->get();
        $category = ProjectCategories::all();
        
        return view('project_all',['projects'=>$project,'categories'=>$category]);



    }

    public function showProject($id) {
         $project = Project::where('id',$id)->where('user_id', auth()->user()->id)->get();
         $category = ProjectCategories::all();
         return view('project_edit',['project'=>$project,'categories'=>$category]);

    }

    public function destroy($id)
    {
            $delete_donation = Donation::where('project_id',$id)->first();

          
            $delete_donation->delete();
            



            
            $delete_project = Project::where('id',$id)->first();
            $delete_project->delete();
            return back()->with('success', 'You have successfully deleted the project.');

    }


}
