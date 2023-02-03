<?php

class LogData extends Eloquent
{
    
    protected $table = 'Log';
    protected  $primaryKey = 'LogID';
    public $timestamps = false;
    public $ungarded = true;
    
    
    
        public function ActivityType()
       {

			// define relationship
                return $this->belongsTo("ActivityType","activityID");
			
	}
        
         public function log()
       {

			// define relationship
                return $this->belongsTo("User","userID");
			
	}
        
        
    
}
