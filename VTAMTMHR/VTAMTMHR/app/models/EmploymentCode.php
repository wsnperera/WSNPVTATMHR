<?php

class EmploymentCode extends Eloquent {

    protected $table = 'employmentcode';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public function getInstitution() {
        return $this->belongsTO('Institute', 'InsId');
    }

    public static function validate($inputs) {

        $rules = array(
            'EmpCode' => 'Required|unique:employmentcode,id,' . $inputs['id'],
            'Designation' => 'Required|unique:employmentcode,id,' . $inputs['id'],
        );


        return $validator = Validator::make($inputs, $rules);
    }

    public static function validate1($inputs) {
        $rules = array (
            'EmpCode' => 'Required',
            'Academic' => 'Required',
            'Designation' => 'Required',
            'SalaryCode' => 'Required',
            'MajorMinor' => 'Required',
            'Positions' => 'Required|numeric',
        );

        return $validator = Validator::make($inputs, $rules);
    }

    public function EmployeeQualification() {
        return $this->belongsTO('EmployeeQualification', 'EmpCode');
    }

    public function getSalaryScale() {
        return $this->belongsTo('SalaryScale', 'SS_ID');
    }

}
