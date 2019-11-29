<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_log extends Model
{
    protected $table = "project_logs";
    protected $fillable = ['project_id','descroption','last_update'];

    public function project(){
        $this->belongsTo(Project::class,'project_id');
    }

    public function update_by(){
        $this->belongsTo(User::class,'last_update');
    }
}
