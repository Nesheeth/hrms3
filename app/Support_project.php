<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support_project extends Model
{
    protected $table  = 'support_project'; 
    protected $fillable = ['project_id','start_date','expiry_date','total_hours','remaining_hours','project_renewed'];  

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
}
