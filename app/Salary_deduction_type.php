<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_deduction_type extends Model
{
    protected $table = "salary_deduction_type";

    protected $fillable = ['name','description','status'];

    
}
