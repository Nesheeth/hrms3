<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['emp_id', 'amount','emi','duration','aff_date','status','message'];

      public function user()
    {
        return $this->hasOne('App\User','id','emp_id');
    }

    public function getEmi(){
    	return $this->hasMany('App\EMI','loan_id');
    }
  
}
