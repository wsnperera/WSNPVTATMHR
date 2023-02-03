<?php


	class NVQAssessorInstitute extends Eloquent
	{


		protected  $table = 'assessorinstitute';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

	    public static function validate($inputs)
	    {
	        $rules = array  ( 
	            'InstituteName' => 'Required',
	            'InstituteAddress' => 'Required'
	        );
	        return $validator = Validator::make($inputs,$rules);
	    }
	}


?>