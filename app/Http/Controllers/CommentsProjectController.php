<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\CommentsProject;
class CommentsProjectController extends Controller
{
    public function store(Request $request)
    {
          $comment_t = new CommentsProject;
          $comment_t->user_id = $request->input('user_id');
          $comment_t->project_id = $request->input('project_id');
          $comment_t->body = $request->input('body');
          $comment_t->save();
          return back()->with('success', 'Your form has been submitted.');
    }

    public function delete($id) {
        $delete = CommentsProject::find($id);
        $delete->delete();
        return back()->with('success', 'You have successfully deleted the categories.');
    }

}
