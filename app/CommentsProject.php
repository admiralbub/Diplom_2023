<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
class CommentsProject extends Model
{
    protected $table = 'commentsproject';
    protected $fillable = [
        'user_id', 
        'project_id', 
        'body',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
