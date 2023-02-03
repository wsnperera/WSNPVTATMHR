<?php


class Institue extends Eloquent
{
    
    
		protected  $table = 'institution';  // define your table name here
		protected $primaryKey = 'InstituteId'; // define Table primary key
		public $timestamps = false; 
                
                public function Courses()
                {
                   return $this->hasMany("Course","InstituteId");
                   
                   
                }
                 public function Batch()
                {
                    return $this-> hasMany("Batchstart","InstituteId");
                }
                   public function Coursestarted()
                {
                   return $this->hasMany("Coursestarted","InstituteId");
                   
                   
                } 
				  public function Employee()
                {
                   return $this->hasMany("Employee","InstituteId");
                   
                   
                } 

}

?>
