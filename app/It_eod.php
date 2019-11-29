<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class It_eod extends Model
{
   protected $table = "it_eods";
   protected $fillable = ['user_id','shift','eod_date','task_id','issue_type','cbpc_no','issue_details','resolution_provided','resolution_status','comment'];
   
   public function user(){
    	return $this->belongsTo(User::class,'user_id');
   }

}

