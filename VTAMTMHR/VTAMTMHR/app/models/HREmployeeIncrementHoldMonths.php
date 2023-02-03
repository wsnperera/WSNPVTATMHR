<?php

class HREmployeeIncrementHoldMonths extends Eloquent {

    protected $table = 'hremployeeincrementholdmonths';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
     public static function GetMonths($TID)
    {
	    $ans = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',$TID)->where('Deleted','=',0)->orderBy('id')->get();
	    return $ans;
    }
	public static function checkmonth($id,$MonthNo)
	{
		$ans = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',$id)->where('Deleted','=',0)->where('MonthNo','=',$MonthNo)->get();
		
	    return count($ans);
	}
   
}
