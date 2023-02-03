<?php
class Institute extends Eloquent
{
    protected  $table = 'institution';  // define your table name here
    protected $primaryKey = 'InstituteId'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded=true;
    public static function validate($inputs)
    {
        $rules = array
        ( 
            'InstituteName' => 'Required|alpha_spaces',
            'InstituteAddress' => 'Required',
            'HeadName' => 'Required|alpha_spaces',
            'designation' => 'Required',
            'InstituteTele1' => 'Required|numeric|digits:10',
            'InstituteTele2' => 'numeric|digits:10',
            'InstituteEmail' => 'Required|Email',
            'InstituteDistrict' => 'Required|alpha',
            'InstituteCountry' => 'Required',
        );
        $em=array(
            'InstituteName.required'=>'Institute Name Must Be Filled',
            'InstituteName.alpha'=>'Institute Name Must Be Characters',
            'InstituteAddress.required'=>'Institute Address Must Be Filled');


        return $validator = Validator::make($inputs, $rules);
    }
}
?>
