<?php
class Module extends Eloquent
{
    protected  $table = 'module';  // define your table name here
    protected $primaryKey = 'ModuleId'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;
    
    public static function validate($inputs)
    {
        $rules = array  ( 
            'ModuleName' => 'Required',
        );
        return $validator = Validator::make($inputs,$rules);
    }
}