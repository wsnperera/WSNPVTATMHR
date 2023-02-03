<?php


class NvqStudentQualification extends Eloquent 
{
   
		protected  $table = 'nvqstudentqualification';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded = true;
                
               
                
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'StudentId' => 'Required|unique',
                    
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }  
                
    public static function getname($id,$mode){
        if($mode=='RPL'){
        $name=Nvqrplapplication::where('id','=',$id)->first();
        return $name->NameWithInitials;
          }

        if($mode=='Enterprise'){
        $name=NCTrainee::where('ApplicantId','=',$id)->first();
        return $name->NameWithInitials;
          }

        if($mode=='CBT'){
        $name=Trainee::where('Training_No','=',$id)->first();
        return $name->NameWithInitials;
          }
    }            
        
    
   
    
}

?>