<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
class EmpSession extends Authenticatable
{
  
  protected $table = "emp_session";
    
}