<?php

use SimpleExcel\SimpleExcel;


class NewAccreditationController extends BaseController {
	
		public function Accreditationloaddistrictcentersin()
	{
		
		$dis = Input::get('District');
		$Year = Input::get('Year');
		
      /*$Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$dis)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();*/
	  
	  $sql = DB::select(DB::raw("select * 
  from organisation
 where organisation.Deleted=0
  and organisation.Active IN('Yes','Closed')
  and organisation.DistrictCode='".$dis."'
 
  order by organisation.OrgaName"));
	  
	  return json_encode($sql);
	}
	
	public function ADDpaymentshortcut11()
  {
    $ID = Input::get('id');

    $ApplicationRecievedDate = Input::get('ApplicationRecievedDate');
	
   // $currentTimestamp = date('Y-m-d H:i:s');
    $AccreditationApplication = AccreditationApplication::where('id','=',$ID)
    ->update(array('ApplicationReciievedStatus' => 'Yes','ApplicationRecievedDate' => $ApplicationRecievedDate));
     return 1;

  }
	public function ADDpaymentshortcut()
  {
    $ID = Input::get('id');
    $PayDate = Input::get('PayDate');
	$PayAmount = Input::get('PayAmount');
	$VoucherNo = Input::get('VoucherNo');
   
   // $currentTimestamp = date('Y-m-d H:i:s');
    $AccreditationApplication = AccreditationApplication::where('id','=',$ID)
    ->update(array('PaymentSubmitStatus' => 'Yes','PayAmount' => $PayAmount, 'PayDate' => $PayDate,'VoucherNo' => $VoucherNo, 'Completed' => 1));
     return 1;

  }
	
	public function DeleteAccreditationPaymentNew()
	{
		$id = Input::get('id');
	    $update = AccreditationApplication::where('id','=',$id)->update(array('Deleted' => 1));
		return Redirect::to('ViewAccreditationPaymentNew');
	}
	
	
	public function loadaccreditationapplicationTimetable()
  {
     $OrgaID = Input::get('CenterID');
	 $CD_ID = Input::get('CD_ID');
     $u = User::getSysUser()->EmpId;
     $centerName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
     $courseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
     
	 $MOCenterMonitoringPlan = DB::select(DB::raw("select accreditationapplication.*
				  from accreditationapplication
				  where accreditationapplication.Deleted=0
				  and accreditationapplication.CenterId='".$OrgaID."'
				  and accreditationapplication.CD_ID='".$CD_ID."'
				  order by accreditationapplication.id"));
     $html='';
     $i = 1;
     if(!empty($MOCenterMonitoringPlan))
     {

      $html = '<div class="control-group">
                  
                   <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead> 
                        <tr>
                        <th class="center">No</th>
                        <th class="center">Centre Name</th>
                        <th class="center">Course Name</th>
                        <th class="center">Application Submit Status</th>
                        <th class="center">Application Submited Date</th>
                        <th class="center">Payment Status</th>
						<th class="center">Date Paid</th>
						<th class="center">Voucher No & Amount</th>
                        </tr>
                       </thead>
                       <tbody>';

                       foreach($MOCenterMonitoringPlan as $m)
                       {
                           
						   $html.='<tr>
                        <td class="center"><font color="blue">'.$i++.'</font></td>
                        <td class="center"><font color="blue">'.$centerName.'</font></td>
                       
                        <td class="center"><font color="blue">'.$courseName.'</font></td>
                        <td class="center"><font color="blue">'.$m->ApplicationReciievedStatus.'</font></td>
                        <td class="center"><font color="blue">'.$m->ApplicationRecievedDate.'</font></td>
						<td class="center"><font color="blue">'.$m->PaymentSubmitStatus.'</font></td>
                        <td class="center"><font color="blue">'.$m->PayDate.'</font></td>
						<td class="center"><font color="blue">'.$m->VoucherNo.'(Rs.'.$m->PayAmount.')</font></td>
                        </tr>';
						   
						  
                       }

                       $html.='</tbody>
                       </table>
                  
                </div>';
     }
     else
     {
        $html='<div class="control-group">
                  
                 <font color="red">Accreditation Applications Not Available for this Course..</font>
                   
                </div>';
     }

     return $html;
  }
	
public function ViewAccreditationPaymentNew()
{
	 $method = Request::getMethod();
    $view = View::make('Accreditation.ViewPayment');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
	 $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
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
				  and organisation.Active in ('Yes','Closed')
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
        $District = Input::get('District');
		$CenterID = Input::get('CenterID');
		$CD_ID = Input::get('CD_ID');
		
		if($District == 'All' && $CenterID == 'All' && $CD_ID == 'All')
		{
			$sql = "select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
  from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN('Yes')
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id";
		}
		elseif($District != 'All' && $CenterID == 'All' && $CD_ID == 'All')
		{
			$sql = 'select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN("Yes")
  and district.DistrictCode="'.$District.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id';
		}
		elseif($District != 'All' && $CenterID != 'All' && $CD_ID == 'All')
		{
			$sql = 'select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
 accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN("Yes")
  and district.DistrictCode="'.$District.'"
  and accreditationapplication.CenterId="'.$CenterID.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id';
		}
		elseif($District != 'All' && $CenterID != 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN("Yes")
  and district.DistrictCode="'.$District.'"
  and accreditationapplication.CenterId="'.$CenterID.'"
  and accreditationapplication.CD_ID="'.$CD_ID.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id';
		}
		elseif($District == 'All' && $CenterID == 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN("Yes")
  and accreditatiaccreditationapplicationondetails.CD_ID="'.$CD_ID.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id';
		}
		elseif($District != 'All' && $CenterID == 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
 accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN("Yes")
  and district.DistrictCode="'.$District.'"
  and accreditationapplication.CD_ID="'.$CD_ID.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id';
		}
		else{
			
			$sql = "select accreditationapplication.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
 accreditationapplication.ApplicationReciievedStatus,
  accreditationapplication.ApplicationRecievedDate,
  accreditationapplication.PaymentSubmitStatus,
  accreditationapplication.PayAmount,
  accreditationapplication.PayDate,
  accreditationapplication.VoucherNo
from accreditationapplication
  left join organisation
  on accreditationapplication.CenterId=organisation.id
  left join coursedetails
  on accreditationapplication.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationapplication.Deleted=0
  and organisation.Deleted=0
  and organisation.Active IN('Yes')
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationapplication.id";
		}
		$DD = DB::select(DB::raw($sql));
		$view->AccreditList = $DD;
	    
		$view->DistrictP = $District;
		$view->CenterIDP = $CenterID;
		$view->CD_IDP = $CD_ID;
		
		return $view;
    }
 }
public function CreateAccreditationPaymentNew()
{
	$method = Request::getMethod();
    $view = View::make('Accreditation.CreatePayment');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
	$view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
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
	   $CD_ID = Input::get('CD_ID');
	   $TradeID = Input::get('Trade');
	   $ApplicationReciievedStatus = Input::get('ApplicationReciievedStatus');
	   $ApplicationRecievedDate = Input::get('ApplicationRecievedDate');
	   $PaymentSubmitStatus = Input::get('PaymentSubmitStatus');
	   $PayDate = Input::get('PayDate');
	   $PayAmount = Input::get('PayAmount');
	   $VoucherNo = Input::get('VoucherNo');
	   
	   // Save to Accreditation application Details table
	   
	   $d = new AccreditationApplication;
	   $d->CenterId = $CenterID;
	   $d->CD_ID = $CD_ID;
	   $d->TradeId = $TradeID;
	   $d->ApplicationReciievedStatus = $ApplicationReciievedStatus;
	   $d->Active=1;
	   
	   if($ApplicationReciievedStatus == 'Yes')
	   {
		  $d->ApplicationRecievedDate = $ApplicationRecievedDate;
	   }
	   if(empty($PaymentSubmitStatus))
	   {
		   $d->PaymentSubmitStatus = 'No';
	   }
	   else
	   {
		   $d->PaymentSubmitStatus = $PaymentSubmitStatus;
	   }
	   
	   if($PaymentSubmitStatus == 'Yes')
	   {
		  $d->PayDate = $PayDate;
		  $d->PayAmount = $PayAmount;
		  $d->VoucherNo = $VoucherNo;
	   }
	   if($PaymentSubmitStatus == 'Yes' && $ApplicationReciievedStatus == 'Yes')
	   {
		   $d->Completed = 1;
	   }
	  
	   $d->User = User::getSysUser()->userID;
	   $d->save();
	   
	   //return $view;
	   return Redirect::to('CreateAccreditationPaymentNew')->with("done", true);
    }
		
}
	
public function loadaccreditationTimetable()
  {
     $OrgaID = Input::get('CenterID');
	 $CD_ID = Input::get('CD_ID');
     $u = User::getSysUser()->EmpId;
     $centerName = Organisation::where('id','=',$OrgaID)->pluck('OrgaName');
     $courseName = Course::where('CD_ID','=',$CD_ID)->pluck('CourseName');
     
	              /*$MOCenterMonitoringPlan = DB::select(DB::raw("select accreditationdetails.*
				  from accreditationdetails
				  where accreditationdetails.Deleted=0
				  and accreditationdetails.CenterId='".$OrgaID."'
				  and accreditationdetails.CD_ID='".$CD_ID."'
				  and accreditationdetails.Active='1'")); */
				  
				  $MOCenterMonitoringPlan = DB::select(DB::raw("select accreditationdetails.*
				  from accreditationdetails
				  where accreditationdetails.Deleted=0
				  and accreditationdetails.CenterId='".$OrgaID."'
				  and accreditationdetails.CD_ID='".$CD_ID."'
				  order by accreditationdetails.id"));
     $html='';
     $i = 1;
     if(!empty($MOCenterMonitoringPlan))
     {

      $html = '<div class="control-group">
                  
                   <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead> 
                        <tr>
                        <th class="center">No</th>
                        <th class="center">Centre Name</th>
                        <th class="center">Course Name</th>
                        <th class="center">Accredit Status</th>
                        <th class="center">Accredit Recommended Date</th>
                        <th class="center">Accredit Date</th>
						<th class="center">Accredit Valid Date</th>
                        </tr>
                       </thead>
                       <tbody>';

                       foreach($MOCenterMonitoringPlan as $m)
                       {
                           if($m->Active == '1')
						   {
						   $html.='<tr>
                        <td class="center"><font color="blue">'.$i++.'</font></td>
                        <td class="center"><font color="blue">'.$centerName.'</font></td>
                       
                        <td class="center"><font color="blue">'.$courseName.'</font></td>
                        <td class="center"><font color="blue">'.$m->Accredit.'</font></td>
                        <td class="center"><font color="blue">'.$m->AccreditRecommandedDate.'</font></td>
						<td class="center"><font color="blue">'.$m->AccreditDate.'</font></td>
                        <td class="center"><font color="blue">'.$m->AccreditationValidDate.'</font></td>
                        </tr>';
						   }
						   else
						   {
							   $html.='<tr>
                        <td class="center">'.$i++.'</td>
                        <td class="center">'.$centerName.'</td>
                       
                        <td class="center">'.$courseName.'</td>
                        <td class="center">'.$m->Accredit.'</td>
                        <td class="center">'.$m->AccreditRecommandedDate.'</td>
						<td class="center">'.$m->AccreditDate.'</td>
                        <td class="center">'.$m->AccreditationValidDate.'</td>
                        </tr>';
						   }
                       }

                       $html.='</tbody>
                       </table>
                  
                </div>';
     }
     else
     {
        $html='<div class="control-group">
                  
                 <font color="red">Accreditation Records Available for this Course..</font>
                   
                </div>';
     }

     return $html;
  }

	
	public function DownloadExcelAccreditationNew()
	{
		  
    $District = Input::get('DistrictP'); //Course Detail tale id
    $CenterID = Input::get('CenterIDP');
    $CD_ID = Input::get('CD_IDP');
    
    	if($District == 'All' && $CenterID == 'All' && $CD_ID == 'All')
		{
			$sql = "select accreditationdetails.id,
			  district.DistrictName,
			  organisation.OrgaName,
			  organisation.RegistrationNo,
			  organisation.Type,
			  trade.TradeName,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.Duration,
			  coursedetails.CourseType,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  accreditationdetails.Accredit,
			  accreditationdetails.AccreditRecommandedDate,
			  accreditationdetails.AccreditDate,
			  accreditationdetails.AccreditationValidDate,
			  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
			  from accreditationdetails
			  left join organisation
			  on accreditationdetails.CenterId=organisation.id
			  left join coursedetails
			  on accreditationdetails.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  left join district
			  on organisation.DistrictCode=district.DistrictCode
			  WHERE accreditationdetails.Deleted=0
			  and organisation.Deleted=0
  
			  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id";
		}
		elseif($District != 'All' && $CenterID == 'All' && $CD_ID == 'All')
		{
			$sql = 'select accreditationdetails.id,
			  district.DistrictName,
			  organisation.OrgaName,
			  organisation.RegistrationNo,
			  organisation.Type,
			  trade.TradeName,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.Duration,
			  coursedetails.CourseType,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  accreditationdetails.Accredit,
			  accreditationdetails.AccreditRecommandedDate,
			  accreditationdetails.AccreditDate,
			  accreditationdetails.AccreditationValidDate,
			  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
			  from accreditationdetails
			  
			  left join organisation
			  on accreditationdetails.CenterId=organisation.id
			  left join coursedetails
			  on accreditationdetails.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  left join district
			  on organisation.DistrictCode=district.DistrictCode
			  WHERE accreditationdetails.Deleted=0
			 and organisation.Deleted=0
 
			  and district.DistrictCode="'.$District.'"
			   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District != 'All' && $CenterID != 'All' && $CD_ID == 'All')
		{
			$sql = 'select accreditationdetails.id,
				  district.DistrictName,
				  organisation.OrgaName,
				  organisation.RegistrationNo,
				  organisation.Type,
				  trade.TradeName,
				  coursedetails.CourseName,
				  coursedetails.CourseListCode,
				  coursedetails.Duration,
				  coursedetails.CourseType,
				  coursedetails.Nvq,
				  coursedetails.CourseLevel,
				  accreditationdetails.Accredit,
				  accreditationdetails.AccreditRecommandedDate,
				  accreditationdetails.AccreditDate,
				  accreditationdetails.AccreditationValidDate,
				  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
				  from accreditationdetails
				 
				  left join organisation
				  on accreditationdetails.CenterId=organisation.id
				  left join coursedetails
				  on accreditationdetails.CD_ID=coursedetails.CD_ID
				  left join trade
				  on coursedetails.TradeId=trade.TradeId
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  WHERE accreditationdetails.Deleted=0
				  and organisation.Deleted=0

				  and district.DistrictCode="'.$District.'"
				  and accreditationdetails.CenterId="'.$CenterID.'"
				   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District != 'All' && $CenterID != 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationdetails.id,
				  district.DistrictName,
				  organisation.OrgaName,
				  organisation.RegistrationNo,
				  organisation.Type,
				  trade.TradeName,
				  coursedetails.CourseName,
				  coursedetails.CourseListCode,
				  coursedetails.Duration,
				  coursedetails.CourseType,
				  coursedetails.Nvq,
				  coursedetails.CourseLevel,
				  accreditationdetails.Accredit,
				  accreditationdetails.AccreditRecommandedDate,
				  accreditationdetails.AccreditDate,
				  accreditationdetails.AccreditationValidDate,
				  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
				  from accreditationdetails
				  
				  left join organisation
				  on accreditationdetails.CenterId=organisation.id
				  left join coursedetails
				  on accreditationdetails.CD_ID=coursedetails.CD_ID
				  left join trade
				  on coursedetails.TradeId=trade.TradeId
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  WHERE accreditationdetails.Deleted=0
				  and organisation.Deleted=0
  
				  and district.DistrictCode="'.$District.'"
				  and accreditationdetails.CenterId="'.$CenterID.'"
				  and accreditationdetails.CD_ID="'.$CD_ID.'"
				  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District == 'All' && $CenterID == 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationdetails.id,
				  district.DistrictName,
				  organisation.OrgaName,
				  organisation.RegistrationNo,
				  organisation.Type,
				  trade.TradeName,
				  coursedetails.CourseName,
				  coursedetails.CourseListCode,
				  coursedetails.Duration,
				  coursedetails.CourseType,
				  coursedetails.Nvq,
				  coursedetails.CourseLevel,
				  accreditationdetails.Accredit,
				  accreditationdetails.AccreditRecommandedDate,
				  accreditationdetails.AccreditDate,
				  accreditationdetails.AccreditationValidDate,
				  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
				  from accreditationdetails
				  left join organisation
				  on accreditationdetails.CenterId=organisation.id
				  left join coursedetails
				  on accreditationdetails.CD_ID=coursedetails.CD_ID
				  left join trade
				  on coursedetails.TradeId=trade.TradeId
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  WHERE accreditationdetails.Deleted=0
				  and organisation.Deleted=0
                  and accreditationdetails.CD_ID="'.$CD_ID.'"
				  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District != 'All' && $CenterID == 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationdetails.id,
			  district.DistrictName,
			  organisation.OrgaName,
			  organisation.RegistrationNo,
			  organisation.Type,
			  trade.TradeName,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.Duration,
			  coursedetails.CourseType,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  accreditationdetails.Accredit,
			  accreditationdetails.AccreditRecommandedDate,
			  accreditationdetails.AccreditDate,
			  accreditationdetails.AccreditationValidDate,
			  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
			  from accreditationdetails
			 
			  left join organisation
			  on accreditationdetails.CenterId=organisation.id
			  left join coursedetails
			  on accreditationdetails.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  left join district
			  on organisation.DistrictCode=district.DistrictCode
			  WHERE accreditationdetails.Deleted=0
			  and organisation.Deleted=0
            
			  and district.DistrictCode="'.$District.'"
			  and accreditationdetails.CD_ID="'.$CD_ID.'"
			  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		else{
			
			$sql = "select accreditationdetails.id,
				  district.DistrictName,
				  organisation.OrgaName,
				  organisation.RegistrationNo,
				  organisation.Type,
				  trade.TradeName,
				  coursedetails.CourseName,
				  coursedetails.CourseListCode,
				  coursedetails.Duration,
				  coursedetails.CourseType,
				  coursedetails.Nvq,
				  coursedetails.CourseLevel,
				  accreditationdetails.Accredit,
				  accreditationdetails.AccreditRecommandedDate,
				  accreditationdetails.AccreditDate,
				  accreditationdetails.AccreditationValidDate,
				  accreditationdetails.AccreditNoReason,
				  accreditationdetails.Active
				  from accreditationdetails
				
				  left join organisation
				  on accreditationdetails.CenterId=organisation.id
				  left join coursedetails
				  on accreditationdetails.CD_ID=coursedetails.CD_ID
				  left join trade
				  on coursedetails.TradeId=trade.TradeId
				  left join district
				  
				  on organisation.DistrictCode=district.DistrictCode
				  WHERE accreditationdetails.Deleted=0
				  and organisation.Deleted=0

				  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id";
		}
		$DD = DB::select(DB::raw($sql));
    $i = 1;
    
     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('#','District', 'Center', 'Registration No','Trade', 'Course','CourseListCode','Duration','CourseType', 'NVQ/NON','NVQLevel',
	 'AccreditStatus','RecommendedDate','AccreditDate','AccreditValidDate','ReasonForNotAccredit','Active');
    array_push($printablearray, $headerArray);
     foreach ($DD as $aa) {
		if($aa->Active ==1)
		{
			$Active='Yes';
		}
		else
		{
			$Active='No';
		}
		if($aa->Accredit == 'NotExist')
		{
			$CenID = AccreditationDetails::where('id','=',$aa->id)->where('Deleted','=',0)->pluck('CenterId');
							$CD_ID = AccreditationDetails::where('id','=',$aa->id)->where('Deleted','=',0)->pluck('CD_ID');
							 $sqlq = DB::select(DB::raw("select accreditationdetails.AccreditRecommandedDate,
														  accreditationdetails.AccreditDate,
														  accreditationdetails.AccreditationValidDate
														  from accreditationdetails
														  where accreditationdetails.Deleted=0
														  and accreditationdetails.CenterId='".$CenID."'
														  and accreditationdetails.CD_ID='".$CD_ID."'
														  and accreditationdetails.Accredit NOT IN('NotExist')
														  order by accreditationdetails.id DESC
														  limit 1
														  "));
							if(count($sqlq) != 0)
							{
								$newdata =  json_decode(json_encode((array)$sqlq),true);
								$OldAccreditRecommandedDate = $newdata[0]["AccreditRecommandedDate"];
								$OldAccreditDate = $newdata[0]["AccreditDate"];
								$OldAccreditationValidDate = $newdata[0]["AccreditationValidDate"];
							}
							else
							{
								$OldAccreditRecommandedDate = "";
								$OldAccreditDate = "";
								$OldAccreditationValidDate = "";
							}
		}
		else
		{
			$OldAccreditRecommandedDate = $aa->AccreditRecommandedDate;
			$OldAccreditDate = $aa->AccreditDate;
			$OldAccreditationValidDate = $aa->AccreditNoReason;
			
		}
		
      array_push($printablearray, array($i,$aa->DistrictName,
	  $aa->OrgaName, 
	  $aa->RegistrationNo,
	  $aa->TradeName,
	  $aa->CourseName,
	  $aa->CourseListCode,
	  $aa->Duration,
	  $aa->CourseType,
	  $aa->Nvq,
	  $aa->CourseLevel,
	  $aa->Accredit,
	  $OldAccreditRecommandedDate,
	  $OldAccreditDate,
	  $OldAccreditationValidDate,
	  $aa->AccreditNoReason,
	  $Active
	 /*  $aa->ApplicationReciievedStatus,
	  $aa->ApplicationRecievedDate,
	  $aa->PaymentSubmitStatus,
	  $aa->PayAmount,
	  $aa->PayDate,
	  $aa->VoucherNo */
	  
	  ));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('AccreditationList');
  
	}
	
	public function DeleteAccreditationNew()
	{
		$id = Input::get('id');
		$checkACtive = AccreditationDetails::where('id','=',$id)->pluck('Active');
		if($checkACtive == 1)
		{
			$CD_ID = AccreditationDetails::where('id','=',$id)->pluck('CD_ID');
			$CenterId = AccreditationDetails::where('id','=',$id)->pluck('CenterId');
			$update = AccreditationDetails::where('id','=',$id)->update(array('Deleted' => 1));
			$getMax = AccreditationDetails::where('CD_ID','=',$CD_ID)->where('CenterId','=',$CenterId)->where('Deleted','=',0)->max('id');
			$updateA = AccreditationDetails::where('id','=',$getMax)->update(array('Active' => 1));
		}
		$update = AccreditationDetails::where('id','=',$id)->update(array('Deleted' => 1));
		return Redirect::to('ViewAccreditationNew');
	}
	
	 public function LoadAccreditationCDListII()
 {
	 $CenterID = Input::get('cid');
	 $District = Input::get('District');
	// $Year = Input::get('Year');
	 
	/* if($District =='All' && $CenterID == 'All')
	 {
		  $sql = "select DISTINCT coursedetails.CD_ID,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.CourseType,
			  coursedetails.Duration,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  coursedetails.Active
			  from courseyearplan
			  left join organisation
			  on courseyearplan.OrgId=organisation.id
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  where courseyearplan.Deleted=0
			  and courseyearplan.Year='".$Year."'
			  and coursedetails.Deleted=0
			  and organisation.Deleted=0
			  order by coursedetails.CourseName";
	 }
	 elseif($District !='All' && $CenterID == 'All')
	 {
		 $sql = "select DISTINCT coursedetails.CD_ID,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.CourseType,
			  coursedetails.Duration,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  coursedetails.Active
			  from courseyearplan
			  left join organisation
			  on courseyearplan.OrgId=organisation.id
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  where courseyearplan.Deleted=0
			   and courseyearplan.Year='".$Year."'
			  and coursedetails.Deleted=0
			  and organisation.DistrictCode='".$District."'
			  order by coursedetails.CourseName";
	 }
	 else {
		 $sql = "select DISTINCT coursedetails.CD_ID,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.CourseType,
			  coursedetails.Duration,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  coursedetails.Active
			  from courseyearplan
			  left join organisation
			  on courseyearplan.OrgId=organisation.id
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  where courseyearplan.Deleted=0
			   and courseyearplan.Year='".$Year."'
			  and coursedetails.Deleted=0
			  and organisation.DistrictCode='".$District."'
			  and organisation.id='".$CenterID."' 
			  order by coursedetails.CourseName";
	 }*/
	 if($District =='All' && $CenterID == 'All')
	 {
		  $sql = "select DISTINCT coursedetails.CD_ID,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.CourseType,
			  coursedetails.Duration,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  coursedetails.Active
			  from courseyearplan
			  left join organisation
			  on courseyearplan.OrgId=organisation.id
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  where courseyearplan.Deleted=0
			 
			  and coursedetails.Deleted=0
			  and organisation.Deleted=0
			  order by coursedetails.CourseName";
	 }
	 elseif($District !='All' && $CenterID == 'All')
	 {
		 $sql = "select DISTINCT coursedetails.CD_ID,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.CourseType,
			  coursedetails.Duration,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  coursedetails.Active
			  from courseyearplan
			  left join organisation
			  on courseyearplan.OrgId=organisation.id
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  where courseyearplan.Deleted=0
			 
			  and coursedetails.Deleted=0
			  and organisation.DistrictCode='".$District."'
			  order by coursedetails.CourseName";
	 }
	 else {
		 $sql = "select DISTINCT coursedetails.CD_ID,
			  coursedetails.CourseName,
			  coursedetails.CourseListCode,
			  coursedetails.CourseType,
			  coursedetails.Duration,
			  coursedetails.Nvq,
			  coursedetails.CourseLevel,
			  coursedetails.Active
			  from courseyearplan
			  left join organisation
			  on courseyearplan.OrgId=organisation.id
			  left join coursedetails
			  on courseyearplan.CD_ID=coursedetails.CD_ID
			  left join trade
			  on coursedetails.TradeId=trade.TradeId
			  where courseyearplan.Deleted=0
			 
			  and coursedetails.Deleted=0
			  and organisation.DistrictCode='".$District."'
			  and organisation.id='".$CenterID."' 
			  order by coursedetails.CourseName";
	 }
	
	 $DD = DB::select(DB::raw($sql));
	 
	 return json_encode($DD);
 }
 

 public function ViewAccreditationNew()
 {
	 $method = Request::getMethod();
    $view = View::make('Accreditation.ViewAccreditation');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
	 $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
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
        $District = Input::get('District');
		$CenterID = Input::get('CenterID');
		$CD_ID = Input::get('CD_ID');
		
		if($District == 'All' && $CenterID == 'All' && $CD_ID == 'All')
		{
			$sql = "select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
  accreditationdetails.Active
from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
  
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id";
		}
		elseif($District != 'All' && $CenterID == 'All' && $CD_ID == 'All')
		{
			$sql = 'select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
   accreditationdetails.Active
from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
  
  and district.DistrictCode="'.$District.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District != 'All' && $CenterID != 'All' && $CD_ID == 'All')
		{
			$sql = 'select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
   accreditationdetails.Active
from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
  and district.DistrictCode="'.$District.'"
  
  and accreditationdetails.CenterId="'.$CenterID.'"
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District != 'All' && $CenterID != 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
   accreditationdetails.Active
from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
  and district.DistrictCode="'.$District.'"
  and accreditationdetails.CenterId="'.$CenterID.'"
  and accreditationdetails.CD_ID="'.$CD_ID.'"
   
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District == 'All' && $CenterID == 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
   accreditationdetails.Active
from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
  and accreditationdetails.CD_ID="'.$CD_ID.'"
   
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		elseif($District != 'All' && $CenterID == 'All' && $CD_ID != 'All')
		{
			$sql = 'select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
   accreditationdetails.Active
from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
  and district.DistrictCode="'.$District.'"
  and accreditationdetails.CD_ID="'.$CD_ID.'"
   
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id';
		}
		else{
			
			$sql = "select accreditationdetails.id,
  district.DistrictName,
  organisation.OrgaName,
  organisation.RegistrationNo,
  organisation.Type,
  trade.TradeName,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.Duration,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  accreditationdetails.Accredit,
  accreditationdetails.AccreditRecommandedDate,
  accreditationdetails.AccreditDate,
  accreditationdetails.AccreditationValidDate,
  accreditationdetails.AccreditNoReason,
   accreditationdetails.Active
   from accreditationdetails
  left join organisation
  on accreditationdetails.CenterId=organisation.id
  left join coursedetails
  on accreditationdetails.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  left join district
  on organisation.DistrictCode=district.DistrictCode
  WHERE accreditationdetails.Deleted=0
   
   order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,accreditationdetails.id";
		}
		$DD = DB::select(DB::raw($sql));
		$view->AccreditList = $DD;
	    
		$view->DistrictP = $District;
		$view->CenterIDP = $CenterID;
		$view->CD_IDP = $CD_ID;
		
		return $view;
    }
 }
 
 public function LoadAccreditationCDList()
 {
	 $CenterID = Input::get('cid');
	 $TradeID = Input::get('TID');
	 
	 $sql = "select DISTINCT coursedetails.CD_ID,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Duration,
  coursedetails.Nvq,
  coursedetails.CourseLevel
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  left join trade
  on coursedetails.TradeId=trade.TradeId
  where courseyearplan.Deleted=0
  and coursedetails.Deleted=0
  and courseyearplan.OrgId='".$CenterID."'
  and trade.TradeId='".$TradeID."'
  order by coursedetails.CourseName";
	 $DD = DB::select(DB::raw($sql));
	 
	 return json_encode($DD);
 }
 
 public function CreateAccreditationNew()
 {
	$method = Request::getMethod();
    $view = View::make('Accreditation.CreateAccreditation');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
	 $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
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
	   $CD_ID = Input::get('CD_ID');
	   $TradeID = Input::get('Trade');
	   $Accredit = Input::get('Accredit');
	   $AccreditNoReason = Input::get('AccreditNoReason');
	   $AccreditRecommanddate = Input::get('AccreditRecommendDate');
	   $AccreditDate = Input::get('AccreditDate');
	   $AccreditationValidDate = Input::get('AccreditationValidDate');
	   
	   // Save to Accreditation Details table
	   $UpdateActice = AccreditationDetails::where('CenterId','=',$CenterID)->where('CD_ID','=',$CD_ID)->update(array('Active' => 0));
	   $d = new AccreditationDetails;
	   $d->CenterId = $CenterID;
	   $d->CD_ID = $CD_ID;
	   $d->TradeId = $TradeID;
	   $d->Accredit = $Accredit;
	   $d->Active = 1;
	   if($Accredit == 'Yes')
	   {
		$d->AccreditRecommandedDate = $AccreditRecommanddate;
		$d->AccreditDate = $AccreditDate;
		$d->AccreditationValidDate = $AccreditationValidDate;
							
	   }
	   elseif($Accredit == 'Recommended')
	   {
		   
		   $d->AccreditRecommandedDate = $AccreditRecommanddate;
		   $d->AccreditDate = '0000-00-00';
		   $d->AccreditationValidDate = '0000-00-00';
			
		}
		else
		{
		   $d->AccreditRecommandedDate = '0000-00-00';
		   $d->AccreditDate = '0000-00-00';
		   $d->AccreditationValidDate = '0000-00-00';
		   $d->AccreditNoReason = $AccreditNoReason;
			
		}
	   
	  
	   $d->User = User::getSysUser()->userID;
	   $d->save();
	   
	   //return $view;
	   return Redirect::to('CreateAccreditationNew')->with("done", true);
    }
	
 }
}
?>