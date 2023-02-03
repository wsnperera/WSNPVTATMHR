<?php

use SimpleExcel\SimpleExcel;


class ExamDivisionController extends BaseController {
	
	  public function ExamTEMPLoadTraineemodulelistwithresult()
  {

    $html = '';
    $Traineeid = Input::get('Traineeid');
    $sql = "select nvqmodule.id,nvqmodule.code,nvqmodule.name,nvqstudentunitresult.result 
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$Traineeid'";
       
        $test = DB::select(DB::raw($sql));


        $sql1 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$Traineeid'
  and nvqstudentunitresult.result='C'";
  $ModuleidList = DB::select(DB::raw($sql1));


        if (!empty($test)) {
            $html = '<pre><h6><center>Result For Units: <b></b></center></h6></pre>  
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
            <th class="center">Unit Code</th>
                    <th>Unit Name</th>                          
                    <th>Result</th>  
           </tr>
                    </thead>
                    <tbody>';
            foreach ($test as $e) {


                
                  $html .='<tr>
                              <td class="center" >' . $e->code . '</td>
                              <td>' . $e->name. '</td>
                              <td>' . $e->result. '</td>
                            </tr>';

                
               
              }

              $html.='</tbody></table>';
            }

          
        
        //return $html; 

            return json_encode(array('html' => $html, 'module' => $ModuleidList));


  }
	
	   public function ExamGETAjaxQualificationStudent() 
	   {

       $Traineeid = Input::get('ModuleList');
       $sqltemp = '0';
      
	  $sql1 = "select nvqunits.UID
				  from nvqstudentunitresult
				  left join nvqunits
				  on nvqstudentunitresult.UnitId=nvqunits.UID
				  where nvqstudentunitresult.Deleted=0
				  and nvqstudentunitresult.StudentId='$Traineeid'
				  and nvqstudentunitresult.result='C'";
				  
      $ModuleidList = DB::select(DB::raw($sql1));
        foreach ($ModuleidList as $sm) {
            $sqltemp .= "," . $sm->id . "";
        }

 // sqltemp

       // return $sqltemp;

/*
        $selectedmodules = (Input::has("selectedmodules") ? Input::get('selectedmodules') : array());
        //$newmodules = (Input::has("module") ? Input::get('module') : array());
        // $newselectedmodules=$selectedmodules+$newmodules;
        //return $newselectedmodules;
        $sqltemp = "";
        foreach ($selectedmodules as $sm) {
            $sqltemp .= ", '" . $sm['value'] . "'";
        }
*/

       

                    $sql = "select nvqqualificationpackage.packagecode,nvqqualificationpackage.id 
                    from nvqqualificationpackage
                    inner join nvqqualificationunit as a
                    on a.QualificationPackageId=nvqqualificationpackage.id
                    and a.UnitID in ($sqltemp)
                    left join nvqqualificationunit as b
                    on b.QualificationPackageId=nvqqualificationpackage.id and b.UnitID not in ($sqltemp)
                    where a.Deleted!='1'
                    and b.id is null
                    and nvqqualificationpackage.Deleted!='1'
                    group by nvqqualificationpackage.packagecode
                   ";
        $packages = DB::select($sql);
        //return $packages;
     /*   $html = '<div class="control-group">
                    <label class="control-label">Qualification Packages :</label>
                        <div class="controls"><label>';
        if (count($packages) === 0) {
            $html.='<span style="color:red" >No Qualification Package Available</span>';
        } else {
            foreach ($packages as $package) {
                $html .='<span class="lbl" name="package"> &nbsp;' . (isset($package->packagecode) ? $package->packagecode : "") . '.</span>
            <input name="package_ids[]" value="' . $package->id . '" type="hidden">
           ';
            }


        }

        $html .='</label></div>
                </div>';
        return $html;*/

        /*------------------------------------------*/
        $html = '<div class="control-group">
                    <label class="control-label">Qualification Packages :</label>
                        <div class="controls">';
                       if (count($packages) === 0) {
            $html.='<span style="color:red" >No Qualification Package Available</span>';
        }
        else
        {
          foreach ($packages as $package) {
            $html.='<input type="text" name="Package" id="Package" value="'.$package->packagecode.'" readonly/><input name="package_ids[]" value="' . $package->id . '" type="hidden">';
          }
        }
        $html .='</div>
                </div>';
        return $html;

        
}
	
   public function ExamTEMPLoadTraineeList()
  {
    $CourseYearPlanID = Input::get('AssessmentNo');
    $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');

            $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
				  $total = DB::select(DB::raw($sql));
				  $totalrep = DB::select(DB::raw($sql2));
          $json = array("Trainee" => $total, "Repeaters" => $totalrep);
            return json_encode($json);

  }
	
  public function ExamTempViewResult()
  {
    $method=Request::getMethod();
    $view = View::make('Assessor.TempViewResult');
  $sql1 = "select courseyearplan.id,courseyearplan.AssessmentNo
			  from courseyearplan
			  where courseyearplan.Deleted=0
			  and courseyearplan.AssessmentNo is not null
			  order by courseyearplan.AssessmentNo";
			  
		  $Assnumbers = DB::select(DB::raw($sql1));
		   $view->Assnumbers = $Assnumbers;

    if($method == 'GET')
    {
      return $view;
    }
    if($method == 'POST')
    {
    }

  }
	
	  public function ExamConfirmResultCenter()
  {
     $CYPID = Input::get('CS_ID');
  
    $updateCourseYearPlan = CourseYearPlan::where('id','=',$CYPID)->update(array('CenterConfirmResult' => 1));

    return Redirect::to('ExamreturnToTraineeList?AssessmentNo='.$CYPID);

  }
	
	  public function ExamreturnToTraineeList()
  {

       $method=Request::getMethod();
        $view = View::make('Assessor.EnterExamResult1');
         $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;

       if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type',['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }
		
		
		 $sql1 = "select courseyearplan.id,courseyearplan.AssessmentNo
			  from courseyearplan
			  where courseyearplan.Deleted=0
			  and courseyearplan.AssessmentNo is not null
			  order by courseyearplan.AssessmentNo";
			  
		  $Assnumbers = DB::select(DB::raw($sql1));
		   $view->Assnumbers = $Assnumbers;
      /*    $center = Input::get('center');
          $CS_ID = Input::get('Course');
          $comS = Input::get('comS'); */
		  
		  $CourseYearPlanID = Input::get('AssessmentNo');
		  $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');

         $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
				  $total = DB::select(DB::raw($sql));
				  $totalrep = DB::select(DB::raw($sql2));
				  $view->Trainees = $total;
				  $view->TraineesRep = $totalrep;
				  $view->CourseYearPlanID = $CourseYearPlanID;
				  $view->AssesmentNo = $AssessmentNo;
				 
				  return $view;

  }
	
   public function ExamSaveModuleResult()
  {
    $FinalExamFacedCYPID = Input::get('CYPID');
    $T_ID = Input::get('T_ID');
    $CDID = Input::get('CDID');
	$COMTCode = Input::get('COMTCode');
	$VersionNo = Input::get('VersionNo');
    $ModuleListarray = Input::get('ModuleList');
    $resultList = Input::get('ResultList');
    $getcountResultList = Count($resultList);
	$FinalExamAssessmentNo = CourseYearPlan::where('id','=',$FinalExamFacedCYPID)->pluck('AssessmentNo');
    $TraineeOriginalCYPID = IRTrainee::where('id','=',$T_ID)->pluck('CourseYearPlanID');	
	
    $CresultArray = array();
    $packageIDArray = array();
    $deleteNVQStudentUnitResult = NVQStudentUnitResult::where('Deleted','=',0)->where('StudentId','=',$T_ID)->where('FinalExamAssessmentNo','=',$FinalExamAssessmentNo)->update(array('Deleted' => 1));
	$deleteNVQstudentPackage = NVQStudentPackage::where('Deleted','=',0)->where('StudentID','=',$T_ID)->where('FinalExamAssessmentNo','=',$FinalExamAssessmentNo)->update(array('Deleted' => 1));
	$deleteNVQstudentModuleROA = NVQStudentUnitROA::where('Deleted','=',0)->where('StudentID','=',$T_ID)->where('FinalExamAssessmentNo','=',$FinalExamAssessmentNo)->update(array('Deleted' => 1));
//ok
    $i = 0;
    for($i=0;$i<$getcountResultList;$i++)
    {
      if($resultList[$i] == 'C' || $resultList[$i] == 'N' || $resultList[$i] == 'A')
      {
		  
        //return $resultList[$i];
      
        $v = new NVQStudentUnitResult();
		$v->CYPID = $TraineeOriginalCYPID;
        $v->StudentId = $T_ID;
		$v->FinalExamAssessmentNo = $FinalExamAssessmentNo;
		$v->ExamFacedCYPID = $FinalExamFacedCYPID;
        $v->UnitId = $ModuleListarray[$i];
        $v->result = $resultList[$i];
        $v->User =User::getSysUser()->userID; 
        $v->Save(); 
		
        if($resultList[$i] == 'C')
        {
          $CresultArray[] = $ModuleListarray[$i];
        }


      }
      
      
    }
	
    //return $CresultArray;
      $sqltemp = '0';
	  $sql1 = "select distinct nvqunits.UID,nvqunits.UnitCode,nvqunits.UnitName,nvqunits.UnitVersion
	  from nvqqualificationunit
	  left join nvqqualificationpackage
	  on nvqqualificationunit.QualificationPackageId=nvqqualificationpackage.id
	  left join nvqunits
	  on nvqqualificationunit.UnitID=nvqunits.UID
	  where nvqqualificationunit.Deleted=0
	  and nvqqualificationpackage.cscode='".$COMTCode."'
	  and nvqunits.UnitVersion='".$VersionNo."'
	  order by nvqunits.UnitCode";
  
	  $ModuleidList = DB::select(DB::raw($sql1));
	  
        foreach ($ModuleidList as $sm) 
		{

            $sqltemp .= "," . $sm->UID . "";
        }
    
	 //return  $sqltemp;

	//get nvq packages that can give for this student based on his results
    $sql = "SELECT
				  nvqqualificationpackage.packagecode,
				  nvqqualificationpackage.id
				FROM nvqqualificationpackage
				  INNER JOIN nvqqualificationunit AS a
					ON a.QualificationPackageId = nvqqualificationpackage.id
					AND a.UnitID IN ($sqltemp)
				  LEFT JOIN nvqqualificationunit AS b
					ON b.QualificationPackageId = nvqqualificationpackage.id
					AND b.UnitID NOT IN ($sqltemp)
				WHERE a.Deleted != '1'
				AND b.id IS NULL
				AND nvqqualificationpackage.Deleted != '1'
				GROUP BY nvqqualificationpackage.packagecode
                    ";
      $packages = DB::select(DB::raw($sql));

      //return  $packages;
	  
	

      if(!empty($packages))
      {

        foreach ($packages as $p) {

          $packageIDArray = $p->id;

          $v = new NVQStudentPackage();
          $v->CYPID = $TraineeOriginalCYPID;
          $v->StudentID = $T_ID;
          $v->FinalExamAssessmentNo = $FinalExamAssessmentNo;
          $v->ExamFacedCYPID = $FinalExamFacedCYPID;
          $v->PackageID = $p->id;
          $v->VersionNo = $VersionNo;
          $v->User = User::getSysUser()->userID; 
          $v->save();
         

        }
  
        //compare unit list
        /*  $sql2 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$T_ID'
  and nvqstudentunitresult.result='C'
  and nvqmodule.id NOT IN (select distinct nvqmodule.id
                        from nvqqualificationpackagemodule
                        left join nvqmodule
                        on nvqqualificationpackagemodule.moduleid=nvqmodule.id
                        where nvqqualificationpackagemodule.Deleted=0
                        and nvqqualificationpackagemodule.packageid in(select nvqqualificationpackage.id 
                                                                  from nvqqualificationpackage
                                                                  inner join nvqqualificationpackagemodule as a
                                                                  on a.packageid=nvqqualificationpackage.id
                                                                  and a.moduleid in ($sqltemp)
                                                                  left join nvqqualificationpackagemodule as b
                                                                  on b.packageid=nvqqualificationpackage.id and b.moduleid not in ($sqltemp)
                                                                  where a.Deleted!='1'
                                                                  and b.id is null
                                                                  and nvqqualificationpackage.Deleted!='1'
                                                                  group by nvqqualificationpackage.packagecode))"; */
																  
  $sql2 = "select nvqunits.UID
  from nvqstudentunitresult
  left join nvqunits
  on nvqstudentunitresult.UnitId=nvqunits.UID
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$T_ID'
  and nvqstudentunitresult.result='C'
  and nvqunits.UID NOT IN (select distinct nvqunits.UID
                        from nvqqualificationunit
                        left join nvqunits
                        on nvqqualificationunit.UnitID=nvqunits.UID
                        where nvqqualificationunit.Deleted=0
                        and nvqqualificationunit.QualificationPackageId in(select nvqqualificationpackage.id 
                                                                  from nvqqualificationpackage
                                                                  inner join nvqqualificationunit as a
                                                                  on a.QualificationPackageId=nvqqualificationpackage.id
                                                                  and a.UnitID in ($sqltemp)
                                                                  left join nvqqualificationunit as b
                                                                  on b.QualificationPackageId=nvqqualificationpackage.id 
                                                                  and b.UnitID not in ($sqltemp)
                                                                  where a.Deleted!='1'
                                                                  and b.id is null
                                                                  and nvqqualificationpackage.Deleted!='1'
                                                                  group by nvqqualificationpackage.packagecode))";

         $OriginalpackageModuleListROA = DB::select(DB::raw($sql2));

         if(count($OriginalpackageModuleListROA) != 0)
         {
            foreach($OriginalpackageModuleListROA as $a)
            {

              $c = new NVQStudentUnitROA();
              $c->CYPID = $TraineeOriginalCYPID;
              $c->StudentID = $T_ID;
              $c->FinalExamAssessmentNo = $FinalExamAssessmentNo;
              $c->ExamFacedCYPID = $FinalExamFacedCYPID;
			  $c->VersionNo = $VersionNo;
              $c->UnitId = $a->id;
              $c->User = User::getSysUser()->userID; 
              $c->save();

            }

         }




      }
      else
      {

        //No any Packages available;
        $sql11 = "select nvqunits.UID
				  from nvqstudentunitresult
				  left join nvqunits
				  on nvqstudentunitresult.UnitId=nvqunits.UID
				  where nvqstudentunitresult.Deleted=0
				  and nvqstudentunitresult.StudentId='$T_ID'
				  and nvqstudentunitresult.result='C'";
        $ModuleidList = DB::select(DB::raw($sql11));
   foreach ($ModuleidList as $sm) {

			  $c = new NVQStudentUnitROA();
              $c->CYPID = $TraineeOriginalCYPID;
              $c->StudentID = $T_ID;
              $c->FinalExamAssessmentNo = $FinalExamAssessmentNo;
              $c->ExamFacedCYPID = $FinalExamFacedCYPID;
			  $c->VersionNo = $VersionNo;
              $c->UnitId = $sm->id;
              $c->User = User::getSysUser()->userID; 
              $c->save();
            
        }



      }

          
//ok
    if($TraineeOriginalCYPID == $FinalExamFacedCYPID)
	{
		//Original Batch student with his 1st attempt
		$updateTrainee = IRTrainee::where('id','=',$T_ID)->update(array('FinalAssessHeld' => 1,'FResultEntered' => 1));
		
	}
	else{
		//Repeat Batch student with his 2nd or third  attempt
		$updateTrainee = IRTrainee::where('id','=',$T_ID)->update(array('FinalAssessHeld' => 1,'FResultEntered' => 1));
		$updateTraineeTrans = ExamRepeaterTrainees::where('T_ID','=',$T_ID)->where('OriginalCYPassessmentNo','=',$FinalExamAssessmentNo)->update(array('FinalAssessHeld' => 1,'FResultEntered' => 1));
		
	}
    
    $updateCourseYearPlan = CourseYearPlan::where('id','=',$FinalExamFacedCYPID)->update(array('FinalExamHeld' => 1));

     return Redirect::to('ExamreturnToTraineeList?AssessmentNo='.$FinalExamFacedCYPID);
//return Redirect::to('returnToTraineeList?AssessmentNo='.$FinalExamFacedCYPID.'&&comS='.$comS);
  }
	
	public function ExamNewEULoadStudentExamResultEnterOriginal()
  {
     $view = View::make('Assessor.StudentUnitResult');
	 $method=Request::getMethod();
    $CYPID = Input::get('CDID');
    $T_ID = Input::get('asnid');
	$VersionNo = '';
	$CDID = CourseYearPlan::where('id','=',$CYPID)->pluck('CD_ID');
	$COMTCode = Course::where('CD_ID','=',$CDID)->pluck('ComStand');
	
  
    
   
   $sql1 = "select distinct nvqunits.UnitVersion
  from nvqqualificationunit
  left join nvqqualificationpackage
  on nvqqualificationunit.QualificationPackageId=nvqqualificationpackage.id
  left join nvqunits
  on nvqqualificationunit.UnitID=nvqunits.UID
  where nvqqualificationunit.Deleted=0
  and nvqqualificationpackage.cscode='".$COMTCode."'
  order by nvqunits.UnitVersion";
  
  $Verions = DB::select(DB::raw($sql1));
    $view->CYPID=$CYPID;
    $view->T_ID=$T_ID;
    $view->CDID=$CDID;
	$view->COMTCode=$COMTCode;
	$view->Verions = $Verions;
	$view->VersionNo = $VersionNo;
     if($method == 'GET')
     {
            return $view;
     }
	 if($method == 'POST')
     {
            $CYPID = Input::get('CYPID');
			$T_ID = Input::get('T_ID');
			$CDID = Input::get('CDID');
			$COMTCode = Input::get('COMTCode');
			$Version = Input::get('Version');
			
			 $sql1 = "select distinct nvqunits.UnitVersion
  from nvqqualificationunit
  left join nvqqualificationpackage
  on nvqqualificationunit.QualificationPackageId=nvqqualificationpackage.id
  left join nvqunits
  on nvqqualificationunit.UnitID=nvqunits.UID
  where nvqqualificationunit.Deleted=0
  and nvqqualificationpackage.cscode='".$COMTCode."'
  order by nvqunits.UnitVersion";
  
  $Verions = DB::select(DB::raw($sql1));
			
	  $sql = "select distinct nvqunits.UID,nvqunits.UnitCode,nvqunits.UnitName
	  from nvqqualificationunit
	  left join nvqqualificationpackage
	  on nvqqualificationunit.QualificationPackageId=nvqqualificationpackage.id
	  left join nvqunits
	  on nvqqualificationunit.UnitID=nvqunits.UID
	  where nvqqualificationunit.Deleted=0
	  and nvqqualificationpackage.cscode='".$COMTCode."'
	  and nvqunits.UnitVersion='".$Version."'
	  order by nvqunits.UnitCode";
    $total = DB::select(DB::raw($sql)); 
	$view->Module = $total; 
	$view->CYPID=$CYPID;
    $view->T_ID=$T_ID;
    $view->CDID=$CDID;
	$view->COMTCode=$COMTCode;
	$view->Verions = $Verions;
	$view->VersionNo = $Version;
			
	return $view;		
     }
  }
	
	  public function ExamNewEUExamResultEnter()
  {
        $method=Request::getMethod();
        $view = View::make('Assessor.EnterExamResult1');
         $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;
        
        if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type',['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }
		
		 $sql1 = "select courseyearplan.id,courseyearplan.AssessmentNo
			  from courseyearplan
			  where courseyearplan.Deleted=0
			  and courseyearplan.AssessmentNo is not null
			  order by courseyearplan.AssessmentNo";
			  
		  $Assnumbers = DB::select(DB::raw($sql1));
		   $view->Assnumbers = $Assnumbers;

         if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {

            //return 'hsgdfy';
           $CourseYearPlanID = Input::get('AssessmentNo');
		  $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');

            $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
				  $total = DB::select(DB::raw($sql));
				  $totalrep = DB::select(DB::raw($sql2));
				  $view->Trainees = $total;
				  $view->TraineesRep = $totalrep;
				  $view->CourseYearPlanID = $CourseYearPlanID;
				  $view->AssesmentNo = $AssessmentNo;
				 
				  return $view;

        }
    
  }
	
	  public function ExamPrintNVQAddmissionCard()
  {
    $view = View::make('Assessor.PrintAddmission');
     $method=Request::getMethod();
  
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;
        
        if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type',['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }
        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
           $District = Input::get('District');
          $CenterID = Input::get('CenterID');
          $Year = Input::get('Year');
		  $Batch = Input::get('Batch');
		  
		   $CourseYearPlanID = Input::get('CourseYearPlanID');
		  $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');

           $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					  and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
				  $total = DB::select(DB::raw($sql));
		  $totalrep = DB::select(DB::raw($sql2));
          $view->Trainees = $total;
		   $view->TraineesRep = $totalrep;
          $view->CourseYearPlanID = $CourseYearPlanID;
          $view->Center = $CenterID;
		  $view->District = $District;
		  $view->Year = $Year;
		  $view->Batch = $Batch;
          return $view;

        }
  }
	
	   public function ExamPrintAttendanceSheet3(){
		   
		$CourseYearPlanID = Input::get('CS_ID');
		$AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');
		$courseyerplanrec = CourseYearPlan::where('id','=',$CourseYearPlanID)->first();
		$getOrganame = Organisation::where('id','=',$courseyerplanrec->OrgId)->pluck('OrgaName');
		$CourseDetailsRec = Course::where('CD_ID','=',$courseyerplanrec->CD_ID)->first(); 
		
		$GetFinalAssDates = ExamFinalAssessmentDates::where('YearPlanID','=',$CourseYearPlanID)->where('Deleted','=',0)->orderBy('FinalAssessmentDate')->get();
		  $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					  and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
		  $total = DB::select(DB::raw($sql));
		  $totalrep = DB::select(DB::raw($sql2));
		
		$Packages = MOCenterMonitoringPlan::getPackages($CourseDetailsRec->CD_ID); 

	    $sql345 ="select distinct nvqunits.UnitCode,nvqunits.UnitName,nvqqualificationunit.UnitStatus,nvqunits.UnitVersion
					  from coursedetailpackages
					  left join nvqqualificationpackage
					  on coursedetailpackages.NVQualificationPackageID=nvqqualificationpackage.id
					  left join nvqqualificationunit
					  on nvqqualificationpackage.id=nvqqualificationunit.QualificationPackageId
					  left JOIN nvqunits
					  on nvqqualificationunit.UnitID=nvqunits.UID
					  where coursedetailpackages.CD_ID='".$CourseDetailsRec->CD_ID."'
					  and coursedetailpackages.Deleted=0";

	    $totalunits = DB::select(DB::raw($sql345));
					
      $html ='<html>

<head>
<title>AS01</title>
</head>    <body>';


	$html.='<center>
	<table style="width:100%;border-collapse:collapse;" border="0">
		<tr>
			<td style="width:20%">
			</td>
			<td style="width:60%"><center><b><h2><br/>COMPETENCY BASED ASSESSMENTS</h2></b></center>
			</td>
			<td style="width:5%">
			</td>
			<td style="width:15%"><center>
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="1"> 
					<tr>
						<td>AS- 01
						</td>
					</tr>
				</table></center>
			</td>
		</tr>
    </table></center>';
	$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="6">
		<tr>
			<td style="width:100%;border-collapse:collapse;border-bottom-color:#ffffff;" border="0">
				This form should be filled on completion of a Competency Base Assessment, signed by the Assessor/s and submitted to the Director in charge for the assessment of the training institute.
			</td>
		</tr>
		<tr>
			<td style="width:100%;border-collapse:collapse;border-bottom-color:#ffffff;" border="0">
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
					<tr style="">
						<td style="width:50%;border-bottom-color:#ffffff;">
						</td>
						<td style="width:50%;border-bottom-color:#ffffff;">
							
							<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
								<tr >
								<td style="width:20%;border-left-color:#ffffff;border-top-color:#ffffff;border-bottom-color:#ffffff;">
								Ref No.
								</td>
								<td style="width:55%;border-bottom-color:#ffffff;">
								<table style="width:100%;border-collapse:collapse;font-size:22px;" border="1">
								<tr>
								<td style="width:100%">
								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								</td>
								</tr>
								</table>
								</td>
								<td style="width:25%;border-right-color:#ffffff;border-top-color:#ffffff;border-bottom-color:#ffffff;">
								</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td <td style="width:100%;border-collapse:collapse;border-bottom-color:#ffffff;" border="0">
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
					<tr>	
						<td style="width:50%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Occupation:- ...........................................................
						</td>
						<td style="width:50%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Qaulification No:- .....................................................
						</td>
					</tr>
				</table>
		
			</td>
		</tr>
		<tr>
			<td <td style="width:100%;border-collapse:collapse;border-bottom-color:#ffffff;" border="0">
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
					<tr>	
						<td style="width:50%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Name & Adderess of the Training Institute</br>
						.......................................................................</br>
						.......................................................................</br>
						</td>
						<td style="width:50%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Name & Adderess of the Training Institute</br>
						.......................................................................</br>
						.......................................................................</br>
						</td>
					</tr>
				</table>
		
			</td>
		</tr>
	</table>
	</br></br>
	</center>';
		$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
		<tr>
			<td style="width:20%">
			</td>
			<td style="width:60%"><center><b><h3><br/>REPORT ON ASSESSMENTS</h3></b></center>
			</td>
			<td style="width:20%">
			</td>
			
		</tr>
    </table></center>
	';
		$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
		<tr>
			<td style="width:100%">
				1. Total number of candidates summoned for the assessment: ............................................................................</br></br>
			</td>
			
			
		</tr>
		<tr>
			<td style="width:100%">
				2. Number of candidates assessed:</br></br>
			</td>
		</tr>
    </table></center>
	';
$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="6">
		<tr>
			<td style="width:20%;">
			<b></br>No</b>
			</td>
			<td style="width:40%;">
			<b></br>Date of Assessment</b>
			</td>
			<td style="width:40%;">
			<b></br>No. of candidate Assessed</b>
			</td>
			
		</tr>';
		$gg = 1;
		foreach($GetFinalAssDates as $g)
		{
			$html.='
			<tr>
				<td style="width:20%;">Day '.$gg++.'</br></br></td>
				<td style="width:40%;">'.$g->FinalAssessmentDate.'</td>
				<td style="width:40%;"></td>
			
		    </tr>';
		}
	$html.='</table>
	</center>';
		
	$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
		<tr>
			<td style="width:100%">
				3. Name & address of the place/s of assessment(if not at the Training center mentioned above): <br/>
			...............................................................................................................................................................................................................................................................................................................
			...............................................................................................................................................................................................................................................................................................................
			...............................................................................................................................................................................................................................................................................................................
			</td>
			
			
		</tr>
		
    </table></center>
	';
		$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;;page-break-before: always;" border="6">
		<tr>
			<td style="width:100%;border-bottom-color:#ffffff" >
				<br/>6. This should be signed by the Head of the Training Institute or an designated by him<br/><br/>
			</td>
		</tr>
		<tr>
			<td style="width:100%;border-bottom-color:#ffffff;" >
				I certify that the assessments of the candidates were carried out by the Assessor at this Training centre/at the place/s given in item 3 above.<br/><br/>
			</td>
		</tr>
		<tr>
			<td style="width:100%;;border-bottom-color:#ffffff;" >
				I have checked and accepted from the Assessor the competency Based Assessment Record Books and other evidences of the candidates who were assessed and entered on page 2 of this form.
			<br/><br/>
			</td>
			
		</tr>
		<tr>
			<td style="width:100%;;border-bottom-color:#ffffff;" >
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
				<tr>
					<td style="width:35%;">
					<center><b>...........................................</b></center>
					</td>
					<td style="width:30%;">
					<center><b>...........................................</b></center>
					</td>
					<td style="width:35%;">
				<center><b>...........................................</b></center>
					</td>
					
				</tr>
				<tr>
					<td style="width:35%;">
					<center>Date</center>
					</td>
					<td style="width:30%;">
					<center>Signature</center>
					</td>
					<td style="width:35%;">
				   <center>Name</center>
					</td>
					
				</tr>
				<tr>
					<td style="width:35%;">
					<center></center>
					</td>
					<td style="width:30%;">
					<center></center>
					</td>
					<td style="width:35%;">
				<center><b>...........................................</b></center>
					</td>
					
				</tr>
				<tr>
					<td style="width:35%;">
					<center></center>
					</td>
					<td style="width:30%;">
					<center></center>
					</td>
					<td style="width:35%;">
				<center>Designation</center>
					</td>
					
				</tr>
				</table>
				</td>
		</tr>
		
    </table></center>
	';
	
	$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
		<tr>
			<td style="width:100%">
				<br/>5. Comments of the Assessor(if any) <br/>
			...............................................................................................................................................................................................................................................................................................................
			...............................................................................................................................................................................................................................................................................................................
			...............................................................................................................................................................................................................................................................................................................
						...............................................................................................................................................................................................................................................................................................................
<br/>
			</td>
			
			
		</tr>
		
    </table></center>
	';
	
		$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="6">
		<tr>
			<td style="width:100%;border-collapse:collapse;border-bottom-color:#ffffff;" border="0">
			I certify that the information furnished in this report are true and correct.
			</td>
		</tr>
	
		<tr>
			<td <td style="width:100%;border-collapse:collapse;border-bottom-color:#ffffff;" border="0">
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
					<tr>	
						<td style="width:30%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Signature of the Assessor:<br/><br/>
						</td>
						<td style="width:70%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						
						</td>
					</tr>
					<tr>	
						<td style="width:30%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Name:<br/><br/>
						</td>
						<td style="width:70%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						
						</td>
					</tr>
					<tr>	
						<td style="width:30%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Reg. No/Licence No:<br/><br/>
						</td>
						<td style="width:70%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						
						</td>
					</tr>
					<tr>	
						<td style="width:30%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						Date:<br/><br/>
						</td>
						<td style="width:70%;border-top-color:#ffffff;;border-bottom-color:#ffffff;">
						
						</td>
					</tr>
				</table>
		
			</td>
		</tr>
	
	</table>
	</center>';
	//second page
	$html.='<center>
	<table style="width:100%;border-collapse:collapse;align:center;page-break-before: always;" border="0">
		<tr>
			<td style="width:20%">
			</td>
			<td style="width:60%"><center><b><h2><br/>DETAILS OF ASSESSMENT CARRIED OUT</h2></b>
			</center>
			</td>
			<td style="width:5%">
			</td>
			<td style="width:15%"><center>
				<table style="width:100%;border-collapse:collapse;" border="1"> 
					<tr>
						<td>AS- 01
						</td>
					</tr>
				</table></center>
			</td>
		</tr>
		</table></center>';
		$html.='<center>
	<table style="width:100%;border-collapse:collapse;align:center;" border="0">
		<tr>
			
			<td style="width:60%;font-size:18px;;align:center"><center>
			(Please enter the results of assessment in respect of each unit assessed in front of the candidates name using the key given below)
			</center>
			</td>
			
		</tr>
    </table></center>';
	
	$html.='<center>
	<table style="width:100%;border-collapse:collapse;" border="0">
		<tr>
			
			<td style="width:20%;font-size:26px;;align:center">
			<b>Skill Standard Code:</b>
			
			</td>
			<td style="width:80%;font-size:18px;;align:center">
			'.$CourseDetailsRec->ComStand.'
			
			</td>
			
			
		</tr>
		<tr>
			
			<td style="width:20%;font-size:26px;;align:center">
			<b>Qualification Code:</b>
			
			</td>
			<td style="width:80%;font-size:18px;;align:center">';
				foreach($Packages as $qp)
				{
					$html.='<span>'. $qp->packagecode .'   </span>';
				}
			$html.='</td>
		</tr>
    </table></center>';
	$countTotunits = count($totalunits);
	
	$html.='<br/><center><table style="width:100%;border-collapse:collapse;font-size:20px;;align:center" border="1" style="">
	<tr>
	<th style="width:5%" rowspan="2"><Center>No</center></th>
	<th style="width:12%" colspan="2"><Center>Candidate</center></th>
	
	
	
	<th style="width:5%"  colspan="'.$countTotunits.'"><Center>National Skill Standards Unit Number</center></th>
	<th style="width:5%" rowspan="2"><Center>No. of unit Assessed</center></th>
	</tr>
	<tr>
		<th style="width:12%"><Center>Name</center></th>
		<th style="width:12%"><Center>Identification Number</center></th>';
		foreach($totalunits as $TU)
		{
			$html.='<th style="width:5%"><Center>'.$TU->UnitCode.'</center></th>';
		}
		
	$html.='</tr>';
	
	$i = 1;
	 foreach ($total as $t) 
	 {
		   $html.='<tr>
					  <td style="width:5%"><Center>'.$i++.'</Center></td>
					  <td style="width:12%">'.$t->NameWithInitials.'</td>
					  <td style="width:12%">'.$t->MISNumber.'</td>';
						foreach($totalunits as $TU)
						{
							$html.=' <td style="width:5%"></td>';
						}
  
		   $html.='<td ></td>
			  </tr>';
	 }
	  foreach ($totalrep as $t) 
	 {
		   $html.='<tr>
					  <td style="width:5%"><Center>'.$i++.'</Center></td>
					  <td style="width:12%">'.$t->NameWithInitials.'</td>
					  <td style="width:12%">'.$t->MISNumber.'</td>';
						foreach($totalunits as $TU)
						{
							$html.=' <td style="width:5%"></td>';
						}
  
		   $html.='<td ></td>
			  </tr>';
	 }
$html.='<tr>
	<td style="width:5%" ><Center></center>*</td>
	<td style="width:12%" colspan="2"><Center>No.of Candidates competent in unit</center></td>';
						foreach($totalunits as $TU)
						{
							$html.=' <td style="width:5%"></td>';
						}
	
	
	
	$html.='<td style="width:5%" ><Center></center></td>
	</tr>';
	$html.='<tr>
	<td style="width:5%" ><Center></center>*</td>
	<td style="width:12%" colspan="2"><Center>No.of Candidates not competent in unit</center></td>';
						foreach($totalunits as $TU)
						{
							$html.=' <td style="width:5%"></td>';
						}
	
	
	
	$html.='<td style="width:5%"><Center></center></td>
	</tr>';
		
	$html.='<tr>
	<td style="width:5%" ><Center></center>*</td>
	<td style="width:12%" colspan="2"><Center>No.of Candidates absent for unit</center></td>';
	foreach($totalunits as $TU)
	{
							$html.=' <td style="width:5%"></td>';
	}
	
	$html.='<td style="width:5%;border-top-color:#ffffff;"><Center></center></td>
	</tr>';
	$html.='</table></center>';
	
	$html.='<center>
	<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
	
		<tr>
			<td style="width:100%;;border-bottom-color:#ffffff;" >
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
				<tr>
					<td style="width:35%;">
				<table style="width:100%;border-collapse:collapse;font-size:22px;" border="0">
								<tr >
								<td style="width:20%;border-left-color:#ffffff;border-top-color:#ffffff;border-bottom-color:#ffffff;">
								Ref No.
								</td>
								<td style="width:55%;border-bottom-color:#ffffff;">
								<table style="width:100%;border-collapse:collapse;font-size:22px;" border="1">
								<tr>
								<td style="width:100%">
								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br/><br/>
								</td>
								</tr>
								</table>
								</td>
								<td style="width:25%;border-right-color:#ffffff;border-top-color:#ffffff;border-bottom-color:#ffffff;">
								(as on page 1)
								</td>
								</tr>
							</table>
					</td>
					<td style="width:30%;">
					<center><b><br/>...........................................<br/>Signature of the Assessor</b></center>
					</td>
					<td style="width:35%;">
				<center><b><br/>...........................................<br/>Date</b></center>
					</td>
					
				</tr>
				
				
				</table>
				</td>
		</tr>
		
    </table></center>
	';
	$html.='<center>
	<table style="width:70%;border-collapse:collapse;font-size:22px;" border="0">
	
		<tr>
			<td><br/><br/><b>Key : C - Competent</b>
					</td>
					<td >
				<br/><br/><b>Key : N - Not Yet Competent</b>
					</td>
					<td>
				<br/><br/><b>Key : A - Absent</b>
					</td>
			
				
				
		</tr>
		
    </table></center>
	';
	
$html.='</body>
</html>
';
echo $html; 
    }
	
	    public function ExamPrintAttendanceSheet2()
    {
          $CourseYearPlanID = Input::get('CS_ID');
		$AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');
		$courseyerplanrec = CourseYearPlan::where('id','=',$CourseYearPlanID)->first();
		$getOrganame = Organisation::where('id','=',$courseyerplanrec->OrgId)->pluck('OrgaName');
		$CourseDetailsRec = Course::where('CD_ID','=',$courseyerplanrec->CD_ID)->first();
         

       
     $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					  and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
				  $total = DB::select(DB::raw($sql));
		  $totalrep = DB::select(DB::raw($sql2));
	
	$getNominatedAssesorList = DB::select(DB::raw("select assessor.AssessorId,assessor.Name,assessornomination.NominationType,assessor.DateEntered
																	  from assessornomination
																	  left join assessor
																	  on assessornomination.AssessorId=assessor.id
																	  where assessornomination.Deleted=0
																	  and assessornomination.AssessorActive=1
																	  and assessornomination.CYPID='".$CourseYearPlanID."'
																	  order by AssessorId"));



$html = '';
	$html='<html>
	<title>Final Assessment Attendence Sheet</title>
	<head>
    </head>
    <body>';
	
	$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:22px;" border="0" style="">
	<tr>
	<td style="width:20%"><img src="assets\SLLOGO.png" alt="Smiley face" height="100" width="110"/>
	</td>
	<td style="width:60%"><center><b><h3>Vocational Training Authority of Sri Lanka</h3></b><br/>Testing & Evaluation Division<br/>Final Assessment Attendence Sheet</center>
	</td>
	<td style="width:20%"><img src="assets\VTA.jpg" alt="Smiley face" height="100" width="160"/></td>
	<td style="width:20%"></td></tr>
    </table></center><br/>
	';
	 $html.='

<table style="width:100%;border-collapse:collapse;" border="1">
<tbody>
<tr>
<td>
Training Center:
</td>
<td >
&nbsp;&nbsp;'.$getOrganame.'
</td>
<td  >
Course Name:
</td>
<td >
&nbsp;&nbsp;'.$CourseDetailsRec->CourseName.'
</td>
</tr>
<tr >
<td  >
Year:
</td>
<td >
&nbsp;&nbsp;'.$courseyerplanrec->Year.'
</td>
<td  >
Batch:
</td>
<td >
&nbsp;&nbsp;'.$courseyerplanrec->batch.'
</td>
</tr>
</table>
<br/>
<br/>
<table style="width:100%;border-collapse:collapse;" border="1">
<tbody>

<tr>
<td>
<b>No</b>
</td>
<td>
<b>NIC</b>
</td>
<td  >
<b>Name With initials</b>
</td>
<td >
<b>MIS Number</b>
</td>
<td >
<b>Trainee’s Address</b>
</td>
<td >
<b>Trainee’s Signature</b>
</td>
</tr></b>';

$i = 1;
 foreach ($total as $t) {
   
  $html.='<tr>
  <td >'.$i.'</td>
  <td >'.$t->NIC.'</td>
  <td >'.$t->NameWithInitials.'</td>
  <td >'.$t->MISNumber.'</td>
  <td >'.$t->Address.'</td>
  <td ></td></tr>';
  



 $i++;
 }
  foreach ($totalrep as $t) {
   
  $html.='<tr>
  <td >'.$i.'</td>
  <td >'.$t->NIC.'</td>
  <td >'.$t->NameWithInitials.'</td>
  <td >'.$t->MISNumber.'</td>
  <td >'.$t->Address.'</td>
  <td ></td></tr>';
  



 $i++;
 }


 
$html.='</table><br/><br/>';
 
$html.='<table style="width:100%;border-collapse:collapse;" border="0">
 <tr>
  <td >N.B :- Certificates will be issued to the names mentioned above</span></p>
  </td>
 </tr>
</table>
 <table style="width:100%;border-collapse:collapse;" border="1">
 <tr>
  <td>
  <b>No</b>
  </td>
  <td>
  <b>Assessor Name</b>
  </td>
  <td>
 <b>Reg No</b>
  </td>
   <td><b>Date</b>
  </td>
  <td><b>Signature</b>
  </td>
  </tr>';
  $rr = 1;
  foreach($getNominatedAssesorList as $kl)
  {
	  $html.='<tr>
   <td>'.$rr.'</td>
    <td>'.$kl->Name.'</td>
	 <td>'.$kl->AssessorId.'</td>
	  <td></td>
	    <td></td>
	';
	$rr++;			
  }
  

$html.='</div>

</body>


</html>';

echo $html;

  
    }
	
	public function ExamViewandprintFinaAttendance()
    {
        $method=Request::getMethod();
        $view = View::make('NVQExamNew.ViewStudentAttendanceDetails');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;
        
        if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type',['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }
        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
             $District = Input::get('District');
          $CenterID = Input::get('CenterID');
          $Year = Input::get('Year');
		  $Batch = Input::get('Batch');
		  
		   $CourseYearPlanID = Input::get('CourseYearPlanID');
		  $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');
		  
		  
           $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.PreAssessHeld=1
					  and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.PreAssessHeld=1
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          
  
				  $total = DB::select(DB::raw($sql));
		  $totalrep = DB::select(DB::raw($sql2));
          $view->Trainees = $total;
		   $view->TraineesRep = $totalrep;
          $view->CourseYearPlanID = $CourseYearPlanID;
          $view->Center = $CenterID;
		  $view->District = $District;
		  $view->Year = $Year;
		  $view->Batch = $Batch;
          return $view;



               
        }

        
    }
	
  public function ExamSaveRepeatersToAssessment()
  {

     $TraineeRelatedCourseYearPlanID = Input::get('CourseYearPlanID');
     $traineeIds = Input::get('trainee_ids');
	 $getCYPOriginalID = Input::get('AssesmentNo');
	  $AssesmentNo = CourseYearPlan::where('id','=',$getCYPOriginalID)->pluck('AssessmentNo');
	 

     $update = ExamRepeaterTrainees::where('TraineesOriginalCYPID','=',$TraineeRelatedCourseYearPlanID)
	 ->where('OriginalCYPassessmentNo','=',$AssesmentNo)
	 ->update(array('Deleted' => 1));
	
     foreach ($traineeIds as $k) {

     // return $k;
			$Availability = ExamRepeaterTrainees::where('T_ID','=',$k)
			->where('TraineesOriginalCYPID','=',$TraineeRelatedCourseYearPlanID)
			->where('OriginalCYPassessmentNo','=',$AssesmentNo)->get();
			if(count($Availability) == 0)
			{
							$v = new ExamRepeaterTrainees();
							$v->T_ID = $k;
							$v->OriginalCYPassessmentNo = $AssesmentNo;
							$v->TraineesOriginalCYPID = $TraineeRelatedCourseYearPlanID;
							$v->ExamFacingCYPID = $getCYPOriginalID;
							$v->User =  User::getSysUser()->userID;
							$v->save();
			}
			else
			{
				$update = ExamRepeaterTrainees::where('TraineesOriginalCYPID','=',$TraineeRelatedCourseYearPlanID)
				 ->where('T_ID','=',$k)
				 ->where('OriginalCYPassessmentNo','=',$AssesmentNo)
				 ->update(array('Deleted' => 0));
	
				
			}
     
     
     }

     return Redirect::to('ExamAddRepeatersToAssessment')->with("done", true);;
  }
	
		public function ExamAddRepeatersToAssessment()
  {
        $method=Request::getMethod();
        $view = View::make('Assessor.AddRepeaterstoAssessments');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;
        
        if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type',['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }
		
		 $sql1 = "select courseyearplan.id,courseyearplan.AssessmentNo
			  from courseyearplan
			  where courseyearplan.Deleted=0
			  and courseyearplan.AssessmentNo is not null
			  order by courseyearplan.AssessmentNo";
			  
		  $Assnumbers = DB::select(DB::raw($sql1));
		   $view->Assnumbers = $Assnumbers;

         if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
          //return 'sfr';
          $District = Input::get('District');
          $CenterID = Input::get('CenterID');
          $Year = Input::get('Year');
		  $Batch = Input::get('Batch');
		   $AssesmentNo = Input::get('AssessmentNo');
		  $CourseYearPlanID = Input::get('CourseYearPlanID');

             $sql = "select irtrainee.*,examrepeatertrainees.TraineesOriginalCYPID
					from irtrainee
				  left join examrepeatertrainees
				  on irtrainee.id=examrepeatertrainees.T_ID and irtrainee.CourseYearPlanID=examrepeatertrainees.TraineesOriginalCYPID
				  and examrepeatertrainees.Deleted=0
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
          $total = DB::select(DB::raw($sql));
		  
		 
          $view->Trainees = $total;
		  
          $view->CourseYearPlanID = $CourseYearPlanID;
          $view->Center = $CenterID;
		  $view->District = $District;
		  $view->AssesmentNo = $AssesmentNo;
		  $view->Year = $Year;
		  $view->Batch = $Batch;
          return $view;

        }

  }
	
	  public function ExamPrintPreAssessmentAttendence()
	  {
		$CourseYearPlanID = Input::get('CS_ID');
		$AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');
		$courseyerplanrec = CourseYearPlan::where('id','=',$CourseYearPlanID)->first();
		$getOrganame = Organisation::where('id','=',$courseyerplanrec->OrgId)->pluck('OrgaName');
		$CourseDetailsRec = Course::where('CD_ID','=',$courseyerplanrec->CD_ID)->first();
   
    
   
     $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					  and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
          $total = DB::select(DB::raw($sql));
		  
	$sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
	$totalrep = DB::select(DB::raw($sql2));
	
	$getNominatedAssesorList = DB::select(DB::raw("select assessor.AssessorId,assessor.Name,assessornomination.NominationType,assessor.DateEntered
																	  from assessornomination
																	  left join assessor
																	  on assessornomination.AssessorId=assessor.id
																	  where assessornomination.Deleted=0
																	  and assessornomination.AssessorActive=1
																	  and assessornomination.CYPID='".$CourseYearPlanID."'
																	  order by AssessorId"));


    $html = '';
	$html='<html>
	<title>Pre Assessment Attendence Sheet</title>
	<head>
    </head>
    <body>';
	$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:22px;" border="0" style="">
	<tr>
	<td style="width:20%"><img src="assets\SLLOGO.png" alt="Smiley face" height="100" width="110"/>
	</td>
	<td style="width:60%"><center><b><h3>Vocational Training Authority of Sri Lanka</h3></b><br/>Testing & Evaluation Division<br/>Pre Assessment Attendence Sheet</center>
	</td>
	<td style="width:20%"><img src="assets\VTA.jpg" alt="Smiley face" height="100" width="160"/></td>
	<td style="width:20%"></td></tr>
    </table></center><br/>';

    $html.='

<table style="width:100%;border-collapse:collapse;" border="1">
<tbody>
<tr>
<td>
Training Center:
</td>
<td >
&nbsp;&nbsp;'.$getOrganame.'
</td>
<td  >
Course Name:
</td>
<td >
&nbsp;&nbsp;'.$CourseDetailsRec->CourseName.'
</td>
</tr>
<tr >
<td  >
Year:
</td>
<td >
&nbsp;&nbsp;'.$courseyerplanrec->Year.'
</td>
<td  >
Batch:
</td>
<td >
&nbsp;&nbsp;'.$courseyerplanrec->batch.'
</td>
</tr>
</table>
<br/>
<br/>


<table style="width:100%;border-collapse:collapse;" border="1">
<tbody>

<tr>
<td>
<b>No</b>
</td>
<td>
<b>NIC</b>
</td>
<td  >
<b>Name With initials</b>
</td>
<td >
<b>MIS Number</b>
</td>
<td >
<b>Trainee’s Address</b>
</td>
<td >
<b>Trainee’s Signature</b>
</td>
</tr></b>';

$i = 1;
 foreach ($total as $t) {
   
  $html.='<tr>
  <td >'.$i.'</td>
  <td >'.$t->NIC.'</td>
  <td >'.$t->NameWithInitials.'</td>
  <td >'.$t->MISNumber.'</td>
  <td >'.$t->Address.'</td>
  <td ></td></tr>';
  



 $i++;
 }
  foreach ($totalrep as $t) {
   
  $html.='<tr>
  <td >'.$i.'</td>
  <td >'.$t->NIC.'</td>
  <td >'.$t->NameWithInitials.'</td>
  <td >'.$t->MISNumber.'</td>
  <td >'.$t->Address.'</td>
  <td ></td></tr>';
  



 $i++;
 }


 
$html.='</table><br/><br/>';

$html.='<table style="width:100%;border-collapse:collapse;" border="0">
 <tr>
  <td >N.B :- Certificates will be issued to the names mentioned above</span></p>
  </td>
 </tr>
</table>
 <table style="width:100%;border-collapse:collapse;" border="1">
 <tr>
  <td>
  <b>No</b>
  </td>
  <td>
  <b>Assessor Name</b>
  </td>
  <td>
 <b>Reg No</b>
  </td>
  <td><b>Date</b>
  </td>
   <td><b>Signature</b>
  </td>
  </tr>';
  $rr = 1;
  foreach($getNominatedAssesorList as $kl)
  {
	  $html.='<tr>
   <td>'.$rr.'</td>
    <td>'.$kl->Name.'</td>
	 <td>'.$kl->AssessorId.'</td>
	  <td></td>
	   <td></td>
	';
	$rr++;			
  }
  

$html.='</div>

</body>


</html>';

return $html;
  }
	
	public function ExamSavePreAssessmentAttendence()
  {

     $CourseYearPlanID = Input::get('CourseYearPlanID');
	 $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');
     $traineeIds = Input::get('trainee_ids');
	  $traineeIdsrep = Input::get('trainee_idsrep');

     $update = IRTrainee::where('CourseYearPlanID','=',$CourseYearPlanID)->where('Deleted','=',0)->update(array('PreAssessHeld' => 0));
	 if(count($traineeIds)!=0)
	 {
     foreach ($traineeIds as $k) {

     // return $k;

      $updateTraineeTrans = IRTrainee::where('id','=',$k)->update(array('PreAssessHeld' => 1));
     
     }
	 }
	 // update examtraineerepeaters
	 $update = ExamRepeaterTrainees::where('OriginalCYPassessmentNo','=',$AssessmentNo)->where('Deleted','=',0)->update(array('PreAssessHeld' => 0));
	 if(count($traineeIdsrep)!=0)
	 {
	 foreach ($traineeIdsrep as $k1) {

    

      $updateTraineeTransrep = ExamRepeaterTrainees::where('id','=',$k1)->update(array('PreAssessHeld' => 1));
     
     }
	 }

     return Redirect::to('ExamAssignTraineesToPreAssessment')->with("done", true);;
  }
	
		  public function ExamGetCenterCourseListBatchwise()
  {
    $CenterID = Input::get('CourseListCode');
	$Year = Input::get('Year');
	$Batch = Input::get('Batch');
	$District = Input::get('dis');

	if($District == 'All' && $CenterID == 'All')
	{
		 $sql = "select courseyearplan.id,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  courseyearplan.Year,
			  courseyearplan.batch,
			  courseyearplan.medium,
			  courseyearplan.RealstartDate,
			  coursedetails.Duration,
			  coursedetails.CourseType,
			  coursedetails.CourseLevel
			  from courseyearplan
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  where courseyearplan.Deleted=0
			  and courseyearplan.StartedStatus=1
			  and courseyearplan.Year='".$Year."'
			  and courseyearplan.batch like '$Batch%'
			  order by coursedetails.CourseName
";

	}
	elseif($District != 'All' && $CenterID == 'All')
	{
			  $sql = "select courseyearplan.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  courseyearplan.Year,
  courseyearplan.batch,
  courseyearplan.medium,
  courseyearplan.RealstartDate,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.CourseLevel
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join organisation
  on courseyearplan.OrgId=organisation.id
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$District."'
  and courseyearplan.StartedStatus=1
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
 order by coursedetails.CourseName
";
	}
	elseif($District != 'All' && $CenterID != 'All')
	{
		 $sql = "select courseyearplan.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  courseyearplan.Year,
  courseyearplan.batch,
  courseyearplan.medium,
  courseyearplan.RealstartDate,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.CourseLevel
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join organisation
  on courseyearplan.OrgId=organisation.id
  where courseyearplan.Deleted=0
  and courseyearplan.OrgId='".$CenterID."'
  and organisation.DistrictCode='".$District."'
  and courseyearplan.StartedStatus=1
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  order by coursedetails.CourseName
";
	}
	else
	{
		$sql = "select courseyearplan.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  courseyearplan.Year,
  courseyearplan.batch,
  courseyearplan.medium,
  courseyearplan.RealstartDate,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.CourseLevel
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join organisation
  on courseyearplan.OrgId=organisation.id
  where courseyearplan.Deleted=0
  and courseyearplan.OrgId='".$CenterID."'
  and courseyearplan.StartedStatus=1
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  order by coursedetails.CourseName
";
	}
	
  
$sql0 = DB::select(DB::raw($sql));
  return json_encode($sql0);
  }
	
	public function ExamAssignTraineesToPreAssessment()
  {
        $method=Request::getMethod();
        $view = View::make('Assessor.MarkAttendenceforPreAssessments');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;
        
        if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type',['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }

         if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
          //return 'sfr';
          $District = Input::get('District');
          $CenterID = Input::get('CenterID');
          $Year = Input::get('Year');
		  $Batch = Input::get('Batch');
		  
		  $CourseYearPlanID = Input::get('CourseYearPlanID');
		  $AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');

           $sql = "select irtrainee.*
					from irtrainee
					where irtrainee.Deleted=0
					and irtrainee.Dropout=0
					  and irtrainee.CourseYearPlanID='".$CourseYearPlanID."'
					order by irtrainee.MISNumber";
					
		    $sql2 = "select irtrainee.*,examrepeatertrainees.id as RepeatID,examrepeatertrainees.PreAssessHeld as repPreAssessHeld
					  from examrepeatertrainees
					  left join irtrainee
					  on examrepeatertrainees.T_ID=irtrainee.id
					  where examrepeatertrainees.Deleted=0
					  and examrepeatertrainees.OriginalCYPassessmentNo='".$AssessmentNo."'
					  and irtrainee.Dropout=0
					  order by irtrainee.MISNumber";
          $total = DB::select(DB::raw($sql));
		   $totalrep = DB::select(DB::raw($sql2));
          $view->Trainees = $total;
		   $view->TraineesRep = $totalrep;
          $view->CourseYearPlanID = $CourseYearPlanID;
          $view->Center = $CenterID;
		  $view->District = $District;
		  $view->Year = $Year;
		  $view->Batch = $Batch;
          return $view;

        }



  }

	
     public function ExamPrintAssessorAssignedLetterForRenominated()
    {
         $CS_ID = Input::get('CS_ID');
         $CYPRec = CourseYearPlan::where('id','=',$CS_ID)->first();
         $sqlgetallAssessors = DB::select(DB::raw("select assessor.Name, assessor.AssessorId,assessor.Mobile,assessor.id
                              from assessorrenomination
                              left join assessor
                              on assessorrenomination.AssessorId=assessor.id
                              where assessorrenomination.CYPID='$CS_ID'
							  and assessorrenomination.Deleted=0
                              and assessorrenomination.AssessorActive='1'"));

          
       $ar = json_decode(json_encode((array)$sqlgetallAssessors),true);

       if(count($sqlgetallAssessors) == 2)
       {
         
          $asseid1 = $ar[0]['id'];
          $assessorID1 =  $ar[0]['AssessorId'];
          $assessorName1 = $ar[0]['Name'];
          $assessorMobile1 =  $ar[0]['Mobile'];
          $asseid2 = $ar[1]['id'];
          $assessorID2 =  $ar[1]['AssessorId'];
          $assessorName2 = $ar[1]['Name'];
          $assessorMobile2 =  $ar[1]['Mobile'];
       } 
       elseif(count($sqlgetallAssessors) == 1)
       {
          $asseid1 = $ar[0]['id'];
           $assessorID1 =  $ar[0]['AssessorId'];
          $assessorName1 = $ar[0]['Name'];
          $assessorMobile1 =  $ar[0]['Mobile'];
          $asseid2 = '';
          $assessorID2 =  '';
          $assessorName2 = '';
          $assessorMobile2 =  '';
       }
       elseif(count($sqlgetallAssessors) == 0)
       {
          $asseid1 = '';
          $assessorID1 =  '';
          $assessorName1 = '';
          $assessorMobile1 =  '';
          $asseid2 = '';
          $assessorID2 =  '';
          $assessorName2 = '';
          $assessorMobile2 =  '';
       }
       else
       {
          $asseid1 = $ar[0]['id'];
          $assessorID1 =  $ar[0]['AssessorId'];
          $assessorName1 = $ar[0]['Name'];
          $assessorMobile1 =  $ar[0]['Mobile'];
          $asseid2 = $ar[1]['id'];
          $assessorID2 =  $ar[1]['AssessorId'];
          $assessorName2 = $ar[1]['Name'];
          $assessorMobile2 =  $ar[1]['Mobile'];
     
	   }
        
        
        $docode = Organisation::where('id', '=', $CYPRec->OrgId)->pluck('DistrictCode');
        $districtName = District::where('DistrictCode','=',$docode)->pluck('DistrictName');
        $year = date('Y');

        $orgaName = Organisation::where('id','=',$CYPRec->OrgId)->pluck('OrgaName');
        $orgaRegNo = Organisation::where('id','=',$CYPRec->OrgId)->pluck('RegistrationNo');
       // $CD_ID = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
        $NVQLevel = Course::where('CD_ID','=',$CYPRec->CD_ID)->where('Deleted','=',0)->pluck('CourseLevel');
		$CourseName = Course::where('CD_ID','=',$CYPRec->CD_ID)->where('Deleted','=',0)->pluck('CourseName');
       // $courseStartDate = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('StartDate');
        //$CourseEndDate = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('ExpectedCompleted');
        $traineeCount = IRTrainee::where('CourseYearPlanID','=',$CS_ID)->where('Deleted','=',0)->where('Dropout','!=',1)->count();

         $html = '<html>
         <head>
         <style>
         #outer-container {
            
            justify-content: space-around;
            
          }
         </style>
         </head>
         <body>
         <div id="outer-container">
         <br/><br/><br/><br/><br/><br/>
         '.$year.'/...../......<br/>
Deputy Director/ Assistant Director,<br/>
District Vocational Training Center/ National Vocational Training Institute,<br/>
'.$districtName.'.<br/>
<center><u><b>Conducting Assessment For NVQ Certification</b></u></center><br/>
<p align="justufy">
With reference to your request on the above topic and as per the approval for nominating assessors given <br/>by the Director General, Tertiary and Vocational Education Commission, I would like to inform you that <br/> you are authorized to get the services of following assessors to conduct the below mentioned assessment.
</p>


	<table style="width:100%;border-collapse:collapse;" border="1">
<tbody>
<tr >
<td  >
Training Center
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$orgaName.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
TVEC Registration No
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$orgaRegNo.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
Course Name
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$CourseName.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
NVQ Level
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$NVQLevel.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
<center>Course Starting Date</center>
</td>
<td >
<center>Course Ending Date</center>
</td>
<td >
<center>No. Of Trainees</center>
</td>
</tr>
<tr >
<td >
&nbsp;&nbsp;'.$CYPRec->RealstartDate.'
</td>
<td >
&nbsp;&nbsp;'.$CYPRec->RealEndDate.'
</td>
<td >
&nbsp;&nbsp;'.$traineeCount.'
</td>
</tr>

<tr >
<td >

<center>Assessor ID</center>
</td>
<td >
<center>Assessor Name</center>
</td>
<td >
<center>Telephone No.</center>
</td>
</tr>
';
 foreach($sqlgetallAssessors as $ASd)
{
	$html.='<tr><td>'.$ASd->AssessorId.'</td>
	<td>&nbsp;&nbsp;'.$ASd->Name.'</td>
	<td>&nbsp;&nbsp;'.$ASd->Mobile.'</td></tr>
	';
} 




$html.='</tbody>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
U.K Nanda,<br/>
Director (Testing &amp; Evaluation)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; For Conduct The Assessment<br/>
<br/>
Copies &ndash;<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 *&nbsp;Please note strictly that the copy of &lsquo;PA form should be<br/>
01.&nbsp;&nbsp;'.$assessorName1.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sent to Tertiary and Vocational Education Commission<br/>
02.&nbsp;&nbsp;'.$assessorName2.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; within 03 days after assessment,having the Pre - assessment<br/><br/>
03. Director(Quality Assiarence & assessment Regulation)- kindly informed to you,<br/>assessors nomination done according to instructions given by TVEC.<br/>
<ol>
<li>Please be kind enough to conduct assessments for NVQ Level 04, after computer of on<br/>the job training.</li>
</ol>
<b><center>Please note that this approval is valid only up to month period of time</center></b>
</body>
</div>
</html>
';
 //$updateletterprintass1 = NVQAssessorNomination::where('CS_ID','=',$CS_ID)->update(array('LetterPrintForAssessor' => 1));
 //$updatenvqcoursetrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->update(array('AssNominatedLetterSendDO' => 1));
// $updateletterprintass2 = NVQAssessorNomination::where('id','=',$asseid2)->update(array('LetterPrintForAssessor' => 1));
echo $html;
    }
	
	    public function ExamPrintAssessorAssignedLetter()
    {
         $CS_ID = Input::get('CS_ID');
         $CYPRec = CourseYearPlan::where('id','=',$CS_ID)->first();
         $sqlgetallAssessors = DB::select(DB::raw("select assessor.Name, assessor.AssessorId,assessor.Mobile,assessor.id
                              from assessornomination
                              left join assessor
                              on assessornomination.AssessorId=assessor.id
                              where assessornomination.CYPID='$CS_ID'
							  and assessornomination.Deleted=0
                              and assessornomination.AssessorActive='1'"));

          
       $ar = json_decode(json_encode((array)$sqlgetallAssessors),true);

       if(count($sqlgetallAssessors) == 2)
       {
         
          $asseid1 = $ar[0]['id'];
          $assessorID1 =  $ar[0]['AssessorId'];
          $assessorName1 = $ar[0]['Name'];
          $assessorMobile1 =  $ar[0]['Mobile'];
          $asseid2 = $ar[1]['id'];
          $assessorID2 =  $ar[1]['AssessorId'];
          $assessorName2 = $ar[1]['Name'];
          $assessorMobile2 =  $ar[1]['Mobile'];
       } 
       elseif(count($sqlgetallAssessors) == 1)
       {
          $asseid1 = $ar[0]['id'];
           $assessorID1 =  $ar[0]['AssessorId'];
          $assessorName1 = $ar[0]['Name'];
          $assessorMobile1 =  $ar[0]['Mobile'];
          $asseid2 = '';
          $assessorID2 =  '';
          $assessorName2 = '';
          $assessorMobile2 =  '';
       }
       elseif(count($sqlgetallAssessors) == 0)
       {
          $asseid1 = '';
          $assessorID1 =  '';
          $assessorName1 = '';
          $assessorMobile1 =  '';
          $asseid2 = '';
          $assessorID2 =  '';
          $assessorName2 = '';
          $assessorMobile2 =  '';
       }
       else
       {
          $asseid1 = $ar[0]['id'];
          $assessorID1 =  $ar[0]['AssessorId'];
          $assessorName1 = $ar[0]['Name'];
          $assessorMobile1 =  $ar[0]['Mobile'];
          $asseid2 = $ar[1]['id'];
          $assessorID2 =  $ar[1]['AssessorId'];
          $assessorName2 = $ar[1]['Name'];
          $assessorMobile2 =  $ar[1]['Mobile'];
     
	   }
        
        
        $docode = Organisation::where('id', '=', $CYPRec->OrgId)->pluck('DistrictCode');
        $districtName = District::where('DistrictCode','=',$docode)->pluck('DistrictName');
        $year = date('Y');

        $orgaName = Organisation::where('id','=',$CYPRec->OrgId)->pluck('OrgaName');
        $orgaRegNo = Organisation::where('id','=',$CYPRec->OrgId)->pluck('RegistrationNo');
       // $CD_ID = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
        $NVQLevel = Course::where('CD_ID','=',$CYPRec->CD_ID)->where('Deleted','=',0)->pluck('CourseLevel');
		$CourseName = Course::where('CD_ID','=',$CYPRec->CD_ID)->where('Deleted','=',0)->pluck('CourseName');
       // $courseStartDate = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('StartDate');
        //$CourseEndDate = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('ExpectedCompleted');
        $traineeCount = IRTrainee::where('CourseYearPlanID','=',$CS_ID)->where('Deleted','=',0)->where('Dropout','!=',1)->count();

         $html = '<html>
         <head>
         <style>
         #outer-container {
            
            justify-content: space-around;
            
          }
         </style>
         </head>
         <body>
         <div id="outer-container">
         <br/><br/><br/><br/><br/><br/>
         '.$year.'/...../......<br/>
Deputy Director/ Assistant Director,<br/>
District Vocational Training Center/ National Vocational Training Institute,<br/>
'.$districtName.'.<br/>
<center><u><b>Conducting Assessment For NVQ Certification</b></u></center><br/>
<p align="justufy">
With reference to your request on the above topic and as per the approval for nominating assessors given <br/>by the Director General, Tertiary and Vocational Education Commission, I would like to inform you that <br/> you are authorized to get the services of following assessors to conduct the below mentioned assessment.
</p>


	<table style="width:100%;border-collapse:collapse;" border="1">
<tbody>
<tr >
<td  >
Training Center
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$orgaName.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
TVEC Registration No
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$orgaRegNo.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
Course Name
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$CourseName.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
NVQ Level
</td>
<td style="border-right:none">
&nbsp;&nbsp;'.$NVQLevel.'
</td>
<td style="border-left:none">
<p>&nbsp;</p>
</td>
</tr>
<tr >
<td >
<center>Course Starting Date</center>
</td>
<td >
<center>Course Ending Date</center>
</td>
<td >
<center>No. Of Trainees</center>
</td>
</tr>
<tr >
<td >
&nbsp;&nbsp;'.$CYPRec->RealstartDate.'
</td>
<td >
&nbsp;&nbsp;'.$CYPRec->RealEndDate.'
</td>
<td >
&nbsp;&nbsp;'.$traineeCount.'
</td>
</tr>

<tr >
<td >

<center>Assessor ID</center>
</td>
<td >
<center>Assessor Name</center>
</td>
<td >
<center>Telephone No.</center>
</td>
</tr>
';
 foreach($sqlgetallAssessors as $ASd)
{
	$html.='<tr><td>'.$ASd->AssessorId.'</td>
	<td>&nbsp;&nbsp;'.$ASd->Name.'</td>
	<td>&nbsp;&nbsp;'.$ASd->Mobile.'</td></tr>
	';
} 




$html.='</tbody>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
U.K Nanda,<br/>
Director (Testing &amp; Evaluation)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; For Conduct The Assessment<br/>
<br/>
Copies &ndash;<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 *&nbsp;Please note strictly that the copy of &lsquo;PA form should be<br/>
01.&nbsp;&nbsp;'.$assessorName1.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sent to Tertiary and Vocational Education Commission<br/>
02.&nbsp;&nbsp;'.$assessorName2.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; within 03 days after assessment,having the Pre - assessment<br/><br/>
03. Director(Quality Assiarence & assessment Regulation)- kindly informed to you,<br/>assessors nomination done according to instructions given by TVEC.<br/>
<ol>
<li>Please be kind enough to conduct assessments for NVQ Level 04, after computer of on<br/>the job training.</li>
</ol>
<b><center>Please note that this approval is valid only up to month period of time</center></b>
</body>
</div>
</html>
';
 //$updateletterprintass1 = NVQAssessorNomination::where('CS_ID','=',$CS_ID)->update(array('LetterPrintForAssessor' => 1));
 //$updatenvqcoursetrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->update(array('AssNominatedLetterSendDO' => 1));
// $updateletterprintass2 = NVQAssessorNomination::where('id','=',$asseid2)->update(array('LetterPrintForAssessor' => 1));
echo $html;
    }
	
	 public function ExamViewNPrintLettersForAssignedAssessors()
    {
        $method=Request::getMethod();
        $view = View::make('Assessor.ViewAssignedAssessors');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $view->Districts = District::orderBy('DistrictName')->get();
        $view->OrgaType = $OegaType;
        $view->Type = $Type;
        
        if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }


        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
           //return 'sdfvgg';
            $CenterID = Input::get('CenterID');
			$Year = Input::get('Year');
			$Batch = Input::get('Batch');
			$district = Input::get('District');
			$UserOrgID = User::getSysUser()->organisationId; 
			$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
			$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');

            	if($Batch == 'All')
		{
			if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CD_ID=coursedetails.CD_ID
            where courseyearplan.Deleted=0
            and courseyearplan.Year='".$Year."'
          
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and courseyearplan.Year='".$Year."'
 
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		
		}
		else
		{
			if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
          courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
					  from courseyearplan
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where courseyearplan.Deleted=0
					  and courseyearplan.Year='".$Year."'
					 and courseyearplan.batch like '$Batch%'
					  and courseyearplan.StartedStatus=1
					  group by courseyearplan.id 
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
          courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
 and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration";
		}
		
			
		}
		

                $trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;

                return $view;
        }

        
    }

	
	  public function ExamAssignAssessorForCourse()
    {
		// return 1;
        $method=Request::getMethod();
        $view = View::make('Assessor.AssignCreate');
		$CourseYearOrginigal = CourseYearPlan::where('Deleted','=',0)->where('id','=',Input::get('edit_id'))->first();
        $view->district = District::orderBy('DistrictName')->get();
		$view->coursese = $CourseYearOrginigal;
        $view->AssessorInstitute = NVQAssessorInstitute::where('Deleted','=',0)->orderBy('InstituteName')->get();
        $view->AssesorList = NVQAssessor::where('Deleted','=',0)->orderBy('AssessorId')->get();
        $view->CenterIDD = Input::get('CenterIDD');
		$view->districtD = Input::get('districtD');
		$view->YearD = Input::get('YearD');
		$view->BatchD = Input::get('BatchD');
      

        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
                //return 'sdfa';
            $CYPID = Input::get('id');
            $AssessmentNo = Input::get('AssessmentNo');
			$Assessor1 = [];
			$AssessorReNominated = [];
            $Assessor1 = Input::get('AssessorNominated');
            $RenominatedStatus = Input::get('RenominatedStatus');
			$AssessorReNominated = Input::get('AssessorReNominated');
			
			
            $UpdateCYPI = CourseYearPlan::where('id','=',$CYPID)->update(array('AssessorReNominated' =>  $RenominatedStatus,'AssessmentNo' => $AssessmentNo,'AssesorNominated' => 1));
			$CountAssessor1 = count($Assessor1);
			$countAssessorReNominated1 = count($AssessorReNominated);
			$update = NVQAssessorNomination::where('CYPID','=',$CYPID)->where('NominationType','=','Nominated')->update(array('AssessorActive' => 0,'Deleted' => 1));
			$updateRenom = NVQAssessorNomination::where('CYPID','=',$CYPID)->where('NominationType','=','ReNominated')->update(array('AssessorActive' => 0,'Deleted' => 1));
			
			for($i=0;$i<$CountAssessor1;$i++)
			{
					$ifavailable = NVQAssessorNomination::where('CYPID','=',$CYPID)->where('NominationType','=','Nominated')->where('AssessorId','=',$Assessor1[$i])->get();
					if(count($ifavailable)>0)
					{
					$ifavailable = NVQAssessorNomination::where('CYPID','=',$CYPID)->where('NominationType','=','Nominated')->where('AssessorId','=',$Assessor1[$i])->update(array('AssessorActive' => 1,'Deleted' => 0));
					}
					else
					{
					$v = new NVQAssessorNomination();
					$v->CYPID = $CYPID;
					$v->AssessorId = $Assessor1[$i];
					$v->NominationType = 'Nominated';
					$v->AssessorActive = 1;
					$v->User =  User::getSysUser()->userID;
					$v->save();
					}
				
			}
			
			     //Edit Multiple Assesor Nominated Dates
          $setValAN = explode(',',Input::get('datesANM'));
          $no_of_DatesAN = count($setValAN);
          $final_selected_datesAN = array_map('trim',$setValAN);
          $deletedAN = ExamAssesorMoninatedDates::where('YearPlanID','=',$CYPID)->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesAN;$f++)
          {
            $availableAN = ExamAssesorMoninatedDates::where('YearPlanID','=',Input::get('edit_id'))->where('AssessorNominatedDate','=',$final_selected_datesAN[$f])->count();
            if($availableAN == 0)
            {
            $u = new ExamAssesorMoninatedDates();
            $u->AssessorNominatedDate = $final_selected_datesAN[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaAN = ExamAssesorMoninatedDates::where('YearPlanID','=',Input::get('edit_id'))->where('AssessorNominatedDate','=',$final_selected_datesAN[$f])->update(array('Deleted' => 0));
            }
          }
          // end
		  
			if($RenominatedStatus == 1)
			{
			for($i=0;$i<$countAssessorReNominated1;$i++)
			{
					$ifavailable = NVQAssessorNomination::where('CYPID','=',$CYPID)->where('NominationType','=','ReNominated')->where('AssessorId','=',$AssessorReNominated[$i])->get();
					if(count($ifavailable)>0)
					{
					$ifavailable = NVQAssessorNomination::where('CYPID','=',$CYPID)->where('NominationType','=','ReNominated')->where('AssessorId','=',$AssessorReNominated[$i])->update(array('AssessorActive' => 1,'Deleted' => 0));
					}
					else
					{
					$v = new NVQAssessorNomination();
					$v->CYPID = $CYPID;
					$v->AssessorId = $AssessorReNominated[$i];
					$v->AssessorActive = 1;
					$v->NominationType = 'ReNominated';
					$v->User =  User::getSysUser()->userID;
					$v->save();
					}
				
			}
			}
           
             $view = View::make('Assessor.ViewAssignedAssessors');
        
          $UserOrgID = User::getSysUser()->organisationId; 
          $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
          $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
          $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
          $view->Districts = District::orderBy('DistrictName')->get();
          $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
    $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
    ->where('Active','=','Yes')
    ->whereNotIn('Type',['HO','DO','PO'])
    ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
    $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
  elseif($OegaType == 'PO')
  {
    
    $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
    $sql = "select * 
          from organisation
          left join district
          on organisation.DistrictCode=district.DistrictCode
          left join province
          on district.ProvinceCode=province.ProvinceCode
          where organisation.Deleted=0
          and organisation.Active='Yes'
          and province.ProvinceCode='".$loggedUserProvince."'
          and organisation.Type not in('HO','DO','PO')
          order by organisation.OrgaName";
          $centers = DB::select(DB::raw($sql));
          $view->Centers = $centers;
  }
    else
    {
    $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
  
    //$CenterIDD=Input::get('CenterIDD');
    //$YearD=Input::get('YearD');
    //$BatchD=Input::get('BatchD');
    //$districtD=Input::get('districtD');
    
    $CenterID = Input::get('CenterIDD');
    $Year = Input::get('YearD');
    $Batch = Input::get('BatchD');
    $district = Input::get('districtD');
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');

         if($CenterID == 'All' && $district == 'All')
    {
      //$district = Input::get('District');
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
         courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CourseListCode=coursedetails.CourseListCode
            where courseyearplan.Deleted=0
            and courseyearplan.Year='".$Year."'
            and courseyearplan.batch like '$Batch%'
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
            ";
    }
    elseif($CenterID == 'All' && $district != 'All')
    {
      $sql = "DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
           courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CourseListCode=coursedetails.CourseListCode
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and courseyearplan.Year='".$Year."'
 and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
    }
    else
    {
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
         courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CourseListCode=coursedetails.CourseListCode
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
    }
      
  $trplans = DB::select(DB::raw($sql));
  $view->trplans = $trplans;
  $view->CenterIDD = $CenterID;
  $view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
    return $view;               

        }
    }
	
	  public function DeletedUnits() {


        $cid = Input::get('cid');


        $course = NVQUnits::findOrFail($cid); // if not found show 404 page


        $course->Deleted = 1;
		
        $course->User = User::getSysUser()->userID;



        $course->save();

  return Redirect::to('viewUnits');
    }
	
	  public function EditUnits() {
        $view = View::make('NVQUnits.Edit');


        switch (Request::getMethod()) {
            case 'GET':
                    $view->course = NVQUnits::where('UID', "=", Input::get('cid'))->first();
                

                return $view;

                break;

            case 'POST':

				$UnitCode = Input::get('UnitCode');
				 $UnitName = Input::get('UnitName');
                $i=0;

                $c = NVQUnits::find(Input::get('CD_ID'));


                //$c->fill(Input::all());
                $c->UnitCode= $UnitCode;
				$c->UnitName = $UnitName;
                $c->UnitVersion = Input::get('UnitVersion');
				 //$c->UnitStatus= Input::get('Ustatus');
                $c->User = User::getSysUser()->userID;
                
                $c->save();
              

               
                return Redirect::to('viewUnits');

                // do your edit here


            
        }
    }
	
	 public function CreateUnits() {


        $method = Request::getMethod();

        $view = View::make('NVQUnits.Create');
        $view->user = User::getSysUser();
		


        if ($method == "GET") {


            return $view;
        }
        if ($method == "POST") {

                $UnitCode = Input::get('UnitCode');
				 $UnitName = Input::get('UnitName');
                
                $c = new NVQUnits;
               // $c->fill(Input::all());
                $c->UnitCode= $UnitCode;
				$c->UnitName = $UnitName;
				$c->UnitVersion = Input::get('UnitVersion');
				//$a->UnitStatus= Input::get('Ustatus');
                $c->User = User::getSysUser()->userID;
                $c->save();



                return $view->with("done", true);
            
        }
    }
	
	  public function viewUnits() {

     $courses = NVQUnits::where('Deleted','=','0')->orderBy('UnitCode')->get();

        $v = View::make('NVQUnits.course');
        $v->courses = $courses;
        $v->user = User::getSysUser();
        return $v;
    }


  public function PrintExamAssesorAssigningView()
  {
    $CenterID = Input::get('CenterIDD');
    $Year = Input::get('YearD');
    $Batch = Input::get('BatchD');
    $district = Input::get('districtD');
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $html='';
    
    if($Batch == 'All')
    {
      if($CenterID == 'All' && $district == 'All')
    {
      //$district = Input::get('District');
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
			courseyearplan.AssessmentNo,
            courseyearplan.FinalExamHeld,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CourseListCode=coursedetails.CourseListCode
            where courseyearplan.Deleted=0
            and courseyearplan.Year='".$Year."'
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
            ";
    }
    elseif($CenterID == 'All' && $district != 'All')
    {
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
           courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CourseListCode=coursedetails.CourseListCode
            where courseyearplan.Deleted=0
            and organisation.DistrictCode='".$district."'
            and courseyearplan.Year='".$Year."'
             and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
            ";
    }
    else
    {
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
           courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CourseListCode=coursedetails.CourseListCode
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
    }
    }
    else
    {
      if($CenterID == 'All' && $district == 'All')
    {
      //$district = Input::get('District');
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
         courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment

            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CourseListCode=coursedetails.CourseListCode
            where courseyearplan.Deleted=0
            and courseyearplan.Year='".$Year."'
            and courseyearplan.batch like '$Batch%'
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
            ";
    }
    elseif($CenterID == 'All' && $district != 'All')
    {
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
          courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CourseListCode=coursedetails.CourseListCode
            where courseyearplan.Deleted=0
            and organisation.DistrictCode='".$district."'
            and courseyearplan.Year='".$Year."'
            and courseyearplan.batch like '$Batch%'
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
            ";
    }
    else
    {
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
            courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CourseListCode=coursedetails.CourseListCode
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
    }
    }
     
    
    
  $trplans = DB::select(DB::raw($sql));
    $i = 1;
    $taskname = '';
  $taskCode = '';
    $modulename = '';
  $ModuleCode = '';
     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No',
	 'District', 'Centre', 'Year', 'Batch',
   'CourseName','Duration','Enrollment Capacity',
   'CourseType', 'NVQ/NON-NVQ','NVQLevel','Start Date','End Date','Actual Start Date','Actual End Date','Assesment No',
   
   'AssessorNominatedDate','Assesor Nominated List','Assesor Renominated Status',
   'Pre Assesment Date',
   'Final Assesment Held',
   'FinalAssessmentDate',
   'DocumentSendingDatetoHO','ResultCheckedDate','Comments','Assessor Entered Dates');
    array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

        $endDate = MOCenterMonitoringPlan::getEndDate($aa->RealstartDate,$aa->Duration);
         $Packages = MOCenterMonitoringPlan::getPackages($aa->CD_ID);
         $monitoringDate = MOCenterMonitoringPlan::getMonitoringDates($aa->id);    
         
         $pack = '';
         $com = ',';
         $exp = '';
         $emp = '';
         $a = '/';
         $dod = '.';
		 $fbrase = '(';
		  $bbrase = ')';
        $fdates='';
         $Andates = '';
		 $AssesorList = '';
         $dsdateHO = '';
         $rescheckdate='';
         $dsenddatetoTVEC = '';
         $dateprepareROA = '';
         $certifiresdatesfromTVEC='';
         $certifiissudatedistrict='';
         $Englishtradecourseres='';
         $CBTResdate='';
		 $asserenome = '';
		 $AssesorRenomdList = '';
		 $AssesorEnteredDates = '';

foreach($Packages as $p)
        {
          $pack= $pack.$p->packagecode.$com;
        }   

  foreach($monitoringDate as $m)
        {
          $exp=$exp.$m->DatePlanned.$com;
          $emp=$emp.$m->Initials.$dod.$m->LastName.$a.$m->Approved.$a.$m->Visited.$com;
          
          
        } 
        
/* $getAccredit = AccreditationDetails::getAccreditation($aa->OrgId,$aa->CD_ID);
 $AccCount = count($getAccredit);
 
            if($AccCount == 0)
            {
                             $acctedit='Data Not Available';
               $accteditrec='Data Not Available';
                             $accteditfrom='Data Not Available';
               $accteditto='Data Not Available';
            }
              else
              {
                foreach($getAccredit as $a)
                {
                  if($a->Accredit == 'Yes')
                  {
                  $acctedit=$a->Accredit;
                  $accteditrec=$a->AccreditRecommandedDate;
                  $accteditfrom=$a->AccreditDate;
                  $accteditto=$a->AccreditationValidDate;
                  }
                  elseif($a->Accredit == 'Recommended')
                  {
                  $acctedit=$a->Accredit;
                  $accteditrec=$a->AccreditRecommandedDate;
                  $accteditfrom='****';
                  $accteditto='****';
                  }
                  elseif($a->Accredit == 'Expired')
                  {
                  $acctedit=$a->Accredit;
                  $accteditrec='****';
                  $accteditfrom='****';
                  $accteditto=$a->AccreditationValidDate;
                  }
                  else
                  {
                  $acctedit=$a->Accredit;
                  $accteditrec='****';
                  $accteditfrom='****';
                  $accteditto='****';
                  }
                }
              } */
    $GetFinalAssDates = ExamFinalAssessmentDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
              foreach($GetFinalAssDates as $f)
              {
                 $fdates.=$f->FinalAssessmentDate.$com;
              }   
$GetAssessorNominatedDates = ExamAssesorMoninatedDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
           foreach($GetAssessorNominatedDates as $f)
              {
                 $Andates.=$f->AssessorNominatedDate.$com;
              }
              
              $GetDocumentsendingDatestoHO = ExamDocumentSendingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
             foreach($GetDocumentsendingDatestoHO as $f)
              {
                 $dsdateHO.=$f->DocumentSendingDateToHO.$com;
              }
              
              $GetResultCheckedDates = ExamResultCheckedDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
                foreach($GetResultCheckedDates as $f)
              {
                 $rescheckdate.=$f->ResultCheckedDate.$com;
              }
			  $getNominatedAssesorList = DB::select(DB::raw("select assessor.AssessorId,assessor.Name,assessor.DateEntered,assessornomination.NominationType
																	  from assessornomination
																	  left join assessor
																	  on assessornomination.AssessorId=assessor.id
																	  where assessornomination.Deleted=0
																	  and assessornomination.AssessorActive=1
																	  and assessornomination.CYPID='".$aa->id."'
																	  order by AssessorId"));
																	  
																  
              
              
           foreach($getNominatedAssesorList as $kl)
		   {
						$AssesorList.=$kl->AssessorId.$fbrase.$kl->NominationType.$bbrase.$com;
						$AssesorEnteredDates.=$kl->DateEntered.$com;
		   }
		  			
           if($aa->AssessorReNominated == 1)   
		   {
			   $asserenome = 'Yes';
		   }
			else
			{
				$asserenome = 'No';
			}	
			
			
			
			
			
      array_push($printablearray, array($i,$aa->DistrictName, 
    $aa->OrgaName, $aa->Year,$aa->batch,$aa->CourseName,$aa->Duration,$aa->maxCapacity,
    $aa->CourseType,$aa->Nvq,$aa->CourseLevel,$aa->RealstartDate,$aa->RealEndDate,$aa->ExActualStartDate,$aa->ExActualEndDate,$aa->AssessmentNo,$Andates,$AssesorList,
	$asserenome,
	$aa->PreAssessmentDate,$aa->FinalExamHeld,$fdates,
    $dsdateHO,$rescheckdate,$aa->Comment,$AssesorEnteredDates));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('ExamDateDetails-"'.(Date("Y-m-d")).'"');
    
  }

  public function editExamAssesorAssigningView()
  {
     switch (Request::getMethod()) {
            case 'GET':
     
          $userOrgId=User::getSysUserOrg();
          $view = View::make('ExamAssesor.EditCourseYearPlanByTestingEva');
          $CourseYearOrginigal = CourseYearPlan::where('Deleted','=',0)->where('id','=',Input::get('edit_id'))->first();
          $CourseYearPlan1 = DB::select(DB::raw("select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
            courseyearplan.FinalExamHeld,
          
            courseyearplan.Comment
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CD_ID=coursedetails.CD_ID
            where courseyearplan.Deleted=0
            and courseyearplan.id='".Input::get('edit_id')."'
            limit 1
          "));
          
       
          $view->CenterIDD=Input::get('CenterIDD');
          $view->YearD=Input::get('YearD');
          $view->BatchD=Input::get('BatchD');
          $view->districtD=Input::get('districtD');
          
          $view->CourseYearPlan=$CourseYearPlan1;
          $view->courseYearOri = $CourseYearOrginigal;
          return $view;
          break;
          case 'POST':
          
          $orgID = Input::get('edit_id');
                 
          $cyp = CourseYearPlan::find(Input::get('edit_id'));
                
          $cyp->PreAssessmentDate = Input::get('PreAssessmentDate');
		  //$cyp->AssessmentNo =  Input::get('AssesmentNo');
         
          $cyp->FinalExamHeld = Input::get('FinalExamHeld');
          $cyp->ExActualStartDate = Input::get('ExActualStartDate');
          $cyp->ExActualEndDate = Input::get('ExActualEndDate');
          //Edit Multiple Final Assessment Dates
          $setVal = explode(',',Input::get('dates'));
          $no_of_Dates = count($setVal);
          $final_selected_dates = array_map('trim',$setVal);
          $deleted = ExamFinalAssessmentDates::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_Dates;$f++)
          {
            $available = ExamFinalAssessmentDates::where('YearPlanID','=',Input::get('edit_id'))->where('FinalAssessmentDate','=',$final_selected_dates[$f])->count();
            if($available == 0)
            {
            $u = new ExamFinalAssessmentDates();
            $u->FinalAssessmentDate = $final_selected_dates[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefda = ExamFinalAssessmentDates::where('YearPlanID','=',Input::get('edit_id'))->where('FinalAssessmentDate','=',$final_selected_dates[$f])->update(array('Deleted' => 0));
            }
          }
          //$cyp->FinalAssessmentDate = Input::get('FinalAssessmentDate');
          //
      
          
          //Edit Multiple Document Sending Dates To HO
          $setValDSHO = explode(',',Input::get('datesDSHOM'));
          $no_of_DatesDSHO = count($setValDSHO);
          $final_selected_datesDSHO = array_map('trim',$setValDSHO);
          $deletedDSHO = ExamDocumentSendingDateToHO::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesDSHO;$f++)
          {
            $availableDSHO = ExamDocumentSendingDateToHO::where('YearPlanID','=',Input::get('edit_id'))->where('DocumentSendingDateToHO','=',$final_selected_datesDSHO[$f])->count();
            if($availableDSHO == 0)
            {
            $u = new ExamDocumentSendingDateToHO();
            $u->DocumentSendingDateToHO = $final_selected_datesDSHO[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaDSHO = ExamDocumentSendingDateToHO::where('YearPlanID','=',Input::get('edit_id'))->where('DocumentSendingDateToHO','=',$final_selected_datesDSHO[$f])->update(array('Deleted' => 0));
            }
          }
          // end
          
          //Edit Result Checked Dates
          $setValRCD = explode(',',Input::get('datesRCDM'));
          $no_of_DatesRCD = count($setValRCD);
          $final_selected_datesRCD = array_map('trim',$setValRCD);
          $deletedRCD = ExamResultCheckedDates::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesRCD;$f++)
          {
            $availableRCD = ExamResultCheckedDates::where('YearPlanID','=',Input::get('edit_id'))->where('ResultCheckedDate','=',$final_selected_datesRCD[$f])->count();
            if($availableRCD == 0)
            {
            $u = new ExamResultCheckedDates();
            $u->ResultCheckedDate = $final_selected_datesRCD[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaRCD = ExamResultCheckedDates::where('YearPlanID','=',Input::get('edit_id'))->where('ResultCheckedDate','=',$final_selected_datesRCD[$f])->update(array('Deleted' => 0));
            }
          }
          // end
          
          //Edit Document Sending Dates to TVEC
          /*$setValDSDT = explode(',',Input::get('datesDSDTM'));
          $no_of_DatesDSDT = count($setValDSDT);
          $final_selected_datesDSDT = array_map('trim',$setValDSDT);
          $deletedDSDT = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesDSDT;$f++)
          {
            $availableDSDT = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',Input::get('edit_id'))->where('DocumentSendingDateToTVEC','=',$final_selected_datesDSDT[$f])->count();
            if($availableDSDT == 0)
            {
            $u = new ExamDocumentSendingDtaeToTVEC();
            $u->DocumentSendingDateToTVEC = $final_selected_datesDSDT[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaDSDT = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',Input::get('edit_id'))->where('DocumentSendingDateToTVEC','=',$final_selected_datesDSDT[$f])->update(array('Deleted' => 0));
            }
          }*/
          // end
          
          //Edit Date of Prepare ROA
         /* $setValDPROA = explode(',',Input::get('datesDPROAM'));
          $no_of_DatesDPROA = count($setValDPROA);
          $final_selected_datesDPROA = array_map('trim',$setValDPROA);
          $deletedDPROA = ExamDatePrepareROACertificate::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesDPROA;$f++)
          {
            $availableDPROA = ExamDatePrepareROACertificate::where('YearPlanID','=',Input::get('edit_id'))->where('DatePrepareROAcertificate','=',$final_selected_datesDPROA[$f])->count();
            if($availableDPROA == 0)
            {
            $u = new ExamDatePrepareROACertificate();
            $u->DatePrepareROAcertificate = $final_selected_datesDPROA[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaDPROA = ExamDatePrepareROACertificate::where('YearPlanID','=',Input::get('edit_id'))->where('DatePrepareROAcertificate','=',$final_selected_datesDPROA[$f])->update(array('Deleted' => 0));
            }
          }*/
          // end
          
          //Edit certificate recieving from TVEC
        /*  $setValCRDFTVEC = explode(',',Input::get('datesCRDFTVECM'));
          $no_of_DatesCRDFTVEC = count($setValCRDFTVEC);
          $final_selected_datesCRDFTVEC = array_map('trim',$setValCRDFTVEC);
          $deletedCRDFTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesCRDFTVEC;$f++)
          {
            $availableCRDFTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',Input::get('edit_id'))->where('CertificateRecievingDateFromTVEC','=',$final_selected_datesCRDFTVEC[$f])->count();
            if($availableCRDFTVEC == 0)
            {
            $u = new ExamCertificateRecievingDateFromTVEC();
            $u->CertificateRecievingDateFromTVEC = $final_selected_datesCRDFTVEC[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaCRDFTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',Input::get('edit_id'))->where('CertificateRecievingDateFromTVEC','=',$final_selected_datesCRDFTVEC[$f])->update(array('Deleted' => 0));
            }
          }*/
          // end
          //Edit certificate issuing dates to District
         /* $setValCIDTDIS = explode(',',Input::get('datesCIDTDISM'));
          $no_of_DatesCIDTDIS = count($setValCIDTDIS);
          $final_selected_datesCIDTDIS = array_map('trim',$setValCIDTDIS);
          $deletedCIDTDIS = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesCIDTDIS;$f++)
          {
            $availableCIDTDIS = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',Input::get('edit_id'))->where('CertificateissuingDateToDistrict','=',$final_selected_datesCIDTDIS[$f])->count();
            if($availableCIDTDIS == 0)
            {
            $u = new ExamCertificateIssuingDateToDistrict();
            $u->CertificateissuingDateToDistrict = $final_selected_datesCIDTDIS[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaCIDTDIS = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',Input::get('edit_id'))->where('CertificateissuingDateToDistrict','=',$final_selected_datesCIDTDIS[$f])->update(array('Deleted' => 0));
            }
          }*/
          // end
          
          //Edit English Trade Course Reciveing HO
        /*  $setValETCRDHO = explode(',',Input::get('datesETCRDHOM'));
          $no_of_DatesETCRDHO = count($setValETCRDHO);
          $final_selected_datesETCRDHO = array_map('trim',$setValETCRDHO);
          $deletedETCRDHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesETCRDHO;$f++)
          {
            $availableETCRDHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',Input::get('edit_id'))->where('EnglishTradeCourseResDate','=',$final_selected_datesETCRDHO[$f])->count();
            if($availableETCRDHO == 0)
            {
            $u = new ExamEnglishTradeCourseRecievingDateHO();
            $u->EnglishTradeCourseResDate = $final_selected_datesETCRDHO[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaETCRDHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',Input::get('edit_id'))->where('EnglishTradeCourseResDate','=',$final_selected_datesETCRDHO[$f])->update(array('Deleted' => 0));
            }
          }*/
          // end
          //Edit CBT Results HO
         /* $setValCBTHO = explode(',',Input::get('datesCBTHOM'));
          $no_of_DatesCBTHO = count($setValCBTHO);
          $final_selected_datesCBTHO = array_map('trim',$setValCBTHO);
          $deletedCBTHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
          for($f=0;$f<$no_of_DatesCBTHO;$f++)
          {
            $availableCBTHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',Input::get('edit_id'))->where('CBTResultsRecievingDate','=',$final_selected_datesCBTHO[$f])->count();
            if($availableCBTHO == 0)
            {
            $u = new ExamCBTResultRecievingDateToHO();
            $u->CBTResultsRecievingDate = $final_selected_datesCBTHO[$f];
            $u->User = User::getSysUser()->userID;
            $u->YearPlanID = Input::get('edit_id');
            $u->save();
            }
            else
            {
              $updatefdaCBTHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',Input::get('edit_id'))->where('CBTResultsRecievingDate','=',$final_selected_datesCBTHO[$f])->update(array('Deleted' => 0));
            }
          }*/
          // end
          $cyp->Comment = Input::get('Comment');
          $cyp->ExamUnitUserID = User::getSysUser()->userID;
          $cyp->save();

          $view = View::make('ExamAssesor.ViewTrainingPlanUpdateByTestingEva');
         // $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
          $UserOrgID = User::getSysUser()->organisationId; 
          $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
          $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
          $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
          $view->Districts = District::orderBy('DistrictName')->get();
          $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
    $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
    ->where('Active','=','Yes')
    ->whereNotIn('Type',['HO','DO','PO'])
    ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
    $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
  elseif($OegaType == 'PO')
  {
    
    $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
    $sql = "select * 
          from organisation
          left join district
          on organisation.DistrictCode=district.DistrictCode
          left join province
          on district.ProvinceCode=province.ProvinceCode
          where organisation.Deleted=0
          and organisation.Active='Yes'
          and province.ProvinceCode='".$loggedUserProvince."'
          and organisation.Type not in('HO','DO','PO')
          order by organisation.OrgaName";
          $centers = DB::select(DB::raw($sql));
          $view->Centers = $centers;
  }
    else
    {
    $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
  
    //$CenterIDD=Input::get('CenterIDD');
    //$YearD=Input::get('YearD');
    //$BatchD=Input::get('BatchD');
    //$districtD=Input::get('districtD');
    
    $CenterID = Input::get('CenterIDD');
    $Year = Input::get('YearD');
    $Batch = Input::get('BatchD');
    $district = Input::get('districtD');
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
    $loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');

         if($CenterID == 'All' && $district == 'All')
    {
      //$district = Input::get('District');
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
         courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CourseListCode=coursedetails.CourseListCode
            where courseyearplan.Deleted=0
            and courseyearplan.Year='".$Year."'
            and courseyearplan.batch like '$Batch%'
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
            ";
    }
    elseif($CenterID == 'All' && $district != 'All')
    {
      $sql = "DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
           courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CourseListCode=coursedetails.CourseListCode
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and courseyearplan.Year='".$Year."'
 and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
    }
    else
    {
      $sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.PreAssessmentDate,
			courseyearplan.AssessorReNominated,
             courseyearplan.FinalExamHeld,
         courseyearplan.AssessmentNo,
           courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CourseListCode=coursedetails.CourseListCode
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
    }
      
  $trplans = DB::select(DB::raw($sql));
  $view->trplans = $trplans;
  $view->CenterIDD = $CenterID;
  $view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
    return $view;               
                    
                
                break;
            default:
                break;
        }
  }
  
	
	public function ExamAssesorAssigningView()
	{
	$method = Request::getMethod();
    $view = View::make('ExamAssesor.ViewTrainingPlanUpdateByTestingEva');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
	  $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
	  $view->Districts = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		$sql = "select * 
				  from organisation
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where organisation.Deleted=0
				  and organisation.Active='Yes'
				  and province.ProvinceCode='".$loggedUserProvince."'
				  and organisation.Type not in('HO','DO','PO')
				  order by organisation.OrgaName";
				  $centers = DB::select(DB::raw($sql));
				  $view->Centers = $centers;
	}
    else
    {
	  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }


    $method=Request::getMethod();
    
    if ($method == "GET") 
    {
        return $view;
    }
	
	 if ($method == "POST") 
    {
		
		$CenterID = Input::get('CenterID');
		$Year = Input::get('Year');
		$Batch = Input::get('Batch');
		$district = Input::get('District');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		
		if($Batch == 'All')
		{
			if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
            from courseyearplan
            left join organisation
            on courseyearplan.OrgId=organisation.id
            left join district
            on organisation.DistrictCode=district.DistrictCode
            left join coursedetails
            on courseyearplan.CD_ID=coursedetails.CD_ID
            where courseyearplan.Deleted=0
            and courseyearplan.Year='".$Year."'
          
            and courseyearplan.StartedStatus=1
            group by courseyearplan.id 
            order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and courseyearplan.Year='".$Year."'
 
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		
		}
		else
		{
			if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
          courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
					  from courseyearplan
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where courseyearplan.Deleted=0
					  and courseyearplan.Year='".$Year."'
					 and courseyearplan.batch like '$Batch%'
					  and courseyearplan.StartedStatus=1
					  group by courseyearplan.id 
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
          courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select DISTINCT courseyearplan.id,
            district.DistrictName,organisation.OrgaName,
            organisation.Type,
            courseyearplan.Year,
            courseyearplan.maxCapacity,
            courseyearplan.batch,
            coursedetails.CourseName,
            coursedetails.CourseListCode,
            coursedetails.CD_ID,
            coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
            coursedetails.Duration,
            courseyearplan.medium AS Medium,
            courseyearplan.RealstartDate,
            courseyearplan.RealEndDate,
            courseyearplan.StartedStatus,
            courseyearplan.AssessmentNo,
            courseyearplan.OrgId,
            courseyearplan.ExActualStartDate,
            courseyearplan.ExActualEndDate,
            courseyearplan.Comment,
                 courseyearplan.PreAssessmentDate,
				 courseyearplan.AssessorReNominated,
  courseyearplan.FinalExamHeld
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.DistrictCode='".$district."'
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
 and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus=1
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration";
		}
		
			
		}
		
		
		//return $sql;
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
        return $view;
    }
	}
	

}