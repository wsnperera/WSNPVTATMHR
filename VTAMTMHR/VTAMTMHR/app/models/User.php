<?php

class User extends Eloquent {

    protected $table = 'user';  // define your table name here
    protected $primaryKey = 'userID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

    public static function getSysUser() {
        return User::where('userID', '=', Session::get('currentUser')->userID)->first();
    }
	public static function getCurrentPromotion() 
	{
		$user=User::find(Session::get('currentUser')->userID);
		return Promotion::where("CurrentRecord", "=", "Yes")->where("Emp_ID", "=", $user->EmpId)->first();
	}
    public static function getSysUserOrg() {
        return User::where('userID', '=', Session::get('currentUser')->userID)->pluck('organisationId');
    }
    public static function getSysUserType() {
        return User::where('userID', '=', Session::get('currentUser')->userID)->pluck('userType');
    }
     public static function getSysUserEmpId() {
        return User::where('userID', '=', Session::get('currentUser')->userID)->pluck('EmpId');
    }
    public function Institute() {
        return $this->hasOne('Institute', 'User');
    }

    public function Organisation() {
        return $this->hasMany('Organisation', 'User');
    }

    public function Department() {
        return $this->hasMany('Department', 'User');
    }

    public function TransferType() {
        return $this->hasMany('TransferType', 'User');
    }

    public function getIns() {
        return $this->hasOne('Institue', 'instituteId');
    }

    public function getOrg() {
        return $this->hasOne('Organization', 'organisationId');
    }

    public function getEmployee() {
        return $this->belongsTo('Employee', 'EmpId', 'id');
    }

    public function getInstitution() {
        return $this->belongsTo('Institute', 'instituteId', 'InstituteId');
    }

    public function getOrganization() {
     return $this->belongsTo('Organization', 'organisationId', 'id');
//	return json_encode(array("Type"=>"HO"));
    }
 public function getOrganisation() {
      return $this->belongsTo('Organisation', 'organisationId', 'id');
	$object = new stdClass();
	$object->Type = "HO";var_dump($object);return $object;
        $abc = DB::select(DB::raw("select organisationtype.* from organisation left join organisationtype on organisation.TypeId = organisationtype.OT_ID"));
return $abc[0];
    }


    public function getActivities() {
        return $this->hasMany('UserRole', 'userid', 'userID');
    }
/*	public static function setCache()
    {
        $arrayRouteName=array();
        $userrole=DB::select('select a.routename rn from userrole ur,activity a where a.activityid=ur.activityid and a.Deleted=0 and ur.Deleted=0 and ur.userid='.Session::get('currentUser')->userID.'');
        foreach($userrole as $ur)
        {
            $arrayRouteName[]=$ur->rn;
        }
        Cache::forever(Session::get('currentUser')->userID, $arrayRouteName);
    }*/

public static function setCache()
    {
        $arrayRouteName=array();
        $userrole=DB::select('select a.routename rn from userrole ur,activity a where a.activityid=ur.activityid and a.Deleted=0 and ur.Deleted=0 and ur.userid='.Session::get('currentUser')->userID.'');
        foreach($userrole as $ur)
        {
            $arrayRouteName[]=$ur->rn;
        }
        Cache::forever(Session::get('currentUser')->userID, $arrayRouteName);
    }
    public static function hasPermission($route = null) 
    {
        if(Cache::has(Session::get('currentUser')->userID))
        {
            $activity=Cache::get(Session::get('currentUser')->userID);
            if(is_array($route))
            {
                foreach($route as $r)
                {
                    if(in_array($r, $activity))
                    {
                        return true;
                    }
                }
            }
            elseif(in_array($route, $activity))
            {
                    return true;
            }
        }
        return false;
    }
    /* public static function hasPermission($route = null) {
		//return true;
        if(Cache::has(Session::get('currentUser')->userID))
        {
            $activity=Cache::get(Session::get('currentUser')->userID);
            if(is_array($route))
            {
                foreach($route as $r)
                {
                    if(in_array($r, $activity))
                    {
                        return true;
                    }
                }
            }
            elseif(in_array($route, $activity))
            {
                    return true;
            }
        }
        return false;
    }
*/
    public static function validate($inputs) {
        $rules = array (
            'EmpId' => 'Required|unique:user',
            'userName' => 'Required|unique:user',
            'passWord' => 'Required',
            'userType' => 'Required',
			'CenterID' => 'Required',
                //'PartTime' => 'Required',
                //'PublicIn' => 'Required',
        );
       return $validator = Validator::make($inputs, $rules);
    }
    public function getOrga(){
        return $this->belongsTo("Organisation", "organisationId");
    }

}

?>
