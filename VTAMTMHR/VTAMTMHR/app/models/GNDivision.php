<?php

class GNDivision extends Eloquent {

    protected $table = 'gndivision';  // define your table name here
    protected $primaryKey = 'GNDivisionCode'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {

        $rules = array(
            'GNDivisionName' => 'Required|unique:gndivision,GNDivisionName',
        );
        $msg = array(
            'GNDivisionCode.required' => 'GN Division Code  is a required field',
        );

        return $validator = Validator::make($inputs, $rules, $msg);
    }

    public static function validateEdit($inputs) {

        $rules = array(
            'GNDivisionName' => 'Required',
        );
        $msg = array(
            'GNDivisionCode.required' => 'GN Division Code  is a required field',
        );


        return $validator = Validator::make($inputs, $rules, $msg);
    }

    public function getDSDivision() {
        return $this->belongsTo('DSDivision', 'DSDivisionCode');
    }
     public static function getDistrictName($DSDivisionCode) {
         $getDistrictCode = DSDivision::where('ElectorateCode','=',$DSDivisionCode)->pluck('DistrictCode');
         $getDistrictName = District::where('DistrictCode','=',$getDistrictCode)->pluck('DistrictName');
        return $getDistrictName;
    }
}
