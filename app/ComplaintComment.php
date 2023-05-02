<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\CommentsProject;
class ComplaintComment extends Model
{
    protected $table = 'complaintcomments';
    protected $fillable = [
        'project_id', 
        'comment', 
        'done',
    ];

    

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function comments()
    {
        return $this->belongsTo(CommentsProject::class,'comment');
    }
}
