<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCategories extends Model
{
    //name_categories
     protected $fillable = [
        'name_categories', 
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
