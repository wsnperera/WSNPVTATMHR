<?php

class UserType extends Eloquent
{
    protected  $table = 'usertype';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;
    
    
    public function Institute() {
        return $this->belongsTo("Institue", "InstituteId");
    }
    
     public static function validate($inputs) {
        $rules = array (
            'UType' => 'Required|unique:usertype',
        );
        $msg = array(
            'UType.required' => 'User Type  is a required field',
             'UType.unique' => 'This User Type  is already exist',
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }
  public static function validateedit($inputs) {
        $rules = array (
            'UType' => 'Required',
        );
        $msg = array(
            'UType.required' => 'User Type  is a required field',
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }


}
