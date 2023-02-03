<?php

class HREmployee extends Eloquent {

    protected $table = 'hremployee';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validateCreate($inputs) {
        $rules = array (
            //'NIC' => 'Required|nic_val|unique:employee,NIC,NULL,id,Deleted,0',
            'EPFNo' => 'Required',
            'LastName' => 'Required',
            'Initials' => 'Required',
            'Name' => 'Required',
            'Sex' => 'Required',
            'DOB' => 'Required',
            'PAddress' => 'Required',
            'DSDivision' => 'Required',
            'Contact' => 'digits:10',
            'Mobile' => 'digits:10',
            'Email' => 'email',
            'OContact' => 'digits:10',
            'OMobile' => 'digits:10',
            
        );
        $msg = array(
            'NIC.nic_val'=>'Enter a valid NIC number',
            'Mobile.digits' => 'Personal Mobile Number need to hold 10 digits',
            'Contact.digits' => 'Residence Telephone Number need to hold 10 digits',
            'PAddress.required' => 'Permanent Address is a required field',
            'Emergency.required' => 'Mention a contact person Name & contact Number while any Emergency occurs',
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }
 public static function validateEdit($inputs) {

        $rules = array(
            //'NIC' => 'Required|nic_val|unique:employee,NIC,' . $inputs['EPFNo'].',EPFNo,Deleted,0',
            'EPFNo' => 'Required',
            'LastName' => 'Required',
            'Initials' => 'Required',
            'Name' => 'Required',
            'Sex' => 'Required',
            'DOB' => 'Required',
            'PAddress' => 'Required',
            'DSDivision' => 'Required',
            'Contact' => 'digits:10',
            'Mobile' => 'digits:10',
            'Email' => 'email',
            'OContact' => 'digits:10',
            'OMobile' => 'digits:10',
           
        );
        $msg = array(
            'NIC.nic_val'=>'Enter a valid NIC number',
            'Mobile.digits' => 'Personal Mobile Number need to hold 10 digits',
            'Contact.digits' => 'Residence Telephone Number need to hold 10 digits',
            'Emergency.required' => 'Mention a contact person Name & contact Number while any Emergency occurs',
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }
    public function Institue() {
        return $this->belongsTo("Institue", "InstituteId");
    }

    public function Organisation() {
        return $this->belongsTo("Organisation", "OrgId");
    }

    public function Promotion() {
        return $this->hasMany('Promotion', 'id');
    }

    public function EmployeeAttendance() {
        return $this->hasMany('EmployeeAttendance', 'id', 'EmpId');
    }

    public function getPromotion() {
        return $this->hasMany('Promotion', 'NIC', 'NIC');
    }

    public function getOrganization() {
        return $this->belongsTo('Organization', 'OrgId');
    }

    public function getDistrict() {
        return $this->belongsTo('District', 'DistrictName');
    }

    public function getDSDivision() {
        return $this->belongsTo('Electorate', 'DSDivision');
    }

}
