<?php
class QualificationOrganisation extends Eloquent
	{


		protected  $table = 'qualificationorganisation';  // define your table name here
		protected $primaryKey = 'QO_ID'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded=true;
                
                

    public static function validate($inputs)
    {
$rules= array(

    'OrgaName'=>'Required|unique:qualificationorganisation',
    'instituteId'=>'',
   
);
$ms=array(
    'OrgaName.required'=>'Organisation Name must be a required field'
    
  );  

 return $validator=Validator::make($inputs,$rules,$ms);
                
        }
         public static function validateedit($inputs)
    {
$rules= array(

    'OrgaName'=>'Required',
    'instituteId'=>'',
   
);
$ms=array(
    'OrgaName.required'=>'Organisation Name must be a required field'
    
  );  

        return $validator=Validator::make($inputs,$rules,$ms);
                
        }
        
        public function getInstitute()
        {
            return $this->belongsTO('Institute','instituteId');
        }
          
    
        }