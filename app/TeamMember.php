<?php
namespace App;
 use Illuminate\Database\Eloquent\Model;
 class TeamMember extends Model{

 	public function user(){

 			return $this->belongsTo('App\User','team_member_id');
 		}

 		public function kt(){

 			return $this->belongsTo('App\KnowledgeTransfer','user_id');

 		}
     }