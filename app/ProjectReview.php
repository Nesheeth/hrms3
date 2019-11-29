<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
class ProjectReview extends Authenticatable
{
 public function getProject(){
    return $this->hasOne('App\Project','id','project_id');
 }
    
}
