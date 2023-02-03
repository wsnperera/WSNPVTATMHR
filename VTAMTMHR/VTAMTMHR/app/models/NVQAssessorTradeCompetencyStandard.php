<?php


	class NVQAssessorTradeCompetencyStandard extends Eloquent
	{


		protected  $table = 'assessortrade';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

        public static function validate($inputs)
	    {
	        $rules = array  ( 
	            'AssessorID' => 'Required',
	            'Name' => 'Required',
	            'HAddress' => 'Required',
	            'HTelephone' => 'Required|numeric|digits:10',
	            'Mobile' => 'Required|numeric|digits:10',
	            'Designation' => 'Required',
	            'M_Code' => 'Required',
	            'WorkingPlace' => 'Required',
	            'Type' => 'Required',
	            'OTelephone' => 'Required|numeric|digits:10',
	            'Note' => 'Required',
	            'TradeId' => 'Required'

	        );
	        return $validator = Validator::make($inputs,$rules);
	    }
	}


	


?>