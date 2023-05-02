<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\user;
class Donation extends Model
{
    protected $table = 'donations';
    protected $fillable = [
        'amount', 
        'user_id', 
        'paypal_payment_id',
        'check',
        'project_id',
        'created_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }

}
