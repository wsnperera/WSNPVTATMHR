<?php
class SalaryScale extends Eloquent{
    protected  $table = 'salaryscale';  // define your table name here
    protected $primaryKey = 'SS_ID'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;
    
    public static function validate($inputs) {
        $rules = array  ( 
             'SalaryScale' => 'Required|unique:salaryscale',
             'MaxSalary' => 'Required|numeric',
             'MinSalary' => 'Required|numeric',
        );
        return $validator = Validator::make($inputs,$rules);
    }
     public static function validateEdit($inputs) {
        $rules = array  ( 
             'SalaryScale' => 'Required',
             'MaxSalary' => 'Required|numeric',
             'MinSalary' => 'Required|numeric',
        );
        return $validator = Validator::make($inputs,$rules);
    }
}