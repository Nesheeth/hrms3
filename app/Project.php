<?php



namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model{
   
     protected  $garded = [];

     public function type(){
         return $this->belongsTo(Project_type::class, 'project_type');  
     }

     public function status(){
        return $this->belongsTo(Project_status::class, 'project_status');  
     }

     public function review(){
     	return $this->belongsTo(ProjectReview::class, 'project_id');
     }
    // public function getProjectReview(){
    //     return $this->hasOne('App\ProjectReview','')
    // }

}

