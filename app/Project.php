<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Donation;
class Project extends Model
{

    use Sluggable;
    protected $fillable = [
        'categories_id', 
        'title', 
        'img',
        'slug',
        'annotation',
        'amount',
        'user_id',
        'body',
        'video',
        'started_at',
        'started_end',
        'website',
        'instagram',
        'twitter',
        'facebook',
        'telegram',
    ];

    public function category()
    {
        return $this->belongsTo (ProjectCategories::class,'categories_id');
    }
    public function comments()
    {
        return $this->belongsTo(CommentsProject::class);
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
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
