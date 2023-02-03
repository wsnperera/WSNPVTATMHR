
<?php

use SimpleExcel\SimpleExcel;


class HRReportController extends BaseController {
	
	public function DownloadDistrictInstructorNotTrainingStaffReport()
	{
	 $District = Input::get('District');
   // $dateRange = Input::get('dateRange');
    //$tempDateRange = explode(" - ", $dateRange);
    //$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
    //$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$TradeID = Input::get('TradeID');
	$TrainingType = Input::get('TrainingType');
	$Year = Input::get('Year');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Centre Type','Name With Initials','Full Name','NIC','EPF No','Designation','Training Type','Trade Name','Course Name');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
      trade.TradeName,
      hremployeetradecourse.CourseName
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
      left join trade
      on hremployee.Trade=trade.TradeId
      left join hremployeetradecourse
      on hremployee.TradeCourseId=hremployeetradecourse.id
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hremployee.id NOT IN(select EmpId from hremployeetraining where hremployeetraining.Deleted=0
          and hremployeetraining.TrainingType='".$TrainingType."')
          and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
          and hremploymentcode.Academic='Yes'
          and trade.TradeId='".$TradeID."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
      trade.TradeName,
      hremployeetradecourse.CourseName
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
      left join trade
      on hremployee.Trade=trade.TradeId
      left join hremployeetradecourse
      on hremployee.TradeCourseId=hremployeetradecourse.id
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hremployee.id NOT IN(select EmpId from hremployeetraining where hremployeetraining.Deleted=0
          and hremployeetraining.TrainingType='".$TrainingType."')
          and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
          and hremploymentcode.Academic='Yes'
          and trade.TradeId='".$TradeID."'
		  and district.DistrictCode='".$District."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
      trade.TradeName,
      hremployeetradecourse.CourseName
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
      left join trade
      on hremployee.Trade=trade.TradeId
      left join hremployeetradecourse
      on hremployee.TradeCourseId=hremployeetradecourse.id
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hremployee.id NOT IN(select EmpId from hremployeetraining where hremployeetraining.Deleted=0
          and hremployeetraining.TrainingType='".$TrainingType."')
          and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
          and hremploymentcode.Academic='Yes'
          and trade.TradeId='".$TradeID."'
		  and district.DistrictCode='".$District."'
		  and organisation.id='".$CenterID."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
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
				array_push($data_row, $Namewithini);
				array_push($data_row, $fullName);
				array_push($data_row, $ds->NIC);
				array_push($data_row, $ds->EPF);
				array_push($data_row, $ds->Designation);
				array_push($data_row, $TrainingType);
				array_push($data_row, $ds->TradeName);
				array_push($data_row, $ds->CourseName);
			    array_push($printablearray, $data_row);
				    
            }
		  
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictInstructorsNotTrainedReport' . date('Y-m-d'));
	}
	
		public function LoadDistrictInstructorNotTrainingStaffReport()
	{
	   //$dateRange = Input::get('dateRange');
       // $tempDateRange = explode(" - ", $dateRange);
       // $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
       // $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

		$District = Input::get('District');
		$CenterID = Input::get('CenterID');
		if($District != 'All')
		{
		$DistrictName = District::where('DistrictCode','=',$District)->pluck('DistrictName');
		}
		else
		{
			$DistrictName = 'All';
		}
		$TradeID = Input::get('TradeID');
		$TrainingType = Input::get('TrainingType');
		$TradeName = Trade::where('TradeId','=',$TradeID)->pluck('TradeName');
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
                    
                <h3><center>District Wise Retirement Staff Report<pre><h5>For : '.$DistrictName.' District & Trade - '.$TradeName.'</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
							<th align="center" class="center" >Centre</th>
							<th align="center" class="center" >Centre Type</th>
                            <th align="center" class="center" >Name With Initials</th>
							<th align="center" class="center" >Full Name</th>
							<th align="center" class="center" >NIC</th>
							<th align="center" class="center" >EPF No</th>
							<th align="center" class="center" >Designation</th>
							<th align="center" class="center" >Training Type</th>
							<th align="center" class="center" >Trade Name</th>
							<th align="center" class="center" >Course Name</th>
							
						 </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
      trade.TradeName,
      hremployeetradecourse.CourseName
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
      left join trade
      on hremployee.Trade=trade.TradeId
      left join hremployeetradecourse
      on hremployee.TradeCourseId=hremployeetradecourse.id
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hremployee.id NOT IN(select EmpId from hremployeetraining where hremployeetraining.Deleted=0
          and hremployeetraining.TrainingType='".$TrainingType."')
          and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
          and hremploymentcode.Academic='Yes'
          and trade.TradeId='".$TradeID."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
      trade.TradeName,
      hremployeetradecourse.CourseName
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
      left join trade
      on hremployee.Trade=trade.TradeId
      left join hremployeetradecourse
      on hremployee.TradeCourseId=hremployeetradecourse.id
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hremployee.id NOT IN(select EmpId from hremployeetraining where hremployeetraining.Deleted=0
          and hremployeetraining.TrainingType='".$TrainingType."')
          and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
          and hremploymentcode.Academic='Yes'
          and trade.TradeId='".$TradeID."'
		  and district.DistrictCode='".$District."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
      trade.TradeName,
      hremployeetradecourse.CourseName
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
      left join trade
      on hremployee.Trade=trade.TradeId
      left join hremployeetradecourse
      on hremployee.TradeCourseId=hremployeetradecourse.id
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hremployee.id NOT IN(select EmpId from hremployeetraining where hremployeetraining.Deleted=0
          and hremployeetraining.TrainingType='".$TrainingType."')
          and hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
          and hremploymentcode.Academic='Yes'
          and trade.TradeId='".$TradeID."'
		  and district.DistrictCode='".$District."'
		  and organisation.id='".$CenterID."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
    
	 
}
    
    foreach($Districtlist as $ds) {
		
							
									
												
												$html.='<tr>
												<td class="center">' . $i++ . '</td>
												<td class="left">'.$ds->DistrictName.'</td>
												<td class="left">'.$ds->OrgaName.'</td>
												<td class="left">'.$ds->Type.'</td>';
												$Namewithini = $ds->Initials.' '.$ds->LastName;
												$fullName = $ds->Name.' '.$ds->LastName;
									            $html.='<td class="left">'.$Namewithini.'</td>
												<td class="left">'.$fullName.'</td>
												<td class="left">'.$ds->NIC.'</td>
												<td class="left">'.$ds->EPF.'</td>
												<td class="left">'.$ds->Designation.'</td>
												<td class="left">'.$TrainingType.'</td>
												<td class="left">'.$ds->TradeName.'</td>
												<td class="left">'.$ds->CourseName.'</td>
												<tr/>';
												
												
																					
									
	}
	
												
	$Count = count($Districtlist);
        $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewDistrictInstructorNotTrainingStaffReport()
	{
		$method = Request::getMethod();
		$view = View::make('HRReports.InstructorsNotTraining');
		$view->District = District::orderBy('DistrictName')->get();
		$view->Trade = Trade::where('Deleted','=',0)->orderBy('TradeName')->get();
	//	$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
	public function DownloadDistrictRetirementStaffReport()
	{
	 $District = Input::get('District');
   // $dateRange = Input::get('dateRange');
    //$tempDateRange = explode(" - ", $dateRange);
    //$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
    //$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$Year = Input::get('Year');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Centre Type','Name With Initials','Full Name','NIC','EPF No','Designation','DOB','Date Retire');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
          hremployee.DOB,
          DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as RetireDate
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and YEAR(DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR)) = '".$Year."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
          hremployee.DOB,
          DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as RetireDate
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and YEAR(DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR)) = '".$Year."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
          hremployee.DOB,
          DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as RetireDate
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and organisation.id='".$CenterID."'
		  and YEAR(DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR)) = '".$Year."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
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
				array_push($data_row, $Namewithini);
				array_push($data_row, $fullName);
				array_push($data_row, $ds->NIC);
				array_push($data_row, $ds->EPF);
				array_push($data_row, $ds->Designation);
				array_push($data_row, $ds->DOB);
				array_push($data_row, $ds->RetireDate);
			    array_push($printablearray, $data_row);
				    
            }
		  
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictStaffReport' . date('Y-m-d'));
	}
	
	public function LoadDistrictRetirementStaffReport()
	{
	   //$dateRange = Input::get('dateRange');
       // $tempDateRange = explode(" - ", $dateRange);
       // $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
       // $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

		$District = Input::get('District');
		$CenterID = Input::get('CenterID');
		if($District != 'All')
		{
		$DistrictName = District::where('DistrictCode','=',$District)->pluck('DistrictName');
		}
		else
		{
			$DistrictName = 'All';
		}
		$Year = Input::get('Year');
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
                    
                <h3><center>District Wise Retirement Staff Report<pre><h5>For : '.$DistrictName.' District</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
							<th align="center" class="center" >Centre</th>
							<th align="center" class="center" >Centre Type</th>
                            <th align="center" class="center" >Name With Initials</th>
							<th align="center" class="center" >Full Name</th>
							<th align="center" class="center" >NIC</th>
							<th align="center" class="center" >EPF No</th>
							<th align="center" class="center" >Designation</th>
							<th align="center" class="center" >DOB</th>
							<th align="center" class="center" >Date Retire</th>
						 </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
          hremployee.DOB,
          DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as RetireDate
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and YEAR(DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR)) = '".$Year."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
          hremployee.DOB,
          DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as RetireDate
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and YEAR(DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR)) = '".$Year."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
          hremployee.DOB,
          DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as RetireDate
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and organisation.id='".$CenterID."'
		  and YEAR(DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR)) = '".$Year."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
    
	 
}
    
    foreach($Districtlist as $ds) {
		
							
									
												
												$html.='<tr>
												<td class="center">' . $i++ . '</td>
												<td class="left">'.$ds->DistrictName.'</td>
												<td class="left">'.$ds->OrgaName.'</td>
												<td class="left">'.$ds->Type.'</td>';
												$Namewithini = $ds->Initials.' '.$ds->LastName;
												$fullName = $ds->Name.' '.$ds->LastName;
									            $html.='<td class="left">'.$Namewithini.'</td>
												<td class="left">'.$fullName.'</td>
												<td class="left">'.$ds->NIC.'</td>
												<td class="left">'.$ds->EPF.'</td>
												<td class="left">'.$ds->Designation.'</td>
												<td class="left">'.$ds->DOB.'</td>
												<td class="left">'.$ds->RetireDate.'</td><tr/>';
												
												
																					
									
	}
	
												
	$Count = count($Districtlist);
        $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewDistrictRetirementStaffReport()
	{
		$method = Request::getMethod();
		$view = View::make('HRReports.Retirement');
		$view->District = District::orderBy('DistrictName')->get();
	//	$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
		public function DownloadDistrictAgeServiceStaffReport()
	{
	// $District = Input::get('District');
   // $dateRange = Input::get('dateRange');
    //$tempDateRange = explode(" - ", $dateRange);
    //$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
    //$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

        $District = Input::get('District');
		$ServiceCategoryID = Input::get('ServiceCategoryID');
		$Age = Input::get('Age');
		$SCYear = Input::get('SCYear');
	//$Year = Input::get('Year');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Centre Type','Name With Initials','Full Name','Age','NIC','EPF No','Designation','Service Category','Salary Code');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
if ($District == 'All' && $ServiceCategoryID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrsalaryscale1.Year in('".$SCYear."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
	//	$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $ServiceCategoryID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and hrsalaryscale1.Year in('".$SCYear."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		//$Districtlist = DB::select(DB::raw($sql));
	
}
else if($District = 'All' && $ServiceCategoryID != 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrsalaryscale1.id in('".$ServiceCategoryID."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		//$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and hrsalaryscale1.id in('".$ServiceCategoryID."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";

    
	 
}

		$Districtlist = DB::select(DB::raw($sql));
    
			foreach($Districtlist as $ds) 
			{
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $ds->DistrictName);
				array_push($data_row, $ds->OrgaName);
				array_push($data_row, $ds->Type);
				$Namewithini = $ds->Initials.' '.$ds->LastName;
$fullName = $ds->Name.' '.$ds->LastName;
				array_push($data_row, $Namewithini);
				array_push($data_row, $fullName);
				array_push($data_row, $ds->RealAge);
				array_push($data_row, $ds->NIC);
				array_push($data_row, $ds->EPF);
				array_push($data_row, $ds->Designation);
				array_push($data_row, $ds->PServiceCategory);
				array_push($data_row, $ds->PSalaryCode);
			    array_push($printablearray, $data_row);
				    
            }
		  
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('ServiceCategoryWiseStaffReport' . date('Y-m-d'));
	}
	
	public function ViewDistrictAgeServiceStaffReport()
	{
		$method = Request::getMethod();
		$view = View::make('HRReports.AgeCategory');
		$view->District = District::orderBy('DistrictName')->get();
		$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
		public function LoadDistrictAgeServiceStaffReport()
	{
		//$dateRange = Input::get('dateRange');
       // $tempDateRange = explode(" - ", $dateRange);
       // $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
       // $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

		 $District = Input::get('District');
		$ServiceCategoryID = Input::get('ServiceCategoryID');
		$Age = Input::get('Age');
		$SCYear = Input::get('SCYear');
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
                    <input type="hidden" value="' . $ServiceCategoryID . '" name="ServiceCategoryID" id="CenterID"/>
                   
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>Service Category Wise Staff Report<pre><h5>For : '.$DistrictName.' District</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
							<th align="center" class="center" >Centre</th>
							<th align="center" class="center" >Centre Type</th>
                            <th align="center" class="center" >Name With Initials</th>
							<th align="center" class="center" >Full Name</th>
							<th align="center" class="center" >Age</th>
							<th align="center" class="center" >NIC</th>
							<th align="center" class="center" >EPF No</th>
							<th align="center" class="center" >Designation</th>
							<th align="center" class="center" >Service Category</th>
							<th align="center" class="center" >Salary Code</th>
						 </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
if ($District == 'All' && $ServiceCategoryID == 'All') 
{
	//return 1;
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrsalaryscale1.Year in('".$SCYear."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		
}
else if($District != 'All' && $ServiceCategoryID == 'All')
{
	//return 2;
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and hrsalaryscale1.Year in('".$SCYear."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		
	
}
else if($District == 'All' && $ServiceCategoryID != 'All')
{
	//return 3;
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrsalaryscale1.id in('".$ServiceCategoryID."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		
	
}
else
{
	//return 4;
 //district colombo center dhiwala
$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  and hrsalaryscale1.id in('".$ServiceCategoryID."')
		  and YEAR(CURDATE()) - YEAR(hremployee.DOB) - (RIGHT(CURDATE(), 5) < RIGHT(hremployee.DOB, 5)) <='".$Age."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		
    
	 
}
//return $sql;
$Districtlist = DB::select(DB::raw($sql));
    
    foreach($Districtlist as $ds) {
		
							
									
												
												$html.='<tr>
												<td class="center">' . $i++ . '</td>
												<td class="left">'.$ds->DistrictName.'</td>
												<td class="left">'.$ds->OrgaName.'</td>
												<td class="left">'.$ds->Type.'</td>';
												$Namewithini = $ds->Initials.' '.$ds->LastName;
$fullName = $ds->Name.' '.$ds->LastName;
									            $html.='<td class="left">'.$Namewithini.'</td>
												<td class="left">'.$fullName.'</td>
												<td class="left">'.$ds->RealAge.'</td>
												<td class="left">'.$ds->NIC.'</td>
												<td class="left">'.$ds->EPF.'</td>
												<td class="left">'.$ds->Designation.'</td>
												<td class="left">'.$ds->PServiceCategory.'</td>
												<td class="left">'.$ds->PSalaryCode.'</td><tr/>';
												
												
																					
									
	}
	
												
	$Count = count($Districtlist);
        $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewDistrictStaffReport()
	{
		$method = Request::getMethod();
		$view = View::make('HRReports.ViewDistrictStaff');
		$view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
	public function LoadDistrictStaffReport()
	{
		//$dateRange = Input::get('dateRange');
       // $tempDateRange = explode(" - ", $dateRange);
       // $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
       // $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

		$District = Input::get('District');
		$CenterID = Input::get('CenterID');
		$UpToDate = Input::get('UpToDate');
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
                    
                <h3><center>District Wise Staff Report<pre><h5>For : '.$DistrictName.' District</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
							<th align="center" class="center" >Centre</th>
							<th align="center" class="center" >Centre Type</th>
                            <th align="center" class="center" >Name With Initials</th>
							<th align="center" class="center" >Full Name</th>
							<th align="center" class="center" >NIC</th>
							<th align="center" class="center" >EPF No</th>
							<th align="center" class="center" >Designation</th>
							<th align="center" class="center" >Employee Type</th>
							<th align="center" class="center" >DOB</th>
							<th align="center" class="center" >Age up to date '.$UpToDate.'</th>
						 </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.DOB,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR('".$UpToDate."') - YEAR(hremployee.DOB) - (RIGHT('".$UpToDate."', 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
      and hrsalaryscale.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.DOB,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR('".$UpToDate."') - YEAR(hremployee.DOB) - (RIGHT('".$UpToDate."', 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
      and hrsalaryscale.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.DOB,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR('".$UpToDate."') - YEAR(hremployee.DOB) - (RIGHT('".$UpToDate."', 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
      and hrsalaryscale.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		   and organisation.id='".$CenterID."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
    
	 
}
    
    foreach($Districtlist as $ds) {
		
							
									
												
												$html.='<tr>
												<td class="center">' . $i++ . '</td>
												<td class="left">'.$ds->DistrictName.'</td>
												<td class="left">'.$ds->OrgaName.'</td>
												<td class="left">'.$ds->Type.'</td>';
												$Namewithini = $ds->Initials.' '.$ds->LastName;
$fullName = $ds->Name.' '.$ds->LastName;
									            $html.='<td class="left">'.$Namewithini.'</td>
												<td class="left">'.$fullName.'</td>
												<td class="left">'.$ds->NIC.'</td>
												<td class="left">'.$ds->EPF.'</td>
												<td class="left">'.$ds->Designation.'</td>
												<td class="left">'.$ds->EmployeeType.'</td>
												<td class="left">'.$ds->DOB.'</td>
												<td class="left">'.$ds->RealAge.'</td><tr/>';
												
												
																					
									
	}
	
												
	$Count = count($Districtlist);
        $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function DownloadDistrictStaffReport()
	{
	 $District = Input::get('District');
   // $dateRange = Input::get('dateRange');
    //$tempDateRange = explode(" - ", $dateRange);
    //$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
    //$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
	$CenterID = Input::get('CenterID');
	$UpToDate = Input::get('UpToDate');
	//$Year = Input::get('Year');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Centre','Centre Type','Name With Initials','Full Name','NIC','EPF No','Designation','Employee Type','DOB','Age Up to Date '.$UpToDate.'');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
if ($District == 'All' && $CenterID == 'All') 
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.DOB,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR('".$UpToDate."') - YEAR(hremployee.DOB) - (RIGHT('".$UpToDate."', 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
      and hrsalaryscale.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
}
else if($District != 'All' && $CenterID == 'All')
{
	$sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.DOB,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR('".$UpToDate."') - YEAR(hremployee.DOB) - (RIGHT('".$UpToDate."', 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
      and hrsalaryscale.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
		$Districtlist = DB::select(DB::raw($sql));
	
}
else
{
 //district colombo center dhiwala
 $sql = "select hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,hremployee.DOB,
		  organisation.OrgaName,
		  organisation.Type,
		  department.DepartmentName,
		  transfertype.TransferType,
		  hremploymentcode.Designation,
		  employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrpromotion.IncrementMonth,
		  hrpromotion.IncrementDay,
		  hrgrade.Grade,
		  hrpromotion.SalaryStep,
		  hrpromotion.Priority,
		  district.DistrictName,
		  hrpromotion.CurrentRecord,
		  hrpromotion.StartDate,
		  hrpromotion.SCYear,
		  transfertype.Available,
		  hrpromotion.GratuityAmount,
		  hrpromotion.DateOfTermination,
		  hrpromotion.ETFReleasedDate,
		  hrpromotion.EPFReleasedDate,
		  hrpromotion.ConfirmationDate,
          hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  YEAR('".$UpToDate."') - YEAR(hremployee.DOB) - (RIGHT('".$UpToDate."', 5) < RIGHT(hremployee.DOB, 5)) as RealAge
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
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join district
		  on organisation.DistrictCode=district.DistrictCode
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hremployee.Deleted=0
		  and hremployee.PersonalFileCompleted=1
      and transfertype.Available=1
	  and transfertype.Deleted=0
      and hremploymentcode.Deleted=0
      and employeetype.Deleted=0
      and hrsalaryscale.Deleted=0
	  and hrpromotion.Priority=1
		  and hrpromotion.CurrentRecord='Yes'
		  and district.DistrictCode='".$District."'
		   and organisation.id='".$CenterID."'
		  order by organisation.OrgaName,hremploymentcode.Designation";
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
				array_push($data_row, $Namewithini);
				array_push($data_row, $fullName);
				array_push($data_row, $ds->NIC);
				array_push($data_row, $ds->EPF);
				array_push($data_row, $ds->Designation);
				array_push($data_row, $ds->EmployeeType);
				array_push($data_row, $ds->DOB);
				array_push($data_row, $ds->RealAge);
			    array_push($printablearray, $data_row);
				    
            }
		  
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictStaffReport' . date('Y-m-d'));
	}
}
?>