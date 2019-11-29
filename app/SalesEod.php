<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesEod extends Model
{   
    protected  $table = "sales_eods";
    protected  $fillable = ['user_id','project_id','eod_date','task_1','task_2','task_3','task_4','comment']; 

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
