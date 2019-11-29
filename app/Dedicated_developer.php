<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dedicated_developer extends Model
{
    protected $table = "dedicated_developer";
    protected $fillable = ['project_id','no_of_resources','reason_for_closing','updated_by'];

    public function project(){
        return $this->belongsTo(Project::class,'project_id'); 
    }

    public function last_update(){ 
        return $this->belongsTo(User::class, 'updated_by'); 
    }
}
