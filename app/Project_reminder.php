<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_reminder extends Model
{
    protected $fillable = ['project_id','reminder_type','reminder_date','reminder_time','reminder_day','reminder_notes','status'];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
    
    public function getTypeAttribute(){
        $type = $this->attributes['price'];
        if($type==1)
           return "One Time";
        elseif($type==2)
           return "Every Day";
        elseif($type==3)
           return "Weekly";
        else
        return "";
    }
}
