<?php
class MOInstructorCourse extends Eloquent
{
    
    
		protected  $table = 'moinstructorcourse';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
        public static $unguarded = true;
                
               
                
}