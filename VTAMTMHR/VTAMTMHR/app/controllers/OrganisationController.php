<?php

use SimpleExcel\SimpleExcel;

class OrganisationController extends BaseController {

    public function viewOrganisation() {
        //$organisation = Organisation::where('Deleted','!=',1)->where('id','=',432)->get();



        $userorgid = User::getSysUserOrg();
        $districtId = Organisation::where('id', '=', $userorgid)->pluck('DistrictCode');
        $Type = Organisation::where('id', '=', $userorgid)->pluck('Type');
        if ($Type == 'HO') {
            $organisation = Organisation::where('Deleted', '=', '0')->orderBy('OrgaName', 'ASC')->get();
        } elseif ($Type == 'DO') {
            $organisation = Organisation::where('Deleted', '=', '0')->where('DistrictCode', '=', $districtId)->orderBy('OrgaName', 'ASC')->get();
        } else {
            $organisation = Organisation::where('Deleted', '=', '0')->where('id', '=', $userorgid)->get();
        }
//                $sql="SELECT o.*,i.InstituteName FROM organisation o
//                    INNER JOIN institution i ON o.InstituteId=i.InstituteId
//                    AND o.Deleted!=1
//                    ORDER BY o.OrgaName";
//                $res=DB::select(DB::raw($sql));
        $v = View::make('Organisation.Organisation');
        $v->organisation = $organisation;
        $v->type = $Type;
        $v->user = User::getSysUser();

//           
//           
        return $v;
//            $organisation = Organisation::where("Deleted","!=","1")->get();
//            echo print_r($organisation);
    }

    public function actionSearch() {

        $v = View::make('Organisation.Organisation');


        $searchKey = Input::get('serachkey');
        $district = District::where('DistrictName', "=", $searchKey)->pluck("DistrictCode");

        $organisation = Organisation::where('Deleted', '!=', 1)->where("CenterCode", "=", $searchKey)->orWhere('DistrictCode', '=', $district)->get();



        $v->user = User::getSysUser();
        $v->organisation = $organisation;
        $v->Issearch = true;

        return $v->with('message', 'There is no such records!');
    }

    public function downloadOrganisationDetails() {
        //$Orga_details=Input::get('Orga_details');
        $userorgid = User::getSysUserOrg();
        $Type = Organisation::where('id', '=', $userorgid)->pluck('Type');
        $districtId = Organisation::where('id', '=', $userorgid)->pluck('DistrictCode');
        $excel = new SimpleExcel('csv');
        $printablearray = array();
        $headerArray = array('College Name', 'College Code', 'College Type', 'Address', 'Telephone No', 'Fax No', 'Email', 'Career Guidance Telephone No', 'Registration No',
            'Business Unit', 'Ownership', 'District', 'Electorate', 'Date Closed', 'Date Entered',
            'OIC', 'Latitude', 'Longitude', 'Active');
        array_push($printablearray, $headerArray);
        if ($Type == 'HO') {
            $organisation = Organisation::where('Deleted', '=', '0')->orderBy('OrgaName', 'ASC')->get();
        } elseif ($Type == 'DO') {
            $organisation = Organisation::where('Deleted', '=', '0')->where('DistrictCode', '=', $districtId)->orderBy('OrgaName', 'ASC')->get();
        } else {
            $organisation = Organisation::where('Deleted', '=', '0')->where('id', '=', $userorgid)->get();
        }

        foreach ($organisation as $o) {

            $Organization = Organisation::getOICName($o->OIC);
            $Ownership = Organisation::getOWNERSHIP($o->Ownership);
            if (!is_null($o->DistrictCode)) {
                $district = District::where('DistrictCode', '=', $o->DistrictCode)->pluck('DistrictName');
            } else {
                $district = '';
            }
            if (!is_null($o->ElectorateCode)) {
                $ElectorateName = Electorate::where('ElectorateCode', '=', $o->ElectorateCode)->pluck('ElectorateName');
            } else {
                $ElectorateName = '';
            }


            array_push($printablearray, array(
                $o->OrgaName,
                $o->CenterCode,
                $o->OrgType->Type,
                $o->AddL1,
                $o->Tel,
                $o->Fax,
                $o->Email,
                $o->CaGuTel,
                $o->RegistrationNo,
                $Ownership,
                $o->BusinessUnit,
                $district,
                $ElectorateName,
                $o->DateClosed,
                $o->DateEntered,
                $Organization['Initials'] . $Organization['LastName'],
                $o->Latitude,
                $o->Longitude,
                $o->Active
            ));
        }

        $excel->writer->setData($printablearray); // now all your data should be in printableArray
        $excel->writer->saveFile('OrganisationDetails' . Date("Y-m-d") . ''); // save it
    }

    public function actionDelete() {
        $oid = Input::get('oid');
        $organisation = Organisation::findOrFail($oid);
        $organisation->Deleted = 1;
        $organisation->Changed = 1;
        $organisation->User = User::getSysUser()->userID;
        $organisation->save();
        return Redirect::to('organisation')->with('message', 'Organisation Deleted successfully!');
    }

    public function actionCreate() {
        $method = Request::getMethod();
        $view = View::make('Organisation.Create');
        $view->user = User::getSysUser();
        $orgID = User::getSysUserOrg();
        $logUserDistrict = Organisation::where('id', '=', $orgID)->pluck('DistrictCode');

        $view->electorate = Electorate::where('ElectorateCode', "!=", "")->get();
        $view->district = District::where('DistrictCode', "!=", "")->get();
        $view->centercode = CenterCode::where('CenterCode', "!=", "")->get();
        $view->orgtype = OrganisationType::where("Deleted", "!=", 1)->get();
        $view->ortype = Organisation::where("Deleted", "!=", 1)->where("TypeId", "=", 1)->get();
        $view->ownership = Orgaownership::all();

        $sql = "select employee.id, 
                        employee.Name,employee.Initials,employee.LastName,employee.EPFNo 
                        from promotion 
                        left join employee 
                        on promotion.NIC=employee.NIC 
                        left join transfertype 
                        on promotion.TransferType=transfertype.T_ID 
                        
                        left join employmentcode
                        on promotion.NewPost = employmentcode.id
                        LEFT JOIN organisation ON organisation.id=promotion.ToOrganisation
                        
                        where promotion.CurrentRecord='Yes'
                        and transfertype.Available=1
                        and employmentcode.Designation LIKE '%Instructor%' OR employmentcode.Designation LIKE '%Training Officer%'
                        and promotion.Deleted=0
                        AND organisation.DistrictCode='$logUserDistrict'
                          ";
        // and promotion.ToOrganisation='" . $orgID . "'
        // return $sql;
        $view->instructor = DB::select(DB::raw($sql));

        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {

            $validator = Organisation::validate(Input::all());

            if ($validator->passes()) {
                $o = new Organisation;
                $o->fill(Input::except('COT_Id', 'BusinessUnit'));
				$TYpeNme = OrganisationType::where('OT_ID','=',Input::get('TypeId'))->pluck('Type');
				$o->Type= $TYpeNme;
                // $o->DateEntered = \Carbon\Carbon::now();
                $o->User = User::getSysUser()->userID;
                if (Input::get('BusinessUnit') == 'on') {
                    $o->BusinessUnit = 1;
                } else {
                    $o->BusinessUnit = 0;
                }

                if ((Input::get('COT_Id') == 1) || (Input::get('COT_Id') == 5) || (Input::get('COT_Id') == 3)) {
                    $o->COT_Id = Input::get('COT_Id');
                } else {
                    $dis = Input::get('DistrictCode');
                    $ct = Organisation::where('DistrictCode', '=', $dis)->where('TypeId')->pluck('id');
                   /* if (count($ct) == 0) {
                        return Redirect::to('createOrganisation')->withErrors("Please Enter District Office for Relavent District");
                    } else {
                        $o->COT_Id = $ct;
                    }*/
					
					
					
                }
                $o->save();

                $abc = Organisation::where('CenterCode', '=', Input::get('CenterCode'))->first();

                if (Input::get('TypeId') == 1) {
                    $abc->COT_Id = $abc->id;
                    $abc->save();
                }
                return Redirect::to('organisation')->with("done", true);
            } else {
                return Redirect::to('createOrganisation')->withErrors($validator);
            }
        }
    }

    public function actionEdit() {
        $view = View::make('Organisation.Edit');

        $method = Request::getMethod();

        if ($method == "GET") {
            $organisation = Organisation::find(Input::get('id'));
            $view->user = User::getSysUser();
            $view->institutes = User::getSysUser()->Institute;
            $orgID = User::getSysUserOrg();
            $userTypeId = Organisation::where('id', '=', $orgID)->where('Deleted', '=', 0)->pluck('TypeId');
            $userType = OrganisationType::where('OT_ID', '=', $userTypeId)->pluck('Type');

            $logUserDistrict = Organisation::where('id', '=', $orgID)->pluck('DistrictCode');
            $view->electorate = Electorate::where('ElectorateCode', "!=", "")->get();
            $view->district = District::where('DistrictCode', "!=", "")->get();
            $view->organisation = $organisation;
            $view->abc = Organisation::where('ElectorateCode', "=", Input::get('id'))->where('Deleted', "!=", "1")->first();
            $view->orgtype = OrganisationType::where("Deleted", "!=", 1)->get();
            $view->ortype = Organisation::where("Deleted", "!=", 1)->where("TypeId", "=", 1)->get();
            $view->ownership = Orgaownership::all();
            $view->userType = $userType;

            $orgID = User::getSysUserOrg();
            $sql = "select employee.id, 
                        employee.Name,employee.Initials,employee.LastName,employee.EPFNo 
                        from promotion 
                        left join employee 
                        on promotion.NIC=employee.NIC 
                        left join transfertype 
                        on promotion.TransferType=transfertype.T_ID 
                        
                        left join employmentcode
                        on promotion.NewPost = employmentcode.id
                        LEFT JOIN organisation ON organisation.id=promotion.ToOrganisation
                        where promotion.CurrentRecord='Yes'
                        and transfertype.Available=1
                        and employmentcode.Designation LIKE '%Instructor%' OR employmentcode.Designation LIKE '%Training Officer%'
                        and promotion.Deleted=0
                        AND organisation.DistrictCode='$logUserDistrict'";
            $view->instructor = DB::select(DB::raw($sql));

            return $view;
        }
        if ($method == "POST") {
            $validator = Organisation::validateedit(Input::all());
            if ($validator->passes()) {
                $array = Input::all();

                $o = Organisation::find($array['id']);
                $o->fill(Input::all());
				$TYpeNme = OrganisationType::where('OT_ID','=',Input::get('TypeId'))->pluck('Type');
				$o->Type= $TYpeNme;
                $o->Changed = 1;
                if ($o->save()) {
                    return Redirect::to('organisation');
                }
            } else {
                return Redirect::to('editOrganisation?id=' . Input::get('id'))->withErrors($validator);
            }
        }
    }

    public function Dateclosed() {
        $method = Request::getMethod();
        $view = View::make('Organisation.Dacl');

        if ($method == "GET") {
            $organisation = Organisation::find(Input::get('id'));

            $view->user = User::getSysUser();
            $view->institutes = Institute::where('Deleted', "!=", 1)->get();
            $view->electorate = Electorate::where('ElectorateCode', "!=", "")->get();
            $view->district = District::where('DistrictCode', "!=", "")->get();
            $view->organisation = $organisation;
            return $view;
        }
        if ($method == "POST") {
            $ID = Input::get('id');


            $o = Organisation::find($ID);
            $o->DateClosed = Input::get('DateClosed');
			$o->Active = Input::get('Active');
			$o->User = User::getSysUser()->userID;
			$o->save();
            
                return Redirect::to('organisation');
            
        }
    }

    public function disAjax() {
        $v = Input::get('d_code');

        //return  $v;

        $abc = Electorate::where('DistrictCode', "=", $v)->get();

        //$sql = "select * from electorate where electorate.DistrictCode = '".$org_id."' ";
        //$abc = DB::select(DB::raw($sql));
        //return $abc;

        $aaa = "<select id=\"ElectorateCode\" name=\"ElectorateCode\">";
        $aaa .= "<option></option>";
        foreach ($abc as $abc) {
            $aaa .= "<option value=\"$abc->ElectorateCode\">$abc->ElectorateName</option>";
        }
        $aaa .= "</select>";
        echo $aaa;
    }

    public function cenAjax() {
        $v = Input::get('c_code');
        $centercode = CenterCode::where('CenterCode', "=", $v)->pluck('CenterName');

        echo $centercode;
    }

}
