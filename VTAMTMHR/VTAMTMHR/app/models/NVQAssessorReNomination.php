<?php


	class NVQAssessorReNomination extends Eloquent
	{


		protected  $table = 'assessorrenomination';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

	   
	}


?>