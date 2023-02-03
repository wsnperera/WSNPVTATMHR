<?php

class UserController extends BaseController {
	
	public function loadempcentersin()
	{
		
		$EmpId = Input::get('EmpId');
		
   
	  
	  $sql = DB::select(DB::raw("select organisation.id,organisation.OrgaName,organisation.Type
  from employee
  left join organisation
  on employee.CurrentOrgaID=organisation.id
  where employee.NIC='".$EmpId."'
  and employee.Deleted=0
  and organisation.Deleted=0
 "));
	  
	  return json_encode($sql);
	}

    public function viewUsers() {
        $orgaId = User::getSysUser()->organisationId;
        $orgaType = Organisation::where('id','=',$orgaId)->pluck('Type');
        $discode = Organisation::where('id','=',$orgaId)->pluck('DistrictCode');
        if($orgaType == 'HO')
        {
            
                $sql  = "select user.*,organisation.OrgaName,employee.Initials,employee.LastName,usertype.UType,user.UserDivision
from user
  left join organisation
  on user.organisationId=organisation.id
  left join employee
  on user.EmpId=employee.id
  left join usertype
  on user.userType=usertype.id
where user.Deleted=0
order by active DESC
 ";

        }
        elseif($orgaType == 'DO')
        {
                $sql = "select user.*
                        from user
                        inner join organisation
                        on user.organisationId=organisation.id
                        inner join organisationtype
                        on organisation.TypeId=organisationtype.OT_ID
                        where user.Deleted=0
                        and organisation.DistrictCode='$discode'
                        and organisationtype.Type NOT IN('HO','NVTI')
                        and organisation.Deleted=0
                        order by active DESC";

        }
        elseif ($orgaType == 'NVTI') 
        {
                $sql = "select user.*
                        from user
                        where user.Deleted=0
                        and User.organisationId='$orgaId'
                        order by active DESC";
          
        }
        else
        {
                $sql = "select user.*
                        from user
                        where user.Deleted=0
                        and User.organisationId='$orgaId'
                        order by active DESC";

        }
       $users = DB::select(DB::raw($sql));
        $v = View::make('User.User');
        $v->users = $users;
        $v->user = User::getSysUser();
        $v->userType=$orgaType;
        return $v;
    }

    public function actionSearch() {

        $v = View::make('User.User');
        $searchKey = Input::get('key');
        $v->users = User::where("userName", "=", $searchKey)->where('active', '!=', 0)->get();
        $v->user = User::getSysUser();
        $v->Issearch = true;
        return $v;
    }

    public function actionDelete() {
        $cid = Input::get('cid');
        $trades = Trade1::find($cid); // if not found show 404 page
        $trades->Deleted = 1;
        $trades->DateEntered = \Carbon\Carbon::now();
        $trades->User = User::getSysUser()->userID;
        $trades->save();
        return Redirect::to('viewTrades');
    }

    public function actionCreate() {
        $method = Request::getMethod();
        if ($method == "GET") {
            $view = View::make('User.Create');
            $view->user = User::getSysUser();
            $view->users = User::where('active', "!=", 0)->get();
            $view->trades = Trade::where('Deleted', '!=', 1)->get();
            $view->usertype = UserType::where('Active', '!=', 'No')->get();
            return $view;
        }
        if ($method == "POST") {
            $validator = User::validate(Input::all());
            if ($validator->passes()) {
				
				//return Input::get("CenterID");
				$UserDivision = Input::get('UserDivision');
				/* if($UserDivision == 'Admin')
				{
				}
				else{ */
					 $employee = Employee::where("NIC", "=", Input::get("EmpId"))->where('CurrentOrgaID','=',Input::get("CenterID"))->where("Deleted","!=",1)->first();
                     $promotion = "";
					 
					  if (!empty($employee)) 
						{
							$existUser = User::where('EmpId','=',$employee->id)->where('organisationId','=',$employee->CurrentOrgaID)->where("Deleted","!=",1)->first();
							if(count($existUser) == 0)
							{
								$updateuser = User::where('userName','=',Input::get("userName"))->update(array('active' => '0'));
								Input::merge(array("EmpId" => $employee->id));
								$c = new User;
								$c->EmpId = $employee->id;
								$c->userName = Input::get("userName");
								$c->userType = Input::get("userType");
								$c->passWord = Hash::make(Input::get('passWord'));
								$c->instituteId = $employee->InstituteId;
								$c->organisationId = $employee->CurrentOrgaID;
								$c->UserDivision = $UserDivision;
								$c->active = 1;
								$c->save();
								$this->userPrevilages($c);
							}
							else
							{
								$c = User::find($existUser->userID);
								$c->active = 1;
								$c->save();
								$this->userPrevilages($c);
								
							}
							
							return Redirect::to('viewUsers');
						} 
						else 
						{
							return Redirect::to('createUser')->withErrors(array("message" => "Employee cannot found"));
						}
				/* } */
               
                
               
            } else {
                return Redirect::to('createUser')->withErrors($validator);
            }
        }
    }

    public function actionEdit() {
        $view = View::make('User.Edit');
        switch (Request::getMethod()) {
            case 'GET':
               // $view->trades = Trade::where('Deleted', '!=', 1)->get();
                $view->users = User::find(Request::get('cid'));
                $view->usertype = UserType::where('Active', '!=', 'No')->get();
                return $view;
            case 'POST':
                $c = User::find(Input::get('UserID'));
                $c->TradeId = Input::get("TradeId");
                $c->userType = Input::get("userType");
				$c->UserDivision = Input::get("UserDivision");
                if ($c->save()) {
                    $this->userPrevilages($c);
                    return Redirect::to('viewUsers');
                }
                break;
            default:
                break;
        }
    }

    public function userPrevilages($user) {
        $defaultUP = UserTypeRole::where('utypeid', '=', $user->userType)->where('Deleted', '!=', 1)->get();
        UserRole::where('userid', '=', $user->userID)->where('Deleted', '!=', 1)->delete();
        foreach ($defaultUP as $DUP) {
            $adduserrole = new UserRole;
            $adduserrole->activityid = $DUP->activityid;
            $adduserrole->userid = $user->userID;
            $adduserrole->permission = 1;
            $adduserrole->Deleted = 0;
            $adduserrole->DateEntered = \Carbon\Carbon::now();
            $adduserrole->User = User::getSysUser()->userID;
            $adduserrole->save();
        }
    }

    public function deactivateUsers() {
        if (Input::get("select") == "deactivate") {
            $user = User::find(Input::get("cid"));
            $user->active = 0;
            $user->save();
            return Redirect::back();
        } else {
            $user = User::find(Input::get("cid"));
            $user->active = 1;
            $user->save();
            return Redirect::back();
        }
    }

    public function deactivateUser($EmployeeID) {
        $sql = "select tt.*,p.* from transfertype as tt join promotion as p on p.TransferType = tt.T_ID "
                . "where p.Emp_ID = '" . $EmployeeID . "' and p.CurrentRecord = 'Yes'";
        $promotion = DB::select($sql);
        if (!empty($promotion) && $promotion[0]->Priority == 1 && $promotion[0]->T_ID != 1) {
            $user = User::where("EmpId", "=", $EmployeeID)->first();
            if (!empty($user)) {
                $userDeactivate = User::find($user->userID);
                $userDeactivate->organisationId = $promotion[0]->ToOrganisation;
                $userDeactivate->active = 0;
                $userDeactivate->save();
                UserRole::where("userid", "=", $user->userID)->delete();
            }
        }
    }

    public function resetPassword() {
        $method = Request::getMethod();
        if ($method == "GET") {
            $view = View::make("User.resetPassword");
            $view->userId = Input::get("cid");
            return $view;
        }
        if ($method == "POST") {
            $userID = Input::get("userID");
            $newPassword = Input::get("newPassWord");
            $error = array();
            if (empty($newPassword)) {
                array_push($error, "New Password and Confirm Password field cannot be empty");
                return Redirect::back()->withErrors($error);
            } else {
                $newUserPassword = User::find($userID);
                $newUserPassword->passWord = Hash::make("$newPassword");
                $newUserPassword->save();
                return Redirect::to("viewUsers")->with("done", true);
            }
        }
    }

     public function actionCreateDO() {
        $method = Request::getMethod();
        if ($method == "GET") {
            $orgaId = User::getSysUser()->organisationId;
            $orgaType = Organisation::where('id','=',$orgaId)->pluck('Type');
           
            $view = View::make('UserDO.createDO');
            $view->UserTypeDN = $orgaType;
            $view->user = User::getSysUser();
            $view->users = User::where('active', "!=", 0)->get();
            $view->trades = Trade::where('Deleted', '!=', 1)->get();
            $view->usertype = UserType::where('Active', '!=', 'No')->get();
            $userdis = Organisation::where('id','=',User::getSysUser()->organisationId)->pluck('DistrictCode');
            $view->employee=Employee::where('OrgId','=',$orgaId)->get();
            if($orgaType == 'DO'){
            $view->orgaList = Organisation::where('DistrictCode','=',$userdis)->where('Type','!=','NVTI')->get();
            }
            else{
            $view->orgaList = Organisation::where('DistrictCode','=',$userdis)->where('Type','=','NVTI')->get();    
            }
            return $view;
        }
        if ($method == "POST") {
            $orgaId = User::getSysUser()->organisationId;
            $orgaType = Organisation::where('id','=',$orgaId)->pluck('Type');

            $validator = User::validate(Input::all());
            if ($validator->passes()) {
                $employee = Employee::where("NIC", "=",'738390636V')->where("Deleted","!=",1)->first();
                $promotion = "";
                if (!empty($employee)) {
                   return $sql = "select * from transfertype as tt join promotion as p on p.TransferType = tt.T_ID "
                            . "where p.Emp_ID = '" . $employee->id . "' and p.CurrentRecord = 'Yes' and tt.Priority = 1";
                    $promotion = DB::select($sql);
                }
                if (!empty($promotion) && $promotion[0]->Available == 1) {
                    Input::merge(array("EmpId" => $employee->id));
                    $c = new User;
                    $c->fill(Input::except("passWord"));
                    $pWD = Input::get('passWord');
                    $c->passWord = Hash::make("$pWD");
                    $c->instituteId = $employee->InstituteId;
                    if($orgaType == 'DO'){
                    $c->organisationId = $employee->OrgId;
                    }
                    if($orgaType == 'NVTI'){
                    $c->organisationId = User::getSysUser()->organisationId;
                    }
                    
                    $c->active = 1;
                    $c->save();
                    $this->userPrevilages($c);
                    return Redirect::to('viewUsers');
                } else {
                    return Redirect::to('createUser')->withErrors(array("message" => "Employee cannot found"));
                }
            } else {
                return Redirect::to('createUser')->withErrors($validator);
            }
        }
    }

    public function getEmployeecreateUserDO(){

    $orgID = Input::get('orgID');
    $employee = Employee::where('Deleted','=',0)->where('OrgId','=',$orgID)->get();

     $abc = '<option>--Select--</option>';
        foreach ($employee  as $emp) {
            $abc .= '<option value=' . $emp->NIC . '>' . $emp->Initials . '.'.$emp->LastName.'</option>';
        }
    

        echo $abc;


    } 

}
