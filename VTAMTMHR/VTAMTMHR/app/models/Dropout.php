<?php

class Dropout extends Eloquent {

    protected $table = 'dropout';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {

        $rules = array
            (
            'Paper1' => 'Required|numeric',
            'Paper2' => 'Required|numeric'
        );


        return $validator = Validator::make($inputs, $rules);
    }

    public function getApplicent() {

        return $this->belongsTo('Applicant', 'NIC');
    }

    public function Institue() {

        // define relationship
        return $this->belongsTo("Institue", "InstituteId");
    }
    public function getName() {
        return $this->belongsTo("Trainee", "Stdid");
    }

    public function Organisation() {

        // define relationship
        return $this->belongsTo("Organisation", "OrgaId");
    }

    public function Trainee() {

        // define relationship
        return Trainee::where('Training_No', '=', $this->Training_No)->first();
    }

}
