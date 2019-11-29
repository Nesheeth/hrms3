<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_tracking extends Model
{
    //protected $fillable = ['leave_type','user_id','date_from','date_to','days','contact_number','reason',];
    protected $guarded = []; 

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function leave(){
        return $this->belongsTo(LeaveType::class,'leave_type');
    }
    

}
