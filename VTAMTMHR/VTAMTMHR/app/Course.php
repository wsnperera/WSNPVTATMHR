<?php


	class Course extends Eloquent

	{


		protected  $table = 'coursedetails';  // define your table name here
		protected $primaryKey = 'CD_ID'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded = true;
                
                
                
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'InstituteId' => 'Required',
                        'CourseListCode' => 'Required|unique:coursedetails,CourseListCode',
                        'CourseName' => 'Required',
                        'CourseType' => 'Required',
                        'Duration' => 'Required',
                        'Medium' => 'Required',
                        'TradeId' => 'Required',
                        'CourseLevel' => 'Required',
                        'Nvq' => 'Required',
                        'ProgramType' => 'Required',
                        'Qualification_ID' => 'Required'
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }
                        
		
		public function Institue()
                {
                        
			// define relationship
                        return $this->belongsTo("Institue","InstituteId");
                        
			
                }
				
				
                public function coursedetail()
                {
                    return $this->belongsTo("batchstart","BS_ID");
                }
                
                
                
                


	}


?>