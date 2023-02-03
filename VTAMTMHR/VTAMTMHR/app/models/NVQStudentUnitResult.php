<?php

class NVQStudentUnitResult extends Eloquent
{
    
    
		protected  $table = 'nvqstudentunitresult';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false; 



		 public static function GetUnitResult($TraineeId, $UnitID,$FinalExamAssessmentNo) {
        $Result = NVQStudentUnitResult::where('StudentId', '=', $TraineeId)
                 ->where('UnitId','=',$UnitID)
                 ->where('FinalExamAssessmentNo','=',$FinalExamAssessmentNo)
                 ->where('Deleted', '!=', 1)
                ->pluck('result');
        return $Result;
    }

    public static function GetPackageAvailable($TraineeId,$CSID) {
        $Result = NVQStudentPackage::where('T_ID', '=', $TraineeId)
                    ->where('CS_ID','=',$CSID)
                 ->where('Deleted', '!=', 1)
                ->get();
        return $Result;
    }

    
}
