<?php
use SimpleExcel\SimpleExcel;

class HrKPIController extends BaseController {
	
	public function DownloadEmpLPISummeryReport()
	{
	// $District = Input::get('District');
   // $dateRange = Input::get('dateRange');
    //$tempDateRange = explode(" - ", $dateRange);
    //$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
    //$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$ScheduleID = Input::get('ScheduleID');
		   $Schedule= KPISchedule::where('id','=',$ScheduleID)->first();
	//$Year = Input::get('Year');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Centre Type','Division','Name With Initials','Full Name','NIC','EPF No',
	'Designation','Supervisor Name','Supervisor Designation','Submit to the supervisor','Supervisor completion status',
	'KPI Total Weight','KPI Self Achived Weight','KPI Supervisor Achived Weight','KPI Self Achived Percentage',
	'KPI Supervisor Achived Percentage','KPI Self Achived Grade','KPI Supervisor Achived Grade','Comments By the Employee',
	'Comments By the Supervisor');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select district.DistrictName,organisation.OrgaName,organisation.Type, department.DepartmentName,
  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.NIC,
		  hrpromotion.EPF, hremploymentcode.Designation, employeetype.EmployeeType,
  supervisor.Initials as supinitials,supervisor.Name as supName,supervisor.LastName as supLastName,
  kpiemployeecriteriaresult.*
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join kpiemployeecriteriaresult
  on hremployee.id=kpiemployeecriteriaresult.EmpId
  and kpiemployeecriteriaresult.Deleted=0
  AND kpiemployeecriteriaresult.ScheduleId='".$ScheduleID."'
     left join hremployee as supervisor
  on kpiemployeecriteriaresult.SuperviserId=supervisor.id
		left join district
		  on organisation.DistrictCode=district.DistrictCode
		 where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  order by kpiemployeecriteriaresult.SubmitTotheSupervisor DESC,
  organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select district.DistrictName,organisation.OrgaName,organisation.Type, department.DepartmentName,
  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.NIC,
		  hrpromotion.EPF, hremploymentcode.Designation, employeetype.EmployeeType,
  supervisor.Initials as supinitials,supervisor.Name as supName,supervisor.LastName as supLastName,
  kpiemployeecriteriaresult.*
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join kpiemployeecriteriaresult
  on hremployee.id=kpiemployeecriteriaresult.EmpId
  and kpiemployeecriteriaresult.Deleted=0
  AND kpiemployeecriteriaresult.ScheduleId='".$ScheduleID."'
     left join hremployee as supervisor
  on kpiemployeecriteriaresult.SuperviserId=supervisor.id
		left join district
		  on organisation.DistrictCode=district.DistrictCode
		 where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
  		  and district.DistrictCode='".$District."'

		  order by kpiemployeecriteriaresult.SubmitTotheSupervisor DESC,
  organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select district.DistrictName,organisation.OrgaName,organisation.Type, department.DepartmentName,
  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.NIC,
		  hrpromotion.EPF, hremploymentcode.Designation, employeetype.EmployeeType,
  supervisor.Initials as supinitials,supervisor.Name as supName,supervisor.LastName as supLastName,
  kpiemployeecriteriaresult.*
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join kpiemployeecriteriaresult
  on hremployee.id=kpiemployeecriteriaresult.EmpId
  and kpiemployeecriteriaresult.Deleted=0
  AND kpiemployeecriteriaresult.ScheduleId='".$ScheduleID."'
     left join hremployee as supervisor
  on kpiemployeecriteriaresult.SuperviserId=supervisor.id
		left join district
		  on organisation.DistrictCode=district.DistrictCode
		 where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
  		  and district.DistrictCode='".$District."'
		   and organisation.id='".$CenterID."'

		  order by kpiemployeecriteriaresult.SubmitTotheSupervisor DESC,
  organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
    
	 
}
    
    
			foreach($Districtlist as $ds) 
			{
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $ds->DistrictName);
				array_push($data_row, $ds->OrgaName);
				array_push($data_row, $ds->Type);
				$Namewithini = $ds->Initials.' '.$ds->LastName;
				$fullName = $ds->Name.' '.$ds->LastName;
				$SupNamewithini = $ds->supinitials.' '.$ds->supLastName;
				
															if(!empty($ds->SuperviserId ))
											{
											$sql89 = "SELECT hremployee.*,hremploymentcode.Designation,department.DepartmentName
																		  from hrpromotion
																		  left join transfertype
																		  on hrpromotion.TransferType=transfertype.T_ID
																		  left join hremployee
																		  on hrpromotion.Emp_ID=hremployee.id
																		  left join hremploymentcode
																		  on hrpromotion.NewPost=hremploymentcode.id
																		  left join department
																		  on hrpromotion.ToDepartment=department.D_ID
																		  where hrpromotion.Deleted=0
																		  and hrpromotion.Priority=1
																		  and hrpromotion.CurrentRecord='Yes'
																		  and transfertype.Available=1
																		  and hremployee.id='".$ds->SuperviserId."'
																		  limit 1";
																		  
																		  $sup = DB::select(DB::raw($sql89));
  
				$newdata1 =  json_decode(json_encode((array)$sup),true);
				$Designationsup = $newdata1[0]["Designation"];
											}
											else
											{
												$Designationsup = '';

											}
				array_push($data_row, $Namewithini);
				array_push($data_row, $fullName);
				array_push($data_row, $ds->NIC);
				array_push($data_row, $ds->EPF);
				array_push($data_row, $ds->Designation);
				array_push($data_row, $SupNamewithini);
				array_push($data_row, $Designationsup);
				
				if($ds->SubmitTotheSupervisor == 1)
												{
													$empsumit = 'Submitted';
												}
												else{
												   $empsumit = ' Not Submitted';

												}
												
												if($ds->SupervisorCompletedStatus == 1)
												{
													$supsumit = 'Completed';
												}
												else{
												   $supsumit = ' Not Completed';

												}
												
				array_push($data_row, $empsumit);
				array_push($data_row, $supsumit);
				array_push($data_row, $ds->TotalWeight);
				array_push($data_row, $ds->SelfAchivedWeight);
				array_push($data_row, $ds->SupervisorAchivedWeight);
				array_push($data_row, $ds->SelfPercentage);
				array_push($data_row, $ds->SupervisorPercentage);
				array_push($data_row, $ds->GradeAchived);
				array_push($data_row, $ds->SupGradeAchived);
				array_push($data_row, $ds->CommentsByEmployee);
				array_push($data_row, $ds->CommentsByTheSupervisor);



			    array_push($printablearray, $data_row);
				    
            }
		  
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('KPISummeryReportI' . date('Y-m-d'));
	}
		
	
	public function LoadEmpLPISummeryReport()
	{
		//$dateRange = Input::get('dateRange');
       // $tempDateRange = explode(" - ", $dateRange);
       // $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
       // $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

		$District = Input::get('District');
		$CenterID = Input::get('CenterID');
		$ScheduleID = Input::get('ScheduleID');
		   $Schedule= KPISchedule::where('id','=',$ScheduleID)->first();

		
		if($District != 'All')
		{
		$DistrictName = District::where('DistrictCode','=',$District)->pluck('DistrictName');
		}
		else
		{
			$DistrictName = 'All';
		}
		//$Year = Input::get('Year');
		//$Batch = Input::get('Batch');
		$Count = 0;
		$html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $CenterID . '" name="CenterID" id="CenterID"/>
                   
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>KPI Summery Report I<pre><h5>For the Year: '.$Schedule->Year.' & Quater: '.$Schedule->Quater.'</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
							<th align="center" class="center" >Centre</th>
							<th align="center" class="center" >Centre Type</th>
							<th align="center" class="center" >Division</th>

                            <th align="center" class="center" >Name With Initials</th>
							<th align="center" class="center" >Full Name</th>
							<th align="center" class="center" >NIC</th>
							<th align="center" class="center" >EPF No</th>
							<th align="center" class="center" >Designation</th>
							
							<th align="center" class="center" >Supervisor Name</th>
							<th align="center" class="center" >Supervisor Designation</th>
							<th align="center" class="center" >Submit to the supervisor</th>
							<th align="center" class="center" >Supervisor completion status</th>

							<th align="center" class="center" >KPI Total Weight</th>
					        <th align="center" class="center" >KPI Self Achived Weight</th>
					        <th align="center" class="center" >KPI Supervisor Achived Weight</th>
					        <th align="center" class="center" >KPI Self Achived Percentage</th>
					        <th align="center" class="center" >KPI Supervisor Achived Percentage</th>
						    <th align="center" class="center" >KPI Self Achived Grade</th>
						    <th align="center" class="center" >KPI Supervisor Achived Grade</th>
						    <th align="center" class="center" >Comments By the Employee</th>
						    <th align="center" class="center" >Comments By the Supervisor</th>



						 </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select district.DistrictName,organisation.OrgaName,organisation.Type, department.DepartmentName,
  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.NIC,
		  hrpromotion.EPF, hremploymentcode.Designation, employeetype.EmployeeType,
  supervisor.Initials as supinitials,supervisor.Name as supName,supervisor.LastName as supLastName,
  kpiemployeecriteriaresult.*
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join kpiemployeecriteriaresult
  on hremployee.id=kpiemployeecriteriaresult.EmpId
  and kpiemployeecriteriaresult.Deleted=0
  AND kpiemployeecriteriaresult.ScheduleId='".$ScheduleID."'
     left join hremployee as supervisor
  on kpiemployeecriteriaresult.SuperviserId=supervisor.id
		left join district
		  on organisation.DistrictCode=district.DistrictCode
		 where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  order by kpiemployeecriteriaresult.SubmitTotheSupervisor DESC,
  organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select district.DistrictName,organisation.OrgaName,organisation.Type, department.DepartmentName,
  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.NIC,
		  hrpromotion.EPF, hremploymentcode.Designation, employeetype.EmployeeType,
  supervisor.Initials as supinitials,supervisor.Name as supName,supervisor.LastName as supLastName,
  kpiemployeecriteriaresult.*
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join kpiemployeecriteriaresult
  on hremployee.id=kpiemployeecriteriaresult.EmpId
  and kpiemployeecriteriaresult.Deleted=0
  AND kpiemployeecriteriaresult.ScheduleId='".$ScheduleID."'
     left join hremployee as supervisor
  on kpiemployeecriteriaresult.SuperviserId=supervisor.id
		left join district
		  on organisation.DistrictCode=district.DistrictCode
		 where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
  		  and district.DistrictCode='".$District."'

		  order by kpiemployeecriteriaresult.SubmitTotheSupervisor DESC,
  organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select district.DistrictName,organisation.OrgaName,organisation.Type, department.DepartmentName,
  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.NIC,
		  hrpromotion.EPF, hremploymentcode.Designation, employeetype.EmployeeType,
  supervisor.Initials as supinitials,supervisor.Name as supName,supervisor.LastName as supLastName,
  kpiemployeecriteriaresult.*
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join kpiemployeecriteriaresult
  on hremployee.id=kpiemployeecriteriaresult.EmpId
  and kpiemployeecriteriaresult.Deleted=0
  AND kpiemployeecriteriaresult.ScheduleId='".$ScheduleID."'
     left join hremployee as supervisor
  on kpiemployeecriteriaresult.SuperviserId=supervisor.id
		left join district
		  on organisation.DistrictCode=district.DistrictCode
		 where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
  		  and district.DistrictCode='".$District."'
		   and organisation.id='".$CenterID."'

		  order by kpiemployeecriteriaresult.SubmitTotheSupervisor DESC,
  organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
    
	 
}
    
	
    foreach($Districtlist as $ds) {
		
							
									
												
												$html.='<tr>
												<td class="center">' . $i++ . '</td>
												<td class="left">'.$ds->DistrictName.'</td>
												<td class="left">'.$ds->OrgaName.'</td>
												<td class="left">'.$ds->Type.'</td>
												<td class="left">'.$ds->DepartmentName.'</td>';
												$Namewithini = $ds->Initials.' '.$ds->LastName;
												$fullName = $ds->Name.' '.$ds->LastName;
												
												$SupNamewithini = $ds->supinitials.' '.$ds->supLastName;
											if(!empty($ds->SuperviserId ))
											{
											$sql89 = "SELECT hremployee.*,hremploymentcode.Designation,department.DepartmentName
																		  from hrpromotion
																		  left join transfertype
																		  on hrpromotion.TransferType=transfertype.T_ID
																		  left join hremployee
																		  on hrpromotion.Emp_ID=hremployee.id
																		  left join hremploymentcode
																		  on hrpromotion.NewPost=hremploymentcode.id
																		  left join department
																		  on hrpromotion.ToDepartment=department.D_ID
																		  where hrpromotion.Deleted=0
																		  and hrpromotion.Priority=1
																		  and hrpromotion.CurrentRecord='Yes'
																		  and transfertype.Available=1
																		  and hremployee.id='".$ds->SuperviserId."'
																		  limit 1";
																		  
																		  $sup = DB::select(DB::raw($sql89));
  
  $newdata1 =  json_decode(json_encode((array)$sup),true);
$Designationsup = $newdata1[0]["Designation"];
											}
											else
											{
												$Designationsup = '';

											}

									            $html.='<td class="left">'.$Namewithini.'</td>
												<td class="left">'.$fullName.'</td>
												<td class="left">'.$ds->NIC.'</td>
												<td class="left">'.$ds->EPF.'</td>
												<td class="left">'.$ds->Designation.'</td>
												<td class="left">'.$SupNamewithini.'</td>
												<td class="left">'.$Designationsup.'</td>';
												if($ds->SubmitTotheSupervisor == 1)
												{
													$empsumit = 'Submitted';
												}
												else{
												   $empsumit = ' Not Submitted';

												}
												
												if($ds->SupervisorCompletedStatus == 1)
												{
													$supsumit = 'Completed';
												}
												else{
												   $supsumit = ' Not Completed';

												}
												
											$html.='<td class="left">'.$empsumit.'</td>
											<td class="left">'.$supsumit.'</td>
											<td class="left">'.$ds->TotalWeight.'</td>
												<td class="left">'.$ds->SelfAchivedWeight.'</td>
												<td class="left">'.$ds->SupervisorAchivedWeight.'</td>
												<td class="left">'.$ds->SelfPercentage.'</td>
												<td class="left">'.$ds->SupervisorPercentage.'</td>
												<td class="left">'.$ds->GradeAchived.'</td>
												<td class="left">'.$ds->SupGradeAchived.'</td>
												<td class="left">'.$ds->CommentsByEmployee.'</td>
												<td class="left">'.$ds->CommentsByTheSupervisor.'</td><tr/>';
												
												
																					
									
	}
	
												
	$Count = count($Districtlist);
        $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewEmpLPISummeryReport()
	{
		$method = Request::getMethod();
		$view = View::make('KPIReports.ViewKPISummeryf');
		$view->District = District::orderBy('DistrictName')->get();
		$view->Schedules = KPISchedule::where('Deleted','=',0)->orderBy('Year','Quater')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
	  public function KPIApproveCompleteForm()
  {
    $ID = Input::get('id');
    $empid = User::getSysUser()->EmpId;
    $Update = KPIEmployeeCriteriaResult::where('id','=',$ID)
    ->update(array('SupervisorCompletedStatus' => '1'));
     return 1;
  }
	
		 public function ViewSeltKPISuperviseForm()
  {
      $KPIRId = Input::get('id');
      $view = View::make('KPIuperviseForms.TOView');
      $view->HOCMRId = $KPIRId;
      $Questions = DB::select(DB::raw("SELECT kpiemployeecriteriaresultrans.*,kpiemployeecriteria.Criteria,kpiemployeecriteria.Fweight
  from kpiemployeecriteriaresultrans
  left join kpiemployeecriteria
  on kpiemployeecriteriaresultrans.CriteriaId=kpiemployeecriteria.id
  where kpiemployeecriteriaresultrans.Deleted=0
  and kpiemployeecriteriaresultrans.KPIECId='".$KPIRId."'
  ORDER by kpiemployeecriteriaresultrans.id"));


    $method=Request::getMethod();
    $view->Questions = $Questions;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          return $view;
        }
  }
	
	
	public function CreateKPISuperviseForm()
  {
    $KPIRId = Input::get('id');
	$KPIResult = KPIEmployeeCriteriaResult::where('id','=',$KPIRId)->first();

    $view = View::make('KPIuperviseForms.TOCreate');
    $view->HOCMRId = $KPIRId;
	$view->KPIResult = $KPIResult;
   

    $method=Request::getMethod();
    $Questions = DB::select(DB::raw("SELECT kpiemployeecriteria.*
  from kpiemployeecriteriaresultrans
  left join kpiemployeecriteria
  on kpiemployeecriteriaresultrans.CriteriaId=kpiemployeecriteria.id
  where kpiemployeecriteriaresultrans.Deleted=0
  and kpiemployeecriteriaresultrans.KPIECId='".$KPIRId."'
  order by kpiemployeecriteria.id"));	
  
  
    $view->Questions = $Questions;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
         $HOCMRId = Input::get('HOCMRId');
		   $CommentsByTheSupervisor = Input::get('CommentsByTheSupervisor');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
		   $KPIResult = KPIEmployeeCriteriaResult::where('id','=',$HOCMRId)->first();

         
			$CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $Grade = '';
		   
			for($i=0;$i<$CountQuestionsID;$i++)
           {
              $KPITransId = $QuestionsID[$i];
			  
						
			$update = KPIEmployeeCriteriaResultTrans::where('CriteriaId','=',$KPITransId)->where('KPIECId','=',$HOCMRId)->update(array('AchivedMarkBySupervisor' => $AnswerID[$i]));
			
            $FinalMark = $FinalMark +   $AnswerID[$i];
              
           }
		   $totweight = $KPIResult->TotalWeight;

		   $Percentage = Round((($FinalMark/$totweight)*100),0);
			
			if($Percentage >=80)
			{
				$Grade = 'A';
			}
			elseif($Percentage >=60)
			{
				$Grade = 'B';

			}
			elseif($Percentage >=40)
			{
				$Grade = 'C';

			}
			else
			{
				$Grade = 'D';

			}
		   
		   $Updatersult = KPIEmployeeCriteriaResult::where('id','=',$KPIResult->id)
		   ->update(array('SupervisorAchivedWeight' => $FinalMark,'CommentsByTheSupervisor' => $CommentsByTheSupervisor,
		   'SupervisorPercentage' => $Percentage,'SupGradeAchived' => $Grade));

		
           
           // return $view;
            return Redirect::to('ViewKPISuperviseForms');
        }
  }
	
	public function ViewKPISuperviseForms()
  {
    $view = View::make('KPIuperviseForms.EmpQua');
	$empid = User::getSysUser()->EmpId;
	$EPFUser = Employee::where('id','=',$empid)->pluck('EPFNo');
	$hrEmpid = HREmployeeEPFHistory::where('Deleted','=',0)->where('EPFNo','=',$EPFUser)->pluck('EmpId');

	
    $courses = DB::select(DB::raw("select distinct kpiemployeecriteriaresult.*,
  hremployee.Initials,hremployee.LastName,hremployee.NIC,
	hremployee.EPFNo,
  organisation.OrgaName,
  department.DepartmentName,
  hremploymentcode.Designation,
  employeetype.EmployeeType
  from kpiemployeecriteriaresult
  left join hremployee
  on kpiemployeecriteriaresult.EmpId=hremployee.id
  left join hrpromotion
  on hremployee.id=hrpromotion.Emp_ID
  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
where kpiemployeecriteriaresult.Deleted=0
  and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
  and hrpromotion.Priority=1
  and kpiemployeecriteriaresult.SuperviserId='".$hrEmpid."'
  and kpiemployeecriteriaresult.SubmitTotheSupervisor=1
"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	  public function KPISubmitSelfForm()
  {
    $ID = Input::get('id');
    $empid = User::getSysUser()->EmpId;
    $Update = KPIEmployeeCriteriaResult::where('id','=',$ID)
    ->update(array('SubmitTotheSupervisor' => '1'));
     return 1;
  }
	
		
  public function PrintSeltKPIForm()
  {
    $KPIRId = Input::get('resID');
    $html = '';
    //return $CMPID;
	$Questions = DB::select(DB::raw("SELECT kpiemployeecriteriaresultrans.*,kpiemployeecriteria.Criteria,kpiemployeecriteria.Fweight
  from kpiemployeecriteriaresultrans
  left join kpiemployeecriteria
  on kpiemployeecriteriaresultrans.CriteriaId=kpiemployeecriteria.id
  where kpiemployeecriteriaresultrans.Deleted=0
  and kpiemployeecriteriaresultrans.KPIECId='".$KPIRId."'
  ORDER by kpiemployeecriteriaresultrans.id"));
  
  
   $rec =  KPIEmployeeCriteriaResult::where('id','=',$KPIRId)->first();
			 $supervisoLnam = HREmployee::where('id','=',$rec->SuperviserId)->first();
			 
			 $employees = DB::select(DB::raw("SELECT hremployee.*,hremploymentcode.Designation,department.DepartmentName
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremployee
  on hrpromotion.Emp_ID=hremployee.id
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join department
  on hrpromotion.ToDepartment=department.D_ID
  where hrpromotion.Deleted=0
  and hrpromotion.Priority=1
  and hrpromotion.CurrentRecord='Yes'
  and transfertype.Available=1
  and hremployee.id='".$rec->EmpId."'
  limit 1"));
  
  $newdata =  json_decode(json_encode((array)$employees),true);
$DepartmentName = $newdata[0]["DepartmentName"];
$Initials = $newdata[0]["Initials"];
$LastName = $newdata[0]["LastName"];
$EPFNo = $newdata[0]["EPFNo"];
$Designation = $newdata[0]["Designation"];

$sup = DB::select(DB::raw("SELECT hremployee.*,hremploymentcode.Designation,department.DepartmentName
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremployee
  on hrpromotion.Emp_ID=hremployee.id
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join department
  on hrpromotion.ToDepartment=department.D_ID
  where hrpromotion.Deleted=0
  and hrpromotion.Priority=1
  and hrpromotion.CurrentRecord='Yes'
  and transfertype.Available=1
  and hremployee.id='".$rec->SuperviserId."'
  limit 1"));
  
  $newdata1 =  json_decode(json_encode((array)$sup),true);
$Designationsup = $newdata1[0]["Designation"];
		   $ScheduleId = KPISchedule::where('id','=',$rec->ScheduleId)->first();
	

    $html = '<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>KPI Form)</title>
    </head>
	<H3><Center><b>Vocational Training Authority</b></center></H3>
    <H4><Center>KPI Form for the Year '.$ScheduleId->Year.' Quater '.$ScheduleId->Quater.'</center></H4>
   
   
    <table cellspacing="10" align="center" >
	<tr><td>Department:</td> <td>'.$DepartmentName.'</td> <td>Name:</td><td>'.$Initials.' '.$LastName.'</td></tr>
      <tr><td>EPF No:</td> <td>'.$EPFNo.'</td> <td>Designation:</td><td>'.$Designation.'</td></tr>
	   <tr><td>Supervisor:</td> <td>'.$supervisoLnam->Initials.' '.$supervisoLnam->LastName.'</td> <td>Supervisor Designation:</td><td>'.$Designationsup.'</td></tr>';
     
      
    $html.='</table>
    <hr/>
    <table  align="center" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	$i = 1;
	   $html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black"># </font></b></td>
							  <td class="center"><b><font color="black">KPIs </font></b></td>
							   <td class="center"><b><font color="black">Weight </font></b></td>
							   <td class="center"><b><font color="black">Self </font></b></td>
							   <td class="center"><b><font color="black">Supervisor </font></b></td>
                            </tr>
                            
                     ';
    foreach($Questions as $c)
     {         
         
					 $html.='<tr>
                                    <td >'.$i++.'</td>
                                    <td >'.$c->Criteria.'</td>';
									 $html.='<td class="center">'.$c->Fweight.'</td>';
									 $html.='<td class="center">'.$c->SelfAchivedMark.'</td>';
									 $html.='<td class="center">'.$c->AchivedMarkBySupervisor.'</td></tr>';
								
                                    
                
                                
              

                                    
             
                               
                           
    }
             
      $html.='<tr>
								    <th class="center">*</th>
                                    <th class="center"><font color="blue">Total</font></th>
									<th class="center"><font color="blue">'.$rec->TotalWeight.'</font></th>
									<th class="center"><font color="blue">'.$rec->SelfAchivedWeight.'</font></th>
									<th class="center"><font color="blue">'.$rec->SupervisorAchivedWeight.'</font></th>

                                </tr>
								<tr>
								    <th class="center">*</th>
									<th class="center"><font color="green">--</font></th>
                                    <th class="center"><font color="green">Percentage(%)</font></th>
									<th class="center"><font color="green">'.$rec->SelfPercentage.'%</font></th>
									<th class="center"><font color="green">'.$rec->SupervisorPercentage.'%</font></th>

                                </tr>
								<tr>
								    <th class="center">*</th>
                                    <th class="center"><font color="red">--</font></th>
                                    <th class="center"><font color="red">Grade</font></th>
									<th class="center"><font color="red">'.$rec->GradeAchived.'</font></th>
									<th class="center"><font color="red">'.$rec->SupGradeAchived.'</font></th>

                                </tr>

             
             </table>
          
             
	
	
	<h4><u>Comments By the Employee</u></h4><p style="text-align: justify;">';
	
	
	
	
	$html.='<p>'.$rec->CommentsByEmployee.'</p></br>
		<h4><u>Comments By the supervisor</u></h4><p style="text-align: justify;">';

	$html.='<p>'.$rec->CommentsByTheSupervisor.'</p></br>
	
	
    <body></html>';

    return $html;
  }
	
		 public function ViewSeltKPIForm()
  {
      $KPIRId = Input::get('id');
      $view = View::make('KPIForms.TOView');
      $view->HOCMRId = $KPIRId;
      $Questions = DB::select(DB::raw("SELECT kpiemployeecriteriaresultrans.*,kpiemployeecriteria.Criteria,kpiemployeecriteria.Fweight
  from kpiemployeecriteriaresultrans
  left join kpiemployeecriteria
  on kpiemployeecriteriaresultrans.CriteriaId=kpiemployeecriteria.id
  where kpiemployeecriteriaresultrans.Deleted=0
  and kpiemployeecriteriaresultrans.KPIECId='".$KPIRId."'
  ORDER by kpiemployeecriteriaresultrans.id"));


    $method=Request::getMethod();
    $view->Questions = $Questions;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          return $view;
        }
  }
	
	public function EditKPIForm()
  {
    $KPIRId = Input::get('id');
	$ScheduleId = KPISchedule::where('EndingStatus','=',0)->where('Deleted','=',0)->pluck('id');
    //$HOCMRId = KPIEmployeeCriteriaResult::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('ScheduleId','=',$ScheduleId)->pluck('id');
	$KPIResult = KPIEmployeeCriteriaResult::where('id','=',$KPIRId)->first();

    $view = View::make('KPIForms.TOEdit');
    $view->HOCMRId = $KPIRId;
	$view->KPIResult = $KPIResult;
   

    $method=Request::getMethod();
    $Questions = KPIEmployeeCriteria::where('Deleted','=',0)->where('EmpId','=',$KPIResult->EmpId)->where('Active','=',1)->orderBy('id')->get();
	
	$view->employees = DB::select(DB::raw("SELECT hremployee.*,hremploymentcode.Designation
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremployee
  on hrpromotion.Emp_ID=hremployee.id
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  where hrpromotion.Deleted=0
  and hrpromotion.Priority=1
  and hrpromotion.CurrentRecord='Yes'
  and transfertype.Available=1
  order by hremploymentcode.Designation"));
    $view->Questions = $Questions;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
           $HOCMRId = Input::get('HOCMRId');
		   $CommentByEmp = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
           $SupervisorId = Input::get('QO_ID');
		   	$KPIResult = KPIEmployeeCriteriaResult::where('id','=',$KPIRId)->first();

         
			$CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $Grade = '';
		   
			for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
			  
			  $Availability = KPIEmployeeCriteriaResultTrans::where('Deleted','=',0)->where('CriteriaId','=',$IndividualQuestionsID)
								->where('KPIECId','=',$HOCMRId)->count();
								
			if($Availability != 0)
			{
				$update = KPIEmployeeCriteriaResultTrans::where('Deleted','=',0)->where('CriteriaId','=',$IndividualQuestionsID)
								->where('KPIECId','=',$HOCMRId)->update(array('SelfAchivedMark' => $AnswerID[$i],'User' => User::getSysUser()->userID));
			}
			else
			{
              
              $UpdateKPITrans = KPIEmployeeCriteriaResultTrans::
				$c = new KPIEmployeeCriteriaResultTrans();
                $c->CriteriaId = $IndividualQuestionsID;
				$c->EmpId = $KPIResult->EmpId;
                $c->ScheduleId = $ScheduleId;
                $c->SelfAchivedMark = $AnswerID[$i];
                $c->User = User::getSysUser()->userID;
                $c->save();
				
			}

            $FinalMark = $FinalMark +   $AnswerID[$i];
              
           }
		   $totweight = KPIEmployeeCriteria::where('EmpId','=',$KPIResult->EmpId)->where('Deleted','=',0)->where('Active','=',1)->sum('Fweight');

		   $Percentage = Round((($FinalMark/$totweight)*100),0);
			
			if($Percentage >=80)
			{
				$Grade = 'A';
			}
			elseif($Percentage >=60)
			{
				$Grade = 'B';

			}
			elseif($Percentage >=40)
			{
				$Grade = 'C';

			}
			else
			{
				$Grade = 'D';

			}
		   
		   $Updatersult = KPIEmployeeCriteriaResult::where('Deleted','=',0)->where('id','=',$HOCMRId)
		   ->update(array('SelfAchivedWeight' => $FinalMark,'CommentsByEmployee' => $CommentByEmp,
		   'SuperviserId' => $SupervisorId,'User' => User::getSysUser()->userID,'SelfPercentage' => $Percentage,'GradeAchived' => $Grade));

		
           
           // return $view;
            return Redirect::to('ViewKPIForms');
        }
  }
	
	  public function CreateKPIForm()
  {
   
    $view = View::make('KPIForms.TOCreate');
	$EmpId = Input::get('id');
    $Questions = KPIEmployeeCriteria::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('Active','=',1)->orderBy('id')->get();
	$UserOrgID = User::getSysUser()->organisationId; 
 // $view->employees = HREmployee::where("Deleted", "!=", 1)->orderBy('EPFNo')->get();
 
	$view->employees = DB::select(DB::raw("SELECT hremployee.*,hremploymentcode.Designation
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremployee
  on hrpromotion.Emp_ID=hremployee.id
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  where hrpromotion.Deleted=0
  and hrpromotion.Priority=1
  and hrpromotion.CurrentRecord='Yes'
  and transfertype.Available=1
  order by hremploymentcode.Designation"));
 
    $view->Questions = $Questions;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {

		   $EmpId = Input::get('id');
		   $CommentByEmp = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
           $SupervisorId = Input::get('QO_ID');
		   $ScheduleId = KPISchedule::where('EndingStatus','=',0)->where('Deleted','=',0)->pluck('id');

		   

            //Clear data tables
           $deleteKPIEmpResultTransTable = KPIEmployeeCriteriaResultTrans::where('EmpId','=',$EmpId)->where('ScheduleId','=',$ScheduleId)->update(array("Deleted" => 1));
           $deleteKPIEmpResultTable = KPIEmployeeCriteriaResult::where('EmpId','=',$EmpId)->where('ScheduleId','=',$ScheduleId)->update(array("Deleted" => 1));
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $Grade = '';
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              
               
				$c = new KPIEmployeeCriteriaResultTrans();
                $c->CriteriaId = $IndividualQuestionsID;
				$c->EmpId = $EmpId;
                $c->ScheduleId = $ScheduleId;
                $c->SelfAchivedMark = $AnswerID[$i];
                $c->User = User::getSysUser()->userID;
                $c->save();

            $FinalMark = $FinalMark +   $AnswerID[$i];
              
           }
		   
			$totweight = KPIEmployeeCriteria::where('EmpId','=',$EmpId)->where('Deleted','=',0)->where('Active','=',1)->sum('Fweight');
			
			$Percentage = Round((($FinalMark/$totweight)*100),0);
			
			if($Percentage >=80)
			{
				$Grade = 'A';
			}
			elseif($Percentage >=60)
			{
				$Grade = 'B';

			}
			elseif($Percentage >=40)
			{
				$Grade = 'C';

			}
			else
			{
				$Grade = 'D';

			}
			
            $d = new KPIEmployeeCriteriaResult();
            $d->EmpId = $EmpId;
            $d->ScheduleId = $ScheduleId;
            $d->TotalWeight = $totweight;
			$d->SelfAchivedWeight = $FinalMark;
            $d->SuperviserId = $SupervisorId;
            $d->CommentsByEmployee = $CommentByEmp;
			$d->SelfPercentage = $Percentage;
			$d->GradeAchived = $Grade;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = KPIEmployeeCriteriaResult::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('ScheduleId','=',$ScheduleId)->pluck('id');
			
			$updateKPIEmployeeCriteriaResultTrans = KPIEmployeeCriteriaResultTrans::where('EmpId','=',$EmpId)->where('ScheduleId','=',$ScheduleId)
			->where('Deleted','=',0)
			->update(array('KPIECId' => $HOCMRId));


            
            return Redirect::to('ViewKPIForms');

        }
    

  }
	
	public function ViewKPIForms()
  {
    $view = View::make('KPIForms.EmpQua');
	
	if(User::hasPermission('AccsessEnterAllEmployeeKPIForms'))
	{
		 $courses = DB::select(DB::raw("select distinct kpiemployeecriteria.EmpId,
  hremployee.Initials,hremployee.LastName,hremployee.NIC,
	hremployee.EPFNo,
  organisation.OrgaName,
  department.DepartmentName,
  hremploymentcode.Designation,
  employeetype.EmployeeType
  from kpiemployeecriteria
  left join hremployee
  on kpiemployeecriteria.EmpId=hremployee.id
  left join hrpromotion
  on hremployee.id=hrpromotion.Emp_ID
  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
where kpiemployeecriteria.Deleted=0
  and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
  and hrpromotion.Priority=1
"));
		
	}
	else
	{
		
		$empid = User::getSysUser()->EmpId;
	$EPFUser = Employee::where('id','=',$empid)->pluck('EPFNo');
	$hrEmpid = HREmployeeEPFHistory::where('Deleted','=',0)->where('EPFNo','=',$EPFUser)->pluck('EmpId');
		
		$courses = DB::select(DB::raw("select distinct kpiemployeecriteria.EmpId,
  hremployee.Initials,hremployee.LastName,hremployee.NIC,
	hremployee.EPFNo,
  organisation.OrgaName,
  department.DepartmentName,
  hremploymentcode.Designation,
  employeetype.EmployeeType
  from kpiemployeecriteria
  left join hremployee
  on kpiemployeecriteria.EmpId=hremployee.id
  left join hrpromotion
  on hremployee.id=hrpromotion.Emp_ID
  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
  where kpiemployeecriteria.Deleted=0
  and hrpromotion.Deleted=0
  and hremployee.id='".$hrEmpid."'
		  and hrpromotion.CurrentRecord='Yes'
  and hrpromotion.Priority=1
"));
		
	}
   
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	
	public function EndKPISchedule()
	{
		
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$UpdateDelete = KPISchedule::where('id','=',$id)->update(array('EndingStatus' => 1,'User' =>$user));
		
		return Redirect::to('ViewKPISchedule');
	}
	
		public function DeleteKPISchedule()
	{
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$UpdateDelete = KPISchedule::where('id','=',$id)->update(array('Deleted' => 1,'User' =>$user));
		
		return Redirect::to('ViewKPISchedule');
	}
	
	public function EditKPISchedule()
		{
		
		$QId = Input::get('id');
		$method = Request::getMethod();
		$view = View::make('KPISchedule.Edit')->with('user', User::getSysUser());
		
		$view->QID = $QId;
		$cc = KPISchedule::where('id','=',$QId)->get();
		$view->cc = $cc;
		if ($method == "GET") 
		{
			return $view;
		}
		 if ($method == "POST") 
		{
			$id = Input::get('id');
			
		$Quater = Input::get('Quater');
		$Year = Input::get('Year');
		$Description = Input::get('Description');
	    $SubmissionDate = Input::get('SubmissionDate');
			
			$update = KPISchedule::where('id','=',$id)->update(array('Quater' => $Quater,'Year' => $Year, 'Description' => $Description,'SubmissionDate' => $SubmissionDate,'User' => User::getSysUser()->userID,'Updated' =>1));
			return Redirect::to('ViewKPISchedule');
		}
	}
	
	public function SaveAjaxKPISchedule()
	{
		$Quater = Input::get('Quater');
		$Year = Input::get('Year');
		$Description = Input::get('Description');
	    $SubmissionDate = Input::get('SubmissionDate');

	
		$user = User::getSysUser()->userID;
		$available = KPISchedule::where('Quater','=',$Quater)->where('Year','=',$Year)->where('Deleted','=',0)->get();
		$EndnowAvailability = KPISchedule::where('EndingStatus','=',0)->where('Deleted','=',0)->get();
		
		if(count($EndnowAvailability) != 0)
		{
			$getAllDesig = 2;
		}
		else{
		if(count($available) == 0)
		{
			$c = new KPISchedule;
			$c->Year = $Year;
			$c->Quater = $Quater;
			$c->Description = $Description;	
			$c->SubmissionDate = $SubmissionDate;	
			$c->User = $user;
			$c->save();
			
			$getAllDesig = 1;
		}
		else{
			
			$getAllDesig = 0;
		}
		}
		 
		return json_encode($getAllDesig);
	}
	
	public function CreateKPISchedule()
	{
		$method = Request::getMethod();
        $view = View::make('KPISchedule.Create')->with('user', User::getSysUser());
		
		if ($method == "GET") {
            return $view;
        }
	}
	
	public function ViewKPISchedule()
	{
	
     $view = View::make('KPISchedule.View');
	 $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $SalaryScales = KPISchedule::where('Deleted','=',0)->orderBy('Year')->get();
	  $view->SalaryScales = $SalaryScales;
      return $view;
     }
	}
	
	 public function EditHREmployeeKPICriteriaListActiveStatus1()
  {
    $ID = Input::get('id');
    // $empid = User::getSysUser()->EmpId;
    $Update = KPIEmployeeCriteria::where('id','=',$ID)->update(array('Active' => '1'));
     return 1;
  }
	
	 public function EditHREmployeeKPICriteriaListActiveStatus()
  {
    $ID = Input::get('id');
    // $empid = User::getSysUser()->EmpId;
    $Update = KPIEmployeeCriteria::where('id','=',$ID)->update(array('Active' => '0'));
     return 1;
  }
	
	   public function EditHREmployeeKPICriteriaList() {
        $view = View::make('KPICreteria.Edit');
        $method = Request::getMethod();

        if ($method == "GET") {
            $empqua = KPIEmployeeCriteria::where('id', "=", Input::get('id'))->first();
            $EmpId = KPIEmployeeCriteria::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('KPICreteria.Edit')
                    ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
           
            $view->user = User::getSysUser();
            
            $view->empqua = $empqua;
			
           
         
            return $view;
        }
        if ($method == "POST") {
          
            
                
                $oq = KPIEmployeeCriteria::find(Input::get('EQ_ID'));
        
                
               
                $oq->Criteria = Input::get('Criteria');
				$oq->Fweight = Input::get('Fweight');
				$oq->User = User::getSysUser()->userID;
                $oq->Updated = 1;
                if ($oq->save()) {
                    return Redirect::to('ViewHREmployeeKPICriterias');
                }
            
        }
    }
	
	
	public function DeleteHREmployeeKPICriteriaList()
{
    $Id = Input::get('id');
    $user = User::getSysUser()->userID;
	$c = KPIEmployeeCriteria::where('id','=',$Id)->update(array('Deleted' => '1', 'User' => $user));
   
    return Redirect::to('ViewHREmployeeKPICriterias');
}
	
	public function DeleteHREmployeeKPICriteria()
{
    $EmpId = Input::get('id');
    $user = User::getSysUser()->userID;
	$c = KPIEmployeeCriteria::where('EmpId','=',$EmpId)->update(array('Deleted' => '1', 'User' => $user));
   
    return Redirect::to('ViewHREmployeeKPICriterias');
}
	
  public function ViewHREmployeeKPICriteriasList()
  {
    $view = View::make('KPICreteria.CriteriaList');
	$EmpId = Input::get('id');
    $courses = DB::select(DB::raw("SELECT kpiemployeecriteria.*
  from kpiemployeecriteria
  where kpiemployeecriteria.Deleted=0
  and kpiemployeecriteria.EmpId='".$EmpId."'
  order by kpiemployeecriteria.id"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
		public function ViewHREmployeeKPICriterias()
  {
    $view = View::make('KPICreteria.EmpQua');
	

	if(User::hasPermission('AccsessEnterAllEmployeeKPICriteria'))
	{

    $courses = DB::select(DB::raw("select distinct kpiemployeecriteria.EmpId,
  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
  organisation.OrgaName,
  department.DepartmentName,
  hremploymentcode.Designation,
  employeetype.EmployeeType
  from kpiemployeecriteria
  left join hremployee
  on kpiemployeecriteria.EmpId=hremployee.id
  left join hrpromotion
  on hremployee.id=hrpromotion.Emp_ID
  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
where kpiemployeecriteria.Deleted=0
  and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
  and hrpromotion.Priority=1
"));
	}
	else
	{
		
	$empid = User::getSysUser()->EmpId;
	$EPFUser = Employee::where('id','=',$empid)->pluck('EPFNo');
	$hrEmpid = HREmployeeEPFHistory::where('Deleted','=',0)->where('EPFNo','=',$EPFUser)->pluck('EmpId');
		
		$courses = DB::select(DB::raw("select distinct kpiemployeecriteria.EmpId,
  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
  organisation.OrgaName,
  department.DepartmentName,
  hremploymentcode.Designation,
  employeetype.EmployeeType
  from kpiemployeecriteria
  left join hremployee
  on kpiemployeecriteria.EmpId=hremployee.id
  left join hrpromotion
  on hremployee.id=hrpromotion.Emp_ID
  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
where kpiemployeecriteria.Deleted=0
  and hrpromotion.Deleted=0
  and hremployee.id='".$hrEmpid."'
		  and hrpromotion.CurrentRecord='Yes'
  and hrpromotion.Priority=1
"));
	}
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	public function KPICriteriasaveAll(){

            $EmpId = Input::get('EmpId');
			$Criteria = Input::get('Criteria');
			$Fweight = Input::get('Fweight');

              $available = KPIEmployeeCriteria::where('EmpId','=',$EmpId)->where('Criteria','=',$Criteria)->where('Fweight','=',$Fweight)->where('Deleted','=',0)->get();
                
				if(count($available) == 0)
				{	
				$mc = new KPIEmployeeCriteria();
                $mc->EmpId = $EmpId;
                $mc->Criteria = $Criteria;
                $mc->Fweight = $Fweight;
                $mc->User = User::getSysUser()->userID;
                $mc->save();
				
				         
            $html='';
            $html =  '<b>Criteria Added Successfully</b>';
				}
				else
				{
					$update = KPIEmployeeCriteria::where('EmpId','=',$EmpId)->where('Criteria','=',$Criteria)->where('Fweight','=',$Fweight)->where('Deleted','=',0)
					->update(array('Active' => 1));
					
					         
            $html='';
            $html =  '<b>Already have & updated Successfully</b>';
				}
                   
   

            $json = array("done" => $html);
            return json_encode($json, 0);
        }
		
	public function KPIHRnicAjax() {
		
        $EPF = Input::get('epf');
		$empid = User::getSysUser()->EmpId;
		$EPFUser = Employee::where('id','=',$empid)->pluck('EPFNo');
		$hrEmpid = HREmployeeEPFHistory::where('Deleted','=',0)->where('EPFNo','=',$EPFUser)->pluck('EmpId');
		
		if($EPF == $EPFUser || User::hasPermission('AccsessEnterAllEmployeeKPICriteria'))
		{
		$res = 'True';
		$employeeID = HREmployeeEPFHistory::where('EPFNo','=',$EPF)->where('Deleted','=',0)->pluck('EmpId');
        $employeeNIC = HREmployee::where('Deleted', "!=", 1)->where('id', "=", $employeeID)->pluck('NIC');
		$Initials = HREmployee::where('Deleted', "!=", 1)->where('id', "=", $employeeID)->pluck('Initials');
		$LastName = HREmployee::where('Deleted', "!=", 1)->where('id', "=", $employeeID)->pluck('LastName');
		$name = $Initials .' '.$LastName;
        echo $employeeID . '/n/' . $employeeNIC . '/n/' . $name  . '/n/' . $res;
		}
		else
		{
			$res = 'False';
			$employeeID='';
			$employeeNIC='';
			$name='';
		}
        
    }

	
	 public function CreateHREmployeeKPICriterias() 
	 {
        $method = Request::getMethod();
        $view = View::make('KPICreteria.Create');
        $view->user = User::getSysUser();
		
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
        }
    }

}

?>