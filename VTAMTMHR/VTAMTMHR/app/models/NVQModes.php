<?php

class NVQModes extends Eloquent
	{


		protected  $table = 'NVQmodes';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded=true;
        }

        ?>