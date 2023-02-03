<?php
class MODateTask extends Eloquent
{
    protected  $table = 'modatetask';  // define your table name here
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public static $unguarded=true;

    public static function GETWEEKSESSIONModule($year,$batch,$CDID,$WEEKNo,$sessionNo,$day,$MONTHID,$CalenderYear)
    {

    	$getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CDID)->pluck('CourseListCode');
    	$sql = "select  modatetask.TaskSeqID,motask.TaskName,motask.TaskCode
                                  from modatetask
                                  left join modatecalender
                                  on modatetask.MODateCalenderID=modatecalender.id
                                  left join motaskseq
                                  on modatetask.TaskSeqID=motaskseq.id
                                  left join motask
                                  on motaskseq.taskid=motask.id
                                  where modatetask.Deleted=0
                                  and modatetask.Year='".$year."'
                                  and modatetask.Batch like '".$batch."'
                                  and modatetask.CD_ID='".$CDID."'
                                  and modatecalender.WeekNo='".$WEEKNo."'
								  and modatecalender.Year = '".$CalenderYear."'
                                  and modatecalender.Session='".$sessionNo."'
								  and modatecalender.Month='".$MONTHID."'
                                  and modatecalender.Day='".$day."'";
        $ddMONS1 = DB::select(DB::raw($sql));
        return $ddMONS1;
    }

    public static function IFHOLIDAY($year,$batch,$CDID,$WEEKNo,$day,$CalenderYear)
    {
      $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CDID)->pluck('CourseListCode');
       $sql = "select  modatetask.TaskSeqID
                                  from modatetask
                                  left join modatecalender
                                  on modatetask.MODateCalenderID=modatecalender.id
                                  left join motaskseq
                                  on modatetask.TaskSeqID=motaskseq.id
                                  left join motask
                                  on motaskseq.taskid=motask.id
                                  where modatetask.Deleted=0
                                  and modatetask.Year='".$year."'
                                  and modatetask.Batch like '".$batch."'
                                  and modatetask.CD_ID='".$CDID."'
                                  and modatecalender.WeekNo='".$WEEKNo."'
								  and modatecalender.Year = '".$CalenderYear."'
                                  and modatecalender.day='".$day."'
                                 ";
      $ddMONS1 = DB::select(DB::raw($sql));
      return count($ddMONS1);


    }

    public static function weekFrom($year,$week,$month,$CalenderYear)
    {
        $WeekFrom = "";
        $sql = "select modatecalender.Date
        from modatecalender
        where modatecalender.Deleted=0
		and modatecalender.Active=1
        and modatecalender.Year='".$CalenderYear."'
        and modatecalender.WeekNo='".$week."'
        and modatecalender.Month='".$month."'
		
        order by modatecalender.Date asc
        limit 1";
        $date = DB::select(DB::raw($sql));
                if(!empty($date))
                {
                  $ss =  json_decode(json_encode((array)$date),true);
                  
                  $WeekFrom = $ss[0]["Date"];
                }

      return $WeekFrom;
    }
    public static function weekTo($year,$week,$month,$CalenderYear)
    {
        $WeekTo = "";
        $sql = "select modatecalender.Date
        from modatecalender
        where modatecalender.Deleted=0
		and modatecalender.Active=1
        and modatecalender.Year='".$CalenderYear."'
        and modatecalender.WeekNo='".$week."'
        and modatecalender.Month='".$month."'
		
        order by modatecalender.Date desc
        limit 1";
        $date = DB::select(DB::raw($sql));
                if(!empty($date))
                {
                  $ss =  json_decode(json_encode((array)$date),true);
                  
                  $WeekTo = $ss[0]["Date"];
                }
        return $WeekTo;
    }
    
    
}