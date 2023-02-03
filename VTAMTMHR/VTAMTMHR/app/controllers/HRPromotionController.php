<?php
use SimpleExcel\SimpleExcel;

class HRPromotionController extends BaseController {
	
	public function HrEvaluationFormSubmissionStatus()
	{
		$id = Input::get('id');
		$UpdatePrint = HREmployeeSalaryStepData::where('id','=',$id)->update(array('AIFPrint' => 1));
		return 0;
		
	}
	
	public function ActionIncrementReactiveDate()
	{
		$ID = Input::get('id');
		//$ReactiveDate = Input::get('ReactiveDate');
		$NextY = Input::get('NextY');
	    $empid = User::getSysUser()->EmpId;
	    $FutureDatelimit = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('NextIncrementDate');
		$StepID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('SalaryStepTransID');
	    $ScaleID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('ServiceCategoryID');
		$P_ID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('PromotionID');
		$EmpID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('EmpID');
		$ReactiveDate = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('ReactivatedDate');
		// Update Promotion Increment Date and Month
	    $IncrementDate = date("d", strtotime($ReactiveDate));
		$IncrementMonth = date("m", strtotime($ReactiveDate));
		$MOCenterMonitoringPlan = HREmployeeSalaryStepData::where('id','=',$ID)->update(array('Approved' => '5','User' => User::getSysUser()));
		 if($NextY == 'Yes')
		{
		
		$UpdatePromotion1 = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)
		->update(array('IncrementMonth' => $IncrementMonth, 'IncrementDay' => $IncrementDate,'PSalaryStep' => $StepID, 'PServiceCategoryID' => $ScaleID));
		
		$UpdatePromotion2 = HRPromotion::where('P_ID','=',$P_ID)->update(array('PSalaryStep' => $StepID, 'PServiceCategoryID' => $ScaleID));
		
		$GetFutureRec = HREmployeeSalaryStepData::where('EmpID','=',$EmpID)->where('Deleted','=',0)->where('NextIncrementDate','>',$FutureDatelimit)->where('Approved','=',0)->get();
			
			
			foreach($GetFutureRec as $g)
			{
				 $GetNextInrementDateYear = date("Y", strtotime($g->NextIncrementDate));
				 $cc = "select DATE_FORMAT('$ReactiveDate','$GetNextInrementDateYear-%m-%d') as newdate";
				 $UpdateNewDate = DB::select(DB::raw($cc));
				 $newdata22 =  json_decode(json_encode((array)$UpdateNewDate),true);
				 $YearwiseIncrementDateNew = $newdata22[0]["newdate"];
				
				$UpdateUniq = HREmployeeSalaryStepData::where('id','=',$g->id)->update(array('NextIncrementDate' => $YearwiseIncrementDateNew));
			}
		
		} 
		else
		{
			$UpdatePromotion1 = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)
		    ->update(array('PSalaryStep' => $StepID, 'PServiceCategoryID' => $ScaleID));
			$UpdatePromotion2 = HRPromotion::where('P_ID','=',$P_ID)->update(array('PSalaryStep' => $StepID, 'PServiceCategoryID' => $ScaleID));
		}
		
		
			
			
						
	
		return 1;
	}
	
		
	public function DeleteHREmployeeIncrementHistory()
 {
                $id = Input::get('id');
                $quorg = HREmployeeSalaryStepData::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
			
                return Redirect::to('ViewIncrementHistory');
                
            }
	
	
	public function DownloadAnnualIncrementPaymentFormBReactive()
	{
		$id = Input::get('id');
		$HRemployeesalarystepID = HREmployeeSalaryStepData::where('id','=',$id)->first();
		$Initials = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Initials');
		$LastName = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('LastName');
		$HREmploymentCodeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('NewPost');
		$Designation = HREmploymentCode::where('id','=',$HREmploymentCodeID)->pluck('Designation');
		//$FirstAppoDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$HRemployeesalarystepID->EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)->pluck('StartDate');
		$FDateSql = DB::select(DB::raw("SELECT DATE_FORMAT(hrpromotion.StartDate,'%d-%m-%Y') AS niceDate
									  from hrpromotion
									  left join transfertype
									  on hrpromotion.TransferType=transfertype.T_ID
									  left join employeetype
									  on hrpromotion.EmpType=employeetype.ET_ID
									  where hrpromotion.Deleted=0
									  and hrpromotion.Emp_ID='".$HRemployeesalarystepID->EmpID."'
									  and hrpromotion.Priority=1
									  and transfertype.TransferType in('Promotion','FirstAppointment')
									  and employeetype.EmployeeType='Permanent'
									  ORDER by hrpromotion.StartDate DESC
									  limit 1"));
   $FDateSqlaaa =  json_decode(json_encode((array)$FDateSql),true);
   $FirstAppoDate = $FDateSqlaaa[0]["niceDate"];
   
   $DateOfInsql = DB::select(DB::raw("SELECT DATE_FORMAT('".$HRemployeesalarystepID->NextIncrementDate."','%d-%m-%Y') AS incrDate"));
   $FDateOfInsql =  json_decode(json_encode((array)$DateOfInsql),true);
   $DateOfIncrement = $FDateOfInsql[0]["incrDate"];
		$CurrentOrdaID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('ToOrganisation');
		$CurrentOrgaName = Organisation::where('id','=',$CurrentOrdaID)->pluck('OrgaName');
		$EPF = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('EPF');
		
		/* $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.PromotionID='".$HRemployeesalarystepID->PromotionID."'
							    and hremployeesalarystep.Approved not in(0)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1")); */
								
								
							/*  $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved not in(1,5)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
								and hremployeesalarystep.id not in('".$HRemployeesalarystepID->id."')
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1"));
								 */
								 
								  $AA =  "select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved in(1,5)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1";
								
								$sqlp = DB::select(DB::raw($AA));
								
							  /* $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"];
							  $PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"];
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  $PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId'); */
							  
							  $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  //$PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"]; 2020-09-11
							  $PresentserviceCatID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PServiceCategoryID');
							  //$PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"]; 2020-09-11
							  $PresentserviceStepID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PSalaryStep');
							  $PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId');
							  
	$PresentSalaryScale = HRSalaryscale::where('Deleted','=',0)->where('id','=',$PresentserviceCatID)->pluck('SalaryScale');
	$PresentSalaryStepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepNo');
	$PresentSalaryStepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepAmount');
	$NextsalarystepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepNo');
	$NextsalarystepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepAmount');
	$sqladdyearass = DB::select(DB::raw("select DATE_SUB('".$HRemployeesalarystepID->NextIncrementDate."', INTERVAL 1 YEAR) as newdate"));
							$newdata322 =  json_decode(json_encode((array)$sqladdyearass),true);
							$expectedcomstepassFrom = $newdata322[0]["newdate"];
							
	//hremployeesal conversion
	
	$PresentSalaryBasicSQL = DB::select(DB::raw("select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$PresentserviceCatID."'
											  and hrsalaryconversionincrement.StepTransID='".$PresentserviceStepID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$PresentGradeID."'"));
											  
											  if(count($PresentSalaryBasicSQL) == 0)
											  {
												  $PresentBasicSalary = '';
												  $PresentAdjusmentAllowence = '';
											  }
											  else
											  {
											  $newdataaaPressal =  json_decode(json_encode((array)$PresentSalaryBasicSQL),true);
											  $PresentBasicSalary = $newdataaaPressal[0]["BasicSalary"];
											  $PresentAdjusmentAllowence = $newdataaaPressal[0]["AdjusmentAllowence"];
											  }
	//NextIncrementDate
	$NextGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('GradeId');
	$NextSalaryBasicSQL = DB::select(DB::raw("select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$HRemployeesalarystepID->ServiceCategoryID."'
											  and hrsalaryconversionincrement.StepTransID='".$HRemployeesalarystepID->SalaryStepTransID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$NextGradeID."'"));
											  
											  if(count($NextSalaryBasicSQL) == 0)
											  {
												  $NextBasicSalary = '';
												  $NextAdjusmentAllowence = '';
											  }
											  else
											  {
											  $newdataaaNextssal =  json_decode(json_encode((array)$NextSalaryBasicSQL),true);
											  $NextBasicSalary = $newdataaaNextssal[0]["BasicSalary"];
											  $NextAdjusmentAllowence = $newdataaaNextssal[0]["AdjusmentAllowence"];
											  }
											  
	
	//end
	$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'-%m-%Y') AS SYSdateName"));
   $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
   $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
	$PersonalFileNAme = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$HRemployeesalarystepID->EmpID)->pluck('FileNo');
	
	$GenderName = "";						  
	$Gender = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Sex');
	if($Gender == 'Male')
	{
		$GenderName = 'Mr';
	}
	elseif($Gender == 'Female')
	{
		$GenderName = 'Ms';
	}
	else
	{
		$GenderName = "";
	}
	
	
	if(date('Y', strtotime($DateOfIncrement)) <= 2019)
	{
		//return '2019';
	$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}
	else
	{
		//return '2020';
		$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	</tr>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}



    return $html;	
							
	}
	
	public function DownloadAnnualIncrementPaymentFormReactive()
	{
		 $id = Input::get('id');
		$HRemployeesalarystepID = HREmployeeSalaryStepData::where('id','=',$id)->first();
		$Initials = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Initials');
		$LastName = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('LastName');
		$HREmploymentCodeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('NewPost');
		$Designation = HREmploymentCode::where('id','=',$HREmploymentCodeID)->pluck('Designation');
		//$FirstAppoDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$HRemployeesalarystepID->EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)->pluck('StartDate');
		$FDateSql = DB::select(DB::raw("SELECT DATE_FORMAT(hrpromotion.StartDate,'%d-%m-%Y') AS niceDate
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join employeetype
  on hrpromotion.EmpType=employeetype.ET_ID
  where hrpromotion.Deleted=0
  and hrpromotion.Emp_ID='".$HRemployeesalarystepID->EmpID."'
  and hrpromotion.Priority=1
  and transfertype.TransferType in('Promotion','FirstAppointment')
  and employeetype.EmployeeType='Permanent'
  ORDER by hrpromotion.StartDate DESC
  limit 1"));
   $FDateSqlaaa =  json_decode(json_encode((array)$FDateSql),true);
   $FirstAppoDate = $FDateSqlaaa[0]["niceDate"];
   
   $DateOfInsql = DB::select(DB::raw("SELECT DATE_FORMAT('".$HRemployeesalarystepID->NextIncrementDate."','%d-%m-%Y') AS incrDate"));
   $FDateOfInsql =  json_decode(json_encode((array)$DateOfInsql),true);
   $DateOfIncrement = $FDateOfInsql[0]["incrDate"];
		$CurrentOrdaID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('ToOrganisation');
		$CurrentOrgaName = Organisation::where('id','=',$CurrentOrdaID)->pluck('OrgaName');
		$EPF = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('EPF');
		
		/* $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.PromotionID='".$HRemployeesalarystepID->PromotionID."'
							    and hremployeesalarystep.Approved not in(0)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1")); */
								
								
							/*  $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved not in(1,5)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
								and hremployeesalarystep.id not in('".$HRemployeesalarystepID->id."')
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1")); */
								
								$AA =  "select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved in(1,5)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1";
								
								$sqlp = DB::select(DB::raw($AA));
								
								
							 /*  $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"];
							  $PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"];
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  $PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId'); */
							  $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  //$PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"]; 2020-09-11
							  $PresentserviceCatID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PServiceCategoryID');
							  //$PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"]; 2020-09-11
							  $PresentserviceStepID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PSalaryStep');
							  $PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId');
							  
							$PresentSalaryScale = HRSalaryscale::where('Deleted','=',0)->where('id','=',$PresentserviceCatID)->pluck('SalaryScale');
							$PresentSalaryStepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepNo');
							$PresentSalaryStepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepAmount');
							$NextsalarystepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepNo');
							$NextsalarystepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepAmount');
							$sqladdyearass = DB::select(DB::raw("select DATE_SUB('".$HRemployeesalarystepID->NextIncrementDate."', INTERVAL 1 YEAR) as newdate"));
							$newdata322 =  json_decode(json_encode((array)$sqladdyearass),true);
							$expectedcomstepassFrom = $newdata322[0]["newdate"];
							
	//hremployeesal conversion
	
	$PresentSalaryBasicSQL = DB::select(DB::raw("select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$PresentserviceCatID."'
											  and hrsalaryconversionincrement.StepTransID='".$PresentserviceStepID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$PresentGradeID."'"));
											  
											  if(count($PresentSalaryBasicSQL) == 0)
											  {
												  $PresentBasicSalary = '';
												  $PresentAdjusmentAllowence = '';
											  }
											  else
											  {
											  $newdataaaPressal =  json_decode(json_encode((array)$PresentSalaryBasicSQL),true);
											  $PresentBasicSalary = $newdataaaPressal[0]["BasicSalary"];
											  $PresentAdjusmentAllowence = $newdataaaPressal[0]["AdjusmentAllowence"];
											  }
	//NextIncrementDate
	 
	$NextGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('PGradeId'); //Change Grade ID to Pgrade ID in Promotion Table
	$NextSalaryBasicSQL = DB::select(DB::raw("select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$HRemployeesalarystepID->ServiceCategoryID."'
											  and hrsalaryconversionincrement.StepTransID='".$HRemployeesalarystepID->SalaryStepTransID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$NextGradeID."'"));
											  
											  if(count($NextSalaryBasicSQL) == 0)
											  {
												  $NextBasicSalary = '';
												  $NextAdjusmentAllowence = '';
											  }
											  else
											  {
											  $newdataaaNextssal =  json_decode(json_encode((array)$NextSalaryBasicSQL),true);
											  $NextBasicSalary = $newdataaaNextssal[0]["BasicSalary"];
											  $NextAdjusmentAllowence = $newdataaaNextssal[0]["AdjusmentAllowence"];
											  }
											  
	
	//end
	$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'-%m-%Y') AS SYSdateName"));
   $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
   $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
	$PersonalFileNAme = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$HRemployeesalarystepID->EmpID)->pluck('FileNo');
	
	$GenderName = "";						  
	$Gender = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Sex');
	if($Gender == 'Male')
	{
		$GenderName = 'Mr';
	}
	elseif($Gender == 'Female')
	{
		$GenderName = 'Ms';
	}
	else
	{
		$GenderName = "";
	}
	
	
	if(date('Y', strtotime($DateOfIncrement)) <= 2019)
	{
		//return '2019';
	$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}
	else
	{
		//return '2020';
		$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
     : '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$HRemployeesalarystepID->ReactivatedDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}



    return $html;	
							
	}
	
	public function DownloadAnnualIncrementPaymentFormB()
	{
		$id = Input::get('id');
		$HRemployeesalarystepID = HREmployeeSalaryStepData::where('id','=',$id)->first();
		$Initials = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Initials');
		$LastName = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('LastName');
		$HREmploymentCodeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('NewPost');
		$Designation = HREmploymentCode::where('id','=',$HREmploymentCodeID)->pluck('Designation');
		//$FirstAppoDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$HRemployeesalarystepID->EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)->pluck('StartDate');
		$FDateSql = DB::select(DB::raw("SELECT DATE_FORMAT(hrpromotion.StartDate,'%d-%m-%Y') AS niceDate
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join employeetype
  on hrpromotion.EmpType=employeetype.ET_ID
  where hrpromotion.Deleted=0
  and hrpromotion.Emp_ID='".$HRemployeesalarystepID->EmpID."'
  and hrpromotion.Priority=1
  and transfertype.TransferType in('Promotion','FirstAppointment')
  and employeetype.EmployeeType='Permanent'
  ORDER by hrpromotion.StartDate DESC
  limit 1"));
   $FDateSqlaaa =  json_decode(json_encode((array)$FDateSql),true);
   $FirstAppoDate = $FDateSqlaaa[0]["niceDate"];
   
   $DateOfInsql = DB::select(DB::raw("SELECT DATE_FORMAT('".$HRemployeesalarystepID->NextIncrementDate."','%d-%m-%Y') AS incrDate"));
   $FDateOfInsql =  json_decode(json_encode((array)$DateOfInsql),true);
   $DateOfIncrement = $FDateOfInsql[0]["incrDate"];
		$CurrentOrdaID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('ToOrganisation');
		$CurrentOrgaName = Organisation::where('id','=',$CurrentOrdaID)->pluck('OrgaName');
		$EPF = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('EPF');
		
		/* $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.PromotionID='".$HRemployeesalarystepID->PromotionID."'
							    and hremployeesalarystep.Approved not in(0)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1")); */
								
								
							/*  $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved not in(0)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1")); */
								
								$AA =  "select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved in(1,5)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1";
								
								$sqlp = DB::select(DB::raw($AA));
								
								
							  $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  //$PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"]; 2020-09-11
							  $PresentserviceCatID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PServiceCategoryID');
							  //$PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"]; 2020-09-11
							  $PresentserviceStepID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PSalaryStep');
							  $PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId');
	
	$PresentSalaryScale = HRSalaryscale::where('Deleted','=',0)->where('id','=',$PresentserviceCatID)->pluck('SalaryScale');
	$PresentSalaryStepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepNo');
	$PresentSalaryStepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepAmount');
	$NextsalarystepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepNo');
	$NextsalarystepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepAmount');
	$sqladdyearass = DB::select(DB::raw("select DATE_SUB('".$HRemployeesalarystepID->NextIncrementDate."', INTERVAL 1 YEAR) as newdate"));
							$newdata322 =  json_decode(json_encode((array)$sqladdyearass),true);
							$expectedcomstepassFrom = $newdata322[0]["newdate"];
							
	//hremployeesal conversion
	
    // $PresentGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('PGradeId');
	$PresentSalaryBasicSQL = DB::select(DB::raw("select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$PresentserviceCatID."'
											  and hrsalaryconversionincrement.StepTransID='".$PresentserviceStepID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$PresentGradeID."'"));
											  
											  if(count($PresentSalaryBasicSQL) == 0)
											  {
												  $PresentBasicSalary = '';
												  $PresentAdjusmentAllowence = '';
											  }
											  else
											  {
											  $newdataaaPressal =  json_decode(json_encode((array)$PresentSalaryBasicSQL),true);
											  $PresentBasicSalary = $newdataaaPressal[0]["BasicSalary"];
											  $PresentAdjusmentAllowence = $newdataaaPressal[0]["AdjusmentAllowence"];
											  }
	//NextIncrementDate
	$NextGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('GradeId');
	$NextSalaryBasicSQL = DB::select(DB::raw("select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$HRemployeesalarystepID->ServiceCategoryID."'
											  and hrsalaryconversionincrement.StepTransID='".$HRemployeesalarystepID->SalaryStepTransID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$NextGradeID."'"));
											  
											  if(count($NextSalaryBasicSQL) == 0)
											  {
												  $NextBasicSalary = '';
												  $NextAdjusmentAllowence = '';
											  }
											  else
											  {
											  $newdataaaNextssal =  json_decode(json_encode((array)$NextSalaryBasicSQL),true);
											  $NextBasicSalary = $newdataaaNextssal[0]["BasicSalary"];
											  $NextAdjusmentAllowence = $newdataaaNextssal[0]["AdjusmentAllowence"];
											  }
											  
	
	//end
	$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'-%m-%Y') AS SYSdateName"));
   $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
   $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
	$PersonalFileNAme = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$HRemployeesalarystepID->EmpID)->pluck('FileNo');
	
	$GenderName = "";						  
	$Gender = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Sex');
	if($Gender == 'Male')
	{
		$GenderName = 'Mr';
	}
	elseif($Gender == 'Female')
	{
		$GenderName = 'Ms';
	}
	else
	{
		$GenderName = "";
	}
	
	
	if(date('Y', strtotime($DateOfIncrement)) <= 2019)
	{
		//return '2019';
	$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}
	else
	{
		//return '2020';
		$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	</tr>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	<p>This is refers to administrative circular No: 03(i)/2020 and 26.11.2021 dated regarding implementation of the officials language policy.</p>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}



    return $html;	
							
	}
	
	public function DeleteHREmployeeServiceLetter()
 {
                $id = Input::get('id');
                $quorg = HREmployeeServiceLetter::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
				
                return Redirect::to('ViewHREmployeeServiceLettersIssued');
                
 }
	

	public function DownloadHREmployeeServiceLetter()
	{
		$EmpId = Input::get('EmpId');
		$original_date = Input::get('DateIssued');
		$AddressLine1 = Input::get('AddressLine1');
		$AddressLine2 = Input::get('AddressLine2');
		$AddressLine3 = Input::get('AddressLine3');
		$AddressLine4 = Input::get('AddressLine4');
		$AddressLine5 = Input::get('AddressLine5');
		$AddressLine6 = Input::get('AddressLine6');
		$Signature = Input::get('Signature');
		
		$timestamp = strtotime($original_date);
        $DateIssued = date("d-m-Y", $timestamp);
		
		
		$Initials = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('Initials');
	    $LastName = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('LastName');
		$Gender = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('Sex');
		$GenderName = '';
		if($Gender == 'Male')
		{
			$GenderName = 'Mr';
		}
		else
		{
			$GenderName = 'Ms';
		}
		$FName = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('Name');
		$NIC = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('NIC');
		$EPFNO = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('EPFNo');
		$PerAddress = HREmployee::where('id','=',$EmpId)->where('Deleted','=',0)->pluck('PAddress');
		$PFileNumber = HREmployeePersonalFileDoc::where('EmpId','=',$EmpId)->where('Deleted','=',0)->where('Active','=',1)->pluck('FileNo');
		$PFileNumberID = HREmployeePersonalFileDoc::where('EmpId','=',$EmpId)->where('Deleted','=',0)->where('Active','=',1)->pluck('id');
		$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'%d-%m-%Y') AS SYSdateName"));
	    $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
	    $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
		
		$promotion = "select distinct hrpromotion.P_ID,
		hremployee.NIC,
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
		  left join hremployeeepfhistory
          on hremployee.id=hremployeeepfhistory.EmpId
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
		  left join trade
          on hremployee.Trade=trade.TradeId
		  left join hremployeetradecourse
		  on hremployee.TradeCourseId=hremployeetradecourse.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrpromotion.Priority='1'
		  and hremployeeepfhistory.Deleted=0
		  and hrpromotion.Emp_ID='".$EmpId."'
		  and hremployee.Deleted=0
		  order by hremploymentcode.Designation,transfertype.Available";
		  
		  $promotionsys = DB::select(DB::raw($promotion));
	    $promotionsyssql =  json_decode(json_encode((array)$promotionsys),true);
	    $Designation = $promotionsyssql[0]["Designation"];
		$TradeName = $promotionsyssql[0]["TradeName"];
		$CourseName = $promotionsyssql[0]["CourseName"];
		  
		  
		  $Promotion2 ="select  distinct hrpromotion.P_ID,hremployee.NIC,
		  hremployee.OldNIC,
		  hrpromotion.EPF,
		  hremployee.Initials,hremployee.Name,hremployee.LastName,
		  organisation.OrgaName,
		  organisation.Type,
          min(hrpromotion.StartDate) AS StartDate,
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
		  left join hremployeeepfhistory
          on hremployee.id=hremployeeepfhistory.EmpId
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
		  left join trade
          on hremployee.Trade=trade.TradeId
		   left join hremployeetradecourse
		  on hremployee.TradeCourseId=hremployeetradecourse.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.Priority='1'
		  and hremployeeepfhistory.Deleted=0
		  and hrpromotion.Emp_ID='".$EmpId."'
		  and hremployee.Deleted=0
          and transfertype.TransferType in('FirstAppointment','Promotion','ChangeofDesignation')
         GROUP by hremploymentcode.Designation,employeetype.EmployeeType
		  order by hrpromotion.StartDate";
		  
		  $promotionsys2 = DB::select(DB::raw($Promotion2));
		  
		  $startdates ="select  distinct hrpromotion.P_ID,
          min(hrpromotion.StartDate) AS StartDate,
		  hrsalaryscale.ServiceCategory
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join hremployeeepfhistory
          on hremployee.id=hremployeeepfhistory.EmpId
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
		  and hrpromotion.Priority='1'
		  and hremployeeepfhistory.Deleted=0
		  and hrpromotion.Emp_ID='".$EmpId."'
		  and hremployee.Deleted=0
          and transfertype.TransferType in('FirstAppointment','Promotion','ChangeofDesignation')
          GROUP by hremploymentcode.Designation,employeetype.EmployeeType
		  order by hrpromotion.StartDate";
		  
		  $startdatesLiast = DB::select(DB::raw($startdates));
	   $Dates = [];
	   
	   foreach ($startdatesLiast as $d) 
		{
			$Dates [] = $d->StartDate;
		}
		//return $Dates[];
		
		$eq = new HREmployeeServiceLetter;
		$eq->EmpID = $EmpId;
		$eq->DateIssued = $DateIssued;
		$eq->AddressTo1 = $AddressLine1;
		$eq->AddressTo2 = $AddressLine2;
		$eq->AddressTo3 = $AddressLine3;
		$eq->AddressTo4 = $AddressLine4;
		$eq->AddressTo5 = $AddressLine5;
		$eq->AddressTo6 = $AddressLine6;
		$eq->PersonalFileID = $PFileNumberID; 
		$eq->User = User::getSysUser()->userID;
		$eq->save();
		
		$html='<html><head>
   
    </head>
    <body leftmargin="50">
	
	<br/><br/>
	<br/><br/>
	<br/><br/>
	<table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
		<td style="width:70%;font-size:16px;" >My Number: '.$PFileNumber.'<br/><br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%"></td>
	</tr>
	
	<tr>
		<td style="width:70%;font-size:16px;">'.$DateIssued.'<br/><br/><br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>';
	
	if(!empty($AddressLine1))
	{
		$html.='<tr>
		<td style="width:70%;font-size:16px;">'.$AddressLine1.'<br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>';
	}
	if(!empty($AddressLine2))
	{
		$html.='<tr>
			<td style="width:70%;font-size:16px;">'.$AddressLine2.'<br/></td>
			<td style="width:15%;font-size:16px;"></td>
			<td style="width:15%;font-size:16px;"></td>
			</tr>';
	}
	if(!empty($AddressLine3))
	{
	$html.='<tr>
		<td style="width:70%;font-size:16px;">'.$AddressLine3.'<br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>';
	}
	if(!empty($AddressLine4))
	{
	$html.='<tr>
		<td style="width:70%;font-size:16px;">'.$AddressLine4.'<br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>';
	}
	if(!empty($AddressLine5))
	{
	$html.='<tr>
		<td style="width:70%;font-size:16px;">'.$AddressLine5.'<br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>';
	}
	if(!empty($AddressLine6))
	{
	$html.='<tr>
		<td style="width:70%;font-size:16px;">'.$AddressLine6.'<br/>
		</td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>';
	}
	$Dot = '.';
	$SPace = ' ';
	$EmployeeName = $GenderName.$Dot.$Initials.$SPace.$LastName;
	$html.='<tr>
		<td style="width:70%;font-size:16px;"><br/>Dear Sir/Madam,<br/><br/></td>
		<td style="width:15%;font-size:16px;"></td>
		<td style="width:15%;font-size:16px;"></td>
	</tr>

	</table></center>
	
	<B><U>Certification of Service - EPF No:-'.$EPFNO.'</U></B><br/><br/>
	<center><table style="width:100%;border-collapse:collapse;" border="0">
	<tr>';
	if($Designation == 'Instructor' || $Designation == 'Senior Instructor' || $Designation == 'Sports Instructor' || $Designation == 'Instructor Grade I' || $Designation == 'Instructor Grade II' || $Designation == 'Instructor Grade III' || $Designation == 'Instructor-Contract')
	{
					
		$html.='<td style="width:100%;font-size:16px;" align="justify">This is to certify that, '.$EmployeeName.' (NIC No:'.$NIC.') of '.$PerAddress.' is working at the post of '.$Designation.' ('.$CourseName.') in this Authority.<br/><br/></td>';
	}
	else
	{
		$html.='<td style="width:100%;font-size:16px;" align="justify">This is to certify that, '.$EmployeeName.' (NIC No:'.$NIC.') of '.$PerAddress.' is working at the post of '.$Designation.' in this Authority.<br/><br/></td>';
	}	
	$html.='</tr>
	<tr>
		<td style="width:100%;font-size:16px;">His/Her employment details are mentioned below, for your information.<br/><br/></td>
		
	</tr>
	
	
	<tr>
		<td style="width:100%;font-size:16px;" ><center>
			 <table style="width:100%;border-collapse:collapse;" border="0">';
			 $Copunt = count($promotionsys2);
			 $i=1;
			 $Edate ='';
			 $DateOfend = '';
			 $StrDate = '';
			 foreach($promotionsys2 as $g) 
			 {
				 if($i<$Copunt)
				 {
					$Edate = $Dates[$i];
					$DateOfred = DB::select(DB::raw("SELECT DATE_SUB('".$Edate."',INTERVAL 1 DAY) AS SYSdateNamess"));
					$DateOfredred =  json_decode(json_encode((array)$DateOfred),true);
					$DateOfend = $DateOfredred[0]["SYSdateNamess"];
					$DateOfend = strtotime($DateOfend);
                    $DateOfend = date("d-m-Y", $DateOfend);
				 
				 }
				 else{
					 $DateOfend = 'date';
				 }
				 
		    $html.='<tr>';
					$StrDate = strtotime($g->StartDate);
                    $StrDate = date("d-m-Y", $StrDate);
					
					$html.='<td style="width:45%;font-size:16px;">From '.$StrDate.' to '.$DateOfend.'</td>
					<td style="width:5%;font-size:16px;"><center>-</center></td>
					<td style="width:50%;font-size:16px;">'.$g->Designation.' ('.$g->EmployeeType.')</td>';
					
				    $html.='</tr>';
				$i = $i+1;
			 }
				
					
				
			$html.='</table>
			</center>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" ><br/>This letter is issued on the request of '.$GenderName.' '.$Initials.' '.$LastName.'.<br/><br/><br/><br/><br/><br/><br/></td>
		
	</tr>';
	if($Signature == 1)
	{
	$html.='<tr>
		<td style="width:100%;font-size:16px;">G.V.P.N.Perera,<br/></td>
		</tr>
		<tr>
		<td style="width:100%;font-size:16px;">Director (HR & Administration) Acting,<br/></td>
		
	</tr>';
	}elseif($Signature == 2)
	{
		$html.='<tr>
		<td style="width:100%;font-size:16px;">S.Rathnayaka,<br/></td>
		</tr>
		<tr>
		<td style="width:100%;font-size:16px;">Deputy Director (HR & Administration),<br/></td>
		
	</tr>
	<tr>
		
		<td style="width:100%;font-size:16px;">For Director (HR & Administration),</td>
		
	</tr>';
	}
	elseif($Signature == 3)
	{
		$html.='<tr>
		<td style="width:100%;font-size:16px;">W.M.A.S.L.Wijenayake,<br/></td>
		</tr>
		<tr>
		<td style="width:100%;font-size:16px;">Deputy Director (HR & Administration),<br/></td>
		
	</tr>
	<tr>
		
		<td style="width:100%;font-size:16px;">For Director (HR & Administration),</td>
		
	</tr>';
	}
	else{
	}
	
   
	
	$html.='<tr>
		
		<td style="width:100%;font-size:16px;">Vocational Training Authority of Sri Lanka.</td>
	</tr>

	</table>
	</body>
	</html>
	
	
			
	';
	
	return $html;
	}
	
		public function CreateHREmployeeServiceLetters() 
	   {
        $method = Request::getMethod();
        $view = View::make('HRServiceLetter.Create');
        $view->user = User::getSysUser();
		
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
          
        }
    }
	
	
		public function ViewHREmployeeServiceLettersIssued()
	{
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
		if($userOrgType == 'HO')
		{
			if($UserTypeName == 'HR-MAPF')
			{
				$quorga = DB::select(DB::raw("select hremployeeserviceletter.*,
											  hremployee.Initials,hremployee.LastName,hremployee.EPFNo,hremployee.NIC,
											  employee.Initials as userinitials,
											  employee.LastName as userlastname,
											  hremployeepersonalfiledoc.FileNo
											  from hremployeeserviceletter
											  left join hremployee
											  on hremployeeserviceletter.EmpID=hremployee.id
											  left join hremployeepersonalfiledoc
											  on hremployeeserviceletter.PersonalFileID=hremployeepersonalfiledoc.id
											  left join user
											  on hremployeeserviceletter.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  left join hremployeeepfhistory
											  on hremployee.id=hremployeeepfhistory.EmpId
											  where hremployeeserviceletter.Deleted=0
											  and hremployeeepfhistory.Deleted=0
											  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
											  from hruserepflist
											  where hruserepflist.Deleted=0
											  and hruserepflist.Active=1
											  and hruserepflist.UserID='".User::getSysUser()->userID."')
											  order by hremployeeserviceletter.DateIssued"));
			}
			else
			{
				$quorga = DB::select(DB::raw("select hremployeeserviceletter.*,
											  hremployee.Initials,hremployee.LastName,hremployee.EPFNo,hremployee.NIC,
											  employee.Initials as userinitials,
											  employee.LastName as userlastname,
											  hremployeepersonalfiledoc.FileNo
											  from hremployeeserviceletter
											  left join hremployee
											  on hremployeeserviceletter.EmpID=hremployee.id
											  left join hremployeepersonalfiledoc
											  on hremployeeserviceletter.PersonalFileID=hremployeepersonalfiledoc.id
											  left join user
											  on hremployeeserviceletter.User=user.userID
											  left join employee
											  on user.EmpId=employee.id
											  where hremployeeserviceletter.Deleted=0
											  order by hremployeeserviceletter.DateIssued"));
			}
		}
		else{
		}
		
		
 		$v = View::make('HRServiceLetter.EmpQua');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function DownloadExamDepartmentResultSheetAL()
	{
		$id = Input::get('id');
		$Orirec = HREmployeeAlResult::where('id','=',$id)->where('Deleted','=',0)->first();
		$Stream = HRALStream::where('id','=',$Orirec->StreamId)->where('Deleted','=',0)->pluck('Stream');
		$Initials = HREmployee::where('id','=',$Orirec->EmpId)->where('Deleted','=',0)->pluck('Initials');
	    $LastName = HREmployee::where('id','=',$Orirec->EmpId)->where('Deleted','=',0)->pluck('LastName');
		$FName = HREmployee::where('id','=',$Orirec->EmpId)->where('Deleted','=',0)->pluck('Name');
		$PFileNumber = HREmployeePersonalFileDoc::where('EmpId','=',$Orirec->EmpId)->where('Deleted','=',0)->where('Active','=',1)->pluck('FileNo');
		$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'%d-%m-%Y') AS SYSdateName"));
	    $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
	    $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
		 $GradeJ = DB::raw("SELECT
							  hremployeealresulttrans.id,
							  hralsubject.Subject,
							  hrolgrade.GradeName,
							  hrolgrade.Grade
							  FROM hremployeealresulttrans
							  LEFT JOIN hralsubject
							  ON hremployeealresulttrans.SubjectId = hralsubject.id
							  LEFT JOIN hrolgrade
							  ON hremployeealresulttrans.GradeId = hrolgrade.id
							  WHERE hremployeealresulttrans.EALRId = '".$id."'
							  AND hremployeealresulttrans.EmpId = '".$Orirec->EmpId."'
							  and hremployeealresulttrans.Deleted=0
							  ORDER BY hremployeealresulttrans.id");
		$GradeList = DB::select($GradeJ);
		$html='<html><head>
   
    </head>
    <body leftmargin="50">
	<table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
		<td style="width:35%;font-size:16px;" ></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%">My Number: '.$PFileNumber.'</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;"></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">Vocational Training Authority</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;"></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">No 354/2,Elvitigala Mawatha,</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;">
		<table style="width:100%;border-collapse:collapse;" border="1">
			<tr><td style="font-size:16px;"><br/></td></tr>
			</table>
			</td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">Colombo 05.</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;"></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">'.$DateOfSystem.'.</td>
	</tr>
	</table></center>
	COMMISSIONER GENERAL OF EXAMINATION<br/>(CERTIFICATE BRANCH)<br/><br/>
	<center><B><U>CONFIRMATION OF EXAMINATION RESULTS</U></B></center><br/>
	<center><table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
		<td style="width:100%;font-size:16px;" >please confirm the following exam results.This details of results was obtained from the results sheet given by him/her photo copy of result sheet annexed herewith.<br/><br/></td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >01. i. Name of Applicant(With Initials)</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$Initials.' '.$LastName.'</b><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................................................................................................................................................</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ii. Name in Full of Applicant</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$FName.' '.$LastName.'</b><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................................................................................................................................................</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iii. Name in Full of Applicant</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$FName.' '.$LastName.'</b><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................................................................................................................................................</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >02.  Name of Examination: <b>G.C.E. Advanced Level</b></td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >03.  Year & Month of Examination: <b>'.$Orirec->Year.'  '.$Orirec->Month.'</b></td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
			 <table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:50%;font-size:16px;">04. (i) Index Number: <b>'.$Orirec->IndexNo.'</b></td>
					<td style="width:50%;font-size:16px;">(i) Center Number: <b>'.$Orirec->CentreNo.'</b></td>
				</tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >05.  Subject Passed & Grades</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" ><center>
			 <table style="width:85%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:5%;font-size:16px;"></td>
					<td style="width:40%;font-size:16px;"><u>Subject</u></td>
					<td style="width:30%;font-size:16px;"><u>Passes</u></td>
					<td style="width:10%;font-size:16px;"><center><u>Symbols</u></center></td>
				</tr>';
				
				$CountGtadeList = count($GradeList);
				
				$A=1;
				foreach($GradeList as $G)
				{
					$html.='<tr>
					<td style="width:5%;font-size:16px;">'.$A.'.</td>
					<td style="width:40%;font-size:16px;">'.$G->Subject.'</td>
					<td style="width:30%;font-size:16px;">'.$G->GradeName.'</td>
					<td style="width:10%;font-size:16px;"><center>'.$G->Grade.'</center></td>
				    </tr>';	
					$A = $A+1;
				}
				
				if($Orirec->GeneralKowledgeMark !=0)
				{
					
					$html.='<tr>
					<td style="width:5%;font-size:16px;">'.$A.'.</td>
					<td style="width:40%;font-size:16px;">General Knowledge</td>
					<td style="width:30%;font-size:16px;"></td>
					<td style="width:10%;font-size:16px;"><center>'.$Orirec->GeneralKowledgeMark.'</center></td>
				    </tr>';	
					$A = $A+1;
				}
				
				
				for($CC=$A;$CC<=10;$CC++)
				{
					$html.='<tr>
					<td style="width:5%;font-size:16px;">'.$CC.'.</td>
					<td style="width:40%;font-size:16px;">.............................................................</td>
					<td style="width:30%;font-size:16px;">...................................................</td>
					<td style="width:10%;font-size:16px;"><center>.........................</center></td>
				    </tr>';	
				}
					
				
			$html.='</table>
			</right>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		<br/>
		<br/>
		
			 <table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:40%;font-size:16px;" >Prepared By: ...............................................</td>
					<td style="width:20%;font-size:16px;"></td>
				    <td style="width:40%;font-size:16px;" ><center>............................................................</center></td>
					
				</tr>
					<tr>
					<td style="width:40%;font-size:16px;" ></td>
					<td style="width:20%;font-size:16px;"></td>
				    <td style="width:40%;font-size:16px;" ><center>Signature & Post</center></td>
					
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" ><hr/>
	<b><center>For the Use of Examination Department Only</center></b><br/></td>
		
	</tr>
	<tr>
		<table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:60%;font-size:16px;">Name as per original result scheduler: </td>
					<td style="width:40%;font-size:16px;">...........................................................................................................<br/>
					...........................................................................................................</td>
				</tr>	
			</table>
	</tr>
	<tr>
		<table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:23%;font-size:16px;">Distinction Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;">........</td>
					<td style="width:50%;font-size:16px;"></td>
					
				</tr>
				<tr>
					<td style="width:23%;font-size:16px;">Very Good Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;">........</td>
					<td style="width:50%;font-size:16px;">Checked By:&nbsp;&nbsp;&nbsp;&nbsp;1.</td>
					
					
				</tr>
			<tr>
					<td style="width:23%;font-size:16px;">Credit Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;">........</td>
					<td style="width:50%;font-size:16px;"></td>
					
				</tr>
				<tr>
					<td style="width:23%;font-size:16px;">Ordinary Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;"><u>........</u></td>
					<td style="width:50%;font-size:16px;">Checked By:&nbsp;&nbsp;&nbsp;&nbsp;2.</td>
					
					
				</tr>	
				<tr>
					<td style="width:23%;font-size:16px;">Total Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;text-decoration: underline double;">........</td>
					<td style="width:50%;font-size:16px;"></td>
					
				</tr>				
			</table>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
			 <table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:50%;font-size:16px;"><br/>Date:&nbsp;...........................................</td>
					<td style="width:50%;font-size:16px;"><br/>Counter Signature:&nbsp;......................................</td>
				</tr>	
			</table>
		</td>
	</tr>
	</table>
	</body>
	</html>
	
	
			
	';
	
	return $html;
	}
	
	public function DownloadExamDepartmentResultSheetOL()
	{
		$id = Input::get('id');
		$Orirec = HREmployeeOlResult::where('id','=',$id)->where('Deleted','=',0)->first();
		$Initials = HREmployee::where('id','=',$Orirec->EmpId)->where('Deleted','=',0)->pluck('Initials');
	    $LastName = HREmployee::where('id','=',$Orirec->EmpId)->where('Deleted','=',0)->pluck('LastName');
		$FName = HREmployee::where('id','=',$Orirec->EmpId)->where('Deleted','=',0)->pluck('Name');
		$PFileNumber = HREmployeePersonalFileDoc::where('EmpId','=',$Orirec->EmpId)->where('Deleted','=',0)->where('Active','=',1)->pluck('FileNo');
		$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'%d-%m-%Y') AS SYSdateName"));
	    $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
	    $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
		 $GradeJ = DB::raw("select hremployeeolresulttrans.id,
							hrolsubject.Subject,
							hrolgrade.GradeName,
							hrolgrade.Grade
							from hremployeeolresulttrans
							left join hrolsubject
							on hremployeeolresulttrans.SubjectId=hrolsubject.id
							left join hrolgrade
							on hremployeeolresulttrans.GradeId=hrolgrade.id
							where hremployeeolresulttrans.EOLRId='".$id."'
							 and hremployeeolresulttrans.Deleted=0
							and hremployeeolresulttrans.EmpId='".$Orirec->EmpId."'
							order by hremployeeolresulttrans.id");
		$GradeList = DB::select($GradeJ);
		$html='<html><head>
   
    </head>
    <body leftmargin="50">
	<table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
		<td style="width:35%;font-size:16px;" ></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%">My Number: '.$PFileNumber.'</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;"></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">Vocational Training Authority</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;"></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">No 354/2,Elvitigala Mawatha,</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;">
		<table style="width:100%;border-collapse:collapse;" border="1">
			<tr><td style="font-size:16px;"><br/></td></tr>
			</table>
			</td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">Colombo 05.</td>
	</tr>
	<tr>
		<td style="width:35%;font-size:16px;"></td>
		<td style="width:30%;font-size:16px;"></td>
		<td style="width:35%;font-size:16px;">'.$DateOfSystem.'.</td>
	</tr>
	</table></center>
	COMMISSIONER GENERAL OF EXAMINATION<br/>(CERTIFICATE BRANCH)<br/><br/>
	<center><B><U>CONFIRMATION OF EXAMINATION RESULTS</U></B></center><br/>
	<center><table style="width:100%;border-collapse:collapse;" border="0">
	<tr>
		<td style="width:100%;font-size:16px;" >please confirm the following exam results.This details of results was obtained from the results sheet given by him/her photo copy of result sheet annexed herewith.<br/><br/></td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >01. i. Name of Applicant(With Initials)</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$Initials.' '.$LastName.'</b><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................................................................................................................................................</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ii. Name in Full of Applicant</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$FName.' '.$LastName.'</b><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................................................................................................................................................</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iii. Name in Full of Applicant</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$FName.' '.$LastName.'</b><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................................................................................................................................................</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >02.  Name of Examination: <b>G.C.E. Ordinary Level</b></td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >03.  Year & Month of Examination: <b>'.$Orirec->Year.'  '.$Orirec->Month.'</b></td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
			 <table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:50%;font-size:16px;">04. (i) Index Number: <b>'.$Orirec->IndexNo.'</b></td>
					<td style="width:50%;font-size:16px;">(i) Center Number: <b>'.$Orirec->CentreNo.'</b></td>
				</tr>	
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >05.  Subject Passed & Grades</td>
		
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" ><center>
			 <table style="width:85%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:5%;font-size:16px;"></td>
					<td style="width:40%;font-size:16px;"><u>Subject</u></td>
					<td style="width:30%;font-size:16px;"><u>Passes</u></td>
					<td style="width:10%;font-size:16px;"><center><u>Symbols</u></center></td>
				</tr>';
				
				$CountGtadeList = count($GradeList);
				
				$A=1;
				foreach($GradeList as $G)
				{
					$html.='<tr>
					<td style="width:5%;font-size:16px;">'.$A.'.</td>
					<td style="width:40%;font-size:16px;">'.$G->Subject.'</td>
					<td style="width:30%;font-size:16px;">'.$G->GradeName.'</td>
					<td style="width:10%;font-size:16px;"><center>'.$G->Grade.'</center></td>
				    </tr>';	
					$A = $A+1;
				}
				
				for($CC=$A;$CC<=10;$CC++)
				{
					$html.='<tr>
					<td style="width:5%;font-size:16px;">'.$CC.'.</td>
					<td style="width:40%;font-size:16px;">.............................................................</td>
					<td style="width:30%;font-size:16px;">...................................................</td>
					<td style="width:10%;font-size:16px;"><center>.........................</center></td>
				    </tr>';	
				}
					
				
			$html.='</table>
			</center>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
		<br/>
		<br/>
			 <table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:40%;font-size:16px;" >Prepared By: ...............................................</td>
					<td style="width:20%;font-size:16px;"></td>
				    <td style="width:40%;font-size:16px;" ><center>............................................................</center></td>
					
				</tr>
					<tr>
					<td style="width:40%;font-size:16px;" ></td>
					<td style="width:20%;font-size:16px;"></td>
				    <td style="width:40%;font-size:16px;" ><center>Signature & Post</center></td>
					
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" ><hr/>
	<b><center>For the Use of Examination Department Only</center></b><br/></td>
		
	</tr>
	<tr>
		<table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:60%;font-size:16px;">Name as per original result scheduler: </td>
					<td style="width:40%;font-size:16px;">...........................................................................................................<br/>
					...........................................................................................................</td>
				</tr>	
			</table>
	</tr>
	<tr>
		<table style="width:90%;border-collapse:collapse;" border="0" align="right">
				<tr>
					<td style="width:23%;font-size:16px;">Distinction Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;">........</td>
					<td style="width:50%;font-size:16px;"></td>
					
				</tr>
				<tr>
					<td style="width:23%;font-size:16px;">Very Good Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;">........</td>
					<td style="width:50%;font-size:16px;">Checked By:&nbsp;&nbsp;&nbsp;&nbsp;1.</td>
					
					
				</tr>
			<tr>
					<td style="width:23%;font-size:16px;">Credit Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;">........</td>
					<td style="width:50%;font-size:16px;"></td>
					
				</tr>
				<tr>
					<td style="width:23%;font-size:16px;">Ordinary Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;"><u>........</u></td>
					<td style="width:50%;font-size:16px;">Checked By:&nbsp;&nbsp;&nbsp;&nbsp;2.</td>
					
					
				</tr>	
				<tr>
					<td style="width:23%;font-size:16px;">Total Passes</td>
					<td style="width:2%;font-size:16px;">:</td>
					<td style="width:25%;font-size:16px;text-decoration: underline double;">........</td>
					<td style="width:50%;font-size:16px;"></td>
					
				</tr>				
			</table>
	</tr>
	<tr>
		<td style="width:100%;font-size:16px;" >
			 <table style="width:100%;border-collapse:collapse;" border="0">
				<tr>
					<td style="width:50%;font-size:16px;"><br/>Date:&nbsp;...........................................</td>
					<td style="width:50%;font-size:16px;"><br/>Counter Signature:&nbsp;......................................</td>
				</tr>	
			</table>
		</td>
	</tr>
	</table>
	</body>
	</html>
	
	
			
	';
	
	return $html;
	}
	
	public function EditHREmployeeIncrementsHistory()
	{
		
		$view = View::make('HREmployeeIncrements.EditHistory');
        $method = Request::getMethod();

        if ($method == "GET") 
{
            $empqua = HREmployeeSalaryStepData::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeSalaryStepData::where('id', '=', Input::get('id'))->pluck('EmpID');
            $view = View::make('HREmployeeIncrements.EditHistory')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
            $view->user = User::getSysUser();
			$GetGradeID = HRPromotion::where('P_ID','=',$empqua->PromotionID)->pluck('PGradeId');
			$GetSerYear = HRSalaryscale:: where('id','=',$empqua->ServiceCategoryID)->pluck('Year');
			$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
			$view->GetSerYear = $GetSerYear;
			$view->GetGradeID = $GetGradeID;
			$view->GList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		    $view->quaorg = HRSalaryscale::where("Deleted", "!=", 1)->where('Year','=',$GetSerYear)->orderBy('ServiceCategory')->get();
			$view->salarysteps = HRSalaryStepTrans::where('Deleted','=',0)->where('SalaryScaleID','=',$empqua->ServiceCategoryID)->orderBy('StepNo')->get();
		    $view->employees = HREmployee::where("Deleted", "!=", 1)->where('id','!=',$EmpId)->orderBy('EPFNo')->get();
		    $view->empqua = $empqua;
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $eq = HREmployeeSalaryStepData::find(Input::get('EQ_ID'));
                $eq->SalaryStepTransID = Input::get('SalaryStepTransID');
				$eq->NextIncrementDate = Input::get('NextIncrementDate');
			    $eq->ServiceCategoryID = Input::get('QO_ID');
				$eq->User = User::getSysUser()->userID;
                $eq->save();
				
				$PromoID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('PromotionID');
				$ApproveStatus = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('Approved');
				$availabilitya = HRIncrementAction::where('id','=',$ApproveStatus)->pluck('Availability');
				 if($availabilitya == 1)
				 {
					   
					$UpdatePromotion = HRPromotion::where('P_ID','=',$PromoID)->update(array('PSalaryStep' => Input::get('SalaryStepTransID'),'PServiceCategoryID' => Input::get('QO_ID')));
					
				 }
				
              
               
                return Redirect::to('ViewIncrementHistory');
                
            
        }
	}
	
	public function DeleteHREmployeeIncrementApprovedRecord()
	{
		$id = Input::get('id');
        $empqua = HREmployeeSalaryStepData::find($id);
        $empqua->Deleted = 1;
        $empqua->User = User::getSysUser()->userID;
        $empqua->save();
        return Redirect::to('HREmployeeIncrementsEditMode');
	}
	
	public function DeleteHRUserEPFList()
	  {
                $id = Input::get('id');
                $quorg = HRUserEPFList::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRUserEPFList');
                
            }
	
	public function EditHRUserEPFList()
	{
			$view = View::make('HRUserEPFList.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
				
				$view->Users = DB::select(DB::raw("select user.userID,user.userName,employee.Initials,employee.LastName
										  from user
										  left join employee
										  on user.EmpId=employee.id
										  where user.Deleted=0
										  and user.active=1
										  and user.UserDivision='Admin'
										  and employee.Deleted=0"));
			$quorg = HRUserEPFList::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
					$oq = HRUserEPFList::find(Input::get('QO_ID'));
					$oq->UserID = Input::get('UserID');
					$oq->EPFNo = Input::get('EPFNo');
					$oq->Active = Input::get('Active');
					$oq->User = User::getSysUser()->userID;
					
					$oq->save();
					
					return Redirect::to('ViewHRUserEPFList');
			
			
			}
}
	
	public function CreateHRUserEPFList()
	 {
        $method = Request::getMethod();
        $view = View::make('HRUserEPFList.Create');
        $view->Users = DB::select(DB::raw("select user.userID,user.userName,employee.Initials,employee.LastName
										  from user
										  left join employee
										  on user.EmpId=employee.id
										  where user.Deleted=0
										  and user.active=1
										  and user.UserDivision='Admin'
										  and employee.Deleted=0"));
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRUserEPFList;
                $qo->UserID = Input::get('UserID');
				$qo->EPFNo = Input::get('EPFNo');
				$qo->Active = Input::get('Active');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRUserEPFList')->with("done", true);
            
            
            }
            
          }
	
	public function ViewHRUserEPFList()
	{
		$quorga = DB::select(DB::raw("select hruserepflist.*,employee.Initials,employee.LastName,organisation.OrgaName,organisation.Type
									  from hruserepflist
									  left join user
									  on hruserepflist.UserID=user.userID
									  left join employee
									  on user.EmpId=employee.id
									  left join organisation
									  on employee.CurrentOrgaID=organisation.id
									  where hruserepflist.Deleted=-0
									  and user.active=1"));
 		$v = View::make('HRUserEPFList.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	
	public function DownloadRetirementList()
	{
		 $Count = 1;

         $tablePrintHeader = array('#','EPF No','NIC','Full Name','Name with Initials','District','To Center','Type','To Department',
		 'Transfer Type','Designation','Employee Type','Effective Date','Service Category','Salary Code','Salary Scale','Salary Step','Step Amount','EB Availability','Grade','Increment Month','Increment Day','Confirmation Date',
		 'Gratuity Amount','ETF Released Date','EPF Released Date','Date of Retirement');

         $excel = new SimpleExcel('csv');
         $printablearray = array();

         array_push($printablearray, $tablePrintHeader);

        $i = 1;
		        $userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				
				$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
				$CountCMP=0;
				if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$sqlaccrediationPay = "select hrpromotion.P_ID,hremployee.NIC,
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
                    DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as retdate
									  from hrpromotion
									  left join hremployee
									  on hrpromotion.Emp_ID=hremployee.id
									  left join hremployeeepfhistory
											              on hremployeeepfhistory.EmpId=hremployee.id
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
									  and hremployeeepfhistory.Deleted=0
									  and hrpromotion.CurrentRecord='Yes'
									  and transfertype.Available!=0
									  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
								      and YEAR(DATE_ADD(CURDATE(), INTERVAL 3 MONTH)) - YEAR(hremployee.DOB) - (RIGHT(DATE_ADD(CURDATE(), INTERVAL 3 MONTH), 5) < RIGHT(hremployee.DOB, 5)) >=60 
									  order by hremploymentcode.Designation,transfertype.Available";
						}
						else
						{
							$sqlaccrediationPay = "select hrpromotion.P_ID,hremployee.NIC,
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
                    DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as retdate
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
									  and transfertype.Available!=0
								      and YEAR(DATE_ADD(CURDATE(), INTERVAL 3 MONTH)) - YEAR(hremployee.DOB) - (RIGHT(DATE_ADD(CURDATE(), INTERVAL 3 MONTH), 5) < RIGHT(hremployee.DOB, 5)) >=60 
									  order by hremploymentcode.Designation,transfertype.Available";
						}
					}
					else{
					}
		                              
					$sqlaccrediationPayList = DB::select(DB::raw($sqlaccrediationPay));
					
	foreach($sqlaccrediationPayList as $cs) 
	{
		
			
                $data_row = array();
                array_push($data_row, $i++);
                
				array_push($data_row, $cs->EPF);
			    array_push($data_row, $cs->NIC);
				$cname = $cs->Initials.' '.$cs->LastName;
				$cname1 = $cs->Name.' '.$cs->LastName;
				array_push($data_row, $cname1);
				array_push($data_row, $cname);
				array_push($data_row, $cs->DistrictName);
				array_push($data_row, $cs->OrgaName);
				array_push($data_row, $cs->Type);
				array_push($data_row, $cs->DepartmentName);
				array_push($data_row, $cs->TransferType);
			    array_push($data_row, $cs->Designation);
				array_push($data_row, $cs->EmployeeType);
				array_push($data_row, $cs->StartDate);
				array_push($data_row, $cs->PServiceCategory);
				array_push($data_row, $cs->PSalaryCode);
				array_push($data_row, $cs->PSalaryScale);
				if(!empty($cs->PSalaryStep) || $cs->PSalaryStep != 0)
						{
						 $salsteptransP = HRSalaryStepTrans::where('id','=',$cs->PSalaryStep)->first();
						}
						else
						{
							$salsteptransP="";
						}
						if($cs->PSalaryStep != '' || $cs->PSalaryStep != 0)

						{	array_push($data_row, $salsteptransP->StepNo);
				            array_push($data_row, $salsteptransP->StepAmount);
							if($salsteptransP->EBAvailable == 1)
							{
							array_push($data_row, 'Yes');
							}
							else
							{
								array_push($data_row, 'No');
							}
						}
						else
						{
							array_push($data_row, '');
				            array_push($data_row, '');
							array_push($data_row, '');
						}
				array_push($data_row, $cs->PGrade);
				array_push($data_row, $cs->IncrementMonth);
				array_push($data_row, $cs->IncrementDay);
				array_push($data_row, $cs->ConfirmationDate);
				array_push($data_row, $cs->GratuityAmount);
				array_push($data_row, $cs->ETFReleasedDate);
				array_push($data_row, $cs->EPFReleasedDate);
				array_push($data_row, $cs->retdate);
				array_push($printablearray, $data_row);
				    
    }
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('RetirementList' . date('Y-m-d'));
	}
	
	public function InstantRetirements()
	{
		$view = View::make("Home.RetiredList");
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
		
		if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$sqlIncrement = " select hrpromotion.P_ID,hremployee.NIC,
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
                    DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as retdate
									  from hrpromotion
									  left join hremployee
									  on hrpromotion.Emp_ID=hremployee.id
									  left join hremployeeepfhistory
											              on hremployeeepfhistory.EmpId=hremployee.id
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
									  and transfertype.Available!=0
									  and hremployeeepfhistory.Deleted=0
									  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
								      and YEAR(DATE_ADD(CURDATE(), INTERVAL 6 MONTH)) - YEAR(hremployee.DOB) - (RIGHT(DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 5) < RIGHT(hremployee.DOB, 5)) >=60 
									  order by hremploymentcode.Designation,transfertype.Available";
						}
						else
						{
							$sqlIncrement = " select hrpromotion.P_ID,hremployee.NIC,
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
                    DATE_ADD(hremployee.DOB, INTERVAL 60 YEAR) as retdate
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
									  and transfertype.Available!=0
								      and YEAR(DATE_ADD(CURDATE(), INTERVAL 6 MONTH)) - YEAR(hremployee.DOB) - (RIGHT(DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 5) < RIGHT(hremployee.DOB, 5)) >=60 
									  order by hremploymentcode.Designation,transfertype.Available";
						}
					}
					else{
					}
					
		
					$sqlIncrementList = DB::select(DB::raw($sqlIncrement));
					$view->sqlIncrementList = $sqlIncrementList;
					return $view;
	}
	
		public function DownloadIncrementList()
	{
		 $Count = 1;

         $tablePrintHeader = array('#', 'Current Organisation','Type','Employee Name','NIC','EPF No','Designation','Service Category','Step No','Step Amount','Increment Date','Evaluation Form Status','Approve Status');

         $excel = new SimpleExcel('csv');
         $printablearray = array();

         array_push($printablearray, $tablePrintHeader);

        $i = 1;
		        $userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				//$userOrgId = User::getSysUser()->organisationId;
				$userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
				$userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
				$userTypeID = User::getSysUser()->userType;
				$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
				$CountCMP=0;
				
				if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$sqlaccrediationPay = "select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hremployee.EPFNo,
											  hrpromotion.EPF,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo,
											  hrsalarysteptrans.StepAmount,
											  hremployeesalarystep.GrossSalary
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hremployeeepfhistory
											  on hremployeeepfhistory.EmpId=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployee.Deleted=0
											  and transfertype.Available=1
											  and hremployeeepfhistory.Deleted=0
											  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
                        and hremployeesalarystep.Approved=0
                        and hremployeesalarystep.NextIncrementDate<=DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
                          order by hremployeesalarystep.NextIncrementDate";
						}
						else{
							$sqlaccrediationPay = "select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hremployee.EPFNo,
											  hrpromotion.EPF,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo,
											  hrsalarysteptrans.StepAmount,
											  hremployeesalarystep.GrossSalary
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployee.Deleted=0
											  and transfertype.Available=1
                        and hremployeesalarystep.Approved=0
                        and hremployeesalarystep.NextIncrementDate<=DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
                          order by hremployeesalarystep.NextIncrementDate";
						}
						
					}
					else{
					}
		
					$sqlaccrediationPayList = DB::select(DB::raw($sqlaccrediationPay));
					
	foreach($sqlaccrediationPayList as $cs) 
	{
		
			
                $data_row = array();
                array_push($data_row, $i++);
                
				array_push($data_row, $cs->OrgaName);
			    array_push($data_row, $cs->Type);
				$cname = $cs->Initials.' '.$cs->LastName;
				array_push($data_row, $cname);
				array_push($data_row, $cs->NIC);
				array_push($data_row, $cs->EPF);
				array_push($data_row, $cs->Designation);
				array_push($data_row, $cs->ServiceCategory);
				array_push($data_row, $cs->StepNo);
			    array_push($data_row, $cs->StepAmount);
				array_push($data_row, $cs->NextIncrementDate);
				
				 if($cs->AIFPrint == 0)
				 {
						$Eval = 'Not Yet Submitted';
				 }
				 else
				 {
					 $Eval = 'Submitted';
				 }
				array_push($data_row, $Eval);			
				
				if($cs->Approved == 1)
				{
					$tt = 'Yes';
				}
				else if($cs->Approved == 2)
				{
							$tt = 'Temporary Hold';
				}
							else if($cs->Approved == 3)
							{
							$tt = 'Hold';
							}
							else if($cs->Approved == 4)
							{
							 $tt = 'Stop';
							}
							 else if($cs->Approved == 5)
							 {
							 $tt = 'Reactive';
							 }
							 else
							 {
								$tt = 'Pending';
							 }
				array_push($data_row, $tt);
				array_push($printablearray, $data_row);
				    
    }
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('IncrementList' . date('Y-m-d'));
	}
	
	public function InstantIncrements()
	{
		$view = View::make("Home.Increments");
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
		
		if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$sqlIncrement = " select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hrpromotion.EPF,
											  hremployee.EPFNo,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo,
											  hrsalarysteptrans.StepAmount,
											  hremployeesalarystep.GrossSalary
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join hremployeeepfhistory
											  on hremployeeepfhistory.EmpId=hremployee.id
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployee.Deleted=0
											  and hremployeeepfhistory.Deleted=0
											  and transfertype.Available=1
											   and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
                        and hremployeesalarystep.Approved=0
                        and hremployeesalarystep.NextIncrementDate<=DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
                          order by hremployeesalarystep.NextIncrementDate";
						}
						else
						{
							$sqlIncrement = " select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hrpromotion.EPF,
											  hremployee.EPFNo,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo,
											  hrsalarysteptrans.StepAmount,
											  hremployeesalarystep.GrossSalary
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployee.Deleted=0
											  and transfertype.Available=1
                        and hremployeesalarystep.Approved=0
                        and hremployeesalarystep.NextIncrementDate<=DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
                          order by hremployeesalarystep.NextIncrementDate";
							
						}
					}
					else{
						
					}
		
					$sqlIncrementList = DB::select(DB::raw($sqlIncrement));
					$view->sqlIncrementList = $sqlIncrementList;
					return $view;
	}
	
	public function ViewIncrementHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeIncrements.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
										$Sql = "select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hremployee.EPFNo,
											  hrpromotion.EPF,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo,
											  hremployeesalarystep.GrossSalary
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployee.id='".$GetEmpID."'
											  and hremployee.Deleted=0
											  and transfertype.Available=1";
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
	public function HREmployeeEditIncrementsEditMode()
	{
		$view = View::make('HREmployeeIncrements.EditMain');
        $method = Request::getMethod();

        if ($method == "GET") 
        {
            $empqua = HREmployeeSalaryStepData::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeSalaryStepData::where('id', '=', Input::get('id'))->pluck('EmpID');
            $view = View::make('HREmployeeIncrements.EditMain')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
			$Emplcode = HRPromotion::where('P_ID','=',$empqua->PromotionID)->pluck('NewPost');
			$Desi = HREmploymentCode::where('id','=',$Emplcode)->pluck('Designation');
			
            $view->user = User::getSysUser();
			$view->Designation = $Desi;
			//return HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$empqua->SalaryStepTransID)->get();
		    $view->quaorg = HRSalaryscale::where("id", "=", $empqua->ServiceCategoryID)->where('Deleted','=',0)->get();
			$view->salarysteps = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$empqua->SalaryStepTransID)->get();
		    $view->employees = HREmployee::where("Deleted", "!=", 1)->where('id','!=',$EmpId)->orderBy('EPFNo')->get();
		    $view->empqua = $empqua;
			$view->action = HRIncrementAction::where('Deleted','=',0)->orderBy('id')->get();
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $eq = HREmployeeSalaryStepData::find(Input::get('EQ_ID'));
                $eq->Approved = Input::get('Approve');
				$eq->ReasonForHold = Input::get('Reason');
			    $eq->GrossSalary = Input::get('GrossSalary');
				$eq->User = User::getSysUser()->userID;
                $eq->save();
				
				$n = new HREmployeeIncrementAction();
				$n->HREmpsalarystepID = Input::get('EQ_ID');
				$n->ActionID = Input::get('Approve');
				$n->User = User::getSysUser()->userID;
				
				$checkval = HREmployeeIncrementAction::where('HREmpsalarystepID','=',Input::get('EQ_ID'))->where('ActionID','=',Input::get('Approve'))->get();
				if(count($checkval) == 0)
				{
					$n->save(); 
				}
				
				
				$checkholdmonth = HRIncrementAction::where('id','=',Input::get('Approve'))->pluck('HoldMonth');
              
               if($checkholdmonth == 1)
			   {
				   if(Input::get('Approve') == 2 || Input::get('Approve') == 3)
				   {
					 $deletea = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
					 $Months = [];
                     $Months = Input::get('IncrementMonth');
                     $countP = count($Months);
					 $i=0;
					 
					 for($i=0;$i<$countP;$i++)
					{
							$r = new HREmployeeIncrementHoldMonths();
							$r->MonthNo = $Months[$i];
							$r->HREmpsalaryStepID = Input::get('EQ_ID');
							$r->User = User::getSysUser()->userID;
							$r->save();

					}
					 
				   }
				  /*  if(Input::get('Approve') == 3)
				   {
					   $deletea = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
					    $i=1;
						for($i=1;$i<=12;$i++)
						{
								$r = new HREmployeeIncrementHoldMonths();
								$r->MonthNo = $i;
								$r->HREmpsalaryStepID = Input::get('EQ_ID');
								$r->User = User::getSysUser()->userID;
								$r->save();

						}
					   
				   } */
			   }
			   else{
				    $deletea = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
			   }
			   
			   $availabilitya = HRIncrementAction::where('id','=',Input::get('Approve'))->pluck('Availability');
			   $PromoID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('PromotionID');
			   $StepID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('SalaryStepTransID');
			   $ScaleID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('ServiceCategoryID');
			   $prenextdate = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('NextIncrementDate');
			   $getFirst = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->first();
			   if($availabilitya == 1)
			   {
				   // check it again
				   $UpdatePromotion = HRPromotion::where('P_ID','=',$PromoID)->update(array('PSalaryStep' => $StepID,'PServiceCategoryID' => $ScaleID));
			   }
			   else
			   {
				            $sqladdyear = DB::select(DB::raw("select DATE_SUB('".$prenextdate."', INTERVAL 1 YEAR) as newdate"));
							$newdata3 =  json_decode(json_encode((array)$sqladdyear),true);
							$expectedcomstep = $newdata3[0]["newdate"];
							
							$preget = DB::select(DB::raw("select hremployeesalarystep.ServiceCategoryID,hremployeesalarystep.SalaryStepTransID,hremployeesalarystep.*
														  from hremployeesalarystep
														  left join hrincrementaction
														  on hremployeesalarystep.Approved=hrincrementaction.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeesalarystep.EmpID='".$getFirst->EmpID."'
														  and hremployeesalarystep.NextIncrementDate<'".$getFirst->NextIncrementDate."'
														  and hrincrementaction.Availability=1
														  and hremployeesalarystep.Approved in (1,5)
														  order by hremployeesalarystep.NextIncrementDate DESC
														  limit 1	"));
							if(!empty($preget))
							{
								$newdata3 =  json_decode(json_encode((array)$preget),true);
							    $PreServiceCategoryID = $newdata3[0]["ServiceCategoryID"];
							    $PreSalaryStepTransID = $newdata3[0]["SalaryStepTransID"];
								
								$UpdatePromotion = HRPromotion::where('P_ID','=',$PromoID)->update(array('PSalaryStep' => $PreSalaryStepTransID,'PServiceCategoryID' => $PreServiceCategoryID));
							}
							
				   
			   }
                    return Redirect::to('HREmployeeIncrementsEditMode');
                
            
        }
	}
	
		public function HREmployeeIncrementsEditMode()
	{
		$method = Request::getMethod();
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		if ($method == "GET")
			{
				
				if($userOrgType == 'HO')
			{
				if($UserTypeName == 'HR-MAPF')
				{
					 $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
												  hremployee.NIC,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.EPFNo,
												  hrpromotion.EPF,
												  hremploymentcode.Designation,
												  hrpromotion.PServiceCategoryID,
												  organisation.OrgaName,
												  organisation.Type,
												  hrsalaryscale.id as salcaleid,
												  hrsalaryscale.ServiceCategory,
												  hrsalarysteptrans.id as salarysteptransid,
												  hrsalarysteptrans.StepNo
												  from hremployeesalarystep
												  left join hremployee
												  on hremployeesalarystep.EmpID=hremployee.id
												  left join hremployeeepfhistory
											      on hremployee.id=hremployeeepfhistory.EmpId
												  left join hrpromotion
												  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
												  left join transfertype
												  on hrpromotion.TransferType=transfertype.T_ID
												  left join hremploymentcode
												  on hrpromotion.NewPost=hremploymentcode.id
												  left join organisation
												  on hrpromotion.ToOrganisation=organisation.id
												  left join hrsalaryscale
												  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
												  left join hrsalarysteptrans
												  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
												  where hremployeesalarystep.Deleted=0
												  and hremployeesalarystep.Approved !=0
												  and hremployee.Deleted=0
												  and hremployeeepfhistory.Deleted=0
												  and transfertype.Available=1
												  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')"));
				}
				else
				{
					 $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hremployee.EPFNo,
											  hrpromotion.EPF,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployeesalarystep.Approved !=0
											  and hremployee.Deleted=0
											  and transfertype.Available=1"));
				}
			}
			else
			{
			}
 
			}
			if ($method == "POST")
			{
				$cid = Input::get('QO_ID');
				if($cid == 'All')
				{
						if($userOrgType == 'HO')
			{
				if($UserTypeName == 'HR-MAPF')
				{
					 $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
												  hremployee.NIC,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.EPFNo,
												  hrpromotion.EPF,
												  hremploymentcode.Designation,
												  hrpromotion.PServiceCategoryID,
												  organisation.OrgaName,
												  organisation.Type,
												  hrsalaryscale.id as salcaleid,
												  hrsalaryscale.ServiceCategory,
												  hrsalarysteptrans.id as salarysteptransid,
												  hrsalarysteptrans.StepNo
												  from hremployeesalarystep
												  left join hremployee
												  on hremployeesalarystep.EmpID=hremployee.id
												   left join hremployeeepfhistory
											  on hremployee.id=hremployeeepfhistory.EmpId
												  left join hrpromotion
												  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
												  left join transfertype
												  on hrpromotion.TransferType=transfertype.T_ID
												  left join hremploymentcode
												  on hrpromotion.NewPost=hremploymentcode.id
												  left join organisation
												  on hrpromotion.ToOrganisation=organisation.id
												  left join hrsalaryscale
												  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
												  left join hrsalarysteptrans
												  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
												  where hremployeesalarystep.Deleted=0
												  and hremployeesalarystep.Approved !=0
												  and hremployee.Deleted=0
												  and hremployeeepfhistory.Deleted=0
												  and transfertype.Available=1
												  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')"));
				}
				else
				{
					 $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hremployee.EPFNo,
											  hrpromotion.EPF,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployeesalarystep.Approved !=0
											  and hremployee.Deleted=0
											  and transfertype.Available=1"));
				}
			}
			else
			{
			}
					/* $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
  hremployee.NIC,
  hremployee.Initials,
  hremployee.LastName,
  hremployee.EPFNo,
  hrpromotion.EPF,
  hremploymentcode.Designation,
  hrpromotion.PServiceCategoryID,
  organisation.OrgaName,
  organisation.Type,
  hrsalaryscale.id as salcaleid,
  hrsalaryscale.ServiceCategory,
  hrsalarysteptrans.id as salarysteptransid,
  hrsalarysteptrans.StepNo
  from hremployeesalarystep
  left join hremployee
  on hremployeesalarystep.EmpID=hremployee.id
  left join hrpromotion
  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join organisation
  on hrpromotion.ToOrganisation=organisation.id
  left join hrsalaryscale
  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
  left join hrsalarysteptrans
  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
  where hremployeesalarystep.Deleted=0
  and hremployeesalarystep.Approved!=0
  and hremployee.Deleted=0
  and transfertype.Available=1")); */
				}
				else
				{
						if($userOrgType == 'HO')
			{
				if($UserTypeName == 'HR-MAPF')
				{
					 $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
												  hremployee.NIC,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.EPFNo,
												  hrpromotion.EPF,
												  hremploymentcode.Designation,
												  hrpromotion.PServiceCategoryID,
												  organisation.OrgaName,
												  organisation.Type,
												  hrsalaryscale.id as salcaleid,
												  hrsalaryscale.ServiceCategory,
												  hrsalarysteptrans.id as salarysteptransid,
												  hrsalarysteptrans.StepNo
												  from hremployeesalarystep
												  left join hremployee
												  on hremployeesalarystep.EmpID=hremployee.id
												   left join hremployeeepfhistory
											  on hremployee.id=hremployeeepfhistory.EmpId
												  left join hrpromotion
												  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
												  left join transfertype
												  on hrpromotion.TransferType=transfertype.T_ID
												  left join hremploymentcode
												  on hrpromotion.NewPost=hremploymentcode.id
												  left join organisation
												  on hrpromotion.ToOrganisation=organisation.id
												  left join hrsalaryscale
												  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
												  left join hrsalarysteptrans
												  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
												  where hremployeesalarystep.Deleted=0
												  and hremployeesalarystep.Approved !=0
												  and hremployee.Deleted=0
												  and hremployeeepfhistory.Deleted=0
												  and transfertype.Available=1
												  and hrpromotion.ToOrganisation='".$cid."'
												  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')"));
				}
				else
				{
					 $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
											  hremployee.NIC,
											  hremployee.Initials,
											  hremployee.LastName,
											  hremployee.EPFNo,
											  hrpromotion.EPF,
											  hremploymentcode.Designation,
											  hrpromotion.PServiceCategoryID,
											  organisation.OrgaName,
											  organisation.Type,
											  hrsalaryscale.id as salcaleid,
											  hrsalaryscale.ServiceCategory,
											  hrsalarysteptrans.id as salarysteptransid,
											  hrsalarysteptrans.StepNo
											  from hremployeesalarystep
											  left join hremployee
											  on hremployeesalarystep.EmpID=hremployee.id
											  left join hrpromotion
											  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
											  left join transfertype
											  on hrpromotion.TransferType=transfertype.T_ID
											  left join hremploymentcode
											  on hrpromotion.NewPost=hremploymentcode.id
											  left join organisation
											  on hrpromotion.ToOrganisation=organisation.id
											  left join hrsalaryscale
											  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
											  left join hrsalarysteptrans
											  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
											  where hremployeesalarystep.Deleted=0
											  and hremployeesalarystep.Approved !=0
											  and hremployee.Deleted=0
											  and hrpromotion.ToOrganisation='".$cid."'
											  and transfertype.Available=1"));
				}
			}
			else
			{
			}
					/* $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
  hremployee.NIC,
  hremployee.Initials,
  hremployee.LastName,
  hremployee.EPFNo,
  hrpromotion.EPF,
  hremploymentcode.Designation,
  hrpromotion.PServiceCategoryID,
  organisation.OrgaName,
  organisation.Type,
  hrsalaryscale.id as salcaleid,
  hrsalaryscale.ServiceCategory,
  hrsalarysteptrans.id as salarysteptransid,
  hrsalarysteptrans.StepNo
  from hremployeesalarystep
  left join hremployee
  on hremployeesalarystep.EmpID=hremployee.id
  left join hrpromotion
  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join organisation
  on hrpromotion.ToOrganisation=organisation.id
  left join hrsalaryscale
  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
  left join hrsalarysteptrans
  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
  where hremployeesalarystep.Deleted=0
  and hremployeesalarystep.Approved!=0
  and hremployee.Deleted=0
  and transfertype.Available=1
  and hrpromotion.ToOrganisation='".$cid."'")); */
				}
				
			}
			
 		$v = View::make('HREmployeeIncrements.ViewEdit');
 		$v->quorga = $quorga;
		$v->Centers = Organisation::where('Deleted','=',0)->orderBy('OrgaName')->get();
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ActionIncrementReactive()
	{
		$ID = Input::get('id');
		$ReactiveDate = Input::get('ReactiveDate');
		//$NextY = Input::get('NextY');
	    $empid = User::getSysUser()->EmpId;
	    $FutureDatelimit = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('NextIncrementDate');
		$StepID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('SalaryStepTransID');
	    $ScaleID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('ServiceCategoryID');
		$P_ID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('PromotionID');
		$EmpID = HREmployeeSalaryStepData::where('id','=',$ID)->pluck('EmpID');
		// Update Promotion Increment Date and Month
	    $IncrementDate = date("d", strtotime($ReactiveDate));
		$IncrementMonth = date("m", strtotime($ReactiveDate));
		//$MOCenterMonitoringPlan = HREmployeeSalaryStepData::where('id','=',$ID)->update(array('Approved' => '5','ReactivatedDate' => $ReactiveDate,'User' => User::getSysUser()));
		$MOCenterMonitoringPlan = HREmployeeSalaryStepData::where('id','=',$ID)->update(array('ReactivatedDate' => $ReactiveDate,'User' => User::getSysUser()));
		/*  if($NextY == 'Yes')
		{
		
		 $UpdatePromotion1 = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)
		->update(array('IncrementMonth' => $IncrementMonth, 'IncrementDay' => $IncrementDate,'PSalaryStep' => $StepID, 'PServiceCategoryID' => $ScaleID));
		
		$UpdatePromotion2 = HRPromotion::where('P_ID','=',$P_ID)->update(array('PSalaryStep' => $StepID, 'PServiceCategoryID' => $ScaleID)); 
		
		
		$GetFutureRec = HREmployeeSalaryStepData::where('EmpID','=',$EmpID)->where('Deleted','=',0)->where('NextIncrementDate','>',$FutureDatelimit)->where('Approved','=',0)->get();
			
			
			foreach($GetFutureRec as $g)
			{
				 $GetNextInrementDateYear = date("Y", strtotime($g->NextIncrementDate));
				 $cc = "select DATE_FORMAT('$ReactiveDate','$GetNextInrementDateYear-%m-%d') as newdate";
				 $UpdateNewDate = DB::select(DB::raw($cc));
				 $newdata22 =  json_decode(json_encode((array)$UpdateNewDate),true);
				 $YearwiseIncrementDateNew = $newdata22[0]["newdate"];
				
				$UpdateUniq = HREmployeeSalaryStepData::where('id','=',$g->id)->update(array('NextIncrementDate' => $YearwiseIncrementDateNew));
			}
		
		} */ 
		
		
			
			
						
	
		return 1;
	}
	
	public function ViewHREmployeeIncrementsReactive()
	{
		$method = Request::getMethod();
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		if ($method == "GET")
			{
				if($userOrgType == 'HO')
				{
					if($UserTypeName == 'HR-MAPF')
					{
						$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
													  hremployee.NIC,
													  hremployee.Initials,
													  hremployee.LastName,
													  hremployee.EPFNo,
													  hrpromotion.EPF,
													  hremploymentcode.Designation,
													  hrpromotion.PServiceCategoryID,
													  organisation.OrgaName,
													  organisation.Type,
													  hrsalaryscale.id as salcaleid,
													  hrsalaryscale.ServiceCategory,
													  hrsalarysteptrans.id as salarysteptransid,
													  hrsalarysteptrans.StepNo
													  from hremployeesalarystep
													  left join hremployee
													  on hremployeesalarystep.EmpID=hremployee.id
													  left join hremployeeepfhistory
											          on hremployee.id=hremployeeepfhistory.EmpId
													  left join hrpromotion
													  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  left join hremploymentcode
													  on hrpromotion.NewPost=hremploymentcode.id
													  left join organisation
													  on hrpromotion.ToOrganisation=organisation.id
													  left join hrsalaryscale
													  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
													  left join hrsalarysteptrans
													  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
													  left join hrincrementaction
													  on hremployeesalarystep.Approved=hrincrementaction.id
													  where hremployeesalarystep.Deleted=0
													  and hrincrementaction.id in(2)
													  and hremployee.Deleted=0
													  and hremployeeepfhistory.Deleted=0
													  and transfertype.Available=1
													  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')"));
					}
					else
					{
						$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
													  hremployee.NIC,
													  hremployee.Initials,
													  hremployee.LastName,
													  hremployee.EPFNo,
													  hrpromotion.EPF,
													  hremploymentcode.Designation,
													  hrpromotion.PServiceCategoryID,
													  organisation.OrgaName,
													  organisation.Type,
													  hrsalaryscale.id as salcaleid,
													  hrsalaryscale.ServiceCategory,
													  hrsalarysteptrans.id as salarysteptransid,
													  hrsalarysteptrans.StepNo
													  from hremployeesalarystep
													  left join hremployee
													  on hremployeesalarystep.EmpID=hremployee.id
													  left join hrpromotion
													  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  left join hremploymentcode
													  on hrpromotion.NewPost=hremploymentcode.id
													  left join organisation
													  on hrpromotion.ToOrganisation=organisation.id
													  left join hrsalaryscale
													  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
													  left join hrsalarysteptrans
													  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
													  left join hrincrementaction
													  on hremployeesalarystep.Approved=hrincrementaction.id
													  where hremployeesalarystep.Deleted=0
													and hrincrementaction.id in(2)
													  and hremployee.Deleted=0
													  and transfertype.Available=1"));
					}
				}
				else
				{
				}
		
			}
			if ($method == "POST")
			{
				$cid = Input::get('QO_ID');
				if($cid == 'All')
				{
					if($userOrgType == 'HO')
				{
					if($UserTypeName == 'HR-MAPF')
					{
						$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
													  hremployee.NIC,
													  hremployee.Initials,
													  hremployee.LastName,
													  hremployee.EPFNo,
													  hrpromotion.EPF,
													  hremploymentcode.Designation,
													  hrpromotion.PServiceCategoryID,
													  organisation.OrgaName,
													  organisation.Type,
													  hrsalaryscale.id as salcaleid,
													  hrsalaryscale.ServiceCategory,
													  hrsalarysteptrans.id as salarysteptransid,
													  hrsalarysteptrans.StepNo
													  from hremployeesalarystep
													  left join hremployee
													  on hremployeesalarystep.EmpID=hremployee.id
													  left join hremployeeepfhistory
											          on hremployee.id=hremployeeepfhistory.EmpId
													  left join hrpromotion
													  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  left join hremploymentcode
													  on hrpromotion.NewPost=hremploymentcode.id
													  left join organisation
													  on hrpromotion.ToOrganisation=organisation.id
													  left join hrsalaryscale
													  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
													  left join hrsalarysteptrans
													  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
													  left join hrincrementaction
													  on hremployeesalarystep.Approved=hrincrementaction.id
													  where hremployeesalarystep.Deleted=0
													 and hrincrementaction.id in(2)
													  and hremployee.Deleted=0
													  and hremployeeepfhistory.Deleted=0
													  and transfertype.Available=1
													  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')"));
					}
					else
					{
						$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
													  hremployee.NIC,
													  hremployee.Initials,
													  hremployee.LastName,
													  hremployee.EPFNo,
													  hrpromotion.EPF,
													  hremploymentcode.Designation,
													  hrpromotion.PServiceCategoryID,
													  organisation.OrgaName,
													  organisation.Type,
													  hrsalaryscale.id as salcaleid,
													  hrsalaryscale.ServiceCategory,
													  hrsalarysteptrans.id as salarysteptransid,
													  hrsalarysteptrans.StepNo
													  from hremployeesalarystep
													  left join hremployee
													  on hremployeesalarystep.EmpID=hremployee.id
													  left join hrpromotion
													  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  left join hremploymentcode
													  on hrpromotion.NewPost=hremploymentcode.id
													  left join organisation
													  on hrpromotion.ToOrganisation=organisation.id
													  left join hrsalaryscale
													  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
													  left join hrsalarysteptrans
													  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
													  left join hrincrementaction
													  on hremployeesalarystep.Approved=hrincrementaction.id
													  where hremployeesalarystep.Deleted=0
													  and hrincrementaction.id in(2)
													  and hremployee.Deleted=0
													  and transfertype.Available=1"));
					}
				}
				else
				{
				}
				}
				else
				{
					if($userOrgType == 'HO')
				{
					if($UserTypeName == 'HR-MAPF')
					{
						$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
													  hremployee.NIC,
													  hremployee.Initials,
													  hremployee.LastName,
													  hremployee.EPFNo,
													  hrpromotion.EPF,
													  hremploymentcode.Designation,
													  hrpromotion.PServiceCategoryID,
													  organisation.OrgaName,
													  organisation.Type,
													  hrsalaryscale.id as salcaleid,
													  hrsalaryscale.ServiceCategory,
													  hrsalarysteptrans.id as salarysteptransid,
													  hrsalarysteptrans.StepNo
													  from hremployeesalarystep
													  left join hremployee
													  on hremployeesalarystep.EmpID=hremployee.id
													  left join hremployeeepfhistory
											          on hremployee.id=hremployeeepfhistory.EmpId
													  left join hrpromotion
													  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  left join hremploymentcode
													  on hrpromotion.NewPost=hremploymentcode.id
													  left join organisation
													  on hrpromotion.ToOrganisation=organisation.id
													  left join hrsalaryscale
													  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
													  left join hrsalarysteptrans
													  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
													  left join hrincrementaction
													  on hremployeesalarystep.Approved=hrincrementaction.id
													  where hremployeesalarystep.Deleted=0
													 and hrincrementaction.id in(2)
													  and hremployee.Deleted=0
													  and hremployeeepfhistory.Deleted=0
													  and transfertype.Available=1
													  and hrpromotion.ToOrganisation='".$cid."'
													  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')"));
					}
					else
					{
						$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
													  hremployee.NIC,
													  hremployee.Initials,
													  hremployee.LastName,
													  hremployee.EPFNo,
													  hrpromotion.EPF,
													  hremploymentcode.Designation,
													  hrpromotion.PServiceCategoryID,
													  organisation.OrgaName,
													  organisation.Type,
													  hrsalaryscale.id as salcaleid,
													  hrsalaryscale.ServiceCategory,
													  hrsalarysteptrans.id as salarysteptransid,
													  hrsalarysteptrans.StepNo
													  from hremployeesalarystep
													  left join hremployee
													  on hremployeesalarystep.EmpID=hremployee.id
													  left join hrpromotion
													  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  left join hremploymentcode
													  on hrpromotion.NewPost=hremploymentcode.id
													  left join organisation
													  on hrpromotion.ToOrganisation=organisation.id
													  left join hrsalaryscale
													  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
													  left join hrsalarysteptrans
													  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
													  left join hrincrementaction
													  on hremployeesalarystep.Approved=hrincrementaction.id
													  where hremployeesalarystep.Deleted=0
													and hrincrementaction.id in(2)
													  and hremployee.Deleted=0
													  and hrpromotion.ToOrganisation='".$cid."'
													  and transfertype.Available=1"));
					}
				}
				else
				{
				}
					/* $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
  hremployee.NIC,
  hremployee.Initials,
  hremployee.LastName,
  hremployee.EPFNo,
  hrpromotion.EPF,
  hremploymentcode.Designation,
  hrpromotion.PServiceCategoryID,
  organisation.OrgaName,
  organisation.Type,
  hrsalaryscale.id as salcaleid,
  hrsalaryscale.ServiceCategory,
  hrsalarysteptrans.id as salarysteptransid,
  hrsalarysteptrans.StepNo
  from hremployeesalarystep
  left join hremployee
  on hremployeesalarystep.EmpID=hremployee.id
  left join hrpromotion
  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join organisation
  on hrpromotion.ToOrganisation=organisation.id
  left join hrsalaryscale
  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
  left join hrsalarysteptrans
  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
  left join hrincrementaction
  on hremployeesalarystep.Approved=hrincrementaction.id
  where hremployeesalarystep.Deleted=0
  and hrincrementaction.HoldMonth=1
  and hremployee.Deleted=0
  and transfertype.Available=1
  and hrpromotion.ToOrganisation='".$cid."'")); */
				}
				
			}
			
 		$v = View::make('HREmployeeIncrements.ViewReactive');
 		$v->quorga = $quorga;
		$v->Centers = Organisation::where('Deleted','=',0)->orderBy('OrgaName')->get();
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function EditHREmployeeIncrementsAction()
	{
		$view = View::make('HREmployeeIncrements.EditAction');
        $method = Request::getMethod();

        if ($method == "GET") 
        {
            $empqua = HREmployeeSalaryStepData::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeSalaryStepData::where('id', '=', Input::get('id'))->pluck('EmpID');
            $view = View::make('HREmployeeIncrements.EditAction')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
			$Emplcode = HRPromotion::where('P_ID','=',$empqua->PromotionID)->pluck('NewPost');
			$Desi = HREmploymentCode::where('id','=',$Emplcode)->pluck('Designation');
			
            $view->user = User::getSysUser();
			$view->Designation = $Desi;
			//return HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$empqua->SalaryStepTransID)->get();
		    $view->quaorg = HRSalaryscale::where("id", "=", $empqua->ServiceCategoryID)->where('Deleted','=',0)->get();
			$view->salarysteps = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$empqua->SalaryStepTransID)->get();
		    $view->employees = HREmployee::where("Deleted", "!=", 1)->where('id','!=',$EmpId)->orderBy('EPFNo')->get();
		    $view->empqua = $empqua;
			$view->action = HRIncrementAction::where('Deleted','=',0)->orderBy('id')->get();
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $eq = HREmployeeSalaryStepData::find(Input::get('EQ_ID'));
                $eq->Approved = Input::get('Approve');
				$eq->ReasonForHold = Input::get('Reason');
			    $eq->GrossSalary = Input::get('GrossSalary');
				$eq->User = User::getSysUser()->userID;
                $eq->save();
				
				$n = new HREmployeeIncrementAction();
				$n->HREmpsalarystepID = Input::get('EQ_ID');
				$n->ActionID = Input::get('Approve');
				$n->User = User::getSysUser()->userID;
				$n->save(); 
				
				$checkholdmonth = HRIncrementAction::where('id','=',Input::get('Approve'))->pluck('HoldMonth');
              
               if($checkholdmonth == 1)
			   {
				   if(Input::get('Approve') == 2 || Input::get('Approve') == 3)
				   {
					 $deletea = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
					 $Months = [];
                     $Months = Input::get('IncrementMonth');
                     $countP = count($Months);
					 $i=0;
					 
					 for($i=0;$i<$countP;$i++)
					{
							$r = new HREmployeeIncrementHoldMonths();
							$r->MonthNo = $Months[$i];
							$r->HREmpsalaryStepID = Input::get('EQ_ID');
							$r->User = User::getSysUser()->userID;
							$r->save();

					}
					 
				   }
				  /*  if(Input::get('Approve') == 3)
				   {
					   $deletea = HREmployeeIncrementHoldMonths::where('HREmpsalaryStepID','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
					    $i=1;
						for($i=1;$i<=12;$i++)
						{
								$r = new HREmployeeIncrementHoldMonths();
								$r->MonthNo = $i;
								$r->HREmpsalaryStepID = Input::get('EQ_ID');
								$r->User = User::getSysUser()->userID;
								$r->save();

						}
					   
				   } */
			   }
			   
			   $availabilitya = HRIncrementAction::where('id','=',Input::get('Approve'))->pluck('Availability');
			   $PromoID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('PromotionID');
			   $StepID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('SalaryStepTransID');
			   $ScaleID = HREmployeeSalaryStepData::where('id','=',Input::get('EQ_ID'))->pluck('ServiceCategoryID');
			   if($availabilitya == 1)
			   {
				   $UpdatePromotion = HRPromotion::where('P_ID','=',$PromoID)->update(array('PSalaryStep' => $StepID,'PServiceCategoryID' => $ScaleID));
			   }
                    return Redirect::to('ViewHREmployeeIncrements');
                
            
        }
	}
	
		public function EditHREmployeeIncrements()
	{
		$view = View::make('HREmployeeIncrements.Edit');
        $method = Request::getMethod();

        if ($method == "GET") 
{
            $empqua = HREmployeeSalaryStepData::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeSalaryStepData::where('id', '=', Input::get('id'))->pluck('EmpID');
            $view = View::make('HREmployeeIncrements.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
            $view->user = User::getSysUser();
			$GetGradeID = HRPromotion::where('P_ID','=',$empqua->PromotionID)->pluck('PGradeId');
			$GetSerYear = HRSalaryscale:: where('id','=',$empqua->ServiceCategoryID)->pluck('Year');
			$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
			$view->GetSerYear = $GetSerYear;
			$view->GetGradeID = $GetGradeID;
			$view->GList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		    $view->quaorg = HRSalaryscale::where("Deleted", "!=", 1)->where('Year','=',$GetSerYear)->orderBy('ServiceCategory')->get();
			$view->salarysteps = HRSalaryStepTrans::where('Deleted','=',0)->where('SalaryScaleID','=',$empqua->ServiceCategoryID)->orderBy('StepNo')->get();
		    $view->employees = HREmployee::where("Deleted", "!=", 1)->where('id','!=',$EmpId)->orderBy('EPFNo')->get();
		    $view->empqua = $empqua;
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $eq = HREmployeeSalaryStepData::find(Input::get('EQ_ID'));
                $eq->SalaryStepTransID = Input::get('SalaryStepTransID');
				$eq->NextIncrementDate = Input::get('NextIncrementDate');
			    $eq->ServiceCategoryID = Input::get('QO_ID');
				$eq->User = User::getSysUser()->userID;
                $eq->save();
              
               return Redirect::to('ViewHREmployeeIncrements');
                
            
        }
		
	}
	
	public function DownloadAnnualIncrementPaymentForm()
	{
		
		
		$id = Input::get('id');
		$HRemployeesalarystepID = HREmployeeSalaryStepData::where('id','=',$id)->first();
		$Initials = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Initials');
		$LastName = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('LastName');
		$HREmploymentCodeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('NewPost');
		$Designation = HREmploymentCode::where('id','=',$HREmploymentCodeID)->pluck('Designation');
		//$FirstAppoDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$HRemployeesalarystepID->EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)->pluck('StartDate');
		$FDateSql = DB::select(DB::raw("SELECT DATE_FORMAT(hrpromotion.StartDate,'%d-%m-%Y') AS niceDate
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join employeetype
  on hrpromotion.EmpType=employeetype.ET_ID
  where hrpromotion.Deleted=0
  and hrpromotion.Emp_ID='".$HRemployeesalarystepID->EmpID."'
  and hrpromotion.Priority=1
  and transfertype.TransferType in('Promotion','FirstAppointment')
  and employeetype.EmployeeType='Permanent'
  ORDER by hrpromotion.StartDate DESC
  limit 1"));
   $FDateSqlaaa =  json_decode(json_encode((array)$FDateSql),true);
   $FirstAppoDate = $FDateSqlaaa[0]["niceDate"];
   
   $DateOfInsql = DB::select(DB::raw("SELECT DATE_FORMAT('".$HRemployeesalarystepID->NextIncrementDate."','%d-%m-%Y') AS incrDate"));
   $FDateOfInsql =  json_decode(json_encode((array)$DateOfInsql),true);
   $DateOfIncrement = $FDateOfInsql[0]["incrDate"];
		$CurrentOrdaID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('ToOrganisation');
		$CurrentOrgaName = Organisation::where('id','=',$CurrentOrdaID)->pluck('OrgaName');
		$EPF = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('EPF');
		
		/* $sqlp = DB::select(DB::raw("select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.PromotionID='".$HRemployeesalarystepID->PromotionID."'
							    and hremployeesalarystep.Approved not in(0)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1")); */
								
								
							   $AA =  "select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved in(1,5)
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1";
								
								$sqlp = DB::select(DB::raw($AA));
								
								
							  $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  //$PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"]; 2020-09-11
							  $PresentserviceCatID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PServiceCategoryID');
							  //$PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"]; 2020-09-11
							  $PresentserviceStepID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PSalaryStep');
							  $PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId');
							  
							  $PresentSalaryScale = HRSalaryscale::where('Deleted','=',0)->where('id','=',$PresentserviceCatID)->pluck('SalaryScale');
							  $PresentSalaryStepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepNo');
							  $PresentSalaryStepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepAmount');
							  $NextsalarystepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepNo');
							  $NextsalarystepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepAmount');
							  $sqladdyearass = DB::select(DB::raw("select DATE_SUB('".$HRemployeesalarystepID->NextIncrementDate."', INTERVAL 1 YEAR) as newdate"));
							  $newdata322 =  json_decode(json_encode((array)$sqladdyearass),true);
							  $expectedcomstepassFrom = $newdata322[0]["newdate"];
							
	//hremployeesal conversion
	
	//$ = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('PGradeId');
										 $BB = "select hrsalaryconversionincrement.*
											     from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$PresentserviceCatID."'
											  and hrsalaryconversionincrement.StepTransID='".$PresentserviceStepID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$PresentGradeID."'";
											  
											  $PresentSalaryBasicSQL = DB::select(DB::raw($BB));
											  
											  if(count($PresentSalaryBasicSQL) == 0)
											  {
												$PresentBasicSalary = '';
												$PresentAdjusmentAllowence = '';
											  }
											  else
											  {
											    $newdataaaPressal =  json_decode(json_encode((array)$PresentSalaryBasicSQL),true);
											    $PresentBasicSalary = $newdataaaPressal[0]["BasicSalary"];
											    $PresentAdjusmentAllowence = $newdataaaPressal[0]["AdjusmentAllowence"];
											  }
	//NextIncrementDate
	 
	$NextGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('PGradeId'); //Change Grade ID to Pgrade ID in Promotion Table
	 $chesql = "select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$HRemployeesalarystepID->ServiceCategoryID."'
											  and hrsalaryconversionincrement.StepTransID='".$HRemployeesalarystepID->SalaryStepTransID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$NextGradeID."'";
	 $NextSalaryBasicSQL = DB::select(DB::raw($chesql));
											  
											  if(count($NextSalaryBasicSQL) == 0)
											  {
												  $NextBasicSalary = '';
												  $NextAdjusmentAllowence = '';
											  }
											  else
											  {
											      $newdataaaNextssal =  json_decode(json_encode((array)$NextSalaryBasicSQL),true);
											      $NextBasicSalary = $newdataaaNextssal[0]["BasicSalary"];
											      $NextAdjusmentAllowence = $newdataaaNextssal[0]["AdjusmentAllowence"];
											  }
											  
	
	//end
	$DateOfSys = DB::select(DB::raw("SELECT DATE_FORMAT(CURDATE(),'-%m-%Y') AS SYSdateName"));
   $DateOfSysql =  json_decode(json_encode((array)$DateOfSys),true);
   $DateOfSystem = $DateOfSysql[0]["SYSdateName"];
	$PersonalFileNAme = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$HRemployeesalarystepID->EmpID)->pluck('FileNo');
	
	$GenderName = "";						  
	$Gender = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Sex');
	if($Gender == 'Male')
	{
		$GenderName = 'Mr';
	}
	elseif($Gender == 'Female')
	{
		$GenderName = 'Ms';
	}
	else
	{
		$GenderName = "";
	}
	
	
	if(date('Y', strtotime($DateOfIncrement)) <= 2019)
	{
		//return '2019';
	$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentAdjusmentAllowence.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	<td style="width:50%;font-size:16px;">
	: II.Adjustment allowances for Gross Salary
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextAdjusmentAllowence.'
	</td>
	</tr>
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) & (07:II) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}
	else
	{
		//return '2020';
		$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table>';
$html.='<center>.........................................................................................................................................................................</center><br/>';
$html.='<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:100%;font-size:16px;">
	<center><b>Vocational Training Authority of Sri Lanka</b></center>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:14px;">
	<center>No:354,Nipunatha Piyasa,Elvitigala Mw,Narahenpita,Colombo 05.</center>
	</td>
	</tr></table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">

	<tr>
	<td style="width:60%;font-size:16px;">
	My No: '.$PersonalFileNAme.'
	</td>
	<td style="width:40%;font-size:16px;">
	Date : ...... '.$DateOfSystem.'
	</td>
	</tr>
	</table></center><hr/>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:70%;font-size:16px;">
	Director(Finance),
	</td>
	<td style="width:30%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:70%;font-size:16px;">
	VTA.
	</td>
	<td style="width:30%;font-size:16px;">
	E.P.F - '.$EPF.'
	</td>
	</tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	<b><u>Certificate of Payment of Increment</u></b>
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:5%;font-size:16px;">
	1.
	</td>
	<td style="width:30%;font-size:16px;">
	Name
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$GenderName.' '.$Initials.' '.$LastName.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	2.
	</td>
	<td style="width:30%;font-size:16px;">
	Designation
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$Designation.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	3.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Appoinment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$FirstAppoDate.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	4.
	</td>
	<td style="width:30%;font-size:16px;">
	Monthly Salary Scale
	</td>
	<td style="width:50%;font-size:16px;">
	: Rs.'.$PresentSalaryScale.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	5.
	</td>
	<td style="width:30%;font-size:16px;">
	Current Salary
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$PresentBasicSalary.'
	</tr>
	
	<tr>
	<td style="width:5%;font-size:16px;">
	6.
	</td>
	<td style="width:30%;font-size:16px;">
	Date of Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: '.$DateOfIncrement.'
	</td>
	<td style="width:15%;font-size:16px;">
	
	</td>
	</tr>
	<tr>
	<td style="width:5%;font-size:16px;">
	7.
	</td>
	<td style="width:30%;font-size:16px;">
	According to Increment
	</td>
	<td style="width:50%;font-size:16px;">
	: I.Monthly Salary Step
	</td>
	<td style="width:15%;font-size:16px;">
	: Rs. '.$NextBasicSalary.'
	</td>
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	Above new salary step in No(07:I) is approved from the date in No(06).
	</td>
	
	</tr>
	
	</table></center>';
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;" border="0">
    <tr>
	<td style="width:100%;font-size:16px;">
	..........................................................................
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	Director (Human Resources & Administration)
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	CC:
	</td>
	</tr>
	 <tr>
	<td style="width:100%;font-size:16px;">
	1. '.$GenderName.' '.$Initials.' '.$LastName.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- For Information
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:16px;">
	2. Auditor General
	</td>
	</tr>
	</table></center><br/>';
	

$html.='</td></tr></table></body></html>';	
	}



    return $html;	
							
	}
	
	public function DownloadAnnualIncrementForm()
	{
    
    $id = Input::get('id');
	 $HRemployeesalarystepID = HREmployeeSalaryStepData::where('id','=',$id)->first();
	$Initials = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Initials');
	$LastName = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('LastName');
	$HREmploymentCodeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('NewPost');
	$Designation = HREmploymentCode::where('id','=',$HREmploymentCodeID)->pluck('Designation');
	//$FirstAppoDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',$HRemployeesalarystepID->EmpID)->where('CurrentRecord','=','Yes')->where('Priority','=',1)->pluck('StartDate');
	$CurrentOrdaID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('ToOrganisation');
	$CurrentOrgaName = Organisation::where('id','=',$CurrentOrdaID)->pluck('OrgaName');
	if($CurrentOrgaName == 'Head Office')
	{
		$DivisionNameID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('ToDepartment');
		$CurrentOrgaName = Department::where('D_ID','=',$DivisionNameID)->pluck('DepartmentName');
	}
	$FDateSql = DB::select(DB::raw("SELECT DATE_FORMAT(hrpromotion.StartDate,'%d-%m-%Y') AS niceDate
  from hrpromotion
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join employeetype
  on hrpromotion.EmpType=employeetype.ET_ID
  where hrpromotion.Deleted=0
  and hrpromotion.Emp_ID='".$HRemployeesalarystepID->EmpID."'
  and hrpromotion.Priority=1
  and transfertype.TransferType in('Promotion','FirstAppointment')
  and employeetype.EmployeeType='Permanent'
  ORDER by hrpromotion.StartDate DESC
  limit 1"));
   $FDateSqlaaa =  json_decode(json_encode((array)$FDateSql),true);
   $FirstAppoDate = $FDateSqlaaa[0]["niceDate"];
  
	 /* $sqlpp = "select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.PromotionID='".$HRemployeesalarystepID->PromotionID."'
							    and hremployeesalarystep.Approved not in(0)
								and hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1"; */
								
								$sqlpp = "select hremployeesalarystep.*
							    from hremployeesalarystep
							    where hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.EmpID='".$HRemployeesalarystepID->EmpID."'
							    and hremployeesalarystep.Approved not in(0)
								and hremployeesalarystep.Deleted=0
							    and hremployeesalarystep.NextIncrementDate<CURDATE()
							    order by hremployeesalarystep.NextIncrementDate DESC
							    limit 1";
								
	$sqlp = DB::select(DB::raw($sqlpp));
							  $newdataaa =  json_decode(json_encode((array)$sqlp),true);
							  $PresentserviceCatID = $newdataaa[0]["ServiceCategoryID"];
							  $PresentserviceStepID = $newdataaa[0]["SalaryStepTransID"];
							  $OLDPromotionId = $newdataaa[0]["PromotionID"];
							  
	$PresentSalaryScale = HRSalaryscale::where('Deleted','=',0)->where('id','=',$PresentserviceCatID)->pluck('SalaryScale');
	$PresentSalaryStepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepNo');
	$PresentSalaryStepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$PresentserviceStepID)->pluck('StepAmount');
	$NextsalarystepNo = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepNo');
	$NextsalarystepAmount = HRSalaryStepTrans::where('Deleted','=',0)->where('id','=',$HRemployeesalarystepID->SalaryStepTransID)->pluck('StepAmount');
	
	
	$sqladdyearass = DB::select(DB::raw("select DATE_FORMAT(DATE_SUB('".$HRemployeesalarystepID->NextIncrementDate."', INTERVAL 1 YEAR),'%d-%m-%Y') as newdate"));
							$newdata322 =  json_decode(json_encode((array)$sqladdyearass),true);
							$expectedcomstepassFrom = $newdata322[0]["newdate"];
	
	//hremployeesal conversion
	$PresentGradeID = HRPromotion::where('P_ID','=',$OLDPromotionId)->pluck('PGradeId');
	  //$PresentGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('PGradeId');
	             $sqlPresentSalaryBasicSQL = "select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$PresentserviceCatID."'
											  and hrsalaryconversionincrement.StepTransID='".$PresentserviceStepID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$PresentGradeID."'";
											  
											  
									$PresentSalaryBasicSQL = DB::select(DB::raw($sqlPresentSalaryBasicSQL));		  
											  if(count($PresentSalaryBasicSQL) == 0)
											  {
												  $PresentBasicSalary = '';
												  $PresentAdjusmentAllowence = '';
											  }
											  else{
											  $newdataaaPressal =  json_decode(json_encode((array)$PresentSalaryBasicSQL),true);
											  $PresentBasicSalary = $newdataaaPressal[0]["BasicSalary"];
											  $PresentAdjusmentAllowence = $newdataaaPressal[0]["AdjusmentAllowence"];
											  }
	//NextIncrementDate
	$NextGradeID = HRPromotion::where('P_ID','=',$HRemployeesalarystepID->PromotionID)->pluck('GradeId');
	 $sqlNextSalaryBasicSQL = "select hrsalaryconversionincrement.*
											  from hrsalaryconversionincrement
											  left join hrgrade
											  on hrsalaryconversionincrement.GradeId=hrgrade.id
											  where hrsalaryconversionincrement.Deleted=0
											  and hrsalaryconversionincrement.Active='1'
											  and hrsalaryconversionincrement.ServiceCategoryID='".$HRemployeesalarystepID->ServiceCategoryID."'
											  and hrsalaryconversionincrement.StepTransID='".$HRemployeesalarystepID->SalaryStepTransID."'
											  and Year(hrsalaryconversionincrement.SalaryConversionDate)=YEAR('".$HRemployeesalarystepID->NextIncrementDate."')
											  and hrsalaryconversionincrement.GradeId='".$NextGradeID."'";
							$NextSalaryBasicSQL = DB::select(DB::raw($sqlNextSalaryBasicSQL));				  
											  if(count($NextSalaryBasicSQL) == 0)
											  {
												  $NextBasicSalary = '';
												  $NextAdjusmentAllowence = '';
											  }
											  else{
												  $newdataaaNextssal =  json_decode(json_encode((array)$NextSalaryBasicSQL),true);
											      $NextBasicSalary = $newdataaaNextssal[0]["BasicSalary"];
											      $NextAdjusmentAllowence = $newdataaaNextssal[0]["AdjusmentAllowence"];
											  }
											  
											  
	
	//end
	
	$AssesmentPeriodTo = DB::select(DB::raw("select DATE_FORMAT(DATE_SUB('".$HRemployeesalarystepID->NextIncrementDate."', INTERVAL 1 DAY),'%d-%m-%Y') as ASSPTo"));
							$AssesmentPeriodTo322 =  json_decode(json_encode((array)$AssesmentPeriodTo),true);
							$AssesmentPeriodToDate = $AssesmentPeriodTo322[0]["ASSPTo"];
	$JM = "";
	$MA = "";
	 $html = '';
	
	 $JMc = DB::select(DB::raw("select *
								  from hrsalaryscale
								  where id='".$HRemployeesalarystepID->ServiceCategoryID."'
								  and (hrsalaryscale.SalaryCode like 'JM%' OR 
								  hrsalaryscale.SalaryCode like 'MM%' OR 
								  hrsalaryscale.SalaryCode like 'HM%' )"));
		$GenderName = "";						  
	$Gender = HREmployee::where('id','=',$HRemployeesalarystepID->EmpID)->where('Deleted','=',0)->pluck('Sex');
	if($Gender == 'Male')
	{
		$GenderName = 'Mr';
	}
	elseif($Gender == 'Female')
	{
		$GenderName = 'Ms';
	}
	else
	{
		$GenderName = "";
	}
	
	if(count($JMc) == 0)
	{
		$JM = "No";
		$MA = "Yes";
	}
	else
	{
		$JM = "Yes";
		$MA = "No";
	}
	
	if($JM == 'Yes')
	{
		$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">
	<tr>
	<td style="width:100%">
	<h3><center><b>ASSESSMENT FOR ANNUAL INCREMENTS</b></center></h3>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<center>(For Executive Grades)</center>
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
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:25%">Name:</td><td style="width:25%">'.$GenderName.' '.$Initials.' '.$LastName.'</td>
	<td style="width:25%">Designation:</td><td style="width:25%">'.$Designation.'</td></tr>
	<tr><td style="width:25%">Date of Employment:</td><td style="width:25%">'.$FirstAppoDate.'</td>
	<td style="width:25%">Present Salary Scale:</td><td style="width:25%">'.$PresentSalaryScale.'</td></tr>
	<tr><td style="width:25%">Work Place:</td><td style="width:25%">'.$CurrentOrgaName.'</td>
	<td style="width:25%">Present Salary :</td><td style="width:25%">'.$PresentBasicSalary.' + '.$PresentAdjusmentAllowence.' /=</td></tr>
	<tr><td style="width:25%"></td><td style="width:25%"></td>
	<td style="width:25%">Next Salary :</td><td style="width:25%">'.$NextBasicSalary.' + '.$NextAdjusmentAllowence.' /=</td></tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><br/><td style="width:100%">Assessment Period: From:  '.$expectedcomstepassFrom.'  To:'.$AssesmentPeriodToDate.'</td></tr>
	</table></center>';
	
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:50%">
	<center><table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:100%"><center>Mark:Excellent - 04,Good - 03,Fair - 02</center></td</tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"><center>Minimum Expected - 01</center></td></tr>
	<tr><td style="width:100%"><center>Unsatisfactory - 0</center></td></tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"><center>Maximum Marks : 56</center></td></tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"></td></tr>
	</table></center>
	</td>
	<td style="width:50%">
	<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:100%"><center>Leave taken(During the related increment period)</center><br/></td</tr>
	</table>
	<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:25%"><left>Casual:</left></td><td style="width:75%"></td></tr>
	<tr><td style="width:25%"><left>Medical:</right></td><td style="width:75%"></td></tr>
	<tr><td style="width:25%"><left>Annual:</left></td><td style="width:75%"></td></tr>
	<tr><td style="width:25%"><right>No Pay:</right></td><td style="width:75%"></td></tr>
	</table>
	<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:100%"><br/>Signature of Leave Clerk :.....................................</td></tr>
	
	</table>
	</td></tr>
	
	</table></center>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;align:center" border="0" style="">
	<tr><br/><td style="width:95%"><b>Recommendations/Warning/Punishments during the period:</b></td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	</table></center>';

	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;;align:center" border="1" style="">
	<tr>
	<td style="width:5%"><Center>No</center></td>
	<td style="width:40%"><Center>Description</center></td>
	<td style="width:10%"><Center>Excellent</center></td>
	<td style="width:10%"><Center>Good</center></td>
	<td style="width:10%"><Center>Fair</center></td>
	<td style="width:10%"><Center>Poor</center></td>
	<td style="width:15%"><Center>Comments</center></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>1</Center></td>
	<td style="width:40%">PLANNING AND PREPARATION<br/>(ability to outline the objectives of the job and attend to planning and preparation to achive them)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>2</Center></td>
	<td style="width:40%">OUTPUT<br/>(His/Her actual output against the planned quantity of work,consistency,completion of work,commitment,use of time ect.)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>3</Center></td>
	<td style="width:40%">QUALITY OF WORK<br/>(Accuracy,correctness,efficiency,application,ect.)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>4</Center></td>
	<td style="width:40%">DEPEND ABILITY<br/>(Sence of responsibility,reliability,tactfulness)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>5</Center></td>
	<td style="width:40%">JOB KNOWLEDGE<br/>(Ability to perform all phases of the job,to handle new and unusual assignment within the scope of his/her job)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>6</Center></td>
	<td style="width:40%">INITIATIVE AND CREATIVITY<br/>(Ability to suggest ideas,methods ect. and readness to assume responsibility in introducing same.)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>7</Center></td>
	<td style="width:40%">LEADERSHIP<br/>(Ability to execute the work through others.To command and win respect and co-operation from subordinates.)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	</table></br></center>';
	$html.='</td></tr></table>';
	//second page
	$html.='<table style="width:100%;border-collapse:collapse;align:center;page-break-before: always" border="1">
	<tr>
	<td>';
	$html.='<center><BR/><table style="width:95%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr>
	<td style="width:5%"><Center>No</center></td>
	<td style="width:40%"><Center>Description</center></td>
	<td style="width:10%"><Center>Excellent</center></td>
	<td style="width:10%"><Center>Good</center></td>
	<td style="width:10%"><Center>Fair</center></td>
	<td style="width:10%"><Center>Poor</center></td>
	<td style="width:15%"><Center>Comments</center></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>8</Center></td>
	<td style="width:40%">JUDGMENT<br/>(His/Her insight into problems,sense ofproportions and values,ability to reach decisions,find solutions in complex and emergency)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>9</Center></td>
	<td style="width:40%">PUBLIC RELATIONS<br/>(Courtesy,presentation,tactfulness,acceptence,achivebility ect.)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>10</Center></td>
	<td style="width:40%">MAINTENANCE,NEATNESS & ODERLINESS<br/>(Handling property and equipment)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>11</Center></td>
	<td style="width:40%">LIAISON & CO-OPRATION<br/>(Ability and desire to work in co-opration and liaison with others)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>12</Center></td>
	<td style="width:40%">DESIRE TO SUCCEED<br/>(Willingness to teach,train and develop subordinates,willingness to learn and succeed,willpower,enthusiasm ect.)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>13</Center></td>
	<td style="width:40%">ATTITUDE & LOYALITY<br/>(Favorable attitude towards the job and VTA loyality)</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>14</Center></td>
	<td style="width:40%">ATTENDENCE & PUNTUALITY<br/></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%;border-right-color:#ffffff;"><Center></Center></td>
	<td style="width:45%"><Center>Total Marks</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:15%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:5%;border-right-color:#ffffff;"><Center></Center></td>
	<td style="width:45%"><Center>Grand Total</center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:15%"><Center></center></td>
	</tr>
	<tr>
	<td style="width:5%;border-right-color:#ffffff;"><Center></Center></td>
	<td style="width:45%"><Center>Percentage out of the Total Marks<br/><br/></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:15%"><Center></center><br/></td>
	</tr>
	</table><br/></center>';
	
		$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;align:center" border="0" style="">
	<tr><td style="width:95%"><b>Comments:</b></td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	</table></center>';
	
	
	$html.='<br/>
	<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:100%">Recommendations<br/></td></tr>
	<tr><td style="width:100%"><br/>Recommended Increment Rs:..................................................</td></tr>
	</table></center><br/><br/><br/>';
	
	$html.='<br/>
	<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:70%"></td><td style="width:30%">.....................................................</td></tr>
	<tr><td style="width:70%"></td><td style="width:30%"><center>Asst.Director/Dy.Director/Director</center></td></tr>
	</table></center><br/>';
	
	$html.='<hr/>';
	
	$html.='
	<center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:50%">Approved/Not approved:</td><td style="width:50%"></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"><br/><br/><center>.................................................................................</center></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"><center>Chairman/Director-Admin</center><br/><br/></td></tr>
	<tr><td style="width:50%"></td><td style="width:50%"><center>Date : .................................................................</center></td></tr>
	</table></center><br/>';
	
	$html.='</td></tr></table>';
	
     $html.='</tbody></html>';     
  }
   
	if($MA == 'Yes')
	{
		$html='<html><head>
   
    </head>
    <body>
	<table style="width:100%;border-collapse:collapse;" border="1">
	<tr>
	<td>
	
	<center><table style="width:95%;border-collapse:collapse;" border="0">
	<tr>
	<td style="width:100%">
	<h3><center><b>ASSESSMENT FOR ANNUAL INCREMENTS</b></center></h3>
	</td>
	</tr>
	<tr>
	<td style="width:100%;font-size:15px;">
	<center>(For Non Executive Grades)</center>
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
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:25%">Name:</td><td style="width:25%">'.$GenderName.' '.$Initials.' '.$LastName.'</td>
	<td style="width:25%">Designation:</td><td style="width:25%">'.$Designation.'</td></tr>
	<tr><td style="width:25%">Date of Employment:</td><td style="width:25%">'.$FirstAppoDate.'</td>
	<td style="width:25%">Present Salary Scale:</td><td style="width:25%">'.$PresentSalaryScale.'</td></tr>
	<tr><td style="width:25%">Work Place:</td><td style="width:25%">'.$CurrentOrgaName.'</td>
	<td style="width:25%">Present Salary :</td><td style="width:25%">'.$PresentBasicSalary.' + '.$PresentAdjusmentAllowence.' /=</td></tr>
	<tr><td style="width:25%"></td><td style="width:25%"></td>
	<td style="width:25%">Next Salary :</td><td style="width:25%">'.$NextBasicSalary.' + '.$NextAdjusmentAllowence.' /=</td></tr>
	</table></center>';
	$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><br/><td style="width:100%">Assessment Period: From:  '.$expectedcomstepassFrom.'  To:'.$AssesmentPeriodToDate.'</td></tr>
	</table></center>';
	
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:50%">
	<center><table style="width:100%;border-collapse:collapse;font-size:15px;" border="0" style="">
	<tr><td style="width:100%"><center>Mark:Excellent - 04,Good - 03,Fair - 02</center></td</tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"><center>Minimum Expected - 01</center></td></tr>
	<tr><td style="width:100%"><center>Unsatisfactory - 0</center></td></tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"><center>Maximum Marks : 28</center></td></tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"></td></tr>
	<tr><td style="width:100%"></td></tr>
	</table></center>
	</td>
	<td style="width:50%">
	<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:100%"><center>Leave taken(During the related increment period)</center><br/></td</tr>
	</table>
	<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:25%"><left>Casual:</left></td><td style="width:75%"></td></tr>
	<tr><td style="width:25%"><left>Medical:</right></td><td style="width:75%"></td></tr>
	<tr><td style="width:25%"><left>Annual:</left></td><td style="width:75%"></td></tr>
	<tr><td style="width:25%"><right>No Pay:</right></td><td style="width:75%"></td></tr>
	</table>
	<table style="width:100%;border-collapse:collapse;font-size:15px;" border="1" style="">
	<tr><td style="width:100%"><br/>Signature of Leave Clerk :.....................................</td></tr>
	
	</table>
	</td></tr>
	
	</table></center><br/>';
	
	$html.='<center><table style="width:95%;border-collapse:collapse;font-size:15px;align:center" border="0" style="">
	<tr><br/><td style="width:95%"><b>Recommendations/Warning/Punishments during the period:</b></td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	<tr><td style="width:95%">..............................................................................................................................................................................</td></tr>
	</table></center>';

	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;;align:center" border="1" style="">
	<tr>
	<td style="width:5%"><Center>No</center></td>
	<td style="width:40%"><Center>Description</center></td>
	<td style="width:10%"><Center>Excellent</center></td>
	<td style="width:10%"><Center>Good</center></td>
	<td style="width:10%"><Center>Fair</center></td>
	<td style="width:10%"><Center>Poor</center></td>
	<td style="width:15%"><Center>Gr.Total</center></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>1</Center></td>
	<td style="width:40%">Knowledge of Work</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>2</Center></td>
	<td style="width:40%">Quality of Work</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>3</Center></td>
	<td style="width:40%">Initiative</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>4</Center></td>
	<td style="width:40%">Responsibility</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>5</Center></td>
	<td style="width:40%">Loyalty & Co-operation</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>6</Center></td>
	<td style="width:40%">Attitude towards work and Co-workers</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%"><Center>7</Center></td>
	<td style="width:40%">Attendence & Punctuality</td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:10%"></td>
	<td style="width:15%"></td>
	</tr>
	<tr>
	<td style="width:5%;border-right-color:#ffffff;"><Center></Center></td>
	<td style="width:45%"><Center>Total Marks</center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:10%"><Center></center></td>
	<td style="width:15%"><Center></center></td>
	</tr>
	
	<td style="width:5%;border-right-color:#ffffff;"><Center></Center></td>
	<td style="width:45%"><Center>Percentage out of the Total Marks<br/><br/></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:10%;border-right-color:#ffffff;"><Center></center></td>
	<td style="width:15%"><Center></center><br/></td>
	</tr>
	</table></center>';
	
	$html.='<br/><center><table style="width:95%;border-collapse:collapse;font-size:15px;;align:center" border="1" style="">
	<tr>
	<td style="width:50%">
	<center>
	<table style="width:100%;border-collapse:collapse;font-size:15px;;align:center" border="0" style="">
	<tr>
	<td style="width:100%">
	<u>RECOMMENDATION</u>
	<br/>
	Remark:
	<br/>
	................................................................................<br/>
	................................................................................</br/>
	................................................................................<br/><br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.....................................................<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;Signature of Director/Dy.Director/Asst.Director
	</td>
	</tr>
	
	</table></center>
	</td>
	
	<td style="width:50%">
	<center>
	<table style="width:100%;border-collapse:collapse;font-size:15px;;align:center" border="0" style="">
	<tr>
	<td style="width:100%">
	<u>APPROVED/NOT APPROVED</u>
	<br/><br/>
	<br/>
	&nbsp;&nbsp;............................................................<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Director(Administration)</br/>
	<br/>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:...............................
	
	</td>
	</tr>
	</table></center>
	</td>
	
	</tr></table></center><br/><br/>';
	$html.='<center><b><i>If not approved the increment,it should be informed to the relevant employee in-writing.</i></b></center>';
	$html.='</td></tr></table>';
	//second page
	
	
     $html.='</tbody></html>';     
  }
  


  return $html;


  }
	public function ViewHREmployeeIncrements()
	{
		$method = Request::getMethod();
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
		if ($method == "GET")
			{
				if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
														  hremployee.NIC,
														  hremployee.Initials,
														  hremployee.LastName,
														  hremployee.EPFNo,
														  hrpromotion.EPF,
														  hremploymentcode.Designation,
														  hrpromotion.PServiceCategoryID,
														  organisation.OrgaName,
														  organisation.Type,
														  hrsalaryscale.id as salcaleid,
														  hrsalaryscale.ServiceCategory,
														  hrsalarysteptrans.id as salarysteptransid,
														  hrsalarysteptrans.StepNo
														  from hremployeesalarystep
														  left join hremployee
														  on hremployeesalarystep.EmpID=hremployee.id
														  left join hremployeeepfhistory
											              on hremployeeepfhistory.EmpId=hremployee.id
														  left join hrpromotion
														  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
														  left join transfertype
														  on hrpromotion.TransferType=transfertype.T_ID
														  left join hremploymentcode
														  on hrpromotion.NewPost=hremploymentcode.id
														  left join organisation
														  on hrpromotion.ToOrganisation=organisation.id
														  left join hrsalaryscale
														  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
														  left join hrsalarysteptrans
														  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeeepfhistory.Deleted=0
											              and hremployeesalarystep.Approved=0
														  and hremployee.Deleted=0
														  and transfertype.Available=1
														  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
														AND hremployeesalarystep.EmpID NOT IN (SELECT
														hrpromotion.Emp_ID
													  FROM hrpromotion
														LEFT JOIN transfertype
														  ON hrpromotion.TransferType = transfertype.T_ID
													  WHERE hrpromotion.Deleted = 0
													  AND hrpromotion.CurrentRecord = 'Yes'
													  AND transfertype.Available = 0
													  AND hrpromotion.Priority = 1)"));
						}
						else
						{
							$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
														  hremployee.NIC,
														  hremployee.Initials,
														  hremployee.LastName,
														  hremployee.EPFNo,
														  hrpromotion.EPF,
														  hremploymentcode.Designation,
														  hrpromotion.PServiceCategoryID,
														  organisation.OrgaName,
														  organisation.Type,
														  hrsalaryscale.id as salcaleid,
														  hrsalaryscale.ServiceCategory,
														  hrsalarysteptrans.id as salarysteptransid,
														  hrsalarysteptrans.StepNo
														  from hremployeesalarystep
														  left join hremployee
														  on hremployeesalarystep.EmpID=hremployee.id 
														  left join hrpromotion
														  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
														  left join transfertype
														  on hrpromotion.TransferType=transfertype.T_ID
														  left join hremploymentcode
														  on hrpromotion.NewPost=hremploymentcode.id
														  left join organisation
														  on hrpromotion.ToOrganisation=organisation.id
														  left join hrsalaryscale
														  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
														  left join hrsalarysteptrans
														  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeesalarystep.Approved=0
														  and hremployee.Deleted=0
														  and transfertype.Available=1
														  AND hremployeesalarystep.EmpID NOT IN (SELECT
															hrpromotion.Emp_ID
														  FROM hrpromotion
															LEFT JOIN transfertype
															  ON hrpromotion.TransferType = transfertype.T_ID
														  WHERE hrpromotion.Deleted = 0
														  AND hrpromotion.CurrentRecord = 'Yes'
														  AND transfertype.Available = 0
														  AND hrpromotion.Priority = 1)"));
						}
					}
					else
					{
					}
		
			}
			if ($method == "POST")
			{
				$cid = Input::get('QO_ID');
				if($cid == 'All')
				{
					if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
														  hremployee.NIC,
														  hremployee.Initials,
														  hremployee.LastName,
														  hremployee.EPFNo,
														  hrpromotion.EPF,
														  hremploymentcode.Designation,
														  hrpromotion.PServiceCategoryID,
														  organisation.OrgaName,
														  organisation.Type,
														  hrsalaryscale.id as salcaleid,
														  hrsalaryscale.ServiceCategory,
														  hrsalarysteptrans.id as salarysteptransid,
														  hrsalarysteptrans.StepNo
														  from hremployeesalarystep
														  left join hremployee
														  on hremployeesalarystep.EmpID=hremployee.id
														  left join hremployeeepfhistory
											              on hremployeeepfhistory.EmpId=hremployee.id
														  left join hrpromotion
														  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
														  left join transfertype
														  on hrpromotion.TransferType=transfertype.T_ID
														  left join hremploymentcode
														  on hrpromotion.NewPost=hremploymentcode.id
														  left join organisation
														  on hrpromotion.ToOrganisation=organisation.id
														  left join hrsalaryscale
														  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
														  left join hrsalarysteptrans
														  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeeepfhistory.Deleted=0
											              and hremployeesalarystep.Approved=0
														  and hremployee.Deleted=0
														  and transfertype.Available=1
														  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
														AND hremployeesalarystep.EmpID NOT IN (SELECT
														hrpromotion.Emp_ID
													  FROM hrpromotion
														LEFT JOIN transfertype
														  ON hrpromotion.TransferType = transfertype.T_ID
													  WHERE hrpromotion.Deleted = 0
													  AND hrpromotion.CurrentRecord = 'Yes'
													  AND transfertype.Available = 0
													  AND hrpromotion.Priority = 1)"));
						}
						else
						{
							$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
														  hremployee.NIC,
														  hremployee.Initials,
														  hremployee.LastName,
														  hremployee.EPFNo,
														  hrpromotion.EPF,
														  hremploymentcode.Designation,
														  hrpromotion.PServiceCategoryID,
														  organisation.OrgaName,
														  organisation.Type,
														  hrsalaryscale.id as salcaleid,
														  hrsalaryscale.ServiceCategory,
														  hrsalarysteptrans.id as salarysteptransid,
														  hrsalarysteptrans.StepNo
														  from hremployeesalarystep
														  left join hremployee
														  on hremployeesalarystep.EmpID=hremployee.id
														  left join hrpromotion
														  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
														  left join transfertype
														  on hrpromotion.TransferType=transfertype.T_ID
														  left join hremploymentcode
														  on hrpromotion.NewPost=hremploymentcode.id
														  left join organisation
														  on hrpromotion.ToOrganisation=organisation.id
														  left join hrsalaryscale
														  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
														  left join hrsalarysteptrans
														  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeesalarystep.Approved=0
														  and hremployee.Deleted=0
														  and transfertype.Available=1
														  AND hremployeesalarystep.EmpID NOT IN (SELECT
															hrpromotion.Emp_ID
														  FROM hrpromotion
															LEFT JOIN transfertype
															  ON hrpromotion.TransferType = transfertype.T_ID
														  WHERE hrpromotion.Deleted = 0
														  AND hrpromotion.CurrentRecord = 'Yes'
														  AND transfertype.Available = 0
														  AND hrpromotion.Priority = 1)"));
						}
					}
					else
					{
					}
				}
				else
				{
					if($userOrgType == 'HO')
					{
						if($UserTypeName == 'HR-MAPF')
						{
							$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
														  hremployee.NIC,
														  hremployee.Initials,
														  hremployee.LastName,
														  hremployee.EPFNo,
														  hrpromotion.EPF,
														  hremploymentcode.Designation,
														  hrpromotion.PServiceCategoryID,
														  organisation.OrgaName,
														  organisation.Type,
														  hrsalaryscale.id as salcaleid,
														  hrsalaryscale.ServiceCategory,
														  hrsalarysteptrans.id as salarysteptransid,
														  hrsalarysteptrans.StepNo
														  from hremployeesalarystep
														  left join hremployee
														  on hremployeesalarystep.EmpID=hremployee.id
														  left join hremployeeepfhistory
											              on hremployeeepfhistory.EmpId=hremployee.id
														  left join hrpromotion
														  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
														  left join transfertype
														  on hrpromotion.TransferType=transfertype.T_ID
														  left join hremploymentcode
														  on hrpromotion.NewPost=hremploymentcode.id
														  left join organisation
														  on hrpromotion.ToOrganisation=organisation.id
														  left join hrsalaryscale
														  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
														  left join hrsalarysteptrans
														  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeeepfhistory.Deleted=0
											              and hremployeesalarystep.Approved=0
														  and hremployee.Deleted=0
														  and transfertype.Available=1
														  and hrpromotion.ToOrganisation='".$cid."'
														  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
														  from hruserepflist
														  where hruserepflist.Deleted=0
														  and hruserepflist.Active=1
									                      and hruserepflist.UserID='".User::getSysUser()->userID."')
														  AND hremployeesalarystep.EmpID NOT IN (SELECT
														  hrpromotion.Emp_ID
													      FROM hrpromotion
														  LEFT JOIN transfertype
														  ON hrpromotion.TransferType = transfertype.T_ID
													      WHERE hrpromotion.Deleted = 0
													      AND hrpromotion.CurrentRecord = 'Yes'
													      AND transfertype.Available = 0
													      AND hrpromotion.Priority = 1)"));
						}
						else
						{
							$quorga = DB::select(DB::raw("select hremployeesalarystep.*,
														  hremployee.NIC,
														  hremployee.Initials,
														  hremployee.LastName,
														  hremployee.EPFNo,
														  hrpromotion.EPF,
														  hremploymentcode.Designation,
														  hrpromotion.PServiceCategoryID,
														  organisation.OrgaName,
														  organisation.Type,
														  hrsalaryscale.id as salcaleid,
														  hrsalaryscale.ServiceCategory,
														  hrsalarysteptrans.id as salarysteptransid,
														  hrsalarysteptrans.StepNo
														  from hremployeesalarystep
														  left join hremployee
														  on hremployeesalarystep.EmpID=hremployee.id
														  left join hrpromotion
														  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
														  left join transfertype
														  on hrpromotion.TransferType=transfertype.T_ID
														  left join hremploymentcode
														  on hrpromotion.NewPost=hremploymentcode.id
														  left join organisation
														  on hrpromotion.ToOrganisation=organisation.id
														  left join hrsalaryscale
														  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
														  left join hrsalarysteptrans
														  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
														  where hremployeesalarystep.Deleted=0
														  and hremployeesalarystep.Approved=0
														  and hremployee.Deleted=0
														  and transfertype.Available=1
														  and hrpromotion.ToOrganisation='".$cid."'
														  AND hremployeesalarystep.EmpID NOT IN (SELECT hrpromotion.Emp_ID
														  FROM hrpromotion
														  LEFT JOIN transfertype
														  ON hrpromotion.TransferType = transfertype.T_ID
														  WHERE hrpromotion.Deleted = 0
														  AND hrpromotion.CurrentRecord = 'Yes'
														  AND transfertype.Available = 0
														  AND hrpromotion.Priority = 1)"));
						}
					}
					else
					{
					}
					/* $quorga = DB::select(DB::raw("select hremployeesalarystep.*,
					  hremployee.NIC,
					  hremployee.Initials,
					  hremployee.LastName,
					  hremployee.EPFNo,
					  hrpromotion.EPF,
					  hremploymentcode.Designation,
					  hrpromotion.PServiceCategoryID,
					  organisation.OrgaName,
					  organisation.Type,
					  hrsalaryscale.id as salcaleid,
					  hrsalaryscale.ServiceCategory,
					  hrsalarysteptrans.id as salarysteptransid,
					  hrsalarysteptrans.StepNo
					  from hremployeesalarystep
					  left join hremployee
					  on hremployeesalarystep.EmpID=hremployee.id
					  left join hrpromotion
					  on hremployeesalarystep.PromotionID=hrpromotion.P_ID
					  left join transfertype
					  on hrpromotion.TransferType=transfertype.T_ID
					  left join hremploymentcode
					  on hrpromotion.NewPost=hremploymentcode.id
					  left join organisation
					  on hrpromotion.ToOrganisation=organisation.id
					  left join hrsalaryscale
					  on hremployeesalarystep.ServiceCategoryID=hrsalaryscale.id
					  left join hrsalarysteptrans
					  on hremployeesalarystep.SalaryStepTransID=hrsalarysteptrans.id
					  where hremployeesalarystep.Deleted=0
					  and hremployeesalarystep.Approved=0
					  and hremployee.Deleted=0
					  and transfertype.Available=1
  and hrpromotion.ToOrganisation='".$cid."'")); */
				}
				
			}
			
 		$v = View::make('HREmployeeIncrements.View');
 		$v->quorga = $quorga;
		$v->Centers = Organisation::where('Deleted','=',0)->orderBy('OrgaName')->get();
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	 public function DeleteHRLoanType()
	  {
                $id = Input::get('id');
                $quorg = HRLoanType::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				//$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRLoanType');
                
       }
	
    public function EditHRLoanType()
	{
			$view = View::make('HRLoanType.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRLoanType::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = HRLoanType::find(Input::get('QO_ID'));
			$qo->LoanType = Input::get('OrgaName');
			$qo->User = User::getSysUser()->userID;
            $qo->save();
			
			return Redirect::to('ViewHRLoanType');
			
			
			}
}
	
		public function CreateHRLoanType()
	 {
        $method = Request::getMethod();
        $view = View::make('HRLoanType.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRLoanType;
                $qo->LoanType = Input::get('OrgaName');
				$qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRLoanType')->with("done", true);
            
            
            }
            
          }
	
	public function ViewHRLoanType()
	{
		$quorga = HRLoanType::where('Deleted',"!=","1")->OrderBy('LoanType')->get();
 		$v = View::make('HRLoanType.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function DeleteHRDepartment()
	  {
                $id = Input::get('id');
                $quorg = Department::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRDepartment');
                
            }
	
				public function EditHRDepartment()
	{
			$view = View::make('HRDepartment.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = Department::where('D_ID',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = Department::find(Input::get('QO_ID'));
			$qo->DepartmentName = Input::get('OrgaName');
			$qo->User = User::getSysUser()->userID;
            $qo->save();
			
			return Redirect::to('ViewHRDepartment');
			
			
			}
}
	
		public function CreateHRDepartment()
	 {
        $method = Request::getMethod();
        $view = View::make('HRDepartment.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new Department;
                $qo->DepartmentName = Input::get('OrgaName');
				$qo->instituteId = 1;
				$qo->organisationId = User::getSysUser()->organisationId;
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRDepartment')->with("done", true);
            
            
            }
            
          }
	
	public function ViewHRDepartment()
	{
		$quorga = Department::where('Deleted',"!=","1")->OrderBy('DepartmentName')->get();
 		$v = View::make('HRDepartment.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
			public function DeleteHREmployeeType()
	  {
                $id = Input::get('id');
                $quorg = EmployeeType::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHREmployeeType');
                
        }
	
			public function EditHREmployeeType()
	{
			$view = View::make('HREmployeeType.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = EmployeeType::where('ET_ID',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = EmployeeType::find(Input::get('QO_ID'));
			$qo->EmployeeType = Input::get('OrgaName');
			$qo->User = User::getSysUser()->userID;
            $qo->save();
			
			return Redirect::to('ViewHREmployeeType');
			
			
			}
}
	
	
		public function CreateHREmployeeType()
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeeType.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new EmployeeType;
                $qo->EmployeeType = Input::get('OrgaName');
				 
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHREmployeeType')->with("done", true);
            
            
            }
            
          }
	
			public function ViewHREmployeeType()
	{
		$quorga = EmployeeType::where('Deleted',"!=","1")->OrderBy('EmployeeType')->get();
 		$v = View::make('HREmployeeType.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function DeleteHRTransferType()
	  {
                $id = Input::get('id');
                $quorg = TransferType::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRTransferType');
                
            }
	
			public function EditHRTransferType()
	{
			$view = View::make('HRTransferType.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = TransferType::where('T_ID',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$qo = TransferType::find(Input::get('QO_ID'));
			$qo->TransferType = Input::get('OrgaName');
				 $qo->Available = Input::get('Available');
				 if(Input::get('Available') == 1)
				 {
					  $qo->CurrentRecord = 'Yes';
				 }
				 else{
					 $qo->CurrentRecord = 'No';
				 }
				 $qo->Priority = 1;
				 $qo->institutionId = 1;
				 $qo->OrganisationId = User::getSysUser()->organisationId;
                 $qo->User = User::getSysUser()->userID;
                 $qo->save();
			
			return Redirect::to('ViewHRTransferType');
			
			
			}
}
	
		public function CreateHRTransferType()
	 {
        $method = Request::getMethod();
        $view = View::make('HRTransferType.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new TransferType;
                $qo->TransferType = Input::get('OrgaName');
				 $qo->Available = Input::get('Available');
				 if(Input::get('Available') == 1)
				 {
					  $qo->CurrentRecord = 'Yes';
				 }
				 else{
					 $qo->CurrentRecord = 'No';
				 }
				 $qo->Priority = 1;
				 $qo->institutionId = 1;
				 $qo->OrganisationId = User::getSysUser()->organisationId;
                 $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRTransferType')->with("done", true);
            
            
            }
            
          }
	
			public function ViewHRTransferType()
	{
		$quorga = TransferType::where('Deleted',"!=","1")->OrderBy('TransferType')->get();
 		$v = View::make('HRTransferType.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function EditHRTrainingProgram()
	{
			$view = View::make('HRTrainingProgram.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HREmployeeTrainingProgram::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HREmployeeTrainingProgram::find(Input::get('QO_ID'));
			$oq->NameOfTheProgram = Input::get('OrgaName');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRTrainingProgram');
			
			
			}
}
	
	public function CreateHRTrainingProgram()
	 {
        $method = Request::getMethod();
        $view = View::make('HRTrainingProgram.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HREmployeeTrainingProgram;
                $qo->NameOfTheProgram = Input::get('OrgaName');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRTrainingProgram')->with("done", true);
            
            
            }
            
          }
	
		public function ViewHRTrainingProgram()
	{
		$quorga = HREmployeeTrainingProgram::where('Deleted',"!=","1")->OrderBy('NameOfTheProgram')->get();
 		$v = View::make('HRTrainingProgram.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function DeleteHRTrainingProgram()
	  {
                $id = Input::get('id');
                $quorg = HREmployeeTrainingProgram::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRTrainingProgram');
                
            }
	
		public function DeleteHRTrainingInstitute()
	  {
                $id = Input::get('id');
                $quorg = HREmployeeTrainingInstitute::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRTrainingInstitute');
                
            }
	
	public function EditHRTrainingInstitute()
	{
			$view = View::make('HRTrainingInstitute.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HREmployeeTrainingInstitute::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HREmployeeTrainingInstitute::find(Input::get('QO_ID'));
			$oq->InstituteName = Input::get('OrgaName');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRTrainingInstitute');
			
			
			}
}
	
	public function CreateHRTrainingInstitute()
	 {
        $method = Request::getMethod();
        $view = View::make('HRTrainingInstitute.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HREmployeeTrainingInstitute;
                $qo->InstituteName = Input::get('OrgaName');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRTrainingInstitute')->with("done", true);
            
            
            }
            
          }
	
	public function ViewHRTrainingInstitute()
	{
		$quorga = HREmployeeTrainingInstitute::where('Deleted',"!=","1")->OrderBy('InstituteName')->get();
 		$v = View::make('HRTrainingInstitute.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function PrintHREmployeeProfile()
    {
    	//return "Plz";

        $id =  Input::get("studentData");
        $year = date("Y");
        $date = date("Y-m-d");

        $html = '';
		$html='<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>Employee Profile</title>
    </head> <H3><Center><u><i>Collection of Employee Data</i></u></center></H3>';
		$trainee = DB::select(DB::raw("select hremployee.*,district.DistrictName,electorate.ElectorateName,province.ProvinceName,organisation.OrgaName,organisation.Type
  from hremployee
  left join district
  on hremployee.DistrictName=district.DistrictCode
  left join electorate
  on hremployee.DSDivision=electorate.ElectorateCode
  left JOIN province
  on district.ProvinceCode=province.ProvinceCode
  left join organisation
  on hremployee.OrgId=organisation.id
  where hremployee.Deleted=0
  and hremployee.id='".$id."'"));
  
  $AllNIC = HREmployeeNICHistory::where('EmpId','=',$id)->where('Deleted','=',0)->orderBy('Active', 'DESC')->get();
	$html.='<table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	$html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Personal Details</font></b></td>
							  <td></td>
							  <td></td>
                           </tr> ';
	foreach($trainee as $trainee)
	{
		$html.='<tr>
                <br/><br/><td><img src="'.$trainee->Photograph.'" alt="Smiley face" height="200" width="200"/></td><br/>
                <td></td> 
                <td></td>
            </tr>';
		$html.='<tr>
                <td>Name With Initials</td>
                <td>:-</td> 
                <td>'.$trainee->Initials.' '.$trainee->LastName.'</td>
            </tr>';
			$html.='<tr>
                <td>Names Represented by Initials</td>
                <td>:-</td> 
                <td>'.$trainee->Name.'</td>
            </tr>';
			$html.='<tr>
                <td>NIC Number</td>
                <td>:-</td> 
                <td>';
				foreach($AllNIC as $NIC)
				{
					if($NIC->Active == 1)
					{
						$html.='<font  color="red">'.$NIC->NIC.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="black">'.$NIC->NIC.'</font>&nbsp;&nbsp;&nbsp;';
					}
				}
				
				
           $html.='</tr>';
		   $AllEPF = HREmployeeEPFHistory::where('EmpId','=',$id)->where('Deleted','=',0)->orderBy('Active', 'DESC')->get();
		   	$html.='<tr>
                <td>EPF Number</td>
                <td>:-</td> 
                <td>';
				foreach($AllEPF as $EP)
				{
					if($EP->Active == 1)
					{
						$html.='<font  color="red">'.$EP->EPFNo.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="black">'.$EP->EPFNo.'</font>&nbsp;&nbsp;&nbsp;';
					}
				}
				
				
           $html.='</td></tr>';
		   $html.='<tr>
                <td>Date Of Birth</td>
                <td>:-</td> 
                <td>';
				if(!empty($trainee->DOB))
					{
						$html.='<font  color="black">'.$trainee->DOB.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
					$html.='</td>';
            $html.='</tr>';
			 $html.='<tr>
                <td>Gender</td>
                <td>:-</td> 
                <td>';if(!empty($trainee->Sex))
					{
						$html.='<font  color="black">'.$trainee->Sex.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr>';
			 $html.='<tr>
                <td>Civil Status</td>
                <td>:-</td> 
                <td>';if(!empty($trainee->CivilStatus))
					{
						$html.='<font  color="black">'.$trainee->CivilStatus.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr></table>';
			$html.='<table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
			$html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Residential Details</font></b></td>
							  <td></td>
							  <td></td>
                           </tr> ';
			 $html.='<tr>
                <td>Permanent Postal Address</td>
                <td>:-</td> 
                <td>';if(!empty($trainee->PAddress))
					{
						$html.='<font  color="black">'.$trainee->PAddress.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr>';
			$html.='<tr>
                <td>Contact No</td>
                <td>:-</td> 
                <td>';
				$html.='<b>Residence-</b>';
				if(!empty($trainee->Contact))
					{
						$html.='<font  color="black">'.$trainee->Contact.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
					$html.='<b>Official-</b>';
				if(!empty($trainee->OMobile))
					{
						$html.='<font  color="black">'.$trainee->OMobile.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
					$html.='<b>Mobile-</b>';
				if(!empty($trainee->Mobile))
					{
						$html.='<font  color="black">'.$trainee->Mobile.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr>';	
			$html.='<tr>
                <td>Province</td>
                <td>:-</td> 
                <td>';if(!empty($trainee->ProvinceName))
					{
						$html.='<font  color="black">'.$trainee->ProvinceName.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr>';
			$html.='<tr>
                <td>District</td>
                <td>:-</td> 
                <td>';if(!empty($trainee->DistrictName))
					{
						$html.='<font  color="black">'.$trainee->DistrictName.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr>';
			$html.='<tr>
                <td>DS Division</td>
                <td>:-</td> 
                <td>';if(!empty($trainee->ElectorateName))
					{
						$html.='<font  color="black">'.$trainee->ElectorateName.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
            $html.='</td></tr>';
	}//close trainee foreach
	$html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">GCE(O/L)(Two Sitting Only)</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> ';
						   $OLResult = DB::select(DB::raw("select hremployeeolresulttrans.id,
									  hremployeeolresult.Year,
									  hremployeeolresult.IndexNo,
									  hrolattept.Attempt,
									  hrolsubject.Subject,
									  hrolgrade.Grade,
									  hrolgrade.PassStatus
									  from hremployeeolresulttrans
									  left join hremployeeolresult
									  on hremployeeolresulttrans.EOLRId=hremployeeolresult.id
									  left join hrolattept
									  on hremployeeolresult.AttemptId=hrolattept.id
									  left join hrolsubject
									  on hremployeeolresulttrans.SubjectId=hrolsubject.id
									  left join hrolgrade
									  on hremployeeolresulttrans.GradeId=hrolgrade.id
									  where hremployeeolresulttrans.Deleted=0
									  and hremployeeolresult.Deleted=0
									  and hremployeeolresulttrans.EmpId='".$id."'
									  order by hremployeeolresulttrans.AttemptId,hremployeeolresulttrans.id")); 
									  if(!empty($OLResult))
									  {
		$html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       
                        <th rowspan="2">No</th>
                        <th rowspan="2">Year</th>
                        <th rowspan="2">Index No</th>
                        <th rowspan="2">Attempt</th>
                        <th colspan="3" class="center">Result</th>
		</tr>
		 <tr>
						
                        <th>Subject</th>
                        <th>Grade</th>
                    </tr>
		</thead>
		 <tbody>';
		 $i = 1;
		 foreach($OLResult as $eq)
		 {
			 $html.='<tr>
                        <td>'.$i++ .'</td>
                        <td>'.$eq->Year.'</td>
                        <td>'.$eq->IndexNo.'</td>
                        <td>'.$eq->Attempt.'</td>
                        <td>'.$eq->Subject.'</td>
						<td>'.$eq->Grade.'</td>
                        
		</tr>';
		 }
		 $html.='</tbody>   
        </table>';
	}//if
	else
	{
		$html.='<center><font  color="red">Data Not Found</font></center>';
	}
	
	$html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">GCE(A/L)(Single Sitting Only)</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> ';
						   
	$ALResult = DB::select(DB::raw("select hremployeealresulttrans.id,
									  hremployeealresult.Year,
									  hremployeealresult.IndexNo,
									  hralattempt.Attempt,
									  hralsubject.Subject,
									  hrolgrade.Grade,
									  hrolgrade.PassStatus
									  from hremployeealresulttrans
									  left join hremployeealresult
									  on hremployeealresulttrans.EALRId=hremployeealresult.id
									  left join hralattempt
									  on hremployeealresult.AttemptId=hralattempt.id
									  left join hralsubject
									  on hremployeealresulttrans.SubjectId=hralsubject.id
									  left join hrolgrade
									  on hremployeealresulttrans.GradeId=hrolgrade.id
									  where hremployeealresulttrans.Deleted=0
									  and hremployeealresulttrans.EmpId='".$id."'
									  and hremployeealresult.Deleted=0")); 
				 $GKMarks = HREmployeeAlResult::where('Deleted','=',0)->where('EmpId','=',$id)->first();					  
									    if(!empty($ALResult))
									  {
		$html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       
                        <th rowspan="2">No</th>
                        <th rowspan="2">Year</th>
                        <th rowspan="2">Index No</th>
                        <th rowspan="2">Attempt</th>
                        <th colspan="3" class="center">Result</th>
		</tr>
		 <tr>
						
                        <th>Subject</th>
                        <th>Grade</th>
                    </tr>
		</thead>
		 <tbody>';
		 $i = 1;
		 foreach($ALResult as $eq)
		 {
			 $html.='<tr>
                        <td>'.$i++ .'</td>
                        <td>'.$eq->Year.'</td>
                        <td>'.$eq->IndexNo.'</td>
                        <td>'.$eq->Attempt.'</td>
                        <td>'.$eq->Subject.'</td>
						<td>'.$eq->Grade.'</td>
                        
		</tr>';
		 }
		 if($GKMarks != '' || $GKMarks != 0)
		 {
		 $html.='
			<tr>
                        <td>'.$i++.'</td>
                        <td>'.$GKMarks->Year.'</td>
                        <td>'.$GKMarks->IndexNo.'</td>
                        <td>I</td>
                        <td>General Knowledge</td>
						<td>'.$GKMarks->GeneralKowledgeMark.'</td>
                        
		</tr>';
		 }
		
		 $html.='</tbody>   
        </table>';
	}//if
	else
	{
		$html.='<center><font  color="red">Data Not Found</font></center>';
	}
	
	$html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Education Qualifications</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> ';
						   
						   $SqlQ = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                                          hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$id."'
										  and hrqualificationtype.Type='Educational'
										  order by hrqualificationcategory.CategoryLevel";
		 $EQualification = DB::select(DB::raw($SqlQ));
						   if(!empty($EQualification))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       
                        <th rowspan="2">No</th>
                        <th rowspan="2">Qualification Type</th>
                        <th rowspan="2">Qualification Category</th>
                        <th rowspan="2">Qualification</th>
                        <th rowspan="2">University/Institute</th>
						<th rowspan="2">Course Type</th>
                        <th rowspan="2">Main Subjects/Specialized Area</th>
                        <th colspan="3" class="center">Result</th>
		</tr>
		 <tr>
						<th>Status</th>
                        <th>Year</th>
                        <th>Month</th>
                    </tr>
		</thead>
		 <tbody>';
		 $i=1;
		 foreach($EQualification as  $eq)
		 {
			 $html.='<tr>
                        <td>'.$i++.'</td>
                        <td>'.$eq->Type.'</td>
                        <td>'.$eq->QCategory.'</td>
                        <td>'.$eq->Qualification.'</td>
                        <td>'.$eq->UniversityName.'</td>
						<td>'.$eq->CourseType.'</td>
                        <td>'.$eq->MainSubjects.'</td>
                        <td>'.$eq->Result.'</td>
						<td>'.$eq->Year.'</td>';
                       
					
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                      
						 $html.=' <td>'.$monthName.'</td></tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }
		 
	$html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Professional Qualifications</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 
						   
						   $SqlP = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$id."'
										  and hrqualificationtype.Type='Professional'
										  order by hrqualificationcategory.CategoryLevel";
		  $PQualification = DB::select(DB::raw($SqlP));
		  					   if(!empty($PQualification))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       
                        <th rowspan="2">No</th>
                        <th rowspan="2">Qualification Type</th>
                        <th rowspan="2">Qualification Category</th>
                        <th rowspan="2">Qualification</th>
                        <th rowspan="2">University/Institute</th>
						<th rowspan="2">Course Type</th>
                        <th rowspan="2">Main Subjects/Specialized Area</th>
                        <th colspan="3" class="center">Result</th>
		</tr>
		 <tr>
						<th>Status</th>
                        <th>Year</th>
                        <th>Month</th>
                    </tr>
		</thead>
		 <tbody>';
		 $i=1;
		 foreach($PQualification as  $eq)
		 {
			 $html.='<tr>
                        <td>'.$i++.'</td>
                        <td>'.$eq->Type.'</td>
                        <td>'.$eq->QCategory.'</td>
                        <td>'.$eq->Qualification.'</td>
                        <td>'.$eq->UniversityName.'</td>
						<td>'.$eq->CourseType.'</td>
                        <td>'.$eq->MainSubjects.'</td>
                        <td>'.$eq->Result.'</td>
						<td>'.$eq->Year.'</td>';
                       
					
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                      
						 $html.=' <td>'.$monthName.'</td></tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }
	 $html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Vocational Qualifications</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 
						   
						   	$SqlV = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$id."'
										  and hrqualificationtype.Type='Vocational'
										  order by hrqualificationcategory.CategoryLevel";
		  $VQualification = DB::select(DB::raw($SqlV));
		    if(!empty($VQualification))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       
                        <th rowspan="2">No</th>
                        <th rowspan="2">Qualification Type</th>
                        <th rowspan="2">Qualification Category</th>
                        <th rowspan="2">Qualification</th>
                        <th rowspan="2">University/Institute</th>
						<th rowspan="2">Course Type</th>
                        <th rowspan="2">Main Subjects/Specialized Area</th>
                        <th colspan="3" class="center">Result</th>
		</tr>
		 <tr>
						<th>Status</th>
                        <th>Year</th>
                        <th>Month</th>
                    </tr>
		</thead>
		 <tbody>';
		 $i=1;
		 foreach($VQualification as  $eq)
		 {
			 $html.='<tr>
                        <td>'.$i++.'</td>
                        <td>'.$eq->Type.'</td>
                        <td>'.$eq->QCategory.'</td>
                        <td>'.$eq->Qualification.'</td>
                        <td>'.$eq->UniversityName.'</td>
						<td>'.$eq->CourseType.'</td>
                        <td>'.$eq->MainSubjects.'</td>
                        <td>'.$eq->Result.'</td>
						<td>'.$eq->Year.'</td>';
                       
					
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                      
						 $html.=' <td>'.$monthName.'</td></tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }
			
      $html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Foreign/Local Training(With Pay Leave)</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 	

$SqlTrainingWithPay = "select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										 and hremployee.id='".$id."'
										 and hremployeetraining.PayStatus='Pay'
										 order by hremployeetraining.TrainingType";
										  
		$PayTraining = DB::select(DB::raw($SqlTrainingWithPay));	
	    if(!empty($PayTraining))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                       
						 <th rowspan="2">Training Type</th>
						
						 <th rowspan="2">Country</th>
                        <th rowspan="2">Name of the Program</th>
                        <th rowspan="2">Institute/University</th>
                        <th colspan="2" class="center">Duration</th>
						<th rowspan="2">Amount Paid By VTA</th>
						<th colspan="2" class="center">Compulsory Period of Service</th>
						<th rowspan="2">Amount of Surcharge</th>
						
						<th rowspan="2">Cerfiticate Forwarded</th>
						
                        
                    </tr>
                    <tr>
						<th class="center">From</th>
                        <th class="center">To</th>
						<th class="center">Years</th>
                        <th class="center">Months</th>
						
                       
                    </tr>
                </thead>
		 <tbody>';
		 $i=1;
		 foreach($PayTraining as  $eq)
		 {
			 $html.='<tr>
                   <td>'.$i++.'</td>
                     
                       
						<td>'.$eq->TrainingType.'</td>
						
						<td>'.$eq->CountryName.'</td>
                        <td>'.$eq->NameOfTheProgram.'</td>
                        <td>'.$eq->InstituteName.'</td>
                        <td>'.$eq->DurationFrom.'</td>
                       <td>'.$eq->DurationTo.'</td>
					 
                        <td>'.$eq->AmountPaidByVTA.'</td>
						 <td>'.$eq->CompulsoryPeriodOfService.'</td>
						 <td>'.$eq->CompulsoryPeriodOfServiceMonth.'</td>
						  <td>'.$eq->AmountOfSurcharge.'</td>';
						   
							 
							  if($eq->CertificateForwarded == 1)
							  {
								  $html.='<td>Yes</td>';
							  }
							  else 
							  {
								 $html.='<td>No</td>';
							  }
							  
		$html.='</tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }	

  $html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Foreign/Local Training(No Pay Leave)</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 	

 $SqlTrainingWithNoPay = "select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										 and hremployee.id='".$id."'
										 and hremployeetraining.PayStatus='NoPay'
										 order by hremployeetraining.TrainingType";
										  
		$NoPayTraining = DB::select(DB::raw($SqlTrainingWithNoPay));	
   if(!empty($NoPayTraining))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                       
						 <th rowspan="2">Training Type</th>
						
						 <th rowspan="2">Country</th>
                        <th rowspan="2">Name of the Program</th>
                        <th rowspan="2">Institute/University</th>
                        <th colspan="2" class="center">Duration</th>
						<th rowspan="2">Amount Paid By VTA</th>
						<th colspan="2" class="center">Compulsory Period of Service</th>
						<th rowspan="2">Amount of Surcharge</th>
						
						<th rowspan="2">Cerfiticate Forwarded</th>
						
                        
                    </tr>
                    <tr>
						<th class="center">From</th>
                        <th class="center">To</th>
						<th class="center">Years</th>
                        <th class="center">Months</th>
						
                       
                    </tr>
                </thead>
		 <tbody>';
		 $i=1;
		 foreach($NoPayTraining as  $eq)
		 {
			 $html.='<tr>
                   <td>'.$i++.'</td>
                     
                       
						<td>'.$eq->TrainingType.'</td>
						
						<td>'.$eq->CountryName.'</td>
                        <td>'.$eq->NameOfTheProgram.'</td>
                        <td>'.$eq->InstituteName.'</td>
                        <td>'.$eq->DurationFrom.'</td>
                       <td>'.$eq->DurationTo.'</td>
					 
                        <td>'.$eq->AmountPaidByVTA.'</td>
						 <td>'.$eq->CompulsoryPeriodOfService.'</td>
						  <td>'.$eq->CompulsoryPeriodOfServiceMonth.'</td>
						  <td>'.$eq->AmountOfSurcharge.'</td>';
						   
							 
							  if($eq->CertificateForwarded == 1)
							  {
								  $html.='<td>Yes</td>';
							  }
							  else 
							  {
								 $html.='<td>No</td>';
							  }
							  
		$html.='</tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }		

       $html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Experience (Before Join to the VTA)</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 

$SqlExps = "select hremployeeexperience.id,
										hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrexperiencecompany.CompanyName,
										hrexperiencedesignation.Designation,
										  hremployeeexperience.DateJoined,
										  hremployeeexperience.DateResigned,
										  hremployeeexperience.ReasonToLeave
										  from hremployeeexperience
										  left join hremployee
											on hremployeeexperience.EmpId=hremployee.id
										  left join hrexperiencecompany
										  on hremployeeexperience.CompanyId=hrexperiencecompany.id
										  left join hrexperiencedesignation
										  on hremployeeexperience.DesignationID=hrexperiencedesignation.id
										  where hremployeeexperience.Deleted=0
										  and hremployee.id='".$id."'
										  order By hremployeeexperience.DateJoined";
		  $Experience = DB::select(DB::raw($SqlExps));	

  if(!empty($Experience))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       
                        <th rowspan="2">No</th>
                       <th rowspan="2">Company Name</th>
                        <th rowspan="2">Designation</th>
                        <th colspan="3" class="center">Duration</th>
						<th rowspan="2" class="center">Reason To Leave</th>
		</tr>
		 <tr>
						<th>Date Joined</th>
                        <th>Date Resigned</th>
                        <th>Period</th>
                    </tr>
		</thead>
		 <tbody>';
		 $i=1;
		 foreach($Experience as  $eq)
		 {
			 $html.='<tr>
                  <td>'.$i++.'</td>
                         <td>'.$eq->CompanyName.'</td>
                        <td>'.$eq->Designation.'</td>
                        <td>'.$eq->DateJoined.'</td>
                       <td>'.$eq->DateResigned.'</td>';
					   
					    
					   $sql = "Select
								TIMESTAMPDIFF( YEAR, '".$eq->DateJoined."','". $eq->DateResigned."' ) as _year
								,TIMESTAMPDIFF( MONTH,'".$eq->DateJoined."', '". $eq->DateResigned."' ) % 12 as _month
								,FLOOR( TIMESTAMPDIFF( DAY, '".$eq->DateJoined."', '". $eq->DateResigned."' ) % 30.4375 ) as _day";
								$res=DB::select(DB::raw($sql));
								$newdata =  json_decode(json_encode((array)$res),true);
								$year = $newdata[0]["_year"];
								$month = $newdata[0]["_month"];
								$day = $newdata[0]["_day"];
					  
					   $html.='<td>'.$year.' Years & '.$month.' Months
					   </td>
                        <td>'.$eq->ReasonToLeave.'</td>';
		$html.='</tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }		

       $html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Present Employment Details</font></b></td>
							  <td></td>
							  <td></td>
                           </tr> '; 
$CurrentPro = DB::select(DB::raw("select hrpromotion.*,
		  hremploymentcode.Designation,
		  hrpromotion.Emp_ID,
		  transfertype.TransferType,
		  transfertype.Available,
		  trade.TradeName,
		  hrgrade.Grade,
		   hrpromotion.SalaryStep,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrsalarysteptrans.StepAmount,
		  department.DepartmentName,
		  organisation.OrgaName,organisation.Type,employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  hrsalarysteptrans1.StepAmount as PStepAmount
		  from hrpromotion
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join trade
		  on hremployee.Trade=trade.TradeId
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrsalarysteptrans
		  on hrpromotion.SalaryStep=hrsalarysteptrans.id
		   left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join hrsalarysteptrans as hrsalarysteptrans1
		  on hrpromotion.PSalaryStep=hrsalarysteptrans1.id
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrpromotion.Emp_ID='".$id."'
		  and hrpromotion.Priority='1'"));				   
						   
		foreach($CurrentPro as $CurrentPro)
	{
		$html.='<tr>
                <td>Center/Institute</td>
                <td>:-</td> 
                <td>'.$CurrentPro->OrgaName.' ('.$CurrentPro->Type.')</td>
            </tr>';
			$html.='<tr>
                <td>Department(Only For HO)</td>
                <td>:-</td> 
                <td>'.$CurrentPro->DepartmentName.'</td>
            </tr>';
			$html.='<tr>
                <td>Designation</td>
                <td>:-</td> 
                <td>'.$CurrentPro->Designation.'</td>
            </tr>';
			$html.='<tr>
                <td> Transfer Type(Promotion/First Appoinment/..)</td>
                <td>:-</td> 
                <td>'.$CurrentPro->TransferType.'</td>
            </tr>';
			$html.='<tr>
                <td>  Type(Permenant/Contract/Casual/..)</td>
                <td>:-</td> 
                <td>'.$CurrentPro->EmployeeType.'</td>
            </tr>';
			$html.='<tr>
                <td>Trade(Academic Staff Only) </td>
                <td>:-</td> 
                <td>'.$CurrentPro->TradeName.'</td>
            </tr>';
			$html.='<tr>
                <td>Grade(I/II/III)</td>
                <td>:-</td> 
                <td>'.$CurrentPro->Grade.'</td>
            </tr>';
			$html.='<tr>
                <td>Date Of Appoinment</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->StartDate))
					{
						$html.='<font  color="black">'.$CurrentPro->StartDate.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td>Service Category</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->PServiceCategory))
					{
						$html.='<font  color="black">'.$CurrentPro->PServiceCategory.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td>Salary Code</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->PSalaryCode))
					{
						$html.='<font  color="black">'.$CurrentPro->PSalaryCode.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td>Salary Scale</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->PSalaryScale))
					{
						$html.='<font  color="black">'.$CurrentPro->PSalaryScale.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td> No of Increments Earned</td>
                <td>:-</td> 
                <td>';
				
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td> Present Salary Step</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->PStepAmount))
					{
						$html.='<font  color="black">'.$CurrentPro->PStepAmount.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td>Confirmation Date(Only For Permanent Staff)</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->ConfirmationDate))
					{
						$html.='<font  color="black">'.$CurrentPro->ConfirmationDate.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td> EB Qualified Dates(Only For Permanent Staff)</td>
                <td>:-</td> 
                <td>';
				$grade1 = HREBQualification::where('EmpId','=',$id)->where('GradeId','=',1)->where('Deleted','=',0)->pluck('QualifiedDate');
				$grade2 = HREBQualification::where('EmpId','=',$id)->where('GradeId','=',2)->where('Deleted','=',0)->pluck('QualifiedDate');
				$grade3 = HREBQualification::where('EmpId','=',$id)->where('GradeId','=',3)->where('Deleted','=',0)->pluck('QualifiedDate');
				
				$html.='<b>Grade III-</b>';
				if(!empty($grade1))
					{
						$html.='<font  color="black">'.$grade1.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
					$html.='<b>Grade II-</b>';
				if(!empty($grade2))
					{
						$html.='<font  color="black">'.$grade2.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
					$html.='<b>Grade I-</b>';
				if(!empty($grade3))
					{
						$html.='<font  color="black">'.$grade3.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			
			$html.='<tr>
                <td>Date Of Termination(Only For Terminations)</td>
                <td>:-</td> 
                <td>';
				if($CurrentPro->Available == 1)
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
						
					}
					else
					{
						$html.='<font  color="black">'.$CurrentPro->StartDate.'</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td> Gratuity Amount Rs.</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->GratuityAmount))
					{
						$html.='<font  color="black">'.$CurrentPro->GratuityAmount.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td> ETF Released Date</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->ETFReleasedDate))
					{
						$html.='<font  color="black">'.$CurrentPro->ETFReleasedDate.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
			$html.='<tr>
                <td> EPF Released Date</td>
                <td>:-</td> 
                <td>';
				if(!empty($CurrentPro->EPFReleasedDate))
					{
						$html.='<font  color="black">'.$CurrentPro->EPFReleasedDate.'</font>&nbsp;&nbsp;&nbsp;';
					}
					else
					{
						$html.='<font  color="red">Data Not Found</font>&nbsp;&nbsp;&nbsp;';
					}
				$html.='</td>
				
            </tr>';
	}//endforeach
	$html.='</table>';
	
	 $html.='<br/><br/><br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Previous Employment Details</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 
						   
						   		$ExPro = DB::select(DB::raw("select hrpromotion.*,
			  hremploymentcode.Designation,
			  hrpromotion.Emp_ID,
			  transfertype.TransferType,
			  transfertype.Available,
			  trade.TradeName,
			  hrgrade.Grade,
			  hrsalaryscale.SalaryCode,
			  hrsalaryscale.SalaryScale,
			  hrsalarysteptrans.StepAmount,
			  department.DepartmentName,
			  organisation.OrgaName,organisation.Type,employeetype.EmployeeType,
			  hrgrade1.Grade as PGrade,
			   hrpromotion.SalaryStep,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  hrsalarysteptrans1.StepAmount as PStepAmount
  from hrpromotion
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join organisation
  on hrpromotion.ToOrganisation=organisation.id
  left join department
  on hrpromotion.ToDepartment=department.D_ID
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremployee
  on hrpromotion.Emp_ID=hremployee.id
  left join trade
  on hremployee.Trade=trade.TradeId
  left join hrgrade
  on hrpromotion.GradeId=hrgrade.id
  left join hrsalaryscale
  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
  left join hrsalarysteptrans
  on hrpromotion.SalaryStep=hrsalarysteptrans.id
   left join employeetype
  on hrpromotion.EmpType=employeetype.ET_ID
  left join hrsalarysteptrans as hrsalarysteptrans1
		  on hrpromotion.PSalaryStep=hrsalarysteptrans1.id
  left join hrgrade as hrgrade1
  on hrpromotion.PGradeId=hrgrade1.id
  left join hrsalaryscale as hrsalaryscale1
  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
  where hrpromotion.Deleted=0
  and hrpromotion.CurrentRecord='No'
  and hrpromotion.Emp_ID='".$id."'
  Order By hrpromotion.StartDate"));
  
  if(!empty($ExPro))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
		<tr>
		
                       <th rowspan="2">No</th>
                       <th rowspan="2">To Center(Type)</th>
                       <th rowspan="2">To Department</th>
                        <th rowspan="2">Transfer Type</th>
                        <th rowspan="2">Designation</th>
                        <th rowspan="2">Employee Type</th>
						<th rowspan="2">Effective Date</th>
                        
             
						 <th colspan="4" style="text-align: center;"> Salary Details</th>
                        <th rowspan="2">Increment Month</th>
                        <th rowspan="2">Increment Day</th>
						
						
                       
                    </tr>
                    <tr>
                      
                        <th style="text-align: center;">Salary Code</th>
						<th style="text-align: center;">Salary Scale</th>
						<th style="text-align: center;">Salary Step</th>
						<th style="text-align: center;">Grade</th>
						
						
                    </tr>
		</thead>
		 <tbody>';
		 $i=1;
		 foreach($ExPro as  $pr)
		 {
			 $html.='<tr>
                 <td>'.$i++.'</td>
                       
						
						<td>'.$pr->OrgaName.'('.$pr->Type.')</td>
						<td>'.$pr->DepartmentName.'</td>
						<td>'.$pr->TransferType.'</td>
						<td>'.$pr->Designation.'</td>
						<td>'.$pr->EmployeeType.'</td>
						<td>'.$pr->StartDate.'</td>';
						
						if(!empty($pr->PSalaryCode))
						{
							//++++++++++++++++++++++++++
						$html.='<td>'.$pr->PSalaryCode.'</td>
						<td>'.$pr->PSalaryScale.'</td>';
						if(!empty($pr->PSalaryStep) || $pr->PSalaryStep !=0)
						{
						 $salsteptransP = HRSalaryStepTrans::where('id','=',$pr->PSalaryStep)->first();
						}
						else
						{
							$salsteptransP="";
						}
						if($pr->PSalaryStep != '' || $pr->PSalaryStep != 0)
						{
							
							$html.='<td>No.'.$salsteptransP->StepNo.'-'.$salsteptransP->StepAmount.'/=';
							if($salsteptransP->EBAvailable == 1)
							{
								$html.='(EB Available)';
							}
							else
							{
							}
							$html.='</td>';
						}
						else
						{
							$html.='<td></td>';
						}
							
						$html.='<td>'.$pr->PGrade.'</td>';
						//+++++++++++++++
						}
						else
						{
							$html.='<td>'.$pr->SalaryCode.'</td>
						<td>'.$pr->SalaryScale.'</td>';
						if(!empty($pr->SalaryStep))
						{
						 $salsteptrans = HRSalaryStepTrans::where('id','=',$pr->SalaryStep)->first();
						}
						else
						{
							$salsteptrans="";
						}
						if($pr->SalaryStep != '')
						{
							
							$html.='<td>No.'.$salsteptrans->StepNo.'-'.$salsteptrans->StepAmount.'/=';
							if($salsteptrans->EBAvailable == 1)
							{
								$html.='(EB Available)';
							}
							else
							{
							}
							$html.='</td>';
						}
						else
						{
							$html.='<td></td>';
						}
							
						$html.='<td>'.$pr->Grade.'</td>';
						}
						
						
						
						
						
						
						$html.='<td>'.$pr->IncrementMonth.'</td>
						<td>'.$pr->IncrementDay.'</td>';
		$html.='</tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }		
	 
	     $html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">Loan Details</font></b></td>
							  <td></td>
							  <td></td>
                           </tr></table> '; 
						   
						   	    $SqlLoan = "select hremployeeloan.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  hrloantype.LoanType
										  from hremployeeloan
										  left join hremployee
										  on hremployeeloan.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeeloan.Assure1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeeloan.Assure2=hregua2.id
										  left join hrloantype
										  on hremployeeloan.LoanTypeId=hrloantype.id
										  where hremployeeloan.Deleted=0
										  and hremployee.id='".$id."'
										  order by hremployee.EPFNo";
										  
		$LoanDetails = DB::select(DB::raw($SqlLoan));
		if(!empty($LoanDetails))
									  {
	 $html.='<br/><table  align="center" border=1  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
		<thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                        <th rowspan="2">Employee Name</th>
                        <th rowspan="2">NIC </th>
                        <th rowspan="2">EPF</th>
						 <th rowspan="2">Loan Type</th>
						 
						
                        <th rowspan="2">Loan Amount</th>
                       
                        <th colspan="3" class="center">Duration</th>
						
						
						<th rowspan="2">Loan Status</th>
					
                        
                    </tr>
                    <tr>
						<th class="center">Date Issued </th>
                        <th class="center">Date Complete</th>
						 <th class="center">No of Installments</th>
						  
						
                       
                    </tr>
                </thead>
		 <tbody>';
		 $i=1;
		 foreach($LoanDetails as  $eq)
		 {
			 $html.='<tr>
                   <td>'.$i++.'</td>
                     
                        <td>'.$eq->Initials.' '.$eq->LastName.'</td>
                        <td>'.$eq->NIC.'</td>
						<td>'.$eq->EPFNo.'</td>
						<td>'.$eq->LoanType.'</td>
						<td>'.$eq->LoanAmount.'</td>
						<td>'.$eq->IssuedDate.'</td>
                        <td>'.$eq->CompletedDate.'</td>
					    <td>'.$eq->NoOFInstallment.'</td>';
						
							  $html.='<td>';
							  if($eq->LoanClosed == 1)
							  {
								  $html.='Completed';
							  }
							  else 
							  {
								  $html.='Not Completed'; 
							  }
							  $html.='</td>';
		$html.='</tr>';
		 }
		 $html.='</tbody></table>';
	 }
	 else
	 {
		 $html.='<center><font  color="red">Data Not Found</font></center>';
	 }		
	 
	$html.='<br/><table  align="center" border=0  width="100%" cellpadding="5" cellspacing=0 style="border-collapse:collapse;"><tr id="d0" style="background-color:#CC9999">
        <td><b><font color="black">Personal File Document List</font></b></td>
		<td></td>
		 <td></td></tr> '; 
	$PFileNo = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$id)->pluck('FileNo');
	$PFileNoId = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$id)->pluck('id');
	 $html.='<tr>
                <td width="35%"> File No</td>
                <td  width="5%">:-</td> 
                <td  width="60%">'.$PFileNo.'</td>
            </tr>';
		$quaorg = HRPersonalFileDocument::where('Deleted','=',0)->where('Active','=',1)->orderBy('id')->get();
		foreach($quaorg as $g)
		{
			$html.='<tr>
                <td width="35%">'.$g->DocumentName.'</td>
                <td  width="5%">:-</td>';
				$result = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$PFileNoId)->where('DocumentId','=',$g->id)->pluck('Availability');
				$countres = count($result);
				
                $html.='<td  width="60%">';
				if($countres == 0)
				{
							$html.='Not Available';
				}
						else
						{
							if($result == 1)
							{
								$html.='Yes';
							}
								else
								{
						
									$html.='No';
								}
							
						}
				$html.='</td>
            </tr>';
		}
		
		$html.='</table>';
				
		echo $html;
	}
	
	public function ViewHREmployeeALResultsSheetHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeALResult.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
										$Sql = "select hremployeealresult.*,
									  hremployee.NIC,
									  hremployee.OldNIC,
									  hremployee.EPFNo,
									  hremployee.Initials,hremployee.LastName,
									  hremployee.Photograph,
									  hralattempt.Attempt,
									  hrolmedium.Medium,
									  hralstream.Stream
									  from hremployeealresult
									  left join hremployee
									  on hremployeealresult.EmpId=hremployee.id
									  left join hralattempt
									  on hremployeealresult.AttemptId=hralattempt.id
									  left join hralstream
									  on hremployeealresult.StreamId=hralstream.id
									  left join hrolmedium
									  on hremployeealresult.MediumId=hrolmedium.id
									  where hremployeealresult.Deleted=0
									  and hremployee.id='".$GetEmpID."'
									  order by hremployee.EPFNo,hralattempt.Attempt";
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
	public function DeleteHREmployeeALResults()
 {
                $id = Input::get('id');
                $quorg = HREmployeeAlResult::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
				$delete = HREmployeeAlResultTrans::where('EALRId','=',$id)->update(array('Deleted' => '1' , 'User' => User::getSysUser()->userID));
                return Redirect::to('ViewHREmployeeALResults');
                
            }
	
	public function EditHREmployeeALResults()
	{
			$view = View::make('HREmployeeALResult.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HREmployeeAlResult::where('id',"=",Input::get('id'))->first();
			$view->user = User::getSysUser();
			$EmpId = HREmployeeAlResult::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeeALResult.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
					->with("EmpId", HREmployee::where('id', '=', $EmpId)->pluck('id'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
			$view->Attempt = HRALAttempt::where('Deleted',"!=","1")->OrderBy('Attempt')->get();
			$view->Mediums = HROLMedium::where('Deleted',"!=","1")->OrderBy('Medium')->get();
			$view->subjects = HRALSubject::where("Deleted", "!=", 1)->orderBy('Subject')->get();
			$view->grades = HROLGrade::where("Deleted", "!=", 1)->orderBy('Grade')->get();
			$view->streams = HRALStream::where("Deleted", "!=", 1)->orderBy('Stream')->get();
			$view->enteredsubjects = HREmployeeAlResultTrans::where('EALRId','=',Input::get('id'))->where('Deleted','=',0)->orderBy('id')->get();
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

				$eq = HREmployeeAlResult::find(Input::get('EQ_ID'));
			    $EmpId = HREmployeeAlResult::where('id','=',Input::get('EQ_ID'))->pluck('EmpId');
				$AttemptId = HREmployeeAlResult::where('id','=',Input::get('EQ_ID'))->pluck('AttemptId');
				$Year = Input::get('Year');
				$Month = Input::get('Month');
				$CentreNo = Input::get('CentreNo');
				$Index = Input::get('Index');
				$MediumId = Input::get('MediumId');
				$StreamId = Input::get('StreamId');
				$GLMarks = Input::get('GKMarks');
				//return Input::get('QO_ID');
				$AllSubject = Input::get('QO_ID');
				$cc = 0;
				for($t=0;$t<count($AllSubject);$t++)
				{
					if(!empty($AllSubject[$t]))
						{
							$cc = $cc +1;
						}
					
				}
				
				$AllResults = Input::get('Result');
				$eq->MediumId = $MediumId; 
				$eq->Year = $Year;
				$eq->Month = $Month;
				$eq->CentreNo = $CentreNo;
				$eq->IndexNo = $Index;
				$eq->GeneralKowledgeMark = $GLMarks;
				$eq->StreamId = $StreamId;
				$eq->User = User::getSysUser()->userID;
				$eq->save();
				$delete = HREmployeeAlResultTrans::where('EALRId','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
				if($cc != 0)
				{
					
					
					for($k=0;$k<count($AllSubject);$k++)
					{
						if(!empty($AllSubject[$k]))
						{
							$et = new HREmployeeAlResultTrans;
							
							if(HRALSubject::where('Deleted', '!=', 1)->where('id', '=', $AllSubject[$k])->count() == 0) 
							{
								$QO = new HRALSubject;
								$QO->Subject = $AllSubject[$k];
								$QO->User = User::getSysUser()->userID;
								$QO->save();
								$newQO_ID = HRALSubject::where('Deleted', '!=', 1)->where('Subject', '=', $AllSubject[$k])->pluck('id');
								$et->SubjectId = $newQO_ID;
							} 
							else 
							{
								$et->SubjectId = $AllSubject[$k];
							}
							 
							$et->EALRId = Input::get('EQ_ID');
							$et->EmpId = $EmpId;
							$et->AttemptId = $AttemptId;
							if(!empty($AllResults[$k]))
							{
								$et->GradeId = $AllResults[$k];
							}
							else
							{
								$et->GradeId = 6;//if empty assign "F"
							}
							
							$et->User = User::getSysUser()->userID;
							$et->save();
							
							
						}
					}
					
					
				}
				
					return Redirect::to('ViewHREmployeeALResults');
			}
			
			
	
}
	
		public function HREmployeeALResultsSheet()
	{
		$ID = Input::get('id');
        $sql = "SELECT hralsubject.Subject,hrolgrade.Grade
	from hremployeealresulttrans
  left join hralsubject
  on hremployeealresulttrans.SubjectId=hralsubject.id
  left join hrolgrade
  on hremployeealresulttrans.GradeId=hrolgrade.id
  where hremployeealresulttrans.Deleted=0
  and hremployeealresulttrans.EALRId='".$ID."'
  order by hremployeealresulttrans.id
";
  
    $DD = DB::select(DB::raw($sql));
	
	$gkmark = HREmployeeAlResult::where('id','=',$ID)->pluck('GeneralKowledgeMark');
	
	$json = array("html" => $DD, "GkMark" => $gkmark);
    return json_encode($json, 0);
	 
	// return json_encode($DD);
	}
	
	public function ViewHREmployeeALResults()
	{
		 $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
		if($userOrgType == 'HO')
		{
			if($UserTypeName == 'HR-MAPF')
			{
				$quorga = DB::select(DB::raw("select hremployeealresult.*,
									  hremployee.NIC,
									  hremployee.OldNIC,
									  hremployee.EPFNo,
									  hremployee.Initials,hremployee.LastName,
									  hremployee.Photograph,
									  hralattempt.Attempt,
									  hrolmedium.Medium,
									  hralstream.Stream
									  from hremployeealresult
									  left join hremployee
									  on hremployeealresult.EmpId=hremployee.id
									  left join hremployeeepfhistory
									  on hremployee.id=hremployeeepfhistory.EmpId
									  left join hralattempt
									  on hremployeealresult.AttemptId=hralattempt.id
									  left join hralstream
                                      on hremployeealresult.StreamId=hralstream.id
									  left join hrolmedium
									  on hremployeealresult.MediumId=hrolmedium.id
									  where hremployeealresult.Deleted=0
									  and hremployeeepfhistory.Deleted=0
											  and hremployee.Deleted=0
											  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
									  order by hremployee.EPFNo,hralattempt.Attempt"));
			}
			else
			{
				$quorga = DB::select(DB::raw("select hremployeealresult.*,
									  hremployee.NIC,
									  hremployee.OldNIC,
									  hremployee.EPFNo,
									  hremployee.Initials,hremployee.LastName,
									  hremployee.Photograph,
									  hralattempt.Attempt,
									  hrolmedium.Medium,
									  hralstream.Stream
									  from hremployeealresult
									  left join hremployee
									  on hremployeealresult.EmpId=hremployee.id
									  left join hralattempt
									  on hremployeealresult.AttemptId=hralattempt.id
									  left join hralstream
                                      on hremployeealresult.StreamId=hralstream.id
									  left join hrolmedium
									  on hremployeealresult.MediumId=hrolmedium.id
									  where hremployeealresult.Deleted=0
									  and hremployee.Deleted=0
									  order by hremployee.EPFNo,hralattempt.Attempt
									 "));
			}
		}
		else
		{
		}
		
 		$v = View::make('HREmployeeALResult.EmpQua');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function DeleteHRALStream()
	  {
                $id = Input::get('id');
                $quorg = HRALStream::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRALStream');
                
            }
	
	public function EditHRALStream()
	{
			$view = View::make('HRALStream.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRALStream::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRALStream::find(Input::get('QO_ID'));
			$oq->Stream = Input::get('Stream');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$availabe = HRALStream::where('Deleted',"!=","1")->where('Stream','=',Input::get('Stream'))->get();
				if(count($availabe) == 0)
				{
                $oq->save();
                
				}
				
			
			return Redirect::to('ViewHRALStream');
			
			
			}
}
	
	public function CreateHRALStream()
	 {
        $method = Request::getMethod();
        $view = View::make('HRALStream.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRALStream;
                $qo->Stream = Input::get('Stream');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HRALStream::where('Deleted',"!=","1")->where('Stream','=',Input::get('Stream'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHRALStream')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHRALStream')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function ViewHRALStream()
	{
		$quorga = HRALStream::where('Deleted',"!=","1")->OrderBy('Stream')->get();
 		$v = View::make('HRALStream.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function HREmployeeALResultsCheckAttept()
    {
        $id=Input::get('id');
		  $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
		  $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  
	
          $Ins = DB::select(DB::raw("select hralattempt.*
									from hralattempt
									where hralattempt.id not in (select DISTINCT hremployeealresult.AttemptId 
									from hremployeealresult 
									where hremployeealresult.Deleted=0
									and hremployeealresult.EmpId='".$id."')
									and hralattempt.Deleted=0
									order by hralattempt.Attempt"));
		  
    
    /* $html='';
	$msg = "---Select Attempt---";
	$html='<option value="">'.$msg.'</option>';
        foreach($Ins As $i){
            $html.='<option value="'.$i->id.'">'.$i->Attempt.'</option>';
        }
		
        $html.=''; */
    return $Ins;
    //
    }
	
		public function CreateHREmployeeALResults() 
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeeALResult.Create');
        $view->user = User::getSysUser();
		$view->Attempt = HRALAttempt::where('Deleted',"!=","1")->OrderBy('Attempt')->get();
		$view->Mediums = HROLMedium::where('Deleted',"!=","1")->OrderBy('Medium')->get();
		$view->subjects = HRALSubject::where("Deleted", "!=", 1)->orderBy('Subject')->get();
		$view->streams = HRALStream::where("Deleted", "!=", 1)->orderBy('Stream')->get();
		$view->grades = HROLGrade::where("Deleted", "!=", 1)->orderBy('Grade')->get();
		
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
           
               
				$EmpId = Input::get('EmpId');
				$AttemptId = Input::get('AttemptId');
				$Year = Input::get('Year');
				$Month = Input::get('Month');
				$CentreNo = Input::get('CentreNo');
				$Index = Input::get('Index');
				$MediumId = Input::get('MediumId');
				$StreamId = Input::get('StreamId');
				$GLMarks = Input::get('GKMarks'); 
				//general knowledge marks
				//return Input::get('QO_ID');
				$AllSubject = Input::get('QO_ID');
				$cc = 0;
				for($t=0;$t<count($AllSubject);$t++)
				{
					if(!empty($AllSubject[$t]))
						{
							$cc = $cc +1;
						}
					
				}
				//return count($AllSubject);
				$AllResults = Input::get('Result');
				
				$eq = new HREmployeeAlResult;
				$eq->EmpId = $EmpId;
				$eq->AttemptId = $AttemptId;
				$eq->GeneralKowledgeMark = $GLMarks;
				$eq->StreamId = $StreamId;
				$eq->MediumId = $MediumId; 
				$eq->Year = $Year;
				$eq->Month = $Month;
				$eq->CentreNo = $CentreNo;
				$eq->IndexNo = $Index;
				$eq->User = User::getSysUser()->userID;
				
				$available = HREmployeeAlResult::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('AttemptId','=',$AttemptId)->get();
				
				if(count($available) == 0 && $cc != 0)
				{
					$eq->save();
					$EOLRId = HREmployeeAlResult::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('AttemptId','=',$AttemptId)->where('MediumId','=',$MediumId)->where('Year','=',$Year)->
							  where('IndexNo','=',$Index)->pluck('id');
					for($k=0;$k<count($AllSubject);$k++)
					{
						if(!empty($AllSubject[$k]))
						{
							$et = new HREmployeeAlResultTrans;
							
							if(HRALSubject::where('Deleted', '!=', 1)->where('id', '=', $AllSubject[$k])->count() == 0) 
							{
								$QO = new HRALSubject;
								$QO->Subject = $AllSubject[$k];
								$QO->User = User::getSysUser()->userID;
								$QO->save();
								$newQO_ID = HRALSubject::where('Deleted', '!=', 1)->where('Subject', '=', $AllSubject[$k])->pluck('id');
								$et->SubjectId = $newQO_ID;
							} 
							else 
							{
								$et->SubjectId = $AllSubject[$k];
							}
							 
							$et->EALRId = $EOLRId;
							$et->EmpId = $EmpId;
							$et->AttemptId = $AttemptId;
							if(!empty($AllResults[$k]))
							{
								$et->GradeId = $AllResults[$k];
							}
							else
							{
								$et->GradeId = 6;//if empty assign "F"
							}
							
							$et->User = User::getSysUser()->userID;
							$et->save();
							
							
						}
					}
					return Redirect::to('CreateHREmployeeALResults')->with("done", true);
					
				}
				else
				{
					return Redirect::to('CreateHREmployeeALResults')->with("Exist", true);
				}
                
                
             
          
        }
    }
	
		public function DeleteHRALSubject()
	  {
                $id = Input::get('id');
                $quorg = HRALSubject::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRALSubject');
                
            }
	
	public function EditHRALSubject()
	{
			$view = View::make('HRALSubject.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRALSubject::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRALSubject::find(Input::get('QO_ID'));
			$oq->Subject = Input::get('Subject');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$availabe = HRALSubject::where('Deleted',"!=","1")->where('Subject','=',Input::get('Subject'))->get();
				if(count($availabe) == 0)
				{
                $oq->save();
                
				}
				
			
			return Redirect::to('ViewHRALSubject');
			
			
			}
}
	
	public function CreateHRALSubject()
	 {
        $method = Request::getMethod();
        $view = View::make('HRALSubject.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRALSubject;
                $qo->Subject = Input::get('Subject');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HRALSubject::where('Deleted',"!=","1")->where('Subject','=',Input::get('Subject'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHRALSubject')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHRALSubject')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function ViewHRALSubject()
	{
		$quorga = HRALSubject::where('Deleted',"!=","1")->OrderBy('Subject')->get();
 		$v = View::make('HRALSubject.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function DeleteHRALAttempt()
	  {
                $id = Input::get('id');
                $quorg = HRALAttempt::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRALAttempt');
                
            }
	
	public function EditHRALAttempt()
	{
			$view = View::make('HRALAttempt.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRALAttempt::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRALAttempt::find(Input::get('QO_ID'));
			$oq->Attempt = Input::get('Attempt');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$availabe = HRALAttempt::where('Deleted',"!=","1")->where('Attempt','=',Input::get('Attempt'))->get();
				if(count($availabe) == 0)
				{
                $oq->save();
                
				}
				
			
			return Redirect::to('ViewHRALAttempt');
			
			
			}
}
	
		public function CreateHRALAttempt()
	 {
        $method = Request::getMethod();
        $view = View::make('HRALAttempt.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRALAttempt;
                $qo->Attempt = Input::get('Attempt');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HRALAttempt::where('Deleted',"!=","1")->where('Attempt','=',Input::get('Attempt'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHRALAttempt')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHRALAttempt')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function ViewHRALAttempt()
	{
		$quorga = HRALAttempt::where('Deleted',"!=","1")->OrderBy('Attempt')->get();
 		$v = View::make('HRALAttempt.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ViewHREmployeeOLResultsSheetHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeOLResult.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
										$Sql = "select hremployeeolresult.*,
									  hremployee.NIC,
									  hremployee.OldNIC,
									  hremployee.EPFNo,
									  hremployee.Initials,hremployee.LastName,
									  hremployee.Photograph,
									  hrolattept.Attempt,
									  hrolmedium.Medium
									  from hremployeeolresult
									  left join hremployee
									  on hremployeeolresult.EmpId=hremployee.id
									  left join hrolattept
									  on hremployeeolresult.AttemptId=hrolattept.id
									  left join hrolmedium
									  on hremployeeolresult.MediumId=hrolmedium.id
									  where hremployeeolresult.Deleted=0
									  and hremployee.id='".$GetEmpID."'
									  order by hremployee.EPFNo,hrolattept.Attempt";
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
public function DeleteHREmployeeOLResults()
 {
                $id = Input::get('id');
                $quorg = HREmployeeOlResult::findOrFail($id); // if not found show 404 page
                $quorg->Deleted =1;
				$quorg->User = User::getSysUser()->userID;
                $quorg->save();
				$delete = HREmployeeOlResultTrans::where('EOLRId','=',$id)->update(array('Deleted' => '1' , 'User' => User::getSysUser()->userID));
                return Redirect::to('ViewHREmployeeOLResults');
                
            }
	
	public function EditHREmployeeOLResults()
	{
			$view = View::make('HREmployeeOLResult.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HREmployeeOlResult::where('id',"=",Input::get('id'))->first();
			$view->user = User::getSysUser();
			$EmpId = HREmployeeOlResult::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeeOLResult.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
					->with("EmpId", HREmployee::where('id', '=', $EmpId)->pluck('id'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
			$view->Attempt = HROLAttempt::where('Deleted',"!=","1")->OrderBy('Attempt')->get();
			$view->Mediums = HROLMedium::where('Deleted',"!=","1")->OrderBy('Medium')->get();
			$view->subjects = HROLSubject::where("Deleted", "!=", 1)->orderBy('Subject')->get();
			$view->grades = HROLGrade::where("Deleted", "!=", 1)->orderBy('Grade')->get();
			$view->country = Country::orderBy('CountryName')->get();
			$view->enteredsubjects = HREmployeeOlResultTrans::where('EOLRId','=',Input::get('id'))->where('Deleted','=',0)->orderBy('id')->get();
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

				$eq = HREmployeeOlResult::find(Input::get('EQ_ID'));
			    $EmpId = HREmployeeOlResult::where('id','=',Input::get('EQ_ID'))->pluck('EmpId');
				$AttemptId = HREmployeeOlResult::where('id','=',Input::get('EQ_ID'))->pluck('AttemptId');
				$Year = Input::get('Year');
				$Index = Input::get('Index');
				$Month = Input::get('Month');
				$CentreNo = Input::get('CentreNo');
				$MediumId = Input::get('MediumId');
				//return Input::get('QO_ID');
				$AllSubject = Input::get('QO_ID');
				$cc = 0;
				for($t=0;$t<count($AllSubject);$t++)
				{
					if(!empty($AllSubject[$t]))
						{
							$cc = $cc +1;
						}
					
				}
				
				$AllResults = Input::get('Result');
				$eq->MediumId = $MediumId; 
				$eq->Year = $Year;
				$eq->Month = $Month;
				$eq->CentreNo = $CentreNo;
				$eq->IndexNo = $Index;
				$eq->User = User::getSysUser()->userID;
				$eq->save();
				$delete = HREmployeeOlResultTrans::where('EOLRId','=',Input::get('EQ_ID'))->update(array('Deleted' => 1));
				if($cc != 0)
				{
					
					
					for($k=0;$k<count($AllSubject);$k++)
					{
						if(!empty($AllSubject[$k]))
						{
							$et = new HREmployeeOlResultTrans;
							
							if(HROLSubject::where('Deleted', '!=', 1)->where('id', '=', $AllSubject[$k])->count() == 0) 
							{
								$QO = new HROLSubject;
								$QO->Subject = $AllSubject[$k];
								$QO->User = User::getSysUser()->userID;
								$QO->save();
								$newQO_ID = HROLSubject::where('Deleted', '!=', 1)->where('Subject', '=', $AllSubject[$k])->pluck('id');
								$et->SubjectId = $newQO_ID;
							} 
							else 
							{
								$et->SubjectId = $AllSubject[$k];
							}
							 
							$et->EOLRId = Input::get('EQ_ID');
							$et->EmpId = $EmpId;
							$et->AttemptId = $AttemptId;
							if(!empty($AllResults[$k]))
							{
								$et->GradeId = $AllResults[$k];
							}
							else
							{
								$et->GradeId = 6;//if empty assign "F"
							}
							
							$et->User = User::getSysUser()->userID;
							$et->save();
							
							
						}
					}
					
					
				}
				
					return Redirect::to('ViewHREmployeeOLResults');
			}
			
			
	
}
	
	public function HREmployeeOLResultsSheet()
	{
		$ID = Input::get('id');
        $sql = "SELECT hrolsubject.Subject,hrolgrade.Grade
from hremployeeolresulttrans
  left join hrolsubject
  on hremployeeolresulttrans.SubjectId=hrolsubject.id
  left join hrolgrade
  on hremployeeolresulttrans.GradeId=hrolgrade.id
  where hremployeeolresulttrans.Deleted=0
  and hremployeeolresulttrans.EOLRId='".$ID."'
  order by hremployeeolresulttrans.id
";
  
    $DD = DB::select(DB::raw($sql));
	 
	 return json_encode($DD);
	}
	
	public function ViewHREmployeeOLResults()
	{
		$userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
		if($userOrgType == 'HO')
		{
			if($UserTypeName == 'HR-MAPF')
			{
				$quorga = DB::select(DB::raw("select hremployeeolresult.*,
									  hremployee.NIC,
									  hremployee.OldNIC,
									  hremployee.EPFNo,
									  hremployee.Initials,hremployee.LastName,
									  hremployee.Photograph,
									  hrolattept.Attempt,
									  hrolmedium.Medium
									  from hremployeeolresult
									  left join hremployee
									  on hremployeeolresult.EmpId=hremployee.id
									  left join hremployeeepfhistory
									  on hremployee.id=hremployeeepfhistory.EmpId
									  left join hrolattept
									  on hremployeeolresult.AttemptId=hrolattept.id
									  left join hrolmedium
									  on hremployeeolresult.MediumId=hrolmedium.id
									  where hremployeeolresult.Deleted=0
									  and hremployeeepfhistory.Deleted=0
									  and hremployee.Deleted=0
									  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
									  order by hremployee.EPFNo,hrolattept.Attempt"));
			}
			else
			{
				$quorga = DB::select(DB::raw("select hremployeeolresult.*,
									  hremployee.NIC,
									  hremployee.OldNIC,
									  hremployee.EPFNo,
									  hremployee.Initials,hremployee.LastName,
									  hremployee.Photograph,
									  hrolattept.Attempt,
									  hrolmedium.Medium
									  from hremployeeolresult
									  left join hremployee
									  on hremployeeolresult.EmpId=hremployee.id
									  left join hrolattept
									  on hremployeeolresult.AttemptId=hrolattept.id
									  left join hrolmedium
									  on hremployeeolresult.MediumId=hrolmedium.id
									  where hremployeeolresult.Deleted=0
									  and hremployee.Deleted=0
									  order by hremployee.EPFNo,hrolattept.Attempt"));
			}
		}
		else{
		}
		
		
 		$v = View::make('HREmployeeOLResult.EmpQua');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function HREmployeeOLResultsCheckAttept()
    {
        $id=Input::get('id');
		  $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
		  $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  
	
          $Ins = DB::select(DB::raw("select hrolattept.*
									from hrolattept
									where hrolattept.id not in (select DISTINCT hremployeeolresult.AttemptId 
									from hremployeeolresult 
									where hremployeeolresult.Deleted=0
									and hremployeeolresult.EmpId='".$id."')
									and hrolattept.Deleted=0
									order by hrolattept.Attempt"));
		  
    
    /* $html='';
	$msg = "---Select Attempt---";
	$html='<option value="">'.$msg.'</option>';
        foreach($Ins As $i){
            $html.='<option value="'.$i->id.'">'.$i->Attempt.'</option>';
        }
		
        $html.=''; */
    return $Ins;
    //
    }
	
	public function CreateHREmployeeOLResults() 
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeeOLResult.Create');
        $view->user = User::getSysUser();
		$view->Attempt = HROLAttempt::where('Deleted',"!=","1")->OrderBy('Attempt')->get();
		$view->Mediums = HROLMedium::where('Deleted',"!=","1")->OrderBy('Medium')->get();
		$view->subjects = HROLSubject::where("Deleted", "!=", 1)->orderBy('Subject')->get();
		$view->grades = HROLGrade::where("Deleted", "!=", 1)->orderBy('Grade')->get();
		$view->country = Country::orderBy('CountryName')->get();
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
           
               
				$EmpId = Input::get('EmpId');
				$AttemptId = Input::get('AttemptId');
				$Year = Input::get('Year');
				$Month = Input::get('Month');
				$Index = Input::get('Index');
				$CentreNo = Input::get('CentreNo');
				$MediumId = Input::get('MediumId');
				//return Input::get('QO_ID');
				$AllSubject = Input::get('QO_ID');
				$cc = 0;
				for($t=0;$t<count($AllSubject);$t++)
				{
					if(!empty($AllSubject[$t]))
						{
							$cc = $cc +1;
						}
					
				}
				//return count($AllSubject);
				$AllResults = Input::get('Result');
				
				$eq = new HREmployeeOlResult;
				$eq->EmpId = $EmpId;
				$eq->AttemptId = $AttemptId;
				$eq->MediumId = $MediumId; 
				$eq->Month = $Month;
				$eq->CentreNo = $CentreNo;
				$eq->Year = $Year;
				$eq->IndexNo = $Index;
				$eq->User = User::getSysUser()->userID;
				
				$available = HREmployeeOlResult::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('AttemptId','=',$AttemptId)->where('MediumId','=',$MediumId)->where('Year','=',$Year)->
				where('IndexNo','=',$Index)->get();
				
				if(count($available) == 0 && $cc != 0)
				{
					$eq->save();
					$EOLRId = HREmployeeOlResult::where('Deleted','=',0)->where('EmpId','=',$EmpId)->where('AttemptId','=',$AttemptId)->where('MediumId','=',$MediumId)->where('Year','=',$Year)->
							  where('IndexNo','=',$Index)->pluck('id');
					for($k=0;$k<count($AllSubject);$k++)
					{
						if(!empty($AllSubject[$k]))
						{
							$et = new HREmployeeOlResultTrans;
							
							if(HROLSubject::where('Deleted', '!=', 1)->where('id', '=', $AllSubject[$k])->count() < 1) 
							{
								$QO = new HROLSubject;
								$QO->Subject = $AllSubject[$k];
								$QO->User = User::getSysUser()->userID;
								$QO->save();
								$newQO_ID = HROLSubject::where('Deleted', '!=', 1)->where('Subject', '=', $AllSubject[$k])->pluck('id');
								$et->SubjectId = $newQO_ID;
							} 
							else 
							{
								$et->SubjectId = $AllSubject[$k];
							}
							 
							$et->EOLRId = $EOLRId;
							$et->EmpId = $EmpId;
							$et->AttemptId = $AttemptId;
							if(!empty($AllResults[$k]))
							{
								$et->GradeId = $AllResults[$k];
							}
							else
							{
								$et->GradeId = 6;//if empty assign "F"
							}
							
							$et->User = User::getSysUser()->userID;
							$et->save();
							
							
						}
					}
					return Redirect::to('CreateHREmployeeOLResults')->with("done", true);
					
				}
				else
				{
					return Redirect::to('CreateHREmployeeOLResults')->with("Exist", true);
				}
                
                
             
          
        }
    }
	
		public function DeleteHROLGrades()
	  {
                $id = Input::get('id');
                $quorg = HROLGrade::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHROLGrades');
                
            }
	
	public function EditHROLGrades()
	{
			$view = View::make('HROLGrades.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HROLGrade::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HROLGrade::find(Input::get('QO_ID'));
			$oq->Grade = Input::get('Grade');
			$oq->GradeName = Input::get('GradeName');
			$oq->PassStatus = Input::get('PassStatus');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			/* $availabe = HROLGrade::where('Deleted',"!=","1")->where('Grade','=',Input::get('Grade'))->get();
				if(count($availabe) == 0)
				{
                
                
				} */
				
			
			return Redirect::to('ViewHROLGrades');
			
			
			}
}
	
		public function CreateHROLGrades()
	 {
        $method = Request::getMethod();
        $view = View::make('HROLGrades.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HROLGrade;
                $qo->Grade = Input::get('Grade');
				$qo->GradeName = Input::get('GradeName');
				$qo->PassStatus = Input::get('PassStatus');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HROLGrade::where('Deleted',"!=","1")->where('Grade','=',Input::get('Grade'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHROLGrades')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHROLGrades')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function ViewHROLGrades()
	{
		$quorga = HROLGrade::where('Deleted',"!=","1")->OrderBy('Grade')->get();
 		$v = View::make('HROLGrades.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ViewHROLMedium()
	{
		$quorga = HROLMedium::where('Deleted',"!=","1")->OrderBy('Medium')->get();
 		$v = View::make('HROLMedium.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function CreateHROLMedium()
	 {
        $method = Request::getMethod();
        $view = View::make('HROLMedium.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HROLMedium;
                $qo->Medium = Input::get('Medium');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HROLMedium::where('Deleted',"!=","1")->where('Medium','=',Input::get('Medium'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHROLMedium')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHROLMedium')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function EditHROLMedium()
	{
			$view = View::make('HROLMedium.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HROLMedium::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HROLMedium::find(Input::get('QO_ID'));
			$oq->Medium = Input::get('Medium');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$availabe = HROLMedium::where('Deleted',"!=","1")->where('Medium','=',Input::get('Medium'))->get();
				if(count($availabe) == 0)
				{
                $oq->save();
                
				}
				
			
			return Redirect::to('ViewHROLMedium');
			
			
			}
}
	
	public function DeleteHROLMedium()
	  {
                $id = Input::get('id');
                $quorg = HROLMedium::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHROLMedium');
                
            }
	
		
	public function DeleteHROLSubject()
	  {
                $id = Input::get('id');
                $quorg = HROLSubject::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHROLSubject');
                
            }
	
	public function EditHROLSubject()
	{
			$view = View::make('HROLSubject.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HROLSubject::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HROLSubject::find(Input::get('QO_ID'));
			$oq->Subject = Input::get('Subject');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$availabe = HROLSubject::where('Deleted',"!=","1")->where('Subject','=',Input::get('Subject'))->get();
				if(count($availabe) == 0)
				{
                $oq->save();
                
				}
				
			
			return Redirect::to('ViewHROLSubject');
			
			
			}
}
	
	public function CreateHROLSubject()
	 {
        $method = Request::getMethod();
        $view = View::make('HROLSubject.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HROLSubject;
                $qo->Subject = Input::get('Subject');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HROLSubject::where('Deleted',"!=","1")->where('Subject','=',Input::get('Subject'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHROLSubject')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHROLSubject')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function ViewHROLSubject()
	{
		$quorga = HROLSubject::where('Deleted',"!=","1")->OrderBy('Subject')->get();
 		$v = View::make('HROLSubject.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function DeleteHROLAttempt()
	  {
                $id = Input::get('id');
                $quorg = HROLAttempt::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 //$quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHROLAttempt');
                
            }
	
	public function EditHROLAttempt()
	{
			$view = View::make('HROLAttempt.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HROLAttempt::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HROLAttempt::find(Input::get('QO_ID'));
			$oq->Attempt = Input::get('Attempt');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$availabe = HROLAttempt::where('Deleted',"!=","1")->where('Attempt','=',Input::get('Attempt'))->get();
				if(count($availabe) == 0)
				{
                $oq->save();
                
				}
				
			
			return Redirect::to('ViewHROLAttempt');
			
			
			}
}
	
		public function CreateHROLAttempt()
	 {
        $method = Request::getMethod();
        $view = View::make('HROLAttempt.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HROLAttempt;
                $qo->Attempt = Input::get('Attempt');
                $qo->User = User::getSysUser()->userID;
				
				$availabe = HROLAttempt::where('Deleted',"!=","1")->where('Attempt','=',Input::get('Attempt'))->get();
				if(count($availabe) == 0)
				{
                $qo->save();
                return Redirect::to('CreateHROLAttempt')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHROLAttempt')->with("Exist", true);
				}
            
            
            }
            
          }
	
	public function ViewHROLAttempt()
	{
		$quorga = HROLAttempt::where('Deleted',"!=","1")->OrderBy('Attempt')->get();
 		$v = View::make('HROLAttempt.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ViewHREmployeePersonalFileDocHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeePersonalFileDoc.PromoHistory');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $qqq = HRPersonalFileDocument::where('Deleted','=',0)->where('Active','=',1)->orderBy('id')->get();
		$v->quaorg = $qqq;
		$v->countquaorg = count($qqq);
		$v->user = User::getSysUser();

		
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
									$dataList = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  and hremployee.id='".$GetEmpID."'
												  order by hremployeepersonalfiledoc.FileNo"));
		  //$dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
	public function EditHREmployeePersonalFileDoc()
	{
		$view = View::make('HREmployeePersonalFileDoc.Edit');
        $method = Request::getMethod();

        if ($method == "GET") 
{
            $empqua = HREmployeePersonalFileDoc::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeePersonalFileDoc::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeePersonalFileDoc.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
					->with("EmpId", HREmployee::where('id', '=', $EmpId)->pluck('id'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
            $view->user = User::getSysUser();
		    $view->quaorg = HRPersonalFileDocument::where('Deleted','=',0)->where('Active','=',1)->orderBy('id')->get();
            $view->empqua = $empqua;
			return $view;
        }
		if ($method == "POST") {
          
              
			  
              $availablefileNo = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('EmpId','!=',Input::get('EmpId'))->where('FileNo','=',Input::get('FileNo'))->get(); 
				if(count($availablefileNo) != 0)
				{
					return Redirect::back()->with("ExistAnother", true);
				}
				else
				{
					
					
						$eq = HREmployeePersonalFileDoc::find(Input::get('EQ_ID'));
						$eq->FileNo = Input::get('FileNo');
						$eq->User = User::getSysUser()->userID;
						$eq->Active = Input::get('Active');
						$eq->save();
						$getHREPFDId = Input::get('EQ_ID');
						
						$DocIDs = Input::get('DocIDs'); 
						$checkedChecked_ids = Input::get('Checked_ids');
						$PageNos = [];
						$PageNos = Input::get('PageNos');
						$countallDocIDs = count($DocIDs);
						$countcheckedChecked_ids = count($checkedChecked_ids);
						
						
						  for($k=0;$k<$countallDocIDs;$k++)
						  {

							$UniqDocID = $DocIDs[$k];
							$availability = HREmployeePersonalFileDocTrans::where('hrEPFDId','=',$getHREPFDId)->where('DocumentId','=',$UniqDocID)->where('Deleted','=',0)->first();
							
							if(count($availability) != 0)
							{
								$f = HREmployeePersonalFileDocTrans::find($availability->id);
								$f->FileNo = Input::get('FileNo');
								$f->User = User::getSysUser()->userID;
								if(in_array($UniqDocID, $checkedChecked_ids))
								{
									 $f->Availability = 1;
									 $f->PageNo = $PageNos[$k];
								}	
								else
								{
									 $f->Availability = 0;
								}
								$f->save(); 
							}
							else
							{
							  
							  $f = new HREmployeePersonalFileDocTrans();
							  $f->hrEPFDId = $getHREPFDId;
							  $f->EmpId = Input::get('EmpId');
							  $f->FileNo = Input::get('FileNo');
							  $f->DocumentId = $UniqDocID;
								if(in_array($UniqDocID, $checkedChecked_ids))
								{
									 $f->Availability = 1;
									 $f->PageNo = $PageNos[$k];
								}	
								else
								{
									 $f->Availability = 0;
								}
							  $f->User = User::getSysUser()->userID;
							  $f->save();
							}						 
						}
						
						return Redirect::to('ViewHREmployeePersonalFileDoc');
					
					
				}
            
        }
		
	}
	
	public function DeleteHREmployeePersonalFileDoc()
	{
		       $id = Input::get('id');
               $quorg = HREmployeePersonalFileDoc::findOrFail($id); // if not found show 404 page
               $quorg->Deleted =1;
			   $quorg->Active =0;
			   $quorg->User = User::getSysUser()->userID;
               $quorg->save();
			   
			   $Updatedoctrans = HREmployeePersonalFileDocTrans::where('hrEPFDId','=',$id)->update(array('Deleted' => 1,'User' =>User::getSysUser()->userID));
               return Redirect::to('ViewHREmployeePersonalFileDoc');
	}
	
	public function ViewHREmployeePersonalFileDoc()
	{
        $v = View::make('HREmployeePersonalFileDoc.EmpQua');
		$method = Request::getMethod();
		$qqq = HRPersonalFileDocument::where('Deleted','=',0)->where('Active','=',1)->orderBy('id')->get();
		$v->quaorg = $qqq;
		$v->countquaorg = count($qqq);
		$v->user = User::getSysUser();
		$userOrgaId = User::getSysUser()->organisationId;
				$userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
				$userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
				$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->where('ToOrganisation', '=', $userOrgaId)->lists('Emp_ID');
				//$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->lists('Emp_ID');
				$userTypeID = User::getSysUser()->userType;
		        $UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');

        if ($method == "GET") 
		{
			    
				
				if ($userOrgaType === 'HO') {
					if($UserTypeName == 'HR-MAPF')
			{
				$empqua = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  left join hremployeeepfhistory
											      on hremployee.id=hremployeeepfhistory.EmpId
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  and hremployeeepfhistory.Deleted=0
												  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
												  order by hremployeepersonalfiledoc.FileNo"));
			}
			else
			{
				$empqua = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  order by hremployeepersonalfiledoc.FileNo"));
			}
					
					
					
				} else {

					  $empqua = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  and hremployee.id IN('".$ProCurrentEmpId."')
												  order by hremployeepersonalfiledoc.FileNo"));
				}
				
				$v->empqua = $empqua;
				
		}
		if ($method == "POST") 
		{
			$Stype = Input::get('SType');
			$NIC = Input::get('NIC');
			
			if($Stype == 'NIC')
			{
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
			
			if ($userOrgaType === 'HO') 
			{
				if($UserTypeName == 'HR-MAPF')
				{
					/* $empqua = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  and hremployee.id='".$GetEmpID."'
												  order by hremployeepersonalfiledoc.FileNo")); */
												  
												  $empqua = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  left join hremployeeepfhistory
											      on hremployee.id=hremployeeepfhistory.EmpId
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  and hremployeeepfhistory.Deleted=0
												   and hremployee.id='".$GetEmpID."'
												  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
												  order by hremployeepersonalfiledoc.FileNo"));
				}
				else
				{
					$empqua = DB::select(DB::raw("select hremployeepersonalfiledoc.*,
												  hremployee.NIC,
												  hremployee.EPFNo,
												  hremployee.Initials,
												  hremployee.LastName,
												  hremployee.Photograph
												  from hremployeepersonalfiledoc
												  left join hremployee
												  on hremployeepersonalfiledoc.EmpId=hremployee.id
												  where hremployeepersonalfiledoc.Deleted=0
												  and hremployee.Deleted=0
												  and hremployee.id='".$GetEmpID."'
												  order by hremployeepersonalfiledoc.FileNo"));
				}
			}
			else
			{
			}
			
										
		  $v->empqua = $empqua;
		  $v->Issearch = 'true';
			
		}
        
        return $v;
    }
	
	
	 public function CreateHREmployeePersonalFileDoc() 
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeePersonalFileDoc.Create');
        $view->user = User::getSysUser();
		$view->quaorg = HRPersonalFileDocument::where('Deleted','=',0)->where('Active','=',1)->orderBy('id')->get();
		
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
				$availableempfileno = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('EmpId','=',Input::get('EmpId'))->where('FileNo','=',Input::get('FileNo'))->get();
				if(count($availableempfileno) != 0)
				{
					return Redirect::to('CreateHREmployeePersonalFileDoc')->with("Exist", true);
				}
				else
				{
					$availablefileNo = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('EmpId','!=',Input::get('EmpId'))->where('FileNo','=',Input::get('FileNo'))->get(); 
					if(count($availablefileNo) != 0)
					{
						return Redirect::to('CreateHREmployeePersonalFileDoc')->with("ExistAnother", true);
					}
					else{
						
						$update = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('EmpId','=',Input::get('EmpId'))->update(array('Active' => 0));
						$eq = new HREmployeePersonalFileDoc;
						$eq->EmpId = Input::get('EmpId');
						$eq->FileNo = Input::get('FileNo');
						$eq->User = User::getSysUser()->userID;
						$eq->Active = 1;
						$eq->save();
						
						$getHREPFDId = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('EmpId','=',Input::get('EmpId'))->where('FileNo','=',Input::get('FileNo'))->pluck('id');
						$DocIDs = Input::get('DocIDs'); 
						$checkedChecked_ids = Input::get('Checked_ids');
						$countallDocIDs = count($DocIDs);
						$countcheckedChecked_ids = count($checkedChecked_ids);
						$PageNos = [];
						$PageNos = Input::get('PageNos');
						
						
						  for($k=0;$k<$countallDocIDs;$k++)
						  {

							$UniqDocID = $DocIDs[$k];
							if(in_array($UniqDocID, $checkedChecked_ids))
							{
							  $f = new HREmployeePersonalFileDocTrans();
							  $f->hrEPFDId = $getHREPFDId;
							  $f->EmpId = Input::get('EmpId');
							  $f->FileNo = Input::get('FileNo');
							  $f->DocumentId = $UniqDocID;
							  $f->Availability = 1;
							  $f->PageNo = $PageNos[$k];
							  $f->User = User::getSysUser()->userID;
							  $f->save(); 

							}
							else
							{
							  
							  $f = new HREmployeePersonalFileDocTrans();
							  $f->hrEPFDId = $getHREPFDId;
							  $f->EmpId = Input::get('EmpId');
							  $f->FileNo = Input::get('FileNo');
							  $f->DocumentId = $UniqDocID;
							  $f->Availability = 0;
							  $f->User = User::getSysUser()->userID;
							  $f->save();
							}
						  }
						
						return Redirect::to('CreateHREmployeePersonalFileDoc')->with("done", true);
					}
					
				}
				
                
				
				

              
          
        }
    }
	
		public function DeleteHRPersonalFileDoc()
	{
		       $id = Input::get('id');
                $quorg = HRPersonalFileDocument::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRPersonalFileDoc');
	}
	
	public function EditHRPersonalFileDoc()
	{
		$view = View::make('HRPersonalFileDoc.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRPersonalFileDocument::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRPersonalFileDocument::find(Input::get('QO_ID'));
			$oq->DocumentName = Input::get('DocumentName');
            $oq->User = User::getSysUser()->userID;
		    $oq->Active = Input::get('Active');
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRPersonalFileDoc');
			
			
			}
	}
	
		public function CreateHRPersonalFileDoc()
	{
		$method = Request::getMethod();
        $view = View::make('HRPersonalFileDoc.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRPersonalFileDocument;
                $qo->DocumentName = Input::get('DocumentName');
                $qo->User = User::getSysUser()->userID;
				$qo->Active = Input::get('Active');
                $qo->save();
               return Redirect::to('CreateHRPersonalFileDoc')->with("done", true);
            
            
            }
	}
	
		public function ViewHRPersonalFileDoc()
	{
		$quorga = HRPersonalFileDocument::where('Deleted',"!=","1")->get();
 		$v = View::make('HRPersonalFileDoc.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function ViewHREmployeeLoanHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeLoan.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
										$Sql = "select hremployeeloan.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  hrloantype.LoanType
										  from hremployeeloan
										  left join hremployee
										  on hremployeeloan.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeeloan.Assure1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeeloan.Assure2=hregua2.id
										  left join hrloantype
										  on hremployeeloan.LoanTypeId=hrloantype.id
										  where hremployeeloan.Deleted=0
										  and hremployee.id='".$GetEmpID."'
										  order by hremployee.EPFNo";
		  $dataList = DB::select(DB::raw($Sql));
		  $v->promotion = $dataList;
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  return $v;
        }
		
	}
	
	public function DeleteHREmployeeLoan()
	{
		$id = Input::get('id');
        $empqua = HREmployeeLoan::findOrFail($id);
        $empqua->Deleted = 1;
        $empqua->User = User::getSysUser()->userID;
        $empqua->save();
        return Redirect::to('ViewHREmployeeLoan');
	}
	
	public function EditHREmployeeLoan()
	{
		$view = View::make('HREmployeeLoan.Edit');
        $method = Request::getMethod();

        if ($method == "GET") 
{
            $empqua = HREmployeeLoan::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeLoan::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeeLoan.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
            $view->user = User::getSysUser();
		    $view->quaorg = HRLoanType::where("Deleted", "!=", 1)->orderBy('LoanType')->get();
		    $view->employees = HREmployee::where("Deleted", "!=", 1)->where('id','!=',$EmpId)->orderBy('EPFNo')->get();
		    $view->empqua = $empqua;
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $eq = HREmployeeLoan::find(Input::get('EQ_ID'));
              
               $ProgramID = Input::get('QO_ID');
                if (HRLoanType::where('Deleted', '!=', 1)->where('id', '=', $ProgramID)->count() < 1) {
                    $QO = new HRLoanType;
                    $QO->LoanType = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HRLoanType::where('Deleted', '!=', 1)->where('LoanType', '=', Input::get('QO_ID'))->pluck('id');
                    $eq->LoanTypeId = $newQO_ID;
                } else {
                    $eq->LoanTypeId = Input::get('QO_ID');
                }
				
				$eq->LoanAmount = Input::get('LoanAmount');
				$eq->IssuedDate = Input::get('IssuedDate');
				$issu = Input::get('IssuedDate');
				$install = Input::get('NoOFInstallment');
				if(!empty($issu))
				{
				$ss = DB::select(DB::raw("SELECT DATE_ADD('$issu', INTERVAL '$install' MONTH) as completeddate"));
				$newdata =  json_decode(json_encode((array)$ss),true);
				$expectedcom = $newdata[0]["completeddate"];
				$eq->CompletedDate = $expectedcom;
				}
				$Guarantors = [];
                $Guarantors = Input::get('Gaurators');
                $countP = count($Guarantors); 
				$gua1 = "";
				$gua2 = "";
				if(!empty($Guarantors[0]))
				{
					$gua1 = $Guarantors[0];
				}
				if(!empty($Guarantors[1]))
				{
					$gua2 = $Guarantors[1];
				}
				$eq->Assure1 = $gua1;
                $eq->Assure2 = $gua2;
				$eq->NoOFInstallment = Input::get('NoOFInstallment');
				$eq->LoanClosed = Input::get('LoanClosed');
				$eq->save();
              
                if ($eq->save()) {
                    return Redirect::to('ViewHREmployeeLoan');
                }
            
        }
		
	}
	
		public function LoadhrEmployeeGuarantorwithourOwner()
    {
        $id=Input::get('id');
		  $userOrgId=User::getSysUserOrg();
          $OrgaDetails=Organisation::where('Deleted','=',0)->where('id','=',$userOrgId)->first();
          $OrgaType=OrganisationType::where('OT_ID','=',$OrgaDetails->TypeId)->pluck('Type');
		  $loggeduserDistrict = Organisation::where('id','=',$userOrgId)->pluck('DistrictCode');
		  
	
            
				$Ins=HREmployee::where('Deleted','=',0)->where('id','!=',$id)->orderBy('EPFNo')->get();
    
    $html='';
        foreach($Ins As $i){
            $html.='<option value="'.$i->id.'">'.$i->EPFNo.'-'.$i->Initials.'  '.$i->LastName.'</option>';
        }
		
        $html.='';
    return $html;
    //
    }
	
	 public function CreateHREmployeeLoan() 
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeeLoan.Create');
        $view->user = User::getSysUser();
		$view->quaorg = HRLoanType::where("Deleted", "!=", 1)->orderBy('LoanType')->get();
		
		$view->employees = HREmployee::where("Deleted", "!=", 1)->orderBy('EPFNo')->get();
		
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") 
		{
          
           
                $eq = new HREmployeeLoan;
                
                $ProgramID = Input::get('QO_ID');
                if (HRLoanType::where('Deleted', '!=', 1)->where('id', '=', $ProgramID)->count() < 1) {
                    $QO = new HRLoanType;
                    $QO->LoanType = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HRLoanType::where('Deleted', '!=', 1)->where('LoanType', '=', Input::get('QO_ID'))->pluck('id');
                    $eq->LoanTypeId = $newQO_ID;
                } else {
                    $eq->LoanTypeId = Input::get('QO_ID');
                }
				
			
                $eq->EmpId = Input::get('EmpId');
                $eq->LoanAmount = Input::get('LoanAmount');
				$eq->IssuedDate = Input::get('IssuedDate');
				$issu = Input::get('IssuedDate');
				$install = Input::get('NoOFInstallment');
				if(!empty($issu))
				{
				$ss = DB::select(DB::raw("SELECT DATE_ADD('$issu', INTERVAL '$install' MONTH) as completeddate"));
				$newdata =  json_decode(json_encode((array)$ss),true);
				$expectedcom = $newdata[0]["completeddate"];
				$eq->CompletedDate = $expectedcom;
				}
				
				$Guarantors = [];
                $Guarantors = Input::get('Gaurators');
                $countP = count($Guarantors); 
				$gua1 = "";
				$gua2 = "";
				if(!empty($Guarantors[0]))
				{
					$gua1 = $Guarantors[0];
				}
				if(!empty($Guarantors[1]))
				{
					$gua2 = $Guarantors[1];
				}
				$eq->Assure1 = $gua1;
                $eq->Assure2 = $gua2;
				$eq->NoOFInstallment = Input::get('NoOFInstallment');
				$eq->LoanClosed = Input::get('LoanClosed');
				$eq->save();

                return Redirect::to('CreateHREmployeeLoan')->with("done", true);
          
        }
    }
	
	public function ViewHREmployeeLoan()
	{
        $v = View::make('HREmployeeLoan.EmpQua');
        $userOrgaId = User::getSysUser()->organisationId;
        $userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
        $userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
        $ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->where('ToOrganisation', '=', $userOrgaId)->lists('Emp_ID');
		//$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->lists('Emp_ID');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
        if ($userOrgaType === 'HO') {
			
			if($UserTypeName == 'HR-MAPF')
			{
				$empqua = DB::select(DB::raw("select hremployeeloan.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  hrloantype.LoanType
										  from hremployeeloan
										  left join hremployee
										  on hremployeeloan.EmpId=hremployee.id
										  left join hremployeeepfhistory
										  on hremployee.id=hremployeeepfhistory.EmpId
										  left join hremployee as hregua1
										  on hremployeeloan.Assure1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeeloan.Assure2=hregua2.id
										  left join hrloantype
										  on hremployeeloan.LoanTypeId=hrloantype.id
										  where hremployeeloan.Deleted=0
										  and hremployeeepfhistory.Deleted=0
										  and hremployee.Deleted=0
										  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
										  order by hremployee.EPFNo"));
			}
			else
			{
				$empqua = DB::select(DB::raw("select hremployeeloan.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  hrloantype.LoanType
										  from hremployeeloan
										  left join hremployee
										  on hremployeeloan.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeeloan.Assure1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeeloan.Assure2=hregua2.id
										  left join hrloantype
										  on hremployeeloan.LoanTypeId=hrloantype.id
										  where hremployeeloan.Deleted=0
										   and hremployee.Deleted=0
										  order by hremployee.EPFNo"));
			}
            
        } else {

			$empqua = DB::select(DB::raw("select hremployeeloan.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  hrloantype.LoanType
										  from hremployeeloan
										  left join hremployee
										  on hremployeeloan.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeeloan.Assure1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeeloan.Assure2=hregua2.id
										  left join hrloantype
										  on hremployeeloan.LoanTypeId=hrloantype.id
										  where hremployeeloan.Deleted=0
										   and hremployee.Deleted=0
										  and hremployee.id IN('".$ProCurrentEmpId."')
										  order by hremployee.EPFNo
										  "));
        }
        $v->empqua = $empqua;
        $v->user = User::getSysUser();
        return $v;
    }
	
		public function ViewHREmployeeTrainingHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeTraining.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
										$Sql = "select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hremployeetraining.ProgramType,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType,
										  hremployeetraining.TrainingCompletedDate,
										  hremployeetraining.CertificateForwadedDate
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										  and hremployee.id='".$GetEmpID."'
										  order by hremployee.EPFNo";
		  $dataList = DB::select(DB::raw($Sql));
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  $v->promotion = $dataList;
		  return $v;
        }
		
	}
	
	public function DeleteHREmployeeTraining()
	{
		$id = Input::get('id');
        $empqua = HREmployeeTraining::findOrFail($id);
        $empqua->Deleted = 1;
        $empqua->User = User::getSysUser()->userID;
        $empqua->save();
        return Redirect::to('ViewHREmployeeTraining');
	}
	
		
	public function EditHREmployeeTraining()
	{
		$view = View::make('HREmployeeTraining.Edit');
        $method = Request::getMethod();

        if ($method == "GET") 
{
            $empqua = HREmployeeTraining::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeTraining::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeeTraining.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
            $view->user = User::getSysUser();
		    $view->quaorg = HREmployeeTrainingProgram::where("Deleted", "!=", 1)->orderBy('NameOfTheProgram')->get();
		    $view->Institutes = HREmployeeTrainingInstitute::where("Deleted", "!=", 1)->orderBy('InstituteName')->get();
		     $view->employees = HREmployee::where("Deleted", "!=", 1)->where('id','!=',$EmpId)->orderBy('EPFNo')->get();
		    $view->country = Country::orderBy('CountryName')->get();
            $view->empqua = $empqua;
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $oq = HREmployeeTraining::find(Input::get('EQ_ID'));
              
               $ProgramID = Input::get('QO_ID');
                if (HREmployeeTrainingProgram::where('Deleted', '!=', 1)->where('id', '=', $ProgramID)->count() < 1) {
                    $QO = new HREmployeeTrainingProgram;
                    $QO->NameOfTheProgram = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HREmployeeTrainingProgram::where('Deleted', '!=', 1)->where('NameOfTheProgram', '=', Input::get('QO_ID'))->pluck('id');
                    $oq->ProgramId = $newQO_ID;
                } else {
                    $oq->ProgramId = Input::get('QO_ID');
                }
				
				$InsID = Input::get('InstituteID');
				if (HREmployeeTrainingInstitute::where('Deleted', '!=', 1)->where('id', '=', $InsID)->count() < 1) {
                    $Qd = new HREmployeeTrainingInstitute;
                    $Qd->InstituteName = Input::get('InstituteID');
                    $Qd->User = User::getSysUser()->userID;
                    $Qd->save();
                    $newQD_ID = HREmployeeTrainingInstitute::where('Deleted', '!=', 1)->where('InstituteName', '=', Input::get('InstituteID'))->pluck('id');
                    $oq->TrainingInstituteId = $newQD_ID;
                } else {
                    $oq->TrainingInstituteId = Input::get('InstituteID');
                }
				
				$countryID = Input::get('CountryId');
				if (Country::where('id', '=', $countryID)->count() < 1) {
                    $QC = new Country;
                    $QC->CountryName = Input::get('CountryId');
                    $QC->save();
                    $newQc_ID = Country::where('CountryName', '=', Input::get('CountryId'))->pluck('id');
                    $oq->CountryId = $newQc_ID;
                } else {
                    $oq->CountryId = Input::get('CountryId');
                }
               
               // $oq->EmpId = Input::get('EmpId');
                $oq->TrainingType = Input::get('TrainingType');
				$oq->AmountPaidByVTA = Input::get('AmountPaidByVTA');
				$oq->CompulsoryPeriodOfService = Input::get('CompulsoryPeriodOfService');
				$oq->CompulsoryPeriodOfServiceMonth = Input::get('CompulsoryPeriodOfServiceMonth');
				$oq->AmountOfSurcharge = Input::get('AmountOfSurcharge');
				$oq->CertificateForwarded = Input::get('CertificateForwarded');
				$oq->CertificateForwadedDate = Input::get('CertificateForwardedDate');
				$oq->TrainingCompletedDate = Input::get('TrainingCompletedDate');
				 /* $dateRange = Input::get('date-range-picker');
			 	$tempDateRange = explode(" - ", $dateRange);
				$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
				$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4]; */
                $oq->DurationFrom = Input::get('date-range-picker-From');
				$oq->DurationTo = Input::get('date-range-picker-To');
				$Guarantors = [];
                $Guarantors = Input::get('Gaurators');
                $countP = count($Guarantors); 
				$gua1 = "";
				$gua2 = "";
				if(!empty($Guarantors[0]))
				{
					$gua1 = $Guarantors[0];
				}
				if(!empty($Guarantors[1]))
				{
					$gua2 = $Guarantors[1];
				}
				
				$oq->Guarantor1 = $gua1;
                $oq->Guarantor2 = $gua2;
				$oq->PayStatus = Input::get('PayStatus');
				$oq->ProgramType = Input::get('ProgramType');
				$oq->Other = Input::get('Other');
				$oq->save();
              
                if ($oq->save()) {
                    return Redirect::to('ViewHREmployeeTraining');
                }
            
        }
		
	}
	
	 public function CreateHREmployeeTraining() 
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeeTraining.Create');
        $view->user = User::getSysUser();
		$view->quaorg = HREmployeeTrainingProgram::where("Deleted", "!=", 1)->orderBy('NameOfTheProgram')->get();
		$view->Institutes = HREmployeeTrainingInstitute::where("Deleted", "!=", 1)->orderBy('InstituteName')->get();
		$view->employees = HREmployee::where("Deleted", "!=", 1)->orderBy('EPFNo')->get();
		$view->country = Country::orderBy('CountryName')->get();
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
           
                $eq = new HREmployeeTraining;
                
                $ProgramID = Input::get('QO_ID');
                if (HREmployeeTrainingProgram::where('Deleted', '!=', 1)->where('id', '=', $ProgramID)->count() < 1) {
                    $QO = new HREmployeeTrainingProgram;
                    $QO->NameOfTheProgram = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HREmployeeTrainingProgram::where('Deleted', '!=', 1)->where('NameOfTheProgram', '=', Input::get('QO_ID'))->pluck('id');
                    $eq->ProgramId = $newQO_ID;
                } else {
                    $eq->ProgramId = Input::get('QO_ID');
                }
				
				$InsID = Input::get('InstituteID');
				if (HREmployeeTrainingInstitute::where('Deleted', '!=', 1)->where('id', '=', $InsID)->count() < 1) {
                    $Qd = new HREmployeeTrainingInstitute;
                    $Qd->InstituteName = Input::get('InstituteID');
                    $Qd->User = User::getSysUser()->userID;
                    $Qd->save();
                    $newQD_ID = HREmployeeTrainingInstitute::where('Deleted', '!=', 1)->where('InstituteName', '=', Input::get('InstituteID'))->pluck('id');
                    $eq->TrainingInstituteId = $newQD_ID;
                } else {
                    $eq->TrainingInstituteId = Input::get('InstituteID');
                }
				
				$countryID = Input::get('CountryId');
				if (Country::where('id', '=', $countryID)->count() < 1) {
                    $QC = new Country;
                    $QC->CountryName = Input::get('CountryId');
                    $QC->save();
                    $newQc_ID = Country::where('CountryName', '=', Input::get('CountryId'))->pluck('id');
                    $eq->CountryId = $newQc_ID;
                } else {
                    $eq->CountryId = Input::get('CountryId');
                }
				
                $eq->EmpId = Input::get('EmpId');
                $eq->TrainingType = Input::get('TrainingType');
				$eq->AmountPaidByVTA = Input::get('AmountPaidByVTA');
				$eq->CompulsoryPeriodOfService = Input::get('CompulsoryPeriodOfService');
				$eq->CompulsoryPeriodOfServiceMonth = Input::get('CompulsoryPeriodOfServiceMonth');
				$eq->AmountOfSurcharge = Input::get('AmountOfSurcharge');
				$eq->CertificateForwarded = Input::get('CertificateForwarded');
				$eq->CertificateForwadedDate = Input::get('CertificateForwardedDate');
				$eq->TrainingCompletedDate = Input::get('TrainingCompletedDate');
				
				 /* $dateRange = Input::get('date-range-picker');
			 	$tempDateRange = explode(" - ", $dateRange);
				$tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
				$tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4]; */
                $eq->DurationFrom = Input::get('date-range-picker-From');
				$eq->DurationTo = Input::get('date-range-picker-To');
				$Guarantors = [];
                $Guarantors = Input::get('Gaurators');
                $countP = count($Guarantors); 
				$gua1 = "";
				$gua2 = "";
				if(!empty($Guarantors[0]))
				{
					$gua1 = $Guarantors[0];
				}
				if(!empty($Guarantors[1]))
				{
					$gua2 = $Guarantors[1];
				}
				
				$eq->Guarantor1 = $gua1;
                $eq->Guarantor2 = $gua2;
				$eq->PayStatus = Input::get('PayStatus');
				$eq->ProgramType = Input::get('ProgramType');
				$eq->Other = Input::get('Other');
				$eq->save();

                return Redirect::to('CreateHREmployeeTraining')->with("done", true);
          
        }
    }
	
	public function ViewHREmployeeTraining()
	{
        $v = View::make('HREmployeeTraining.EmpQua');
        $userOrgaId = User::getSysUser()->organisationId;
        $userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
        $userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
        $ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->where('ToOrganisation', '=', $userOrgaId)->lists('Emp_ID');
		//$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->lists('Emp_ID');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
        if ($userOrgaType === 'HO') {
			
			if($UserTypeName == 'HR-MAPF')
			{
				$empqua = DB::select(DB::raw("select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										    hremployeetraining.ProgramType,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType,
										  hremployeetraining.TrainingCompletedDate,
										  hremployeetraining.CertificateForwadedDate
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployeeepfhistory
											  on hremployee.id=hremployeeepfhistory.EmpId
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										   and hremployee.Deleted=0
										   and hremployeeepfhistory.Deleted=0
										   and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
										  order by hremployee.EPFNo"));
			}
			else
			{
				$empqua = DB::select(DB::raw("select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployeetraining.ProgramType,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType,
										  hremployeetraining.TrainingCompletedDate,
										  hremployeetraining.CertificateForwadedDate
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										   and hremployee.Deleted=0
										  order by hremployee.EPFNo"));
			}
            
        } else {

$empqua = DB::select(DB::raw("select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployeetraining.ProgramType,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType,
										  hremployeetraining.TrainingCompletedDate,
										  hremployeetraining.CertificateForwadedDate
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										 on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										   and hremployee.Deleted=0
										  and hremployee.id IN('".$ProCurrentEmpId."')
										  order by hremployee.EPFNo"));
        }
        $v->empqua = $empqua;
        $v->user = User::getSysUser();
        return $v;
    }
	
	public function ViewHREmployeeEBQualificationHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREBQualification.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
										$Sql = "select hremployeeebqualification.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrgrade.Grade,
										  hremployee.Photograph,
										  hremployee.OldNIC
										  from hremployeeebqualification
										  left join hremployee
										  on hremployeeebqualification.EmpId=hremployee.id
										  left join hrgrade
										  on hremployeeebqualification.GradeId=hrgrade.id
										  where hremployeeebqualification.Deleted=0
										  and hremployee.id='".$GetEmpID."'
										  order By hrgrade.Grade";
		  $dataList = DB::select(DB::raw($Sql));
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  $v->promotion = $dataList;
		  return $v;
        }
		
	}
	
	public function DeleteHREmployeeEBQualification()
	{
        $id = Input::get('id');
        $empqua = HREBQualification::findOrFail($id);
        $empqua->Deleted = 1;
        $empqua->User = User::getSysUser()->userID;
        $empqua->save();
        return Redirect::to('ViewHREmployeeEBQualification');
    }
	
	  public function EditHREmployeeEBQualification() {
        $view = View::make('HREBQualification.Edit');
        $method = Request::getMethod();

        if ($method == "GET") {
            
			
            $EmpId = HREBQualification::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREBQualification.Edit')
                    ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
					$empqua = HREBQualification::where('id', "=", Input::get('id'))->first();
					$view->user = User::getSysUser();
					$view->empqua = $empqua;
					$view->grades = HRGrade::where("Deleted", "!=", 1)->orderBy('Grade')->get();
           
         
            return $view;
        }
        if ($method == "POST") {
          
            
                
                $eq = HREBQualification::find(Input::get('EQ_ID'));
                $eq->GradeId = Input::get('GradeID');
				$eq->QualifiedDate = Input::get('DateQualified');
				$eq->User = User::getSysUser()->userID;
				$available = HREBQualification::where('EmpId','=',Input::get('EmpId'))->where('GradeId','=',Input::get('GradeID'))->where('Deleted','=',0)->get();
				if(count($available) == 0)
				{
					 $eq->save();
					 
				}
				
				
				return Redirect::to('ViewHREmployeeEBQualification');
			
				
            
        }
    }
	
	 public function CreateHREmployeeEBQualification() {
        $method = Request::getMethod();
        $view = View::make('HREBQualification.Create');
        $view->user = User::getSysUser();
		$view->grades = HRGrade::where("Deleted", "!=", 1)->orderBy('Grade')->get();
      
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
           
                $eq = new HREBQualification;
                $eq->EmpId = Input::get('EmpId');
                $eq->GradeId = Input::get('GradeID');
				$eq->QualifiedDate = Input::get('DateQualified');
				$eq->User = User::getSysUser()->userID;
				$available = HREBQualification::where('EmpId','=',Input::get('EmpId'))->where('GradeId','=',Input::get('GradeID'))->where('Deleted','=',0)->get();
				if(count($available) == 0)
				{
					 $eq->save();
					 return Redirect::to('CreateHREmployeeEBQualification')->with("done", true);
				}
				else
				{
					return Redirect::to('CreateHREmployeeEBQualification')->with("Exit", true);
				}
               

                
          
        }
    }
	
	public function ViewHREmployeeEBQualification()
	{
        $v = View::make('HREBQualification.EmpQua');
        $userOrgaId = User::getSysUser()->organisationId;
        $userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
        $userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
        $ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->where('ToOrganisation', '=', $userOrgaId)->lists('Emp_ID');
		//$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->lists('Emp_ID');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
        if ($userOrgaType === 'HO') {
			
			if($UserTypeName == 'HR-MAPF')
			{
				$empqua = DB::select(DB::raw("select hremployeeebqualification.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrgrade.Grade
										  from hremployeeebqualification
										  left join hremployee
										  on hremployeeebqualification.EmpId=hremployee.id
										  left join hremployeeepfhistory
										  on hremployee.id=hremployeeepfhistory.EmpId
										  left join hrgrade
										  on hremployeeebqualification.GradeId=hrgrade.id
										  where hremployeeebqualification.Deleted=0
										  and hremployeeepfhistory.Deleted=0
										  and hremployee.Deleted=0
											  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
											order By hremployee.EPFNo
										"));
			}
			else
			{
				$empqua = DB::select(DB::raw("select hremployeeebqualification.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrgrade.Grade
										 from hremployeeebqualification
										  left join hremployee
										  on hremployeeebqualification.EmpId=hremployee.id
										  left join hrgrade
											on hremployeeebqualification.GradeId=hrgrade.id
										  where hremployeeebqualification.Deleted=0
										  and hremployee.Deleted=0
											order By hremployee.EPFNo
										"));
			}
            
        } else {

             $empqua = DB::select(DB::raw("select hremployeeebqualification.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrgrade.Grade
										 from hremployeeebqualification
										  left join hremployee
										  on hremployeeebqualification.EmpId=hremployee.id
										  left join hrgrade
											on hremployeeebqualification.GradeId=hrgrade.id
										  where hremployeeebqualification.Deleted=0
										  and hremployee.Deleted=0
										  and hremployee.id IN('".$ProCurrentEmpId."')
											order By hremployee.EPFNo"));
        }
        $v->empqua = $empqua;
        $v->user = User::getSysUser();
        return $v;
    }
	
	public function GetTransferTypeAvailable()
	{
		$tt = Input::get('tt');
  
		$salaryScale = TransferType::where('T_ID','=',$tt)->pluck('Available');
      
		$json = array("done" => $salaryScale);
            return json_encode($json, 0); 
	}
	
	public function HREmployeeProfileGetStudentData()
	{
        $id =  Input::get("studentData");

        $view = View::make('HREmployeeProfile.Profile');

        	$sql1 = DB::select(DB::raw("select hremployee.*,district.DistrictName,electorate.ElectorateName,province.ProvinceName,organisation.OrgaName,organisation.Type
										  from hremployee
										  left join district
										  on hremployee.DistrictName=district.DistrictCode
										  left join electorate
										  on hremployee.DSDivision=electorate.ElectorateCode
										  left JOIN province
										  on district.ProvinceCode=province.ProvinceCode
										  left join organisation
										  on hremployee.OrgId=organisation.id
										  where hremployee.Deleted=0
										  and hremployee.id='".$id."'"));
  
       //	$trainee = HREmployee::where('id','=',$id)->where('Deleted','=',0)->get();
        $view->trainee = $sql1;	
		$sqlPrpmo = DB::select(DB::raw("select hrpromotion.*,
		  hremploymentcode.Designation,
		  hrpromotion.Emp_ID,
		  transfertype.TransferType,
		  transfertype.Available,
		  trade.TradeName,
		  hrgrade.Grade,
		   hrpromotion.SalaryStep,
		  hrsalaryscale.SalaryCode,
		  hrsalaryscale.SalaryScale,
		  hrsalarysteptrans.StepAmount,
		  department.DepartmentName,
		  organisation.OrgaName,organisation.Type,employeetype.EmployeeType,
		  hrsalaryscale.ServiceCategory,
		  hrgrade1.Grade as PGrade,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  hrsalarysteptrans1.StepAmount as PStepAmount
		  from hrpromotion
		  left join hremploymentcode
		  on hrpromotion.NewPost=hremploymentcode.id
		  left join organisation
		  on hrpromotion.ToOrganisation=organisation.id
		  left join department
		  on hrpromotion.ToDepartment=department.D_ID
		  left join transfertype
		  on hrpromotion.TransferType=transfertype.T_ID
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join trade
		  on hremployee.Trade=trade.TradeId
		  left join hrgrade
		  on hrpromotion.GradeId=hrgrade.id
		  left join hrsalaryscale
		  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
		  left join hrsalarysteptrans
		  on hrpromotion.SalaryStep=hrsalarysteptrans.id
		   left join employeetype
		  on hrpromotion.EmpType=employeetype.ET_ID
		  left join hrsalarysteptrans as hrsalarysteptrans1
		  on hrpromotion.PSalaryStep=hrsalarysteptrans1.id
		  left join hrgrade as hrgrade1
		  on hrpromotion.PGradeId=hrgrade1.id
		  left join hrsalaryscale as hrsalaryscale1
		  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
		  where hrpromotion.Deleted=0
		  and hrpromotion.CurrentRecord='Yes'
		  and hrpromotion.Emp_ID='".$id."'
		  and hrpromotion.Priority='1'"));
		$view->EmpId = $id;
		$view->CurrentPro = $sqlPrpmo;
		
		$sqlExPrpmoWithoutPrio2 = DB::select(DB::raw("select hrpromotion.*,
			  hremploymentcode.Designation,
			  hrpromotion.Emp_ID,
			  transfertype.TransferType,
			  transfertype.Available,
			  trade.TradeName,
			  hrgrade.Grade,
			  hrsalaryscale.SalaryCode,
			  hrsalaryscale.SalaryScale,
			  hrsalarysteptrans.StepAmount,
			  department.DepartmentName,
			  organisation.OrgaName,organisation.Type,employeetype.EmployeeType,
			  hrgrade1.Grade as PGrade,
			   hrpromotion.SalaryStep,
		  hrsalaryscale1.ServiceCategory as PServiceCategory,
		  hrsalaryscale1.SalaryCode as PSalaryCode,
		  hrsalaryscale1.SalaryScale as PSalaryScale,
		  hrpromotion.PSalaryStep,
		  hrsalarysteptrans1.StepAmount as PStepAmount
  from hrpromotion
  left join hremploymentcode
  on hrpromotion.NewPost=hremploymentcode.id
  left join organisation
  on hrpromotion.ToOrganisation=organisation.id
  left join department
  on hrpromotion.ToDepartment=department.D_ID
  left join transfertype
  on hrpromotion.TransferType=transfertype.T_ID
  left join hremployee
  on hrpromotion.Emp_ID=hremployee.id
  left join trade
  on hremployee.Trade=trade.TradeId
  left join hrgrade
  on hrpromotion.GradeId=hrgrade.id
  left join hrsalaryscale
  on hrpromotion.ServiceCategoryID=hrsalaryscale.id
  left join hrsalarysteptrans
  on hrpromotion.SalaryStep=hrsalarysteptrans.id
   left join employeetype
  on hrpromotion.EmpType=employeetype.ET_ID
  left join hrsalarysteptrans as hrsalarysteptrans1
		  on hrpromotion.PSalaryStep=hrsalarysteptrans1.id
  left join hrgrade as hrgrade1
  on hrpromotion.PGradeId=hrgrade1.id
  left join hrsalaryscale as hrsalaryscale1
  on hrpromotion.PServiceCategoryID=hrsalaryscale1.id
  where hrpromotion.Deleted=0
  and hrpromotion.CurrentRecord='No'
  and hrpromotion.Emp_ID='".$id."'
  Order By hrpromotion.StartDate"));
  $view->ExPro = $sqlExPrpmoWithoutPrio2;
		$view->AllNIC = HREmployeeNICHistory::where('EmpId','=',$id)->where('Deleted','=',0)->orderBy('Active', 'DESC')->get();
		$view->AllEPF = HREmployeeEPFHistory::where('EmpId','=',$id)->where('Deleted','=',0)->orderBy('Active', 'DESC')->get();
		$SqlQ = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                                          hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$id."'
										  and hrqualificationtype.Type='Educational'
										  order by hrqualificationcategory.CategoryLevel";
		 $Quaification = DB::select(DB::raw($SqlQ));
		$view->EQualification = $Quaification;	
		$SqlP = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$id."'
										  and hrqualificationtype.Type='Professional'
										  order by hrqualificationcategory.CategoryLevel";
		  $Professional = DB::select(DB::raw($SqlP));
		$view->PQualification = $Professional;
		$SqlV = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$id."'
										  and hrqualificationtype.Type='Vocational'
										  order by hrqualificationcategory.CategoryLevel";
		  $Vocational = DB::select(DB::raw($SqlV));
		$view->VQualification = $Vocational;
		
		$SqlExps = "select hremployeeexperience.id,
										hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrexperiencecompany.CompanyName,
										hrexperiencedesignation.Designation,
										  hremployeeexperience.DateJoined,
										  hremployeeexperience.DateResigned,
										  hremployeeexperience.ReasonToLeave
										  from hremployeeexperience
										  left join hremployee
											on hremployeeexperience.EmpId=hremployee.id
										  left join hrexperiencecompany
										  on hremployeeexperience.CompanyId=hrexperiencecompany.id
										  left join hrexperiencedesignation
										  on hremployeeexperience.DesignationID=hrexperiencedesignation.id
										  where hremployeeexperience.Deleted=0
										  and hremployee.id='".$id."'
										  order By hremployeeexperience.DateJoined";
		  $Experience = DB::select(DB::raw($SqlExps));
       $view->Experience = $Experience;
	   
	   $SqlTrainingWithPay = "select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										 and hremployee.id='".$id."'
										 and hremployeetraining.PayStatus='Pay'
										 order by hremployeetraining.TrainingType";
										  
		$paytraining = DB::select(DB::raw($SqlTrainingWithPay));
       $view->PayTraining = $paytraining;
	   
	    $SqlTrainingWithNoPay = "select hremployeetraining.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hremployeetraining.TrainingType,
										  hremployeetraining.DurationFrom,
										  hremployeetraining.DurationTo,
										  hremployeetraining.AmountPaidByVTA,
										  hremployeetraining.CompulsoryPeriodOfService,
										  hremployeetraining.CompulsoryPeriodOfServiceMonth,
										  hremployeetraining.AmountOfSurcharge,
										  hremployeetraining.CertificateForwarded,
										  hremployeetraininginstitute.InstituteName,
										  hremployeetrainingprogram.NameOfTheProgram,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  country.CountryName,
										  hremployeetraining.Other,
										  hremployeetraining.PayStatus,
										  hremployeetraining.TrainingType
										  from hremployeetraining
										  left join hremployee
										  on hremployeetraining.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeetraining.Guarantor1=hregua1.id
										  left join country
										  on hremployeetraining.CountryId=country.id
										  left join hremployee as hregua2
										  on hremployeetraining.Guarantor2=hregua2.id
										  left join hremployeetraininginstitute
										  on hremployeetraining.TrainingInstituteId=hremployeetraininginstitute.id
										  left join hremployeetrainingprogram
										  on hremployeetraining.ProgramId=hremployeetrainingprogram.id
										  where hremployeetraining.Deleted=0
										 and hremployee.id='".$id."'
										 and hremployeetraining.PayStatus='NoPay'
										 order by hremployeetraining.TrainingType";
										  
		$nopaytraining = DB::select(DB::raw($SqlTrainingWithNoPay));
       $view->NoPayTraining = $nopaytraining;
	   
	    $SqlLoan = "select hremployeeloan.*,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hremployee.Photograph,
										  hregua1.EPFNo as guarepf1,
										  hregua1.Initials as guaini1,
										  hregua1.LastName as gualname1,
										  hregua2.EPFNo as guarepf2,
										  hregua2.Initials as guaini2,
										  hregua2.LastName as gualname2,
										  hrloantype.LoanType
										  from hremployeeloan
										  left join hremployee
										  on hremployeeloan.EmpId=hremployee.id
										  left join hremployee as hregua1
										  on hremployeeloan.Assure1=hregua1.id
										  left join hremployee as hregua2
										  on hremployeeloan.Assure2=hregua2.id
										  left join hrloantype
										  on hremployeeloan.LoanTypeId=hrloantype.id
										  where hremployeeloan.Deleted=0
										  and hremployee.id='".$id."'
										  order by hremployee.EPFNo";
										  
		$LoanDetails = DB::select(DB::raw($SqlLoan));
        $view->LoanDetails = $LoanDetails;
		
		//OL att 1
		$OLResult = DB::select(DB::raw("select hremployeeolresulttrans.id,
									  hremployeeolresult.Year,
									  hremployeeolresult.IndexNo,
									  hrolattept.Attempt,
									  hrolsubject.Subject,
									  hrolgrade.Grade,
									  hrolgrade.PassStatus
									  from hremployeeolresulttrans
									  left join hremployeeolresult
									  on hremployeeolresulttrans.EOLRId=hremployeeolresult.id
									  left join hrolattept
									  on hremployeeolresult.AttemptId=hrolattept.id
									  left join hrolsubject
									  on hremployeeolresulttrans.SubjectId=hrolsubject.id
									  left join hrolgrade
									  on hremployeeolresulttrans.GradeId=hrolgrade.id
									  where hremployeeolresulttrans.Deleted=0
									  and hremployeeolresult.Deleted=0
									  and hremployeeolresulttrans.EmpId='".$id."'
									  order by hremployeeolresulttrans.AttemptId,hremployeeolresulttrans.id")); 
	  $view->OLResult = $OLResult;
	  $ALResult = DB::select(DB::raw("select hremployeealresulttrans.id,
									  hremployeealresult.Year,
									  hremployeealresult.IndexNo,
									  hralattempt.Attempt,
									  hralsubject.Subject,
									  hrolgrade.Grade,
									  hrolgrade.PassStatus
									  from hremployeealresulttrans
									  left join hremployeealresult
									  on hremployeealresulttrans.EALRId=hremployeealresult.id
									  left join hralattempt
									  on hremployeealresult.AttemptId=hralattempt.id
									  left join hralsubject
									  on hremployeealresulttrans.SubjectId=hralsubject.id
									  left join hrolgrade
									  on hremployeealresulttrans.GradeId=hrolgrade.id
									  where hremployeealresulttrans.Deleted=0
									  and hremployeealresulttrans.EmpId='".$id."'
									  and hremployeealresult.Deleted=0")); 
	  $view->ALResult = $ALResult;
	  $view->GKMarks = HREmployeeAlResult::where('Deleted','=',0)->where('EmpId','=',$id)->first();
		// personal file
		$qqq = HRPersonalFileDocument::where('Deleted','=',0)->where('Active','=',1)->orderBy('id')->get();
		$view->quaorg = $qqq;
		$view->PFileNo = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$id)->pluck('FileNo');
		$view->PFileNoId = HREmployeePersonalFileDoc::where('Deleted','=',0)->where('Active','=',1)->where('EmpId','=',$id)->pluck('id');
        return $view;
	}
	
	   public function HREmployeeProfileajaxViewData()
    {
       	$searchVal = Input::get('searchVal');
       	$choice = Input::get('choice');

       	//return $searchVal;
       	//return $choice;
    
		
		if ($choice == 'nic')
		{
			//NIC
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$searchVal)->where('Deleted','=',0)->pluck('EmpId');
			    $Employee = HREmployee::where('id','=',$GetEmpID)->where('Deleted','=',0)->get();
			    $dataList = $Employee;
		}
		elseif ($choice == 'tno') 
		{
			//EPF
			$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$searchVal)->where('Deleted','=',0)->pluck('EmpId');
			$Employee = HREmployee::where('id','=',$GetEmpID)->where('Deleted','=',0)->get();
			$dataList = $Employee;
		}
		else 
		{
			$Employee = HREmployee::where('LastName', 'like', '$searchVal%')->where('Deleted','=',0)->get();
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
            $html.='<div class="well well-small"><b><center> All Details Matched From Employee List</center></b></div>';
			//$html.='</br>';

        	$html.='<div id="table" class="row-fluid span20" style="margin: 0px;" overflow="auto">';
			$html.='<table  class="table table-striped table-bordered table-hover">';
			                           
			$html.='<tbody id="table-body">';
			$html.='</tbody>';

            $html.='<thead>';
            $html.='<tr>';
            $html.='<th></th>';
            $html.='<th>View Employee Profile</th>';
            $html.='<th>Full Name</th>';
			$html.='<th>Name with Initials</th>';
            $html.='<th>NIC</th>';
			$html.='<th>EPF No</th>';
			
            $html.='</tr>';
            $html.='</thead>';

            foreach ($dataList as $aList)
           	{		

                    $html.='<tr>';
                    $html.='<td>'.$c.'</td>';
                    $html.='<td>
					<form action="HREmployeeProfileGetStudentData">
					<input type="hidden" name="studentData" value="'.$aList->id.'"/>
					<center>
					<button onclick="viewStudentProfile()" id="stdData" name="stdData" value="'.$aList->id.'" class="btn btn-small btn-pink">View Employee Profile</button>
					</center>
					</form>
					</td>';
                    $html.='<td>'.$aList->Name.' '.$aList->LastName.'</td>';
					$html.='<td>'.$aList->Initials.' '.$aList->LastName.'</td>';
                    $html.='<td>'.$aList->NIC.'</td>';
					$html.='<td>'.$aList->EPFNo.'</td>';
					
                    $html.='</tr>';

                    $c ++;
       		}

            $html.='</table>';
   			$html.='</div>';

            return $html;
                   
        }
    }
	
	    public function ViewHREmployeeProfile() {

        $view = View::make('HREmployeeProfile.EmployeeProfile');
        $view->user = User::getSysUser();

        return $view;
    }
	
	public function DeleteHRExperienceDesignation()
	  {
                $id = Input::get('id');
                $quorg = HRExperienceDesignation::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRExperienceDesignation');
                
            }
	
	public function EditHRExperienceDesignation()
	{
			$view = View::make('HRExperienceDesignation.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRExperienceDesignation::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRExperienceDesignation::find(Input::get('QO_ID'));
			$oq->Designation = Input::get('Designation');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRExperienceDesignation');
			
			
			}
}
	
		public function CreateHRExperienceDesignation()
	 {
        $method = Request::getMethod();
        $view = View::make('HRExperienceDesignation.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRExperienceDesignation;
                $qo->Designation = Input::get('Designation');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRExperienceDesignation')->with("done", true);
            
            
            }
            
          }
	
		public function ViewHRExperienceDesignation()
	{
		$quorga = HRExperienceDesignation::where('Deleted',"!=","1")->OrderBy('Designation')->get();
 		$v = View::make('HRExperienceDesignation.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function DeleteHRExperienceCompany()
	  {
                $id = Input::get('id');
                $quorg = HRExperienceCompany::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRExperienceCompany');
                
            }
	
	public function EditHRExperienceCompany()
	{
			$view = View::make('HRExperienceCompany.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRExperienceCompany::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRExperienceCompany::find(Input::get('QO_ID'));
			$oq->CompanyName = Input::get('OrgaName');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRExperienceCompany');
			
			
			}
}
		public function CreateHRExperienceCompany()
	 {
        $method = Request::getMethod();
        $view = View::make('HRExperienceCompany.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRExperienceCompany;
                $qo->CompanyName = Input::get('OrgaName');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRExperienceCompany')->with("done", true);
            
            
            }
            
          }
		
	public function ViewHRExperienceCompany()
	{
		$quorga = HRExperienceCompany::where('Deleted',"!=","1")->OrderBy('CompanyName')->get();
 		$v = View::make('HRExperienceCompany.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ViewHREmployeeExperienceHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeExperience.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
			$Sql = "select hremployeeexperience.id,
										hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrexperiencecompany.CompanyName,
										  hrexperiencedesignation.Designation,
										  hremployeeexperience.DateJoined,
										  hremployeeexperience.DateResigned,
										  hremployeeexperience.ReasonToLeave,
										  hremployeeexperience.Years,
										  hremployeeexperience.Months			
										  from hremployeeexperience
										  left join hremployee
										  on hremployeeexperience.EmpId=hremployee.id
										  left join hrexperiencecompany
										  on hremployeeexperience.CompanyId=hrexperiencecompany.id
										  left join hrexperiencedesignation
										  on hremployeeexperience.DesignationID=hrexperiencedesignation.id
										  where hremployeeexperience.Deleted=0
										  and hremployee.id='".$GetEmpID."'
										  order By hremployeeexperience.DateJoined";
		  $dataList = DB::select(DB::raw($Sql));
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  $v->promotion = $dataList;
		  return $v;
        }
		
	}
	
	public function EditHREmployeeExperience()
	{
		$view = View::make('HREmployeeExperience.Edit');
        $method = Request::getMethod();

        if ($method == "GET") 
{
            $empqua = HREmployeeExperience::where('id', "=", Input::get('id'))->first();
			$EmpId = HREmployeeExperience::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeeExperience.Edit')
                   ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
            $view->user = User::getSysUser();
		    $view->quaorg = HRExperienceCompany::where("Deleted", "!=", 1)->orderBy('CompanyName')->get();
		    $view->Designation = HRExperienceDesignation::where("Deleted", "!=", 1)->orderBy('Designation')->get();
            $view->empqua = $empqua;
			return $view;
        }
		if ($method == "POST") {
          
            
                
                $oq = HREmployeeExperience::find(Input::get('EQ_ID'));
              
                $UniID = Input::get('QO_ID');
                if (HRExperienceCompany::where('Deleted', '!=', 1)->where('id', '=', $UniID)->count() < 1) {
                    $QO = new HRExperienceCompany;
                    $QO->CompanyName = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HRExperienceCompany::where('Deleted', '!=', 1)->where('CompanyName', '=', Input::get('QO_ID'))->pluck('id');
                    $oq->CompanyId = $newQO_ID;
                } else {
                    $oq->CompanyId = Input::get('QO_ID');
                }
				$DesID = Input::get('DesignationID');
				if (HRExperienceDesignation::where('Deleted', '!=', 1)->where('id', '=', $DesID)->count() < 1) {
                    $Qd = new HRExperienceDesignation;
                    $Qd->Designation = Input::get('DesignationID');
                    $Qd->User = User::getSysUser()->userID;
                    $Qd->save();
                    $newQD_ID = HRExperienceDesignation::where('Deleted', '!=', 1)->where('Designation', '=', Input::get('DesignationID'))->pluck('id');
                    $oq->DesignationID = $newQD_ID;
                } else {
                    $oq->DesignationID = Input::get('DesignationID');
                }
				
               
                if(!empty(Input::get('DateJoined')))
				{
					$oq->DateJoined = Input::get('DateJoined');
				}
				if(!empty(Input::get('DateResigned')))
				{
					$oq->DateResigned = Input::get('DateResigned');
				}
				$oq->ReasonToLeave = Input::get('Reason');
				if(!empty(Input::get('DateJoined')) && !empty(Input::get('DateResigned')))
				{
					$sql = "Select
								TIMESTAMPDIFF( YEAR, '".Input::get('DateJoined')."','". Input::get('DateResigned')."' ) as _year
								,TIMESTAMPDIFF( MONTH,'".Input::get('DateJoined')."', '". Input::get('DateResigned')."' ) % 12 as _month
								,FLOOR( TIMESTAMPDIFF( DAY, '".Input::get('DateJoined')."', '". Input::get('DateResigned')."' ) % 30.4375 ) as _day";
								$res=DB::select(DB::raw($sql));
								$newdata =  json_decode(json_encode((array)$res),true);
								$year = $newdata[0]["_year"];
								$month = $newdata[0]["_month"];
								$day = $newdata[0]["_day"];
								
				$oq->Years = $year;
				$oq->Months = $month;
				}
				else
				{
					$oq->Years = Input::get('Years');
				    $oq->Months = Input::get('Months');
				}
				
				
                $oq->User = User::getSysUser()->userID;
              
                if ($oq->save()) {
                    return Redirect::to('ViewHREmployeeExperience');
                }
            
        }
		
	}
	
	public function DeleteHREmployeeExperience()
	{
		$id = Input::get('id');
        $empqua = HREmployeeExperience::findOrFail($id);
        $empqua->Deleted = 1;
        $empqua->User = User::getSysUser()->userID;
        $empqua->save();
        return Redirect::to('ViewHREmployeeExperience');
	}
	
	 public function CreateHREmployeeExperience() 
	 {
        $method = Request::getMethod();
        $view = View::make('HREmployeeExperience.Create');
        $view->user = User::getSysUser();
		$view->quaorg = HRExperienceCompany::where("Deleted", "!=", 1)->orderBy('CompanyName')->get();
		$view->Designation = HRExperienceDesignation::where("Deleted", "!=", 1)->orderBy('Designation')->get();
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
           
                $eq = new HREmployeeExperience;
                
                $UniID = Input::get('QO_ID');
                if (HRExperienceCompany::where('Deleted', '!=', 1)->where('id', '=', $UniID)->count() < 1) {
                    $QO = new HRExperienceCompany;
                    $QO->CompanyName = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HRExperienceCompany::where('Deleted', '!=', 1)->where('CompanyName', '=', Input::get('QO_ID'))->pluck('id');
                    $eq->CompanyId = $newQO_ID;
                } else {
                    $eq->CompanyId = Input::get('QO_ID');
                }
				$DesID = Input::get('DesignationID');
				if (HRExperienceDesignation::where('Deleted', '!=', 1)->where('id', '=', $DesID)->count() < 1) {
                    $Qd = new HRExperienceDesignation;
                    $Qd->Designation = Input::get('DesignationID');
                    $Qd->User = User::getSysUser()->userID;
                    $Qd->save();
                    $newQD_ID = HRExperienceDesignation::where('Deleted', '!=', 1)->where('Designation', '=', Input::get('DesignationID'))->pluck('id');
                    $eq->DesignationID = $newQD_ID;
                } else {
                    $eq->DesignationID = Input::get('DesignationID');
                }
				
                $eq->EmpId = Input::get('EmpId');
				if(!empty(Input::get('DateJoined')))
				{
					$eq->DateJoined = Input::get('DateJoined');
				}
				if(!empty(Input::get('DateResigned')))
				{
					$eq->DateResigned = Input::get('DateResigned');
				}
                
				
				$eq->ReasonToLeave = Input::get('Reason');
				
				if(!empty(Input::get('DateJoined')) && !empty(Input::get('DateResigned')))
				{
					$sql = "Select
								TIMESTAMPDIFF( YEAR, '".Input::get('DateJoined')."','". Input::get('DateResigned')."' ) as _year
								,TIMESTAMPDIFF( MONTH,'".Input::get('DateJoined')."', '". Input::get('DateResigned')."' ) % 12 as _month
								,FLOOR( TIMESTAMPDIFF( DAY, '".Input::get('DateJoined')."', '". Input::get('DateResigned')."' ) % 30.4375 ) as _day";
								$res=DB::select(DB::raw($sql));
								$newdata =  json_decode(json_encode((array)$res),true);
								$year = $newdata[0]["_year"];
								$month = $newdata[0]["_month"];
								$day = $newdata[0]["_day"];
								
				$eq->Years = $year;
				$eq->Months = $month;
				}
				else
				{
					$eq->Years = Input::get('Years');
				    $eq->Months = Input::get('Months');
				}
				
                $eq->User = User::getSysUser()->userID;
                $eq->save();

                return Redirect::to('CreateHREmployeeExperience')->with("done", true);
          
        }
    }
	
	public function ViewHREmployeeExperience()
	{
        $v = View::make('HREmployeeExperience.EmpQua');
        $userOrgaId = User::getSysUser()->organisationId;
        $userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
        $userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
        $ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->where('ToOrganisation', '=', $userOrgaId)->lists('Emp_ID');
		//$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->lists('Emp_ID');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
        if ($userOrgaType === 'HO') {
			if($UserTypeName == 'HR-MAPF')
			{
				$empqua = DB::select(DB::raw("select hremployeeexperience.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrexperiencecompany.CompanyName,
										  hrexperiencedesignation.Designation,
										  hremployeeexperience.DateJoined,
										  hremployeeexperience.DateResigned,
										  hremployeeexperience.ReasonToLeave,
										  hremployeeexperience.Years,
										  hremployeeexperience.Months										
										  from hremployeeexperience
										  left join hremployee
										  on hremployeeexperience.EmpId=hremployee.id
										  left join hremployeeepfhistory
										  on hremployee.id=hremployeeepfhistory.EmpId
										  left join hrexperiencecompany
										  on hremployeeexperience.CompanyId=hrexperiencecompany.id
										  left join hrexperiencedesignation
										  on hremployeeexperience.DesignationID=hrexperiencedesignation.id
										  where hremployeeexperience.Deleted=0
										  and hremployeeepfhistory.Deleted=0
                                          and hremployee.Deleted=0
										  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
										  "));
			}
			else
			{
				$empqua = DB::select(DB::raw("select hremployeeexperience.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrexperiencecompany.CompanyName,
										  hrexperiencedesignation.Designation,
										  hremployeeexperience.DateJoined,
										  hremployeeexperience.DateResigned,
										  hremployeeexperience.ReasonToLeave,
										  hremployeeexperience.Years,
										  hremployeeexperience.Months										
										  from hremployeeexperience
										  left join hremployee
										  on hremployeeexperience.EmpId=hremployee.id
										  left join hrexperiencecompany
										  on hremployeeexperience.CompanyId=hrexperiencecompany.id
										  left join hrexperiencedesignation
										  on hremployeeexperience.DesignationID=hrexperiencedesignation.id
										  where hremployeeexperience.Deleted=0
										  and hremployee.Deleted=0"));
			}
			
            
        } else {

             $empqua = DB::select(DB::raw("select hremployeeexperience.id,
										   hremployee.Initials,hremployee.LastName,hremployee.NIC,
										   hremployee.EPFNo,
										   hrexperiencecompany.CompanyName,
											hrexperiencedesignation.Designation,
											  hremployeeexperience.DateJoined,
											  hremployeeexperience.DateResigned,
											  hremployeeexperience.ReasonToLeave,
										hremployeeexperience.Years,
										hremployeeexperience.Months			
											  from hremployeeexperience
											  left join hremployee
											  on hremployeeexperience.EmpId=hremployee.id
											  left join hrexperiencecompany
											  on hremployeeexperience.CompanyId=hrexperiencecompany.id
											  left join hrexperiencedesignation
											  on hremployeeexperience.DesignationID=hrexperiencedesignation.id
											  where hremployeeexperience.Deleted=0
											   and hremployee.Deleted=0
										  and hremployee.id IN('".$ProCurrentEmpId."')"));
        }
        $v->empqua = $empqua;
        $v->user = User::getSysUser();
        return $v;
    }
	
	public function ViewHREmployeeQualificationHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HREmployeeQualification.PromoHistory');
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
			$Sql = "select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,hremployee.OldNIC,
                      hremployee.Photograph,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType,
										  hremployeequalification.UGCApproveStatus
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployee.id='".$GetEmpID."'
										  order by hrqualificationcategory.CategoryLevel";
		  $dataList = DB::select(DB::raw($Sql));
		   $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  $v->promotion = $dataList;
		  return $v;
        }
		
	}
	
	public function DeleteHREmployeeQualification()
	{
        $id = Input::get('id');
        $empqua = HREmployeeQualification::findOrFail($id);
        $empqua->Deleted = 1;
        $empqua->User = User::getSysUser()->userID;
        $empqua->save();
        return Redirect::to('ViewHREmployeeQualification');
    }
	
	   public function EditHREmployeeQualification() {
        $view = View::make('HREmployeeQualification.Edit');
        $method = Request::getMethod();

        if ($method == "GET") {
            $empqua = HREmployeeQualification::where('id', "=", Input::get('id'))->first();
            $GetempQCode = HREmployeeQualification::where('id', '=', Input::get('id'))->pluck('QualificationID');
            $EmpId = HREmployeeQualification::where('id', '=', Input::get('id'))->pluck('EmpId');
            $view = View::make('HREmployeeQualification.Edit')
                    ->with("EmpQualificationTypeID", HRQualification::where('id', '=', $GetempQCode)->pluck('QualificationTypeID'))
                    ->with("EmpQualificationCategoryID", HRQualification::where('id', '=', $GetempQCode)->pluck('QualificationCategoryID'))
					->with("EmpQualificationName", HRQualification::where('id', '=', $empqua->QualificationID)->pluck('Qualification'))
                    ->with("EmpNIC", HREmployee::where('id', '=', $EmpId)->pluck('NIC'))
					->with("EmpInitials", HREmployee::where('id', '=', $EmpId)->pluck('Initials'))
					->with("EmpLastName", HREmployee::where('id', '=', $EmpId)->pluck('LastName'))
                    ->with("EPF", HREmployee::where('id', '=', $EmpId)->pluck('EPFNo'));
           
            $view->user = User::getSysUser();
            
            $view->empqua = $empqua;
			$QTypeID = HRQualification::where('id','=',$GetempQCode)->pluck('QualificationTypeID');
			$QcategoryID =HRQualification::where('id','=',$GetempQCode)->pluck('QualificationCategoryID');
            $view->qualification = HRQualification::where("Deleted", "!=", 1)->where('QualificationTypeID','=',$QTypeID)->where('QualificationCategoryID','=',$QcategoryID)->orderBy('Qualification')->get();
            $view->quaorg = HRUniversity::where("Deleted", "!=", 1)->orderBy('UniversityName')->get();
		    $view->quatype = HRQualificationType::where("Deleted", "!=", 1)->orderBy('Type')->get();
		    $view->quacategory = HRQualificationCategory::where("Deleted", "!=", 1)->orderBy('QCategory')->get();
           
         
            return $view;
        }
        if ($method == "POST") {
          
            
                
                $oq = HREmployeeQualification::find(Input::get('EQ_ID'));
              
                $UniID = Input::get('QO_ID');
                 if (HRUniversity::where('Deleted', '!=', 1)->where('id', '=', $UniID)->count() < 1) {
                    $QO = new HRUniversity;
                    $QO->UniversityName = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HRUniversity::where('Deleted', '!=', 1)->where('UniversityName', '=', Input::get('QO_ID'))->pluck('id');
                    $oq->UniversityID = $newQO_ID;
                } else {
                    $oq->UniversityID = Input::get('QO_ID');
                }
                
               
                $oq->QualificationID = Input::get('QCode');
				$oq->MainSubjects = Input::get('MainSubject');
				$oq->Month = Input::get('Month');
				$oq->Year = Input::get('Year');
				$oq->CourseType = Input::get('CourseType');
				$oq->UGCApproveStatus = Input::get('UGCApproveStatus');
                $oq->User = User::getSysUser()->userID;
                $oq->Changed = 1;
                if ($oq->save()) {
                    return Redirect::to('ViewHREmployeeQualification');
                }
            
        }
    }
	
	 public function HRnicAjax() {
        $EPF = Input::get('epf');
        $employeeID = HREmployeeEPFHistory::where('EPFNo','=',$EPF)->where('Deleted','=',0)->pluck('EmpId');
        $employeeNIC = HREmployee::where('Deleted', "!=", 1)->where('id', "=", $employeeID)->pluck('NIC');
		$Initials = HREmployee::where('Deleted', "!=", 1)->where('id', "=", $employeeID)->pluck('Initials');
		$LastName = HREmployee::where('Deleted', "!=", 1)->where('id', "=", $employeeID)->pluck('LastName');
		$name = $Initials .' '.$LastName;
        echo $employeeID . '/n/' . $employeeNIC . '/n/' . $name ;
    }
	
	 public function HRsaveQualificationDescription() {
       
        $html = '';
       
           
			
			$Available = HRQualification::where('Deleted','=',0)->where('QualificationTypeID','=',Input::get('QualificationType'))->where('QualificationCategoryID','=',Input::get('QualificationCat'))->where('Qualification','=',Input::get('QualificationDescription'))->get();
               if(count($Available) == 0)
			   {
				    $qo = new HRQualification;
					$qo->QualificationTypeID = Input::get('QualificationType');
					$qo->QualificationCategoryID = Input::get('QualificationCat');
					$qo->Qualification = Input::get('QualificationDescription');
					$qo->User = User::getSysUser()->userID;
					$qo->save();
			   }
            $qualificationType = HRQualification::where('Deleted','=',0)->where('QualificationTypeID','=',Input::get('QualificationType'))->where('QualificationCategoryID','=',Input::get('QualificationCat'))->orderBy('Qualification')->get();
            $html.='<select name="QCode" id="QCode" ><option value="">--Select Qualification--</option>';
            foreach ($qualificationType as $qt) {
                if ($qt->id == $qo->id) {
                    $html.='<option value="' . $qt->id . '" selected>' . $qt->Qualification . '</option>';
                } else {
                    $html.='<option value="' . $qt->id . '">' . $qt->Qualification . '</option>';
                }
            }
            $html.='</select><span style="margin-left:5px;"><input type="button"  value="New Qualification Description" name="NewQualificationDescription" id="NewQualificationDescription" onclick="addQualificationDescription()" class="btn btn-small btn-primary"/></span>';
            $done = '<div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">
                     <i class="icon-remove"></i>
                     </button>
                     <strong>
                     <i class="icon-ok"></i>
                     Qualification Desription Added Successfully!
                     </strong>
                     <br>
                     </div>';
            $json = array("html" => $html, "QCode" => $qo->id, "done" => $done);
            return json_encode($json, 0);
        
    }
	
	  public function HREmpQualificationTypeAjax() {
        $QType = Input::get('QType');
		$QCategory = Input::get('QCategory');
        $ss = HRQualification::where('Deleted', '!=', 1)->where('QualificationTypeID', "=", $QType)->where('QualificationCategoryID', "=", $QCategory)->orderBy('Qualification')->get();
        $html = "<select name='QCode' id='QCode'>";
        $html.="<option value=\"\">--Select Qualification--</option>";
        foreach ($ss as $s) {
            $html .="<option value =\"$s->id\">$s->Qualification</option>";
        }
        $html .="</select><b style=\"color: red\">*</b><input type='button'  value='New Qualification Description' name='NewQualificationDescription' id='NewQualificationDescription' onclick='addQualificationDescription()' class='btn btn-small btn-primary'/>"
                . "<span id=\"QdesOther\"></span>";

        echo $html;
    }
	
	 public function CreateHREmployeeQualification() {
        $method = Request::getMethod();
        $view = View::make('HREmployeeQualification.Create');
        $view->user = User::getSysUser();
		$view->qualification = Qualification::where("Deleted", "!=", 1)->orderBy('qualification')->get();
        $view->quaorg = HRUniversity::where("Deleted", "!=", 1)->orderBy('UniversityName')->get();
		$view->quatype = HRQualificationType::where("Deleted", "!=", 1)->orderBy('Type')->get();
		$view->quacategory = HRQualificationCategory::where("Deleted", "!=", 1)->orderBy('QCategory')->get();
       
        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
          
           
                $eq = new HREmployeeQualification;
                
                $UniID = Input::get('QO_ID');
                if (HRUniversity::where('Deleted', '!=', 1)->where('id', '=', $UniID)->count() < 1) {
                    $QO = new HRUniversity;
                    $QO->UniversityName = Input::get('QO_ID');
                    $QO->User = User::getSysUser()->userID;
                    $QO->save();
                    $newQO_ID = HRUniversity::where('Deleted', '!=', 1)->where('UniversityName', '=', Input::get('QO_ID'))->pluck('id');
                    $eq->UniversityID = $newQO_ID;
                } else {
                    $eq->UniversityID = Input::get('QO_ID');
                }

                $eq->EmpId = Input::get('EmpId');
                $eq->QualificationID = Input::get('QCode');
				$eq->MainSubjects = Input::get('MainSubject');
				$eq->Result = Input::get('Result');
				$eq->Month = Input::get('Month');
				$eq->Year = Input::get('Year');
				$eq->CourseType = Input::get('CourseType');
				$eq->UGCApproveStatus = Input::get('UGCApproveStatus');
                $eq->User = User::getSysUser()->userID;
                $eq->save();

                return Redirect::to('CreateHREmployeeQualification')->with("done", true);
          
        }
    }
	
	public function ViewHREmployeeQualification()
	{
        $v = View::make('HREmployeeQualification.EmpQua');
        $userOrgaId = User::getSysUser()->organisationId;
        $userOrgaTypeID = Organisation::where('id', '=', $userOrgaId)->pluck('TypeId');
        $userOrgaType = OrganisationType::where('OT_ID', '=', $userOrgaTypeID)->pluck('Type');
        $ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->where('ToOrganisation', '=', $userOrgaId)->lists('Emp_ID');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		//$ProCurrentEmpId = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', '=', 'Yes')->lists('Emp_ID');
        if ($userOrgaType === 'HO') {
			if($UserTypeName == 'HR-MAPF')
			{
				$empqua = DB::select(DB::raw("select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType,
										  hremployeequalification.UGCApproveStatus
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hremployeeepfhistory
										  on hremployee.id=hremployeeepfhistory.EmpId
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										  and hremployeeepfhistory.Deleted=0
										  and hremployee.Deleted=0
										  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
										  from hruserepflist
										  where hruserepflist.Deleted=0
										  and hruserepflist.Active=1
										  and hruserepflist.UserID='".User::getSysUser()->userID."')
										"));
			}
			else
			{
				$empqua = DB::select(DB::raw("select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType,
										  hremployeequalification.UGCApproveStatus
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										   and hremployee.Deleted=0
										"));
			}
            
        } else {

             $empqua = DB::select(DB::raw("select hremployeequalification.id,
										  hremployee.Initials,hremployee.LastName,hremployee.NIC,
										  hremployee.EPFNo,
										  hrqualificationtype.Type,
										  hrqualificationcategory.QCategory,
										  hrqualification.Qualification,
										  hruniversity.UniversityName,
										  hremployeequalification.MainSubjects,
										  hremployeequalification.Result,
										  hremployeequalification.Year,
										  hremployeequalification.Month,
										  hremployeequalification.CourseType,
										  hremployeequalification.UGCApproveStatus
										  from hremployeequalification
										  left join hremployee
										  on hremployeequalification.EmpId=hremployee.id
										  left join hrqualification
										  on hremployeequalification.QualificationID=hrqualification.id
										  left join hrqualificationtype
										  on hrqualification.QualificationTypeID=hrqualificationtype.id
										  left join hrqualificationcategory
										  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
										  left join hruniversity
										  on hremployeequalification.UniversityID=hruniversity.id
										  where hremployeequalification.Deleted=0
										   and hremployee.Deleted=0
										  and hremployee.id IN('".$ProCurrentEmpId."')
										"));
        }
        $v->empqua = $empqua;
        $v->user = User::getSysUser();
        return $v;
    }
	
		public function DeleteHRQualification()
	{
		       $id = Input::get('id');
                $quorg = HRQualification::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRQualification');
	}
	
	public function EditHRQualification()
	{
		$view = View::make('HRQualification.Edit');
			$method = Request::getMethod();
			$QCategory = HRQualificationCategory::where('Deleted',"!=","1")->OrderBy('QCategory')->get();
			$Qtype = HRQualificationType::where('Deleted',"!=","1")->OrderBy('Type')->get();
			//$institutes = User::getSysUser()->instituteId;
			$view->QCategory = $QCategory;
			$view->Qtype = $Qtype;
			if ($method == "GET")
			{
			$quorg = HRQualification::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			
			$Available = HRQualification::where('Deleted','=',0)->where('QualificationTypeID','=',Input::get('QType'))->where('QualificationCategoryID','=',Input::get('QCategory'))->where('Qualification','=',Input::get('Qualification'))->get();
			if(count($Available) == 0)
			   {
				  
				$oq = HRQualification::find(Input::get('QO_ID'));
				$oq->QualificationTypeID = Input::get('QType');
				$oq->QualificationCategoryID = Input::get('QCategory');
				$oq->Qualification = Input::get('Qualification');
				$oq->User = User::getSysUser()->userID;
				$oq->Changed=1;
				$oq->save();
			   }
			
			return Redirect::to('ViewHRQualification');
			
			
			}
	}
	
		public function CreateHRQualification()
	{
		$method = Request::getMethod();
        $view = View::make('HRQualification.Create');
		$QCategory = HRQualificationCategory::where('Deleted',"!=","1")->OrderBy('QCategory')->get();
		$Qtype = HRQualificationType::where('Deleted',"!=","1")->OrderBy('Type')->get();
        //$institutes = User::getSysUser()->instituteId;
		$view->QCategory = $QCategory;
        $view->Qtype = $Qtype;
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
				$Available = HRQualification::where('Deleted','=',0)->where('QualificationTypeID','=',Input::get('QType'))->where('QualificationCategoryID','=',Input::get('QCategory'))->where('Qualification','=',Input::get('Qualification'))->get();
               if(count($Available) == 0)
			   {
				    $qo = new HRQualification;
					$qo->QualificationTypeID = Input::get('QType');
					$qo->QualificationCategoryID = Input::get('QCategory');
					$qo->Qualification = Input::get('Qualification');
					$qo->User = User::getSysUser()->userID;
					$qo->save();
			   }
			  
               return Redirect::to('CreateHRQualification')->with("done", true);
            
            
            }
	}
	
	public function ViewHRQualification()
	{
		$quorga = DB::select(DB::raw("select hrqualification.id,hrqualification.Qualification,hrqualificationcategory.QCategory,hrqualificationtype.Type
									 from hrqualification
									  left join hrqualificationtype
									  on hrqualification.QualificationTypeID=hrqualificationtype.id
									  left join hrqualificationcategory
									  on hrqualification.QualificationCategoryID=hrqualificationcategory.id
									  where hrqualification.Deleted=0
									  order by hrqualificationtype.Type,hrqualificationcategory.QCategory,hrqualification.Qualification"));
 		$v = View::make('HRQualification.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
		public function DeleteHRQualificationCategory()
	{
		       $id = Input::get('id');
                $quorg = HRQualificationCategory::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRQualificationCategory');
	}
	
	public function EditHRQualificationCategory()
	{
		$view = View::make('HRQualificationCategory.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRQualificationCategory::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRQualificationCategory::find(Input::get('QO_ID'));
			$oq->QCategory = Input::get('QCategory');
			$oq->User = User::getSysUser()->userID;
			$oq->CategoryLevel = Input::get('Level');
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRQualificationCategory');
			
			
			}
	}
	
	public function CreateHRQualificationCategory()
	{
		$method = Request::getMethod();
        $view = View::make('HRQualificationCategory.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRQualificationCategory;
                $qo->QCategory = Input::get('QCategory');
                $qo->User = User::getSysUser()->userID;
				$qo->CategoryLevel = Input::get('Level');
                $qo->save();
               return Redirect::to('CreateHRQualificationCategory')->with("done", true);
            
            
            }
	}
	
	
	
	public function ViewHRQualificationCategory()
	{
		$quorga = HRQualificationCategory::where('Deleted',"!=","1")->OrderBy('CategoryLevel')->get();
 		$v = View::make('HRQualificationCategory.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function DeleteHRQualificationType()
	{
		       $id = Input::get('id');
                $quorg = HRQualificationType::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRQualificationType');
	}
	
	public function EditHRQualificationType()
	{
		$view = View::make('HRQualificationType.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRQualificationType::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRQualificationType::find(Input::get('QO_ID'));
			$oq->Type = Input::get('Qualification');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRQualificationType');
			
			
			}
	}
	
	public function CreateHRQualificationType()
	{
		$method = Request::getMethod();
        $view = View::make('HRQualificationType.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRQualificationType;
                $qo->Type = Input::get('Qualification');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRQualificationType')->with("done", true);
            
            
            }
	}
	
	public function ViewHRQualificationType()
	{
		$quorga = HRQualificationType::where('Deleted',"!=","1")->OrderBy('Type')->get();
 		$v = View::make('HRQualificationType.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function DeleteHRUniversity()
	  {
                $id = Input::get('id');
                $quorg = HRUniversity::findOrFail($id); // if not found show 404 page
                 $quorg->Deleted =1;
				 $quorg->Changed =1;
                 //$organisation->DateEntered = \Carbon\Carbon::now();
                 $quorg->User = User::getSysUser()->userID;
                 $quorg->save();
                return Redirect::to('ViewHRUniversity');
                
            }
	
	public function EditHRUniversity()
	{
			$view = View::make('HRUniversity.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			$quorg = HRUniversity::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			

			$oq = HRUniversity::find(Input::get('QO_ID'));
			$oq->UniversityName = Input::get('OrgaName');
			$oq->User = User::getSysUser()->userID;
			$oq->Changed=1;
			$oq->save();
			
			return Redirect::to('ViewHRUniversity');
			
			
			}
}
	
	public function CreateHRUniversity()
	 {
        $method = Request::getMethod();
        $view = View::make('HRUniversity.Create');
        //$institutes = User::getSysUser()->instituteId;
       
        
        if ($method == "GET")
        {
            return $view;
        }
        if ($method == "POST") 
            {
            
                $qo = new HRUniversity;
                $qo->UniversityName = Input::get('OrgaName');
                $qo->User = User::getSysUser()->userID;
                $qo->save();
               return Redirect::to('CreateHRUniversity')->with("done", true);
            
            
            }
            
          }
	
	public function ViewHRUniversity()
	{
		$quorga = HRUniversity::where('Deleted',"!=","1")->OrderBy('UniversityName')->get();
 		$v = View::make('HRUniversity.QuOrga');
 		$v->quorga = $quorga;
 		$v->user = User::getSysUser();
 		return $v ;
	}
	
	public function ViewHRPromotionHistory()
	{
		$method = Request::getMethod();
		$v = View::make('HRPromotion.PromoHistory');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
		
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
				$GetEmpID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			else
			{
				$GetEmpID = HREmployeeEPFHistory::where('EPFNo','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
			}
			
			if($userOrgType == 'HO')
			{
				if($UserTypeName == 'HR-MAPF')
				{
					$Sql = "select hrpromotion.P_ID,hremployee.NIC,
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
		   hremployee.Photograph,
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
		  hrpromotion.PSalaryStep
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join hremployeeepfhistory
		  on hremployee.id=hremployeeepfhistory.EmpId
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
		  and hremployeeepfhistory.Deleted=0
		and hremployee.Deleted=0
		  and hrpromotion.Emp_ID='".$GetEmpID."'
		  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
																				  from hruserepflist
																				  where hruserepflist.Deleted=0
																				  and hruserepflist.Active=1
																				  and hruserepflist.UserID='".User::getSysUser()->userID."')
		  order by hrpromotion.StartDate,hrpromotion.Priority";
				}
				else
				{
					$Sql = "select hrpromotion.P_ID,hremployee.NIC,
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
		   hremployee.Photograph,
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
		  hrpromotion.PSalaryStep
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
		  and hrpromotion.Emp_ID='".$GetEmpID."'
		  order by hrpromotion.StartDate,hrpromotion.Priority";
				}
			}
			else
			{
			}
			
		  $dataList = DB::select(DB::raw($Sql));
		  $v->Employeerec = HREmployee::where('id','=',$GetEmpID)->first();
		  $v->promotion = $dataList;
		  return $v;
        }
		
	}
	
	public function HEepfLoadajaxDes()
	{
        $v = Input::get('NIC');
		//$EMPID = HREmployee::where('NIC','=',$v)->orWhere('OldNIC','=',$v)->where('Deleted','=',0)->pluck('id');
		$EMPID = HREmployeeNICHistory::where('NIC','=',$v)->where('Deleted','=',0)->pluck('EmpId');
       // $EPF = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', "=", "Yes")->where('Emp_ID', "=", $EMPID)->pluck('EPF');

//        $EPF = Employee::where('Deleted', "!=", 1)->where('NIC', "=", $v)->pluck('EPFNo');
       
        $ProDesig = HRPromotion::where('Deleted','!=',1)->where('CurrentRecord','=','Yes')->where('Emp_ID', "=", $EMPID)->pluck('NewPost');
        $getNewPostName = HREmploymentCode::where('Deleted', '!=', 1)->where('id', '=', $ProDesig)->pluck('Designation');

        if ((strstr($getNewPostName, "Instructor") ? 'Yes' : 'No') === 'No') {
            $html = "error";
        }else{
            $html = "success";
        }
        echo $EMPID .'/n/'.$html;
    }
	
	 public function HEChecktransferType() {
        $abc = Input::get('NIC');
		//$EMPID = HREmployee::where('NIC','=',$abc)->orWhere('OldNIC','=',$abc)->where('Deleted','=',0)->pluck('id');
		$EMPID = HREmployeeNICHistory::where('NIC','=',$abc)->where('Deleted','=',0)->pluck('EmpId');
        $traType = Input::get('TransferType');
        $TransferTypeId = TransferType::where('Deleted', '!=', 1)->where("TransferType", "=", 'FirstAppointment')->pluck('T_ID');
        $checkTraType1 = HRPromotion::where('Emp_ID', "=", $EMPID)->where("Deleted", "!=", 1)->where("TransferType", "=", $TransferTypeId)->count('P_ID');
        if ($checkTraType1 >= 1) {
            $checkTraType = '1';
        } else {
            $checkTraType = '0';
        }

        echo $checkTraType;
    }
	
	public function HECheckTransferTypeName()
	{
        $traType = Input::get('TransferType');
        $checkTraTypeName = TransferType::where('Deleted', '!=', 1)->where('T_ID', '=', $traType)->pluck('TransferType');

        if ($checkTraTypeName !== '') {
            echo $checkTraTypeName;
        }

    }
	
	public function HEGetEPFList()
	{
		$NIC = Input::get('NIC');
		//$EMPID = HREmployee::where('NIC','=',$NIC)->orWhere('OldNIC','=',$NIC)->where('Deleted','=',0)->pluck('id');
		$EMPID = HREmployeeNICHistory::where('NIC','=',$NIC)->where('Deleted','=',0)->pluck('EmpId');
		$GetHREPFlist = HREmployeeEPFHistory::where('Deleted','=',0)->where('EmpId','=',$EMPID)->orderBy('Active')->get();
		return $GetHREPFlist;
	}
	
	public function HRpromotionExist() {
        $nic = Input::get('NIC');
       // $EMPID = HREmployee::where('NIC','=',$nic)->orWhere('OldNIC','=',$nic)->where('Deleted','=',0)->pluck('id');
	   $EMPID = HREmployeeNICHistory::where('NIC','=',$nic)->where('Deleted','=',0)->pluck('EmpId');
        $k = User::getSysUser()->instituteId;
        $ProExist = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', "=", $EMPID)->orderBy('StartDate')->get();
        $ProExistCount = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', "=", $EMPID)->count('P_ID');
        if ($ProExistCount >= 1) {
            $html = "<pre><h6><center>Assigned Promotions for NIC: <b>$nic</b></center></h6></pre>  
	           <table id='sample-table-2' class='table table-striped table-bordered table-hover'>
                    <thead>
                    <tr>
		    <th class='center'>NIC</th>
                    <th>EPF</th>							
                    <th>Effective Date</th>
                    <th>Appointment Type</th>
                    <th>Designation</th>
                  
                    <th>Organisation</th>
		   </tr>
                    </thead>
                    <tbody>";

            foreach ($ProExist as $e) {
                if ($e->CurrentRecord === 'Yes') {
                    $html .='<tr style="color: blue">
                            <td class="center"   >' . $e->NIC . '</td>
                            <td >' . $e->EPF . '</td>							
                            <td  >' . $e->StartDate . '</td>
                            <td  >' . $e->getTransferType->TransferType . '</td>
                            <td  >' . $e->getPost->Designation . '</td>
                          
                            <td>' . $e->getOrga->OrgaName . '</td>';
                } else {
                    $html .='<tr >
                            <td class="center" >' . $e->NIC . '</td>
                            <td>' . $e->EPF . '</td>							
                            <td>' . $e->StartDate . '</td>
                            <td>' . $e->getTransferType->TransferType . '</td>
                            <td  >' . $e->getPost->Designation . '</td>
                            
                            <td>' . $e->getOrga->OrgaName . '</td>';
                }
            }

            return $html;
        } else if (!empty($EMPID) && $ProExistCount < 1) {
//            $html ="<div class='control-group' style='padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px'>"
//                    . "<b>No any Promotion Assigned Yet...!</b>"
//                    . "</div>";
//            return $html;
            return '1';
        } else if (empty($EMPID) && $ProExistCount < 1) {
//            $html ="<div class='control-group' style='padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 2px solid red;width:460px'>"
//                    . "  <img src='assets/images/EmpError.jpg' width='60px' height='60px'/>  "
//                    . "<b>Mentioned EPF No Holder is not an Employee of the VTA Centers...!</b>"
//                    . "</div>";
//            return $html;
            return '2';
        }
    }
	
	public function CreateHRPromotion()
	{
        $method = Request::getMethod();
        $OrganisationID = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $OrganisationID)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        if ($userOrgType === 'HO') 
		{
            $view = View::make('HRPromotion.Create');
             
			$DVTCOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'DVTC')->pluck('OT_ID');
			$VTCOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'VTC')->pluck('OT_ID');
			$view->transfertype = TransferType::where("Deleted", "!=", 1)->orderBy('TransferType')->get();
			//$view->organisation = Organisation::where("Deleted", "!=", 1)->where('TypeId','!=',$DVTCOrgaTypeID)->where('TypeId','!=',$VTCOrgaTypeID)->orderBy('OrgaName')->get();
			$view->organisation = Organisation::where("Deleted", "!=", 1)->orderBy('OrgaName')->get();
        } 
		else if ($userOrgType === 'DO') {
            $view = View::make('Promotion.CreateDOPros');
            
        $HOOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'HO')->pluck('OT_ID');
        $DOOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'DO')->pluck('OT_ID');
        $NVTIOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'NVTI')->pluck('OT_ID');
        $userOrgDistrictCode = Organisation::where('Deleted', '!=', 1)->where('id', '=', User::getSysUser()->organisationId)->pluck('DistrictCode');
        
        $view->transfertype = TransferType::where("Deleted", "!=", 1)->where("TransferType", "=", 'Transfer')->orderBy('TransferType')->get();
        $view->organisation = Organisation::where("Deleted", "!=", 1)->where('DistrictCode','=',$userOrgDistrictCode)->where('TypeId','!=',$HOOrgaTypeID)->where('TypeId','!=',$NVTIOrgaTypeID)->where('TypeId','!=',$DOOrgaTypeID)->orderBy('OrgaName')->get();
        }
        $view->user = User::getSysUser();
        //    $OrgaType = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'DO')->pluck('OT_ID');
        $view->employmentcode = HREmploymentCode::Where("Deleted", "!=", 1)->orderBy('Designation')->get();
        $view->trade = Trade::where("Deleted", "!=", 1)->orderBy('TradeName')->get();
        $view->department = Department::where("Deleted", "!=", 1)->orderBy('DepartmentName')->get();
        $view->employeetype = EmployeeType::where("Deleted", "!=", 1)->orderBy('EmployeeType')->get();
        $InstituteID = User::getSysUser()->instituteId;
        $view->InstituteID = $InstituteID;
        $view->InstituteName = Institute::where('InstituteId', '=', $InstituteID)->pluck('InstituteName');
        $view->OrganisationID = $OrganisationID;
		$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
		$view->SCList = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
		$view->GList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();

        if ($method == "GET") {
            return $view;
        }
        if ($method == "POST") {
            $validator = HRPromotion::validate(Input::all());
            if ($validator->passes()) {
                $search = Input::get('NIC');
				//$EMPID = HREmployee::where('NIC','=',$search)->orWhere('OldNIC','=',$search)->where('Deleted','=',0)->pluck('id');
				$EMPID = HREmployeeNICHistory::where('NIC','=',$search)->where('Deleted','=',0)->pluck('EmpId');
                $pr1 = HRPromotion::where("Emp_ID", "=", $EMPID)->where('Deleted','=',0)->get();
                $sdate = Input::get('StartDate');
                $transfertype = Input::get('TransferType');
                $date = HRPromotion::where("Emp_ID", "=", $EMPID)->where('Deleted','=',0)->max('StartDate');
                if ($date < $sdate) {
                    foreach ($pr1 as $pr1) {
                        $pr1->CurrentRecord = "No";
                        $pr1->save();
                    }
                    if ($transfertype == '8') {
                        $tra_type = HRPromotion::where("Emp_ID", "=", $EMPID)->where("StartDate", "=", $date)->where('Deleted','=',0)->pluck('TransferType');
                        if ($tra_type == '8') {
                            $pr = new HRPromotion();
                            $pr->InstituteId = 1;
							$pr->OrganisationId = User::getSysUser()->organisationId;
							$pr->Emp_ID = $EMPID;
							$pr->NIC = Input::get('NIC');
							$pr->EPF = Input::get('EPF');
							$pr->StartDate = Input::get('StartDate');
							$pr->ToOrganisation = Input::get('ToOrganisation');
							$grtOTYPE = Organisation::where('id','=',Input::get('ToOrganisation'))->pluck('Type');
							if($grtOTYPE == 'HO')
							{
								$pr->ToDepartment = Input::get('ToDepartment');
							}
							
							$pr->TransferType = Input::get('TransferType');
							$TransAvailable = TransferType::where('T_ID','=',Input::get('TransferType'))->pluck('Available');
							$pr->NewPost = Input::get('NewPost');
							$pr->EmpType = Input::get('EmpType');
							
							$gradeex = HRGrade::where('id','=',Input::get('Grade'))->pluck('Grade');
							$pr->Grade = $gradeex;
							$pr->SalaryScale = Input::get('SalaryScale');
							/* if(Input::get('SCYear') >= '2016')
							{ */
								
							/* } */
							/* else{
								$pr->SalaryStep = Input::get('SalaryStepManual');
							} */
							if(!empty(Input::get('SalaryStepAuto')))
							{
								if(Input::get('SalaryStepAuto')!= '0')
								{
									$pr->SalaryStep = Input::get('SalaryStepAuto');
								}
							}
							
							
							$SalaryCodex = HRSalaryscale::where('id','=',Input::get('ServiceCategoryID'))->pluck('SalaryCode');
							$pr->SalaryCode = $SalaryCodex;
							$pr->IncrementMonth = Input::get('IncrementMonth');
							$pr->IncrementDay = Input::get('IncrementDay');
							//$MAXStartDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->max('StartDate');
							//$PrePID = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->where('StartDate','=',$MAXStartDate)->pluck('P_ID');
							$pr->SCYear = Input::get('SCYear');
							$pr->ServiceCategoryID = Input::get('ServiceCategoryID');
							$pr->GradeId = Input::get('Grade');
							$pr->Changed = 1;
                            $pr->User = User::getSysUser()->userID;
							$pr->ConfirmationDate = Input::get('ConfirmationDate');
                            $pr->CurrentRecord = 'Yes';
                            $pr->Priority = '2';
							//--- Present Salary
							$PPSalaryCodex = HRSalaryscale::where('id','=',Input::get('PServiceCategoryID'))->pluck('SalaryCode');
							$gradeexP = HRGrade::where('id','=',Input::get('PGrade'))->pluck('Grade');
							$pr->PGrade = $gradeexP;
							$pr->PSalaryScale = Input::get('PSalaryScale');
							if(!empty(Input::get('PSalaryStepAuto')))
							{
								if(Input::get('PSalaryStepAuto')!= '0')
								{
									$pr->PSalaryStep = Input::get('PSalaryStepAuto');
								}
							}
							//$pr->PSalaryStep = Input::get('PSalaryStepAuto');
							$pr->PSalaryCode = $PPSalaryCodex;
							$pr->PSCYear = Input::get('PSCYear');
							$pr->PServiceCategoryID = Input::get('PServiceCategoryID');
							$pr->PGradeId = Input::get('PGrade');
							//---
							if($TransAvailable == 0)
							{
								$pr->DateOfTermination = Input::get('StartDate');
								$pr->ETFReleasedDate = Input::get('ETFReleasedDate');
								$pr->EPFReleasedDate = Input::get('EPFReleasedDate');
								$pr->GratuityAmount = Input::get('GratuityAmount');
							}
                            $pr->save();
                        } else {
                            $abc = HRPromotion::where("Emp_ID", "=", $EMPID)->where("StartDate", "=", $date)->where('Deleted','=',0)->first();
                            $abc->CurrentRecord = "Yes";
                            $abc->save();
                            $pr = new HRPromotion();
                            $pr->InstituteId = 1;
							$pr->OrganisationId = User::getSysUser()->organisationId;
							$pr->Emp_ID = $EMPID;
							$pr->NIC = Input::get('NIC');
							$pr->EPF = Input::get('EPF');
							$pr->StartDate = Input::get('StartDate');
							$pr->ToOrganisation = Input::get('ToOrganisation');
							$grtOTYPE = Organisation::where('id','=',Input::get('ToOrganisation'))->pluck('Type');
							if($grtOTYPE == 'HO')
							{
								$pr->ToDepartment = Input::get('ToDepartment');
							}
							//$pr->ToDepartment = Input::get('ToDepartment');
							$pr->TransferType = Input::get('TransferType');
							$TransAvailable = TransferType::where('T_ID','=',Input::get('TransferType'))->pluck('Available');
							$pr->NewPost = Input::get('NewPost');
							$pr->EmpType = Input::get('EmpType');
							$pr->ConfirmationDate = Input::get('ConfirmationDate');
							$gradeex = HRGrade::where('id','=',Input::get('Grade'))->pluck('Grade');
							$pr->Grade = $gradeex;
							$pr->SalaryScale = Input::get('SalaryScale');
							/* if(Input::get('SCYear') >= '2016')
							{ */
								//$pr->SalaryStep = Input::get('SalaryStepAuto');
							/* }
							else{
								$pr->SalaryStep = Input::get('SalaryStepManual');
							} */
							if(!empty(Input::get('SalaryStepAuto')))
							{
								if(Input::get('SalaryStepAuto')!= '0')
								{
									$pr->SalaryStep = Input::get('SalaryStepAuto');
								}
							}
							$SalaryCodex = HRSalaryscale::where('id','=',Input::get('ServiceCategoryID'))->pluck('SalaryCode');
							$pr->SalaryCode = $SalaryCodex;
							$pr->IncrementMonth = Input::get('IncrementMonth');
							$pr->IncrementDay = Input::get('IncrementDay');
							//$MAXStartDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->max('StartDate');
							//$PrePID = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->where('StartDate','=',$MAXStartDate)->pluck('P_ID');
							$pr->SCYear = Input::get('SCYear');
							$pr->ServiceCategoryID = Input::get('ServiceCategoryID');
							$pr->GradeId = Input::get('Grade');
							$pr->Changed = 1;
                            $pr->User = User::getSysUser()->userID;
                            $pr->CurrentRecord = 'Yes';
                            $pr->Priority = '2';
							//--- Present Salary
							$PPSalaryCodex = HRSalaryscale::where('id','=',Input::get('PServiceCategoryID'))->pluck('SalaryCode');
							$gradeexP = HRGrade::where('id','=',Input::get('PGrade'))->pluck('Grade');
							$pr->PGrade = $gradeexP;
							$pr->PSalaryScale = Input::get('PSalaryScale');
							if(!empty(Input::get('PSalaryStepAuto')))
							{
								if(Input::get('PSalaryStepAuto')!= '0')
								{
									$pr->PSalaryStep = Input::get('PSalaryStepAuto');
								}
							}
							//$pr->PSalaryStep = Input::get('PSalaryStepAuto');
							$pr->PSalaryCode = $PPSalaryCodex;
							$pr->PSCYear = Input::get('PSCYear');
							$pr->PServiceCategoryID = Input::get('PServiceCategoryID');
							$pr->PGradeId = Input::get('PGrade');
							//---
							if($TransAvailable == 0)
							{
								$pr->DateOfTermination = Input::get('StartDate');
								$pr->ETFReleasedDate = Input::get('ETFReleasedDate');
								$pr->EPFReleasedDate = Input::get('EPFReleasedDate');
								$pr->GratuityAmount = Input::get('GratuityAmount');
							}
                            $pr->save();
                        }
                    } else {

                        $pr = new HRPromotion();
                         $pr->InstituteId = 1;
							$pr->OrganisationId = User::getSysUser()->organisationId;
							$pr->Emp_ID = $EMPID;
							$pr->NIC = Input::get('NIC');
							$pr->EPF = Input::get('EPF');
							$pr->StartDate = Input::get('StartDate');
							$pr->ToOrganisation = Input::get('ToOrganisation');
							$grtOTYPE = Organisation::where('id','=',Input::get('ToOrganisation'))->pluck('Type');
							if($grtOTYPE == 'HO')
							{
								$pr->ToDepartment = Input::get('ToDepartment');
							}
							//$pr->ToDepartment = Input::get('ToDepartment');
							$pr->TransferType = Input::get('TransferType');
							$TransAvailable = TransferType::where('T_ID','=',Input::get('TransferType'))->pluck('Available');
							$pr->NewPost = Input::get('NewPost');
							$pr->EmpType = Input::get('EmpType');
							$pr->ConfirmationDate = Input::get('ConfirmationDate');
							$gradeex = HRGrade::where('id','=',Input::get('Grade'))->pluck('Grade');
							$pr->Grade = $gradeex;
							$pr->SalaryScale = Input::get('SalaryScale');
							/* if(Input::get('SCYear') >= '2016')
							{ */
								//$pr->SalaryStep = Input::get('SalaryStepAuto');
							/* }
							else{
								$pr->SalaryStep = Input::get('SalaryStepManual');
							} */
							if(!empty(Input::get('SalaryStepAuto')))
							{
								if(Input::get('SalaryStepAuto')!= '0')
								{
									$pr->SalaryStep = Input::get('SalaryStepAuto');
								}
							}
							$SalaryCodex = HRSalaryscale::where('id','=',Input::get('ServiceCategoryID'))->pluck('SalaryCode');
							$pr->SalaryCode = $SalaryCodex;
							$pr->IncrementMonth = Input::get('IncrementMonth');
							$pr->IncrementDay = Input::get('IncrementDay');
							//$MAXStartDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->max('StartDate');
							//$PrePID = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->where('StartDate','=',$MAXStartDate)->pluck('P_ID');
							$pr->SCYear = Input::get('SCYear');
							$pr->ServiceCategoryID = Input::get('ServiceCategoryID');
							$pr->GradeId = Input::get('Grade');
							$pr->Changed = 1;
                      
                        $pr->User = User::getSysUser()->userID;
                        $pr->CurrentRecord = 'Yes';
                        $pr->Priority = '1';
						//--- Present Salary
							$PPSalaryCodex = HRSalaryscale::where('id','=',Input::get('PServiceCategoryID'))->pluck('SalaryCode');
							$gradeexP = HRGrade::where('id','=',Input::get('PGrade'))->pluck('Grade');
							$pr->PGrade = $gradeexP;
							$pr->PSalaryScale = Input::get('PSalaryScale');
							if(!empty(Input::get('PSalaryStepAuto')))
							{
								if(Input::get('PSalaryStepAuto')!= '0')
								{
									$pr->PSalaryStep = Input::get('PSalaryStepAuto');
								}
							}
							//$pr->PSalaryStep = Input::get('PSalaryStepAuto');
							$pr->PSalaryCode = $PPSalaryCodex;
							$pr->PSCYear = Input::get('PSCYear');
							$pr->PServiceCategoryID = Input::get('PServiceCategoryID');
							$pr->PGradeId = Input::get('PGrade');
							//---
						if($TransAvailable == 0)
							{
								$pr->DateOfTermination = Input::get('StartDate');
								$pr->ETFReleasedDate = Input::get('ETFReleasedDate');
								$pr->EPFReleasedDate = Input::get('EPFReleasedDate');
								$pr->GratuityAmount = Input::get('GratuityAmount');
							}
                        $pr->save();
                    }
                } else {
                    $pr = new HRPromotion();
                    //$pr->fill(Input::all());
                    //$pr->DateEntered = \Carbon\Carbon::now();
					 $pr->InstituteId = 1;
					$pr->OrganisationId = User::getSysUser()->organisationId;
					$pr->Emp_ID = $EMPID;
					$pr->NIC = Input::get('NIC');
					$pr->EPF = Input::get('EPF');
					$pr->StartDate = Input::get('StartDate');
					$pr->ToOrganisation = Input::get('ToOrganisation');
					$grtOTYPE = Organisation::where('id','=',Input::get('ToOrganisation'))->pluck('Type');
							if($grtOTYPE == 'HO')
							{
								$pr->ToDepartment = Input::get('ToDepartment');
							}
					//$pr->ToDepartment = Input::get('ToDepartment');
					$pr->TransferType = Input::get('TransferType');
					$TransAvailable = TransferType::where('T_ID','=',Input::get('TransferType'))->pluck('Available');
					$pr->NewPost = Input::get('NewPost');
					$pr->EmpType = Input::get('EmpType');
					$pr->ConfirmationDate = Input::get('ConfirmationDate');		
					$gradeex = HRGrade::where('id','=',Input::get('Grade'))->pluck('Grade');
					$pr->Grade = $gradeex;
					$pr->SalaryScale = Input::get('SalaryScale');
					/* if(Input::get('SCYear') >= '2016')
							{ */
							//	$pr->SalaryStep = Input::get('SalaryStepAuto');
							/* }
							else{
								$pr->SalaryStep = Input::get('SalaryStepManual');
							} */
							if(!empty(Input::get('SalaryStepAuto')))
							{
								if(Input::get('SalaryStepAuto')!= '0')
								{
									$pr->SalaryStep = Input::get('SalaryStepAuto');
								}
							}
					$SalaryCodex = HRSalaryscale::where('id','=',Input::get('ServiceCategoryID'))->pluck('SalaryCode');
					$pr->SalaryCode = $SalaryCodex;
					$pr->IncrementMonth = Input::get('IncrementMonth');
					$pr->IncrementDay = Input::get('IncrementDay');
					//$MAXStartDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->max('StartDate');
					//$PrePID = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->where('StartDate','=',$MAXStartDate)->pluck('P_ID');
					$pr->SCYear = Input::get('SCYear');
					$pr->ServiceCategoryID = Input::get('ServiceCategoryID');
					$pr->GradeId = Input::get('Grade');
					$pr->Changed = 1;
					//--- Present Salary
							$PPSalaryCodex = HRSalaryscale::where('id','=',Input::get('PServiceCategoryID'))->pluck('SalaryCode');
							$gradeexP = HRGrade::where('id','=',Input::get('PGrade'))->pluck('Grade');
							$pr->PGrade = $gradeexP;
							$pr->PSalaryScale = Input::get('PSalaryScale');
							if(!empty(Input::get('PSalaryStepAuto')))
							{
								if(Input::get('PSalaryStepAuto')!= '0')
								{
									$pr->PSalaryStep = Input::get('PSalaryStepAuto');
								}
							}
							//$pr->PSalaryStep = Input::get('PSalaryStepAuto');
							$pr->PSalaryCode = $PPSalaryCodex;
							$pr->PSCYear = Input::get('PSCYear');
							$pr->PServiceCategoryID = Input::get('PServiceCategoryID');
							$pr->PGradeId = Input::get('PGrade');
							//---
					if($TransAvailable == 0)
							{
								$pr->DateOfTermination = Input::get('StartDate');
								$pr->ETFReleasedDate = Input::get('ETFReleasedDate');
								$pr->EPFReleasedDate = Input::get('EPFReleasedDate');
								$pr->GratuityAmount = Input::get('GratuityAmount');
							}
                    $pr->User = User::getSysUser()->userID;
                    $pr->CurrentRecord = 'No';
                    if ($transfertype !== '8') {
                        $pr->Priority = '1';
                    } else {
                        $pr->Priority = '2';
                    }
                    $pr->save();
                }//ok
                $count = HRPromotion::where('Deleted', "!=", 1)->where("Emp_ID", "=", $EMPID)->count('P_ID');
                $cc1 = HRPromotion::where('Deleted', "!=", 1)->where("Emp_ID", "=", $EMPID)->orderBy('StartDate', 'desc')->take($count - 1)->orderBy('StartDate', 'ASC')->get();
                if (!empty($cc1)) {
                    foreach ($cc1 as $cc1) {
                        $cc2 = HRPromotion::where('Deleted', "!=", 1)->where("Emp_ID", "=", $EMPID)->orderBy('StartDate')->get();
                        foreach ($cc2 as $cc2) {
                            if ($cc1->P_ID === $cc2->P_ID) {
                                $cc3 = $cc2->StartDate;
                                $cc4 = HRPromotion::where('Deleted', "!=", 1)->where("Emp_ID", "=", $EMPID)->where('StartDate', '<', $cc3)->orderBy('StartDate', 'desc')->first();
                                if (!empty($cc4)) {
                                    $cc1->Pre_P_ID = $cc4->P_ID;
                                    $cc1->save();
                                }
                            }
                        }
                    }
                }
                //ok
               // $getUserEmpId = HRPromotion::where('Deleted', '!=', 1)->where("Emp_ID", "=", $EMPID)->Where('CurrentRecord', '=', 'Yes')->OrderBy('StartDate', 'DESC')->take(1)->pluck('Emp_ID');
                
                //$FindEmpId = HREmployee::where('id', '=', $EMPID)->pluck('id');
              
                    $updateEmpOrgId = HREmployee::find($EMPID);
                    $updateEmpOrgId->OrgId = Input::get('ToOrganisation');
                    $updateEmpOrgId->save();
                

                //$EmployeeID = Input::get('Emp_ID');
//                $usercontroller = new UserController();
//                $usercontroller->deactivateUser($EmployeeID);

                return Redirect::to('CreateHRPromotion')->with("done", true);
            } else {
                return Redirect::to('CreateHRPromotion')->withErrors($validator);
            }
        }
    }
	
	
	public function DeleteHRPromotion()
	{
        $pid = Input::get('pid');
        $promotion = HRPromotion::findOrFail($pid);
        $promotion->Deleted = 1;
        $promotion->Changed = 1;
        $promotion->CurrentRecord = "No";
        $promotion->User = User::getSysUser()->userID;
        $promotion->save();
		//ok

        $userOrgId = User::getSysUser()->organisationId;
        $promotion->userOrgId = $userOrgId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $promotion->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $getNIC = HRPromotion::where('P_ID', '=', $pid)->pluck('Emp_ID');

        $proTraType = HRPromotion::where('P_ID', '=', $pid)->pluck('TransferType');
        if ($proTraType !== "8") {
            $getPreviousPID = HRPromotion::where('Deleted', "!=", 1)->where('Pre_P_ID', '=', $pid)->pluck('P_ID');
            if (!empty($getPreviousPID)) {
                $checkTraType = HRPromotion::where('P_ID', '=', $getPreviousPID)->pluck('TransferType');
                if ($checkTraType === '8') {
                    $getPreviousPro = HRPromotion::findOrFail($getPreviousPID);
                    $getPreviousPro->Deleted = 1;
                    $getPreviousPro->CurrentRecord = "No";
                    $getPreviousPro->save();
                }
            }
            $proCount = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $getNIC)->count('P_ID');
            if ($proCount > 0) {
                $currentPre_PID = HRPromotion::where('P_ID', '=', $pid)->pluck('Pre_P_ID');
                if ($currentPre_PID !== '0') {
                    $getCurrentPro = HRPromotion::findOrFail($currentPre_PID);
                    $getCurrentPro->Deleted = 0;
                    $getCurrentPro->CurrentRecord = "Yes";
                    $getCurrentPro->save();
                }
                $currentPreviousTraType = HRPromotion::where('P_ID', '=', $currentPre_PID)->pluck('TransferType');
                if ($currentPreviousTraType === '8') {
                    $getCurrentPro2 = HRPromotion::where('P_ID', '=', $currentPre_PID)->pluck('Pre_P_ID');
                    $getCurrentPro3 = HRPromotion::findOrFail($getCurrentPro2);
                    $getCurrentPro3->Deleted = 0;
                    $getCurrentPro3->CurrentRecord = "Yes";
                    $getCurrentPro3->save();
                }
            }
        }

        $setPrePid = HRPromotion::where('Emp_ID', '=', $getNIC)->get();
        foreach ($setPrePid as $setPrePid) {
            $setPrePid->Pre_P_ID = 0;
            $setPrePid->save();
        }
        $count = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $getNIC)->count('P_ID');
        $cc1 = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $getNIC)->orderBy('StartDate', 'desc')->take($count - 1)->orderBy('StartDate', 'ASC')->get();
        if (!empty($cc1)) {
            foreach ($cc1 as $cc1) {
                $cc2 = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $getNIC)->orderBy('StartDate')->get();
                foreach ($cc2 as $cc2) {
                    if ($cc1->P_ID === $cc2->P_ID) {
                        $cc3 = $cc2->StartDate;
                        $cc4 = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $getNIC)->where('StartDate', '<', $cc3)->orderBy('StartDate', 'desc')->first();
                        if (!empty($cc4)) {
                            $cc1->Pre_P_ID = $cc4->P_ID;
                            $cc1->save();
                        }
                    }
                }
            }
        }
        return Redirect::to('ViewHRPromotion');
    }
	 public function ViewHRPromotion() {
		 
        $v = View::make('HRPromotion.Promo');
        $userOrgId = User::getSysUser()->organisationId;
        $userOrgTypeId = Organisation::where('id', "=", $userOrgId)->pluck('TypeId');
        $userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
		$userTypeID = User::getSysUser()->userType;
		$UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
        if ($userOrgType === 'HO') {
			
			if($UserTypeName == 'HR-MAPF')
			{
				$promotion = "select Distinct hrpromotion.P_ID,hremployee.NIC,
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
		  hrpromotion.PSalaryStep
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join hremployeeepfhistory
          on hremployee.id=hremployeeepfhistory.EmpId
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
		  and hremployeeepfhistory.Deleted=0
		  and hremployee.Deleted=0
		  and hremployeeepfhistory.EPFNo IN (select hruserepflist.EPFNo
                                      from hruserepflist
                                      where hruserepflist.Deleted=0
                                      and hruserepflist.Active=1
                                      and hruserepflist.UserID='".User::getSysUser()->userID."')
		  order by hremploymentcode.Designation,transfertype.Available";
			}
			else
			{
				$promotion = "select Distinct hrpromotion.P_ID,hremployee.NIC,
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
		  hrpromotion.PSalaryStep
		  from hrpromotion
		  left join hremployee
		  on hrpromotion.Emp_ID=hremployee.id
		  left join hremployeeepfhistory
          on hremployee.id=hremployeeepfhistory.EmpId
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
		  and hremployeeepfhistory.Deleted=0
		  and hremployee.Deleted=0
		  order by hremploymentcode.Designation,transfertype.Available";
			}
            
        } else if($userOrgType === 'DO'){
            
            $HOOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'HO')->pluck('OT_ID');
            $NVTIOrgaTypeID = OrganisationType::where('Deleted', '!=', 1)->where('Type', '=', 'NVTI')->pluck('OT_ID');
            $userOrgDistrictCode = Organisation::where('Deleted', '!=', 1)->where('id', '=', User::getSysUser()->organisationId)->pluck('DistrictCode');
            $ValidOrganisationID = Organisation::where("Deleted", "!=", 1)->where('DistrictCode','=',$userOrgDistrictCode)->where('TypeId','!=',$HOOrgaTypeID)->where('TypeId','!=',$NVTIOrgaTypeID)->lists('id');
        
            $promotion = "select Distinct hrpromotion.P_ID,hremployee.NIC,
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
		  hrpromotion.PSalaryStep
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
  and hrpromotion.CurrentRecord='Yes'
  and district.DistrictCode='".$userOrgDistrictCode."'
  and organisation.Type Not In('NVTI')
 order by hremploymentcode.Designation,transfertype.Available";
        }else{
             $promotion = "select Distinct hrpromotion.P_ID,hremployee.NIC,
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
		  hrpromotion.PSalaryStep
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
  and hrpromotion.CurrentRecord='Yes'
  and organisation.id='".$userOrgId."'
  order by hremploymentcode.Designation,transfertype.Available";
        
        }
		$DataList = DB::select(DB::raw($promotion));
        $v->userOrgId = $userOrgId;
        $v->userOrgType = OrganisationType::where('OT_ID', '=', $userOrgTypeId)->pluck('Type');
        $v->user = User::getSysUser();
        $v->promotion = $DataList;

        return $v;
    }
	public function get_employee_category(){
        $v = Input::get('emp_code_id');
        $EMP_code = "";

//        $EPF = Employee::where('Deleted', "!=", 1)->where('NIC', "=", $v)->pluck('EPFNo');
//        $ID = Employee::where('Deleted', "!=", 1)->where('NIC', "=", $v)->pluck('id');
//        $ProDesig = Promotion::where('Deleted','!=',1)->where('CurrentRecord','=','Yes')->where('NIC','=',$v)->pluck('NewPost');
//        $getNewPostName = EmploymentCode::where('Deleted', '!=', 1)->where('id', '=', $ProDesig)->pluck('Designation');


        if (!empty($EMP_code)) {
            return $EMP_code;
        }else{
            return "";
        }


    }
	public function EditHRPromotion() {

        $view = View::make('HRPromotion.Edit');
        $method = Request::getMethod();
        if ($method == "GET") {
            $promotion = HRPromotion::where('P_ID', "=", Input::get('id'))->first();
            $view->user = User::getSysUser();
            $view->promotion = $promotion;
            $view->promotion11 = $promotion->ToOrganisation;
            $view->organisation = Organisation::where("Deleted", "!=", 1)->orderBy('OrgaName')->get();
            $view->employmentcode = HREmploymentCode::where("Deleted", "!=", 1)->where('Active','=',1)->orderBy('Designation')->get();
            $view->trade = Trade::where("Deleted", "!=", 1)->orderBy('TradeName')->get();
            $view->department = Department::where("Deleted", "!=", 1)->orderBy('DepartmentName')->get();
            $view->transfertype = TransferType::where("Deleted", "!=", 1)->orderBy('TransferType')->get();
            $view->employeetype = EmployeeType::where("Deleted", "!=", 1)->orderBy('EmployeeType')->get();
            $InstituteID = User::getSysUser()->instituteId;
            $view->InstituteID = $InstituteID;
            $view->InstituteName = Institute::where('InstituteId', '=', $InstituteID)->pluck('InstituteName');
			$view->SCYears = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
			$view->SCList = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
			$view->GList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
			$view->salarystaptrans = HRSalaryStepTrans::where('Deleted','=',0)->where('SalaryScaleID','=',$promotion->ServiceCategoryID)->orderBy('StepNo')->get();
			$view->Psalarystaptrans = HRSalaryStepTrans::where('Deleted','=',0)->where('SalaryScaleID','=',$promotion->PServiceCategoryID)->orderBy('StepNo')->get();
			$view->GetHREPFlist = HREmployeeEPFHistory::where('Deleted','=',0)->where('EmpId','=',$promotion->Emp_ID)->orderBy('Active')->get();
			

            return $view;
        }
        if ($method == "POST") {
            $validator = HRPromotion::validate(Input::all());
            if ($validator->passes()) {
                $array = Input::all();

                $p = HRPromotion::find($array['P_ID']);
                $p->InstituteId = 1;
				$p->OrganisationId = User::getSysUser()->organisationId;
				$p->Emp_ID = Input::get('Emp_ID');
				$p->NIC = Input::get('NIC');
				$p->EPF = Input::get('EPF');
				$p->StartDate = Input::get('StartDate');
				$p->ToOrganisation = Input::get('ToOrganisation');
				$grtOTYPE = Organisation::where('id','=',Input::get('ToOrganisation'))->pluck('Type');
				if($grtOTYPE == 'HO')
				{
					$p->ToDepartment = Input::get('ToDepartment');
				}
				//$p->ToDepartment = Input::get('ToDepartment');
				$p->TransferType = Input::get('TransferType');
				$TransAvailable = TransferType::where('T_ID','=',Input::get('TransferType'))->pluck('Available');
				$p->NewPost = Input::get('NewPost');
				$p->EmpType = Input::get('EmpType');
				//$p->CurrentRecord = 'Yes';
				//$p->Priority = 1;
				
				$p->ConfirmationDate = Input::get('ConfirmationDate');
				if($TransAvailable == 0)
							{
								$pr->DateOfTermination = Input::get('StartDate');
								$pr->ETFReleasedDate = Input::get('ETFReleasedDate');
								$pr->EPFReleasedDate = Input::get('EPFReleasedDate');
								$pr->GratuityAmount = Input::get('GratuityAmount');
							}
				$gradeex = HRGrade::where('id','=',Input::get('Grade'))->pluck('Grade');
				$p->Grade = $gradeex;
				$p->SalaryScale = Input::get('SalaryScale');
				/* if(Input::get('SCYear') >= '2016')
							{ */
								//$p->SalaryStep = Input::get('SalaryStepAuto');
							/* }
							else{
								$p->SalaryStep = Input::get('SalaryStepManual');
							} */
							if(!empty(Input::get('SalaryStepAuto')))
							{
								if(Input::get('SalaryStepAuto')!= '0')
								{
									$p->SalaryStep = Input::get('SalaryStepAuto');
								}
							}
				$SalaryCodex = HRSalaryscale::where('id','=',Input::get('ServiceCategoryID'))->pluck('SalaryCode');
				$p->SalaryCode = $SalaryCodex;
				$p->IncrementMonth = Input::get('IncrementMonth');
				$p->IncrementDay = Input::get('IncrementDay');
				$MAXStartDate = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->max('StartDate');
				$PrePID = HRPromotion::where('Deleted','=',0)->where('Emp_ID','=',Input::get('Emp_ID'))->where('StartDate','=',$MAXStartDate)->pluck('P_ID');
				//$p->Pre_P_ID = $PrePID;
				$p->User = User::getSysUser()->userID;
				$p->SCYear = Input::get('SCYear');
				$p->ServiceCategoryID = Input::get('ServiceCategoryID');
				$p->GradeId = Input::get('Grade');
				$p->Changed = 1;
				//--- Present Salary
							$PPSalaryCodex = HRSalaryscale::where('id','=',Input::get('PServiceCategoryID'))->pluck('SalaryCode');
							$gradeexP = HRGrade::where('id','=',Input::get('PGrade'))->pluck('Grade');
							$p->PGrade = $gradeexP;
							$p->PSalaryScale = Input::get('PSalaryScale');
							if(!empty(Input::get('PSalaryStepAuto')))
							{
								if(Input::get('PSalaryStepAuto')!= '0')
								{
									$p->PSalaryStep = Input::get('PSalaryStepAuto');
								}
							}
							//$p->PSalaryStep = Input::get('PSalaryStepAuto');
							$p->PSalaryCode = $PPSalaryCodex;
							$p->PSCYear = Input::get('PSCYear');
							$p->PServiceCategoryID = Input::get('PServiceCategoryID');
							$p->PGradeId = Input::get('PGrade');
							//---
                if ($p->save()) {
                    $search = HRPromotion::where('P_ID', '=', $array['P_ID'])->pluck('Emp_ID');
                    $EditP1 = HRPromotion::where('Emp_ID', '=', $search)->where('Deleted', '!=', 1)->get();
                    foreach ($EditP1 as $EditP1) {
                        if ($EditP1->TransferType === '8') {
                            $EditP1->Priority = '2';
                        } else {
                            $EditP1->Priority = '1';
                        }
                        $EditP1->CurrentRecord = 'No';
                        $EditP1->save();
                    }//ok
                    $EditP2 = HRPromotion::where('Emp_ID', '=', $search)->where('Deleted', '!=', 1)->where('TransferType', '!=', 8)->max('StartDate');
                    $EditP3 = HRPromotion::where('Emp_ID', '=', $search)->where('Deleted', '!=', 1)->where('TransferType', '!=', 8)->where('StartDate', "=", $EditP2)->get();
                    if (!empty($EditP3)) {
                        foreach ($EditP3 as $EditP3) {
                            $EditP3->CurrentRecord = 'Yes';
                            $EditP3->save();
                        }
                    }//ok
                    $EditP4 = HRPromotion::where('Emp_ID', '=', $search)->where('Deleted', '!=', 1)->where('TransferType', '=', 8)->where('StartDate', ">", $EditP2)->get();
                    if (!empty($EditP4)) {
                        foreach ($EditP4 as $EditP4) {
                            $EditP4->CurrentRecord = 'Yes';
                            $EditP4->save();
                        }
                    }//ok
                    $count = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $search)->count('P_ID');
                    $cc1 = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $search)->orderBy('StartDate', 'desc')->take($count - 1)->orderBy('StartDate', 'ASC')->get();
                    if (!empty($cc1)) {
                        foreach ($cc1 as $cc1) {
                            $cc2 = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $search)->orderBy('StartDate')->get();
                            foreach ($cc2 as $cc2) {
                                if ($cc1->P_ID === $cc2->P_ID) {
                                    $cc3 = $cc2->StartDate;
                                    $cc4 = HRPromotion::where('Deleted', "!=", 1)->where('Emp_ID', '=', $search)->where('StartDate', '<', $cc3)->orderBy('StartDate', 'desc')->first();
                                    if (!empty($cc4)) {
                                        $cc1->Pre_P_ID = $cc4->P_ID;
                                        $cc1->save();
                                    }
                                }
                            }
                        }
                    }//ok
                    $getUserEmpId = HRPromotion::where('Deleted', '!=', 1)->where('Emp_ID', '=', $search)->Where('CurrentRecord', '=', 'Yes')->where('Priority','=',1)->OrderBy('StartDate', 'DESC')->take(1)->pluck('Emp_ID');
                    $FindUserId = User::where('EmpId', '=', $getUserEmpId)->pluck('userID');
                    /* if (!empty($FindUserId)) {
                        $updateUserOrgId = User::find($FindUserId);
                        $updateUserOrgId->organisationId = Input::get('ToOrganisation');
                        $updateUserOrgId->save();
                    } */
                    $FindEmpId = HREmployee::where('id', '=', $getUserEmpId)->pluck('id');
                    if (!empty($FindEmpId)) {
                        $updateEmpOrgId = HREmployee::find($FindEmpId);
                        $updateEmpOrgId->OrgId = Input::get('ToOrganisation');
                        $updateEmpOrgId->save();
                    }//still ok

                   // $EPFChangePromotion = HRPromotion::where('Deleted', '!=', 1)->where('Emp_ID', '=', $search)->get();
                   /*  if (!empty($EPFChangePromotion)) {
                        foreach ($EPFChangePromotion as $EPFChangePromotion) {
                            $EPFChangePromotion->EPF = Input::get('EPF');
                            $EPFChangePromotion->save();
                        }
                    } */
                   // $EPFChangeEmployee = HREmployee::where('Deleted', '!=', 1)->where('Emp_ID', '=', $search)->get();
                   /*  if (!empty($EPFChangeEmployee)) {
                        foreach ($EPFChangeEmployee as $EPFChangeEmployee) {
                            $EPFChangeEmployee->EPFNo = Input::get('EPF');
                            $EPFChangeEmployee->save();
                        }
                    } */
                   /*  $checkPromotionHistory = HRPromotion::where('Deleted', "!=", 1)->where('CurrentRecord', "=", 'Yes')->where('EPF', '=', Input::get('EPF'))->count('P_ID');
                    $checkEPFHistory = EPFHistory::where('EPF', '=', Input::get('EPF'))->count('id');
                    if ($checkEPFHistory !== 1 && $checkPromotionHistory > 0) {
                        $EPFHistory = new EPFHistory();
                        $EPFHistory->EPF = Input::get('EPF');
                        $EPFHistory->NIC = Input::get('NIC');
                        $EPFHistory->FromDate = date('y-m-d');
                        $EPFHistory->save();
                    } */
                    //$this->Inchrage(Input::get('id'));
                   /*  $EmployeeID = Input::get('Emp_ID');
                    $usercontroller = new UserController();
                    $usercontroller->deactivateUser($EmployeeID); */
                    return Redirect::to('ViewHRPromotion');
                }
				//hremployeesalarytep Data Editing
			
            } else {
                return Redirect::to('EditHRPromotion?id=' . Input::get('P_ID'))->withErrors($validator);
            }
        }
    }


}


