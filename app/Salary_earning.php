<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_earning extends Model
{
    //
    function earning_type(){
        return $this->belongsTo(Salary_earning_type::class,'type');
    }
    
}
