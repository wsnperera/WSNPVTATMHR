<?php

class TemPromotion extends Eloquent {

    protected $table = 'tempromotion';  // define your table name here
    protected $primaryKey = 'P_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {
        $rules = array(
            'NIC' => 'Required|alpha_num|digits:10',
            'EPF' => 'Required',
            'StartDate' => 'Required|date',
            'TransferType' => 'Required',
            'IncrementDay' => 'numeric|digits_between:1,2|max:31',
            'NewPost' => 'Required',
        );
        $ms = array(
            'NIC.required' => 'You are not a current employee first you need to assign as Employee',
            'StartDate.date' => 'Start Date must be a date',
        );

        return $validator = Validator::make($inputs, $rules, $ms);
    }

     public static function getNOConfirm()
    {
       
        $val=  TemPromotion::where("Deleted", "!=", 1)
        		->where('Comfirm','=',0)
        		->get();
        return count($val);
    }
    public function getEmp() {
        return $this->belongsTO('Employee', 'Emp_ID');
    }

    public function getOrga() {
        return $this->belongsTO('Organisation', 'ToOrganisation');
    }

    public function getPost() {
        return $this->belongsTO('EmployeeCode', 'NewPost');
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

    public function getSalaryScale() {
        return $this->belongsTO('SalaryScale', 'SalaryScale');
    }
public function getEmpType() {
        return $this->belongsTO('EmployeeType', 'EmpType');
    }
}
