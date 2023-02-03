<?php

class MOQuestion extends Eloquent {

    protected $table = 'moquestions';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;



    public static function getCorrectAnswer($QID)
    {
	    $ans = MOQuestionAnswers::where('QuestionId','=',$QID)
	    ->where('Active','=',1)
	    ->where('AnswerType','=','C')
	    ->where('Order','=',1)
        ->where('Deleted','=',0)
	    ->pluck('Answer');
	    return $ans;
    }
    public static function getWAnswer1($QID)
    {
    	$ans = MOQuestionAnswers::where('QuestionId','=',$QID)->where('Active','=',1)->where('AnswerType','=','W')->where('Order','=',2)->where('Deleted','=',0)->pluck('Answer');
	    return $ans;
    }
    public static function getWAnswer2($QID)
    {
    	$ans = MOQuestionAnswers::where('QuestionId','=',$QID)->where('Active','=',1)->where('AnswerType','=','W')->where('Order','=',3)->where('Deleted','=',0)->pluck('Answer');
	    return $ans;
    }
    public static function getWAnswer3($QID)
    {
    	$ans = MOQuestionAnswers::where('QuestionId','=',$QID)->where('Active','=',1)->where('AnswerType','=','W')->where('Order','=',4)->where('Deleted','=',0)->pluck('Answer');
	    return $ans;
    }
	
	public static function getAllanswers($QID)
	{
		$ans = "select *
				from moquestionanswers
				where moquestionanswers.Deleted=0
				and moquestionanswers.Active=1
				and moquestionanswers.QuestionId='".$QID."'
				order by RAND()";
				$newdu = DB::select(DB::raw($ans));
	    return $newdu;
	}

   
   
}
