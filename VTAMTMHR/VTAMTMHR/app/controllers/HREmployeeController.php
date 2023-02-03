<?php

class HREmployeeController extends BaseController {
	
	public function HrEmployeepersonalfileCompleted()
	{
		$ID = Input::get('id');
		//$empid = User::getSysUser()->EmpId;
		$HREmployee = HREmployee::where('id','=',$ID)
		->update(array('PersonalFileCompleted' => '1'));
     return 1;
	}
	
	public function AddHREmployeeEPF()
	{
		$id = Input::get('id');
		$EPF = Input::get('EPF');
		$Availavble = HREmployeeEPFHistory::where('EmpId','=',$id)->where('EPFNo','=',$EPF)->where('Deleted','=',0)->get();
		$update = HREmployeeEPFHistory::where('EmpId','=',$id)->where('Deleted','=',0)->update(array('Active' => 0));
		if(count($Availavble) == 0)
		{
			$c = new HREmployeeEPFHistory();
			$c->EmpId = $id;
			$c->EPFNo = $EPF;
			$c->Active = 1;
			$c->User = User::getSysUser()->userID;
			$c->save(); 
			$updateEmployee = HREmployee::where('id','=',$id)->update(array('EPFNo' => $EPF));
		}
		else
		{
			$updateactive = HREmployeeEPFHistory::where('EmpId','=',$id)->where('EPFNo','=',$EPF)->where('Deleted','=',0)->update(array('Active' => 1));
			$updateEmployee = HREmployee::where('id','=',$id)->update(array('EPFNo' => $EPF));
		}
		
		return 1;
	}
	
	public function AddHREmployeeNIC()
	{
		$id = Input::get('id');
		$NIC = Input::get('NIC');
		
		$available = HREmployeeNICHistory::where('EmpId','=',$id)->where('Deleted','=',0)->where('NIC','=',$NIC)->get();
		$update = HREmployeeNICHistory::where('EmpId','=',$id)->where('Deleted','=',0)->update(array('Active' => 0));
		if(count($available) == 0)
		{
			
			$c = new HREmployeeNICHistory();
			$c->EmpId = $id;
			$c->NIC = $NIC;
			$c->Active = 1;
			$c->User = User::getSysUser()->userID;
			$c->save();
			
			$getCurrentNIC = HREmployee::where('id','=',$id)->pluck('NIC');
			$UpdateOLDNIC = HREmployee::where('id','=',$id)->update(array('OldNIC' => $getCurrentNIC,'NIC' => $NIC));
			
		}
		else
		{
			$updateactive = HREmployeeNICHistory::where('EmpId','=',$id)->where('NIC','=',$NIC)->where('Deleted','=',0)->update(array('Active' => 1));
			$getCurrentNIC = HREmployee::where('id','=',$id)->pluck('NIC');
			$UpdateOLDNIC = HREmployee::where('id','=',$id)->update(array('OldNIC' => $getCurrentNIC,'NIC' => $NIC));
		}
		return 1;
	}
	
	public function DeleteHREmployee()
	{
		$cid = Input::get('id');
        $Employee = HREmployee::findOrFail($cid);
        $Employee->Deleted = 1;
		$Employee->User = User::getSysUser()->userID;
        $Employee->save();
        $DeletedPromotion = HRPromotion::where('Emp_ID','=',$cid)->update(array('Deleted' => 1,'User' => User::getSysUser()->userID));
        $DeletedEPFHistory = HREmployeeEPFHistory::where('EmpId','=',$cid)->update(array('Deleted' => 1,'User' => User::getSysUser()->userID));
		$DeleteNICHistory = HREmployeeNICHistory::where('EmpId','=',$cid)->update(array('Deleted' => 1,'User' => User::getSysUser()->userID));
      
        return Redirect::to('ViewHREmployee');
	}
	
	public function HRPhotoEdit() {
        $method = Request::getMethod();
        // $filename = str_random(12);
        $file = Input::file('Photograph');
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $date = date('Ymd/h:i:s/a');
        $fullname = Str::slug($date . $filename) . '.' . $extension;
        $destinationPath = 'assets/employee/';
        $upload_success = $file->move($destinationPath, $fullname);
        // $path = $file->getRealPath();
        if ($method == 'POST') {
            $id = Input::get('id');
            $i = HREmployee::find($id);
            $i->Photograph = $upload_success;
            $i->save();
            return Redirect::to('ViewHREmployee');
        }
    }
	
	 public function EditHREmployee() {
        switch (Request::getMethod()) {
            case 'GET':
                $view = View::make('HREmployee.EditEmployee');
                $id = Input::get('cid');
                $view->Employee = HREmployee::where('id', '=', $id)->first();
                $view->user = User::getSysUser();
                $ins = User::getSysUser()->instituteId;
                $view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
                $view->in_id = $ins;
                $view->holidaytypes = District::orderBy('DistrictName')->get();
                $electoratecode_emp = HREmployee::where('id', '=', $id)->pluck('DistrictName');
                $view->Electorate = Electorate::where('DistrictCode', "=", $electoratecode_emp)->orderBy('ElectorateName')->get();
                $view->trade = Trade::where('Deleted', '!=', 1)->orderBy('TradeName')->get();
				$view->Courses = HREmployeeTradeCourse::where('Deleted','=',0)->orderBy('CourseName')->get();
                return $view;
                break;

            case 'POST':
                $validator = HREmployee::validateEdit(Input::all());
                if ($validator->passes()) {
                    $id = Input::get('id');
                    $i = HREmployee::find($id);
                    $i->Changed = 1;
					
					$existNIC = HREmployee::where('id','=',$id)->pluck('NIC');
					$existOldNIC = HREmployee::where('id','=',$id)->pluck('OldNIC');
					$existEPFNo = HREmployee::where('id','=',$id)->pluck('EPFNo');
					if($existNIC != Input::get('NIC'))
					{
						$i->NIC = Input::get('NIC');
						if($existOldNIC == $existNIC)
						{
							$i->OldNIC = Input::get('NIC');
						}
						
						$updateINNICHistory = HREmployeeNICHistory::where('EmpId','=',$id)->where('NIC','=',$existNIC)->update(array('NIC' => Input::get('NIC')));
						$updatePromotion = HRPromotion::where('Emp_ID','=',$id)->where('NIC','=',$existNIC)->update(array('NIC' => Input::get('NIC')));
					}
					if($existEPFNo != Input::get('EPFNo'))
					{
						$i->EPFNo = Input::get('EPFNo');
						$updateEPFPromotion  = HRPromotion::where('Emp_ID','=',$id)->where('EPF','=',$existEPFNo)->update(array('EPF' => Input::get('EPFNo')));
						$updateEPFHistory = HREmployeeEPFHistory::where('EmpId','=',$id)->where('EPFNo','=',$existEPFNo)->update(array('EPFNo' => Input::get('EPFNo')));
					}
					 $HTD['LastName'] = Input::get('LastName');
                     $HTD['Name'] = Input::get('Name');
                     $HTD['Initials'] = Input::get('Initials');
					$i->InstituteId = Input::get('InstituteId');
					$i->LastName = $HTD['LastName'];
					$i->Initials = $HTD['Initials'];
					//trade course
					$UniID = Input::get('QO_ID');
                if (HREmployeeTradeCourse::where('Deleted', '!=', 1)->where('id', '=', $UniID)->count() < 1) {
                    $QO = new HREmployeeTradeCourse;
                    $QO->CourseName = Input::get('QO_ID');
					$QO->TradeId = Input::get('Trade');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HREmployeeTradeCourse::where('Deleted', '!=', 1)->where('CourseName', '=', Input::get('QO_ID'))->pluck('id');
                    $i->TradeCourseId = $newQO_ID;
                } else {
                    $i->TradeCourseId = Input::get('QO_ID');
                }
				//trade course
					$i->Name = $HTD['Name'];
					$i->Sex = Input::get('Sex');
					$i->DOB = Input::get('DOB');
					$i->CivilStatus = Input::get('CivilStatus');
					$i->Race = Input::get('Race');
					$i->Religion = Input::get('Religion');
					$i->BloodGroup = Input::get('BloodGroup');
					$i->PassportNo = Input::get('PassportNo');
					$i->ExpiryDate = Input::get('ExpiryDate');
					$i->PAddress = Input::get('PAddress');
					$i->CAddress = Input::get('CAddress');
					$i->DistrictName = Input::get('DistrictName');
					$i->DSDivision = Input::get('DSDivision');
					$i->Contact = Input::get('Contact');
					$i->Mobile = Input::get('Mobile');
					$i->Email = Input::get('Email');
					$i->OContact = Input::get('OContact');
					$i->OMobile = Input::get('OMobile');
					$i->OEmail = Input::get('OEmail');
					$i->EmergencyName = Input::get('EmergencyName');
					$i->Emergency = Input::get('Emergency');
					$i->Trade = Input::get('Trade');
					$i->TravelMode = Input::get('TravelMode');
					//$i->Items_P_by_C = Input::get('Items_P_by_C');
					$i->User = User::getSysUser()->userID;
					$i->OrgId = User::getSysUser()->organisationId;
					$i->save();
                        return Redirect::to('ViewHREmployee');
                    
                } else {
                    return Redirect::to('EditHREmployee?cid=' . Input::get('id'))->withErrors($validator);
                }
                break;
            default:
        }
    }
	
	  public function HRloadNicAjaxDetails(){
        $nic = Input::get('nic');
		$getEmpID = HREmployeeNICHistory::where('NIC','=',$nic)->where('Deleted','=',0)->pluck('EmpId');
        $appl = HREmployee::where('Deleted', '!=', 1)->where('id', '=', $getEmpID)->first();
        $EPFNo = $appl->EPFNo;
        $LastName = $appl->LastName;
        $Initials = $appl->Initials;
        $Name = $appl->Name;
        $DOB = $appl->DOB;
        $CivilStatus = $appl->CivilStatus;
        $PAddress = $appl->PAddress;
        $Mobile = $appl->Mobile;
        $Race = $appl->Race;
        $Religion = $appl->Religion;
        $BloodGroup = $appl->BloodGroup;
        $PassportNo = $appl->PassportNo;
        $CAddress = $appl->CAddress;
        $DistrictName = $appl->DistrictName;
        $DSDivision = $appl->DSDivision;
        $Contact = $appl->Contact;
        $Email = $appl->Email;
        $OContact = $appl->OContact;
        $OMobile = $appl->OMobile;
        $OEmail = $appl->OEmail;
		//$DSDivision = $appl->DSDivision;
        $dale ='';
       echo $EPFNo . '|#|' . $LastName . '|#|' . $Initials . '|#|' . $Name .'|#|' . $DOB . '|#|' . $CivilStatus . '|#|' . $PAddress . '|#|' . $Mobile  .'|#|' . $Race  .'|#|' . $Religion  .'|#|' . $BloodGroup  .'|#|' . $PassportNo  .'|#|' . $CAddress  .'|#|' . $DistrictName  .'|#|' . $DSDivision  . '|#|' . $Contact  .'|#|' . $Email  .'|#|' . $OContact  .'|#|' . $OMobile  .'|#|' . $OEmail . $dale;
  }
	
	public function CreateHREmployee()
	{
        $view = View::make('HREmployee.CreateEmployee');
        $method = Request::getMethod();
        $view->user = User::getSysUser();

        if ($method == 'GET') {

            $ins = User::getSysUser()->instituteId;
            $org = User::getSysUser()->organisationId;
          
            $view->in_id = $ins;
            $view->holidaytypes = District::orderBy('DistrictName')->get();
            $view->trade = Trade::where('Deleted', '!=', 1)->orderBy('TradeName')->get();
			$Electorate = Electorate::orderBy('ElectorateName')->get();
			$view->Courses = HREmployeeTradeCourse::where('Deleted','=',0)->orderBy('CourseName')->get();
			$view->Electorate = $Electorate;
            return $view;
        }
        if ($method == 'POST') {
            $validator = HREmployee::validateCreate(Input::all());
            if ($validator->passes()) {
                $file = Input::file('Photograph');
                if (!empty($file)) {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $date = date('Ymd/h:i:s/a');
                    $fullname = Str::slug($date . $filename) . '.' . $extension;
                    $destinationPath = 'assets/employee/';
                    $upload_success = $file->move($destinationPath, $fullname);
                }
                $HDT = new HREmployee();
				
				 $UniID = Input::get('QO_ID');
                if (HREmployeeTradeCourse::where('Deleted', '!=', 1)->where('id', '=', $UniID)->count() < 1) {
                    $QO = new HREmployeeTradeCourse;
                    $QO->CourseName = Input::get('QO_ID');
					$QO->TradeId = Input::get('Trade');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HREmployeeTradeCourse::where('Deleted', '!=', 1)->where('CourseName', '=', Input::get('QO_ID'))->pluck('id');
                    $HDT->TradeCourseId = $newQO_ID;
                } else {
                    $HDT->TradeCourseId = Input::get('QO_ID');
                }
				
                $HTD['LastName'] = Input::get('LastName');
                $HTD['Name'] = Input::get('Name');
                $HTD['Initials'] = Input::get('Initials');
                if (!empty($file)) {
					
                    $HDT->Photograph = $upload_success;
                }
                $HDT->NIC = Input::get('NIC');
				$HDT->OldNIC = Input::get('NIC');
                $HDT->InstituteId = Input::get('InstituteId');
                $HDT->EPFNo = Input::get('EPFNo');
                $HDT->LastName = $HTD['LastName'];
                $HDT->Initials = $HTD['Initials'];
                $HDT->Name = $HTD['Name'];
                $HDT->Sex = Input::get('Sex');
                $HDT->DOB = Input::get('DOB');
                $HDT->CivilStatus = Input::get('CivilStatus');
                $HDT->Race = Input::get('Race');
                $HDT->Religion = Input::get('Religion');
                $HDT->BloodGroup = Input::get('BloodGroup');
                $HDT->PassportNo = Input::get('PassportNo');
                $HDT->ExpiryDate = Input::get('ExpiryDate');
                $HDT->PAddress = Input::get('PAddress');
                $HDT->CAddress = Input::get('CAddress');
                $HDT->DistrictName = Input::get('DistrictName');
                $HDT->DSDivision = Input::get('DSDivision');
                $HDT->Contact = Input::get('Contact');
                $HDT->Mobile = Input::get('Mobile');
                $HDT->Email = Input::get('Email');
                $HDT->OContact = Input::get('OContact');
                $HDT->OMobile = Input::get('OMobile');
                $HDT->OEmail = Input::get('OEmail');
                $HDT->EmergencyName = Input::get('EmergencyName');
                $HDT->Emergency = Input::get('Emergency');
                $HDT->Trade = Input::get('Trade');
                $HDT->TravelMode = Input::get('TravelMode');
                $HDT->Items_P_by_C = Input::get('Items_P_by_C');
				//$HDT->Photograph = $fullname;
                $HDT->User = User::getSysUser()->userID;
                $HDT->OrgId = User::getSysUser()->organisationId;
				
				$AlraedyExistINNICHistory = HREmployeeNICHistory::where('NIC','=',Input::get('NIC'))->where('Deleted','=',0)->get();
				if(count($AlraedyExistINNICHistory) == 0)
				{ 
					$HDT->save();
					$getEmpId = HREmployee::where('NIC','=',Input::get('NIC'))->where('Deleted','=',0)->where('EPFNo','=',Input::get('EPFNo'))->pluck('id');
					
					$NewHREnic = new HREmployeeNICHistory();
					$NewHREnic->EmpId = $getEmpId;
					$NewHREnic->NIC = Input::get('NIC');
					$NewHREnic->Active = 1;
					$NewHREnic->User = User::getSysUser()->userID;
					$NewHREnic->save();
					
					$NewHREepf = new HREmployeeEPFHistory();
					$NewHREepf->EmpId = $getEmpId;
					$NewHREepf->EPFNo = Input::get('EPFNo');
					$NewHREepf->Active = 1;
					$NewHREepf->User =	User::getSysUser()->userID;				
					$NewHREepf->save();
					
				}
				else
				{
					//$getEmpId = HREmployee::where('NIC','=',Input::get('NIC'))->orWhere('OldNIC','=',Input::get('NIC'))->where('Deleted','=',0)->pluck('id');
					$getEmpId = HREmployeeNICHistory::where('NIC','=',Input::get('NIC'))->where('Deleted','=',0)->pluck('EmpId');
				}
                
                $promotion = HRPromotion::where('Emp_ID', '=', $getEmpId)->where('Deleted','=',0)->count('P_ID');
              
                if ($promotion === 0) {
                    $pr = new HRPromotion;
                    $pr->InstituteId = Input::get('InstituteId');
                    $pr->NIC = Input::get('NIC');
                    $pr->Emp_ID = $getEmpId;
                    $pr->EPF = Input::get('EPFNo');
                    $pr->ToOrganisation = Input::get('OrgId');
                    $pr->TransferType = '1';
                    $pr->CurrentRecord = 'Yes';
                    $pr->Priority = '1';
                    //$pr->DateEntered = \Carbon\Carbon::now();
                    $pr->User = User::getSysUser()->userID;
                    $pr->save();

                    $pid = HRPromotion::where('Emp_ID', '=', $getEmpId)->where('Deleted','=',0)->pluck('P_ID');
                    return Redirect::to('EditHRPromotion?id=' . $pid);
                }

                $ins = User::getSysUser()->instituteId;
                //$view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
                $org = User::getSysUser()->organisationId;
                $view->organization = Organisation::where('id', '=', $org)->pluck('OrgaName');

                $view->in_id = $ins;
                $view->og_id = $org;
                return Redirect::to('CreateHREmployee');
            } else {
                return Redirect::to('CreateHREmployee')->withErrors($validator);
            }
            return $view;
        }
    }
	
	public function ViewHREmployee()
	{
		$v = View::make('HREmployee.Employee');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
        if($userOrgType == 'HO')
		{
			if($UserTypeName == 'HR-MAPF')
			{
											  $Employee = DB::select(DB::raw("select hremployee.*
											  from hremployeeepfhistory
											  left join hremployee
											  on hremployeeepfhistory.EmpId=hremployee.id
											  where hremployeeepfhistory.Deleted=0
											  and hremployee.Deleted=0
											  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
											  from hruserepflist
											  where hruserepflist.Deleted=0
											  and hruserepflist.Active=1
											  and hruserepflist.UserID='".User::getSysUser()->userID."')
											  order by hremployee.PersonalFileCompleted,hremployeeepfhistory.EPFNo"));
			}
			else
			{
				$Employee = HREmployee::where('Deleted', "!=", 1)->orderBy('EPFNo')->get();
			}
			
            
			
        }else if($userOrgType == 'DO'){

           /*  $HOOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'HO')->pluck('OT_ID');
            $NVTIOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'NVTI')->pluck('OT_ID');
            $userOrgDistrictCode = Organisation::where('Deleted', '!=', 1)->where('id', '=', User::getSysUser()->organisationId)->pluck('DistrictCode');
            $ValidOrganisationID = Organisation::where("Deleted", "!=", 1)->where('DistrictCode','=',$userOrgDistrictCode)->where('TypeId','!=',$HOOrgaTypeID)->where('TypeId','!=',$NVTIOrgaTypeID)->lists('id');

            $promotion = Promotion::where("Deleted", "!=", 1)->where("CurrentRecord", "=", "Yes")->whereIn("ToOrganisation", $ValidOrganisationID)->orderBy('ToOrganisation','EPF')->lists('Emp_ID');

            $Employee = Employee::where('Deleted', "!=", 1)->whereIn('id',$promotion)->get(); */
			$Employee='';
        }else {
            /* $proUser = Promotion::where('Deleted','!=',1)->where('CurrentRecord','=','Yes')->where('ToOrganisation','=',$userOrgId)->lists('Emp_ID');
             $Employee = Employee::where('Deleted', "!=", 1)->whereIn('id',$proUser)->get(); */
			 $Employee='';
        }
        $v->user = User::getSysUser();
        $v->userOrgType = $userOrgType;
        $v->Employee = $Employee;
        return $v;
	}

}