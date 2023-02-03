<?php

class Electorate extends Eloquent {

    protected $table = 'electorate';  // define your table name here
    protected $primaryKey = 'ElectorateCode'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {

        $rules = array
            (
            'ProvinceCode' => 'Required',
            'DistrictCode' => 'Required',
            'ElectorateCode' => 'Required',
            'ElectorateName' => 'Required',
            
        );


        return $validator = Validator::make($inputs, $rules);
    }

    public function getDistrict() {


        return District::where('DistrictCode', '=', $this->DistrictCode)->first();
    }

    public function getProvince() {

        return Province::find(1);
    }

    public function District() {

        // define relationship
        return $this->belongsTo("District", "DistrictCode");
    }

    public function Organisation() {

        // define relationship
        return $this->belongsTo("Organisation", "id");
    }

}

?>