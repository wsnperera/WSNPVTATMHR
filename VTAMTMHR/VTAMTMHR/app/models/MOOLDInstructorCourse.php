<?php
class MOOLDInstructorCourse extends Eloquent
{
    
    
		protected  $table = 'oldmoinstructorcourse';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
        public static $unguarded = true;
                
               
                
}