<?php
class TaskSeq extends Eloquent
{
    protected  $table = 'motaskseq';  // define your table name here
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public static $unguarded=true;
    
    public static function validate($inputs)
    {
        $rules = array  ( 
            'Order' => 'Required|numeric|digits:3',
            'noofsessions' => 'Required|numeric'
        );
        return $validator = Validator::make($inputs,$rules);
    }
}