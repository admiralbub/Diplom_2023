<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExclusiveMaterial extends Model
{
   use Sluggable;
   protected $table = 'exclusive_material';

    protected $fillable = [
        'title', 
        'body',
        'slug',
        'img',
        'user_id',
        'created_at',
        'project_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate'=>true
            ]
        ];
    }
}
