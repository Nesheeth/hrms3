<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_Assignation extends Model
{
    protected $table = "project_assignation";
    protected $fillable = ['project_id','employee_id','emp_role','start_date','end_date','assign_percentage','assign_status','performance_notes','assign_by','update_by'];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
   
    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }

    public function role(){
        return $this->belongsTo(Emp_role::class,'emp_role');
    }

    public function assign(){
        return $this->belongsTo(User::class,'assign_by');
    }

    public function last_update(){
        return $this->belongsTo(User::class,'update_by');
    }

    // public function kt_project(){
    //     return $this->belongsTo(KnowledgeTransfer::class,'project_id');
    // }

}
