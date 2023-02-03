<?php

class EmployeeController extends BaseController {

public function EmpPosition() {

        //return "Plz";

        $sql = "SELECT e.*,ec.Designation,i.InstituteName,o.OrgaName,employeetype.EmployeeType,ec.Academic 
                From promotion p 
                LEFT JOIN employee e 
                ON p.Emp_ID=e.id 
                LEFT JOIN employmentcode ec 
                ON ec.id=p.NewPost 
                LEFT JOIN institution i 
                ON e.InstituteId=i.InstituteId 
                LEFT JOIN organisation o 
                ON e.OrgId=o.id 
                LEFT JOIN employeetype 
                on p.EmpType = employeetype.ET_ID
                where p.CurrentRecord='Yes' 
                AND e.Deleted!=1 
                AND p.Deleted!=1 
                AND p.TransferType!='5' 
                AND p.TransferType!='7'  
                ORDER BY ec.Designation";

        $Employee = DB::select(DB::raw($sql));

        $sqldesig = "SELECT ec.Designation 
                        From promotion p 
                        LEFT JOIN employee e 
                        ON p.Emp_ID=e.id 
                        LEFT JOIN employmentcode ec 
                        ON ec.id=p.NewPost 
                        LEFT JOIN institution i 
                        ON e.InstituteId=i.InstituteId 
                        LEFT JOIN organisation o 
                        ON e.OrgId=o.id 
                        where p.CurrentRecord='Yes' 
                        AND e.Deleted!=1 
                        AND p.Deleted!=1 
                        AND p.TransferType!='7' 
                        AND p.TransferType!='5' 
                        GROUP BY p.NewPost 
                        ORDER BY ec.Designation";

        $Designation = DB::select(DB::raw($sqldesig));

        //return $sqldesig;

        $v = View::make('Employee.EmployeePosition');
        $v->Employee = $Employee;
        $v->Designation = $Designation;
        $v->user = User::getSysUser();
        return $v;
    }


  public function viewEmployees() {
        
        $v = View::make('Employee.Employee');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        if($userOrgType === 'HO'){
            $Employee = DB::select(DB::raw("select employee.*,employmentcode.Designation,organisation.OrgaName,organisation.Type,district.DistrictName as dname,dsdivision.ElectorateName
                      from employee
                      left join employmentcode
                      on employee.CurrentDesignation=employmentcode.id
                      left join organisation
                      on employee.CurrentOrgaID=organisation.id
                      left join district
					  on employee.DistrictName=district.DistrictCode
					  left join dsdivision
					  on employee.DSDivision=dsdivision.ElectorateCode
                      where employee.Deleted=0"));
        }else {
             $Employee = DB::select(DB::raw("select employee.*,employmentcode.Designation,organisation.OrgaName,organisation.Type,district.DistrictName as dname,dsdivision.ElectorateName
                      from employee
                      left join employmentcode
                      on employee.CurrentDesignation=employmentcode.id
                      left join organisation
                      on employee.CurrentOrgaID=organisation.id
                      left join district
					  on employee.DistrictName=district.DistrictCode
					  left join dsdivision
					  on employee.DSDivision=dsdivision.ElectorateCode
                      where employee.Deleted=0
                      and employee.OrgId=$userOrgId"));
        }
        $v->user = User::getSysUser();
        $v->userOrgType = $userOrgType;
        $v->Employee = $Employee;
        return $v;
    }

    public function actionDelete() {
        $cid = Input::get('id');
        $Employee = Employee::findOrFail($cid);
        $Employee->Deleted = 1;
        $Employee->Changed = 1;
        $Employee->save();
         $userID = User::where('EmpId','=',$cid)->where('Deleted','=',0)->pluck('userID');
         $updateuseracc = User::where('EmpId','=',$cid)->update(array('Deleted' => '1'));
         $updateuserrole = UserRole::where('userid','=',$userID)->update(array('Deleted' => '1'));
        
       
        
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $Employee->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        return Redirect::to('viewEmployee');
    }

    public function actionSearch() {
        $v = View::make('Employee.Employee');
        $searchKey = Input::get('serachkey');
        $Employee = Employee::where("NIC", "=", $searchKey)->where('Deleted', '!=', 1)->get();
        $v->user = User::getSysUser();
        $v->Employee = $Employee;
        $v->Issearch = true;
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $v->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        return $v;
    }
	
	
	

    public function actionCreate() {
        $view = View::make('Employee.CreateEmployee');
        $method = Request::getMethod();
        $view->user = User::getSysUser();
        $ins = User::getSysUser()->instituteId;
        $org = User::getSysUser()->organisationId;
        $view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
        $view->in_id = $ins;
        $view->holidaytypes = District::orderBy('DistrictName')->get();
        $view->trade = Trade::where('Deleted', '!=', 1)->orderBy('TradeName')->get();
        $view->centers = Organisation::where('Deleted','=',0)->orderBy('OrgaName')->get();
        $view->designations = EmploymentCode::where('Deleted','=',0)->orderBy('Designation')->get();

        if ($method == 'GET') {

           
            return $view;
        }
        if ($method == 'POST') {
            $validator = Employee::validateCreate(Input::all());
            if ($validator->passes()) {
                //$file = Input::file('Photograph');
                $count = Employee::where('Deleted','=',0)->where('EPFNo','=',Input::get('EPFNo'))->count();

                $HDT = new Employee();
                $HTD['LastName'] = Input::get('LastName');
                $HTD['Name'] = Input::get('Name');
                $HTD['Initials'] = Input::get('Initials');
                
                $HDT->NIC = Input::get('NIC');
                $HDT->InstituteId = Input::get('InstituteId');
                $HDT->EPFNo = Input::get('EPFNo');
                $HDT->LastName = $HTD['LastName'];
                $HDT->Initials = $HTD['Initials'];
                $HDT->Name = $HTD['Name'];
                $HDT->Sex = Input::get('Sex');
                $HDT->DOB = Input::get('DOB');
               // $HDT->CivilStatus = Input::get('CivilStatus');
               // $HDT->Race = Input::get('Race');
               //$HDT->Religion = Input::get('Religion');
               // $HDT->BloodGroup = Input::get('BloodGroup');
                //$HDT->PassportNo = Input::get('PassportNo');
               // $HDT->ExpiryDate = Input::get('ExpiryDate');
                //$HDT->PAddress = Input::get('PAddress');
               //$HDT->CAddress = Input::get('CAddress');
               // $HDT->DistrictName = Input::get('DistrictName');
               // $HDT->DSDivision = Input::get('DSDivision');
                //$HDT->Contact = Input::get('Contact');
                //$HDT->Mobile = Input::get('Mobile');
               // $HDT->Email = Input::get('Email');
               // $HDT->OContact = Input::get('OContact');
                //$HDT->OMobile = Input::get('OMobile');
               // $HDT->OEmail = Input::get('OEmail');
               // $HDT->EmergencyName = Input::get('EmergencyName');
              //  $HDT->Emergency = Input::get('Emergency');
               // $HDT->Trade = Input::get('Trade');
               // $HDT->TravelMode = Input::get('TravelMode');
                //$HDT->Items_P_by_C = Input::get('Items_P_by_C');
                $HDT->DateEntered = date('y-m-d');
                $HDT->User = User::getSysUser()->userID;
                $HDT->OrgId = User::getSysUser()->organisationId;
                $HDT->CurrentDesignation = Input::get('Designation');
                $HDT->CurrentOrgaID = Input::get('ToOrganisation');
                /* if($count == 0)
                { */
                $HDT->save();
                /* } */

                $r = new MOEmployeeTrans();
                $r->EPFNo = Input::get('EPFNo');
                $r->EmpID = Employee::where('EPFNo','=',Input::get('EPFNo'))->where('Deleted','=',0)->where('CurrentOrgaID','=',Input::get('ToOrganisation'))->pluck('id');
                $r->CenterID = Input::get('ToOrganisation');
                $r->Active=1;
                $r->User = User::getSysUser()->userID;
              /*   if($count == 0)
                { */
                $r->save();
               /*  } */

                

                return Redirect::to('createEmployee');
                

              
            } 
            else
             {
                return Redirect::to('createEmployee')->withErrors($validator);
            }
            return $view;
        }
    }

    public function actionEdit() {
        switch (Request::getMethod()) {
            case 'GET':
                $view = View::make('Employee.EditEmployee');
                $id = Input::get('cid');
                $view->Employee = Employee::where('id', '=', $id)->first();
                $view->user = User::getSysUser();
                $ins = User::getSysUser()->instituteId;
                $view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
                $view->in_id = $ins;
                $view->holidaytypes = District::orderBy('DistrictName')->get();
                $electoratecode_emp = Employee::where('id', '=', $id)->pluck('DistrictName');
                $view->Electorate = Electorate::where('DistrictCode', "=", $electoratecode_emp)->orderBy('ElectorateName')->get();
                $view->trade = Trade::where('Deleted', '!=', 1)->orderBy('TradeName')->get();

        $view->centers = Organisation::where('Deleted','=',0)->orderBy('OrgaName')->get();
        $view->designations = EmploymentCode::where('Deleted','=',0)->orderBy('Designation')->get();
                return $view;
                break;

            case 'POST':
                $validator = Employee::validateEdit(Input::all());
                if ($validator->passes()) {
                    $id = Input::get('id');
				$existOrgaID = Employee::where('id','=',$id)->pluck('CurrentOrgaID');
                $HDT = Employee::find($id);
                    //$i->fill(Input::all());
					
                $HDT->Changed = 1;
                $HTD['LastName'] = Input::get('LastName');
                $HTD['Name'] = Input::get('Name');
                $HTD['Initials'] = Input::get('Initials');
                
                $HDT->NIC = Input::get('NIC');
                $HDT->InstituteId = Input::get('InstituteId');
                $HDT->EPFNo = Input::get('EPFNo');
                $HDT->LastName = $HTD['LastName'];
                $HDT->Initials = $HTD['Initials'];
                $HDT->Name = $HTD['Name'];
                $HDT->Sex = Input::get('Sex');
                $HDT->DOB = Input::get('DOB');
                /* $HDT->CivilStatus = Input::get('CivilStatus');
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
                $HDT->Items_P_by_C = Input::get('Items_P_by_C'); */
                $HDT->DateEntered = date('y-m-d');
                $HDT->User = User::getSysUser()->userID;
                $HDT->OrgId = User::getSysUser()->organisationId;
                $HDT->CurrentDesignation = Input::get('Designation');
                $HDT->CurrentOrgaID = Input::get('ToOrganisation');
				$HDT->Active = Input::get('Active');
                $HDT->save();
				$updateUser = User::where('EmpId','=',$id)->update(array('organisationId' => Input::get('ToOrganisation')));
				
				$OldTransactionAvailable = MOEmployeeTrans::where('EmpID','=',$id)->where('CenterID','=',$existOrgaID)->get();
				if(count($OldTransactionAvailable) == 0)
				{
				$r = new MOEmployeeTrans();
                $r->EPFNo = Input::get('EPFNo');
                $r->EmpID = $id;
                $r->CenterID = $existOrgaID;
                $r->Active=0;
                $r->User = User::getSysUser()->userID;
                $r->save();
				}
                $updatemoemptrans = MOEmployeeTrans::where('EmpID','=',$id)->update(array('Active' => '0'));
                $r = new MOEmployeeTrans();
                $r->EPFNo = Input::get('EPFNo');
                $r->EmpID = $id;
                $r->CenterID = Input::get('ToOrganisation');
                $r->Active=1;
                $r->User = User::getSysUser()->userID;
                $r->save();
                
                return Redirect::to('viewEmployee');
               
                  
                } else {
                    return Redirect::to('editEmployee?cid=' . Input::get('id'))->withErrors($validator);
                }
                break;
            default:
        }
    }

    public function nicAjax() {
        $v = Input::get('DistrictName');
        $ss = Electorate::where('DistrictCode', "=", $v)->orderBy('ElectorateName')->get();
        $html = "<select name='DSDivision' id='DSDivision' required>";
        $html.="<option value=\"\">--Select--</option>";
        foreach ($ss as $s) {
            $html .="<option value =\"$s->ElectorateCode\">$s->ElectorateName</option>";
        }
        $html .="</select><b style='color: red'>*</b>";

        echo $html;
    }
  

  public function loadNicAjaxDetails(){
        $nic = Input::get('nic');
        $appl = Employee::where('Deleted', '!=', 1)->where('NIC', '=', $nic)->first();
        $EPFNo = $appl->EPFNo;
        $LastName = $appl->LastName;
        $Initials = $appl->Initials;
        $Name = $appl->Name;
        $DOB = $appl->DOB;
        //$CivilStatus = $appl->CivilStatus;
       // $PAddress = $appl->PAddress;
       // $Mobile = $appl->Mobile;
       // $Race = $appl->Race;
        //$Religion = $appl->Religion;
       // $BloodGroup = $appl->BloodGroup;
       // $PassportNo = $appl->PassportNo;
       // $CAddress = $appl->CAddress;
       // $DistrictName = $appl->DistrictName;
       // $DSDivision = $appl->DSDivision;
       // $Contact = $appl->Contact;
      //  $Email = $appl->Email;
      //  $OContact = $appl->OContact;
       // $OMobile = $appl->OMobile;
       // $OEmail = $appl->OEmail;
        $dale ='';
       echo $EPFNo . '|#|' . $LastName . '|#|' . $Initials . '|#|' . $Name .'|#|' . $DOB . '|#|'  . $dale;
  }

    public function image() {
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
            $i = Employee::find($id);
            $i->Photograph = $upload_success;
            $i->save();
            return Redirect::to('viewEmployee');
        }
    }

}
