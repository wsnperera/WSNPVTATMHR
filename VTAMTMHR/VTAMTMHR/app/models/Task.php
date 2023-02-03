<?php
class Task extends Eloquent
{
    protected  $table = 'motask';  // define your table name here
    
    public $timestamps = false; 
    public static $unguarded=true;
    
    public static function validate($inputs)
    {
        $rules = array  ( 
            'TaskName' => 'Required',
        );
        return $validator = Validator::make($inputs,$rules);
    }
}