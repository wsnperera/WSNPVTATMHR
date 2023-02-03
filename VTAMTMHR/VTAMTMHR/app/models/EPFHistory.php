<?php

class EPFHistory extends Eloquent {

    protected $table = 'epfhistory';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validateCreate($inputs) {
        $rules = array(
            'NIC' => 'Required',
            'EPF' => 'Required|unique:epfhistory,EPF',
        );
        $msg = array(
            'NIC.required' => 'NIC is a required field',
            'EPF.required' => 'EPF No is a required field',
            
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }

    

}
