<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixed_project extends Model
{
    protected $table = "fixed_project";
    protected $fillable = ['project_id','milestone_number','milestone_details','delivery_date','milestone_notes','delivery_notes','delivery_date_updated','reason_for_delay','new_delivery_date'];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }  
}
