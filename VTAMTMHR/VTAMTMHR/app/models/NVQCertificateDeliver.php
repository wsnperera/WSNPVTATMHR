<?php

class NVQCertificateDeliver extends Eloquent
	{


		protected  $table = 'nvqcertificatedelivery';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded=true;
        }