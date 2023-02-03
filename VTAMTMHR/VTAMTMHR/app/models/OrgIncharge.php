<?php

class OrgIncharge extends Eloquent {

    protected $table = 'organisation_incharge';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public function getEmployeeName() {
        return$this->belongsTo("Employee", "EmpId", "id");
    }
    public function getInstituteName(){
        return $this->belongsTo("Institute","InstituteId","InstituteId");
    }
    public function getOrganizationName(){
        return $this->belongsTo("Organization","OrgaId","id");
    }
    
    public static function validate($inputs)
    {
        $rules = array
        ( 
           'InstituteId' => 'Required',
           'OrgaId' => 'Required',
           'EmpId' => 'Required',
           'StartDate' => 'Required',
           'EndDate'=>'Required',
           'CurrentRecord' => 'Required',
        );
        return $validator = Validator::make($inputs, $rules);
    }

}
