<?php

class TransferType extends Eloquent {

    protected $table = 'transfertype';  // define your table name here
    protected $primaryKey = 'T_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public function User() {
        return $this->belongsTo("User", "userID");
    }
   public function getInstitute() {
        return $this->belongsTo("Institute", "institutionId");
    }
     public static function validate($inputs) {
        $rules = array(
            'TransferType' => 'Required|unique:transfertype,TransferType,NULl,T_ID,Deleted,0|alpha_spaces:transfertype',
        );
        $ms = array(
            'TransferType.required' => 'Appointment Type Name must be a required field',
            'TransferType.alpha_spaces' => 'Appointment Type Name must be contained LETTERS & Spaces',
            'TransferType.unique' => 'This Appointment Type Name already exist.',
        );

        return $validator = Validator::make($inputs, $rules, $ms);
    }

    public static function validateedit($inputs) {
        $rules = array(
            'TransferType' => 'Required',
        );
        $ms = array(
            'TransferType.required' => 'Appointment Type Name must be a required field'
        );

        return $validator = Validator::make($inputs, $rules, $ms);
    }
}

