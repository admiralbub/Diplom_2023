<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complaint;
class ComplaintProjectController extends Controller
{
    public function store(Request $request)
    {
          $complaint = new Complaint;
          $complaint->project_id = $request->input('project_id');
          $complaint->name = $request->input('name');
          $complaint->type = $request->input('type');
          $complaint->body = $request->input('body');
          $complaint->done = 0;
          $complaint->save();
          return back()->with('success_complaint', 'You have successfully submitted a complaint about the project, and the administrator will contact you within a day');
    }
    public function complaint_done(Request $request)
    {
        $id = $request->input('id');    
        $complaint_d = Complaint::find($id);
        $complaint_d->done = $request->input('checked');
        $complaint_d->save();
        return back();
    }
}
