<?php

use SimpleExcel\SimpleExcel;


class TrainingPlanReportController extends BaseController {
	

		public function editCourseYearPlanOJT()
	{
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
                $view = View::make('OJT.EditCourseYearPlanByTestingEva');
                $view->CourseListCode = Course::where('Deleted', '=', 0)
                ->orderBy('CourseListCode')
                ->get();
                $view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
            $CourseYearPlan1 = CourseYearPlan::find(Input::get('edit_id'));
         $temp_yr=$CourseYearPlan1->startDate;
		 $CDID = $CourseYearPlan1->CD_ID;
		 $CategoryIdn  = Course::where('CD_ID','=',$CDID)->pluck('CourseCategoryId');
		 $sqlrepeatcourse = DB::select(DB::raw("SELECT courseyearplan.id,organisation.OrgaName,organisation.Type,coursedetails.CourseName,coursedetails.CourseListCode,courseyearplan.Year
											  ,courseyearplan.batch,courseyearplan.medium,coursedetails.CourseType,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,courseyearplan.RealstartDate
											  from courseyearplan
											  left join coursedetails
											  on courseyearplan.CD_ID=coursedetails.CD_ID
											  left join coursecategory
											  on coursedetails.CourseCategoryId=coursecategory.id
											  left join organisation
											  on courseyearplan.OrgId=organisation.id
											  where courseyearplan.Deleted=0
											  and courseyearplan.RealstartDate>'".$temp_yr."'
											  and coursedetails.Deleted=0
											  and courseyearplan.StartedStatus=1
											  and coursedetails.CourseCategoryId='".$CategoryIdn."'
											  and courseyearplan.id not in('".Input::get('edit_id')."')
											  order by organisation.OrgaName,courseyearplan.Year,courseyearplan.batch"));
		
		    $view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			$view->RepCourse = $sqlrepeatcourse;
			$view->CourseLevels = DB::select(DB::raw("select distinct coursedetails.CourseLevel
													  from coursedetails
													  where coursedetails.Deleted=0
													  order by CourseLevel"));
			
			$ppp = DB::select(DB::raw("select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
									  from moinstructorcourse
									  left join moinstructor
									  on moinstructorcourse.InstructorID=moinstructor.id
									  where moinstructorcourse.CourseYearPlanID='".Input::get('edit_id')."'
									  and moinstructorcourse.Active='Yes'"));
             $view->AddedInstructors = $ppp;
           $view->OrgaType=$OrgaType;
            $view->date=trim($temp_yr);
			$view->CourseLevel=trim($CourseYearPlan1->CourseLevel);
			
			$NVQLevel =Course::where('CourseListCode','=',$CourseYearPlan1->CourseListCode)
							->where('Deleted', '!=', 1)
							->pluck('Nvq');
			$view->NVQ=trim($NVQLevel);

              $view->CourseYearPlan=$CourseYearPlan1;
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
              $organisation=Organisation::where('Deleted','=',0)->where('Active','=','Yes')->where('Type','!=','HO')->orderBy('OrgaName')->get();
              $view->organisation=$organisation;
			  
			  
                // $view->CourseYearPlan = CourseYearPlan::where("Deleted","=",0);
                return $view;
                break;
                case 'POST':
               // $validator = CourseYearPlan::validate(Input::all());
              
                    
                    $orgID = Input::get('edit_id');
                 
					$cyp = CourseYearPlan::find(Input::get('edit_id'));
                    $cyp->NoOFOJTPlaced = Input::get('NoOFOJTPlaced');
					$cyp->NoOFOJTCompleted = Input::get('NoOFOJTCompleted');
					$cyp->NoOfJobPlaaced = Input::get('NoOfJobPlaaced');
					$cyp->OJTPlacedNVQLevel = Input::get('OJTCourseLevel');
					$cyp->save();
                    $view = View::make('OJT.ViewTrainingPlanUpdateByTestingEva');
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.NoOfTrainees,
  courseyearplan.Dropout,
  courseyearplan.StartedStatus,
  courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
  courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
  courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
  courseyearplan.AccreditRecommendDate,
  courseyearplan.NoOfRepeaters,
  courseyearplan.AssessorReNominated,
  courseyearplan.EnglishReceivingDateHO,
  courseyearplan.CBTResultReceivingDateToHO,
  courseyearplan.OrgId,
  courseyearplan.FinalExamHeld,
  courseyearplan.ExActualStartDate,
  courseyearplan.ExActualEndDate,
  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.NoOfTrainees,
  courseyearplan.Dropout,
  courseyearplan.StartedStatus,
  courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
  courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
  courseyearplan.AccreditRecommendDate,
  courseyearplan.NoOfRepeaters,
  courseyearplan.AssessorReNominated,
  courseyearplan.EnglishReceivingDateHO,
  courseyearplan.CBTResultReceivingDateToHO,
	courseyearplan.OrgId,
	courseyearplan.FinalExamHeld,
	courseyearplan.ExActualStartDate,
	courseyearplan.ExActualEndDate,
	courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
	
		public function ViewTrainingPlanUpdateIROJT()
	{
	$method = Request::getMethod();
    $view = View::make('OJT.ViewTrainingPlanUpdateByTestingEva');
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					  
					  courseyearplan.PreAssessmentDate,
					 
					  courseyearplan.FinalExamHeld,
					 
					
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.AssessorReNominated,
					 
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate
					
 
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					  
					  courseyearplan.PreAssessmentDate,
					 
					  courseyearplan.FinalExamHeld,
					 
					
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.AssessorReNominated,
					 
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					  
					  courseyearplan.PreAssessmentDate,
					 
					  courseyearplan.FinalExamHeld,
					 
					
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.AssessorReNominated,
					 
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					  
					  courseyearplan.PreAssessmentDate,
					 
					  courseyearplan.FinalExamHeld,
					 
					
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.AssessorReNominated,
					 
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					  
					  courseyearplan.PreAssessmentDate,
					 
					  courseyearplan.FinalExamHeld,
					 
					
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.AssessorReNominated,
					 
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					  
					  courseyearplan.PreAssessmentDate,
					 
					  courseyearplan.FinalExamHeld,
					 
					
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.AssessorReNominated,
					 
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate
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
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
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
	
	public function UpdateAllExpectedCompletedDateCourseYearPlan()
	{
		$sql = "select courseyearplan.*,coursedetails.Duration
			    from courseyearplan
			    left join coursedetails
			    on courseyearplan.CD_ID=coursedetails.CD_ID
			    where courseyearplan.Deleted=0
			    order by courseyearplan.id";
		$CYP=DB::select(DB::raw($sql));
		foreach($CYP as $mm)
		{
			$endDate = TrainingPlanReportController::getExpectedEndDate($mm->RealstartDate,$mm->Duration);
			$update = CourseYearPlan::where('id','=',$mm->id)->update(array('RealEndDate' => $endDate));
		}
		
		return 'Real End Dates Updated Successfully!!!';
	}
	public static function getExpectedEndDate($startdate,$duration)
	{
		
		$sql78 = "SELECT DATE_ADD('$startdate', INTERVAL '$duration' MONTH) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
		  return $expectedcom;
	}
	public function LoadMoinstructorListDis()
    {
        $id=Input::get('id');
		  $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
		  $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  
		/*   if($OrgaType != 'HO')
				{
					$Instructors = MOInstructor::where('Deleted','=',0)->where('DistrictCode','=',$loggeduserDistrict)->orderBy('Name')->get();
				} */
				/* else
				{ */
					$Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
				/* } */
				$ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$id."'
						  and moinstructorcourse.Active='Yes'";
            
				$Ins=DB::select(DB::raw($ppp));
    //
    $html='';
        foreach($Ins As $i){
          //  $html.='<option value="'.$i->id.'" selected>'.$i->Name.'-'.$i->EPFNo.'</option>';
			$html.='<option value="'.$i->id.'" selected>'.$i->EPFNo.' - '.$i->Name.'</option>';
        }
		foreach($Instructors As $i){
            //$html.='<option value="'.$i->id.'">'.$i->Name.'-'.$i->EPFNo.'</option>';
			$html.='<option value="'.$i->id.'">'.$i->EPFNo.' - '.$i->Name.'</option>';
        }
        $html.='';
    return $html;
    //
    }
	
	public function DownloadLoadViewCenterSubCriteariaWiseMonitoringProgressReport()
{
	 $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

	$District = Input::get('District');
	$CenterID = Input::get('CenterID');
	//$CD_ID = Input::get('CD_ID');
	$CriteariaID = Input::get('CriteariaID');
	
	//$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	//$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	$CriteariaNameSinhala = MOCenterCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInSinhala');
	$CriteariaNameEnglish = MOCenterCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInEnglish');
	
    $Count = 0;
    $html='';
$tablePrintHeader0 = array('', 'Date Range', $tempStartDate,'-',$tempEndDate,'','','','','','','','');
    $tablePrintHeader = array('#', 'District','Center','Critearia','Sub Critearia','Total Mark','Date Planned1','Mark Achived1%','Date Planned2','Mark Achived2%');
	

    $excel = new SimpleExcel('csv');
    $printablearray = array();
	array_push($printablearray, $tablePrintHeader0);
    array_push($printablearray, $tablePrintHeader);

         $i = 1;
  
$Critearia = MOCenterCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
$SubCritearia = MOCenterCriteria::where('CategoryId','=',$CriteariaID)->where('Active','=',1)->where('Deleted','=',0)->orderBy('Order')->get();

		   $sql = "select monewcentermonitoringplan.*
  from monewcentermonitoringplan
 where monewcentermonitoringplan.Deleted=0
  and monewcentermonitoringplan.Visited=1
 and monewcentermonitoringplan.CenterID='".$CenterID."'
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'";
		  $mainCount = DB::select(DB::raw($sql));
		  $CountTH = count($mainCount);


             foreach($SubCritearia as $ps) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $DistrictNAme);
                array_push($data_row, $CenterName);
			  
                array_push($data_row, $CriteariaNameEnglish);
				 array_push($data_row, $ps->CriteriaNameInEnglish);
				 if($ps->FullWeight != 0)
								{
									$FullWeight = $ps->FullWeight;
								}
								else{
									$FullWeight ='User Entered Values';
								}
				array_push($data_row, $FullWeight);
				 foreach($mainCount as $m) {
					 
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOCenterMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								
								 if($ps->FullWeight != 0)
								{
									$sql1 = "select sum(mocentermonitoring.Mark) as TotalSubCriteariaMark
										  from mocentermonitoring
										  left join mocentercriteria
										  on mocentermonitoring.CriteriaID=mocentercriteria.id
										  left join mocentercriteriacategory
										  on mocentercriteria.CategoryId=mocentercriteriacategory.id
										  where mocentermonitoring.CMPlanid='".$MonitoringPlanID."'
										  and mocentermonitoring.Deleted=0
										  and mocentercriteria.Active=1
										  and mocentercriteria.Deleted=0
										  and mocentercriteriacategory.Active=1
										  and mocentercriteriacategory.Deleted=0
										   and mocentermonitoring.ClassWeightType IN('YN','P')
										  and mocentercriteriacategory.id='".$CriteariaID."'
										  and mocentercriteria.id='".$ps->id."'";
								}
								else{
									$sql1 = "select mocentermonitoring.Mark as TotalSubCriteariaMark
										  from mocentermonitoring
										  left join mocentercriteria
										  on mocentermonitoring.CriteriaID=mocentercriteria.id
										  left join mocentercriteriacategory
										  on mocentercriteria.CategoryId=mocentercriteriacategory.id
										  where mocentermonitoring.CMPlanid='".$MonitoringPlanID."'
										  and mocentermonitoring.Deleted=0
										  and mocentercriteria.Active=1
										  and mocentercriteria.Deleted=0
										  and mocentercriteriacategory.Active=1
										  and mocentercriteriacategory.Deleted=0
										   and mocentermonitoring.ClassWeightType IN('YN','P','EN')
										  and mocentercriteriacategory.id='".$CriteariaID."'
										  and mocentercriteria.id='".$ps->id."'";
								}
								 
										  
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalSubCriteariaMark"];
								if($ps->FullWeight != 0)
								{
									$ff = round((($Finaltot_Mark/$ps->FullWeight)*100),2);
									$ff = $ff.'%';
								}
								else{
									
									$ff = $Finaltot_Mark;
								}
								
								
				array_push($data_row, $MonitoringPlanDate);
				array_push($data_row, $ff);
               
				 }
                
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CenterSubCriteariaWiseMonitoringProgressReport-"'.$CriteariaNameEnglish.'"' .$tempStartDate .'-'. $tempEndDate);
		
}
	
	public function LoadViewCenterSubCriteariaWiseMonitoringProgressReport()
{
	 $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	//$CD_ID = Input::get('CD_ID');
	$CriteariaID = Input::get('CriteariaID');
	
	
	//$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	//$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	$CriteariaNameSinhala = MOCenterCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInSinhala');
	$CriteariaNameEnglish = MOCenterCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInEnglish');
	
    $Count = 0;
    $html='';
	
  $sql = "select monewcentermonitoringplan.*
  from monewcentermonitoringplan
 where monewcentermonitoringplan.Deleted=0
  and monewcentermonitoringplan.Visited=1
 and monewcentermonitoringplan.CenterID='".$CenterID."'
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'";
  $mainCount = DB::select(DB::raw($sql));
  $CountTH = count($mainCount);

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
					<input type="hidden" value="' . $CenterID . '" name="CenterID" id="CenterID"/>
					
					<input type="hidden" value="' . $CriteariaID . '" name="CriteariaID" id="CriteariaID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h4><center> Sub CriteariaWise Monitoring Progress Report<pre><h5>District-('.$DistrictNAme.') For  '.$CenterName.'<br/>Date Range:'.$tempStartDate.' to '.$tempEndDate.'</br>'.$CriteariaNameSinhala.'<br/>('.$CriteariaNameEnglish.')</h5></pre></center></h4>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
							<th align="center" class="center" >District</th>
							<th align="center" class="center" >Center</th>
							
							<th align="center" class="center" >Monitoring Criteria</th>
							<th align="center" class="center" >Monitoring Sub Criteria</th>
                           
							<th align="center" class="center" >Total Mark For Sub Critearia</th>';
							
							for($w=1;$w<=$CountTH;$w++)
							{
							$html.='<th align="center" class="center" >Date Planned</th>
							<th align="center" class="center" >Total Mark Achived</th>';
							}
                            
                            
              
              
                        $html.='</tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
  
$Critearia = MOCenterCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
$SubCritearia = MOCenterCriteria::where('CategoryId','=',$CriteariaID)->where('Active','=',1)->where('Deleted','=',0)->orderBy('Order')->get();
  
  
   /*  $sql="";

           //return $sql;
   $total_rec = DB::select(DB::raw($sql)); */

          

                foreach($SubCritearia as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td>'.$DistrictNAme.'</td>
							<td>'.$CenterName.'</td>
						
							<td>'.$CriteariaNameSinhala.'<br/>'.$CriteariaNameEnglish.'</td>
                            <td>'.$ps->CriteriaNameInSinhala.'<br/>'.$ps->CriteriaNameInEnglish.'</td>';
							if($ps->FullWeight != 0)
								{
									$html.='<td>'.$ps->FullWeight.'</td>';
								}
								else{
									$html.='<td>User Entered Values</td>';
								}
							
							foreach($mainCount as $m)
							{
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOCenterMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								if($ps->FullWeight != 0)
								{
									$sql1 = "select sum(mocentermonitoring.Mark) as TotalSubCriteariaMark
										  from mocentermonitoring
										  left join mocentercriteria
										  on mocentermonitoring.CriteriaID=mocentercriteria.id
										  left join mocentercriteriacategory
										  on mocentercriteria.CategoryId=mocentercriteriacategory.id
										  where mocentermonitoring.CMPlanid='".$MonitoringPlanID."'
										  and mocentermonitoring.Deleted=0
										  and mocentercriteria.Active=1
										  and mocentercriteria.Deleted=0
										  and mocentercriteriacategory.Active=1
										  and mocentercriteriacategory.Deleted=0
										   and mocentermonitoring.ClassWeightType IN('YN','P')
										  and mocentercriteriacategory.id='".$CriteariaID."'
										  and mocentercriteria.id='".$ps->id."'";
								}
								else{
									$sql1 = "select mocentermonitoring.Mark as TotalSubCriteariaMark
										  from mocentermonitoring
										  left join mocentercriteria
										  on mocentermonitoring.CriteriaID=mocentercriteria.id
										  left join mocentercriteriacategory
										  on mocentercriteria.CategoryId=mocentercriteriacategory.id
										  where mocentermonitoring.CMPlanid='".$MonitoringPlanID."'
										  and mocentermonitoring.Deleted=0
										  and mocentercriteria.Active=1
										  and mocentercriteria.Deleted=0
										  and mocentercriteriacategory.Active=1
										  and mocentercriteriacategory.Deleted=0
										   and mocentermonitoring.ClassWeightType IN('YN','P','EN')
										  and mocentercriteriacategory.id='".$CriteariaID."'
										  and mocentercriteria.id='".$ps->id."'";
								}
								 
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalSubCriteariaMark"];
								
								$html.='<td>'.$MonitoringPlanDate.'</td>
								<td>'.$Finaltot_Mark.'</td>';
								
								
							}
							
							
                            $html.='<tr>';
							
						
                           
                            
                }
				
				
            


   $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Table" => $html));
		
}
	
	public function ViewCenterSubCriteariaWiseMonitoringProgressReport()
{
	$method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewCenterSubCriteriaWiseProgressReport');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
	$view->Critearias = MOCenterCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
	
	
    
    if ($method == "GET") 
    {
        return $view;
    }
		
}
	
		public function DownloadLoadViewCenterCriteariaWiseMonitoringProgressReport()
	 {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

	$District = Input::get('District');
	$CenterID = Input::get('CenterID');
	//$CD_ID = Input::get('CD_ID');
	//$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	//$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	
    $Count = 0;
    $html='';
$tablePrintHeader0 = array('', 'Date Range', $tempStartDate,'-',$tempEndDate,'','','','','','','');
    $tablePrintHeader = array('#', 'District','Center','Critearia in English','Total Mark','Date Planned1','Mark Achived1%','Date Planned2','Mark Achived2%');
	

    $excel = new SimpleExcel('csv');
    $printablearray = array();
	array_push($printablearray, $tablePrintHeader0);
    array_push($printablearray, $tablePrintHeader);

         $i = 1;
  
$Critearia = MOCenterCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();

		   $sql = "select monewcentermonitoringplan.*
  from monewcentermonitoringplan
 where monewcentermonitoringplan.Deleted=0
  and monewcentermonitoringplan.Visited=1
 and monewcentermonitoringplan.CenterID='".$CenterID."'
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'";
		  $mainCount = DB::select(DB::raw($sql));
		  $CountTH = count($mainCount);


             foreach($Critearia as $ps) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $DistrictNAme);
                array_push($data_row, $CenterName);
			  
			    //$emp = '"'.$Data->Initials.'" . "'.$Data->Name.'" . "'.$Data->LastName.'"';
			    //$emp = $Data->Initials.$Data->Name.$Data->LastName;
			
                //array_push($data_row, $ps->TypeInSinhala);
				 array_push($data_row, $ps->TypeInEnglish);
				 if($ps->FullWeightFoTheSection == 0)
				 {
					 $FullWeightFoTheSection = 'User Entered Values';
				 } else
					 {
						 $FullWeightFoTheSection = $ps->FullWeightFoTheSection;
					 }
				array_push($data_row, $FullWeightFoTheSection);
				 foreach($mainCount as $m) {
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOCenterMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								$sql1 = "select sum(mocentermonitoring.Mark) as TotalCriteariaMark
										  from mocentermonitoring
										  left join mocentercriteria
										  on mocentermonitoring.CriteriaID=mocentercriteria.id
										  left join mocentercriteriacategory
										  on mocentercriteria.CategoryId=mocentercriteriacategory.id
										  where mocentermonitoring.CMPlanid='".$MonitoringPlanID."'
										  and mocentermonitoring.Deleted=0
										  and mocentercriteria.Active=1
										  and mocentercriteria.Deleted=0
										  and mocentercriteriacategory.Active=1
										  and mocentercriteriacategory.Deleted=0
										   and mocentermonitoring.ClassWeightType IN('YN','P')
										  and mocentercriteriacategory.id='".$ps->id."'";
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalCriteariaMark"];
								
								
								if($ps->FullWeightFoTheSection !=0)
							{
								$ff = round((($Finaltot_Mark/$ps->FullWeightFoTheSection)*100),2);
								$ff = $ff.'%';
							}
							else
							{
								$ff = 'User Entered Values';
							}
								
								
				array_push($data_row, $MonitoringPlanDate);
				array_push($data_row, $ff);
               
				 }
                
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CenterCriteariaWiseMonitoringProgressReport' .$tempStartDate . $tempEndDate);

  }
	
	public function LoadViewCenterCriteariaWiseMonitoringProgressReport()
	{
     $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	// $CD_ID = Input::get('CD_ID');
	// $CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	// $CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	
    $Count = 0;
    $html='';
	
  $sql = "select monewcentermonitoringplan.*
  from monewcentermonitoringplan
 where monewcentermonitoringplan.Deleted=0
  and monewcentermonitoringplan.Visited=1
 and monewcentermonitoringplan.CenterID='".$CenterID."'
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'";
  $mainCount = DB::select(DB::raw($sql));
  $CountTH = count($mainCount);

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
					<input type="hidden" value="' . $CenterID . '" name="CenterID" id="CenterID"/>
					
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center> Center CriteariaWise Monitoring Progress Report<pre><h5>District-('.$DistrictNAme.') For '.$CenterName.'<br/>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
							<th align="center" class="center" >District</th>
							<th align="center" class="center" >Center</th>
							
							<th align="center" class="center" >Monitoring Criteria</th>
                           
							<th align="center" class="center" >Total Mark</th>';
							
							for($w=1;$w<=$CountTH;$w++)
							{
							$html.='<th align="center" class="center" >Date Planned</th>
							<th align="center" class="center" >Total Mark Achived</th>';
							}
                            
                            
              
              
                        $html.='</tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
  
$Critearia = MOCenterCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
  
  
   /*  $sql="";

           //return $sql;
   $total_rec = DB::select(DB::raw($sql)); */

          

                foreach($Critearia as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td>'.$DistrictNAme.'</td>
							<td>'.$CenterName.'</td>
						
                            <td>'.$ps->TypeInSinhala.'<br/>'.$ps->TypeInEnglish.'</td>';
							if($ps->FullWeightFoTheSection !=0)
							{
								$html.='<td>'.$ps->FullWeightFoTheSection.'</td>';
							}
							else
							{
								$html.='<td>User Entered Values</td>';
							}
							
							foreach($mainCount as $m)
							{
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOCenterMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								$sql1 = "select sum(mocentermonitoring.Mark) as TotalCriteariaMark
										  from mocentermonitoring
										  left join mocentercriteria
										  on mocentermonitoring.CriteriaID=mocentercriteria.id
										  left join mocentercriteriacategory
										  on mocentercriteria.CategoryId=mocentercriteriacategory.id
										  where mocentermonitoring.CMPlanid='".$MonitoringPlanID."'
										  and mocentermonitoring.Deleted=0
										  and mocentercriteria.Active=1
										  and mocentercriteria.Deleted=0
										  and mocentercriteriacategory.Active=1
										  and mocentercriteriacategory.Deleted=0
										   and mocentermonitoring.ClassWeightType IN('YN','P')
										  and mocentercriteriacategory.id='".$ps->id."'";
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalCriteariaMark"];
								
								
								
								$html.='<td>'.$MonitoringPlanDate.'</td>';
								if($ps->FullWeightFoTheSection !=0)
							{
								$html.='<td>'.$Finaltot_Mark.'</td>';
							}
							else
							{
								$html.='<td>User Entered Values</td>';
							}
								
								
								
								
							}
							
							
                            $html.='<tr>';
							
						
                           
                            
                }
				
				
            


   $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Table" => $html));
  }
	
		 public function ViewCenterCriteariaWiseMonitoringProgressReport()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewCenterCriteriaWiseProgressReport');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
  }
	
	public function editCourseYearPlanDisNVTIDOTO() {
        switch (Request::getMethod()) {
            case 'GET':
			
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
                $view = View::make('TrainingPlanUpdate.EditCourseYearPlanByTO');
                $view->CourseListCode = Course::where('Deleted', '=', 0)
                ->orderBy('CourseListCode')
                ->get();
				$loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
				
            $CourseYearPlan1 = CourseYearPlan::find(Input::get('edit_id'));
         $temp_yr=$CourseYearPlan1->startDate;
		/*  if($OrgaType != 'HO')
				{
					$view->Instructors = MOInstructor::where('Deleted','=',0)->where('DistrictCode','=',$loggeduserDistrict)->orderBy('Name')->get();
				}
				else
				{ */
					$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
				/* } */
				$ppp = DB::select(DB::raw("select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
  from moinstructorcourse
  left join moinstructor
  on moinstructorcourse.InstructorID=moinstructor.id
  where moinstructorcourse.CourseYearPlanID='".Input::get('edit_id')."'
  and moinstructorcourse.Active='Yes'"));
             $view->AddedInstructors = $ppp;
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
           $view->OrgaType=$OrgaType;
            $view->date=trim($temp_yr);
			$view->CourseLevel=trim($CourseYearPlan1->CourseLevel);
			
			$NVQLevel =Course::where('CourseListCode','=',$CourseYearPlan1->CourseListCode)
							->where('Deleted', '!=', 1)
							->pluck('Nvq');
			$view->NVQ=trim($NVQLevel);
			
			

              $view->CourseYearPlan=$CourseYearPlan1;
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
              $organisation=Organisation::where('Deleted','=',0)->where('Active','=','Yes')->where('Type','!=','HO')->orderBy('OrgaName')->get();
              $view->organisation=$organisation;
                // $view->CourseYearPlan = CourseYearPlan::where("Deleted","=",0);
                return $view;
                break;
                case 'POST':
               // $validator = CourseYearPlan::validate(Input::all());
              
                    
                    $orgID = Input::get('edit_id');
                   /*  $instructorEPF = Input::get('InstructorList');
				    $instructorEPF2 = Input::get('InstructorList1');
					$instructorName1 = MOInstructor::where('EPFNo','=',$instructorEPF)->pluck('Name');
					$instructorName2 = MOInstructor::where('EPFNo','=',$instructorEPF2)->pluck('Name'); */
					
					//
					
				     $Packages = [];
                     $Packages = Input::get('NVQPackage');
                     $countP = count($Packages); 
				//
					
					
				   $UpCourseID = CourseYearPlan::where('id','=',Input::get('edit_id'))->pluck('CD_ID');
				   $CourseLevel = Course::where('CD_ID','=',$UpCourseID)->pluck('CourseLevel');
				   $updateArray = CourseYearPlan::where('id','=',Input::get('edit_id'))->update(array('NoOfTrainees' => Input::get('TCount'),'Dropout' => Input::get('DCount'),'StartedStatus' => Input::get('StartedStatus'),'ReasonForNotStarted' =>Input::get('ReasonForNotStarted'),
				   'OJTPlacedNVQLevel' => $CourseLevel,'TMEstimatedCost' => Input::get('TMEstimatedCost')));
                   $getMaxID = $orgID;
                   $update = MOInstructorCourse::where('CourseYearPlanID','=',$getMaxID)->update(array('Active' => 'No','Deleted' => '1'));
				   $UserOrgID = User::getSysUser()->organisationId; 
                   $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	               $LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
					for($i=0;$i<$countP;$i++)
					{
							$r = new MOInstructorCourse();
							$r->CourseYearPlanID = $getMaxID;
							$r->InstructorID = $Packages[$i];
							$r->Active = 'Yes';
							$r->User = User::getSysUser()->userID;
							$r->DistrictCode = $LoggedUserDis;
							$r->UserOrgaID = $UserOrgID;
							$r->save();

					}
					
					
					$view = View::make('TrainingPlanUpdate.ViewTrainingPlanUpdateByTO');
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

         /* if($CenterID == 'All')
		{
			$district = Input::get('District');
			$sql = "select courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus
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
					  and courseyearplan.batch='".$Batch."'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
					district.DistrictName,organisation.OrgaName,
					organisation.Type,
					courseyearplan.Year,
					courseyearplan.batch,
					coursedetails.CourseName,
					coursedetails.CourseListCode,
					coursedetails.CD_ID,
					coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					coursedetails.Duration,
					courseyearplan.medium AS Medium,
					courseyearplan.RealstartDate,
					courseyearplan.NoOfTrainees,
					courseyearplan.Dropout,
					courseyearplan.StartedStatus
					from courseyearplan
					left join organisation
					on courseyearplan.OrgId=organisation.id
					left join district
					on organisation.DistrictCode=district.DistrictCode
					left join coursedetails
					on courseyearplan.CD_ID=coursedetails.CD_ID
					where courseyearplan.Deleted=0
					and organisation.id='".$CenterID."'
					and courseyearplan.Year='".$Year."'
					and courseyearplan.batch='".$Batch."'
					order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					";
		} */
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.maxCapacity,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.RealEndDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.ReasonForNotStarted
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
					 group by courseyearplan.id 
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.maxCapacity,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.RealEndDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.ReasonForNotStarted
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
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.maxCapacity,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.RealEndDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.ReasonForNotStarted
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
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		
		 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');	
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
    return $view;               //return Redirect::to('ViewTrainingPlanUpdateDisNVTI?');
						//return Redirect::back();
                    
                
                break;
            default:
                break;
        }
    }

	
	public function ViewTrainingPlanUpdateDisNVTIDOTO()
	{
		$method = Request::getMethod();
    $view = View::make('TrainingPlanUpdate.ViewTrainingPlanUpdateByTO');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
	 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
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
		
		
		/* if($CenterID == 'All')
		{
			$district = Input::get('District');
			$sql = "select courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus
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
					  and courseyearplan.batch='".$Batch."'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		} */
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.maxCapacity,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.RealEndDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.ReasonForNotStarted
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
					  group by courseyearplan.id 
					order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.maxCapacity,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.RealEndDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.ReasonForNotStarted
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
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.maxCapacity,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.RealEndDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					
					  courseyearplan.ReasonForNotStarted
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
	
public function DownloadLoadViewSubCriteariaWiseMonitoringProgressReport()
{
	 $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

	$District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$CD_ID = Input::get('CD_ID');
	$CriteariaID = Input::get('CriteariaID');
	
	$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	$CriteariaNameSinhala = MOCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInSinhala');
	$CriteariaNameEnglish = MOCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInEnglish');
	
    $Count = 0;
    $html='';
$tablePrintHeader0 = array('', 'Date Range', $tempStartDate,'-',$tempEndDate,'','','','','','','','');
    $tablePrintHeader = array('#', 'District','Center','Course','CourseListCode','Critearia','Sub Critearia','Total Mark','Date Planned1','Mark Achived1%','Date Planned2','Mark Achived2%');
	

    $excel = new SimpleExcel('csv');
    $printablearray = array();
	array_push($printablearray, $tablePrintHeader0);
    array_push($printablearray, $tablePrintHeader);

         $i = 1;
  
$Critearia = MOCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
$SubCritearia = MOCriteria::where('CategoryId','=',$CriteariaID)->where('Active','=',1)->where('Deleted','=',0)->orderBy('Order')->get();

		  $sql = "select mocentremonitoringplan.*
		  from mocentremonitoringplan
		  left join courseyearplan
		  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
		  where mocentremonitoringplan.Deleted=0
		  and mocentremonitoringplan.Visited=1
		  and courseyearplan.OrgId='".$CenterID."'
		  and courseyearplan.CD_ID='".$CD_ID."'
		  and courseyearplan.Deleted=0
		  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
		  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'";
		  $mainCount = DB::select(DB::raw($sql));
		  $CountTH = count($mainCount);


             foreach($SubCritearia as $ps) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $DistrictNAme);
                array_push($data_row, $CenterName);
			    array_push($data_row, $CourseName);
			   
			    array_push($data_row, $CourseListCode);
                array_push($data_row, $CriteariaNameEnglish);
				 array_push($data_row, $ps->CriteriaNameInEnglish);
				array_push($data_row, $ps->FullWeight);
				 foreach($mainCount as $m) {
					 
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								
								 $sql1 = "select sum(momonitoring.Mark) as TotalSubCriteariaMark
										  from momonitoring
										  left join mocriteria
										  on momonitoring.CriteriaID=mocriteria.id
										  left join mocriteriacategory
										  on mocriteria.CategoryId=mocriteriacategory.id
										  where momonitoring.CMPlanid='".$MonitoringPlanID."'
										  and momonitoring.Deleted=0
										  and mocriteria.Active=1
										  and mocriteria.Deleted=0
										  and mocriteriacategory.Active=1
										  and mocriteriacategory.Deleted=0
										  and mocriteriacategory.id='".$CriteariaID."'
										  and mocriteria.id='".$ps->id."'";
										  
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalSubCriteariaMark"];
								$ff = round((($Finaltot_Mark/$ps->FullWeight)*100),2);
								$ff = $ff.'%';
								
				array_push($data_row, $MonitoringPlanDate);
				array_push($data_row, $ff);
               
				 }
                
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('SubCriteariaWiseMonitoringProgressReport-"'.$CriteariaNameEnglish.'"' .$tempStartDate .'-'. $tempEndDate);
		
}
	
public function LoadViewSubCriteariaWiseMonitoringProgressReport()
{
	 $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$CD_ID = Input::get('CD_ID');
	$CriteariaID = Input::get('CriteariaID');
	
	
	$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	$CriteariaNameSinhala = MOCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInSinhala');
	$CriteariaNameEnglish = MOCriteriaCategory::where('id','=',$CriteariaID)->pluck('TypeInEnglish');
	
    $Count = 0;
    $html='';
	
  $sql = "select mocentremonitoringplan.*
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Visited=1
  and courseyearplan.OrgId='".$CenterID."'
  and courseyearplan.CD_ID='".$CD_ID."'
  and courseyearplan.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'";
  $mainCount = DB::select(DB::raw($sql));
  $CountTH = count($mainCount);

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
					<input type="hidden" value="' . $CenterID . '" name="CenterID" id="CenterID"/>
					<input type="hidden" value="' . $CD_ID . '" name="CD_ID" id="CD_ID"/>
					<input type="hidden" value="' . $CriteariaID . '" name="CriteariaID" id="CriteariaID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h4><center> Sub CriteariaWise Monitoring Progress Report<pre><h5>District-('.$DistrictNAme.') For '.$CourseName.'('.$CourseListCode.') in '.$CenterName.'<br/>Date Range:'.$tempStartDate.' to '.$tempEndDate.'</br>'.$CriteariaNameSinhala.'<br/>('.$CriteariaNameEnglish.')</h5></pre></center></h4>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
							<th align="center" class="center" >District</th>
							<th align="center" class="center" >Center</th>
							<th align="center" class="center" >Course</th>
							<th align="center" class="center" >Monitoring Criteria</th>
							<th align="center" class="center" >Monitoring Sub Criteria</th>
                           
							<th align="center" class="center" >Total Mark For Sub Critearia</th>';
							
							for($w=1;$w<=$CountTH;$w++)
							{
							$html.='<th align="center" class="center" >Date Planned</th>
							<th align="center" class="center" >Total Mark Achived</th>';
							}
                            
                            
              
              
                        $html.='</tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
  
$Critearia = MOCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
$SubCritearia = MOCriteria::where('CategoryId','=',$CriteariaID)->where('Active','=',1)->where('Deleted','=',0)->orderBy('Order')->get();
  
  
   /*  $sql="";

           //return $sql;
   $total_rec = DB::select(DB::raw($sql)); */

          

                foreach($SubCritearia as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td>'.$DistrictNAme.'</td>
							<td>'.$CenterName.'</td>
							<td>'.$CourseName.'('.$CourseListCode.')</td>
							<td>'.$CriteariaNameSinhala.'<br/>'.$CriteariaNameEnglish.'</td>
                            <td>'.$ps->CriteriaNameInSinhala.'<br/>'.$ps->CriteriaNameInEnglish.'</td>
							<td>'.$ps->FullWeight.'</td>';
							foreach($mainCount as $m)
							{
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								 $sql1 = "select sum(momonitoring.Mark) as TotalSubCriteariaMark
										  from momonitoring
										  left join mocriteria
										  on momonitoring.CriteriaID=mocriteria.id
										  left join mocriteriacategory
										  on mocriteria.CategoryId=mocriteriacategory.id
										  where momonitoring.CMPlanid='".$MonitoringPlanID."'
										  and momonitoring.Deleted=0
										  and mocriteria.Active=1
										  and mocriteria.Deleted=0
										  and mocriteriacategory.Active=1
										  and mocriteriacategory.Deleted=0
										  and mocriteriacategory.id='".$CriteariaID."'
										  and mocriteria.id='".$ps->id."'";
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalSubCriteariaMark"];
								
								$html.='<td>'.$MonitoringPlanDate.'</td>
								<td>'.$Finaltot_Mark.'</td>';
								
								
							}
							
							
                            $html.='<tr>';
							
						
                           
                            
                }
				
				
            


   $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Table" => $html));
		
}
	
public function ViewSubCriteariaWiseMonitoringProgressReport()
{
	$method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewSubCriteariaProgressReport');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
	$view->Critearias = MOCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
	
	
    
    if ($method == "GET") 
    {
        return $view;
    }
		
}
	
public function CriteariaWiseFilterCourseYearPlans1()
  {
    $CenterID = Input::get('CenterID');
	
  $sql = DB::select(DB::raw("select DISTINCT coursedetails.CD_ID,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  courseyearplan.Year,
  courseyearplan.batch,
  courseyearplan.RealstartDate,
  coursedetails.Duration
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and courseyearplan.StartedStatus=1
  and courseyearplan.OrgId='".$CenterID."'
  group by coursedetails.CD_ID
  order by coursedetails.CourseName
"));
  return json_encode($sql);
  }
	
		public function CriteariaWiseloaddistrictcentersin()
	{
		
		$dis = Input::get('District');
		
      /*$Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$dis)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();*/
	  if($dis == 'All')
	  {
		  $sql = DB::select(DB::raw("select * 
			 from organisation
             where organisation.Deleted=0
             and organisation.Active='Yes'
             and organisation.Type NOT IN('HO','DO','PO')
             order by organisation.OrgaName"));
	  }
	  else{
		  $sql = DB::select(DB::raw("select * 
			 from organisation
             where organisation.Deleted=0
             and organisation.Active='Yes'
             and organisation.DistrictCode='".$dis."'
			 and organisation.Type NOT IN('HO','DO','PO')
             order by organisation.OrgaName"));
	  }
	  
	  
	  return json_encode($sql);
	}
	
		public function DownloadLoadViewCriteariaWiseMonitoringProgressReport()
	 {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

	$District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$CD_ID = Input::get('CD_ID');
	$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	
    $Count = 0;
    $html='';
$tablePrintHeader0 = array('', 'Date Range', $tempStartDate,'-',$tempEndDate,'','','','','','','');
    $tablePrintHeader = array('#', 'District','Center','Course','CourseListCode','Critearia in English','Total Mark','Date Planned1','Mark Achived1%','Date Planned2','Mark Achived2%');
	

    $excel = new SimpleExcel('csv');
    $printablearray = array();
	array_push($printablearray, $tablePrintHeader0);
    array_push($printablearray, $tablePrintHeader);

         $i = 1;
  
$Critearia = MOCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();

		  $sql = "select mocentremonitoringplan.*
		  from mocentremonitoringplan
		  left join courseyearplan
		  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
		  where mocentremonitoringplan.Deleted=0
		  and mocentremonitoringplan.Visited=1
		  and courseyearplan.OrgId='".$CenterID."'
		  and courseyearplan.CD_ID='".$CD_ID."'
		  and courseyearplan.Deleted=0
		  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
		  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
		  order by DatePlanned";
		  $mainCount = DB::select(DB::raw($sql));
		  $CountTH = count($mainCount);


             foreach($Critearia as $ps) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $DistrictNAme);
                array_push($data_row, $CenterName);
			    array_push($data_row, $CourseName);
			    //$emp = '"'.$Data->Initials.'" . "'.$Data->Name.'" . "'.$Data->LastName.'"';
			    //$emp = $Data->Initials.$Data->Name.$Data->LastName;
			    array_push($data_row, $CourseListCode);
                //array_push($data_row, $ps->TypeInSinhala);
				 array_push($data_row, $ps->TypeInEnglish);
				array_push($data_row, $ps->FullWeightFoTheSection);
				 foreach($mainCount as $m) {
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								$sql1 = "select sum(momonitoring.Mark) as TotalCriteariaMark
										  from momonitoring
										  left join mocriteria
										  on momonitoring.CriteriaID=mocriteria.id
										  left join mocriteriacategory
										  on mocriteria.CategoryId=mocriteriacategory.id
										  where momonitoring.CMPlanid='".$MonitoringPlanID."'
										  and momonitoring.Deleted=0
										  and mocriteria.Active=1
										  and mocriteria.Deleted=0
										  and mocriteriacategory.Active=1
										  and mocriteriacategory.Deleted=0
										  and mocriteriacategory.id='".$ps->id."'";
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalCriteariaMark"];
								$ff = round((($Finaltot_Mark/$ps->FullWeightFoTheSection)*100),2);
								$ff = $ff.'%';
								
				array_push($data_row, $MonitoringPlanDate);
				array_push($data_row, $ff);
               
				 }
                
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CriteariaWiseMonitoringProgressReport' .$tempStartDate . $tempEndDate);

  }
	public function LoadViewCriteariaWiseMonitoringProgressReport()
	{
     $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$CD_ID = Input::get('CD_ID');
	$CourseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$CenterName = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
	$CourseListCode =  Course::where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
	$Discode = Organisation::where('id','=',$CenterID)->pluck('DistrictCode');
	$DistrictNAme = District::where('DistrictCode','=',$Discode)->pluck('DistrictName');
	
    $Count = 0;
    $html='';
	
  $sql = "select mocentremonitoringplan.*
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Visited=1
  and courseyearplan.OrgId='".$CenterID."'
  and courseyearplan.CD_ID='".$CD_ID."'
  and courseyearplan.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  order by DatePlanned";
  $mainCount = DB::select(DB::raw($sql));
  $CountTH = count($mainCount);

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
					<input type="hidden" value="' . $CenterID . '" name="CenterID" id="CenterID"/>
					<input type="hidden" value="' . $CD_ID . '" name="CD_ID" id="CD_ID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center> CriteariaWise Monitoring Progress Report<pre><h5>District-('.$DistrictNAme.') For '.$CourseName.'('.$CourseListCode.') in '.$CenterName.'<br/>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
							<th align="center" class="center" >District</th>
							<th align="center" class="center" >Center</th>
							<th align="center" class="center" >Course</th>
							<th align="center" class="center" >Monitoring Criteria</th>
                           
							<th align="center" class="center" >Total Mark</th>';
							
							for($w=1;$w<=$CountTH;$w++)
							{
							$html.='<th align="center" class="center" >Date Planned</th>
							<th align="center" class="center" >Total Mark Achived</th>';
							}
                            
                            
              
              
                        $html.='</tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
  
$Critearia = MOCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
  
  
   /*  $sql="";

           //return $sql;
   $total_rec = DB::select(DB::raw($sql)); */

          

                foreach($Critearia as $ps) {
					
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td>'.$DistrictNAme.'</td>
							<td>'.$CenterName.'</td>
							<td>'.$CourseName.'('.$CourseListCode.')</td>
                            <td>'.$ps->TypeInSinhala.'<br/>'.$ps->TypeInEnglish.'</td>
							<td>'.$ps->FullWeightFoTheSection.'</td>';
							foreach($mainCount as $m)
							{
								$MonitoringPlanID = $m->id;
								$MonitoringPlanDate = $m->DatePlanned;
								$ActualMonitoringDate = MOMonitoringResult::where('CMPlanID','=',$MonitoringPlanID)->where('Deleted','=',0)->pluck('MonitoringDate');
								$sql1 = "select sum(momonitoring.Mark) as TotalCriteariaMark
										  from momonitoring
										  left join mocriteria
										  on momonitoring.CriteriaID=mocriteria.id
										  left join mocriteriacategory
										  on mocriteria.CategoryId=mocriteriacategory.id
										  where momonitoring.CMPlanid='".$MonitoringPlanID."'
										  and momonitoring.Deleted=0
										  and mocriteria.Active=1
										  and mocriteria.Deleted=0
										  and mocriteriacategory.Active=1
										  and mocriteriacategory.Deleted=0
										  and mocriteriacategory.id='".$ps->id."'";
								$tot_Mark = DB::select(DB::raw($sql1));
								$tot_Mark1 =  json_decode(json_encode((array)$tot_Mark),true);
								$Finaltot_Mark = $tot_Mark1[0]["TotalCriteariaMark"];
								
								$html.='<td>'.$MonitoringPlanDate.'</td>
								<td>'.$Finaltot_Mark.'</td>';
								
								
							}
							
							
                            $html.='<tr>';
							
						
                           
                            
                }
				
				
            


   $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Table" => $html));
  }
	
   public function ViewCriteariaWiseMonitoringProgressReport()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewCriteariaWiseProgressReport');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
  }
	
	public function PrintExcelTrainingPlanReportByTestingEva1()
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
					  district.DistrictName,
					  organisation.OrgaName,
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
					  courseyearplan.NoOfTrainees,
					  courseyearplan.Dropout,
                      courseyearplan.StartedStatus,
					  courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					  courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
					  district.DistrictName,
					  organisation.OrgaName,
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment

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
					  courseyearplan.NoOfTrainees,
					  courseyearplan.Dropout,
                      courseyearplan.StartedStatus,
					  courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					  courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
						courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
     $headerArray = array('No','District', 'Centre', 'Year', 'Batch',
	 'CourseName','Duration','Enrollment Capacity',
	 'CourseType', 'NVQ/NON-NVQ','NVQLevel','Accredation Y/N',
	 'NoOfTraineesRegistered','NoOfTraineesDropout','NoOfRepeaters','AssessorNominatedDate',
	 'EligibilityTestDate',
	 'NoofTraineesForEligibilityTest','Final Assesment Held','FinalAssessmentDate'
	 ,'NoofTraineesFinalAssessed(Original)','NoofTraineesFinalAssessed(R1)','NoofTraineesFinalAssessed(R2)','DocumentSendingDatetoHO','ResultCheckedDate','Assessor Renominated','AssessorName1','AssessorName2'
	 ,'NoofTraineesNotCompetent(Original)','NoofTraineesNotCompetent(R1)','NoofTraineesNotCompetent(R2)'
	 ,'NoofTraineesCompetent(NVQ)(Original)','NoofTraineesCompetent(NVQ)(R1)','NoofTraineesCompetent(NVQ)(R2)','1st Repeat With Batch','2nd Repeat With Batch',
	 'UnitOnly','NVQ L1','NVQ L2','NVQ L3','NVQ L4','NVQ L5','ROA',
	 'UnitOnly (HeadCount)','NVQ L1 (HeadCount)','NVQ L2 (HeadCount)','NVQ L3 (HeadCount)','NVQ L4 (HeadCount)','NVQ L5 (HeadCount)','ROA (HeadCount)',
	 'DocumentSendingdatetoTVEC','DateofPrepairingROACertificate','CertificateRecievingDateFromTVEC','CertificateIssuingDateToDistrict','EnglishTradeCoursesReceivingDate to HO','CBTResultReceivingDate to HO','Comments');
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
			  $fdates='';
			   $Andates = '';
			   $dsdateHO = '';
			   $rescheckdate='';
			   $dsenddatetoTVEC = '';
			   $dateprepareROA = '';
			   $certifiresdatesfromTVEC='';
			   $certifiissudatedistrict='';
			   $Englishtradecourseres='';
			   $CBTResdate='';

foreach($Packages as $p)
				{
					$pack= $pack.$p->packagecode.$com;
				}		

  foreach($monitoringDate as $m)
				{
					$exp=$exp.$m->DatePlanned.$com;
					$emp=$emp.$m->Initials.$dod.$m->LastName.$a.$m->Approved.$a.$m->Visited.$com;
					
					
				}	
				
$getAccredit = AccreditationDetails::getAccreditation($aa->OrgId,$aa->CD_ID);
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
							}
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
						  $GetDocumentsendingDatestoTVEC = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						   foreach($GetDocumentsendingDatestoTVEC as $f)
						  {
						     $dsenddatetoTVEC.=$f->DocumentSendingDateToTVEC.$com;
						  }
						  $GetDatePrepareROA = ExamDatePrepareROACertificate::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetDatePrepareROA as $f)
						  {
						     $dateprepareROA.=$f->DatePrepareROAcertificate.$com;
						  }
						  $GetDateRecievingCertifiFromTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetDateRecievingCertifiFromTVEC as $f)
						  {
						     $certifiresdatesfromTVEC.=$f->CertificateRecievingDateFromTVEC.$com;
						  }
						  $GetExamCertificateIssuingDateToDistrict = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCertificateIssuingDateToDistrict as $f)
						  {
						     $certifiissudatedistrict.=$f->CertificateissuingDateToDistrict.$com;
						  }
						  $GetExamEnglishTradeCourseRecievingDateHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetExamEnglishTradeCourseRecievingDateHO as $f)
						  {
						     $Englishtradecourseres.=$f->EnglishTradeCourseResDate.$com;
						  }
						  $GetExamCBTResultRecievingDateToHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCBTResultRecievingDateToHO as $f)
						  {
						     $CBTResdate.=$f->CBTResultsRecievingDate.$com;
						  }						  
						  
						if($aa->RepeatBatch1YearPlanID != 0 || $aa->RepeatBatch1YearPlanID!= '')  
						  {
									$CoureyearplanR1 = CourseYearPlan::where('id','=',$aa->RepeatBatch1YearPlanID)->first();
									if(count($CoureyearplanR1) !=0)
									{
										
									
									$R1OrgaName = Organisation::where('id','=',$CoureyearplanR1->OrgId)->pluck('OrgaName');
									$R1CourseName = Course::where('CD_ID','=',$CoureyearplanR1->CD_ID)->pluck('CourseName');
									$repone = $R1OrgaName.'-'.$R1CourseName.' '.$CoureyearplanR1->Year.' Batch '.$CoureyearplanR1->batch;
									}
									else
									{
										$CoureyearplanR1 ="";
										$R1OrgaName ="";
										$R1CourseName =""; 
										$repone = "";
									}
						  }
						  else
						  {
							            $CoureyearplanR1 ="";
										$R1OrgaName ="";
										$R1CourseName ="";
										$repone = "";
						  }	
						if($aa->RepeatBatch2YearPlanID != 0 || $aa->RepeatBatch2YearPlanID!= '')
						{
							$CoureyearplanR2 = CourseYearPlan::where('id','=',$aa->RepeatBatch2YearPlanID)->first();
							if(count($CoureyearplanR2) !=0)
							{
							
							$R2OrgaName = Organisation::where('id','=',$CoureyearplanR2->OrgId)->pluck('OrgaName');
							$R2CourseName = Course::where('CD_ID','=',$CoureyearplanR2->CD_ID)->pluck('CourseName');
							$reptwo = $R2OrgaName.'-'.$R2CourseName.' '.$CoureyearplanR2->Year.' Batch '.$CoureyearplanR2->batch;
							}
							else
							{
								$CoureyearplanR2 ="";
								$R2OrgaName ="";
								$R2CourseName ="";
								$reptwo ="";
							}
						}	
						else
						{
							    $CoureyearplanR2 ="";
								$R2OrgaName ="";
								$R2CourseName ="";
								$reptwo ="";
						}						  
      array_push($printablearray, array($i,$aa->DistrictName, 
	  $aa->OrgaName, $aa->Year,$aa->batch,$aa->CourseName,$aa->Duration,$aa->maxCapacity,
	  $aa->CourseType,$aa->Nvq,$aa->CourseLevel,
	  $acctedit,
	  $aa->NoOfTrainees,
	  $aa->Dropout,
	  $aa->NoOfRepeaters,
	  $Andates,$aa->PreAssessmentDate,$aa->NoOfTraineesPreAssessed,$aa->FinalExamHeld,$fdates,
	  $aa->NoOfTraineesFinalAssessed,$aa->NoOfTraineesFinalAssessedR1,$aa->NoOfTraineesFinalAssessedR2,
	  $dsdateHO,$rescheckdate,
	   $aa->AssessorReNominated,
	  $aa->Assessor1,
	  $aa->Assessor2,$aa->NoOfTraineesNotCompetent,$aa->NoOfTraineesNotCompetentR1,$aa->NoOfTraineesNotCompetentR2,
	  $aa->NoOfTraineesCompetentNVQ,$aa->NoOfTraineesCompetentNVQR1,$aa->NoOfTraineesCompetentNVQR2,$repone,$reptwo,
	  $aa->UnitOnly+$aa->UnitOnlyII+$aa->UnitOnlyIII+$aa->UnitOnlyIV+$aa->UnitOnlyV+$aa->UnitOnlyVI,
	  $aa->L1+$aa->L1II+$aa->L1IV+$aa->L1V+$aa->L1V+$aa->L1VI,
	  $aa->L2+$aa->L2II+$aa->L2III+$aa->L2IV+$aa->L2V+$aa->L2VI,
	  $aa->L3+$aa->L3II+$aa->L3III+$aa->L3IV+$aa->L3V+$aa->L3VI,
	  $aa->L4+$aa->L4II+$aa->L4III+$aa->L4IV+$aa->L4V+$aa->L4VI,
	  $aa->L5+$aa->L5II+$aa->L5III+$aa->L5IV+$aa->L5V+$aa->L5VI,
	  $aa->ROA+$aa->ROAII+$aa->ROAIII+$aa->ROAIV+$aa->ROAV+$aa->ROAVI,
	  
	  $aa->UnitOnlyH+$aa->UnitOnlyHII+$aa->UnitOnlyHIII+$aa->UnitOnlyHIV+$aa->UnitOnlyHV+$aa->UnitOnlyHVI,
	  $aa->L1H+$aa->L1HII+$aa->L1HIII+$aa->L1HIV+$aa->L1HV+$aa->L1HVI,
	  $aa->L2H+$aa->L2HII+$aa->L2HIII+$aa->L2HIV+$aa->L2HV+$aa->L2HVI,
	  $aa->L3H+$aa->L3HII+$aa->L3HIII+$aa->L3HIV+$aa->L3HV+$aa->L3HVI,
	  $aa->L4H+$aa->L4HII+$aa->L4HIII+$aa->L4HIV+$aa->L4HV+$aa->L4HVI,
	  $aa->L5H+$aa->L5HII+$aa->L5HIII+$aa->L5HIV+$aa->L5HV+$aa->L5HVI,
	  $aa->ROAH+$aa->ROAHII+$aa->ROAHIII+$aa->ROAHIV+$aa->ROAHV+$aa->ROAHVI,
	  $dsenddatetoTVEC,$dateprepareROA,$certifiresdatesfromTVEC,$certifiissudatedistrict,$Englishtradecourseres,$CBTResdate,$aa->Comment));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('ExamDetails-"'.(Date("Y-m-d")).'"');
		
	}
	
	public function PrintPDFTrainingPlanReportByTestingEva1()
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		}
		 
			
	$trplans = DB::select(DB::raw($sql));
		
		$i = 1;
   $html ='<html><head><center><b><h3>Exam Details For - '.$Year.'( Batch-'.$Batch.') Full Time NVQ Courses</h3></b></center></head><body>
   <font size="5px" face="Times New Roman" ><table style = "font-size:18px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">District</th>
<th align="center">Centre</th>
<th align="center">Year</th>
<th align="center">Batch</th>
<th align="center">Course</th>

<th align="center">Duration</th>
<th align="center">CourseType</th>
<th align="center">NVQ/NON-NVQ</th>
<th align="center">NVQ Level</th>
<th align="center">Accredation Y/N</th>
<th align="center">No of Trainees Registered</td>
<th align="center">No of Trainees Dropout</td>
<th align="center">No of Repeaters</td>
<th align="center">Assessor Nominated Date</th>
<th align="center">Eligibility Test Date</th>
<th align="center">No of Trainees For Eligibility Test</th>
<th align="center">Final Assessment Held</th>
<th align="center">Final Assessment Date</th>
<th align="center">No of Trainees Final Assessed(Original)</th>
<th align="center">No of Trainees Final Assessed(R1)</th>
<th align="center">No of Trainees Final Assessed(R2)</th>
<th align="center">Document Sending Date to HO</th>
<th align="center">Result Checked Date</th>
<th align="center">Assessor Renominated</th>
<th align="center">Assessor Name 1</th>
<th align="center">Assessor Name 2</th>
<th align="center">No of Trainees Not Competent(Original)</th>
<th align="center">No of Trainees Not Competent(R1)</th>
<th align="center">No of Trainees Not Competent(R2)</th>
<th align="center">No of Trainees Competent (NVQ)(Original)</th>
<th align="center">No of Trainees Competent (NVQ)(R1)</th>
<th align="center">No of Trainees Competent (NVQ)(R2)</th>
<th align="center">1st Repeat Batch</th>
<th align="center">2nd Repeat Batch</th>
<th align="center">Unit Only</th>
<th align="center">NVQ L1</th>
<th align="center">NVQ L2</th>
<th align="center">NVQ L3</th>
<th align="center">NVQ L4</th>
<th align="center">NVQ L5</th>
<th align="center">ROA</th>
<th align="center">Unit Only (Head Count)</th>
<th align="center">NVQ L1 (Head Count)</th>
<th align="center">NVQ L2 (Head Count)</th>
<th align="center">NVQ L3 (Head Count)</th>
<th align="center">NVQ L4 (Head Count)</th>
<th align="center">NVQ L5 (Head Count)</th>
<th align="center">ROA (Head Count)</th>
<th align="center">Document Sending date to TVEC</th>
<th align="center">Date of Prepairing ROA Certificate</th>
<th align="center">Certificate Recieving Date From TVEC</th>
<th align="center">Certificate Issuing Date To District</th>
<th align="center">English Trade Courses Receiving Date to HO</th>
<th align="center">CBT Result Receiving Date to HO</th>
</thead><tbody>';

foreach ($trplans as $aa ) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->DistrictName.'</td>
          <td>'.$aa->OrgaName.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->batch.'</td>
          <td>'.$aa->CourseName.'</td>
         
		   <td>'.$aa->Duration.'</td>
          <td>'.$aa->CourseType.'</td>
		  <td>'.$aa->Nvq.'</td>
		  <td>'.$aa->CourseLevel.'</td>';
		$endDate = MOCenterMonitoringPlan::getEndDate($aa->RealstartDate,$aa->Duration);
		$Packages = MOCenterMonitoringPlan::getPackages($aa->CD_ID);
		$monitoringDate = MOCenterMonitoringPlan::getMonitoringDates($aa->id);
			$getAccredit = AccreditationDetails::getAccreditation($aa->OrgId,$aa->CD_ID);
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
							}   
			  
				   
				  
				   
				  $html.='<td>'. $acctedit.'</td>
				  <td>'.$aa->NoOfTrainees.'</td>
				  <td>'.$aa->Dropout.'</td>
				  <td>'.$aa->NoOfRepeaters.'</td><td>';
				  $GetAssessorNominatedDates = ExamAssesorMoninatedDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
					 foreach($GetAssessorNominatedDates as $f)
						  {
						     $html.='<span>'.$f->AssessorNominatedDate.'</br></span>';
						  }
				  
					    $html.='</td>
						  <td>'.$aa->PreAssessmentDate.'</td>
						  <td>'.$aa->NoOfTraineesPreAssessed.'</td>
						  <td>'.$aa->FinalExamHeld.'</td><td>';
						  
						  $GetFinalAssDates = ExamFinalAssessmentDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						  foreach($GetFinalAssDates as $f)
						  {
						     $html.='<span>'.$f->FinalAssessmentDate.'</br></span>';
						  }
						  $html.='</td><td>'.$aa->NoOfTraineesFinalAssessed.'</td>
						  <td>'.$aa->NoOfTraineesFinalAssessedR1.'</td>
						  <td>'.$aa->NoOfTraineesFinalAssessedR2.'</td><td>';
						  
						   $GetDocumentsendingDatestoHO = ExamDocumentSendingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetDocumentsendingDatestoHO as $f)
						  {
						     $html.='<span>'.$f->DocumentSendingDateToHO.'</br></span>';
						  }
						   $html.='</td><td>';
						  
						 $GetResultCheckedDates = ExamResultCheckedDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						    foreach($GetResultCheckedDates as $f)
						  {
						     $html.='<span>'.$f->ResultCheckedDate.'</br></span>';
						  }
						  $html.='</td><td>'.$aa->AssessorReNominated.'</td>
						  <td>'.$aa->Assessor1.'</td>
						  <td>'.$aa->Assessor2.'</td>
						  <td>'.$aa->NoOfTraineesNotCompetent.'</td>
						  <td>'.$aa->NoOfTraineesNotCompetentR1.'</td>
						  <td>'.$aa->NoOfTraineesNotCompetentR2.'</td>
						  <td>'.$aa->NoOfTraineesCompetentNVQ.'</td>
						  <td>'.$aa->NoOfTraineesCompetentNVQR1.'</td>
						  <td>'.$aa->NoOfTraineesCompetentNVQR2.'</td>';
							if($aa->RepeatBatch1YearPlanID != 0 || $aa->RepeatBatch1YearPlanID!= '')  
						  {
									$CoureyearplanR1 = CourseYearPlan::where('id','=',$aa->RepeatBatch1YearPlanID)->first();
									if(count($CoureyearplanR1) !=0)
									{
										
									
									$R1OrgaName = Organisation::where('id','=',$CoureyearplanR1->OrgId)->pluck('OrgaName');
									$R1CourseName = Course::where('CD_ID','=',$CoureyearplanR1->CD_ID)->pluck('CourseName');
									$repone = $R1OrgaName.'-'.$R1CourseName.' '.$CoureyearplanR1->Year.' Batch '.$CoureyearplanR1->batch;
									}
									else
									{
										$CoureyearplanR1 ="";
										$R1OrgaName ="";
										$R1CourseName =""; 
										$repone = "";
									}
						  }
						  else
						  {
							            $CoureyearplanR1 ="";
										$R1OrgaName ="";
										$R1CourseName ="";
										$repone = "";
						  }	
						if($aa->RepeatBatch2YearPlanID != 0 || $aa->RepeatBatch2YearPlanID!= '')
						{
							$CoureyearplanR2 = CourseYearPlan::where('id','=',$aa->RepeatBatch2YearPlanID)->first();
							if(count($CoureyearplanR2) !=0)
							{
							
							$R2OrgaName = Organisation::where('id','=',$CoureyearplanR2->OrgId)->pluck('OrgaName');
							$R2CourseName = Course::where('CD_ID','=',$CoureyearplanR2->CD_ID)->pluck('CourseName');
							$reptwo = $R2OrgaName.'-'.$R2CourseName.' '.$CoureyearplanR2->Year.' Batch '.$CoureyearplanR2->batch;
							}
							else
							{
								$CoureyearplanR2 ="";
								$R2OrgaName ="";
								$R2CourseName ="";
								$reptwo ="";
							}
						}	
						else
						{
							    $CoureyearplanR2 ="";
								$R2OrgaName ="";
								$R2CourseName ="";
								$reptwo ="";
						}			 
							 
						   $html.='<td>'.$repone.'</td><td>'.$reptwo.'</td>';
						   $UnitOnlysum = $aa->UnitOnly+$aa->UnitOnlyII+$aa->UnitOnlyIII+$aa->UnitOnlyIV+$aa->UnitOnlyV+$aa->UnitOnlyVI;
						   $L1sum = $aa->L1+$aa->L1II+$aa->L1IV+$aa->L1V+$aa->L1V+$aa->L1VI;
						   $L2sum = $aa->L2+$aa->L2II+$aa->L2III+$aa->L2IV+$aa->L2V+$aa->L2VI;
						   $L3sum = $aa->L3+$aa->L3II+$aa->L3III+$aa->L3IV+$aa->L3V+$aa->L3VI;
						   $L4sum = $aa->L4+$aa->L4II+$aa->L4III+$aa->L4IV+$aa->L4V+$aa->L4VI;
						   $L5sum = $aa->L5+$aa->L5II+$aa->L5III+$aa->L5IV+$aa->L5V+$aa->L5VI;
						   $ROAsum = $aa->ROA+$aa->ROAII+$aa->ROAIII+$aa->ROAIV+$aa->ROAV+$aa->ROAVI;
						   
						   $html.='<td>'.$UnitOnlysum.'</td>
						   <td>'.$L1sum.'</td>
						   <td>'.$L2sum.'</td>
						   <td>'.$L3sum.'</td>
						   <td>'.$L4sum.'</td>
						   <td>'.$L5sum.'</td>
						   <td>'.$ROAsum.'</td>';
						   
						   $UnitOnlyHsum = $aa->UnitOnlyH+$aa->UnitOnlyHII+$aa->UnitOnlyHIII+$aa->UnitOnlyHIV+$aa->UnitOnlyHV+$aa->UnitOnlyHVI;
						   $L1Hsum = $aa->L1H+$aa->L1HII+$aa->L1HIII+$aa->L1HIV+$aa->L1HV+$aa->L1HVI;
						   $L2Hsum = $aa->L2H+$aa->L2HII+$aa->L2HIII+$aa->L2HIV+$aa->L2HV+$aa->L2HVI;
						   $L3Hsum = $aa->L3H+$aa->L3HII+$aa->L3HIII+$aa->L3HIV+$aa->L3HV+$aa->L3HVI;
						   $L4Hsum = $aa->L4H+$aa->L4HII+$aa->L4HIII+$aa->L4HIV+$aa->L4HV+$aa->L4HVI;
						   $L5Hsum = $aa->L5H+$aa->L5HII+$aa->L5HIII+$aa->L5HIV+$aa->L5HV+$aa->L5HVI;
						   $ROAHsum = $aa->ROAH+$aa->ROAHII+$aa->ROAHIII+$aa->ROAHIV+$aa->ROAHV+$aa->ROAHVI;
						   
						   
						 $html.='<td>'.$UnitOnlyHsum.'</td>
						   <td>'.$L1Hsum.'</td>
						   <td>'.$L2Hsum.'</td>
						   <td>'.$L3Hsum.'</td>
						   <td>'.$L4Hsum.'</td>
						   <td>'.$L5Hsum.'</td>
						   <td>'.$ROAHsum.'</td><td>';
						   
						   $GetDocumentsendingDatestoTVEC = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						   foreach($GetDocumentsendingDatestoTVEC as $f)
						  {
						     $html.='<span>'.$f->DocumentSendingDateToTVEC.'</br></span>';
						  }
						 $html.='</td><td>';
						  $GetDatePrepareROA = ExamDatePrepareROACertificate::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetDatePrepareROA as $f)
						  {
						     $html.='<span>'.$f->DatePrepareROAcertificate.'</br></span>';
						  }
						 $html.='</td><td>';
						 $GetDateRecievingCertifiFromTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetDateRecievingCertifiFromTVEC as $f)
						  {
						     $html.='<span>'.$f->CertificateRecievingDateFromTVEC.'</br></span>';
						  }
						 $html.='</td><td>';
						   $GetExamCertificateIssuingDateToDistrict = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCertificateIssuingDateToDistrict as $f)
						  {
						     $html.='<span>'.$f->CertificateissuingDateToDistrict.'</br></span>';
						  }
						 $html.='</td> <td>';
						  $GetExamEnglishTradeCourseRecievingDateHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetExamEnglishTradeCourseRecievingDateHO as $f)
						  {
						     $html.='<span>'.$f->EnglishTradeCourseResDate.'</br></span>';
						  }
						$html.='</td> <td>';
							$GetExamCBTResultRecievingDateToHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCBTResultRecievingDateToHO as $f)
						  {
						     $html.='<span>'.$f->CBTResultsRecievingDate.'</br></span>';
						  }
						$html.='</td></tr>';
          
  }

  $html.='</tbody></table></font></body></html>';
   return $html;

	}
	
	public function PrintExcelTrainingPlanReportByTestingEva()
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
					  district.DistrictName,
					  organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
					  district.DistrictName,
					  organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
     $headerArray = array('No','District', 'Centre', 'Year', 'Batch','CourseName','CourseListCode','CourseType', 'NVQ/NON-NVQ','NVQLevel', 
	 'Duration','Medium','StartDate','EndDate','PackagesIncluded','Instructors','NoofTraineesRegistered','NoofTraineesDropout','NoofRepeaters','NoofOJTPlaced','NoofOJTCompleted',
	 'NoofJOBPlaced',
	 'CourseStartedStatus',
	 'Accredation Y/N','AccredationRecommendedDate','AccredationDate','Accredation Valid Date','AssessorNominatedDate',
	 'EligibilityTestDate',
	 'NoofTraineesForEligibilityTest','Final Assessment Held',
	 'FinalAssessmentDate',
	 'NoofTraineesFinalAssessed',
	 'DocumentSendingDatetoHO',
	 'ResultCheckedDate',
	 'AssessorRenominated',
	 'AssessorName1',
	 'AssessorName2',
	 'NoofTraineesNotCompetent','NoofTraineesCompetent(NVQ)','UnitOnly','NVQ L1','NVQ L2','NVQ L3','NVQ L4','NVQ L5','ROA',
	 'UnitOnly (HeadCount)','NVQ L1 (HeadCount)','NVQ L2 (HeadCount)','NVQ L3 (HeadCount)','NVQ L4 (HeadCount)','NVQ L5 (HeadCount)','ROA (HeadCount)',
	 'DocumentSendingdatetoTVEC','DateofPrepairingROACertificate','CertificateRecievingDateFromTVEC','CertificateIssuingDateToDistrict',
	 'EnglishTradeCoursesReceivingDate to HO','CBTResultReceivingDate to HO','Comment');
    array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

        $endDate = MOCenterMonitoringPlan::getEndDate($aa->RealstartDate,$aa->Duration);
			   $Packages = MOCenterMonitoringPlan::getPackages($aa->CD_ID);
			   $monitoringDate = MOCenterMonitoringPlan::getMonitoringDates($aa->id);    
			   $ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$aa->id."'
						  and moinstructorcourse.Active='Yes'";
                          $Ins=DB::select(DB::raw($ppp));
			   $pack = '';
			   $com = ',';
			   $exp = '';
			   $emp = '';
			   $a = '/';
			   $dod = '.';
			   $fdates='';
			   $Andates = '';
			   $dsdateHO = '';
			   $rescheckdate='';
			   $dsenddatetoTVEC = '';
			   $dateprepareROA = '';
			   $certifiresdatesfromTVEC='';
			   $certifiissudatedistrict='';
			   $Englishtradecourseres='';
			   $CBTResdate='';
			    $fbr = '(';
			   $bbr = ')';
			   $instructors = '';
			   
			   foreach($Ins as $m)
				{
					
					$instructors=$instructors.$m->Name.$fbr.$m->EPFNo.$bbr.$com;
					
					
				}	

foreach($Packages as $p)
				{
					$pack= $pack.$p->packagecode.$com;
				}		

  foreach($monitoringDate as $m)
				{
					$exp=$exp.$m->DatePlanned.$com;
					$emp=$emp.$m->Initials.$dod.$m->LastName.$a.$m->Approved.$a.$m->Visited.$com;
					
					
				}				
 $getAccredit = AccreditationDetails::getAccreditation($aa->OrgId,$aa->CD_ID);
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
							}
							
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
						  $GetDocumentsendingDatestoTVEC = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						   foreach($GetDocumentsendingDatestoTVEC as $f)
						  {
						     $dsenddatetoTVEC.=$f->DocumentSendingDateToTVEC.$com;
						  }
						  $GetDatePrepareROA = ExamDatePrepareROACertificate::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetDatePrepareROA as $f)
						  {
						     $dateprepareROA.=$f->DatePrepareROAcertificate.$com;
						  }
						  $GetDateRecievingCertifiFromTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetDateRecievingCertifiFromTVEC as $f)
						  {
						     $certifiresdatesfromTVEC.=$f->CertificateRecievingDateFromTVEC.$com;
						  }
						  $GetExamCertificateIssuingDateToDistrict = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCertificateIssuingDateToDistrict as $f)
						  {
						     $certifiissudatedistrict.=$f->CertificateissuingDateToDistrict.$com;
						  }
						  $GetExamEnglishTradeCourseRecievingDateHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetExamEnglishTradeCourseRecievingDateHO as $f)
						  {
						     $Englishtradecourseres.=$f->EnglishTradeCourseResDate.$com;
						  }
						  $GetExamCBTResultRecievingDateToHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCBTResultRecievingDateToHO as $f)
						  {
						     $CBTResdate.=$f->CBTResultsRecievingDate.$com;
						  }
      array_push($printablearray, array($i,$aa->DistrictName, 
	  $aa->OrgaName, $aa->Year,$aa->batch,$aa->CourseName,$aa->CourseListCode,$aa->CourseType,$aa->Nvq,$aa->CourseLevel,$aa->Duration,$aa->Medium,$aa->RealstartDate, 
	  $endDate,$pack,$instructors,
	  
	  $aa->NoOfTrainees,
	  $aa->Dropout,
	  $aa->NoOfRepeaters,
	  $aa->NoOFOJTPlaced,
	  $aa->NoOFOJTCompleted,
	  $aa->NoOfJobPlaaced,
	  $aa->StartedStatus,
	  $acctedit,
	  $accteditrec,
	  $accteditfrom,
	  $accteditto,
	  $Andates,$aa->PreAssessmentDate,$aa->NoOfTraineesPreAssessed,$aa->FinalExamHeld,$fdates,
	  $aa->NoOfTraineesFinalAssessed,$dsdateHO,$rescheckdate,
	  $aa->AssessorReNominated,
	  $aa->Assessor1,
	  $aa->Assessor2,$aa->NoOfTraineesNotCompetent,$aa->NoOfTraineesCompetentNVQ,
	  $aa->UnitOnly+$aa->UnitOnlyII+$aa->UnitOnlyIII+$aa->UnitOnlyIV+$aa->UnitOnlyV+$aa->UnitOnlyVI,
	  $aa->L1+$aa->L1II+$aa->L1IV+$aa->L1V+$aa->L1V+$aa->L1VI,
	  $aa->L2+$aa->L2II+$aa->L2III+$aa->L2IV+$aa->L2V+$aa->L2VI,
	  $aa->L3+$aa->L3II+$aa->L3III+$aa->L3IV+$aa->L3V+$aa->L3VI,
	  $aa->L4+$aa->L4II+$aa->L4III+$aa->L4IV+$aa->L4V+$aa->L4VI,
	  $aa->L5+$aa->L5II+$aa->L5III+$aa->L5IV+$aa->L5V+$aa->L5VI,
	  $aa->ROA+$aa->ROAII+$aa->ROAIII+$aa->ROAIV+$aa->ROAV+$aa->ROAVI,
	  
	  $aa->UnitOnlyH+$aa->UnitOnlyHII+$aa->UnitOnlyHIII+$aa->UnitOnlyHIV+$aa->UnitOnlyHV+$aa->UnitOnlyHVI,
	  $aa->L1H+$aa->L1HII+$aa->L1HIII+$aa->L1HIV+$aa->L1HV+$aa->L1HVI,
	  $aa->L2H+$aa->L2HII+$aa->L2HIII+$aa->L2HIV+$aa->L2HV+$aa->L2HVI,
	  $aa->L3H+$aa->L3HII+$aa->L3HIII+$aa->L3HIV+$aa->L3HV+$aa->L3HVI,
	  $aa->L4H+$aa->L4HII+$aa->L4HIII+$aa->L4HIV+$aa->L4HV+$aa->L4HVI,
	  $aa->L5H+$aa->L5HII+$aa->L5HIII+$aa->L5HIV+$aa->L5HV+$aa->L5HVI,
	  $aa->ROAH+$aa->ROAHII+$aa->ROAHIII+$aa->ROAHIV+$aa->ROAHV+$aa->ROAHVI,
	  $dsenddatetoTVEC,
	  $dateprepareROA,
	  $certifiresdatesfromTVEC,
	  $certifiissudatedistrict,
	  $Englishtradecourseres,
	  $CBTResdate.$aa->Comment));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('TrainingPlanswithFullDetails');
		
	}
	
	public function PrintPDFTrainingPlanReportByTestingEva()
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced

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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced

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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					   courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced

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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced

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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					   courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced

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
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		}
		 
			
	$trplans = DB::select(DB::raw($sql));
		
		$i = 1;
   $html ='<html><head><center><b><h3>Training Plans - '.$Year.'( Batch-'.$Batch.')</h3></b></center></head><body>
   <font size="5px" face="Times New Roman" ><table style = "font-size:18px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">District</th>
<th align="center">Centre</th>
<th align="center">Year</th>
<th align="center">Batch</th>
<th align="center">Course</th>
<th align="center">CourseListCode</th>
<th align="center">CourseType</th>
<th align="center">NVQ/NON-NVQ</th>
<th align="center">NVQ Level</th>
<th align="center">Duration</th>
<th align="center">Medium</th>
<th align="center">Start Date</th>
<th align="center">End Date</th>
<th align="center">Packages Included</th>
<th align="center">Instructors</th>
<th align="center">No of Trainees Registered</th>
<th align="center">No of Trainees Dropout</th>
<th align="center">No of Repeaters</th>
<th align="center">Course Started Status</th>
<th align="center">Accredation Ststus</th>
<th align="center">Accredation Recommended Date</th>
<th align="center">Accredation Date</th>
<th align="center">Accredation Valid Date</th>
<th align="center">Assessor Nominated Date</th>
<th align="center">Eligibility Test Date</th>
<th align="center">No of Trainees for Eligibility Test</th>
<th align="center">Final Assessment Held</th>
<th align="center">Final Assessment Date</th>
<th align="center">No of Trainees Final Assessed</th>
<th align="center">Document Sending Date to HO</th>
<th align="center">Result Checked Date</th>
<th align="center">Assessor ReNominated</th>
<th align="center">Assessor Name 1</th>
<th align="center">Assessor Name 2</th>
<th align="center">No of Trainees Not Competent</th>
<th align="center">No of Trainees Competent (NVQ)</th>
<th align="center">Unit Only</th>
<th align="center">NVQ L1</th>
<th align="center">NVQ L2</th>
<th align="center">NVQ L3</th>
<th align="center">NVQ L4</th>
<th align="center">NVQ L5</th>
<th align="center">ROA</th>
<th align="center">Unit Only (Head Count)</th>
<th align="center">NVQ L1 (Head Count)</th>
<th align="center">NVQ L2 (Head Count)</th>
<th align="center">NVQ L3 (Head Count)</th>
<th align="center">NVQ L4 (Head Count)</th>
<th align="center">NVQ L5 (Head Count)</th>
<th align="center">ROA (Head Count)</th>
<th align="center">Document Sending date to TVEC</th>
<th align="center">Date of Prepairing ROA Certificate</th>
<th align="center">Certificate Recieving Date From TVEC</th>
<th align="center">Certificate Issuing Date To District</th>

<th align="center">English Trade Courses Receiving Date to HO</th>
<th align="center">CBT Result Receiving Date to HO</th>

</thead><tbody>';

foreach ($trplans as $aa ) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->DistrictName.'</td>
          <td>'.$aa->OrgaName.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->batch.'</td>
          <td>'.$aa->CourseName.'</td>
          <td>'.$aa->CourseListCode.'</td>
          <td>'.$aa->CourseType.'</td>
		  <td>'.$aa->Nvq.'</td>
		  <td>'.$aa->CourseLevel.'</td>
		  <td>'.$aa->Duration.'</td>
		  <td>'.$aa->Medium.'</td>
		  <td>'.$aa->RealstartDate.'</td>';
		$endDate = MOCenterMonitoringPlan::getEndDate($aa->RealstartDate,$aa->Duration);
		$Packages = MOCenterMonitoringPlan::getPackages($aa->CD_ID);
		$monitoringDate = MOCenterMonitoringPlan::getMonitoringDates($aa->id);
		$ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$aa->id."'
						  and moinstructorcourse.Active='Yes'";
                $Ins=DB::select(DB::raw($ppp));
			 $countPPP = count($Ins);  
			    $html.=' <td>'.$endDate.'</td><td><span>';
				foreach($Packages as $p)
				{
					$html.=''.$p->packagecode.'</br>';
				}
				   $html.='</span</td><td><span>';
				   
				  //
				//  $html.=' <td>'.$endDate.'</td><td><span>';
				if($countPPP != 0)
				{
				foreach($Ins as $p)
				{
					$html.=''.$p->Name.'('.$p->EPFNo.')</br>';
				}
				   $html.='</span</td>';
				   
				}
				else{
					$html.='</span</td>';
				}
			 
				  //
				  
				  $getAccredit = AccreditationDetails::getAccreditation($aa->OrgId,$aa->CD_ID);
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
							}
							
				   
				  $html.='
				   
					 <td>'.$aa->NoOfTrainees.'</td>
					 <td>'.$aa->Dropout.'</td>
					 <td>'.$aa->NoOfRepeaters.'</td>
					 <td>'.$aa->StartedStatus.'</td>
					 <td>'.$acctedit.'</td>
					 <td>'.$accteditrec.'</td>
					 <td>'.$accteditfrom.'</td>
					 <td>'.$accteditto.'</td><td>';
					 $GetAssessorNominatedDates = ExamAssesorMoninatedDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
					 foreach($GetAssessorNominatedDates as $f)
						  {
						     $html.='<span>'.$f->AssessorNominatedDate.'</br></span>';
						  }
					 $html.='</td>
				     <td>'.$aa->PreAssessmentDate.'</td>
					 <td>'.$aa->NoOfTraineesPreAssessed.'</td>
					 <td>'.$aa->FinalExamHeld.'</td><td>';
						  
						  $GetFinalAssDates = ExamFinalAssessmentDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						  foreach($GetFinalAssDates as $f)
						  {
						     $html.='<span>'.$f->FinalAssessmentDate.'</br></span>';
						  }
						  
						   $html.='</td>
						   <td>'.$aa->NoOfTraineesFinalAssessed.'</td><td>';
						 $GetDocumentsendingDatestoHO = ExamDocumentSendingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetDocumentsendingDatestoHO as $f)
						  {
						     $html.='<span>'.$f->DocumentSendingDateToHO.'</br></span>';
						  }
						   $html.='</td><td>';
						   $GetResultCheckedDates = ExamResultCheckedDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						    foreach($GetResultCheckedDates as $f)
						  {
						     $html.='<span>'.$f->ResultCheckedDate.'</br></span>';
						  }
						 $html.='</td>
						   <td>'.$aa->AssessorReNominated.'</td>
						   <td>'.$aa->Assessor1.'</td>
						   <td>'.$aa->Assessor2.'</td>
						   <td>'.$aa->NoOfTraineesNotCompetent.'</td>
						   <td>'.$aa->NoOfTraineesCompetentNVQ.'</td>';
						   
						   $UnitOnlysum = $aa->UnitOnly+$aa->UnitOnlyII+$aa->UnitOnlyIII+$aa->UnitOnlyIV+$aa->UnitOnlyV+$aa->UnitOnlyVI;
						   $L1sum = $aa->L1+$aa->L1II+$aa->L1IV+$aa->L1V+$aa->L1V+$aa->L1VI;
						   $L2sum = $aa->L2+$aa->L2II+$aa->L2III+$aa->L2IV+$aa->L2V+$aa->L2VI;
						   $L3sum = $aa->L3+$aa->L3II+$aa->L3III+$aa->L3IV+$aa->L3V+$aa->L3VI;
						   $L4sum = $aa->L4+$aa->L4II+$aa->L4III+$aa->L4IV+$aa->L4V+$aa->L4VI;
						   $L5sum = $aa->L5+$aa->L5II+$aa->L5III+$aa->L5IV+$aa->L5V+$aa->L5VI;
						   $ROAsum = $aa->ROA+$aa->ROAII+$aa->ROAIII+$aa->ROAIV+$aa->ROAV+$aa->ROAVI;
						   
						   $html.='<td>'.$UnitOnlysum.'</td>
						   <td>'.$L1sum.'</td>
						   <td>'.$L2sum.'</td>
						   <td>'.$L3sum.'</td>
						   <td>'.$L4sum.'</td>
						   <td>'.$L5sum.'</td>
						   <td>'.$ROAsum.'</td>';
						   
						   $UnitOnlyHsum = $aa->UnitOnlyH+$aa->UnitOnlyHII+$aa->UnitOnlyHIII+$aa->UnitOnlyHIV+$aa->UnitOnlyHV+$aa->UnitOnlyHVI;
						   $L1Hsum = $aa->L1H+$aa->L1HII+$aa->L1HIII+$aa->L1HIV+$aa->L1HV+$aa->L1HVI;
						   $L2Hsum = $aa->L2H+$aa->L2HII+$aa->L2HIII+$aa->L2HIV+$aa->L2HV+$aa->L2HVI;
						   $L3Hsum = $aa->L3H+$aa->L3HII+$aa->L3HIII+$aa->L3HIV+$aa->L3HV+$aa->L3HVI;
						   $L4Hsum = $aa->L4H+$aa->L4HII+$aa->L4HIII+$aa->L4HIV+$aa->L4HV+$aa->L4HVI;
						   $L5Hsum = $aa->L5H+$aa->L5HII+$aa->L5HIII+$aa->L5HIV+$aa->L5HV+$aa->L5HVI;
						   $ROAHsum = $aa->ROAH+$aa->ROAHII+$aa->ROAHIII+$aa->ROAHIV+$aa->ROAHV+$aa->ROAHVI;
						   
						   
						 $html.='<td>'.$UnitOnlyHsum.'</td>
						   <td>'.$L1Hsum.'</td>
						   <td>'.$L2Hsum.'</td>
						   <td>'.$L3Hsum.'</td>
						   <td>'.$L4Hsum.'</td>
						   <td>'.$L5Hsum.'</td>
						   <td>'.$ROAHsum.'</td>
						   <td>';
						   $GetDocumentsendingDatestoTVEC = ExamDocumentSendingDtaeToTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						   foreach($GetDocumentsendingDatestoTVEC as $f)
						  {
						     $html.='<span>'.$f->DocumentSendingDateToTVEC.'</br></span>';
						  }
						 $html.='</td><td>';
						 $GetDatePrepareROA = ExamDatePrepareROACertificate::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetDatePrepareROA as $f)
						  {
						     $html.='<span>'.$f->DatePrepareROAcertificate.'</br></span>';
						  }
						 $html.='</td><td>';
						$GetDateRecievingCertifiFromTVEC = ExamCertificateRecievingDateFromTVEC::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetDateRecievingCertifiFromTVEC as $f)
						  {
						     $html.='<span>'.$f->CertificateRecievingDateFromTVEC.'</br></span>';
						  }
						 $html.='</td><td>';
						 $GetExamCertificateIssuingDateToDistrict = ExamCertificateIssuingDateToDistrict::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCertificateIssuingDateToDistrict as $f)
						  {
						     $html.='<span>'.$f->CertificateissuingDateToDistrict.'</br></span>';
						  }
						 $html.='</td> <td>';
						 $GetExamEnglishTradeCourseRecievingDateHO = ExamEnglishTradeCourseRecievingDateHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						 foreach($GetExamEnglishTradeCourseRecievingDateHO as $f)
						  {
						     $html.='<span>'.$f->EnglishTradeCourseResDate.'</br></span>';
						  }
						$html.='</td> <td>';
						$GetExamCBTResultRecievingDateToHO = ExamCBTResultRecievingDateToHO::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						foreach($GetExamCBTResultRecievingDateToHO as $f)
						  {
						     $html.='<span>'.$f->CBTResultsRecievingDate.'</br></span>';
						  }
						$html.='</td></tr>';
          
  }

  $html.='</tbody></table></font></body></html>';
   return $html;

	}
	
	public function editCourseYearPlanTestingEva()
	{
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
                $view = View::make('TrainingPlanUpdate.EditCourseYearPlanByTestingEva');
                $view->CourseListCode = Course::where('Deleted', '=', 0)
                ->orderBy('CourseListCode')
                ->get();
                $view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
            $CourseYearPlan1 = CourseYearPlan::find(Input::get('edit_id'));
         $temp_yr=$CourseYearPlan1->startDate;
		 $CDID = $CourseYearPlan1->CD_ID;
		 $CategoryIdn  = Course::where('CD_ID','=',$CDID)->pluck('CourseCategoryId');
		 $sqlrepeatcourse = DB::select(DB::raw("SELECT courseyearplan.id,organisation.OrgaName,organisation.Type,coursedetails.CourseName,coursedetails.CourseListCode,courseyearplan.Year
  ,courseyearplan.batch,courseyearplan.medium,coursedetails.CourseType,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,courseyearplan.RealstartDate
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  where courseyearplan.Deleted=0
  and courseyearplan.RealstartDate>'".$temp_yr."'
  and coursedetails.Deleted=0
  and courseyearplan.StartedStatus=1
  and coursedetails.CourseCategoryId='".$CategoryIdn."'
  and courseyearplan.id not in('".Input::get('edit_id')."')
  order by organisation.OrgaName,courseyearplan.Year,courseyearplan.batch"));
		
		    $view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			$view->RepCourse = $sqlrepeatcourse;
			
			$ppp = DB::select(DB::raw("select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
  from moinstructorcourse
  left join moinstructor
  on moinstructorcourse.InstructorID=moinstructor.id
  where moinstructorcourse.CourseYearPlanID='".Input::get('edit_id')."'
  and moinstructorcourse.Active='Yes'"));
             $view->AddedInstructors = $ppp;
           $view->OrgaType=$OrgaType;
            $view->date=trim($temp_yr);
			$view->CourseLevel=trim($CourseYearPlan1->CourseLevel);
			
			$NVQLevel =Course::where('CourseListCode','=',$CourseYearPlan1->CourseListCode)
							->where('Deleted', '!=', 1)
							->pluck('Nvq');
			$view->NVQ=trim($NVQLevel);

              $view->CourseYearPlan=$CourseYearPlan1;
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
              $organisation=Organisation::where('Deleted','=',0)->where('Active','=','Yes')->where('Type','!=','HO')->orderBy('OrgaName')->get();
              $view->organisation=$organisation;
			  
			  
                // $view->CourseYearPlan = CourseYearPlan::where("Deleted","=",0);
                return $view;
                break;
                case 'POST':
               // $validator = CourseYearPlan::validate(Input::all());
              
                    
                    $orgID = Input::get('edit_id');
                 
					$cyp = CourseYearPlan::find(Input::get('edit_id'));
                    //$cyp->AssessorNominatedDate = Input::get('AssessorNominatedDate');
                    $cyp->PreAssessmentDate = Input::get('PreAssessmentDate');
                    $cyp->NoOfTraineesPreAssessed = Input::get('NoOfTraineesPreAssessed');
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
					//Edit Multiple Assesor Nominated Dates
					$setValAN = explode(',',Input::get('datesANM'));
					$no_of_DatesAN = count($setValAN);
					$final_selected_datesAN = array_map('trim',$setValAN);
					$deletedAN = ExamAssesorMoninatedDates::where('YearPlanID','=',Input::get('edit_id'))->update(array('Deleted' => 1));
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
					$setValDSDT = explode(',',Input::get('datesDSDTM'));
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
					}
					// end
					
					//Edit Date of Prepare ROA
					$setValDPROA = explode(',',Input::get('datesDPROAM'));
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
					}
					// end
					
					//Edit certificate recieving from TVEC
					$setValCRDFTVEC = explode(',',Input::get('datesCRDFTVECM'));
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
					}
					// end
					//Edit certificate issuing dates to District
					$setValCIDTDIS = explode(',',Input::get('datesCIDTDISM'));
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
					}
					// end
					
					//Edit English Trade Course Reciveing HO
					$setValETCRDHO = explode(',',Input::get('datesETCRDHOM'));
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
					}
					// end
					//Edit CBT Results HO
					$setValCBTHO = explode(',',Input::get('datesCBTHOM'));
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
					}
					// end
					
					$cyp->NoOfTraineesFinalAssessed = Input::get('NoOfTraineesFinalAssessed');
					//$cyp->DocumentSendingDateToHO = Input::get('DocumentSendingDateToHO');
					//$cyp->ResultCheckedDate = Input::get('ResultCheckedDate');
					
					$cyp->Assessor1 = Input::get('Assessor1');
					$cyp->Assessor2 = Input::get('Assessor2');
					$cyp->NoOfRepeaters = Input::get('NoOfRepeaters');
					//$cyp->NoOFOJTPlaced = Input::get('NoOFOJTPlaced');
					//$cyp->NoOFOJTCompleted = Input::get('NoOFOJTCompleted');
					$cyp->NoOftraineesforcommonexam = Input::get('NoOftraineesforcommonexam');
					$cyp->AssessorReNominated = Input::get('AssessorReNominated');
					$cyp->NoOfTraineesNotCompetent = Input::get('NoOfTraineesNotCompetent');
					$cyp->NoOfTraineesCompetentNVQ = Input::get('NoOfTraineesCompetentNVQ');
					$cyp->UnitOnly = Input::get('UnitOnly');
					$cyp->L1 = Input::get('L1');
					$cyp->L2 = Input::get('L2');
					$cyp->L3 = Input::get('L3');
					$cyp->L4 = Input::get('L4');
					$cyp->L5 = Input::get('L5');
					$cyp->ROA = Input::get('ROA');
					//second Attempt
					$cyp->UnitOnlyII = Input::get('UnitOnlyII');
					$cyp->L1II = Input::get('L1II');
					$cyp->L2II = Input::get('L2II');
					$cyp->L3II = Input::get('L3II');
					$cyp->L4II = Input::get('L4II');
					$cyp->L5II = Input::get('L5II');
					$cyp->ROAII = Input::get('ROAII'); 
					//Third Attempt
					$cyp->UnitOnlyIII = Input::get('UnitOnlyIII');
					$cyp->L1III = Input::get('L1III');
					$cyp->L2III = Input::get('L2III');
					$cyp->L3III = Input::get('L3III');
					$cyp->L4III = Input::get('L4III');
					$cyp->L5III = Input::get('L5III');
					$cyp->ROAIII = Input::get('ROAIII'); 
					//forth Attempt
					$cyp->UnitOnlyIV = Input::get('UnitOnlyIV');
					$cyp->L1IV = Input::get('L1IV');
					$cyp->L2IV = Input::get('L2IV');
					$cyp->L3IV = Input::get('L3IV');
					$cyp->L4IV = Input::get('L4IV');
					$cyp->L5IV = Input::get('L5IV');
					$cyp->ROAIV = Input::get('ROAIV');
					//Fifth Attempt
					$cyp->UnitOnlyV = Input::get('UnitOnlyV');
					$cyp->L1V = Input::get('L1V');
					$cyp->L2V = Input::get('L2IV');
					$cyp->L3V = Input::get('L2V');
					$cyp->L4V = Input::get('L4V');
					$cyp->L5V = Input::get('L5V');
					$cyp->ROAV = Input::get('ROAV');
					//Sixth Attempt
					$cyp->UnitOnlyVI = Input::get('UnitOnlyVI');
					$cyp->L1VI = Input::get('L1VI');
					$cyp->L2VI = Input::get('L2VI');
					$cyp->L3VI = Input::get('L3VI');
					$cyp->L4VI = Input::get('L4VI');
					$cyp->L5VI = Input::get('L5VI');
					$cyp->ROAVI = Input::get('ROAVI');
					
					//Head Counts
					$cyp->UnitOnlyH = Input::get('UnitOnlyH');
					$cyp->L1H = Input::get('L1H');
					$cyp->L2H = Input::get('L2H');
					$cyp->L3H = Input::get('L3H');
					$cyp->L4H = Input::get('L4H');
					$cyp->L5H = Input::get('L5H');
					$cyp->ROAH = Input::get('ROAH');
					//second Attempt
					$cyp->UnitOnlyHII = Input::get('UnitOnlyHII');
					$cyp->L1HII = Input::get('L1HII');
					$cyp->L2HII = Input::get('L2HII');
					$cyp->L3HII = Input::get('L3HII');
					$cyp->L4HII = Input::get('L4HII');
					$cyp->L5HII = Input::get('L5HII');
					$cyp->ROAHII = Input::get('ROAHII');
					//Third Attempt
					$cyp->UnitOnlyHIII = Input::get('UnitOnlyHIII');
					$cyp->L1HIII = Input::get('L1HIII');
					$cyp->L2HIII = Input::get('L2HIII');
					$cyp->L3HIII = Input::get('L3HIII');
					$cyp->L4HIII = Input::get('L4HIII');
					$cyp->L5HIII = Input::get('L5HIII');
					$cyp->ROAHIII = Input::get('ROAHIII');
					//Forth Attempt
					$cyp->UnitOnlyHIV = Input::get('UnitOnlyHIV');
					$cyp->L1HIV = Input::get('L1HIV');
					$cyp->L2HIV = Input::get('L2HIV');
					$cyp->L3HIV = Input::get('L3HIV');
					$cyp->L4HIV = Input::get('L4HIV');
					$cyp->L5HIV = Input::get('L5HIV');
					$cyp->ROAHIV = Input::get('ROAHIV');
					//fifth Attempt
					$cyp->UnitOnlyHV = Input::get('UnitOnlyHV');
					$cyp->L1HV = Input::get('L1HV');
					$cyp->L2HV = Input::get('L2HV');
					$cyp->L3HV = Input::get('L3HV');
					$cyp->L4HV = Input::get('L4HV');
					$cyp->L5HV = Input::get('L5HV');
					$cyp->ROAHV = Input::get('ROAHV');
					//sixth Attempt
					$cyp->UnitOnlyHVI = Input::get('UnitOnlyHVI');
					$cyp->L1HVI = Input::get('L1HVI');
					$cyp->L2HVI = Input::get('L2HVI');
					$cyp->L3HVI = Input::get('L3HVI');
					$cyp->L4HVI = Input::get('L4HVI');
					$cyp->L5HVI = Input::get('L5HVI');
					$cyp->ROAHVI = Input::get('ROAHVI');
					
					
					$cyp->Comment = Input::get('Comment');
					//$cyp->NoOfJobPlaaced = Input::get('NoOfJobPlaaced');
					//$cyp->DocumentSendingDateToTVEC = Input::get('DocumentSendingDateToTVEC');
					//$cyp->DateOfPrepareROAcertificate = Input::get('DateOfPrepareROAcertificate');
					//$cyp->CertificateRecievingDateFromTVEC = Input::get('CertificateRecievingDateFromTVEC');
					//$cyp->CertificateIssuingDateToDistrict = Input::get('CertificateIssuingDateToDistrict');
					//$cyp->EnglishReceivingDateHO = Input::get('EnglishReceivingDateHO');
					$cyp->CBTResultReceivingDateToHO = Input::get('CBTResultReceivingDateToHO');
					$cyp->ExamUnitUserID = User::getSysUser()->userID;
					$cyp->NoOfTraineesFinalAssessedR1 = Input::get('NoOfTraineesFinalAssessedR1');
					$cyp->NoOfTraineesFinalAssessedR2 = Input::get('NoOfTraineesFinalAssessedR2');
					$cyp->NoOfTraineesNotCompetentR1 = Input::get('NoOfTraineesNotCompetentR1');
					$cyp->NoOfTraineesNotCompetentR2 = Input::get('NoOfTraineesNotCompetentR2');
					$cyp->NoOfTraineesCompetentNVQR1 = Input::get('NoOfTraineesCompetentNVQR1');
					$cyp->NoOfTraineesCompetentNVQR2 = Input::get('NoOfTraineesCompetentNVQR2');
					$cyp->RepeatBatch1YearPlanID = Input::get('RepeatBatch1YearPlanID');
					$cyp->RepeatBatch2YearPlanID = Input::get('RepeatBatch2YearPlanID');
                    $cyp->save();
                    $view = View::make('TrainingPlanUpdate.ViewTrainingPlanUpdateByTestingEva');
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
	courseyearplan.NoOfRepeaters,
	courseyearplan.AssessorReNominated,
	courseyearplan.EnglishReceivingDateHO,
	courseyearplan.CBTResultReceivingDateToHO,
	courseyearplan.OrgId,
	courseyearplan.FinalExamHeld,
	courseyearplan.ExActualStartDate,
	courseyearplan.ExActualEndDate,
	courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
	
	public function ViewTrainingPlanUpdateTestingEva()
	{
	$method = Request::getMethod();
    $view = View::make('TrainingPlanUpdate.ViewTrainingPlanUpdateByTestingEva');
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
   courseyearplan.FinalExamHeld,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
   courseyearplan.FinalExamHeld,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalExamHeld,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					  courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					  courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
   courseyearplan.FinalExamHeld,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
   courseyearplan.FinalExamHeld,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
    courseyearplan.UnitOnlyII,
  courseyearplan.L1II,
  courseyearplan.L2II,
  courseyearplan.L3II,
  courseyearplan.L4II,
  courseyearplan.L5II,
  courseyearplan.ROAII,
  courseyearplan.UnitOnlyIII,
  courseyearplan.L1III,
  courseyearplan.L2III,
  courseyearplan.L3III,
  courseyearplan.L4III,
  courseyearplan.L5III,
  courseyearplan.ROAIII,
  courseyearplan.UnitOnlyIV,
  courseyearplan.L1IV,
  courseyearplan.L2IV,
  courseyearplan.L3IV,
  courseyearplan.L4IV,
  courseyearplan.L5IV,
  courseyearplan.ROAIV,
  courseyearplan.UnitOnlyV,
  courseyearplan.L1V,
  courseyearplan.L2V,
  courseyearplan.L3V,
  courseyearplan.L4V,
  courseyearplan.L5V,
  courseyearplan.ROAV,
  courseyearplan.UnitOnlyVI,
  courseyearplan.L1VI,
  courseyearplan.L2VI,
  courseyearplan.L3VI,
  courseyearplan.L4VI,
  courseyearplan.L5VI,
  courseyearplan.ROAVI,
  courseyearplan.UnitOnlyH,
  courseyearplan.L1H,
  courseyearplan.L2H,
  courseyearplan.L3H,
  courseyearplan.L4H,
  courseyearplan.L5H,
  courseyearplan.ROAH,
  courseyearplan.UnitOnlyHII,
  courseyearplan.L1HII,
  courseyearplan.L2HII,
  courseyearplan.L3HII,
  courseyearplan.L4HII,
  courseyearplan.L5HII,
  courseyearplan.ROAHII,
  courseyearplan.UnitOnlyHIII,
  courseyearplan.L1HIII,
  courseyearplan.L2HIII,
  courseyearplan.L3HIII,
  courseyearplan.L4HIII,
  courseyearplan.L5HIII,
  courseyearplan.ROAHIII,
  courseyearplan.UnitOnlyHIV,
  courseyearplan.L1HIV,
  courseyearplan.L2HIV,
  courseyearplan.L3HIV,
  courseyearplan.L4HIV,
  courseyearplan.L5HIV,
  courseyearplan.ROAHIV,
  courseyearplan.UnitOnlyHV,
  courseyearplan.L1HV,
  courseyearplan.L2HV,
  courseyearplan.L3HV,
  courseyearplan.L4HV,
  courseyearplan.L5HV,
  courseyearplan.ROAHV,
  courseyearplan.UnitOnlyHVI,
  courseyearplan.L1HVI,
  courseyearplan.L2HVI,
  courseyearplan.L3HVI,
  courseyearplan.L4HVI,
  courseyearplan.L5HVI,
  courseyearplan.ROAHVI,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
  courseyearplan.Accredit,
  courseyearplan.AccreditDate,
  courseyearplan.AccreditationValidDate,
   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated,
					  courseyearplan.EnglishReceivingDateHO,
					  courseyearplan.CBTResultReceivingDateToHO,
					  courseyearplan.OrgId,
					  courseyearplan.ExActualStartDate,
					  courseyearplan.ExActualEndDate,
					  courseyearplan.NoOfTraineesFinalAssessedR1,
  courseyearplan.NoOfTraineesFinalAssessedR2,
  courseyearplan.NoOfTraineesNotCompetentR1,
  courseyearplan.NoOfTraineesNotCompetentR2,
  courseyearplan.NoOfTraineesCompetentNVQR1,
  courseyearplan.NoOfTraineesCompetentNVQR2,
  courseyearplan.RepeatBatch1YearPlanID,
  courseyearplan.RepeatBatch2YearPlanID,
  courseyearplan.NoOFOJTPlaced,
  courseyearplan.NoOFOJTCompleted,
  courseyearplan.NoOfJobPlaaced,
  courseyearplan.Comment
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
	
public function editCourseYearPlanDisNVTI() {
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
                $view = View::make('TrainingPlanUpdate.EditCourseYearPlanByDisNVTI');
                $view->CourseListCode = Course::where('Deleted', '=', 0)
                ->orderBy('CourseListCode')
                ->get();
                $view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
            $CourseYearPlan1 = CourseYearPlan::find(Input::get('edit_id'));
         $temp_yr=$CourseYearPlan1->startDate;
		 
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
           $view->OrgaType=$OrgaType;
            $view->date=trim($temp_yr);
			$view->CourseLevel=trim($CourseYearPlan1->CourseLevel);
			
			$NVQLevel =Course::where('CourseListCode','=',$CourseYearPlan1->CourseListCode)
							->where('Deleted', '!=', 1)
							->pluck('Nvq');
			$view->NVQ=trim($NVQLevel);

              $view->CourseYearPlan=$CourseYearPlan1;
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
              $organisation=Organisation::where('Deleted','=',0)->where('Active','=','Yes')->where('Type','!=','HO')->orderBy('OrgaName')->get();
              $view->organisation=$organisation;
                // $view->CourseYearPlan = CourseYearPlan::where("Deleted","=",0);
                return $view;
                break;
                case 'POST':
               // $validator = CourseYearPlan::validate(Input::all());
              
                    
                    $orgID = Input::get('edit_id');
                 /*    $instructorEPF = Input::get('InstructorList');
				    $instructorEPF2 = Input::get('InstructorList1');
					$instructorName1 = MOInstructor::where('EPFNo','=',$instructorEPF)->pluck('Name');
					$instructorName2 = MOInstructor::where('EPFNo','=',$instructorEPF2)->pluck('Name'); */
					/* $cyp = CourseYearPlan::find(Input::get('edit_id'));
                    $cyp->NoOfTrainees = Input::get('TCount');
                    $cyp->Dropout = Input::get('DCount');
                    $cyp->CurrentInstructorEPF = $instructorEPF;
					$cyp->CurrentInstructorEPF2 = $instructorEPF2;
                    $cyp->InstructorName = $instructorName1;
				    $cyp->InstructorName2 = $instructorName2;
					$cyp->StartedStatus = Input::get('StartedStatus');
                    $cyp->save(); */
					 $PreAssessmentDate = Input::get('PreAssessmentDate');
					 $NoOfTraineesPreAssessed = Input::get('NoOfTraineesPreAssessed');
					 $NoOfRepeaters = Input::get('NoOfRepeaters');
					// $FinalAssessmentDate = Input::get('FinalAssessmentDate');
				     $NoOfTraineesFinalAssessed = Input::get('NoOfTraineesFinalAssessed');
					 $DocumentSendingDateToHO = Input::get('DocumentSendingDateToHO');
					 $Assessor1 = Input::get('Assessor1');
					 $Assessor2 = Input::get('Assessor2');
					 
					  //Edit Multiple
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
					
					
					$updateArray = CourseYearPlan::where('id','=',Input::get('edit_id'))->update(array('PreAssessmentDate' =>$PreAssessmentDate,
					'NoOfTraineesPreAssessed' =>$NoOfTraineesPreAssessed,'NoOfRepeaters' =>$NoOfRepeaters, 'NoOfTraineesFinalAssessed' => $NoOfTraineesFinalAssessed, 
					'DocumentSendingDateToHO' => $DocumentSendingDateToHO, 'Assessor1' => $Assessor1, 
					'Assessor2' => $Assessor2));
                   /*  $getMaxID = $orgID;
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
					
					
					$view = View::make('TrainingPlanUpdate.ViewTrainingPlanUpdateByDisNVTI');
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

         /* if($CenterID == 'All')
		{
			$district = Input::get('District');
			$sql = "select courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus
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
					  and courseyearplan.batch='".$Batch."'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
					district.DistrictName,organisation.OrgaName,
					organisation.Type,
					courseyearplan.Year,
					courseyearplan.batch,
					coursedetails.CourseName,
					coursedetails.CourseListCode,
					coursedetails.CD_ID,
					coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					coursedetails.Duration,
					courseyearplan.medium AS Medium,
					courseyearplan.RealstartDate,
					courseyearplan.NoOfTrainees,
					courseyearplan.Dropout,
					courseyearplan.StartedStatus
					from courseyearplan
					left join organisation
					on courseyearplan.OrgId=organisation.id
					left join district
					on organisation.DistrictCode=district.DistrictCode
					left join coursedetails
					on courseyearplan.CD_ID=coursedetails.CD_ID
					where courseyearplan.Deleted=0
					and organisation.id='".$CenterID."'
					and courseyearplan.Year='".$Year."'
					and courseyearplan.batch='".$Batch."'
					order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					";
		} */
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated
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
    return $view;               //return Redirect::to('ViewTrainingPlanUpdateDisNVTI?');
						//return Redirect::back();
                    
                
                break;
            default:
                break;
        }
    }

	
	public function ViewTrainingPlanUpdateDisNVTI()
	{
		$method = Request::getMethod();
    $view = View::make('TrainingPlanUpdate.ViewTrainingPlanUpdateByDisNVTI');
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
		
		
		/* if($CenterID == 'All')
		{
			$district = Input::get('District');
			$sql = "select courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus
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
					  and courseyearplan.batch='".$Batch."'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		} */
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.AssessorNominatedDate,
					  courseyearplan.PreAssessmentDate,
					  courseyearplan.NoOfTraineesPreAssessed,
					  courseyearplan.FinalAssessmentDate,
					  courseyearplan.NoOfTraineesFinalAssessed,
					  courseyearplan.DocumentSendingDateToHO,
					  courseyearplan.ResultCheckedDate,
					  courseyearplan.Assessor1,
					  courseyearplan.Assessor2,
					  courseyearplan.NoOfTraineesNotCompetent,
					  courseyearplan.NoOfTraineesCompetentNVQ,
					  courseyearplan.UnitOnly,
					  courseyearplan.L1,
					  courseyearplan.L2,
					  courseyearplan.L3,
					  courseyearplan.L4,
					  courseyearplan.L5,
					  courseyearplan.ROA,
					  courseyearplan.DocumentSendingDateToTVEC,
					  courseyearplan.DateOfPrepareROAcertificate,
					  courseyearplan.CertificateRecievingDateFromTVEC,
					  courseyearplan.CertificateIssuingDateToDistrict,
					   courseyearplan.InstructorName,
					  courseyearplan.InstructorName2,
					   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated
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
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
   courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus,
courseyearplan.AssessorNominatedDate,
  courseyearplan.PreAssessmentDate,
  courseyearplan.NoOfTraineesPreAssessed,
  courseyearplan.FinalAssessmentDate,
  courseyearplan.NoOfTraineesFinalAssessed,
  courseyearplan.DocumentSendingDateToHO,
  courseyearplan.ResultCheckedDate,
  courseyearplan.Assessor1,
  courseyearplan.Assessor2,
  courseyearplan.NoOfTraineesNotCompetent,
  courseyearplan.NoOfTraineesCompetentNVQ,
  courseyearplan.UnitOnly,
  courseyearplan.L1,
  courseyearplan.L2,
  courseyearplan.L3,
  courseyearplan.L4,
  courseyearplan.L5,
  courseyearplan.ROA,
  courseyearplan.DocumentSendingDateToTVEC,
  courseyearplan.DateOfPrepareROAcertificate,
  courseyearplan.CertificateRecievingDateFromTVEC,
  courseyearplan.CertificateIssuingDateToDistrict,
   courseyearplan.InstructorName,
  courseyearplan.InstructorName2,
   courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.NoOfRepeaters,
					  courseyearplan.AssessorReNominated
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
	
	 public function PrintExcelTrainingPlanReportCheck()
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
		/* if($CenterID == 'All')
		{
			$district = Input::get('districtD');
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
    courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
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
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
    courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		} */
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					 courseyearplan.ReasonForNotStarted,
					 courseyearplan.RealEndDate,
					  courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 courseyearplan.ReasonForNotStarted,
					  courseyearplan.AssessorReNominated
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					  courseyearplan.RealEndDate,
					   courseyearplan.RealstartDate,
					    courseyearplan.ReasonForNotStarted,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 
					  courseyearplan.AssessorReNominated
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					   courseyearplan.ReasonForNotStarted,
					 courseyearplan.medium AS Medium,
					  courseyearplan.RealEndDate,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 
					  courseyearplan.AssessorReNominated
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
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
			
	$trplans = DB::select(DB::raw($sql));
    $i = 1;
    $taskname = '';
	$taskCode = '';
    $modulename = '';
	$ModuleCode = '';
     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','District', 'Centre', 'Year', 'Batch','CourseName','CourseListCode','CourseType'
	 , 'NVQ/NON-NVQ','NVQLevel', 'Duration','Medium','StartDate','EndDate','PackagesIncluded','Instructors','CourseStartedStatus',
	 'Reason For Not Started','NoOf Trainees Registered','NoOfTraineesDropout','EligibilityTestDate',
	 'FinalAssessmentDate','MonitoringDatesPlanned/Approved/Visited','Employee Names');
    array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {
		 
		
						$endDate = 	$aa->RealEndDate;
						
						
			   $Packages = MOCenterMonitoringPlan::getPackages($aa->CD_ID);
			   
			    $ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$aa->id."'
						  and moinstructorcourse.Active='Yes'";
                $Ins=DB::select(DB::raw($ppp));
				
			   
			   $pack = '';
			   $com = ',';
			   $exp = '';
			   $emp = '';
			   $a = '/';
			   $dod = '.';
			   $fbr = '(';
			   $bbr = ')';
			   $instructors = '';
			   $fdates='';
			   
			   foreach($Ins as $m)
				{
					
					$instructors=$instructors.$m->Name.$fbr.$m->EPFNo.$bbr.$com;
					
					
				}	

foreach($Packages as $p)
				{
					$pack= $pack.$p->packagecode.$com;
				}		

  		

$GetFinalAssDates = ExamFinalAssessmentDates::where('YearPlanID','=',$aa->id)->where('Deleted','=',0)->get();
						  foreach($GetFinalAssDates as $f)
						  {
						     $fdates.=$f->FinalAssessmentDate.$com;
						  }				

      array_push($printablearray, array($i,$aa->DistrictName, $aa->OrgaName, 
	  $aa->Year,$aa->batch,
	  $aa->CourseName,
	  $aa->CourseListCode,$aa->CourseType,
	  $aa->Nvq,$aa->CourseLevel,$aa->Duration,
	  $aa->Medium,$aa->RealstartDate, 
	  $endDate,
	  $pack,
	  $instructors,
	  $aa->StartedStatus,$aa->ReasonForNotStarted,
	  $aa->NoOfTrainees,
	  $aa->Dropout,
	
	  
	 $fdates,
	
	  
	  $exp,$emp));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('TrainingPlans');
  }
	
	public function PrintPDFTrainingPlanReportCheck()
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
		/* if($CenterID == 'All')
		{
			$district = Input::get('districtD');
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
    courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
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
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
    coursedetails.CourseListCode,
	coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
 courseyearplan.medium AS Medium,
   courseyearplan.RealstartDate,
    courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		} */
		
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.RealEndDate,
					  courseyearplan.AssessorReNominated
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					  courseyearplan.RealEndDate,
					  courseyearplan.AssessorReNominated
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 courseyearplan.RealEndDate,
					  courseyearplan.AssessorReNominated
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
  group by courseyearplan.id 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		}
			
	$trplans = DB::select(DB::raw($sql));
		
		$i = 1;
   $html ='<html><head><center><b><h3>Training Plans - '.$Year.'( Batch-'.$Batch.')</h3></b></center></head><body>
   <font size="5px" face="Times New Roman" ><table style = "font-size:18px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">District</th>
<th align="center">Centre</th>
<th align="center">Year</th>
<th align="center">Batch</th>
<th align="center">Course</th>
<th align="center">CourseListCode</th>
<th align="center">CourseType</th>
<th align="center">NVQ/NON-NVQ</th>
<th align="center">NVQ Level</th>
<th align="center">Duration</th>
<th align="center">Medium</th>
<th align="center">Start Date</th>
<th align="center">End Date</th>
<th align="center">Packages Included</th>



<th align="center">Course Started Status</th>



</thead><tbody>';

foreach ($trplans as $aa ) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->DistrictName.'</td>
          <td>'.$aa->OrgaName.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->batch.'</td>
          <td>'.$aa->CourseName.'</td>
          <td>'.$aa->CourseListCode.'</td>
          <td>'.$aa->CourseType.'</td>
		   <td>'.$aa->Nvq.'</td>
		    <td>'.$aa->CourseLevel.'</td>
			 <td>'.$aa->Duration.'</td>
			  <td>'.$aa->Medium.'</td>
			   <td>'.$aa->RealstartDate.'</td>';
			   
						$endDate = 	$aa->RealEndDate;
						
						
						
			   $Packages = MOCenterMonitoringPlan::getPackages($aa->CD_ID);
			
			   
			    $html.=' <td>'.$endDate.'</td><td><span>';
				foreach($Packages as $p)
				{
					$html.=''.$p->packagecode.'</br>';
				}
				   $html.='</span</td>
				   
					
					<td>'.$aa->StartedStatus.'</td>
					
          </tr>';
          
  }

  $html.='</tbody></table></font></body></html>';
   return $html;

	}
	
	public function ViewTrainingPlanReportCheck()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewTrainingPlanReport');
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
		
		
		/* if($CenterID == 'All')
		{
			$district = Input::get('District');
			$sql = "select courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					    courseyearplan.NoOfTrainees,
courseyearplan.Dropout,
courseyearplan.StartedStatus
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
					  and courseyearplan.batch='".$Batch."'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
					  ";
		}
		else
		{
			$sql = "select courseyearplan.id,
  district.DistrictName,organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CD_ID,
  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
  courseyearplan.RealstartDate,
  courseyearplan.NoOfTrainees,
  courseyearplan.Dropout,
  courseyearplan.StartedStatus
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and organisation.id='".$CenterID."'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch='".$Batch."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration
  ";
		} */
			
		 if($CenterID == 'All' && $district == 'All')
		{
			//$district = Input::get('District');
			$sql = "select DISTINCT courseyearplan.id,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 
					  courseyearplan.AssessorReNominated
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 
					  courseyearplan.AssessorReNominated
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
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CD_ID,
					  coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,
					  coursedetails.Duration,
					 courseyearplan.medium AS Medium,
					   courseyearplan.RealstartDate,
					   courseyearplan.NoOfTrainees,
					   courseyearplan.Dropout,
					   courseyearplan.StartedStatus,
					   courseyearplan.PreAssessmentDate,
					 courseyearplan.Accredit,
					  courseyearplan.AccreditDate,
					  courseyearplan.AccreditationValidDate,
					   courseyearplan.AccreditRecommendDate,
					 
					  courseyearplan.AssessorReNominated
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


}

?>