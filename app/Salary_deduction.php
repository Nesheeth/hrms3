<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_deduction extends Model
{
    //

    function deduction_type(){
        return $this->belongsTo(Salary_deduction_type::class,'type');
    }
}
