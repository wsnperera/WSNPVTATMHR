<?php


class EntryQualification extends Eloquent
{
         protected  $table = 'qualification';  // define your table name here
		 protected $primaryKey = 'Qualification_ID'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;

		
		public function Institue()
                {
                        
			// define relationship
                        return $this->belongsTo("Institue","InstituteId");
                       
			
                }
                public function Organisation()
                {
                        
			// define relationship
                        return $this->belongsTo("Organisation","OrganisationId");
                       
			
                }
                
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'InstituteId' => 'Required|numeric',
                        'OrganisationId' => 'Required|numeric',
                         'Qualification' => 'Required'
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }
}

?>
