<?php

class Trainee extends Eloquent {

    protected $table = 'trainee';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;


    public function getInstitute() {
        return $this->belongsTo('Institute','InstituteId');
    }


    public function Institue() {

        // define relationship
        return $this->belongsTo("Institue", "InstituteId");
    }

    public function Applicant() {

        // define relationship
        return $this->belongsTo("Applicant", "id");
    }

    public function Course() {

        // define relationship
        return $this->belongsTo("Course", "CourseListCode");
    }

    public function Organisation() {

        // define relationship
        return $this->belongsTo("Organisation", "OrgaId");
    }

    public function Testcenter() {

        // define relationship
        return $this->belongsTo("Testcenter", "CenterId");
    }

    public function District() {

        // define relationship
        return $this->belongsTo("District", "DistrictCode");
    }

    public function Province() {

        // define relationship
        return $this->belongsTo("Province", "ProvinceCode");
    }

    public function Courseapplicant() {

        // define relationship
        return $this->belongsTo("Courseapplicant", "CourseCode");
    }
     public function dropouts()
		{

                        // define relationship
                        return $this->belongsTo("Dropout","Training_No");
                        
                        
		}
	
	
	
	
	
    public static function validate($inputs) {

        $rules = array
            (
            'InstituteId' => '',
            'OrgaId' => '',
            'Year' => 'Required|numeric|Max:2050|digits:4',
            'CourseListCode' => '',
            'CourseCode' => '',
            'NIC' => 'Required|unique:applicant,NIC|digits:10|nic_val',
            'NameWithInitials' => 'Required',
            'FullName' => 'Required|alpha_spaces',
            'Address' => 'Required',
            'NameWithInitialsSinhala' => 'Required|alpha_spaces',
            'FullNameSinhala' => 'Required|alpha_spaces',
            'AddressSinhala' => 'Required',
            'DOB' => 'Required',
            'Gender' => '',
            'Province' => '',
            'District' => '',
            'Tel' => 'Required|numeric|digits:10',
            'email' => 'Required|email|unique:applicant,email',
            'Special_skills_y_n' => '',
            'Special_skills_year' => 'Required',
            'Special_skills_field' => '|alpha_spaces',
            'Special_skills_level' => '',
            'Medium' => '',
            'Bank_brunch' => 'Required',
            'date_paid' => 'Required',
            'CenterId' => '',
            'CertificateUpl' => '',
            'Qualified' => '',
            'Reason' => '',
            'ReceiptUpl' => '',
            'Uploaded' => '',
            'Deleted' => '',
            'Changed' => '',
            'created_at' => '',
            'User' => '',
            'submit_mode' => 'Required'
        );
        return $validator = Validator::make($inputs, $rules);
    }

}

?>
