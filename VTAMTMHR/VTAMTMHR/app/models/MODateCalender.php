<?php


	class MODateCalender extends Eloquent
	{


		protected  $table = 'modatecalender';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

        
	}


	


?>