<?php

class Course extends Eloquent {

    protected $table = 'coursedetails';  // define your table name here
    protected $primaryKey = 'CD_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {

        $rules = array
            (
            'CourseListCode' => 'Required',
            'CourseName' => 'Required',
            'CourseType' => 'Required',
            'TradeId' => 'Required',
            'CourseLevel' => 'Required',
            'Nvq' => 'Required',
            'ProgramType' => 'Required',
           
        );


        return $validator = Validator::make($inputs, $rules);
    }

    public function Institue() {

        // define relationship
        return $this->belongsTo("Institue", "InstituteId");
    }

    public function coursedetail() {
        return $this->belongsTo("batchstart", "BS_ID");
    }

    public function getTrade() {
        return $this->belongsTo("Trade", "TradeId");
    }

    public function getQulification() {
        return $this->belongsTo("Qualification", "Qualification_ID");
    }

    public static function getCourseName($CourseListCode) {
        return Course::where('CourseListCode', '=', $CourseListCode)
                        ->where('Deleted', '!=', 1)
                        ->pluck('CourseName');
    }

}

?>