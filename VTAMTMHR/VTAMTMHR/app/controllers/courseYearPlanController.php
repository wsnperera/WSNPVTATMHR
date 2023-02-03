<?php

class CourseYearPlanController extends BaseController {

    public function SaveMOInstructor()
    {
         $Name = Input::get('Name'); 
        $EPF = Input::get('EPF');
        $UserOrgID = User::getSysUser()->organisationId; 
        $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		
            $alreadyexist = MOInstructor::where('EPFNo','=',$EPF)->where('Deleted','=',0)->get();
            if(count($alreadyexist) == 0)
            {
                $I = new MOInstructor();
                $I->Name = $Name;
                $I->EPFNo = $EPF;
                $I->User = User::getSysUser()->userID;
				if($EPF !=0)
				{
					$I->save();
				}
                
            }

            //$sql = "select * from moinstructor where Deleted=0 order by Name";
            //$list = DB::select(DB::raw($sql));
			$list = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();

            $done = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                   Working Institute Added Successfully!
                </strong>
                <br>
            </div>';
            $json = array("list" => $list,"done" => $done);
            return json_encode($json, 0);

           
    }

    public function editModulesToCourse() {
     $method = Request::getMethod();
        if ($method == "GET") {
            $courseYearPlanID = Input::get('yearPalnID');
            $view = View::make('CourseYearPlan.EditAssignModulesToCourse');
            $courseYearPlan = CourseYearPlan::where('id', '=', $courseYearPlanID)
                    ->first();

//            $sqlMoudule = 'select module.ModuleId,module.ModuleName,module.ModuleCode from module,Courseyearplanmodules 
//                            where module.ModuleId=Courseyearplanmodules.moduleID 
//                            and Courseyearplanmodules.courseListCode="' . $view->courseYearPlan->CourseListCode . '"
//                            and Courseyearplanmodules.cypID="' . $view->courseYearPlan->id . '" 
//                            and Courseyearplanmodules.Deleted=0 
//                            and module.Deleted=0';
          $sqlMoudule = 'select nvqmodule.name as modulename,nvqmodule.code as modulecode,nvqmodule.id as id,courseyearplanmodules.id as cmoduleid from courseyearplanmodules
                        left join courseyearplan on  courseyearplanmodules.cypID=courseyearplan.id
                        left join nvqmodule on courseyearplanmodules.moduleID=nvqmodule.id 
                        where  courseyearplanmodules.courseListCode="' . $courseYearPlan->CourseListCode . '"
                        and courseyearplanmodules.cypID="' . $courseYearPlan->id . '"';
//             $sqlInstructor = 'select employee.id,employee.Name,employee.LastName,employee.Initials from employee,courseyearplaninstructor 
//                        where courseyearplaninstructor.cypID="' . $view->courseYearPlan->id . '"
//                        and employee.id=courseyearplaninstructor.empID';
//            $sqlInstructor = 'select employee.Name from employee,courseyearplaninstructor 
//                            where courseyearplaninstructor.cypID="' . $view->courseYearPlan->id . '"
//                            and courseyearplaninstructor.Deleted=0
//                            and employee.id=courseyearplaninstructor.empID';
            $courseYearPlanModule = json_decode(json_encode(DB::select($sqlMoudule)), true);
            $courseYearPlanModuleArray = array();
            foreach ($courseYearPlanModule as $cypm) {
                array_push($courseYearPlanModuleArray, $cypm);
            }
            $view->courseYearPlanModule = $courseYearPlanModuleArray;
            //$Instructor = json_decode(json_encode(DB::select($sqlInstructor)), true);

            $htmlTableRaw = '<tr><td><center><select name="Instructor[]" ><option></option>';
            $orgID = User::getSysUser()->organisationId;
            $sql = "select employee.id, 
                        employee.Name,employee.Initials,employee.LastName,employee.EPFNo 
                        from promotion 
                        left join employee 
                        on promotion.NIC=employee.NIC 
                        left join transfertype 
                        on promotion.TransferType=transfertype.T_ID 
                        
                        left join employmentcode
                        on promotion.NewPost = employmentcode.id
                        
                        where promotion.CurrentRecord='Yes'
                        and transfertype.Available=1
                        and employmentcode.Academic='Yes'
                        and promotion.Deleted=0
                        and promotion.ToOrganisation='" . $orgID . "'";
            //$courseYearPlanID = Input::get('yearPalnID');
            //$view->module = json_decode(json_encode(DB::select($sqlMoudule)), true);
            //$view->module = Module::where('Deleted', '=', 0)
            //    ->get();
            $Instructor = json_decode(json_encode(DB::select($sql)), true);
            foreach ($Instructor as $i) {
                $htmlTableRaw.='<option value="' . $i['id'] . '" >' . $i['Initials'] . '' . $i['Name'] . '' . $i['LastName'] .'(EPFNo-'.$i['EPFNo']. ')</option>';
            }
            $htmlTableRaw.='</select></td></tr>';
            $htmlTableRaw .= '';
            // $view->Instructor = $Instructor;
            $view->htmlTableRaw = $htmlTableRaw;
            $tvecTrade=TVECtrade::get();
            $view->tvecTrade = $tvecTrade;
            $tradeid = Course::where('CourseListCode', '=', $courseYearPlan->CourseListCode)->pluck('TradeId');
            //return $tradeid; 
            $com = NVQcompetencystandard::where('Deleted', '=', 0)->where('tradeid', '=', $tradeid)->get();
            $view->com = $com;
            $view->courseYearPlan = $courseYearPlan;
            $view->yearPalnID = $courseYearPlanID;
            return $view;
        } else {
            $cypID = Input::get('cypID');
            $package = Input::get('package_ids');
            //$modules = Input::get('modules');
            $selectedmodules = Input::get('Module_ids');
            $CourseListCode = Input::get('CourseListCode');
          //  $Competency_code = Input::get('type');
           // $startDate = Input::get('startDate');
           // $maxCapacity = Input::get('maxCapacity');
          //  $medium = Input::get('medium');
           // $fee = Input::get('fee');
          //  $feeType = Input::get('feeType');
            $userID = User::getSysUser()->userID;
            $Instructor = Input::get('Instructor');
//            if (count($modules) <= 0) {
//                return Redirect::back()->withErrors('Required to select One Or More Modules To complete this Action');
//            }

             $cscode=NVQQualificationPackage::whereIn("id",$package)->where("Deleted","=",0)->lists("cscode");
             $com_id=NVQcompetencystandard::whereIn("code",$cscode)->where("Deleted","=",0)->lists("id");
			if($com_id !=""){
            foreach ($com_id as $id) 
				{
				$already_competency=Courseyearplancompetency::where('cs_id','=',$id)->where('cyp_id','=',$cypID)->where('Deleted','=',0)->first();
				if(!empty($already_competency)){
				$comstandard = $already_competency;
				}else{
				$comstandard = new Courseyearplancompetency;
				}
                
                $comstandard->cyp_id=$cypID;
                $comstandard->cs_id=$id;
                $comstandard->User=$userID;
                $comstandard->save();

				}
			}
			
			 if($package!=""){
            foreach ($package as $p) {
			      $already_package=Courseyearplanqualificationpackage::where('packageID','=',$p)->where('cypID','=',$cypID)->where('Deleted','=',0)->first();
			  if(!empty($already_package)){
				$qualificationpackage = $already_package;
				}else{
				 $qualificationpackage = new Courseyearplanqualificationpackage;
				}
               
                $qualificationpackage->cypID = $cypID;
                $qualificationpackage->packageID = $p;
                $qualificationpackage->save();
            }
            
            }
			
            $instructorCheckArray = array();
            foreach ($Instructor as $i) {
                if (in_array($i, $instructorCheckArray)) {
                    return Redirect::back()->withErrors('The Same Instructor has been Selected Twice');
                }
                $instructorCheckArray[] = $i;
            }
//            $deleteCourseyearplanmodules = Courseyearplanmodules::where('courseListCode', '=', $CourseListCode)
//                    ->where('cypID', '=', $cypID)
//                    ->where('Deleted', '=', 0)
//                    ->where('moduleID', '=', $selectedmodules)
//                    ->get();
//            $deleteCourseyearplanmodules1 = Courseyearplanmodules::where('courseListCode', '=', $CourseListCode)
//                    ->where('cypID', '=', $cypID)
//                    ->where('Deleted', '=', 1)
//                    ->where('moduleID', '=', $selectedmodules)
//                    ->get();
//            foreach ($modules as $m) {
//                $courseyearplanmodules = new Courseyearplanmodules;
//                $courseyearplanmodules->courseListCode = $CourseListCode;
//                $courseyearplanmodules->cypID = $cypID;
//                $courseyearplanmodules->moduleID = $m;
//                $courseyearplanmodules->User = $userID;
//                $courseyearplanmodules->DateEntered = date('Y-m-d');
//                $courseyearplanmodules->save();
//            }
            foreach ($selectedmodules as $m) {
                $courseyearplanmodule = Courseyearplanmodules::where('courseListCode', '=', $CourseListCode)
                        ->where('cypID', '=', $cypID)
                        ->where('moduleID', '=', $m)
                        ->first();
                if (!empty($courseyearplanmodule)) {
                    $courseyearplanmodules = Courseyearplanmodules::find($courseyearplanmodule->id);
                } else {
                    $courseyearplanmodules = new Courseyearplanmodules;
                }
                $courseyearplanmodules->courseListCode = $CourseListCode;
                $courseyearplanmodules->cypID = $cypID;
                $courseyearplanmodules->moduleID = $m;
                $courseyearplanmodules->User = $userID;
                $courseyearplanmodules->Deleted = 0;
                $courseyearplanmodules->Changed = 1;
                $courseyearplanmodules->save();
            }
          if (!empty($Competency_code)) {
		 // return 1;
	           // foreach($Competency_code as $cs){
				    $nvqcompetency=NVQcompetencystandard::where('code','=',$Competency_code)->where('Deleted','=',0)->first();
                   // $courseyearplancompetency = Courseyearplancompetency::where('cyp_id','=',$cypID)->where('cs_id','=',$nvqcompetency->id)->first();
					$courseyearplancompetency = new Courseyearplancompetency;
					$courseyearplancompetency->cyp_id = $cypID;
                    $courseyearplancompetency->cs_id = $nvqcompetency->id;
                    $courseyearplancompetency->User =$userID;
                    $courseyearplancompetency->save();
					//}
                } 
				/*else {
				//foreach($Competency_code as $cs){
				    $nvqcompetency=NVQcompetencystandard::where('code','=',$cs)->where('Deleted','=',0)->first();
                    $courseyearplancompetency = new Courseyearplancompetency;
					$courseyearplancompetency->cyp_id = $cypID;
					$courseyearplancompetency->cs_id = $nvqcompetency->id;
                    $courseyearplancompetency->User =$userID;
                    $courseyearplancompetency->save();
               // }
				} */
              

           /* $deleteCourseyearplaninstructor = Courseyearplaninstructor::where('cypID', '=', $cypID)
                    ->delete(); */
			 $sql1="Update courseyearplaninstructor
			            set Deleted=1
						where cypID='$cypID'";
			$already_Instructor = DB::Update(DB::raw($sql1));
            foreach ($Instructor as $i) {
                $courseyearplaninstructor = new Courseyearplaninstructor;
                $courseyearplaninstructor->cypID = $cypID;
                $courseyearplaninstructor->empID = $i;
                $courseyearplaninstructor->User = $userID;
                $courseyearplaninstructor->DateEntered = date('Y-m-d');
                $courseyearplaninstructor->save();
            }
			
		/*	if($com_id !=""){
            foreach ($com_id as $id) 
				{
                $comstandard = new Courseyearplancompetency;
                $comstandard->cyp_id=$cypID;
                $comstandard->cs_id=$id;
                $comstandard->User=$userID;
                $comstandard->save();

				}
			} */
//            foreach ($package as $p) {
//                $qualificationpackage = new Courseyearplanqualificationpackage;
//                $qualificationpackage->cypID = $cypID;
//                $qualificationpackage->packageID = $p;
//                $qualificationpackage->save();
//            }

            $coureseYearPaln = CourseYearPlan::where('id', '=', $cypID)
                    ->first();
            //$coureseYearPaln->maxCapacity = $maxCapacity;
           // $coureseYearPaln->confirm = 1;
           // $coureseYearPaln->medium = $medium;
           // $coureseYearPaln->feeType = $feeType;
            //$coureseYearPaln->fee = $fee;
           // $coureseYearPaln->startDate = $startDate;
            $coureseYearPaln->Changed = 1;
            $coureseYearPaln->save();
            return Redirect::to('ConfirmCourseYearPlanFirstPage');
        }
    }

public function getNVQCompetencyStandardNew(){
      $values = Input::get('values');

      $com = NVQcompetencystandard::where('Deleted', '=', 0)->where('tradeid', '=', $values)->get(); 
      return $com;

}
    public function viewModulesToCourse() {
        $courseYearPlanID = Input::get('yearPalnID');
        // return $selectedmodules = Input::get('Module_ids');
        $view = View::make('CourseYearPlan.viewModulesToCourse');
        $view->courseYearPlan = CourseYearPlan::where('id', '=', $courseYearPlanID)
                ->first();
        /*  $sqlMoudule = 'select module.ModuleName,module.ModuleCode from module,courseyearplanmodules 
          where module.ModuleId=courseyearplanmodules.moduleID
          and courseyearplanmodules.courseListCode="' . $view->courseYearPlan->CourseListCode . '"
          and courseyearplanmodules.cypID="' . $view->courseYearPlan->id . '"
          and courseyearplanmodules.Deleted=0
          and module.Deleted=0'; */
        $sqlMoudule = 'select nvqmodule.name as modulename,nvqmodule.code as modulecode from courseyearplanmodules
                        left join courseyearplan on  courseyearplanmodules.cypID=courseyearplan.id
                        left join nvqmodule on courseyearplanmodules.moduleID=nvqmodule.id 
                        where  courseyearplanmodules.courseListCode="' . $view->courseYearPlan->CourseListCode . '"
                        and courseyearplanmodules.cypID="' . $view->courseYearPlan->id . '"';

        //return $sqlMoudule;
        $sqlInstructor = 'select employee.Name,employee.LastName,employee.Initials from employee,courseyearplaninstructor 
                        where courseyearplaninstructor.cypID="' . $view->courseYearPlan->id . '"
                        and employee.id=courseyearplaninstructor.empID';
        $view->module = json_decode(json_encode(DB::select($sqlMoudule)), true);
        $view->Instructor = json_decode(json_encode(DB::select($sqlInstructor)), true);
        return $view;
    }

    public function createcompetencystandard() {
        $view = View::make('CourseYearPlan.createcompetencystandard');
        return $view;
    }

    public function getNVQmoduleProgram() {
        //return Input::all();
        $all = Input::all();
        $package_ids = null;

        $package_ids = NVQQualificationPackage::whereIn('cscode', $all["module"])
                ->where('Deleted', '!=', 1)
                ->get();

        $sql = 'SELECT distinct nvqmodule.name,nvqmodule.id
                        FROM nvqmodule
                        LEFT OUTER JOIN nvqqualificationpackagemodule
                        ON nvqqualificationpackagemodule.moduleid = nvqmodule.id
                        
                 WHERE packageid in (0';
        for ($i = 0; $i < count($package_ids); $i++) {
            $sql .=', ' . $package_ids[$i]->id . '';
        }
        $sql .= ') AND nvqmodule.Deleted !=1';

        $modules = DB::select($sql);
//return $modules;
        $html = '<div class="control-group">
                    <label class="control-label">Modules :</label>
                        <div class="controls">';

        foreach ($modules as $module) {
            $html .='<label>
			<input name="Module_ids[]" value="' . $module->id . '" type="checkbox">
                        <span class="lbl"> &nbsp;' . $module->name . '.</span>
                </label>';
        }

        $html .='<br><input type="button" id="modulebutton" onclick="getQualifications();" value="Chech Qualification Packages" class="btn btn-small btn-gray">';
        $html .='</div><div id="qualification_package"></div>
                </div>';
        return $html;
    }

    public function getNVQmoduleProgramedit() {

        //return Input::all();
        $all = Input::all();
        $smod = Input::get('selectedmodules');
        // $smod = json_decode($all['selectedmodules']);
        $package_ids = null;

        //return $smod;
        $package_ids = NVQQualificationPackage::whereIn('cscode', $all["module"])
                ->where('Deleted', '!=', 1)
                ->get();
         if($smod!=''){
         $sql = 'SELECT distinct nvqmodule.name,nvqmodule.id
                        FROM nvqmodule
                        LEFT OUTER JOIN nvqqualificationpackagemodule
                        ON nvqqualificationpackagemodule.moduleid = nvqmodule.id
                        
                 WHERE packageid in (0';
        for ($i = 0; $i < count($package_ids); $i++) {
            $sql .=', ' . $package_ids[$i]->id . '';
        }
        $sql .= ') AND nvqmodule.id not in (0';
        foreach ($smod as $sid) {
            $sql .=', ' . $sid . '';
        }
        $sql .= ') AND nvqmodule.Deleted !=1'; 
         }
         else{
             $sql = 'SELECT distinct nvqmodule.name,nvqmodule.id
                        FROM nvqmodule
                        LEFT OUTER JOIN nvqqualificationpackagemodule
                        ON nvqqualificationpackagemodule.moduleid = nvqmodule.id
                        
                 WHERE packageid in (0';
        for ($i = 0; $i < count($package_ids); $i++) {
            $sql .=', ' . $package_ids[$i]->id . '';
        }
        $sql .= ')  AND nvqmodule.Deleted !=1'; 

         }
       

        $modules = DB::select($sql);
//return $modules;
        $html = '<div class="control-group">
                    <label class="control-label">Modules :</label>
                        <div class="controls">';

        foreach ($modules as $module) {
            $html .='<label>
			<input name="Module_ids[]" value="' . $module->id . '" type="checkbox">
                        <span class="lbl"> &nbsp;' . $module->name . '.</span>
                </label>';
        }

        $html .='<br><input type="button" id="modulebutton" onclick="getQualifications();" value="Chech Qualification Packages" class="btn btn-small btn-gray">';
        $html .='</div><div id="qualification_package"></div>
                </div>';
        return $html;
    }


    public function ajaxdeletemodules() {
        $mod_id = Input::get("mod_id");
        $yearPalnID = Input::get("yearPalnID");
        $clc = Input::get("clc");
        $EP = Courseyearplanmodules::find($mod_id);
        if (!empty($EP)) {
            $EP->Deleted = 1;
            $EP->Changed = 1;
            $EP->User = User::getSysUser()->userID;
            if (!$EP->save()) {
                return "1";
            }
        } else {
            return "1";
        }
    }

    public function ajaxgetQualifications() {


        $selectedmodules = (Input::has("selectedmodules") ? Input::get('selectedmodules') : array());
        //$newmodules = (Input::has("module") ? Input::get('module') : array());
        // $newselectedmodules=$selectedmodules+$newmodules;
        //return $newselectedmodules;
        $sqltemp = "";
        foreach ($selectedmodules as $sm) {
            $sqltemp .= ", '" . $sm['value'] . "'";
        }
        $sql = "select nvqqualificationpackage.packagecode,nvqqualificationpackage.id 
                    from nvqqualificationpackage
                    inner join nvqqualificationpackagemodule as a
                    on a.packageid=nvqqualificationpackage.id
                    and a.moduleid in (''$sqltemp)
                    left join nvqqualificationpackagemodule as b
                    on b.packageid=nvqqualificationpackage.id and b.moduleid not in (''$sqltemp)
                    where a.Deleted!='1'
                    and b.id is null
                    and nvqqualificationpackage.Deleted!='1'
                    group by nvqqualificationpackage.packagecode";
        $packages = DB::select($sql);
        //return $packages;
        $html = '<div class="control-group">
                    <label class="control-label">Qualification Packages :</label>
                        <div class="controls"><label>';
        if (count($packages) === 0) {
            $html.='<span style="color:red" >No Qualification Package</span>';
        } else {
            foreach ($packages as $package) {
                $html .='<span class="lbl" name="package"> &nbsp;' . (isset($package->packagecode) ? $package->packagecode : "") . '.</span>
            <input name="package_ids[]" value="' . $package->id . '" type="hidden">
           ';
            }
        }

        $html .='</label></div>
                </div>';
        return $html;



//        $sql = "select distinct nvqqualificationpackage.packagecode
//                    from nvqqualificationpackagemodule
//                    left join nvqqualificationpackage
//                    on nvqqualificationpackagemodule.packageid=nvqqualificationpackage.id
//                    where nvqqualificationpackagemodule.moduleid in ('' ";
//        foreach ($selectedmodules as $sm) {
//            $sql .= ", '".$sm['value']."'";
//        }
//        $sql .= ")
//                    and nvqqualificationpackagemodule.Deleted!='1'
//                    and nvqqualificationpackage.Deleted!='1'";
//        $falge = 0;
//        $falge1 = 0;
//   
//        $temp_pkgID_ary = array();
//        $temp_modsIDs = array();
//        for ($i = 0; $i < count($selectedmodules); $i++) {
//            $a = explode('-', $selectedmodules[$i]['value']);
//            array_push($temp_modsIDs, $a[1]);
//            if (!in_array($a[0], $temp_pkgID_ary)) {
//                array_push($temp_pkgID_ary, $a[0]);
//            }
//        }
        //return $temp_pkgID_ary;
        //return $temp_modsIDs;
//        for ($j = 0; $j < count($temp_pkgID_ary); $j++) {
//            $moduleids = NVQqualificationpackagemodule::where('packageid', '=', $temp_pkgID_ary[$j])
//                    ->where('Deleted', '!=', 1)
//                    ->lists('moduleid');
//            // return $moduleids;
//            //$temp = array_diff($moduleids, $temp_modsIDs);
//            //return $temp;
//            if ($temp_modsIDs == $moduleids) {
//                return "abbb";
//                // $packageid=  NVQQualificationPackage::where('id','=',$temp_pkgID_ary[])
//                // ->pluck('packagecode');
//            } else {
//                return "wrong";
//                //bootbox.alert("Please select correct modules to get the qualification package.");
//            }
//        }
//        return $temp_pkgID_ary;
//        //  return $selectedmodules[0]['value'];
//    }
    }

    public function ajaxgetnewQualifications() {


        $selectedmodules = (Input::has("selectedmodules") ? Input::get('selectedmodules') : array());

        $sqltemp = "";
        foreach ($selectedmodules as $sm) {
            $sqltemp .= ", '" . $sm['value'] . "'";
        }
        $sql = "select nvqqualificationpackage.packagecode,nvqqualificationpackage.id 
                    from nvqqualificationpackage
                    inner join nvqqualificationpackagemodule as a
                    on a.packageid=nvqqualificationpackage.id
                    and a.moduleid in (''$sqltemp)
                    left join nvqqualificationpackagemodule as b
                    on b.packageid=nvqqualificationpackage.id and b.moduleid not in (''$sqltemp)
                    where a.Deleted!='1'
                    and b.id is null
                    and nvqqualificationpackage.Deleted!='1'
                    group by nvqqualificationpackage.packagecode";
        $packages = DB::select($sql);
        //return $packages;
        $html = '<div class="control-group">
                    <label class="control-label">Qualification Packages :</label>
                        <div class="controls"><label>';
        if (count($packages) === 0) {
            $html.='<span style="color:red" >No Qualification Package</span>';
        } else {
            foreach ($packages as $package) {
                $html .='<div class="control-group"><span class="lbl" name="package"> &nbsp;' . (isset($package->packagecode) ? $package->packagecode : "") . '.</span>
         <div class="controls">   <input name="package_ids[]" value="' . $package->id . '" type="hidden"></div></div>
           ';
            }
        }

        $html .='</label></div>
                </div>';
        return $html;
    }

    public function assignModulesToCourse() {
        $method = Request::getMethod();

        if ($method == "GET") {
            $htmlTableRaw = '<tr><td><center><select name="Instructor[]" ><option></option>';
            $orgID = User::getSysUser()->organisationId;
            // $sql = "select employee.id, 
            //             employee.Name,employee.LastName,employee.Initials 
            //             from promotion 
            //             left join employee 
            //             on promotion.NIC=employee.NIC 
            //             left join transfertype 
            //             on promotion.TransferType=transfertype.T_ID 
            //             and transfertype.TransferType NOT in('Termination','Resignation','Vacate','Retired','CoverUp')
            //             left join employmentcode
            //             on promotion.NewPost = employmentcode.id
            //             and employmentcode.Designation LIKE '%Instructor%'
            //             where promotion.CurrentRecord='Yes'
            //             and promotion.Deleted=0
            //             and promotion.ToOrganisation='" . $orgID . "'";

            $sql = "select employee.id, 
                        employee.Name,employee.Initials,employee.LastName,employee.EPFNo 
                        from promotion 
                        left join employee 
                        on promotion.NIC=employee.NIC 
                        left join transfertype 
                        on promotion.TransferType=transfertype.T_ID 
                        
                        left join employmentcode
                        on promotion.NewPost = employmentcode.id
                        
                        where promotion.CurrentRecord='Yes'
                        and transfertype.Available=1
                        and employmentcode.Academic='Yes'
                        and promotion.Deleted=0
                        and promotion.ToOrganisation='" . $orgID . "'"; 
                                   
            $courseYearPlanID = Input::get('yearPalnID');
            $view = View::make('CourseYearPlan.assignModulesToCourse');
            $courseYearPlan = CourseYearPlan::where('id', '=', $courseYearPlanID)
                    ->first();
//            $moduleCourse = ModuleCourse::where('CourseListCode', '=', $view->courseYearPlan->CourseListCode)
//                    ->where('Deleted', '=', 0)
//                    ->lists('ModuleId');
//            if (count($moduleCourse)) {
//                $view->module = Module::where('Deleted', '=', 0)
//                        ->whereIn('ModuleId', $moduleCourse)
//                        ->get();
//            }

            $Instructor = json_decode(json_encode(DB::select($sql)), true);
           
            //$htmlTableRaw = '<select>';
            foreach ($Instructor as $i) {
                $htmlTableRaw.='<option value="' . $i['id'] . '" >' . $i['Initials'] . '' . $i['Name'] . '' . $i['LastName'] .'(EPFNo-'.$i['EPFNo']. ')</option>';
            }
            $htmlTableRaw.='</select></td></tr>';
            $htmlTableRaw .= '';
            // return $htmlTableRaw;
            $view->htmlTableRaw = $htmlTableRaw;
			$tradeid1=TVECtrade::where("Deleted","=",0)->get();
			$view->tradeid=$tradeid1;
            $tradeid = Course::where('CourseListCode', '=', $courseYearPlan->CourseListCode)->pluck('TradeId');
            //return $tradeid; 
            $com = NVQcompetencystandard::where('Deleted', '=', 0)->where('tradeid', '=', $tradeid)->get();
            $view->courseYearPlan = $courseYearPlan;
            $view->com = $com;
            return $view;
        } else {

            $package = Input::get('package_ids');
            $selectedmodules = Input::get('Module_ids');
            $cypID = Input::get('cypID');
            //return $package = Input::get('package');
            // return $modules;
            $CourseListCode = Input::get('CourseListCode');
           // $batch = Input::get('batch');
           // $startDate = Input::get('startDate');
           // $maxCapacity = Input::get('maxCapacity');
          //  $medium = Input::get('medium');
          //  $fee = Input::get('fee');
          //  $feeType = Input::get('feeType');
            $userID = User::getSysUser()->userID;
            $Instructor = Input::get('Instructor');
            
            $cscode=NVQQualificationPackage::whereIn("id",$package)->where("Deleted","=",0)->lists("cscode");

            $com_id=NVQcompetencystandard::whereIn("code",$cscode)->where("Deleted","=",0)->lists("id");

            // $modules=Input::get('modules');
//            if (count($modules) <= 0) {
//                return Redirect::back()->withErrors('Required to select One Or More Modules To complete this Action');
//            }
            $instructorCheckArray = array();
            foreach ($Instructor as $i) {
                if (in_array($i, $instructorCheckArray)) {
                    return Redirect::back()->withErrors('The Same Instructor has been Selected Twice');
                }
                $instructorCheckArray[] = $i;
            }
            if($selectedmodules!=""){
            foreach ($selectedmodules as $m) {
                $courseyearplanmodules = new Courseyearplanmodules;
                $courseyearplanmodules->courseListCode = $CourseListCode;
                $courseyearplanmodules->cypID = $cypID;
                $courseyearplanmodules->moduleID = $m;
                $courseyearplanmodules->User = $userID;
                $courseyearplanmodules->save();
            }
        }
            if($package!=""){
            foreach ($package as $p) {
                $qualificationpackage = new Courseyearplanqualificationpackage;
                $qualificationpackage->cypID = $cypID;
                $qualificationpackage->packageID = $p;
                $qualificationpackage->save();
            }
            
            }
            if($Instructor!="" ){
            foreach ($Instructor as $i) {
                $courseyearplaninstructor = new Courseyearplaninstructor;
                $courseyearplaninstructor->cypID = $cypID;
                $courseyearplaninstructor->empID = $i;
                $courseyearplaninstructor->User = $userID;
                $courseyearplaninstructor->save();
            }
        }

            $coureseYearPaln = CourseYearPlan::where('id', '=', $cypID)
                    ->first();
           // $coureseYearPaln->maxCapacity = $maxCapacity;
            $coureseYearPaln->confirm = 1;
            $coureseYearPaln->confirmChage = 1;
           // $coureseYearPaln->medium = $medium;
           // $coureseYearPaln->feeType = $feeType;
           // $coureseYearPaln->fee = $fee;
          //  $coureseYearPaln->startDate = $startDate;
            $coureseYearPaln->Changed = 1;
            $coureseYearPaln->save();
			
			if($com_id !=""){
            foreach ($com_id as $id) 
				{
                $comstandard = new Courseyearplancompetency;
                $comstandard->cyp_id=$cypID;
                $comstandard->cs_id=$id;
                $comstandard->User=$userID;
                $comstandard->save();

				}
			}
           





//                $qualificationpackage=new Courseyearplanqualificationpackage;
//                $qualificationpackage->cypID=$cypID;
//                $qualificationpackage->packageID=$packageID;
//                $qualificationpackage->save();

            return Redirect::to('ConfirmCourseYearPlanFirstPage');
        }
    }
	
public function getcompetencystandardnew() {
    $typeid = Input::get('corseid');
   // return $typeid;
   // $res = DB::select(DB::raw("select id,trainingName from emptrainingprograme where Deleted=0
           // and type_id='$typeid'"));
    //$com = NVQcompetencystandard::where('Deleted', '=', 0)->where('tradeid', '=', $typeid)->get();
    $sql="SELECT *
  FROM nvqcompetencystandard n
  WHERE n.Deleted=0
  AND n.tradeid='$typeid'";
  $com = DB::select(DB::raw($sql));
         return json_encode($com);

 }


    public function ajaxGetFeePartFull() {
        $couseDetails = Course::where('Deleted', '=', 0)
                ->where('CourseListCode', '=', Input::get('couseListCode'))
                ->first();
        if (count($couseDetails) > 0) {
            return $couseDetails->CourseType;
        } else {
            return '';
        }
    }

    public function ConfirmCourseYearPlanFirstPage() {
        $method = Request::getMethod();
        $view = View::make('CourseYearPlan.ConfirmCourseYearPlanFirstPage');
        $array = array();
        $array[0] = date('Y') - 1;
        $array[1] = date('Y');
        $array[2] = date('Y') + 1;
        $view->CourseYearPlan = CourseYearPlan::where('instId', '=', User::getSysUser()->instituteId)
                ->where('Deleted', '=', 0)
                ->whereIn('year', $array)
                //->where('OrgId', '=', User::getSysUser()->organisationId)
                ->groupBy('OrgId')
                ->get();
        return $view;
    }

    public function ConfirmCourseYearPlan() {
        $method = Request::getMethod();
        if ($method == 'GET') {
            $array = array();
            $array[0] = date('Y') - 1;
            $array[1] = date('Y');
            $array[2] = date('Y') + 1;
            $view = View::make('CourseYearPlan.ConfirmCourseYearPlan');          
            
            
            $CourseYearPlan = CourseYearPlan::where('instId', '=', User::getSysUser()->instituteId)
                    ->where('Deleted', '=', 0)
                    ->where('OrgId', '=', Input::get('OrgId'))
                    ->whereIn('year', $array)
                    ->orderBy('startDate', 'Year', 'Desc', 'confirm')
                    ->get();
//          
//            $view->coursename =Course::where('CourseListCode', '=', $CourseYearPlan->CourseListCode)
//                    ->where('Deleted', '!=', 1)
//                    ->get();
             $view->CourseYearPlan=$CourseYearPlan;
            return $view;
        } else {
            $CourseYearPlan = CourseYearPlan::findOrFail(Input::get('id'));
            $CourseYearPlan->confirm = Input::get('confirm');
            $CourseYearPlan->confirmChage = 1;
            $CourseYearPlan->save();
            return $CourseYearPlan->confirm;
        }
    }

    public function editCourseYearPlan() {
        switch (Request::getMethod()) {
            case 'GET':
			// By Amila
			$sql="select usertype.UType
                from usertype
                left join user on
                user.userType=usertype.id
                where user.userID='".User::getSysUser()->userID."'";
          $uType=DB::select(DB::raw($sql));
		//
          $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');

           $CourseListCode1 = Course::where('Deleted', '=', 0)
                ->orderBy('CourseListCode')
                ->get();
     // return    $cyp=Input::get('edit_id');
                $view = View::make('CourseYearPlan.EditCourseYearPlan');
                $view->CourseListCode = Course::where('Deleted', '=', 0)
                ->orderBy('CourseListCode')
                ->get();
                $view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
            $CourseYearPlan1 = CourseYearPlan::find(Input::get('edit_id'));
         $temp_yr=$CourseYearPlan1->startDate;

           $view->OrgaType=$OrgaType;
            $view->date=trim($temp_yr);
			$view->CourseLevel=trim($CourseYearPlan1->CourseLevel);
			$view->district=District::orderBy('DistrictName')->get();
			$GetOrgaID = $CourseYearPlan1->OrgId;
			$DistrictCode = Organisation::where('id','=',$GetOrgaID)->pluck('DistrictCode');
			$NVQLevel =Course::where('CourseListCode','=',$CourseYearPlan1->CourseListCode)
							->where('Deleted', '!=', 1)
							->pluck('Nvq');
			$view->NVQ=trim($NVQLevel);
			$view->district_R = $DistrictCode;
			$view->organisation_R = $GetOrgaID;

              $view->CourseYearPlan=$CourseYearPlan1;
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
              $organisation=Organisation::where('Deleted','=',0)->whereIn('Active',['Yes','Closed'])->whereNotIn('Type',['HO','PO','DO'])->where('DistrictCode','=',$DistrictCode)->orderBy('OrgaName')->get();
              $view->organisation=$organisation;
                // $view->CourseYearPlan = CourseYearPlan::where("Deleted","=",0);
                return $view;
                break;
                case 'POST':
                $validator = CourseYearPlan::validate(Input::all());
                if ($validator->passes()) {
                    $cyp = CourseYearPlan::find(Input::get('edit_id'));
                    $orgID = Input::get('edit_id');
                        $district = Input::get('district'); 
                        $parallel_batch = Input::get('parallel_batch');
                    
                        $medium=Input::get('medium');
                        $maxCapacity=Input::get('maxCapacity');
                        
                        $year = Input::get('Year');
                      
                        $CourseLevel = Input::get('CourseLevel');
                       
                        
						//$CD_ID = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CD_ID');
                        $CD_ID = Input::get('CourseListCode');
						$CourseListCode = Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
                        $batch = Input::get('batch');
                        $attachedCenter = Input::get('attachedCenter');
                        $attachedCenterid = Input::get('attachedCenterid');
                        
                        // $Accredit =  Input::get('Accredit');
						// $AccreditRecommendDate = Input::get('AccreditRecommendDate');
                        // $AccreditDate =  Input::get('AccreditDate');
						// $AccreditValidDate = Input::get('AccreditationValidDate');
						
                        //$instructorEPF = Input::get('InstructorList');
						//$instructorEPF2 = Input::get('InstructorList1');
						//$instructorName1 = MOInstructor::where('EPFNo','=',$instructorEPF)->pluck('Name');
						//$instructorName2 = MOInstructor::where('EPFNo','=',$instructorEPF2)->pluck('Name');


                    $cyp->CourseLevel = Input::get('CourseLevel');  
                    $CourseYearPlan = CourseYearPlan::where('instId', '=', User::getSysUser()->instituteId)
                        ->where('id', '=', $orgID)
                        ->where('CD_ID', '=', $CD_ID)
                        ->where('Year', '=', $year)
                        ->where('batch', '=', $batch)
                        ->where('Deleted', '=', 0)
                        ->get();
                /* if (count($CourseYearPlan) != 0) {
                    $error = 'Already Planned this Plan<br>Year : ' . $year . '<br>Course List Code : ' . $CourseListCode . '<br>Batch : ' . $batch;
                    return Redirect::back()->withErrors($error);
                } */
               /* else{*/
                        



                       
                        $cyp->instId = User::getSysUser()->instituteId;
                        //$cyp->OrgId = $orgID;
                        $cyp->CourseListCode = $CourseListCode;
                        $cyp->Year = $year;
                        $cyp->confirm=1;
                        $cyp->batch = $batch;
                        $cyp->medium = $medium;
                        //$cyp->NoOfTrainees = Input::get('TCount');
                        //$cyp->Dropout = Input::get('DCount');
                        $cyp->CourseLevel = $CourseLevel;
                        $cyp->parallelGroups=$parallel_batch;
                        $cyp->maxCapacity=$maxCapacity;
                        //$cyp->startDate = $startDate;
                        //$cyp->ExamType = Input::get('ExamType');
                        $cyp->User = User::getSysUser()->userID;
						$cyp->CD_ID = $CD_ID;
                        $cyp->OrgId = Input::get('OrgId');
                        $cyp->attachedCenter = $attachedCenter;
                        $cyp->attachedCenterID = $attachedCenterid;
						$cyp->RealStartDate = Input::get('RealStartDate');
						$cyp->RealEndDate = Input::get('RealEndDate');
                       
                        // $cyp->Accredit = $Accredit;
						// if($Accredit == 'Yes')
						// {
							// $cyp->AccreditRecommendDate = $AccreditRecommendDate;
							// $cyp->AccreditDate = $AccreditDate;
							// $cyp->AccreditationValidDate = $AccreditValidDate;
							
						// }
						// elseif($Accredit == 'Recommended')
						// {
							// $cyp->AccreditRecommendDate = $AccreditRecommendDate;
							// $cyp->AccreditDate = '0000-00-00';
							// $cyp->AccreditationValidDate = '0000-00-00';
						// }
						// else{
							
							// $cyp->AccreditRecommendDate = '0000-00-00';
							// $cyp->AccreditDate = '0000-00-00';
							// $cyp->AccreditationValidDate = '0000-00-00';
						// }
                        //$cyp->AccreditDate = $AccreditDate;
                        //$cyp->CurrentInstructorEPF = $instructorEPF;
						//$cyp->CurrentInstructorEPF2 = $instructorEPF2;
                       // $cyp->InstructorName = $instructorName1;
						//$cyp->InstructorName2 = $instructorName2;
						//$cyp->StartedStatus = Input::get('StartedStatus');
                        $cyp->save();
                        $getMaxID = $orgID;
						$updatemomonitoringtimetableprogress = MOMonitoringTimeTableProgress::where('YearPlanID','=',Input::get('edit_id'))->update(array('CourseListCode' => $CourseListCode));
						$updatemomonitoringtimetableprogressresult = MOMonitoringTimeTableProgressResult::where('YearPlanID','=',Input::get('edit_id'))->update(array('CourseListCode' => $CourseListCode));
                            /*$update = YearPlanInstructorTrans::where('YearPlanId','=',$getMaxID)->update(array('Active' => '0'));
							if(!empty(Input::get('InstructorList')))
							{
                            $t = new YearPlanInstructorTrans();
                            $t->YearPlanId = $getMaxID;
                            $t->MoInstructorEPF = $instructorEPF;
                            $t->User =  User::getSysUser()->userID;
                            $t->save();
							}
							if(!empty(Input::get('InstructorList')))
							{
							$t = new YearPlanInstructorTrans();
                            $t->YearPlanId = $getMaxID;
                            $t->MoInstructorEPF = $instructorEPF2;
                            $t->User =  User::getSysUser()->userID;
                            $t->save();
							}*/
                        return Redirect::to('viewCourseYearPlan');
                    /*}*/
                } 
                else {
                    return Redirect::back()->withErrors($validator);
                }
                break;
            default:
                break;
        }
    }

    public function CreateCourseYearPlanOne() {
        $method = Request::getMethod();
        $view = View::make('CourseYearPlan.ViewCourseYearPlanOne');
        $view->CourseListCode = Course::where('Deleted', '=', 0)
                ->where('InstituteId', '=', User::getSysUser()->instituteId)
                ->orderBy('CourseListCode')
                ->get();
        if ($method == "GET") {
			$view->district=District::orderBy('DistrictName')->get();
          /**  $view->Oraganization = Organisation::where('Deleted', '=', 0)
                  ->where('Active','!=','No')
                    ->orderBy('OrgaName')
                    ->get(); **/
            $view->Module = Module::where('Deleted', '=', 0)
                    ->orderBy('ModuleName')
                    ->get();

             $view->orgID_R = Input::get('org_id');
             $view->district_R = Input::get('district');
             $view->year_R = Input::get('year');
             //$view->startDate_R = trim(Input::get('startdate'));
             $view->batch_R = Input::get('batch');  
             $view->medium_R = Input::get('medium');
             $view->parallel_batch_R = Input::get('parallel_batch');
             $view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();

            return $view;
        }
        if ($method == "POST") {
            $validator = CourseYearPlan::validate(Input::all());
            if ($validator->passes()) {
                $orgID = Input::get('OrgId');
                $district = Input::get('district'); 
                $parallel_batch = Input::get('parallel_batch');
            //return 
                $medium=Input::get('medium');
                $maxCapacity=Input::get('maxCapacity');
                //$orgID = User::getSysUser()->organisationId;
                $year = Input::get('Year');
               // $Nvq = Input::get('Nvq');
				$CourseLevel = Input::get('CourseLevel');
                //$coursefee = Input::get('CourseFee');
                $CD_ID = Input::get('CourseListCode');
				$CourseListCode = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseListCode');
                //$startDate = Input::get('startDate');
                $batch = Input::get('batch');
                $attachedCenter = Input::get('attachedCenter');
                $attachedCenterid = Input::get('attachedCenterid');
                //$description = Input::get('description');
				// $Accredit =  Input::get('Accredit');
				// $AccreditRecommendDate = Input::get('AccreditRecommendDate');
                // $AccreditDate =  Input::get('AccreditDate');
				// $AccreditValidDate = Input::get('AccreditationValidDate');
               $RealStartDate = Input::get('RealStartDate');
               // $instructorEPF = Input::get('InstructorList');
			   //$instructorEPF2 = Input::get('InstructorList1');
               // $instructorName1 = MOInstructor::where('EPFNo','=',$instructorEPF)->pluck('Name');
			   //$instructorName2 = MOInstructor::where('EPFNo','=',$instructorEPF2)->pluck('Name');

                $CourseYearPlan = CourseYearPlan::where('instId', '=', User::getSysUser()->instituteId)
                        ->where('OrgId', '=', $orgID)
                        ->where('CD_ID', '=', $CD_ID)
                        ->where('Year', '=', $year)
                        ->where('batch', '=', $batch)
                        ->where('Deleted', '=', 0)
                        ->get();
                /* if (count($CourseYearPlan) != 0) {
                    $error = 'Already Planned this Plan<br>Year : ' . $year . '<br>Course List Code : ' . $CourseListCode . '<br>Batch : ' . $batch;
                    return Redirect::back()->withErrors($error);
                }
                else
                { */
                $cyp = new CourseYearPlan();
                $cyp->instId = User::getSysUser()->instituteId;
                $cyp->OrgId = $orgID;
                $cyp->CourseListCode = $CourseListCode;
                $cyp->Year = $year;
		        $cyp->confirm=0;
                $cyp->batch = $batch;
                $cyp->medium = $medium;
                // $cyp->CourseFee = $coursefee;
                //$cyp->Nvq = $Nvq;
                $cyp->CourseLevel = $CourseLevel;
                $cyp->parallelGroups=$parallel_batch;
                $cyp->maxCapacity=$maxCapacity;
                //$cyp->startDate = $startDate;
                //$cyp->ExamType = Input::get('ExamType');
                $cyp->User = User::getSysUser()->userID;
				$cyp->CD_ID = $CD_ID;
                //$cyp->RealstartDate = $RealStartDate;
				$Duration1 = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
				$endDate = MONewCenterMonitoringPlan::getEndDate($RealStartDate,$Duration1);
				$cyp->RealEndDate = $endDate;
                $cyp->attachedCenter = $attachedCenter;
                $cyp->attachedCenterID = $attachedCenterid;
				$cyp->RealStartDate = Input::get('RealStartDate');
				$cyp->RealEndDate = Input::get('RealEndDate');
                //$cyp->Description = $description;
                // $cyp->Accredit = $Accredit;
						/* if($Accredit == 'Yes')
						{
							$cyp->AccreditRecommendDate = $AccreditRecommendDate;
							$cyp->AccreditDate = $AccreditDate;
							$cyp->AccreditationValidDate = $AccreditValidDate;
							
						}
						elseif($Accredit == 'Recommended')
						{
							$cyp->AccreditRecommendDate = $AccreditRecommendDate;
							$cyp->AccreditDate = '0000-00-00';
							$cyp->AccreditationValidDate = '0000-00-00';
						}
						else{
							
							$cyp->AccreditRecommendDate = '0000-00-00';
							$cyp->AccreditDate = '0000-00-00';
							$cyp->AccreditationValidDate = '0000-00-00';
						} */
                //$cyp->CurrentInstructorEPF = $instructorEPF;
				//$cyp->CurrentInstructorEPF2 = $instructorEPF2;
                //$cyp->InstructorName = $instructorName1;
				//$cyp->InstructorName2 = $instructorName2;

                $cyp->save();

               /*  $getMaxID = CourseYearPlan::max('id');
                $update = YearPlanInstructorTrans::where('YearPlanId','=',$getMaxID)->update(array('Active' => '0'));
				if(!empty(Input::get('InstructorList')))
				{
                $t = new YearPlanInstructorTrans();
                $t->YearPlanId = $getMaxID;
                $t->MoInstructorEPF = $instructorEPF;
                $t->User =  User::getSysUser()->userID;
                $t->save();
				}
				if(!empty(Input::get('InstructorList1')))
				{
                $t = new YearPlanInstructorTrans();
                $t->YearPlanId = $getMaxID;
                $t->MoInstructorEPF = $instructorEPF2;
                $t->User =  User::getSysUser()->userID;
                $t->save();
				} */
				
                return Redirect::to('CreateCourseYearPlanOne?org_id='.$orgID.'&year='.$year.'&batch='.$batch.'&district='.$district.'&medium='.$medium.'&parallel_batch='.$parallel_batch.'')
                                ->with('message',"Course Year Plan added successesfully !");
            /* } */ 
        }
        else {
                return Redirect::back()->withErrors($validator);
            }
    }

}
	
	public function ajaxOrganisationLoad(){
		$district = Input::get('district');
      //  $orgID_R = Input::get('orgID_R');
		 $OrgId=Organisation::where('DistrictCode','=',$district)->where('Deleted','=',0)->where('TypeId','!=',5)->orderBy('OrgaName')->get();
        $abc = "<select name=\"OrgId\" id=\"OrgId\">
                <option value=\"\">---Select---</option>";
        // foreach ($OrgId as $d) {
        //     $abc .= '<option value=\"$d->id\"';
        //     if($d->id == $orgID_R){
        //         $abc .= 'selected';
        //     } 
        //     $abc .='>$d->OrgaName</option>"';
        // }

        foreach ($OrgId as $d) {
            $abc .= "<option value=\"$d->id\">$d->OrgaName - $d->Type</option>";
        }
       
        echo $abc;
	}
	
	public function ajaxGetNvqLevelCourse(){
		$CourseListCode = Input::get('CourseListCode');
		$Course = Course::where('CD_ID','=',$CourseListCode)->where('Deleted', '!=', 1)->first();
		$html ='<option value=""></option>';
		if(!empty($Course)){
			if($Course->Nvq=='NVQ'){
			$html .='<option value="1">Level 1</option>
                        <option value="2">Level 2</option>
						<option value="3">Level 3</option>								
						<option value="4">Level 4</option>
						<option value="5">Level 5</option>
						<option value="6">Level 6</option>';				
			}
			else{
				$html .='<option value="Certificate">Certificate</option>
                        <option value="Diploma">Diploma</option>';
			}
		}
		return $html;
	}

    public function deleteCourseYearPlan() {
      $id = Input::get('id');
        $cyp = CourseYearPlan::findOrFail($id); // if not found show 404 page
        $cyp->Deleted = 1;
        $cyp->save();
        return Redirect::to('viewCourseYearPlan');
    }

    public function viewCourseYearPlan() {
        $method = Request::getMethod();
        $view = View::make('CourseYearPlan.viewCourseYearPlan');
        $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
        $orgatype = Organisation::where('id','=',User::getSysUser()->organisationId)->pluck('Type');
        $year=Date('Y');
        if($orgatype == 'HO')
        {
            $view->YearPlan = CourseYearPlan::where('Deleted', '=', 0)
                ->where('Year', '=', $year)
                ->orderBy('OrgId', 'Year', 'Desc')
                ->get();


        }
        else
        {
            $view->YearPlan = CourseYearPlan::where('Deleted', '=', 0)
                 ->where('OrgId', '=', User::getSysUser()->organisationId)
                 ->where('Year', '=', $year)
                ->orderBy('Year', 'Desc')
                ->get();
        }
        
        if ($method == "POST") {

            $year = Input::get('year');
            $orgatype = Organisation::where('id','=',User::getSysUser()->organisationId)->pluck('Type');

            if($year == 'All')
            {

                if($orgatype == 'HO')
                {
                         $view->YearPlan = CourseYearPlan::where('Deleted', '=', 0)
                        ->orderBy('OrgId','Year','Desc')
                        ->get();
                }
                else
                {
                        $view->YearPlan = CourseYearPlan::where('Deleted', '=', 0)
                         ->where('OrgId', '=', User::getSysUser()->organisationId)
                        ->orderBy('Year','Desc')
                        ->get();
                }

            }
            else
            {
                if($orgatype == 'HO')
                {
                    $view->YearPlan = CourseYearPlan::where('Deleted', '=', 0)
                      ->where('Year', '=', $year)
                      ->orderBy('OrgId','Year','Desc')
                      ->get();
                }
                else
                {
                    $view->YearPlan = CourseYearPlan::where('Deleted', '=', 0)
                          ->where('Year', '=', $year)
                         ->where('OrgId', '=', User::getSysUser()->organisationId)
                        ->orderBy('Year','Desc')
                        ->get();
                }

            }
           
        }
        return $view;
    }

    public function CreateCourseYearPlan() {
        $method = Request::getMethod();
        $view = View::make('CourseYearPlan.CreateCourseYearPlan');
        if ($method == "GET") {
            $arry = array();
            $c = 0;
            $date = date('Y') - 1;
            $nowYear = CourseYearPlan::where('Year', '=', date('Y'))
                    ->where('instId', '=', User::getSysUser()->instituteId)
                    ->where('OrgId', '=', User::getSysUser()->organisationId)
                    ->where('Deleted', '=', 0)
                    ->get();
            foreach ($nowYear as $v) {
                $arry[$c++] = $v->CourseListCode; //last code
            }
            if ($arry == null) {
                $view->BeforeYearPlan = CourseYearPlan::where('Year', '=', $date)
                        ->where('instId', '=', User::getSysUser()->instituteId)
                        ->where('OrgId', '=', User::getSysUser()->organisationId)
                        ->where('confirm', '=', 1)
                        ->where('Deleted', '=', 0)
                        ->get();
            } else {
                $view->BeforeYearPlan = CourseYearPlan::where('Year', '=', $date)
                        ->where('instId', '=', User::getSysUser()->instituteId)
                        ->where('OrgId', '=', User::getSysUser()->organisationId)
                        ->where('confirm', '=', 1)
                        ->where('Deleted', '=', 0)
                        ->whereNotIn('CourseListCode', $arry)
                        ->get();
            }
            $view->get = TRUE;
        } else {
            $view->get = FALSE;
            $BeforeYearPlan = array();
            $IdArray = Input::get('id');
            if ($IdArray == '') {
                $IdArray = array();
            }
            $c = 0;
            foreach ($IdArray as $id) {
                $BeforeYearPlan[$c++] = CourseYearPlan::where('id', '=', $id)->first();
            }
            $view->BeforeYearPlan = $BeforeYearPlan;
        }
        return $view;
    }

    public function CreateCourseYearPlan2() {
        $IdArray = Input::get('id');
        $y = date('Y');
        if ($IdArray == '') {
            $IdArray = array();
        }
        foreach ($IdArray as $id) {
            $cyp = new CourseYearPlan();
            $cyp->instId = User::getSysUser()->instituteId;
            $cyp->OrgId = User::getSysUser()->organisationId;
            $cyp->CourseListCode = Input::get('CourseListCode' . $id);
            $cyp->Year = $y;
            $cyp->batch = Input::get('batch' . $id);
            $cyp->medium = Input::get('medium' . $id);
            $cyp->Fee = Input::get('Fee' . $id);
            $cyp->parallelGroups = Input::get('parallelGroups' . $id);
            $cyp->AptitudeTest = Input::get('AptitudeTest' . $id);
            $cyp->startDate = Input::get('startDate');
            $cyp->User = User::getSysUser()->userID;
            $cyp->DateEntered = \Carbon\Carbon::now();
            $cyp->save();
        }
        return Redirect::to('viewCourseYearPlan');
    }

    public function ajaxCheckedValues() {
        
    }

    public function checkmodulepackage() {


        $moduleids = Input::get("moduleid");
        //return $moduleids;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    


        $arrmodule = array();
        $arrpackage = array();



        $package = NVQqualificationpackagemodule::where('Deleted', '=', 0)->lists('moduleid');



        $c = 0;

        foreach ($moduleids as $key => $m) {
            if (in_array($m, $package)) {
                $c++;
            }
            # code...
        }
        return $c;

        // return "aaaa";
    }

    public function getcomstandard() {
        $com = NVQcompetencystandard::where('Deleted', '=', 0)->pluck('name');
        $view->com = $com;
    }

    public function ajaxGetattachedCenter(){
        $attachedCenter = Input::get("attachedCenter");
         $html="";
        if($attachedCenter=='Yes'){
        $organisation=Organisation::where('Deleted','=',0)->where('Active','=','Yes')->where('Type','!=','HO')->orderBy('OrgaName')->get();
        $html.=" <div class='control-group'>
                    <label class='control-label' for='attachedCenterid'>Select Attached Centre : </label>
                        <div class='controls'>
                            <select name='attachedCenterid' id='attachedCenterid'>
                                <option value=''>-Select Centre-</option>";
                                 foreach($organisation as $o){
        $html.= "<option value=\"$o->id\">$o->OrgaName</option>";
                                }
         $html.="</select>
                        </div>
                </div>";
          }

          return $html;
    }

}
