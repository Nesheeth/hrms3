<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_earning_type extends Model
{
    protected $table = "salary_earning _type"; 

    protected $fillable = ['name','description','status']; 
}
