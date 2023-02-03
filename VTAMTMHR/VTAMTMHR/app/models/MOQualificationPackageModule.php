<?php
class MOQualificationPackageModule extends Eloquent {
	 protected $table = 'moqualificationpackagemodule';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function getmod($packid,$moduleid)
    {

    	$data = DB::select(DB::raw("select *
  from moqualificationpackagemodule
  where moqualificationpackagemodule.packageid='".$packid."'
  and moqualificationpackagemodule.moduleid='".$moduleid."'
  and moqualificationpackagemodule.Deleted='0'
  and moqualificationpackagemodule.Active='1'"));
    	$count = count($data);

    	return $count;

    }


}
?>