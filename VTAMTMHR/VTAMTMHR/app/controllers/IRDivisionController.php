<?php
use SimpleExcel\SimpleExcel;

class IRDivisionController extends BaseController {
	
	public function UpdateJOBPOccupiedcolumn()
	{
		$AllOJTVac = IRJOBVacancy::where('Deleted','=',0)->get();
		foreach($AllOJTVac as $m)
		{
			if($m->VacancyType != 'GenderBased')
			{
				//common vacancies
				$Ocvac = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvac
													  from irtraineejobplacement
													  left join irtrainee
													  on irtraineejobplacement.irtraineeID=irtrainee.id
													  where irtraineejobplacement.JOBPVacancyID='".$m->id."'
													  and irtraineejobplacement.Deleted=0
													  and irtraineejobplacement.Active=1
													  and irtraineejobplacement.Dropout=0
													  and irtraineejobplacement.OJTCompletedF=0
													  and irtrainee.OJTCompleted=0"));
				$newdata =  json_decode(json_encode((array)$Ocvac),true);
				$OccuipFemale = $newdata[0]["occupiedvac"];
				
				$UpdateTable = IRJOBVacancy::where('id','=',$m->id)->update(array('OccupiedFemaleVacancy' => $OccuipFemale));
				
				//$AvailableVacCommon = ($m->VacancyFemale - $OccuipFemale);
				
			}
			else
			{
				//GenderBased
				
				// 1 Female
				$Ocvac = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvac
											 from irtraineejobplacement
												  left join irtrainee
												  on irtraineejobplacement.irtraineeID=irtrainee.id
												  where irtraineejobplacement.JOBPVacancyID='".$m->id."'
												  and irtraineejobplacement.Deleted=0
												  and irtraineejobplacement.Active=1
												  and irtraineejobplacement.Dropout=0
												  and irtraineejobplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Female'"));
				$newdataf =  json_decode(json_encode((array)$Ocvac),true);
				$OccuipFemale = $newdataf[0]["occupiedvac"];
				$UpdateTable = IRJOBVacancy::where('id','=',$m->id)->update(array('OccupiedFemaleVacancy' => $OccuipFemale));
				
				//2 Male
				
				$OcvacM = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvacm
											  from irtraineejobplacement
											  left join irtrainee
											  on irtraineejobplacement.irtraineeID=irtrainee.id
											  where irtraineejobplacement.JOBPVacancyID='".$m->id."'
											  and irtraineejobplacement.Deleted=0
											  and irtraineejobplacement.Active=1
											  and irtraineejobplacement.Dropout=0
											  and irtraineejobplacement.OJTCompletedF=0
											  and irtrainee.OJTCompleted=0
											  and irtrainee.Gender='Male'"));
				$newdataM =  json_decode(json_encode((array)$OcvacM),true);
				$OccuipMale = $newdataM[0]["occupiedvacm"];
			    $UpdateTable = IRJOBVacancy::where('id','=',$m->id)->update(array('OccupiedMaleVacancy' => $OccuipMale));
				return 'Done';

			}
			
		}
		
	}
	
	public function IRJOBPStudentProfileGetStudentData()
	{
        $traineeid =  Input::get("studentData");

        $v = View::make('OTJoBPlacementStudents.Profile');

        				$Sql = "select irtraineejobplacement.id,
					  irtrainee.id as TraineeId,
					  irtrainee.NameWithInitials,irtrainee.NIC,
					  irtrainee.MISNumber,irtrainee.Mobile,irtrainee.Gender,
					  ircompany.CompanyName,ircompany.Address,
					  coursecategory.Category,
					  irjobvacancy.TrainingArea,
					  irtraineejobplacement.StartingDate,
					  irtraineejobplacement.EndDate,
					  irtraineejobplacement.Salary,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  irtrainee.OJTPlaced,
					  irtrainee.OJTCompleted,
                      irtrainee.JobPlaced,
					  irtraineejobplacement.Active,irtraineejobplacement.ReasonForDropoutOJT,irtraineejobplacement.Dropout,
					  irtrainee.JobDropout
					  from irtraineejobplacement
					  left join irtrainee
					  on irtraineejobplacement.irtraineeID=irtrainee.id
					  left join irjobvacancy
					  on irtraineejobplacement.JOBPVacancyID=irjobvacancy.id
					  left join coursecategory
					  on irjobvacancy.CourseOccupationID=coursecategory.id
					  left join ircompany
					  on irtraineejobplacement.CompanyID=ircompany.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtraineejobplacement.Deleted=0
					  and irtrainee.id='".$traineeid."'
					  order by irtraineejobplacement.id";
  
     $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = IRTrainee::where('id','=',$traineeid)->first();
		  return $v;
	}
	
	
	public function IRJOBPStudentProfileajaxViewData()
    {
       	$searchVal = Input::get('searchVal');
       	$choice = Input::get('choice');

       	//return $searchVal;
       	//return $choice;
    
		
		if ($choice == 'nic')
		{
			//NIC
				
			    $Employee = DB::select(DB::raw("select irtrainee.*,courseyearplan.Year,batch,organisation.OrgaName,district.DistrictName,
				 coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and irtrainee.NIC='".$searchVal."'
"));
			    $dataList = $Employee;
		}
		else 
		{
			//EPF
			
			$Employee = DB::select(DB::raw("select irtrainee.*,courseyearplan.Year,batch,organisation.OrgaName,district.DistrictName,
			 coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and irtrainee.MISNumber='".$searchVal."'
"));
			$dataList = $Employee;
		}
		

       //return $dataList; 

		$html='';
		$c = 1;
		$a = 1;

		if(empty($dataList))
        {
           return 0;
        }

        else
        {			
        	$html.='</br>';
            $html.='<div class="well well-small"><b><center> All Details Matched From Trainee List</center></b></div>';
			//$html.='</br>';

        	$html.='<div id="table" class="row-fluid span20" style="margin: 0px;" overflow="auto">';
			$html.='<table  class="table table-striped table-bordered table-hover">';
			                           
			$html.='<tbody id="table-body">';
			$html.='</tbody>';

            $html.='<thead>';
            $html.='<tr>';
            $html.='<th>#</th>';
			$html.='<th>View Job Placement Profile</th>';
			$html.='<th>District</th>';
			$html.='<th>Centre</th>';
			$html.='<th>Year</th>';
			$html.='<th>Batch</th>';
			$html.='<th>Course Name</th>';
			$html.='<th>Course List Code</th>';
			$html.='<th>Course Type</th>';
			$html.='<th>NVQ/Non</th>';
			$html.='<th>NVQ Level</th>';
			$html.='<th>Duration</th>';
			$html.='<th>NIC</th>';
			$html.='<th>MIS Number</th>';
            $html.='<th>Full Name</th>';
			$html.='<th>Name with Initials</th>';
			$html.='</tr>';
            $html.='</thead>';

            foreach ($dataList as $aList)
           	{		

                    $html.='<tr>';
                    $html.='<td>'.$c.'</td>';
                    $html.='<td>
					<form action="IRJOBPStudentProfileGetStudentData">
					<input type="hidden" name="studentData" value="'.$aList->id.'"/>
					<center>
					<button onclick="viewStudentProfile()" id="stdData" name="stdData" value="'.$aList->id.'" class="btn btn-pink">View</button>
					</center>
					</form>
					</td>';
					 $html.='<td>'.$aList->DistrictName.'</td>';
					 $html.='<td>'.$aList->OrgaName.'</td>';
					 $html.='<td>'.$aList->Year.'</td>';
					 $html.='<td>'.$aList->batch.'</td>';
					 $html.='<td>'.$aList->CourseName.'</td>';
					 $html.='<td>'.$aList->CourseListCode.'</td>';
					 $html.='<td>'.$aList->CourseType.'</td>';
					 $html.='<td>'.$aList->Nvq.'</td>';
					 $html.='<td>'.$aList->CourseLevel.'</td>';
					 $html.='<td>'.$aList->Duration.'</td>';
					 $html.='<td>'.$aList->NIC.'</td>';
					 $html.='<td>'.$aList->MISNumber.'</td>';
                     $html.='<td>'.$aList->FullName.'</td>';
					 $html.='<td>'.$aList->NameWithInitials.'</td>';
                   
					
                    $html.='</tr>';

                    $c ++;
       		}

            $html.='</table>';
   			$html.='</div>';

            return $html;
                   
        }
    }

	
	public function IROJTStudentProfileGetStudentData()
	{
        $traineeid =  Input::get("studentData");

        $v = View::make('OJTStudents.Profile');

        				$Sql = "select irtraineeojtplacement.id,
  irtrainee.id as TraineeId,
  irtrainee.NameWithInitials,irtrainee.NIC,
  irtrainee.MISNumber,irtrainee.Mobile,irtrainee.Gender,
  ircompany.CompanyName,ircompany.Address,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary,
  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
  irtrainee.OJTPlaced,
  irtrainee.OJTCompleted,
  irtraineeojtplacement.Active,irtraineeojtplacement.ReasonForDropoutOJT,irtraineeojtplacement.Dropout
  from irtraineeojtplacement
  left join irtrainee
  on irtraineeojtplacement.irtraineeID=irtrainee.id
  left join irojtvacancy
  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
  left join coursecategory
  on irojtvacancy.CourseOccupationID=coursecategory.id
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtraineeojtplacement.Deleted=0
  and irtrainee.id='".$traineeid."'
  order by irtraineeojtplacement.id";
  
     $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = IRTrainee::where('id','=',$traineeid)->first();
		  return $v;
	}
	
		   public function IROJTStudentProfileajaxViewData()
    {
       	$searchVal = Input::get('searchVal');
       	$choice = Input::get('choice');

       	//return $searchVal;
       	//return $choice;
    
		
		if ($choice == 'nic')
		{
			//NIC
				
			    $Employee = DB::select(DB::raw("select irtrainee.*,courseyearplan.Year,batch,organisation.OrgaName,district.DistrictName,
				 coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and irtrainee.NIC='".$searchVal."'
"));
			    $dataList = $Employee;
		}
		else 
		{
			//EPF
			
			$Employee = DB::select(DB::raw("select irtrainee.*,courseyearplan.Year,batch,organisation.OrgaName,district.DistrictName,
			 coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and irtrainee.MISNumber='".$searchVal."'
"));
			$dataList = $Employee;
		}
		

       //return $dataList; 

		$html='';
		$c = 1;
		$a = 1;

		if(empty($dataList))
        {
           return 0;
        }

        else
        {			
        	$html.='</br>';
            $html.='<div class="well well-small"><b><center> All Details Matched From Trainee List</center></b></div>';
			//$html.='</br>';

        	$html.='<div id="table" class="row-fluid span20" style="margin: 0px;" overflow="auto">';
			$html.='<table  class="table table-striped table-bordered table-hover">';
			                           
			$html.='<tbody id="table-body">';
			$html.='</tbody>';

            $html.='<thead>';
            $html.='<tr>';
            $html.='<th>#</th>';
			$html.='<th>View Industrial Placement Profile</th>';
			$html.='<th>District</th>';
			$html.='<th>Centre</th>';
			$html.='<th>Year</th>';
			$html.='<th>Batch</th>';
			$html.='<th>Course Name</th>';
			$html.='<th>Course List Code</th>';
			$html.='<th>Course Type</th>';
			$html.='<th>NVQ/Non</th>';
			$html.='<th>NVQ Level</th>';
			$html.='<th>Duration</th>';
			$html.='<th>NIC</th>';
			$html.='<th>MIS Number</th>';
            $html.='<th>Full Name</th>';
			$html.='<th>Name with Initials</th>';
			$html.='</tr>';
            $html.='</thead>';

            foreach ($dataList as $aList)
           	{		

                    $html.='<tr>';
                    $html.='<td>'.$c.'</td>';
                    $html.='<td>
					<form action="IROJTStudentProfileGetStudentData">
					<input type="hidden" name="studentData" value="'.$aList->id.'"/>
					<center>
					<button onclick="viewStudentProfile()" id="stdData" name="stdData" value="'.$aList->id.'" class="btn btn-pink">View</button>
					</center>
					</form>
					</td>';
					 $html.='<td>'.$aList->DistrictName.'</td>';
					 $html.='<td>'.$aList->OrgaName.'</td>';
					  $html.='<td>'.$aList->Year.'</td>';
					   $html.='<td>'.$aList->batch.'</td>';
					   $html.='<td>'.$aList->CourseName.'</td>';
					   $html.='<td>'.$aList->CourseListCode.'</td>';
					   $html.='<td>'.$aList->CourseType.'</td>';
					   $html.='<td>'.$aList->Nvq.'</td>';
					   $html.='<td>'.$aList->CourseLevel.'</td>';
					   $html.='<td>'.$aList->Duration.'</td>';
					    $html.='<td>'.$aList->NIC.'</td>';
					$html.='<td>'.$aList->MISNumber.'</td>';
                    $html.='<td>'.$aList->FullName.'</td>';
					$html.='<td>'.$aList->NameWithInitials.'</td>';
                   
					
                    $html.='</tr>';

                    $c ++;
       		}

            $html.='</table>';
   			$html.='</div>';

            return $html;
                   
        }
    }

  public function IRFilterCourseYearPlans111()
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
  and coursedetails.CourseType ='Full'
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
  and coursedetails.CourseType ='Full'
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
  and organisation.DistrictCode='".$District."'
  and courseyearplan.OrgId='".$CenterID."'
  and courseyearplan.StartedStatus=1
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and coursedetails.CourseType ='Full'
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
  and coursedetails.CourseType ='Full'
  order by coursedetails.CourseName
";
}
	
  
$sql0 = DB::select(DB::raw($sql));
  return json_encode($sql0);
  }
	
	public function UpdateOJTOccupiedcolumn()
	{
		$AllOJTVac = IROJTVacancy::where('Deleted','=',0)->get();
		foreach($AllOJTVac as $m)
		{
			if($m->VacancyType != 'GenderBased')
			{
				//common vacancies
				$Ocvac = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvac
													  from irtraineeojtplacement
													  left join irtrainee
													  on irtraineeojtplacement.irtraineeID=irtrainee.id
													  where irtraineeojtplacement.OJTVacancyID='".$m->id."'
													  and irtraineeojtplacement.Deleted=0
													  and irtraineeojtplacement.Active=1
													  and irtraineeojtplacement.Dropout=0
													  and irtraineeojtplacement.OJTCompletedF=0
													  and irtrainee.OJTCompleted=0"));
				$newdata =  json_decode(json_encode((array)$Ocvac),true);
				$OccuipFemale = $newdata[0]["occupiedvac"];
				
				$UpdateTable = IROJTVacancy::where('id','=',$m->id)->update(array('OccupiedFemaleVacancy' => $OccuipFemale));
				
				//$AvailableVacCommon = ($m->VacancyFemale - $OccuipFemale);
				
			}
			else
			{
				//GenderBased
				
				// 1 Female
				$Ocvac = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvac
											 from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$m->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Female'"));
				$newdataf =  json_decode(json_encode((array)$Ocvac),true);
				$OccuipFemale = $newdataf[0]["occupiedvac"];
				$UpdateTable = IROJTVacancy::where('id','=',$m->id)->update(array('OccupiedFemaleVacancy' => $OccuipFemale));
				
				//2 Male
				
				$OcvacM = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvacm
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$m->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Male'"));
				$newdataM =  json_decode(json_encode((array)$OcvacM),true);
				$OccuipMale = $newdataM[0]["occupiedvacm"];
			    $UpdateTable = IROJTVacancy::where('id','=',$m->id)->update(array('OccupiedMaleVacancy' => $OccuipMale));
				return 'Done';

			}
			
		}
		
	}
	
	public function IRdisLoadajax() {
        $v = Input::get('d_code');

        //return  $v;

        $abc = Electorate::where('DistrictCode', "=", $v)->get();

        //$sql = "select * from electorate where electorate.DistrictCode = '".$org_id."' ";
        //$abc = DB::select(DB::raw($sql));
        //return $abc;

        $aaa = "<select id=\"ElectorateCode\" name=\"ElectorateCode\" required=\"true\" >";
        $aaa .= "<option value=\"\">--- Select DS Division</option>";
		$aaa .= "<option value=\"All\">All</option>";
        foreach ($abc as $abc) {
            $aaa .= "<option value=\"$abc->ElectorateCode\">$abc->ElectorateName</option>";
        }
        $aaa .= "</select>";
        echo $aaa;
    }
	
	public function IRAddDropoutReasonGiveApproval()
	{
		$id = Input::get('id');
		
		$update = IRTrainee::where('id','=',$id)->update(array('Dropout' => 1,'DropApprovedUser' => User::getSysUser()->userID));
		
		return 1;
	}
	
	public function IRAddDropoutReason()
	{
		$id = Input::get('id');
		$ReasonD = Input::get('ReasonD');
		
		$update = IRTrainee::where('id','=',$id)->update(array('DropoutRequested' => 1,'ReasonForDropout' => $ReasonD,'DropoutReqUser' => User::getSysUser()->userID));
		
		return 1;
	}
	
	public function GetOJTAvailableVacancy() {
		
		
     //$CompanyID = Input::get('CourseListCode');
	 $dis = Input::get('District');
	 $elec = Input::get('Electorate');
	 $UserOrgID = User::getSysUser()->organisationId; 
	 $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	 $IRTraineeID = Input::get('traineeid');
     $u = User::getSysUser()->EmpId;
	 $Gender = IRTrainee::where('id','=',$IRTraineeID)->pluck('Gender');
	 $IRTraineeRec = IRTrainee::where('id','=',$IRTraineeID)->first();
	 $CourseYearPlan = CourseYearPlan::where('id','=',$IRTraineeRec->CourseYearPlanID)->first();
	 $CourseDetailRec = Course::where('CD_ID','=',$CourseYearPlan->CD_ID)->first();
	 $Count = 0;
	if($elec == 'All')
	{
		if($OegaType == 'HO')
		{
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.Active=1"));

		}
		 elseif($OegaType == 'DO')
		  {
			  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			  $MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
											  and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		  }
		  elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
		elseif($OegaType == 'PO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											 and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									          and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		}
		else{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
	}
	else
	{
		if($OegaType == 'HO')
		{
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and ircompany.Active=1"));

		}
		 elseif($OegaType == 'DO')
		  {
			  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			  $MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
											  and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		  }
		  elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
		elseif($OegaType == 'PO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											on ircompany.UserCenterID=organisation.id
											left join district as orgdis
											on organisation.DistrictCode=orgdis.DistrictCode
											left join user
											on ircompany.User=user.userID
											left join employee
											on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									          and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		}
		else{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irojtvacancy.id,
											  coursecategory.Category,
											  irojtvacancy.TrainingArea,
											  irojtvacancy.VacancyType,
											  irojtvacancy.VacancyFemale,
											  irojtvacancy.VacancyMale,
											  irojtvacancy.OccupiedFemaleVacancy,
											  irojtvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irojtvacancy
											  left join coursecategory
											  on irojtvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irojtvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irojtvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where irojtvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irojtvacancy.Active=1
											  and irojtvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
	}
    
	  

        //return  $v;
		$aaa="";
$aaa = "<select id=\"VacancyCode\" name=\"VacancyCode\" required=\"true\">";
        $aaa .= "<option value=\"\">---Select Vacancy---</option>";
		

 if(!empty($MOCenterMonitoringPlan))
     {
		 
		 $Count = 1;
		 foreach($MOCenterMonitoringPlan as $m)
                       {
						   if($m->VacancyType != 'GenderBased')
							{
								// common vacancy
								$Ocvac = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvac
													  from irtraineeojtplacement
													  left join irtrainee
													  on irtraineeojtplacement.irtraineeID=irtrainee.id
													  where irtraineeojtplacement.OJTVacancyID='".$m->id."'
													  and irtraineeojtplacement.Deleted=0
													  and irtraineeojtplacement.Active=1
													  and irtraineeojtplacement.Dropout=0
													  and irtraineeojtplacement.OJTCompletedF=0
													  and irtrainee.OJTCompleted=0"));
								$newdata =  json_decode(json_encode((array)$Ocvac),true);
								$OccuipFemale = $newdata[0]["occupiedvac"];
								
								$AvailableVacCommon = ($m->VacancyFemale - $OccuipFemale);
								if($AvailableVacCommon > 0)
								{
									$aaa .= "<option value=\"$m->id\">$m->CompanyName($m->Address) -: $m->Category  (No of vacancy - $AvailableVacCommon) Entered By $m->UserOrganisationName</option>";
								}
							}
							else
							{
								// Genderbased Vacancy
								// if students gender is female
								if($Gender == 'Female' || $Gender == 'female')
								{
									$Ocvac = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvac
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$m->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Female'"));
									$newdata =  json_decode(json_encode((array)$Ocvac),true);
									$OccuipFemale = $newdata[0]["occupiedvac"];
									$AvailableVacFemale = 0;

									$AvailableVacFemale = ($m->VacancyFemale - $OccuipFemale);
									if($AvailableVacFemale > 0)
									{
										//$aaa .= "<option value=\"$m->id\">$m->Category (No of vacancy - $AvailableVacFemale)</option>";
										$aaa .= "<option value=\"$m->id\">$m->CompanyName($m->Address) -: $m->Category  (No of vacancy - $AvailableVacFemale) Entered By $m->UserOrganisationName</option>";


									}

								}
								else
								{
									$OcvacM = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvacm
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$m->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Male'"));
									$newdataM =  json_decode(json_encode((array)$OcvacM),true);
									$OccuipMale = $newdataM[0]["occupiedvacm"];
									$AvailableVacMale = 0;
									
									$AvailableVacMale =($m->VacancyMale - $OccuipMale);
									if($AvailableVacMale > 0)
									{
										//$aaa .= "<option value=\"$m->id\">$m->Category (No of vacancy - $AvailableVacMale)</option>";
										$aaa .= "<option value=\"$m->id\">$m->CompanyName($m->Address) -: $m->Category  (No of vacancy - $AvailableVacMale) Entered By $m->UserOrganisationName</option>";


									}

								}
							}
					   }
	 }
	 else
	 {
		 $Count = 0;
	 }

        
        
        $aaa .= "</select>";
		
		            return json_encode(array("Count" => $Count, "Table" => $aaa));

        //echo $aaa;
    }

	
			public function PrintOJTCompany()
  {
		
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		
		if($OegaType == 'HO')
		{	$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
												organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
                    left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
											organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join organisation
										on ircompany.UserCenterID=organisation.id
										left join district as orgdis
										on organisation.DistrictCode=orgdis.DistrictCode
										left join user
										on ircompany.User=user.userID
										left join employee
										on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
										and organisation.Type not in('NVTI')
									  order by ircompany.CompanyName"));
			
		}
		elseif($OegaType == 'NVTI')
		{
									$UserOrgID = User::getSysUser()->organisationId;
									$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
																	organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'PO')
		{
			 $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
											organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
									  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join province
									  on district.ProvinceCode=province.ProvinceCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join organisation
									  on ircompany.UserCenterID=organisation.id
									  left join district as orgdis
									  on organisation.DistrictCode=orgdis.DistrictCode
									  left join user
									  on ircompany.User=user.userID
									  left join employee
									  on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									  and organisation.Type not in('NVTI')
									  order by ircompany.CompanyName"));
									  
									  
		//2021/9/17
		
		}
		else
		{
			$UserOrgID = User::getSysUser()->organisationId;
				$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
													organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
										from ircompany
										left join trade
										on ircompany.CTradeId=trade.TradeId
										left join district
										on ircompany.DistrictCode=district.DistrictCode
										left join electorate
										on ircompany.DSDivision=electorate.ElectorateCode
										left join organisation
										on ircompany.UserCenterID=organisation.id
										left join district as orgdis
										on organisation.DistrictCode=orgdis.DistrictCode
										left join user
										on ircompany.User=user.userID
										left join employee
										on user.EmpId=employee.id
										where ircompany.Deleted=0
										and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
										order by ircompany.CompanyName"));
		}
			
			
	$trplans = $quorga;
    $i = 1;

     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','Trade of the Company','Company Name','Address','District','DS Division','Tel','Email','Coordinators Name','Coordinators Mobile',
	 'Company Type','Owership','Data Entered District','Data Entered Centre','Data Entered User','Active');
     array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

     	       
			   
			   
			       if($aa->Active == 1)
				   {
					   $Active='Yes';
				   }
				   else{
					   $Active='No';
				   }
					 
			$emp = ' ';	
			$UserNAme = $aa->Initials.$emp.$aa->LastName;	
      array_push($printablearray, array($i,
	  $aa->TradeName,
	  $aa->CompanyName, 
	  $aa->Address, 
	  $aa->DistrictName,$aa->ElectorateName,
	  $aa->TelNo,
	  $aa->Email,$aa->CoordinationOfficerName,$aa->COMobille,
	  $aa->CompanyType,
	  $aa->Ownership,
	  $aa->userdistrict,$aa->UserOrganisationName,$UserNAme,
	  $Active
	 
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('CompanyList');
  }
	
	public function PrintIRJobVacancy()
  {
		
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		$html='';
		if($OegaType == 'HO')
		{
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
										and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									   and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'PO')
		{
			 $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									  and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		else
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									    and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}			
			
	$trplans = $quorga;
    $i = 1;

     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','District','DS Division','Company Name','Address','Trade','Course Category',
	 'Training Area','Salary',
	 'Vacancy Type',
	 'Vacancy (Female)','Vacancy (Male)',
	 'Vacancy (Common)','Total No of Vacancies','Vacancy Placed(Female)',
	 'Vacancy Placed(Male)','Total No of Vacancies Placed','Data Entered District','Data Entered Centre','Data Entered User','Active');
     array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

     	       $pack = '';
			   $com = ',';
			   $exp = '';
			   $emp = '';
			   $a = '';
			   $dod = '.';
			   $fbr = '(';
			   $bbr = ')';
			  
			   $fdates='';
			   $vtype = '';
			   $vfemale = 0;
			   $vmale = 0;
			   $vcommon = 0;
			   $Zero = 0;
			   $TotNoofVac = 0;
			   $OccuipFemale = 0;
			   $OccuipMale = 0;
			   $OccuipTot = 0;
			   if($aa->VacancyType == 'GenderBased')
			   {
				   
				$vtype ='Gender Based Vacancies';
			   }
			   else 
			   {
					$vtype = 'Common Vacancies';
			   }
			   if($aa->VacancyType != 'GenderBased')
			   {
				    $vfemale = 0;
			        $vmale = 0;
				    $vcommon = $aa->VacancyFemale;
			   }
			   else
			   {
				   $vfemale = $aa->VacancyFemale;
			        $vmale = $aa->VacancyMale;
				    $vcommon = 0;
			   }
			   //$TotNoofVac = $vfemale+$vmale+$vcommon;
			   $TotNoofVac = $aa->VacancyFemale+$aa->VacancyMale;
			   
			  $Ocvac = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvac
												  from irtraineejobplacement
												  left join irtrainee
												  on irtraineejobplacement.irtraineeID=irtrainee.id
												  where irtraineejobplacement.JOBPVacancyID='".$aa->id."'
												  and irtraineejobplacement.Deleted=0
												  and irtraineejobplacement.Active=1
												  and irtraineejobplacement.Dropout=0
												  and irtraineejobplacement.OJTCompletedF=0
												  and irtrainee.JobPlaced=1
												  and irtrainee.JobDropout=0
												  and irtrainee.Gender='Female' "));
					    $newdata =  json_decode(json_encode((array)$Ocvac),true);
						$OccuipFemale = $newdata[0]["occupiedvac"];
						
						$OcvacM = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvacm
												  from irtraineejobplacement
												  left join irtrainee
												  on irtraineejobplacement.irtraineeID=irtrainee.id
												  where irtraineejobplacement.JOBPVacancyID='".$aa->id."'
												  and irtraineejobplacement.Deleted=0
												  and irtraineejobplacement.Active=1
												  and irtraineejobplacement.Dropout=0
												  and irtraineejobplacement.OJTCompletedF=0
												  and irtrainee.JobPlaced=1
												  and irtrainee.JobDropout=0
												  and irtrainee.Gender='Male' "));
					    $newdataM =  json_decode(json_encode((array)$OcvacM),true);
						$OccuipMale = $newdataM[0]["occupiedvacm"];
						
					$OccuipTot = $OccuipFemale+	$OccuipMale;
			       if($aa->Active == 1)
				   {
					   $Active='Yes';
				   }
				   else{
					   $Active='No';
				   }
					 
		$space = ' ';		
		$UserName = $aa->Initials.$space.$aa->LastName;		
      array_push($printablearray, array($i,
	  $aa->DistrictName, $aa->ElectorateName, 
	  $aa->CompanyName,$aa->Address,
	  $aa->TradeName,
	  $aa->Category,$aa->TrainingArea,$aa->SalaryGap, 
	  $vtype,$vfemale,$vmale,$vcommon,$TotNoofVac,
	  $OccuipFemale,$OccuipMale,$OccuipTot,
	  $aa->userdistrict,
	  $aa->UserOrganisationName,
	  $UserName,
	  $Active
	 
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('JobPlacementVcancyList');
  }
	
		public function PrintOJTVacancy()
  {
		
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		$html='';
		if($OegaType == 'HO')
		{
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,ircompany.TelNo,ircompany.Email,ircompany.CoordinationOfficerName,
  ircompany.COMobille,ircompany.CompanyType,ircompany.Ownership,
  district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,
									  ircompany.TelNo,ircompany.Email,ircompany.CoordinationOfficerName,
  ircompany.COMobille,ircompany.CompanyType,ircompany.Ownership,
  district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
										and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,ircompany.TelNo,ircompany.Email,ircompany.CoordinationOfficerName,
  ircompany.COMobille,ircompany.CompanyType,ircompany.Ownership,
									  district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		elseif($OegaType == 'PO')
		{
			 $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,ircompany.TelNo,ircompany.Email,ircompany.CoordinationOfficerName,
  ircompany.COMobille,ircompany.CompanyType,ircompany.Ownership,
  district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									  and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		else
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									   ircompany.CompanyName,ircompany.Address,ircompany.TelNo,ircompany.Email,ircompany.CoordinationOfficerName,
  ircompany.COMobille,ircompany.CompanyType,ircompany.Ownership,
  district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		
			
	$trplans = $quorga;
    $i = 1;

     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','District','DS Division','Company Name','Address','Company Tel','Company Email','Coordinator Name','Coordinator Mobile',
	 'Company Type','Ownership',
	 'Trade','Course Category',
	 'Training Area',
	 'Vacancy Type',
	 'Vacancy (Female)','Vacancy (Male)',
	 'Vacancy (Common)','Total No of Vacancies','Vacancy Placed(Female)',
	 'Vacancy Placed(Male)','Total No of Vacancies Placed','Data Entered District','Data Entered Centre','Data Entered User','Active');
     array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

     	       $pack = '';
			   $com = ',';
			   $exp = '';
			   $emp = '';
			   $a = '';
			   $dod = '.';
			   $fbr = '(';
			   $bbr = ')';
			  
			   $fdates='';
			   $vtype = '';
			   $vfemale = 0;
			   $vmale = 0;
			   $vcommon = 0;
			   $Zero = 0;
			   $TotNoofVac = 0;
			   $OccuipFemale = 0;
			   $OccuipMale = 0;
			   $OccuipTot = 0;
			   if($aa->VacancyType == 'GenderBased')
			   {
				   
				$vtype ='Gender Based Vacancies';
			   }
			   else 
			   {
					$vtype = 'Common Vacancies';
			   }
			   if($aa->VacancyType != 'GenderBased')
			   {
				    $vfemale = 0;
			        $vmale = 0;
				    $vcommon = $aa->VacancyFemale;
			   }
			   else
			   {
				   $vfemale = $aa->VacancyFemale;
			        $vmale = $aa->VacancyMale;
				    $vcommon = 0;
			   }
			 // $TotNoofVac = $vfemale+$vmale+$vcommon;
			 $TotNoofVac = $aa->VacancyFemale+$aa->VacancyMale;
			   
			   $Ocvac = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvac
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$aa->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Female'"));
					    $newdata =  json_decode(json_encode((array)$Ocvac),true);
						$OccuipFemale = $newdata[0]["occupiedvac"];
						
						$OcvacM = DB::select(DB::raw("select count(irtraineeojtplacement.id) as occupiedvacm
												  from irtraineeojtplacement
												  left join irtrainee
												  on irtraineeojtplacement.irtraineeID=irtrainee.id
												  where irtraineeojtplacement.OJTVacancyID='".$aa->id."'
												  and irtraineeojtplacement.Deleted=0
												  and irtraineeojtplacement.Active=1
												  and irtraineeojtplacement.Dropout=0
												  and irtraineeojtplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Male'"));
					    $newdataM =  json_decode(json_encode((array)$OcvacM),true);
						$OccuipMale = $newdataM[0]["occupiedvacm"];
						
					$OccuipTot = $OccuipFemale+	$OccuipMale;
			       if($aa->Active == 1)
				   {
					   $Active='Yes';
				   }
				   else{
					   $Active='No';
				   }
	$space = ' ';				 
	$userName = $aa->Initials.$space.$aa->LastName;
				
      array_push($printablearray, array($i,
	  $aa->DistrictName, $aa->ElectorateName, 
	  $aa->CompanyName,$aa->Address,$aa->TelNo,$aa->Email,$aa->CoordinationOfficerName,
	  $aa->COMobille,$aa->CompanyType,$aa->Ownership,
	  $aa->TradeName,
	  $aa->Category,$aa->TrainingArea, 
	  $vtype,$vfemale,$vmale,$vcommon,$TotNoofVac,
	  $OccuipFemale,$OccuipMale,$OccuipTot,
	  $aa->userdistrict,
	  $aa->UserOrganisationName,
	  $userName,
	  $Active
	 
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('OJTVcancyList');
  }
	
		public function DeleteOJTStudentsPOMonitoringHistory()
	  {
                $id = Input::get('id');
                $quorg = IRPOMonitoring::findOrFail($id);
				$quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();				// if not found show 404 page
				
			
					

                return Redirect::to('ViewOJTStudentPOMonitoringHistory');
                
      }
	
	public function ViewOJTStudentPOMonitoringHistory()
	{
		$method = Request::getMethod();
		$v = View::make('OJTPO.StudentHistory');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
       
		
        $v->userOrgId = $userOrgId;
        $v->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $v->user = User::getSysUser();
     

        if ($method == "GET") {
            return $v;
        }
		  if ($method == "POST") {
            $Stype = Input::get('SType');
			$NIC = Input::get('NIC');
			
			if($Stype == 'NIC')
			{
				$GetEmpID = IRTrainee::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('id');
			}
			else
			{
				$GetEmpID = IRTrainee::where('MISNumber','=',$NIC)->where('Deleted','=',0)->pluck('id');
			}
			
										$Sql = "select irpomonitoring.id,
  irtrainee.id as TraineeId,
  irtrainee.NameWithInitials,irtrainee.NIC,
  irtrainee.MISNumber,irtrainee.Mobile,irtrainee.Gender,
  ircompany.CompanyName,ircompany.Address,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary,
  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
  irtrainee.OJTPlaced,
  irtrainee.OJTCompleted,
  irtraineeojtplacement.Active,irtraineeojtplacement.ReasonForDropoutOJT,irtraineeojtplacement.Dropout,
  irpomonitoring.DateVisited,irpomonitoring.TraineeAttendence,irpomonitoring.TraineeSatisfaction,employee.Initials,employee.LastName,Porganisation.OrgaName as porga
  from irpomonitoring
  left join irtraineeojtplacement
  on irpomonitoring.ojtplacementID=irtraineeojtplacement.id
    left join employee
  on irpomonitoring.POEmpId=employee.id
  left join organisation as Porganisation
  on employee.CurrentOrgaID=Porganisation.id
  left join irtrainee
  on irtraineeojtplacement.irtraineeID=irtrainee.id
  left join irojtvacancy
  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
  left join coursecategory
  on irojtvacancy.CourseOccupationID=coursecategory.id
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtraineeojtplacement.Deleted=0
  and irpomonitoring.Deleted=0
  and irtrainee.id='".$GetEmpID."'
  order by irtraineeojtplacement.id

";
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = IRTrainee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
	public function IRGetMonitoringPOList()
	{
		$ID = Input::get('id');//jobPlaceID 
        $sql = "select irpomonitoring.*,employee.Initials,employee.LastName,organisation.OrgaName
  from irpomonitoring
  left join employee
  on irpomonitoring.POEmpId=employee.id
    left join organisation
  on employee.CurrentOrgaID=organisation.id
  where irpomonitoring.Deleted=0
  and irpomonitoring.ojtplacementID='".$ID."'";
  
    $DD = DB::select(DB::raw($sql));
	 
	 return json_encode($DD);
	}
	
		public function IRCreatePOMonitoringData() 
		{
			
       $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
			
			$sql="select usertype.UType
                from usertype
                left join user on
                user.userType=usertype.id
                where user.userID='".User::getSysUser()->userID."'";
          $uType=DB::select(DB::raw($sql));
		
          $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
          $view = View::make('OJTPO.EditOJTStudent');
		  $view->Districts = District::orderBy('DistrictName')->get();
          $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  //return Input::get('edit_id');
		  $TraineeID = IROJTTraineePlacement::where('id','=',Input::get('edit_id'))->pluck('irtraineeID');
		  $record = IRTrainee::where('id','=',$TraineeID)->first();
		  //$OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
		  //$OrgaDistrict = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
		 // $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();
		  $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
		  $OrgaDistrict = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
		  $DistrictName = District::where('DistrictCode','=',$OrgaDistrict)->pluck('DistrictName');
		  $OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
		  $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();
          $CourseName = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->pluck('CourseName');		  
          $IRTrainee1 = IRTrainee::find(Input::get('edit_id'));
		  
		  $view->Centers = Organisation::where('Deleted','=',0)
                ->where('DistrictCode','=',$OrgaDistrict)
				  ->whereNotIn('Type',['HO','DO','PO'])
				  ->where('Active','=','Yes')
				  ->orderBy('OrgaName')
				->get();
			
		$allcourse = DB::select(DB::raw("select courseyearplan.*,
										  coursedetails.CourseName,coursedetails.CourseType,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel
										  from courseyearplan
										  left join coursedetails
										  on courseyearplan.CD_ID=coursedetails.CD_ID
										  where courseyearplan.Deleted=0
										  and courseyearplan.Year='".$CourseYearPlan1->Year."'
										  and courseyearplan.OrgId='".$OrgaID."'
										  and courseyearplan.batch like '$CourseYearPlan1->batch'
										  order by coursedetails.CourseName"
										  ));
         
			$view->IRTrainee=$record;
			$view->ojtplaceID = Input::get('edit_id');
			$view->allcourse = $allcourse;
			$view->CourseYearPlan=$CourseYearPlan1;
			$view->selectedDis = $OrgaDistrict;
			$view->DistrictName = $DistrictName;
			$view->OrganisationName = $OrgaName;
			$view->CourseName = $CourseName;
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
			
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
            
              
                return $view;
	}
                if($method == 'POST')
		{
               
              $OjtPlaceID = Input::get('edit_id');//ojt placement ID
			  $POUserId = User::getSysUser()->userID;
			  $POEmpId = User::getSysUser()->EmpId;
			
				   $d = new IRPOMonitoring();
				   $d->ojtplacementID = $OjtPlaceID;
				   $d->POEmpId = $POEmpId;
				   $d->DateVisited = Input::get('DateVisited');
				   $d->TraineeAttendence = Input::get('Attendence');
				   $d->TraineeSatisfaction = Input::get('Satisfaction');
				   $d->User = $POUserId;
				   $d->save();
				   
				   $year = input::get('YearD');
				   $batch = input::get('BatchD');
					$method="POST";	
				  
                   
		
					
	             //return Redirect::to('ViewMyOJTStudents');
				  return Redirect::to('ViewMyOJTStudents?Year='.$year.'&&Batch='.$batch);
						//return Redirect::back();
                    
                
		
        }
    }
	
	public function DownloadOJTPOMonitoringForm()
	{
    
    $id = Input::get('id');
	$record = IRTrainee::where('id','=',$id)->first();
    $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
    $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
	$OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
	$DistrictCode = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
	$DistrictName = District::where('DistrictCode','=',$DistrictCode)->pluck('DistrictName');
	$CourseDetails = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->first();
	$OjtPlacementrec = IROJTTraineePlacement::where('irtraineeID','=',$record->id)->where('Deleted','=',0)
						->where('Active','=',1)->first();
	$IRCompanyDec = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();

	$html='<html>
	<head>
    </head>
    <body>';
	
	$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr>
		<td style="width:20%"><img src="assets\SLLOGO.png" alt="Smiley face" height="100" width="110"/></td>
		<td style="width:60%"><center><b>Industrial Training Division<br/>Vocational Training Authority of Sri Lanka</b><br/>Industrial Training Monitoring Report</center></td>
		<td style="width:20%"><img src="assets\VTA.jpg" alt="Smiley face" height="100" width="160"/></td>
	</tr>
    </table>
	</center>';
	
	$html.='<br/><u><b>Trainee Details</b></u><br/><br/><center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:25%">&nbsp&nbsp1. Name:</td><td style="width:75%">&nbsp&nbsp'.$record->NameWithInitials.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp2. Centre:</td><td style="width:75%">&nbsp&nbsp'.$OrgaName.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp3. Course Name:</td><td style="width:75%">&nbsp&nbsp'.$CourseDetails->CourseName.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp4. Year & Batch:</td><td style="width:75%">&nbsp&nbsp'.$CourseYearPlan1->Year.' - '.$CourseYearPlan1->batch.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp5. NIC & MIS No:</td><td style="width:75%">&nbsp&nbsp'.$record->NIC.' -  '.$record->MISNumber.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp6. Contact No:</td><td style="width:75%">&nbsp&nbsp'.$record->Mobile.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp7. Address:</td><td style="width:75%">&nbsp&nbsp'.$record->Address.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp8. Gender:</td><td style="width:75%">&nbsp&nbsp'.$record->Gender.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp9. Training Period:</td><td style="width:75%">&nbsp&nbspFrom '.$OjtPlacementrec->StartingDate.' To '.$OjtPlacementrec->EndDate.'</td></tr>
	<tr><td style="width:25%">&nbsp&nbsp10. Organisation Name:</td><td style="width:75%">&nbsp&nbsp'.$IRCompanyDec->CompanyName.'</td></tr>
    <tr><td style="width:25%">&nbsp&nbsp11. Contact Person & Tel:</td><td style="width:75%">&nbsp&nbsp'.$IRCompanyDec->CoordinationOfficerName.' & '.$IRCompanyDec->COMobille.'</td></tr>
    </table></center>';

	$html.='<br/><u><b>Mopnitoring Details</b></u><br/><br/><center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:50%"><center><b><br/>Questionnaire<br/></b><br/></center></td><td style="width:25%"><center><b><br/>1st Visit<br/><br/></b></center></td><td style="width:25%"><center><b><br/>2nd Visit<br/><br/></b></center></td></tr>
	<tr><td style="width:50%">&nbsp&nbspDate of Visit :<br/><br/></td><td style="width:25%"></td><td style="width:25%"></td></tr>
	<tr><td style="width:50%">&nbsp&nbspAttendence (Present/Absent) :<br/><br/></td><td style="width:25%"></td><td style="width:25%"></td></tr>
	<tr><td style="width:50%">
			<table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
				<tr>
						<td style="width:25%">
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
							<tr><td style="width:100%"><center>&nbsp&nbspDaily Diary</center></td></tr>
							</table>
						</td>
						<td style="width:75%">
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
							<tr><td style="width:100%;border-right-style:hidden;border-top-style:hidden">&nbsp&nbspReceived Yes/No :<br/><br/></td></tr>
							<tr><td style="width:100%;border-right-style:hidden;border-bottom-style:hidden">&nbsp&nbspUpdate (To last Friday) Yes/No :<br/><br/></td></tr>
							
							</table>
						</td>
				</tr>
			</table>
		</td>
	<td style="width:25%">
		<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
			<tr><td style="width:100%;border-right-style:hidden;border-top-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
			<tr><td style="width:100%;border-right-style:hidden;border-bottom-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
		</table>
	</td>
	<td style="width:25%">
		<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
			<tr><td style="width:100%;border-right-style:hidden;border-top-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
			<tr><td style="width:100%;border-right-style:hidden;border-bottom-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
		</table>
	</td>
	</tr>
	<tr><td style="width:50%">&nbsp&nbspNo of Leave Taken :<br/><br/></td><td style="width:25%"></td><td style="width:25%"></td>
	</tr>
	
	<tr><td style="width:50%">
			<table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
				<tr>
						<td style="width:25%">
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
							<tr><td style="width:100%"><center>&nbsp&nbspFacility Available</center></td></tr>
							</table>
						</td>
						<td style="width:75%">
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
							<tr><td style="width:80%;border-top-style:hidden">&nbsp&nbspVery Satisfied<br/><br/></td><td style="width:20%;border-right-style:hidden;border-top-style:hidden">&nbsp&nbsp1</td></tr>
							<tr><td style="width:80%">&nbsp&nbspSatisfied<br/><br/></td><td style="width:20%;border-right-style:hidden;">&nbsp&nbsp2</td></tr>
							<tr><td style="width:80%">&nbsp&nbspNeutral<br/><br/></td><td style="width:20%;border-right-style:hidden;">&nbsp&nbsp3</td></tr>
							<tr><td style="width:80%;">&nbsp&nbspDissatisfied<br/><br/></td><td style="width:20%;border-right-style:hidden;">&nbsp&nbsp4</td></tr>
							<tr><td style="width:80%;border-bottom-style:hidden">&nbsp&nbspVery Dissatisfied<br/><br/></td><td style="width:20%;border-right-style:hidden;border-bottom-style:hidden">&nbsp&nbsp5</td></tr>
							
							</table>
						</td>
				</tr>
			</table>
		</td>
	<td style="width:25%">
		<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
			<tr><td style="width:100%;border-right-style:hidden;border-top-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
			<tr><td style="width:100%;border-right-style:hidden;border-bottom-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
		</table>
	</td>
	<td style="width:25%">
		<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
			<tr><td style="width:100%;border-right-style:hidden;border-top-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
			<tr><td style="width:100%;border-right-style:hidden;border-bottom-style:hidden;border-left-style:hidden">&nbsp&nbsp</td></tr>
		</table>
	</td>
	</tr>
	<tr><td style="width:50%">&nbsp&nbspEmployers Comments and Signature :<br/><br/><br/><br/><br/></td><td style="width:25%"></td><td style="width:25%"></td>
	</tr>
	<tr><td style="width:50%">&nbsp&nbspIR Officers Comments and Signature :<br/><br/><br/><br/><br/></td><td style="width:25%"></td><td style="width:25%"></td>
	</tr>
	<tr><td style="width:50%">&nbsp&nbspDD/AD/TO Comments and Signature :<br/><br/><br/><br/><br/></td><td style="width:25%"></td><td style="width:25%"></td>
	</tr>
    </table></center>';	


	
	//second page
	
	
     $html.='</tbody></html>';     
  

  return $html;


  }
	
		public function IRDropoutListPrintPdf()
	{
		
		$CenterID = Input::get('CenterIDD');
		$Year = Input::get('YearD');
		$Batch = Input::get('BatchD');
		$district = Input::get('districtD');
		$CYIP = Input::get('CYIPD');
		if($district == 'All')
		{
			$DistrictName = $district;
		}
		else
		{
        $DistrictName = District::where('DistrictCode','=',$district)->pluck('DistrictName');
		}
		if($CenterID == 'All')
		{
			$CentreNAme = $CenterID;
		}	
		else
		{
			$CentreNAme = Organisation::where('id','=',$CenterID)->pluck('OrgaName');
		}
        		
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		$html='';
		 if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
	and courseyearplan.id='".$CYIP."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
			
	$trplans = DB::select(DB::raw($sql));
		
		$i = 1;
   $html ='<html><head><center><b><h3>Industrial  Relations Division<br/>
   Vocational Training Authority of Sri Lanka<br/>
   District: '.$DistrictName.'  Centre Name: '.$CentreNAme.'<br/>
   Year: '.$Year.' Batch: '.$Batch.'</h3></b></center></head><body>
   <font size="5px" face="Times New Roman" ><table style = "font-size:18px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">District</th>
<th align="center">Centre</th>
<th align="center">Year</th>
<th align="center">Batch</th>
<th align="center">Course</th>
<th align="center">CourseType</th>
<th align="center">NVQ Level</th>
<th align="center">Duration</th>
<th align="center">Medium</th>
<th align="center">Name With Initials</th>
<th align="center">Full Name</th>
<th align="center">NIC</th>
<th align="center">MIS Number</th>
<th align="center">Mobile</th>
<th align="center">Address</th>
<th align="center">Gender</th>
<th align="center">Dropout Status</th>

</thead><tbody>';

foreach ($trplans as $aa ) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->DistrictName.'</td>
          <td>'.$aa->OrgaName.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->batch.'</td>
          <td>'.$aa->CourseName.'</td>
          <td>'.$aa->CourseType.'</td>
		 <td>'.$aa->CourseLevel.'</td>
		  <td>'.$aa->Duration.'</td>
		  <td>'.$aa->Medium.'</td>
		  <td>'.$aa->NameWithInitials.'</td>
		  <td>'.$aa->FullName.'</td>
		  <td>'.$aa->NIC.'</td>
		  <td>'.$aa->MISNumber.'</td>
		  <td>'.$aa->Mobile.'</td>
		  <td>'.$aa->Address.'</td>
		  <td>'.$aa->Gender.'</td>';
		  
		  if($aa->Dropout == 1)
		  {
			  $Drops = 'Yes';
		  }
		  else
		  {
			 $Drops = 'No';
		  }			
		  $html.='<td>'.$Drops.'</td>';
			   
         $html.=' </tr>';
          
  }

  $html.='</tbody></table></font></body></html>';
   return $html;

	}
	
	public function IRloaddistricDSDivision()
	{
		
		$dis = Input::get('District');
	
	  
	    $sql = DB::select(DB::raw("select electorate.*
							  from electorate
							  where electorate.DistrictCode='".$dis."'
							  order by ElectorateName"));
  
 
	  
	  return json_encode($sql);
	}
	
	  public function IRFilterCourseYearPlans1()
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
			  and coursedetails.CourseType ='Full'
			  and coursedetails.CourseLevel in(4,5,6)
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
  and coursedetails.CourseType ='Full'
  and coursedetails.CourseLevel in(4,5,6)
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
  and coursedetails.CourseType ='Full'
  and coursedetails.CourseLevel in(4,5,6)
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
  and coursedetails.CourseType ='Full'
  and coursedetails.CourseLevel in(4,5,6)
  order by coursedetails.CourseName
";
	}
	
  
$sql0 = DB::select(DB::raw($sql));
  return json_encode($sql0);
  }
	
	public function DownloadOJTAgreementEngForm()
	{
    
    $id = Input::get('id');
	$record = IRTrainee::where('id','=',$id)->first();
    $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
    $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
	$OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
	$DistrictCode = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
	$DistrictName = District::where('DistrictCode','=',$DistrictCode)->pluck('DistrictName');
	$CourseDetails = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->first();
	$OjtPlacementrec = IROJTTraineePlacement::where('irtraineeID','=',$record->id)->where('Deleted','=',0)
						->where('Active','=',1)->first();
	$IRCompanyDec = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();

	$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
		<tr>
			<td>';
				$html.='<br/><center>
				<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
				<tr>
					<td style="width:50%">
						<left>
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
									<tr><td style="width:100%"><br/><br/><br/>Vocational Training Authority of Sri Lanka</td></tr>
									<tr><td style="width:100%">No. 344/2</td></tr>
									<tr><td style="width:100%">Nipunatha Piyasa</td></tr>
									<tr><td style="width:100%">Elvitigala Mawatha</td></tr>
									<tr><td style="width:100%">Narahenpita</td></tr>
									<tr><td style="width:100%">Colombo 05</td></tr>
									<tr><td style="width:100%"><br/><br/><br/>Vocational Training Agreement</td></tr>
							</table>
						</left>
					</td>
					<td style="width:50%">
							<table style="width:100%;border-collapse:collapse;font-size:15px;text-align: justify;" border="1" style="">
									<tr><td style="width:100%"> This Agreement is approved under the Sri Lnaka Vocational Training authority Act No 12 of 1995 and is registered in the Training agreement.<br/><br/></td</tr>
							</table>
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
									<tr><td style="width:50%"><left> Registration Number<br/><br/><br/></left></td><td style="width:50%">Date<br/><br/><br/></td></tr>
									<tr><td style="width:50%"><left> Seal<br/><br/><br/><br/><br/><br/></left></td><td style="width:50%">Signature<br/><br/><br/><br/><br/><br/></td></tr>
							</table>
							<table style="width:100%;border-collapse:collapse;font-size:15px;" border="" style="">
									<tr><td style="width:100%"><center>(For Office Use Only)</center></td></tr>
							</table><br/>
					</td>
				</tr>
				</table></center>';
	
				$html.='<table style="width:100%;border-collapse:collapse;" border="0">
							<tr>
								<td><center>
									<table style="width:95%;border-collapse:collapse;" border="0">
										<tr>
											<td style="width:100%">
											<br/>(In terms of Section 4/2/1/G of the Act No 12 of 1995)<br/>
											</td>
										</tr>
										<tr>
											<td style="width:100%;font-size:16px;">
											<br/><b><u>Note on the Training Agreement</u></b><br/><br/>
											</td>
										</tr>
										<tr>
											<td style="width:100%;font-size:15px;text-align: justify;">
											<p>Every employer who intends to employ a trainee for the purpose of providing vocational (industrial) training must enter into a vocational training agreement with the trainee prior to that training and be registered with the Vocational Training Authority of Sri Lanka. . Employers should send a copy of the agreement to the relevant District Office of Vocational Training Center of the Sri 
											Lanka Vocational Training Authority/National Vocational Training Institute.
											</p>
											</td>
										</tr>
										<tr>
											<td style="width:100%">
											<br/><center>Between the training employer and the trainee</center>
											</td>
										</tr>
									</table></center>
								</td>
							</tr>
						</table>';
	
				$html.='<br/><center>
							<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
								<tr>
									<td style="width:50%"><left>
										<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
											<tr><td style="width:100%">Institution:- '.$IRCompanyDec->CompanyName.' <br/><br/><br/><br/></td></tr>
											<tr><td style="width:100%">Address:- '.$IRCompanyDec->Address.'<br/><br/><br/><br/><br/></td></tr>
											<tr><td style="width:100%">Email:- '.$IRCompanyDec->Email.'<br/><br/></td></tr>
											<tr><td style="width:100%">Contact No:- '.$IRCompanyDec->TelNo.'<br/></td></tr>
										</table></left>
									</td>
									<td style="width:50%">
										<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
											<tr><td style="width:100%"><left> Full Name In Sinhala:-<br/><br/><br/></left></td></tr>
											<tr><td style="width:100%"><left> Full Name In English:- '.$record->FullName.'<br/><br/></left></td></tr>
											<tr><td style="width:100%">Address:- '.$record->Address.'<br/><br/><br/</td></tr>
											<tr><td style="width:100%">MIS Number:- '.$record->MISNumber.' <br/><br/></td></tr>
											<tr><td style="width:100%">NIC:- '.$record->NIC.'<br/></td></tr>
											<tr><td style="width:100%">Gender:- '.$record->Gender.'<br/></td></tr>
											<tr><td style="width:100%">Contact No:- '.$record->Mobile.'<br/></td></tr>
										</table>
									</td>
								</tr>
							</table></center>';
				$html.='<table style="width:100%;border-collapse:collapse;" border="0">
							<tr>
								<td><center>
									<table style="width:95%;border-collapse:collapse;" border="0">
										<tr>
											<td style="width:100%;font-size:15px;text-align: justify;">
											<p><br/>The above named employer and trainee should abide by this agreement.<br/><br/>
											<br/>
											<br/>
											<i>A)</i> Months of training under this agreement is ................ months.<br/><br/><br/>
											</p>
											</td>
										</tr>
									</table></center>
								</td>
							</tr>
						</table>';
	
				$html.='<center>
							<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
								<tr>
									<td style="width:5%"></td><td style="width:40%">Start Date:- ..................................</td><td style="width:10%"></td>
									<td style="width:40%">End Date:- ...................................</td><td style="width:5%"></td>
								</tr>
							</table>
						</center>';
	
				$html.='<table style="width:100%;border-collapse:collapse;" border="0">
							<tr>
								<td><center>
									<table style="width:95%;border-collapse:collapse;" border="0">
										<tr>
											<td style="width:100%">
											<br/><center><b><i>Page 1 of 3</i><b/></center>
											</td>
										</tr>
									</table></center>
								</td>
							</tr>
						</table>
			</td>
		</tr>
	</table>
	';
				
				$html.='<table style="width:100%;border-collapse:collapse;page-break-before: always" border="1">
							<tr>
								<td><center>
									<table style="width:95%;border-collapse:collapse;" border="0">
										<tr>
											<td style="width:100%;font-size:15px;text-align: justify;">
											<br/><br/>
											B) Name of the Institute/Company which provides Industrial Training is '.$IRCompanyDec->CompanyName.' and the
											Address is '.$IRCompanyDec->Address.', where the training is provided.
											<br/><br/>
											C) The training period is 40 hours per week.<br/><br/>
											D) The Industrial Training must cover the National Skills Standard and Curriculum of the course for which the trainee is trained during the entire industry training period.<br/><br/>
											E) The training employer would agree to pay a monthly allowence of Rs.................................. to the trainee.<br/><br/>
											
											F) If the training employer is suitably qualified, he or she must provide industrial training or through his/her qualified employees.<br/><br/>
											G) At the beginning of the training, the training employer must provide the trainee with a copy of the training schedule/agenda for the entire training period.<br/><br/>
											H) The training employer shall provide the trainee with training equipment, training aids, tools, training materials and printed materials.<br/><br/>
											I) The trainee should be provided with leave once a month for visiting the institutional(VTA) training centre for the purpose of monitoring and futher two days for attending the pre/final assessments during the entire training period.<br/><br/>
											J) The training employer shall ensure that the trainee participates in all training activities outside the organization specified in the Training agenda/plan.<br/><br/>
											K) The training employer must give the trainee the work that is necessary for the training objectives and to suit the physical ability and capacity of the trainee.<br/><br/>
											L) The training employer must ensure that the trainees skills are developed and that he/she is not subject to physical or moral injury.<br/><br/>
											M) The trainee shall make every effort to achieve the objectives of the training as prescribed by the Training agenda/plan .<br/><br/>
											N) All the tasks assigned by the employer shall be performed by the trainee with due care during the training course.<br/><br/>
											O) The trainee shall comply with all instructions issued by the employer, coach or any other authorized person as part of the training.<br/><br/>
											P) The rules and regulations of the training employer of the organization should be followed by the trainee.<br/><br/>
											Q) The machinery tools and other equipment provided by the employer for the training should be used solely for the purpose of industrial training.<br/><br/>
											R) All records issued for the trainee for training purposes should be kept in proper order and submitted to the employer and authority inspector for regular inspection.<br/><br/>
											S) The trainee must keep the training and trade secrets of the employer.<br/><br/>
											T) In the absence of illness, accidents or other reasons, the trainee should immediately notify the training employer and submit medical certificates if necessary.<br/><br/>
											U) Trainee is entitled for seven sick days per year and 14 casual holidays. Approved leave is proportional to the training period.<br/>
												<center><b><i>Page 2 of 3</i><b/></center>
											</td>
										</tr>
									</table></center>
									
								</td>
							</tr>
						</table>';
						
						$html.='<table style="width:100%;border-collapse:collapse;page-break-before: always" border="1">
							<tr>
								<td><center>
									<table style="width:95%;border-collapse:collapse;" border="0">
										<tr>
											<td style="width:100%;font-size:15px;text-align: justify;">
											<br/>Common:-<br/><br/>
											The Training Employer and the Trainee agree that the following general rules apply during this Agreement.<br/><br/>
											A)	The trainee shall be covered by the provisions of the Workmens Compensation Ordinance and the Factory Provisions Ordinance.<br/><br/>
											B)	The decision of the Chairman of the Vocational Training Authority of Sri Lanka to settle any disputes arising in respect of training between the parties to this Agreement shall be final.<br/><br/>
											C) The trainee shall not be considered a worker as defined under the Industrial Disputes Act.<br/><br/>
										
												
											</td>
										</tr>
									</table></center>
									
									<center>
									<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/><br/><br/><center>......................................................................</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><br/><br/><br/><center>......................................................................</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><center>Training Employer</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><center>Signature of trainee/guardian</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"></td>
											<td style="width:5%"></td>
											<td style="width:45%"></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/><center><br/><br/><br/>Name:- ..............................................................</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><br/><center><br/><br/><br/>Name:- ..............................................................</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/><center><br/><br/>Address:- ..............................................................</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><br/><center><br/><br/>Address:- ..............................................................</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/>(Company Seal)<br/><br/><br/><br/><br/></td>
											<td style="width:5%"></td>
											<td style="width:45%"></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"></td>
											<td style="width:5%"></td>
											<td style="width:45%"><center>20............./................/.................</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><center><br/>Employer Evidence<br/><br/><br/><br/></center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><center><br/>Proof of the trainee<br/><br/><br/><br/></center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/><center>......................................................................</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><br/><center>......................................................................</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><center>Signature</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><center>Signature</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/><center><br/><br/><br/>Name:- ..............................................................</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><br/><center><br/><br/><br/>Name:- ..............................................................</center></td>
											<td style="width:2.5%"></td>
										</tr>
										<tr>
											<td style="width:2.5%"></td>
											<td style="width:45%"><br/><center><br/><br/>Address:- ..............................................................</center></td>
											<td style="width:5%"></td>
											<td style="width:45%"><br/><center><br/><br/>Address:- ..............................................................</center></td>
											<td style="width:2.5%"></td>
										</tr>
									</table>
									</center>
									<br/><br/><br/><br/><br/><br/><center><b><i>Page 3 of 3</i><b/></center>
								</td>
							</tr>
						</table>';

  return $html;


  }
	
	public function DownloadOJTCompletionForm()
	{
    
    $id = Input::get('id');
	$record = IRTrainee::where('id','=',$id)->first();
    $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
    $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
	$OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
	$DistrictCode = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
	$DistrictName = District::where('DistrictCode','=',$DistrictCode)->pluck('DistrictName');
	$CourseDetails = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->first();
	$OjtPlacementrec = IROJTTraineePlacement::where('irtraineeID','=',$record->id)->where('Deleted','=',0)
						->where('Active','=',1)->first();
	$IRCompanyDec = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();

	$html='<html>
	<head>
    </head>
    <body>';
	
	$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:20%"><img src="assets\SLLOGO.png" alt="Smiley face" height="100" width="110"/></td><td style="width:60%"><center><b><h3>Vocational Training Authority of Sri Lanka</h3></b><br/>Industrial Relation Division</center></td><td style="width:20%"><img src="assets\VTA.jpg" alt="Smiley face" height="100" width="160"/></td></tr>
    </table></center>';
	
	$html.='<table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
	<td>
	<center>
	<table style="width:95%;border-collapse:collapse;" border="0">
	<tr>
	<td style="width:100%;font-size:18px;" >
	<hr/>
	<br/>
	<br/>
	Form No:<br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:18px;">
	<center><b><u>Certification of Completion Industrial Training</u></b></center><br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%">
     Deputy/Assistant Director,
	</td>
	</tr>
	<tr>
	<td style="width:100%">
	'.$DistrictName.' District Office,
	</td>
	</tr>
	<tr>
	<td style="width:100%">
	20........../............./..........
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<br/><b><u>Certification of Completion of Industrial Training</u></b><br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	Dear Sir/Madam,<br/><br/>
	</td>
	</tr>
	
	<tr>
	<td style="width:100%;font-size:15px;text-align: justify;">
	<p>I hereby certify that Mr/Ms. '.$record->FullName.' holding '.$record->NIC.' who followed the course '.$CourseDetails->CourseName.' in batch '.$CourseYearPlan1->batch.' 
	of '.$CourseYearPlan1->Year.' at '.$OrgaName.' has successfully completed the Industrial Training at our organization from '.$OjtPlacementrec->StartingDate.' to '.$OjtPlacementrec->EndDate.'. 
	</p><br/><br/><br/><br/><br/><br/><br/><br/>
	</td>
	</tr>
	
	
	
	
	</table></center>';
		$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:10%"></td><td style="width:30%">......................................................</td><td style="width:20%"></td><td style="width:30%">......................................................</td><td style="width:10%"></td></tr>
	<tr><td style="width:10%"></td><td style="width:30%"><center>Signature</center></td><td style="width:20%"></td><td style="width:30%"><center>Date</center></td><td style="width:10%"></td></tr>
	<tr><td style="width:10%"></td><td style="width:30%"><center>(Office Rubber Stamp</center></td><td style="width:20%"></td><td style="width:30%"></td><td style="width:10%"></td></tr>
    </table></center>';


	$html.='</td></tr></table>';
	//second page
	
	
     $html.='</tbody></html>';     
  

  return $html;


  }
	
	public function DownloadOJTVerificationForm()
	{
    
    $id = Input::get('id');
	$record = IRTrainee::where('id','=',$id)->first();
    $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
    $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
	$OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
	$DistrictCode = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
	$DistrictName = District::where('DistrictCode','=',$DistrictCode)->pluck('DistrictName');
	$CourseDetails = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->first();
	$OjtPlacementrec = IROJTTraineePlacement::where('irtraineeID','=',$record->id)->where('Deleted','=',0)
						->where('Active','=',1)->first();
	$IRCompanyDec = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();

	$html='<html>
	<head>
    </head>
    <body>';
	
	$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:20%"><img src="assets\SLLOGO.png" alt="Smiley face" height="100" width="110"/></td><td style="width:60%"><center><b><h3>Vocational Training Authority of Sri Lanka</h3></b><br/>Industrial Relation Division</center></td><td style="width:20%"><img src="assets\VTA.jpg" alt="Smiley face" height="100" width="160"/></td></tr>
    </table></center>';
	
	$html.='<table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
	<td>
	<center>
	<table style="width:95%;border-collapse:collapse;" border="0">
	<tr>
	<td style="width:100%;font-size:18px;" >
	<hr/>
	<br/>
	<br/>
	Form No:<br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:18px;">
	<center><b><u>Industrial Training Verification Form</u></b></center><br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%">
     Deputy/Assistant Director,
	</td>
	</tr>
	<tr>
	<td style="width:100%">
	'.$DistrictName.' District Office,
	</td>
	</tr>
	<tr>
	<td style="width:100%">
	20........../............./..........
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<br/><b><u>Verification of Industrial Training</u></b><br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	Dear Sir/Madam,<br/><br/>
	</td>
	</tr>
	
	<tr>
	<td style="width:100%;font-size:15px;text-align: justify;">
	<p>We are pleased to inform you that Mr/Ms. '.$record->FullName.' of '.$record->NIC.', who followed the course '.$CourseDetails->CourseName.' at '.$OrgaName.' 
	from the batch  '.$CourseYearPlan1->batch.' of '.$CourseYearPlan1->Year.'  has been recruited to our oranisation for Industrial Training for a 
	period of six/nine months commencing from '.$OjtPlacementrec->StartingDate.' to '.$OjtPlacementrec->EndDate.'
	</p>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<p><br/>Industrial Training Organisation/Company details</p>
	</td>
	</tr>
	
	<tr>
	<td style="width:100%;font-size:15px;"><br/>
	1. Coordinating officer of Industrial Training :- '.$IRCompanyDec->CoordinationOfficerName.'<br/>
	2. Telephone No :- '.$IRCompanyDec->COMobille.'<br/>
	3. Email Address :- '.$IRCompanyDec->Email.'<br/>
	<br/><br/><br/><br/>
	</td>
	</tr>
	
	</table></center>';
		$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:10%"></td><td style="width:30%">......................................................</td><td style="width:20%"></td><td style="width:30%">......................................................</td><td style="width:10%"></td></tr>
	<tr><td style="width:10%"></td><td style="width:30%"><center>Signature</center></td><td style="width:20%"></td><td style="width:30%"><center>Date</center></td><td style="width:10%"></td></tr>
	<tr><td style="width:10%"></td><td style="width:30%"><center>(Office Rubber Stamp</center></td><td style="width:20%"></td><td style="width:30%"></td><td style="width:10%"></td></tr>
    </table></center>';


	$html.='</td></tr></table>';
	//second page
	
	
     $html.='</tbody></html>';     
  

  return $html;


  }
	
	public function DownloadOJTPlacementLetter()
	{
    
    $id = Input::get('id');
	$record = IRTrainee::where('id','=',$id)->first();
    $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
    $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
	$OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
	$CourseDetails = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->first();
	$OjtPlacementrec = IROJTTraineePlacement::where('irtraineeID','=',$record->id)->where('Deleted','=',0)
						->where('Active','=',1)->first();
	$IRCompanyDec = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();
	$CaddressFull = $IRCompanyDec->Address;
	$iparr = explode (",", $CaddressFull); 
	$LenCount = count($iparr);
	//$IRcompanyCoOdinator = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();
	//return $LenCount;

	$html='<html>
	
	<head>
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
	<td>
	<center>
	<table style="width:95%;border-collapse:collapse;" border="0">
	<tr>
	<td style="width:100%;font-size:18px;" >
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	
	Date:20......../......./.........<br/><br/>
	</td>
	</tr>';
	
	$html.='<tr>
	<td>
	'.$IRCompanyDec->CoordinationOfficerName.',
	</td>
	</tr>
	<tr>
	<td style="width:100%">
	'.$IRCompanyDec->CompanyName.',
	</td>
	</tr>';
	$e=0;
	for($e=0;$e<$LenCount;$e++)
	{
		if($e == ($LenCount-1))
		{
			$html.='<tr>
	<td style="width:100%">
	'.$iparr[$e].'
	</td>
	</tr>';
		}
		else
		{
			$html.='<tr>
	<td style="width:100%">
	'.$iparr[$e].',
	</td>
	</tr>';
		}
		
	}
	
	
	$html.='<tr>
	<td style="width:100%;font-size:15px;">
	<br/><br/>Dear Sir/Madam,<br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Referring Trainee for industrial Training</u></b><br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;text-align: justify;">
	<p>Vocational Training Authority of Sri Lanka is a statutory body established under the Vocational Training Authority act No 12 of 1995 with the view to providing vocational training to the youth through a network of more than 220 training
	centres spread across the country.It offers skills training programs in more than 18 vocational trade disciplines mainly focussing on the skills and competencies demanded by the Industries.</p>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;text-align: justify;">
	<p><br/>It conducts '.$CourseDetails->CourseName.'(NVQ Level '.$CourseDetails->CourseLevel.') course.It consists of six/twelve/eighteen months in-house training and six/nine months Industrial Training period. '.$record->FullName.' ('.$record->NIC.') has followed above course which was conducted from '.$CourseYearPlan1->RealstartDate.' 
	to '.$CourseYearPlan1->RealEndDate.' at '.$OrgaName.'. We wish to attach him/her as an Industrial Trainee at your prestigious organisation to get hands on experience on above mentioned trade area.</p>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<p><br/>We expect following skills to be developed from the trainees during the Industrial training period at your place.</p>
	</td>
	</tr>
	
	<tr>
	<td style="width:100%;font-size:15px;"><br/>
	1. Task Performances,task management controlling,unexpected situations,trouble shooting.<br/>
	2. Better exposure to the working evvironment and job category.<br/>
	3. Shifting skills(adaptaion for the modern thchnology and machines).<br/>
	4. Upgrading soft skills (public relationship).<br/>
	5. Upgrading other skills of trainees.<br/><br/>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;text-align: justify;">
	<p>The minimum Industrial Training requirement for the final examination is six/nine months in your organisation.It is very much appreciated if you could pay a reasonable amount for this trainee as a 
	monthly stipend since he/she will directly involve in the process of services provided in your organisation.
	</p>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;text-align: justify;">
	<p><br/>It is also requested to grant leave on the first wednesday of every month to report our institute with his/her attendance of the previous month.This is essential for us to discuss about their training 
	in your organisation.
	</p>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<p><br/>Your early attention is greatly appreciated and we are very mush grateful to you in regard.</p>
	</td>
	</tr>

	<tr>
	<td style="width:100%;font-size:15px;">
	<br/><br/>Thank You.
	</td>
	</tr>
	
	<tr>
	<td style="width:100%;font-size:15px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<br/><br/>..........................................
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	Deputy/Assistant Director
	</td>
	</tr>
	</table></center>';
	


	$html.='</td></tr></table>';
	//second page
	
	
     $html.='</tbody></html>';     
  

  return $html;


  }
	
	public function DownloadOJTAttendeceSheet()
	{
    
    $id = Input::get('id');
	$record = IRTrainee::where('id','=',$id)->first();
    $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
    $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
	$OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
	$CourseDetails = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->first();
	$OjtPlacementrec = IROJTTraineePlacement::where('irtraineeID','=',$record->id)->where('Deleted','=',0)
						->where('Active','=',1)->first();
	$IRCompanyDec = IRCompany::where('id','=',$OjtPlacementrec->CompanyID)->first();

	$html='<html>
	
	<head>
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	<center>
	<table style="width:95%;border-collapse:collapse;" border="0">
	<tr>
	<td style="width:100%;font-size:18px;" >
	<center><b>Industrial Training Attendence Sheet</b></center>
	</td>
	</tr>
	
	<tr>
	<td style="width:100%">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<center>No:354,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:25%">1. Student Name:</td><td style="width:75%">'.$record->NameWithInitials.'</td></tr>
	<tr><td style="width:25%">2. Centre:</td><td style="width:75%">'.$OrgaName.'</td></tr>
	<tr><td style="width:25%">3. Course Name:</td><td style="width:75%">'.$CourseDetails->CourseName.'</td></tr>
	<tr><td style="width:25%">4. Year:</td><td style="width:75%">'.$CourseYearPlan1->Year.'</td></tr>
	<tr><td style="width:25%">5. Batch:</td><td style="width:75%">'.$CourseYearPlan1->batch.'</td></tr>
	<tr><td style="width:25%">6. Training Period:</td><td style="width:75%">From '.$OjtPlacementrec->StartingDate.' To '.$OjtPlacementrec->EndDate.'</td></tr>
	<tr><td style="width:25%">7. Student Address:</td><td style="width:75%">'.$record->Address.'</td></tr>
	<tr><td style="width:25%"></td><td style="width:75%"></td></tr>
	</table></center>';
	
	
	
	
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;;align:center" border="1" style="">
	<tr>
	<td style="width:2%"><Center>No</center></td>
	<td style="width:10%"><Center>Month</center></td>
	<td style="width:2%"><Center>1</center></td>
	<td style="width:2%"><Center>2</center></td>
	<td style="width:2%"><Center>3</center></td>
	<td style="width:2%"><Center>4</center></td>
	<td style="width:2%"><Center>5</center></td>
	<td style="width:2%"><Center>6</center></td>
	<td style="width:2%"><Center>7</center></td>
	<td style="width:2%"><Center>8</center></td>
	<td style="width:2%"><Center>9</center></td>
	<td style="width:2%"><Center>10</center></td>
	<td style="width:2%"><Center>11</center></td>
	<td style="width:2%"><Center>12</center></td>
	<td style="width:2%"><Center>13</center></td>
	<td style="width:2%"><Center>14</center></td>
	<td style="width:2%"><Center>15</center></td>
	<td style="width:2%"><Center>16</center></td>
	<td style="width:2%"><Center>17</center></td>
	<td style="width:2%"><Center>18</center></td>
	<td style="width:2%"><Center>19</center></td>
	<td style="width:2%"><Center>20</center></td>
	<td style="width:2%"><Center>21</center></td>
	<td style="width:2%"><Center>22</center></td>
	<td style="width:2%"><Center>23</center></td>
	<td style="width:2%"><Center>24</center></td>
	<td style="width:2%"><Center>25</center></td>
	<td style="width:2%"><Center>26</center></td>
	<td style="width:2%"><Center>27</center></td>
	<td style="width:2%"><Center>28</center></td>
	<td style="width:2%"><Center>29</center></td>
	<td style="width:2%"><Center>30</center></td>
	<td style="width:2%"><Center>31</center></td>
	<td style="width:5%"><Center>No of Days</center></td>
	<td style="width:11%"><Center>Payment</center></td>
	<td style="width:10%"><Center>Amount</center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>1</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>2</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>3</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>4</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>5</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>6</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:2%"><Center>7</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:2%"><Center></center></td>
	<td style="width:5%"><Center></center></td>
	<td style="width:11%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	</tr>
	
	</table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;align:center" border="0" style="">
	<tr><br/><td style="width:95%"><b>Industrial Training Placement Details:</b></td></tr>
	</table></center>';
	$html.='<center>
	<table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:25%">Name of the Company:</td><td style="width:75%">'.$IRCompanyDec->CompanyName.'</td></tr>
	<tr><td style="width:25%">Address:</td><td style="width:75%">'.$IRCompanyDec->Address.'</td></tr>
	<tr><td style="width:25%">Tel No:</td><td style="width:75%">'.$IRCompanyDec->TelNo.'</td></tr>
	</table></center>';


	$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;align:center" border="0" style="">
	<tr><br/><td style="width:95%"><b>I Certify that the above attendence details are correct.<br/>
	<br/>
	Name of the Supervisor: <br/><br/>
	Designation: <br/><br/>
	Signature: <br/><br/>
	Stamp: </b></td></tr>
	</table></center>';



	$html.='</td></tr></table>';
	//second page
	
	
     $html.='</tbody></html>';     
  

  return $html;


  }
	
	
		public function ViewOJTStudentsDocumentList() 
		{
			
       $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
			
			$sql="select usertype.UType
                from usertype
                left join user on
                user.userType=usertype.id
                where user.userID='".User::getSysUser()->userID."'";
          $uType=DB::select(DB::raw($sql));
		
          $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
          $view = View::make('OJTStudentDoc.EditOJTStudent');
		  //$view->Districts = District::orderBy('DistrictName')->get();
          $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  $record = IRTrainee::where('id','=',Input::get('edit_id'))->first();
          $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
          $IRTrainee1 = IRTrainee::find(Input::get('edit_id'));
		  $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
		  $OrgaDistrict = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
		  $view->Centers = Organisation::where('Deleted','=',0)
                ->where('DistrictCode','=',$OrgaDistrict)
				  ->whereNotIn('Type',['HO','DO','PO'])
				  ->where('Active','=','Yes')
				  ->orderBy('OrgaName')
				->get();
			 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
			$allcourse = DB::select(DB::raw("select courseyearplan.*,
										  coursedetails.CourseName,coursedetails.CourseType,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel
										  from courseyearplan
										  left join coursedetails
										  on courseyearplan.CD_ID=coursedetails.CD_ID
										  where courseyearplan.Deleted=0
										  and courseyearplan.Year='".$CourseYearPlan1->Year."'
										  and courseyearplan.OrgId='".$OrgaID."'
										  and courseyearplan.batch like '$CourseYearPlan1->batch'
										  order by coursedetails.CourseName"
										  ));
         
			$view->IRTrainee=$record;
			$view->allcourse = $allcourse;
			$view->CourseYearPlan=$CourseYearPlan1;
			$view->selectedDis = $OrgaDistrict;
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
			
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
            
              
                return $view;
		}
                if($method == 'POST')
		{
               
              $IRTraineeID = Input::get('edit_id');
             
				   $updateArray = IRTrainee::where('id','=',Input::get('edit_id'))
				   ->update(array('CourseYearPlanID' => Input::get('CourseYearPlanID'),
				   'FullName' => Input::get('FullName'),
				   'NameWithInitials' => Input::get('NameWithInitials'),
				   'NIC' =>Input::get('NIC'),
				   'MISNumber' => Input::get('MISNumber'),
				   'Mobile' => Input::get('Mobile'),
				   'Address' => Input::get('Address'),
				   'Gender' => Input::get('Gender'),
				   'Dropout' => Input::get('Dropout')));
                   
					
					
					$view = View::make('OJTStudents.ViewOJTStudents');
					 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
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
		$sql = "select organisation.* 
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
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id

  ";
		}
		else
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id

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
                    
                
		
        }
    }
	
	  public function ViewOJTStudentsDoc()
	{
		$method = Request::getMethod();
    $view = View::make('OJTStudentDoc.ViewOJTPlacedStudents');
    //$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
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
		$sql = "select organisation.* 
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
$view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');

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
		$CYIP = Input::get('CourseYearPlanID');

		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
		 if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
                       irtraineeojtplacement.id as ojtplaceiD,
					   district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
                      ircompany.CompanyName,
                      ircompany.Address as CAddress,
                      coursecategory.Category,
                      irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
                      left join irtrainee
                      on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
                      and irtraineeojtplacement.Active=1
					  order by irtrainee.MISNumber";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
						and organisation.DistrictCode='".$district."'
						and irtraineeojtplacement.Active=1
					  order by irtrainee.MISNumber
  ";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = " select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and courseyearplan.Year='".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  and organisation.DistrictCode='".$district."'
					  and organisation.id='".$CenterID."'
					  and irtraineeojtplacement.Active=1
					  order by irtrainee.MISNumber";
		}
		else
		{
			 $sql = " select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and courseyearplan.Year='".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  and organisation.DistrictCode='".$district."'
					  and organisation.id='".$CenterID."'
					  and courseyearplan.id='".$CYIP."'
					  and irtraineeojtplacement.Active=1
					  order by irtrainee.MISNumber";
		}
		
	$trplans = DB::select(DB::raw($sql));
	$view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
        return $view;
    }
	
	}
	 public function DownloadJOBPDistrictWiseCountReportExcel()
  {
    $Year = Input::get('Year');
	$Batch = Input::get('Batch');
   
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Registered','Dropout','Target','OJT Completed Target','No of OJT Placed(Local)','No of OJT Placed(Foreign)','No of OJT Placed(Total)','No of Job Placed(Gov)','No of Job Placed(Semi - Gov)','No of Job Placed(Private)','No of Job Placed(NGO)','No of Job Placed(Self)','No of Job Placed(Other)','No of Job Placed(Total)');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
      if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			
			
			
$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$Government = 0;
$SemiGovernment =0;
$Private = 0;
$NGO = 0;
$Self = 0;
$Other = 0;
$TotalOwnership = 0;
$registered = 0;
$dropout = 0;
$OJTCompleted = 0;

                foreach($total_rec as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName);
               
			   // array_push($data_row, $Data->GradeAmin);
				array_push($data_row, $Data->Registered);
			   array_push($data_row, $Data->Dropout);
				array_push($data_row, $Data->target);
				array_push($data_row, $Data->OJTcompleted);
			   // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Data->LocalTot);
			  //  array_push($data_row, $Data->GradeCmin);
			  array_push($data_row, $Data->ForeignTot);
			  
			  $TotLocFo = $Data->LocalTot+ $Data->ForeignTot;
			   array_push($data_row, $TotLocFo);
			   
			   array_push($data_row, $Data->Government);
			   array_push($data_row, $Data->SemiGovernment);
			   array_push($data_row, $Data->Private1);
			   array_push($data_row, $Data->NGO);
			   array_push($data_row, $Data->Self);
			   array_push($data_row, $Data->Other);
			  
			   $TotOwner = $Data->Government+$Data->SemiGovernment+$Data->Private1+$Data->NGO+$Data->Self+$Data->Other;
			   array_push($data_row, $TotOwner);
			   array_push($printablearray, $data_row);
				
							$target = $target + $Data->target;
							$Local = $Local + $Data->LocalTot;
							$Foreign = $Foreign + $Data->ForeignTot;
							$Total = $Total + $TotLocFo ;
							$Government = $Government + $Data->Government;
							$SemiGovernment = $SemiGovernment + $Data->SemiGovernment;
							$Private = $Private + $Data->Private1;
							$NGO = $NGO + $Data->NGO;
 							$Self = $Self + $Data->Self;
                            $Other = $Other + $Data->Other;
							$TotalOwnership = $TotalOwnership + $TotOwner;
                            $registered = $registered + $Data->Registered;
							$dropout = $dropout + $Data->Dropout;
							$OJTCompleted = $OJTCompleted + $Data->OJTcompleted;
                }
				
				
				$data_row = array();
				array_push($data_row, $i++);
				array_push($data_row, ' ');
                array_push($data_row, 'Total');
               
			    
				array_push($data_row, $registered);
				array_push($data_row, $dropout);
				array_push($data_row, $target);
				array_push($data_row, $OJTCompleted);
			    // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Local);
			    //  array_push($data_row, $Data->GradeCmin);
			    array_push($data_row, $Foreign);
				array_push($data_row, $Total);
			    array_push($data_row, $Government);
				 array_push($data_row, $SemiGovernment);
				 array_push($data_row, $Private);
				 array_push($data_row, $NGO);
				 array_push($data_row, $Self);
				 array_push($data_row, $Other);
				 array_push($data_row, $TotalOwnership);
               
                array_push($printablearray, $data_row);


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseWiseJOBPCountReport' . date('Y-m-d'));
            
  }
	
		public function LoadJOBPDistrictWiseCountReport()
	{
		
		$Batch = Input::get('Batch');
		
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $Year . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Job Placement Count Report<pre><h5> Year:'.$Year.' Batch '.$Batch.'</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th  class="center" rowspan="2">District/NVTI Name</th>
                            <th  class="center" rowspan="2">Centre</th>
							<th align="center" class="center" rowspan="2">Registered</th>
							<th align="center" class="center" rowspan="2">Dropout</th>
							<th align="center" class="center" rowspan="2"> Total Target</th>
							<th align="center" class="center" rowspan="2"> OJT Completed Target</th>
							<th align="center" class="center" colspan="3">No Of OJT Placements</th>
							<th align="center" class="center" colspan="7">No Of OJT Placements</th>
						</tr>
						  <tr align="center">
						  <th align="center" class="center">Local</th>
						  <th align="center" class="center">Foreign</th>
						  <th align="center" class="center">Total</th>
						  
						  <th align="center" class="center">Government</th>
						 <th align="center" class="center">Semi Government</th>
						 <th align="center" class="center">Private</th>
						 <th align="center" class="center">NGO</th>
						 <th align="center" class="center">Self</th>
						 <th align="center" class="center">Other</th>
						 <th align="center" class="center">Total</th>
						 
						</tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";

  
 
}

$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$Government = 0;
$SemiGovernment =0;
$Private = 0;
$NGO = 0;
$Self = 0;
$Other = 0;
$TotalOwnership = 0;
$registered = 0;
$dropout = 0;
$OJTCompleted = 0;

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			

			   foreach($total_rec as $ps) {
				   $TotLocFo =0;
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="left">'.$ps->OrgaName.'</td>
							
							<td class="center">'.$ps->Registered.'</td>
							<td class="center">'.$ps->Dropout.'</td>
							<td class="center">'.$ps->target.'</td>
							<td class="center">'.$ps->OJTcompleted.'</td>
							<td class="center">'.$ps->LocalTot.'</td>
							<td class="center">'.$ps->ForeignTot.'</td>';
							
							$TotLocFo = $ps->LocalTot+ $ps->ForeignTot;
							$html.='<td class="center">'.$TotLocFo.'</td>
							<td class="center">'.$ps->Government.'</td>
							<td class="center">'.$ps->SemiGovernment.'</td>
							<td class="center">'.$ps->Private1.'</td>
							<td class="center">'.$ps->NGO.'</td>
							<td class="center">'.$ps->Self.'</td>
							<td class="center">'.$ps->Other.'</td>';
							$TotOwner = $ps->Government+$ps->SemiGovernment+$ps->Private1+$ps->NGO+$ps->Self+$ps->Other;
							$html.='<td class="center">'.$TotOwner.'</td>';
			
							
                            $html.='<tr>';
							
							$target = $target + $ps->target;
							$Local = $Local + $ps->LocalTot;
							$Foreign = $Foreign + $ps->ForeignTot;
							$Total = $Total + $TotLocFo ;
							$Government = $Government + $ps->Government;
							$SemiGovernment = $SemiGovernment + $ps->SemiGovernment;
							$Private = $Private + $ps->Private1;
							$NGO = $NGO + $ps->NGO;
 							$Self = $Self + $ps->Self;
                            $Other = $Other + $ps->Other;
							$TotalOwnership = $TotalOwnership + $TotOwner;
							$registered = $registered + $ps->Registered;
							$dropout = $dropout + $ps->Dropout;
							$OJTCompleted = $OJTCompleted + $ps->OJTcompleted;
							
 							
                            
                }
				
				
				 $html .='<tr>
                            <td class="center"></td>
                            <td class="left">Total</td>
                            <td class="center"></td>
							<td class="center">'.$registered.'</td>
							<td class="center">'.$dropout.'</td>
							<td class="center">'.$target.'</td>
							<td class="center">'.$OJTCompleted.'</td>
							<td class="center">'.$Local.'</td>
							<td class="center">'.$Foreign.'</td>
							<td class="center">'.$Total.'</td>
							
							<td class="center">'.$Government.'</td>
							<td class="center">'.$SemiGovernment.'</td>
							<td class="center">'.$Private.'</td>
							<td class="center">'.$NGO.'</td>
							<td class="center">'.$Self.'</td>
							<td class="center">'.$Other.'</td>
							<td class="center">'.$TotalOwnership.'</td>';
							
			
							
                            $html.='<tr>';
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	
	
			public function ViewJOBPDistrictWiseCountReport()
	{
		$method = Request::getMethod();
    $view = View::make('OTJOBPReports.ViewDistrictWisePlacementCount');
     $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
   // $view->District = District::orderBy('DistrictName')->get();
    
   
        return $view;
    
	}
	
	 public function DownloadJOBPCourseWiseCountReportExcel()
  {
    $Year = Input::get('Year');
	$Batch = Input::get('Batch');
   
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Course','CourseLevel','Duration','Year','Batch','Registered','Dropout','Target','OJT Completed Target','No of Job Placed(Local)','No of Job Placed(Foreign)','No of Job Placed(Total)','No of Job Placed(Gov)','No of Job Placed(Semi - Gov)','No of Job Placed(Private)','No of Job Placed(NGO)','No of Job Placed(Self)','No of Job Placed(Other)','No of Job Placed(Total)');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
    if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineejobplacement
  on irtrainee.id=irtraineejobplacement.irtraineeID
  and irtraineejobplacement.Active='1'
  left join ircompany
  on irtraineejobplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
 
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineejobplacement
  on irtrainee.id=irtraineejobplacement.irtraineeID
  and irtraineejobplacement.Active='1'
  left join ircompany
  on irtraineejobplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
   and courseyearplan.batch like '$Batch%'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
 
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName
  
";

  
 
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			
			
			
$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$Government = 0;
$SemiGovernment =0;
$Private = 0;
$NGO = 0;
$Self = 0;
$Other = 0;
$TotalOwnership = 0;
$registered = 0;
$dropout = 0;
$OJTCompleted = 0;

                foreach($total_rec as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName);
                array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				array_push($data_row, $Data->Year);
				array_push($data_row, $Data->batch);
			   // array_push($data_row, $Data->GradeAmin);
			   array_push($data_row, $Data->Registered);
			   array_push($data_row, $Data->Dropout);
				array_push($data_row, $Data->target);
				array_push($data_row, $Data->OJTcompleted);
			   // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Data->LocalTot);
			  //  array_push($data_row, $Data->GradeCmin);
			  array_push($data_row, $Data->ForeignTot);
			  
			  $TotLocFo = $Data->LocalTot+ $Data->ForeignTot;
			   array_push($data_row, $TotLocFo);
			   array_push($data_row, $Data->Government);
			   array_push($data_row, $Data->SemiGovernment);
			   array_push($data_row, $Data->Private1);
			   array_push($data_row, $Data->NGO);
			   array_push($data_row, $Data->Self);
			   array_push($data_row, $Data->Other);
			  
			   $TotOwner = $Data->Government+$Data->SemiGovernment+$Data->Private1+$Data->NGO+$Data->Self+$Data->Other;
			   array_push($data_row, $TotOwner);
                 
                array_push($printablearray, $data_row);
				
							$target = $target + $Data->target;
							$Local = $Local + $Data->LocalTot;
							$Foreign = $Foreign + $Data->ForeignTot;
							$Total = $Total + $TotLocFo ;
							$Government = $Government + $Data->Government;
							$SemiGovernment = $SemiGovernment + $Data->SemiGovernment;
							$Private = $Private + $Data->Private1;
							$NGO = $NGO + $Data->NGO;
 							$Self = $Self + $Data->Self;
                            $Other = $Other + $Data->Other;
							$TotalOwnership = $TotalOwnership + $TotOwner;
                            $registered = $registered + $Data->Registered;
							$dropout = $dropout + $Data->Dropout;
							$OJTCompleted = $OJTCompleted + $Data->OJTcompleted;
                }
				
				
				$data_row = array();
				array_push($data_row, $i++);
				array_push($data_row, ' ');
                array_push($data_row, 'Total');
                array_push($data_row, ' ');
				array_push($data_row, ' ');
				array_push($data_row, ' ');
				array_push($data_row, ' ');
				array_push($data_row, ' ');
			    array_push($data_row, $registered);
				array_push($data_row, $dropout);
				array_push($data_row, $target);
				array_push($data_row, $OJTCompleted);
			    // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Local);
			    //  array_push($data_row, $Data->GradeCmin);
			    array_push($data_row, $Foreign);
				 array_push($data_row, $Total);
				 array_push($data_row, $Government);
				 array_push($data_row, $SemiGovernment);
				 array_push($data_row, $Private);
				 array_push($data_row, $NGO);
				 array_push($data_row, $Self);
				 array_push($data_row, $Other);
				 array_push($data_row, $TotalOwnership);
			
               
                array_push($printablearray, $data_row);


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CourseWiseWiseJOBPCountReport' . date('Y-m-d'));
            
  }
	
		public function LoadJOBPCourseWiseCountReport()
	{
		
		$Batch = Input::get('Batch');
		
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $Year . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>Course Wise Job Placement Count Report<pre><h5> Year:'.$Year.' Batch '.$Batch.'</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th align="center" class="center" rowspan="2">District/NVTI Name</th>
                            <th align="center" class="center" rowspan="2">Centre</th>
							<th align="center" class="center" rowspan="2">Course</th>
							<th align="center" class="center" rowspan="2">Course Level</th>
							<th align="center" class="center" rowspan="2">Duration</th>
							<th align="center" class="center" rowspan="2">Year</th>
							<th align="center" class="center" rowspan="2">Batch</th>
							<th align="center" class="center" rowspan="2">Registered</th>
							<th align="center" class="center" rowspan="2">Dropout</th>
							<th align="center" class="center" rowspan="2"> Total Target</th>
							<th align="center" class="center" rowspan="2"> OJT Completed Target</th>
							<th align="center" class="center" colspan="3">No Of Job Placements(L/F)</th>
							<th align="center" class="center" colspan="7">No Of Job Placements(Ownership)</th>
						</tr>
						 <tr align="center">
						 <th align="center" class="center">Local</th>
						 <th align="center" class="center">Foreign</th>
						 <th align="center" class="center">Total</th>
						 
						 <th align="center" class="center">Government</th>
						 <th align="center" class="center">Semi Government</th>
						 <th align="center" class="center">Private</th>
						 <th align="center" class="center">NGO</th>
						 <th align="center" class="center">Self</th>
						 <th align="center" class="center">Other</th>
						 <th align="center" class="center">Total</th>
						 
						 
						  
						  
						  </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineejobplacement
  on irtrainee.id=irtraineejobplacement.irtraineeID
  and irtraineejobplacement.Active='1'
  left join ircompany
  on irtraineejobplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
 
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType='Local')
             THEN
            1
        ELSE 0
    END) LocalTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.CompanyType!='Local')
             THEN
            1
        ELSE 0
    END) ForeignTot,
SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Government')
             THEN
            1
        ELSE 0
    END) Government,
  SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='SemiGovernment')
             THEN
            1
        ELSE 0
    END) SemiGovernment,
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Private')
             THEN
            1
        ELSE 0
    END) Private1,
  
    SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='NGO')
             THEN
            1
        ELSE 0
    END) NGO,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Self')
             THEN
            1
        ELSE 0
    END) Self,
   SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.JobPlaced=1 and ircompany.Ownership='Other')
             THEN
            1
        ELSE 0
    END) Other
  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineejobplacement
  on irtrainee.id=irtraineejobplacement.irtraineeID
  and irtraineejobplacement.Active='1'
  left join ircompany
  on irtraineejobplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
   and courseyearplan.batch like '$Batch%'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
 
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName
  
";

  
 
}

$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$Government = 0;
$SemiGovernment =0;
$Private = 0;
$NGO = 0;
$Self = 0;
$Other = 0;
$TotalOwnership = 0;
$registered = 0;
$dropout = 0;
$OJTCompleted = 0;


           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			

			   foreach($total_rec as $ps) {
				   $TotLocFo =0;
				   $TotOwner = 0;
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->OrgaName.'</td>
							<td class="center">'.$ps->CourseName.'</td>
							<td class="center">'.$ps->CourseLevel.'</td>
							<td class="center">'.$ps->Duration.'</td>
							<td class="center">'.$ps->Year.'</td>
							
							<td class="center">'.$ps->batch.'</td>
							<td class="center">'.$ps->Registered.'</td>
							<td class="center">'.$ps->Dropout.'</td>
							<td class="center">'.$ps->target.'</td>
							<td class="center">'.$ps->OJTcompleted.'</td>
							<td class="center">'.$ps->LocalTot.'</td>
							<td class="center">'.$ps->ForeignTot.'</td>';
							
							$TotLocFo = $ps->LocalTot+ $ps->ForeignTot;
							$html.='<td class="center">'.$TotLocFo.'</td>
							
							<td class="center">'.$ps->Government.'</td>
							<td class="center">'.$ps->SemiGovernment.'</td>
							<td class="center">'.$ps->Private1.'</td>
							<td class="center">'.$ps->NGO.'</td>
							<td class="center">'.$ps->Self.'</td>
							<td class="center">'.$ps->Other.'</td>';
							$TotOwner = $ps->Government+$ps->SemiGovernment+$ps->Private1+$ps->NGO+$ps->Self+$ps->Other;
							$html.='<td class="center">'.$TotOwner.'</td>';
							
                            $html.='<tr>';
							
							$target = $target + $ps->target;
							$Local = $Local + $ps->LocalTot;
							$Foreign = $Foreign + $ps->ForeignTot;
							$Total = $Total + $TotLocFo ;
							$Government = $Government + $ps->Government;
							$SemiGovernment = $SemiGovernment + $ps->SemiGovernment;
							$Private = $Private + $ps->Private1;
							$NGO = $NGO + $ps->NGO;
 							$Self = $Self + $ps->Self;
                            $Other = $Other + $ps->Other;
							$TotalOwnership = $TotalOwnership + $TotOwner;
							$registered = $registered + $ps->Registered;
							$dropout = $dropout + $ps->Dropout;
							$OJTCompleted = $OJTCompleted + $ps->OJTcompleted;
                }
				
				
				 $html .='<tr>
                            <td class="center"></td>
                            <td class="left">Total</td>
                            <td class="center"></td>
							<td class="center"></td>
							<td class="center"></td>
						    <td class="center"></td>
						    <td class="center"></td>
							<td class="center"></td>
							<td class="center">'.$registered.'</td>
							<td class="center">'.$dropout.'</td>
							<td class="center">'.$target.'</td>
							<td class="center">'.$OJTCompleted.'</td>
							<td class="center">'.$Local.'</td>
							<td class="center">'.$Foreign.'</td>
							<td class="center">'.$Total.'</td>
							
							<td class="center">'.$Government.'</td>
							<td class="center">'.$SemiGovernment.'</td>
							<td class="center">'.$Private.'</td>
							<td class="center">'.$NGO.'</td>
							<td class="center">'.$Self.'</td>
							<td class="center">'.$Other.'</td>
							<td class="center">'.$TotalOwnership.'</td>';
							
			
							
                            $html.='<tr>';
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
		public function ViewJOBPCourseWiseCountReport()
	{
		$method = Request::getMethod();
    	$view = View::make('OTJOBPReports.ViweDistrictWisecourseCount');
     $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
        // $view->District = District::orderBy('DistrictName')->get();
    
   
        return $view;
    
	}
	
	
	public function DeleteJOBPStudentsPlacement()
	  {
                $id = Input::get('id');
                $quorg = IRJOBPTraineePlacement::findOrFail($id);
				$quorg->Deleted =1;
				$quorg->Active = 0;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();				// if not found show 404 page
				$TraineeID =IRJOBPTraineePlacement::where('id','=',$id)->pluck('irtraineeID');
				$getMaxPalceID = IRJOBPTraineePlacement::where('irtraineeID','=',$TraineeID)->where('Deleted','=',0)->orderBy('id')->max('id');
				if(count($getMaxPalceID) == 0)
				{
					$UpdateTraineeTable = IRTrainee::where('id','=',$TraineeID)->update(array('JobPlaced' => 0,'JobDropout' => 0));
				}
				else
				{
					$updatePlacementTab = IRJOBPTraineePlacement::where('id','=',$getMaxPalceID)->update(array('Active' => 1,'Deleted' => 0));
				
				    $getFullRec = IRJOBPTraineePlacement::where('id','=',$getMaxPalceID)->first();
				
				    $UpdateTraineeTable = IRTrainee::where('id','=',$TraineeID)->update(array('JobPlaced' => 1,'JobDropout' => $getFullRec->Dropout));
				}
				
				// Vacancy Relreased particular company
					$VacancyID = IRJOBPTraineePlacement::where('id','=',$id)->pluck('JOBPVacancyID');
					$OJTVacancyTableOCFemale = 0;
					$OJTVacancyTableOCMale = 0;
					//$OJTVacancyTableOCFemaleold = 0;
					//$OJTVacancyTableOCMaleold = 0;
					$Gender = IRTrainee::where('id','=',$TraineeID)->pluck('Gender');
					$JOBPVacancyType = IRJOBVacancy::where('id','=',$VacancyID)->pluck('VacancyType');
					if($JOBPVacancyType == 'GenderBased')
					{	
						if($Gender == 'Female')
						{
							$OJTVacancyTableOCFemale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
							$OJTVacancyTableOCFemale = $OJTVacancyTableOCFemale - 1;
							$UpdateVacancyTable = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemale));
							
							//$OldvacancyID1 = IROJTTraineePlacement::where('id','=',$getMaxPalceID)->pluck('OJTVacancyID');
							//$OJTVacancyTableOCFemaleold = IROJTVacancy::where('id','=',$OldvacancyID1)->pluck('OccupiedFemaleVacancy');
							//$OJTVacancyTableOCFemaleold = $OJTVacancyTableOCFemaleold + 1;
							//$UpdateVacancyTable2 = IROJTVacancy::where('id','=',$OldvacancyID1)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemaleold));
						}
						else
						{
							$OJTVacancyTableOCMale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedMaleVacancy');
							$OJTVacancyTableOCMale = $OJTVacancyTableOCMale - 1;
							$UpdateVacancyTable1 = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedMaleVacancy' => $OJTVacancyTableOCMale));
							
							//$OldvacancyID2 = IROJTTraineePlacement::where('id','=',$getMaxPalceID)->pluck('OJTVacancyID');
							//$OJTVacancyTableOCMaleold = IROJTVacancy::where('id','=',$OldvacancyID2)->pluck('OccupiedMaleVacancy');
							//$OJTVacancyTableOCMaleold = $OJTVacancyTableOCMaleold + 1;
							//$UpdateVacancyTable3 = IROJTVacancy::where('id','=',$OldvacancyID2)->update(array('OccupiedMaleVacancy' => $OJTVacancyTableOCMaleold));
						}
					}
					else
					{
						$OJTVacancyTableOCFemale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
						$OJTVacancyTableOCFemale = $OJTVacancyTableOCFemale - 1;
						$UpdateVacancyTable = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemale));
					}
					

                return Redirect::to('ViewJOBPStudentHistory');
                
      }
	
	public function AddJOBPStudentDropout()
	{
		$CMPlanID = Input::get('id');//get ojtplacement id
		$Comment = Input::get('reason');
		
		$irOJTPlacementTable = IRJOBPTraineePlacement::where('id','=',$CMPlanID)->update(array('ReasonForDropoutOJT' => $Comment,'Dropout' => '1','OJTCompletedF' => 0));
		$TraineeID =IRJOBPTraineePlacement::where('id','=',$CMPlanID)->pluck('irtraineeID');
	    $IRTraineeeTable = IRTrainee::where('id','=',$TraineeID)->update(array('JobDropout' => '1'));
		$Gender = IRTrainee::where('id','=',$TraineeID)->pluck('Gender');
	    
		// Vacancy Relreased particular company
		$VacancyID = IRJOBPTraineePlacement::where('id','=',$CMPlanID)->pluck('JOBPVacancyID');
		$OJTVacancyTableOCFemale = 0;
		$OJTVacancyTableOCMale = 0;
		$JOBPVacancyType = IRJOBVacancy::where('id','=',$VacancyID)->pluck('VacancyType');
		if($JOBPVacancyType == 'GenderBased')
		{
				if($Gender == 'Female')
				{
					$OJTVacancyTableOCFemale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
					$OJTVacancyTableOCFemale = $OJTVacancyTableOCFemale - 1;
					$UpdateVacancyTable = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemale));
				}
				else
				{
					$OJTVacancyTableOCMale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedMaleVacancy');
					$OJTVacancyTableOCMale = $OJTVacancyTableOCMale - 1;
					$UpdateVacancyTable1 = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedMaleVacancy' => $OJTVacancyTableOCMale));
				}
		
		}
		else{
			$OJTVacancyTableOCFemale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
			$OJTVacancyTableOCFemale = $OJTVacancyTableOCFemale - 1;
			$UpdateVacancyTable = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemale));
		}

		 return 1;
	
	}
	
	public function ViewJOBPStudentHistory()
	{
		$method = Request::getMethod();
		$v = View::make('OTJoBPlacementStudents.StudentHistory');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
       
		
        $v->userOrgId = $userOrgId;
        $v->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $v->user = User::getSysUser();
     

        if ($method == "GET") {
            return $v;
        }
		  if ($method == "POST") {
            $Stype = Input::get('SType');
			$NIC = Input::get('NIC');
			
			if($Stype == 'NIC')
			{
				$GetEmpID = IRTrainee::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('id');
			}
			else
			{
				$GetEmpID = IRTrainee::where('MISNumber','=',$NIC)->where('Deleted','=',0)->pluck('id');
			}
			
			  $Sql = "select irtraineejobplacement.id,
					  irtrainee.id as TraineeId,
					  irtrainee.NameWithInitials,irtrainee.NIC,
					  irtrainee.MISNumber,irtrainee.Mobile,irtrainee.Gender,
					  ircompany.CompanyName,ircompany.Address,
					  coursecategory.Category,
					  irjobvacancy.TrainingArea,
					  irtraineejobplacement.StartingDate,
					  irtraineejobplacement.EndDate,
					  irtraineejobplacement.Salary,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  irtrainee.OJTPlaced,
					  irtrainee.OJTCompleted,
                      irtrainee.JobPlaced,
					  irtraineejobplacement.Active,irtraineejobplacement.ReasonForDropoutOJT,irtraineejobplacement.Dropout,
					  irtrainee.JobDropout
					  from irtraineejobplacement
					  left join irtrainee
					  on irtraineejobplacement.irtraineeID=irtrainee.id
					  left join irjobvacancy
					  on irtraineejobplacement.JOBPVacancyID=irjobvacancy.id
					  left join coursecategory
					  on irjobvacancy.CourseOccupationID=coursecategory.id
					  left join ircompany
					  on irtraineejobplacement.CompanyID=ircompany.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtraineejobplacement.Deleted=0
					  and irtrainee.id='".$GetEmpID."'
					  order by irtraineejobplacement.id";
					  
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = IRTrainee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
	 public function GetJOBpAvailableVacancy()
  {
     //$CompanyID = Input::get('CourseListCode');
	 $dis = Input::get('District');
	 $elec = Input::get('Electorate');
	 $UserOrgID = User::getSysUser()->organisationId; 
	 $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	 $IRTraineeID = Input::get('traineeid');
     $u = User::getSysUser()->EmpId;
	 $Gender = IRTrainee::where('id','=',$IRTraineeID)->pluck('Gender');
	 $IRTraineeRec = IRTrainee::where('id','=',$IRTraineeID)->first();
	 $CourseYearPlan = CourseYearPlan::where('id','=',$IRTraineeRec->CourseYearPlanID)->first();
	 $CourseDetailRec = Course::where('CD_ID','=',$CourseYearPlan->CD_ID)->first();
	 $Count = 0;
    
	if($elec == 'All')
	{
		if($OegaType == 'HO')
		{
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.Active=1"));
		}
		elseif($OegaType == 'DO')
		  {
			  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			  $MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
											  and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		  }
		  elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
		elseif($OegaType == 'PO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											 and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									          and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		}
		else{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
	}
	else
	{
		if($OegaType == 'HO')
		{
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and ircompany.Active=1"));
		}
		elseif($OegaType == 'DO')
		  {
			  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			  $MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
											  and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		  }
		  elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
		elseif($OegaType == 'PO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									          and organisation.Type not in('NVTI')
											  and ircompany.Active=1"));
		}
		else{
			$UserOrgID = User::getSysUser()->organisationId;
			$MOCenterMonitoringPlan = DB::select(DB::raw("select irjobvacancy.id,
											  coursecategory.Category,
											  irjobvacancy.TrainingArea,
											  irjobvacancy.VacancyType,
											  irjobvacancy.VacancyFemale,
											  irjobvacancy.VacancyMale,
											  irjobvacancy.OccupiedFemaleVacancy,
											  irjobvacancy.OccupiedMaleVacancy,
											  ircompany.CompanyName,
											  ircompany.Address,
											  organisation.OrgaName as UserOrganisationName
											  from irjobvacancy
											  left join coursecategory
											  on irjobvacancy.CourseOccupationID=coursecategory.id
											  left join trade
											  on irjobvacancy.TradeID=trade.TradeId
											  left join ircompany
											  on irjobvacancy.CompanyID=ircompany.id
											  left join organisation
											  on ircompany.UserCenterID=organisation.id
											  left join district as orgdis
											  on organisation.DistrictCode=orgdis.DistrictCode
											  left join user
											  on ircompany.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where  irjobvacancy.TradeID='".$CourseDetailRec->TradeId."'
											  and irjobvacancy.Active=1
											  and irjobvacancy.Deleted=0
											  and ircompany.Deleted=0
											  and ircompany.DistrictCode='".$dis."'
											  and ircompany.DSDivision='".$elec."'
											  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
											  and ircompany.Active=1"));
		}
	}
   
     $html='';
     $i = 1;
     $aaa="";
$aaa = "<select id=\"VacancyCode\" name=\"VacancyCode\" required=\"true\">";
        $aaa .= "<option value=\"\">---Select Vacancy---</option>";
		
		 if(!empty($MOCenterMonitoringPlan))
		 {
			 $Count = 1;
			 foreach($MOCenterMonitoringPlan as $m)
		   {
			   if($m->VacancyType != 'GenderBased')
							{
								// common vacancy
								$Ocvac = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvac
													  from irtraineejobplacement
													  left join irtrainee
													  on irtraineejobplacement.irtraineeID=irtrainee.id
													  where irtraineejobplacement.JOBPVacancyID='".$m->id."'
													  and irtraineejobplacement.Deleted=0
													  and irtraineejobplacement.Active=1
													  and irtraineejobplacement.Dropout=0
													  and irtraineejobplacement.OJTCompletedF=0
													  and irtrainee.OJTCompleted=0"));
								$newdata =  json_decode(json_encode((array)$Ocvac),true);
								$OccuipFemale = $newdata[0]["occupiedvac"];
								
								$AvailableVacCommon = ($m->VacancyFemale - $OccuipFemale);
								if($AvailableVacCommon > 0)
								{
									$aaa .= "<option value=\"$m->id\">$m->CompanyName($m->Address) -: [$m->Category]  (No of vacancy - $AvailableVacCommon) Entered By $m->UserOrganisationName</option>";
								}
							}
							else
							{
								// Genderbased Vacancy
								// if students gender is female
								if($Gender == 'Female' || $Gender == 'female')
								{
									$Ocvac = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvac
												  from irtraineejobplacement
												  left join irtrainee
												  on irtraineejobplacement.irtraineeID=irtrainee.id
												  where irtraineejobplacement.JOBPVacancyID='".$m->id."'
												  and irtraineejobplacement.Deleted=0
												  and irtraineejobplacement.Active=1
												  and irtraineejobplacement.Dropout=0
												  and irtraineejobplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Female'"));
									$newdata =  json_decode(json_encode((array)$Ocvac),true);
									$OccuipFemale = $newdata[0]["occupiedvac"];
									$AvailableVacFemale = 0;

									$AvailableVacFemale = ($m->VacancyFemale - $OccuipFemale);
									if($AvailableVacFemale > 0)
									{
										//$aaa .= "<option value=\"$m->id\">$m->Category (No of vacancy - $AvailableVacFemale)</option>";
										$aaa .= "<option value=\"$m->id\">$m->CompanyName($m->Address) -: [$m->Category]  (No of vacancy - $AvailableVacFemale) Entered By $m->UserOrganisationName</option>";


									}

								}
								else
								{
									$OcvacM = DB::select(DB::raw("select count(irtraineejobplacement.id) as occupiedvacm
												  from irtraineejobplacement
												  left join irtrainee
												  on irtraineejobplacement.irtraineeID=irtrainee.id
												  where irtraineejobplacement.JOBPVacancyID='".$m->id."'
												  and irtraineejobplacement.Deleted=0
												  and irtraineejobplacement.Active=1
												  and irtraineejobplacement.Dropout=0
												  and irtraineejobplacement.OJTCompletedF=0
												  and irtrainee.OJTCompleted=0
												  and irtrainee.Gender='Male'"));
									$newdataM =  json_decode(json_encode((array)$OcvacM),true);
									$OccuipMale = $newdataM[0]["occupiedvacm"];
									$AvailableVacMale = 0;
									
									$AvailableVacMale =($m->VacancyMale - $OccuipMale);
									if($AvailableVacMale > 0)
									{
										//$aaa .= "<option value=\"$m->id\">$m->Category (No of vacancy - $AvailableVacMale)</option>";
										$aaa .= "<option value=\"$m->id\">$m->CompanyName($m->Address) -: [$m->Category]  (No of vacancy - $AvailableVacMale) Entered By $m->UserOrganisationName</option>";


									}

								}
							}
							   
		   }				   
		 }
		 else
		 {
			 $Count = 0;
		 }
		 
		 $aaa .= "</select>";
	     return json_encode(array("Count" => $Count, "Table" => $aaa));
	 
  }
	
			public function JOBPplacementtudents() 
		{
			
        $method=Request::getMethod();
		  if($method == 'GET')
        {
          $UserOrgID=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$UserOrgID)->first();
          $OegaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
          $view = View::make('OTJoBPlacementStudents.OJTPlacement');
		  $view->Districts = District::orderBy('DistrictName')->get();
          $loggeduserDistrict = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		  $record = IRTrainee::where('id','=',Input::get('edit_id'))->first();
          $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
          $IRTrainee1 = IRTrainee::find(Input::get('edit_id'));
		  $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
		  $OrgaDistrict = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
		  $DistrictName = District::where('DistrictCode','=',$OrgaDistrict)->pluck('DistrictName');
		  $OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
		  $CourseName = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->pluck('CourseName');
		  $view->Centers = Organisation::where('Deleted','=',0)
                ->where('DistrictCode','=',$OrgaDistrict)
				  ->whereNotIn('Type',['HO','DO','PO'])
				  ->where('Active','=','Yes')
				  ->orderBy('OrgaName')
				->get();
			
		if($OegaType == 'HO')
		{	
			$view->district = District::orderBy('DistrictName')->get();
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
		}
		elseif($OegaType == 'NVTI')
		{	
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();		
		}
		elseif($OegaType == 'PO')
		{
			$view->district = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		}
		else
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
		}
         
			$view->IRTrainee=$record;
			$view->CourseYearPlan=$CourseYearPlan1;
			$view->DistrictName = $DistrictName;
			$view->OrganisationName = $OrgaName;
			$view->CourseName = $CourseName;
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
			
			  
            
              
                return $view;
		}
              
             if($method == 'POST')
		{
               
              $IRTraineeID = Input::get('edit_id');
			  //$companyID = Input::get('CompanyID');
			  $StartDate = Input::get('StartDate');
			  $EndDate = Input::get('EndDate');
			  $Salary = Input::get('Salary');
			  //$trainee_ids = Input::get('trainee_ids');
			  //$ModateTaskIDs = Input::get('ModateTaskIDs');
			   $VacancyID = Input::get('VacancyCode');
			  $companyID = IROJTVacancy::where('id','=',$VacancyID)->pluck('CompanyID');
			 // $countTraineeid = count($trainee_ids);
			  $Gender = IRTrainee::where('id','=',$IRTraineeID)->pluck('Gender');
			  /* $VacancyID = 0;
              // get jobvacancid
			  for($i=0;$i<$countTraineeid;$i++)
				{
					if($i == 0)
					{
					$VacancyID = $trainee_ids[$i];
					}		
				} */
				//return $VacancyID;
				//UpdateJobPlacementTable Active column
				$UpdateOJTPlcActive = IRJOBPTraineePlacement::where('irtraineeID','=',$IRTraineeID)
				->where('Deleted','=',0)
				->update(array('Active' => 0));
				
				//Save to Table
				$d = new IRJOBPTraineePlacement();
				$d->irtraineeID = $IRTraineeID;
				$d->CompanyID = $companyID;
				$d->JOBPVacancyID = $VacancyID;
				$d->StartingDate = $StartDate;
				$d->EndDate = $EndDate;
				$d->Salary = $Salary;
				$d->Dropout = 0;
				$d->OJTCompletedF = 0;
				$d->User = User::getSysUser()->userID;
				$d->save();
				$OccupiedVacFemale=0;
				$OccupiedVacMale = 0;
				// Update Available Vacancy Count
				$UpdateTraineeTable = IRTrainee::where('id','=',$IRTraineeID)->update(array('JobPlaced' => 1,'JobDropout' => 0));
				$JOBPVacancyType = IRJOBVacancy::where('id','=',$VacancyID)->pluck('VacancyType');
				if($JOBPVacancyType == 'GenderBased')
				{
					if($Gender == 'Female')
					{
						$OccupiedVacFemale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
						$OccupiedVacFemale = $OccupiedVacFemale +1;
						$UpdateOJTVacancyTableF = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OccupiedVacFemale));
					}
					elseif($Gender == 'Male')
					{
						$OccupiedVacMale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedMaleVacancy');
						$OccupiedVacMale = $OccupiedVacMale +1;
						$UpdateOJTVacancyTableM = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedMaleVacancy' => $OccupiedVacMale));
					}
					else
					{
					}
				}
				else
				{
					$OccupiedVacFemale = IRJOBVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
					$OccupiedVacFemale = $OccupiedVacFemale +1;
					$UpdateOJTVacancyTableF = IRJOBVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OccupiedVacFemale));
					
				}
                   
					
					
	$view = View::make('OTJoBPlacementStudents.ViewOJTStudents');
					
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
		$sql = "select organisation.* 
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
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id

  ";
		}
		else
		{
			$sql = "select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		  
	
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
    return $view;               //return Redirect::to('ViewTrainingPlanUpdateDisNVTI?');
						//return Redirect::back();
                    
                
        }      
        
    }
	
	 public function ViewJOBPStudents()
	{
	$method = Request::getMethod();
    $view = View::make('OTJoBPlacementStudents.ViewOJTStudents');
    //$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
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
		$sql = "select organisation.* 
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
 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');

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
		$CYIP = Input::get('CourseYearPlanID');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
		if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					   and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
                      and irtrainee.OJTCompleted=1
					order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
					district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
	and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and irtrainee.OJTCompleted=1
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id

  ";
		}
			elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
                    district.DistrictName,organisation.OrgaName,
					organisation.Type,
					courseyearplan.Year,
					courseyearplan.batch,
					coursedetails.CourseName,
					coursedetails.CourseListCode,
					coursedetails.CourseType,
                    coursedetails.Nvq,
                    coursedetails.CourseLevel,
					coursedetails.Duration,
					courseyearplan.medium as Medium,
					courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and organisation.id='".$CenterID."'
  and irtrainee.OJTCompleted=1
 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id

  ";
		}
		else
		{
			
			$sql = "select irtrainee.*,
                    district.DistrictName,organisation.OrgaName,
					organisation.Type,
					courseyearplan.Year,
					courseyearplan.batch,
					coursedetails.CourseName,
					coursedetails.CourseListCode,
					coursedetails.CourseType,
                    coursedetails.Nvq,
                    coursedetails.CourseLevel,
					coursedetails.Duration,
					courseyearplan.medium as Medium,
					courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
 and coursedetails.CourseType='Full'
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
	and courseyearplan.id='".$CYIP."'
  and irtrainee.OJTCompleted=1
 
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id

  ";
		}
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
	$view->CYIPD = $CYIP;
	 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
        return $view;
    }
	
	}
	
  public function DownloadOJTDistrictWiseCountReportExcel()
  {
    $Year = Input::get('Year');
	$Batch = Input::get('Batch');
   
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Registered','Dropouts','OJT Target','No of OJT Placed(Total)',
	'Dropouts During OJT','OJT Ongoing','OJT Completed');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
      if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";

  
 
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			
			
$registered = 0;
$dropout = 0;			
$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$OJTDropout = 0;
$OJTOngoing = 0;
$OJTCompleted = 0;

                foreach($total_rec as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName);
               
			   // array_push($data_row, $Data->GradeAmin);
			   array_push($data_row, $Data->Registered);
			    array_push($data_row, $Data->Dropout);
				array_push($data_row, $Data->target);
			   // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Data->LocalTot);
			  //  array_push($data_row, $Data->GradeCmin);
			  //array_push($data_row, $Data->ForeignTot);
			  
			 // $TotLocFo = $Data->LocalTot+ $Data->ForeignTot;
			  // array_push($data_row, $TotLocFo);
			   array_push($data_row, $Data->OJTDropouts);
			   array_push($data_row, $Data->OJTOngoing);
			   array_push($data_row, $Data->OJTcompleted);
			
               
                array_push($printablearray, $data_row);
				$registered = $registered + $Data->Registered;
							$dropout = $dropout + $Data->Dropout;
							$target = $target + $Data->target;
							$Local = $Local + $Data->LocalTot;
							//$Foreign = $Foreign + $Data->ForeignTot;
							//$Total = $Total + $TotLocFo ;
							$OJTDropout = $OJTDropout + $Data->OJTDropouts;
							$OJTOngoing = $OJTOngoing + $Data->OJTOngoing;
							$OJTCompleted = $OJTCompleted + $Data->OJTcompleted;
                            
                }
				
				
				$data_row = array();
				array_push($data_row, $i++);
				array_push($data_row, ' ');
                array_push($data_row, 'Total');
               
			    array_push($data_row, $registered);
				array_push($data_row, $dropout);
				array_push($data_row, $target);
			    // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Local);
			    //  array_push($data_row, $Data->GradeCmin);
			  //  array_push($data_row, $Foreign);
				//array_push($data_row, $Total);
			array_push($data_row, $OJTDropout);
				array_push($data_row, $OJTOngoing);
				array_push($data_row, $OJTCompleted);
               
                array_push($printablearray, $data_row);


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseWiseOJTCountReport' . date('Y-m-d'));
            
  }
	
		public function LoadOJTDistrictWiseCountReport()
	{
		
		$Batch = Input::get('Batch');
		
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $Year . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise OJT Placement Count Report<pre><h5> Year:'.$Year.' Batch '.$Batch.'</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th  class="center" rowspan="2">District/NVTI Name</th>
                            <th  class="center" rowspan="2">Centre</th>
							<th align="center" class="center" rowspan="2">Registered</th>
							<th align="center" class="center" rowspan="2">Dropout</th>
							<th  class="center" rowspan="2">OJT Target</th>
							<th align="center" class="center" rowspan="2">OJT Placements</th>
							<th align="center" class="center" rowspan="2">OJT Dropouts</th>
							<th align="center" class="center" rowspan="2">OJT Ongoing</th>
							<th align="center" class="center" rowspan="2">OJT Completed</th>
						</tr>
						 
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
 
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted
from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName
";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
 SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by district.DistrictName,organisation.OrgaName
  order by district.DistrictName,organisation.OrgaName";

  
 
}
$registered = 0;
$dropout = 0;
$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$OJTDropout = 0;
$OJTOngoing = 0;
$OJTCompleted = 0;


           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			

			   foreach($total_rec as $ps) {
				   $TotLocFo =0;
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="left">'.$ps->OrgaName.'</td>
							<td class="center">'.$ps->Registered.'</td>
							<td class="center">'.$ps->Dropout.'</td>
							<td class="center">'.$ps->target.'</td>
							<td class="center">'.$ps->LocalTot.'</td>';
							
							//$TotLocFo = $ps->LocalTot+ $ps->ForeignTot;
							$html.='
							<td class="center">'.$ps->OJTDropouts.'</td>
							<td class="center">'.$ps->OJTOngoing.'</td>
							<td class="center">'.$ps->OJTcompleted.'</td>';
							
			
							
                            $html.='<tr>';
							$registered = $registered + $ps->Registered;
							$dropout = $dropout + $ps->Dropout;
							$target = $target + $ps->target;
							$Local = $Local + $ps->LocalTot;
							//$Foreign = $Foreign + $ps->ForeignTot;
							//$Total = $Total + $TotLocFo ;
							$OJTDropout = $OJTDropout + $ps->OJTDropouts;
							$OJTOngoing = $OJTOngoing + $ps->OJTOngoing;
							$OJTCompleted = $OJTCompleted + $ps->OJTcompleted;
 							
                            
                }
				
				
				 $html .='<tr>
                            <td class="center"></td>
                            <td class="left">Total</td>
                            <td class="center"></td>
							<td class="center">'.$registered.'</td>
							<td class="center">'.$dropout.'</td>
							<td class="center">'.$target.'</td>
							<td class="center">'.$Local.'</td>
							
							<td class="center">'.$OJTDropout.'</td>
							<td class="center">'.$OJTOngoing.'</td>
							<td class="center">'.$OJTCompleted.'</td>';
							
			
							
                            $html.='<tr>';
							$html .='<tr>
                            <td class="center"></td>
                            <td class="left">Total</td>
                            <td class="center"></td>
							
							<td class="center">Total Registered</td>
							<td class="center">Total Dropout</td>
							<td class="center">OJT Target</td>
							
							<td class="center">Total OJT Placed</td>
							<td class="center">Total OJT Dropout</td>
							<td class="center">Total OJT Ongoing</td>
							<td class="center">Total OJT Completed</td>';
							
			
							
                            $html.='<tr>';
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewOJTDistrictWiseCountReport()
	{
		$method = Request::getMethod();
		$view = View::make('OJTReport.ViewDistrictWisePlacementCount');
		 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
    
   // $view->District = District::orderBy('DistrictName')->get();
    
   
        return $view;
    
	}
	
 public function DownloadOJTCourseWiseCountReportExcel()
  {
    $Year = Input::get('Year');
	$Batch = Input::get('Batch');
   
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Course','CourseLevel','Duration','Year','Batch','Registered','Dropouts','Target','No of OJT Placed(Total)',
	'Dropouts During OJT','OJT Ongoing','OJT Completed');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
     if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName
";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) as target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName
";
}

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			
			
$registered = 0;
$dropout = 0;			
$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$OJTDropout = 0;
$OJTOngoing = 0;
$OJTCompleted = 0;

                foreach($total_rec as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName);
                array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				array_push($data_row, $Data->Year);
				array_push($data_row, $Data->batch);
			    // array_push($data_row, $Data->GradeAmin);
			    array_push($data_row, $Data->Registered);
			    array_push($data_row, $Data->Dropout);
				array_push($data_row, $Data->target);
			    // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Data->LocalTot);
			    //  array_push($data_row, $Data->GradeCmin);
			   // array_push($data_row, $Data->ForeignTot);
			  
			  // $TotLocFo = $Data->LocalTot+ $Data->ForeignTot;
			   //array_push($data_row, $TotLocFo);
			   array_push($data_row, $Data->OJTDropouts);
			   array_push($data_row, $Data->OJTOngoing);
			   array_push($data_row, $Data->OJTcompleted);
			
               
                array_push($printablearray, $data_row);
							
							$registered = $registered + $Data->Registered;
							$dropout = $dropout + $Data->Dropout;
							$target = $target + $Data->target;
							$Local = $Local + $Data->LocalTot;
							//$Foreign = $Foreign + $Data->ForeignTot;
							//$Total = $Total + $TotLocFo ;
							
							$OJTDropout = $OJTDropout + $Data->OJTDropouts;
							$OJTOngoing = $OJTOngoing + $Data->OJTOngoing;
							$OJTCompleted = $OJTCompleted + $Data->OJTcompleted;
                            
                }
				
				
				$data_row = array();
				array_push($data_row, $i++);
				array_push($data_row, ' ');
                array_push($data_row, 'Total');
                array_push($data_row, ' ');
				array_push($data_row, ' ');
				array_push($data_row, ' ');
				array_push($data_row, ' ');
				array_push($data_row, ' ');
			    array_push($data_row, $registered);
				array_push($data_row, $dropout);
				array_push($data_row, $target);
			    // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Local);
			    //  array_push($data_row, $Data->GradeCmin);
			  //  array_push($data_row, $Foreign);
				//array_push($data_row, $Total);
				 
				array_push($data_row, $OJTDropout);
				array_push($data_row, $OJTOngoing);
				array_push($data_row, $OJTCompleted);
			
               
                array_push($printablearray, $data_row);


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CourseWiseWiseOJTCountReport' . date('Y-m-d'));
            
  }
	
	public function LoadOJTCourseWiseCountReport()
	{
		
		$Batch = Input::get('Batch');
		
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $Year . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>Course Wise OJT Placement Count Report<pre><h5> Year:'.$Year.' Batch '.$Batch.'</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th align="center" class="center" rowspan="2">District/NVTI Name</th>
                            <th align="center" class="center" rowspan="2">Centre</th>
							<th align="center" class="center" rowspan="2">Course</th>
							<th align="center" class="center" rowspan="2">Course Level</th>
							<th align="center" class="center" rowspan="2">Duration</th>
							<th align="center" class="center" rowspan="2">Year</th>
							<th align="center" class="center" rowspan="2">Batch</th>
							<th align="center" class="center" rowspan="2">Registered</th>
							<th align="center" class="center" rowspan="2">Dropout</th>
							<th align="center" class="center" rowspan="2">OJT Target</th>
							<th align="center" class="center" rowspan="2">OJT Placement</th>
							<th align="center" class="center" rowspan="2">OJT Dropouts</th>
							<th align="center" class="center" rowspan="2">OJT Ongoing</th>
							<th align="center" class="center" rowspan="2">OJT Completed</th>
						</tr>
						
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($Batch == 'All') {

 
  $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1)
             THEN
            1
        ELSE 0
    END) LocalTot,

SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted
from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName
  ";

}
else 
{
   $sqldis="select district.DistrictName,organisation.OrgaName,
  coursedetails.CourseName,coursedetails.CourseLevel,coursedetails.Duration,
  courseyearplan.Year,courseyearplan.batch,
  SUM(CASE
        WHEN
            (irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Registered,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=1 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) Dropout,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0)
             THEN
            1
        ELSE 0
    END) as target,
 SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 )
             THEN
            1
        ELSE 0
    END) LocalTot,

SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=1 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTDropouts,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=0)
             THEN
            1
        ELSE 0
    END) OJTOngoing,
	SUM(CASE
        WHEN
            (irtrainee.Dropout=0 and irtrainee.Deleted=0 and irtrainee.OJTPlaced=1 and irtrainee.OJTDropout=0 and irtrainee.OJTCompleted=1)
             THEN
            1
        ELSE 0
    END) OJTcompleted

  from courseyearplan
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join irtrainee
  on courseyearplan.id=irtrainee.CourseYearPlanID 
  left join irtraineeojtplacement
  on irtrainee.id=irtraineeojtplacement.irtraineeID
  and irtraineeojtplacement.Active='1'
  and irtraineeojtplacement.Deleted=0
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  where courseyearplan.Deleted=0
  and courseyearplan.Year='".$Year."'
  and courseyearplan.batch like '$Batch%'
  and coursedetails.Nvq in('NVQ')
  and courseyearplan.StartedStatus='1'
  and coursedetails.CourseType in('Full')
  and coursedetails.CourseLevel in(4,5,6)
  group by courseyearplan.id
  order by district.DistrictName,organisation.OrgaName";

  
 
}
$registered = 0;
$dropout = 0;
$target = 0;
$Local = 0;
$Foreign = 0;
$Total = 0;
$OJTDropout = 0;
$OJTOngoing = 0;
$OJTCompleted = 0;


           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			

			   foreach($total_rec as $ps) {
				   $TotLocFo =0;
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->OrgaName.'</td>
							<td class="center">'.$ps->CourseName.'</td>
							<td class="center">'.$ps->CourseLevel.'</td>
							<td class="center">'.$ps->Duration.'</td>
							<td class="center">'.$ps->Year.'</td>
							<td class="center">'.$ps->batch.'</td>
							<td class="center">'.$ps->Registered.'</td>
							<td class="center">'.$ps->Dropout.'</td>
							<td class="center">'.$ps->target.'</td>  
							<td class="center">'.$ps->LocalTot.'</td>';
							
							//$TotLocFo = $ps->LocalTot+ $ps->ForeignTot;
							$html.='<td class="center">'.$ps->OJTDropouts.'</td>
							<td class="center">'.$ps->OJTOngoing.'</td>
							<td class="center">'.$ps->OJTcompleted.'</td>';
							
			
							
                            $html.='<tr>';
							$registered = $registered + $ps->Registered;
							$dropout = $dropout + $ps->Dropout;
							$target = $target + $ps->target;
							$Local = $Local + $ps->LocalTot;
							//$Foreign = $Foreign + $ps->ForeignTot;
							//$Total = $Total + $TotLocFo ;
							
							$OJTDropout = $OJTDropout + $ps->OJTDropouts;
							$OJTOngoing = $OJTOngoing + $ps->OJTOngoing;
							$OJTCompleted = $OJTCompleted + $ps->OJTcompleted;
							
 							
                            
                }
				
				
				 $html .='<tr>
                            <td class="center"></td>
                            <td class="left">Total</td>
                            <td class="center"></td>
							<td class="center"></td>
							<td class="center"></td>
						    <td class="center"></td>
						    <td class="center"></td>
							<td class="center"></td>
							<td class="center">'.$registered.'</td>
							<td class="center">'.$dropout.'</td>
							<td class="center">'.$target.'</td>
							<td class="center">'.$Local.'</td>
							
							<td class="center">'.$OJTDropout.'</td>
							<td class="center">'.$OJTOngoing.'</td>
							<td class="center">'.$OJTCompleted.'</td>';
							
			
							
                            $html.='<tr>';
				 $html .='<tr>
                            <td class="center"></td>
                            <td class="left">Total</td>
                            <td class="center"></td>
							<td class="center"></td>
							<td class="center"></td>
						    <td class="center"></td>
						    <td class="center"></td>
							<td class="center"></td>
							<td class="center">Total Registered</td>
							<td class="center">Total Dropout</td>
							<td class="center">OJT Target</td>
							
							<td class="center">Total OJT Placed</td>
							<td class="center">Total OJT Dropout</td>
							<td class="center">Total OJT Ongoing</td>
							<td class="center">Total OJT Completed</td>';
							
			
							
                            $html.='<tr>';
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
		public function ViewOJTCourseWiseCountReport()
	{
		$method = Request::getMethod();
		 $view = View::make('OJTReport.ViweDistrictWisecourseCount');
    
		 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
   
   // $view->District = District::orderBy('DistrictName')->get();
    
   
        return $view;
    
	}
	
	
		public function PrintOJTPlacedMyStudents()
  {
		//$CenterID = Input::get('CenterIDD');
		$Year = Input::get('YearD');
		$Batch = Input::get('BatchD');
		//$district = Input::get('districtD');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		$html='';
		 $EID = User::getSysUser()->EmpId;
		 $sql = "SELECT
  irtrainee.*,
  irtraineeojtplacement.id AS ojtplaceiD,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
  courseyearplan.StartedStatus,
  ircompany.CompanyName,
  ircompany.Address AS CAddress,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary
FROM irtraineeojtplacement
  LEFT JOIN irtrainee
    ON irtraineeojtplacement.irtraineeID = irtrainee.id
  LEFT JOIN courseyearplan
    ON irtrainee.CourseYearPlanID = courseyearplan.id
  LEFT JOIN organisation
    ON courseyearplan.OrgId = organisation.id
  LEFT JOIN district
    ON organisation.DistrictCode = district.DistrictCode
  LEFT JOIN coursedetails
    ON courseyearplan.CD_ID = coursedetails.CD_ID
  LEFT JOIN ircompany
    ON irtraineeojtplacement.CompanyID = ircompany.id
  LEFT JOIN irojtvacancy
    ON irtraineeojtplacement.OJTVacancyID = irojtvacancy.id
  LEFT JOIN coursecategory
    ON irojtvacancy.CourseOccupationID = coursecategory.id
WHERE ircompany.DSDivision IN (SELECT
    irpodsdivisions.DSDivisionId
  FROM irpodsdivisions
  WHERE irpodsdivisions.EmpId = '".$EID."'
  AND irpodsdivisions.Deleted = 0
  AND irpodsdivisions.Active = 1)
and irtrainee.Deleted = 0
AND courseyearplan.Deleted = 0
AND courseyearplan.Year = '".$Year."'
AND courseyearplan.batch LIKE '$Batch%'
AND irtraineeojtplacement.Active = 1
ORDER BY district.DistrictName,organisation.OrgaName,irtrainee.MISNumber";
			
	$trplans = DB::select(DB::raw($sql));
    $i = 1;

     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','District', 'Centre', 'Year', 'Batch','CourseName','CourseListCode','CourseStartedStatus','Instructors','CourseType','NVQStatus','NVQLevel', 'Duration',
	 'NameWithInitials','FullName','NIC','MISNumber','Mobile','Address','Gender','CompanyName','CompanyAddress','JobCategory','StartDate','EndDate','Salary','OJTCompleted','OJTDropout');
     array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

           
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
			   $a = '';
			   $dod = '.';
			   $fbr = '(';
			   $bbr = ')';
			   $instructors = '';
			   $fdates='';
			  
			   $OJTCompleted = '';
			   
			   $OJTDropout = '';
			   
			   foreach($Ins as $m)
				{
					
					$instructors=$instructors.$m->Name.$fbr.$m->EPFNo.$bbr.$com;
					
					
				}
				
				
				if($aa->OJTCompleted == 0)
				{
					$OJTCompleted = 'No';
				}
				elseif($aa->OJTCompleted == 1)
				{
					$OJTCompleted = 'Yes';
				}
				else
				{
					$OJTCompleted = 'Dropout During OJT';
				}
				if($aa->OJTDropout == 0)
				{
					$OJTDropout = 'No';
				}
				else
				{
					$OJTDropout = 'Yes';
				}
				
				
				
				
      array_push($printablearray, array($i,
	  $aa->DistrictName, $aa->OrgaName, 
	  $aa->Year,$aa->batch,
	  $aa->CourseName,
	  $aa->CourseListCode,$aa->StartedStatus, $instructors, $aa->CourseType,$aa->Nvq,$aa->CourseLevel,$aa->Duration,
	  $aa->NameWithInitials,$aa->FullName, 
	  $aa->NIC,
	  $aa->MISNumber,
	  $aa->Mobile,
	  $aa->Address,$aa->Gender,
	$aa->CompanyName,$aa->CAddress,$aa->Category,$aa->StartingDate,$aa->EndDate,$aa->Salary,
	  $OJTCompleted,$OJTDropout
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('OJTPalcedMyStudentList');
  }
	
	  public function ViewMyOJTStudents()
	{
	$method = Request::getMethod();
    $view = View::make('OJTPO.ViewOJTStudents');
    //$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
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
		$sql = "select organisation.* 
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
		$Year = Input::get('Year');
		$Batch = Input::get('Batch');
		$EID = User::getSysUser()->EmpId;
		if(!empty($Year) && !empty($Batch)) 
		{
			
			  $sql = "SELECT
  irtrainee.*,
  irtraineeojtplacement.id AS ojtplaceiD,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
  courseyearplan.StartedStatus,
  ircompany.CompanyName,
  ircompany.Address AS CAddress,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary
  FROM irtraineeojtplacement
  LEFT JOIN irtrainee
    ON irtraineeojtplacement.irtraineeID = irtrainee.id
  LEFT JOIN courseyearplan
    ON irtrainee.CourseYearPlanID = courseyearplan.id
  LEFT JOIN organisation
    ON courseyearplan.OrgId = organisation.id
  LEFT JOIN district
    ON organisation.DistrictCode = district.DistrictCode
  LEFT JOIN coursedetails
    ON courseyearplan.CD_ID = coursedetails.CD_ID
  LEFT JOIN ircompany
    ON irtraineeojtplacement.CompanyID = ircompany.id
  LEFT JOIN irojtvacancy
    ON irtraineeojtplacement.OJTVacancyID = irojtvacancy.id
  LEFT JOIN coursecategory
    ON irojtvacancy.CourseOccupationID = coursecategory.id
WHERE ircompany.DSDivision IN (SELECT
    irpodsdivisions.DSDivisionId
  FROM irpodsdivisions
  WHERE irpodsdivisions.EmpId = '".$EID."'
  AND irpodsdivisions.Deleted = 0
  AND irpodsdivisions.Active = 1)
and irtrainee.Deleted = 0
AND courseyearplan.Deleted = 0
AND courseyearplan.Year = '".$Year."'
AND courseyearplan.batch LIKE '$Batch%'
AND irtraineeojtplacement.Active = 1
ORDER BY district.DistrictName,organisation.OrgaName,irtrainee.MISNumber";
		
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	//$view->CenterIDD = $CenterID;
	//$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
        
		}
		
        return $view;
    }
	
	 if ($method == "POST") 
    {
		
		//$CenterID = Input::get('CenterID');
		$Year = Input::get('Year');
		$Batch = Input::get('Batch');
		//$district = Input::get('District');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	    $EID = User::getSysUser()->EmpId;

			//$district = Input::get('District');
  $sql = "SELECT
  irtrainee.*,
  irtraineeojtplacement.id AS ojtplaceiD,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  courseyearplan.Year,
  courseyearplan.batch,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  courseyearplan.medium AS Medium,
  courseyearplan.StartedStatus,
  ircompany.CompanyName,
  ircompany.Address AS CAddress,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary
  FROM irtraineeojtplacement
  LEFT JOIN irtrainee
    ON irtraineeojtplacement.irtraineeID = irtrainee.id
  LEFT JOIN courseyearplan
    ON irtrainee.CourseYearPlanID = courseyearplan.id
  LEFT JOIN organisation
    ON courseyearplan.OrgId = organisation.id
  LEFT JOIN district
    ON organisation.DistrictCode = district.DistrictCode
  LEFT JOIN coursedetails
    ON courseyearplan.CD_ID = coursedetails.CD_ID
  LEFT JOIN ircompany
    ON irtraineeojtplacement.CompanyID = ircompany.id
  LEFT JOIN irojtvacancy
    ON irtraineeojtplacement.OJTVacancyID = irojtvacancy.id
  LEFT JOIN coursecategory
    ON irojtvacancy.CourseOccupationID = coursecategory.id
WHERE ircompany.DSDivision IN (SELECT
    irpodsdivisions.DSDivisionId
  FROM irpodsdivisions
  WHERE irpodsdivisions.EmpId = '".$EID."'
  AND irpodsdivisions.Deleted = 0
  AND irpodsdivisions.Active = 1)
and irtrainee.Deleted = 0
AND courseyearplan.Deleted = 0
AND courseyearplan.Year = '".$Year."'
AND courseyearplan.batch LIKE '$Batch%'
AND irtraineeojtplacement.Active = 1
ORDER BY district.DistrictName,organisation.OrgaName,irtrainee.MISNumber";
		
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	//$view->CenterIDD = $CenterID;
	//$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
        return $view;
    }
	
	}
	
	public function DeleteAssignPODSDivitions()
	  {
                $EmpId = Input::get('id');
                $quorg = IRPODSDivisions::where('EmpId','=',$EmpId)->where('Deleted','=',0)->update(array('Deleted' => 1,'User' => User::getSysUser()->userID));
				
                return Redirect::to('ViewAssignPODSDivitions');
                
            }


	
			  public function EditAssignPODSDivitions()
	{
			$view = View::make('OJTPO.Edit');
			$method = Request::getMethod();
			$UserOrgID = User::getSysUser()->organisationId; 
			$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
			$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
			

			if ($method == "GET")
			{
			$quorg = IRPODSDivisions::where('id',"=",Input::get('id'))->first();
			$view->DistrictName = District::where('DistrictCode', "=", $quorg->DistrictCode)->pluck('DistrictName');
			$view->user = User::getSysUser();
			$view->electorate = Electorate::where('DistrictCode', "=", $quorg->DistrictCode)->orderBy('ElectorateName')->get();	
            $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();	
			$OrgaCID = Employee::where('id','=',$quorg->EmpId)->pluck('CurrentOrgaID');
			$view->Initials = Employee::where('id','=',$quorg->EmpId)->pluck('Initials');
			$view->LastName = Employee::where('id','=',$quorg->EmpId)->pluck('LastName');
			$view->quorg = $quorg;
			$view->currentOrga = Organisation::where('id','=',$OrgaCID)->pluck('OrgaName');
			$view->AddedDs = DB::select(DB::raw("select electorate.ElectorateCode,electorate.ElectorateName
											  from irpodsdivisions
											  left join electorate
											  on irpodsdivisions.DSDivisionId=electorate.ElectorateCode
											  where irpodsdivisions.Deleted=0
											  and irpodsdivisions.EmpId='".$quorg->EmpId."'
											  and irpodsdivisions.Active=1"));
			return $view;

			}
			if ($method == "POST")
			{
			

			    $Packages = [];
                $Packages = Input::get('NVQPackage');
                $countP = count($Packages); 
				$i=0;
				$Alldeactive = IRPODSDivisions::where('EmpId','=',Input::get('EmpId'))->where('Deleted','=',0)->update(array('Active' => 0));
				
				for($i=0;$i<$countP;$i++)
					{
						$Availability = IRPODSDivisions::where('EmpId','=',Input::get('EmpId'))->where('DSDivisionId','=',$Packages[$i])->count();
						if($Availability >0)
						{
							$Update = IRPODSDivisions::where('EmpId','=',Input::get('EmpId'))->where('DSDivisionId','=',$Packages[$i])->
							update(array('Active' => 1,'Deleted' => 0));
						}
						else
						{
							
							$qo = new IRPODSDivisions;
							$qo->EmpId = Input::get('EmpId');
							$qo->DSDivisionId = $Packages[$i];
							$DistrictCodeId = Electorate::where('ElectorateCode','=',$Packages[$i])->pluck('DistrictCode');
							$qo->DistrictCode = $DistrictCodeId;
							$qo->Active = 1;
							//$qo->FromDate = Input::get('FromDate');
							//$qo->ToDate = Input::get('ToDate');
							$qo->User = User::getSysUser()->userID;
							$qo->save();
						}
				

					}
			
			return Redirect::to('ViewAssignPODSDivitions');
			
			
			}
}
	
	  public function OJTGetEmpIdPO()
  {
    $Center = Input::get('center');
    $UserOrgID = User::getSysUser()->organisationId; 
	$EmpID = User::getSysUser()->EmpId; 
   
if($Center != 420)
{
	$EMP = DB::select(DB::raw("select employee.id,employee.Name,employee.LastName,employmentcode.Designation
  from employee
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where employee.Deleted=0
  and employee.CurrentOrgaID='$Center'
  and employee.id !='$EmpID'
  and (employmentcode.Designation like 'Programme Officer')
  order by employmentcode.Designation"));
}
else{
	$EMP = DB::select(DB::raw("select employee.id,employee.Name,employee.LastName,employmentcode.Designation
  from user
  left join employee
  on user.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where user.active=1
  and user.Deleted=0
  and employee.Deleted=0
  and user.organisationId='$Center'
  and employee.id !='$EmpID'
  and (employmentcode.Designation like 'Programme Officer')
  order by employmentcode.Designation"));
}
    

    return json_encode($EMP);
  }
	
	public function CreateAssignPODSDivitions()
	 {
        $method = Request::getMethod();
        $view = View::make('OJTPO.Create');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		//$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
        //$institutes = User::getSysUser()->instituteId;
      	$view->Districts = District::orderBy('DistrictName')->get();
		$view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
		$view->electorate = Electorate::orderBy('ElectorateName')->get();
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
				
				$Packages = [];
                $Packages = Input::get('NVQPackage');
                $countP = count($Packages); 
				$i=0;
				$Alldeactive = IRPODSDivisions::where('EmpId','=',Input::get('EmpId'))->where('Deleted','=',0)->update(array('Active' => 0));
				for($i=0;$i<$countP;$i++)
					{
						$Availability = IRPODSDivisions::where('EmpId','=',Input::get('EmpId'))->where('DSDivisionId','=',$Packages[$i])->count();
						if($Availability >0)
						{
							$Update = IRPODSDivisions::where('EmpId','=',Input::get('EmpId'))->where('DSDivisionId','=',$Packages[$i])->
							update(array('Active' => 1,'Deleted' => 0));
						}
						else
						{
							$qo = new IRPODSDivisions;
							$qo->EmpId = Input::get('EmpId');
							$qo->DSDivisionId = $Packages[$i];
							$DistrictCodeId = Electorate::where('ElectorateCode','=',$Packages[$i])->pluck('DistrictCode');
							$qo->DistrictCode = $DistrictCodeId;
							$qo->Active = 1;
							//$qo->FromDate = Input::get('FromDate');
							//$qo->ToDate = Input::get('ToDate');
							$qo->User = User::getSysUser()->userID;
							$qo->save();
						}
				

					}
            
                
               return Redirect::to('CreateAssignPODSDivitions')->with("done", true);
            
            
            }
            
          }
	
	public function ViewAssignPODSDivitions()
	{
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$quorga = DB::select(DB::raw("select irpodsdivisions.*,
									  employee.NIC,employee.EPFNo,
									  employee.Initials,
									  employee.LastName,
									  organisation.OrgaName,organisation.Type,
									  employmentcode.Designation,
									  district.DistrictName
									  from irpodsdivisions
									  left join employee
									  on irpodsdivisions.EmpId=employee.id
									  LEFT join district
									  on irpodsdivisions.DistrictCode=district.DistrictCode
									  left join electorate
									  on irpodsdivisions.DSDivisionId=electorate.ElectorateCode
									  left JOIN organisation
									  on employee.CurrentOrgaID=organisation.id
									  left join employmentcode
									  on employee.CurrentDesignation=employmentcode.id
									  where irpodsdivisions.Deleted=0
									  group by irpodsdivisions.EmpId
									  order by district.DistrictName"));
		
			
 		$v = View::make('OJTPO.QuOrga');
 		$v->quorga = $quorga;
		$v->OrgaType = $OegaType;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function PrintOJTPlacedStudents()
  {
		$CenterID = Input::get('CenterIDD');
		$Year = Input::get('YearD');
		$Batch = Input::get('BatchD');
		$district = Input::get('districtD');
		$CYIP = Input::get('CYIPD');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		$html='';
		 if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			   //$district = Input::get('District');
			   $sql = "select irtrainee.*,
                       irtraineeojtplacement.id as ojtplaceiD,
					   district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
                      ircompany.CompanyName,
                      ircompany.Address as CAddress,
                      coursecategory.Category,
                      irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
                      left join irtrainee
                      on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					   and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
                      and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					   and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
						and organisation.DistrictCode='".$district."'
						and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  and organisation.DistrictCode='".$district."'
					  and organisation.id='".$CenterID."'
						and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			 $sql = " select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					  and courseyearplan.Year='".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  and organisation.DistrictCode='".$district."'
					  and organisation.id='".$CenterID."'
					  and courseyearplan.id='".$CYIP."'
					  and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
			
	$trplans = DB::select(DB::raw($sql));
    $i = 1;

     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','District', 'Centre', 'Year', 'Batch','CourseName','CourseListCode','CourseStartedStatus','Instructors','CourseType','NVQStatus','NVQLevel', 'Duration',
	 'NameWithInitials','FullName','NIC','MISNumber','Mobile','Address','Gender','CompanyName','CompanyAddress','JobCategory','StartDate','EndDate','Salary','OJTCompleted','OJTDropout');
     array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

           
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
			   $a = '';
			   $dod = '.';
			   $fbr = '(';
			   $bbr = ')';
			   $instructors = '';
			   $fdates='';
			  
			   $OJTCompleted = '';
			   
			   $OJTDropout = '';
			   
			   foreach($Ins as $m)
				{
					
					$instructors=$instructors.$m->Name.$fbr.$m->EPFNo.$bbr.$com;
					
					
				}
				
				
				if($aa->OJTCompleted == 0)
				{
					$OJTCompleted = 'No';
				}
				elseif($aa->OJTCompleted == 1)
				{
					$OJTCompleted = 'Yes';
				}
				else
				{
					$OJTCompleted = 'Dropout During OJT';
				}
				if($aa->OJTDropout == 0)
				{
					$OJTDropout = 'No';
				}
				else
				{
					$OJTDropout = 'Yes';
				}
				
				
				
				
      array_push($printablearray, array($i,
	  $aa->DistrictName, $aa->OrgaName, 
	  $aa->Year,$aa->batch,
	  $aa->CourseName,
	  $aa->CourseListCode,$aa->StartedStatus, $instructors, $aa->CourseType,$aa->Nvq,$aa->CourseLevel,$aa->Duration,
	  $aa->NameWithInitials,$aa->FullName, 
	  $aa->NIC,
	  $aa->MISNumber,
	  $aa->Mobile,
	  $aa->Address,$aa->Gender,
	  $aa->CompanyName,$aa->CAddress,$aa->Category,$aa->StartingDate,$aa->EndDate,$aa->Salary,
	  $OJTCompleted,$OJTDropout
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('OJTPalcedStudentList');
  }
	
	public function MarkOJTCompletion()
  {
    $OJTPlacementID = Input::get('id');
    $TraineeID =IROJTTraineePlacement::where('id','=',$OJTPlacementID)->pluck('irtraineeID');
	$updatePlacementTable = IROJTTraineePlacement::where('id','=',$OJTPlacementID)->update(array('OJTCompletedF' => 1));
	$updateTraineeTable = IRTrainee::where('id','=',$TraineeID)->update(array('OJTCompleted' => 1));
    return 1;
  }
	public function ViewOJTPlacedStudents()
	{
		$method = Request::getMethod();
    $view = View::make('OJTStudents.ViewOJTPlacedStudents');
    //$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
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
		$sql = "select organisation.* 
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
 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');

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
		$CYIP = Input::get('CourseYearPlanID');
		$district = Input::get('District');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
		  if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			   //$district = Input::get('District');
			   $sql = "select irtrainee.*,
                       irtraineeojtplacement.id as ojtplaceiD,
					   district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
                      ircompany.CompanyName,
                      ircompany.Address as CAddress,
                      coursecategory.Category,
                      irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
                      left join irtrainee
                      on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					   and coursedetails.CourseType='Full'
					    and coursedetails.CourseLevel in(4,5,6)
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
                      and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					   and coursedetails.CourseType='Full'
					    and coursedetails.CourseLevel in(4,5,6)
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
						and organisation.DistrictCode='".$district."'
						and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					   and coursedetails.CourseLevel in(4,5,6)
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  and organisation.DistrictCode='".$district."'
					  and organisation.id='".$CenterID."'
						and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			 $sql = " select irtrainee.*,
                      irtraineeojtplacement.id as ojtplaceiD,
					  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus,
					  ircompany.CompanyName,
					  ircompany.Address as CAddress,
					  coursecategory.Category,
					  irojtvacancy.TrainingArea,
					  irtraineeojtplacement.StartingDate,irtraineeojtplacement.EndDate,
					  irtraineeojtplacement.Salary
					  from irtraineeojtplacement
					  left join irtrainee
					  on irtraineeojtplacement.irtraineeID=irtrainee.id
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join ircompany
					  on irtraineeojtplacement.CompanyID=ircompany.id
					  left join irojtvacancy
					  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
					  left join coursecategory
					  on irojtvacancy.CourseOccupationID=coursecategory.id
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					   and coursedetails.CourseLevel in(4,5,6)
					  and courseyearplan.Year='".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  and organisation.DistrictCode='".$district."'
					  and organisation.id='".$CenterID."'
					  and courseyearplan.id='".$CYIP."'
					  and irtraineeojtplacement.Active=1
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
	$view->CYIPD = $CYIP;
	 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
        return $view;
    }
	
	}
	
	
		public function CreateIRTrainee() 
		{
			
		   $method = Request::getMethod();	
		
          $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
          $view = View::make('OJTStudents.CreateOJTStudent');
		  $view->Districts = District::orderBy('DistrictName')->get();
          $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  
        if ($method == "GET")
        {
            return $view;
        }
          if ($method == "POST") 
            {      
                
               $availabilityMISNo  = IRTrainee::where('Deleted','=',0)->where('MISNumber','=',Input::get('MISNumber'))->where('CourseYearPlanID','=',Input::get('CourseYearPlanID'))->
			   get();
			   if(count($availabilityMISNo) == 0)
			   {
				   $d = new IRTrainee();
				$d->CourseYearPlanID = Input::get('CourseYearPlanID');
				$d->FullName = Input::get('FullName');
				$d->NameWithInitials = Input::get('NameWithInitials');
				$d->NIC = Input::get('NIC');
				$d->MISNumber = Input::get('MISNumber');
				$d->Mobile = Input::get('Mobile');
				$d->Address = Input::get('Address');
				$d->Gender = Input::get('Gender');
				$d->User = User::getSysUser()->userID;
				$d->save();
				
				 return Redirect::to('CreateIRTrainee')->with("done", true);
			   }
			   else
			   {
				   return Redirect::to('CreateIRTrainee')->with("error", true);
			   }
				
                   
                //return Redirect::to('ViewIRJOBPVacancy');
                
			}
        
    }

	
	public function DeleteOJTStudentsPlacement()
	  {
                $id = Input::get('id');
                $quorg = IROJTTraineePlacement::findOrFail($id);
				$quorg->Deleted =1;
				$quorg->Active = 0;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();				// if not found show 404 page
				$TraineeID =IROJTTraineePlacement::where('id','=',$id)->pluck('irtraineeID');
				$getMaxPalceID = IROJTTraineePlacement::where('irtraineeID','=',$TraineeID)->where('Deleted','=',0)->orderBy('id')->max('id');
				if(count($getMaxPalceID) == 0)
				{
					$UpdateTraineeTable = IRTrainee::where('id','=',$TraineeID)->update(array('OJTPlaced' => 0,'OJTCompleted' => 0,'OJTDropout' => 0));
				}
				else
				{
					$updatePlacementTab = IROJTTraineePlacement::where('id','=',$getMaxPalceID)->update(array('Active' => 1,'Deleted' => 0));
				
				    $getFullRec = IROJTTraineePlacement::where('id','=',$getMaxPalceID)->first();
				
				    $UpdateTraineeTable = IRTrainee::where('id','=',$TraineeID)->update(array('OJTPlaced' => 1,'OJTCompleted' => 0,'OJTDropout' => $getFullRec->Dropout));
				}
				
				// Vacancy Relreased particular company
					$VacancyID = IROJTTraineePlacement::where('id','=',$id)->pluck('OJTVacancyID');
					$OJTVacancyTableOCFemale = 0;
					$OJTVacancyTableOCMale = 0;
					//$OJTVacancyTableOCFemaleold = 0;
					//$OJTVacancyTableOCMaleold = 0;
					$Gender = IRTrainee::where('id','=',$TraineeID)->pluck('Gender');
					if($Gender == 'Female')
					{
						$OJTVacancyTableOCFemale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
						$OJTVacancyTableOCFemale = $OJTVacancyTableOCFemale - 1;
						$UpdateVacancyTable = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemale));
						
						//$OldvacancyID1 = IROJTTraineePlacement::where('id','=',$getMaxPalceID)->pluck('OJTVacancyID');
						//$OJTVacancyTableOCFemaleold = IROJTVacancy::where('id','=',$OldvacancyID1)->pluck('OccupiedFemaleVacancy');
						//$OJTVacancyTableOCFemaleold = $OJTVacancyTableOCFemaleold + 1;
						//$UpdateVacancyTable2 = IROJTVacancy::where('id','=',$OldvacancyID1)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemaleold));
					}
					else
					{
						$OJTVacancyTableOCMale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedMaleVacancy');
						$OJTVacancyTableOCMale = $OJTVacancyTableOCMale - 1;
						$UpdateVacancyTable1 = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedMaleVacancy' => $OJTVacancyTableOCMale));
						
						//$OldvacancyID2 = IROJTTraineePlacement::where('id','=',$getMaxPalceID)->pluck('OJTVacancyID');
						//$OJTVacancyTableOCMaleold = IROJTVacancy::where('id','=',$OldvacancyID2)->pluck('OccupiedMaleVacancy');
						//$OJTVacancyTableOCMaleold = $OJTVacancyTableOCMaleold + 1;
						//$UpdateVacancyTable3 = IROJTVacancy::where('id','=',$OldvacancyID2)->update(array('OccupiedMaleVacancy' => $OJTVacancyTableOCMaleold));
					}

                return Redirect::to('ViewOJTStudentHistory');
                
      }
	
	public function AddOJTStudentDropout()
	{
		$CMPlanID = Input::get('id');//get ojtplacement id
		$Comment = Input::get('reason');
		
		$irOJTPlacementTable = IROJTTraineePlacement::where('id','=',$CMPlanID)->update(array('ReasonForDropoutOJT' => $Comment,'Dropout' => '1','OJTCompletedF' => 0));
		$TraineeID =IROJTTraineePlacement::where('id','=',$CMPlanID)->pluck('irtraineeID');
	    $IRTraineeeTable = IRTrainee::where('id','=',$TraineeID)->update(array('OJTDropout' => '1','OJTCompleted' => 0));
		$Gender = IRTrainee::where('id','=',$TraineeID)->pluck('Gender');
	    
		// Vacancy Relreased particular company
		$VacancyID = IROJTTraineePlacement::where('id','=',$CMPlanID)->pluck('OJTVacancyID');
		$OJTVacancyTableOCFemale = 0;
		$OJTVacancyTableOCMale = 0;
		if($Gender == 'Female')
		{
			$OJTVacancyTableOCFemale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
			$OJTVacancyTableOCFemale = $OJTVacancyTableOCFemale - 1;
			$UpdateVacancyTable = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OJTVacancyTableOCFemale));
		}
		else
		{
			$OJTVacancyTableOCMale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedMaleVacancy');
			$OJTVacancyTableOCMale = $OJTVacancyTableOCMale - 1;
			$UpdateVacancyTable1 = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedMaleVacancy' => $OJTVacancyTableOCMale));
		}
		
		

		 return 1;
	
	}
	
	
		public function ViewOJTStudentHistory()
	{
		$method = Request::getMethod();
		$v = View::make('OJTStudents.StudentHistory');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
       
		
        $v->userOrgId = $userOrgId;
        $v->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $v->user = User::getSysUser();
     

        if ($method == "GET") {
            return $v;
        }
		  if ($method == "POST") {
            $Stype = Input::get('SType');
			$NIC = Input::get('NIC');
			
			if($Stype == 'NIC')
			{
				//$GetEmpID = IRTrainee::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('id');
				$Sql = "select irtraineeojtplacement.id,
  irtrainee.id as TraineeId,
  irtrainee.NameWithInitials,irtrainee.NIC,
  irtrainee.MISNumber,irtrainee.Mobile,irtrainee.Gender,
  ircompany.CompanyName,ircompany.Address,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary,
  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
  irtrainee.OJTPlaced,
  irtrainee.OJTCompleted,
  irtraineeojtplacement.Active,irtraineeojtplacement.ReasonForDropoutOJT,irtraineeojtplacement.Dropout
  from irtraineeojtplacement
  left join irtrainee
  on irtraineeojtplacement.irtraineeID=irtrainee.id
  left join irojtvacancy
  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
  left join coursecategory
  on irojtvacancy.CourseOccupationID=coursecategory.id
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtraineeojtplacement.Deleted=0
  and irtrainee.NIC='".$NIC."'
  order by irtraineeojtplacement.id

";
			}
			else
			{
				$GetEmpID = IRTrainee::where('MISNumber','=',$NIC)->where('Deleted','=',0)->pluck('id');
						$Sql = "select irtraineeojtplacement.id,
  irtrainee.id as TraineeId,
  irtrainee.NameWithInitials,irtrainee.NIC,
  irtrainee.MISNumber,irtrainee.Mobile,irtrainee.Gender,
  ircompany.CompanyName,ircompany.Address,
  coursecategory.Category,
  irojtvacancy.TrainingArea,
  irtraineeojtplacement.StartingDate,
  irtraineeojtplacement.EndDate,
  irtraineeojtplacement.Salary,
  district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
  irtrainee.OJTPlaced,
  irtrainee.OJTCompleted,
  irtraineeojtplacement.Active,irtraineeojtplacement.ReasonForDropoutOJT,irtraineeojtplacement.Dropout
  from irtraineeojtplacement
  left join irtrainee
  on irtraineeojtplacement.irtraineeID=irtrainee.id
  left join irojtvacancy
  on irtraineeojtplacement.OJTVacancyID=irojtvacancy.id
  left join coursecategory
  on irojtvacancy.CourseOccupationID=coursecategory.id
  left join ircompany
  on irtraineeojtplacement.CompanyID=ircompany.id
  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtraineeojtplacement.Deleted=0
  and irtrainee.id='".$GetEmpID."'
  order by irtraineeojtplacement.id

";
			}
			
			//return $Sql;							 
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = IRTrainee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
 
	
		public function OJTSplacementtudents() 
		{
			
        $method=Request::getMethod();
		  if($method == 'GET')
        {
          $UserOrgID=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$UserOrgID)->first();
          $OegaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
          $view = View::make('OJTStudents.OJTPlacement');
		  $view->Districts = District::orderBy('DistrictName')->get();
          $loggeduserDistrict = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		  $record = IRTrainee::where('id','=',Input::get('edit_id'))->first();
          $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
          $IRTrainee1 = IRTrainee::find(Input::get('edit_id'));
		  $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
		  $OrgaDistrict = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
		  $DistrictName = District::where('DistrictCode','=',$OrgaDistrict)->pluck('DistrictName');
		  $OrgaName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
		  $CourseName = Course::where('CD_ID','=',$CourseYearPlan1->CD_ID)->pluck('CourseName');
		  $view->Centers = Organisation::where('Deleted','=',0)
                ->where('DistrictCode','=',$OrgaDistrict)
				  ->whereNotIn('Type',['HO','DO','PO'])
				  ->where('Active','=','Yes')
				  ->orderBy('OrgaName')
				->get();
			 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
		/* if($OegaType == 'HO')
		{	
			$view->district = District::orderBy('DistrictName')->get();
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
		}
		elseif($OegaType == 'NVTI')
		{	
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();		
		}
		elseif($OegaType == 'PO')
		{
			$view->district = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		}
		else
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
		} */
        $view->district = District::orderBy('DistrictName')->get(); 
			$view->IRTrainee=$record;
			$view->CourseYearPlan=$CourseYearPlan1;
			$view->DistrictName = $DistrictName;
			$view->OrganisationName = $OrgaName;
			$view->CourseName = $CourseName;
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
			
			  
            
              
                return $view;
		}
              
         if($method == 'POST')
		{
               
              $IRTraineeID = Input::get('edit_id');
			 // $companyID = Input::get('CompanyID');
			  $StartDate = Input::get('StartDate');
			  $EndDate = Input::get('EndDate');
			  $Salary = Input::get('Salary');
			  // $trainee_ids = Input::get('trainee_ids');// vacancy Ids
			  // $ModateTaskIDs = Input::get('ModateTaskIDs');
			  $VacancyID = Input::get('VacancyCode');
			  $companyID = IROJTVacancy::where('id','=',$VacancyID)->pluck('CompanyID');
			  //$countTraineeid = count($trainee_ids);
			  $Gender = IRTrainee::where('id','=',$IRTraineeID)->pluck('Gender');
			 // $CYIP = IRTrainee::where('id','=',$IRTraineeID)->pluck('CourseYearPlanID');
			  //$VacancyID = 0;
              // get jobvacancid
			  /* for($i=0;$i<$countTraineeid;$i++)
				{
					if($i == 0)
					{
					$VacancyID = $trainee_ids[$i];
					}	
					else{
					}	
				} */
				//return $VacancyID;
				//UpdateojtPlacementTable Active column
				$UpdateOJTPlcActive = IROJTTraineePlacement::where('irtraineeID','=',$IRTraineeID)
				->where('Deleted','=',0)
				->update(array('Active' => 0));
				
				//Save to Table
				$d = new IROJTTraineePlacement();
				$d->irtraineeID = $IRTraineeID;
				$d->CompanyID = $companyID;
				$d->OJTVacancyID = $VacancyID;
				$d->StartingDate = $StartDate;
				$d->EndDate = $EndDate;
				$d->Salary = $Salary;
				$d->Dropout = 0;
				$d->OJTCompletedF = 0;
				$d->User = User::getSysUser()->userID;
				$d->PlacementThrough = Input::get('PlacementThrough');
				$d->save();
				$OccupiedVacFemale=0;
				$OccupiedVacMale = 0;
				// Update Available Vacancy Count
				$UpdateTraineeTable = IRTrainee::where('id','=',$IRTraineeID)->update(array('OJTPlaced' => 1,'OJTCompleted' => 0,'OJTDropout' => 0));
				$OJTVacancyType = IROJTVacancy::where('id','=',$VacancyID)->pluck('VacancyType');
				if($OJTVacancyType == 'GenderBased')
				{
					if($Gender == 'Female')
					{
						$OccupiedVacFemale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
						$OccupiedVacFemale = $OccupiedVacFemale +1;
						$UpdateOJTVacancyTableF = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OccupiedVacFemale));
					}
					elseif($Gender == 'Male')
					{
						$OccupiedVacMale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedMaleVacancy');
						$OccupiedVacMale = $OccupiedVacMale +1;
						$UpdateOJTVacancyTableM = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedMaleVacancy' => $OccupiedVacMale));
					}
					else
					{
					}
				}
				else
				{
					$OccupiedVacFemale = IROJTVacancy::where('id','=',$VacancyID)->pluck('OccupiedFemaleVacancy');
					$OccupiedVacFemale = $OccupiedVacFemale +1;
					$UpdateOJTVacancyTableF = IROJTVacancy::where('id','=',$VacancyID)->update(array('OccupiedFemaleVacancy' => $OccupiedVacFemale));
				}
                   
					
					
					$view = View::make('OJTStudents.ViewOJTStudents');
					
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
		$sql = "select organisation.* 
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
	
		
		
		$CenterID = Input::get('CenterIDD');
		$Year = Input::get('YearD');
		$Batch = Input::get('BatchD');
		$district = Input::get('districtD');
		$CYIP = Input::get('CYIPD');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');

        if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
                      district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
                      coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
	and courseyearplan.id='".$CYIP."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		  
	
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
	$view->CYIPD = $CYIP;
    return $view;               //return Redirect::to('ViewTrainingPlanUpdateDisNVTI?');
						//return Redirect::back();
                    
                
        }      
        
    }
	
public function PrintOJTStudents()
  {
		$CenterID = Input::get('CenterIDD');
		$Year = Input::get('YearD');
		$Batch = Input::get('BatchD');
		$district = Input::get('districtD');
		$CYIP = Input::get('CYIPD');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		$html='';
		  if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
                      district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
	and courseyearplan.id='".$CYIP."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		
		  
		
			
	$trplans = DB::select(DB::raw($sql));
    $i = 1;

     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','District', 'Centre', 'Year', 'Batch','CourseName','CourseListCode','CourseStartedStatus','Instructors','CourseType','NVQStatus','NVQLevel', 'Duration',
	 'NameWithInitials','FullName','NIC','MISNumber','Mobile','Address','Gender','Dropout','OJTPlaced','OJTCompleted','OJTDropout','JobPlaced','JobDropout');
     array_push($printablearray, $headerArray);
     foreach ($trplans as $aa) {

           
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
			   $a = '';
			   $dod = '.';
			   $fbr = '(';
			   $bbr = ')';
			   $instructors = '';
			   $fdates='';
			   $Dropout = '';
			   $OJTPlaced = '';
			   $OJTCompleted = '';
			   $JobPlaced = '';
			   $JobDropout = '';
			   $OJTDropout = '';
			   
			   foreach($Ins as $m)
				{
					
					$instructors=$instructors.$m->Name.$fbr.$m->EPFNo.$bbr.$com;
					
					
				}
				if($aa->Dropout == 0)
				{
					$Dropout = 'No';
				}
				else
				{
					$Dropout = 'Yes';
				}
				if($aa->OJTPlaced == 0)
				{
					$OJTPlaced = 'No';
				}
				else
				{
					$OJTPlaced = 'Yes';
				}
				if($aa->OJTCompleted == 0)
				{
					$OJTCompleted = 'No';
				}
				elseif($aa->OJTCompleted == 1)
				{
					$OJTCompleted = 'Yes';
				}
				else
				{
					$OJTCompleted = 'Dropout During OJT';
				}
				if($aa->JobPlaced == 0)
				{
					$JobPlaced = 'No';
				}
				else
				{
					$JobPlaced = 'Yes';
				}
				if($aa->OJTDropout == 0)
				{
					$OJTDropout = 'No';
				}
				else
				{
					$OJTDropout = 'Yes';
				}
				if($aa->JobDropout == 0)
				{
					$JobDropout = 'No';
				}
				else
				{
					$JobDropout = 'Yes';
				}
				
				
				
      array_push($printablearray, array($i,
	  $aa->DistrictName, $aa->OrgaName, 
	  $aa->Year,$aa->batch,
	  $aa->CourseName,
	  $aa->CourseListCode,$aa->StartedStatus, $instructors, $aa->CourseType,$aa->Nvq,$aa->CourseLevel,$aa->Duration,
	  $aa->NameWithInitials,$aa->FullName, 
	  $aa->NIC,
	  $aa->MISNumber,
	  $aa->Mobile,
	  $aa->Address,$aa->Gender,$Dropout,
	  $OJTPlaced,
	  $OJTCompleted,$OJTDropout,
	  $JobPlaced,$JobDropout
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('OJTStudentList');
  }
	
	public function DeleteOJTStudents()
	  {
                $id = Input::get('id');
                $quorg = IRTrainee::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
				
				$DeleteAllFromPlacemeent = IROJTTraineePlacement::where('irtraineeID','=',$id)->update(array('Deleted' => 0));
                return Redirect::to('ViewOJTStudents');
                
      }


	
	public function OJTCourseFilter()
  {
    $CenterID = Input::get('CourseListCode');
	$Batch = Input::get('Batch');
	$Year = Input::get('Year');
	$District = Input::get('District');
    $sql = DB::select(DB::raw("select courseyearplan.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  courseyearplan.Year,
  courseyearplan.batch,
  courseyearplan.medium,
  courseyearplan.RealstartDate,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and courseyearplan.RealstartDate is not null
  and courseyearplan.batch like '$Batch%'
  and courseyearplan.Year='".$Year."'
  and courseyearplan.OrgId='".$CenterID."'
  order by coursedetails.CourseName"));

  return json_encode($sql);
  }
	
		public function editOJTStudents() 
		{
			
       $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
			
			$sql="select usertype.UType
                from usertype
                left join user on
                user.userType=usertype.id
                where user.userID='".User::getSysUser()->userID."'";
          $uType=DB::select(DB::raw($sql));
		
          $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
          $view = View::make('OJTStudents.EditOJTStudent');
		  $view->Districts = District::orderBy('DistrictName')->get();
          $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  $record = IRTrainee::where('id','=',Input::get('edit_id'))->first();
          $CourseYearPlan1 = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->first();		  
          $IRTrainee1 = IRTrainee::find(Input::get('edit_id'));
		  $OrgaID = CourseYearPlan::where('id','=',$record->CourseYearPlanID)->pluck('OrgId');
		  $OrgaDistrict = Organisation::where('id','=',$OrgaID)->pluck('DistrictCode');
		  $view->Centers = Organisation::where('Deleted','=',0)
                ->where('DistrictCode','=',$OrgaDistrict)
				  ->whereNotIn('Type',['HO','DO','PO'])
				  ->where('Active','=','Yes')
				  ->orderBy('OrgaName')
				->get();
				 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
			
			$allcourse = DB::select(DB::raw("select courseyearplan.*,
										  coursedetails.CourseName,coursedetails.CourseType,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel
										  from courseyearplan
										  left join coursedetails
										  on courseyearplan.CD_ID=coursedetails.CD_ID
										  where courseyearplan.Deleted=0
										  and courseyearplan.Year='".$CourseYearPlan1->Year."'
										  and courseyearplan.OrgId='".$OrgaID."'
										  and courseyearplan.batch like '$CourseYearPlan1->batch'
										  order by coursedetails.CourseName"
										  ));
         
			$view->IRTrainee=$record;
			$view->allcourse = $allcourse;
			$view->CourseYearPlan=$CourseYearPlan1;
			$view->selectedDis = $OrgaDistrict;
			$view->CenterIDD=Input::get('CenterIDD');
			$view->YearD=Input::get('YearD');
			$view->BatchD=Input::get('BatchD');
			$view->districtD=Input::get('districtD');
			
			
			  foreach($uType as $ut){
                $userType=$ut->UType;
              }
              $view->userType=$userType;
            
              
                return $view;
		}
                if($method == 'POST')
		{
               
              $IRTraineeID = Input::get('edit_id');
             
				   $updateArray = IRTrainee::where('id','=',Input::get('edit_id'))
				   ->update(array('CourseYearPlanID' => Input::get('CourseYearPlanID'),
				   'FullName' => Input::get('FullName'),
				   'NameWithInitials' => Input::get('NameWithInitials'),
				   'NIC' =>Input::get('NIC'),
				   'MISNumber' => Input::get('MISNumber'),
				   'Mobile' => Input::get('Mobile'),
				   'Address' => Input::get('Address'),
				   'Gender' => Input::get('Gender')));
                   
			//	$CYIP = IRTrainee::where('id','=',Input::get('edit_id'))->pluck('CourseYearPlanID');
					
					$view = View::make('OJTStudents.ViewOJTStudents');
					
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
		$sql = "select organisation.* 
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
	
		
		
		$CenterID = Input::get('CenterIDD');
		$Year = Input::get('YearD');
		$Batch = Input::get('BatchD');
		$district = Input::get('districtD');
		$CYIP = Input::get('CYIPD');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');

       if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
	and courseyearplan.id='".$CYIP."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		  
	
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
	$view->CYIPD = $CYIP;
    return $view;               //return Redirect::to('ViewTrainingPlanUpdateDisNVTI?');
						//return Redirect::back();
                    
                
		
        }
    }
	
    public function ViewOJTStudents()
	{
		$method = Request::getMethod();
    $view = View::make('OJTStudents.ViewOJTStudents');
    //$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
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
		$sql = "select organisation.* 
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
 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');

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
		$CYIP = Input::get('CourseYearPlanID');
		$district = Input::get('District');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
		 if($CenterID == 'All' && $district == 'All' && $CYIP == 'All')
		{
			//$district = Input::get('District');
			   $sql = "select irtrainee.*,
						district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
					  coursedetails.Nvq,
                      coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
					  from irtrainee
					  left join courseyearplan
					  on irtrainee.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  where irtrainee.Deleted=0
					  and courseyearplan.Deleted=0
					  and coursedetails.CourseType='Full'
					   and coursedetails.CourseLevel in(4,5,6)
					  and courseyearplan.Year = '".$Year."'
					  and courseyearplan.batch like '$Batch%'
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID == 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		elseif($CenterID != 'All' && $district != 'All' && $CYIP == 'All')
		{
			$sql = "  select irtrainee.*,
    district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
   and coursedetails.CourseLevel in(4,5,6)
	and courseyearplan.Year = '".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
	and organisation.id='".$CenterID."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		else
		{
			$sql = "  select irtrainee.*,
    				district.DistrictName,organisation.OrgaName,
					  organisation.Type,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.CourseType,
            coursedetails.Nvq,
            coursedetails.CourseLevel,
					  coursedetails.Duration,
					  courseyearplan.medium as Medium,
					  courseyearplan.StartedStatus
  from irtrainee
  left join courseyearplan
  on irtrainee.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where irtrainee.Deleted=0
  and courseyearplan.Deleted=0
  and coursedetails.CourseType='Full'
   and coursedetails.CourseLevel in(4,5,6)
	and courseyearplan.Year='".$Year."'
	and courseyearplan.batch like '$Batch%'
    and organisation.DistrictCode='".$district."'
    and organisation.id='".$CenterID."'
	and courseyearplan.id='".$CYIP."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,irtrainee.id";
		}
		
			
	$trplans = DB::select(DB::raw($sql));
	$view->trplans = $trplans;
	$view->CenterIDD = $CenterID;
	$view->districtD = $district;
    $view->YearD = $Year;
    $view->BatchD = $Batch;
	$view->CYIPD = $CYIP;
	 $view->YearList = CourseYearPlan::where('Deleted', '=', 0)
               ->orderBy('Year', 'Desc')
                ->groupBy('Year')
                ->lists('Year');
        return $view;
    }
	
	}
	
	public function DeleteIRJOBPVacancy()
	{
                $id = Input::get('id');
                $quorg = IRJOBVacancy::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
                return Redirect::to('ViewIRJOBPVacancy');
                
    }
	public function EditIRJOBPVacancy()
	{
			$view = View::make('OJTJobVacancy.Edit');
			$method = Request::getMethod();
			
			

			if ($method == "GET")
			{
			$quorg = IRJOBVacancy::where('id',"=",Input::get('id'))->first();
			$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
			$discode = IRCompany::where("id","=",$quorg->CompanyID)->pluck('DistrictCode');
			
			$elecode = IRCompany::where("id","=",$quorg->CompanyID)->pluck('DSDivision');
			$view->elecode = $elecode;
			$view->user = User::getSysUser();
			$view->electorate = Electorate::where('DistrictCode', "=", $discode)->orderBy('ElectorateName')->get();
		    $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
			$view->quorg = $quorg;
			$view->discode = $discode;
			 $sql = DB::select(DB::raw("select ircompany.*
					  from ircompany
					  where ircompany.Deleted=0
					  and DistrictCode='".$discode."'
					  and DSDivision='".$elecode."'
					  and Active=1
					  order by CompanyName"));
			$view->company = $sql;
			
			$sqloccupation=DB::select(DB::raw("select distinct coursecategory.* 
			  from  coursedetails
			  left join coursecategory
			  on coursedetails.CourseCategoryId=coursecategory.id
			  where coursedetails.Deleted=0 
			  and coursedetails.TradeId='".$quorg->TradeID."'
			  and coursedetails.CourseType='Full'
			  order by coursecategory.Category"));
			  
			  $view->Occupation = $sqloccupation;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = IRJOBVacancy::find(Input::get('QO_ID'));
			$qo->CompanyID = Input::get('CompanyID');
			$qo->TradeID = Input::get('Trade');
			$qo->CourseOccupationID = Input::get('CourseOccupation');
			$qo->TrainingArea = Input::get('TrainingArea');
			$VacancyType = Input::get('VacancyType');
			if($VacancyType == 'NotGenderBased')
			{
				$qo->VacancyFemale = Input::get('VacancyFemale');
		        $qo->VacancyMale = 0;
			}
			else
			{
				 $qo->VacancyFemale = Input::get('VacancyFemale');
		         $qo->VacancyMale = Input::get('VacancyMale');
			}
			
			$qo->SalaryGap = Input::get('SalaryGap');
			$qo->VacancyType = Input::get('VacancyType');
			$qo->Active = Input::get('Active');
			$qo->User = User::getSysUser()->userID;
            $qo->save();
			
			return Redirect::to('ViewIRJOBPVacancy');
			
			
			}
}
	
	public function CreateIRJOBPVacancy()
	{
        $method = Request::getMethod();
        $view = View::make('OJTJobVacancy.Create');
		$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
		$view->electorate = Electorate::where('DistrictCode', "!=", "")->orderBy('ElectorateName')->get();
		$view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new IRJOBVacancy;
                $qo->CompanyID = Input::get('CompanyID');
				$qo->TradeID = Input::get('Trade');
				$qo->CourseOccupationID = Input::get('CourseOccupation');
				$qo->TrainingArea = Input::get('TrainingArea');
				$VacancyType = Input::get('VacancyType');
				if($VacancyType == 'NotGenderBased')
				{
					$qo->VacancyFemale = Input::get('VacancyFemale');
		            $qo->VacancyMale = 0;
				}
				else
				{
					$qo->VacancyFemale = Input::get('VacancyFemale');
		            $qo->VacancyMale = Input::get('VacancyMale');
				}
				
				$qo->SalaryGap = Input::get('SalaryGap');
				$qo->VacancyType = Input::get('VacancyType');
				$qo->User = User::getSysUser()->userID;
                $qo->save();
                return Redirect::to('CreateIRJOBPVacancy')->with("done", true);
            
            
            }
            
    }
	
	public function ViewIRJOBPVacancy()
	{
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		
		if($OegaType == 'HO')
		{
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
										and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									   and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'PO')
		{
			 $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									  and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}
		else
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irjobvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									 orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irjobvacancy
									  left join ircompany
									  on irjobvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irjobvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irjobvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irjobvacancy.Deleted=0
									    and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName"));
		}			
 		$v = View::make('OJTJobVacancy.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function DeleteIROJTVacancy()
	  {
                $id = Input::get('id');
                $quorg = IROJTVacancy::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
                return Redirect::to('ViewIROJTVacancy');
                
            }
	
	public function EditIROJTVacancy()
	{
			$view = View::make('OJTVacancy.Edit');
			$method = Request::getMethod();
			
			

			if ($method == "GET")
			{
			$quorg = IROJTVacancy::where('id',"=",Input::get('id'))->first();
			$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
			$discode = IRCompany::where("id","=",$quorg->CompanyID)->pluck('DistrictCode');
			
			$elecode = IRCompany::where("id","=",$quorg->CompanyID)->pluck('DSDivision');
			$view->elecode = $elecode;
			$view->user = User::getSysUser();
			$view->electorate = Electorate::where('DistrictCode', "=", $discode)->orderBy('ElectorateName')->get();
		    $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
			$view->quorg = $quorg;
			$view->discode = $discode;
			 $sql = DB::select(DB::raw("select ircompany.*
					  from ircompany
					  where ircompany.Deleted=0
					  and DistrictCode='".$discode."'
					  and DSDivision='".$elecode."'
					  and Active=1
					  order by CompanyName"));
			$view->company = $sql;
			
			$sqloccupation=DB::select(DB::raw("select distinct coursecategory.* 
			  from  coursedetails
			  left join coursecategory
			  on coursedetails.CourseCategoryId=coursecategory.id
			  where coursedetails.Deleted=0 
			  and coursedetails.TradeId='".$quorg->TradeID."'
			  and coursedetails.CourseType='Full'
			  order by coursecategory.Category"));
			  
			  $view->Occupation = $sqloccupation;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = IROJTVacancy::find(Input::get('QO_ID'));
			$qo->CompanyID = Input::get('CompanyID');
			$qo->TradeID = Input::get('Trade');
			$qo->CourseOccupationID = Input::get('CourseOccupation');
			$qo->TrainingArea = Input::get('TrainingArea');
			$VacancyType = Input::get('VacancyType');
			$qo->VacancyType = Input::get('VacancyType');
			
			if($VacancyType == 'NotGenderBased')
				{
					$qo->VacancyFemale = Input::get('VacancyFemale');
					$qo->VacancyMale = 0;
				}
				else
				{
					$qo->VacancyFemale = Input::get('VacancyFemale');
					$qo->VacancyMale = Input::get('VacancyMale');
				}
				
			
			$qo->Active = Input::get('Active');
			$qo->User = User::getSysUser()->userID;
            $qo->save();
			
			return Redirect::to('ViewIROJTVacancy');
			
			
			}
}
	
		public function LoadIRTradeOccupation()
    {
        $tradeID = Input::get('TradeId');
     
           $sql="select distinct coursecategory.* 
			  from  coursedetails
			  left join coursecategory
			  on coursedetails.CourseCategoryId=coursecategory.id
			  where coursedetails.Deleted=0 
			  and coursedetails.TradeId='".$tradeID."'
			  and coursedetails.CourseType='Full'
			  order by coursecategory.Category";
  
  $EMP = DB::select(DB::raw($sql));

    return json_encode($EMP);
    }
	
	public function LoadIRCompanyFromElectorate()
	{
		
		$dis = Input::get('District');
		$elec = Input::get('Electorate');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		
		
	if($OegaType == 'HO')
		{	$sql = DB::select(DB::raw("select ircompany.*
			  from ircompany
			  where ircompany.Deleted=0
			  and DistrictCode='".$dis."'
			  and DSDivision='".$elec."'
			  and Active=1
			  order by CompanyName"));
		}	
      elseif($OegaType == 'DO')
	  {
		  
		  $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		  $sql = DB::select(DB::raw("select ircompany.*
		  from ircompany
		  left join organisation
		   on ircompany.UserCenterID=organisation.id
		  where ircompany.Deleted=0
		  and ircompany.DistrictCode='".$dis."'
		  and ircompany.DSDivision='".$elec."'
		  and organisation.DistrictCode='".$DistrictCode."'
		  and ircompany.Active=1
		  order by ircompany.CompanyName"));
		  
	  }
	  elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$sql = DB::select(DB::raw("select ircompany.*
			from ircompany
										  left join organisation
										   on ircompany.UserCenterID=organisation.id
										  where ircompany.Deleted=0
										  and ircompany.DistrictCode='".$dis."'
										  and ircompany.DSDivision='".$elec."'
										  and organisation.id='".$UserOrgID."'
										  and ircompany.Active=1
										  order by ircompany.CompanyName"));							  
									
		}
		elseif($OegaType == 'PO')
		{
			
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$sql = DB::select(DB::raw("select ircompany.*
		  from ircompany
		  left join organisation
		   on ircompany.UserCenterID=organisation.id
		   left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
		  where ircompany.Deleted=0
		  and ircompany.DistrictCode='".$dis."'
		  and ircompany.DSDivision='".$elec."'
		  and orgdis.ProvinceCode='".$ProvinceCode."'
		  and ircompany.Active=1
		  order by ircompany.CompanyName"));
		}
		else{
			
			$UserOrgID = User::getSysUser()->organisationId;
			$sql = DB::select(DB::raw("select ircompany.*
			from ircompany
										  left join organisation
										   on ircompany.UserCenterID=organisation.id
										  where ircompany.Deleted=0
										  and ircompany.DistrictCode='".$dis."'
										  and ircompany.DSDivision='".$elec."'
										  and ircompany.UserCenterID='".$UserOrgID."'
										  and ircompany.Active=1
										  order by ircompany.CompanyName"));
			
		}
	  
	  /* $sql = DB::select(DB::raw("select ircompany.*
  from ircompany
  where ircompany.Deleted=0
  and DistrictCode='".$dis."'
  and DSDivision='".$elec."'
  and Active=1
  order by CompanyName")); */
  
  
	  
	  return json_encode($sql);
	}
	
		public function CreateIROJTVacancy()
	 {
        $method = Request::getMethod();
        $view = View::make('OJTVacancy.Create');
		$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
		$view->electorate = Electorate::where('DistrictCode', "!=", "")->orderBy('ElectorateName')->get();
		$view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new IROJTVacancy;
                $qo->CompanyID = Input::get('CompanyID');
				$qo->TradeID = Input::get('Trade');
				$qo->CourseOccupationID = Input::get('CourseOccupation');
				$qo->TrainingArea = Input::get('TrainingArea');
				$VacancyType = Input::get('VacancyType');
				$qo->VacancyType = Input::get('VacancyType');
				if($VacancyType == 'NotGenderBased')
				{
					$qo->VacancyFemale = Input::get('VacancyFemale');
					$qo->VacancyMale = 0;
				}
				else
				{
					$qo->VacancyFemale = Input::get('VacancyFemale');
					$qo->VacancyMale = Input::get('VacancyMale');
				}
				
				
				$qo->User = User::getSysUser()->userID;
                $qo->save();
                return Redirect::to('CreateIROJTVacancy')->with("done", true);
            
            
            }
            
          }
	
	public function ViewIROJTVacancy()
	{
		
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		if($OegaType == 'HO')
		{
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
										and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		elseif($OegaType == 'NVTI')
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		elseif($OegaType == 'PO')
		{
			 $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									  and organisation.Type not in('NVTI')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		else
		{
			$UserOrgID = User::getSysUser()->organisationId;
			$quorga = DB::select(DB::raw("select irojtvacancy.*,
									  ircompany.CompanyName,ircompany.Address,district.DistrictName,electorate.ElectorateName,
									  coursecategory.Category,
									  orgdis.DistrictName as userdistrict,trade.TradeName,
									  organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from irojtvacancy
									  left join ircompany
									  on irojtvacancy.CompanyID=ircompany.id
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join coursecategory
									  on irojtvacancy.CourseOccupationID=coursecategory.id
									  left join trade
									  on irojtvacancy.TradeID=trade.TradeId
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where irojtvacancy.Deleted=0
									  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  and ircompany.Deleted=0
									   order by ircompany.CompanyName "));
		}
		
									  
 		$v = View::make('OJTVacancy.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ViewIRCompany()
	{
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		
		if($OegaType == 'HO')
		{	$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
												organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
                    left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
											organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join organisation
										on ircompany.UserCenterID=organisation.id
										left join district as orgdis
										on organisation.DistrictCode=orgdis.DistrictCode
										left join user
										on ircompany.User=user.userID
										left join employee
										on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  and (organisation.DistrictCode='".$DistrictCode."' || organisation.OrgaName='Head Office')
										and organisation.Type not in('NVTI')
									  order by ircompany.CompanyName"));
			
		}
		elseif($OegaType == 'NVTI')
		{
									$UserOrgID = User::getSysUser()->organisationId;
									$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
																	organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join organisation
                    on ircompany.UserCenterID=organisation.id
                    left join district as orgdis
                    on organisation.DistrictCode=orgdis.DistrictCode
					left join user
                    on ircompany.User=user.userID
                    left join employee
                    on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
									  order by ircompany.CompanyName"));
		}
		elseif($OegaType == 'PO')
		{
			 $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$ProvinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
			$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
											organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
									  from ircompany
									  left join trade
									  on ircompany.CTradeId=trade.TradeId
									  left join district
									  on ircompany.DistrictCode=district.DistrictCode
									  left join province
									  on district.ProvinceCode=province.ProvinceCode
									  left join electorate
									  on ircompany.DSDivision=electorate.ElectorateCode
									  left join organisation
									  on ircompany.UserCenterID=organisation.id
									  left join district as orgdis
									  on organisation.DistrictCode=orgdis.DistrictCode
									  left join user
									  on ircompany.User=user.userID
									  left join employee
									  on user.EmpId=employee.id
									  where ircompany.Deleted=0
									  and (orgdis.ProvinceCode='".$ProvinceCode."' || organisation.OrgaName='Head Office')
									  and organisation.Type not in('NVTI')
									  order by ircompany.CompanyName"));
									  
									  
		//2021/9/17
		
		}
		else
		{
			$UserOrgID = User::getSysUser()->organisationId;
				$quorga = DB::select(DB::raw("select ircompany.*,district.DistrictName,electorate.ElectorateName,orgdis.DistrictName as userdistrict,trade.TradeName,
													organisation.OrgaName as UserOrganisationName,employee.Initials,employee.LastName
										from ircompany
										left join trade
										on ircompany.CTradeId=trade.TradeId
										left join district
										on ircompany.DistrictCode=district.DistrictCode
										left join electorate
										on ircompany.DSDivision=electorate.ElectorateCode
										left join organisation
										on ircompany.UserCenterID=organisation.id
										left join district as orgdis
										on organisation.DistrictCode=orgdis.DistrictCode
										left join user
										on ircompany.User=user.userID
										left join employee
										on user.EmpId=employee.id
										where ircompany.Deleted=0
										and (ircompany.UserCenterID='".$UserOrgID."' || organisation.OrgaName='Head Office')
										order by ircompany.CompanyName"));
		}
			
 		$v = View::make('OJTCompany.QuOrga');
 		$v->quorga = $quorga;
		$v->OrgaType = $OegaType;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	public function CreateIRCompany()
	 {
        $method = Request::getMethod();
        $view = View::make('OJTCompany.Create');
		$UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
		//$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
        //$institutes = User::getSysUser()->instituteId;
     /*   if($OegaType == 'HO')
		{	
			$view->district = District::orderBy('DistrictName')->get();
		}
		elseif($OegaType == 'DO')
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
		}
		elseif($OegaType == 'NVTI')
		{	
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();		
		}
		elseif($OegaType == 'PO')
		{
			$view->district = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
		}
		else
		{
			$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
		} */
		$view->district = District::orderBy('DistrictName')->get();
		$view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new IRCompany;
                $qo->CompanyName = Input::get('OrgaName');
				$qo->Address = Input::get('Address');
				$qo->DSDivision = Input::get('ElectorateCode');
				$qo->DistrictCode = Input::get('DistrictCode');
				$qo->TelNo = Input::get('Tel');
		        $qo->Email = Input::get('Email');
				$qo->CoordinationOfficerName = Input::get('CoordinatorName');
				$qo->COMobille = Input::get('CTel');
				$qo->CompanyType = Input::get('CompanyType');
				$qo->Ownership = Input::get('Ownership');
                $qo->User = User::getSysUser()->userID;
				$qo->UserCenterID = User::getSysUser()->organisationId;
				//$qo->CTradeID = Input::get('Trade');
                $qo->save();
               return Redirect::to('CreateIRCompany')->with("done", true);
            
            
            }
            
          }
		  
		  public function EditIRCompany()
	{
			$view = View::make('OJTCompany.Edit');
			$method = Request::getMethod();
			$UserOrgID = User::getSysUser()->organisationId; 
			$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
			$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
			$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
			

			if ($method == "GET")
			{
			$quorg = IRCompany::where('id',"=",Input::get('id'))->first();
			//$view->district = District::where('DistrictCode', "!=", "")->orderBy('DistrictName')->get();
			$view->user = User::getSysUser();
			
				/* if($OegaType == 'HO')
				{	
					$view->district = District::orderBy('DistrictName')->get();
				}
				elseif($OegaType == 'DO')
				{
					$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
					$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
				}
				elseif($OegaType == 'NVTI')
				{	
					$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
					$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();		
				}
				elseif($OegaType == 'PO')
				{
					$view->district = District::where('ProvinceCode','=',$loggedUserProvince)->orderBy('DistrictName')->get();
				}
				else
				{
					$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
					$view->district = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
				} */
				
				$view->district = District::orderBy('DistrictName')->get();
			$view->electorate = Electorate::where('DistrictCode', "=", $quorg->DistrictCode)->orderBy('ElectorateName')->get();	
			$view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = IRCompany::find(Input::get('QO_ID'));
			$qo->CompanyName = Input::get('OrgaName');
			$qo->Address = Input::get('Address');
			$qo->DSDivision = Input::get('ElectorateCode');
			$qo->DistrictCode = Input::get('DistrictCode');
			$qo->TelNo = Input::get('Tel');
		    $qo->Email = Input::get('Email');
		    $qo->CoordinationOfficerName = Input::get('CoordinatorName');
			$qo->COMobille = Input::get('CTel');
			$qo->CompanyType = Input::get('CompanyType');
			$qo->Ownership = Input::get('Ownership');
            $qo->User = User::getSysUser()->userID;
			$qo->UserCenterID = User::getSysUser()->organisationId;
			//$qo->CTradeId = Input::get('Trade');
			$qo->Active = Input::get('Active');
			if(Input::get('Active' == '0'))
			{
				$update1 = IROJTVacancy::where('CompanyID','=',Input::get('QO_ID'))->update(array('Active' => 0));
				$update2 = IRJOBVacancy::where('CompanyID','=',Input::get('QO_ID'))->update(array('Active' => 0));
			}
            $qo->save();
			
			return Redirect::to('ViewIRCompany');
			
			
			}
}

       public function DeleteIRCompany()
	  {
                $id = Input::get('id');
                $quorg = IRCompany::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
				
				$deleteOJTVacancy = IROJTVacancy::where('CompanyID','=',$id)->update(array('Deleted' => 1));
				$deleteJobVacancy = IRJOBVacancy::where('CompanyID','=',$id)->update(array('Deleted' => 1));
				
                return Redirect::to('ViewIRCompany');
                
      }

}
