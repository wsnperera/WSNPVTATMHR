<?php
	class Events extends Eloquent
	{


		protected  $table = 'event';  // define your table name here
		protected $primaryKey = 'EventId'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded=true;
		
                public function Eventplanned()
                                {
                                    return $this->belongsTo('Eventplanned','EventId');
                                }
                                
        }