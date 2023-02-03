<?php

class QualificationType extends Eloquent {

    protected $table = 'qualificationtype';  // define your table name here
    protected $primaryKey = 'QT_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    public static function validate($inputs) {
        $rules = array(
            'QualificationType'=>'Required',
            'QualificationDescription' => 'Required|unique:qualificationtype,QualificationDescription,NULL,id,Deleted,0,QualificationType,' . $inputs['QualificationType'],
            'Qualification' => 'Required',
        );
        return $validator = Validator::make($inputs, $rules);
    }
    public static function validateEdit($inputs) {
        $rules = array(
            'QualificationType'=>'Required',
            'QualificationDescription' => 'Required',
            'Qualification' => 'Required',
        );
        return $validator = Validator::make($inputs, $rules);
    }

}
