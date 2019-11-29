<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Eod extends Model
{
   //protected $table = "emp_eods";
   protected $fillable = ['user_id','project_id','date','task_name','description','es_hours','today_hours','total_hours','delivery_date','task_status','comments'];
   
   public function user(){
    	return $this->belongsTo(User::class,'user_id');
   }

   public function project(){ 
    	return $this->belongsTo(Project::class,'project_id');  
   }

}

