<?php


	class NVQAssessorNomination extends Eloquent
	{


		protected  $table = 'assessornomination';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

	   
	}


?>