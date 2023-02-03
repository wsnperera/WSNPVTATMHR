<?php


	class NVQAssessorWorkingPlace extends Eloquent
	{


		protected  $table = 'assessorworkingplace';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

	    public static function validate($inputs)
	    {
	        $rules = array  ( 
	            'WorkingPlaceName' => 'Required',
	            'WorkingPlaceAddress' => 'Required'
	        );
	        return $validator = Validator::make($inputs,$rules);
	    }
	}


?>