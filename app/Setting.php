<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Setting extends Model
{
    protected $table = 'hrms_global_settings';

    public function get_setting_by_key($key_name){
        $settings = DB::table('hrms_global_settings')->where('key_name',$key_name)->first();
        return $settings->value;
    }

}