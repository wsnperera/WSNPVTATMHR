<?php

class ModuleTask extends Eloquent {

    protected $table = 'momoduletask';  // define your table name here
    //protected $primaryKey = 'MC_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function validate($inputs) {
        $rules = array  (
            'CourseListCode' => 'required',
            'ModuleId' => 'required',
            'M_Code' => 'required|unique:modulecourse,M_Code,NULL,MC_ID,Deleted,0',
            'Hours' => 'required|numeric',
            'Type' => 'required',
            'assessmentweight' => 'required|numeric|min:0|max:100',
            'CACutOff' => 'required|numeric',
            'finalmarkweight' => 'required|numeric|min:0|max:100',
            'FECutOff' => 'required|numeric',
        );
        return $validator = Validator::make($inputs, $rules);
    }
    public static function validateNew($inputs) {
        $rules = array  (
            'CourseListCode' => 'required',
            'TaskId' => 'required',
            'M_Code' => 'required',
            'Hours' => 'required|numeric',
            'Type' => 'required|unique:modulecourse,Type,'.$inputs['Type'].',MC_ID,Deleted,0',
            'assessmentweight' => 'required|numeric|min:0|max:100',
            'CACutOff' => 'required|numeric',
            'finalmarkweight' => 'required|numeric|min:0|max:100',
            'FECutOff' => 'required|numeric',
        );
        return $validator = Validator::make($inputs, $rules);
    }
    public static function validateEdit($inputs) {
        $rules = array  (
            'CourseListCode' => 'required',
            'ModuleId' => 'required',
            'M_Code' => 'required|unique:modulecourse,M_Code,'.$inputs['MC_ID'].',MC_ID,Deleted,0,CourseListCode,' .$inputs['CourseListCode'],
            'Hours' => 'required|numeric',
            'Type' => 'required',
            'assessmentweight' => 'required|numeric|min:0|max:100',
            'CACutOff' => 'required|numeric',
            'finalmarkweight' => 'required|numeric|min:0|max:100',
            'FECutOff' => 'required|numeric',
        );
        $msg = array(
            'M_Code.unique'=>'Module Code "'.$inputs['M_Code'].'" already exits for Course List Code "'.$inputs['CourseListCode'].'"'
        );
        return $validator = Validator::make($inputs, $rules,$msg);
    }
    public static function validateEditNew($inputs) {
        $rules = array  (
            'CourseListCode' => 'required',
            'ModuleId' => 'required',
            'M_Code' => 'required|unique:modulecourse,M_Code,'.$inputs['MC_ID'].',MC_ID,Deleted,0,CourseListCode,' .$inputs['CourseListCode'],
            'Hours' => 'required|numeric',
            'Type' => 'required|unique:modulecourse,Type,'.$inputs['Type'].',MC_ID,M_Code,'.$inputs['MC_ID'].',Deleted,0',
            'assessmentweight' => 'required|numeric|min:0|max:100',
            'CACutOff' => 'required|numeric',
            'finalmarkweight' => 'required|numeric|min:0|max:100',
            'FECutOff' => 'required|numeric',
        );
        $msg = array(
            'M_Code.unique'=>'Module Code "'.$inputs['M_Code'].'" and Type "'.$inputs['Type'].'" already exits for Course List Code "'.$inputs['CourseListCode'].'"'
        );
        return $validator = Validator::make($inputs, $rules,$msg);
    }

    public static function getModuleTask() {
        //return $this->belongsTo('Module', 'moduleid');
        return ModuleTask::where('deleted','!=',1)->get();

    }


    public function getModule() {
        return $this->belongsTo('Module', 'moduleid');
    }


    public function getTask() {
        return $this->belongsTo('Task', 'taskid');
    }

     public function getCourse() {
        return $this->belongsTo('Course', 'courseid');
    }


}
