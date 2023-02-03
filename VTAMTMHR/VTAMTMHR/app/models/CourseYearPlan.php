<?php
class CourseYearPlan extends Eloquent
{
    protected  $table = 'courseyearplan';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded = true;
    public static function checkExist($ins,$org,$courseListCode)
    {
        $c=  CourseYearPlan::where('Deleted','=',0)->where('Year','=',date('Y'))->where('instId','=',$ins)->where('OrgId','=',$org)->where('CourseListCode','=',$courseListCode)->count();
        if($c>=1)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    public static function getNOConfirm()
    {
        $array=array();
        $array[0]=date('Y')-1;
        $array[1]=date('Y');
        $array[2]=date('Y')+1;
        $val=  CourseYearPlan::where('instId','=',User::getSysUser()->instituteId)
                //->where('OrgId','=',User::getSysUser()->organisationId)
                ->where('confirmChage','=',0)
                ->where('Deleted','=',0)
                ->whereIn('year',$array)
                ->get();
        return count($val);
    }
    public static function getNOConfirmFirstPage($x)
    {
        $array=array();
        $array[0]=date('Y')-1;
        $array[1]=date('Y');
        $array[2]=date('Y')+1;
        $val=  CourseYearPlan::where('instId','=',User::getSysUser()->instituteId)
                ->where('OrgId','=',$x)
                ->where('confirmChage','=',0)
                ->where('Deleted','=',0)
                ->whereIn('year',$array)
                ->get();
        return count($val);
    }
    public static function getNOConfirmedRequest($x)
    {
        $array=array();
        $array[0]=date('Y')-1;
        $array[1]=date('Y');
        $array[2]=date('Y')+1;
        $val=  CourseYearPlan::where('instId','=',User::getSysUser()->instituteId)
                ->where('OrgId','=',$x)
                ->where('confirm','=',1)
                ->where('Deleted','=',0)
                ->whereIn('year',$array)
                ->get();
        return count($val);
    }
    public static function validate($inputs)
    {
        $rules = array
        ( 
            'Year' => 'Required',
            'CourseListCode' => 'Required',
           
			'CourseLevel' => 'Required',
             'medium'=>'Required',
             'parallel_batch'=>'Required',
            
        );
        return $validator = Validator::make($inputs,$rules);
    }
    public static function GetFeePartFull($val)
    {
        $couseDetails=  Course::where('Deleted','=',0)
                        ->where('CourseListCode','=',$val)
                        ->first();
        if(count($couseDetails)>0)
        {
            return $couseDetails->CourseType;
        }
        else
        {
            return '';
        }
    }
    public function getInstitution()
    {
        return $this->belongsTO('Institute','instId');
    }
    public function getOrganisation()
    {
        return $this->belongsTO('Organisation','OrgId');
    }

    public static function getDuration($clc){
        return Course::where('CD_ID','=',$clc)->where('Deleted','=',0)->pluck('Duration');
    }
    
    public static function getOrganizatinName($x) {
        return Organisation::where('id', '=', $x)->pluck('OrgaName');
    }
	 public static function getCName($clc){
        return Course::where('CD_ID','=',$clc)->where('Deleted','=',0)->pluck('CourseName');
    }
}
