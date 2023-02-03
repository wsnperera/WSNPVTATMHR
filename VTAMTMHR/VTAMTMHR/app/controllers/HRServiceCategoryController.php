<?php

class HRServiceCategoryController extends BaseController {
	
	public function PrintHrServiceCategorySalaryConversion()
	{
		$year = Input::get('YearP');
		$html = '';
		$cc = DB::select(DB::raw("select hrsalaryconversionincrement.id,
		  hrsalaryscale.Year,
		  hrsalaryscale.ServiceCategory,
		  hrsalaryscale.SalaryCode,
		  hrgrade.Grade,
		  hrsalaryconversionincrement.SalaryConversionDate,
		  hrsalarysteptrans.StepNo,
		  hrsalaryconversionincrement.BasicSalary,
		  hrsalaryconversionincrement.AdjusmentAllowence,
		  hrsalaryconversionincrement.Active,
		  hrsalaryconversionincrement.GrossSalary
		  from hrsalaryconversionincrement
		  left join hrsalaryscale
		  on hrsalaryconversionincrement.ServiceCategoryID=hrsalaryscale.id
		  left join hrgrade
		  on hrsalaryconversionincrement.GradeId=hrgrade.id
		  left join hrsalarysteptrans
		  on hrsalaryconversionincrement.StepTransID=hrsalarysteptrans.id
		  where hrsalaryconversionincrement.Deleted=0
		  and hrsalaryconversionincrement.SCYear='".$year."'
		  order by hrsalaryscale.BasicSalary,hrsalaryconversionincrement.SalaryConversionDate,hrsalarysteptrans.StepNo"));
		$i=1;
		$html='<html><head>
   
    </head>
    <body>
   
    <center><h3><b>Salary Converions For - '.$year.'</center></h3></b>
	<font size="5px" face="Times New Roman" >
	<table style = "font-size:14px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">Year</th>
<th align="left">Service Category</th>
<th align="left">Salary Code</th>
<th align="left">Grade</th>
<th align="left">Conversion Date</th>
<th align="left">Step No</th>
<th align="left">Basic Salary</th>
<th align="left">Gross Salary</th>
<th align="left">Allowence</th>
<th align="center">Active Status</th>

</thead><tbody>';
 foreach ($cc as $aa) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->ServiceCategory.'</td>
          <td>'.$aa->SalaryCode.'</td>
          <td>'.$aa->Grade.'</td>
		   <td>'.$aa->SalaryConversionDate.'</td>
		    <td>'.$aa->StepNo.'</td>
			 <td>'.$aa->BasicSalary.'</td>
			  <td>'.$aa->GrossSalary.'</td>
			  <td>'.$aa->AdjusmentAllowence.'</td>';
		  if($aa->Active == 1)
		  {
			  $html.='<td>Yes</td>';
		  }
		  else
		  {
			   $html.='<td>No</td>';
		  }
          
          $html.='</tr>'; 
          

          
  }
   
$html.='</tbody></table></font></body></html>';

    return $html;
	}
	
	public function DeleteHrServiceCategorySalaryConversion()
	{
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$update = HRSalaryConversionIncrement::where('id','=',$id)->update(array('Deleted' => 1,'User' => $user));
		return Redirect::to('ViewHrServiceCategorySalaryConversion');
	}
	
	public function EditHrServiceCategorySalaryConversion()
	{
		
		$QId = Input::get('id');
		$method = Request::getMethod();
		 $cc = HRSalaryConversionIncrement::where('id','=',$QId)->first();
		
		$view = View::make('HRServiceCategorySalaryConversion.Edit')->with('user', User::getSysUser());
		$view->gradesList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		$view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
		$view->SCList = HRSalaryscale::where('Deleted','=',0)->where('Year','=',$cc->SCYear)->orderBy('BasicSalary')->get();
		$view->GList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		$view->SalStep = HRSalaryStepTrans::where('SalaryScaleID','=',$cc->ServiceCategoryID)->where('Deleted','=',0)->orderBy('StepNo')->get();
		$view->cc = $cc;
		
		$view->QID = $QId;
		if ($method == "GET") 
		{
			return $view;
		}
		 if ($method == "POST") 
		{
			$id = Input::get('id');
			$user = User::getSysUser()->userID;
			$SCYear = Input::get('SCYear');
			$ServiceCategoryID = Input::get('ServiceCategoryID');
			$GradeID = Input::get('Grade');
			$SalaryStepAutoID = Input::get('SalaryStepAuto');
			$SalaryConversionDate = Input::get('SalaryConversionDate');
			$BasicSalary = Input::get('BasicSalary');
			$Allowence = Input::get('Allowence');
			$GrossSalary = Input::get('GrossSalary');
			
			$Active = Input::get('Active');
		
		$Update = HRSalaryConversionIncrement::where('id','=',$id)->update(array('ServiceCategoryID' => $ServiceCategoryID,'GradeId' => $GradeID,'StepTransID' => $SalaryStepAutoID,'SalaryConversionDate' => $SalaryConversionDate,'BasicSalary' => $BasicSalary,'AdjusmentAllowence' =>$Allowence,'Active' => $Active,
		'SCYear' => $SCYear,'User' =>$user,'GrossSalary' => $GrossSalary));
			return Redirect::to('ViewHrServiceCategorySalaryConversion');
		}
	}
	
	public function SearchHrServiceCategorySalaryConversion()
	{
		$year = Input::get('Year');
		$view = View::make('HRServiceCategorySalaryConversion.View');
	    $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $SalaryScales = DB::select(DB::raw("select hrsalaryconversionincrement.id,
  hrsalaryscale.Year,
  hrsalaryscale.ServiceCategory,
  hrsalaryscale.SalaryCode,
  hrgrade.Grade,
  hrsalaryconversionincrement.SalaryConversionDate,
  hrsalarysteptrans.StepNo,
  hrsalaryconversionincrement.BasicSalary,
  hrsalaryconversionincrement.AdjusmentAllowence,
  hrsalaryconversionincrement.Active,
  hrsalaryconversionincrement.GrossSalary
  from hrsalaryconversionincrement
  left join hrsalaryscale
  on hrsalaryconversionincrement.ServiceCategoryID=hrsalaryscale.id
  left join hrgrade
  on hrsalaryconversionincrement.GradeId=hrgrade.id
  left join hrsalarysteptrans
  on hrsalaryconversionincrement.StepTransID=hrsalarysteptrans.id
  where hrsalaryconversionincrement.Deleted=0
  and hrsalaryconversionincrement.SCYear='".$year."'
  order by hrsalaryscale.BasicSalary,hrsalaryconversionincrement.SalaryConversionDate,hrsalarysteptrans.StepNo"));
	  $view->SalaryScales = $SalaryScales;
	  $view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
	 // $view->CheckedGrade = HRSalaryScaleGrade::where('Deleted','=',0)->where('ServiceCategoryID','=',$QId)->where('Active','=',1)->orderBy('GradeID')->get();
	  $view->YearP = $year;
      return $view;
     }
		
	}
	
	public function ServiceCategorySalaryConversionSaveAll()
{
	      $Year = Input::get('Year');
          $ServiceCategoryID = Input::get('ServiceCategory');
          $GradeID = Input::get('Grade');
          $SalaryStepAutoID = Input::get('SalaryStepAuto');
          $Active = Input::get('Active');
		  $BasicSalary = Input::get('BasicSalary');
		  $SalaryConversionDate  = Input::get('SalaryConversionDate');
		  $Allowence  = Input::get('Allowence');
		  $user = User::getSysUser()->userID;
		  $GrossSalary = Input::get('GrossSalary');
		  
		  $availbale = HRSalaryConversionIncrement::where('Deleted','=',0)
		 ->where('ServiceCategoryID','=',$ServiceCategoryID)
		 ->where('GradeId','=',$GradeID)
		 ->where('StepTransID','=',$SalaryStepAutoID)
		 ->where('SalaryConversionDate','=',$SalaryConversionDate)
		 ->where('Active','=',1)
		 ->get();
		 
         if(count($availbale) == 0)
		 {
			  $c = new HRSalaryConversionIncrement();
			  $c->ServiceCategoryID = $ServiceCategoryID;
			  $c->GradeId = $GradeID;
			  $c->StepTransID = $SalaryStepAutoID;
			  $c->SalaryConversionDate = $SalaryConversionDate;
			  $c->BasicSalary = $BasicSalary;
			  $c->AdjusmentAllowence = $Allowence;
			  $c->Active = $Active;
			  $c->GrossSalary = $GrossSalary;
			  $c->SCYear = $Year;
			  $c->User = $user;
			  $c->save();
			$html = '<font color="blue"><b>Record Added Succsessfully!!!</b></font>'; 
		 }
		
		 else{
			 $html = '<font color="red"><b>Entered Record Already Exist in Active Status...!!!.If You Wanna to Change Please Use Edit Option...!!!</b></font>';
		 }
          
	  $json = array("done" => $html);
            return json_encode($json, 0);
}
	
	public function CreateHrServiceCategorySalaryConversion()
	{
		$method = Request::getMethod();
        $view = View::make('HRServiceCategorySalaryConversion.Create')->with('user', User::getSysUser());
		
		$view->gradesList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		$view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
		$view->SCList = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
		$view->GList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
        		
		if ($method == "GET") 
		{
            return $view;
        }
	}
	
	public function ViewHrServiceCategorySalaryConversion()
	{
	
     $view = View::make('HRServiceCategorySalaryConversion.View');
	 $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  //$SalaryScales = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
	  //$view->SalaryScales = $SalaryScales;
	  $view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
      return $view;
     }
	}
	
	public function extrastepsload()
	{
		//Enter Extra steptrans 20
		 $HRSalaryscale = HRSalaryscale::where('Deleted','=',0)->where('Active','=',1)->where('Year','=','2016-2')->orderBy('Year')->get();
		 
		 foreach($HRSalaryscale as $hs)
		 {
			$Ext10 = 1; 
		  $getHeighestStepID = HRSalaryStep::where('SalaryScaleID','=',$hs->id)->where('Deleted','=',0)->max('id');
		  $getHeighestStepNo = HRSalaryStepTrans::where('SalaryScaleID','=',$hs->id)->where('Deleted','=',0)->max('StepNo');
		  $getHeighestStepAmount = HRSalaryStepTrans::where('SalaryScaleID','=',$hs->id)->where('Deleted','=',0)->where('StepNo','=',$getHeighestStepNo)->pluck('StepAmount');
		  $getHeighestStepNo = $getHeighestStepNo+1;
		  for($Ext10=1;$Ext10<=20;$Ext10++)
		  {
			      $cc = new HRSalaryStepTrans();
				  $cc->SalaryStepID = $getHeighestStepID;
				  $cc->SalaryScaleID = $hs->id;
				  $cc->StepNo = $getHeighestStepNo;
				  $cc->StepAmount = $getHeighestStepAmount;
				  $cc->EBAvailable = 0;
				  $cc->User = User::getSysUser()->userID;
				  $cc->save();
				  $getHeighestStepNo = $getHeighestStepNo+1;
		  }
			 
		 }
		  
		  
		 return 'loaded successfully'; 
		  //Enter Extra steptrans 20
	}
	
	public function LoadAjaxServiceCategorySteps()
{
	$ServicecategoryID = Input::get('ServicecategoryID');
	$Year = Input::get('year');
  
			$sql = "select *
  from hrsalarysteptrans
  where hrsalarysteptrans.Deleted=0
  and hrsalarysteptrans.SalaryScaleID='".$ServicecategoryID."'
  order by hrsalarysteptrans.StepNo";
    $Data = DB::select(DB::raw($sql));
    return $Data;
}
	
	public function getSalaryScaleValue()
	{
		$SCID = Input::get('SCYear');
  
		$salaryScale = HRSalaryscale::where('id','=',$SCID)->pluck('SalaryScale');
       // $Data = DB::select(DB::raw($sql));
       // return $salaryScale;
		$json = array("done" => $salaryScale);
            return json_encode($json, 0); 
	}
	
	public function DeleteOfficeTimes()
	{
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$UpdateDelete = HROfficeTime::where('id','=',$id)->update(array('Deleted' => 1,'User' =>$user));
		
		return Redirect::to('ViewOfficeTimes');
	}
	
	public function EditOfficeTimes()
		{
		
		$QId = Input::get('id');
		$method = Request::getMethod();
		$view = View::make('HROfficeTime.Edit')->with('user', User::getSysUser());
		
		$view->QID = $QId;
		$cc = HROfficeTime::where('id','=',$QId)->get();
		$view->cc = $cc;
		if ($method == "GET") 
		{
			return $view;
		}
		 if ($method == "POST") 
		{
			$id = Input::get('id');
			$ArrivalTime = Input::get('ArrivalTime');
		    $Departute = Input::get('Departute');
		    $DesignationActive = Input::get('DesignationActive');
			
			$update = HROfficeTime::where('id','=',$id)->update(array('ArrivalTime' => $ArrivalTime,'Departute' => $Departute, 'Active' => $DesignationActive));
			return Redirect::to('ViewOfficeTimes');
		}
	}
	
	public function SaveAjaxtOfficeTimes()
	{
		$ArrivalTime = Input::get('ArrivalTime');
		$Departute = Input::get('Departute');
		$DesignationActive = Input::get('DesignationActive');
		
	
		$user = User::getSysUser()->userID;
		$available = HROfficeTime::where('ArrivalTime','=',$ArrivalTime)->where('Departute','=',$Departute)->where('Active','=',$DesignationActive)->where('Deleted','=',0)->get();
		if(count($available) == 0)
		{
			$c = new HROfficeTime;
			$c->ArrivalTime = $ArrivalTime;
			$c->Departute = $Departute;
			$c->Active = $DesignationActive;	
			$c->User = $user;
			$c->save();
		}
		
		 $getAllDesig = 1;
		return json_encode($getAllDesig);
	}
	
	public function CreateOfficeTimes()
	{
		$method = Request::getMethod();
        $view = View::make('HROfficeTime.Create')->with('user', User::getSysUser());
		
		if ($method == "GET") {
            return $view;
        }
	}
	
	public function ViewOfficeTimes()
	{
	
     $view = View::make('HROfficeTime.View');
	 $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $SalaryScales = HROfficeTime::where('Deleted','=',0)->get();
	  $view->SalaryScales = $SalaryScales;
      return $view;
     }
	}
	
	public function PrintCardreDetails()
	{
		//$year = Input::get('YearP');
		$html = '';
		$cc = DB::select(DB::raw("select hremploymentcode.*,hrofficetime.ArrivalTime,hrofficetime.Departute
		  from hremploymentcode
		  left join hrofficetime
		  on hremploymentcode.HROfficeTimeID=hrofficetime.id
		  where hremploymentcode.Deleted=0
		  order by hremploymentcode.Designation
		"));
		$i=1;
		$html='<html><head>
   
    </head>
    <body>
   
    <center><h3><b>Cardre Details</center></h3></b>
	<font size="5px" face="Times New Roman" >
	<table style = "font-size:14px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">Designation</th>
<th align="left">Designation Code</th>
<th align="left">Maximum no of Positions</th>
<th align="left">Academic Status</th>
<th align="left">Working Hours</th>
<th align="center">Active Status</th>

</thead><tbody>';
 foreach ($cc as $aa) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->Designation.'</td>
          <td>'.$aa->DesignationCode.'</td>
		  <td>'.$aa->MaxNoOPossitions.'</td>
          <td>'.$aa->Academic.'</td>
          <td>'.$aa->ArrivalTime.' - '.$aa->Departute.'</td>';
		   
		  if($aa->Active == 1)
		  {
			  $html.='<td>Yes</td>';
		  }
		  else
		  {
			   $html.='<td>No</td>';
		  }
          
          $html.='</tr>'; 
          

          
  }
   
$html.='</tbody></table></font></body></html>';

    return $html;
	}
	
	public function DeleteCardreDetails()
	{
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$UpdateDelete = HREmploymentCode::where('id','=',$id)->update(array('Deleted' => 1,'User' =>$user));
		
		return Redirect::to('ViewCardreDetails');
	}
	
	public function EditCardreDetails()
	{
		
		$QId = Input::get('id');
		$method = Request::getMethod();
		$view = View::make('HRCardre.Edit')->with('user', User::getSysUser());
		$view->OfficeTime = HROfficeTime::where('Deleted','=',0)->get();
		$view->QID = $QId;
		$cc = DB::select(DB::raw("select *
								  from hremploymentcode
								  where Deleted=0
								  and id='".$QId."'"));
		$view->cc = $cc;
		if ($method == "GET") 
		{
			return $view;
		}
		 if ($method == "POST") 
		{
			$id = Input::get('id');
			$user = User::getSysUser()->userID;
			$DesignationName = Input::get('DesignationName');
			$DesignationCode = Input::get('DesignationCode');
			$maxpossition = Input::get('maxpossition');
			$AcademicStatus = Input::get('AcademicStatus');
			$DesignationActive = Input::get('DesignationActive');
			$DesignationTimeslot = Input::get('DesignationTimeslot');
			
			$update = HREmploymentCode::where('id','=',$id)->update(array('Designation' => $DesignationName,'DesignationCode' => $DesignationCode, 'Academic' => $AcademicStatus,'Active' => $DesignationActive,'HROfficeTimeID' => $DesignationTimeslot,'MaxNoOPossitions' => $maxpossition));
			return Redirect::to('ViewCardreDetails');
		}
	}
	
	public function CreateCardreDetails()
	{
		$method = Request::getMethod();
        $view = View::make('HRCardre.Create')->with('user', User::getSysUser());
		$view->OfficeTime = HROfficeTime::where('Deleted','=',0)->get();
		$view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
		$view->SrviceCategoryList = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
		if ($method == "GET") {
            return $view;
        }
	}
	
	public function ViewCardreDetails()
	{
	
     $view = View::make('HRCardre.View');
	 $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $SalaryScales = DB::select(DB::raw("select hremploymentcode.*,hrofficetime.ArrivalTime,hrofficetime.Departute
  from hremploymentcode
  left join hrofficetime
  on hremploymentcode.HROfficeTimeID=hrofficetime.id
  where hremploymentcode.Deleted=0
  order by hremploymentcode.Designation
"));
	  $view->SalaryScales = $SalaryScales;
      return $view;
     }
	}
	
	public function DeactivateHrEmploymentCode()
	{
		$Year = Input::get('Year');
		$user = User::getSysUser()->userID;
		$updateActiveNo = HRTransSalaryEmpCode::where('SCYear','=',$Year)->update(array('Active' => 0,'User' =>$user,'Deleted' => 0));
		return 1;
	}
	
	public function PrintHrEmploymentCode()
	{
		$year = Input::get('YearP');
		$html = '';
		$SalaryScales = DB::select(DB::raw("select hrtranssalaryempcode.id,
  hremploymentcode.Designation,
  hrsalaryscale.ServiceCategory,
  hrsalaryscale.Year,
  hrsalaryscale.SalaryCode,
  hrsalaryscale.SalaryScale,
  hrtranssalaryempcode.Active,
  hrofficetime.ArrivalTime,
  hrofficetime.Departute
  from hrtranssalaryempcode
  left join hrsalaryscale
  on hrtranssalaryempcode.HRSalaryScaleID=hrsalaryscale.id
  left join hremploymentcode
  on hrtranssalaryempcode.HREmpcodeID=hremploymentcode.id
  left join hrofficetime
  on hremploymentcode.HROfficeTimeID=hrofficetime.id
  where hrtranssalaryempcode.Deleted=0
  and hrsalaryscale.Year='".$year."'
  order by hremploymentcode.Designation,hrsalaryscale.Year,hrsalaryscale.SalaryCode,hrtranssalaryempcode.Active
"));
		$i=1;
		$html='<html><head>
   
    </head>
    <body>
   
    <center><h3><b>Designation list with Service Category - '.$year.'</center></h3></b>
	<font size="5px" face="Times New Roman" >
	<table style = "font-size:14px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="left">Designation</th>
<th align="center">Year</th>
<th align="center">Service Category</th>
<th align="left">Salary Code</th>
<th align="left">Salary Scale</th>
<th align="left">Arrival Time</th>
<th align="left">Departure</th>
<th align="center">Active Status</th>

</thead><tbody>';
 foreach ($SalaryScales as $aa) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->Designation.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->ServiceCategory.'</td>
          <td>'.$aa->SalaryCode.'</td>
		  <td>'.$aa->SalaryScale.'</td>
		  <td>'.$aa->ArrivalTime.'</td>
	      <td>'.$aa->Departute.'</td>';
		  if($aa->Active == 1)
		  {
			  $html.='<td>Yes</td>';
		  }
		  else
		  {
			   $html.='<td>No</td>';
		  }
          
          $html.='</tr>'; 
          

          
  }
   
$html.='</tbody></table></font></body></html>';

    return $html;
	}
	
	public function DeleteHrEmploymentCode()
	{
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$UpdateDelete = HRTransSalaryEmpCode::where('id','=',$id)->update(array('Deleted' => 1,'User' =>$user));
		
		return Redirect::to('ViewHrEmploymentCode');
	}
	
	public function EditHrEmploymentCode()
	{
		
		$QId = Input::get('id');
		$method = Request::getMethod();
		$view = View::make('HREmploymentCode.Edit')->with('user', User::getSysUser());
		$view->OfficeTime = HROfficeTime::where('Deleted','=',0)->get();
		$view->Designations = HREmploymentCode::where('Deleted','=',0)->orderBy('Designation')->where('Active','=',1)->get();
		$view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
		$view->SrviceCategoryList = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
		$view->QID = $QId;
		 $cc = DB::select(DB::raw("select *
			  from hrtranssalaryempcode
			  where Deleted=0
			  and id='".$QId."'"));
		 $view->cc = $cc;
		if ($method == "GET") 
		{
			return $view;
		}
		 if ($method == "POST") 
		{
		  $DesignationID = Input::get('Designation');
          $SCYear = Input::get('SCYear');
          $ServiceCategoryID = Input::get('ServiceCategoryID');
          $Active = Input::get('Active');
          $user = User::getSysUser()->userID;
		  $dd = HRTransSalaryEmpCode::where('id','=',$QId)->update(array('HREmpcodeID' =>$DesignationID ,'HRSalaryScaleID' => $ServiceCategoryID,'SCYear' => $SCYear,'Active' => $Active,'User' =>$user));
		
			
		return Redirect::to('ViewHrEmploymentCode');
		
	}
	}
	
	public function SearchHrEmploymentCode()
	{
		$year = Input::get('Year');
		$view = View::make('HREmploymentCode.View');
	    $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $SalaryScales = DB::select(DB::raw("select hrtranssalaryempcode.id,
  hremploymentcode.Designation,
  hrsalaryscale.ServiceCategory,
  hrsalaryscale.Year,hrsalaryscale.SalaryCode,
  hrsalaryscale.SalaryScale,
  hrtranssalaryempcode.Active,
  hrofficetime.ArrivalTime,
  hrofficetime.Departute
  from hrtranssalaryempcode
  left join hrsalaryscale
  on hrtranssalaryempcode.HRSalaryScaleID=hrsalaryscale.id
  left join hremploymentcode
  on hrtranssalaryempcode.HREmpcodeID=hremploymentcode.id
  left join hrofficetime
  on hremploymentcode.HROfficeTimeID=hrofficetime.id
where hrtranssalaryempcode.Deleted=0
  and hrsalaryscale.Year='".$year."'
  order by hremploymentcode.Designation,hrsalaryscale.Year,hrsalaryscale.SalaryCode
"));
	  $view->SalaryScales = $SalaryScales;
	  $view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
	  $view->YearP = $year;
      return $view;
     }
		
	}
	
public function TransEmpServiceCategorySaveAll()
{
	      $DesignationID = Input::get('Designation');
          $SCYear = Input::get('SCYear');
          $ServiceCategoryID = Input::get('ServiceCategoryID');
          $Active = Input::get('Active');
          $user = User::getSysUser()->userID;
		  
		  $available = HRTransSalaryEmpCode::where('Deleted','=',0)->where('Active','=',1)->where('HREmpcodeID','=',$DesignationID)->where('HRSalaryScaleID','=',$ServiceCategoryID)->get();
		  if(count($available) == 0)
		  {
			  
			  $c = new HRTransSalaryEmpCode();
			  $c->HREmpcodeID = $DesignationID;
			  $c->HRSalaryScaleID = $ServiceCategoryID;
			  $c->Active = $Active;
			  $c->SCYear = $SCYear;
			  $c->User = $user;
			  $c->save();
			  $html =  '<font color="blue"><b>This Record Added Succsessfully!!!</b></font>';
		  }
		  else
		  {
			   $html =  '<font color="red"><b>This Record Already Exist & it is in Active Status!!!</b></font>';
		  }

       
		  // $html =  '<font color="blue"><b>"'.$ServiceCategory.' - '.$SalaryCode.'"  Added Succsessfully!!!</b></font>';
		    $json = array("done" => $html);
            return json_encode($json, 0);
}

public function LoadAjaxServiceCategoryGrade()
{
	$SCID = Input::get('SCYear');
  
			$sql = "select hrgrade.*
  from hrsalaryscalegrade
  left join hrgrade
  on hrsalaryscalegrade.GradeID=hrgrade.id
  where hrsalaryscalegrade.Deleted=0
  and hrsalaryscalegrade.Active=1
  and hrgrade.Deleted=0
  and hrsalaryscalegrade.ServiceCategoryID='".$SCID."'
";
    $Data = DB::select(DB::raw($sql));
    return $Data;
}
	
	  public function LoadAjaxServiceCategoryYear()
  {
    $SCYear = Input::get('SCYear');
  
			$sql = "select *
  FROM hrsalaryscale
  where hrsalaryscale.Deleted=0
  and hrsalaryscale.Active=1
  and hrsalaryscale.Year='".$SCYear."'
  order by hrsalaryscale.SalaryScale";
    $Data = DB::select(DB::raw($sql));
    return $Data;
  }
	
	public function SaveAjaxHrEmploymentCode()
	{
		$DesignationName = Input::get('DesignationName');
		$DesignationCode = Input::get('DesignationCode');
		$AcademicStatus = Input::get('AcademicStatus');
		$DesignationActive = Input::get('DesignationActive');
		$DesignationTimeslot = Input::get('DesignationTimeslot');
		$maxpossition = Input::get('maxpossition');
	
		$user = User::getSysUser()->userID;
		$available = HREmploymentCode::where('Designation','=',$DesignationName)->where('Deleted','=',0)->get();
		if(count($available) == 0)
		{
			$c = new HREmploymentCode;
			$c->Designation = $DesignationName;
			$c->DesignationCode = $DesignationCode;
			$c->Academic = $AcademicStatus;
			$c->Active = $DesignationActive;
			$c->HROfficeTimeID = $DesignationTimeslot;
			$c->MaxNoOPossitions = $maxpossition;
			$c->User = $user;
			$c->save();
		}
		
		 $getAllDesig = HREmploymentCode::where('Deleted','=',0)->orderBy('Designation')->get();
		return $getAllDesig;
		
		
	}
	
	public function ViewHrEmploymentCode()
	{
	
     $view = View::make('HREmploymentCode.View');
	 $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
	  
			  
      return $view;
     }
	}
	
	public function CreateHrEmploymentCode()
	{
		$method = Request::getMethod();
        $view = View::make('HREmploymentCode.Create')->with('user', User::getSysUser());
		$view->OfficeTime = HROfficeTime::where('Deleted','=',0)->get();
		$view->Designations = HREmploymentCode::where('Deleted','=',0)->orderBy('Designation')->where('Active','=',1)->get();
		$view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
		if ($method == "GET") {
            return $view;
        }
	}
	
	public function DeactivateHrServiceCategory()
	{
		 $Year = Input::get('Year');
		$user = User::getSysUser()->userID;
		$updateActiveNo = HRSalaryscale::where('Year','=',$Year)->update(array('Active' => 0,'User' =>$user,'Deleted' => 0));
		return 1;
	}
	
	public function ViewHrServiceCategory()
	{
	
     $view = View::make('HRServiceCategory.View');
	 $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  //$SalaryScales = HRSalaryscale::where('Deleted','=',0)->orderBy('Year')->get();
	  //$view->SalaryScales = $SalaryScales;
	  $view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
      return $view;
     }
	}
	
	public function SearchHrServiceCategory()
	{
		$year = Input::get('Year');
		$view = View::make('HRServiceCategory.View');
	    $method=Request::getMethod();
     
	 if($method == 'GET')
     {
	  $SalaryScales = HRSalaryscale::where('Deleted','=',0)->where('Year','=',$year)->orderBy('SalaryCode')->get();
	  $view->SalaryScales = $SalaryScales;
	  $view->Years = HRSalaryscale::select('Year')->orderBy('Year')->distinct()->get();
	 // $view->CheckedGrade = HRSalaryScaleGrade::where('Deleted','=',0)->where('ServiceCategoryID','=',$QId)->where('Active','=',1)->orderBy('GradeID')->get();
	  $view->YearP = $year;
      return $view;
     }
		
	}
	
	public function CreateHrServiceCategory()
	{
		$method = Request::getMethod();
        $view = View::make('HRServiceCategory.Create')->with('user', User::getSysUser());
		$view->gradesList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		if ($method == "GET") {
            return $view;
        }
	}
	public function ServiceCategorySaveAll()
{
	      $Year = Input::get('Year');
          $ServiceCategory = Input::get('ServiceCategory');
          $SalaryCode = Input::get('SalaryCode');
          $SalaryScale = Input::get('SalaryScale');
          $Active = Input::get('Active');
		  $basicSalary = Input::get('BasicSalary');
		  $Grade_ids  = Input::get('Grade_ids');
		  
		  $user = User::getSysUser()->userID;
		  
		  //salarystep
		    $Noofsteparray = Input::get('noofsteps');
		  $NoofstepAmountarray = Input::get('noofstepsamount');
		  $EBSteps = Input::get('EBSteps');
		  
		  $availbale = HRSalaryscale::where('Deleted','=',0)->where('ServiceCategory','=',$ServiceCategory)->where('SalaryCode','=',$SalaryCode)->where('Active','=',1)->get();
         if(count($availbale) == 0)
		 {
			  $c = new HRSalaryscale();
			  $c->Year = $Year;
			  $c->ServiceCategory = $ServiceCategory;
			  $c->SalaryCode = $SalaryCode;
			  $c->SalaryScale = $SalaryScale;
			  $c->Active = $Active;
			  $c->BasicSalary = $basicSalary;
			  $c->User = $user;
			  $c->save();
			  $getSCID = HRSalaryscale::where('ServiceCategory','=',$ServiceCategory)->where('SalaryCode','=',$SalaryCode)->where('SalaryScale','=',$SalaryScale)->where('Active','=',$Active)->where('Deleted','=',0)->pluck('id');
		  
			  for($i=0;$i<count($Grade_ids);$i++)
			  {
				  $vv = new HRSalaryScaleGrade();
				  $vv->ServiceCategoryID = $getSCID;
				  $vv->GradeID = $Grade_ids[$i];
				  $vv->Active = 1;
				  $vv->User =  $user;
				  $vv->save();
			  }
		  //salary step start
		  $TotalSteps = 0;
		  $Asye = [];
		  foreach($NoofstepAmountarray as $sa)
		  {
			  $Asye[] = $sa["value"];
		  }
		  $ebeyepslist = [];
		  foreach($EBSteps as $ebb)
		  {
			  $ebeyepslist[] = $ebb["value"];
		  }
		  $k = 1;
		 // return $Asye;
		  $i=0;
		 foreach($Noofsteparray as $cs)
		  {
			 
			 $code=$cs["value"];
			 if(!empty($code))
			 {
			  $vvv = new HRSalaryStep();
			  $vvv->SalaryScaleID = $getSCID;
			  $vvv->NoOfSteps = $code;
			  $vvv->StepAmount = $Asye[$i];
			  $vvv->User =  $user;
			  $vvv->save();
			  
			  $getSalStepID = HRSalaryStep::where('SalaryScaleID','=',$getSCID)->where('NoOfSteps','=',$code)->where('StepAmount','=',$Asye[$i])->where('Deleted','=',0)->pluck('id');
			  $TotalSteps = $code;
			  
			   for($a=1;$a<=$TotalSteps;$a++)
			  {
				  $cc = new HRSalaryStepTrans();
				  $cc->SalaryStepID = $getSalStepID;
				  $cc->SalaryScaleID = $getSCID;
				  $cc->StepNo = $k;
				  $cc->StepAmount = $Asye[$i];
				  if (in_array($k, $ebeyepslist))
				  {
					   $cc->EBAvailable = 1;
				  
				  }
				  $cc->User = $user;
				  $cc->save();
				  $k = $k +1;
				  
				  
			  }
			  $i = $i +1;
			 }
			  
			  
			 
		  }
		  //Enter Extra steptrans 30
		  $Ext10 = 1;
		  $getHeighestStepID = HRSalaryStep::where('SalaryScaleID','=',$getSCID)->where('Deleted','=',0)->max('id');
		  $getHeighestStepNo = HRSalaryStepTrans::where('SalaryScaleID','=',$getSCID)->where('Deleted','=',0)->max('StepNo');
		  $getHeighestStepAmount = HRSalaryStepTrans::where('SalaryScaleID','=',$getSCID)->where('Deleted','=',0)->where('StepNo','=',$getHeighestStepNo)->pluck('StepAmount');
		  $getHeighestStepNo = $getHeighestStepNo+1;
		  for($Ext10=1;$Ext10<=30;$Ext10++)
		  {
			      $cc = new HRSalaryStepTrans();
				  $cc->SalaryStepID = $getHeighestStepID;
				  $cc->SalaryScaleID = $getSCID;
				  $cc->StepNo = $getHeighestStepNo;
				  $cc->StepAmount = $getHeighestStepAmount;
				  $cc->EBAvailable = 0;
				  $cc->User = $user;
				  $cc->save();
				  $getHeighestStepNo = $getHeighestStepNo+1;
		  }
		  
		  //Enter Extra steptrans 30
		  
		  //salary step end
		  
		  $html = '<font color="blue"><b>"'.$ServiceCategory.' - '.$SalaryCode.'"  Added Succsessfully!!!</b></font>';
		 }
		 else{
			 $html = '<font color="red"><b>"'.$ServiceCategory.' - '.$SalaryCode.'"  Already Exist in Active Status!!!</b></font>';
		 }
          
	  $json = array("done" => $html);
            return json_encode($json, 0);
}
	
	public function PrintHrServiceCategory()
	{
		$year = Input::get('YearP');
		$html = '';
		$sql = "select * from hrsalaryscale where Deleted=0 and Year='".$year."' order by SalaryCode";
		$cc = DB::select(DB::raw($sql));
		$i=1;
		$html='<html><head>
   
    </head>
    <body>
   
    <center><h3><b>Salary Structure for Statutiry Bodies,Coorporations and Fully Owned Government Companies - '.$year.'</center></h3></b>
	<font size="5px" face="Times New Roman" >
	<table style = "font-size:14px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">Year</th>
<th align="left">Service Category</th>
<th align="left">Salary Code</th>
<th align="left">Salary Scale</th>
<th align="center">Active Status</th>

</thead><tbody>';
 foreach ($cc as $aa) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->Year.'</td>
          <td>'.$aa->ServiceCategory.'</td>
          <td>'.$aa->SalaryCode.'</td>
          <td>'.$aa->SalaryScale.'</td>';
		  if($aa->Active == 1)
		  {
			  $html.='<td>Yes</td>';
		  }
		  else
		  {
			   $html.='<td>No</td>';
		  }
          
          $html.='</tr>'; 
          

          
  }
   
$html.='</tbody></table></font></body></html>';

    return $html;
	}
	
	public function DeleteHrServiceCategory()
	{
		$id = Input::get('id');
		$user = User::getSysUser()->userID;
		$UpdateDelete = HRSalaryscale::where('id','=',$id)->update(array('Deleted' => 1,'User' =>$user));
		$updatehrsalarystep = HRSalaryStep::where('SalaryScaleID','=',$id)->update(array('Deleted' => 1));
		$updatehrsalatysteptrans = HRSalaryStepTrans::where('SalaryScaleID','=',$id)->update(array('Deleted' => 1));
		$updateservicegrades = HRSalaryScaleGrade::where('ServiceCategoryID','=',$id)->update(array('Deleted' => 1,'Active' => 0));
		
		return Redirect::to('ViewHrServiceCategory');
	}
	
	public function EditHrServiceCategory()
	{
		
		$QId = Input::get('id');
		$method = Request::getMethod();
		$view = View::make('HRServiceCategory.Edit')->with('user', User::getSysUser());
		$view->gradesList = HRGrade::where('Deleted','=',0)->orderBy('Grade')->get();
		$view->CheckedGrade = HRSalaryScaleGrade::where('Deleted','=',0)->where('ServiceCategoryID','=',$QId)->where('Active','=',1)->orderBy('GradeID')->get();
		$view->QID = $QId;
		 $cc = DB::select(DB::raw("select *
  from hrsalaryscale
  where Deleted=0
  and id='".$QId."'"));
		 $view->cc = $cc;
		if ($method == "GET") 
		{
			return $view;
		}
		 if ($method == "POST") 
		{
			$id = Input::get('id');
			$user = User::getSysUser()->userID;
			$Year = Input::get('Year');
			$ServiceCategory = Input::get('ServiceCategory');
			$SalaryCode = Input::get('SalaryCode');
			$SalaryScale = Input::get('SalaryScale');
			$Active = Input::get('Active');
			$Grade_ids = Input::get('ids');
			$Inactivechecked = HRSalaryScaleGrade::where('ServiceCategoryID','=',$id)->delete();
			 for($i=0;$i<count($Grade_ids);$i++)
			{
				
				  $vv = new HRSalaryScaleGrade();
				  $vv->ServiceCategoryID = $id;
				  $vv->GradeID = $Grade_ids[$i];
				  $vv->Active = 1;
				  $vv->User =  $user;
				  $vv->save();
				}
				
			
			$updateTrans = HRTransSalaryEmpCode::where('HRSalaryScaleID','=',$id)->where('Deleted','=',0)->update(array('SCYear' => $Year));			
			$update = HRSalaryscale::where('id','=',$id)->update(array('Year' => $Year,'ServiceCategory' => $ServiceCategory, 'SalaryCode' => $SalaryCode,'SalaryScale' => $SalaryScale,'Active' => $Active));
			return Redirect::to('ViewHrServiceCategory');
		}
	}
  
	

}
?>
