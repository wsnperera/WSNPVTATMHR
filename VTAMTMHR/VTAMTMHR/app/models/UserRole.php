<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserRole
 *
 * @author User
 */
class UserRole extends Eloquent
{
    protected  $table = 'userrole';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;


      public function getActivity() {
        return $this->belongsTo('Activity', 'activityid', 'activityid');
    }


}
