<?php

use SimpleExcel\SimpleExcel;


class MOActualTimeTableController extends BaseController {
	
  public function CancelSpecialPermissionMOCenterMOnitoringPlan()
  {
    $ID = Input::get('id');
    $empid = User::getSysUser()->EmpId;
    $MOCenterMonitoringPlan = MOCenterMonitoringPlan::where('id','=',$ID)
    ->update(array('SpecialPermissionToEnter' => '0'));
     return 1;
  }
	
  public function GiveSpecialPermissionMOCenterMOnitoringPlan()
  {
    $ID = Input::get('id');
    $empid = User::getSysUser()->EmpId;
    $MOCenterMonitoringPlan = MOCenterMonitoringPlan::where('id','=',$ID)
    ->update(array('SpecialPermissionToEnter' => '1'));
     return 1;
  }
	
	 public function DownloadInstructorGradingFullDetailsReport1()
  {
    $Year = Input::get('Year');
	$District = Input::get('District');
   
    $Count = 1;
	$AllQuestions = DB::select(DB::raw("select distinct moinstructorcriteriaquestion.id,moinstructorcriteriaquestion.QuestionInSinhala,
										  moinstructorcriteriaquestion.QuestionInEnglish,moinstructorcriteriaquestion.AnswerTypeId
										  from moinstructorgradingresulttrans
										  left join moinstructorcriteriaquestion
										  on moinstructorgradingresulttrans.QuestionID=moinstructorcriteriaquestion.id
										  where moinstructorgradingresulttrans.Deleted=0
										  and moinstructorcriteriaquestion.id in(1,2,3,5,6,7)
										  and moinstructorgradingresulttrans.Year='".$Year."'
										  and moinstructorcriteriaquestion.Deleted=0"));
	$CountAllQuestions = count($AllQuestions);

    $tablePrintHeader = array('#','Year','Batch','District','CentreName','CourseName','NVQLevel','Duration','InstructorName','EPFNo');
	
    $excel = new SimpleExcel('csv');
    $printablearray = array();
	 array_push($printablearray, $tablePrintHeader);
	 $data_rowHeaderQues = array();
	 $data_rowHeaderAnswers = array();
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
	 
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 
	foreach($AllQuestions as $QA)
	{
		$UniqAnswersForQuestion = DB::select(DB::raw("select *
														    from moinstructorquestionanswer
														    where moinstructorquestionanswer.Deleted=0
														    and moinstructorquestionanswer.QuestionId='".$QA->id."'
														    order by moinstructorquestionanswer.QuestionId,moinstructorquestionanswer.AnswerWeight DESC"));
		 $anscount = count($UniqAnswersForQuestion);
		       
	    array_push($data_rowHeaderQues, $QA->QuestionInEnglish);
		
		if(count($UniqAnswersForQuestion) == 0)
		{
			array_push($data_rowHeaderAnswers, ' ');
		}
		else
		{
			foreach($UniqAnswersForQuestion as $QAA)
			{
			  
			  array_push($data_rowHeaderAnswers, $QAA->AnswerInEnglish);
			 
			}
		}
		
		for($r=0;$r<$anscount-1;$r++)
		{
			 array_push($data_rowHeaderQues, ' ');
		}
				
				
			
               
                
	}
	// array_push($data_rowHeaderQues, 'Total Mark Achived(Out of 700)');
	
	// array_push($data_rowHeaderQues, 'Comments');
	 
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	
	 
	 array_push($printablearray, $data_rowHeaderQues);
	  array_push($printablearray, $data_rowHeaderAnswers);
	 
	 //all answers
	
     $i = 1;
   if ($District == 'All') 
			{
				$sqldis="select moinstructorgradingresult.id,
						 district.DistrictName,
						 organisation.OrgaName,organisation.Type,
						 coursedetails.CourseName,
						 coursedetails.Duration,
						 coursedetails.CourseLevel,
						  moinstructor.EPFNo,
						  moinstructor.Name,
						  moinstructorgradingresult.TotalWeight,
						  moinstructorgradingresult.AchivedMark,
						  moinstructorgradingresult.Year,
						  moinstructorgradingresult.Batch,
						 moinstructorgradingresult.Comments
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  order by district.DistrictName,organisation.OrgaName,moinstructorgradingresult.Year,Batch,coursedetails.CourseName,CourseLevel
						";
			}
			else 
			{
			   $sqldis="select moinstructorgradingresult.id,
						 district.DistrictName,
						 organisation.OrgaName,organisation.Type,
						 coursedetails.CourseName,
						 coursedetails.Duration,
						 coursedetails.CourseLevel,
						  moinstructor.EPFNo,
						  moinstructor.Name,
						  moinstructorgradingresult.TotalWeight,
						  moinstructorgradingresult.AchivedMark,
						  moinstructorgradingresult.Year,
						  moinstructorgradingresult.Batch,
						 moinstructorgradingresult.Comments
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  and district.DistrictCode='".$District."'
						  order by district.DistrictName,organisation.OrgaName,moinstructorgradingresult.Year,Batch,coursedetails.CourseName,CourseLevel
						";
			  
			 
			}

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			


                foreach($total_rec as $Data) {
				           
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Year);
				array_push($data_row, $Data->Batch);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName.'('.$Data->Type.')');
				array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				array_push($data_row, $Data->Name);
				array_push($data_row, $Data->EPFNo);
				
						foreach($AllQuestions as $QA)
						{
							
							if($QA->AnswerTypeId == 2)
									 {
										  //user input
										$UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
									  ->orderBy('id')->get();
									  if(count($UniqAnswersForQuestion) == 0)
											{
												$REC = MoInstructorGradingResultTrans::where('QuestionID','=',$QA->id)
													 ->where('AnswerID','=',999999)
													 ->where('MIDRID','=',$Data->id)
													 ->where('AnswerType','=','UI')
													 ->where('Deleted','=',0)
													 ->first();
												
												 array_push($data_row, $REC->AchivedMark);
											}
									  
									 }
									 else
									 {
										 //selection answer
										 //$UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
																//->orderBy('id')->get();
											 $AllAnswers = DB::select(DB::raw("select *
																	from moinstructorquestionanswer
																	where moinstructorquestionanswer.Deleted=0
																	and moinstructorquestionanswer.QuestionId='".$QA->id."'
																	order by moinstructorquestionanswer.QuestionId,moinstructorquestionanswer.AnswerWeight DESC"));
																	
											foreach($AllAnswers as $ANS)
											 {
												  $REC = MoInstructorGradingResultTrans::where('QuestionID','=',$QA->id)
												 ->where('AnswerID','=',$ANS->id)
												 ->where('MIDRID','=',$Data->id)
												 ->where('Deleted','=',0)
												 ->first();
												 
												 if(count($REC) == 0)
												 {
													  
													 array_push($data_row, 'No');
												 }
												 else
												 {
													
													 array_push($data_row, 'Yes');
												 }
											 }
									 }
									
									 
						}
				
				//array_push($data_row, $Data->AchivedMark);
				//array_push($data_row, $Data->Comments);
               
                array_push($printablearray, $data_row);
                            
                }
				

 
               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseInstructorGradingDetailReport' . date('Y-m-d'));
            
  }
	
	public function DownloadYearwiseTimeTableIssuingReport()
  {
    $Year = Input::get('Year');
	$Batch = Input::get('Batch');
	
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','Batch','Tarde','CourseName','CourseListCode','CourseType','NVQ','NVQLevel','Duration','TimeTableIssuedStatus');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
     $Grade = "";

         	$sql="select courseyearplan.Year,courseyearplan.batch,courseyearplan.CD_ID,
					  coursedetails.CourseListCode,coursedetails.CourseName,coursedetails.CourseType,
					  coursedetails.Duration,coursedetails.Nvq,
					  coursedetails.CourseLevel,
					  trade.TradeName
					  from courseyearplan
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  where courseyearplan.Year='".$Year."'
					  and courseyearplan.Deleted=0
					  and courseyearplan.batch like '$Batch%'
					  and coursedetails.Nvq='NVQ'
					  and coursedetails.CourseType='Full'
					  group by courseyearplan.Year,courseyearplan.batch,courseyearplan.CD_ID
					  order by trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel";

           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
			$TotIns = '';

                foreach($total_rec as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->Year);
				array_push($data_row, $Data->batch);
                array_push($data_row, $Data->TradeName);
				array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseListCode);
				array_push($data_row, $Data->CourseType);
				array_push($data_row, $Data->Nvq);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				
				$sql ='select modatetask.*
									from modatetask
									left join modatecalender
									on modatetask.MODateCalenderID=modatecalender.id
									left join coursedetails
									on modatetask.CD_ID=coursedetails.CD_ID
									left join motaskseq
									on modatetask.TaskSeqID=motaskseq.id
									left join module
									on motaskseq.moduleid=module.ModuleId
									left join motask
									on motaskseq.taskid=motask.id
									where modatetask.Deleted=0
									and modatetask.Year="'.$Data->Year.'"
									and modatetask.Batch like "'.$Data->batch.'"
									and modatetask.CD_ID="'.$Data->CD_ID.'"';
							$TimeTable = DB::select(DB::raw($sql));
							$Countss = count($TimeTable);
							if($Countss>0)
							{
								$TotIns = 'Yes';
							}
							else
							{
								$TotIns = 'No';
							}
							array_push($data_row, $TotIns);
				array_push($printablearray, $data_row);
				
                            
                }
				 
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('YearwiseTimeTableIssuingReport' . date('Y-m-d'));
            
  }
	
  public function ViewYearwiseTimeTableIssuingReport()
  {
    $view = View::make('MOTimeTable.ViewIssuedList');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
	  $view->Districts = District::orderBy('DistrictName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
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
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
			$Batch = Input::get('Batch');
			

           

				$sql="select courseyearplan.Year,courseyearplan.batch,courseyearplan.CD_ID,
					  coursedetails.CourseListCode,coursedetails.CourseName,coursedetails.CourseType,
					  coursedetails.Duration,coursedetails.Nvq,
					  coursedetails.CourseLevel,
					  trade.TradeName
					  from courseyearplan
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  where courseyearplan.Year='".$Year."'
					  and courseyearplan.Deleted=0
					  and courseyearplan.batch like '$Batch%'
					  and coursedetails.Nvq='NVQ'
					  and coursedetails.CourseType='Full'
					  group by courseyearplan.Year,courseyearplan.batch,courseyearplan.CD_ID
					  order by trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel";
			
			
			
			
          $courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
		  $view->PBatch = $Batch;
		  
          $view->courses = $courses;
          return $view;
        }

  }
	
		 public function DownloadInstructorGradingInstructorCountReport()
  {
    $Year = Input::get('Year');
	
    $Count = 1;

    $tablePrintHeader = array('#', 'TradeName','CourseName','CourseLevel','NoofInstructors');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
     $Grade = "";

         	$sql="select trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel,count(distinct moinstructor.EPFNo) as NooFInstructors
from moinstructorgradingresult
left join coursedetails
on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
left join trade
on coursedetails.TradeId=trade.TradeId
  left join moinstructor
  on moinstructorgradingresult.InstructorID=moinstructor.id
where moinstructorgradingresult.Deleted=0
and moinstructorgradingresult.Year='".$Year."'
group by trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel
order by trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel";

           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
			$TotIns = 0;

                foreach($total_rec as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->TradeName);
				array_push($data_row, $Data->CourseName);
                array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->NooFInstructors);
				$TotIns = $TotIns+ $Data->NooFInstructors;
                array_push($printablearray, $data_row);
				
                            
                }
				
				$data_row = array();
                array_push($data_row, '');
                array_push($data_row, '');
				array_push($data_row, '');
                array_push($data_row, 'Total');
				array_push($data_row, $TotIns);
				
                array_push($printablearray, $data_row);


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('HOInstructorCountReportYearWise' . date('Y-m-d'));
            
  }
	
	 public function ViewInstructorGradingInstructorCountReport()
  {
    $view = View::make('MOInstructorMonitor.ViewInstructorCountReport2');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
	  $view->Districts = District::orderBy('DistrictName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
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
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
			

           

				$sql="select trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel,count(distinct moinstructor.EPFNo) as NooFInstructors
from moinstructorgradingresult
left join coursedetails
on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
left join trade
on coursedetails.TradeId=trade.TradeId
  left join moinstructor
  on moinstructorgradingresult.InstructorID=moinstructor.id
where moinstructorgradingresult.Deleted=0
and moinstructorgradingresult.Year='".$Year."'
group by trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel
order by trade.TradeName,coursedetails.CourseName,coursedetails.CourseLevel";
			
			
			
			
          $courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
		  
          $view->courses = $courses;
          return $view;
        }

  }
	
   public function DownloadInstructorGradingFullDetailsReport()
  {
    $Year = Input::get('Year');
	$District = Input::get('District');
   
    $Count = 1;
	$AllQuestions = DB::select(DB::raw("select distinct moinstructorcriteriaquestion.id,moinstructorcriteriaquestion.QuestionInSinhala,
										  moinstructorcriteriaquestion.QuestionInEnglish,moinstructorcriteriaquestion.AnswerTypeId
										  from moinstructorgradingresulttrans
										  left join moinstructorcriteriaquestion
										  on moinstructorgradingresulttrans.QuestionID=moinstructorcriteriaquestion.id
										  where moinstructorgradingresulttrans.Deleted=0
										  and moinstructorgradingresulttrans.Year='".$Year."'
										  and moinstructorcriteriaquestion.Deleted=0"));
	$CountAllQuestions = count($AllQuestions);

    $tablePrintHeader = array('#','Year','Batch','District','CentreName','CourseName','NVQLevel','Duration','InstructorName','EPFNo');
	
    $excel = new SimpleExcel('csv');
    $printablearray = array();
	 array_push($printablearray, $tablePrintHeader);
	 $data_rowHeaderQues = array();
	 $data_rowHeaderAnswers = array();
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
	 
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 
	foreach($AllQuestions as $QA)
	{
		$UniqAnswersForQuestion = DB::select(DB::raw("select *
														    from moinstructorquestionanswer
														    where moinstructorquestionanswer.Deleted=0
														    and moinstructorquestionanswer.QuestionId='".$QA->id."'
														    order by moinstructorquestionanswer.QuestionId,moinstructorquestionanswer.AnswerWeight DESC"));
		 $anscount = count($UniqAnswersForQuestion);
		       
	    array_push($data_rowHeaderQues, $QA->QuestionInEnglish);
		
		if(count($UniqAnswersForQuestion) == 0)
		{
			array_push($data_rowHeaderAnswers, ' ');
		}
		else
		{
			foreach($UniqAnswersForQuestion as $QAA)
			{
			  
			  array_push($data_rowHeaderAnswers, $QAA->AnswerInEnglish);
			 
			}
		}
		
		for($r=0;$r<$anscount-1;$r++)
		{
			 array_push($data_rowHeaderQues, ' ');
		}
				
				
			
               
                
	}
	 array_push($data_rowHeaderQues, 'Total Mark Achived(Out of 700)');
	
	 array_push($data_rowHeaderQues, 'Comments');
	 
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	
	 
	 array_push($printablearray, $data_rowHeaderQues);
	  array_push($printablearray, $data_rowHeaderAnswers);
	 
	 //all answers
	
     $i = 1;
   if ($District == 'All') 
			{
				$sqldis="select moinstructorgradingresult.id,
						 district.DistrictName,
						 organisation.OrgaName,organisation.Type,
						 coursedetails.CourseName,
						 coursedetails.Duration,
						 coursedetails.CourseLevel,
						  moinstructor.EPFNo,
						  moinstructor.Name,
						  moinstructorgradingresult.TotalWeight,
						  moinstructorgradingresult.AchivedMark,
						  moinstructorgradingresult.Year,
						  moinstructorgradingresult.Batch,
						 moinstructorgradingresult.Comments
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  order by district.DistrictName,organisation.OrgaName,moinstructorgradingresult.Year,Batch,coursedetails.CourseName,CourseLevel
						";
			}
			else 
			{
			   $sqldis="select moinstructorgradingresult.id,
						 district.DistrictName,
						 organisation.OrgaName,organisation.Type,
						 coursedetails.CourseName,
						 coursedetails.Duration,
						 coursedetails.CourseLevel,
						  moinstructor.EPFNo,
						  moinstructor.Name,
						  moinstructorgradingresult.TotalWeight,
						  moinstructorgradingresult.AchivedMark,
						  moinstructorgradingresult.Year,
						  moinstructorgradingresult.Batch,
						 moinstructorgradingresult.Comments
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  and district.DistrictCode='".$District."'
						  order by district.DistrictName,organisation.OrgaName,moinstructorgradingresult.Year,Batch,coursedetails.CourseName,CourseLevel
						";
			  
			 
			}

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			


                foreach($total_rec as $Data) {
				           
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Year);
				array_push($data_row, $Data->Batch);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName.'('.$Data->Type.')');
				array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				array_push($data_row, $Data->Name);
				array_push($data_row, $Data->EPFNo);
				
						foreach($AllQuestions as $QA)
						{
							
							if($QA->AnswerTypeId == 2)
									 {
										  //user input
										$UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
									  ->orderBy('id')->get();
									  if(count($UniqAnswersForQuestion) == 0)
											{
												$REC = MoInstructorGradingResultTrans::where('QuestionID','=',$QA->id)
													 ->where('AnswerID','=',999999)
													 ->where('MIDRID','=',$Data->id)
													 ->where('AnswerType','=','UI')
													 ->where('Deleted','=',0)
													 ->first();
												
												 array_push($data_row, $REC->AchivedMark);
											}
									  
									 }
									 else
									 {
										 //selection answer
										 //$UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
																//->orderBy('id')->get();
											 $AllAnswers = DB::select(DB::raw("select *
																	from moinstructorquestionanswer
																	where moinstructorquestionanswer.Deleted=0
																	and moinstructorquestionanswer.QuestionId='".$QA->id."'
																	order by moinstructorquestionanswer.QuestionId,moinstructorquestionanswer.AnswerWeight DESC"));
																	
											foreach($AllAnswers as $ANS)
											 {
												  $REC = MoInstructorGradingResultTrans::where('QuestionID','=',$QA->id)
												 ->where('AnswerID','=',$ANS->id)
												 ->where('MIDRID','=',$Data->id)
												 ->where('Deleted','=',0)
												 ->first();
												 
												 if(count($REC) == 0)
												 {
													  
													 array_push($data_row, 'No');
												 }
												 else
												 {
													
													 array_push($data_row, 'Yes');
												 }
											 }
									 }
									
									 
						}
				
				array_push($data_row, $Data->AchivedMark);
				array_push($data_row, $Data->Comments);
               
                array_push($printablearray, $data_row);
                            
                }
				

 
               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseInstructorGradingDetailReport' . date('Y-m-d'));
            
  }
	
	public function LoadHOInstructorGradingFullDetailsReport()
	{
		
		$District = Input::get('District');
		if($District != 'All')
		{
			
		$DistrictName  = District::where('DistrictCode','=',$District)->pluck('DistrictName');
		
		}
		else
		{
			$DistrictName  = $District;
		}
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';
		
		$AllQuestions = DB::select(DB::raw("select distinct moinstructorcriteriaquestion.id,moinstructorcriteriaquestion.QuestionInSinhala,
										  moinstructorcriteriaquestion.QuestionInEnglish,moinstructorcriteriaquestion.AnswerTypeId
										  from moinstructorgradingresulttrans
										  left join moinstructorcriteriaquestion
										  on moinstructorgradingresulttrans.QuestionID=moinstructorcriteriaquestion.id
										  where moinstructorgradingresulttrans.Deleted=0
										  and moinstructorgradingresulttrans.Year='".$Year."'
										  and moinstructorcriteriaquestion.Deleted=0"));
										  
		$CountAllQuestions = count($AllQuestions);
            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Instructor Grading Detail Report<pre><h5> Year:'.$Year.' District '.$DistrictName.' With NVTI</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">No</th>
							<th align="center" class="center" rowspan="2">Year</th>
							<th align="center" class="center" rowspan="2">Batch</th>
                            <th align="center" class="center" rowspan="2">District</th>
							<th align="center" class="center" rowspan="2">Centre Name</th>
                            <th align="center" class="center" rowspan="2">Course Name</th>
							<th align="center" class="center" rowspan="2">NVQ Level</th>
							<th align="center" class="center" rowspan="2">Duration</th>
							<th align="center" class="center" rowspan="2">Instructor Name</th>
							<th align="center" class="center" rowspan="2">EPF No</th>';
							
						
						 foreach($AllQuestions as $QA)
						 {
							 $UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('AnswerWeight')->get();
							  $anscount = count($UniqAnswersForQuestion);
							
							 $html.='<th align="center" class="center" colspan="'.$anscount.'">'.$QA->QuestionInSinhala.'<br/>'.$QA->QuestionInEnglish.'</th>';
							
						 }
						  $html.='<th align="center" class="center"  rowspan="2">Total Mark Achived(Out of 700)</th>
								  <th align="center" class="center"  rowspan="2">Comments</th></tr>';
						  $html.='<tr align="center">';		  
						foreach($AllQuestions as $QA)
						 {
						  $AllAnswers = DB::select(DB::raw("select *
														    from moinstructorquestionanswer
														    where moinstructorquestionanswer.Deleted=0
														    and moinstructorquestionanswer.QuestionId='".$QA->id."'
														    order by moinstructorquestionanswer.QuestionId,moinstructorquestionanswer.AnswerWeight DESC"));
						
						  if(count($AllAnswers) == 0)
						  {
							 $html.='<th align="center" class="center"></th>';  
						  }
						  else
						  {
							 foreach($AllAnswers as $QAA)
							 {
								 
								 $html.='<th align="center" class="center">'.$QAA->AnswerInSinhala.'<br/>'.$QAA->AnswerInEnglish.'</th>';
								 
							 }
						  }
						 }
						  $html.='</tr>';
						 
                        
                    $html.='</thead>
                    <tbody>';
     $i = 1;
			if ($District == 'All') 
			{
				$sqldis="select moinstructorgradingresult.id,
						 district.DistrictName,
						 organisation.OrgaName,organisation.Type,
						 coursedetails.CourseName,
						 coursedetails.Duration,
						 coursedetails.CourseLevel,
						  moinstructor.EPFNo,
						  moinstructor.Name,
						  moinstructorgradingresult.TotalWeight,
						  moinstructorgradingresult.AchivedMark,
						  moinstructorgradingresult.Year,
						  moinstructorgradingresult.Batch,
						 moinstructorgradingresult.Comments
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  order by district.DistrictName,organisation.OrgaName,moinstructorgradingresult.Year,Batch,coursedetails.CourseName,CourseLevel
						";
			}
			else 
			{
			   $sqldis="select moinstructorgradingresult.id,
						 district.DistrictName,
						 organisation.OrgaName,organisation.Type,
						 coursedetails.CourseName,
						 coursedetails.Duration,
						 coursedetails.CourseLevel,
						  moinstructor.EPFNo,
						  moinstructor.Name,
						  moinstructorgradingresult.TotalWeight,
						  moinstructorgradingresult.AchivedMark,
						  moinstructorgradingresult.Year,
						  moinstructorgradingresult.Batch,
						 moinstructorgradingresult.Comments
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  and district.DistrictCode='".$District."'
						  order by district.DistrictName,organisation.OrgaName,moinstructorgradingresult.Year,Batch,coursedetails.CourseName,CourseLevel
						";
			  
			 
			}

         //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			

			   foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td class="left">'.$ps->Year.'</td>
							<td class="left">'.$ps->Batch.'</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->OrgaName.'('.$ps->Type.')</td>
							<td class="center">'.$ps->CourseName.'</td>
							<td class="center">'.$ps->CourseLevel.'</td>
							<td class="center">'.$ps->Duration.'</td>
							<td class="center">'.$ps->Name.'</td>
							<td class="center">'.$ps->EPFNo.'</td>';
							
						 foreach($AllQuestions as $QA)
						 {
							 
							 if($QA->AnswerTypeId == 2)
							 {
								 //user input
								$UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('id')->get();
									if(count($UniqAnswersForQuestion) == 0)
									{
										$REC = MoInstructorGradingResultTrans::where('QuestionID','=',$QA->id)
											 ->where('AnswerID','=',999999)
											 ->where('MIDRID','=',$ps->id)
											 ->where('AnswerType','=','UI')
											 ->where('Deleted','=',0)
											 ->first();
										
										 $html.='<td class="center">'.$REC->AchivedMark.'</td>';
									}
							 }
						 	 else
							 {
								 //selection answer
								 //$UniqAnswersForQuestion = MOInstructorQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
														//->orderBy('id')->get();
									 $AllAnswers = DB::select(DB::raw("select *
														    from moinstructorquestionanswer
														    where moinstructorquestionanswer.Deleted=0
														    and moinstructorquestionanswer.QuestionId='".$QA->id."'
														    order by moinstructorquestionanswer.QuestionId,moinstructorquestionanswer.AnswerWeight DESC"));
														
									foreach($AllAnswers as $ANS)
									 {
										  $REC = MoInstructorGradingResultTrans::where('QuestionID','=',$QA->id)
										 ->where('AnswerID','=',$ANS->id)
										 ->where('MIDRID','=',$ps->id)
										 ->where('Deleted','=',0)
										 ->first();
										 
										 if(count($REC) == 0)
										 {
											  
											 $html.='<td class="center"></td>';
										 }
										 else
										 {
											
											 $html.='<td class="center"><font color="red"><i class="icon-ok bigger-130"></i></font></td>';
										 }
									 }
							 } 
							 
							 
							
							 
							 
						 } 
							
							
                            $html.='<td class="center">'.$ps->AchivedMark.'</td>
							
							<td class="center">'.$ps->Comments.'</td><tr>';
							
 							
                            
                } 
				
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewHOInstructorGradingFullDetailsReport()
	{
		$method = Request::getMethod();
        $view = View::make('MOInstructorMonitor.ViewHOCenterGradeFullDetailsReport');
    
        $view->District = District::orderBy('DistrictName')->get();
    
		if ($method == "GET") 
		{
			return $view;
		}
	}
    public function DeleteADDDCriteriaFormsEntered()
	{
		$id = Input::get('id');
		$deleteHOMORes = MOToAdGradingResults::where('id','=',$id)->update(array('Deleted' => 1));
		$deleteHOMOResTrans = MOToAdGradingResultsTrans::where('MIDRID','=',$id)->update(array('Deleted' => 1));
		return Redirect::to('ViewADDDCriteriaForms');
	}
	
	public function PrintADDDCriteriaFormsEntered()
  {
    $resID = Input::get('resID');
    $html = '';
   
	$UserOrgID = User::getSysUser()->organisationId; 
	$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$OrgaType = $OegaType;
	$Districts = District::orderBy('DistrictName')->get();
	$rec = MOToAdGradingResults::where('id','=',$resID)->first();
    $getDisCode = organisation::where('id','=',$rec->CenterId)->pluck('DistrictCode');
	$disNAme = District::where('DistrictCode','=',$getDisCode)->pluck('DistrictName');
	$OrgaName = Organisation::where('id','=',$rec->CenterId)->pluck('OrgaName');
	$OrgaType = Organisation::where('id','=',$rec->CenterId)->pluck('Type');
	$InsIni = Employee::where('id','=',$rec->EmpID)->pluck('Initials');
	$InsName = Employee::where('id','=',$rec->EmpID)->pluck('LastName');
	$InsEPF = Employee::where('id','=',$rec->EmpID)->pluck('EPFNo');
	$DesignationID = Employee::where('id','=',$rec->EmpID)->pluck('CurrentDesignation');
	$Designation = EmployeeCode::where('id','=',$DesignationID)->pluck('Designation');
    

  
	$Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='AD'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));

    $FTmatkC = 0;
    $ATmarkC = 0;
    $FTotal = 0;
    $ATotal = 0;

    $html = '<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>ියෝජ්‍ය/සහකාර අධ්‍යක්ෂවරු  අධීක්ෂණය(ප්‍රධාන කාර්යාලය)</title>
    </head>
    <H4><Center><u>නියෝජ්‍ය/සහකාර අධ්‍යක්ෂවරුන් සඳහා කාර්ය සාධන ඇගයීම  '.$rec->Year.'</u></center></H4>
   
   
    <table cellspacing="10" align="center">
	<tr><td>දිස්ත්‍රික්කය </td><td>'.$disNAme.'</td><td>මධ්‍යස්ථානය</td><td>'.$OrgaName.'</td></tr>
	<tr><td>නම</td> <td>'.$InsIni.' '.$InsName.'</td> <td>EPF අංකය   </td><td>'.$InsEPF.'</td></tr>';
     
      
    $html.='</table>
    <hr/>';
	$ii = 1;
	foreach($Criteris as $cc)
		{
			
						$GetQuestion = MOToAdCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->where('CriteriaId','=',$cc->id)->orderBy('QOrder')->get();
						
    $html.=' 
	<table  align="center" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	$i = 1;
	   $html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black"> </font></b>'.$ii.'</td>
							  <td class="center"><b><font color="black">'.$cc->TypeInSinhala.'(ලකුණු '.$cc->FullWeightFoTheSection.')</br> '.$cc->TypeInEnglish.'</font></b></td>
							   <td class="center"><b><font color="black">මුළු ලකුණු </font></b></td>
							   <td class="center"><b><font color="black">පිළිතුර </font></b></td>
                               <td class="center"><b><font color="black">ලැබු ලකුණු</font></b></td>
							   <td class="center"><b><font color="black">ලකුණු අඩුකිරීම්</font></b></td>
							   <td class="center"><b><font color="black">ලකුණු අඩුකිරීමට හේතුව</font></b></td>
							   <td class="center"><b><font color="black">ලබාගත් මුළු ලකුණු ප්‍රමාණය</font></b></td>
                            </tr>
                            
                     ';
					 $i = 1;
    foreach($GetQuestion as $c)
     {         
         
					 $html.='<tr>
                                    <td >'.$ii.'.'.$i++.'</td>
                                    <td >'.$c->QuestionInSinhala.'<br/>'.$c->QuestionInEnglish.'</td>';
									 
									
								$AnswerType = MOToAdAnswerType::where('id','=',$c->AnswerTypeId)->pluck('TypeCode');  
									
                                   
                               if($AnswerType == 'SE' || $AnswerType == 'YN')
								{
									$html.='<td class="center">'.$c->FullWeight.'</td>';
									$GetAnswers = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('Active','=',1)->where('QuestionId','=',$c->id)->orderBy('AnswerWeight','DESC')->get();
									$SelectedAns = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AnswerID');
									$AnswerName = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInSinhala');
									$AnswerNameE = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInEnglish');
									$Answeight = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerWeight');
									
									$html.='
                                    <td >'.$AnswerName.'<br/>'.$AnswerNameE.'</td>
									<td >'.$Answeight.'</td>';
									$decmark = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductMark');
									$decreason = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductReason');
									$FinalMar = $Answeight-$decmark;
									
									$html.='<td >'.$decmark.'</td><td >'.$decreason.'</td><td >'.$FinalMar.'</td>
									';
                                  
								}
								elseif($AnswerType == 'UI')
								{
									$html.='<td class="center">'.$c->FullWeight.' for the Category</td>';
									$GetAnswers = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('Active','=',1)->where('QuestionId','=',$c->id)->orderBy('AnswerWeight','DESC')->get();
									$SelectedAns = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AnswerID');
									$AnswerName = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInSinhala');
									$AnswerNameE = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInEnglish');
									$Answeight = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerWeight');
									$grselectid = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('AchivedMark');
									$AchivemarkUI = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('AchivedMarkValueForUI');
									$decmark = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductMark');
									$decreason = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductReason');
									$FinalMar = $AchivemarkUI-$decmark;
									
									$html.='
                                    <td >'.$grselectid.' (User Input Value)</td>
									<td >'.$AchivemarkUI.'</td>
									<td >'.$decmark.'</td>
									<td >'.$decreason.'</td>
									<td >'.$FinalMar.'</td>';
								}
								else
								{
									$html.='<td class="center">'.$c->FullWeight.' for the Category</td>';
									$SelectedAns = MoInstructorGradingResultTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AchivedMark');
									$decmark = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductMark');
									$decreason = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductReason');
									$FinalMar = $SelectedAns-$decmark;
									
									$html.='
									<td >System Calculation</td>
                                    <td >'.$SelectedAns.'</td>
									<td >'.$decmark.'</td>
									<td >'.$decreason.'</td>
									<td >'.$FinalMar.'</td>';
								}
                                
                                    
                                    
                
                                
              

                   $html.=' </tr>';                
             
                               
                           
    }
	 $ii++;
	 
	 $html.='</table></br>';
		}
             
      $html.='<pre bgcolor="RED"><h4><b><font color="RED"> Final Results Summary</font></b></h4></pre>
							<table  align="left" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
							  <tr id="d0" style="background-color:#CC9999">
								     
                                  
                                    <th class="center">Total Marks</th>
									<th class="center">Total Achieved Marks</th>
									<th class="center">Total Deduction Marks</th>
									<th class="center">Final Mark</th>
                                </tr>
							   <tr>
								    
									<th class="center"><font color="blue">'.$rec->TotalWeight.'</font></th>
                                   <th class="center"><font color="blue">'.$rec->AchivedMark.'</font></th>
									<th class="center"><font color="blue">'.$rec->TotalMarksDeduct.'</font></th>';
									$FachMark = $rec->AchivedMark-$rec->TotalMarksDeduct;
									$html.='<th class="center"><font color="blue">'.$FachMark.'</font></th>
                                </tr>
								
                            
                        </table></br>';
			 /*  $html.='<tr>
							<td class="center"><b><font color="green"><center></center></font></b></td>
                            <td class="center"><b><font color="green"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="green"></font></b></td>
							 <td class="center"><b><font color="green"><center>පාඨමාලා සංඛ්‍යාව</center></font></b></td>
                            <td class="center"><b><font color="green">'.$rec->NoOfCourses.'</font></b></td>

              </tr>';
			  $html.='<tr>
							<td class="center"><b><font color="red"><center></center></font></b></td>
                            <td class="center"><b><font color="red"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="red"></font></b></td>
							 <td class="center"><b><font color="red"><center>ශ්‍රේණිය</center></font></b></td>
                            <td class="center"><b><font color="red">'.$rec->CenterGrade.'</font></b></td>

              </tr> 
			  */
             

             
           $html.='</br/><h4 style="page-break-before: always"><u>විශේෂ සටහන් (Other Comments)</u></h4><p style="text-align: justify;">';
	
	
	
	
	$html.='<p>'.$rec->Comments.'</p>
	
    <body></html>';

    return $html;
  }
	
	 public function ViewADDDCriteriaFormsEntered()
  {
        $ID = Input::get('id');
        $view = View::make('MoToAdGrading.ADDDView');
	    $UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$view->OrgaType = $OegaType;
		$view->Districts = District::orderBy('DistrictName')->get();
		$rec = MOToAdGradingResults::where('id','=',$ID)->first();
		$view->rec = $rec;
      
      $view->CenterMoniPlan = $ID;
   

    $method=Request::getMethod();
    //$Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='AD'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));
	$view->Criteris = $Criteris;
   // $view->Questions = $Questions;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          return $view;
        }
  }
	
	public function EditADDDCriteriaForms()
	{
	$ID = Input::get('id');
	$view = View::make('MoToAdGrading.ADEdit');
	//$Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='AD'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Employee = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
										  order by employee.EPFNo"));
	
	$rec = MOToAdGradingResults::where('id','=',$ID)->first();
	$DistrictCode = Organisation::where('id','=',$rec->CenterId)->pluck('DistrictCode');
	$view->rec = $rec;
	$view->DistrictCode = $DistrictCode;
	$view->Criteris = $Criteris;
	
	
     if($OegaType == 'HO')
    {
		$view->Districts = District::orderBy('DistrictName')->get();
        $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->whereIn('Type',['NVTI','DO','HO'])->where('DistrictCode','=',$DistrictCode)->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereIn('Type',['NVTI','DO'])
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
				  and organisation.Type  in('PO','DO','NVTI')
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
 
    //$view->Questions = $Questions;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
		if($method == 'POST')
		{
		   $ResId = Input::get('resID');
		   $District = Input::get('District');
		   $CenterID = Input::get('CenterID');
		   $EmpID = Input::get('EmpID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
		   $DeductMark = Input::get('DeductMark');
		   $DeductReason = Input::get('DeductReason');
		   
           //Clear data tables
           $deletemonitoringTransTable = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterID','=',$CenterID)->update(array("Deleted" => 1));
           $deleteMonitoringResultTable = MOToAdGradingResults::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterId','=',$CenterID)->update(array("Deleted" => 1));
          
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
		   $Totalrequestedmaterial = 0;
		   $Totalreleasedmaterial = 0;
		   $centerGrading = 0;
		   $InstrutorRanking = 0;
		   $totMarkFullDec = 0;
		   $totachiveUI = 0;
		   $StuTargetFullTime = 0;
		   $StuTargetPartTime = 0;
		   $StuTargetAchiveFullTime = 0;
		   $StuTargetAchivePartTime = 0;
		   $ADStudentAchinementFullTime = 0;
		   $totFullTime = 0;
		   $ADStudentAchinementPartTime = 0;
		   $totPartTime = 0;
		   
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOToAdCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOToAdAnswerType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
			  
			  $totMarkFullDec = $totMarkFullDec + $DeductMark[$i];
              if($getCalType == 'SE' || $getCalType == 'YN')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = MOToAdCriteriaQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new MOToAdGradingResultsTrans();
                $c->QuestionID = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $mark;
				$c->DeductMark = $DeductMark[$i];
				$c->DeductReason =	$DeductReason[$i];			
                $c->CenterID = $CenterID;
                $c->Year = $Year;
				$c->EmpID = $EmpID;
				$c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              elseif($getCalType == 'UI')
              {
				  
				 
					  $AnswerWeghtID = $AnswerID[$i];
				      $c = new MOToAdGradingResultsTrans();
				  
						 if($i == 17)
						 {
							 //user input
							  $Totalrequestedmaterial = $AnswerWeghtID;
						 }
						 elseif($i == 18)
						 {
							 //user input
						 	 $Totalreleasedmaterial = $AnswerWeghtID;
						 }
						 elseif($i == 3)
						 {
							 $StuTargetFullTime = $AnswerWeghtID;
						 }
						 elseif($i == 4)
						 {
							 $StuTargetAchiveFullTime = $AnswerWeghtID;
						 }
						 elseif($i == 5)
						 {
							$StuTargetPartTime =  $AnswerWeghtID;
						 }
						 elseif($i == 6)
						 {
							 $StuTargetAchivePartTime = $AnswerWeghtID;
						 }
						 else
						 {
							 
						 }
							
						$c->QuestionID = $IndividualQuestionsID;
							$c->AnswerID = 999999;
							$c->AnswerType = $getCalType;
							$c->AchivedMark = $AnswerWeghtID;
							//$c->AchivedMarkValueForUI = $totachiveUI;
							$c->DeductMark = $DeductMark[$i];
							$c->DeductReason =	$DeductReason[$i];			
							$c->CenterId = $CenterID;
							$c->Year = $Year;
							$c->EmpID = $EmpID;
							$c->User = User::getSysUser()->userID;
							$c->save();

              
              }
			  else
			  {
				  //system  calculate
				  $AnswerWeghtID = $AnswerID[$i];//Syetem Calculation as value
				 
						if($i == 13)
						 {//center grading
							 //user input
							 $centerYear = $Year-1;//replace tear to current Year
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgmark = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															  from hocentremonitoringresult
															  left join organisation
															  on hocentremonitoringresult.CenterId=organisation.id
															  left join district
															  on organisation.DistrictCode=district.DistrictCode
															  where hocentremonitoringresult.Deleted=0
															  and hocentremonitoringresult.Year='".$centerYear."'
															  and organisation.Type NOT IN('Attached')
															  and district.ProvinceCode='".$ProvinceID."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'DO')
							 {
								 
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.Type NOT IN('NVTI','Attached')
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'NVTI')
							 {
								  $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.id='".$CenterID."'
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 else
							 {
							 }
							 
							 $FinalCenterGradeValue = round((($TotalCengrademark/5)*100),0);
							 $FinalCenterGradeValueMark = 0;
							 if($FinalCenterGradeValue>= 90)
							  {
								  $FinalMark = $FinalMark + 5;
								  $FinalCenterGradeValueMark = 5;
							  }
							  elseif($FinalCenterGradeValue<=89 && $FinalCenterGradeValue>=75)
							  {
								  $FinalMark = $FinalMark + 3;
								  $FinalCenterGradeValueMark = 3;
							  }
							  elseif($FinalCenterGradeValue<=74 && $FinalCenterGradeValue>=50)
							  {
								  $FinalMark = $FinalMark + 2;
								  $FinalCenterGradeValueMark = 2;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $FinalCenterGradeValueMark = 0;
							  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $FinalCenterGradeValueMark;
							  $c->AchivedMarkValueForUI = $FinalCenterGradeValueMark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason =	$DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 elseif($i == 14)
						 {
							 //instructor ranking
							 //user input
							 $centerYear = $Year-2;//replace tear to current Year
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgPercentage = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.ProvinceCode='".$ProvinceID."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
								
							}
							 elseif($CenterType == 'DO')
							 {
								 
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and organisation.Type NOT IN('NVTI')
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 elseif($CenterType == 'NVTI')
							 {
								$ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								$sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
														   from moinstructorgradingresult
														   left join organisation
														   on moinstructorgradingresult.CenterId=organisation.id
														   left join district
														   on organisation.DistrictCode=district.DistrictCode
														   where moinstructorgradingresult.Deleted=0
														   and organisation.id='".$CenterID."'
														   and moinstructorgradingresult.Year='".$centerYear."'
														   and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 else
							 {
							 }
							 
							$TotalInsgrademark = 0;
															  
								 if($avgPercentage>= 90)
								 {
									  $FinalMark = $FinalMark + 5;
									  $TotalInsgrademark = 5;
								  }
								  elseif($avgPercentage<=89 && $avgPercentage>=75)
								  {
									  $FinalMark = $FinalMark + 3;
									  $TotalInsgrademark = 3;
								  }
								  elseif($avgPercentage<=74 && $avgPercentage>=50)
								  {
									  $FinalMark = $FinalMark + 2;
									  $TotalInsgrademark = 2;
								  }
								  else
								  {
									  $FinalMark = $FinalMark + 0;
									  $TotalInsgrademark = 0;
								  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $TotalInsgrademark;
							  $c->AchivedMarkValueForUI = $TotalInsgrademark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason = $DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 else
						 {
							 
						 }
				  
				  
				  
			  }
           }
	
	
							   $TotalPercentagematerial = round((($Totalreleasedmaterial/$Totalrequestedmaterial)*100),0);
							  if($TotalPercentagematerial>= 90)
							  {
								  $FinalMark = $FinalMark + 10;
								  $totachiveUI = 10;
							  }
							  elseif($TotalPercentagematerial<=89 && $TotalPercentagematerial>=75)
							  {
								  $FinalMark = $FinalMark + 7;
								  $totachiveUI = 7;
							  }
							  elseif($TotalPercentagematerial<=74 && $TotalPercentagematerial>=50)
							  {
								  $FinalMark = $FinalMark + 4;
								  $totachiveUI = 4;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totachiveUI = 0;
							  }
							  
							 // return $totachiveUI;
		  
			// update user input achived marks
			$UpdateuIachive = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[37,38])
			->update(array('AchivedMarkValueForUI' => $totachiveUI));
			
			//AD user Input
		  
		  $ADStudentAchinementFullTime = round((($StuTargetAchiveFullTime/$StuTargetFullTime)*100),0);
							  if($ADStudentAchinementFullTime>= 90)
							  {
								  $FinalMark = $FinalMark + 3;
								  $totFullTime = 3;
							  }
							  elseif($ADStudentAchinementFullTime<=89 && $ADStudentAchinementFullTime>=75)
							  {
								  $FinalMark = $FinalMark + 2;
								  $totFullTime = 2;
							  }
							  elseif($ADStudentAchinementFullTime<=74 && $ADStudentAchinementFullTime>=50)
							  {
								  $FinalMark = $FinalMark + 1;
								  $totFullTime = 1;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totFullTime = 0;
							  }
		$UpdateuIachive2 = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[23,24])->update(array('AchivedMarkValueForUI' => $totFullTime));  
		 
		$ADStudentAchinementPartTime = round((($StuTargetAchivePartTime/$StuTargetPartTime)*100),0);
							  if($ADStudentAchinementPartTime>= 90)
							  {
								  $FinalMark = $FinalMark + 3;
								  $totPartTime = 3;
							  }
							  elseif($ADStudentAchinementPartTime<=89 && $ADStudentAchinementPartTime>=75)
							  {
								  $FinalMark = $FinalMark + 2;
								  $totPartTime = 2;
							  }
							  elseif($ADStudentAchinementPartTime<=74 && $ADStudentAchinementPartTime>=50)
							  {
								  $FinalMark = $FinalMark + 1;
								  $totPartTime = 1;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totPartTime = 0;
							  }
		$UpdateuIachive1 = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[25,26])->update(array('AchivedMarkValueForUI' => $totPartTime));  
		 //AD user Input end
		 
		  
			$totweight = MOToAdCriteriaCategory::where('Deleted','=',0)->where('EmpTypeId','=',1)->where('Active','=',1)->sum('FullWeightFoTheSection');
            $d = new MOToAdGradingResults();
            $d->CenterId = $CenterID;
            $d->Year = $Year;
			$d->TotalWeight = $totweight;
			$d->AchivedMark = $FinalMark;
			
			$d->TotalMarksDeduct = $totMarkFullDec;
            $d->Comments = $Dreason;
			$d->EmpID = $EmpID;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = MOToAdGradingResults::where('Deleted','=',0)->where('Year','=',$Year)->where('CenterId','=',$CenterID)->where('EmpID','=',$EmpID)->pluck('id');
			
			$updateHOCentreMonitoringResultTrans = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)
			->update(array('MIDRID' => $HOCMRId));


            
            return Redirect::to('ViewADDDCriteriaForms')->with("done", true);
		}
		
	}
	
	public function DownloadADDDGradingFormsExcel()
  {
    
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$Year = Input::get('Year');
	$Center = Input::get('CenterID');
	$District = Input::get('District');
	$EmpID = Input::get('EmpID');
    $userEMpid = User::getSysUser()->EmpId;
   
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','Province','District','Centre','Centre Type','Designation','Officer Name','Total Achived(100)','Total Deduction','Final Mark Achived(100)','Comments');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
    


   $userEMpid = User::getSysUser()->EmpId;

           if($District == 'All' && $Center  == 'All' && $EmpID == 'All')
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
				  and motoadgradingresult.Year='".$Year."'
				  order by district.DistrictName"));
				
			}
			else
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and district.DistrictCode='".$District."'
				  and motoadgradingresult.Year='".$Year."'
				  and organisation.id='".$Center."'
				  and employee.id='".$EmpID."'
				  order by district.DistrictName"));
				
			}
           //return $sql;
            

            $Count = count($dataset);


                foreach($dataset as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->Year);
				array_push($data_row, $Data->ProvinceName);
                array_push($data_row, $Data->DistrictName);
				array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				array_push($data_row, $Data->Designation);
				array_push($data_row, $Data->Initials.' '.$Data->LastName);
				array_push($data_row, $Data->AchivedMark);
				array_push($data_row, $Data->TotalMarksDeduct);
				$Fmark = 0;
				$Fmark = $Data->AchivedMark - $Data->TotalMarksDeduct;
				array_push($data_row, $Fmark);
				array_push($data_row, $Data->Comments);
				
				
			
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('TOGradingReport-I' . date('Y-m-d'));
            
  }
	
  public function ViewADDDCriteriaForms()
  {
    $view = View::make('MoToAdGrading.AView');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Employee = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
										  order by employee.EPFNo"));
	//$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
    if($OegaType == 'HO')
    {
		 $view->Districts = District::orderBy('DistrictName')->get();
         $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->whereIn('Type',['NVTI','DO','HO'])->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereIn('Type',['NVTI','DO'])
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
				  and organisation.Type  in('PO','DO','NVTI')
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
	 
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
			$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
				  order by district.DistrictName"));
				  $view->DataSet = $dataset;
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
			$Center = Input::get('CenterID');
			$District = Input::get('District');
			$EmpID = Input::get('EmpID');
            $userEMpid = User::getSysUser()->EmpId;

            
			if($District == 'All' && $Center  == 'All' && $EmpID == 'All')
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
				  and motoadgradingresult.Year='".$Year."'
				  order by district.DistrictName"));
				
			}
			else
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and district.DistrictCode='".$District."'
				  and motoadgradingresult.Year='".$Year."'
				  and organisation.id='".$Center."'
				  and employee.id='".$EmpID."'
				  order by district.DistrictName"));
				
			}
			
			
			
          //$courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
		  $view->PCenter = $Center;
		  $view->PDistrict = $District;
          $view->PEmpID = $EmpID;
		  $view->DataSet = $dataset;
          return $view;
        }

  }
	
	public function loaddistrictcentersinADName()
	{
		
		$CenterID = Input::get('CenterID');
		
      
	  $sql = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										 and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
										  and employee.CurrentOrgaID='".$CenterID."'
										  order by employee.EPFNo"));
	  
	  return json_encode($sql);
	}
	
	public function CreateADDDCriteriaForms()
  {
    $view = View::make('MoToAdGrading.ADCreate');
    $Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='AD'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));
	
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Employee = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and (employmentcode.Designation like 'Assistant Director' || employmentcode.Designation like 'Deputy Director')
										  order by employee.EPFNo"));
	//$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
    if($OegaType == 'HO')
    {
		 $view->Districts = District::orderBy('DistrictName')->get();
         $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->whereIn('Type',['NVTI','DO','HO'])->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereIn('Type',['NVTI','DO'])
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
				  and organisation.Type  in('PO','DO','NVTI')
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
 
    $view->Criteris = $Criteris;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
		   $District = Input::get('District');
		   $CenterID = Input::get('CenterID');
		   $EmpID = Input::get('EmpID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
		   $DeductMark = Input::get('DeductMark');
		   $DeductReason = Input::get('DeductReason');
         

           //Clear data tables
           $deletemonitoringTransTable = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterID','=',$CenterID)->update(array("Deleted" => 1));
           $deleteMonitoringResultTable = MOToAdGradingResults::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterId','=',$CenterID)->update(array("Deleted" => 1));
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
		   $Totalrequestedmaterial = 0;
		   $Totalreleasedmaterial = 0;
		   $centerGrading = 0;
		   $InstrutorRanking = 0;
		   $totMarkFullDec = 0;
		   $totachiveUI = 0;
		   $StuTargetFullTime = 0;
		   $StuTargetPartTime = 0;
		   $StuTargetAchiveFullTime = 0;
		   $StuTargetAchivePartTime = 0;
		   $ADStudentAchinementFullTime = 0;
		   $totFullTime = 0;
		   $ADStudentAchinementPartTime = 0;
		   $totPartTime = 0;
		   
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOToAdCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOToAdAnswerType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
			  
			  $totMarkFullDec = $totMarkFullDec + $DeductMark[$i];
              if($getCalType == 'SE' || $getCalType == 'YN')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = MOToAdCriteriaQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new MOToAdGradingResultsTrans();
                $c->QuestionID = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $mark;
				$c->DeductMark = $DeductMark[$i];
				$c->DeductReason =	$DeductReason[$i];			
                $c->CenterID = $CenterID;
                $c->Year = $Year;
				$c->EmpID = $EmpID;
				$c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              elseif($getCalType == 'UI')
              {
				  
				 
					  $AnswerWeghtID = $AnswerID[$i];
				      $c = new MOToAdGradingResultsTrans();
				  
						 if($i == 17)
						 {
							 //user input
							 $Totalrequestedmaterial = $AnswerWeghtID;
						 }
						 elseif($i == 18)
						 {
							 //user input
						 	 $Totalreleasedmaterial = $AnswerWeghtID;
						 }
						 elseif($i == 3)
						 {
							 $StuTargetFullTime = $AnswerWeghtID;
						 }
						 elseif($i == 4)
						 {
							 $StuTargetAchiveFullTime = $AnswerWeghtID;
						 }
						 elseif($i == 5)
						 {
							$StuTargetPartTime =  $AnswerWeghtID;
						 }
						 elseif($i == 6)
						 {
							 $StuTargetAchivePartTime = $AnswerWeghtID;
						 }
						 else
						 {
							 
						 }
						 
						 
							  
							$c->QuestionID = $IndividualQuestionsID;
							$c->AnswerID = 999999;
							$c->AnswerType = $getCalType;
							$c->AchivedMark = $AnswerWeghtID;
							//$c->AchivedMarkValueForUI = $totachiveUI;
							$c->DeductMark = $DeductMark[$i];
							$c->DeductReason =	$DeductReason[$i];			
							$c->CenterId = $CenterID;
							$c->Year = $Year;
							$c->EmpID = $EmpID;
							$c->User = User::getSysUser()->userID;
							$c->save();

              
              }
			  else
			  {
				  //system  calculate
				  $AnswerWeghtID = $AnswerID[$i];//Syetem Calculation as value
				 
						if($i == 13)
						 {//center grading
							 //user input
							 $centerYear = $Year-1;//replace tear to current Year
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgmark = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															  from hocentremonitoringresult
															  left join organisation
															  on hocentremonitoringresult.CenterId=organisation.id
															  left join district
															  on organisation.DistrictCode=district.DistrictCode
															  where hocentremonitoringresult.Deleted=0
															  and hocentremonitoringresult.Year='".$centerYear."'
															  and organisation.Type NOT IN('Attached')
															  and district.ProvinceCode='".$ProvinceID."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'DO')
							 {
								 
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.Type NOT IN('NVTI','Attached')
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'NVTI')
							 {
								  $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.id='".$CenterID."'
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 else
							 {
							 }
							 
							 $FinalCenterGradeValue = round((($TotalCengrademark/5)*100),0);
							 $FinalCenterGradeValueMark = 0;
							 if($FinalCenterGradeValue>= 90)
							  {
								  $FinalMark = $FinalMark + 5;
								  $FinalCenterGradeValueMark = 5;
							  }
							  elseif($FinalCenterGradeValue<=89 && $FinalCenterGradeValue>=75)
							  {
								  $FinalMark = $FinalMark + 3;
								  $FinalCenterGradeValueMark = 3;
							  }
							  elseif($FinalCenterGradeValue<=74 && $FinalCenterGradeValue>=50)
							  {
								  $FinalMark = $FinalMark + 2;
								  $FinalCenterGradeValueMark = 2;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $FinalCenterGradeValueMark = 0;
							  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $FinalCenterGradeValueMark;
							  $c->AchivedMarkValueForUI = $FinalCenterGradeValueMark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason =	$DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 elseif($i == 14)
						 {
							 //instructor ranking
							 //user input
							 $centerYear = $Year-2;//replace tear to current Year
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgPercentage = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.ProvinceCode='".$ProvinceID."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
								
							}
							 elseif($CenterType == 'DO')
							 {
								 
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and organisation.Type NOT IN('NVTI')
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 elseif($CenterType == 'NVTI')
							 {
								$ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								$sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
														   from moinstructorgradingresult
														   left join organisation
														   on moinstructorgradingresult.CenterId=organisation.id
														   left join district
														   on organisation.DistrictCode=district.DistrictCode
														   where moinstructorgradingresult.Deleted=0
														   and organisation.id='".$CenterID."'
														   and moinstructorgradingresult.Year='".$centerYear."'
														   and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 else
							 {
							 }
							 
							$TotalInsgrademark = 0;
															  
								 if($avgPercentage>= 90)
								 {
									  $FinalMark = $FinalMark + 5;
									  $TotalInsgrademark = 5;
								  }
								  elseif($avgPercentage<=89 && $avgPercentage>=75)
								  {
									  $FinalMark = $FinalMark + 3;
									  $TotalInsgrademark = 3;
								  }
								  elseif($avgPercentage<=74 && $avgPercentage>=50)
								  {
									  $FinalMark = $FinalMark + 2;
									  $TotalInsgrademark = 2;
								  }
								  else
								  {
									  $FinalMark = $FinalMark + 0;
									  $TotalInsgrademark = 0;
								  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $TotalInsgrademark;
							  $c->AchivedMarkValueForUI = $TotalInsgrademark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason = $DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 else
						 {
							 
						 }
				  
				  
				  
			  }
           }//end foreach
	
						//return $Totalrequestedmaterial;
							  $TotalPercentagematerial = round((($Totalreleasedmaterial/$Totalrequestedmaterial)*100),0);
							  if($TotalPercentagematerial>= 90)
							  {
								  $FinalMark = $FinalMark + 10;
								  $totachiveUI = 10;
							  }
							  elseif($TotalPercentagematerial<=89 && $TotalPercentagematerial>=75)
							  {
								  $FinalMark = $FinalMark + 7;
								  $totachiveUI = 7;
							  }
							  elseif($TotalPercentagematerial<=74 && $TotalPercentagematerial>=50)
							  {
								  $FinalMark = $FinalMark + 4;
								  $totachiveUI = 4;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totachiveUI = 0;
							  }
							  
							  // $totachiveUI;
			// update user input achived marks
			 $UpdateuIachivefgdfhg = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[37,38])->update(array('AchivedMarkValueForUI' => $totachiveUI));
		 
		  //AD user Input
		  
		  $ADStudentAchinementFullTime = round((($StuTargetAchiveFullTime/$StuTargetFullTime)*100),0);
							  if($ADStudentAchinementFullTime>= 90)
							  {
								  $FinalMark = $FinalMark + 3;
								  $totFullTime = 3;
							  }
							  elseif($ADStudentAchinementFullTime<=89 && $ADStudentAchinementFullTime>=75)
							  {
								  $FinalMark = $FinalMark + 2;
								  $totFullTime = 2;
							  }
							  elseif($ADStudentAchinementFullTime<=74 && $ADStudentAchinementFullTime>=50)
							  {
								  $FinalMark = $FinalMark + 1;
								  $totFullTime = 1;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totFullTime = 0;
							  }
		$UpdateuIachive2 = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[23,24])->update(array('AchivedMarkValueForUI' => $totFullTime));  
		 
		$ADStudentAchinementPartTime = round((($StuTargetAchivePartTime/$StuTargetPartTime)*100),0);
							  if($ADStudentAchinementPartTime>= 90)
							  {
								  $FinalMark = $FinalMark + 3;
								  $totPartTime = 3;
							  }
							  elseif($ADStudentAchinementPartTime<=89 && $ADStudentAchinementPartTime>=75)
							  {
								  $FinalMark = $FinalMark + 2;
								  $totPartTime = 2;
							  }
							  elseif($ADStudentAchinementPartTime<=74 && $ADStudentAchinementPartTime>=50)
							  {
								  $FinalMark = $FinalMark + 1;
								  $totPartTime = 1;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totPartTime = 0;
							  }
		$UpdateuIachive1 = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[25,26])->update(array('AchivedMarkValueForUI' => $totPartTime));  
		 //AD user Input end
			$totweight = MOToAdCriteriaCategory::where('Deleted','=',0)->where('EmpTypeId','=',1)->where('Active','=',1)->sum('FullWeightFoTheSection');
            $d = new MOToAdGradingResults();
            $d->CenterId = $CenterID;
            $d->Year = $Year;
			$d->TotalWeight = $totweight;
			$d->AchivedMark = $FinalMark;
			//$c->AchivedMarkValueForUI = $totachiveUI;
			$d->TotalMarksDeduct = $totMarkFullDec;
            $d->Comments = $Dreason;
			$d->EmpID = $EmpID;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = MOToAdGradingResults::where('Deleted','=',0)->where('Year','=',$Year)->where('CenterId','=',$CenterID)->where('EmpID','=',$EmpID)->pluck('id');
			
			$updateHOCentreMonitoringResultTrans = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)
			->update(array('MIDRID' => $HOCMRId));


            
            return Redirect::to('CreateADDDCriteriaForms')->with("done", true);

        }
    

  }
	
   public function DownloadTOGradingFormsExcel()
  {
    
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$Year = Input::get('Year');
	$Center = Input::get('CenterID');
	$District = Input::get('District');
	$EmpID = Input::get('EmpID');
    $userEMpid = User::getSysUser()->EmpId;
   
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','Province','District','Centre','Centre Type','Designation','Officer Name','Total Achived(100)','Total Deduction','Final Mark Achived(100)','Comments');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
    


   $userEMpid = User::getSysUser()->EmpId;

           if($District == 'All' && $Center  == 'All' && $EmpID == 'All')
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and motoadgradingresult.Year='".$Year."'
				  order by district.DistrictName"));
				
			}
			else
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and district.DistrictCode='".$District."'
				  and motoadgradingresult.Year='".$Year."'
				  and organisation.id='".$Center."'
				  and employee.id='".$EmpID."'
				  order by district.DistrictName"));
				
			}
           //return $sql;
            

            $Count = count($dataset);


                foreach($dataset as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->Year);
				array_push($data_row, $Data->ProvinceName);
                array_push($data_row, $Data->DistrictName);
				array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				array_push($data_row, $Data->Designation);
				array_push($data_row, $Data->Initials.' '.$Data->LastName);
				array_push($data_row, $Data->AchivedMark);
				array_push($data_row, $Data->TotalMarksDeduct);
				$Fmark = 0;
				$Fmark = $Data->AchivedMark - $Data->TotalMarksDeduct;
				array_push($data_row, $Fmark);
				array_push($data_row, $Data->Comments);
				
				
			
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('TOGradingReport-I' . date('Y-m-d'));
            
  }
	
		public function DeleteTOCriteriaFormsEntered()
	{
		$id = Input::get('id');
		$deleteHOMORes = MOToAdGradingResults::where('id','=',$id)->update(array('Deleted' => 1));
		$deleteHOMOResTrans = MOToAdGradingResultsTrans::where('MIDRID','=',$id)->update(array('Deleted' => 1));
		return Redirect::to('ViewTOCriteriaForms');
	}
	
	public function PrintTOCriteriaFormsEntered()
  {
    $resID = Input::get('resID');
    $html = '';
   
	$UserOrgID = User::getSysUser()->organisationId; 
	$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$OrgaType = $OegaType;
	$Districts = District::orderBy('DistrictName')->get();
	$rec = MOToAdGradingResults::where('id','=',$resID)->first();
    $getDisCode = organisation::where('id','=',$rec->CenterId)->pluck('DistrictCode');
	$disNAme = District::where('DistrictCode','=',$getDisCode)->pluck('DistrictName');
	$OrgaName = Organisation::where('id','=',$rec->CenterId)->pluck('OrgaName');
	$OrgaType = Organisation::where('id','=',$rec->CenterId)->pluck('Type');
	$InsIni = Employee::where('id','=',$rec->EmpID)->pluck('Initials');
	$InsName = Employee::where('id','=',$rec->EmpID)->pluck('LastName');
	$InsEPF = Employee::where('id','=',$rec->EmpID)->pluck('EPFNo');
	$DesignationID = Employee::where('id','=',$rec->EmpID)->pluck('CurrentDesignation');
	$Designation = EmployeeCode::where('id','=',$DesignationID)->pluck('Designation');
    

  
	$Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='TO'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));

    $FTmatkC = 0;
    $ATmarkC = 0;
    $FTotal = 0;
    $ATotal = 0;

    $html = '<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>පුහුණු නිලධාරී  අධීක්ෂණය(ප්‍රධාන කාර්යාලය)</title>
    </head>
    <H4><Center><u>පුහුණු නිලධාරීන් සඳහා කාර්ය සාධන ඇගයීම  '.$rec->Year.'</u></center></H4>
   
   
    <table cellspacing="10" align="center">
	<tr><td>දිස්ත්‍රික්කය </td><td>'.$disNAme.'</td><td>මධ්‍යස්ථානය</td><td>'.$OrgaName.'</td></tr>
	<tr><td>නම   </td> <td>'.$InsIni.' '.$InsName.'</td> <td>EPF අංකය   </td><td>'.$InsEPF.'</td></tr>';
     
      
    $html.='</table>
    <hr/>';
	$ii = 1;
	foreach($Criteris as $cc)
		{
			
						$GetQuestion = MOToAdCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->where('CriteriaId','=',$cc->id)->orderBy('QOrder')->get();
						
    $html.=' 
	<table  align="center" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	$i = 1;
	   $html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black"> </font></b>'.$ii.'</td>
							  <td class="center"><b><font color="black">'.$cc->TypeInSinhala.'(ලකුණු '.$cc->FullWeightFoTheSection.')</br> '.$cc->TypeInEnglish.'</font></b></td>
							   <td class="center"><b><font color="black">මුළු ලකුණු </font></b></td>
							   <td class="center"><b><font color="black">පිළිතුර </font></b></td>
                               <td class="center"><b><font color="black">ලැබු ලකුණු</font></b></td>
							   <td class="center"><b><font color="black">ලකුණු අඩුකිරීම්</font></b></td>
							   <td class="center"><b><font color="black">ලකුණු අඩුකිරීමට හේතුව</font></b></td>
							   <td class="center"><b><font color="black">ලබාගත් මුළු ලකුණු ප්‍රමාණය</font></b></td>
                            </tr>
                            
                     ';
					 $i = 1;
    foreach($GetQuestion as $c)
     {         
         
					 $html.='<tr>
                                    <td >'.$ii.'.'.$i++.'</td>
                                    <td >'.$c->QuestionInSinhala.'<br/>'.$c->QuestionInEnglish.'</td>';
									 
									
								$AnswerType = MOToAdAnswerType::where('id','=',$c->AnswerTypeId)->pluck('TypeCode');  
									
                                   
                               if($AnswerType == 'SE' || $AnswerType == 'YN')
								{
									$html.='<td class="center">'.$c->FullWeight.'</td>';
									$GetAnswers = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('Active','=',1)->where('QuestionId','=',$c->id)->orderBy('AnswerWeight','DESC')->get();
									$SelectedAns = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AnswerID');
									$AnswerName = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInSinhala');
									$AnswerNameE = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInEnglish');
									$Answeight = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerWeight');
									
									$html.='
                                    <td >'.$AnswerName.'<br/>'.$AnswerNameE.'</td>
									<td >'.$Answeight.'</td>';
									$decmark = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductMark');
									$decreason = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductReason');
									$FinalMar = $Answeight-$decmark;
									
									$html.='<td >'.$decmark.'</td><td >'.$decreason.'</td><td >'.$FinalMar.'</td>
									';
                                  
								}
								elseif($AnswerType == 'UI')
								{
									$html.='<td class="center">'.$c->FullWeight.' for the Category</td>';
									$GetAnswers = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('Active','=',1)->where('QuestionId','=',$c->id)->orderBy('AnswerWeight','DESC')->get();
									$SelectedAns = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AnswerID');
									$AnswerName = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInSinhala');
									$AnswerNameE = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInEnglish');
									$Answeight = MOToAdCriteriaQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerWeight');
									$grselectid = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('AchivedMark');
									$AchivemarkUI = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('AchivedMarkValueForUI');
									$decmark = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductMark');
									$decreason = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductReason');
									$FinalMar = $AchivemarkUI-$decmark;
									
									$html.='
                                    <td >'.$grselectid.' (User Input Value)</td>
									<td >'.$AchivemarkUI.'</td>
									<td >'.$decmark.'</td>
									<td >'.$decreason.'</td>
									<td >'.$FinalMar.'</td>';
								}
								else
								{
									$html.='<td class="center">'.$c->FullWeight.' for the Category</td>';
									$SelectedAns = MoInstructorGradingResultTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AchivedMark');
									$decmark = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductMark');
									$decreason = MOToAdGradingResultsTrans::where('Deleted','=',0)->where('QuestionId','=',$c->id)->where('MIDRID','=',$rec->id)->pluck('DeductReason');
									$FinalMar = $SelectedAns-$decmark;
									
									$html.='
									<td >System Calculation</td>
                                    <td >'.$SelectedAns.'</td>
									<td >'.$decmark.'</td>
									<td >'.$decreason.'</td>
									<td >'.$FinalMar.'</td>';
								}
                                
                                    
                                    
                
                                
              

                   $html.=' </tr>';                
             
                               
                           
    }
	 $ii++;
	 
	 $html.='</table></br>';
		}
             
      $html.='<pre bgcolor="RED"><h4><b><font color="RED"> Final Results Summary</font></b></h4></pre>
							<table  align="left" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
							  <tr id="d0" style="background-color:#CC9999">
								     
                                  
                                    <th class="center">Total Marks</th>
									<th class="center">Total Achieved Marks</th>
									<th class="center">Total Deduction Marks</th>
									<th class="center">Final Mark</th>
                                </tr>
							   <tr>
								    
									<th class="center"><font color="blue">'.$rec->TotalWeight.'</font></th>
                                   <th class="center"><font color="blue">'.$rec->AchivedMark.'</font></th>
									<th class="center"><font color="blue">'.$rec->TotalMarksDeduct.'</font></th>';
									$FachMark = $rec->AchivedMark-$rec->TotalMarksDeduct;
									$html.='<th class="center"><font color="blue">'.$FachMark.'</font></th>
                                </tr>
								
                            
                        </table></br>';
			 /*  
			 $html.='<tr>
							<td class="center"><b><font color="green"><center></center></font></b></td>
                            <td class="center"><b><font color="green"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="green"></font></b></td>
							 <td class="center"><b><font color="green"><center>පාඨමාලා සංඛ්‍යාව</center></font></b></td>
                            <td class="center"><b><font color="green">'.$rec->NoOfCourses.'</font></b></td>

              </tr>';
			  $html.='<tr>
							<td class="center"><b><font color="red"><center></center></font></b></td>
                            <td class="center"><b><font color="red"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="red"></font></b></td>
							 <td class="center"><b><font color="red"><center>ශ්‍රේණිය</center></font></b></td>
                            <td class="center"><b><font color="red">'.$rec->CenterGrade.'</font></b></td>

              </tr> 
			  */
             

             
           $html.='</br/><h4 style="page-break-before: always"><u>විශේෂ සටහන් (Other Comments)</u></h4><p style="text-align: justify;">';
	
	
	
	
	$html.='<p>'.$rec->Comments.'</p>
	
    <body></html>';

    return $html;
  }
	
  public function ViewTOCriteriaFormsEntered()
  {
        $ID = Input::get('id');
        $view = View::make('MoToAdGrading.TOView');
	    $UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$view->OrgaType = $OegaType;
		$view->Districts = District::orderBy('DistrictName')->get();
		$rec = MOToAdGradingResults::where('id','=',$ID)->first();
		$view->rec = $rec;
      
      $view->CenterMoniPlan = $ID;
   

    $method=Request::getMethod();
    //$Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='TO'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));
	$view->Criteris = $Criteris;
   // $view->Questions = $Questions;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          return $view;
        }
  }
	
	public function EditTOCriteriaForms()
	{
	$ID = Input::get('id');
	$view = View::make('MoToAdGrading.TOEdit');
	//$Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='TO'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Employee = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and employmentcode.Designation like '%Training Officer%'
										  order by employee.EPFNo"));
	
	$rec = MOToAdGradingResults::where('id','=',$ID)->first();
	$DistrictCode = Organisation::where('id','=',$rec->CenterId)->pluck('DistrictCode');
	$view->rec = $rec;
	$view->DistrictCode = $DistrictCode;
	$view->Criteris = $Criteris;
	
	
     if($OegaType == 'HO')
    {
		$view->Districts = District::orderBy('DistrictName')->get();
        $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->whereIn('Type',['NVTI','DO','HO'])->where('DistrictCode','=',$DistrictCode)->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereIn('Type',['NVTI','DO'])
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
				  and organisation.Type  in('PO','DO','NVTI')
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
 
    //$view->Questions = $Questions;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
		if($method == 'POST')
		{
		   $ResId = Input::get('resID');
		   $District = Input::get('District');
		   $CenterID = Input::get('CenterID');
		   $EmpID = Input::get('EmpID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
		   $DeductMark = Input::get('DeductMark');
		   $DeductReason = Input::get('DeductReason');
		   
           //Clear data tables
           $deletemonitoringTransTable = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterID','=',$CenterID)->update(array("Deleted" => 1));
           $deleteMonitoringResultTable = MOToAdGradingResults::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterId','=',$CenterID)->update(array("Deleted" => 1));
          
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
		   $Totalrequestedmaterial = 0;
		   $Totalreleasedmaterial = 0;
		   $centerGrading = 0;
		   $InstrutorRanking = 0;
		   $totMarkFullDec = 0;
		   $totachiveUI = 0;
		   
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOToAdCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOToAdAnswerType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
			  
			  $totMarkFullDec = $totMarkFullDec + $DeductMark[$i];
              if($getCalType == 'SE' || $getCalType == 'YN')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = MOToAdCriteriaQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new MOToAdGradingResultsTrans();
                $c->QuestionID = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $mark;
				$c->DeductMark = $DeductMark[$i];
				$c->DeductReason =	$DeductReason[$i];			
                $c->CenterID = $CenterID;
                $c->Year = $Year;
				$c->EmpID = $EmpID;
				$c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              elseif($getCalType == 'UI')
              {
				  
				 
					  $AnswerWeghtID = $AnswerID[$i];
				      $c = new MOToAdGradingResultsTrans();
				  
						 if($i == 12)
						 {
							 //user input
							 $Totalrequestedmaterial = $AnswerWeghtID;
						 }
						 elseif($i == 13)
						 {
							 //user input
							 $Totalreleasedmaterial = $AnswerWeghtID;
						 }
						 else
						 {
							 
						 }
							
						
							
							  
							$c->QuestionID = $IndividualQuestionsID;
							$c->AnswerID = 999999;
							$c->AnswerType = $getCalType;
							$c->AchivedMark = $AnswerWeghtID;
							
							$c->DeductMark = $DeductMark[$i];
							$c->DeductReason =	$DeductReason[$i];			
							$c->CenterId = $CenterID;
							$c->Year = $Year;
							$c->EmpID = $EmpID;
							$c->User = User::getSysUser()->userID;
							$c->save();

              
              }
			  else
			  {
				  //system  calculate
				  $AnswerWeghtID = $AnswerID[$i];//Syetem Calculation as value
				 
						if($i == 8)
						 {//center grading
							 //user input
							 $centerYear = $Year;//replace tear to current Year2019
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgmark = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															  from hocentremonitoringresult
															  left join organisation
															  on hocentremonitoringresult.CenterId=organisation.id
															  left join district
															  on organisation.DistrictCode=district.DistrictCode
															  where hocentremonitoringresult.Deleted=0
															  and hocentremonitoringresult.Year='".$centerYear."'
															  and organisation.Type NOT IN('Attached')
															  and district.ProvinceCode='".$ProvinceID."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'DO')
							 {
								 
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.Type NOT IN('NVTI','Attached')
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'NVTI')
							 {
								  $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.id='".$CenterID."'
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 else
							 {
							 }
							 
							 $FinalCenterGradeValue = round((($TotalCengrademark/5)*100),0);
							 $FinalCenterGradeValueMark = 0;
							 if($FinalCenterGradeValue>= 90)
							  {
								  $FinalMark = $FinalMark + 5;
								  $FinalCenterGradeValueMark = 5;
							  }
							  elseif($FinalCenterGradeValue<=89 && $FinalCenterGradeValue>=75)
							  {
								  $FinalMark = $FinalMark + 3;
								  $FinalCenterGradeValueMark = 3;
							  }
							  elseif($FinalCenterGradeValue<=74 && $FinalCenterGradeValue>=50)
							  {
								  $FinalMark = $FinalMark + 2;
								  $FinalCenterGradeValueMark = 2;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $FinalCenterGradeValueMark = 0;
							  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $FinalCenterGradeValueMark;
							  $c->AchivedMarkValueForUI = $FinalCenterGradeValueMark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason =	$DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 elseif($i == 9)
						 {
							 //instructor ranking
							 //user input
							 $centerYear = $Year-2;//replace tear to current Year 2017
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgPercentage = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.ProvinceCode='".$ProvinceID."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
								
							}
							 elseif($CenterType == 'DO')
							 {
								 
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and organisation.Type NOT IN('NVTI')
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 elseif($CenterType == 'NVTI')
							 {
								$ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								$sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
														   from moinstructorgradingresult
														   left join organisation
														   on moinstructorgradingresult.CenterId=organisation.id
														   left join district
														   on organisation.DistrictCode=district.DistrictCode
														   where moinstructorgradingresult.Deleted=0
														   and organisation.id='".$CenterID."'
														   and moinstructorgradingresult.Year='".$centerYear."'
														   and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 else
							 {
							 }
							 
							$TotalInsgrademark = 0;
															  
								 if($avgPercentage>= 90)
								 {
									  $FinalMark = $FinalMark + 5;
									  $TotalInsgrademark = 5;
								  }
								  elseif($avgPercentage<=89 && $avgPercentage>=75)
								  {
									  $FinalMark = $FinalMark + 3;
									  $TotalInsgrademark = 3;
								  }
								  elseif($avgPercentage<=74 && $avgPercentage>=50)
								  {
									  $FinalMark = $FinalMark + 2;
									  $TotalInsgrademark = 2;
								  }
								  else
								  {
									  $FinalMark = $FinalMark + 0;
									  $TotalInsgrademark = 0;
								  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $TotalInsgrademark;
							  $c->AchivedMarkValueForUI = $TotalInsgrademark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason = $DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 else
						 {
							 
						 }
				  
				  
				  
			  }
           }
	
	
							  $TotalPercentagematerial = round((($Totalreleasedmaterial/$Totalrequestedmaterial)*100),0);
							  if($TotalPercentagematerial>= 90)
							  {
								  $FinalMark = $FinalMark + 10;
								  $totachiveUI = 10;
							  }
							  elseif($TotalPercentagematerial<=89 && $TotalPercentagematerial>=75)
							  {
								  $FinalMark = $FinalMark + 7;
								  $totachiveUI = 7;
							  }
							  elseif($TotalPercentagematerial<=74 && $TotalPercentagematerial>=50)
							  {
								  $FinalMark = $FinalMark + 4;
								  $totachiveUI = 4;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totachiveUI = 0;
							  }
		  
			// update user input achived marks
			$UpdateuIachive = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[13,14])
			->update(array('AchivedMarkValueForUI' => $totachiveUI));
		  
			$totweight = MOToAdCriteriaCategory::where('Deleted','=',0)->where('EmpTypeId','=',1)->where('Active','=',1)->sum('FullWeightFoTheSection');
            $d = new MOToAdGradingResults();
            $d->CenterId = $CenterID;
            $d->Year = $Year;
			$d->TotalWeight = $totweight;
			$d->AchivedMark = $FinalMark;
			
			$d->TotalMarksDeduct = $totMarkFullDec;
            $d->Comments = $Dreason;
			$d->EmpID = $EmpID;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = MOToAdGradingResults::where('Deleted','=',0)->where('Year','=',$Year)->where('CenterId','=',$CenterID)->where('EmpID','=',$EmpID)->pluck('id');
			
			$updateHOCentreMonitoringResultTrans = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)
			->update(array('MIDRID' => $HOCMRId));


            
            return Redirect::to('ViewTOCriteriaForms')->with("done", true);
		}
		
	}
	
	  public function ViewTOCriteriaForms()
  {
    $view = View::make('MoToAdGrading.View');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Employee = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and employmentcode.Designation like '%Training Officer%'
										  order by employee.EPFNo"));
	//$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
    if($OegaType == 'HO')
    {
		 $view->Districts = District::orderBy('DistrictName')->get();
         $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->whereIn('Type',['NVTI','DO','HO'])->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereIn('Type',['NVTI','DO'])
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
				  and organisation.Type  in('PO','DO','NVTI')
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
	 
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
			$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and employmentcode.Designation like 'Training Officer'
				  order by district.DistrictName"));
				  $view->DataSet = $dataset;
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
			$Center = Input::get('CenterID');
			$District = Input::get('District');
			$EmpID = Input::get('EmpID');
            $userEMpid = User::getSysUser()->EmpId;

            
			if($District == 'All' && $Center  == 'All' && $EmpID == 'All')
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and employmentcode.Designation like 'Training Officer'
				  and motoadgradingresult.Year='".$Year."'
				  order by district.DistrictName"));
				
			}
			else
			{
				$dataset = DB::select(DB::raw("select motoadgradingresult.*,
				  employee.Initials,employee.LastName,
				  organisation.OrgaName,organisation.Type,
				  employmentcode.Designation,
				  district.DistrictName,
				  province.ProvinceName
				  from motoadgradingresult
				  left join employee
				  on motoadgradingresult.EmpID=employee.id
				  left join organisation
				  on motoadgradingresult.CenterId=organisation.id
				  left join employmentcode
				  on employee.CurrentDesignation=employmentcode.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join province
				  on district.ProvinceCode=province.ProvinceCode
				  where motoadgradingresult.Deleted=0
				  and district.DistrictCode='".$District."'
				  and motoadgradingresult.Year='".$Year."'
				  and organisation.id='".$Center."'
				  and employee.id='".$EmpID."'
				  order by district.DistrictName"));
				
			}
			
			
			
          //$courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
		  $view->PCenter = $Center;
		  $view->PDistrict = $District;
          $view->PEmpID = $EmpID;
		  $view->DataSet = $dataset;
          return $view;
        }

  }
	
	
		public function loaddistrictcentersinTO()
	{
		
		$dis = Input::get('District');
		
      
	  $sql = DB::select(DB::raw("select * 
      from organisation
      where organisation.Deleted=0
      and organisation.Type in('HO','DO','PO','NVTI')
      and organisation.DistrictCode='".$dis."'
      order by organisation.OrgaName"));
	  
	  return json_encode($sql);
	}
	public function loaddistrictcentersinTOName()
	{
		
		$CenterID = Input::get('CenterID');
		
      
	  $sql = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and employmentcode.Designation like '%Training Officer%'
										  and employee.CurrentOrgaID='".$CenterID."'
										  order by employee.EPFNo"));
	  
	  return json_encode($sql);
	}
	
		
  public function CreateTOCriteriaForms()
  {
    $view = View::make('MoToAdGrading.TOCreate');
    $Criteris = DB::select(DB::raw("select motoadgradingcriteriacategory.* 
									  from motoadgradingcriteriacategory
									  left join motoadgradingemptype
									  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
									  where motoadgradingemptype.Type='TO'
									  and motoadgradingcriteriacategory.Deleted=0
									  and motoadgradingcriteriacategory.Active=1
									  order by motoadgradingcriteriacategory.`Order`"));
	
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Employee = DB::select(DB::raw("select employee.*,organisation.OrgaName,employmentcode.Designation
										  from employee
										  left join employmentcode
										  on employee.CurrentDesignation=employmentcode.id
										  left join organisation
										  on employee.CurrentOrgaID=organisation.id
										  where employee.Deleted=0
										  and employmentcode.Designation like '%Training Officer%'
										  order by employee.EPFNo"));
	//$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
    if($OegaType == 'HO')
    {
		 $view->Districts = District::orderBy('DistrictName')->get();
         $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->whereIn('Type',['NVTI','DO','HO'])->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereIn('Type',['NVTI','DO'])
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
				  and organisation.Type  in('PO','DO','NVTI')
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
 
    $view->Criteris = $Criteris;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
		   $District = Input::get('District');
		   $CenterID = Input::get('CenterID');
		   $EmpID = Input::get('EmpID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
		   $DeductMark = Input::get('DeductMark');
		   $DeductReason = Input::get('DeductReason');
         

           //Clear data tables
           $deletemonitoringTransTable = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterID','=',$CenterID)->update(array("Deleted" => 1));
           $deleteMonitoringResultTable = MOToAdGradingResults::where('Year','=',$Year)->where('EmpID','=',$EmpID)->where('CenterId','=',$CenterID)->update(array("Deleted" => 1));
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
		   $Totalrequestedmaterial = 0;
		   $Totalreleasedmaterial = 0;
		   $centerGrading = 0;
		   $InstrutorRanking = 0;
		   $totMarkFullDec = 0;
		   $totachiveUI = 0;
		   
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOToAdCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOToAdAnswerType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
			  
			  $totMarkFullDec = $totMarkFullDec + $DeductMark[$i];
              if($getCalType == 'SE' || $getCalType == 'YN')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = MOToAdCriteriaQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new MOToAdGradingResultsTrans();
                $c->QuestionID = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $mark;
				$c->DeductMark = $DeductMark[$i];
				$c->DeductReason =	$DeductReason[$i];			
                $c->CenterID = $CenterID;
                $c->Year = $Year;
				$c->EmpID = $EmpID;
				$c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              elseif($getCalType == 'UI')
              {
				  
				 
					  $AnswerWeghtID = $AnswerID[$i];
				      $c = new MOToAdGradingResultsTrans();
				  
						 if($i == 12)
						 {
							 //user input
							 $Totalrequestedmaterial = $AnswerWeghtID;
						 }
						 elseif($i == 13)
						 {
							 //user input
						 	 $Totalreleasedmaterial = $AnswerWeghtID;
						 }
						 else
						 {
							 
						 }
						 
						 
							
							
							  
							$c->QuestionID = $IndividualQuestionsID;
							$c->AnswerID = 999999;
							$c->AnswerType = $getCalType;
							$c->AchivedMark = $AnswerWeghtID;
							//$c->AchivedMarkValueForUI = $totachiveUI;
							$c->DeductMark = $DeductMark[$i];
							$c->DeductReason =	$DeductReason[$i];			
							$c->CenterId = $CenterID;
							$c->Year = $Year;
							$c->EmpID = $EmpID;
							$c->User = User::getSysUser()->userID;
							$c->save();

              
              }
			  else
			  {
				  //system  calculate
				  $AnswerWeghtID = $AnswerID[$i];//Syetem Calculation as value
				 
						if($i == 8)
						 {//center grading
							 //user input
							 $centerYear = $Year-1;//replace tear to current Year
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgmark = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															  from hocentremonitoringresult
															  left join organisation
															  on hocentremonitoringresult.CenterId=organisation.id
															  left join district
															  on organisation.DistrictCode=district.DistrictCode
															  where hocentremonitoringresult.Deleted=0
															  and hocentremonitoringresult.Year='".$centerYear."'
															  and organisation.Type NOT IN('Attached')
															  and district.ProvinceCode='".$ProvinceID."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'DO')
							 {
								 
								 $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.Type NOT IN('NVTI','Attached')
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 elseif($CenterType == 'NVTI')
							 {
								  $sql = DB::select(DB::raw("select hocentremonitoringresult.*
															from hocentremonitoringresult
															left join organisation
															on hocentremonitoringresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where hocentremonitoringresult.Deleted=0
															and hocentremonitoringresult.Year='".$centerYear."'
															and organisation.id='".$CenterID."'
															and district.DistrictCode='".$District."'"));
								$countcenters = Count($sql);
								$avgmark = round((5/$countcenters),2);
								$TotalCengrademark = 0;
															  
								foreach($sql as $s)
								{
									if($s->CenterGrade == 'A')
									{
										$TotalCengrademark = $TotalCengrademark + $avgmark;
									}
									elseif($s->CenterGrade == 'B')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(3/4)),2);
									}
									elseif($s->CenterGrade == 'C')
									{
										$TotalCengrademark = $TotalCengrademark + round(($avgmark*(1/2)),2);
									}
									elseif($s->CenterGrade == 'D')
									{
										$TotalCengrademark = $TotalCengrademark + 0;
									}
									else
									{
										
									}
									
								}
							 }
							 else
							 {
							 }
							 
							 $FinalCenterGradeValue = round((($TotalCengrademark/5)*100),0);
							 $FinalCenterGradeValueMark = 0;
							 if($FinalCenterGradeValue>= 90)
							  {
								  $FinalMark = $FinalMark + 5;
								  $FinalCenterGradeValueMark = 5;
							  }
							  elseif($FinalCenterGradeValue<=89 && $FinalCenterGradeValue>=75)
							  {
								  $FinalMark = $FinalMark + 3;
								  $FinalCenterGradeValueMark = 3;
							  }
							  elseif($FinalCenterGradeValue<=74 && $FinalCenterGradeValue>=50)
							  {
								  $FinalMark = $FinalMark + 2;
								  $FinalCenterGradeValueMark = 2;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $FinalCenterGradeValueMark = 0;
							  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $FinalCenterGradeValueMark;
							  $c->AchivedMarkValueForUI = $FinalCenterGradeValueMark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason =	$DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 elseif($i == 9)
						 {
							 //instructor ranking
							 //user input
							 $centerYear = $Year-2;//replace tear to current Year
							 $CenterType = Organisation::where('id','=',$CenterID)->where('Deleted','=',0)->pluck('Type');
							 $avgPercentage = 0;
							 if($CenterType == 'PO')
							 {
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.ProvinceCode='".$ProvinceID."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
								
							}
							 elseif($CenterType == 'DO')
							 {
								 
								 $ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								 $sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
															from moinstructorgradingresult
															left join organisation
															on moinstructorgradingresult.CenterId=organisation.id
															left join district
															on organisation.DistrictCode=district.DistrictCode
															where moinstructorgradingresult.Deleted=0
															and organisation.Type NOT IN('NVTI')
															and moinstructorgradingresult.Year='".$centerYear."'
															and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 elseif($CenterType == 'NVTI')
							 {
								$ProvinceID = District::where('DistrictCode','=',$District)->pluck('ProvinceCode');
								$sql = DB::select(DB::raw("select round(avg(moinstructorgradingresult.AchivedMark),0) as avg
														   from moinstructorgradingresult
														   left join organisation
														   on moinstructorgradingresult.CenterId=organisation.id
														   left join district
														   on organisation.DistrictCode=district.DistrictCode
														   where moinstructorgradingresult.Deleted=0
														   and organisation.id='".$CenterID."'
														   and moinstructorgradingresult.Year='".$centerYear."'
														   and district.DistrictCode='".$District."'"));
								$newdata =  json_decode(json_encode((array)$sql),true);
								$avgmark = $newdata[0]["avg"];
								$avgPercentage = round((($avgmark/700)*100),0);
							 }
							 else
							 {
							 }
							 
							$TotalInsgrademark = 0;
															  
								 if($avgPercentage>= 90)
								 {
									  $FinalMark = $FinalMark + 5;
									  $TotalInsgrademark = 5;
								  }
								  elseif($avgPercentage<=89 && $avgPercentage>=75)
								  {
									  $FinalMark = $FinalMark + 3;
									  $TotalInsgrademark = 3;
								  }
								  elseif($avgPercentage<=74 && $avgPercentage>=50)
								  {
									  $FinalMark = $FinalMark + 2;
									  $TotalInsgrademark = 2;
								  }
								  else
								  {
									  $FinalMark = $FinalMark + 0;
									  $TotalInsgrademark = 0;
								  }
							  
							  $c = new MOToAdGradingResultsTrans();
							  $c->QuestionID = $IndividualQuestionsID;
							  $c->AnswerID = 666666;
							  $c->AnswerType = $getCalType;
							  $c->AchivedMark = $TotalInsgrademark;
							  $c->AchivedMarkValueForUI = $TotalInsgrademark;
							  $c->DeductMark = $DeductMark[$i];
							  $c->DeductReason = $DeductReason[$i];			
							  $c->CenterId = $CenterID;
							  $c->Year = $Year;
							  $c->EmpID = $EmpID;
							  $c->User = User::getSysUser()->userID;
							  $c->save();
							 
						 }
						 else
						 {
							 
						 }
				  
				  
				  
			  }
           }
	
						//return $Totalrequestedmaterial;
							  $TotalPercentagematerial = round((($Totalreleasedmaterial/$Totalrequestedmaterial)*100),0);
							  if($TotalPercentagematerial>= 90)
							  {
								  $FinalMark = $FinalMark + 10;
								  $totachiveUI = 10;
							  }
							  elseif($TotalPercentagematerial<=89 && $TotalPercentagematerial>=75)
							  {
								  $FinalMark = $FinalMark + 7;
								  $totachiveUI = 7;
							  }
							  elseif($TotalPercentagematerial<=74 && $TotalPercentagematerial>=50)
							  {
								  $FinalMark = $FinalMark + 4;
								  $totachiveUI = 4;
							  }
							  else
							  {
								  $FinalMark = $FinalMark + 0;
								  $totachiveUI = 0;
							  }
			// update user input achived marks
			$UpdateuIachive = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)->whereIn('QuestionID',[13,14])->update(array('AchivedMarkValueForUI' => $totachiveUI));
		 
		  
			$totweight = MOToAdCriteriaCategory::where('Deleted','=',0)->where('EmpTypeId','=',1)->where('Active','=',1)->sum('FullWeightFoTheSection');
            $d = new MOToAdGradingResults();
            $d->CenterId = $CenterID;
            $d->Year = $Year;
			$d->TotalWeight = $totweight;
			$d->AchivedMark = $FinalMark;
			//$c->AchivedMarkValueForUI = $totachiveUI;
			$d->TotalMarksDeduct = $totMarkFullDec;
            $d->Comments = $Dreason;
			$d->EmpID = $EmpID;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = MOToAdGradingResults::where('Deleted','=',0)->where('Year','=',$Year)->where('CenterId','=',$CenterID)->where('EmpID','=',$EmpID)->pluck('id');
			
			$updateHOCentreMonitoringResultTrans = MOToAdGradingResultsTrans::where('Year','=',$Year)->where('CenterID','=',$CenterID)->where('EmpID','=',$EmpID)->where('Deleted','=',0)
			->update(array('MIDRID' => $HOCMRId));


            
            return Redirect::to('CreateTOCriteriaForms')->with("done", true);

        }
    

  }
	
  public function DeleteTOADCriteriaCategoryAnswers()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOToAdCriteriaQuestionAnswer::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
   
    return Redirect::to('ViewTOADCriteriaQuestionAnswers');
  }
	
  public function EditTOADCriteriaCategoryAnswers()
  {
     $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOToAdCriteriaQuestionAnswer.Edit')->with('user', User::getSysUser());
  $view->Answertypes = DB::select(DB::raw("select motoadcriteriaquestion.*,
  motoadgradingemptype.Type 
  from motoadcriteriaquestion
  left join motoadgradingcriteriacategory
  on motoadcriteriaquestion.CriteriaId=motoadgradingcriteriacategory.id
  left join motoadgradingemptype
  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
  where motoadcriteriaquestion.Deleted=0
  and motoadcriteriaquestion.Active=1
  order by motoadcriteriaquestion.QOrder"));
    $view->QID = $QId;
	$view->Rec = MOToAdCriteriaQuestionAnswer::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $QuestionId = Input::get('QuestionId');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			
			
			
			$Update = MOToAdCriteriaQuestionAnswer::where('id','=',$id)->update(array('QuestionId' => $QuestionId, 'AnswerInSinhala' => $Csinhala,
			'AnswerInEnglish' =>$Ceng,'AnswerWeight' => $FullWeightFoTheSection,'Active' =>$Active,'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewTOADCriteriaQuestionAnswers');
    }
  }
	
		public function CreateTOADCriteriaCategoryAnswers()
  {
    $view = View::make('MOToAdCriteriaQuestionAnswer.Create');
    $view->Answertypes = DB::select(DB::raw("select motoadcriteriaquestion.*,
  motoadgradingemptype.Type 
  from motoadcriteriaquestion
  left join motoadgradingcriteriacategory
  on motoadcriteriaquestion.CriteriaId=motoadgradingcriteriacategory.id
  left join motoadgradingemptype
  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
  where motoadcriteriaquestion.Deleted=0
  and motoadcriteriaquestion.Active=1
  order by motoadcriteriaquestion.QOrder"));
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $QuestionId = Input::get('QuestionId');
			$Active = Input::get('Active');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
			
            $c = new MOToAdCriteriaQuestionAnswer();
			$c->QuestionId = $QuestionId;
            $c->AnswerInSinhala = $Csinhala;
            $c->AnswerInEnglish = $Ceng;
            $c->AnswerWeight = $FullWeightFoTheSection;
			$c->Active = $Active;
			$c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateTOADCriteriaCategoryAnswers')->with("done", true);
        }
  }
	
	
  public function ViewTOADCriteriaQuestionAnswers()
  {
    $view = View::make('MOToAdCriteriaQuestionAnswer.View');
    $courses = DB::select(DB::raw("select motoadcriteriaquestionanswer.*,
motoadcriteriaquestion.QuestionInSinhala,
  motoadcriteriaquestion.QuestionInEnglish,
  motoadgradingcriteriacategory.TypeInEnglish,
  motoadgradingcriteriacategory.TypeInSinhala,
  motoadgradingemptype.Type
from motoadcriteriaquestionanswer
left join motoadcriteriaquestion
on motoadcriteriaquestionanswer.QuestionId=motoadcriteriaquestion.id
  left join motoadgradingcriteriacategory
  on motoadcriteriaquestion.CriteriaId=motoadgradingcriteriacategory.id
  left join motoadgradingemptype
  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
where motoadcriteriaquestionanswer.Deleted=0
order by motoadcriteriaquestionanswer.AnswerWeight"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	public function DeleteTOADCriteriaCategoryQuestion()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOToAdCriteriaQuestion::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
    //$cc = MOInstructorQuestionAnswer::where('QuestionId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewTOADCriteriaCategoryQuestion');
  }
	
	public function EditTOADCriteriaCategoryQuestion()
  {
    $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOToAdCriteriaQuestion.Edit')->with('user', User::getSysUser());
    $view->Answertypes = MOToAdAnswerType::where('Deleted','=',0)->get();
	$view->Category = DB::select(DB::raw("select motoadgradingcriteriacategory.*,motoadgradingemptype.Type
  from motoadgradingcriteriacategory
  left join motoadgradingemptype
  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
  where motoadgradingcriteriacategory.Deleted=0
  and motoadgradingcriteriacategory.Active=1
  order by motoadgradingcriteriacategory.`Order`"));
  
    $view->QID = $QId;
	$view->Rec = MOToAdCriteriaQuestion::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            //$maxOrder = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->max('QOrder');
            //$max = $maxOrder+1;
			$AnswerTypeId = Input::get('AnswerTypeId');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			$CategoryId = Input::get('CategoryId');
			
			$Update = MOToAdCriteriaQuestion::where('id','=',$id)->update(array('QuestionInSinhala' => $Csinhala, 'QuestionInEnglish' => $Ceng,
			'QOrder' =>$Order,'Active' => $Active,'AnswerTypeId' =>$AnswerTypeId,'FullWeight' => $FullWeightFoTheSection,'CriteriaId' => $CategoryId ,'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewTOADCriteriaCategoryQuestion');
    }
  }
	
		public function CreateTOADCriteriaCategoryQuestion()
  {
    $view = View::make('MOToAdCriteriaQuestion.Create');
    $view->Answertypes = MOToAdAnswerType::where('Deleted','=',0)->get();
	$view->Category = DB::select(DB::raw("select motoadgradingcriteriacategory.*,motoadgradingemptype.Type
  from motoadgradingcriteriacategory
  left join motoadgradingemptype
  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
  where motoadgradingcriteriacategory.Deleted=0
  and motoadgradingcriteriacategory.Active=1
  order by motoadgradingcriteriacategory.`Order`"));
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $maxOrder = MOToAdCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->max('QOrder');
            $max = $maxOrder+1;
			$AnswerTypeId = Input::get('AnswerTypeId');
			$Active = Input::get('Active');
			$CategoryId = Input::get('CategoryId');
			
            $c = new MOToAdCriteriaQuestion();
            $c->QuestionInSinhala = $Csinhala;
			$c->CriteriaId = $CategoryId;
            $c->QuestionInEnglish = $Ceng;
            $c->QOrder = $max;
			$c->Active = $Active;
			$c->AnswerTypeId = $AnswerTypeId;
			$c->FullWeight  = $FullWeightFoTheSection;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateTOADCriteriaCategoryQuestion')->with("done", true);
        }
  }
	
  public function ViewTOADCriteriaCategoryQuestion()
  {
    $view = View::make('MOToAdCriteriaQuestion.View');
    $courses = DB::select(DB::raw("select motoadcriteriaquestion.*,motoadanswertype.AnswerType,
  motoadgradingcriteriacategory.TypeInEnglish,
  motoadgradingcriteriacategory.TypeInSinhala,
  motoadgradingemptype.Type
    from motoadcriteriaquestion
    left join motoadanswertype
    on motoadcriteriaquestion.AnswerTypeId=motoadanswertype.id
  left join motoadgradingcriteriacategory
  on motoadcriteriaquestion.CriteriaId=motoadgradingcriteriacategory.id
  left join motoadgradingemptype
  on motoadgradingcriteriacategory.EmpTypeId=motoadgradingemptype.id
    where motoadcriteriaquestion.Deleted=0
    order by motoadcriteriaquestion.QOrder"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	  public function DeleteTOADQuestionAnswerType()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOToAdAnswerType::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    //delete criteria EMPtype Trans
    
    return Redirect::to('ViewTOADQuestionAnswerType');
  }
	
  public function CreateTOADQuestionAnswerType()
  {
    $view = View::make('MOToAdAnswerType.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Type = Input::get('Type');
			$Code = Input::get('Code');
           
            $c = new MOToAdAnswerType();
            $c->AnswerType = $Type;
			$c->TypeCode = $Code;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateTOADQuestionAnswerType')->with("done", true);
        }
  }
	
		public function ViewTOADQuestionAnswerType()
  {
    $view = View::make('MOToAdAnswerType.View');
    $courses = MOToAdAnswerType::where('Deleted','=',0)->orderBy('AnswerType')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
		public function DeleteInstructorCriteriaTOADCategory()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOToAdCriteriaCategory::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
    //$cc = MOInstructorCriteria::where('CategoryId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewInstructorCriteriaTOADCategory');
  }
	
	public function CreateInstructorCriteriaTOADCategory()
  {
    $view = View::make('MoToAdCriteriaCategory.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             
			 $Emptypes = MOToAdEmpType::where('Deleted','=',0)->get();
			 $view->Emptypes = $Emptypes;
			 return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $maxOrder = MOToAdCriteriaCategory::max('Order');
            $max = $maxOrder+1;
            $c = new MOToAdCriteriaCategory();
            $c->TypeInEnglish = $Ceng;
            $c->TypeInSinhala = $Csinhala;
            $c->Order = $max;
			$c->FullWeightFoTheSection  = $FullWeightFoTheSection;
			$c->EmpTypeId = Input::get('EmpTypeId');
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateInstructorCriteriaTOADCategory')->with("done", true);
        }
  }
	
  public function ViewInstructorCriteriaTOADCategory()
  {
    $view = View::make('MoToAdCriteriaCategory.View');
    $courses = MOToAdCriteriaCategory::where('Deleted','=',0)->orderBy('Order')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
  public function DeleteCriteriaTOADEmpType()
  {
     $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOToAdEmpType::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    //delete criteria EMPtype Trans
  //$cc = MOCriteriaEmpTypeTrans::where('EmptypeId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewCriteriaTOADEmpType');
  }
	
	  public function CreateCriteriaTOADEmpType()
  {
    $view = View::make('MOToAdEmpType.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Type = Input::get('Type');
           
            $c = new MOToAdEmpType();
            $c->Type = $Type;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateCriteriaTOADEmpType')->with("done", true);
        }
  }
	
	 public function ViewCriteriaTOADEmpType()
  {
    $view = View::make('MOToAdEmpType.View');
    $courses = MOToAdEmpType::where('Deleted','=',0)->orderBy('Type')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	 public function DownloadHOInstructorGradingReport1FormsExcel()
  {
    $Year = Input::get('Year');
	$District = Input::get('District');
	$Batch = Input::get('Batch');
	$CategoryID = Input::get('CourseCategory');
	$CourseLevel = Input::get('CourseLevel');
	
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
   
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','Batch','District','Centre','Centre Type','Trade','Course Category','Course Name','Course Level','Duration','NVQ/NON','Instructor Name','EPF No','Achived Mark(700)','Grade','Rank','Award');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
     $Grade = "";


   $userEMpid = User::getSysUser()->EmpId;

            $sql="select district.DistrictName,organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,
					  coursedetails.CourseListCode,
					  coursedetails.Duration,
					  coursedetails.Nvq,
					  coursedetails.CourseLevel,
					  moinstructor.EPFNo,
					  moinstructor.Name,
                      trade.TradeName,coursecategory.Category,district.DistrictCode
					  from moinstructorgradingresult
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursecategory
					  on coursedetails.CourseCategoryId=coursecategory.id
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and moinstructorgradingresult.Batch like '$Batch%'
					  and coursecategory.id='".$CategoryID."'
					  and coursedetails.CourseLevel='".$CourseLevel."'
					  ORDER by moinstructorgradingresult.AchivedMark desc";

           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
			$rank = 0;
			$AchiMarkSame = 0;
				  $FirstAchiveMArk = 0;
			$Award = "";

                foreach($total_rec as $Data) {
					if($FirstAchiveMArk == $Data->AchivedMark)
							{
								$FirstAchiveMArk = $Data->AchivedMark;
								
							}
							else
							{
								$FirstAchiveMArk = $Data->AchivedMark;
								$rank = $rank +1;
							}
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->Year);
				array_push($data_row, $Data->Batch);
                array_push($data_row, $Data->DistrictName);
				array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				//array_push($data_row, $Data->RegistrationNo);
				array_push($data_row, $Data->TradeName);
				array_push($data_row, $Data->Category);
				array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				array_push($data_row, $Data->Nvq);
				array_push($data_row, $Data->Name);
			    array_push($data_row, $Data->EPFNo);
				array_push($data_row, $Data->AchivedMark);
				//array_push($data_row, $Data->Comments);
				if($Data->AchivedMark >= 500)
				{
								 $Grade="A";
				}
				elseif($Data->AchivedMark >=350 && 500 > $Data->AchivedMark)
				{
							 $Grade="B";
				}
				elseif($Data->AchivedMark >=150 && 350 >$Data->AchivedMark)
				{
					$Grade="C";
				}
				else
				{
					$Grade="D";
				}
						     
			  array_push($data_row, $Grade);
			  
			  if($rank == 1 && $Data->AchivedMark >= 500)
			  {
				  $Award = "1st Place";
			  }
			  elseif($rank == 2 && $Data->AchivedMark >= 500)
			  {
					$Award = "2nd Place";
			  }
			  elseif($rank == 3 && $Data->AchivedMark >= 500)
			  {
				  $Award = "3rd Place";
			  }
				else
				{
					$Award ="";
				}
				array_push($data_row, $rank);			   
				 array_push($data_row, $Award);		 
               
                array_push($printablearray, $data_row);
				//$rank = $rank +1;
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('HOInstructorRankingReport-I' . date('Y-m-d'));
            
  }
	public function loaddistrictBatchCategoryLevel()
	{
		
		$dis = Input::get('District');
		$Year = Input::get('Year');
		$Batch = Input::get('Batch');
		$CourseCategory = Input::get('CourseCategory');
		
      /*$Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$dis)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();*/
	  
	  $sql = DB::select(DB::raw("select distinct coursedetails.CourseLevel
  from moinstructorgradingresult
  left join coursedetails
  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
  left join organisation
  on moinstructorgradingresult.CenterId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  where moinstructorgradingresult.Deleted=0
  and moinstructorgradingresult.Year='".$Year."'
  and moinstructorgradingresult.Batch like '$Batch%'
  and district.DistrictCode='".$dis."'
  and coursecategory.id='".$CourseCategory."'
  order by coursedetails.CourseLevel"));
	  
	  return json_encode($sql);
	}
	
		public function loaddistrictBatchCategory()
	{
		
		$dis = Input::get('District');
		$Year = Input::get('Year');
		$Batch = Input::get('Batch');
		
      /*$Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$dis)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();*/
	  
	  $sql = DB::select(DB::raw("select distinct coursecategory.id,coursecategory.Category
  from moinstructorgradingresult
  left join coursedetails
  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
  left join organisation
  on moinstructorgradingresult.CenterId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  where moinstructorgradingresult.Deleted=0
  and moinstructorgradingresult.Year='".$Year."'
  and moinstructorgradingresult.Batch like '$Batch%'
  and district.DistrictCode='".$dis."'
  order by coursecategory.Category"));
	  
	  return json_encode($sql);
	}
	
 public function ViewInstructorCriteriaFormsReportI()
  {
    $view = View::make('MOInstructorMonitor.ViewGradingReport1');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
	  $view->Districts = District::orderBy('DistrictName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
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
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
			$Batch = Input::get('Batch');
			$District = Input::get('District');
			$CategoryID = Input::get('CourseCategory');
			$CourseLevel = Input::get('CourseLevel');
            $userEMpid = User::getSysUser()->EmpId;

           

				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category,district.DistrictCode
					  from moinstructorgradingresult
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursecategory
					  on coursedetails.CourseCategoryId=coursecategory.id
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and moinstructorgradingresult.Batch like '$Batch%'
					  and coursecategory.id='".$CategoryID."'
					  and coursedetails.CourseLevel='".$CourseLevel."'
					  ORDER by moinstructorgradingresult.AchivedMark desc";
			
			
			
			
          $courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
		  $view->PBatch = $Batch;
		  $view->PDistrict = $District;
		  $view->PCategoryID = $CategoryID;
		  $view->PCourseLevel = $CourseLevel;
          $view->courses = $courses;
          return $view;
        }

  }
	
	public function CourseMonitoringPlanEdit()
	{
			$view = View::make('MOCMPlan.Edit');
			$method = Request::getMethod();

			if ($method == "GET")
			{
			 $quorg = MOCenterMonitoringPlan::where('id',"=",Input::get('id'))->first();

			$view->user = User::getSysUser();
			
			$view->quorg = $quorg;
			return $view;

			}
			if ($method == "POST")
			{
			
			//return Input::get('ID');
			$qo = MOCenterMonitoringPlan::find(Input::get('ID'));
			$qo->DatePlanned = Input::get('DatePlanned');
			$qo->User = User::getSysUser()->userID;
            $qo->save();
			
			return Redirect::to('DoMonitor');
			
			
			}
}
	
	public function DownloadAccreditationInstaTobeUpgradeApplication()
	{
		
		 $Count = 1;

         $tablePrintHeader = array('#', 'District','Center','Type','Course','CourseListCode','Duration','NVQ Level','Accredit Status','Accreditation Application Status');

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
				$CountCMP=0;
				
				if($userOrgType =='HO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
				}
				elseif($userOrgType =='PO')
				{
					$sqlaccrediationApp ="select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and province.ProvinceCode='$UserProvinceCode'
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				elseif($userOrgType =='DO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and district.DistrictCode=$UserDistrictCode
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				else{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and organisation.id='$userOrgId'
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				
				 foreach($sqlaccrediationAppList as $cs) 
	{
		
			
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $cs->DistrictName);
				array_push($data_row, $cs->OrgaName);
			    array_push($data_row, $cs->Type);
				array_push($data_row, $cs->CourseName);
				array_push($data_row, $cs->CourseListCode);
				array_push($data_row, $cs->Duration);
				array_push($data_row, $cs->CourseLevel);
			    array_push($data_row, $cs->Accredit);
				array_push($data_row, $cs->ApplicationReciievedStatus);
				 array_push($printablearray, $data_row);
				    
    }
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('AccreditationApplicationForUpgrade' . date('Y-m-d'));
	}
	
		public function InstantAccreditationTobeUpgradeApplication()
	{
		
		        $view = View::make("Home.AccreditationApplicationToBeUpgrade");
				$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
				
				if($userOrgType =='HO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
				}
				elseif($userOrgType =='PO')
				{
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and province.ProvinceCode='$UserProvinceCode'
										and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				elseif($userOrgType =='DO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and district.DistrictCode=$UserDistrictCode
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				else{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and organisation.id='$userOrgId'
										  and accreditationdetails.Accredit in('ToBeUpgrade')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				
				$view->ApproveACApp = $CountACApp;
				 $view->ApproveACAppList = $sqlaccrediationAppList;
				 return $view;
	}
	
	
  public function DownloadHOInstructorGradingFormsExcel()
  {
    $Year = Input::get('Year');
	$District = Input::get('District');
	$Center = Input::get('CenterID');
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
   
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','Batch','District','Centre','Centre Type','Reg.No','Trade','Course Category','Course Name','Course Level','Duration','NVQ/NON','Instructor Name','EPF No','Achived Mark(700)','Comments');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
    


   $userEMpid = User::getSysUser()->EmpId;

            if($OegaType == 'HO')
			{
				if($District == 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
					  on coursedetails.CourseCategoryId=coursecategory.id
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
					trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
					  on coursedetails.CourseCategoryId=coursecategory.id
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					 order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				  moinstructorgradingresult.*,
				 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				moinstructor.EPFNo,moinstructor.Name,
				trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
				  on coursedetails.CourseCategoryId=coursecategory.id
				  left join trade
				  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			elseif($OegaType == 'DO')
			{
				if($District == 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					   and district.DistrictCode='".$District."'
					 order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				  moinstructorgradingresult.*,
				 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			elseif($OegaType == 'PO')
			{
				if($District == 'All' && $Center  == 'All')
			{
				      $sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.ProvinceCode='".$loggedUserProvince."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				  moinstructorgradingresult.*,
				 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			 elseif($OegaType == 'NVTI')
			{
				if($District == 'All' && $Center  == 'All')
			{
				      $sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and organisation.id='".$Center."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					   and organisation.id='".$Center."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				      moinstructorgradingresult.*,
				      coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				      moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			else
			{
				if($District == 'All' && $Center  == 'All')
				{
						  $sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
						  moinstructorgradingresult.*,
						  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
						  moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  and organisation.id='".$Center."'
						  order by  district.DistrictName
						  ";
				}
				elseif($District != 'All' && $Center  == 'All')
				{
					$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
						  moinstructorgradingresult.*,
						 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
						moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  and district.DistrictCode='".$District."'
						   and organisation.id='".$Center."'
						  order by  district.DistrictName
						  ";
				}
				elseif($District != 'All' && $Center  != 'All')
				{
					$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
						  moinstructorgradingresult.*,
						  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
						  moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					 and district.DistrictCode='".$District."'
					  and organisation.id='".$Center."'
					  order by  district.DistrictName";
				}
				else
				{
					$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
						  moinstructorgradingresult.*,
						 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
						moinstructor.EPFNo,moinstructor.Name,
  trade.TradeName,coursecategory.Category
						  from moinstructorgradingresult
						  left join organisation
						  on moinstructorgradingresult.CenterId=organisation.id
						  left join district
						  on organisation.DistrictCode=district.DistrictCode
						  left join coursedetails
						  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
						  left join moinstructor
						  on moinstructorgradingresult.InstructorID=moinstructor.id
						  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
						  where moinstructorgradingresult.Deleted=0
						  and moinstructorgradingresult.Year='".$Year."'
						  order by  district.DistrictName";
						
				}
			}

           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


                foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->Year);
				array_push($data_row, $Data->Batch);
                array_push($data_row, $Data->DistrictName);
				array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				array_push($data_row, $Data->RegistrationNo);
				array_push($data_row, $Data->TradeName);
				array_push($data_row, $Data->Category);
				array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseLevel);
				array_push($data_row, $Data->Duration);
				array_push($data_row, $Data->Nvq);
				array_push($data_row, $Data->Name);
			    array_push($data_row, $Data->EPFNo);
				array_push($data_row, $Data->AchivedMark);
				array_push($data_row, $Data->Comments);
				
			
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('HOInstructorGradingReport-I' . date('Y-m-d'));
            
  }
	
  public function EditCriteriaCategory()
  {
    $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOCriteriaCategory.Edit')->with('user', User::getSysUser());
    $view->Versions = MOCourseMonitoringVersion::where('Deleted','=',0)->orderBy('VersionNo')->get();
    $view->QID = $QId;
	$view->Rec = MOCriteriaCategory::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $VersionID = Input::get('VersionID');
            $id = Input::get('QID');
			
			
			$Update = MOCriteriaCategory::where('id','=',$id)->update(array('TypeInSinhala' => $Csinhala, 'TypeInEnglish' => $Ceng,
			'Order' =>$Order,'FullWeightFoTheSection' => $FullWeightFoTheSection,'VersionID' => $VersionID ,'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewCriteriaCategory');
    }
  }
	
		
   public function EditCourseMonitoringVersion()
  {
     $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOCourseMonitoringVersion.Edit')->with('user', User::getSysUser());
 
    $view->QID = $QId;
	$view->Rec = MOCourseMonitoringVersion::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $VersionNo = Input::get('VersionNo');
			$StartDate = Input::get('StartDate');
			$EndDate = Input::get('EndDate');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			$Update = MOCourseMonitoringVersion::where('id','=',$id)->update(array('VersionNo' => $VersionNo, 'StartDate' => $StartDate,
			'EndDate' =>$EndDate,'Active' => $Active,'User' => User::getSysUser()->userID));
			
			if($Active == 1)
			{
				$updateallcourseplans = MOCenterMonitoringPlan::where('DatePlanned','>=',$StartDate)->update(array('VersionID' => $id));
			}
			
            return Redirect::to('ViewCourseMonitoringVersion');
    }
  }
	
		public function DeleteCourseMonitoringVersion()
	{
		$id = Input::get('id');
		$deleteHOMORes = MOCourseMonitoringVersion::where('id','=',$id)->update(array('Deleted' => 1));
		
		return Redirect::to('ViewCourseMonitoringVersion');
	}
	
	 public function CreateCourseMonitoringVersion()
  {
    $view = View::make('MOCourseMonitoringVersion.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $VersionNo = Input::get('VersionNo');
			$StartDate = Input::get('StartDate');
			$EndDate = Input::get('EndDate');
			$Active = Input::get('Active');
            $c = new MOCourseMonitoringVersion();
            $c->VersionNo = $VersionNo;
			$c->StartDate = $StartDate;
			$c->EndDate = $EndDate;
			$c->Active = $Active;
            $c->User = User::getSysUser()->userID;
            $c->save();
			$getVersionID = MOCourseMonitoringVersion::where('VersionNo','=',$VersionNo)->where('StartDate','=',$StartDate)->where('Active','=',$Active)->pluck('id');
			
			if($Active == 1)
			{
				$updateallcourseplans = MOCenterMonitoringPlan::where('DatePlanned','>=',$StartDate)->update(array('VersionID' => $getVersionID));
			}
            return Redirect::to('CreateCourseMonitoringVersion')->with("done", true);
        }
  }
	
 public function ViewCourseMonitoringVersion()
  {
    $view = View::make('MOCourseMonitoringVersion.View');
    $courses = MOCourseMonitoringVersion::where('Deleted','=',0)->orderBy('VersionNo')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
public function PrintInstructorCriteriaFormsEntered()
  {
    $resID = Input::get('resID');
    $html = '';
   
	$UserOrgID = User::getSysUser()->organisationId; 
	$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$OrgaType = $OegaType;
	$Districts = District::orderBy('DistrictName')->get();
	$rec = MoInstructorGradingResult::where('id','=',$resID)->first();
	$getDisCode = organisation::where('id','=',$rec->CenterId)->pluck('DistrictCode');
	$disNAme = District::where('DistrictCode','=',$getDisCode)->pluck('DistrictName');
	$OrgaName = Organisation::where('id','=',$rec->CenterId)->pluck('OrgaName');
	$OrgaType = Organisation::where('id','=',$rec->CenterId)->pluck('Type');
	$CourseName = Course::where('CD_ID','=',$rec->CD_ID)->pluck('CourseName');
	$TradeID =  Course::where('CD_ID','=',$rec->CD_ID)->pluck('TradeId');
	$TradeName = Trade::where('TradeId','=',$TradeID)->pluck('TradeName');
	$InsEPF = MOInstructor::where('id','=',$rec->InstructorID)->pluck('EPFNo');
	$InsName = MOInstructor::where('id','=',$rec->InstructorID)->pluck('Name');
    

    $Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$Criteris = MOInstructorCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();

    $FTmatkC = 0;
    $ATmarkC = 0;
    $FTotal = 0;
    $ATotal = 0;

    $html = '<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>උපදේශක  අධීක්ෂණය(ප්‍රධාන කාර්යාලය)</title>
    </head>
    <H4><Center><u>උපදේශක  පිලිබඳ තොරතුරු </u></center></H4>
   
   
    <table cellspacing="10" align="center">
	<tr><td>වර්ෂය</td> <td>'.$rec->Year.'</td> <td>කණ්ඩායම </td><td>'.$rec->Batch.'</td></tr>
	<tr><td>දිස්ත්‍රික්කය </td> <td>'.$disNAme.'</td> <td>මධ්‍යස්ථානය</td><td>'.$OrgaName.'</td></tr>
      <tr><td>වෘත්තීය </td> <td>'.$TradeName.'</td><td>පාඨමාලාව </td><td>'.$CourseName.'</td></tr>
	  <tr><td>උපදේශක  </td> <td>'.$InsName.'</td> <td>උපදේශක අංකය   </td><td>'.$InsEPF.'</td></tr>';
     
      
    $html.='</table>
    <hr/>';
	$ii = 1;
	foreach($Criteris as $cc)
		{
			
						$GetQuestion = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->where('CriteriaId','=',$cc->id)->orderBy('QOrder')->get();
						
    $html.=' 
	<table  align="center" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	$i = 1;
	   $html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black"> </font></b>'.$ii.'</td>
							  <td class="center"><b><font color="black">'.$cc->TypeInSinhala.'</br> '.$cc->TypeInEnglish.'</font></b></td>
							   <td class="center"><b><font color="black">මුළු ලකුණු </font></b></td>
							   <td class="center"><b><font color="black">පිළිතුර </font></b></td>
                             
                              <td class="center"><b><font color="black">ලැබු ලකුණු</font></b></td>
                            </tr>
                            
                     ';
					 $i = 1;
    foreach($GetQuestion as $c)
     {         
         
					 $html.='<tr>
                                    <td >'.$ii.'.'.$i++.'</td>
                                    <td >'.$c->QuestionInSinhala.'</td>';
									 $html.='<td class="center">'.$c->FullWeight.'</td>';
									
								$AnswerType = MOInstructorQuestionType::where('id','=',$c->AnswerTypeId)->pluck('TypeCode'); 
									
                                   
                               if($AnswerType == 'SE')
								{
									
									$GetAnswers = MOInstructorQuestionAnswer::where('Deleted','=',0)->where('Active','=',1)->where('QuestionId','=',$c->id)->orderBy('AnswerWeight','DESC')->get();
									$SelectedAns = MoInstructorGradingResultTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AnswerID');
									$AnswerName = MOInstructorQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInSinhala');
									$Answeight = MOInstructorQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerWeight');
									
									$html.='
                                    <td >'.$AnswerName.'</td><td >'.$Answeight.'</td></tr>';
                                  
								}
								else
								{
									
								$SelectedAns = MoInstructorGradingResultTrans::where('Deleted','=',0)->where('MIDRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AchivedMark');
									
									$html.='
                                    <td >'.$SelectedAns.'</td><td ></td></tr>';
								}
                                
                                    
                                    
                
                                
              

                                    
             
                               
                           
    }
	 $ii++;
	 
	 $html.='</table></br>';
		}
             
      $html.='<pre bgcolor="RED"><h4><b><font color="RED"> Final Results Summary</font></b></h4></pre>
							<table  align="left" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
							  <tr id="d0" style="background-color:#CC9999">
								     
                                  
                                    <th class="center">Total Marks</th>
									
									  <th class="center">Total Achieved Marks</th>
                                </tr>
							   <tr>
								    
									<th class="center"><font color="blue">'.$rec->TotalWeight.'</font></th>
                                   
									<th class="center"><font color="blue">'.$rec->AchivedMark.'</font></th>
                                </tr>
								
                            
                        </table></br>';
			 /*  
			 $html.='<tr>
							<td class="center"><b><font color="green"><center></center></font></b></td>
                            <td class="center"><b><font color="green"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="green"></font></b></td>
							 <td class="center"><b><font color="green"><center>පාඨමාලා සංඛ්‍යාව</center></font></b></td>
                            <td class="center"><b><font color="green">'.$rec->NoOfCourses.'</font></b></td>

              </tr>';
			  $html.='<tr>
							<td class="center"><b><font color="red"><center></center></font></b></td>
                            <td class="center"><b><font color="red"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="red"></font></b></td>
							 <td class="center"><b><font color="red"><center>ශ්‍රේණිය</center></font></b></td>
                            <td class="center"><b><font color="red">'.$rec->CenterGrade.'</font></b></td>

              </tr> 
			  */
             

             
           $html.='</br/><h4 style="page-break-before: always"><u>විශේෂ සටහන් (Other Comments)</u></h4><p style="text-align: justify;">';
	
	
	
	
	$html.='<p>'.$rec->Comments.'</p>
	
    <body></html>';

    return $html;
  }
	
	public function DeleteInstructorCriteriaFormsEntered()
	{
		$id = Input::get('id');
		$deleteHOMORes = MoInstructorGradingResult::where('id','=',$id)->update(array('Deleted' => 1));
		$deleteHOMOResTrans = MoInstructorGradingResultTrans::where('MIDRID','=',$id)->update(array('Deleted' => 1));
		return Redirect::to('ViewInstructorCriteriaForms');
	}
	
		 public function ViewInstructorCriteriaFormsEntered()
  {
        $ID = Input::get('id');
        $view = View::make('MOInstructorMonitor.TOView');
	    $UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$view->OrgaType = $OegaType;
		$view->Districts = District::orderBy('DistrictName')->get();
		$rec = MoInstructorGradingResult::where('id','=',$ID)->first();
		$view->rec = $rec;
      
      $view->CenterMoniPlan = $ID;
   

    $method=Request::getMethod();
    $Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$Criteris = MOInstructorCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
	$view->Criteris = $Criteris;
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
	
	
	public function EditInstructorCriteriaForms()
	{
	$ID = Input::get('id');
	$view = View::make('MOInstructorMonitor.TOEdit');
	$Questions = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	 $Criteris = MOInstructorCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Trades = Trade::where('Deleted','=',0)->orderBy('TradeName')->get();
	$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
    $rec = MoInstructorGradingResult::where('id','=',$ID)->first();
	$view->rec = $rec;
	$view->Criteris = $Criteris;
	$TeadeRec = Course::where('CD_ID','=',$rec->CD_ID)->pluck('TradeId');
	$view->Courses = Course::where('TradeId','=',$TeadeRec)->where('Deleted','=',0)->orderBy('CourseName')->get();
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->whereIn('Active',['Yes','Closed'])->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
      ->whereIn('Active',['Yes','Closed'])
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
    ->whereIn('Active',['Yes','Closed'])
      ->orderBy('OrgaName')
      ->get();
    }
    else
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
     ->whereIn('Active',['Yes','Closed'])
      ->orderBy('OrgaName')
      ->get();
    }
 
    $view->Questions = $Questions;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
		if($method == 'POST')
		{
		   $ResId = Input::get('resID');
		   $CenterID = Input::get('CenterID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
           $NoOfCourses = Input::get('NoOfCourses');
		   $InstructorID = Input::get('NVQPackage');
		   $CD_ID = Input::get('CourseListCode');
		   $Batch = Input::get('Batch');

            //Clear data tables
           $deletemonitoringTable = MoInstructorGradingResultTrans::where('MIDRID','=',$ResId)->update(array("Deleted" => 1));
          
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
		   $TotalTarget = 0;
		   $TotalReg = 0;
		   $TotalCompleted = 0;
		   $TotalPreAssess = 0;
		   $TotalFinalAssess = 0;
		   $TotalNVQ = 0;
		   $TotalAccreditNVQ = 0;
		   $TotalLeaveTaken = 0;
		   
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOInstructorCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOInstructorQuestionType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOInstructorCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOInstructorQuestionType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
              if($getCalType == 'SE')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = MOInstructorQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new MoInstructorGradingResultTrans();
				$c->MIDRID = $ResId;
                $c->QuestionID = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $mark;
                $c->CenterID = $CenterID;
                $c->Year = $Year;
				$c->Batch = $Batch;
				$c->InstructorID = $InstructorID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
             else
              {
				  $AnswerWeghtID = $AnswerID[$i];
				  $c = new MoInstructorGradingResultTrans();
				  
				 if($i == 0)
				 {
					 $TotalTarget = $AnswerWeghtID;
				 }
				 elseif($i == 1)
				 {
					 $TotalReg = $AnswerWeghtID;
				 }
				 elseif($i == 2)
				 {
					 $TotalCompleted = $AnswerWeghtID;
				 }
				 
				 elseif($i == 3)
				 {
					 $TotalFinalAssess = $AnswerWeghtID;
				 }
				 elseif($i == 4)
				 {
					 $TotalNVQ = $AnswerWeghtID;
				 }
				  elseif($i == 5)
				 {
					 $TotalAccreditNVQ = $AnswerWeghtID;
				 }
				 elseif($i == 6)
				 {
					 $TotalLeaveTaken = $AnswerWeghtID;
				 }
				 else
				 {
					 
				 }
				 
				  
				$c->MIDRID = $ResId;
                $c->QuestionId = $IndividualQuestionsID;
                $c->AnswerID = 999999;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $AnswerWeghtID;
                $c->CenterId = $CenterID;
                $c->Year = $Year;
				$c->Batch = $Batch;
				$c->InstructorID = $InstructorID;
                $c->User = User::getSysUser()->userID;
                $c->save();

              
              }
           }
		   
		  $TotalPercentageregtranee = round((($TotalReg/$TotalTarget)*100),0);
		  if($TotalPercentageregtranee>= 80)
		  {
			  $FinalMark = $FinalMark + 20;
		  }
		  elseif($TotalPercentageregtranee<=79 && $TotalPercentageregtranee>=60)
		  {
			  $FinalMark = $FinalMark + 15;
		  }
		  elseif($TotalPercentageregtranee<=59 && $TotalPercentageregtranee>=40)
		  {
			  $FinalMark = $FinalMark + 10;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  
		  $TotalCompletedPercentage = round((($TotalCompleted/$TotalTarget)*100),0);
		  if($TotalCompletedPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 40;
		  }
		  elseif($TotalCompletedPercentage<=79 && $TotalCompletedPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 25;
		  }
		  elseif($TotalCompletedPercentage<=59 && $TotalCompletedPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 15;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  
		  /* $TotalPreAssessPercentage = round((($TotalPreAssess/$TotalTarget)*100),0);
		  if($TotalPreAssessPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 60;
		  }
		  elseif($TotalPreAssessPercentage<=79 && $TotalPreAssessPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 40;
		  }
		  elseif($TotalPreAssessPercentage<=59 && $TotalPreAssessPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 25;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  } */
		  
		  $TotalFinalAssessPercentage = round((($TotalFinalAssess/$TotalTarget)*100),0);
		  
		  if($TotalFinalAssessPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 50;
		  }
		  elseif($TotalFinalAssessPercentage<=79 && $TotalFinalAssessPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 30;
		  }
		  elseif($TotalFinalAssessPercentage<=59 && $TotalFinalAssessPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 15;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  
		  $TotalNVQPercentage = round((($TotalNVQ/$TotalTarget)*100),0);
		  if($TotalNVQPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 60;
		  }
		  elseif($TotalNVQPercentage<=79 && $TotalNVQPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 40;
		  }
		  elseif($TotalNVQPercentage<=59 && $TotalNVQPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 25;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  $TotalAccreditNVQPercentage = round((($TotalAccreditNVQ/$TotalTarget)*100),0);  
		   if($TotalAccreditNVQPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 200;
		  }
		  elseif($TotalAccreditNVQPercentage<=79 && $TotalAccreditNVQPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 100;
		  }
		  elseif($TotalAccreditNVQPercentage<=59 && $TotalAccreditNVQPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 50;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
          
		 if($TotalLeaveTaken>42)
		 {
			 $FinalMark = $FinalMark - ($TotalLeaveTaken-42);
			 
		 }
		 elseif($TotalLeaveTaken<=42 && $TotalLeaveTaken>=35)
		 {
			 $FinalMark = $FinalMark + 0;
		 }
		 elseif($TotalLeaveTaken<=34 && $TotalLeaveTaken>=23)
		 {
			 $FinalMark = $FinalMark + 15;
		 }
		 elseif($TotalLeaveTaken<=22 && $TotalLeaveTaken>=11)
		 {
			 $FinalMark = $FinalMark + 25;
		 }
		 else
		 {
			 $FinalMark = $FinalMark + 40;
		 }

		$totweight = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->sum('FullWeight');
		
		$UpdateResultTable = MoInstructorGradingResult::where('id','=',$ResId)->update(array('CenterId' => $CenterID,'Year' => $Year,'Batch' => $Batch,'TotalWeight' =>$totweight,
		'AchivedMark'=>$FinalMark,'CD_ID' =>$CD_ID,'Comments' =>$Dreason,'InstructorID' =>$InstructorID,'User' => User::getSysUser()->userID));
            
			return Redirect::to('ViewInstructorCriteriaForms')->with("done", true);
		}
		
	}
	
  public function ViewInstructorCriteriaForms()
  {
    $view = View::make('MOInstructorMonitor.View');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
	  $view->Districts = District::orderBy('DistrictName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
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
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
			$Center = Input::get('CenterID');
			$District = Input::get('District');
            $userEMpid = User::getSysUser()->EmpId;

            if($OegaType == 'HO')
			{
				if($District == 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					 order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				  moinstructorgradingresult.*,
				 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			elseif($OegaType == 'DO')
			{
				if($District == 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					   and district.DistrictCode='".$District."'
					 order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				  moinstructorgradingresult.*,
				 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			elseif($OegaType == 'PO')
			{
				if($District == 'All' && $Center  == 'All')
			{
				      $sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.ProvinceCode='".$loggedUserProvince."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				  moinstructorgradingresult.*,
				 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			 elseif($OegaType == 'NVTI')
			{
				if($District == 'All' && $Center  == 'All')
			{
				      $sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and organisation.id='".$Center."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					   and organisation.id='".$Center."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				      moinstructorgradingresult.*,
				      coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				      moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			else
			{
				if($District == 'All' && $Center  == 'All')
			{
				      $sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					  moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and organisation.id='".$Center."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  == 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  and district.DistrictCode='".$District."'
					   and organisation.id='".$Center."'
					  order by  district.DistrictName
					  ";
			}
			elseif($District != 'All' && $Center  != 'All')
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
				      moinstructorgradingresult.*,
				      coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
				      moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
				  from moinstructorgradingresult
				  left join organisation
				  on moinstructorgradingresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  left join coursedetails
				  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
				  left join moinstructor
				  on moinstructorgradingresult.InstructorID=moinstructor.id
				  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
				  where moinstructorgradingresult.Deleted=0
				  and moinstructorgradingresult.Year='".$Year."'
				 and district.DistrictCode='".$District."'
				  and organisation.id='".$Center."'
				  order by  district.DistrictName";
			}
			else
			{
				$sql="select district.DistrictName, organisation.OrgaName,organisation.Type, organisation.RegistrationNo,
					  moinstructorgradingresult.*,
					 coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.Nvq,coursedetails.CourseLevel,
					moinstructor.EPFNo,moinstructor.Name,
                      trade.TradeName,coursecategory.Category
					  from moinstructorgradingresult
					  left join organisation
					  on moinstructorgradingresult.CenterId=organisation.id
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left join coursedetails
					  on moinstructorgradingresult.CD_ID=coursedetails.CD_ID
					  left join moinstructor
					  on moinstructorgradingresult.InstructorID=moinstructor.id
					  left join coursecategory
  on coursedetails.CourseCategoryId=coursecategory.id
  left join trade
  on coursedetails.TradeId=trade.TradeId
					  where moinstructorgradingresult.Deleted=0
					  and moinstructorgradingresult.Year='".$Year."'
					  order by  district.DistrictName";
					
			}
			}
			
          $courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
		  $view->PCenter = $Center;
		  $view->PDistrict = $District;
          $view->courses = $courses;
          return $view;
        }

  }
	
	public function SaveMOInstructorGrading()
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

            
			$Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();

           $html='';
			/* foreach($Ins As $i){
			  //  $html.='<option value="'.$i->id.'" selected>'.$i->Name.'-'.$i->EPFNo.'</option>';
				$html.='<option value="'.$i->id.'" selected>'.$i->EPFNo.' - '.$i->Name.'</option>';
			} */
			foreach($Instructors As $i)
			{
				//$html.='<option value="'.$i->id.'">'.$i->Name.'-'.$i->EPFNo.'</option>';
				$html.='<option value="'.$i->id.'">'.$i->EPFNo.' - '.$i->Name.'</option>';
			}
        $html.='';
    return $html;
            //$json = array("list" => $list,"done" => $done);
           // return json_encode($json, 0);

           
    }
	
	public function MOInstructorLoadCourse()
    {
        $tradeID = Input::get('TradeId');
     
           $sql="select coursedetails.* 
  from  coursedetails
  where coursedetails.Deleted=0 
  and coursedetails.TradeId='".$tradeID."'
  and coursedetails.CourseType='Full'
  order by coursedetails.CourseName";
  
  $EMP = DB::select(DB::raw($sql));

    return json_encode($EMP);
    }

	
	 public function CreateInstructorCriteriaForms()
  {
   
    $view = View::make('MOInstructorMonitor.TOCreate');
    $Criteris = MOInstructorCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
	
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$view->Trades = Trade::where('Deleted','=',0)->orderBy('TradeName')->get();
	$view->Instructors = MOInstructor::where('Deleted','=',0)->orderBy('Name')->get();
    if($OegaType == 'HO')
    {
		 $view->Districts = District::orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
     $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
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
 
    $view->Criteris = $Criteris;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {

		   $CenterID = Input::get('CenterID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
           $NoOfCourses = Input::get('NoOfCourses');
		   $InstructorID = Input::get('NVQPackage');
		   $CD_ID = Input::get('CourseListCode');
		   $Batch = Input::get('Batch');

            //Clear data tables
          // $deletemonitoringTransTable = MoInstructorGradingResultTrans::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CenterId','=',$CenterID)->where('InstructorID','=',$InstructorID)->update(array("Deleted" => 1));
           //$deleteMonitoringResultTable = MoInstructorGradingResult::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CenterId','=',$CenterID)->where('InstructorID','=',$InstructorID)->update(array("Deleted" => 1));
          $AvailableCount = MoInstructorGradingResult::where('Year','=',$Year)->where('Batch','like',$Batch)->where('Deleted','=',0)->where('InstructorID','=',$InstructorID)->count();
		  if($AvailableCount ==0)
		  {
		  
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
		   $TotalTarget = 0;
		   $TotalReg = 0;
		   $TotalCompleted = 0;
		   $TotalPreAssess = 0;
		   $TotalFinalAssess = 0;
		   $TotalNVQ = 0;
		   $TotalAccreditNVQ = 0;
		   $TotalLeaveTaken = 0;
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = MOInstructorCriteriaQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = MOInstructorQuestionType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
              if($getCalType == 'SE')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = MOInstructorQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new MoInstructorGradingResultTrans();
                $c->QuestionID = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $mark;
                $c->CenterID = $CenterID;
                $c->Year = $Year;
				$c->InstructorID = $InstructorID;
				$c->Batch = $Batch;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              
              else
              {
				  $AnswerWeghtID = $AnswerID[$i];
				  $c = new MoInstructorGradingResultTrans();
				  
				 if($i == 0)
				 {
					 $TotalTarget = $AnswerWeghtID;
				 }
				 elseif($i == 1)
				 {
					 $TotalReg = $AnswerWeghtID;
				 }
				 elseif($i == 2)
				 {
					 $TotalCompleted = $AnswerWeghtID;
				 }
				 
				 elseif($i == 3)
				 {
					 $TotalFinalAssess = $AnswerWeghtID;
				 }
				 elseif($i == 4)
				 {
					 $TotalNVQ = $AnswerWeghtID;
				 }
				  elseif($i == 5)
				 {
					 $TotalAccreditNVQ = $AnswerWeghtID;
				 }
				 elseif($i == 6)
				 {
					 $TotalLeaveTaken = $AnswerWeghtID;
				 }
				 else
				 {
					 
				 }
				 
				  
				
                $c->QuestionId = $IndividualQuestionsID;
                $c->AnswerID = 999999;
                $c->AnswerType = $getCalType;
                $c->AchivedMark = $AnswerWeghtID;
                $c->CenterId = $CenterID;
                $c->Year = $Year;
				$c->InstructorID = $InstructorID;
				$c->Batch = $Batch;
                $c->User = User::getSysUser()->userID;
                $c->save();

              
              }
           }
	
		  $TotalPercentageregtranee = round((($TotalReg/$TotalTarget)*100),0);
		  if($TotalPercentageregtranee>= 80)
		  {
			  $FinalMark = $FinalMark + 20;
		  }
		  elseif($TotalPercentageregtranee<=79 && $TotalPercentageregtranee>=60)
		  {
			  $FinalMark = $FinalMark + 15;
		  }
		  elseif($TotalPercentageregtranee<=59 && $TotalPercentageregtranee>=40)
		  {
			  $FinalMark = $FinalMark + 10;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  
		  $TotalCompletedPercentage = round((($TotalCompleted/$TotalTarget)*100),0);
		  if($TotalCompletedPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 40;
		  }
		  elseif($TotalCompletedPercentage<=79 && $TotalCompletedPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 25;
		  }
		  elseif($TotalCompletedPercentage<=59 && $TotalCompletedPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 15;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  
		  /* $TotalPreAssessPercentage = round((($TotalPreAssess/$TotalTarget)*100),0);
		  if($TotalPreAssessPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 60;
		  }
		  elseif($TotalPreAssessPercentage<=79 && $TotalPreAssessPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 40;
		  }
		  elseif($TotalPreAssessPercentage<=59 && $TotalPreAssessPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 25;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  } */
		  
		  $TotalFinalAssessPercentage = round((($TotalFinalAssess/$TotalTarget)*100),0);
		  
		  if($TotalFinalAssessPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 50;
		  }
		  elseif($TotalFinalAssessPercentage<=79 && $TotalFinalAssessPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 30;
		  }
		  elseif($TotalFinalAssessPercentage<=59 && $TotalFinalAssessPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 15;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  
		  $TotalNVQPercentage = round((($TotalNVQ/$TotalTarget)*100),0);
		  if($TotalNVQPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 60;
		  }
		  elseif($TotalNVQPercentage<=79 && $TotalNVQPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 40;
		  }
		  elseif($TotalNVQPercentage<=59 && $TotalNVQPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 25;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
		  $TotalAccreditNVQPercentage = round((($TotalAccreditNVQ/$TotalTarget)*100),0);  
		   if($TotalAccreditNVQPercentage>= 80)
		  {
			  $FinalMark = $FinalMark + 200;
		  }
		  elseif($TotalAccreditNVQPercentage<=79 && $TotalAccreditNVQPercentage>=60)
		  {
			  $FinalMark = $FinalMark + 100;
		  }
		  elseif($TotalAccreditNVQPercentage<=59 && $TotalAccreditNVQPercentage>=40)
		  {
			  $FinalMark = $FinalMark + 50;
		  }
		  else
		  {
			  $FinalMark = $FinalMark + 0;
		  }
          
		 if($TotalLeaveTaken>42)
		 {
			 $FinalMark = $FinalMark - ($TotalLeaveTaken-42);
			 
		 }
		 elseif($TotalLeaveTaken<=42 && $TotalLeaveTaken>=35)
		 {
			 $FinalMark = $FinalMark + 0;
		 }
		 elseif($TotalLeaveTaken<=34 && $TotalLeaveTaken>=23)
		 {
			 $FinalMark = $FinalMark + 15;
		 }
		 elseif($TotalLeaveTaken<=22 && $TotalLeaveTaken>=11)
		 {
			 $FinalMark = $FinalMark + 25;
		 }
		 else
		 {
			 $FinalMark = $FinalMark + 40;
		 }
		  
			$totweight = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->sum('FullWeight');
            $d = new MoInstructorGradingResult();
            $d->CenterId = $CenterID;
            $d->Year = $Year;
			$d->Batch = $Batch;
            $d->TotalWeight = $totweight;
			$d->AchivedMark = $FinalMark;
            $d->CD_ID = $CD_ID;
            $d->Comments = $Dreason;
			$d->InstructorID = $InstructorID;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = MoInstructorGradingResult::where('Deleted','=',0)->where('Year','=',$Year)->where('CenterId','=',$CenterID)->where('Batch','like',$Batch)->where('InstructorID','=',$InstructorID)->pluck('id');
			
			$updateHOCentreMonitoringResultTrans = MoInstructorGradingResultTrans::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CenterId','=',$CenterID)->where('InstructorID','=',$InstructorID)
			->where('Deleted','=',0)
			->update(array('MIDRID' => $HOCMRId));


            
            return Redirect::to('CreateInstructorCriteriaForms')->with("done", true);

        }
		else
		{
			return Redirect::to('CreateInstructorCriteriaForms')->with("Error", true);
		}
		}
		
    

  }
	
	public function DeleteInstructorCriteriaCategoryAnswers()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOInstructorQuestionAnswer::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
   
    return Redirect::to('ViewInstructorCriteriaCategoryAnswers');
  }
	
	   public function EditInstructorCriteriaCategoryAnswers()
  {
     $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOInstructorCriteriaQuestionAnswer.Edit')->with('user', User::getSysUser());
  $view->Answertypes = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
    $view->QID = $QId;
	$view->Rec = MOInstructorQuestionAnswer::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $QuestionId = Input::get('QuestionId');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			
			
			
			$Update = MOInstructorQuestionAnswer::where('id','=',$id)->update(array('QuestionId' => $QuestionId, 'AnswerInSinhala' => $Csinhala,
			'AnswerInEnglish' =>$Ceng,'AnswerWeight' => $FullWeightFoTheSection,'Active' =>$Active,'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewInstructorCriteriaCategoryAnswers');
    }
  }
	
	public function CreateInstructorCriteriaCategoryAnswers()
  {
    $view = View::make('MOInstructorCriteriaQuestionAnswer.Create');
    $view->Answertypes = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $QuestionId = Input::get('QuestionId');
			$Active = Input::get('Active');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
			
            $c = new MOInstructorQuestionAnswer();
			$c->QuestionId = $QuestionId;
            $c->AnswerInSinhala = $Csinhala;
            $c->AnswerInEnglish = $Ceng;
            $c->AnswerWeight = $FullWeightFoTheSection;
			$c->Active = $Active;
			$c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateInstructorCriteriaCategoryAnswers')->with("done", true);
        }
  }
	
	public function ViewInstructorCriteriaCategoryAnswers()
  {
    $view = View::make('MOInstructorCriteriaQuestionAnswer.View');
    $courses = DB::select(DB::raw("select moinstructorquestionanswer.*,moinstructorcriteriaquestion.QuestionInSinhala
                                   from moinstructorquestionanswer
                                   left join moinstructorcriteriaquestion
                                   on moinstructorquestionanswer.QuestionId=moinstructorcriteriaquestion.id
                                   where moinstructorquestionanswer.Deleted=0
                                   order by moinstructorquestionanswer.AnswerWeight"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
  public function DeleteInstructorCriteriaCategoryQuestion()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOInstructorCriteriaQuestion::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
    $cc = MOInstructorQuestionAnswer::where('QuestionId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewInstructorCriteriaCategoryQuestion');
  }
	
  public function EditInstructorCriteriaCategoryQuestion()
  {
    $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOInstructorCriteriaQuestion.Edit')->with('user', User::getSysUser());
    $view->Answertypes = MOInstructorQuestionType::where('Deleted','=',0)->get();
	$view->Category = MOInstructorCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
    $view->QID = $QId;
	$view->Rec = MOInstructorCriteriaQuestion::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            //$maxOrder = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->max('QOrder');
            //$max = $maxOrder+1;
			$AnswerTypeId = Input::get('AnswerTypeId');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			$CategoryId = Input::get('CategoryId');
			
			$Update = MOInstructorCriteriaQuestion::where('id','=',$id)->update(array('QuestionInSinhala' => $Csinhala, 'QuestionInEnglish' => $Ceng,
			'QOrder' =>$Order,'Active' => $Active,'AnswerTypeId' =>$AnswerTypeId,'FullWeight' => $FullWeightFoTheSection,'CriteriaId' => $CategoryId ,'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewInstructorCriteriaCategoryQuestion');
    }
  }
	
		
	public function CreateInstructorCriteriaCategoryQuestion()
  {
    $view = View::make('MOInstructorCriteriaQuestion.Create');
    $view->Answertypes = MOInstructorQuestionType::where('Deleted','=',0)->get();
	$view->Category = MOInstructorCriteriaCategory::where('Deleted','=',0)->where('Active','=',1)->orderBy('Order')->get();
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $maxOrder = MOInstructorCriteriaQuestion::where('Deleted','=',0)->where('Active','=',1)->max('QOrder');
            $max = $maxOrder+1;
			$AnswerTypeId = Input::get('AnswerTypeId');
			$Active = Input::get('Active');
			$CategoryId = Input::get('CategoryId');
			
            $c = new MOInstructorCriteriaQuestion();
            $c->QuestionInSinhala = $Csinhala;
			$c->CriteriaId = $CategoryId;
            $c->QuestionInEnglish = $Ceng;
            $c->QOrder = $max;
			$c->Active = $Active;
			$c->AnswerTypeId = $AnswerTypeId;
			$c->FullWeight  = $FullWeightFoTheSection;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateInstructorCriteriaCategoryQuestion')->with("done", true);
        }
  }
	
		 public function ViewInstructorCriteriaCategoryQuestion()
  {
    $view = View::make('MOInstructorCriteriaQuestion.View');
    $courses = DB::select(DB::raw("select moinstructorcriteriaquestion.*,moinstructorquestiontype.AnswerType
  from moinstructorcriteriaquestion
  left join moinstructorquestiontype
  on moinstructorcriteriaquestion.AnswerTypeId=moinstructorquestiontype.id
  where moinstructorcriteriaquestion.Deleted=0
  order by moinstructorcriteriaquestion.QOrder"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
   public function EditHOCenterGradingQuestionAnswers()
  {
     $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('HOCenterMonitoringQuestionAnswers.Edit')->with('user', User::getSysUser());
  $view->Answertypes = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
    $view->QID = $QId;
	$view->Rec = HOCentreMonitoringQuestionAnswer::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $QuestionId = Input::get('QuestionId');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			
			
			
			$Update = HOCentreMonitoringQuestionAnswer::where('id','=',$id)->update(array('QuestionId' => $QuestionId, 'AnswerInSinhala' => $Csinhala,
			'AnswerInEnglish' =>$Ceng,'AnswerWeight' => $FullWeightFoTheSection,'Active' =>$Active,'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewHOCenterMonitoringQuestionAnswers');
    }
  }
	
	 public function EditHOCenterGradingQuestion()
  {
    $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('HOCenterMonitoringQuestion.Edit')->with('user', User::getSysUser());
    $view->Answertypes = HOCentreMonitoringQuestionAnswerType::where('Deleted','=',0)->get();
    $view->QID = $QId;
	$view->Rec = HOCentreMonitoringQuestion::where('id','=',$QId)->first();
    
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            //$maxOrder = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->max('QOrder');
            //$max = $maxOrder+1;
			$AnswerTypeId = Input::get('AnswerTypeId');
			$Active = Input::get('Active');
			$id = Input::get('QID');
			
			$Update = HOCentreMonitoringQuestion::where('id','=',$id)->update(array('QuestionInSinhala' => $Csinhala, 'QuestionInEnglish' => $Ceng,
			'QOrder' =>$Order,'Active' => $Active,'AnswerTypeId' =>$AnswerTypeId,'FullWeight' => $FullWeightFoTheSection, 'User' => User::getSysUser()->userID));
			
            return Redirect::to('ViewHOCenterMonitoringQuestion');
    }
  }
	
 public function DownloadHOCenterMonitoringGradewiseFullDetailsReport()
  {
    $Year = Input::get('Year');
	$District = Input::get('District');
   
    $Count = 1;
	$AllQuestions = HOCentreMonitoringQuestion::where('Deleted','=',0)->orderBy('QOrder')->get();
	$CountAllQuestions = count($AllQuestions);

    $tablePrintHeader = array('#','Year','District/NVTI Name','Centre Name','Centre Type','Reg No','Questions');
	
    $excel = new SimpleExcel('csv');
    $printablearray = array();
	 array_push($printablearray, $tablePrintHeader);
	 $data_rowHeaderQues = array();
	 $data_rowHeaderAnswers = array();
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
     array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 array_push($data_rowHeaderQues, ' ');
	 
	  array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
     array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 
	foreach($AllQuestions as $QA)
	{
		$UniqAnswersForQuestion = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$QA->id)
		->where('Deleted','=',0)
		->where('Active','=',1)
		->orderBy('id','ASC')
		->get();
		$anscount = count($UniqAnswersForQuestion);
		       
	    array_push($data_rowHeaderQues, $QA->QuestionInEnglish);
		foreach($UniqAnswersForQuestion as $QAA)
	    {
		  
		  array_push($data_rowHeaderAnswers, $QAA->AnswerInEnglish);
		 
	    }
		for($r=0;$r<$anscount-1;$r++)
		{
			 array_push($data_rowHeaderQues, ' ');
		}
				
				
			
               
                
	}
	 array_push($data_rowHeaderQues, 'Total Mark Achived(Out of 100)');
	 array_push($data_rowHeaderQues, 'No Of Courses');
	 array_push($data_rowHeaderQues, 'Grade');
	 array_push($data_rowHeaderQues, 'Comments');
	 
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 array_push($data_rowHeaderAnswers, ' ');
	 
	 array_push($printablearray, $data_rowHeaderQues);
	  array_push($printablearray, $data_rowHeaderAnswers);
	 
	 //all answers
	
    $i = 1;
        if ($District == 'All') {

 
  $sqldis="select district.DistrictName,
  organisation.id,
  organisation.OrgaName,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  group by organisation.id
  order by district.DistrictName,organisation.id
";
$sqlnvti="select organisation.OrgaName,
organisation.id,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  

}
else 
{
   $sqldis="select district.DistrictName,
   organisation.id,
  organisation.OrgaName,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  and organisation.DistrictCode='".$District."'
  group by organisation.id
  order by district.DistrictName,organisation.id
";

$sqlnvti="select organisation.id,
organisation.OrgaName,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and district.DistrictCode='".$District."'
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  
 
}

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			$total_recnvti = DB::select(DB::raw($sqlnvti));


                foreach($total_rec as $Data) {
				           
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Year);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				array_push($data_row, $Data->RegistrationNo);
				
				foreach($AllQuestions as $QA)
				{
							 $UniqAnswersForQuestion = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('id')->get();
							 foreach($UniqAnswersForQuestion as $ANS)
							 {
								 $REC = HOCentreMonitoringResultTrans::where('QuestionId','=',$QA->id)->where('AnswerID','=',$ANS->id)->where('CenterId','=',$Data->id)->where('Year','=',$Year)->where('Deleted','=',0)
								 ->first();
								 if(count($REC) == 0)
								 {
									 array_push($data_row, 'No');
								 }
								 else
								 {
									 array_push($data_row, 'Yes');
								 }
							 }
							
							 
							 
				}
				
				array_push($data_row, $Data->AchivedMark);
				array_push($data_row, $Data->NoOfCourses);
				array_push($data_row, $Data->CenterGrade);
				array_push($data_row, $Data->Comments);
               
                array_push($printablearray, $data_row);
                            
                }
				foreach($total_recnvti as $Data) {
					
                 $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Year);
                array_push($data_row, $Data->OrgaName);
                array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				array_push($data_row, $Data->RegistrationNo);
				
				foreach($AllQuestions as $QA)
						 {
							 $UniqAnswersForQuestion = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('id')->get();
							 foreach($UniqAnswersForQuestion as $ANS)
							 {
								 $REC = HOCentreMonitoringResultTrans::where('QuestionId','=',$QA->id)->where('AnswerID','=',$ANS->id)->where('CenterId','=',$Data->id)->where('Year','=',$Year)->where('Deleted','=',0)
								 ->first();
								 if(count($REC) == 0)
								 {
									 array_push($data_row, 'No');
								 }
								 else
								 {
									 array_push($data_row, 'Yes');
								 }
							 }
							
							 
							 
						 }
				
				array_push($data_row, $Data->AchivedMark);
				array_push($data_row, $Data->NoOfCourses);
				array_push($data_row, $Data->CenterGrade);
				array_push($data_row, $Data->Comments);
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseHOCentreGradingDetailReport' . date('Y-m-d'));
            
  } 
	
	public function LoadHOCenterMonitoringGradewiseFullDetailsReport()
	{
		
		$District = Input::get('District');
		if($District != 'All')
		{
			
		$DistrictName  = District::where('DistrictCode','=',$District)->pluck('DistrictName');
		
		}
		else
		{
			$DistrictName  = $District;
		}
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';
		
		$AllQuestions = HOCentreMonitoringQuestion::where('Deleted','=',0)->orderBy('QOrder')->get();
		$CountAllQuestions = count($AllQuestions);
            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Centre Grading Detail Report<pre><h5> Year:'.$Year.' District '.$DistrictName.' With NVTI</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">No</th>
							 <th align="center" class="center" rowspan="2">Year</th>
                            <th align="center" class="center" rowspan="2">District/NVTI Name</th>
							<th align="center" class="center" rowspan="2">Centre Name</th>
                            <th align="center" class="center"  rowspan="2">Centre Type</th>
							<th align="center" class="center"  rowspan="2">Reg No.</th>';
							
							
							
						
						 foreach($AllQuestions as $QA)
						 {
							 $UniqAnswersForQuestion = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('AnswerWeight')->get();
							  $anscount = count($UniqAnswersForQuestion);
							
							 $html.='<th align="center" class="center" colspan="'.$anscount.'">'.$QA->QuestionInSinhala.'<br/>'.$QA->QuestionInEnglish.'</th>';
							
							 
							 
						 }
						  $html.='<th align="center" class="center"  rowspan="2">Total Mark Achived(Out of 100)</th>
						  <th align="center" class="center"  rowspan="2">NoOf Courses</th>
						  <th align="center" class="center"  rowspan="2">Grade</th>
						  <th align="center" class="center"  rowspan="2">Comments</th></tr>';
						  $AllAnswers = DB::select(DB::raw("select hocentremonitoringquestionanswer.*
															 from hocentremonitoringquestionanswer
															  left join hocentremonitoringquestion
															  on hocentremonitoringquestionanswer.QuestionId=hocentremonitoringquestion.id
															  where hocentremonitoringquestionanswer.Deleted=0
															  and hocentremonitoringquestionanswer.Active=1
															  and hocentremonitoringquestion.Deleted=0
															  order by hocentremonitoringquestion.QOrder,hocentremonitoringquestionanswer.id"));
						  $html.='<tr align="center">';
						  
						 foreach($AllAnswers as $QAA)
						 {
							 
							  
							
							 $html.='<th align="center" class="center">'.$QAA->AnswerInSinhala.'<br/>'.$QAA->AnswerInEnglish.'</th>';
							
							 
							 
						 }
						  $html.='</tr>';
						 
                        
                    $html.='</thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {

 
  $sqldis="select district.DistrictName,
  organisation.id,
  organisation.OrgaName,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  group by organisation.id
  order by district.DistrictName,organisation.id
";
$sqlnvti="select organisation.OrgaName,
organisation.id,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  

}
else 
{
   $sqldis="select district.DistrictName,
   organisation.id,
  organisation.OrgaName,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  and organisation.DistrictCode='".$District."'
  group by organisation.id
  order by district.DistrictName,organisation.id";

  $sqlnvti="select organisation.id,
  organisation.OrgaName,
  organisation.Type,
  organisation.RegistrationNo,
  hocentremonitoringresult.Year,
  hocentremonitoringresult.AchivedMark,
  hocentremonitoringresult.CenterGrade,
  hocentremonitoringresult.NoOfCourses,
  hocentremonitoringresult.Comments
  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and district.DistrictCode='".$District."'
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName";
  
 
}

         //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			$total_recnvti = DB::select(DB::raw($sqlnvti));

			   foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td class="left">'.$Year.'</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->OrgaName.'</td>
							<td class="center">'.$ps->Type.'</td>
							<td class="center">'.$ps->RegistrationNo.'</td>';
							
						foreach($AllQuestions as $QA)
						 {
							 $UniqAnswersForQuestion = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('id')->get();
							 foreach($UniqAnswersForQuestion as $ANS)
							 {
								  $REC = HOCentreMonitoringResultTrans::where('QuestionId','=',$QA->id)
								 ->where('AnswerID','=',$ANS->id)
								 ->where('CenterId','=',$ps->id)->where('Year','=',$Year)
								 ->where('Deleted','=',0)
								 ->first();
								 
								 if(count($REC) == 0)
								 {
									  
									 $html.='<td class="center"></td>';
								 }
								 else
								 {
									
									 $html.='<td class="center"><font color="red"><i class="icon-ok bigger-130"></i></font></td>';
								 }
							 }
							
							 
							 
						 }
							
							
                            $html.='<td class="center">'.$ps->AchivedMark.'</td>
							<td class="center">'.$ps->NoOfCourses.'</td>
							<td class="center">'.$ps->CenterGrade.'</td>
							<td class="center">'.$ps->Comments.'</td><tr>';
							
 							
                            
                }
				foreach($total_recnvti as $ps) {
                  $html .='<tr>
                            <td class="center">' . $i++ . '</td>
							<td class="left">'.$Year.'</td>
                            <td class="left">'.$ps->OrgaName.'</td>
                            <td class="center">'.$ps->OrgaName.'</td>
							<td class="center">'.$ps->Type.'</td>
							<td class="center">'.$ps->RegistrationNo.'</td>';
							
							foreach($AllQuestions as $QA)
						 {
							 $UniqAnswersForQuestion = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$QA->id)->where('Deleted','=',0)
						      ->orderBy('id')->get();
							 foreach($UniqAnswersForQuestion as $ANS)
							 {
								 $REC = HOCentreMonitoringResultTrans::where('QuestionId','=',$QA->id)->where('AnswerID','=',$ANS->id)->where('CenterId','=',$ps->id)->where('Year','=',$Year)->where('Deleted','=',0)
								 ->first();
								 if(count($REC) == 0)
								 {
									 $html.='<td class="center"></td>';
								 }
								 else
								 {
									 $html.='<td class="center"><font color="red"><i class="icon-ok bigger-130"></i></font></td>';
								 }
							 }
							
							 
							 
						 }
							
							
                         $html.='<td class="center">'.$ps->AchivedMark.'</td>
						         <td class="center">'.$ps->NoOfCourses.'</td>
							     <td class="center">'.$ps->CenterGrade.'</td>
							     <td class="center">'.$ps->Comments.'</td><tr>';
							
							
                            
                }
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewHOCenterMonitoringGradewiseFullDetailsReport()
	{
		$method = Request::getMethod();
    $view = View::make('HOCenterMonitor.ViewHOCenterGradeFullDetailsReport');
    
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
  public function DownloadHOCenterMonitoringGradewiseReport()
  {
    $Year = Input::get('Year');
	$District = Input::get('District');
   
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','District/NVTI Name','No of NVTI','No of DVTC','No of VTC','Total No of Centres','A','B','C','D');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
      if ($District == 'All') {

 
  $sqldis="select district.DistrictName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('DVTC','VTC'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin


  from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  group by district.DistrictCode
  order by district.DistrictName
";
$sqlnvti="select organisation.OrgaName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('NVTI'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin


  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
 and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  

}
else 
{
   $sqldis="select district.DistrictName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('DVTC','VTC'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin


  from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  and district.DistrictCode='".$District."'
  group by district.DistrictCode
  order by district.DistrictName
";
$sqlnvti="select organisation.OrgaName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('NVTI'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin


  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and district.DistrictCode='".$District."'
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  
 
}

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			$total_recnvti = DB::select(DB::raw($sqlnvti));
			
			
			$Atot = 0;
$Btot = 0;
$Ctot = 0;
$Dtot = 0;
$OTotNVTI = 0;
$OTotDVTC = 0;
$OTotVTC = 0;
$OTotAllcen = 0;


                foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
				 array_push($data_row, $Year);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->DistrictNVTI);
				array_push($data_row, $Data->DistrictDVTC);
				array_push($data_row, $Data->DistrictVTC);
				array_push($data_row, $Data->TotalCen);
				array_push($data_row, $Data->GradeA);
			   // array_push($data_row, $Data->GradeAmin);
				array_push($data_row, $Data->GradeB);
			   // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Data->GradeC);
			  //  array_push($data_row, $Data->GradeCmin);
			  array_push($data_row, $Data->GradeD);
			
               
                array_push($printablearray, $data_row);
				
							$Atot = $Atot + $Data->GradeA;
							$Btot = $Btot + $Data->GradeB;
							$Ctot = $Ctot + $Data->GradeC;
							$Dtot = $Dtot + $Data->GradeD;
							$OTotNVTI = $OTotNVTI + $Data->DistrictNVTI;
							$OTotDVTC = $OTotDVTC + $Data->DistrictDVTC;
							$OTotVTC = $OTotVTC + $Data->DistrictVTC;
							$OTotAllcen = $OTotAllcen + $Data->TotalCen;
                            
                }
				foreach($total_recnvti as $Data) {
					
                $data_row = array();
                array_push($data_row, $i++);
				array_push($data_row, $Year);
                array_push($data_row, $Data->OrgaName);
                array_push($data_row, $Data->DistrictNVTI);
				array_push($data_row, $Data->DistrictDVTC);
				array_push($data_row, $Data->DistrictVTC);
				array_push($data_row, $Data->TotalCen);
				array_push($data_row, $Data->GradeA);
			   // array_push($data_row, $Data->GradeAmin);
				array_push($data_row, $Data->GradeB);
			   // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Data->GradeC);
			  //  array_push($data_row, $Data->GradeCmin);
			  array_push($data_row, $Data->GradeD);
			
               
                array_push($printablearray, $data_row);
				
							$Atot = $Atot + $Data->GradeA;
							$Btot = $Btot + $Data->GradeB;
							$Ctot = $Ctot + $Data->GradeC;
							$Dtot = $Dtot + $Data->GradeD;
							$OTotNVTI = $OTotNVTI + $Data->DistrictNVTI;
							$OTotDVTC = $OTotDVTC + $Data->DistrictDVTC;
							$OTotVTC = $OTotVTC + $Data->DistrictVTC;
							$OTotAllcen = $OTotAllcen + $Data->TotalCen;
                            
                }
				
				$data_row = array();
				array_push($data_row, $i++);
				array_push($data_row, $Year);
                array_push($data_row, 'Total');
                array_push($data_row, $OTotNVTI);
				array_push($data_row, $OTotDVTC);
				array_push($data_row, $OTotVTC);
				array_push($data_row, $OTotAllcen);
				array_push($data_row, $Atot);
			    // array_push($data_row, $Data->GradeAmin);
				array_push($data_row, $Btot);
			    // array_push($data_row, $Data->GradeBmin);
				array_push($data_row, $Ctot);
			    //  array_push($data_row, $Data->GradeCmin);
			    array_push($data_row, $Dtot);
			
               
                array_push($printablearray, $data_row);


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseHOCentreGradingReport' . date('Y-m-d'));
            
  }
	
	public function LoadHOCenterMonitoringGradewiseReport()
	{
		
		$District = Input::get('District');
		if($District != 'All')
		{
			
		$DistrictName  = District::where('DistrictCode','=',$District)->pluck('DistrictName');
		
		}
		else
		{
			$DistrictName  = $District;
		}
		$Year = Input::get('Year');
		
		$Count = 1;
		$html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    
                    </div>
                   
          
              <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Centre Grading Count Report<pre><h5> Year:'.$Year.' District '.$DistrictName.' With NVTI</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th align="center" class="center" rowspan="2">District/NVTI Name</th>
                            <th align="center" class="center"  colspan="4">No of Centres</th>
							<th align="center" class="center"  colspan="6">Grades</th>
						 </tr>
						 <tr align="center">
						  <th align="center" class="center">NVTI</th>
						  <th align="center" class="center">DVTC</th>
						  <th align="center" class="center">VTC</th>
						 
						  <th align="center" class="center">Total</th>
						  
						  <th align="center" class="center">A</th>
						 
						  <th align="center" class="center">B</th>
						 
						  <th align="center" class="center">C</th>
						  <th align="center" class="center">D</th>
						  
						  
						  </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {

 
  $sqldis="select district.DistrictName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('DVTC','VTC'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin
	


  from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  group by district.DistrictCode
  order by district.DistrictName
";
$sqlnvti="select organisation.OrgaName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('NVTI'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin
	


  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  

}
else 
{
   $sqldis="select district.DistrictName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('DVTC','VTC'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin


  from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and organisationtype.Type NOT IN('HO','DO','NVTI','PO','Attached')
  and district.DistrictCode='".$District."'
  group by district.DistrictCode
  order by district.DistrictName
";
$sqlnvti="select organisation.OrgaName,
  SUM(CASE
        WHEN
            (organisationtype.Type='NVTI')
             THEN
            1
        ELSE 0
    END) DistrictNVTI,
  SUM(CASE
        WHEN
            (organisationtype.Type='DVTC')
             THEN
            1
        ELSE 0
    END) DistrictDVTC,
  SUM(CASE
        WHEN
            (organisationtype.Type='VTC')
             THEN
            1
        ELSE 0
    END) DistrictVTC,
    SUM(CASE
        WHEN
            (organisationtype.Type IN ('NVTI'))
             THEN
            1
        ELSE 0
    END) TotalCen,
   SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A')
             THEN
            1
        ELSE 0
    END) GradeA,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='A-')
             THEN
            1
        ELSE 0
    END) GradeAmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B')
             THEN
            1
        ELSE 0
    END) GradeB,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='B-')
             THEN
            1
        ELSE 0
    END) GradeBmin,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C')
             THEN
            1
        ELSE 0
    END) GradeC,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='C-')
             THEN
            1
        ELSE 0
    END) GradeCmin,
	 SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D')
             THEN
            1
        ELSE 0
    END) GradeD,
  SUM(CASE
        WHEN
            (hocentremonitoringresult.CenterGrade='D-')
             THEN
            1
        ELSE 0
    END) GradeDmin
	


  from  organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join hocentremonitoringresult
  on organisation.id=hocentremonitoringresult.CenterId
  and hocentremonitoringresult.Deleted=0
  and hocentremonitoringresult.Year='".$Year."'
  where organisation.Deleted=0
  and (organisation.Active in('Yes') or (organisation.Active in('Closed') and Year(organisation.DateClosed)='".$Year."'))
  and district.DistrictCode='".$District."'
  and organisationtype.Type IN('NVTI')
  group by organisation.id
  order by organisation.OrgaName
";
  
 
}

$Atot = 0;
$Btot = 0;
$Ctot = 0;
$Dtot = 0;
$OTotNVTI = 0;
$OTotDVTC = 0;
$OTotVTC = 0;
$OTotAllcen = 0;

           //return $sql;
            $total_rec = DB::select(DB::raw($sqldis));
			$total_recnvti = DB::select(DB::raw($sqlnvti));

			   foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->DistrictNVTI.'</td>
							<td class="center">'.$ps->DistrictDVTC.'</td>
							<td class="center">'.$ps->DistrictVTC.'</td>
							<td class="center">'.$ps->TotalCen.'</td>
							<td class="center">'.$ps->GradeA.'</td>
							
							<td class="center">'.$ps->GradeB.'</td>
							
							<td class="center">'.$ps->GradeC.'</td>
							<td class="center">'.$ps->GradeD.'</td>';
							
			
							
                            $html.='<tr>';
							
							$Atot = $Atot + $ps->GradeA;
							$Btot = $Btot + $ps->GradeB;
							$Ctot = $Ctot + $ps->GradeC;
							$Dtot = $Dtot + $ps->GradeD;
							$OTotNVTI = $OTotNVTI + $ps->DistrictNVTI;
							$OTotDVTC = $OTotDVTC + $ps->DistrictDVTC;
							$OTotVTC = $OTotVTC + $ps->DistrictVTC;
							$OTotAllcen = $OTotAllcen + $ps->TotalCen;
							
 							
                            
                }
				foreach($total_recnvti as $ps) {
                  $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">'.$ps->OrgaName.'</td>
                            <td class="center">'.$ps->DistrictNVTI.'</td>
							<td class="center">'.$ps->DistrictDVTC.'</td>
							<td class="center">'.$ps->DistrictVTC.'</td>
							<td class="center">'.$ps->TotalCen.'</td>
							<td class="center">'.$ps->GradeA.'</td>
							
							<td class="center">'.$ps->GradeB.'</td>
							
							<td class="center">'.$ps->GradeC.'</td>
							<td class="center">'.$ps->GradeD.'</td>';
							
			
							
                            $html.='<tr>';
							
							$Atot = $Atot + $ps->GradeA;
							$Btot = $Btot + $ps->GradeB;
							$Ctot = $Ctot + $ps->GradeC;
							$Dtot = $Dtot + $ps->GradeD;
							$OTotNVTI = $OTotNVTI + $ps->DistrictNVTI;
							$OTotDVTC = $OTotDVTC + $ps->DistrictDVTC;
							$OTotVTC = $OTotVTC + $ps->DistrictVTC;
							$OTotAllcen = $OTotAllcen + $ps->TotalCen;
                            
                }
				
				 $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="left">Total</td>
                            <td class="center">'.$OTotNVTI.'</td>
							<td class="center">'.$OTotDVTC.'</td>
							<td class="center">'.$OTotVTC.'</td>
							<td class="center">'.$OTotAllcen.'</td>
							<td class="center">'.$Atot.'</td>
							
							<td class="center">'.$Btot.'</td>
							
							<td class="center">'.$Ctot.'</td>
							<td class="center">'.$Dtot.'</td>';
							
			
							
                            $html.='<tr>';
				
		
         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
	}
	
	public function ViewHOCenterMonitoringGradewiseReport()
	{
		$method = Request::getMethod();
    $view = View::make('HOCenterMonitor.ViweDistrictWiseGradeCount');
    
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
	}
	
	  public function DownloadHOCenterMonitoringFormsExcel()
  {
    $Year = Input::get('Year');
   
    $Count = 1;

    $tablePrintHeader = array('#', 'Year','District','Centre','Centre Type','Reg.No','Achived Mark(100)','No Of Courses','Grade','Comments','Remarks');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
    


  $sql = "SELECT district.DistrictName,organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
				  hocentremonitoringresult.*
				  from hocentremonitoringresult
				  left JOIN organisation
				  on hocentremonitoringresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  where hocentremonitoringresult.Deleted=0
				  and hocentremonitoringresult.Year='".$Year."'
				  order by hocentremonitoringresult.Year,district.DistrictName,hocentremonitoringresult.CenterGrade";



           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


                foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->Year);
                array_push($data_row, $Data->DistrictName);
				array_push($data_row, $Data->OrgaName);
				array_push($data_row, $Data->Type);
				array_push($data_row, $Data->RegistrationNo);
				array_push($data_row, $Data->AchivedMark);
			    array_push($data_row, $Data->NoOfCourses);
				array_push($data_row, $Data->CenterGrade);
				array_push($data_row, $Data->Comments);
				array_push($data_row, $Data->Remarks);
			
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('HOCentreGradingReport-I' . date('Y-m-d'));
            
  }

	
	public function DeleteInstructorCriteriaCategory()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOInstructorCriteriaCategory::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
    $cc = MOInstructorCriteria::where('CategoryId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewInstructorCriteriaCategory');
  }

	
	  public function CreateInstructorCriteriaCategory()
  {
    $view = View::make('MOInstructorCriteriaCategory.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $maxOrder = MOInstructorCriteriaCategory::max('Order');
            $max = $maxOrder+1;
            $c = new MOInstructorCriteriaCategory();
            $c->TypeInEnglish = $Ceng;
            $c->TypeInSinhala = $Csinhala;
            $c->Order = $max;
			$c->FullWeightFoTheSection  = $FullWeightFoTheSection;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateInstructorCriteriaCategory')->with("done", true);
        }
  }
	
	  public function ViewInstructorCriteriaCategory()
  {
    $view = View::make('MOInstructorCriteriaCategory.View');
    $courses = MOInstructorCriteriaCategory::where('Deleted','=',0)->orderBy('Order')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	 public function DeleteInstructorQuestionType()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOInstructorQuestionType::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    return Redirect::to('ViewInstructorQuestionType');
  }
	
	public function CreateInstructorQuestionType()
  {
    $view = View::make('MOInstructorQuestionType.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Type = Input::get('Type');
            $Code = Input::get('Code');
            
           
            $c = new MOInstructorQuestionType();
            $c->AnswerType = $Type;
            $c->TypeCode = $Code;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateInstructorQuestionType')->with("done", true);
        }
  }
	
	  public function ViewInstructorQuestionType()
  {
    $view = View::make('MOInstructorQuestionType.View');
    $courses = MOInstructorQuestionType::where('Deleted','=',0)->orderBy('AnswerType')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
  public function PrintHOCenterMonitoringFormsEntered()
  {
    $resID = Input::get('resID');
    $html = '';
    //return $CMPID;
	$UserOrgID = User::getSysUser()->organisationId; 
	$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$OrgaType = $OegaType;
	$Districts = District::orderBy('DistrictName')->get();
	$rec = HOCentreMonitoringResult::where('id','=',$resID)->first();
	$Centype = Organisation::where('id','=',$rec->CenterId)->pluck('Type');
     $getDisCode = organisation::where('id','=',$rec->CenterId)->pluck('DistrictCode');
				$disNAme = District::where('DistrictCode','=',$getDisCode)->pluck('DistrictName');
				$OrgaName = Organisation::where('id','=',$rec->CenterId)->pluck('OrgaName'); 
    

    $Questions = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	

    $FTmatkC = 0;
    $ATmarkC = 0;
    $FTotal = 0;
    $ATotal = 0;

    $html = '<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>පුහුණු මධ්‍යස්ථාන අධීක්ෂණය(ප්‍රධාන කාර්යාලය)</title>
    </head>
    <H4><Center><u>මධ්‍යස්ථානය පිලිබඳ තොරතුරු </u></center></H4>
   
   
    <table cellspacing="10" align="center">
	<tr><td>වර්ෂය</td> <td>'.$rec->Year.'</td> <td>මධ්‍යස්ථාන වර්ගය</td><td>'.$Centype.'</td></tr>
      <tr><td>දිස්ත්‍රික්කය</td> <td>'.$disNAme.'</td> <td>මධ්‍යස්ථානය</td><td>'.$OrgaName.'</td></tr>';
     
      
    $html.='</table>
    <hr/>
    <table  align="center" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	$i = 1;
	   $html.='<tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black"> </font></b></td>
							  <td class="center"><b><font color="black">ප්‍රශ්නය </font></b></td>
							   <td class="center"><b><font color="black">මුළු ලකුණු </font></b></td>
							   <td class="center"><b><font color="black">පිළිතුර </font></b></td>
                             
                              <td class="center"><b><font color="black">ලැබු ලකුණු</font></b></td>
                            </tr>
                            
                     ';
    foreach($Questions as $c)
     {         
         
					 $html.='<tr>
                                    <td >'.$i++.'</td>
                                    <td >'.$c->QuestionInSinhala.'</td>';
									 $html.='<td class="center">'.$c->FullWeight.'</td>';
									
									$AnswerType = HOCentreMonitoringQuestionAnswerType::where('id','=',$c->AnswerTypeId)->pluck('TypeCode'); 
									
                                   
                               if($AnswerType == 'SE')
								{
									
									$GetAnswers = HOCentreMonitoringQuestionAnswer::where('Deleted','=',0)->where('Active','=',1)->where('QuestionId','=',$c->id)->orderBy('AnswerWeight','DESC')->get();
									$SelectedAns = HOCentreMonitoringResultTrans::where('Deleted','=',0)->where('HCMRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AnswerID');
									$AnswerName = HOCentreMonitoringQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerInSinhala');
									$Answeight = HOCentreMonitoringQuestionAnswer::where('Deleted','=',0)->where('id','=',$SelectedAns)->pluck('AnswerWeight');
									
									$html.='
                                    <td >'.$AnswerName.'</td><td >'.$Answeight.'</td></tr>';
                                   //$html.=' </tr>';

                                   
                                    $FTmatkC =  $FTmatkC + $c->FullWeight;
                                    $ATmarkC = $ATmarkC + $Answeight;
								}
								else{
									
									$SelectedAns = HOCentreMonitoringResultTrans::where('Deleted','=',0)->where('HCMRID','=',$rec->id)->where('QuestionId','=',$c->id)->pluck('AchievedMark');
									
									$html.='
                                    <td >'.$SelectedAns.'</td><td ></td></tr>';
								}
                                
                                    
                                    
                
                                
              

                                    
             
                               
                           
    }
             
      $html.='<tr>
							<td class="center"><b><font color="blue"><center></center></font></b></td>
                            <td class="center"><b><font color="blue"><center>***</center></font></b></td>
                           
                            <td class="center"><b><font color="blue">'.$FTmatkC.'</font></b></td>
							 <td class="center"><b><font color="blue"><center>***</center></font></b></td>
                            <td class="center"><b><font color="blue">'.$ATmarkC.'</font></b></td>

              </tr>';
			  $html.='<tr>
							<td class="center"><b><font color="green"><center></center></font></b></td>
                            <td class="center"><b><font color="green"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="green"></font></b></td>
							 <td class="center"><b><font color="green"><center>පාඨමාලා සංඛ්‍යාව</center></font></b></td>
                            <td class="center"><b><font color="green">'.$rec->NoOfCourses.'</font></b></td>

              </tr>';
			  $html.='<tr>
							<td class="center"><b><font color="red"><center></center></font></b></td>
                            <td class="center"><b><font color="red"><center></center></font></b></td>
                           
                            <td class="center"><b><font color="red"></font></b></td>
							 <td class="center"><b><font color="red"><center>ශ්‍රේණිය</center></font></b></td>
                            <td class="center"><b><font color="red">'.$rec->CenterGrade.'</font></b></td>

              </tr>
             

             
             </table>
          
             
	
	
	<h4><u>විශේෂ සටහන් (Other Comments)</u></h4><p style="text-align: justify;">';
	
	
	
	
	$html.='<p>'.$rec->Comments.'</p></br><h4><u>Remarks</u></h4><p style="text-align: justify;"><p>'.$rec->Remarks.'</p>
	
	
    <body></html>';

    return $html;
  }
	
	 public function ViewHOCenterMonitoringFormsEntered()
  {
      $ID = Input::get('id');
      $view = View::make('HOCenterMonitor.TOView');
	  $UserOrgID = User::getSysUser()->organisationId; 
		$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
		$view->OrgaType = $OegaType;
		$view->Districts = District::orderBy('DistrictName')->get();
		$rec = HOCentreMonitoringResult::where('id','=',$ID)->first();
		$view->rec = $rec;
      
      $view->CenterMoniPlan = $ID;
   

    $method=Request::getMethod();
    $Questions = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
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
	
	public function EditHOCenterMonitoringForms()
	{
	$ID = Input::get('id');
	$view = View::make('HOCenterMonitor.TOEdit');
	$Questions = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
	$rec = HOCentreMonitoringResult::where('id','=',$ID)->first();
	$view->rec = $rec;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    else
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
 
    $view->Questions = $Questions;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
		if($method == 'POST')
		{
		   $ResId = Input::get('resID');
		   $CenterID = Input::get('CenterID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
           $NoOfCourses = Input::get('NoOfCourses');
		   $Remarks = Input::get('Remarks');

            //Clear data tables
           $deletemonitoringTable = HOCentreMonitoringResultTrans::where('HCMRID','=',$ResId)->update(array("Deleted" => 1));
          
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = HOCentreMonitoringQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = HOCentreMonitoringQuestionAnswerType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
              if($getCalType == 'SE')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = HOCentreMonitoringQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new HOCentreMonitoringResultTrans();
				$c->HCMRID = $ResId;
                $c->QuestionId = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchievedMark = $mark;
                $c->CenterId = $CenterID;
                $c->Year = $Year;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              
              else
              {
				  
				$c = new HOCentreMonitoringResultTrans();
				$c->HCMRID = $ResId;
                $c->QuestionId = $IndividualQuestionsID;
                $c->AnswerID = 999999;
                $c->AnswerType = $getCalType;
                $c->AchievedMark = $AnswerWeghtID;
                $c->CenterId = $CenterID;
                $c->Year = $Year;
                $c->User = User::getSysUser()->userID;
                $c->save();

              
              }
           }
		   
		   $CenterType = Organisation::where('id','=',$CenterID)->pluck('Type');
		   //return $CenterType;
		   if($FinalMark>=75)
		   {
			   
			   if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
		   }
		   elseif($FinalMark>=55 && $FinalMark<=74)
		   {
			   if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
		   }
		  elseif($FinalMark>=36 && $FinalMark<=54)
			{
				if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			}
			else
				{
				if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			}

			$totweight = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->sum('FullWeight');
			$UpdateResultTable = HOCentreMonitoringResult::where('id','=',$ResId)->update(array('CenterId' => $CenterID,'Year' => $Year,'TotalWeight' =>$totweight,
			'AchivedMark'=>$FinalMark,'CenterGrade' =>$CenterGrade,'Comments' =>$Dreason,'NoOfCourses' =>$NoOfCourses,'Remarks' => $Remarks,'User' => User::getSysUser()->userID));
            
			return Redirect::to('ViewHOCenterMonitoringForms')->with("done", true);
		}
		
	}
	
	public function DeleteHOCenterMonitoringForms()
	{
		$id = Input::get('id');
		$deleteHOMORes = HOCentreMonitoringResult::where('id','=',$id)->update(array('Deleted' => 1));
		$deleteHOMOResTrans = HOCentreMonitoringResultTrans::where('HCMRID','=',$id)->update(array('Deleted' => 1));
		return Redirect::to('ViewHOCenterMonitoringForms');
	}
	
  public function CreateHOCenterMonitoringForms()
  {
   
    $view = View::make('HOCenterMonitor.TOCreate');
    $Questions = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
	$UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
	$view->Districts = District::orderBy('DistrictName')->get();
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    else
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
 
    $view->Questions = $Questions;
  
    $method=Request::getMethod();
    
   
   
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {

		   $CenterID = Input::get('CenterID');
           $Year = Input::get('Year');
		   $Dreason = Input::get('Dreason');
           $QuestionsID = Input::get('QuestionsID');
           $AnswerID = Input::get('AnswerID');
           $NoOfCourses = Input::get('NoOfCourses');
		   $Remarks = Input::get('Remarks');

            //Clear data tables
           $deletemonitoringTable = HOCentreMonitoringResultTrans::where('Year','=',$Year)->where('CenterId','=',$CenterID)->update(array("Deleted" => 1));
           $deleteMonitoringResultTable = HOCentreMonitoringResult::where('Year','=',$Year)->where('CenterId','=',$CenterID)->update(array("Deleted" => 1));
          
           $k = 0;
        
           $CountQuestionsID = count($QuestionsID);
           $i = 0;
           $FinalMark = 0;
		   $CenterGrade = '';
           for($i=0;$i<$CountQuestionsID;$i++)
           {
              $IndividualQuestionsID = $QuestionsID[$i];
              $getCalTypeId = HOCentreMonitoringQuestion::where('id','=',$IndividualQuestionsID)->pluck('AnswerTypeId');
			  $getCalType = HOCentreMonitoringQuestionAnswerType::where('id','=',$getCalTypeId)->pluck('TypeCode'); 
              if($getCalType == 'SE')
              {
                $AnswerWeghtID = $AnswerID[$i];
                $mark = HOCentreMonitoringQuestionAnswer::where('id','=',$AnswerWeghtID)->pluck('AnswerWeight');
				
                $c = new HOCentreMonitoringResultTrans();
                $c->QuestionId = $IndividualQuestionsID;
                $c->AnswerID = $AnswerWeghtID;
                $c->AnswerType = $getCalType;
                $c->AchievedMark = $mark;
                $c->CenterId = $CenterID;
                $c->Year = $Year;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              
              else
              {
				  
				$c = new HOCentreMonitoringResultTrans();
                $c->QuestionId = $IndividualQuestionsID;
                $c->AnswerID = 999999;
                $c->AnswerType = $getCalType;
                $c->AchievedMark = $AnswerWeghtID;
                $c->CenterId = $CenterID;
                $c->Year = $Year;
                $c->User = User::getSysUser()->userID;
                $c->save();

              
              }
           }
		   $CenterType = Organisation::where('id','=',$CenterID)->pluck('Type');
		   if($FinalMark>=75)
		   {
			   if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'A';  
				   }
				   else
				   {
					 $CenterGrade = 'A';
				   }
			   }
		   }
		   elseif($FinalMark>=55 && $FinalMark<=74)
		   {
			   if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'B';  
				   }
				   else
				   {
					 $CenterGrade = 'B';
				   }
			   }
		   }
		    elseif($FinalMark>=36 && $FinalMark<=54)
			{
				if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'C';  
				   }
				   else
				   {
					 $CenterGrade = 'C';
				   }
			   }
			}
			else
				{
				if($CenterType=='DVTC')
			   {
				   if($NoOfCourses>=10)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			   elseif($CenterType=='NVTI')
			   {
				   if($NoOfCourses>=15)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			   elseif($CenterType=='VTC')
			   {
				   if($NoOfCourses>=5)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			   else
			   {
				   if($NoOfCourses>=2)
				   {
					 $CenterGrade = 'D';  
				   }
				   else
				   {
					 $CenterGrade = 'D';
				   }
			   }
			}

			$totweight = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->sum('FullWeight');
            $d = new HOCentreMonitoringResult();
            $d->CenterId = $CenterID;
            $d->Year = $Year;
            $d->TotalWeight = $totweight;
			$d->AchivedMark = $FinalMark;
            $d->CenterGrade = $CenterGrade;
            $d->Comments = $Dreason;
			$d->NoOfCourses = $NoOfCourses;
			$d->Remarks = $Remarks;
			$d->User = User::getSysUser()->userID;
            $d->save();
			$HOCMRId = HOCentreMonitoringResult::where('Deleted','=',0)->where('Year','=',$Year)->where('CenterId','=',$CenterID)->pluck('id');
			
			$updateHOCentreMonitoringResultTrans = HOCentreMonitoringResultTrans::where('Year','=',$Year)->where('CenterId','=',$CenterID)->where('Deleted','=',0)
			->update(array('HCMRID' => $HOCMRId));


            
            return Redirect::to('CreateHOCenterMonitoringForms')->with("done", true);

        }
    

  }
	
   public function ViewHOCenterMonitoringForms()
  {
    $view = View::make('HOCenterMonitor.View');
   
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    else
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
	
    $userEMpid = User::getSysUser()->EmpId;
  

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Year = Input::get('Year');
            $userEMpid = User::getSysUser()->EmpId;

            $sql = "SELECT district.DistrictName,organisation.OrgaName,organisation.Type,organisation.RegistrationNo,organisation.Active,organisation.DateClosed,
				  hocentremonitoringresult.*
				  from hocentremonitoringresult
				  left JOIN organisation
				  on hocentremonitoringresult.CenterId=organisation.id
				  left join district
				  on organisation.DistrictCode=district.DistrictCode
				  where hocentremonitoringresult.Deleted=0
				  and hocentremonitoringresult.Year='".$Year."'
				  order by hocentremonitoringresult.Year,district.DistrictName,hocentremonitoringresult.CenterGrade";
          $courses = DB::select(DB::raw($sql));
		  $view->PYear = $Year;
          $view->courses = $courses;
          return $view;
        }

  }
	
  public function DeleteHOCenterMonitoringQuestionAnswers()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = HOCentreMonitoringQuestionAnswer::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
   
    return Redirect::to('ViewHOCenterMonitoringQuestionAnswers');
  }
	
		public function CreateHOCenterMonitoringQuestionAnswers()
  {
    $view = View::make('HOCenterMonitoringQuestionAnswers.Create');
    $view->Answertypes = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->orderBy('QOrder')->get();
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $QuestionId = Input::get('QuestionId');
			$Active = Input::get('Active');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
			
            $c = new HOCentreMonitoringQuestionAnswer();
			$c->QuestionId = $QuestionId;
            $c->AnswerInSinhala = $Csinhala;
            $c->AnswerInEnglish = $Ceng;
            $c->AnswerWeight = $FullWeightFoTheSection;
			$c->Active = $Active;
			$c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateHOCenterMonitoringQuestionAnswers')->with("done", true);
        }
  }
	
  public function ViewHOCenterMonitoringQuestionAnswers()
  {
    $view = View::make('HOCenterMonitoringQuestionAnswers.View');
    $courses = DB::select(DB::raw("select hocentremonitoringquestionanswer.*,hocentremonitoringquestion.QuestionInSinhala
                                   from hocentremonitoringquestionanswer
                                   left join hocentremonitoringquestion
                                   on hocentremonitoringquestionanswer.QuestionId=hocentremonitoringquestion.id
                                   where hocentremonitoringquestionanswer.Deleted=0
                                   order by hocentremonitoringquestionanswer.AnswerWeight"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	  public function DeleteHOCenterMonitoringQuestion()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = HOCentreMonitoringQuestion::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
    $cc = HOCentreMonitoringQuestionAnswer::where('QuestionId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewHOCenterMonitoringQuestion');
  }
	
	public function CreateHOCenterMonitoringQuestion()
  {
    $view = View::make('HOCenterMonitoringQuestion.Create');
    $view->Answertypes = HOCentreMonitoringQuestionAnswerType::where('Deleted','=',0)->get();
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $maxOrder = HOCentreMonitoringQuestion::where('Deleted','=',0)->where('Active','=',1)->max('QOrder');
            $max = $maxOrder+1;
			$AnswerTypeId = Input::get('AnswerTypeId');
			$Active = Input::get('Active');
			
            $c = new HOCentreMonitoringQuestion();
            $c->QuestionInSinhala = $Csinhala;
            $c->QuestionInEnglish = $Ceng;
            $c->QOrder = $max;
			$c->Active = $Active;
			$c->AnswerTypeId = $AnswerTypeId;
			$c->FullWeight  = $FullWeightFoTheSection;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateHOCenterMonitoringQuestion')->with("done", true);
        }
  }

	
	 public function ViewHOCenterMonitoringQuestion()
  {
    $view = View::make('HOCenterMonitoringQuestion.View');
    $courses = DB::select(DB::raw("select hocentremonitoringquestion.*,hocentremonitoringquestionanswertype.AnswerType
  from hocentremonitoringquestion
  left join hocentremonitoringquestionanswertype
  on hocentremonitoringquestion.AnswerTypeId=hocentremonitoringquestionanswertype.id
  where hocentremonitoringquestion.Deleted=0
  order by hocentremonitoringquestion.QOrder"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
  public function DeleteHOCenterMonitoringQuestionAnswerType()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = HOCentreMonitoringQuestionAnswerType::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    //delete criteria EMPtype Trans
    
    return Redirect::to('ViewHOCenterMonitoringQuestionAnswerType');
  }

  public function CreateHOCenterMonitoringQuestionAnswerType()
  {
    $view = View::make('HOCenterMonitoringQuestionAnswerType.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Type = Input::get('Type');
			$Code = Input::get('Code');
           
            $c = new HOCentreMonitoringQuestionAnswerType();
            $c->AnswerType = $Type;
			$c->TypeCode = $Code;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateHOCenterMonitoringQuestionAnswerType')->with("done", true);
        }
  }
	
	public function ViewHOCenterMonitoringQuestionAnswerType()
  {
    $view = View::make('HOCenterMonitoringQuestionAnswerType.View');
    $courses = HOCentreMonitoringQuestionAnswerType::where('Deleted','=',0)->orderBy('AnswerType')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
  public function DeleteHOCenterMonitoringGrade()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = HOCentreMonitoringGrade::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    //delete criteria EMPtype Trans
    
    return Redirect::to('ViewHOCenterMonitoringGrade');
  }

  public function CreateHOCenterMonitoringGrade()
  {
    $view = View::make('HOCentreMonitoringGrade.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Grade = Input::get('Type');
			$GOrder = Input::get('GOrder');
           
            $c = new HOCentreMonitoringGrade();
            $c->Grade = $Grade;
			$c->GOrder = $GOrder;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateHOCenterMonitoringGrade')->with("done", true);
        }
  }
	
	public function ViewHOCenterMonitoringGrade()
  {
    $view = View::make('HOCentreMonitoringGrade.View');
    $courses = HOCentreMonitoringGrade::where('Deleted','=',0)->orderBy('GOrder')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }
	
	public function DialyTaskTimeTableTaskList()
	{
		$DatePlanned = Input::get('DatePlanned');
		 $CourseYearPlanID = Input::get('YearPlanId');
		//$CourseYearPlanID = MOCenterMonitoringPlan::where('id','=',$CMPlanid)->pluck('CourseYearPlanID');
		$year = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('Year');
		$batch = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('batch');
		$CD_ID = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('CD_ID');
		$html = '';
		
		//load all task list untill Real date monitored.
	  $sql = "select modatetask.id,
    modatetask.TaskSeqID,
    modatecalender.Date,
    modatecalender.Session,
    motask.TaskName,
    motask.TaskCode,
    module.ModuleName,
    module.ModuleCode
    from modatetask
    left join modatecalender
    on modatetask.MODateCalenderID=modatecalender.id
    left join motaskseq
    on modatetask.TaskSeqID=motaskseq.id
    left join motask
    on motaskseq.taskid=motask.id
    left join module
    on motaskseq.moduleid=module.ModuleId
    where modatetask.Deleted=0
    and modatetask.Year='".$year."'
    and modatetask.Batch = '".$batch."'
    and modatetask.CD_ID='".$CD_ID."'
	order by modatetask.id";

	$timeTableList = DB::select(DB::raw($sql));
	$count = count($timeTableList);
	if($count != 0)
	{
		$html='<table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class="center">No</th>
                        <th class="center">Date</th>
                        <th class="center">Session</th>
                        <th class="center">Module Name</th>
                        <th class="center">Task Name</th>
                         
                         <th class="center">
                                
                        </th>
                        
                        
                </tr>
                </thead>
                    <tbody>';
		$SerialNo=1;
		foreach($timeTableList as $t)
		{
			if($t->Date == $DatePlanned)
			{
				$html .='<tr>

                     <td class="center"><font color="red">'.$SerialNo++.'</font></td>
                     <td class="center"><font color="red">'.$t->Date.'</font></td>
                     <td class="center"><font color="red">'.$t->Session.'</font></td>';
                    if($t->TaskSeqID == '999997')
					{
                     $html.='<td class="center"><font color="red">Orientation Program</font></td>
                     <td class="center"><font color="red">Orientation Program</font></td>';
					}
                    elseif($t->TaskSeqID == '999998')
					{
                     $html.='<td class="center"><font color="red">English/Career Skills</font></td>
                     <td class="center"><font color="red">English/Career Skills</font></td>';
					}
                     elseif($t->TaskSeqID == '999999')
					 {
                     $html.='<td class="center"><font color="red">Continuous Assessment</font></td>
                     <td class="center"><font color="red">Continuous Assessment</font></td>';
					 }
                     else
					 {
                     $html.='<td class="center"><font color="red">'.$t->ModuleName.'('.$t->ModuleCode.')</font></td>
                     <td class="center"><font color="red">'.$t->TaskName.'('.$t->TaskCode.')</font></td>';
					 }
                    $Available = MODailyTimeTbaleAchivementTrans::where('YearPlanId','=',$CourseYearPlanID)->where('Deleted','=',0)->where('MoDateTaskId','=',$t->id)->where('Completed','=',1)->get();
                    if(Count($Available) == 0)
					{
						$html.= '<td class="center"><label>
                        <input type="hidden" name="ModateTaskIDs[]" id="ModateTaskIDs[]" value="'.$t->id.'">
                        <input name="trainee_ids[]" class="abc" value="'.$t->id.'" type="checkbox" />
                        <span class="lbl"> &nbsp;</span>
                        </label>
                        </td>';
					}
					else
					{
						$html.= '<td class="center"><label>
                        <input type="hidden" name="ModateTaskIDs[]" id="ModateTaskIDs[]" value="'.$t->id.'">
                        <input name="trainee_ids[]"  class="abc" value="'.$t->id.'" type="checkbox" checked/>
						<span class="lbl"> &nbsp;</span>
                        </label>
                        </td>';
					}
                   
                  $html.= '</tr>';
			}
			else
			{
				$html .='<tr>

                     <td class="center">'.$SerialNo++.'</td>
                     <td class="center">'.$t->Date.'</td>
                     <td class="center">'.$t->Session.'</td>';
                    if($t->TaskSeqID == '999997')
					{
                     $html.='<td class="center">Orientation Program</td>
                     <td class="center">Orientation Program</td>';
					}
                    elseif($t->TaskSeqID == '999998')
					{
                     $html.='<td class="center">English/Career Skills</td>
                     <td class="center">English/Career Skills</td>';
					}
                     elseif($t->TaskSeqID == '999999')
					 {
                     $html.='<td class="center">Continuous Assessment</td>
                     <td class="center">Continuous Assessment</td>';
					 }
                     else
					 {
                     $html.='<td class="center">'.$t->ModuleName.'('.$t->ModuleCode.')</td>
                     <td class="center">'.$t->TaskName.'('.$t->TaskCode.')</td>';
					 }
                    
                    
                  $Available = MODailyTimeTbaleAchivementTrans::where('YearPlanId','=',$CourseYearPlanID)->where('Deleted','=',0)->where('MoDateTaskId','=',$t->id)->where('Completed','=',1)->get();
                    if(Count($Available) == 0)
					{
						$html.= '<td class="center"><label>
                        <input type="hidden" name="ModateTaskIDs[]" id="ModateTaskIDs[]" value="'.$t->id.'">
                        <input name="trainee_ids[]" class="abc" value="'.$t->id.'" type="checkbox" />
                        <span class="lbl"> &nbsp;</span>
                        </label>
                        </td>';
					}
					else
					{
						$html.= '<td class="center"><label>
                        <input type="hidden" name="ModateTaskIDs[]" id="ModateTaskIDs[]" value="'.$t->id.'">
                        <input name="trainee_ids[]"  class="abc" value="'.$t->id.'" type="checkbox" checked/>
						
                        <span class="lbl"> &nbsp;</span>
                        </label>
                        </td>';
					}
                   
                  $html.= '</tr>';
			}
			
				  
		}
		$html.=' </tbody>
            </table>';
	}
	else
	{
		$html .='<span><font color="red"><H4><i><b>Time Table Not Issued !!!!</b></i><H4></font></span>';
	}
	
			
			return json_encode($html);
	}
	
	public function FilterCourseYearPlansDailyTimeTable()
  {
    $CenterID = Input::get('CourseListCode');
	$Batch = Input::get('Batch');
	$Year = Input::get('Year');
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
	
	 public function CreateVTCDailyTask()
  {
    $view = View::make('VTCDailyTask.Create');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	   ->where('Deleted','=','0')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
	  ->where('Deleted','=','0')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
	    ->where('Deleted','=','0')
      ->orderBy('OrgaName')
      ->get();
    }
	elseif($OegaType == 'PO')
	{
		
		$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$provinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
	  $view->Districts = District::where('ProvinceCode','=',$provinceCode)->orderBy('DistrictName')->get();
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
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
	   ->where('Deleted','=','0')
      ->orderBy('OrgaName')
      ->get();
    }

    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {

            $CenterID = Input::get('CenterID');
            $YearPlanID = Input::get('CourseYearPlanID');
			$CD_ID = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CD_ID');
            $DatePlanned = Input::get('DatePlanned');
			$InsAttend = Input::get('InsAttend');
			$ReasonToNot = Input::get('ReasonToNot');
			$ModateTaskIDs = Input::get('ModateTaskIDs');
			$trainee_ids = Input::get('trainee_ids');
            $UserOrgID = User::getSysUser()->organisationId; 
            $User = User::getSysUser()->userID;
			$NoOfStudent = Input::get('NoOfStudent');
			$countTraineeid = count($trainee_ids);
			$Availability = MODailyTimeTbaleAchivement::where('Deleted','=',0)->where('YearPlanId','=',$YearPlanID)->where('TimeTbaleDate','=',$DatePlanned)->count();
			if($Availability == 0)
			{
				$c = new MODailyTimeTbaleAchivement();
				$c->YearPlanId = $YearPlanID;
				$c->CD_ID = $CD_ID;
				$c->TimeTbaleDate = $DatePlanned;
				$c->InstrutorAttendence = $InsAttend;
				$c->ReasonForNot = $ReasonToNot;
				$c->NoofStudentAttend = $NoOfStudent;
				$c->User = $User;
				$c->save();
				
				$GetMDTAId = MODailyTimeTbaleAchivement::where('Deleted','=',0)
				->where('YearPlanId','=',$YearPlanID)
				->where('CD_ID','=',$CD_ID)
				->where('TimeTbaleDate','=',$DatePlanned)
				->where('InstrutorAttendence','=',$InsAttend)->pluck('id');
				
				
				for($i=0;$i<$countTraineeid;$i++)
				{
					$checktRANS = MODailyTimeTbaleAchivementTrans::where('YearPlanId','=',$YearPlanID)->where('MoDateTaskId','=',$trainee_ids[$i])->where('Deleted','=',0)->where('Completed','=',1)->count();
					if($checktRANS == 0)
					{
						$d = new MODailyTimeTbaleAchivementTrans();
						$d->MDTAId = $GetMDTAId;
						$d->YearPlanId = $YearPlanID;
						$d->CD_ID = $CD_ID;
						$d->MoDateTaskId = $trainee_ids[$i];
						$d->Completed = 1;
						$d->User = $User;
						$d->save();
					}
					
				}
				
			}
            
            return Redirect::to('CreateVTCDailyTask')->with("done", true);
        }

  }
	
	  public function ViewWeekTimeTableLoadCalenderYear()
  {
    $CD_ID = Input::get('CDID'); //Course Detail tale id
    $Year = Input::get('Year');
    $Batch = Input::get('Batch');
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
    $sql = "select DISTINCT modatecalender.Year
            from modatetask
            left join modatecalender
            on modatetask.MODateCalenderID=modatecalender.id
            where modatetask.Deleted=0
            and modatetask.Year like '".$Year."'
            and modatetask.Batch like '".$Batch."'
			and modatecalender.Year is not null
            and modatetask.CD_ID like '".$CD_ID."'";
			
            $dd = DB::select(DB::raw($sql));

  return json_encode($dd);
  }
	
	public function DownloadAccreditationInstaPayment()
	{
		 $Count = 1;

         $tablePrintHeader = array('#', 'District','Center','Type','Registration No','Course','CourseListCode','Duration','NVQ Level','Accredit Status','Accreditation Application Status','Accredit Application Payment Status');

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
				$CountCMP=0;
		                                  $sqlaccrediationPay ="select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus,accreditationapplication.PaymentSubmitStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and accreditationdetails.Accredit in('No','Expired','ToBeUpgrade','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('Yes')
                                          and accreditationapplication.PaymentSubmitStatus in('No')
                                          order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					                      $sqlaccrediationPayList = DB::select(DB::raw($sqlaccrediationPay));
					
	foreach($sqlaccrediationPayList as $cs) 
	{
		
			
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $cs->DistrictName);
				array_push($data_row, $cs->OrgaName);
			    array_push($data_row, $cs->Type);
				array_push($data_row, $cs->RegistrationNo);
				array_push($data_row, $cs->CourseName);
				array_push($data_row, $cs->CourseListCode);
				array_push($data_row, $cs->Duration);
				array_push($data_row, $cs->CourseLevel);
			    array_push($data_row, $cs->Accredit);
				array_push($data_row, $cs->ApplicationReciievedStatus);
				array_push($data_row, $cs->PaymentSubmitStatus);
				array_push($printablearray, $data_row);
				    
    }
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('AccreditationPendingPaymentList' . date('Y-m-d'));
	}
	
	public function DownloadAccreditationInstaApplication()
	{
		
		 $Count = 1;

         $tablePrintHeader = array('#', 'District','Center','Type','Course','CourseListCode','Duration','NVQ Level','Accredit Status','Accreditation Application Status');

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
				$CountCMP=0;
				
				if($userOrgType =='HO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
				}
				elseif($userOrgType =='PO')
				{
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and province.ProvinceCode='$UserProvinceCode'
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				elseif($userOrgType =='DO')
				{
					
					$sqlaccrediationApp ="select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and district.DistrictCode=$UserDistrictCode
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				else{
					
					$sqlaccrediationApp =     "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and organisation.id='$userOrgId'
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				
				 foreach($sqlaccrediationAppList as $cs) 
	{
		
			
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $cs->DistrictName);
				array_push($data_row, $cs->OrgaName);
			    array_push($data_row, $cs->Type);
				array_push($data_row, $cs->CourseName);
				array_push($data_row, $cs->CourseListCode);
				array_push($data_row, $cs->Duration);
				array_push($data_row, $cs->CourseLevel);
			    array_push($data_row, $cs->Accredit);
				array_push($data_row, $cs->ApplicationReciievedStatus);
				 array_push($printablearray, $data_row);
				    
    }
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('AccreditationApplication' . date('Y-m-d'));
	}
	
     public function DownloadAccreditationWillExpire()
	{

    $Count = 1;

    $tablePrintHeader = array('#', 'District','Center','Type','Course','CourseListCode','Duration','NVQ Level','Accredit Status','Accreditation Valid From','Accreditation Valid To');

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
				$CountCMP=0;
				
				if($userOrgType =='HO')
				{
					
					
					// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
					
				}
				elseif($userOrgType =='PO')
				{
						// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								  and province.ProvinceCode=$UserProvinceCode
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
				}
				elseif($userOrgType =='DO')
				{
					
					// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								   and district.DistrictCode=$UserDistrictCode
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
				}
				else{
					
							// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								  and organisation.id='$userOrgId'
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
				}

   	

  foreach($sqlwillexpire as $cs) 
	{
		
			
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $cs->DistrictName);
				array_push($data_row, $cs->OrgaName);
			    array_push($data_row, $cs->Type);
				array_push($data_row, $cs->CourseName);
				array_push($data_row, $cs->CourseListCode);
				array_push($data_row, $cs->Duration);
				array_push($data_row, $cs->CourseLevel);
			    array_push($data_row, $cs->Accredit);
				array_push($data_row, $cs->AccreditDate);
				array_push($data_row, $cs->AccreditationValidDate);
				array_push($printablearray, $data_row);	 
				
				
									
				    
    }
				
				
				
			    $excel->writer->setData($printablearray);
                $excel->writer->saveFile('AccreditationWillExpire' . date('Y-m-d'));
	}
	
	public function InstantAccreditationWillExpire()
	{
		
		    $view = View::make("Home.AccreditationWillExpire");
				$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
				
				if($userOrgType =='HO')
				{
					
					
					// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
					
				}
				elseif($userOrgType =='PO')
				{
						// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								  and province.ProvinceCode=$UserProvinceCode
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
				}
				elseif($userOrgType =='DO')
				{
					
					// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								   and district.DistrictCode=$UserDistrictCode
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
				}
				else{
					
							// will expire
					
					$sqlwillexpire = DB::select(DB::raw("select accreditationdetails.*,
								  organisation.OrgaName,Type,coursedetails.CourseName,
								  CourseListCode,CourseLevel,Nvq,Duration,district.DistrictName
								  from accreditationdetails
								  left join coursedetails
								  on accreditationdetails.CD_ID=coursedetails.CD_ID
								  left join organisation
								  on accreditationdetails.CenterId=organisation.id
								  left join district
								  on organisation.DistrictCode=district.DistrictCode
								  left join province
								  on district.ProvinceCode=province.ProvinceCode
								  where accreditationdetails.Deleted=0
								  and accreditationdetails.Active=1
								  and accreditationdetails.AccreditationValidDate>= CURDATE() and accreditationdetails.AccreditationValidDate<= DATE_ADD(CURDATE(),INTERVAL 1 MONTH)
								  and Accredit IN('Yes')
								  and organisation.id='$userOrgId'
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
				}
				
				$view->CountWillExpire = $CountWillExpire;
				 $view->ApproveACAppList = $sqlwillexpire;
				 return $view;
	}
	
	public function getinstructorsMoCmPlan()
	
	{
		$id = Input::get('CourseListCode');
			 $ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$id."'
						  and moinstructorcourse.Active='Yes'";
                          $Ins=DB::select(DB::raw($ppp));
			$html='';
			
foreach($Ins as $i)		
{
	$html='<span>'.$i->Name.'-'.$i->EPFNo.'</span><br/>';	
}	
						  return json_encode($html);
	}
	
	public function InstantAccreditationPaymentPending()
	{
		
			$view = View::make("Home.AccreditationPaymentPending");
		$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
		$sqlaccrediationPay = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus,accreditationapplication.PaymentSubmitStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and accreditationdetails.Accredit in('No','Expired','ToBeUpgrade','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('Yes')
                      and accreditationapplication.PaymentSubmitStatus in('No')
                    order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationPayList = DB::select(DB::raw($sqlaccrediationPay));
					$view->sqlaccrediationPayListCount = $sqlaccrediationPayList;
					 
					 return $view;
	}
	
	public function InstantAccreditationAppliRecordPending()
	{
		$view = View::make("Home.AccreditAppliPending");
		$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
		$sqlAccreditationAppliTable = "select  district.DistrictName,organisation.OrgaName,organisation.Type,
													  coursedetails.CourseName,
													  coursedetails.CourseListCode,
													  coursedetails.Duration,
													  coursedetails.CourseLevel,
													  accreditationapplication.ApplicationReciievedStatus,
													  organisation.RegistrationNo
                                                      from courseyearplan
													  left join coursedetails
													  on courseyearplan.CD_ID=coursedetails.CD_ID
													  left join organisation
													  on courseyearplan.OrgId=organisation.id
													  left join district
													  on organisation.DistrictCode=district.DistrictCode
													  left join accreditationapplication
													  on courseyearplan.OrgId=accreditationapplication.CenterId
													  and courseyearplan.CD_ID=accreditationapplication.CD_ID
													  and accreditationapplication.Deleted=0
													  where courseyearplan.Deleted=0
													  and accreditationapplication.ApplicationReciievedStatus is null
													  group by courseyearplan.OrgId,courseyearplan.CD_ID
													  order by district.DistrictName,organisation.OrgaName";
					 $sqlAccreditationAppliTableList = DB::select(DB::raw($sqlAccreditationAppliTable));
					 $view->sqlAccreditationAppliTableListCount = $sqlAccreditationAppliTableList;
					 
					 return $view;
	}
	
	public function InstantAccreditationRecordPending()
	{
		$view = View::make("Home.AccreditPending");
		$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
		$sqlAccreditationTable = "select  district.DistrictName,organisation.OrgaName,organisation.Type,
											  coursedetails.CourseName,
											  coursedetails.CourseListCode,
											  coursedetails.Duration,
											  coursedetails.CourseLevel,
											  accreditationdetails.Accredit,
											  organisation.RegistrationNo
											  from courseyearplan
											  left join coursedetails
											  on courseyearplan.CD_ID=coursedetails.CD_ID
											  left join organisation
											  on courseyearplan.OrgId=organisation.id
											  left join district
											  on organisation.DistrictCode=district.DistrictCode
											  left join accreditationdetails
											  on courseyearplan.OrgId=accreditationdetails.CenterId
											  and courseyearplan.CD_ID=accreditationdetails.CD_ID
											  and accreditationdetails.Deleted=0
											  and accreditationdetails.Active=1
											  where courseyearplan.Deleted=0
											  and accreditationdetails.Accredit is null
											  order by district.DistrictName,organisation.OrgaName";
					 $sqlAccreditationTableList = DB::select(DB::raw($sqlAccreditationTable));
					 $view->sqlAccreditationTableListCount = $sqlAccreditationTableList;
					 
					 return $view;
	}
	
	public function InstantAccreditationApplication()
	{
		
		        $view = View::make("Home.AccreditationApplication");
				$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
				
				if($userOrgType =='HO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
				}
				elseif($userOrgType =='PO')
				{
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and province.ProvinceCode='$UserProvinceCode'
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				elseif($userOrgType =='DO')
				{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and district.DistrictCode=$UserDistrictCode
										  and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				else{
					
					$sqlaccrediationApp = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
										  organisation.OrgaName,organisation.Type,organisation.RegistrationNo,
										  coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.Duration,coursedetails.CourseLevel,
										  accreditationdetails.Accredit,accreditationapplication.ApplicationReciievedStatus
										  from accreditationapplication
										  left join accreditationdetails
										  on accreditationapplication.CenterID=accreditationdetails.CenterId
										  and accreditationapplication.CD_ID=accreditationdetails.CD_ID
										  and accreditationdetails.Deleted=0
										  and accreditationdetails.Active=1
										  left join coursedetails
										  on accreditationapplication.CD_ID=coursedetails.CD_ID
										  left join organisation
										  on accreditationapplication.CenterID=organisation.id
										  left join district
										  on organisation.DistrictCode=district.DistrictCode
										  left join province
										  on district.ProvinceCode=province.ProvinceCode
										  where accreditationapplication.Deleted=0
										  and organisation.id='$userOrgId'
										   and accreditationdetails.Accredit in('No','Expired','Recommended')
										  and accreditationapplication.ApplicationReciievedStatus in('No')
										  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
				}
				
				$view->ApproveACApp = $CountACApp;
				 $view->ApproveACAppList = $sqlaccrediationAppList;
				 return $view;
	}
	
	public function printRandomGeneratedMCQPaper()
	{
	  $CD_ID = Input::get('CD_ID'); //Course Detail tale id
      $ModuleID = Input::get('ModuleId');
      $TaskID = Input::get('TaksId');
	   $Medium = Input::get('Medium');
	
		$getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
		$getCourseName = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseName');
    $html = '';

   $i=1;
	if($ModuleID !='All' && $TaskID =='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.ModuleId = '".$ModuleID."'
		  and moquestions.Deleted=0
		  and moquestions.Medium='".$Medium."'
		  ORDER BY RAND()
		  limit 20")); 
	}
	elseif($ModuleID !='All' && $TaskID !='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.ModuleId = '".$ModuleID."'
		   and moquestions.TaskId='".$TaskID."'
		  and moquestions.Deleted=0
		  and moquestions.Medium='".$Medium."'
		  ORDER BY RAND()
		  limit 20")); 
	}
	else{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.Deleted=0
		   and moquestions.Medium='".$Medium."'
		   ORDER BY RAND()
		   limit 20")); 
	}
   
if($Medium == 'S')
{
	 $html='<html>
    <head>
    <meta charset="UTF-8">
	<title>පුහුණු අධීක්ෂණ ප්‍රශ්න පත්‍රය</title>
    </head>
    
    <h4><center><b>ශ්‍රී ලංකා වෘත්තීය පුහුණු අධිකාරිය</b></center></h4>
    <h5><center><b>කෙටි ප්‍රශ්න පත්‍රය</b><br/><font size="1">(කාලය  පැය එකයි)</font></b></center></h5>
    
   <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
   <tr>
	<td style="width:25%">දිනය:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>මධ්‍යස්ථානය:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>පාඨමාලාව:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$getCourseName.'</td>
	</tr>
    <tr>
	<td style="width:25%">වර්ෂය:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>කණ්ඩායම:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td></td>
	</tr>
	
    <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr><td style="width:25%">අභ්‍යාසලාභියාගේ නම:</td>
    <td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
    <td style="width:25%">ජා.හැ.අංකය:</td><td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
	<td style="width:25%">MIS අංකය:</td>
	<td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	</tr>
	</table>
	<hr/>
    
    <font size="1"><left><i>* <b>සියළුම</b> ප්‍රශ්න වලට පිළිතුරු සපයන්න.<br/>* නිවැරදි පිළිතුර <b>යටින් ඉරක් අඳින්න</b></i></left></font><br/><br/>
    
    <tbody>
    ';
}
elseif($Medium == 'E')
{
	 $html='<html>
    <head>
    <meta charset="UTF-8">
	<title>MCQ Question Paper</title>
    </head>
    
    <h4><center><b>Vocational Training Authority of Sri Lanka</b></center></h4>
    <h5><center><b>MCQ Paper</b><br/><font size="1">(Duration: One hour)</font></b></center></h5>
    <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr>
	<td style="width:25%">Date:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>Centre:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>Course:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$getCourseName.'</td>
	</tr>
    <tr>
	<td style="width:25%">Year:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>Batch:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td></td>
	</tr>
	<table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr><td style="width:25%">Name of the Trainee:</td>
    <td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
    <td style="width:25%">NIC Number:</td><td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
	<td style="width:25%">MIS Number:</td>
	<td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	</tr>
	</table>
    <hr/>
    <font size="1"><left><i>* Answer <b>All</b> Questions<br/>* <b>Underline</b> the Correct Answer</i></left></font>
    <tbody>
    ';
}
else{
	 $html='<html>
    <head>
    <meta charset="UTF-8">
	<title>பல் தேர்வு வினாப்பத்திரம்</title>
    </head>
    
    <h4><center><b>இலங்கை தொழிற் பயிற்சி அதிகாரசபை</b></center></h4>
    <h5><center><b>பல் தேர்வு வினாப்பத்திரம்</b><br/><font size="1">(நேரம் : 01 மணித்தியாலம்)</font></b></center></h5>
    
   <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
   <tr>
	<td style="width:25%">திகதி:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>பயிற்சி நிலையம்:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>பயிற்சிநெறி:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$getCourseName.'</td>
	</tr>
    <tr>
	<td style="width:25%">வருடம்:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td>பிரிவு:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	<td></td>
	</tr>
	
    <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr><td style="width:25%">பயிலுனரின் பெயர்:</td>
    <td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
    <td style="width:25%">தே.அ.அ. இல.:</td><td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
	<td style="width:25%">பதிவு இல.:</td>
	<td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	</tr>
	</table>
    <hr/>
    <font size="1"><left><i>* எல்லா வினாக்களுக்கும் விடை தருக<br/>* சரியான விடையின் கீழ் கோடிடுக</i></left></font>
    
    <tbody>
    ';
}
	
   
 foreach ($cc as $aa) {

    $html.='<table style="width:100%;border-collapse:collapse;font-size:12px;" border="0" style="">
	<tr>
	<td style="width:100%">'.$i++.') '.$aa->Question.'</td>
	</tr>
	</table>';
	
          
          //$WAnswer1 = MOQuestion::getWAnswer1($aa->id);
          //$WAnswer2 = MOQuestion::getWAnswer2($aa->id);
          //$WAnswer3 = MOQuestion::getWAnswer3($aa->id);
		  $GetAllAnswers = MOQuestion::getAllanswers($aa->id);
		  $myar = [];
		  foreach($GetAllAnswers as $g)
		  {
			  $myar[] = $g->Answer;
		  }
		  
    $html.='<table style="width:100%;border-collapse:collapse;font-size:12px;" border="0" style="">
				<tr><td style="width:25%">&nbsp&nbsp&nbsp&nbspa. '.$myar[0].'</td>
				<td style="width:25%">&nbsp&nbsp&nbsp&nbspb. '.$myar[1].'</td></tr>
				<tr><td style="width:25%">&nbsp&nbsp&nbsp&nbspc. '.$myar[2].'</td>
				<td style="width:25%">&nbsp&nbsp&nbsp&nbspd. '.$myar[3].'</td></tr>
		    
			</table><br/>'; 
          

          
  }
  
  if($Medium == 'S')
{
	$html.='<p style="page-break-before: always"></p>
	<br/>
	<h4><center><u>නිවැරදි පිළිතුරු පත්‍රය </u></center></h4>
	<table style="width:100%;border-collapse:collapse;font-size:13px;" border="0" style="">';
}
elseif($Medium == 'E')
{
	$html.='<p style="page-break-before: always"></p>
	<br/>
	<h4><center><u>Answer Sheet </u></center></h4>
	<table style="width:100%;border-collapse:collapse;font-size:13px;" border="0" style="">';
}
else
{
	$html.='<p style="page-break-before: always"></p>
	<br/>
	<h4><center><u>சரியான விடைப் பத்திரம் </u></center></h4>
	<table style="width:100%;border-collapse:collapse;font-size:13px;" border="0" style="">';
}
  
	
	
	$i=1;
	foreach ($cc as $aa) {
		$CAnswer = MOQuestion::getCorrectAnswer($aa->id);
	$html.='<tr><td>'.$i++.') '.$CAnswer.'<br/><br/></td></tr>';
	}
	$html.='</table>';

$html.='</tbody></html>';

    return $html;
	}
	
	public function DownloadRandomQuestionPaper()
	{
		$view = View::make('MOQuestion.ViewRandomPaper');
       
     
        $method=Request::getMethod();
   
		$view->modules = Module::where('Deleted', '!=', 1)->orderBy('ModuleCode')->get();
		$view->tasks = Task::where('Deleted', '!=', 1)->orderBy('TaskCode')->get();
		$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
		$view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
    
		$view->CLCS = '';
		$view->MIDS = '';
		$view->TIDS = '';
		if($method == 'GET')
		{
		  return $view;
		}
	}
	
	  public function printQuestionList()
  {
    $CD_ID = Input::get('CD_ID'); //Course Detail tale id
    $ModuleID = Input::get('ModuleId');
    $TaskID = Input::get('TaksId');
	
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
    $getCourseName = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseName');
    $html = '';

   $i=1;
	if($ModuleID !='All' && $TaskID =='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.ModuleId = '".$ModuleID."'
		  and moquestions.Deleted=0")); 
	}
	elseif($ModuleID !='All' && $TaskID !='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.ModuleId = '".$ModuleID."'
		   and moquestions.TaskId='".$TaskID."'
		  and moquestions.Deleted=0")); 
	}
	else{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.Deleted=0")); 
	}
   

    $html='<html><head>
   
    </head>
    <body>
   
    <center><h3><b>MCQ Questions For '.$getCourseName.'-'.$getCourseListCode.'</center></h3></b>
	<font size="5px" face="Times New Roman" >
	<table style = "font-size:14px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<th align="center">No</th>
<th align="center">Course Name</th>
<th align="center">Module Name</th>
<th align="center">Module Code</th>
<th align="center">Task Name</th>
<th align="center">Task Code</th>
<th align="center">Question</th>
<th align="center">Correct Answer</th>
<th align="center">Wrong Answer1</th>
<th align="center">Wrong Answer2</th>
<th align="center">Wrong Answer3</th>
</thead><tbody>';
 foreach ($cc as $aa) {

    $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$aa->CourseName.'</td>
          <td>'.$aa->ModuleName.'</td>
          <td>'.$aa->ModuleCode.'</td>
          <td>'.$aa->TaskName.'</td>
          <td>'.$aa->TaskCode.'</td>
          <td>'.$aa->Question.'</td>';
          $CAnswer = MOQuestion::getCorrectAnswer($aa->id);
          $WAnswer1 = MOQuestion::getWAnswer1($aa->id);
          $WAnswer2 = MOQuestion::getWAnswer2($aa->id);
          $WAnswer3 = MOQuestion::getWAnswer3($aa->id);
    $html.='<td>'.$CAnswer.'</td>
            <td>'.$WAnswer1.'</td>
		    <td>'.$WAnswer2.'</td>
		    <td>'.$WAnswer3.'</td></tr>'; 
          

          
  }
   
$html.='</tbody></table></font></body></html>';

    return $html;


  }
	
	public function DownloadCOurseModuletaskQAll()
	{ 
	  $CD_ID = Input::get('CD_IDP');
      $ModuleID = Input::get('ModuleIDP');
      $TaskID = Input::get('TaskIdP');
	  
	 $tablePrintHeader = array('#', 'Course Name','CourseListCode','Module Name','Module Code','Task Name','Task Code','Question','Correct Answer','Wrong Answer1','Wrong Answer2','Wrong Answer3');
     $excel = new SimpleExcel('csv');
     $printablearray = array();
     array_push($printablearray, $tablePrintHeader);  
	$i=1;
	if($ModuleID !='All' && $TaskID =='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.ModuleId = '".$ModuleID."'
		  and moquestions.Deleted=0")); 
	}
	elseif($ModuleID !='All' && $TaskID !='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.ModuleId = '".$ModuleID."'
		   and moquestions.TaskId='".$TaskID."'
		  and moquestions.Deleted=0")); 
	}
	else{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
		  coursedetails.CourseName,
		  coursedetails.CourseListCode,
		  module.ModuleName,module.ModuleCode,
		  motask.TaskName,motask.TaskCode,
		  moquestions.Question
		  from moquestions
		  left join coursedetails
		  on moquestions.CourseListCode=coursedetails.CD_ID
		  left join module
		  on moquestions.ModuleId=module.ModuleId
		  left join motask
		  on moquestions.TaskId=motask.id
		   where moquestions.Active=1
		   and moquestions.CourseListCode='".$CD_ID."'
		   and moquestions.Deleted=0")); 
	}
	      foreach($cc as $Data) {
			  
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->CourseName);
				array_push($data_row, $Data->CourseListCode);
                array_push($data_row, $Data->ModuleName);
                array_push($data_row, $Data->ModuleCode);
                array_push($data_row, $Data->TaskName);
                array_push($data_row, $Data->TaskCode);
                array_push($data_row, $Data->Question);
                $CAnswer = MOQuestion::getCorrectAnswer($Data->id);
                $WAnswer1 = MOQuestion::getWAnswer1($Data->id);
                $WAnswer2 = MOQuestion::getWAnswer2($Data->id);
                $WAnswer3 = MOQuestion::getWAnswer3($Data->id);
				array_push($data_row, $CAnswer);
				array_push($data_row, $WAnswer1);
				array_push($data_row, $WAnswer2);
				array_push($data_row, $WAnswer3);
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('QuestionListForCourses' . date('Y-m-d'));
	
	}
	
	public function DownloadLoadViewDistrictWiseCenterMonitoringProgress()
  {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Monitoring Officer"s Center Name','Name','Designation','Center planned to monitor','Date Planned','Approved','Visited');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
      if ($District == 'All') {


          $sql = "select 
  distinct monewcentermonitoringplan.id,
	district.DistrictName,
  O2.OrgaName as MOrgaName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  monewcentermonitoringplan.DatePlanned,
  monewcentermonitoringplan.Approved,
  monewcentermonitoringplan.Visited
  from monewcentermonitoringplan
 left join organisation
  on monewcentermonitoringplan.CenterID=organisation.id
  left join organisation as O2
  on monewcentermonitoringplan.OrgaIDUser=O2.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on monewcentermonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where monewcentermonitoringplan.Deleted=0
  and organisation.Deleted=0
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,monewcentermonitoringplan.DatePlanned";

}
else
{
   $sql = "select 
  distinct monewcentermonitoringplan.id,
	district.DistrictName,
  O2.OrgaName as MOrgaName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  monewcentermonitoringplan.DatePlanned,
  monewcentermonitoringplan.Approved,
  monewcentermonitoringplan.Visited
  from monewcentermonitoringplan
 left join organisation
  on monewcentermonitoringplan.CenterID=organisation.id
  left join organisation as O2
  on monewcentermonitoringplan.OrgaIDUser=O2.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on monewcentermonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where monewcentermonitoringplan.Deleted=0
  and organisation.Deleted=0
  and organisation.DistrictCode='".$District."'
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,monewcentermonitoringplan.DatePlanned";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


                foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->DistrictName);
				array_push($data_row, $Data->MOrgaName);
                $EmployeeName = $Data->Initials.' '.$Data->LastName;
                array_push($data_row, $EmployeeName);
                array_push($data_row, $Data->Designation);
                $Orga = $Data->OrgaName.'-'.$Data->Type;
                array_push($data_row, $Orga);
               
                array_push($data_row, $Data->DatePlanned);
				if($Data->Approved == 1)
                {
                   array_push($data_row, 'Yes');
                }
				elseif($Data->Approved == 2)
				{
					array_push($data_row, 'Rejected');
				}
                else
                {
                  array_push($data_row, 'Pending');
                }
               
                if($Data->Visited == 0)
                {
                   array_push($data_row, 'No');
                }
                else
                {
                  array_push($data_row, 'Yes');
                }
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseCenterMonitoringProgressReportI' . date('Y-m-d'));
            
  }
	
	  public function LoadViewDistrictWiseCenterMonitoringProgress()
  {
    $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 0;
    $html='';

            $html = '
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Monitoring Progress Report I<pre><h5>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th align="center" class="center" rowspan="2">District</th>
							 <th align="center" class="center" rowspan="2">Monitoring Officer"s Center</th>
                            <th align="center" class="center" rowspan="2">Officer Name</th>
                            <th align="center" class="center" rowspan="2">Designation</th>
                            <th align="center" class="center" colspan="2">Plan to Monitor</th>
                            <th align="center" class="center" rowspan="2">Approved</th>
							<th align="center" class="center" rowspan="2">Visited</th>
							<th align="center" class="center" rowspan="2">View Result Form</th>
                            
              
              
                        </tr>
                        <tr>
                        
                            <th align="center" class="center">Center</th>
                            <th align="center" class="center">Date</th>
                        </tr>
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {


            $sql = "select 
  distinct monewcentermonitoringplan.id,
	district.DistrictName,
  O2.OrgaName as MOrgaName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  monewcentermonitoringplan.DatePlanned,
  monewcentermonitoringplan.Approved,
  monewcentermonitoringplan.Visited
  from monewcentermonitoringplan
 left join organisation
  on monewcentermonitoringplan.CenterID=organisation.id
  left join organisation as O2
  on monewcentermonitoringplan.OrgaIDUser=O2.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on monewcentermonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where monewcentermonitoringplan.Deleted=0
  and organisation.Deleted=0
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,monewcentermonitoringplan.DatePlanned";

}
else
{
   $sql = "select 
  distinct monewcentermonitoringplan.id,
	district.DistrictName,
  O2.OrgaName as MOrgaName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  monewcentermonitoringplan.DatePlanned,
  monewcentermonitoringplan.Approved,
  monewcentermonitoringplan.Visited
  from monewcentermonitoringplan
 left join organisation
  on monewcentermonitoringplan.CenterID=organisation.id
  left join organisation as O2
  on monewcentermonitoringplan.OrgaIDUser=O2.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on monewcentermonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where monewcentermonitoringplan.Deleted=0
  and organisation.Deleted=0
  and organisation.DistrictCode='".$District."'
  and monewcentermonitoringplan.DatePlanned>='".$tempStartDate."'
  and monewcentermonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,monewcentermonitoringplan.DatePlanned";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
        

                foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td>' . $i++ . '</td>
                            <td>'.$ps->DistrictName.'</td>
							<td class="center">' . $ps->MOrgaName . '</td>
                            <td>'.$ps->Initials.' '.$ps->LastName.'</td>
                            <td>'.$ps->Designation.'</td>
                            
                            
                            <td class="center">' . $ps->OrgaName . '('.$ps->Type.')</td>
                            <td class="center">' . $ps->DatePlanned.'</td>';
							 if($ps->Approved == '1')
                            {
                              $html.='<td class="center"><font color="green"><i class="icon-ok bigger-130"></i></font></td>';
                            }
                            elseif($ps->Approved == '2')
                            {
                              $html.='<td class="center"><font color="red"><i class="icon-remove bigger-130"></i></font></td>';
                            }
							else{
								
								$html.='<td class="center"><font color="blue"><i class="icon-edit bigger-130"></i></font></td>';
							}
							
                            if($ps->Visited == '1')
                            {
                              $html.='<td class="center"><font color="green"><i class="icon-ok bigger-130"></i></font></td>';
                            }
                            else
                            {
                              $html.='<td class="center"><font color="red"><i class="icon-remove bigger-130"></i></font></td>';
                            }
							if($ps->Visited == '1')
							{
								$html.=' <td class="center">
                                <form id="deleteform"  action="ViewNewCenterTOMonitoringFormEntered" method="GET">
                                <input type="hidden" name="id" value="'.$ps->id.'" />
                                <button type="Submit" class="btn btn-pink btn-mini"><i class="icon-eye-open icon-2x icon-only"></i></button>
                                </form>
                             </td></tr>';
							}
							else
							{
								$html.='<td class="center"></td>
                            </tr>';
							}
                            
                }
            


           
        

         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div>";
            return json_encode(array("Count" => $Count, "Table" => $html));

  }
	
	 public function ViewDistrictWiseCenterMonitoringProgress()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewDistrictWiseCenterMProgressI');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
    
  }
	
		public function InstantCenterApprovals()
	{
		$view = View::make("Home.CenterPlanApproval");
				$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
				//$view->user = $user;
				if($userOrgType =='HO')
				{
					if($Designation =='Assistant Director')
					{
						$sql1 = "select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HO')
							  and organisation.Deleted=0
							  and employmentcode.Designation='Training Officer'";
					}
					elseif($Designation =='Deputy Director')
					{
						 $sql1 = "select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HO')
							  and organisation.Deleted=0
							  and employmentcode.Designation in('Training Officer','Assistant Director')";
					}
					elseif($Designation =='Director')
					{
						 $sql1 = "select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HO','PO')
							  and organisation.Deleted=0
							  and employmentcode.Designation in('Training Officer','Assistant Director','Deputy Director')";
					}
					else
					{
						 $sql1 = "select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							 and employee.Deleted=0
							  and organisation.Type in('HHO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
					
				}
				elseif($userOrgType =='PO')
				{
					if($Designation =='Assistant Director')
					{
						$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							 and organisation.Type in('DO','NVTI')
							  and organisation.Deleted=0
							  and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Training Officer')";
					}
					elseif($Designation =='Deputy Director')
					{
						$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO','NVTI')
							  and organisation.Deleted=0
							  and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
					}
					elseif($Designation =='Director')
					{
						$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO','NVTI')
							  and organisation.Deleted=0
							  and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
					}
					else
					{
						$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType							 
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('PPO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
					
					
				}
				elseif($userOrgType =='DO')
				{
					//return $Designation;
					if($Designation =='Assistant Director')
					{
						 $sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					elseif($Designation =='Deputy Director')
					{
						$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Assistant Director')";
					}
					elseif($Designation =='Director')
					{
						$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
					}
					else
					{
						 $sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DDO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
				}
				else{
					$sql1="select monewcentermonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType
							  from monewcentermonitoringplan
							  left join employee
							  on monewcentermonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on monewcentermonitoringplan.CenterID=O2.id
							  where monewcentermonitoringplan.Deleted=0
							  and monewcentermonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HHOO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
				}
				
				 $view->ApproveCCMP = $CountCCMP;
				 $view->AproveCCMPList = $FF;
				return $view;
				//CourseMonitoring Plan Approve 
		
	}
	
	public function InstantCourseApprovals()
	{
		
		
			//CourseMonitoring Plan Approve
			    $view = View::make("Home.CoursePlanApproval");
				$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				$CountCMP=0;
				//$view->user = $user;
				if($userOrgType =='HO')
				{
					if($Designation =='Assistant Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							  courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HO')
							  and organisation.Deleted=0
							  and employmentcode.Designation='Training Officer'";
					}
					elseif($Designation =='Deputy Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							  courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HO')
							  and organisation.Deleted=0
							  and employmentcode.Designation in('Training Officer','Assistant Director')";
					}
					elseif($Designation =='Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							  courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HO','PO')
							  and organisation.Deleted=0
							  and employmentcode.Designation in('Training Officer','Assistant Director','Deputy Director')";
					}
					else
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							  courseyearplan.Year,
                              courseyearplan.batch
							 from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HHO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
					
				}
				elseif($userOrgType =='PO')
				{
					if($Designation =='Assistant Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							  courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Training Officer')";
							
					}
					elseif($Designation =='Deputy Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO','NVTI')
							  and organisation.Deleted=0
							  and province.ProvinceCode='".$UserProvinceCode."'
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
					}
					elseif($Designation =='Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                             courseyearplan.batch
							 from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
					}
					else
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('PPO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
					
					
				}
				elseif($userOrgType =='DO')
				{
					//return $Designation;
					if($Designation =='Assistant Director')
					{
						 $sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                                courseyearplan.batch
							   from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					elseif($Designation =='Deputy Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Assistant Director')";
					}
					elseif($Designation =='Director')
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                             courseyearplan.batch
							from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
						      left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
					}
					else
					{
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							    courseyearplan.Year,
                               courseyearplan.batch
							   from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('DDO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
				}
				else{
					$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel,
							  courseyearplan.Year,
                              courseyearplan.batch
							  from mocentremonitoringplan
							  left join employee
							  on mocentremonitoringplan.EmpId=employee.id
							  left join employmentcode
							  on employee.CurrentDesignation=employmentcode.id
							  left join organisation
							  on employee.CurrentOrgaID=organisation.id
							  left join district
							  on organisation.DistrictCode=district.DistrictCode
							  left join province
							  on district.ProvinceCode=province.ProvinceCode
							  left join organisation as O2
							  on mocentremonitoringplan.CenterID=O2.id
							  left join courseyearplan
							  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
							  left join coursedetails
							  on courseyearplan.CD_ID=coursedetails.CD_ID
							  where mocentremonitoringplan.Deleted=0
							  and mocentremonitoringplan.Approved=0
							  and employee.Deleted=0
							  and organisation.Type in('HHOO')
							  and organisation.Deleted=0
							  and district.DistrictCode=$UserDistrictCode
							  and employmentcode.Designation in('Training Officer')";
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
				}
				
				 $view->AproveCMP = $CountCMP;
				 $view->AproveCMPList = $DD;
				return $view;
				//CourseMonitoring Plan Approve 
		
	}

	
	public function UpdateTimetabletaskList()
	{
		$DateMonitored = Input::get('DatePlanned');
		$CMPlanid = Input::get('CenterMoniPlan');
		$CourseYearPlanID = MOCenterMonitoringPlan::where('id','=',$CMPlanid)->pluck('CourseYearPlanID');
		$year = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('Year');
		$batch = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('batch');
		$CourseListCode = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('CourseListCode');
		$html = '';
		
		//load all task list untill Real date monitored.
		$sql = "select modatetask.id,
    modatetask.TaskSeqID,
    modatecalender.Date,
    modatecalender.Session,
    motask.TaskName,
    motask.TaskCode,
    module.ModuleName,
    module.ModuleCode
    from modatetask
    left join modatecalender
    on modatetask.MODateCalenderID=modatecalender.id
    left join motaskseq
    on modatetask.TaskSeqID=motaskseq.id
    left join motask
    on motaskseq.taskid=motask.id
    left join module
    on motaskseq.moduleid=module.ModuleId
    where modatetask.Deleted=0
    and modatetask.Year='".$year."'
    and modatetask.Batch like '".$batch."'
    and modatetask.CourseListCode='".$CourseListCode."'
    and modatecalender.Date<='".$DateMonitored."'";

	$timeTableList = DB::select(DB::raw($sql));
	$html='<table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class="center">No</th>
                        <th class="center">Date</th>
                        <th class="center">Session</th>
                        <th class="center">Module Name</th>
                        <th class="center">Task Name</th>
                         
                         <th class="center">
                                  <label>(Select All)
                                    <input name="select_all[]" id="actall" value="" type="checkbox" required>
                                    <span class="lbl"> &nbsp;</span>
                                    </label></th>
                        </th>
                        
                        
                </tr>
                </thead>
                    <tbody>';
		$SerialNo=1;
		foreach($timeTableList as $t)
		{
			$html .='<tr>

                     <td class="center">'.$SerialNo++.'</td>
                     <td class="center">'.$t->Date.'</td>
                     <td class="center">'.$t->Session.'</td>';
                    if($t->TaskSeqID == '999997')
					{
                     $html.='<td class="center">Orientation Program</td>
                     <td class="center">Orientation Program</td>';
					}
                    elseif($t->TaskSeqID == '999998')
					{
                     $html.='<td class="center">English/Career Skills</td>
                     <td class="center">English/Career Skills</td>';
					}
                     elseif($t->TaskSeqID == '999999')
					 {
                     $html.='<td class="center">Continuous Assessment</td>
                     <td class="center">Continuous Assessment</td>';
					 }
                     else
					 {
                     $html.='<td class="center">'.$t->ModuleName.'('.$t->ModuleCode.')</td>
                     <td class="center">'.$t->TaskName.'('.$t->TaskCode.')</td>';
					 }
                    
                    
                   $html.= '<td class="center"><label>
                      <input type="hidden" name="ModateTaskIDs[]" id="ModateTaskIDs[]" value="'.$t->id.'">
                        <input name="trainee_ids[]" class="abc" value="'.$t->id.'" type="checkbox" />
                        <span class="lbl"> &nbsp;</span>
                        </label>
                    </td>
                  </tr>';
				  
		}
		$html.=' </tbody>
            </table>';
			
			return json_encode($html);
	}
	// old
	
	public function SecondRevGetOrmit()
{
          $Year = Input::get('YearD');
          $Batch = Input::get('BatchD');
		  $YearPlanID = Input::get('YearPlanIDD');
		  $StartDate = Input::get('StartDateD');
		  $TaskSeqSession = Input::get('TaskSeqSession');
		  $ActualSeqSession = Input::get('ActualSeqSession');
          $K = 1;
          $TOKEN = 'a';
          $html = '';
          $rt = 0;
          $getActualNoOfSessions = 0;
         
          $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
       //   $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
	   $CD_ID = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr($DurationValue, 0, -2);
         
          $sql78 = "SELECT DATE_SUB(DATE_ADD('$StartDate', INTERVAL '$duration' MONTH),INTERVAL 2 DAY) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
           $sql = "select modatecalender.id,modatecalender.Date,modatecalender.Session
                  from modatecalender
                  where modatecalender.Deleted=0
				  and modatecalender.Active=1
                  and modatecalender.Date>='$StartDate'
                  and modatecalender.Date<='$expectedcom'
				  order by modatecalender.Date,modatecalender.Session";
          $AllMODateCalender = DB::select(DB::raw($sql));
          $y = count($AllMODateCalender);
          $NewDates =  json_decode(json_encode((array)$AllMODateCalender),true);
          $deleteAllFrommodatetask = MODateTask::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CD_ID','=',$CD_ID)->delete();
//return $duration;
          /* if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          } */
		  
		  $sss = 0;//only for 2021 batch 1 and for others unblock above code
          
          for($HH=0;$HH<$sss;$HH++)
          {
           

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999997;//Orientation Program
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                              $rt = $rt +1;
          }
          //return $rt;

           
         
          //Update CourseYearPlan StartDate *****
		 // $updateCourseYearPlan = CourseYearPlan::where('id','=',$YearPlanID)->update(array('RealstartDate' => $StartDate));
          $updateCourseYearPlan = CourseYearPlan::where('CD_ID','=',$CD_ID)->where('batch','like',$Batch)->where('Year','=',$Year)->update(array('RealstartDate' => $StartDate));

          $AllTaskSequens = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->where('Active','=',1)->orderBy('orderMT')->get();
          $x = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->where('Active','=',1)->sum('noofsessions');
          $x = floor($y/10)+$x+$sss+2;//Do +2 for continueous Assessment
          $ActualNoOfSession = '';
          $AllTaskSequenceIDs = '';
          $deleteAllFromActualTaskSequence = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CD_ID','=',$CD_ID)->delete();
          /* $R = 0;
           $z = round(($y/$x),1);

             if($z>= 0 && $z<1)
             {
                //$R = 0.5;
				$R = 1;
             }
             elseif($z>=1 && $z<1.5)
             {
                $R = 1;
                
             }
             elseif($z>=1.5 && $z<2)
             {
                $R = 1.5;
                 
             }
             elseif($z>=2 && $z<2.5)
             {
               $R = 2;
             }
             else
             {
               $R = 1;
             } */
              foreach($AllTaskSequens as $t)
              {

                
                   
                   $AllTaskSequenceIDs = $t->id;
				   //$ActualNoOfSession = round($t->noofsessions*$R,1);
				 	$ActualNoOfSession = $t->noofsessions;
                   $u = new MOActualTaskSeq();
                   $u->TaskSequenceID = $AllTaskSequenceIDs;
				   if(in_array($ActualNoOfSession,$TaskSeqSession))
				   {
					    $pos = array_search($ActualNoOfSession,$TaskSeqSession);
						$getuserInputactualSessionValue =  $ActualSeqSession[$pos];
						if($getuserInputactualSessionValue != 0)
						{
						$u->ActualNoOfSessions = $getuserInputactualSessionValue;
						}
						else{
							$u->ActualNoOfSessions = $ActualNoOfSession;
						}
				   }
					else
				   {
					    $u->ActualNoOfSessions = $ActualNoOfSession;
				   }
                   $u->Year = $Year;
                   $u->Batch = $Batch;
                   $u->CourseListCode = $getCourseListCode;
				   $u->CD_ID = $CD_ID;
                   $u->Order = $t->orderMT;
                   $u->User = User::getSysUser()->userID; 
                   $u->save();
              }
            $T1 = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CD_ID','=',$CD_ID)->sum('ActualNoOfSessions');
           
            $T2 = $y;
           $M = 0;
           $Ormit = 0;
              if($T2>$T1)
              {
                $M = $T2 - ($T1+(ceil($y/10)+3));
                if($M<10)
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  //$Ormit = 0;
				  $Ormit = 0;
                }
                elseif($M>=10)
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  $Ormit = 0;
                }
                else
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  $Ormit = 0;
                }
            }else{
				 $M = $T1 - ($T2+(ceil($y/10)+3));
				$Revisiondates = ceil($M/2);// Change floor to ceil
                  $Ormit = 0;
				
			}
             //if t1>t2
            //return $Revisiondates;
          if($Ormit == 0)
          {
             $M = $T2 - $T1;  
                $AllActualTaskSeqList = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CD_ID','=',$CD_ID)->orderBy('Order')->get();
                
                $remain = 0;
                foreach ($AllActualTaskSeqList as $h) 
                {

                 
                    $TaskSeqID = $h->TaskSequenceID;
                    $CourseListCode = $h->CourseListCode;
                    $MOYear = $h->Year;
                    $MOBatch = $h->Batch;
                   

                    $getActualNoOfSessions+= $h->ActualNoOfSessions;
                   
                    
                 
                         for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {

                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }

                            $rt = $rt + 1;
							$a = $a-1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
							  }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                             }
                               
                              
                          }
                          else
                          {
                             

                             ///////
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }
                              $rt = $rt + 1;
                              
                             ////// 
                              
                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
								 if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$rt= $rt+1;
                         
                              
                              $f->save();
							  }
                          }

                          }

                        
                          


                        }
                        

                  $K = $a;
                 // $rt = $rt +1;

                  
                }// main forloop

                   $deleteMORevision = MORevisionDate::where('CourseListCode','=',$getCourseListCode)->delete();      
                       $getActualNoOfSessions+= $M;
                       for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                                if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }
                            $rt = $rt + 1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $b = new MORevisionDate();
                              //$b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
                              }

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                              { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
                            }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                              
                             }
                             
                          }
                          else
                          {

///////////////////////////////////////////////////////////////
                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch;
								$f->CD_ID = $CD_ID;							  
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID;
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];							  
                              $b->save(); 
							  }
                              $rt = $rt + 1;

                              ///////////////////////////////////////////////////

                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$getActualNoOfSessions = $getActualNoOfSessions +1;
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
							  }
                          }

                          }

                          
                          


                        }//ormit for loop

          
                     

                     

                       
                      }//if ormit 0
                  return Redirect::to('GenarateActualTimeTable')->with("done", true); 
    }//close function
	
	public function loadWeekTimeTableWiuthAjax()
	{
		$CD_ID = Input::get('CDID');
		$Year = Input::get('Year');
		$Batch = Input::get('Batch');
		$month = Input::get('Month');
		$WeekNo = Input::get('WeekNo');
		$CalenderYear = Input::get('CalenderYear');
		
		
	 $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
     $CourseName = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseName');
     
     $html = '';
	 
	 if($WeekNo != 'All')
	 {
		 
		 
		 $WeekFrom = MODateTask::weekFrom($Year,$WeekNo,$month,$CalenderYear);
     $WeekTo = MODateTask::weekTo($Year,$WeekNo,$month,$CalenderYear);
		  $html = ' <input type="hidden" value="{{$CD_ID}}" name="CDFID" id="CDFID"/>
            <input type="hidden" value="{{$Batch}}" name="BATCHID" id="BATCHID"/>
            <input type="hidden" value="{{$Year}}" name="YEARID" id="YEARID"/>
            <input type="hidden" value="{{$WeekNo}}" name="WEEKID" id="WEEKID"/>
			<input type="hidden" value="{{$month}}" name="MonthID" id="MonthID"/>
	 
	 <pre><center><b><i><h5>Week Time Table For Course - '.$CourseName.' Batch - '.$Batch.' Month - '.$month.' Week No - '.$WeekNo.' <br/>(From: '.$WeekFrom.'    To: '.$WeekTo.')</h5></i></b></center></pre>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
                        <th  class="center">SESSION</th>
                        <th  class="center">TIME</th>
                        <th  class="center">MONDAY</th>
                        <th  class="center">TUESDAY</th>
                        <th  class="center">WEDNESDAY</th>
                        <th  class="center">THURSDAY</th>
                        <th  class="center">FRIDAY</th>
                        
                </tr>
                 </thead>';
      $HolidayMon = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Mon',$CalenderYear);
      $HolidayTue = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Tue',$CalenderYear);
      $HolidayWed = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Wed',$CalenderYear);
      $HolidayThu = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Thu',$CalenderYear);
      $HolidayFri = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Fri',$CalenderYear);
      $html.='<tbody>
                    <tr>
                        <td class="center"></td>
                        <td class="center">8.30 - 9.00</td>
                        <td class="center">';
                            if($HolidayMon == '0')
                            {
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }

                        $html.='</td>
                        <td class="center">';
                             if($HolidayTue == '0')
                             {
                               $html.='<font color="RED">Holiday</font>';
                              }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayWed == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                         
                        $html.='</td>
                        <td class="center">';
                             if($HolidayThu == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.=' <font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                            
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                           
                       $html.=' </td>
                    </tr>';
                    $html.='<tr>
                        <td class="center">1</td>
                        <td class="center">9.00 - 12.15</td>
                        <td class="center">';
                        if($HolidayMon != 0)
                        {
                        
                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Mon',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
						 
						 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                         
                        $html.='</td>
                        <td class="center">';
                            if($HolidayTue != 0)
                            {
                            
                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Tue',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                                   
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                          
                         
                        $html.='</td>
                        <td class="center">';
                             if($HolidayWed != 0)
                           {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                          
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                         
                        $html.='</td>
                        <td class="center">';
                              if($HolidayThu != 0)
                              {
                            

                                  $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Thu',$month,$CalenderYear);
								  $CountDDD = count($ddMONS1);
                        

                         
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                           else
                           {
                          $html.='<font color="RED">Holiday</font>';
                        }
                         
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri != 0)
                            {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Fri',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);
                        

                          
                               if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                            }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                        $html.='</td>
                    </tr>';
                    $html.='<tr>
                        <td class="center"></td>
                        <td class="center">12.15 - 12.45</td>
                        <td class="center">';
                            if($HolidayMon == '0')
                            {
                            
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayTue == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                            }
                            else{
                                $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                        $html.='</td>
                        <td class="center">';
                             if($HolidayWed == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                             }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayThu == '0')
                             {
                           $html.='<font color="RED">Holiday</font>';
                         }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                          }
                            
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri == '0')
                             {
                            $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                            
                        $html.='</td>
                    </tr>';
                     $html.='<tr>
                        <td class="center">2</td>
                        <td class="center">12.45 - 4.00</td>
                        <td class="center">';
                            if($HolidayMon != 0)
                            {
                           

                       $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Mon',$month,$CalenderYear);
					   $CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td class="center">';
                             if($HolidayTue != 0)
                             {
                           

                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Tue',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
                        
                      
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td class="center">';
                            if($HolidayWed != 0)
                            {
                            

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                            
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                        }
                        $html.='</td>
                        <td class="center">';
                              if($HolidayThu != 0)
                              {
                           

                         
                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Thu',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);

                          
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri != 0)
                             {
                            

                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Fri',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                    </tr>
                   
                
                    
                </tbody>
            </table></body></html>';
	 }
	 else
	 {
		 $html = ' <input type="hidden" value="{{$CD_ID}}" name="CDFID" id="CDFID"/>
            <input type="hidden" value="{{$Batch}}" name="BATCHID" id="BATCHID"/>
            <input type="hidden" value="{{$Year}}" name="YEARID" id="YEARID"/>
            <input type="hidden" value="{{$WeekNo}}" name="WEEKID" id="WEEKID"/>
			<input type="hidden" value="{{$month}}" name="MonthID" id="MonthID"/>
	 
	 <pre><center><b><i><h5>Week Time Table For Course - '.$CourseName.' Year -'.$Year.' Batch -'.$Batch.'</h5></i></b></center></pre>';
	 
	 $sql = "select DISTINCT modatecalender.WeekNo
            from modatetask
            left join modatecalender
            on modatetask.MODateCalenderID=modatecalender.id
            where modatetask.Deleted=0
            and modatetask.Year='".$Year."'
            and modatetask.Batch like '".$Batch."'
            and modatecalender.Month='".$month."'
			and modatecalender.Year = '".$CalenderYear."'
            and modatetask.CD_ID='".$CD_ID."'
			order by modatecalender.WeekNo";
      $WeekNoList = DB::select(DB::raw($sql));
	  $wwwww = 1;
	  foreach($WeekNoList as $WLS)
	  {
		  $WeekFrom = MODateTask::weekFrom($Year,$WLS->WeekNo,$month,$CalenderYear);
		  $WeekTo = MODateTask::weekTo($Year,$WLS->WeekNo,$month,$CalenderYear);
		  $html.= ' <hr/><pre><center><b><i><h6>Month - '.$month.' Week No - '.$wwwww.' <br/>(From: '.$WeekFrom.'    To: '.$WeekTo.')</h6></i></b></center></pre>';
		   $html.='<table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
                        <th  class="center">SESSION</th>
                        <th  class="center">TIME</th>
                        <th  class="center">MONDAY</th>
                        <th  class="center">TUESDAY</th>
                        <th  class="center">WEDNESDAY</th>
                        <th  class="center">THURSDAY</th>
                        <th  class="center">FRIDAY</th>
                        
                </tr>
                 </thead>';
      $HolidayMon = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Mon',$CalenderYear);
      $HolidayTue = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Tue',$CalenderYear);
      $HolidayWed = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Wed',$CalenderYear);
      $HolidayThu = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Thu',$CalenderYear);
      $HolidayFri = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Fri',$CalenderYear);
      $html.='<tbody>
                    <tr>
                        <td class="center"></td>
                        <td class="center">8.30 - 9.00</td>
                        <td class="center">';
                            if($HolidayMon == '0')
                            {
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }

                        $html.='</td>
                        <td class="center">';
                             if($HolidayTue == '0')
                             {
                               $html.='<font color="RED">Holiday</font>';
                              }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayWed == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                         
                        $html.='</td>
                        <td class="center">';
                             if($HolidayThu == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.=' <font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                            
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                           
                       $html.=' </td>
                    </tr>';
                    $html.='<tr>
                        <td class="center">1</td>
                        <td class="center">9.00 - 12.15</td>
                        <td class="center">';
                        if($HolidayMon != 0)
                        {
                        
                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Mon',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
						 
						 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                         
                        $html.='</td>
                        <td class="center">';
                            if($HolidayTue != 0)
                            {
                            
                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Tue',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                                   
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                          
                         
                        $html.='</td>
                        <td class="center">';
                             if($HolidayWed != 0)
                           {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                          
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                         
                        $html.='</td>
                        <td class="center">';
                              if($HolidayThu != 0)
                              {
                            

                                  $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Thu',$month,$CalenderYear);
								  $CountDDD = count($ddMONS1);
                        

                         
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                           else
                           {
                          $html.='<font color="RED">Holiday</font>';
                        }
                         
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri != 0)
                            {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Fri',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);
                        

                          
                               if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                            }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                        $html.='</td>
                    </tr>';
                    $html.='<tr>
                        <td class="center"></td>
                        <td class="center">12.15 - 12.45</td>
                        <td class="center">';
                            if($HolidayMon == '0')
                            {
                            
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayTue == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                            }
                            else{
                                $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                        $html.='</td>
                        <td class="center">';
                             if($HolidayWed == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                             }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td class="center">';
                             if($HolidayThu == '0')
                             {
                           $html.='<font color="RED">Holiday</font>';
                         }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                          }
                            
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri == '0')
                             {
                            $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                            
                        $html.='</td>
                    </tr>';
                     $html.='<tr>
                        <td class="center">2</td>
                        <td class="center">12.45 - 4.00</td>
                        <td class="center">';
                            if($HolidayMon != 0)
                            {
                           

                       $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Mon',$month,$CalenderYear);
					   $CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td class="center">';
                             if($HolidayTue != 0)
                             {
                           

                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Tue',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
                        
                      
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td class="center">';
                            if($HolidayWed != 0)
                            {
                            

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                            
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                        }
                        $html.='</td>
                        <td class="center">';
                              if($HolidayThu != 0)
                              {
                           

                         
                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Thu',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);

                          
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td class="center">';
                             if($HolidayFri != 0)
                             {
                            

                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Fri',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                    </tr>
                   
                
                    
                </tbody>
            </table>';
			
			$wwwww = $wwwww + 1;
	  }
	  $html.='</body></html>';
		 
	 }

    
			
			return $html;
	}
	
	public function DownloadLoadViewDistrictWiseCenterMonitoringProgressSummary()
	 {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Center','Designation','Name','Planned','Approved','Rejected','Pending','Completed','Active');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
   if ($District == 'All') {

$sql="select district.DistrictName,organisation.OrgaName,organisation.Type,employmentcode.Designation,employee.NIC,employee.Initials,employee.Name,employee.LastName,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed,
	employee.Active
from employee
  right join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  and (employmentcode.Designation like 'Assistant Director' OR employmentcode.Designation like 'Deputy Director%' OR employmentcode.Designation like 'Training Officer')
  left join organisation
  on employee.CurrentOrgaID=organisation.id
  and organisation.Deleted=0 
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join mocentremonitoringplan
  on employee.id=mocentremonitoringplan.EmpId
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where employee.Deleted=0   
  and organisationtype.Type NOT IN('HO')     
  group by organisation.DistrictCode,organisation.OrgaName,employmentcode.Designation,employee.id
  order by district.DistrictName,organisation.OrgaName,employmentcode.Designation";

           

 

}
else
{
  $sql="select district.DistrictName,organisation.OrgaName,organisation.Type,employmentcode.Designation,employee.NIC,employee.Initials,employee.Name,employee.LastName,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed,
	employee.Active
from employee
  right join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  and (employmentcode.Designation like 'Assistant Director' OR employmentcode.Designation like 'Deputy Director%' OR employmentcode.Designation like 'Training Officer')
  left join organisation
  on employee.CurrentOrgaID=organisation.id
  and organisation.Deleted=0 
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join mocentremonitoringplan
  on employee.id=mocentremonitoringplan.EmpId
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where employee.Deleted=0   
  and organisationtype.Type NOT IN('HO')     
and organisation.DistrictCode='".$District."'  
  group by organisation.DistrictCode,organisation.OrgaName,employmentcode.Designation,employee.id
  order by district.DistrictName,organisation.OrgaName,employmentcode.Designation";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


            foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->OrgaName);
			    array_push($data_row, $Data->Designation);
			   //$emp = '"'.$Data->Initials.'" . "'.$Data->Name.'" . "'.$Data->LastName.'"';
			   $emp = $Data->Initials.$Data->LastName;
			   array_push($data_row,$emp);
                array_push($data_row, $Data->planned);
				 array_push($data_row, $Data->Approved);
				  array_push($data_row, $Data->Rejected);
				   array_push($data_row, $Data->Pending);
                array_push($data_row, $Data->Completed);
				if($Data->Active == '1')
				{
					$ActiveN = 'Yes';
				}
				else
				{
					$ActiveN = 'No';
				}
                  array_push($data_row, $ActiveN);
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CenterWiseMonitoringProgressReportSummary' . date('Y-m-d'));

  }
	
	public function LoadViewDistrictWiseMonitoringProgresssummaryCenter()
	{
     $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 0;
    $html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center> Center Wise Monitoring Progress Summary<pre><h5>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
							<th align="center" class="center" >Center(HO/PO/DO/NVTI)</th>
							<th align="center" class="center" >Designation</th>
							<th align="center" class="center" >Name</th>
                            <th align="center" class="center" >Planned</th>
							<th align="center" class="center" >Approved</th>
							<th align="center" class="center" >Rejected</th>
							<th align="center" class="center" >Pending Approval</th>
                            <th align="center" class="center" >Completed</th>
							<th align="center" class="center" >Active Status</th>
                            
                            
              
              
                        </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {

  
  $sql="select district.DistrictName,organisation.OrgaName,organisation.Type,employmentcode.Designation,employee.NIC,employee.Initials,employee.Name,employee.LastName,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed,
	employee.Active
from employee
  right join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  and (employmentcode.Designation like 'Assistant Director' OR employmentcode.Designation like 'Deputy Director%' OR employmentcode.Designation like 'Training Officer')
  left join organisation
  on employee.CurrentOrgaID=organisation.id
  and organisation.Deleted=0 
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join mocentremonitoringplan
  on employee.id=mocentremonitoringplan.EmpId
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where employee.Deleted=0   
  and organisationtype.Type NOT IN('HO')                      
  group by organisation.DistrictCode,organisation.OrgaName,employmentcode.Designation,employee.id
  order by district.DistrictName,organisation.OrgaName,employmentcode.Designation";

}
else
{
  
  
    $sql="select district.DistrictName,organisation.OrgaName,organisation.Type,employmentcode.Designation,employee.NIC,employee.Initials,employee.Name,employee.LastName,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
  SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed,
	employee.Active
from employee
  right join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  and (employmentcode.Designation like 'Assistant Director' OR employmentcode.Designation like 'Deputy Director%' OR employmentcode.Designation like 'Training Officer')
  left join organisation
  on employee.CurrentOrgaID=organisation.id
  and organisation.Deleted=0 
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join mocentremonitoringplan
  on employee.id=mocentremonitoringplan.EmpId
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where employee.Deleted=0   
  and organisationtype.Type NOT IN('HO')     
and organisation.DistrictCode='".$District."'  
  group by organisation.DistrictCode,organisation.OrgaName,employmentcode.Designation,employee.id
  order by district.DistrictName,organisation.OrgaName,employmentcode.Designation";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
			$totPlanned =  0;
			$totapproved = 0;
			$totReject = 0;
			$totPending = 0;
			$totComplete = 0;

                foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="center">'.$ps->DistrictName.'</td>
							<td class="center">'.$ps->OrgaName.'</td>
							<td class="center">'.$ps->Designation.'</td>
							<td class="center">'.$ps->Initials.' '.$ps->LastName.'</td>
                            <td class="center">'.$ps->planned.'</td>
							<td class="center">'.$ps->Approved.'</td>
							<td class="center">'.$ps->Rejected.'</td>
							<td class="center">'.$ps->Pending.'</td>
                            <td class="center">'.$ps->Completed.'</td>';
							if($ps->Active == '1')
				{
					$ActiveN = 'Yes';
				}
				else
				{
					$ActiveN = 'No';
				}
							 $html .='<td class="center">'.$ActiveN.'</td>
                            <tr>';
							
							$totPlanned = $totPlanned+$ps->planned;
							$totapproved = $totapproved+$ps->Approved;
							$totReject = $totReject+$ps->Rejected;
							$totPending = $totPending+$ps->Pending;
                            $totComplete = $totComplete+$ps->Completed;
                           
                            
                }
				
				$html .='<tr>
                            <td class="center">Total</td>
                            <td class="center">All</td>
							<td class="center">All</td>
							<td class="center">All</td>
							<td class="center">All</td>
                            <td class="center">'.$totPlanned.'</td>
							<td class="center">'.$totapproved.'</td>
							<td class="center">'.$totReject.'</td>
							<td class="center">'.$totPending.'</td>
                            <td class="center">'.$totComplete.'</td>
							<td class="center"></td>
                            <tr>';
            


           
        

         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
  }
  
	
	 public function ViewDistrictWiseMonitoringProgressSummaryCenter()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewDistrictWiseCenterMProgressSummary');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
  }
	
	public function loaddistrictcentersin()
	{
		
		$dis = Input::get('District');
		
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

  public function DownloadAverageCourseMonitoringDetailswithMarksReport()
  {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','No Of Courses','No of Times Monitored(Monitoring dates* no of Officers)','Average Mark(Out Of 600)');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
   if ($District == 'All') {


              $sql = "select district.DistrictCode,
  district.DistrictName,
  count(courseyearplan.id) NoOfCoursesrunning
from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join courseyearplan
  on courseyearplan.OrgId=organisation.id
  and courseyearplan.Deleted=0
  and courseyearplan.StartedStatus!=0
  where organisation.Deleted=0
 group by organisation.DistrictCode
  order by district.DistrictName";

}
else
{
   $sql = "select district.DistrictCode,
  district.DistrictName,
  count(courseyearplan.id) NoOfCoursesrunning
from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join courseyearplan
  on courseyearplan.OrgId=organisation.id
  and courseyearplan.Deleted=0
  and courseyearplan.StartedStatus!=0
  where organisation.Deleted=0
  and district.DistrictCode='".$District."'
 group by organisation.DistrictCode
  order by district.DistrictName";
}
     
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


            foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->NoOfCoursesrunning);

                $sql1 = "select count(mocentremonitoringplan.id) as monitoringplanCount,
                             round(avg(momonitoringresult.FullMark),2) as AverageMak
                            from courseyearplan
                            left join organisation
                            on courseyearplan.OrgId=organisation.id
                            left JOIN mocentremonitoringplan
                            on courseyearplan.id=mocentremonitoringplan.CourseYearPlanID
                            left join momonitoringresult
                            on mocentremonitoringplan.id=momonitoringresult.CMPlanID
                            where courseyearplan.Deleted=0
							and courseyearplan.StartedStatus!=0
                            and organisation.DistrictCode='".$Data->DistrictCode."'
                            and mocentremonitoringplan.Approved='1'
                            and mocentremonitoringplan.Visited='1'
                            group by organisation.DistrictCode";
                            $newdu = DB::select(DB::raw($sql1));
                            if(!empty($newdu))
                            {
                              $newdata =  json_decode(json_encode((array)$newdu),true);
                              $monitoringplanCount = $newdata[0]["monitoringplanCount"];
                              $AverageMak = $newdata[0]["AverageMak"];
                            }
                            else
                            {
                               $monitoringplanCount = 0;
                               $AverageMak = 0;
                            }
               
                array_push($data_row, $monitoringplanCount);
                array_push($data_row, $AverageMak);
                
                
                
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('AverageCourseMonitoringDetailswithMarks' . date('Y-m-d'));
  }

  public function LoadAverageCourseMonitoringDetailswithMarksReport()
  {
    $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 0;
    $html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>Course Monitoring Detail with Average marks Report <pre><h5>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
                            <th align="center" class="center" >No Of Courses</th>
                            <th align="center" class="center" >No of Times Monitored(Monitoring dates* no of Officers)</th>
                            <th align="center" class="center" >Average Mark(Out Of 600)</th>
                        </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {


              $sql = "select district.DistrictCode,
  district.DistrictName,
  count(courseyearplan.id) NoOfCoursesrunning
from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join courseyearplan
  on courseyearplan.OrgId=organisation.id
  and courseyearplan.Deleted=0
  and courseyearplan.StartedStatus!=0
  where organisation.Deleted=0
 group by organisation.DistrictCode
  order by district.DistrictName";

}
else
{
   $sql = "select district.DistrictCode,
  district.DistrictName,
  count(courseyearplan.id) NoOfCoursesrunning
from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join courseyearplan
  on courseyearplan.OrgId=organisation.id
  and courseyearplan.Deleted=0
  and courseyearplan.StartedStatus!=0
  where organisation.Deleted=0
  and district.DistrictCode='".$District."'
 group by organisation.DistrictCode
  order by district.DistrictName";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
        

                foreach($total_rec as $ps) {

                  $monitoringplanCount = 0;
                  $AverageMak = 0;
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="center">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->NoOfCoursesrunning.'</td>';
                            $sql1 = "select count(mocentremonitoringplan.id) as monitoringplanCount,
                             round(avg(momonitoringresult.FullMark),2) as AverageMak
                            from courseyearplan
                            left join organisation
                            on courseyearplan.OrgId=organisation.id
                            left JOIN mocentremonitoringplan
                            on courseyearplan.id=mocentremonitoringplan.CourseYearPlanID
                            left join momonitoringresult
                            on mocentremonitoringplan.id=momonitoringresult.CMPlanID
                            where courseyearplan.Deleted=0
							and courseyearplan.StartedStatus!=0
                            and organisation.DistrictCode='".$ps->DistrictCode."'
                            and mocentremonitoringplan.Approved='1'
                            and mocentremonitoringplan.Visited='1'
                            group by organisation.DistrictCode";
                            $newdu = DB::select(DB::raw($sql1));
                            if(!empty($newdu))
                            {
                              $newdata =  json_decode(json_encode((array)$newdu),true);
                              $monitoringplanCount = $newdata[0]["monitoringplanCount"];
                              $AverageMak = $newdata[0]["AverageMak"];
                            }
                            else
                            {
                               $monitoringplanCount = 0;
                               $AverageMak = 0;
                            }
                            
                            $html.='<td class="center">'.$monitoringplanCount.'</td>
                            <td class="center">'.$AverageMak.'/600</td>
                            <tr>';
                           
                            
                }
            


           
        

         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));

  }

  public function ViewAverageCourseMonitoringDetailswithMarksReport()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewAverageCourseMonitoringMarks');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
  }

  public function DownloadCourseMonitoringDetailswithMarksReport()
  {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 1;
 
  $FullWeightFortheSectionsql = DB::select(DB::raw("select sum(mocriteriacategory.FullWeightFoTheSection) as tot
  from mocriteriacategory
  where mocriteriacategory.Deleted=0
  and mocriteriacategory.Active=1"));
  $newdata =  json_decode(json_encode((array)$FullWeightFortheSectionsql),true);
  $TotalFullw = $newdata[0]["tot"];
  
  
    $tablePrintHeader = array('#', 'District','Center','Course','Total Makrs(Out of '.$TotalFullw.')','Time Table Achivement','Date Planned','Actual Date Monitored','Monitored By','Center(Officer Monitored)');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
      if ($District == 'All') {


    $sql = "select mocentremonitoringplan.id,
	district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
 momonitoringresult.FullMark,
  momonitoringresult.CourseDeliveryMark,
   momonitoringresult.MonitoringDate,
    O2.OrgaName as MOrganame
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join organisation as O2
on mocentremonitoringplan.OrgaIDUser=O2.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
   left join momonitoringresult
  on mocentremonitoringplan.id=momonitoringresult.CMPlanID
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Approved='1'
  and organisation.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Visited='1'
  group by mocentremonitoringplan.id
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";

}
else
{
$sql = "select mocentremonitoringplan.id,
district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
  momonitoringresult.FullMark,
  momonitoringresult.CourseDeliveryMark,
   momonitoringresult.MonitoringDate,
    O2.OrgaName as MOrganame
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join organisation as O2
on mocentremonitoringplan.OrgaIDUser=O2.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
 on courseyearplan.CD_ID=coursedetails.CD_ID
   left join momonitoringresult
  on mocentremonitoringplan.id=momonitoringresult.CMPlanID
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Approved='1'
  and organisation.Deleted=0
  and organisation.DistrictCode='".$District."'
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Visited='1'
  group by mocentremonitoringplan.id
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


            foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->DistrictName);
                $Orga = $Data->OrgaName.'-'.$Data->Type;
                array_push($data_row, $Orga);
                $CourseDeta = $Data->CourseName . '['.$Data->CourseListCode.']';
                array_push($data_row, $CourseDeta);
                array_push($data_row, $Data->FullMark);
                array_push($data_row, $Data->CourseDeliveryMark."%");
                array_push($data_row, $Data->DatePlanned);
				array_push($data_row, $Data->MonitoringDate);
                $EmployeeName = $Data->Initials.' '.$Data->LastName;
                $EmpWithDeg = $EmployeeName."(".$Data->Designation.")"; 
                array_push($data_row, $EmpWithDeg);
				array_push($data_row, $Data->MOrganame);
                
                
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('CourseMonitoringDetailswithMarks' . date('Y-m-d'));
  }

  public function LoadCourseMonitoringDetailswithMarksReport()
  {
    $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 0;
    $html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>Course Monitoring Details with marks Report <pre><h5>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
                            <th align="center" class="center" >Center</th>
                             <th align="center" class="center" >Course</th>
                            <th align="center" class="center" >Total Mark(Out of 600)</th>
                            <th align="center" class="center" >Time Table Achivement(Out of 100%)</th>
                            <th align="center" class="center" >Date Planned</th>
							 <th align="center" class="center" >Actual Date Monitored</th>
                            <th align="center" class="center" >Monitored By</th>
							 <th align="center" class="center" >Center(Officer Monitored)</th>
              
              
                        </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {


              $sql = "select DISTINCT mocentremonitoringplan.id,
			  district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
 momonitoringresult.FullMark,
  momonitoringresult.CourseDeliveryMark,
  momonitoringresult.MonitoringDate,
  O2.OrgaName as MOrganame
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
left join organisation as O2
on mocentremonitoringplan.OrgaIDUser=O2.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
   left join momonitoringresult
  on mocentremonitoringplan.id=momonitoringresult.CMPlanID
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Approved='1'
  and organisation.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Visited='1'
  group by mocentremonitoringplan.id
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";

}
else
{
   $sql = "select DISTINCT mocentremonitoringplan.id,
   district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
  momonitoringresult.FullMark,
  momonitoringresult.CourseDeliveryMark,
    momonitoringresult.MonitoringDate,
	O2.OrgaName as MOrganame
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join organisation as O2
on mocentremonitoringplan.OrgaIDUser=O2.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
   left join momonitoringresult
  on mocentremonitoringplan.id=momonitoringresult.CMPlanID
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Approved='1'
  and organisation.Deleted=0
  and organisation.DistrictCode='".$District."'
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Visited='1'
  group by mocentremonitoringplan.id
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
        

                foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="center">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->OrgaName.'('.$ps->Type.')</td>
                            <td class="center">' . $ps->CourseName . '['.$ps->CourseListCode.']-('.$ps->CourseType.' Time/'.$ps->Nvq.'-'.$ps->CourseLevel.'/Duration-'.$ps->Duration.')</td>
                            <td class="center">'.$ps->FullMark.'/600</td>
                            <td class="center">'.$ps->CourseDeliveryMark.'%</td>
                             <td class="center">'.$ps->DatePlanned.'</td>
							  <td class="center">'.$ps->MonitoringDate.'</td>
                            <td>'.$ps->Initials.' '.$ps->LastName.'('.$ps->Designation.')</td>
							  <td class="center">'.$ps->MOrganame.'</td>
                            <tr>';
                           
                            
                }
            


           
        

         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
  }

  public function ViewCourseMonitoringDetailswithMarksReport()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewCourseMonitoringDetailsWithMarks');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
  }

  public function DownloadLoadViewDistrictWiseMonitoringProgressSummary()
  {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','No of Monitoring Planned','No of Monitoring Approved','No of Monitoring Rejected','No of Monitoring Pending','No of Monitoring Completed');

    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

    $i = 1;
   if ($District == 'All') {


            /*$sql = "select district.DistrictName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) planned,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where mocentremonitoringplan.Deleted=0
  and mocentremonitoringplan.Approved='1'
  and organisation.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  group by district.DistrictName
  order by district.DistrictName";*/
 $sql="select district.DistrictName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
			 THEN
            1
        ELSE 0
    END) Completed
   from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where organisation.Deleted=0
  and organisationtype.Type NOT IN('HO','NVTI')
  group by organisation.DistrictCode
  order by district.DistrictName";


$sqlnvti="select organisation.OrgaName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
			 THEN
            1
        ELSE 0
    END) Completed
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  
  where organisation.Deleted=0
 
  and organisationtype.Type  IN('NVTI')
  
  group by organisation.OrgaName
  order by organisation.OrgaName";

}
else
{
 

  $sql="select district.DistrictName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
           WHEN
            (mocentremonitoringplan.Approved = 0)
			THEN 
			 1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed
  from district
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
 
  where organisation.Deleted=0
 
 and organisation.DistrictCode='".$District."'
 
   and organisationtype.Type NOT IN('HO','NVTI') 
  group by organisation.DistrictCode
  order by district.DistrictName";
  
  
   $sqlnvti="select organisation.OrgaName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
           WHEN
            (mocentremonitoringplan.Approved = 0)
			THEN 
			 1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where organisation.Deleted=0
   and organisation.DistrictCode='".$District."'
  and organisationtype.Type IN('NVTI') 
  group by organisation.OrgaName
  order by organisation.OrgaName";
}    //return $sql;
            $total_rec = DB::select(DB::raw($sql));
			 $total_rec_nvti = DB::select(DB::raw($sqlnvti));

            $Count = count($total_rec);


            foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->DistrictName);
                array_push($data_row, $Data->planned);
				array_push($data_row, $Data->Approved);
				array_push($data_row, $Data->Rejected);
				array_push($data_row, $Data->Pending);
                array_push($data_row, $Data->Completed);
                array_push($printablearray, $data_row);
                            
                }
				foreach($total_rec_nvti as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->OrgaName);
                array_push($data_row, $Data->planned);
				array_push($data_row, $Data->Approved);
				array_push($data_row, $Data->Rejected);
				array_push($data_row, $Data->Pending);
                array_push($data_row, $Data->Completed);
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseMonitoringProgressReportSummary' . date('Y-m-d'));

  }

  public function LoadViewDistrictWiseMonitoringProgresssummary()
  {
     $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 0;
    $html='';

            $html = '<form class="form-horizontal" method="POST"  action="DownloadLoadViewDistrictWiseMonitoringProgress" id="cnfrmboot" >
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Monitoring Progress Summary<pre><h5>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center">#</th>
                            <th align="center" class="center" >District</th>
                            <th align="center" class="center" >No of Monitoring Planned</th>
							<th align="center" class="center" >No of Monitoring Approved</th>
							<th align="center" class="center" >No of Monitoring Rejected</th>
							<th align="center" class="center" >No of Monitoring Approval Pending</th>
                            <th align="center" class="center" >No of Monitoring Completed</th>
                            
                            
              
              
                        </tr>
                        
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {


           

  $sql="select district.DistrictName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
			 THEN
            1
        ELSE 0
    END) Completed
   from District
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where organisation.Deleted=0
  and organisationtype.Type NOT IN('HO','NVTI')
  group by organisation.DistrictCode
  order by district.DistrictName";


$sqlnvti="select organisation.OrgaName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
			 THEN
            1
        ELSE 0
    END) Completed
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  
  where organisation.Deleted=0
 
  and organisationtype.Type  IN('NVTI')
  
  group by organisation.OrgaName
  order by organisation.OrgaName";

}
else
{
 

   $sql="select district.DistrictName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
           WHEN
            (mocentremonitoringplan.Approved = 0)
			THEN 
			 1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed
  from District
  left join organisation
  on district.DistrictCode=organisation.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
 
  where organisation.Deleted=0
 
 and organisation.DistrictCode='".$District."'
 
   and organisationtype.Type NOT IN('HO','NVTI') 
  group by organisation.DistrictCode
  order by district.DistrictName";
  
  
   $sqlnvti="select organisation.OrgaName,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1 OR mocentremonitoringplan.Approved = 2 OR mocentremonitoringplan.Approved = 0)
             THEN
            1
        ELSE 0
    END) planned,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 1)
             THEN
            1
        ELSE 0
    END) Approved,
	SUM(CASE
        WHEN
            (mocentremonitoringplan.Approved = 2)
             THEN
            1
        ELSE 0
    END) Rejected,
	SUM(CASE
           WHEN
            (mocentremonitoringplan.Approved = 0)
			THEN 
			 1
        ELSE 0
    END) Pending,
SUM(CASE
        WHEN
            (mocentremonitoringplan.Visited = 1)
             THEN
            1
        ELSE 0
    END) Completed
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  left join mocentremonitoringplan
  on organisation.id=mocentremonitoringplan.CenterID
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  and mocentremonitoringplan.Deleted=0
  where organisation.Deleted=0
   and organisation.DistrictCode='".$District."'
  and organisationtype.Type IN('NVTI') 
  group by organisation.OrgaName
  order by organisation.OrgaName";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));
			 $total_rec_nvti = DB::select(DB::raw($sqlnvti));

            $Count = count($total_rec);
			$totPlanned =  0;
			$totapproved = 0;
			$totReject = 0;
			$totPending = 0;
			$totComplete = 0;
			
			
        

                foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="center">'.$ps->DistrictName.'</td>
                            <td class="center">'.$ps->planned.'</td>
							<td class="center">'.$ps->Approved.'</td>
							<td class="center">'.$ps->Rejected.'</td>
							<td class="center">'.$ps->Pending.'</td>
                            <td class="center">'.$ps->Completed.'</td>
                            <tr>';
							
							$totPlanned = $totPlanned+$ps->planned;
							$totapproved = $totapproved+$ps->Approved;
							$totReject = $totReject+$ps->Rejected;
							$totPending = $totPending+$ps->Pending;
                            $totComplete = $totComplete+$ps->Completed;
                            
                }
				
				foreach($total_rec_nvti as $ps1) {
                    $html .='<tr>
                            <td class="center">' . $i++ . '</td>
                            <td class="center">'.$ps1->OrgaName.'</td>
                            <td class="center">'.$ps1->planned.'</td>
							<td class="center">'.$ps1->Approved.'</td>
							<td class="center">'.$ps1->Rejected.'</td>
							<td class="center">'.$ps1->Pending.'</td>
                            <td class="center">'.$ps1->Completed.'</td>
                            <tr>';
							
							$totPlanned = $totPlanned+$ps1->planned;
							$totapproved = $totapproved+$ps1->Approved;
							$totReject = $totReject+$ps1->Rejected;
							$totPending = $totPending+$ps1->Pending;
                            $totComplete = $totComplete+$ps1->Completed;
                            
                }
				$html .='<tr>
                            <td class="center">Total</td>
                            <td class="center">All</td>
                            <td class="center">'.$totPlanned.'</td>
							<td class="center">'.$totapproved.'</td>
							<td class="center">'.$totReject.'</td>
							<td class="center">'.$totPending.'</td>
                            <td class="center">'.$totComplete.'</td>
                            <tr>';
            


           
        

         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div></form>";
            return json_encode(array("Count" => $Count, "Table" => $html));
  }
  
  

  public function ViewDistrictWiseMonitoringProgressSummary()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewDistrictWiseMProgressSummary');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
  }

  public function DownloadLoadViewDistrictWiseMonitoringProgress()
  {
    $District = Input::get('District');
   $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 1;

    $tablePrintHeader = array('#', 'District','Name','Designation','Center planned to monitor','Course plan to monitor','Date Planned','Approved','Visited');
    $excel = new SimpleExcel('csv');
    $printablearray = array();

    array_push($printablearray, $tablePrintHeader);

     $i = 1;
      if ($District == 'All') {


            $sql = "select district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
   mocentremonitoringplan.Approved,
  mocentremonitoringplan.Visited
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where mocentremonitoringplan.Deleted=0
 and organisation.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";

}
else
{
   $sql = "select district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
   mocentremonitoringplan.Approved,
  mocentremonitoringplan.Visited
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where mocentremonitoringplan.Deleted=0
  and organisation.Deleted=0
  and organisation.DistrictCode='".$District."'
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);


                foreach($total_rec as $Data) {
                $data_row = array();
                array_push($data_row, $i++);
                array_push($data_row, $Data->DistrictName);
                $EmployeeName = $Data->Initials.' '.$Data->LastName;
                array_push($data_row, $EmployeeName);
                array_push($data_row, $Data->Designation);
                $Orga = $Data->OrgaName.'-'.$Data->Type;
                array_push($data_row, $Orga);
                $CourseDeta = $Data->CourseName . '['.$Data->CourseListCode.']-('.$Data->CourseType.' Time/'.$Data->Nvq.'-'.$Data->CourseLevel.'/Duration-'.$Data->Duration.')';
                array_push($data_row, $CourseDeta);
                array_push($data_row, $Data->DatePlanned);
				if($Data->Approved == 1)
                {
                   array_push($data_row, 'Yes');
                }
				elseif($Data->Approved == 2)
				{
					array_push($data_row, 'Rejected');
				}
                else
                {
                  array_push($data_row, 'Pending');
                }
               
                if($Data->Visited == 0)
                {
                   array_push($data_row, 'No');
                }
                else
                {
                  array_push($data_row, 'Yes');
                }
               
                array_push($printablearray, $data_row);
                            
                }


               
                $excel->writer->setData($printablearray);
                $excel->writer->saveFile('DistrictWiseMonitoringProgressReportI' . date('Y-m-d'));
            
  }

  public function ViewWeekTimeTableLoadMonth()
  {
    $CD_ID = Input::get('CDID'); //Course Detail tale id
    $Year = Input::get('Year');
    $Batch = Input::get('Batch');
	$CalenderYear = Input::get('CalenderYear');
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
    $sql = "select DISTINCT modatecalender.Month
            from modatetask
            left join modatecalender
            on modatetask.MODateCalenderID=modatecalender.id
            where modatetask.Deleted=0
            and modatetask.Year='".$Year."'
            and modatetask.Batch like '".$Batch."'
			and modatecalender.Year = '".$CalenderYear."'
			and modatecalender.Month is not null
            and modatetask.CD_ID='".$CD_ID."'";
            $dd = DB::select(DB::raw($sql));

  return json_encode($dd);
  }

    public function LoadViewDistrictWiseMonitoringProgress()
  {
    $dateRange = Input::get('dateRange');
    $tempDateRange = explode(" - ", $dateRange);
    $tempEndDate = $tempDateRange[1][6] . $tempDateRange[1][7] . $tempDateRange[1][8] . $tempDateRange[1][9] . '-' . $tempDateRange[1][0] . $tempDateRange[1][1] . '-' . $tempDateRange[1][3] . $tempDateRange[1][4];
     $tempStartDate = $tempDateRange[0][6] . $tempDateRange[0][7] . $tempDateRange[0][8] . $tempDateRange[0][9] . '-' . $tempDateRange[0][0] . $tempDateRange[0][1] . '-' . $tempDateRange[0][3] . $tempDateRange[0][4];

    $District = Input::get('District');
    $Count = 0;
    $html='';

            $html = '
                    <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    <div class="table-header">
                    <input type="hidden" value="' . $District . '" name="DistrictID" id="DistrictID"/>
                    <input type="hidden" value="' . $tempStartDate . '" name="tempStartDate" id="tempStartDate"/>
                    <input type="hidden" value="' . $tempEndDate . '" name="tempEndDate" id="tempEndDate"/>
                    </div>
                   
          
<div class="row-fluid span12" style="margin: 0px" overflow="auto">
                    
                <h3><center>District Wise Monitoring Progress Report I<pre><h5>Date Range:"'.$tempStartDate.'" to "'.$tempEndDate.'"</h5></pre></center></h3>    
                <table id="sample-table-2" class="table table-striped table-bordered table-hover" align="center">
                    <thead>
                        <tr align="center">
                            <th align="center" class="center" rowspan="2">#</th>
                            <th align="center" class="center" rowspan="2">District</th>
							 <th align="center" class="center" rowspan="2">Center</th>
                            <th align="center" class="center" rowspan="2">Name</th>
                            <th align="center" class="center" rowspan="2">Designation</th>
                            <th align="center" class="center" colspan="2">Plan to Monitor</th>
                            <th align="center" class="center" rowspan="2">Approved</th>
							<th align="center" class="center" rowspan="2">Visited</th>
							<th align="center" class="center" rowspan="2">View Result Form</th>
                            
              
              
                        </tr>
                        <tr>
                           
                            <th align="center" class="center">Course</th>
                            <th align="center" class="center">Date</th>
                        </tr>
                    </thead>
                    <tbody>';
     $i = 1;
      if ($District == 'All') {


            $sql = "select 
  distinct mocentremonitoringplan.id,
			district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
  mocentremonitoringplan.Approved,
  mocentremonitoringplan.Visited
  from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where mocentremonitoringplan.Deleted=0
  and organisation.Deleted=0
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";

}
else
{
   $sql = "select distinct mocentremonitoringplan.id,
   district.DistrictName,
  employee.Initials,
  employee.LastName,
  employmentcode.Designation,
  organisation.OrgaName,
  organisation.Type,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  coursedetails.CourseType,
  coursedetails.Nvq,
  coursedetails.CourseLevel,
  coursedetails.Duration,
  mocentremonitoringplan.DatePlanned,
  mocentremonitoringplan.Approved,
  mocentremonitoringplan.Visited
   from mocentremonitoringplan
  left join courseyearplan
  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
  left join organisation
  on courseyearplan.OrgId=organisation.id
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join employee
  on mocentremonitoringplan.EmpId=employee.id
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  left join coursedetails
 on courseyearplan.CD_ID=coursedetails.CD_ID
  where mocentremonitoringplan.Deleted=0
  and organisation.Deleted=0
  and organisation.DistrictCode='".$District."'
  and mocentremonitoringplan.DatePlanned>='".$tempStartDate."'
  and mocentremonitoringplan.DatePlanned<='".$tempEndDate."'
  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,mocentremonitoringplan.DatePlanned";
}
           //return $sql;
            $total_rec = DB::select(DB::raw($sql));

            $Count = count($total_rec);
        

                foreach($total_rec as $ps) {
                    $html .='<tr>
                            <td>' . $i++ . '</td>
                            <td>'.$ps->DistrictName.'</td>
							<td class="center">' . $ps->OrgaName . '('.$ps->Type.')</td>
                            <td>'.$ps->Initials.' '.$ps->LastName.'</td>
                            <td>'.$ps->Designation.'</td>
                            
                            
                            <td class="center">' . $ps->CourseName . '['.$ps->CourseListCode.']-('.$ps->CourseType.' Time/'.$ps->Nvq.'-'.$ps->CourseLevel.'/Duration-'.$ps->Duration.')</td>
                            <td class="center">' . $ps->DatePlanned.'</td>';
							 if($ps->Approved == '1')
                            {
                              $html.='<td class="center"><font color="green"><i class="icon-ok bigger-130"></i></font></td>';
                            }
                            elseif($ps->Approved == '2')
                            {
                              $html.='<td class="center"><font color="red"><i class="icon-remove bigger-130"></i></font></td>';
                            }
							else{
								
								$html.='<td class="center"><font color="blue"><i class="icon-edit bigger-130"></i></font></td>';
							}
							
                            if($ps->Visited == '1')
                            {
                              $html.='<td class="center"><font color="green"><i class="icon-ok bigger-130"></i></font></td>';
                            }
                            else
                            {
                              $html.='<td class="center"><font color="red"><i class="icon-remove bigger-130"></i></font></td>';
                            }
							if($ps->Visited == '1')
							{
								$html.=' <td class="center">
                                <form id="deleteform"  action="ViewTOMonitoringFormEntered" method="GET">
                                <input type="hidden" name="id" value="'.$ps->id.'" />
                                <button type="Submit" class="btn btn-warning btn-mini"><i class="icon-eye-open icon-2x icon-only"></i></button>
                                </form>
                                </td></tr>';
							}
							else
							{
								$html.='<td class="center"></td>
                            </tr>';
							}
                            
                }
            


           
        

         $html .= " </tbody></table>"
                    . " <div class='sapn8'style='height: 50px;float: right'>
                    
                       </div></div></div>";
            return json_encode(array("Count" => $Count, "Table" => $html));

  }

  public function ViewDistrictWiseMonitoringProgress()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewDistrictWiseMProgressI');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->District = District::orderBy('DistrictName')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
    
  }


  public function PrintCoursePlanReportW()
  {
    $CD_ID = Input::get('CD_ID');
      $Batch = Input::get('Batch');
      $Year = Input::get('Year');
      $CLC = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseListCode');
      $CourseName = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseName');
      $html = '';
      $sql = "select distinct module.ModuleId,module.ModuleName,module.ModuleCode
      from modatetask
      left join motaskseq
      on modatetask.TaskSeqID=motaskseq.id
      left join module
      on motaskseq.moduleid=module.ModuleId
      where modatetask.Deleted=0
      and modatetask.Batch like '".$Batch."'
      and modatetask.Year='".$Year."'
      and modatetask.CourseListCode='".$CLC."'
      and modatetask.TaskSeqID not in('999999','999998','999997')
      order by modatetask.MODateCalenderID desc";
      $ModuleList = DB::select(DB::raw($sql));

      $html='<html>
    <head>
    <style>
    
     
  }
</style>
    </head>
    <title>Course Plan</title>
    <h2><center><b>Vocational Training Authority of Sri Lanka</b></center></h2>
    <h3><center><b>Course Plan For '.$CourseName.'('.$CLC.') - '.$Year.' Batch: '.$Batch.'</b></center></h3>';


    $sql = "select distinct modatecalender.Month
                    from modatetask
                    left join modatecalender
                    on modatetask.MODateCalenderID=modatecalender.id
                    where modatetask.Deleted=0
                    and modatetask.Batch like '".$Batch."'
                    and modatetask.Year='".$Year."'
                    and modatetask.CourseListCode='".$CLC."'";
    $months = DB::select(DB::raw($sql));

    $html.='<body><table style="width:100%;border-collapse:collapse;" border="1" >
    <thead>
                <tr>
                        <th align="center" rowspan="3">Module</th>';
    foreach($months as $m)
    {
      $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));
                             $WeekCount = count($week);
                             $FullDayCount =0;

          foreach($week as $w)
          {
              $sqld = "select  distinct modatecalender.day
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'";
                             $Days = DB::select(DB::raw($sqld));
                             $daycount = count($Days);
                             $FullDayCount = $FullDayCount + $daycount;
          }
          $html.='<th align="center"  colspan="'.$WeekCount.'">'.$m->Month.'</th>';
    }
    $html.='</tr><tr>';
    foreach($months as $m)
    {
      $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));
                             $i=1;
            foreach($week as $w)
            {
              $sqld = "select distinct modatecalender.day
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'";
                             $Days = DB::select(DB::raw($sqld));
                             $daycount = count($Days);


                    $html.='<th align="center">'.$i++.'</th>';
            }
    }
    $html.='</tr>';
    

    $html.='</thead>
                
                 <tbody>';

      foreach($ModuleList as $ML)
      {
        $html.='<tr align="center" ><td>'.$ML->ModuleCode.'</td>';
        foreach($months as $m)
        {
          $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));


                  foreach($week as $w)
                  {
                    $mailsql = "select motaskseq.id
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      left join motaskseq
                                      on modatetask.TaskSeqID=motaskseq.id
                                      where modatetask.Deleted=0
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.Batch like '".$Batch."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'
                                      and motaskseq.moduleid='".$ML->ModuleId."'
                                     ";
                         $mainSqllist = DB::select(DB::raw($mailsql));
                         $mainSqllistCount = count($mainSqllist);

                                   if($mainSqllistCount == 0)
                                   {
                                      $html.='<td align="center"></td>';
                                   }
                                   else
                                   {
                                      $html.='<td style="background-color:#FC5742"></td>';
                                   }


                  }
        }
        $html.='</tr>';
      }

      $html.='</tbody>
            </table></body></html>';

    return $html;
  }

  public function ViewCoursePlanReportW()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewCoursePlanReportW');
	$sql ="select coursedetails.*
  from coursedetails
  where coursedetails.CD_ID in(select distinct CD_ID from modatetask where modatetask.Deleted=0)
  and coursedetails.Active='Yes'
  and coursedetails.Deleted=0 order by coursedetails.CourseName";
  $lists = DB::select(DB::raw($sql));
  $view->listCode = $lists;
   // $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
    if($method == "POST")
    {
      $CD_ID = Input::get('CourseListCode');
      $Batch = Input::get('Batch');
      $Year = Input::get('Year');
      $CLC = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseListCode');

  $sql = "select distinct module.ModuleId,module.ModuleName,module.ModuleCode
  from modatetask
  left join motaskseq
  on modatetask.TaskSeqID=motaskseq.id
  left join module
  on motaskseq.moduleid=module.ModuleId
  where modatetask.Deleted=0
  and modatetask.Batch like '$Batch'
  and modatetask.Year='".$Year."'
  and modatetask.CourseListCode='".$CLC."'
  and modatetask.TaskSeqID not in('999999','999998','999997')
  order by modatetask.MODateCalenderID desc";
  $ModuleList = DB::select(DB::raw($sql));
  $view->ModuleList = $ModuleList;
  $view->CD_ID = $CD_ID;
  $view->Batchc = $Batch;
  $view->Yearc = $Year;

  return $view;
    }
  }

  public function PrintCoursePlanReport()
  {
      $CD_ID = Input::get('CD_ID');
      $Batch = Input::get('Batch');
      $Year = Input::get('Year');
      $CLC = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseListCode');
      $CourseName = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseName');
      $html = '';
      $sql = "select distinct module.ModuleId,module.ModuleName,module.ModuleCode
      from modatetask
      left join motaskseq
      on modatetask.TaskSeqID=motaskseq.id
      left join module
      on motaskseq.moduleid=module.ModuleId
      where modatetask.Deleted=0
      and modatetask.Batch like '".$Batch."'
      and modatetask.Year='".$Year."'
      and modatetask.CourseListCode='".$CLC."'
      and modatetask.TaskSeqID not in('999999','999998','999997')
      order by modatetask.MODateCalenderID desc";
      $ModuleList = DB::select(DB::raw($sql));

      $html='<html width="100%" height="100%">
    <head>
    <style>
    @page{
      size: Auto;
     
      

    }

.verticaltext{
      width:1px;
      word-wrap:break-word;
      white-space:pre-wrap;
    }
   
    </style>
    </head>
    <title>Course Plan</title>
    <h2><center><b>Vocational Training Authority of Sri Lanka</b></center></h2>
    <h3><center><b>Course Plan For '.$CourseName.'('.$CLC.') - '.$Year.' Batch: '.$Batch.'</b></center></h3>';

    $sql = "select distinct modatecalender.Month
                    from modatetask
                    left join modatecalender
                    on modatetask.MODateCalenderID=modatecalender.id
                    where modatetask.Deleted=0
                    and modatetask.Batch like '".$Batch."'
                    and modatetask.Year='".$Year."'
                    and modatetask.CourseListCode='".$CLC."'";
    $months = DB::select(DB::raw($sql));

    $html.='<body style="width:100%;height:100%"><table width="100" style="border-collapse:collapse;" border="1" >
    <thead>
                <tr>
                        <th align="center" rowspan="3">Module</th>';
    foreach($months as $m)
    {
      $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));
                             $WeekCount = count($week);
                             $FullDayCount =0;

          foreach($week as $w)
          {
              $sqld = "select  distinct modatecalender.day
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'";
                             $Days = DB::select(DB::raw($sqld));
                             $daycount = count($Days);
                             $FullDayCount = $FullDayCount + $daycount;
          }
          $html.='<th align="center"  colspan="'.$FullDayCount.'">'.$m->Month.'</th>';
    }
    $html.='</tr><tr>';
    foreach($months as $m)
    {
      $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));
                             $i=1;
            foreach($week as $w)
            {
              $sqld = "select distinct modatecalender.day
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'";
                             $Days = DB::select(DB::raw($sqld));
                             $daycount = count($Days);


                    $html.='<th align="center" colspan="'.$daycount.'">'.$i++.'</th>';
            }
    }
    $html.='</tr><tr height="100" style="vertical-align:top";>';
    foreach($months as $m)
    {
      $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));

              foreach($week as $w)
              {
                $sqld = "select distinct  modatecalender.day
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'";
                             $Days = DB::select(DB::raw($sqld));
                             $daycount = count($Days);

                      foreach($Days as $d)
                      {
                        $html.='<th align="left" class="verticaltext">'.$d->day.'</th>';
                      }
              }
    }

    $html.=' </tr>
                 </thead>
                
                 <tbody>';

      foreach($ModuleList as $ML)
      {
        $html.='<tr height="50" width="10"><td>'.$ML->ModuleCode.'</td>';
        foreach($months as $m)
        {
          $sqlw = "select distinct modatecalender.WeekNo
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'";
                             $week = DB::select(DB::raw($sqlw));


                  foreach($week as $w)
                  {
                    $sqld = "select distinct  modatecalender.day
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      where modatetask.Deleted=0
                                      and modatetask.Batch like '".$Batch."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'";
                             $Days = DB::select(DB::raw($sqld));
                             $daycount = count($Days);


                             foreach($Days as $d)
                             {
                                $mailsql = "select motaskseq.id
                                      from modatetask
                                      left join modatecalender
                                      on modatetask.MODateCalenderID=modatecalender.id
                                      left join motaskseq
                                      on modatetask.TaskSeqID=motaskseq.id
                                      where modatetask.Deleted=0
                                      and modatetask.CourseListCode='".$CLC."'
                                      and modatetask.Year='".$Year."'
                                      and modatetask.Batch like '".$Batch."'
                                      and modatecalender.Month='".$m->Month."'
                                      and modatecalender.Day='".$d->day."'
                                      and modatecalender.WeekNo='".$w->WeekNo."'
                                      and motaskseq.moduleid='".$ML->ModuleId."'
                                     ";
                         $mainSqllist = DB::select(DB::raw($mailsql));
                         $mainSqllistCount = count($mainSqllist);

                                   if($mainSqllistCount == 0)
                                   {
                                      $html.='<td align="center"></td>';
                                   }
                                   else
                                   {
                                      $html.='<td style="background-color:#FC5742"></td>';
                                   }
                             }
                  }
        }
        $html.='</tr>';
      }

      $html.='</tbody>
            </table></body></html>';

    return $html;
  }

  public function ViewCoursePlanReport()
  {
    $method = Request::getMethod();
    $view = View::make('MOCoursePlanReport.ViewCoursePlanReport');
	$sql ="select coursedetails.*
  from coursedetails
  where coursedetails.CourseListCode in(select distinct CourseListCode from modatetask where modatetask.Deleted=0)
  and coursedetails.Active='Yes'
  and coursedetails.Deleted=0 order by coursedetails.CourseName";
  $lists = DB::select(DB::raw($sql));
  $view->listCode = $lists;
    //$view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    
    if ($method == "GET") 
    {
        return $view;
    }
    if($method == "POST")
    {
      $CD_ID = Input::get('CourseListCode');
      $Batch = Input::get('Batch');
      $Year = Input::get('Year');
      $CLC = Course::where('CD_ID','=',$CD_ID)->where('Deleted','=',0)->pluck('CourseListCode');

  $sql = "select distinct module.ModuleId,module.ModuleName,module.ModuleCode
  from modatetask
  left join motaskseq
  on modatetask.TaskSeqID=motaskseq.id
  left join module
  on motaskseq.moduleid=module.ModuleId
  where modatetask.Deleted=0
  and modatetask.Batch like '".$Batch."'
  and modatetask.Year='".$Year."'
  and modatetask.CourseListCode='".$CLC."'
  and modatetask.TaskSeqID not in('999999','999998','999997')
  order by modatetask.MODateCalenderID desc";
  $ModuleList = DB::select(DB::raw($sql));
  $view->ModuleList = $ModuleList;
  $view->CD_ID = $CD_ID;
  $view->Batchc = $Batch;
  $view->Yearc = $Year;

  return $view;
    }
  }

  public function DownloadQuestionPaper()
  {
    $CenterMoniPlan = Input::get('id');
	$PaperMedium = Input::get('Medium');
    $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('CourseYearPlanID');
    $DOMoniDate = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('DatePlanned');
    $yearPlanRecored = CourseYearPlan::where('id','=',$YearPlanID)->get();
    $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
	$CD_ID = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CD_ID');
    $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
    $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');
    $centerID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('CenterID');
    $districtCode = Organisation::where('id','=',$centerID)->pluck('DistrictCode');
    $districtName = District::where('DistrictCode','=',$districtCode)->pluck('DistrictName');
    $centerName = Organisation::where('id','=',$centerID)->pluck('OrgaName');
    $CourseName = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CourseName');
    $supervisor = User::getSysUser()->EmpId; 
    $sumervisorNameInitials = Employee::where('id','=',$supervisor)->pluck('Initials');
    $sumervisorNameLastName = Employee::where('id','=',$supervisor)->pluck('LastName');
    $sumervisorNameName = Employee::where('id','=',$supervisor)->pluck('Name');
    //return $id;
	$i = 1;
    $html = '';
	
	if($PaperMedium == 'S')
	{
		 $html='<html>
    <head>
    <meta charset="UTF-8">
	<title>පුහුණු අධීක්ෂණ ප්‍රශ්න පත්‍රය</title>
    </head>
    
    <h4><center><b>ශ්‍රී ලංකා වෘත්තීය පුහුණු අධිකාරිය</b></center></h4>
    <h5><center><b>කෙටි ප්‍රශ්න පත්‍රය</b><br/><font size="1">(කාලය  පැය එකයි)</font></b></center></h5>
    
   <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
   <tr>
	<td style="width:25%">දිනය:&nbsp&nbsp'.$DOMoniDate.'</td>
	<td>මධ්‍යස්ථානය:&nbsp&nbsp'.$centerName.'</td>
	<td>පාඨමාලාව:&nbsp&nbsp'.$CourseName.'</td>
	</tr>
    <tr>
	<td style="width:25%">වර්ෂය:&nbsp&nbsp'.$year.'</td>
	<td>කණ්ඩායම:&nbsp&nbsp'.$batch.'</td>
	<td>අධීක්ෂණ නිලධාරියාගේ නම:&nbsp&nbsp'.$sumervisorNameInitials.' '.$sumervisorNameLastName.'</td>
	</tr>
	
    <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr><td style="width:25%">අභ්‍යාසලාභියාගේ නම:</td>
    <td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
    <td style="width:25%">ජා.හැ.අංකය:</td><td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
	<td style="width:25%">MIS අංකය:</td>
	<td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	</tr>
	</table>
    <hr/>
      <font size="1"><left><i>* <b>සියළුම</b> ප්‍රශ්න වලට පිළිතුරු සපයන්න.<br/>* නිවැරදි පිළිතුර <b>යටින් ඉරක් අඳින්න</b></i></left></font><br/><br/>
    
    <tbody>';
	}
	elseif($PaperMedium == 'E')
	{
		 $html='<html>
    <head>
    <meta charset="UTF-8">
	<title>MCQ Question Paper</title>
    </head>
    
    <h4><center><b>Vocational Training Authority of Sri Lanka</b></center></h4>
    <h5><center><b>MCQ Paper</b><br/><font size="1">(Duration: One hour)</font></b></center></h5>
    <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr>
	<td style="width:25%">Date:&nbsp&nbsp'.$DOMoniDate.'</td>
	<td>Centre:&nbsp&nbsp'.$centerName.'</td>
	<td>Course:&nbsp&nbsp'.$CourseName.'</td>
	</tr>
    <tr>
	<td style="width:25%">Year:&nbsp&nbsp'.$year.'</td>
	<td>Batch:&nbsp&nbsp'.$batch.'</td>
	<td>Name of the Monitoring Officer&nbsp&nbsp'.$sumervisorNameInitials.' '.$sumervisorNameLastName.'</td>
	</tr>
	<table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr><td style="width:25%">Name of the Trainee:</td>
    <td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
    <td style="width:25%">NIC Number:</td><td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
	<td style="width:25%">MIS Number:</td>
	<td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	</tr>
	</table>
    <hr/>
    <font size="1"><left><i>* Answer <b>All</b> Questions<br/>* <b>Underline</b> the Correct Answer</i></left></font>
    <tbody>
    ';
	}
	else
	{
		
		$html='<html>
    <head>
    <meta charset="UTF-8">
	<title>பல் தேர்வு வினாப்பத்திரம்</title>
    </head>
    
    <h4><center><b>இலங்கை தொழிற் பயிற்சி அதிகாரசபை</b></center></h4>
    <h5><center><b>பல் தேர்வு வினாப்பத்திரம்</b><br/><font size="1">(நேரம் : 01 மணித்தியாலம்)</font></b></center></h5>
    <table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr>
	<td style="width:25%">திகதி:&nbsp&nbsp'.$DOMoniDate.'</td>
	<td>பயிற்சி நிலையம்:&nbsp&nbsp'.$centerName.'</td>
	<td>பயிற்சிநெறி:&nbsp&nbsp'.$CourseName.'</td>
	</tr>
    <tr>
	<td style="width:25%">வருடம்:&nbsp&nbsp'.$year.'</td>
	<td>பிரிவு:&nbsp&nbsp'.$batch.'</td>
	<td>மேற்பார்வை செய்த உத்தியோகத்தரின் பெயர்:&nbsp&nbsp'.$sumervisorNameInitials.' '.$sumervisorNameLastName.'</td>
	</tr>
	<table style="width:100%;border-collapse:collapse;font-size:12px;" border="1" style="">
    <tr><td style="width:25%">பயிலுனரின் பெயர்:</td>
    <td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
    <td style="width:25%">தே.அ.அ. இல.:</td><td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>
    <tr>
	<td style="width:25%">பதிவு இல.:</td>
	<td style="width:75%">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
	</tr>
	</table>
    <hr/>
    <font size="1"><left><i>* எல்லா வினாக்களுக்கும் விடை தருக<br/>* சரியான விடையின் கீழ் கோடிடுக</i></left></font>
    <tbody>
    ';
	}
   
	
 	$sqlloadRpaper = "SELECT
     moquestions.id,
     moquestions.Question,
     motask.TaskCode
     FROM moquestions
     left join motask
	on moquestions.TaskId=motask.id
    WHERE moquestions.TaskId IN (SELECT DISTINCT
                              motask.id
                            FROM modatetask
                              LEFT JOIN motaskseq
                                ON modatetask.TaskSeqID = motaskseq.id
                              LEFT JOIN module
                                ON motaskseq.moduleid = module.ModuleId
                              LEFT JOIN motask
                                ON motaskseq.taskid = motask.id
                              LEFT JOIN modatecalender
                                ON modatetask.MODateCalenderID = modatecalender.id
                            WHERE modatetask.Deleted = 0
                            AND modatetask.Batch LIKE '".$batch."'
                            AND modatetask.Year = '".$year."'
                            AND modatetask.CD_ID = '".$CD_ID."'
                            AND modatecalender.Date < '".$DOMoniDate."'
                            AND modatetask.TaskSeqID NOT IN ('999999', '999998', '999997'))
and moquestions.Active = 1
AND moquestions.CourseListCode = '".$CD_ID."'
AND moquestions.Deleted = 0
AND moquestions.Medium = '".$PaperMedium."'
ORDER BY RAND()
LIMIT 20";
$cc = DB::select(DB::raw($sqlloadRpaper));
  foreach ($cc as $aa) {

    $html.='<table style="width:100%;border-collapse:collapse;font-size:12px;" border="0" style="">
	<tr>
	<td style="width:100%">'.$i++.') '.$aa->Question.'</td>
	</tr>
	</table>';
	
          
          //$WAnswer1 = MOQuestion::getWAnswer1($aa->id);
          //$WAnswer2 = MOQuestion::getWAnswer2($aa->id);
          //$WAnswer3 = MOQuestion::getWAnswer3($aa->id);
		  $GetAllAnswers = MOQuestion::getAllanswers($aa->id);
		  $myar = [];
		  foreach($GetAllAnswers as $g)
		  {
			  $myar[] = $g->Answer;
		  }
		  
    $html.='<table style="width:100%;border-collapse:collapse;font-size:12px;" border="0" style="">
				<tr><td style="width:25%">&nbsp&nbsp&nbsp&nbspa. '.$myar[0].'</td>
				<td style="width:25%">&nbsp&nbsp&nbsp&nbspb. '.$myar[1].'</td></tr>
				<tr><td style="width:25%">&nbsp&nbsp&nbsp&nbspc. '.$myar[2].'</td>
				<td style="width:25%">&nbsp&nbsp&nbsp&nbspd. '.$myar[3].'</td></tr>
		    
			</table><br/>'; 
          

          
  }
  if($PaperMedium == 'S')
	{
		 $html.='<p style="page-break-before: always"></p>
	<br/>
	
	<h4><center><u>නිවැරදි පිළිතුරු පත්‍රය</u></center></h4>
	<table style="width:100%;border-collapse:collapse;font-size:13px;" border="0" style="">';
	}
	elseif($PaperMedium == 'E')
	{
		 $html.='<p style="page-break-before: always"></p>
	<br/>
	
	<h4><center><u>Answer Sheet</u></center></h4>
	<table style="width:100%;border-collapse:collapse;font-size:13px;" border="0" style="">';
	}
	else{
		 $html.='<p style="page-break-before: always"></p>
	<br/>
	
	<h4><center><u>சரியான விடைப் பத்திரம்</u></center></h4>
	<table style="width:100%;border-collapse:collapse;font-size:13px;" border="0" style="">';
	}
 
	$i=1;
	foreach ($cc as $aa) {
		$CAnswer = MOQuestion::getCorrectAnswer($aa->id);
	$html.='<tr><td>'.$i++.') '.$CAnswer.'<br/><br/></td></tr>';
	}
	$html.='</table>';

$html.='</tbody></html>'; 

    return $html;

  }

  public function DeleteQuestions()
  {
    $id = Input::get('id');
    $user = User::getSysUser()->userID;
    $UpdateQuestionDelete = MOQuestion::where('id','=',$id)->update(array('Deleted' => '1','Active' => '0','User' => $user));
    $updateQAnswers = MOQuestionAnswers::where('QuestionId','=',$id)->update(array('Deleted' => '1','Active' => '0','User' => $user));
    return Redirect::to('ViewQuestions');

  }

  public function EditQuestions()
  {
    $QId = Input::get('id');
    $method = Request::getMethod();
    $view = View::make('MOQuestion.Edit')->with('user', User::getSysUser());
    $view->modules = Module::where('Deleted', '!=', 1)->orderBy('ModuleCode')->get();
    $view->tasks = Task::where('Deleted', '!=', 1)->orderBy('TaskCode')->get();
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->QID = $QId;
     $cc = DB::select(DB::raw("SELECT moquestions.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  module.ModuleName,module.ModuleCode,
  motask.TaskName,motask.TaskCode,
  moquestions.Question
  from moquestions
  left join coursedetails
  on moquestions.CourseListCode=coursedetails.CD_ID
  left join module
  on moquestions.ModuleId=module.ModuleId
  left join motask
  on moquestions.TaskId=motask.id
   where moquestions.Active=1
  and moquestions.Deleted=0
  and moquestions.id='".$QId."'"));
     $view->cc = $cc;
    if ($method == "GET") 
    {
        return $view;
    }
     if ($method == "POST") 
    {
        $id = Input::get('id');
        $user = User::getSysUser()->userID;
        $QSinhala = Input::get('QSinhala');
        $Canswer = Input::get('Canswer');
        $Wanswer1 = Input::get('Wanswer1');
        $Wanswer2 = Input::get('Wanswer2');
        $Wanswer3 = Input::get('Wanswer3');

        $updateQuestion = MOQuestion::where('id','=',$id)->update(array('Question' => $QSinhala,'CorrectAnswerValue' => $Canswer,'User' => $user));
        $updateCAnswer = MOQuestionAnswers::where('QuestionId','=',$id)->where('Order','=',1)->where('AnswerType','=','C')->update(array('Answer' => $Canswer,'User' => $user));
        $updateWAnswer1 = MOQuestionAnswers::where('QuestionId','=',$id)->where('Order','=',2)->where('AnswerType','=','W')->update(array('Answer' => $Wanswer1,'User' => $user));
        $updateWAnswer2 = MOQuestionAnswers::where('QuestionId','=',$id)->where('Order','=',3)->where('AnswerType','=','W')->update(array('Answer' => $Wanswer2,'User' => $user));
        $updateWAnswer3 = MOQuestionAnswers::where('QuestionId','=',$id)->where('Order','=',4)->where('AnswerType','=','W')->update(array('Answer' => $Wanswer3,'User' => $user));
        return Redirect::to('ViewQuestions');
    }
  }

  public function LoadQuestionModuleTask()
  {
    $ModuleID = Input::get('ModuleId');
    $CD_ID = Input::get('CD_ID');
    /* $sql = "select motask.id,motask.TaskName,motask.TaskCode
            from momoduletask
            left join motask
            on momoduletask.taskid=motask.id
            where momoduletask.deleted='0'
            and momoduletask.moduleid='".$ModuleID."'
            and momoduletask.courseid='".$CD_ID."'
            and motask.deleted='0'"; */
			$sql = "select DISTINCT motask.id,motask.TaskName,motask.TaskCode
				  from motaskseq
				  left join module
				  on motaskseq.moduleid=module.ModuleId
				  left join motask
				  on motaskseq.taskid=motask.id
				  where motaskseq.deleted=0
				  and motaskseq.courseid='".$CD_ID."'
				  and motaskseq.moduleid='".$ModuleID."'
				  and module.Deleted=0
				  and module.Active=1
				  and motask.deleted=0
				  ORDER by motask.TaskCode";
    $Data = DB::select(DB::raw($sql));
    return $Data;
  }

  public function LoadQuestionModuleCourse()
  {
    $CD_ID = Input::get('CourseListCode');
  /*   $sql = "select module.ModuleId,module.ModuleName,module.ModuleCode
            from modulecourse
            left join module
            on modulecourse.ModuleId=module.ModuleId
            where modulecourse.CourseListCode='".$CD_ID."'
            and modulecourse.Deleted='0'
            and module.Active='1'
            order by module.ModuleCode"; */
			$sql = "select DISTINCT module.ModuleId,module.ModuleName,module.ModuleCode
					  from motaskseq
					  left join module
					  on motaskseq.moduleid=module.ModuleId
					  where motaskseq.deleted=0
					  and motaskseq.courseid='".$CD_ID."'
					  and module.Deleted=0
					  and module.Active=1
					  order by module.ModuleCode";
    $Data = DB::select(DB::raw($sql));
    return $Data;
  }
public function QuestionBankSaveAll()
{
	      $CD_ID = Input::get('CD_ID');
          $ModuleID = Input::get('ModuleID');
          $TaskID = Input::get('T_Code');
          $QSinhala = Input::get('QSinhala');
          $Canswer = Input::get('Canswer');
          $Wanswer1 = Input::get('Wanswer1');
          $Wanswer2 = Input::get('Wanswer2');
          $Wanswer3 = Input::get('Wanswer3');
		  $Medium = Input::get('Medium');
          $user = User::getSysUser()->userID;
		  $c = new MOQuestion();
          $c->CourseListCode = $CD_ID;
          $c->ModuleId = $ModuleID;
          $c->TaskId = $TaskID;
          $c->Question = $QSinhala;
		   $c->Medium = $Medium;
          $c->CorrectAnswerValue = $Canswer;
          $c->Active = 1;
          $c->User = $user;
          $c->save();

          $getQuestionID = MOQuestion::where('Deleted','=',0)->where('Question','=',$QSinhala)->max('id');

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Canswer;
          $d->AnswerType = 'C';
          $d->Order = 1;
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Wanswer1;
          $d->Order = 2;
          $d->AnswerType = 'W';
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Wanswer2;
          $d->Order = 3;
          $d->AnswerType = 'W';
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Wanswer3;
          $d->AnswerType = 'W';
          $d->Order = 4;
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $GetCorrectAnsID = MOQuestionAnswers::where('QuestionId','=',$getQuestionID)->where('AnswerType','=','C')->where('Deleted','=',0)->pluck('id');
          $UpdateMOQuestionCansID = MOQuestion::where('id','=',$getQuestionID)->update(array('CorrectAnswerID' => $GetCorrectAnsID)); 
		   $html =  '<font color="blue"><b>"'.$QSinhala.'" Question Added Succsessfully!!!</b></font>';
		    $json = array("done" => $html);
            return json_encode($json, 0);
}
  public function CreateQuestions()
  {
        $method = Request::getMethod();
        $view = View::make('MOQuestion.Create')->with('user', User::getSysUser());
        $view->modules = Module::where('Deleted', '!=', 1)->orderBy('ModuleCode')->get();
        $view->tasks = Task::where('Deleted', '!=', 1)->orderBy('TaskCode')->get();
        $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
        if ($method == "GET") {
            return $view;
        }
        if($method == "POST")
        {
          $CD_ID = Input::get('CourseListCode');
          $ModuleID = Input::get('ModuleID');
          $TaskID = Input::get('T_Code');
          $QSinhala = Input::get('QSinhala');
          $Canswer = Input::get('Canswer');
          $Wanswer1 = Input::get('Wanswer1');
          $Wanswer2 = Input::get('Wanswer2');
          $Wanswer3 = Input::get('Wanswer3');
		  $Medium = Input::get('Medium');
          $user = User::getSysUser()->userID;

          $c = new MOQuestion();
          $c->CourseListCode = $CD_ID;
          $c->ModuleId = $ModuleID;
          $c->TaskId = $TaskID;
          $c->Question = $QSinhala;
		   $c->Medium = $Medium;
          $c->CorrectAnswerValue = $Canswer;
          $c->Active = 1;
          $c->User = $user;
          $c->save();

          $getQuestionID = MOQuestion::where('Deleted','=',0)->where('Question','=',$QSinhala)->max('id');

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Canswer;
          $d->AnswerType = 'C';
          $d->Order = 1;
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Wanswer1;
          $d->Order = 2;
          $d->AnswerType = 'W';
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Wanswer2;
          $d->Order = 3;
          $d->AnswerType = 'W';
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $d = new MOQuestionAnswers();
          $d->QuestionId = $getQuestionID;
          $d->Answer =$Wanswer3;
          $d->AnswerType = 'W';
          $d->Order = 4;
          $d->Active = 1;
          $d->User = $user;
          $d->save();

          $GetCorrectAnsID = MOQuestionAnswers::where('QuestionId','=',$getQuestionID)->where('AnswerType','=','C')->where('Deleted','=',0)->pluck('id');
         $UpdateMOQuestionCansID = MOQuestion::where('id','=',$getQuestionID)->update(array('CorrectAnswerID' => $GetCorrectAnsID));

        return Redirect::to('CreateQuestions')->with("done", true);
          
        }
  }
  public function SearchQuestions()
  {
	  $CD_ID = Input::get('CourseListCode');
      $ModuleID = Input::get('ModuleID');
      $TaskID = Input::get('T_Code');
	  
	  $view = View::make('MOQuestion.View');
  
    $method=Request::getMethod();
	
	if($ModuleID !='All' && $TaskID =='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  module.ModuleName,module.ModuleCode,
  motask.TaskName,motask.TaskCode,
  moquestions.Question
  from moquestions
  left join coursedetails
  on moquestions.CourseListCode=coursedetails.CD_ID
  left join module
  on moquestions.ModuleId=module.ModuleId
  left join motask
  on moquestions.TaskId=motask.id
   where moquestions.Active=1
   and moquestions.CourseListCode='".$CD_ID."'
   and moquestions.ModuleId = '".$ModuleID."'
  and moquestions.Deleted=0")); 
	}
	elseif($ModuleID !='All' && $TaskID !='All')
	{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  module.ModuleName,module.ModuleCode,
  motask.TaskName,motask.TaskCode,
  moquestions.Question
  from moquestions
  left join coursedetails
  on moquestions.CourseListCode=coursedetails.CD_ID
  left join module
  on moquestions.ModuleId=module.ModuleId
  left join motask
  on moquestions.TaskId=motask.id
   where moquestions.Active=1
   and moquestions.CourseListCode='".$CD_ID."'
   and moquestions.ModuleId = '".$ModuleID."'
   and moquestions.TaskId='".$TaskID."'
  and moquestions.Deleted=0")); 
	}
	else{
		$cc = DB::select(DB::raw("SELECT moquestions.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  module.ModuleName,module.ModuleCode,
  motask.TaskName,motask.TaskCode,
  moquestions.Question
  from moquestions
  left join coursedetails
  on moquestions.CourseListCode=coursedetails.CD_ID
  left join module
  on moquestions.ModuleId=module.ModuleId
  left join motask
  on moquestions.TaskId=motask.id
   where moquestions.Active=1
   and moquestions.CourseListCode='".$CD_ID."'
   and moquestions.Deleted=0")); 
	}
  /*  $cc = DB::select(DB::raw("SELECT moquestions.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  module.ModuleName,module.ModuleCode,
  motask.TaskName,motask.TaskCode,
  moquestions.Question
  from moquestions
  left join coursedetails
  on moquestions.CourseListCode=coursedetails.CD_ID
  left join module
  on moquestions.ModuleId=module.ModuleId
  left join motask
  on moquestions.TaskId=motask.id
   where moquestions.Active=1
   and moquestions.CourseListCode='".$CD_ID."'
   and moquestions.ModuleId = '".$ModuleID."'
   and moquestions.TaskId='".$TaskID."'
  and moquestions.Deleted=0"));  */
  
  $sql = "select DISTINCT module.ModuleId,module.ModuleName,module.ModuleCode
					  from motaskseq
					  left join module
					  on motaskseq.moduleid=module.ModuleId
					  where motaskseq.deleted=0
					  and motaskseq.courseid='".$CD_ID."'
					  and module.Deleted=0
					  and module.Active=1
					  order by module.ModuleCode";
    $ModuleData = DB::select(DB::raw($sql));
	
	$sql = "select DISTINCT motask.id,motask.TaskName,motask.TaskCode
				  from motaskseq
				  left join module
				  on motaskseq.moduleid=module.ModuleId
				  left join motask
				  on motaskseq.taskid=motask.id
				  where motaskseq.deleted=0
				  and motaskseq.courseid='".$CD_ID."'
				  and motaskseq.moduleid='".$ModuleID."'
				  and module.Deleted=0
				  and module.Active=1
				  and motask.deleted=0
				  ORDER by motask.TaskCode";
    $TaskData = DB::select(DB::raw($sql));
	  $view->modules = $ModuleData;
	  $view->tasks = $TaskData;
	  $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
	  $view->CLCS = $CD_ID;
	  $view->MIDS = $ModuleID;
	  $view->TIDS = $TaskID;
	  $view->moduleTask =  $cc; 
   return $view;
	  
	  
  }

  public function ViewQuestions()
  {
    $view = View::make('MOQuestion.View');
    $courses = MOCriteria::where('Deleted','=',0)->orderBy('CategoryId')->get();
    //$view->moduleTask = $courses;
    $method=Request::getMethod();
    /* $cc = DB::select(DB::raw("SELECT moquestions.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  module.ModuleName,module.ModuleCode,
  motask.TaskName,motask.TaskCode,
  moquestions.Question
  from moquestions
  left join coursedetails
  on moquestions.CourseListCode=coursedetails.CD_ID
  left join module
  on moquestions.ModuleId=module.ModuleId
  left join motask
  on moquestions.TaskId=motask.id
  where moquestions.Active=1
  and moquestions.Deleted=0")); */
  $view->modules = Module::where('Deleted', '!=', 1)->orderBy('ModuleCode')->get();
  $view->tasks = Task::where('Deleted', '!=', 1)->orderBy('TaskCode')->get();
  $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    //$view->moduleTask =  $cc; 
  $view->CLCS = '';
  $view->MIDS = '';
  $view->TIDS = '';
    if($method == 'GET')
    {
      return $view;
    }
  }

  public function PrintTOMonitoringFormEntered()
  {
    $CenterMoniPlan = Input::get('CenterMoniPlan');
	$DOMoniDate = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('DatePlanned');
	//version update
	/* $VersionUpdate = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
										  from mocoursemonitoringversion
										  where mocoursemonitoringversion.StartDate<='".$DOMoniDate."'
										  and mocoursemonitoringversion.Active=1
										  and mocoursemonitoringversion.Deleted=0
										  ORDER by mocoursemonitoringversion.StartDate DESC
										  limit 1"));
	$newdataVer =  json_decode(json_encode((array)$VersionUpdate),true);
    $VersionID = $newdataVer[0]["vid"]; */
	$VersionID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('VersionID');
	//version update
    $html = '';
    //return $CMPID;
    $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('CourseYearPlanID');
    
	$DOMoniDateActual = MOMonitoringResult::where('CMPlanID','=',$CenterMoniPlan)->pluck('MonitoringDate');
    $yearPlanRecored = CourseYearPlan::where('id','=',$YearPlanID)->get();
    $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
    $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
    $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');
    $FcomPercentage = MOMonitoringTimeTableProgressResult::where('CenterMoPlanID','=',$CenterMoniPlan)->pluck('AchivedPercentage');
    $FNotcomPercentage = (100-$FcomPercentage);
    ////////////////////////////////////
    $centerID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('CenterID');
    $districtCode = Organisation::where('id','=',$centerID)->pluck('DistrictCode');
    $districtName = District::where('DistrictCode','=',$districtCode)->pluck('DistrictName');
    $centerName = Organisation::where('id','=',$centerID)->pluck('OrgaName');
    $DOMoniDate = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('DatePlanned');
    $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('CourseYearPlanID');
    $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
    $CourseName = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CourseName');
    //$InstructorName = CourseYearPlan::where('id','=',$YearPlanID)->pluck('InstructorName');
	$ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
			from moinstructorcourse
			left join moinstructor
			on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$YearPlanID."'
						  and moinstructorcourse.Active='Yes'";
    $InstructorName =DB::select(DB::raw($ppp));
    $Duration = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('Duration');
    $NVQL = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CourseLevel');
    $StartDate = CourseYearPlan::where('id','=',$YearPlanID)->pluck('RealstartDate');
    $duration = substr( $Duration, 0, -2);
    $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
    $newdu = DB::select(DB::raw($sql78));
    $newdata =  json_decode(json_encode((array)$newdu),true);
	$YearCYID = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
	if($YearCYID == '2020')
	{
		$expectedcom = CourseYearPlan::where('id','=',$YearPlanID)->pluck('RealEndDate');
	}
	else
	{
		$expectedcom = $newdata[0]["dd"];
	}
   
	
    $TCount = CourseYearPlan::where('id','=',$YearPlanID)->pluck('NoOfTrainees');
    $DCount = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Dropout');
    $TcountonMonitoringdate = MOMonitoringResult::where('CMPlanID','=',$CenterMoniPlan)->pluck('TraineeCountMDate');
    $Category = MOCriteriaCategory::where('Active','=',1)->where('Deleted','=',0)->where('VersionID','=',$VersionID)->orderBy('Order')->get();
    $supervisor = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlan)->pluck('EmpId');  
    $sumervisorNameInitials = Employee::where('id','=',$supervisor)->pluck('Initials');
    $sumervisorNameLastName = Employee::where('id','=',$supervisor)->pluck('LastName');
    $sumervisorNameName = Employee::where('id','=',$supervisor)->pluck('Name');
    $EMPCODEID = Employee::where('id','=',$supervisor)->pluck('CurrentDesignation');
    $Designation = EmploymentCode::where('id','=',$EMPCODEID)->pluck('Designation');
    $UserOrgaID = Employee::where('id','=',$supervisor)->pluck('CurrentOrgaID');
    $OrganisationName = Organisation::where('id','=',$UserOrgaID)->pluck('OrgaName');

    $FTmatkC = 0;
    $ATmarkC = 0;
    $FTotal = 0;
    $ATotal = 0;

    $html = '<html
    <head>
    <style>
    
    </style>
      <meta charset="UTF-8">
	   <title>පුහුණු අධීක්ෂණ වාර්ථාව</title>
    </head>
    <H4><Center><u>පුහුණු අධීක්ෂණ වාර්ථාව</u></center></H4>
   
   
    <table cellspacing="6" align="center">
      <tr><td>දිස්ත්‍රික්කය</td> <td>'.$districtName.'</td> <td>පාඨමාලා කාල සීමාව </td><td>'.$StartDate.' - '.$expectedcom.'</td></tr>
      <tr><td>මධ්‍යස්ථානය</td><td>'.$centerName.'</td><td>උපදේශකවරයාගේ නම</td><td>';
	   foreach($InstructorName as $i)
	   {
						$html.='<span>'.$i->Name.'('.$i->EPFNo.')</span></br>';
	   }			
	  $html.='</td></tr>
      <tr><td>පාඨමාලාව</td><td>'.$CourseName.'</td><td>ලියාපදිංචි ශිෂ්‍ය සංඛ්‍යාව</td><td>'.$TCount.'</td></tr>
      <tr><td>NVQ  සුදුසුකම</td><td>'.$NVQL.'</td><td>අධීක්ෂණ දින ශිෂ්‍ය සංඛාව</td><td>'.$TcountonMonitoringdate.'</td></tr>
      <tr><td>පාඨමාලා කාලය</td><td>'.$Duration.'</td><td></td></tr>
    </table>
    <hr/>
    <table  align="center" border=1  cellpadding="5" cellspacing=0 style="border-collapse:collapse;">';
	
	$RR = 1;
    foreach($Category as $c)
     {         
        $GetAllCriterias = MOCriteria::where('CategoryId','=',$c->id)->where('Active','=',1)->where('Deleted','=',0)->orderBy('Order')->get();
            $html.='
                          <tr id="d0" style="background-color:#CC9999">
                              <td><b><font color="black">'.$RR++.' '.$c->TypeInSinhala.'<br>'.$c->TypeInEnglish.'</font></b></td>
                              <td class="center"><b><font color="black">මුළු ලකුණු </font></b></td>
                              <td class="center"><b><font color="black">ලැබු ලකුණු</font></b></td>
                            </tr>
                            
                     ';
                               
          $FTmatkC =  0;
          $ATmarkC = 0;
                              
                           
                foreach($GetAllCriterias as $g)
                {

                    $sql = "select moclasscriteriaweight.id,moclasscriteriaweight.Weight,moclass.PercentageGap
                            from moclasscriteriaweight
                            left join moclass
                            on moclasscriteriaweight.ClassId=moclass.id
                            where moclasscriteriaweight.Deleted=0
                            and moclasscriteriaweight.CriteriaId='".$g->id."'";
                    $getClassweight = DB::select(DB::raw($sql));

                                $html.='<tr>
                                    <input type="hidden" name="SubQCetagoryID[]" id="SubQCetagoryID[]" value="'.$g->id.'">
                                    <td >'.$g->CriteriaNameInSinhala.'<br/>'.$g->CriteriaNameInEnglish.'</td>
                                    <td class="center">'.$g->FullWeight.'</td>';
                                 
                                    $getMark = MOMonitoring::where('CMPlanid','=',$CenterMoniPlan)->where('CriteriaID','=',$g->id)->pluck('Mark');
                                   
                                    $html.='<td class="center">'.$getMark.'</td></tr>';

                                   
                                    $FTmatkC =  $FTmatkC + $g->FullWeight;
                                    $ATmarkC = $ATmarkC + $getMark;
                                    
                                    
                }
                                
                  $FTotal = $FTotal + $FTmatkC;
                  $ATotal = $ATotal + $ATmarkC;

                                    
              $html.='<tr>
                                    
                        <td class="center"><b><font color="green"><center>එකතුව</center></font></b></td>
                        <td class="center"><b><font color="green">'.$FTmatkC.'</font></b></td>
                        <td class="center"><b><font color="green">'.$ATmarkC.'</font></b></td>
                                
                      </tr>';
                               
                           
    }
             
      $html.='<tr>
                            
                            <td class="center"><b><font color="red"><center>මුළු එකතුව</center></font></b></td>
                            <td class="center"><b><font color="red">'.$FTotal.'</font></b></td>
                            <td class="center"><b><font color="red">'.$ATotal.'</font></b></td>

              </tr>
              <tr>
                            
                            <td class="center"><b><font color="red"><center>අධීක්ෂණ කළ දිනට කාලසටහන ක්‍රියාත්මක කිරීම</center></font></b></td>
                            <td class="center"><b><font color="red">100%</font></b></td>
                            <td class="center"><b><font color="red">'.$FcomPercentage.'%</font></b></td>

              </tr>

             
             </table>
             <br/>
             <table cellspacing="10" >
    <tr><td>අධීක්ෂණ නිලධාරියාගේ නම</td><td>'.$sumervisorNameInitials.' '.$sumervisorNameName.' '.$sumervisorNameLastName.'</td></tr>
    <tr><td>අධීක්ෂණ නිලධාරියාගේ තනතුර</td><td>'.$Designation.'</td></tr>
    <tr><td>අධීක්ෂණ නිලධාරියාගේ මධ්‍යස්ථානය</td><td>'.$OrganisationName.'</td></tr>
    <tr><td>අධීක්ෂණ කල දිනය</td><td>'.$DOMoniDateActual.'</td></tr>
   
    </table>
	<p style="page-break-before: always"></p>
	<br/>
	
	<h4><u>විශේෂ සටහන් (Other Comments & Reasons for Time Table Progress Delays)</u></h4><p style="text-align: justify;">';
	
	$getDreasonss = MOMonitoringResult::where('CMPlanid','=',$CenterMoniPlan)->where('Deleted','=',0)->pluck('Dreason');
	
	
	$html.=''.$getDreasonss.'</p>

    <body></html>';

    return $html;
  }

  public function ViewTOMonitoringFormEntered()
  {
    $CMPID = Input::get('id');
	 $DOMoniDate = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('DatePlanned');
	//version update
	/* $VersionUpdate = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
										  from mocoursemonitoringversion
										  where mocoursemonitoringversion.StartDate<='".$DOMoniDate."'
										  and mocoursemonitoringversion.Active=1
										  and mocoursemonitoringversion.Deleted=0
										  ORDER by mocoursemonitoringversion.StartDate DESC
										  limit 1"));
	$newdataVer =  json_decode(json_encode((array)$VersionUpdate),true);
    $VersionID = $newdataVer[0]["vid"]; */
	$VersionID = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('VersionID');
	//version update
    $view = View::make('MOMonitor.TOView');
    $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('CourseYearPlanID');
   
    $yearPlanRecored = CourseYearPlan::where('id','=',$YearPlanID)->get();
    $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
    $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
    $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');
    $FcomPercentage = MOMonitoringTimeTableProgressResult::where('CenterMoPlanID','=',$CMPID)->pluck('AchivedPercentage');
    $FNotcomPercentage = (100-$FcomPercentage);
    $view->FcomPercentage = $FcomPercentage;
    $view->FNotcomPercentage = $FNotcomPercentage;
    
    $view->CenterMoniPlan = $CMPID;
    $sql = "select modatetask.id,
    modatetask.TaskSeqID,
    modatecalender.Date,
    modatecalender.Session,
    motask.TaskName,
    motask.TaskCode,
    module.ModuleName,
    module.ModuleCode
  from modatetask
  left join modatecalender
  on modatetask.MODateCalenderID=modatecalender.id
  left join motaskseq
  on modatetask.TaskSeqID=motaskseq.id
  left join motask
  on motaskseq.taskid=motask.id
  left join module
  on motaskseq.moduleid=module.ModuleId
  where modatetask.Deleted=0
  and modatetask.Year='".$year."'
  and modatetask.Batch like '".$batch."'
  and modatetask.CourseListCode='".$CourseListCode."'
  and modatecalender.Date<='".$DOMoniDate."'";

  $timeTableList = DB::select(DB::raw($sql));

  $view->TimeTablePro = $timeTableList;

    $method=Request::getMethod();
    $Category = MOCriteriaCategory::where('Active','=',1)->where('Deleted','=',0)->where('VersionID','=',$VersionID)->orderBy('Order')->get();
    $view->Category = $Category;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          return $view;
        }
  }

  public function EditTOMonitoringFormEntered()
  {
    $CMPID = Input::get('id');
	$DOMoniDate = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('DatePlanned');
	//version update
	/* $VersionUpdate = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
										  from mocoursemonitoringversion
										  where mocoursemonitoringversion.StartDate<='".$DOMoniDate."'
										  and mocoursemonitoringversion.Active=1
										  and mocoursemonitoringversion.Deleted=0
										  ORDER by mocoursemonitoringversion.StartDate DESC
										  limit 1"));
	$newdataVer =  json_decode(json_encode((array)$VersionUpdate),true); */
  /*   $VersionID = $newdataVer[0]["vid"]; */
	$VersionID = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('VersionID');
	//version update
    $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('CourseYearPlanID');
    
    $yearPlanRecored = CourseYearPlan::where('id','=',$YearPlanID)->get();
    $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
    $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
    $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');
    $view = View::make('MOMonitor.TOEdit');
    $view->CenterMoniPlan = $CMPID;
    $sql = "select modatetask.id,
    modatetask.TaskSeqID,
    modatecalender.Date,
    modatecalender.Session,
    motask.TaskName,
    motask.TaskCode,
    module.ModuleName,
    module.ModuleCode
    from modatetask
    left join modatecalender
    on modatetask.MODateCalenderID=modatecalender.id
    left join motaskseq
    on modatetask.TaskSeqID=motaskseq.id
    left join motask
    on motaskseq.taskid=motask.id
    left join module
    on motaskseq.moduleid=module.ModuleId
    where modatetask.Deleted=0
    and modatetask.Year='".$year."'
    and modatetask.Batch like '".$batch."'
    and modatetask.CourseListCode='".$CourseListCode."'
    and modatecalender.Date<='".$DOMoniDate."'";

  $timeTableList = DB::select(DB::raw($sql));

  $view->TimeTablePro = $timeTableList;

    $method=Request::getMethod();
    $Category = MOCriteriaCategory::where('Active','=',1)->where('Deleted','=',0)->where('VersionID','=',$VersionID)->orderBy('Order')->get();

    $view->Category = $Category;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
           $CenterMoniPlanID = Input::get('CenterMoniPlan');
		   $DateSupervised = Input::get('DateS');
		   //version control start
		  /*  $VersionUpdate = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
										  from mocoursemonitoringversion
										  where mocoursemonitoringversion.StartDate<='".$DateSupervised."'
										  and mocoursemonitoringversion.Active=1
										  and mocoursemonitoringversion.Deleted=0
										  ORDER by mocoursemonitoringversion.StartDate DESC
										  limit 1"));
			$newdataVer =  json_decode(json_encode((array)$VersionUpdate),true);
			$VersionID = $newdataVer[0]["vid"]; */
			$VersionID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->pluck('VersionID');
		    //$updatemocenterplanwithversion = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->update(array('VersionID' => $VersionID));
			//version control end
           $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->pluck('CourseYearPlanID');
           $centerID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->pluck('CenterID');
           $TraineeCountOnthemonitoringday = Input::get('MCount');
           
		   $Dreason = Input::get('Dreason');
           $SubQCetagoryID = Input::get('SubQCetagoryID');
           $AnswerClassWeight = Input::get('AnswerClassWeight');
           $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
           $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
           $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');
           $k = 0;

           //Clear data tables
           $deletemonitoringTable = MOMonitoring::where('CMPlanid','=',$CenterMoniPlanID)->delete();
           $deleteMonitoringResultTable = MOMonitoringResult::where('CMPlanID','=',$CenterMoniPlanID)->delete();
           $deleteMonitoringtimetableprogrestable = MOMonitoringTimeTableProgress::where('CenterMoPlanID','=',$CenterMoniPlanID)->delete();
           $deleteMonitoringtimetableprogressresulttable = MOMonitoringTimeTableProgressResult::where('CenterMoPlanID','=',$CenterMoniPlanID)->delete();

           //time table progress
          $allModatetaskIDs = Input::get('ModateTaskIDs'); //condiser as 100% - 16
          $checkedModtateList = Input::get('trainee_ids');

          $countallModatetaskIDs = count($allModatetaskIDs);
          $countcheckedModtateList = count($checkedModtateList);

          for($k=0;$k<$countallModatetaskIDs;$k++)
          {

            $UniqmodatetaskID = $allModatetaskIDs[$k];
            if(in_array($UniqmodatetaskID, $checkedModtateList))
            {
              $f = new MOMonitoringTimeTableProgress();
              $f->CenterMoPlanID = $CenterMoniPlanID;
              $f->YearPlanID = $YearPlanID;
              $f->CourseListCode = $CourseListCode;
              $f->Batch = $batch;
              $f->Year = $year;
              $f->MoDateTaskID = $UniqmodatetaskID;
              $f->Checked = 1;
              $f->User = User::getSysUser()->userID;
              $f->save(); 

            }
            else
            {
              
              $f = new MOMonitoringTimeTableProgress();
              $f->CenterMoPlanID = $CenterMoniPlanID;
              $f->YearPlanID = $YearPlanID;
              $f->CourseListCode = $CourseListCode;
              $f->Batch = $batch;
              $f->Year = $year;
              $f->MoDateTaskID = $UniqmodatetaskID;
              $f->Checked = 0;
              $f->User = User::getSysUser()->userID;
              $f->save(); 
            }
          }

         if($countallModatetaskIDs != 0 && $countcheckedModtateList != 0)
	{
          $AchivedPrecentage = round(($countcheckedModtateList/$countallModatetaskIDs)*100,2);
	}
	else{
		$AchivedPrecentage = '0.00';
	}

          $r = new MOMonitoringTimeTableProgressResult();
          $r->CenterMoPlanID = $CenterMoniPlanID;
          $r->YearPlanID = $YearPlanID;
          $r->CourseListCode = $CourseListCode;
          $r->Year = $year;
          $r->Batch = $batch;
          $r->FullMoDateTaskCount = $countallModatetaskIDs;
          $r->CompletedMoDateTaskCount = $countcheckedModtateList;
          $r->AchivedPercentage = $AchivedPrecentage;
          $r->User = User::getSysUser()->userID;
          $r->save();



          //time table progress
           $CountSubcategory = count($SubQCetagoryID);
           $i = 0;
           $FinalMark = 0;
           for($i=0;$i<$CountSubcategory;$i++)
           {
              $IndividualCriteriaID = $SubQCetagoryID[$i];
              $getCalType = MOCriteria::where('id','=',$IndividualCriteriaID)->pluck('CalculationType');

              if($getCalType == 'P')
              {
                $ClassWeghtID = $AnswerClassWeight[$i];
                $mark = MOClassCriteriaWeight::where('id','=',$ClassWeghtID)->pluck('Weight');
                $c = new MOMonitoring();
                $c->CMPlanid = $CenterMoniPlanID;
                $c->CriteriaID = $IndividualCriteriaID;
                $c->ClassWeightId = $ClassWeghtID;
                $c->Mark = $mark;
                $c->ClassWeightType = $getCalType;
                $c->CenterID = $centerID;
                $c->YearPlanID = $YearPlanID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              elseif($getCalType == 'YN')
              {
                $WeightValue = $AnswerClassWeight[$i];
                if($WeightValue == 'Yes')
                {
                  $mark = MOClassCriteriaWeight::where('CriteriaId','=',$IndividualCriteriaID)->where('Deleted','=',0)->pluck('Weight');
                  $ClassWeghtID = MOClassCriteriaWeight::where('CriteriaId','=',$IndividualCriteriaID)->where('Deleted','=',0)->pluck('id');

                }
                else
                {
                  $mark = 0;
                  $ClassWeghtID = 0;
                }
                $c = new MOMonitoring();
                $c->CMPlanid = $CenterMoniPlanID;
                $c->CriteriaID = $IndividualCriteriaID;
                $c->ClassWeightId = $ClassWeghtID;
                $c->Mark = $mark;
                $c->ClassWeightType = $getCalType;
                $c->CenterID = $centerID;
                $c->YearPlanID = $YearPlanID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;

              }
              else
              {
                $c = new MOMonitoring();
                $c->CMPlanid = $CenterMoniPlanID;
                $c->CriteriaID = $IndividualCriteriaID;
                $c->ClassWeightId = 999999;
                $c->Mark = $AnswerClassWeight[$i];
                $c->ClassWeightType = $getCalType;
                $c->CenterID = $centerID;
                $c->YearPlanID = $YearPlanID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;
              }
           }

            $d = new MOMonitoringResult();
            $d->CMPlanID = $CenterMoniPlanID;
            $d->CenterID = $centerID;
            $d->YearPlanID = $YearPlanID;
            $d->FullMark = $FinalMark;
			$d->Dreason = $Dreason;
            $d->CourseDeliveryMark = $AchivedPrecentage;
            $d->TraineeCountMDate = $TraineeCountOnthemonitoringday;
            $d->MonitoringDate = $DateSupervised;
            $d->User = User::getSysUser()->userID;
            $d->save();


            $updateCMPlanTable = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->update(array('Visited' => '1','DatePlanned' => $DateSupervised));
           // return $view;
            return Redirect::to('DoMonitor');
        }
  }

  public function LoadMonitoringForm()
  {
    $CMPID = Input::get('id');
    $view = View::make('MOMonitor.TOCreate');
    $view->CenterMoniPlan = $CMPID;
	$DOMoniDate = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('DatePlanned');
	 //version update
	 $VersionUpdate = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
										  from mocoursemonitoringversion
										  where mocoursemonitoringversion.StartDate<='".$DOMoniDate."'
										  and mocoursemonitoringversion.Active=1
										  and mocoursemonitoringversion.Deleted=0
										  ORDER by mocoursemonitoringversion.StartDate DESC
										  limit 1"));
	$newdataVer =  json_decode(json_encode((array)$VersionUpdate),true);
    $VersionID = $newdataVer[0]["vid"]; 
	$UpdateVersionID = MOCenterMonitoringPlan::where('id','=',$CMPID)->update(array('VersionID' => $VersionID));
	$VersionID = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('VersionID');
	//version update
    $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CMPID)->pluck('CourseYearPlanID');
   
    $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
    $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
    $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');
    $method=Request::getMethod();
    $Category = MOCriteriaCategory::where('Active','=',1)->where('Deleted','=',0)->where('VersionID','=',$VersionID)->orderBy('Order')->get();
    $sql = "select modatetask.id,
    modatetask.TaskSeqID,
    modatecalender.Date,
    modatecalender.Session,
    motask.TaskName,
    motask.TaskCode,
    module.ModuleName,
    module.ModuleCode
    from modatetask
    left join modatecalender
    on modatetask.MODateCalenderID=modatecalender.id
    left join motaskseq
    on modatetask.TaskSeqID=motaskseq.id
    left join motask
    on motaskseq.taskid=motask.id
    left join module
    on motaskseq.moduleid=module.ModuleId
    where modatetask.Deleted=0
    and modatetask.Year='".$year."'
    and modatetask.Batch like '".$batch."'
    and modatetask.CourseListCode='".$CourseListCode."'
    and modatecalender.Date<='".$DOMoniDate."'";

  $timeTableList = DB::select(DB::raw($sql));

  $view->TimeTablePro = $timeTableList;
    $view->Category = $Category;
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {

           $CenterMoniPlanID = Input::get('CenterMoniPlan');
		   $DateSupervised = Input::get('DateS');
		   //version control start
		   /* $VersionUpdate = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
										  from mocoursemonitoringversion
										  where mocoursemonitoringversion.StartDate<='".$DateSupervised."'
										  and mocoursemonitoringversion.Active=1
										  and mocoursemonitoringversion.Deleted=0
										  ORDER by mocoursemonitoringversion.StartDate DESC
										  limit 1"));
			$newdataVer =  json_decode(json_encode((array)$VersionUpdate),true);
			$VersionID = $newdataVer[0]["vid"]; */
			
			$VersionID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->pluck('VersionID');
			
		   // $updatemocenterplanwithversion = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->update(array('VersionID' => $VersionID));
			//version control end
           $YearPlanID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->pluck('CourseYearPlanID');
           $centerID = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->pluck('CenterID');
           $TraineeCountOnthemonitoringday = Input::get('MCount');
           
		   $Dreason = Input::get('Dreason');
           $SubQCetagoryID = Input::get('SubQCetagoryID');
           $AnswerClassWeight = Input::get('AnswerClassWeight');
           $CourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
           $year = CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');
           $batch = CourseYearPlan::where('id','=',$YearPlanID)->pluck('batch');

            //Clear data tables
           $deletemonitoringTable = MOMonitoring::where('CMPlanid','=',$CenterMoniPlanID)->delete();
           $deleteMonitoringResultTable = MOMonitoringResult::where('CMPlanID','=',$CenterMoniPlanID)->delete();
           $deleteMonitoringtimetableprogrestable = MOMonitoringTimeTableProgress::where('CenterMoPlanID','=',$CenterMoniPlanID)->delete();
           $deleteMonitoringtimetableprogressresulttable = MOMonitoringTimeTableProgressResult::where('CenterMoPlanID','=',$CenterMoniPlanID)->delete();

           //time table progress
           $k = 0;
           //time table progress
          $allModatetaskIDs = Input::get('ModateTaskIDs'); //condiser as 100% - 16
          $checkedModtateList = Input::get('trainee_ids');

          $countallModatetaskIDs = count($allModatetaskIDs);
          $countcheckedModtateList = count($checkedModtateList);

          for($k=0;$k<$countallModatetaskIDs;$k++)
          {

            $UniqmodatetaskID = $allModatetaskIDs[$k];
            if(in_array($UniqmodatetaskID, $checkedModtateList))
            {
              $f = new MOMonitoringTimeTableProgress();
              $f->CenterMoPlanID = $CenterMoniPlanID;
              $f->YearPlanID = $YearPlanID;
              $f->CourseListCode = $CourseListCode;
              $f->Batch = $batch;
              $f->Year = $year;
              $f->MoDateTaskID = $UniqmodatetaskID;
              $f->Checked = 1;
              $f->User = User::getSysUser()->userID;
              $f->save(); 

            }
            else
            {
              $f = new MOMonitoringTimeTableProgress();
              $f->CenterMoPlanID = $CenterMoniPlanID;
              $f->YearPlanID = $YearPlanID;
              $f->CourseListCode = $CourseListCode;
              $f->Batch = $batch;
              $f->Year = $year;
              $f->MoDateTaskID = $UniqmodatetaskID;
              $f->Checked = 0;
              $f->User = User::getSysUser()->userID;
              $f->save(); 
            }
          }
	if($countallModatetaskIDs != 0 && $countcheckedModtateList != 0)
	{
          $AchivedPrecentage = round(($countcheckedModtateList/$countallModatetaskIDs)*100,2);
	}
	else{
		$AchivedPrecentage = '0.00';
	}

          $r = new MOMonitoringTimeTableProgressResult();
          $r->CenterMoPlanID = $CenterMoniPlanID;
          $r->YearPlanID = $YearPlanID;
          $r->CourseListCode = $CourseListCode;
          $r->Year = $year;
          $r->Batch = $batch;
          $r->FullMoDateTaskCount = $countallModatetaskIDs;
          $r->CompletedMoDateTaskCount = $countcheckedModtateList;
          $r->AchivedPercentage = $AchivedPrecentage;
          $r->User = User::getSysUser()->userID;
          $r->save();



          //time table progress
           $CountSubcategory = count($SubQCetagoryID);
           $i = 0;
           $FinalMark = 0;
           for($i=0;$i<$CountSubcategory;$i++)
           {
              $IndividualCriteriaID = $SubQCetagoryID[$i];
              $getCalType = MOCriteria::where('id','=',$IndividualCriteriaID)->pluck('CalculationType');

              if($getCalType == 'P')
              {
                $ClassWeghtID = $AnswerClassWeight[$i];
                $mark = MOClassCriteriaWeight::where('id','=',$ClassWeghtID)->pluck('Weight');
                $c = new MOMonitoring();
                $c->CMPlanid = $CenterMoniPlanID;
                $c->CriteriaID = $IndividualCriteriaID;
                $c->ClassWeightId = $ClassWeghtID;
                $c->Mark = $mark;
                $c->ClassWeightType = $getCalType;
                $c->CenterID = $centerID;
                $c->YearPlanID = $YearPlanID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;


              }
              elseif($getCalType == 'YN')
              {
                $WeightValue = $AnswerClassWeight[$i];
                if($WeightValue == 'Yes')
                {
                  $mark = MOClassCriteriaWeight::where('CriteriaId','=',$IndividualCriteriaID)->where('Deleted','=',0)->pluck('Weight');
                  $ClassWeghtID = MOClassCriteriaWeight::where('CriteriaId','=',$IndividualCriteriaID)->where('Deleted','=',0)->pluck('id');

                }
                else
                {
                  $mark = 0;
                  $ClassWeghtID = 0;
                }
                $c = new MOMonitoring();
                $c->CMPlanid = $CenterMoniPlanID;
                $c->CriteriaID = $IndividualCriteriaID;
                $c->ClassWeightId = $ClassWeghtID;
                $c->Mark = $mark;
                $c->ClassWeightType = $getCalType;
                $c->CenterID = $centerID;
                $c->YearPlanID = $YearPlanID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;

              }
              else
              {
                $c = new MOMonitoring();
                $c->CMPlanid = $CenterMoniPlanID;
                $c->CriteriaID = $IndividualCriteriaID;
                $c->ClassWeightId = 999999;
                $c->Mark = $AnswerClassWeight[$i];
                $c->ClassWeightType = $getCalType;
                $c->CenterID = $centerID;
                $c->YearPlanID = $YearPlanID;
                $c->User = User::getSysUser()->userID;
                $c->save();

                $FinalMark = $FinalMark + $mark;
              }
           }

            $d = new MOMonitoringResult();
            $d->CMPlanID = $CenterMoniPlanID;
            $d->CenterID = $centerID;
            $d->YearPlanID = $YearPlanID;
            $d->FullMark = $FinalMark;
			$d->Dreason = $Dreason;
            $d->CourseDeliveryMark = $AchivedPrecentage;
            $d->TraineeCountMDate = $TraineeCountOnthemonitoringday;
            $d->MonitoringDate = $DateSupervised;
            $d->User = User::getSysUser()->userID;
            $d->save();


            $updateCMPlanTable = MOCenterMonitoringPlan::where('id','=',$CenterMoniPlanID)->update(array('Visited' => '1','DatePlanned' => $DateSupervised));
           // return $view;
            return Redirect::to('DoMonitor');

        }
    

  }

  public function DoMonitor()
  {
    $view = View::make('MOMonitor.View');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	 $UserOrgID = User::getSysUser()->organisationId; 
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      /* $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get(); */
	  
	  $view->Centers = DB::select(DB::raw("select *
  from organisation
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and (organisation.id='".$UserOrgID."' || organisation.OrgaAttachedID='".$UserOrgID."')
  order by organisation.OrgaName"));
    }
	elseif($OegaType == 'PO')
	{
		
		$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$provinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
	  $view->Districts = District::where('ProvinceCode','=',$provinceCode)->orderBy('DistrictName')->get();
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
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    $userEMpid = User::getSysUser()->EmpId;
    $sql = "select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
					courseyearplan.medium,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited,
					mocentremonitoringplan.SpecialPermissionToEnter
                    from mocentremonitoringplan
                    left join organisation
                    on mocentremonitoringplan.CenterID=organisation.id
                    left join courseyearplan
                    on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                    left join coursedetails
                   on courseyearplan.CD_ID=coursedetails.CD_ID
                    where mocentremonitoringplan.Deleted=0
                    and mocentremonitoringplan.EmpId='$userEMpid'
                    and coursedetails.Deleted='0'
                    and mocentremonitoringplan.Approved='1'
				/*and mocentremonitoringplan.DatePlanned<=CURDATE()*/
                    order by mocentremonitoringplan.Visited";
      $courses = DB::select(DB::raw($sql));
      $view->courses = $courses;

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $center = Input::get('center');
            $userEMpid = User::getSysUser()->EmpId;

            $sql = "select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
					courseyearplan.medium,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited,
					mocentremonitoringplan.SpecialPermissionToEnter
                    from mocentremonitoringplan
                    left join organisation
                    on mocentremonitoringplan.CenterID=organisation.id
                    left join courseyearplan
                    on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                    left join coursedetails
                   on courseyearplan.CD_ID=coursedetails.CD_ID
                    where mocentremonitoringplan.Deleted=0
                    and mocentremonitoringplan.CenterID='$center'
                    and mocentremonitoringplan.EmpId='$userEMpid'
                    and coursedetails.Deleted='0'
                    and mocentremonitoringplan.Approved='1'
					/*and mocentremonitoringplan.DatePlanned<=CURDATE()*/
                    order by mocentremonitoringplan.Visited";
          $courses = DB::select(DB::raw($sql));
          $view->courses = $courses;
          return $view;
        }

  }

  public function GetCalClass()
  {
     $CalType = Input::get('CalType');
     $html = '';
     if($CalType == 'P')
     {

      $percentage = MOClass::where('Type','=','P')->where('Deleted','=',0)->get();
     
        $html=' <div class="control-group"><div class="controls"><table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                        <tr>
                            <th>No</th>
                            <th>Class</th>
                            <th>Weight</th>
                            
                           
                        </tr>
                 </thead>';
      foreach ($percentage as $key) 
      {
        $html.='<tbody><tr>
        <input type="hidden" name="ClassID[]" id="ClassID[]" value="'.$key->id.'"/> 
        <td>'.$key->id.'</td>
        <td>'.$key->PercentageGap.'</td>
        <td><input type="text" name="Weight[]" id="Weight[]" placeholder="Enter Weight ...." required/></td></tr>';
        
      }
               
      $html.='</tbody></table></div></div>';
     }
     elseif($CalType == 'YN')
     {
        $percentage = MOClass::where('Type','=','YN')->where('Deleted','=',0)->get();
        $html=' <div class="control-group">
                    
                    <label class="control-label" >Weight : </label>
                    <div class="controls">
                        <select name="ClassID" id="ClassID" required>
                        <option value="">--- Select Weight---</option>';
                  foreach($percentage as $key) 
                {
                  $html.='<option value="'.$key->id.'">'.$key->Max.'</option>';
                  
                }

            $html.='</select></div></div>';
     }
     else
     {
        $html = '';
     }

     return $html;
  }
public function DeleteSubCriteria()
{
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
   $c = MOClassCriteriaWeight::where('CriteriaId','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
   $t = MOCriteria::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    //delete criteria EMPtype Trans
    $cc = MOCriteriaEmpTypeTrans::where('CriteriaId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewCriterias');
}
  public function CreateCriterias()
  {
    $view = View::make('MOCriterias.Create');
    $view->Category = DB::select(DB::raw("select mocriteriacategory.*,mocoursemonitoringversion.VersionNo
  from mocriteriacategory
  left join mocoursemonitoringversion
  on mocriteriacategory.VersionID=mocoursemonitoringversion.id
  where mocriteriacategory.Deleted=0
  order by mocoursemonitoringversion.VersionNo,mocriteriacategory.`Order`"));
    $view->EMPType = MOCriteriaEmpType::where('Deleted','=',0)->get();
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          $CategoryID = Input::get('CategoryID');
		  $VersionID = MOCriteriaCategory::where('id','=',$CategoryID)->pluck('VersionID');
          $CnameSinhala = Input::get('CnameSinhala');
          $CnameEnglish = Input::get('CnameEnglish');
          $Fweight = Input::get('Fweight');
          $Order = Input::get('QOrder');
          $CEmpTypeID = Input::get('CEmpTypeID');
          $CalType = Input::get('CalType');
          $getMaxOrder = MOCriteria::max('Order');
		  $getoderlist = MOCriteria::where('CategoryId','=',$CategoryID)->where('Active','=',1)->where('Deleted','=',0)->where('Order','>=',$Order)->orderBy('Order')->get();
		  foreach($getoderlist as $r)
		  {
				$maxx = $r->Order+1;
			  $update = MOCriteria::where('id','=',$r->id)->update(array('Order' => $maxx));
		  }
          if(empty($getMaxOrder))
          {
            $getMaxOrder = 0;
          }

          if($CalType == 'P')
          {
            $c = new MOCriteria();
            $c->CategoryId = $CategoryID;
            $c->Order = $Order;
            $c->FullWeight = $Fweight;
            $c->CriteriaNameInSinhala = $CnameSinhala;
            $c->CriteriaNameInEnglish = $CnameEnglish; 
            $c->CalculationType = $CalType;
			$c->VersionID = $VersionID;
            $c->User = User::getSysUser()->userID;
            $c->save();

            $ClassIDs = Input::get('ClassID');
            $Weights = Input::get('Weight');
            $countClassID = count($ClassIDs);
            $getMaxCriteriaId = MOCriteria::max('id');
            for($i=0;$i<$countClassID;$i++)
            {
              $d = new MOClassCriteriaWeight();
              $d->ClassId = $ClassIDs[$i];
              $d->CriteriaId = $getMaxCriteriaId;
              $d->Weight = $Weights[$i];
              $d->User = User::getSysUser()->userID;
              $d->save();

            }

            $f = new MOCriteriaEmpTypeTrans();
            $f->EmptypeId = $CEmpTypeID;
            $f->CriteriaId = $getMaxCriteriaId;
            $f->User = User::getSysUser()->userID;
            $f->save();



          }
          elseif($CalType == 'YN')
          {
            $c = new MOCriteria();
            $c->CategoryId = $CategoryID;
            $c->Order = $Order;
            $c->FullWeight = $Fweight;
            $c->CriteriaNameInSinhala = $CnameSinhala;
            $c->CriteriaNameInEnglish = $CnameEnglish; 
            $c->CalculationType = $CalType;
			$c->VersionID = $VersionID;
            $c->User = User::getSysUser()->userID;
            $c->save();

            $ClassIDs = Input::get('ClassID');
            $Weights = MOClass::where('id','=',$ClassIDs)->pluck('Max');
            $getMaxCriteriaId = MOCriteria::max('id');

            $d = new MOClassCriteriaWeight();
            $d->ClassId = $ClassIDs;
            $d->CriteriaId = $getMaxCriteriaId;
            $d->Weight = $Weights;
            $d->User = User::getSysUser()->userID;
            $d->save();

            $f = new MOCriteriaEmpTypeTrans();
            $f->EmptypeId = $CEmpTypeID;
            $f->CriteriaId = $getMaxCriteriaId;
            $f->User = User::getSysUser()->userID;
            $f->save();


          }
          else
          {
            $c = new MOCriteria();
            $c->CategoryId = $CategoryID;
            $c->Order = $Order;
            $c->FullWeight = $Fweight;
            $c->CriteriaNameInSinhala = $CnameSinhala;
            $c->CriteriaNameInEnglish = $CnameEnglish; 
            $c->CalculationType = $CalType;
			$c->VersionID = $VersionID;
            $c->User = User::getSysUser()->userID;
            $c->save();

            $getMaxCriteriaId = MOCriteria::max('id');
            $f = new MOCriteriaEmpTypeTrans();
            $f->EmptypeId = $CEmpTypeID;
            $f->CriteriaId = $getMaxCriteriaId;
            $f->User = User::getSysUser()->userID;
            $f->save();



          }

          return $view;
        }
  }

  public function ViewCriterias()
  {
    $view = View::make('MOCriterias.View');
    $courses = MOCriteria::where('Deleted','=',0)->orderBy('CategoryId')->get();
    //$view->moduleTask = $courses;
    $method=Request::getMethod();
    $cc = DB::select(DB::raw("select mocriteria.id,
  mocriteriacategory.TypeInSinhala,
  mocriteriacategory.FullWeightFoTheSection,
  mocriteria.CriteriaNameInSinhala,
  mocriteria.CalculationType,
  moclass.PercentageGap,
  moclasscriteriaweight.Weight,mocoursemonitoringversion.VersionNo,mocoursemonitoringversion.Active as versionActive
  from mocriteriacategory
  left join mocoursemonitoringversion
  on mocriteriacategory.VersionID=mocoursemonitoringversion.id
  left join mocriteria
  on mocriteriacategory.id=mocriteria.CategoryId
  left join moclasscriteriaweight
  on mocriteria.id=moclasscriteriaweight.CriteriaId
  left join moclass
  on moclasscriteriaweight.ClassId=moclass.id
  where mocriteriacategory.Active='1'
  and mocriteriacategory.Deleted='0'
  and mocriteria.Active='1'
  and moclasscriteriaweight.Deleted='0'"));
  $view->moduleTask =  $cc; 
        if($method == 'GET')
        {
             return $view;
        }
  }

  public function DeleteCriteriaClass()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOClass::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    return Redirect::to('ViewCriteriaClass');
  }

  public function CreateCriteriaClass()
  {
    $view = View::make('MOClass.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Type = Input::get('Type');
            $Max = Input::get('Max');
            $Min = Input::get('Min');
            $Name = Input::get('Name');
           
            $c = new MOClass();
            $c->Type = $Type;
            $c->Max = $Max;
            $c->Min = $Min;
            $c->PercentageGap = $Name;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateCriteriaClass')->with("done", true);
        }
  }

  public function ViewCriteriaClass()
  {
    $view = View::make('MOClass.View');
    $courses = MOClass::where('Deleted','=',0)->orderBy('Type')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }

  public function DeleteCriteriaEmpType()
  {
     $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOCriteriaEmpType::where('id','=',$ID)->update(array('Deleted' => '1', 'User' => $user));
    //delete criteria EMPtype Trans
    $cc = MOCriteriaEmpTypeTrans::where('EmptypeId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewCriteriaEmpType');
  }

  public function CreateCriteriaEmpType()
  {
    $view = View::make('MOCriteriaEmpType.Create');
    
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Type = Input::get('Type');
           
            $c = new MOCriteriaEmpType();
            $c->Type = $Type;
            $c->User = User::getSysUser()->userID;
            $c->save();
            return Redirect::to('CreateCriteriaEmpType')->with("done", true);
        }
  }

  public function ViewCriteriaEmpType()
  {
    $view = View::make('MOCriteriaEmpType.View');
    $courses = MOCriteriaEmpType::where('Deleted','=',0)->orderBy('Type')->get();
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }

  public function DeleteCriteriaCategory()
  {
    $ID = Input::get('id');
    $user = User::getSysUser()->userID;
    $c = MOCriteriaCategory::where('id','=',$ID)->update(array('Active' => '0', 'User' => $user));
    // delete criteria
    $cc = MOCriteria::where('CategoryId','=',$ID)->update(array('Active' => '0','User' => $user));
    return Redirect::to('ViewCriteriaCategory');
  }

  public function CreateCriteriaCategory()
  {
    $view = View::make('MOCriteriaCategory.Create');
    $view->Versions = MOCourseMonitoringVersion::where('Deleted','=',0)->orderBy('VersionNo')->get();
   
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $Csinhala = Input::get('CnameSinhala');
            $Ceng = Input::get('CnameEnglish');
            $Order = Input::get('Order');
			$FullWeightFoTheSection = Input::get('FullWeightFoTheSection');
            $maxOrder = MOCriteriaCategory::max('Order');
            $max = $maxOrder+1;
			$VersionID = Input::get('VersionID');
            $c = new MOCriteriaCategory();
            $c->TypeInEnglish = $Ceng;
            $c->TypeInSinhala = $Csinhala;
            $c->Order = $max;
			$c->FullWeightFoTheSection  = $FullWeightFoTheSection;
            $c->User = User::getSysUser()->userID;
			$c->VersionID = $VersionID;
            $c->save();
            return Redirect::to('CreateCriteriaCategory')->with("done", true);
        }
  }

  public function ViewCriteriaCategory()
  {
    $view = View::make('MOCriteriaCategory.View');
    //$courses = MOCriteriaCategory::where('Deleted','=',0)->orderBy('Order')->get();
	$courses = DB::select(DB::raw("select mocriteriacategory.*,mocoursemonitoringversion.VersionNo,mocoursemonitoringversion.Active as versionActive
  from mocriteriacategory
  left join mocoursemonitoringversion
  on mocriteriacategory.VersionID=mocoursemonitoringversion.id
  where mocriteriacategory.Deleted=0
  order by mocriteriacategory.`Order`"));
    $view->moduleTask = $courses;
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
  }

  public function DeleteTOMOnitoringPlan()
  {
    $id = Input::get('id');
    $MOCenterMonitoringPlan = MOCenterMonitoringPlan::where('id','=',$id)->update(array('Deleted' => '1'));
    return Redirect::to('ViewTOMOCenterMonitoringPlan');

  }

  public function DDADConfirmMOCenterMOnitoringPlan()
  {
    $ID = Input::get('id');
    $empid = User::getSysUser()->EmpId;
    $MOCenterMonitoringPlan = MOCenterMonitoringPlan::where('id','=',$ID)
    ->update(array('Approved' => '1','ApprovedUser' => $empid));
     return 1;
  }

  public function DDADRejectMOCenterMOnitoringPlan()
  {
    $ID = Input::get('id');

    $reason = Input::get('reason');
    $empid = User::getSysUser()->EmpId;
    $currentTimestamp = date('Y-m-d H:i:s');
    $MOCenterMonitoringPlan = MOCenterMonitoringPlan::where('id','=',$ID)
    ->update(array('Approved' => '2','ApprovedUser' => $empid, 'DateRejected' => $currentTimestamp,'RejectReason' => $reason));
     return 1;

  }

  public function GetEmpIdFromCenterMO()
  {
    $Center = Input::get('center');
    $UserOrgID = User::getSysUser()->organisationId; 
	$EmpID = User::getSysUser()->EmpId; 
    //$OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
if($Center != 420)
{
	$EMP = DB::select(DB::raw("select employee.id,employee.Name,employee.LastName,employmentcode.Designation
  from employee
  left join employmentcode
  on employee.CurrentDesignation=employmentcode.id
  where employee.Deleted=0
  and employee.CurrentOrgaID='$Center'
  and employee.id !='$EmpID'
  and (employmentcode.Designation like 'Assistant Director' or employmentcode.Designation like 'Training Officer' or employmentcode.Designation like 'Deputy Director%')
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
  and (employmentcode.Designation like 'Assistant Director%' or employmentcode.Designation like 'Training Officer%' or employmentcode.Designation like 'Deputy Director%')
  order by employmentcode.Designation"));
}
    

    return json_encode($EMP);
  }

  public function ViewDDADMOCenterMonitoringPlan()
  {
    $view = View::make('MOCMPlan.DDADView');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
	  $view->Districts = District::orderBy('DistrictName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
		$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	  $view->Districts = District::where('DistrictCode','=',$DistrictCode)->orderBy('DistrictName')->get();
      /* $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get(); */
	  $view->Centers = DB::select(DB::raw("select *
  from organisation
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and (organisation.id='".$UserOrgID."' || organisation.OrgaAttachedID='".$UserOrgID."')
  order by organisation.OrgaName"));
    }
	elseif($OegaType == 'PO')
	{
		
		$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$provinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
	  $view->Districts = District::where('ProvinceCode','=',$provinceCode)->orderBy('DistrictName')->get();
		$sql = "select * 
  from organisation
  left join district
  on organisation.DistrictCode=district.DistrictCode
  left join province
  on district.ProvinceCode=province.ProvinceCode
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and province.ProvinceCode='".$loggedUserProvince."'
  and organisation.Type not in('HO')
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
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
             $center = Input::get('centerID');
             $EmpId = Input::get('EmpId');

               $sql = "select mocentremonitoringplan.id,
                      organisation.OrgaName,
                      organisation.Type,
                       coursedetails.CourseName,
                      courseyearplan.Year,
                      courseyearplan.batch,
                      mocentremonitoringplan.DatePlanned,
                      mocentremonitoringplan.Approved,
                      mocentremonitoringplan.Visited,
					  mocentremonitoringplan.SpecialPermissionToEnter
                      from mocentremonitoringplan
                      left join organisation
                      on mocentremonitoringplan.CenterID=organisation.id
                      left join courseyearplan
                      on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                      left join coursedetails
                      on courseyearplan.CD_ID=coursedetails.CD_ID
                      where mocentremonitoringplan.Deleted=0
                      and mocentremonitoringplan.OrgaIDUser='$center'
                      and mocentremonitoringplan.EmpId='$EmpId'
                      and coursedetails.Deleted='0'
                      order by mocentremonitoringplan.Approved,organisation.OrgaName,coursedetails.CourseName";

              $centers = DB::select(DB::raw($sql));
              $view->courses = $centers;
              return $view;
        }

  }

  public function ViewTOMOCenterMonitoringPlan()
  {
    $view = View::make('MOCMPlan.TOView');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      /* $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get(); */
	  
	  $view->Centers = DB::select(DB::raw("select *
  from organisation
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and (organisation.id='".$UserOrgID."' || organisation.OrgaAttachedID='".$UserOrgID."')
  order by organisation.OrgaName"));
    }
	elseif($OegaType == 'PO')
	{
		
		$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$provinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
	  $view->Districts = District::where('ProvinceCode','=',$provinceCode)->orderBy('DistrictName')->get();
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
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    $userEMpid = User::getSysUser()->EmpId;
    /*$sql = "select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited
                    from mocentremonitoringplan
                    left join organisation
                    on mocentremonitoringplan.CenterID=organisation.id
                    left join courseyearplan
                    on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                    left join coursedetails
                    on courseyearplan.CD_ID=coursedetails.CD_ID
                    where mocentremonitoringplan.Deleted=0
                    and mocentremonitoringplan.EmpId='$userEMpid'
                    and coursedetails.Deleted='0'
                    order by mocentremonitoringplan.Visited";*/
					
	$sql ="select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited,
			mocentremonitoringplan.SpecialPermissionToEnter		
FROM mocentremonitoringplan
  LEFT JOIN organisation
    ON mocentremonitoringplan.CenterID = organisation.id
  LEFT JOIN courseyearplan
    ON mocentremonitoringplan.CourseYearPlanID = courseyearplan.id
  LEFT JOIN coursedetails
    ON courseyearplan.CD_ID = coursedetails.CD_ID
  LEFT JOIN employee
    ON mocentremonitoringplan.EmpId = employee.id
WHERE mocentremonitoringplan.Deleted = 0
and mocentremonitoringplan.EmpId='$userEMpid'
AND organisation.Deleted = 0
AND employee.Deleted = 0
AND courseyearplan.Deleted = '0'
AND coursedetails.Deleted = '0'
ORDER BY mocentremonitoringplan.Visited";
          $courses = DB::select(DB::raw($sql));
          $view->courses = $courses;

     $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
            $center = Input::get('center');
            $userEMpid = User::getSysUser()->EmpId;

            /*$sql = "select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited
                    from mocentremonitoringplan
                    left join organisation
                    on mocentremonitoringplan.CenterID=organisation.id
                    left join courseyearplan
                    on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                    left join coursedetails
                    on courseyearplan.CD_ID=coursedetails.CD_ID
                    where mocentremonitoringplan.Deleted=0
                    and mocentremonitoringplan.CenterID='$center'
                    and mocentremonitoringplan.EmpId='$userEMpid'
                    and coursedetails.Deleted='0'
                    order by mocentremonitoringplan.Visited";*/
								
	$sql ="select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited,
				mocentremonitoringplan.SpecialPermissionToEnter	
FROM mocentremonitoringplan
  LEFT JOIN organisation
    ON mocentremonitoringplan.CenterID = organisation.id
  LEFT JOIN courseyearplan
    ON mocentremonitoringplan.CourseYearPlanID = courseyearplan.id
  LEFT JOIN coursedetails
    ON courseyearplan.CD_ID = coursedetails.CD_ID
  LEFT JOIN employee
    ON mocentremonitoringplan.EmpId = employee.id
WHERE mocentremonitoringplan.Deleted = 0
and mocentremonitoringplan.EmpId='$userEMpid'
and mocentremonitoringplan.CenterID='$center'
AND organisation.Deleted = 0
AND employee.Deleted = 0
AND courseyearplan.Deleted = 0
AND coursedetails.Deleted = '0'
ORDER BY mocentremonitoringplan.Visited";	
					
          $courses = DB::select(DB::raw($sql));
          $view->courses = $courses;
          return $view;
        }
  }

  public function MOCMCheckPlanneddate()
  {
    $DatePlanned = Input::get('DatePlanned');
    $CenterID = Input::get('CenterID');
    $YearPlanID = Input::get('CourseYearPlanID');

    $getCourseListCode = 
    $StartDate = CourseYearPlan::where('id','=',$YearPlanID)->pluck('RealstartDate');
   // $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
   $CD_ID = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CD_ID');
   
    $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
    $duration = substr( $DurationValue, 0, -2);
    $YearCYID =  CourseYearPlan::where('id','=',$YearPlanID)->pluck('Year');   
    $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
    $newdu = DB::select(DB::raw($sql78));
    $newdata =  json_decode(json_encode((array)$newdu),true);
	if($YearCYID == '2020' || $YearCYID == '2021')
	{
		$expectedcom = CourseYearPlan::where('id','=',$YearPlanID)->pluck('RealEndDate');
	}

	else
	{
		$expectedcom = $newdata[0]["dd"];
	}
	
  
    
   

    $saturday = [];
    $sunday = [];
    $holydays = [];
    $availableHolyday = [];
    $html = '';
    $Fix = 0;
    $rr=0;
   
   

       $sql = "select holiday.Holidaydate
                from holiday
                where holiday.Deleted=0
				and holiday.Active=1
                and holiday.Holidaydate>='$StartDate'
                and holiday.Holidaydate<='$expectedcom'";
            $Hdates = DB::select(DB::raw($sql));
            foreach ($Hdates as $gg ) {
                 
                  $holydays [] = $gg->Holidaydate;
            }

            if($DatePlanned<$StartDate || $DatePlanned>$expectedcom)
            {
               $html = '<div class="control-group">
                  <font color="red">Enter Date Between '.$StartDate.' and '.$expectedcom.'</font>
                  </div>';
                  $rr=1;
                return json_encode(array('html' => $html, 'module' => $rr));
            }

            if(in_array($DatePlanned, $holydays))
            {
                $Fix=1;//if holyday
                $rr=1;
            }
              else
            {
                $begin = new DateTime($DatePlanned);
                $format = "Y-m-d";
                $timestamp = strtotime($begin->format($format));
                $dayeeee = date('D', $timestamp);
                if($dayeeee == 'Sat')
                {
                    $Fix = 2;// if saturday
                    $rr=1;
                }
                elseif($dayeeee == 'Sun')
                {
                    $Fix = 3;// if sunday
                    $rr=1;
                }
                else
                {

                }
              }
              if($Fix == 1)
              {
                  $html = '<div class="control-group">
                  <font color="red">Date that you entered is a holiday</font>
                  </div>';
        
              }
              elseif ($Fix == 2) {
                  $html = '<div class="control-group">
                  <font color="green">Date that you entered is a Saturday</font>
                  </div>';
        
                  }
                elseif ($Fix == 3) {
                    $html = '<div class="control-group">
                <font color="green">Date that you entered is a Sunday</font>
                </div>';
       
                 }
                else
                  {

                  }

    

    
  

    

     return json_encode(array('html' => $html, 'module' => $rr));

  }

  public function FilterCourseYearPlans1()
  {
    $CenterID = Input::get('CourseListCode');
    $sql = DB::select(DB::raw("select courseyearplan.id,
  coursedetails.CourseName,
  coursedetails.CourseListCode,
  courseyearplan.Year,
  courseyearplan.batch,
  courseyearplan.medium,
  courseyearplan.RealstartDate,
  coursedetails.Duration
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and courseyearplan.RealstartDate is not null
  and courseyearplan.OrgId='".$CenterID."'
  and courseyearplan.StartedStatus=1
  order by coursedetails.CourseName
"));

  return json_encode($sql);
  }

  public function FilterCourseYearPlans()
  {
     $CenterID = Input::get('CourseListCode');
     $u = User::getSysUser()->EmpId;
     /* $MOCenterMonitoringPlan = DB::select(DB::raw("SELECT organisation.OrgaName,
                                                  organisation.Type,
                                                  coursedetails.CourseName,
                                                  mocentremonitoringplan.DatePlanned,
                                                  mocentremonitoringplan.Approved,
                                                  mocentremonitoringplan.Visited
                                                  from mocentremonitoringplan
                                                  left join organisation
                                                  on mocentremonitoringplan.CenterID=organisation.id
                                                  left join courseyearplan
                                                  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                                                  left join coursedetails
                                                  on courseyearplan.CD_ID=coursedetails.CD_ID
                                                  where mocentremonitoringplan.Deleted=0
                                                  and mocentremonitoringplan.EmpId='".$u."'
                                                  and mocentremonitoringplan.CenterID='".$CenterID."'")); */
$MOCenterMonitoringPlan = DB::select(DB::raw("select mocentremonitoringplan.id,
                    organisation.OrgaName,
                    organisation.Type,
                    coursedetails.CourseName,
                    courseyearplan.Year,
                    courseyearplan.batch,
                    mocentremonitoringplan.DatePlanned,
                    mocentremonitoringplan.Approved,
                    mocentremonitoringplan.Visited
                    from mocentremonitoringplan
                    left join organisation
                    on mocentremonitoringplan.CenterID=organisation.id
                    left join courseyearplan
                    on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
                    left join coursedetails
                    on courseyearplan.CD_ID=coursedetails.CD_ID
                    where mocentremonitoringplan.Deleted=0
                    and mocentremonitoringplan.CenterID='$CenterID'
                    and mocentremonitoringplan.EmpId='$u'
                    and coursedetails.Deleted='0'
                    order by mocentremonitoringplan.Visited"));
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
                        <th class="center">Date Planned</th>
                        <th class="center">Approved</th>
                        <th class="center">Visited</th>
                        </tr>
                       </thead>
                       <tbody>';

                       foreach($MOCenterMonitoringPlan as $m)
                       {
                           $html.='<tr>
                        <th class="center">'.$i++.'</th>
                        <th class="center">'.$m->OrgaName.' ('.$m->Type.')</th>
                        <th class="center">'.$m->CourseName.'</th>
                        <th class="center">'.$m->DatePlanned.'</th>
                        <th class="center">'.$m->Approved.'</th>
                        <th class="center">'.$m->Visited.'</th>
                        </tr>';
                       }

                       $html.='</tbody>
                       </table>
                  
                </div>';
     }
     else
     {
        $html='<div class="control-group">
                  
                 <font color="red">Monitoring Plans Not Available for this Center..</font>
                   
                </div>';
     }

     return $html;
  }

  public function CreateMOCenterMonitoringPlan()
  {
    $view = View::make('MOCMPlan.Create');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $UserOrgID = User::getSysUser()->organisationId; 
    $OegaType = Organisation::where('id','=',$UserOrgID)->pluck('Type');
	$LoggedUserDis = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
	$loggedUserProvince = District::where('DistrictCode','=',$LoggedUserDis)->pluck('ProvinceCode');
	$view->Districts = District::orderBy('DistrictName')->get();
    $view->OrgaType = $OegaType;
    if($OegaType == 'HO')
    {
      $view->Centers = Organisation::where('Deleted','=',0)
	  ->where('Active','=','Yes')
	  ->whereNotIn('Type',['HO','DO','PO'])
	  ->orderBy('OrgaName')->get();
    }
    elseif($OegaType == 'DO')
    {
      $DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('DistrictCode','=',$DistrictCode)
      ->whereNotIn('Type',['HO','DO','PO'])
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }
    elseif($OegaType == 'NVTI')
    {
      /* $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get(); */
	  
	  $view->Centers = DB::select(DB::raw("select *
  from organisation
  where organisation.Deleted=0
  and organisation.Active='Yes'
  and (organisation.id='".$UserOrgID."' || organisation.OrgaAttachedID='".$UserOrgID."')
  order by organisation.OrgaName"));
    }
	elseif($OegaType == 'PO')
	{
		
		$DistrictCode = Organisation::where('id','=',$UserOrgID)->pluck('DistrictCode');
		$provinceCode = District::where('DistrictCode','=',$DistrictCode)->pluck('ProvinceCode');
	  $view->Districts = District::where('ProvinceCode','=',$provinceCode)->orderBy('DistrictName')->get();
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
      $view->Centers = Organisation::where('Deleted','=',0)
      ->where('id','=',$UserOrgID)
      ->where('Active','=','Yes')
      ->orderBy('OrgaName')
      ->get();
    }

    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {

            $CenterID = Input::get('CenterID');
            $YearPlanID = Input::get('CourseYearPlanID');
            $DatePlanned = Input::get('DatePlanned');
            $UserOrgID = User::getSysUser()->organisationId; 
            $User = User::getSysUser()->userID;
             $available = MOCenterMonitoringPlan::where('CenterID','=',$CenterID)
            ->where('CourseYearPlanID','=',$YearPlanID)
            ->where('EmpId','=',User::getSysUser()->EmpId)
			->where('Deleted','=',0)
            ->where('DatePlanned','=',$DatePlanned)->count();
			
			 $VersionIDQuery = DB::select(DB::raw("select mocoursemonitoringversion.id as vid
											 from mocoursemonitoringversion
											 where mocoursemonitoringversion.StartDate<='".$DatePlanned."'
											 and mocoursemonitoringversion.Deleted=0
											 and mocoursemonitoringversion.Active=1
											 order by mocoursemonitoringversion.StartDate DESC
											 limit 1"));
											 
		     $newdata =  json_decode(json_encode((array)$VersionIDQuery),true);
             $VersionID = $newdata[0]["vid"]; 

            if($available == 0)
            {
              $c = new MOCenterMonitoringPlan();
              $c->CenterID = $CenterID;
              $c->CourseYearPlanID = $YearPlanID;
              $c->EmpId = User::getSysUser()->EmpId;
              $c->DatePlanned = $DatePlanned;
              $c->OrgaIDUser = $UserOrgID;
			  //$c->VersionID = $VersionID;
              $c->User = User::getSysUser()->userID;
              $c->save();
            }


            return Redirect::to('CreateMOCenterMonitoringPlan')->with("done", true);
        }

  }

  public function PrintPDFWeekTimeTableLoadWeekNo()
  {

    //return 'in function';
     $CD_ID = Input::get('CD_ID'); //Course Detail tale id
     $Year = Input::get('Year');
     $Batch = Input::get('Batch');
     $WeekNo = Input::get('WeekNo');
	  $month = Input::get('MonthID');
	  $CalenderYear = Input::get('CalenderYear');
     $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
     $CourseName = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseName');
     $WeekFrom = MODateTask::weekFrom($Year,$WeekNo,$month,$CalenderYear);
     $WeekTo = MODateTask::weekTo($Year,$WeekNo,$month,$CalenderYear);
     $html = '';
	if($WeekNo != 'All')
	{
		$html = '<html><head><center><b><h3>Vocational Training Authority</h3><h4><i>Week Time Table For Course - "'.$CourseName.'('.$getCourseListCode.')" Year- "'.$Year.'" Month - "'.$month.'" Batch - "'.$Batch.'" Week No - "'.$WeekNo.'" <br/>(From: '.$WeekFrom.'    To: '.$WeekTo.')</h4></i></b></center></head>
		<body>
		<table style = "font-size:16px" align="center" border=1 width="1000" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
                 <thead>
                <tr>
                        <th  align="center">SESSION</th>
                        <th  align="center">TIME</th>
                        <th  align="center">MONDAY</th>
                        <th  align="center">TUESDAY</th>
                        <th  align="center">WEDNESDAY</th>
                        <th  align="center">THURSDAY</th>
                        <th  align="center">FRIDAY</th>
                        
                </tr>
                 </thead>';
      $HolidayMon = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Mon',$CalenderYear);
      $HolidayTue = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Tue',$CalenderYear);
      $HolidayWed = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Wed',$CalenderYear);
      $HolidayThu = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Thu',$CalenderYear);
      $HolidayFri = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WeekNo,'Fri',$CalenderYear);
      $html.='<tbody>
                    <tr>
                        <td align="center"></td>
                        <td align="center">8.30 - 9.00</td>
                        <td align="center">';
                            if($HolidayMon == '0')
                            {
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }

                        $html.='</td>
                        <td align="center">';
                             if($HolidayTue == '0')
                             {
                               $html.='<font color="RED">Holiday</font>';
                              }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayWed == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                         
                        $html.='</td>
                        <td align="center">';
                             if($HolidayThu == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.=' <font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                            
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                           
                       $html.=' </td>
                    </tr>';
                    $html.='<tr>
                        <td align="center">1</td>
                        <td align="center">9.00 - 12.15</td>
                        <td align="center">';
                        if($HolidayMon != 0)
                        {
                        
                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Mon',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
						 
						 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                         
                        $html.='</td>
                        <td align="center">';
                            if($HolidayTue != 0)
                            {
                            
                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Tue',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                                   
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                          
                         
                        $html.='</td>
                        <td align="center">';
                             if($HolidayWed != 0)
                           {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                          
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                         
                        $html.='</td>
                        <td align="center">';
                              if($HolidayThu != 0)
                              {
                            

                                  $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Thu',$month,$CalenderYear);
								  $CountDDD = count($ddMONS1);
                        

                         
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                           else
                           {
                          $html.='<font color="RED">Holiday</font>';
                        }
                         
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri != 0)
                            {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,1,'Fri',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);
                        

                          
                               if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                            }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                        $html.='</td>
                    </tr>';
                    $html.='<tr>
                        <td align="center"></td>
                        <td align="center">12.15 - 12.45</td>
                        <td align="center">';
                            if($HolidayMon == '0')
                            {
                            
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayTue == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                            }
                            else{
                                $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                        $html.='</td>
                        <td align="center">';
                             if($HolidayWed == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                             }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayThu == '0')
                             {
                           $html.='<font color="RED">Holiday</font>';
                         }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                          }
                            
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri == '0')
                             {
                            $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                            
                        $html.='</td>
                    </tr>';
                     $html.='<tr>
                        <td align="center">2</td>
                        <td align="center">12.45 - 4.00</td>
                        <td align="center">';
                            if($HolidayMon != 0)
                            {
                           

                       $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Mon',$month,$CalenderYear);
					   $CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td align="center">';
                             if($HolidayTue != 0)
                             {
                           

                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Tue',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
                        
                      
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td align="center">';
                            if($HolidayWed != 0)
                            {
                            

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                            
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                        }
                        $html.='</td>
                        <td align="center">';
                              if($HolidayThu != 0)
                              {
                           

                         
                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Thu',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);

                          
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri != 0)
                             {
                            

                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WeekNo,2,'Fri',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                    </tr>
                   
                
                    
                </tbody>
            </table></body></html>';
	}
	else{
		$html = '<html><head><center><b><h3>Vocational Training Authority</h3><h4><i>Week Time Table For Course - "'.$CourseName.'('.$getCourseListCode.')" Year - "'.$Year.' Month - "'.$month.'" "Batch - "'.$Batch.'" </h4></i></b></center></head><body><hr/>';
		
		$wwww = 1;
				 
			$sql = "select DISTINCT modatecalender.WeekNo
            from modatetask
            left join modatecalender
            on modatetask.MODateCalenderID=modatecalender.id
            where modatetask.Deleted=0
            and modatetask.Year='".$Year."'
            and modatetask.Batch like '".$Batch."'
            and modatecalender.Month='".$month."'
			and modatecalender.Year = '".$CalenderYear."'
            and modatetask.CD_ID='".$CD_ID."'
			order by modatecalender.WeekNo";
			
			$WeekNoList = DB::select(DB::raw($sql));
	  
	  foreach($WeekNoList as $WLS)
	  {
		   $WeekFrom = MODateTask::weekFrom($Year,$WLS->WeekNo,$month,$CalenderYear);
		   $WeekTo = MODateTask::weekTo($Year,$WLS->WeekNo,$month,$CalenderYear);
		   
		  $html.='<center><b><h5>Month - "'.$month.'" Week No - "'.$wwww.'" <br/>(From: '.$WeekFrom.'    To: '.$WeekTo.')</h5></i></b></center>';
		  $html.='<table style = "font-size:16px" align="center" border=1 width="1000" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
                 <thead>
                <tr>
                        <th  align="center">SESSION</th>
                        <th  align="center">TIME</th>
                        <th  align="center">MONDAY</th>
                        <th  align="center">TUESDAY</th>
                        <th  align="center">WEDNESDAY</th>
                        <th  align="center">THURSDAY</th>
                        <th  align="center">FRIDAY</th>
                        
                </tr>
                 </thead>';
		  $HolidayMon = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Mon',$CalenderYear);
		  $HolidayTue = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Tue',$CalenderYear);
		  $HolidayWed = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Wed',$CalenderYear);
		  $HolidayThu = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Thu',$CalenderYear);
		  $HolidayFri = MODateTask::IFHOLIDAY($Year,$Batch,$CD_ID,$WLS->WeekNo,'Fri',$CalenderYear);
      $html.='<tbody>
                    <tr>
                        <td align="center"></td>
                        <td align="center">8.30 - 9.00</td>
                        <td align="center">';
                            if($HolidayMon == '0')
                            {
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }

                        $html.='</td>
                        <td align="center">';
                             if($HolidayTue == '0')
                             {
                               $html.='<font color="RED">Holiday</font>';
                              }
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayWed == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                         
                        $html.='</td>
                        <td align="center">';
                             if($HolidayThu == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                           
                            else
                            {
                              $html.=' <font color="MEDIUMBLUE">MEETING</font>';
                            }
                           
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri == '0')
                             {
                              $html.='<font color="RED">Holiday</font>';
                             }
                            
                            else
                            {
                              $html.='<font color="MEDIUMBLUE">MEETING</font>';
                            }
                            
                           
                       $html.=' </td>
                    </tr>';
                    $html.='<tr>
                        <td align="center">1</td>
                        <td align="center">9.00 - 12.15</td>
                        <td align="center">';
                        if($HolidayMon != 0)
                        {
                        
                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Mon',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
						 
						 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                         
                        $html.='</td>
                        <td align="center">';
                            if($HolidayTue != 0)
                            {
                            
                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Tue',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                                   
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                          
                         
                        $html.='</td>
                        <td align="center">';
                             if($HolidayWed != 0)
                           {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                          
                                 if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                         
                        $html.='</td>
                        <td align="center">';
                              if($HolidayThu != 0)
                              {
                            

                                  $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Thu',$month,$CalenderYear);
								  $CountDDD = count($ddMONS1);
                        

                         
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                           else
                           {
                          $html.='<font color="RED">Holiday</font>';
                        }
                         
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri != 0)
                            {

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,1,'Fri',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);
                        

                          
                               if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                            }
                          else
                          {
                              $html.='<font color="RED">Holiday</font>';
                          }
                        $html.='</td>
                    </tr>';
                    $html.='<tr>
                        <td align="center"></td>
                        <td align="center">12.15 - 12.45</td>
                        <td align="center">';
                            if($HolidayMon == '0')
                            {
                            
                              $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayTue == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                            }
                            else{
                                $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                        $html.='</td>
                        <td align="center">';
                             if($HolidayWed == '0')
                             {
                                $html.='<font color="RED">Holiday</font>';
                             }
                            else
                            {
                              $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                           
                        $html.='</td>
                        <td align="center">';
                             if($HolidayThu == '0')
                             {
                           $html.='<font color="RED">Holiday</font>';
                         }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                          }
                            
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri == '0')
                             {
                            $html.='<font color="RED">Holiday</font>';
                            }
                            else
                            {
                            $html.='<font color="DARKGREEN">LUNCH</font>';
                            }
                            
                        $html.='</td>
                    </tr>';
                     $html.='<tr>
                        <td align="center">2</td>
                        <td align="center">12.45 - 4.00</td>
                        <td align="center">';
                            if($HolidayMon != 0)
                            {
                           

                       $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Mon',$month,$CalenderYear);
					   $CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                         else
                         {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td align="center">';
                             if($HolidayTue != 0)
                             {
                           

                         $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Tue',$month,$CalenderYear);
						 $CountDDD = count($ddMONS1);
                        
                      
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                          }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td align="center">';
                            if($HolidayWed != 0)
                            {
                            

                                $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Wed',$month,$CalenderYear);
								$CountDDD = count($ddMONS1);

                            
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                        }
                        $html.='</td>
                        <td align="center">';
                              if($HolidayThu != 0)
                              {
                           

                         
                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Thu',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);

                          
                        if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                        <td align="center">';
                             if($HolidayFri != 0)
                             {
                            

                        $ddMONS1 = MODateTask::GETWEEKSESSIONModule($Year,$Batch,$CD_ID,$WLS->WeekNo,2,'Fri',$month,$CalenderYear);
						$CountDDD = count($ddMONS1);
                        

                           
                         if($CountDDD != 0)
						 {
						
							 foreach($ddMONS1 as $mS1)
							 {
									 if($mS1->TaskSeqID == '999999')
									 {
										$html.='Continuous Assessments<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999998')
									 {
										$html.='English/Career Skills<br/>';
									 }
									 elseif($mS1->TaskSeqID == '999997')
									 {
										$html.='Orientation Program<br/>';
									 }
									 else
									 {
										$html.=''.$mS1->TaskName.'-('.$mS1->TaskCode.')<br/>';
									 }
								   

							 }
						 }
						 else{
							 $html.='***<br/>';
						 }
                       }
                          else
                          {
                          $html.='<font color="RED">Holiday</font>';
                         }
                        $html.='</td>
                    </tr>
                   
                
                    
                </tbody>
            </table>';
			$wwww = $wwww + 1;
			
	  }
	  
	  $html.='</body></html>';
				 
		
	}
     

     return $html;
  }

 

  public function ViewWeekTimeTableLoadWeekNo()
  {
    $CD_ID = Input::get('CDID'); //Course Detail tale id
    $Year = Input::get('Year');
    $Batch = Input::get('Batch');
    $Month = Input::get('Month');
	$CalenderYear = Input::get('CalenderYear');
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
    $sql = "select DISTINCT modatecalender.WeekNo
            from modatetask
            left join modatecalender
            on modatetask.MODateCalenderID=modatecalender.id
            where modatetask.Deleted=0
            and modatetask.Year='".$Year."'
            and modatetask.Batch like'".$Batch."'
            and modatecalender.Month='".$Month."'
			and modatecalender.Year = '".$CalenderYear."'
            and modatetask.CD_ID='".$CD_ID."'
			order by modatecalender.WeekNo";
            $dd = DB::select(DB::raw($sql));

  return json_encode($dd);
  }

  public function ViewWeekTimeTable()
  {
    $view = View::make('MOTimeTable.ViewWeekTimeTable');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
    $method=Request::getMethod();
    
        if($method == 'GET')
        {
             return $view;
        }
        if($method == 'POST')
        {
          $CD_ID = Input::get('CourseListCode'); //Course Detail tale id
          $Year = Input::get('Year');
          $Batch = Input::get('CourseBatch');
          $WeekNo = Input::get('WeekNo');
          $Month = Input::get('Month');
          $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
          $sql = "select  modatetask.TaskSeqID,motask.TaskName,modatecalender.Day,modatecalender.Session
        from modatetask
        left join modatecalender
        on modatetask.MODateCalenderID=modatecalender.id
        left join motaskseq
        on modatetask.TaskSeqID=motaskseq.id
        left join motask
        on motaskseq.taskid=motask.id
        where modatetask.Deleted=0
        and modatetask.Year='".$Year."'
        and modatetask.Batch like '".$Batch."'
        and modatetask.CD_ID='".$CD_ID."'
        and modatecalender.WeekNo='".$WeekNo."'";

        $Table = DB::select(DB::raw($sql));
         $view->moduleTask = $Table;
         $view->CDFID = $CD_ID;
         $view->BATCHID = $Batch;
         $view->YEARID = $Year;
         $view->WEEKID = $WeekNo;
         $view->MONTHID = $Month;
          
          return $view;
        }
   
  }

  public function printActualTimeTablePDF()
  {
    $CD_ID = Input::get('CD_ID'); //Course Detail tale id
    $Year = Input::get('Year');
    $Batch = Input::get('Batch');
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
    $getCourseName = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseName');
	$getNVQLevel = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseLevel');
	$getDuration = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('Duration');
	$Packages = MOCenterMonitoringPlan::getPackages($CD_ID);
    $html = '';

     $sql = 'select coursedetails.CourseName,modatetask.Batch,
	 module.ModuleName,module.ModuleCode,
	 motask.TaskName,motask.TaskCode,
	 modatecalender.Date,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                       on modatetask.CD_ID=coursedetails.CD_ID
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year="'.$Year.'"
                      and modatetask.Batch like "'.$Batch.'"
					  and modatetask.CD_ID="'.$CD_ID.'"
                      ';
     $TimeTable = DB::select(DB::raw($sql));
    $i = 1;
    $taskname = '';
    $modulename = '';
$html='<html><head>
   
    </head>
    <body>
	<br/>
	<br/>
	<br/>
	
	<h1><center><b>'.$getCourseName.' </b></center></h1><br/>
	<br/><h2><center><b>NVQ Level '.$getNVQLevel.'</br></br>Qualification Packages: ';
	foreach($Packages as $qp)
	{
		$html.='<span>'. $qp->packagecode .'   </span>';
	}
	
	$html.='</br></br>Duration: '.$getDuration.'</br></br>'.$Year.' Batch '.$Batch.'</b></center></h2>
	</br>
	</br>
	<h3><center>';
	$html.='<img src="assets\VTA.jpg" alt="Smiley face" height="100" width="160"/>';
	$html.='</br></br>
	<b>Training Division</br>Vocational Training Authority of Sri Lanka</b></center></h3>';
    $html.='<p style="page-break-before: always"></p>
  <center><h3><b>Time Table For '.$getCourseName.'-'.$getCourseListCode.' ('.$Year.') Batch - '.$Batch.'</center></h3><center><i>(Session = 1 - Morning & 2 - Evening)</i></center></b><font size="5px" face="Times New Roman" >
  <table style = "font-size:18px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<td align="center">No</td>
<td align="center">Year</td>
<td align="center">Batch</td>
<td align="center">Course</td>
<td align="center">WeekNo</td>
<td align="center">Date</td>
<td align="center">Day</td>
<td align="center">Session</td>
<td align="center">Module</td>
<td align="center">Task</td>
</thead><tbody>';
 foreach ($TimeTable as $aa) {

  $html.='<tr>
          <td>'.$i++.'</td>
          <td>'.$Year.'</td>
          <td>'.$Batch.'</td>
          <td>'.$getCourseName.'</td>
          <td>'.$aa->WeekNo.'</td>
          <td>'.$aa->Date.'</td>
          <td>'.$aa->Day.'</td>
          <td>'.$aa->Session.'</td>';
          if($aa->TaskSeqID == 999999)
          {
              $html.='<td>Continuous Assessments</td>
                      <td>Continuous Assessments</td></tr>'; 
          }
          elseif($aa->TaskSeqID == 999998)
          {
              $html.='<td>English/Career Skills</td>
                      <td>English/Career Skills</td></tr>'; 
          }
          elseif($aa->TaskSeqID == 999997)
          {
              $html.='<td>Orientation Program</td>
                      <td>Orientation Program</td></tr>'; 
          }
          else
          {
              $html.='<td>'.$aa->ModuleName.'('.$aa->ModuleCode.')</td>
                      <td>'.$aa->TaskName.'('.$aa->TaskCode.')</td></tr>'; 
          }

          
  }
   



    $html.='</tbody></table></font></body></html>';

    return $html;


  }

  public function ViewActualTimeTable()
  {
    $view = View::make('MOTimeTable.ViewActualTimeTableCourse');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
     $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
    return $view;
  }
  public function SearchMOActualTimeTable()
  {
    $view = View::make('MOTimeTable.ViewActualTimeTableCourse');
    $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
    $view->Trades = Trade::where('Deleted','=',0)->where('Active','=','Yes')->orderBy('TradeName')->get();
    $CD_ID = Input::get('CourseListCode'); //Course Detail tale id
    $Year = Input::get('Year');
    $Batch = Input::get('Batch');
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');

					  $sql = "select coursedetails.CourseName,modatetask.Batch,
					  module.ModuleName,module.ModuleCode,
					  motask.TaskName,motask.TaskCode,
					  modatecalender.Date,modatecalender.Month,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                      on modatetask.CD_ID=coursedetails.CD_ID
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year='$Year'
                      and modatetask.Batch like '$Batch'
                      and modatetask.CD_ID='$CD_ID'
					  order by modatetask.id";
    $TimeTable = DB::select(DB::raw($sql));
    $view->moduleTask = $TimeTable;
    $view->CDID = $CD_ID;
    $view->YearD = $Year;
    $view->BatchD = $Batch;

    return $view;
  }

  public function DownloadMOActualTimeTable()
  {
    $CD_ID = Input::get('CD_ID'); //Course Detail tale id
    $Year = Input::get('Year');
    $Batch = Input::get('Batch');
    $getCourseListCode = Course::where('Deleted', '!=', 1)->where('CD_ID','=',$CD_ID)->pluck('CourseListCode');
    

     $sql = 'select coursedetails.CourseName,modatetask.Batch,
	 module.ModuleName,module.ModuleCode,
	 motask.TaskName,motask.TaskCode,
	 modatecalender.Date,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                      on modatetask.CD_ID=coursedetails.CD_ID
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year="'.$Year.'"
                      and modatetask.Batch like "'.$Batch.'"
                      and modatetask.CD_ID="'.$CD_ID.'"
					  order by modatetask.id';
     $TimeTable = DB::select(DB::raw($sql));
    $i = 1;
    $taskname = '';
	$taskCode = '';
    $modulename = '';
	$ModuleCode = '';
     $excel = new SimpleExcel('csv');
     $printablearray = array();
     $headerArray = array('No','Year', 'Batch', 'CourseName', 'WeekNo','Date','Day','Session', 'Module','ModuleCode', 'Task','TaskCode');
    array_push($printablearray, $headerArray);
     foreach ($TimeTable as $aa) {

                      if($aa->TaskSeqID == 999999)
                        {
                          $taskname = 'Continuous Assessments';
                          $modulename = 'Continuous Assessments'; 
                        }
                        elseif($aa->TaskSeqID == 999998)
                        {
                          $taskname = 'English/Career Skills';
                          $modulename = 'English/Career Skills';
                        }
                        elseif($aa->TaskSeqID == 999997)
                        {
                          $taskname = 'Orientation Program';
                          $modulename = 'Orientation Program';
                        }
                        else
                        {
                         $taskname = $aa->TaskName;
                          $modulename = $aa->ModuleName;
						  $taskCode = $aa->TaskCode;
						  $ModuleCode = $aa->ModuleCode;
						  
                        }

      array_push($printablearray, array($i,$aa->Year, $aa->Batch, $aa->CourseName,$aa->WeekNo,$aa->Date,$aa->Day,$aa->Session,$modulename,$ModuleCode,$taskname,$taskCode));
      $i++;
     }
     $excel->writer->setData($printablearray);
     $excel->writer->saveFile('ActualTimeTable');
  }

public function CreateActualTimeTable()
{
  $view = View::make('MOTimeTable.ActualTimeTable');
  $method=Request::getMethod();
    
        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
                 $Year = Input::get('Year');
                 $Year1 = $Year + 1;
                 $jan = '01';
                 $dec = '01';
                 $f = '01';
                 $l = '01';
                 $e = '/';
                 //$Batch = Input::get('Batch');
                 $startDate = $Year.$e.$jan.$e.$f;
                 $endDate = $Year1.$e.$dec.$e.$l ;



                 $begin = new DateTime($startDate);
                 $end = new DateTime($endDate);
                 $format = 'Y-m-d';
                 $interval = new DateInterval('P1D'); // 1 Day
                 $dateRange = new DatePeriod($begin, $interval, $end);

                 //************************


                 //************************

                 $range = [];
                 $FinalDay = [];
                 $weeklist = [];
                 $monthlist = [];
                // $Available = MODateCalender::where('Year','=',$Year)->delete();
				 $Available = MODateCalender::where('Year','=',$Year)->update(array('Active' => 0));
                 
                 
                             foreach ($dateRange as $date) 
                             {

                             $timestamp = strtotime($date->format($format));
                             $day = date('D', $timestamp);
                             $week = date('W', $timestamp);
                             $month = date('M', $timestamp);
                            

                             $getavailableInHolyday = Holiday::where('Holidaydate','=',$date->format($format))->where('Deleted','=',0)->where('Active','=',1)->get();
                             $Count = count($getavailableInHolyday);

                             if($Count == 0)
                             {

                                    if($day == 'Mon' )
                                    {
                                       $range[] = $date->format($format);
                                       $FinalDay[] = $day;
                                       $weeklist[] = $week;
                                       $monthlist[] = $month;
                                    }
                                    elseif($day == 'Tue' )
                                    {
                                       $range[] = $date->format($format);
                                       $FinalDay[] = $day;
                                       $weeklist[] = $week;
                                       $monthlist[] = $month;
                                    }
                                    elseif($day == 'Wed' )
                                    {
                                       $range[] = $date->format($format);
                                       $FinalDay[] = $day;
                                       $weeklist[] = $week;
                                       $monthlist[] = $month;
                                    }
                                    elseif($day == 'Thu' )
                                    {
                                       $range[] = $date->format($format);
                                       $FinalDay[] = $day;
                                       $weeklist[] = $week;
                                       $monthlist[] = $month;
                                    }
                                    elseif($day == 'Fri' )
                                    {
                                       $range[] = $date->format($format);
                                       $FinalDay[] = $day;
                                       $weeklist[] = $week;
                                       $monthlist[] = $month;
                                    }
                                    else
                                    {

                                    }
                          }
                      }//close foreach

               // return $weeklist;
              // insert data to the table
              
                      $sizeOFrange = sizeof($range);
                      $sizeOFDates = sizeof($FinalDay);
                      for($i=0;$i<$sizeOFrange;$i++)
                      {
                          $c = new MODateCalender();
                          $c->Year = $Year;
                          $c->Month = $monthlist[$i];
                          $c->WeekNo = $weeklist[$i];
                          $c->Day = $FinalDay[$i];
                          $c->Date = $range[$i];
                          $c->User = User::getSysUser()->userID; 
                          $c->Session = 1;
						  $c->Active=1;
                          $c->save();
                          $d = new MODateCalender();
                          $d->Year = $Year;
                          $d->Month = $monthlist[$i];
                          $d->WeekNo = $weeklist[$i];
                          $d->Day = $FinalDay[$i];
                          $d->Date = $range[$i];
                          $d->Session = 2;
						  $d->Active=1;
                          $d->User = User::getSysUser()->userID; 
                          $d->save();

                      }//close for save


                    

                  $courses = MODateCalender::where('Deleted','=',0)->where('Active','=',1)->where('Year','=',$Year)->orderBy('id')->get(); 
                  $view->courses = $courses;
                     return $view;

        }
}


public function GenarateActualTimeTable()
{
  $view = View::make('MOTimeTable.GenarateActualTimeTable');
  $method=Request::getMethod();
        if($method == 'GET')
        {
            return $view;

        }
		if($method == 'POST')
		{
		  $Year = Input::get('Year');
          $Batch = Input::get('Batch');
          $K = 1;
          $TOKEN = 'a';
          $html = '';
          $rt = 0;
          $getActualNoOfSessions = 0;
          $YearPlanID = Input::get('Course');
          $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
		  
          //$CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
		  $CD_ID = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr( $DurationValue, 0, -2);
          $StartDate = Input::get('StartDate');
          $sql78 = "SELECT DATE_SUB(DATE_ADD('$StartDate', INTERVAL '$duration' MONTH),INTERVAL 2 DAY) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
           $sql = "select modatecalender.id,modatecalender.Date,modatecalender.Session
                  from modatecalender
                  where modatecalender.Deleted=0
				  and modatecalender.Active=1
                  and modatecalender.Date>='$StartDate'
                  and modatecalender.Date<='$expectedcom'
				  order by modatecalender.Date,modatecalender.Session";
                  $AllMODateCalender = DB::select(DB::raw($sql));
          $y = count($AllMODateCalender);
          $NewDates =  json_decode(json_encode((array)$AllMODateCalender),true);
		  //***
          // $deleteAllFrommodatetask = MODateTask::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
          //return $duration;
          /* if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          } */
		  
		  $sss = 0;//only use for 2021 batch 1 others unblock above code
          
          

           
         
          //Update CourseYearPlan StartDate *****
		 
		 
		 //****
          //$updateCourseYearPlan = CourseYearPlan::where('CourseListCode','=',$getCourseListCode)->where('batch','=',$Batch)->update(array('RealstartDate' => $StartDate));

          $AllTaskSequens = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->where('Active','=',1)->orderBy('orderMT')->get();
          $x = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->where('Active','=',1)->sum('noofsessions');
          $x = floor($y/10)+$x+$sss+2;//Do +2 for continueous Assessment
          $ActualNoOfSession = '';
          $AllTaskSequenceIDs = '';
		  $ActinStatus = '';
		  $GapDifference = 0;
		  //***
          //$deleteAllFromActualTaskSequence = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
          
			 if($y>$x)
			 {
				$ActinStatus = 'CalenderGreater';
				$GapDifference = ($y-$x); 
			 }
			 elseif($x>$y)
			 {
				$ActinStatus = 'TaskSeqGreater';
				$GapDifference = ($x-$y); 
			 }
			  elseif($x==$y)
			 {
				$ActinStatus = 'TaskSeqEqualCalender';
				$GapDifference = 0; 
			 }
			 else{
			 }
			 
			  //$DistinctNoOFSesssions = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->groupBy('noofsessions')->orderBy('noofsessions')->get();
			  $DistinctNoOFSesssions = DB::select(DB::raw("select motaskseq.noofsessions,count(id) as Occurences
								  from motaskseq
								  where courseid='".$CD_ID."'
								  and deleted=0
								  and Active=1
								  group by noofsessions
								  order by noofsessions"));
			 
			 
			 $view->ActinStatus = $ActinStatus;
			 $view->GapDifference = $GapDifference;
			 $view->DistinctNoOFSesssions = $DistinctNoOFSesssions;
			 $view->Year = $Year;
			 $view->Batch = $Batch;
			 $view->YearPlanID = $YearPlanID;
			 $view->StartDate = $StartDate;
			 $view->x = $x;
			 $view->y = $y;
			 return $view;
			 
		}
       
}

public function saveMOdateTasks()
{

}

public function GetMOCourselistCodes()
{
  $year = Input::get('Year');
  $Batch = Input::get('Batch');
  $sql = "select courseyearplan.id,coursedetails.CourseName,coursedetails.CourseListCode,coursedetails.CourseType,coursedetails.Nvq,coursedetails.CourseLevel,coursedetails.Duration
  from courseyearplan
  left join coursedetails
  on courseyearplan.CD_ID=coursedetails.CD_ID
  where courseyearplan.Deleted=0
  and courseyearplan.Year='$year'
  and courseyearplan.batch like '$Batch'
  group by coursedetails.CourseListCode,courseyearplan.Year,courseyearplan.batch";
  $res = DB::select(DB::raw($sql));

  return json_encode($res);
}


public function GetOrmit()
{
          $Year = Input::get('Year');
          $Batch = Input::get('Batch');
          $K = 1;
          $TOKEN = 'a';
          $html = '';
          $rt = 0;
          $getActualNoOfSessions = 0;
          $YearPlanID = Input::get('Course');
          $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
          $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr( $DurationValue, 0, -2);
          $StartDate = Input::get('StartDate');
          $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
           $sql = "select modatecalender.id,modatecalender.Date,modatecalender.Session
                  from modatecalender
                  where modatecalender.Deleted=0
                  and modatecalender.Date>='$StartDate'
                  and modatecalender.Date<='$expectedcom'";
                  $AllMODateCalender = DB::select(DB::raw($sql));
          $y = count($AllMODateCalender);
          $NewDates =  json_decode(json_encode((array)$AllMODateCalender),true);
           $deleteAllFrommodatetask = MODateTask::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
//return $duration;
          if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          }
          
          for($HH=0;$HH<$sss;$HH++)
          {
           

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999997;//Orientation Program
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                              $rt = $rt +1;
          }
          //return $rt;

           
         
          //Update CourseYearPlan StartDate *****
		 // $updateCourseYearPlan = CourseYearPlan::where('id','=',$YearPlanID)->update(array('RealstartDate' => $StartDate));
          $updateCourseYearPlan = CourseYearPlan::where('CourseListCode','=',$getCourseListCode)->where('Year','=',$Year)->where('batch','like',$Batch)->update(array('RealstartDate' => $StartDate));

          $AllTaskSequens = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->orderBy('orderMT')->get();
          $x = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->sum('noofsessions');
          $x = floor($x/10)+$x+$sss;//Do +2 for continueous Assessment
          $ActualNoOfSession = '';
          $AllTaskSequenceIDs = '';
          $deleteAllFromActualTaskSequence = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
          $R = 0;
           $z = round(($y/$x),1);

             if($z>= 0 && $z<1)
             {
                //$R = 0.5;
				$R = 1;
             }
             elseif($z>=1 && $z<1.5)
             {
                $R = 1;
                
             }
             elseif($z>=1.5 && $z<2)
             {
                $R = 1.5;
                 
             }
             elseif($z>=2 && $z<2.5)
             {
               $R = 2;
             }
             else
             {
               $R = 1;
             }
              foreach($AllTaskSequens as $t)
              {

                 //$ActualNoOfSession = round(($t->noofsessions*($y/$x)),0);
                /*if($t->noofsessions == 0.5)
                {
                  $noofsession = 1;
				  $ActualNoOfSession = round($noofsession*1,1);
                }
                else
                {
                  $noofsession = $t->noofsessions;
				  $ActualNoOfSession = round($noofsession*$R,1);
                }*/
                   
                   $AllTaskSequenceIDs = $t->id;
				   $ActualNoOfSession = round($t->noofsessions*$R,1);

                   $u = new MOActualTaskSeq();
                   $u->TaskSequenceID = $AllTaskSequenceIDs;
				   if($ActualNoOfSession == '0.5')
				   {
                    $u->ActualNoOfSessions = 1;
				   }
				    // elseif($ActualNoOfSession== 6)
				   // {
					   // $u->ActualNoOfSessions = 6;
				   // }
				    elseif($ActualNoOfSession== 2.5)
				   {
					   $u->ActualNoOfSessions = 2;
				   }
				   // elseif($ActualNoOfSession== 5)
				   // {
					   // $u->ActualNoOfSessions = 6;
				   // }
				  // elseif($ActualNoOfSession== 4)
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				    // elseif($ActualNoOfSession== 3)
				   // {
					   // $u->ActualNoOfSessions = 3.5;
				   // }
				   // elseif($ActualNoOfSession== 1.5)
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   // elseif($ActualNoOfSession== 6)
				   // {
					   // $u->ActualNoOfSessions = 6;
				   // }
				     elseif($ActualNoOfSession== 4.5)
				   {
					   $u->ActualNoOfSessions = 3.5;
				   }
				   // elseif($ActualNoOfSession== 7.5)
				   // {
					   // $u->ActualNoOfSessions = 9;
				   // }
				   // elseif($ActualNoOfSession== 3)
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   elseif($ActualNoOfSession== 2)
				   {
					   $u->ActualNoOfSessions = 1.5;
				   }
				   // elseif($ActualNoOfSession== 8)
				   // {
					   // $u->ActualNoOfSessions = 7;
				   // }
				   // elseif($ActualNoOfSession== 10)
				   // {
					   // $u->ActualNoOfSessions = 11;
				   // }
				   // elseif($ActualNoOfSession== 7)
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   // elseif($ActualNoOfSession== 15)
				   // {
					   // $u->ActualNoOfSessions = 14;
				   // }
				   elseif($ActualNoOfSession== 9)
				   {
					   $u->ActualNoOfSessions = 6;
				   }
				   // elseif($ActualNoOfSession == '1')
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   // elseif($ActualNoOfSession == '120')
				   // {
					   // $u->ActualNoOfSessions = 105;
				   // }
				   // elseif($ActualNoOfSession == '27')
				   // {
					   // $u->ActualNoOfSessions = 24;
				   // }
				   // elseif($ActualNoOfSession == '12')
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   // elseif($ActualNoOfSession == '2')
				   // {
					   // $u->ActualNoOfSessions = 1.5;
				   // }
				   // elseif($ActualNoOfSession == '13')
				    // {
					    // $u->ActualNoOfSessions = 12.5;
				   // }
				   // elseif($ActualNoOfSession == '18')
				    // {
					    // $u->ActualNoOfSessions = 15.5;
				   // }
				   // elseif($ActualNoOfSession == '14')
				    // {
					    // $u->ActualNoOfSessions = 15;
				   // }
				    // elseif($ActualNoOfSession == '15')
				    // {
					    // $u->ActualNoOfSessions = 16;
				   // }
				   // elseif($ActualNoOfSession == '35')
				    // {
					    // $u->ActualNoOfSessions = 31;
				   // }
				    // elseif($ActualNoOfSession == '16')
				    // {
					    // $u->ActualNoOfSessions = 17;
				   // } 
				   // elseif($ActualNoOfSession == '18')
				    // {
					    // $u->ActualNoOfSessions = 18;
				   // }
				    // elseif($ActualNoOfSession == '36')
				    // {
					    // $u->ActualNoOfSessions = 33.5;
				   // }
				   else{
					   $u->ActualNoOfSessions = $ActualNoOfSession;
					   
				   }
                   $u->Year = $Year;
                   $u->Batch = $Batch;
                   $u->CourseListCode = $getCourseListCode;
                   $u->Order = $t->orderMT;
                   $u->User = User::getSysUser()->userID; 
                   $u->save();
              }
            $T1 = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->sum('ActualNoOfSessions');
           
            $T2 = $y;
           $M = 0;
           $Ormit = 0;
              if($T2>$T1)
              {
                $M = $T2 - ($T1+(ceil($y/10)+3));
                if($M<10)
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  //$Ormit = 0;
				  $Ormit = 0;
                }
                elseif($M>=10)
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  $Ormit = 0;
                }
                else
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  $Ormit = 0;
                }
            }else{
				 $M = $T1 - ($T2+(ceil($y/10)+3));
				$Revisiondates = ceil($M/2);// Change floor to ceil
                  $Ormit = 0;
				
			}
             //if t1>t2
            //return $Revisiondates;
          if($Ormit == 0)
          {
             $M = $T2 - $T1;  
                $AllActualTaskSeqList = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->orderBy('Order')->get();
                
                $remain = 0;
                foreach ($AllActualTaskSeqList as $h) 
                {

                 
                    $TaskSeqID = $h->TaskSequenceID;
                    $CourseListCode = $h->CourseListCode;
                    $MOYear = $h->Year;
                    $MOBatch = $h->Batch;
                   

                    $getActualNoOfSessions+= $h->ActualNoOfSessions;
                   
                    
                 
                         for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {

                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }

                            $rt = $rt + 1;
							$a = $a-1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
							  }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                             }
                               
                              
                          }
                          else
                          {
                             

                             ///////
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }
                              $rt = $rt + 1;
                              
                             ////// 
                              
                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
								 if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$rt= $rt+1;
                         
                              
                              $f->save();
							  }
                          }

                          }

                        
                          


                        }
                        

                  $K = $a;
                 // $rt = $rt +1;

                  
                }// main forloop

                   $deleteMORevision = MORevisionDate::where('CourseListCode','=',$getCourseListCode)->delete();      
                       $getActualNoOfSessions+= $M;
                       for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                                if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }
                            $rt = $rt + 1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $b = new MORevisionDate();
                              //$b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
                              }

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                              { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
                            }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                              
                             }
                             
                          }
                          else
                          {

///////////////////////////////////////////////////////////////
                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch;
								$f->CD_ID = $CD_ID;							  
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID;
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];							  
                              $b->save(); 
							  }
                              $rt = $rt + 1;

                              ///////////////////////////////////////////////////

                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$getActualNoOfSessions = $getActualNoOfSessions +1;
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
							  }
                          }

                          }

                          
                          


                        }//ormit for loop

          
                      $courses1 = DB::select(DB::raw("select coursedetails.CourseName,modatetask.Batch,module.ModuleName,motask.TaskName,modatecalender.Date,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                      on modatetask.CD_ID=coursedetails.CD_ID
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year='$Year'
                      and modatetask.Batch like '$Batch'
                      and modatetask.CourseListCode='$getCourseListCode'"));
                      // $view->courses = $courses1;
                      // return $view;

                      $html=' <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead> 
                        <tr>
                        <th class="center">No</th>
                        <th class="center">Year</th>
                        <th class="center">Batch</th>
                        <th class="center">Course</th>
                        <th class="center">Week No</th>
                        <th class="center">Date</th>
                        <th class="center">Day</th>
                        <th class="center">Session</th>
                        <th class="center">Module</th>
                        <th class="center">Task</th>
                        </tr>
                       </thead>
                       <tbody>';
                       $tt=1;
                       foreach ($courses1 as $mm ) {
                        $html.='<tr>
                        <td class="center">'.$tt++.'</td>
                        <td class="center">'.$mm->Year.'</td>
                        <td class="center">'.$mm->Batch.'</td>
                        <td class="center">'.$mm->CourseName.'</td>
                        <td class="center">'.$mm->WeekNo.'</td>
                        <td class="center">'.$mm->Date.'</td>
                        <td class="center">'.$mm->Day.'</td>
                        <td class="center">'.$mm->Session.'</td>';
                        
                        if($mm->TaskSeqID == 999999)
                        {
                          $html.='<td class="center">Continuous Assessments</td><td class="center">Continuous Assessments</td>
                        </tr>';
                        }
                        elseif($mm->TaskSeqID == 999998)
                        {
                          $html.='<td class="center">English/Career Skills</td><td class="center">English/Career Skills</td>
                        </tr>';
                        }
                        elseif($mm->TaskSeqID == 999997)
                        {
                          $html.='<td class="center">Oriantation</td><td class="center">Oriantation</td>
                        </tr>';
                        }
                        else
                        {
                          $html.='<td class="center">'.$mm->ModuleName.'</td><td class="center">'.$mm->TaskName.'</td>
                        </tr>';
                        }
                       }



                       $html.='</tbody>
                       </table>';

                       return $html;
                      }//if ormit 0
                      if($Ormit == 1)
                      {

                        $html = '<form action="SaveDatesOrmit" method="POST" class="form-horizontal">
                        <pre><center><font color="red"><b><i>Fill '.$Revisiondates.' Dates For Continuous Assessments between '.$StartDate.' & '.$expectedcom.' </i></b></font></center></pre>';
                        $gg=1;
                        for($vv=0;$vv<$Revisiondates;$vv++)
                        {
                          $html.='
                          <div class="control-group">
                          <label class="control-label" for="centers">Continuous Assessments Date: '.$gg++.'</label>
                          <div class="controls">
                             <input type="date" name="Datelist[]" id="Datelist[]" min="'.$StartDate.'" max="'.$expectedcom.'" required="true" />
                          </div>
                          </div>';
                        }
                        $html.='<input type="hidden" name="Year" id="Year" value="'.$Year.'" />
                        <input type="hidden" name="Batch" id="Batch" value="'.$Batch.'" />
                        <input type="hidden" name="Course" id="Course" value="'.$YearPlanID.'" />
                        <input type="hidden" name="StartDate" id="StartDate" value="'.$StartDate.'" />
                        <div class="control-group">
                    <div class="controls">
                        <button type="button"  id="sub" class="btn btn-success">
                        <i class="icon-eye-open bigger-100"></i>Save Continuous Assessments Dates</button>
                                
                    </div>
                </div>   </form>';

                        return $html;

                      }//if ormit =1
    }//close function
/*
public function GetOrmit()
{
          $Year = Input::get('Year');
          $Batch = Input::get('Batch');
          $K = 1;
          $TOKEN = 'a';
          $html = '';
          $rt = 0;
          $getActualNoOfSessions = 0;
          $YearPlanID = Input::get('Course');
          $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
          $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr( $DurationValue, 0, -2);
          $StartDate = Input::get('StartDate');
          $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
           $sql = "select modatecalender.id,modatecalender.Date,modatecalender.Session
                  from modatecalender
                  where modatecalender.Deleted=0
                  
                  and modatecalender.Date>='$StartDate'
                  and modatecalender.Date<='$expectedcom'";
                  $AllMODateCalender = DB::select(DB::raw($sql));
          $y = count($AllMODateCalender);
          $NewDates =  json_decode(json_encode((array)$AllMODateCalender),true);
           $deleteAllFrommodatetask = MODateTask::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
//return $duration;
          if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          }
          
          for($HH=0;$HH<$sss;$HH++)
          {
           

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999997;//Orientation Program
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
                              $f->User = User::getSysUser()->userID;
                              $f->CD_ID = $CD_ID; 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                              $rt = $rt +1;
          }
          //return $rt;

           
         
          //Update CourseYearPlan StartDate *****
		 // $updateCourseYearPlan = CourseYearPlan::where('id','=',$YearPlanID)->update(array('RealstartDate' => $StartDate));
          $updateCourseYearPlan = CourseYearPlan::where('CourseListCode','=',$getCourseListCode)->where('batch','=',$Batch)->update(array('RealstartDate' => $StartDate));

          $AllTaskSequens = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->orderBy('orderMT')->get();
          $x = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->sum('noofsessions');
          $x = floor($x/10)+$x+$sss;
          $ActualNoOfSession = '';
          $AllTaskSequenceIDs = '';
          $deleteAllFromActualTaskSequence = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
          $R = 0;
           $z = round(($y/$x),1);

             if($z>= 0 && $z<1)
             {
                //$R = 0.5;
				$R = 1;
             }
             elseif($z>=1 && $z<1.5)
             {
                $R = 1;
                
             }
             elseif($z>=1.5 && $z<2)
             {
                $R = 1.5;
                 
             }
             elseif($z>=2 && $z<2.5)
             {
               $R = 2;
             }
             else
             {
               $R = 1;
             }
              foreach($AllTaskSequens as $t)
              {

                   //$ActualNoOfSession = round(($t->noofsessions*($y/$x)),0);
                // if($t->noofsessions == 0.5)
                // {
                  // $noofsession = 1;
				  // $ActualNoOfSession = round($noofsession*1,1);
                // }
                // else
                // {
                  // $noofsession = $t->noofsessions;
				  // $ActualNoOfSession = round($noofsession*$R,1);
                // }
                   
                   $AllTaskSequenceIDs = $t->id;
				   $ActualNoOfSession = round($t->noofsessions*$R,1);

                   $u = new MOActualTaskSeq();
                   $u->TaskSequenceID = $AllTaskSequenceIDs;
				    if($ActualNoOfSession == '0.5')
				   {
                    $u->ActualNoOfSessions = 1;
				   }
				    elseif($ActualNoOfSession== 6)
				   {
					   $u->ActualNoOfSessions = 5;
				   }
				    // elseif($ActualNoOfSession== 2.5)
				   // {
					   // $u->ActualNoOfSessions = 2.5;
				   // }
				   elseif($ActualNoOfSession== 5)
				   {
					   $u->ActualNoOfSessions = 4;
				   }
				  elseif($ActualNoOfSession== 4)
				   {
					   $u->ActualNoOfSessions = 3;
				   }
				   elseif($ActualNoOfSession== 3)
				   {
					   $u->ActualNoOfSessions = 2.5;
				   }
				   elseif($ActualNoOfSession== 2)
				   {
					   $u->ActualNoOfSessions = 2;
				   }
				   // elseif($ActualNoOfSession== 8)
				   // {
					   // $u->ActualNoOfSessions = 7;
				   // }
				   // elseif($ActualNoOfSession== 10)
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   elseif($ActualNoOfSession== 7)
				   {
					   $u->ActualNoOfSessions = 6;
				   }
				   // elseif($ActualNoOfSession== 15)
				   // {
					   // $u->ActualNoOfSessions = 14;
				   // }
				   // elseif($ActualNoOfSession== 9)
				   // {
					   // $u->ActualNoOfSessions = 8;
				   // }
				   // elseif($ActualNoOfSession == '1')
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   // elseif($ActualNoOfSession == '120')
				   // {
					   // $u->ActualNoOfSessions = 105;
				   // }
				   // elseif($ActualNoOfSession == '27')
				   // {
					   // $u->ActualNoOfSessions = 24;
				   // }
				   // elseif($ActualNoOfSession == '12')
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   // elseif($ActualNoOfSession == '2')
				   // {
					   // $u->ActualNoOfSessions = 1.5;
				   // }
				   // elseif($ActualNoOfSession == '13')
				    // {
					    // $u->ActualNoOfSessions = 12.5;
				   // }
				   elseif($ActualNoOfSession == '18')
				    {
					    $u->ActualNoOfSessions = 15.5;
				   }
				    // elseif($ActualNoOfSession == '15')
				    // {
					    // $u->ActualNoOfSessions = 14.5;
				   // }
				   // elseif($ActualNoOfSession == '35')
				    // {
					    // $u->ActualNoOfSessions = 31;
				   // }
				    // elseif($ActualNoOfSession == '16')
				    // {
					    // $u->ActualNoOfSessions = 14;
				   // } 
				   // elseif($ActualNoOfSession == '18')
				    // {
					    // $u->ActualNoOfSessions = 18;
				   // }
				    elseif($ActualNoOfSession == '36')
				    {
					    $u->ActualNoOfSessions = 33.5;
				   }
				   else{
					   $u->ActualNoOfSessions = $ActualNoOfSession;
				   }
                   $u->Year = $Year;
                   $u->Batch = $Batch;
                   $u->CourseListCode = $getCourseListCode;
                   $u->Order = $t->orderMT;
                   $u->User = User::getSysUser()->userID; 
                   $u->save();
              }
            $T1 = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->sum('ActualNoOfSessions');
           
            $T2 = $y;
           $M = 0;
           $Ormit = 0;
              if($T2>$T1)
              {
                $M = $T2 - ($T1+(ceil($y/10)+3));
                if($M<10)
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  //$Ormit = 0;
				  $Ormit = 1;
                }
                elseif($M>=10)
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  $Ormit = 1;
                }
                else
                {
                  $Revisiondates = ceil($M/2)-1;// Change floor to ceil
                  $Ormit = 1;
                }
            }else{
				 $M = $T1 - ($T2+(ceil($y/10)+3));
				$Revisiondates = ceil($M/2);// Change floor to ceil
                  $Ormit = 1;
				
			}
             //if t1>t2
            //return $Revisiondates;
          if($Ormit == 0)
          {
             $M = $T2 - $T1;  
                $AllActualTaskSeqList = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->orderBy('Order')->get();
                
                $remain = 0;
                foreach ($AllActualTaskSeqList as $h) 
                {

                 
                    $TaskSeqID = $h->TaskSequenceID;
                    $CourseListCode = $h->CourseListCode;
                    $MOYear = $h->Year;
                    $MOBatch = $h->Batch;
                   

                    $getActualNoOfSessions+= $h->ActualNoOfSessions;
                   
                    
                 
                         for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {

                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
                              $f->User = User::getSysUser()->userID;
							  $f->CD_ID = $CD_ID;
                              if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }

                            $rt = $rt + 1;
							$a = $a-1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
                              $f->User = User::getSysUser()->userID;
							  $f->CD_ID = $CD_ID;
                               if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
							  }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                             }
                               
                              
                          }
                          else
                          {
                             

                             ///////
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
                              $f->User = User::getSysUser()->userID;
							  $f->CD_ID = $CD_ID;
                               if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }
                              $rt = $rt + 1;
                              
                             ////// 
                              
                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = $TaskSeqID;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
                              $f->User = User::getSysUser()->userID;
							  $f->CD_ID = $CD_ID;
								 if(!empty($NewDates[$rt]['id'])) 
							  {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$rt= $rt+1;
                         
                              
                              $f->save();
							  }
                          }

                          }

                        
                          


                        }
                        

                  $K = $a;
                 // $rt = $rt +1;

                  
                }// main forloop

                   $deleteMORevision = MORevisionDate::where('CourseListCode','=',$getCourseListCode)->delete();      
                       $getActualNoOfSessions+= $M;
                       for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                                if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }
                            $rt = $rt + 1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $b = new MORevisionDate();
                              //$b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
                              }

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
                              $f->User = User::getSysUser()->userID;
							  $f->CD_ID = $CD_ID;
                              if(!empty($NewDates[$rt]['id']))
                              { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
                            }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                              
                             }
                             
                          }
                          else
                          {

///////////////////////////////////////////////////////////////
                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID;
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];							  
                              $b->save(); 
							  }
                              $rt = $rt + 1;

                              ///////////////////////////////////////////////////

                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$getActualNoOfSessions = $getActualNoOfSessions +1;
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
							  }
                          }

                          }

                          
                          


                        }//ormit for loop

          
                      $courses1 = DB::select(DB::raw("select coursedetails.CourseName,modatetask.Batch,module.ModuleName,motask.TaskName,modatecalender.Date,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                      on modatetask.CourseListCode=coursedetails.CourseListCode
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year='$Year'
                      and modatetask.Batch='$Batch'
                      and modatetask.CourseListCode='$getCourseListCode'"));
                      // $view->courses = $courses1;
                      // return $view;

                      $html=' <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead> 
                        <tr>
                        <th class="center">No</th>
                        <th class="center">Year</th>
                        <th class="center">Batch</th>
                        <th class="center">Course</th>
                        <th class="center">Week No</th>
                        <th class="center">Date</th>
                        <th class="center">Day</th>
                        <th class="center">Session</th>
                        <th class="center">Module</th>
                        <th class="center">Task</th>
                        </tr>
                       </thead>
                       <tbody>';
                       $tt=1;
                       foreach ($courses1 as $mm ) {
                        $html.='<tr>
                        <td class="center">'.$tt++.'</td>
                        <td class="center">'.$mm->Year.'</td>
                        <td class="center">'.$mm->Batch.'</td>
                        <td class="center">'.$mm->CourseName.'</td>
                        <td class="center">'.$mm->WeekNo.'</td>
                        <td class="center">'.$mm->Date.'</td>
                        <td class="center">'.$mm->Day.'</td>
                        <td class="center">'.$mm->Session.'</td>';
                        
                        if($mm->TaskSeqID == 999999)
                        {
                          $html.='<td class="center">Continuous Assessments</td><td class="center">Continuous Assessments</td>
                        </tr>';
                        }
                        elseif($mm->TaskSeqID == 999998)
                        {
                          $html.='<td class="center">English</td><td class="center">English</td>
                        </tr>';
                        }
                        elseif($mm->TaskSeqID == 999997)
                        {
                          $html.='<td class="center">Oriantation</td><td class="center">Oriantation</td>
                        </tr>';
                        }
                        else
                        {
                          $html.='<td class="center">'.$mm->ModuleName.'</td><td class="center">'.$mm->TaskName.'</td>
                        </tr>';
                        }
                       }



                       $html.='</tbody>
                       </table>';

                       return $html;
                      }//if ormit 0
                      if($Ormit == 1)
                      {

                        $html = '<form action="SaveDatesOrmit" method="POST" class="form-horizontal">
                        <pre><center><font color="red"><b><i>Fill '.$Revisiondates.' Dates For Continuous Assessments between '.$StartDate.' & '.$expectedcom.' </i></b></font></center></pre>';
                        $gg=1;
                        for($vv=0;$vv<$Revisiondates;$vv++)
                        {
                          $html.='
                          <div class="control-group">
                          <label class="control-label" for="centers">Continuous Assessments Date: '.$gg++.'</label>
                          <div class="controls">
                             <input type="date" name="Datelist[]" id="Datelist[]" min="'.$StartDate.'" max="'.$expectedcom.'" required="true" />
                          </div>
                          </div>';
                        }
                        $html.='<input type="hidden" name="Year" id="Year" value="'.$Year.'" />
                        <input type="hidden" name="Batch" id="Batch" value="'.$Batch.'" />
                        <input type="hidden" name="Course" id="Course" value="'.$YearPlanID.'" />
                        <input type="hidden" name="StartDate" id="StartDate" value="'.$StartDate.'" />
                        <div class="control-group">
                    <div class="controls">
                        <button type="button"  id="sub" class="btn btn-success">
                        <i class="icon-eye-open bigger-100"></i>Save Continuous Assessments Dates</button>
                                
                    </div>
                </div>   </form>';

                        return $html;

                      }//if ormit =1
    }//close function
	*/
	public function SaveDatesOrmit()
    {
          $Year = Input::get('Year');
         $Batch = Input::get('Batch');
         $YearPlanID = Input::get('Course');
         $StartDate = Input::get('StartDate');
         $Dates = [];
         $Dates = Input::get('dates');
         $sizeoffakedates = sizeof($Dates);
         $realfakedatesArray = [];
         for($bb=0;$bb<$sizeoffakedates;$bb++)
         {
            $realfakedatesArray[$bb] = $Dates[$bb]["value"];
         }
         
          $K = 1;
          $TOKEN = 'a';
          $html = '';
          $getActualNoOfSessions = 0;
           $rt = 0; 
          //return $realfakedatesArray;
         
          $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
          $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr( $DurationValue, 0, -2);
          
          $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
          $sql = "select modatecalender.id,modatecalender.Date,modatecalender.Session
                  from modatecalender
                  where modatecalender.Deleted=0
                  /*and modatecalender.Year='2018'*/
                  and modatecalender.Date>='$StartDate'
                  and modatecalender.Date<='$expectedcom'";
           $AllMODateCalender = DB::select(DB::raw($sql));
          $y = count($AllMODateCalender);
         $NewDates =  json_decode(json_encode((array)$AllMODateCalender),true);
         $deleteAllFrommodatetask = MODateTask::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
         if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          }
          
          for($HH=0;$HH<$sss;$HH++)
          {
           

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999997;//Orientation Program
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }
                              $rt = $rt +1;
          }

         // morevisiondate
         $deleteMORevision = MORevisionDate::where('CourseListCode','=',$getCourseListCode)->delete();
         


         // morevisiondate
          //Update CourseYearPlan StartDate *****
          //$updateCourseYearPlan = CourseYearPlan::where('id','=',$YearPlanID)->update(array('RealstartDate' => $StartDate));
		  $updateCourseYearPlan = CourseYearPlan::where('CourseListCode','=',$getCourseListCode)->where('batch','like',$Batch)->update(array('RealstartDate' => $StartDate));

          $AllTaskSequens = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->orderBy('orderMT')->get();
           $x = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->sum('noofsessions');
            $x = floor($x/10)+$x+$sss;
          $ActualNoOfSession = '';
          $AllTaskSequenceIDs = '';
          $deleteAllFromActualTaskSequence = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
          $R = 0;
           $z = round(($y/$x),1);

             if($z>= 0 && $z<1)
             {
               // $R = 0.5;
			   $R = 1;
             }
             elseif($z>=1 && $z<1.5)
             {
                $R = 1;
             }
             elseif($z>=1.5 && $z<2)
             {
                $R = 1.5;
             }
             elseif($z>=2 && $z<2.5)
             {
               $R = 2;
             }
             else
             {
               $R = 1;
             }
              foreach($AllTaskSequens as $t)
              {

                   //$ActualNoOfSession = round(($t->noofsessions*($y/$x)),0);
                /*if($t->noofsessions == 0.5)
                {
                  $noofsession = 1;
				  $ActualNoOfSession = round($noofsession*1,1);
                }
                else
                {
                  $noofsession =$t->noofsessions;
				  $ActualNoOfSession = round($noofsession*$R,1);
                }*/
                   
                   $AllTaskSequenceIDs = $t->id;
				   $ActualNoOfSession = round($t->noofsessions*$R,1);

                   $u = new MOActualTaskSeq();
                   $u->TaskSequenceID = $AllTaskSequenceIDs;
                     if($ActualNoOfSession == '0.5')
				   {
                    $u->ActualNoOfSessions = 1;
				   }
				    // elseif($ActualNoOfSession== 6)
				   // {
					   // $u->ActualNoOfSessions = 6;
				   // }
				    elseif($ActualNoOfSession== 2.5)
				   {
					   $u->ActualNoOfSessions = 2;
				   }
				   // elseif($ActualNoOfSession== 5)
				   // {
					   // $u->ActualNoOfSessions = 6;
				   // }
				  // elseif($ActualNoOfSession== 4)
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				    // elseif($ActualNoOfSession== 3)
				   // {
					   // $u->ActualNoOfSessions = 3.5;
				   // }
				   // elseif($ActualNoOfSession== 1.5)
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   // elseif($ActualNoOfSession== 6)
				   // {
					   // $u->ActualNoOfSessions = 6;
				   // }
				     elseif($ActualNoOfSession== 4.5)
				   {
					   $u->ActualNoOfSessions = 3.5;
				   }
				   // elseif($ActualNoOfSession== 7.5)
				   // {
					   // $u->ActualNoOfSessions = 9;
				   // }
				   // elseif($ActualNoOfSession== 3)
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   elseif($ActualNoOfSession== 2)
				   {
					   $u->ActualNoOfSessions = 1.5;
				   }
				   // elseif($ActualNoOfSession== 8)
				   // {
					   // $u->ActualNoOfSessions = 7;
				   // }
				   // elseif($ActualNoOfSession== 10)
				   // {
					   // $u->ActualNoOfSessions = 11;
				   // }
				   // elseif($ActualNoOfSession== 7)
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   // elseif($ActualNoOfSession== 15)
				   // {
					   // $u->ActualNoOfSessions = 14;
				   // }
				   elseif($ActualNoOfSession== 9)
				   {
					   $u->ActualNoOfSessions = 6;
				   }
				   // elseif($ActualNoOfSession == '1')
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   // elseif($ActualNoOfSession == '120')
				   // {
					   // $u->ActualNoOfSessions = 105;
				   // }
				   // elseif($ActualNoOfSession == '27')
				   // {
					   // $u->ActualNoOfSessions = 24;
				   // }
				   // elseif($ActualNoOfSession == '12')
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   // elseif($ActualNoOfSession == '2')
				   // {
					   // $u->ActualNoOfSessions = 1.5;
				   // }
				   // elseif($ActualNoOfSession == '13')
				    // {
					    // $u->ActualNoOfSessions = 12.5;
				   // }
				   // elseif($ActualNoOfSession == '18')
				    // {
					    // $u->ActualNoOfSessions = 15.5;
				   // }
				   // elseif($ActualNoOfSession == '14')
				    // {
					    // $u->ActualNoOfSessions = 15;
				   // }
				    // elseif($ActualNoOfSession == '15')
				    // {
					    // $u->ActualNoOfSessions = 16;
				   // }
				   // elseif($ActualNoOfSession == '35')
				    // {
					    // $u->ActualNoOfSessions = 31;
				   // }
				    // elseif($ActualNoOfSession == '16')
				    // {
					    // $u->ActualNoOfSessions = 17;
				   // } 
				   // elseif($ActualNoOfSession == '18')
				    // {
					    // $u->ActualNoOfSessions = 18;
				   // }
				    // elseif($ActualNoOfSession == '36')
				    // {
					    // $u->ActualNoOfSessions = 33.5;
				   // }
				   else{
					   $u->ActualNoOfSessions = $ActualNoOfSession;
					   
				   }
                   $u->Year = $Year;
                   $u->Batch = $Batch;
                   $u->CourseListCode = $getCourseListCode;
                   $u->Order = $t->orderMT;
                   $u->User = User::getSysUser()->userID; 
                   $u->save();
              }
           $T1 = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->sum('ActualNoOfSessions');
           $T1 = $T1;
           $T2 = $y;
           $M = 0;
           $Ormit = 0;
            
              if($T2>$T1)
              {
                $M = $T2 - ($T1+(ceil($y/10)+3));
                if($M <10)
                {
                  $Revisiondates = ceil($M/2);// Change floor to ceil
				  $Ormit = 0;
                  //$Ormit = 1; //correct
                }
                elseif($M>=10)
                {
                  $Revisiondates = ceil($M/2);// Change floor to ceil
                 // $Ormit = 1; //for test
				  $Ormit = 0;
                }
                else
                {
                  $Revisiondates = ceil($M/2);// Change floor to ceil
                  //$Ormit = 1;  //for test
				  $Ormit = 0;
                }
            }

            
                $AllActualTaskSeqList = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','like',$Batch)->where('CourseListCode','=',$getCourseListCode)->orderBy('Order')->get();
               

                  foreach ($AllActualTaskSeqList as $h) 
                {

                 
                    $TaskSeqID = $h->TaskSequenceID;
                    $CourseListCode = $h->CourseListCode;
                    $MOYear = $h->Year;
                    $MOBatch = $h->Batch;
                    $getActualNoOfSessions+= $h->ActualNoOfSessions;

                 //$K ==11;
                         for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {


                           if(($rt+1) % 10 == 0)
                          {

                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                            { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                            $rt = $rt + 1;
                            $a = $a-1;
                          }
                          else
                          {
                            if(!empty($NewDates[$rt]['id']))
                            {
                            $checkdateinID = $NewDates[$rt]['id'];
                          $checkdate = $NewDates[$rt]['Date'];
                        }
                        else
                        {
                          $checkdateinID = '';
                          $checkdate ='';
                        }

                          if(in_array($checkdate, $realfakedatesArray))
                          {

                              $b = new MORevisionDate();
                              if(!empty($NewDates[$rt]['id']))
                            {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                            }
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
                              if(!empty($NewDates[$rt]['id']))
                            {
                              $b->save();
                            }

                              $f = new MODateTask();
                              
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch;
								$f->CD_ID = $CD_ID;							  
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                            {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							   $f->save();
                            }
                              $rt = $rt + 1;
                              $a = $a - 1;
                                
                          }
                          else
                          {
                              $remain = $getActualNoOfSessions-$a;
                              if($remain != '0.5')
                              {
                                  

                                  $f = new MODateTask();
                              
                                  $f->TaskSeqID = $TaskSeqID;
                                  $f->CourseListCode = $CourseListCode;
                                  $f->Year = $MOYear;
                                  $f->Batch = $MOBatch; 
								  $f->CD_ID = $CD_ID;
                                  $f->User = User::getSysUser()->userID;
                                  if(!empty($NewDates[$rt]['id']))
                            {
                                  $f->MODateCalenderID = $NewDates[$rt]['id'];
								   $f->save();
                                }
                                  if($TOKEN = 'a')
                                  {
                                     $rt = $rt + 1;
                                  }
                                 else
                                 {
                                   $TOKEN = 'a';
                                 }
                                
                              }
                              else
                              {

                                  ///////
                                  $f = new MODateTask();
                                
                                    $f->TaskSeqID = $TaskSeqID;
                                    $f->CourseListCode = $CourseListCode;
                                    $f->Year = $MOYear;
                                    $f->Batch = $MOBatch; 
									$f->CD_ID = $CD_ID;
                                    $f->User = User::getSysUser()->userID;
                                    if(!empty($NewDates[$rt]['id']))
                            {
                                    $f->MODateCalenderID = $NewDates[$rt]['id'];
                                    $f->save();
                                  }
                                    $rt = $rt + 1;
                                    
                                   ////// 
                                  $f = new MODateTask();
                                  $TOKEN = 'b';
                                  $f->TaskSeqID = $TaskSeqID;
                                  $f->CourseListCode = $CourseListCode;
                                  $f->Year = $MOYear;
                                  $f->Batch = $MOBatch;
									$f->CD_ID = $CD_ID;
                                  $f->User = User::getSysUser()->userID;
                                  if(!empty($NewDates[$rt]['id']))
                            {
                                  $f->MODateCalenderID = $NewDates[$rt]['id'];
                                  
                                  $f->save();
                                }
                              }
                          }

                          }

                          
                         

                          


                        }

                  $K = $a;

                  
                }// main forloop
                $getActualNoOfSessions+= $M;
                       for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                                if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }
                            $rt = $rt + 1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $b = new MORevisionDate();
                              //$b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
                              }

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                              { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
                            }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                              
                             }
                             
                          }
                          else
                          {

///////////////////////////////////////////////////////////////
                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID;
							   if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save(); 
							  }
                              $rt = $rt + 1;

                              ///////////////////////////////////////////////////

                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$getActualNoOfSessions = $getActualNoOfSessions +1;
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
							  }
                          }

                          }

                          
                          


                        }//ormit for loop

                $courses1 = DB::select(DB::raw("select coursedetails.CourseName,modatetask.Batch,module.ModuleName,motask.TaskName,modatecalender.Date,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                      on modatetask.CD_ID=coursedetails.CD_ID
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year='$Year'
                      and modatetask.Batch='$Batch'
                      and modatetask.CourseListCode='$getCourseListCode'"));
                      // $view->courses = $courses1;
                      // return $view;

                      $html=' <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead> 
                        <tr>
                        <th class="center">No</th>
                        <th class="center">Year</th>
                        <th class="center">Batch</th>
                        <th class="center">Course</th>
                        <th class="center">Week No</th>
                        <th class="center">Date</th>
                        <th class="center">Day</th>
                        <th class="center">Session</th>
                        <th class="center">Module</th>
                        <th class="center">Task</th>
                        </tr>
                       </thead>
                       <tbody>';
                       $tt=1;
                       foreach ($courses1 as $mm ) {
                        $html.='<tr>
                        <td class="center">'.$tt++.'</td>
                        <td class="center">'.$mm->Year.'</td>
                        <td class="center">'.$mm->Batch.'</td>
                        <td class="center">'.$mm->CourseName.'</td>
                        <td class="center">'.$mm->WeekNo.'</td>
                        <td class="center">'.$mm->Date.'</td>
                        <td class="center">'.$mm->Day.'</td>
                        <td class="center">'.$mm->Session.'</td>
                        ';
                        if($mm->TaskSeqID == 999999)
                        {
                          $html.='<td class="center">Continuous Assessments</td><td class="center">Continuous Assessments</td>
                        </tr>';
                        }
                         elseif($mm->TaskSeqID == 999998)
                        {
                          $html.='<td class="center">English/Career Skills</td><td class="center">English/Career Skills</td>
                        </tr>';
                        }
                        elseif($mm->TaskSeqID == 999997)
                        {
                          $html.='<td class="center">Oriantation</td><td class="center">Oriantation</td>
                        </tr>';
                        }
                        else
                        {
                          $html.='<td class="center">'.$mm->ModuleName.'</td><td class="center">'.$mm->TaskName.'</td>
                        </tr>';
                        }

                        
                       }



                       $html.='</tbody>
                       </table>';

                       return $html;

    }

/*
    public function SaveDatesOrmit()
    {
          $Year = Input::get('Year');
         $Batch = Input::get('Batch');
         $YearPlanID = Input::get('Course');
         $StartDate = Input::get('StartDate');
         $Dates = [];
         $Dates = Input::get('dates');
         $sizeoffakedates = sizeof($Dates);
         $realfakedatesArray = [];
         for($bb=0;$bb<$sizeoffakedates;$bb++)
         {
            $realfakedatesArray[$bb] = $Dates[$bb]["value"];
         }
         
          $K = 1;
          $TOKEN = 'a';
          $html = '';
          $getActualNoOfSessions = 0;
           $rt = 0; 
          //return $realfakedatesArray;
         
          $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
          $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr( $DurationValue, 0, -2);
          
          $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
          $sql = "select modatecalender.id,modatecalender.Date,modatecalender.Session
                  from modatecalender
                  where modatecalender.Deleted=0
                 
                  and modatecalender.Date>='$StartDate'
                  and modatecalender.Date<='$expectedcom'";
           $AllMODateCalender = DB::select(DB::raw($sql));
          $y = count($AllMODateCalender);
         $NewDates =  json_decode(json_encode((array)$AllMODateCalender),true);
         $deleteAllFrommodatetask = MODateTask::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
         if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          }
          
          for($HH=0;$HH<$sss;$HH++)
          {
           

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999997;//Orientation Program
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
							  }
                              $rt = $rt +1;
          }

         // morevisiondate
         $deleteMORevision = MORevisionDate::where('CourseListCode','=',$getCourseListCode)->delete();
         


         // morevisiondate
          //Update CourseYearPlan StartDate *****
          //$updateCourseYearPlan = CourseYearPlan::where('id','=',$YearPlanID)->update(array('RealstartDate' => $StartDate));
		  $updateCourseYearPlan = CourseYearPlan::where('CourseListCode','=',$getCourseListCode)->where('batch','=',$Batch)->update(array('RealstartDate' => $StartDate));

          $AllTaskSequens = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->orderBy('orderMT')->get();
           $x = TaskSeq::where('courseid','=',$CD_ID)->where('deleted','=',0)->sum('noofsessions');
            $x = floor($x/10)+$x+$sss;
          $ActualNoOfSession = '';
          $AllTaskSequenceIDs = '';
          $deleteAllFromActualTaskSequence = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->delete();
          $R = 0;
           $z = round(($y/$x),1);

             if($z>= 0 && $z<1)
             {
               // $R = 0.5;
			   $R = 1;
             }
             elseif($z>=1 && $z<1.5)
             {
                $R = 1;
             }
             elseif($z>=1.5 && $z<2)
             {
                $R = 1.5;
             }
             elseif($z>=2 && $z<2.5)
             {
               $R = 2;
             }
             else
             {
               $R = 1;
             }
              foreach($AllTaskSequens as $t)
              {

                   //$ActualNoOfSession = round(($t->noofsessions*($y/$x)),0);
                // if($t->noofsessions == 0.5)
                // {
                  // $noofsession = 1;
				  // $ActualNoOfSession = round($noofsession*1,1);
                // }
                // else
                // {
                  // $noofsession =$t->noofsessions;
				  // $ActualNoOfSession = round($noofsession*$R,1);
                // }
                   
                   $AllTaskSequenceIDs = $t->id;
				   $ActualNoOfSession = round($t->noofsessions*$R,1);

                   $u = new MOActualTaskSeq();
                   $u->TaskSequenceID = $AllTaskSequenceIDs;
                  if($ActualNoOfSession == '0.5')
				   {
                    $u->ActualNoOfSessions = 1;
				   }
				    elseif($ActualNoOfSession== 6)
				   {
					   $u->ActualNoOfSessions = 5;
				   }
				    // elseif($ActualNoOfSession== 2.5)
				   // {
					   // $u->ActualNoOfSessions = 2.5;
				   // }
				   elseif($ActualNoOfSession== 5)
				   {
					   $u->ActualNoOfSessions = 4;
				   }
				  elseif($ActualNoOfSession== 4)
				   {
					   $u->ActualNoOfSessions = 3;
				   }
				   elseif($ActualNoOfSession== 3)
				   {
					   $u->ActualNoOfSessions = 2.5;
				   }
				   elseif($ActualNoOfSession== 2)
				   {
					   $u->ActualNoOfSessions = 2;
				   }
				   // elseif($ActualNoOfSession== 8)
				   // {
					   // $u->ActualNoOfSessions = 7;
				   // }
				   // elseif($ActualNoOfSession== 10)
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   elseif($ActualNoOfSession== 7)
				   {
					   $u->ActualNoOfSessions = 6;
				   }
				   // elseif($ActualNoOfSession== 15)
				   // {
					   // $u->ActualNoOfSessions = 14;
				   // }
				   // elseif($ActualNoOfSession== 9)
				   // {
					   // $u->ActualNoOfSessions = 8;
				   // }
				   // elseif($ActualNoOfSession == '1')
				   // {
					   // $u->ActualNoOfSessions = 1;
				   // }
				   // elseif($ActualNoOfSession == '120')
				   // {
					   // $u->ActualNoOfSessions = 105;
				   // }
				   // elseif($ActualNoOfSession == '27')
				   // {
					   // $u->ActualNoOfSessions = 24;
				   // }
				   // elseif($ActualNoOfSession == '12')
				   // {
					   // $u->ActualNoOfSessions = 10;
				   // }
				   // elseif($ActualNoOfSession == '2')
				   // {
					   // $u->ActualNoOfSessions = 1.5;
				   // }
				   // elseif($ActualNoOfSession == '13')
				    // {
					    // $u->ActualNoOfSessions = 12.5;
				   // }
				   elseif($ActualNoOfSession == '18')
				    {
					    $u->ActualNoOfSessions = 15.5;
				   }
				    // elseif($ActualNoOfSession == '15')
				    // {
					    // $u->ActualNoOfSessions = 14.5;
				   // }
				   // elseif($ActualNoOfSession == '35')
				    // {
					    // $u->ActualNoOfSessions = 31;
				   // }
				    // elseif($ActualNoOfSession == '16')
				    // {
					    // $u->ActualNoOfSessions = 14;
				   // } 
				   // elseif($ActualNoOfSession == '18')
				    // {
					    // $u->ActualNoOfSessions = 18;
				   // }
				    elseif($ActualNoOfSession == '36')
				    {
					    $u->ActualNoOfSessions = 33.5;
				   }
				   else{
					   $u->ActualNoOfSessions = $ActualNoOfSession;
				   }
                   $u->Year = $Year;
                   $u->Batch = $Batch;
                   $u->CourseListCode = $getCourseListCode;
                   $u->Order = $t->orderMT;
                   $u->User = User::getSysUser()->userID; 
                   $u->save();
              }
           $T1 = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->sum('ActualNoOfSessions');
           $T1 = $T1;
           $T2 = $y;
           $M = 0;
           $Ormit = 0;
            
              if($T2>$T1)
              {
                $M = $T2 - ($T1+(ceil($y/10)+3));
                if($M <10)
                {
                  $Revisiondates = ceil($M/2);// Change floor to ceil
				  $Ormit = 0;
                  //$Ormit = 1; //correct
                }
                elseif($M>=10)
                {
                  $Revisiondates = ceil($M/2);// Change floor to ceil
                 // $Ormit = 1; //for test
				  $Ormit = 0;
                }
                else
                {
                  $Revisiondates = ceil($M/2);// Change floor to ceil
                  //$Ormit = 1;  //for test
				  $Ormit = 0;
                }
            }

            
                $AllActualTaskSeqList = MOActualTaskSeq::where('Year','=',$Year)->where('Batch','=',$Batch)->where('CourseListCode','=',$getCourseListCode)->orderBy('Order')->get();
               

                  foreach ($AllActualTaskSeqList as $h) 
                {

                 
                    $TaskSeqID = $h->TaskSequenceID;
                    $CourseListCode = $h->CourseListCode;
                    $MOYear = $h->Year;
                    $MOBatch = $h->Batch;
                    $getActualNoOfSessions+= $h->ActualNoOfSessions;

                 //$K ==11;
                         for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {


                           if(($rt+1) % 10 == 0)
                          {

                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch;
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                            { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                            $rt = $rt + 1;
                            $a = $a-1;
                          }
                          else
                          {
                            if(!empty($NewDates[$rt]['id']))
                            {
                            $checkdateinID = $NewDates[$rt]['id'];
                          $checkdate = $NewDates[$rt]['Date'];
                        }
                        else
                        {
                          $checkdateinID = '';
                          $checkdate ='';
                        }

                          if(in_array($checkdate, $realfakedatesArray))
                          {

                              $b = new MORevisionDate();
                              if(!empty($NewDates[$rt]['id']))
                            {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                            }
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
                              if(!empty($NewDates[$rt]['id']))
                            {
                              $b->save();
                            }

                              $f = new MODateTask();
                              
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                            {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							   $f->save();
                            }
                              $rt = $rt + 1;
                              $a = $a - 1;
                                
                          }
                          else
                          {
                              $remain = $getActualNoOfSessions-$a;
                              if($remain != '0.5')
                              {
                                  

                                  $f = new MODateTask();
                              
                                  $f->TaskSeqID = $TaskSeqID;
                                  $f->CourseListCode = $CourseListCode;
                                  $f->Year = $MOYear;
                                  $f->Batch = $MOBatch; 
								  $f->CD_ID = $CD_ID;
                                  $f->User = User::getSysUser()->userID;
                                  if(!empty($NewDates[$rt]['id']))
                            {
                                  $f->MODateCalenderID = $NewDates[$rt]['id'];
								   $f->save();
                                }
                                  if($TOKEN = 'a')
                                  {
                                     $rt = $rt + 1;
                                  }
                                 else
                                 {
                                   $TOKEN = 'a';
                                 }
                                
                              }
                              else
                              {

                                  ///////
                                  $f = new MODateTask();
                                
                                    $f->TaskSeqID = $TaskSeqID;
                                    $f->CourseListCode = $CourseListCode;
                                    $f->Year = $MOYear;
                                    $f->Batch = $MOBatch; 
									$f->CD_ID = $CD_ID;
                                    $f->User = User::getSysUser()->userID;
                                    if(!empty($NewDates[$rt]['id']))
                            {
                                    $f->MODateCalenderID = $NewDates[$rt]['id'];
                                    $f->save();
                                  }
                                    $rt = $rt + 1;
                                    
                                   ////// 
                                  $f = new MODateTask();
                                  $TOKEN = 'b';
                                  $f->TaskSeqID = $TaskSeqID;
                                  $f->CourseListCode = $CourseListCode;
                                  $f->Year = $MOYear;
                                  $f->Batch = $MOBatch; 
								  $f->CD_ID = $CD_ID;
                                  $f->User = User::getSysUser()->userID;
                                  if(!empty($NewDates[$rt]['id']))
                            {
                                  $f->MODateCalenderID = $NewDates[$rt]['id'];
                                  
                                  $f->save();
                                }
                              }
                          }

                          }

                          
                         

                          


                        }

                  $K = $a;

                  
                }// main forloop
                $getActualNoOfSessions+= $M;
                       for($a=$K;$a<=$getActualNoOfSessions;$a++)
                        {

                           if(($rt+1) % 10 == 0)
                          {
                            $f = new MODateTask();
                          
                              $f->TaskSeqID = 999998;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                                if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }
                            $rt = $rt + 1;
                          }
                          else
                          {
                            $remain = $getActualNoOfSessions-$a;
                          if($remain != 0.5)
                          {

                              $b = new MORevisionDate();
                              //$b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
                              }

                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                              if(!empty($NewDates[$rt]['id']))
                              { 
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
							  $f->save();
                            }
                              if($TOKEN = 'a')
                              {
                                 $rt = $rt + 1;
                              }
                             else
                             {
                               $TOKEN = 'a';

                              
                             }
                             
                          }
                          else
                          {

///////////////////////////////////////////////////////////////
                              $f = new MODateTask();
                          
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $CourseListCode;
                              $f->Year = $MOYear;
                              $f->Batch = $MOBatch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID;
							   if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save(); 
							  }
                              $rt = $rt + 1;

                              ///////////////////////////////////////////////////

                              $f = new MODateTask();
                              $TOKEN = 'b';
                              $f->TaskSeqID = 999999;
                              $f->CourseListCode = $getCourseListCode;
                              $f->Year = $Year;
                              $f->Batch = $Batch; 
							  $f->CD_ID = $CD_ID;
                              $f->User = User::getSysUser()->userID;
                               if(!empty($NewDates[$rt]['id']))
                              {
                              $f->MODateCalenderID = $NewDates[$rt]['id'];
                              //$getActualNoOfSessions = $getActualNoOfSessions +1;
                              $f->save();
                            }

                              $b = new MORevisionDate();
                              
                              $b->CourseListCode = $getCourseListCode;
                              $b->CDID = $CD_ID;
                              $b->User = User::getSysUser()->userID; 
							  if(!empty($NewDates[$rt]['id']))
                              {
							  $b->RevisionDateCalenderID = $NewDates[$rt]['id'];
                              $b->save();
							  }
                          }

                          }

                          
                          


                        }//ormit for loop

                $courses1 = DB::select(DB::raw("select coursedetails.CourseName,modatetask.Batch,module.ModuleName,motask.TaskName,modatecalender.Date,modatecalender.Day,modatecalender.Session,modatetask.Year,modatecalender.WeekNo,modatetask.TaskSeqID
                      from modatetask
                      left join modatecalender
                      on modatetask.MODateCalenderID=modatecalender.id
                      left join coursedetails
                      on modatetask.CourseListCode=coursedetails.CourseListCode
                      left join motaskseq
                      on modatetask.TaskSeqID=motaskseq.id
                      left join module
                      on motaskseq.moduleid=module.ModuleId
                      left join motask
                      on motaskseq.taskid=motask.id
                      where modatetask.Deleted=0
                      and modatetask.Year='$Year'
                      and modatetask.Batch='$Batch'
                      and modatetask.CourseListCode='$getCourseListCode'"));
                      // $view->courses = $courses1;
                      // return $view;

                      $html=' <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead> 
                        <tr>
                        <th class="center">No</th>
                        <th class="center">Year</th>
                        <th class="center">Batch</th>
                        <th class="center">Course</th>
                        <th class="center">Week No</th>
                        <th class="center">Date</th>
                        <th class="center">Day</th>
                        <th class="center">Session</th>
                        <th class="center">Module</th>
                        <th class="center">Task</th>
                        </tr>
                       </thead>
                       <tbody>';
                       $tt=1;
                       foreach ($courses1 as $mm ) {
                        $html.='<tr>
                        <td class="center">'.$tt++.'</td>
                        <td class="center">'.$mm->Year.'</td>
                        <td class="center">'.$mm->Batch.'</td>
                        <td class="center">'.$mm->CourseName.'</td>
                        <td class="center">'.$mm->WeekNo.'</td>
                        <td class="center">'.$mm->Date.'</td>
                        <td class="center">'.$mm->Day.'</td>
                        <td class="center">'.$mm->Session.'</td>
                        ';
                        if($mm->TaskSeqID == 999999)
                        {
                          $html.='<td class="center">Continuous Assessments</td><td class="center">Continuous Assessments</td>
                        </tr>';
                        }
                         elseif($mm->TaskSeqID == 999998)
                        {
                          $html.='<td class="center">English</td><td class="center">English</td>
                        </tr>';
                        }
                        elseif($mm->TaskSeqID == 999997)
                        {
                          $html.='<td class="center">Oriantation</td><td class="center">Oriantation</td>
                        </tr>';
                        }
                        else
                        {
                          $html.='<td class="center">'.$mm->ModuleName.'</td><td class="center">'.$mm->TaskName.'</td>
                        </tr>';
                        }

                        
                       }



                       $html.='</tbody>
                       </table>';

                       return $html;

    }
*/
    public function CheckRevisionDate()
    {
         $Year = Input::get('Year');
         $Batch = Input::get('Batch');
         $YearPlanID = Input::get('Course');
         $StartDate = Input::get('StartDate');
         $getCourseListCode = CourseYearPlan::where('id','=',$YearPlanID)->pluck('CourseListCode');
          $CD_ID = Course::where('CourseListCode','=',$getCourseListCode)->pluck('CD_ID');
          $DurationValue = Course::where('CD_ID','=',$CD_ID)->pluck('Duration');
          $duration = substr( $DurationValue, 0, -2);
         
          $sql78 = "SELECT DATE_ADD('$StartDate', INTERVAL '$duration' MONTH) AS dd";
          $newdu = DB::select(DB::raw($sql78));
          $newdata =  json_decode(json_encode((array)$newdu),true);
          $expectedcom = $newdata[0]["dd"];
		  
		  if($duration == 1)
          {
            $sss = 1;//0.5 days
          }
          elseif($duration == 2)
          {
            $sss = 1;//1 days
          }
          elseif($duration == 3)
          {
            $sss = 2;//2 days
          }
          elseif($duration == 6)
          {
            $sss = 4;//3 days
          }
          elseif($duration == 9)
          {
            $sss = 6;//4 days
          }
          else
          {
            $sss = 8;//5 days
          }
          

         
          
          $Dates = [];
          $Dates = Input::get('dates');
          $saturday = [];
          $sunday = [];
          $holydays = [];
          $Orientation = [];
          $availableHolyday = [];
          $availableOrientationdays = [];
          $sizeoffakedates = sizeof($Dates);
          $realfakedatesArray = [];
          $html = '';
           $sql111 = "select distinct modatecalender.Date
                from modatecalender
                 where modatecalender.Deleted=0
                and modatecalender.Date>='$StartDate'
                and modatecalender.Date<='$expectedcom'
                limit $sss";
          $orientationDates = DB::select(DB::raw($sql111));

          foreach ($orientationDates as $o) {
            $Orientation [] = $o->Date;
          }

         for($bb=0;$bb<$sizeoffakedates;$bb++)
         {
            if(!empty($Dates[$bb]["value"]))
            {
                $realfakedatesArray[$bb] = $Dates[$bb]["value"];
            }
         }

        // return $realfakedatesArray;
         $sql = "select holiday.Holidaydate
                from holiday
                where holiday.Deleted=0
                and holiday.Holidaydate>='$StartDate'
                and holiday.Holidaydate<='$expectedcom'";
        $Hdates = DB::select(DB::raw($sql));
        $RFDCount = count($realfakedatesArray);
        $rr = 0;
        foreach ($Hdates as $gg ) {
         
          $holydays [] = $gg->Holidaydate;
        }

        //return $holydays;

            for($rr=0;$rr<$RFDCount;$rr++)
            {
              $chk = $realfakedatesArray[$rr];

              if(in_array($chk, $holydays))
              {
                $availableHolyday [] = $chk;
              }
              elseif(in_array($chk, $Orientation))
              {
                $availableOrientationdays [] = $chk;
              }
              else
              {
                $begin = new DateTime($chk);
                $format = "Y-m-d";
                $timestamp = strtotime($begin->format($format));
                $dayeeee = date('D', $timestamp);
                if($dayeeee == 'Sat')
                {
                    $saturday [] = $chk;
                }
                elseif($dayeeee == 'Sun')
                {
                    $sunday [] = $chk;
                }
                else
                {

                }
              }
            }
            //check sat or sun




            if(count($availableHolyday) != 0 || count($saturday) != 0 || count($sunday) != 0 || count($availableOrientationdays) != 0) 
            {
              $html = '<div class="control-group">
                          
                          <div class="controls"><center><pre style="width:50%"><font color="blue"<i>Continuous Assessments Date Errors !!!!!!!</i></font></pre><table style="width:50%" id="sample-table-2" class="table table-striped table-bordered table-hover"><thead><tr><th>Date</th><th>Description</th></tr></thead><tbody>';

              for($t=0;$t<count($availableHolyday);$t++)
              {
                $html.='<tr><td><font color="red">'.$availableHolyday[$t].'</font></td><td><font color="red">Holyday</font></td</tr>';
              }
              for($f=0;$f<count($availableOrientationdays);$f++)
              {
                $html.='<tr><td><font color="DARKVIOLET">'.$availableOrientationdays[$f].'</font></td><td><font color="DARKVIOLET">Reserved For Orientation Program</font></td</tr>';
              }
              for($u=0;$u<count($saturday);$u++)
              {
                $html.='<tr><td><font color="green">'.$saturday[$u].'</font></td><td><font color="green">Saturday</font></td</tr>';
              }
              for($p=0;$p<count($sunday);$p++)
              {
                $html.='<tr><td><font color="green">'.$sunday[$p].'</font></td><td><font color="green">Sunday</font></td</tr>';
              }


              $html.='</tbody></table></center></div></div>';
            }
            else
            {
              $html = '';
            }

            return $html;
        }

}//close class
