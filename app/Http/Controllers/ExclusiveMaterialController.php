<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExclusiveMaterial;
use App\Donation;
use Carbon\Carbon;
use App\Project;
class ExclusiveMaterialController extends Controller
{
    public function index() {
        $exclusivematerial =  ExclusiveMaterial::where('user_id', auth()->user()->id)->get();
        $projects = Project::where('user_id', auth()->user()->id)->get();
        return view("exclusive_list",['exclusivematerial'=>$exclusivematerial,'projects'=>$projects]);
    }    

    public function add(Request $request) {
        $this->validate($request, [
          'title' => 'required|min:5',
          'project_id' => 'required',
          'title'=>'required',
          'body'=>'required|min:10',
          'image'=>'required',
       ]);
      
        $exclusive = new ExclusiveMaterial;
        $exclusive->title = $request->input('title');
        $exclusive->project_id = $request->input('project_id');
        $exclusive->user_id = auth()->user()->id;
        $exclusive->body = $request->input('body');


        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $filename = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('images/exclusivematerial'), $filename);
            $exclusive->img = $filename;
        }

        $exclusive->save();
        return back()->with('success', 'Your form has been submitted.');
    }

    public function destroy($id)
    {
            
        $exclusiveMaterial = ExclusiveMaterial::find($id);
        $exclusiveMaterial->delete();
        return back()->with('success', 'You have successfully deleted the project.');

    }


    public function exclusive_edit($id) {
         $exclusivematerial =  ExclusiveMaterial::where('user_id', auth()->user()->id)->where('id',$id)->get();
     //   $projects = Project::where('user_id', auth()->user()->id)->get();
        return view("exclusive_edit",['exclusivematerial'=>$exclusivematerial]);
    }

     public function update(Request $request,$id) {
          $this->validate($request, [
              'title' => 'required|min:5',
             
              'body'=>'required|min:10',
           ]);
          
          
          $exclusivematerial = ExclusiveMaterial::find($id);
          if ($request->hasFile('img')) {
            $img = $request->file('img');
            $filename = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('images/exclusivematerial'), $filename);
            $exclusivematerial->img = $filename;
          }
         
          



          $exclusivematerial->title = $request->input('title');
        
          $exclusivematerial->body = $request->input('body');
        
          
          $exclusivematerial->save();
          return back()->with('success', 'Your form has been submitted.');

    }
    public function show($slug) {
          $project= Project::where('slug', $slug)->firstOrFail();
         $exclusivematerial =  ExclusiveMaterial::where('project_id', $project->id)->orderBy('id', 'desc')->get();
        
         $donation_total =  Donation::where('project_id',$project->id)->where('user_id',auth()->user()->id)->where('check',1)->sum('amount');
        

         $donation =  Donation::where('project_id',$project->id)->where('user_id',auth()->user()->id)->where('check',1)->first();

         if(!$donation) {
             return view('сonditionexclusive');
         }
         $percent = ($donation_total  / $project->amount) * 100;

         $startdonation = Carbon::parse($donation->created_at);
         $todayDate = Carbon::now()->toDateString();
         $daysSinceDonation = $startdonation->diffInDays(Carbon::now());
         if(intval($percent)>=1) {
            if($daysSinceDonation<=10) {
                return view('show_exclusive',['exclusivematerial'=>$exclusivematerial]);
            } else {
                 return view('сonditionexclusive');
            }
         } else if(intval($percent)>=10) {
            if($daysSinceDonation<=100) {
                return view('show_exclusive',['exclusivematerial'=>$exclusivematerial]);
            } else {
                 return view('сonditionexclusive');
            }
         } else if(intval($percent)<=50) {
              return view('show_exclusive',['exclusivematerial'=>$exclusivematerial]);
         } else {
            return view('сonditionexclusive');
         }
       
       

    }
}
