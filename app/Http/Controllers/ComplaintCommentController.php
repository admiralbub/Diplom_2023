<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;
use App\ComplaintComment;
class ComplaintCommentController extends Controller
{
    public function store(Request $request)
    {
          $complaint = new ComplaintComment;
          $complaint->project_id = $request->input('project_id');
          $complaint->comment = $request->input('comment');
          $complaint->done = 0;
          $complaint->save();
          return back()->with('success_complaint', 'You have successfully submitted a complaint about the project, and the administrator will contact you within a day');
    }

    public function complaint_done(Request $request)
    {
        $id = $request->input('id');    
        $complaint_d = ComplaintComment::find($id);
        $complaint_d->done = $request->input('checked');
        $complaint_d->save();
        return back();
    }
}
