<?php

class Organisation extends Eloquent {

    protected $table = 'organisation';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public function Institute() {
        // define relationship
        return $this->belongsTo("Institute", "InstituteId");
    }

    public function getInstitute() {
        return $this->belongsTo('Institute', 'InstituteId');
    }

    public function User() {
        return $this->belongsTo("User", "userID");
    }

    public function Traininggroup() {
        return $this->hasMany("Traininggroup", "OrgaId");
    }

    public function EmployeeQualification() {
        return $this->hasMany("EmployeeQualification", "organisationId");
    }

    public static function validate($inputs) {
        $rules = array(
            'OrgaName' => 'Required|unique:organisation|alpha_spaces:organistion',
            'CenterCode' => 'unique:organisation',
            'AddL1' => 'Required',
            'Tel' => 'Required|numeric|digits_between:10,14',
            'Fax' => 'numeric|digits_between:10,14',
            'CaGuTel' => 'Required|numeric|digits_between:10,14',
            'ElectorateCode' => 'Required',
            'DistrictCode' => 'Required',
        );
        $ms = array(
            'OrgaName.required' => 'Center Name must be a required field',
            'OrgaName.alpha_spaces' => 'Center Name must be contained LETTERS & Spaces',
            'OrgaName.unique' => 'This Center Name already exist.',
            'CenterCode.unique' => 'This Center Code already exist.',
            'Tel.required' => 'Telephone Number must be a required field',
            'Tel.numeric' => 'Telephone number must be Number',
            'CaGuTel.required' => 'Career Guidance Telephone Number must be a required field',
            'CaGuTel.numeric' => 'Career Guidance Telephone number must be Number',
            'Fax.numeric' => 'Fax number must be Number',
            'Tel.digits_between' => 'Telephone Number can hold the values between 10 to 14 digits & enter a valid Telephone Number',
        );

        return $validator = Validator::make($inputs, $rules, $ms);
    }

    public static function validateedit($inputs) {
        $rules = array(
            'AddL1' => 'Required',
            'Tel' => 'Required|numeric|digits_between:10,14',
        );
        $ms = array(
            'Tel.required' => 'Telephone Number must be a required field',
            'Tel.numeric' => 'Telephone number must be Number',
            'Tel.digits_between' => 'Telephone Number can hold the values between 10 to 14 digits & enter a valid Telephone Number',
        );

        return $validator = Validator::make($inputs, $rules, $ms);
    }

    public static function boot() {
        parent::boot();

        static::created(function($record) {

            $ins = new Institute();
            $ins = $record;
          //  $lw = new LogWritter();
           // $lw->write($ins->id, 'Organisation', ActivityType::find(1));
        });


        static::updating(function($record) {
            $ins = new Institute();

            $ins = $record;

            if ($ins->Deleted == 0) {
                $lw = new LogWritter();
                $lw->write($ins->id, 'Organisation', ActivityType::find(2));
            }

            if ($ins->Deleted == 1) {
                $lw = new LogWritter();
                $lw->write($ins->id, 'Organisation', ActivityType::find(3));
            }
        });
    }

    public function getElec() {
        return $this->belongsTo("Electorate", "ElectorateCode");
    }

    public function getDistrict() {
        return $this->belongsTo("District", "DistrictCode");
    }

    public function Interview() {
        return $this->belongsTo("Interview", "CenterId");
    }

    public function OrgType() {
        return $this->belongsTo("OrganisationType", "TypeId");
    }

    public function COTType() {
        return $this->belongsTo("Organisation", "COT_Id");
    }
    public static function getOWNERSHIP($id){
         return Orgaownership::where('id','=',$id)->pluck('Type');
   }


   public static function getOICName($empid){
        $name=Employee::where('id','=',$empid)->where('Deleted','=',0)->first();
        return $name;
   }


/*
    public function BatchStart() {

        return $this->hasMany("Batchstart", "OrgaId");
    }

    public function getOrganisationType() {
        return $this->belongsTo("OrganisationType", "TypeId");
    }
*/
}
