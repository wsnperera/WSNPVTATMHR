<?php


	class NVQAssessmentSchedule extends Eloquent
	{


		protected  $table = 'assessmentschedule';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;
	}


?>