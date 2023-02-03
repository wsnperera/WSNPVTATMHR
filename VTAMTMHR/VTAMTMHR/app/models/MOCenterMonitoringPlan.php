<?php
class MOCenterMonitoringPlan extends Eloquent
{
    protected  $table = 'mocentremonitoringplan';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;
    
    public static function validate($inputs)
    {
        $rules = array  ( 
            'ModuleName' => 'Required',
        );
        return $validator = Validator::make($inputs,$rules);
    }
	
	public static function getEndDate($startdate,$duration)
	{
		
		$sql78 = "SELECT DATE_SUB(DATE_ADD('$startdate', INTERVAL '$duration' MONTH),INTERVAL 2 DAY) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
		  return $expectedcom;
	}
	public static function getPackages($CD_ID)
	{
		
		$sql78 = "select nvqqualificationpackage.packagecode
  from coursedetailpackages
  left join nvqqualificationpackage
  on coursedetailpackages.NVQualificationPackageID=nvqqualificationpackage.id
  where coursedetailpackages.CD_ID='".$CD_ID."'
  and coursedetailpackages.Deleted=0";
          $newdu = DB::select(DB::raw($sql78));
          
		  return $newdu;
	}
	public static function getMonitoringDates($CYID)
	{
		
	$sql78 = "select mocentremonitoringplan.DatePlanned,mocentremonitoringplan.Approved,mocentremonitoringplan.Visited,employee.Initials,employee.LastName
	  from mocentremonitoringplan
	   left join employee
  on mocentremonitoringplan.EmpId=employee.id
	  where mocentremonitoringplan.Deleted=0
	  and mocentremonitoringplan.CourseYearPlanID='".$CYID."'
	  order by mocentremonitoringplan.DatePlanned";
          $newdu = DB::select(DB::raw($sql78));
          
		  return $newdu;
	}
	public static function getTotalAverageMarks($CYID,$tempStartDate,$tempEndDate)
	{
		
	$sql78 = "select ROUND(AVG(momonitoringresult.FullMark),0) as dd
	  from mocentremonitoringplan
	  left join momonitoringresult
	  on mocentremonitoringplan.id=momonitoringresult.CMPlanID
	  and momonitoringresult.Deleted=0
	   where mocentremonitoringplan.Deleted=0
	  and mocentremonitoringplan.Visited=1
	  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
      and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
	  and mocentremonitoringplan.CourseYearPlanID='".$CYID."'
	  ";
	  
          $newdu = DB::select(DB::raw($sql78));
		   $newdata =  json_decode(json_encode((array)$newdu),true);
          $avgt = $newdata[0]["dd"];
          
		  return $avgt;
	}
	
}