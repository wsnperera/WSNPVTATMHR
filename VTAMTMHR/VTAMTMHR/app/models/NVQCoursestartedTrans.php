<?php


	class NVQCoursestartedTrans extends Eloquent
	{


		protected  $table = 'nvqcoursestartedtrans';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

       public static function CenterConfirmResult($CSID)
       {
       		$Result = NVQCoursestartedTrans::where('CS_ID','=',$CSID)
					    ->where('Deleted','=',0)
					    ->where('TVECSend','=',1)
					    ->pluck('CenterConfirmResult');
        return $Result;
       }
       public static function ProvinceConfirmResult($CSID)
       {
       		$Result = NVQCoursestartedTrans::where('CS_ID','=',$CSID)
					    ->where('Deleted','=',0)
					    ->where('TVECSend','=',1)
					    ->pluck('ProvinceConfirmResult');
        return $Result;
       }
	}


?>