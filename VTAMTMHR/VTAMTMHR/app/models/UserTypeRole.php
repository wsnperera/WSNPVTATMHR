<?php
class UserTypeRole extends Eloquent
{
    protected  $table = 'usertyperole';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;
    public static function validate($inputs)
    {
        $rules = array
        ( 
            'utypeid' => 'Required',
            'activityid' => 'Required',
        );
        return $validator = Validator::make($inputs,$rules);
    }
    public function getUserType() 
    {
        return $this->belongsTo('UserType', 'utypeid');
    }
    public function getActivityType() 
    {
        return $this->belongsTo('Activity', 'activityid');
    }
}