<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaint';
    protected $fillable = [
        'name', 
        'body',
        'type',
        'done', 
        'project_id',
        'created_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
