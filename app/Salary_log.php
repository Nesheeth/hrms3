<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_log extends Model
{
    protected $fillable = ['salary_id','title','description'];

    public function salary(){
        return $this->belongsTo(Salary::class,'salary_id'); 
    }
}
