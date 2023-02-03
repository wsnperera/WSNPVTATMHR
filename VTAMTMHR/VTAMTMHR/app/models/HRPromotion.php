<?php

class HRPromotion extends Eloquent {

    protected $table = 'hrpromotion';  // define your table name here
    protected $primaryKey = 'P_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {
        $rules = array(
            'NIC' => 'Required',
            'EPF' => 'Required',
            'StartDate' => 'Required|date',
            'TransferType' => 'Required',
            'IncrementDay' => 'numeric',
            'NewPost' => 'Required',
        );
        $ms = array(
            'NIC.required' => 'You are not a current employee first you need to assign as Employee',
            'StartDate.date' => 'Start Date must be a date',
        );

        return $validator = Validator::make($inputs, $rules, $ms);
    }

    public function getEmp() {
        return $this->belongsTO('HREmployee', 'Emp_ID');
    }

    public function getOrga() {
        return $this->belongsTO('Organisation', 'ToOrganisation');
    }

    public function getPost() {
        return $this->belongsTO('HREmploymentCode', 'NewPost');
    }

    public function getInstitute() {
        return $this->belongsTO('Institute', 'InstituteId');
    }

    public function getDepartment() {
        return $this->belongsTO('Department', 'ToDepartment');
    }

    public function getTransferType() {
        return $this->belongsTO('TransferType', 'TransferType');
    }

   

    public static function getDistrictName($id){
        $orgaDetails=Organisation::where('id','=',$id)->where('Deleted','=',0)->pluck('DistrictCode');
        $districtName=District::where('DistrictCode','=',$orgaDetails)->pluck('DistrictName');
        return $districtName;
    }

}
