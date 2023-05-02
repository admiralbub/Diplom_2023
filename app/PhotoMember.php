<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoMember extends Model
{
    protected $table = 'photo_members';
    protected $fillable = [
        'project_id', 
        'name', 
        'user_id',
        'img',
    ];

    public function project()
    {
         return $this->belongsTo(Project::class,'project_id');
    }
}
