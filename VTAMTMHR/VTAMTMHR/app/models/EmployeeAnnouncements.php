<?php

class EmployeeAnnouncements extends Eloquent {

    protected $table = 'employee_announcements';  // define your table name here
    protected $primaryKey = 'EmpA_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validateCreate($inputs) {
        $rules = array(
            'InstituteId' => '',
            'OrgaId' => 'Required',
            'Announcement' => 'Required',
        );
        $msg = array(
            'Announcement.required' => 'Announcement should be required field',
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }
    public static function validateEdit($inputs) {
        $rules = array(
            'InstituteId' => '',
            // 'OrgaId' => 'Required',
            'Announcement' => 'Required',
        );
        $msg = array(
            'Announcement.required' => 'Announcement should be required field',
        );
        return $validator = Validator::make($inputs, $rules, $msg);
    }

    public function Institute() {
        return $this->belongsTo("Institue", "InstituteId");
    }

    public function getOrganisation() {
        return $this->belongsTo("Organisation", "OrgaId");
    }

    public function Promotion() {
        return $this->hasMany('Promotion', 'id');
    }


}
