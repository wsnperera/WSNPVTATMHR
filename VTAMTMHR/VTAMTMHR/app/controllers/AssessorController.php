<?php

use SimpleExcel\SimpleExcel;


class AssessorController extends BaseController {
	
	

  public function ExamPrintAdd()
  {
    	return $CourseYearPlanID = Input::get('CS_ID');
		$AssessmentNo = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('AssessmentNo');
		$courseyerplanrec = CourseYearPlan::where('id','=',$CourseYearPlanID)->first();
		$getOrganame = Organisation::where('id','=',$courseyerplanrec->OrgId)->pluck('OrgaName');
		$CourseDetailsRec = Course::where('CD_ID','=',$courseyerplanrec->CD_ID)->first();

        $GetFinalAssDates = ExamFinalAssessmentDates::where('YearPlanID','=',$CourseYearPlanID)->where('Deleted','=',0)->orderBy('FinalAssessmentDate')->get();
			$getNominatedAssesorList = DB::select(DB::raw("select assessor.AssessorId,assessor.Name,assessornomination.NominationType,assessor.DateEntered
																	  from assessornomination
																	  left join assessor
																	  on assessornomination.AssessorId=assessor.id
																	  where assessornomination.Deleted=0
																	  and assessornomination.AssessorActive=1
																	  and assessornomination.CYPID='".$CourseYearPlanID."'
																	  order by AssessorId"));

    //$TNAME = Trainee::where('id','=',$Otid)->pluck('NameWithInitials');

    $html = '';

    $html = '<html><head>
   <title>Addmission</title>
    </head>
    <body>
   
    <center><h4><b>Vocational Training Authority of Sri Lanka</br>
    '.$courseyerplanrec->Year.'- Batch '.$courseyerplanrec->batch.' Final Examination for '.$CourseDetailsRec->CourseName.'</br>
    Addmission Card</b></h4></center>
   <hr style="border: none; border-bottom: 4px solid black;">
 <table v:shapes="_x0000_s1026" cellpadding=2 cellspacing=0 width=500 height=46
 border=0 dir=ltr style="border-collapse:collapse;">
 <tr>
  <td width=312 height=46 valign=Top style="width:500pt;height:34.4559pt;
  border:solid #1F497D .5pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US;align=center">Name Of the Candidate :</span></p>
  </td>
 </tr>
</table>
<table v:shapes="_x0000_s1027" cellpadding=2 cellspacing=0 width=370 height=46
 border=0 dir=ltr style="border-collapse:collapse;position:absolute;top:71.64pt;left:385.25pt;z-index:2">
 <tr>
  <td width=312 height=46 valign=Top style="width:392.26pt;height:34.4559pt;
 border:solid #1F497D .5pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">*Correct Name :</span></p>
  </td>
 </tr>
</table>
<span lang=en-US style="language:en-US">*If Your name Incorrect. Please write your correct name above box </span>
<table v:shapes="_x0000_s1026" cellpadding=2 cellspacing=0 width=360 height=46
 border=0 dir=ltr style="border-collapse:collapse;">
 <tr>
  <td width=312 height=46 valign=Top style="width:255.8117pt;height:34.4559pt;
  border:solid #1F497D .5pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US;align=center">Index Number :</span></p>
  </td>
 </tr>
</table>
<table v:shapes="_x0000_s1027" cellpadding=2 cellspacing=0 width=200 height=46
 border=0 dir=ltr style="border-collapse:collapse;position:absolute;top:119.64pt;left:290.25pt;z-index:2">
 <tr>
  <td width=312 height=46 valign=Top style="width:264.26pt;height:34.4559pt;
 border:solid #1F497D .5pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US"><center>Medium : English</center></span></p>
  </td>
 </tr>
</table>
<br/>
<table v:shapes="_x0000_s1026" cellpadding=2 cellspacing=0 width=700 height=35
 border=0 dir=ltr style="border-collapse:collapse;">
 <tr>
  <td width=312 height=46 valign=Top style="width:255.8117pt;height:34.4559pt;
  border:solid #1F497D .5pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US;align=center">Examination Center : '.$getOrganame.'</span></p>
  </td>
 </tr>
</table>
<br/>
<b>Attestation of Signature</b>
<p class=MsoNormal style="language:en-US;text-align: justify;line-height:1.8;font-size:12pt">
Attestaion of signature before the examination is compulsory.Candidate"s signature should be attested by Assistant Director, Deputy Director or Director of VTA or head of Government school, Grama Niladari of the division, justice of the peace, Commissoner of Oaths. Attorney-at-Law of Notary public, a Commissoned office of the Army, Navy or air Force, a Government or Local Government staff officer in receipt of an annual salary of Rs. 240,360/- or over, the incumbent of a Buddhist Vihara, a Nayake Bddhist Monk, the incumbent of a place of worship of any other religion or a religious dignitory of standing of any other religion.<br/>
<i>Use of communication equipment is prohabited.</i><br/>
I am aware that although I appear for this examination, my candidature will be cancelled, if i do not possess the necessary qualifications or it is proved that i have violated the examination laws, rules & regulations.
</p>
<p style="font-size:12pt;line-height:1.8">
Signature of Candidate : .................................................<br/>
I certify that the above named candidate placed his/her signature in my presence today.<br/>
National Indentity Card No : ............................................................<br/>
Signature of Attester } ........................................  Date } .........................................
<br/>
Place of Attester     } .........................................<br/>
Name Designation & Address of Attester } .............................................................
<br/>
Rubber Stamp }
</p>
<p>................................................................................................................................................................................................................................</p>

<p style="page-break-after: always;">&nbsp;</p>


    
     
     <center><b>Identity Card</b></center><br/>
     <p style="language:en-US;text-align: justify;line-height:1.8;font-size:18px">To sit for this examination, you should present your national identity card or valid passport.<br/>
No other identity document would be accepted.</p>
<table align="center" border=1 width="800" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
<tr>
<td align="center">No</td>
<td align="center">Date</td>
<td align="center">Time</td>
<td align="center">Signature of the Candidate</td>
<td align="center">Assessor 01 Signature</td>
<td align="center">Assessor 02 Signature</td>
</tr>';

$i=1;
foreach($GetFinalAssDates as $d)
{


  $html .='<tr>
  <td align="center">'.$i++.'</td>
  <td align="center">'.$d->FinalAssessmentDate.'</td>
  <td align="center">9.00 am - 4.00 pm</td>
  <td align="center"></td>
   <td align="center"></td>
    <td align="center"></td>
  </tr>';
}
$html.='</table><br/><br/>';

$html.=' <p style="text-align: justify" >
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;National Identity Card No.  }&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date of issue  }</p>
<br/>
<br/>
     <p style="text-align: justify" >
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Supervisor  }&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date  }</p>
<br/>
<br/>
     <p style="text-align: justify" >
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.............................................................<br/>&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;U.K.Nanda<br/>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Director (Testing & Evaluation)</p>

   <br/>
   <br/>
   <br/>
   <br/>
   <br/>
    <br/>
     <br/> <br/> <br/> <br/> <br/> <br/>

    <p>..................................................................................................................................................................................................................................................</p>
    <p><b>Exam Time Table</b></p>
    <table align="center" border=1 width="800" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
    <td align="center">No</td>
<td align="center">Date</td>
<td align="center">Time</td>
<td align="center">Assessor 01 Name</td>
<td align="center">Assessor 02 Name</td>';
$i=1;

$ass01 = "select assessor.Name
  from assessornomination
  left join assessor
  on assessornomination.AssessorId=assessor.id
  where assessornomination.AssessorActive='1'
  and assessornomination.CS_ID='$CS_ID'
  limit 2";
  $data = DB::select(DB::raw($ass01));
foreach($GetFinalAssDates as $d)
{


  $html .='<tr>
  <td align="center">'.$i++.'</td>
  <td align="center">'.$d->FinalAssessmentDate.'</td>
  <td align="center">9.00 am - 4.00 pm</td>';
 foreach($getNominatedAssesorList as $kl)
  {
  $html.='<td align="center">'.$kl->Name.'</td>';

 }
  
  $html.='</tr>';
}

    $html.='</table>

    

    </body></html>';

return $html;

  }

  public function PrintNVQAddmissionCard()
  {
    $view = View::make('Assessor.PrintAddmission');
     $method=Request::getMethod();
    $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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
          $center = Input::get('center');
          $Course = Input::get('Course');

          $sql = "select nvqtraineetrans.id,trainee.NameWithInitials,trainee.NIC,trainee.training_no,nvqtraineetrans.AddmissionPrint
  from nvqtraineetrans
  left JOIN trainee
  on nvqtraineetrans.T_ID=trainee.id
  where nvqtraineetrans.CS_ID='$Course'
  and nvqtraineetrans.OrgaId='$center'
  and nvqtraineetrans.TVECSend='1'";

          $list = DB::select(DB::raw($sql));
          $view->trainees = $list;
          
          $view->CSID = $Course;
          return $view;

        }
  }

  public function ViewContinuousAssessmentMarks()
  {
     $method=Request::getMethod();
        $view = View::make('Diploma.ViewContAssessmentResult');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Type = $Type;
        
        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type', ['HO','DO'])
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
          $CS_ID = Input::get('Course');
          $Module = Input::get('Module');
          $center = Input::get('center');

          $view->MODULEID = $Module;
          $view->CSID = $CS_ID;
          $view->ORGAID = $center;

          $trainee = DB::select(DB::raw("select trainee.id,trainee.NameWithInitials,trainee.NIC,trainee.training_no
                                  from trainee
                                    left join coursestarted
                                    on trainee.CourseCode=coursestarted.CourseCode
                                    where trainee.Deleted=0
                                    and trainee.Dropout='No'
                                    and coursestarted.CS_ID='$CS_ID'"));
          $view->trainee = $trainee;

          $CAnolist = DB::select(DB::raw("select diplomacontiassessments.id,
                                        diplomacontiassessments.AssessmentNo
                                        from diplomacontiassessments
                                        where diplomacontiassessments.Deleted=0
                                        and diplomacontiassessments.CS_ID='$CS_ID'
                                        and diplomacontiassessments.ModuleId='$Module'")); 

          $view->CAnolist = $CAnolist;

          return $view;



        }

  }

  public function GetDipGetAssessmentTraineeList()
  {
    $CS_ID = Input::get('Course');
    $Module = Input::get('Module');
    $center = Input::get('center');
    $CANo = Input::get('CANo');
    $html = '';
    $i = 1;
    $sql = DB::select(DB::raw("select trainee.id,trainee.NameWithInitials,trainee.NIC,trainee.training_no
from trainee
  left join coursestarted
  on trainee.CourseCode=coursestarted.CourseCode
  where trainee.Deleted=0
  and trainee.Dropout='No'
  and coursestarted.CS_ID='$CS_ID'"));

     $html = "<pre><h6><center><b>Trainee List </b></center></h6></pre>  
              <table align='center' id='ROA' class='table table-striped table-bordered table-hover'>
                    <thead>
                        <tr>
               
                            <th class='center'>No</th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Training No</th>
                            <th>Enter Marks</th>
                              
                                  
                        </tr>
                    </thead>
                    <tbody>";
          $getenteredMark = '';
            foreach ($sql as $e) {

              $getenteredMark = DiplomaContAssessmentResult::getMark($CS_ID,$center,$e->id,$CANo,$Module);
                $html .='<tr>
              
                            <td class="center" style = "font-size:12px" >' . $i++ . '</td>
                            <td style = "font-size:12px" >' . $e->NameWithInitials . '</td>
                            <td style = "font-size:12px">' . $e->NIC . '</td>
                            <td style = "font-size:12px">' . $e->training_no . '</td>
                           
                            <td ><input type="text"   name="marks[]" value="'.$getenteredMark.'"/>
                             <input type="hidden" name="TIDs[]" value="' . $e->id . '"/>
                             <input type="hidden" name="Course" value="' . $CS_ID . '"/>
                             <input type="hidden" name="Module" value="' . $Module . '"/>
                             <input type="hidden" name="center" value="' . $center . '"/>
                             <input type="hidden" name="CANo" value="' . $CANo . '"/>


                             </td>
                          
                          
                          </tr>';
              
              
        
               
            }
            $html .= " </tbody></table></center>";

                  


                  return $html;



  }

  public function SaveDipGetAssessmentNo()
  {
    $CS_ID = Input::get('Course');
    $Module = Input::get('Module');
    $center = Input::get('center');
    $AssNo = Input::get('AssNo');
    $AssDate = Input::get('AssDate');

    $c = new DiplomaContAssessment();
    $c->OrgaId = $center;
    $c->CS_ID = $CS_ID; 
    $c->ModuleId = $Module;
    $c->AssessmentNo = $AssNo; 
    $c->Date = $AssDate;
    $c->User = User::getSysUser()->userID; 
    $c->save();

    $json = array("ModuleId" => 1);
            echo json_encode($json, 0);


  }

  public function DipGetAssessmentNo()
  {
    $CS_ID = Input::get('Course');
    $Module = Input::get('Module');
    $center = Input::get('center');
    $res = DB::select(DB::raw("select diplomacontiassessments.id,diplomacontiassessments.AssessmentNo,diplomacontiassessments.Date
  from diplomacontiassessments
  where diplomacontiassessments.Deleted=0
  and diplomacontiassessments.OrgaId='$center'
  and diplomacontiassessments.CS_ID='$CS_ID'
  and diplomacontiassessments.ModuleId='$Module'"));
         return json_encode($res);

  }

  public function DipGetModuleCourses()
  {
    $CS_ID = Input::get('Course');
        $res = DB::select(DB::raw("select module.ModuleId,module.ModuleName
  from modulecourse
  left join coursedetails
  on modulecourse.CourseListCode=coursedetails.CourseListCode
  left join coursestarted
  on coursedetails.CourseListCode=coursestarted.CourseListCode
  left join module
  on modulecourse.ModuleId=module.ModuleId
  where modulecourse.Deleted=0
  and coursestarted.CS_ID='$CS_ID'"));
         return json_encode($res);
  }

   public function DipGetNominatedCourses()
    {
        $centerid = Input::get('center');
        $res = DB::select(DB::raw("select coursestarted.CS_ID,
  coursestarted.CourseCode,
  coursedetails.CourseName
  from coursestarted
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
  where coursestarted.OrgaId='$centerid'
  and coursestarted.Deleted=0
  and coursedetails.CourseLevel='5'
  and coursestarted.Completed!='YES'"));
         return json_encode($res);
    

    }

  public function AddContinuousAssessmentMarks()
  {
    $method=Request::getMethod();
        $view = View::make('Diploma.AddContinuousassessmentMarks');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Type = $Type;
        
        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type', ['HO','DO'])
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
          $CS_ID = Input::get('Course');
          $Module = Input::get('Module');
          $center = Input::get('center');
          $CANo = Input::get('CANo');
          $TID = Input::get('TIDs');
          $marks = Input::get('marks');

          $count = count($marks);

          $deleteAll = DiplomaContAssessmentResult::where('DiplomaAssessmentId','=',$CANo)->delete();
          for($i=0;$i<$count;$i++)
          {
              if(!empty($marks[$i]))
              {

                $k = new DiplomaContAssessmentResult();
                $k->DiplomaAssessmentId = $CANo;
                $k->T_ID = $TID[$i];
                $k->Mark = $marks[$i];
                $k->OrgaId = $center;
                $k->CS_ID = $CS_ID;
                $k->User = User::getSysUser()->userID; 
                $k->save();

              }
          }


          return Redirect::to('AddContinuousAssessmentMarks');

        }
  }

  public function loadNICCertificateList()
  {
     $TNIC = Input::get('TNIC');
    // $traineeIDlist = Trainee::where('NIC','=',$TNIC)->where('Deleted','=',0)->where('Dropout','=','No')->lists('id');
     $html = '';

     $html1 = '';
     $ROAlist  = DB::select(DB::raw("select distinct nvqstudentmoduleroa.id,
  organisation.OrgaName,
  coursedetails.CourseName,
  coursestarted.CourseCode,
  nvqmodule.code,
  nvqmodule.name,
  nvqstudentmoduleroa.IssuedCertificate
  from nvqstudentmoduleroa
  left join nvqmodule
  on nvqstudentmoduleroa.UnitId=nvqmodule.id
  left join coursestarted
  on nvqstudentmoduleroa.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
  left join organisation
  on nvqstudentmoduleroa.OrgaId=organisation.id
  where nvqstudentmoduleroa.Deleted=0
  AND nvqstudentmoduleroa.IssuedCertificate=0
  and nvqstudentmoduleroa.T_ID IN(select trainee.id from trainee where trainee.Deleted=0 and trainee.Dropout='No' and trainee.NIC='$TNIC')"));
      $NVQlist  = DB::select(DB::raw("select distinct nvqstudentpackage.id,
  organisation.OrgaName,
  coursedetails.CourseName,
  coursestarted.CourseCode,
  nvqstudentpackage.PackageCode,nvqstudentpackage.IssuedCertificate
  from nvqstudentpackage
left join coursestarted
  on nvqstudentpackage.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
  left join organisation
  on nvqstudentpackage.OrgaId=organisation.id
  where nvqstudentpackage.Deleted=0
  AND nvqstudentpackage.IssuedCertificate=0
  and nvqstudentpackage.T_ID IN(select trainee.id from trainee where trainee.Deleted=0 and trainee.Dropout='No' and trainee.NIC='$TNIC')"));

     if (!empty($ROAlist)) {
            $html = "<div class='control-group'><form class='form-horizontal' method='POST' action='' id='cnfrmboot' >
                <div class='row-fluid span12' style='margin: 0px' 'overflow='auto'>
                    <div class='table-header'>
                    </div>
                   
          
          
             <pre><h6><center>ROA Certificate List  <b></b></center></h6></pre>  
              <table align='center' id='ROA' class='table table-striped table-bordered table-hover'>
                    <thead>
                        <tr>
               
                            <th class='center'>Center</th>
                            <th>Course Name</th>
                             <th>CourseCode</th>
                              <th>Unit Code</th>
                               <th>Unit</th>
                                <th>Certificate No</th>
                                  
                        </tr>
                    </thead>
                    <tbody>";
          
            foreach ($ROAlist as $e) {
                $html .='<tr>
              
                            <td class="center" style = "font-size:12px" >' . $e->OrgaName . '</td>
                            <td style = "font-size:12px" >' . $e->CourseName . '</td>
                            <td style = "font-size:12px">' . $e->CourseCode . '</td>
                            <td style = "font-size:12px">' . $e->code . '</td>
                            <td style = "font-size:12px">' . $e->name . '</td>
                            <td ><input type="text"   name="ROACertificateNo[]" />
                             <input type="hidden" name="ROARealIDs[]" value="' . $e->id . '"/></td>
                          
                          
                          </tr>';
              
              
        
               
            }
            $html .= " </tbody></table></center>"
                    . " </div></form></div>";






           // return $html;
        } else {
            //return 'No any students available';
          $html = '<font color="red">No any ROA Certificate available</font>';
        }
        if (!empty($NVQlist)) {
            $html1 = "<div class='control-group'>
            <form class='form-horizontal' method='POST' action='' id='cnfrmboot' >
                <div class='row-fluid span12' style='margin: 0px' 'overflow='auto'>
                    <div class='table-header'>
                    </div>
                   
          
          
             <pre><h6><center>NVQ Certificate List  <b></b></center></h6></pre>  
              <table align='center' id='NVQ' class='table table-striped table-bordered table-hover'>
                    <thead>
                        <tr>
               
                            <th class='center'>Center</th>
                            <th>Course Name</th>
                             <th>CourseCode</th>
                              <th>Package Code</th>
                              
                                <th>Certificate No</th>
                                
                        </tr>
                    </thead>
                    <tbody>";
          
            foreach ($NVQlist as $e) {
                $html1 .='<tr>
              
                            <td class="center" style = "font-size:12px" >' . $e->OrgaName . '</td>
                            <td style = "font-size:12px" >' . $e->CourseName . '</td>
                            <td style = "font-size:12px">' . $e->CourseCode . '</td>
                            <td style = "font-size:12px">' . $e->PackageCode . '</td>
                           
                            <td ><input type="text"   name="NVQCertificateNo[]" />
                            <input type="hidden" name="NVQRealIDs[]" value="' . $e->id . '"/>
                            </td>
                      
                          
                  </center>
                                </label>
                            </td></tr>';
              
              
        
               
            }
            $html1 .= " </tbody></table></center>"
                    . " </div></form></div>";






           // return $html;
        } else {
            //return 'No any students available';
          $html1 = '<font color="red">No any NVQ Certificates available</font>';
        }


        return json_encode(array('html' => $html, 'html1' => $html1));
  }

  public function CreateCertificateHandoverToStudent()
  {
    $view = View::make('Assessor.CreateCertificatehandover');
        $method=Request::getMethod();
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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

          //return 'zsdvg';
          $traineeNIC = Input::get('TNIC');
          $PersonNIC = Input::get('NIC');
          $PersonName = Input::get('Ename');
          $PersonMobile = Input::get('Mobile');
          $DateIssued = Input::get('DateIssued');
             // $ROAid = Input::get('ROAid');
          $ROACertificateNo = Input::get('ROACertificateNo');
               // count($ROACertificateNo);
              //$nvqPackagestdid = Input::get('nvqPackagestdid');
          $NVQCertificateNo = Input::get('NVQCertificateNo');
          $NVQRealIDs = Input::get('NVQRealIDs');
          $ROARealIDs = Input::get('ROARealIDs');
          $i = 0;
          $COUNRROA = count($ROACertificateNo);
          $COUNTNVQ = count($NVQCertificateNo);

               for($i=0;$i<$COUNRROA;$i++)
               {

                  if(!empty($ROACertificateNo[$i]))
                  {
                     $getROAtableid = $ROARealIDs[$i];
                     $ROAtablerow = NVQStudentUnitROA::where('id','=',$getROAtableid)->first();

                    $c = new NVQCertificateHandoverDetails();
                    $c->CS_ID = $ROAtablerow->CS_ID;
                    $c->CST_ID = $ROAtablerow->CST_ID;
                    $c->T_ID = $ROAtablerow->T_ID;
                    $c->NT_ID = $ROAtablerow->NT_ID;
                    $c->OrgaId = $ROAtablerow->OrgaId;
                    $c->PersonName = $PersonName;
                    $c->PersonNIC = $PersonNIC;
                    $c->PersonMobile = $PersonMobile;
                    $c->DateIssued = $DateIssued;
                    $c->CertificateNo = $ROACertificateNo[$i];
                    $c->Type = 'ROA';
                    $c->User =User::getSysUser()->userID; 
                    $c->save();
                    $getMaxID = NVQCertificateHandoverDetails::max('id');
                    $updateNVQStudentUnitROA = NVQStudentUnitROA::where('id','=',$getROAtableid)->update(array('IssuedCertificate' => '1','CertificateHandoverID' => $getMaxID));

                  }


                  
               }

               for($j=0;$j<$COUNTNVQ;$j++)
               {

                  if(!empty($NVQCertificateNo[$j]))
                  {
                     $getNVQtableid = $NVQRealIDs[$j];
                     $NVQtablerow = NVQStudentPackage::where('id','=',$getNVQtableid)->first();

                    $c = new NVQCertificateHandoverDetails();
                    $c->CS_ID = $NVQtablerow->CS_ID;
                    $c->CST_ID = $NVQtablerow->CST_ID;
                    $c->T_ID = $NVQtablerow->T_ID;
                    $c->NT_ID = $NVQtablerow->NT_ID;
                    $c->OrgaId = $NVQtablerow->OrgaId;
                    $c->PersonName = $PersonName;
                    $c->PersonNIC = $PersonNIC;
                    $c->PersonMobile = $PersonMobile;
                    $c->DateIssued = $DateIssued;
                    $c->CertificateNo = $NVQCertificateNo[$j];
                    $c->Type = 'NVQ';
                    $c->User =User::getSysUser()->userID; 
                    $c->save();
                    $getMaxID1 = NVQCertificateHandoverDetails::max('id');
                    $updateNVQStudentPackage = NVQStudentPackage::where('id','=',$getNVQtableid)->update(array('IssuedCertificate' => '1','CertificateHandoverID' => $getMaxID1));

                  }


                  
               }


              return Redirect::to('CertificateHandoverToStudent');
        }
  }

  public function CertificateHandoverToStudent()
  {
       $view = View::make('Assessor.ViewCertificateHandoverDetails');
        $method=Request::getMethod();
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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
            $CType = Input::get('CType');
            $TNIC = Input::get('TNIC');

            if($CType == 'ROA')
            {
              $sql = "select nvqcertificatehandoverdetails.id,
organisation.OrgaName,
  coursedetails.CourseName,
  coursestarted.CourseCode,
 nvqmodule.name,
  nvqcertificatehandoverdetails.PersonName,
  nvqcertificatehandoverdetails.PersonNIC,
  nvqcertificatehandoverdetails.PersonMobile,
  nvqcertificatehandoverdetails.DateIssued,
  nvqcertificatehandoverdetails.Type
  from nvqcertificatehandoverdetails
  left join organisation
  on nvqcertificatehandoverdetails.OrgaId=organisation.id
  left join nvqstudentmoduleroa
  on nvqcertificatehandoverdetails.id=nvqstudentmoduleroa.CertificateHandoverID
  left join nvqmodule
  on nvqstudentmoduleroa.UnitId=nvqmodule.id
  left join coursestarted
  on nvqstudentmoduleroa.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
  where nvqcertificatehandoverdetails.Deleted=0
  and nvqcertificatehandoverdetails.Type='ROA'
  and nvqcertificatehandoverdetails.T_ID IN(select trainee.id from trainee where trainee.Deleted=0 and trainee.Dropout='No' and trainee.NIC='$TNIC')";
            }
            else
            {
                 $sql = "select nvqcertificatehandoverdetails.id,
organisation.OrgaName,
  coursedetails.CourseName,
  coursestarted.CourseCode,
  nvqstudentpackage.PackageCode as name,
 nvqcertificatehandoverdetails.PersonName,
  nvqcertificatehandoverdetails.PersonNIC,
  nvqcertificatehandoverdetails.PersonMobile,
  nvqcertificatehandoverdetails.DateIssued,
   nvqcertificatehandoverdetails.Type
  from nvqcertificatehandoverdetails
  left join organisation
  on nvqcertificatehandoverdetails.OrgaId=organisation.id
  left join nvqstudentpackage
  on nvqcertificatehandoverdetails.id=nvqstudentpackage.CertificateHandoverID
  left join coursestarted
  on nvqstudentpackage.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
  where nvqcertificatehandoverdetails.Deleted=0
  and nvqcertificatehandoverdetails.Type='NVQ'
  and nvqcertificatehandoverdetails.T_ID IN(select trainee.id from trainee where trainee.Deleted=0 and trainee.Dropout='No' and trainee.NIC='$TNIC')";
            }

            

                $total = DB::select(DB::raw($sql));
                $view->courses = $total;
                $view->Type = $CType;
             //   $view->CenterID = $centerID;

                return $view;

        }
  }

  public function saveTVECDocReceive()
  {
    $nvqcoursestartedtransID = Input::get('id');
    $updatenvqcoursetrans = NVQCoursestartedTrans::where('id','=',$nvqcoursestartedtransID)->update(array('DocumentReceiveFromAssessor' => '1'));
    return 1;
  }

  public function TVECDocReceive()
  {
    $method=Request::getMethod();
        $view = View::make('Assessor.TVECdocReceive');
        $view->trade = Coursestarted::where('Deleted', '!=', 1)->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
    
    if ($Type == 'HO'){
        $view->center = Organisation::where('Deleted', '!=', 1)->OrderBy('OrgaName')->get();     
    }
    else
    {
      $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
        //return $view;
    }

    if($method == 'GET')
    {
        return $view;
    }
    if($method == 'POST')
    {
          $centerId = Input::get('center');
          //return $centerId;
            if($centerId == '0'){
    
            

  $sql = "SELECT nvqcoursestartedtrans.id,
  coursestarted.YearStart as yearstart,
    organisation.OrgaName as oname,
    coursedetails.CourseName as cname,
  coursestarted.CourseCode as ccode,
  coursestarted.batch as batch,
    coursestarted.StartDate as sdate,
  coursestarted.ExpectedCompleted as expectedcompleted,
  coursedetails.Duration,
  nvqcoursestartedtrans.TVECSend,
  nvqcoursestartedtrans.DocumentReceiveFromAssessor
  from nvqcoursestartedtrans
  left join coursestarted
  on nvqcoursestartedtrans.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
   LEFT JOIN
    organisation ON coursestarted.OrgaId = organisation.id
  where nvqcoursestartedtrans.Deleted=0
 
   and coursestarted.Deleted != 1
   AND coursedetails.Deleted != 1

    ";

  } 
  else{
     $sql="SELECT nvqcoursestartedtrans.id,
  coursestarted.YearStart as yearstart,
    organisation.OrgaName as oname,
    coursedetails.CourseName as cname,
  coursestarted.CourseCode as ccode,
  coursestarted.batch as batch,
    coursestarted.StartDate as sdate,
  coursestarted.ExpectedCompleted as expectedcompleted,
  coursedetails.Duration,
  nvqcoursestartedtrans.TVECSend,
  nvqcoursestartedtrans.DocumentReceiveFromAssessor
  from nvqcoursestartedtrans
  left join coursestarted
  on nvqcoursestartedtrans.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
   LEFT JOIN
    organisation ON coursestarted.OrgaId = organisation.id
  where nvqcoursestartedtrans.Deleted=0
  and nvqcoursestartedtrans.orgaId='$centerId'
   and coursestarted.Deleted != 1
   AND coursedetails.Deleted != 1

  ";  
}
$total = DB::select(DB::raw($sql));
$view->courses = $total;
return $view;

    }
  }

  public function PrintNVQStudentList()
  {

  
    $CS_ID = Input::get('CS_ID');
    $CourseListCode = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
    $CourseName = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CourseName');
    $OrgaId = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
    $regNo = Organisation::where('id','=',$OrgaId)->pluck('RegistrationNo');
    $yearStart = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('YearStart');
    $batch = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('batch');
    $Obatch = "";
    if($batch == 1)
    {
      $Obatch = "I";
    }
    elseif($batch == 2)
    {
      $Obatch = "II";
    }
    else
    {
      $Obatch = "";
    }
     $sql = "select trainee.training_no,nvqstudentpackage.PackageCode,trainee.NameWithInitials,trainee.Address,trainee.NIC,organisation.OrgaName
                        FROM nvqstudentpackage
                        left join organisation
                        on nvqstudentpackage.OrgaId=organisation.id
                        left join trainee 
                        on nvqstudentpackage.T_ID=trainee.id
                        left join coursestarted
                        on nvqstudentpackage.CS_ID=coursestarted.CS_ID
                        left join coursedetails
                        on coursestarted.CourseListCode=coursedetails.CourseListCode
                        where nvqstudentpackage.CS_ID='$CS_ID'";
      $total = DB::select(DB::raw($sql));
      $ass1id = NVQAssessorNomination::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->where('AssessorActive','=',1)->lists('AssessorId');
      $getAssIDS  = NVQAssessor::whereIn('id',$ass1id)->get();
      $getfinalDate = NVQAssessmentSchedule::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->where('Type','=','Final')
      ->OrderBy('DateScheduled')->first();


      $html = '';
     
      $html = '<font size="5px" face="Times New Roman" ><table style = "font-size:18px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="5" cellspacing=0 style="border-collapse:collapse;">
 <thead>
<td align="center">Reg. No</td>
<td align="center">Qualification</td>
<td align="center">Name</td>
<td align="center">Address</td>
<td align="center">NIC</td>
<td align="center">Mode</td>
<td align="center">Centre</td>
<td align="center">Assessor1</td>
<td align="center">Assessor2</td>
<td align="center">Effective Date</td>
<td align="center">Certification No</td>
</thead><tbody>';
$i=1;

foreach ($total as $t) {

$html.='<tr>
    <td align="center">'.$t->training_no.'</td>
    <td align="center">'.$t->PackageCode.'</td>
      <td align="center">'.$t->NameWithInitials.'</td>
       <td align="center">'.$t->Address.'</td>
        <td align="center">'.$t->NIC.'</td>
         <td align="center">CBT</td>
          <td align="center">'.$t->OrgaName.'</td>';
          foreach($getAssIDS as $a)
          {
            $html.='<td align="center">'.$a->AssessorId.'</td>';
          }

          
         $html.='<td align="center">'.$getfinalDate->DateScheduled.'</td>
         <td align="center"></td>
    </tr>';

}

$html.='</tbody></table></font><br/><p style = "font-size:15px">This is certify that '.count($total).' Nos. of above mentioned candidates are eligible to receive NVQ Certificates as per qualified code.<br/>
Signature of the Director Exams / coordinator:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Institutional stamp:<br/></p>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br/><br/>
<p style = "font-size:15px">From TVEC<br/>
We are sending herewith ............... Nos.of NVQ certificates as specified in the above table and please acknoladge the receipt.
<br/>
<br/>
Signature of Director NVQ / TVEC:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Certificates received by
<br/> 
<br/>
Course - '.$CourseName.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature  :<br/>
<br/>
Reg No - '.$regNo.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name  :<br/><br/>
Batch - '.$yearStart.' '.$Obatch.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:</p>';

echo $html;
   
  }

  public function PrintCertificateOfficer()
  {
    $Certificateid = Input::get('Certificateid');
    $html = '';
    $date = date("Y-m-d");
    $getEMPID = NVQCertificateDeliver::where('id','=',$Certificateid)->pluck('EmpId');
    $initals = Employee::where('id','=',$getEMPID)->pluck('Initials');
    $lastname = Employee::where('id','=',$getEMPID)->pluck('LastName');
    $newPostID = Promotion::where('Emp_ID','=',$getEMPID)->where('CurrentRecord','=','Yes')->where('Deleted','=',0)->pluck('NewPost');
    $designation = EmploymentCode::where('id','=',$newPostID)->where('Deleted','=',0)->pluck('Designation');

    $sql = "select nvqcertificatedelivery.id,organisation.OrgaName,coursedetails.CourseName,nvqcertificatedelivery.NoOfCertificates
            from nvqcertificatedelivery
            left join organisation
            on nvqcertificatedelivery.OrgaId=organisation.id
            left join coursestarted
            on nvqcertificatedelivery.CS_ID=coursestarted.CS_ID
            left join coursedetails
            on coursestarted.CourseListCode=coursedetails.CourseListCode
            where nvqcertificatedelivery.Deleted=0
            and nvqcertificatedelivery.PrintHandOverLetter=0
            and nvqcertificatedelivery.EmpId='$getEMPID'";
  $total = DB::select(DB::raw($sql));

    $html='<html>
         <head>
         <style>
         #outer-container {
            
            justify-content: space-around;
            
          }
         </style>
         </head>
         <body>
         <div id="outer-container">
         <br/><br/><br/>
        
         
         <h3><center><u><b>Testing & Evaluation Division</b></u></center></h3>
         <h3><center><u><b>Vocational Training Authority of Sri Lanka</b></u></center></h3>
          '.$date.'<br/>
         '.$initals.' '.$lastname.'</br>
         '.$designation.'
         </br>
        
         <h4><center><u>Handing Over Certificates</u></center></h4>
         <p align="justufy">
          This is certify to that following certificates are checked and handed over correctly to the above mentioned officer.
          </p>
          </br>

         <table align="center" border=1 width="700"  v:shapes="_x0000_s1029" cellpadding=0 cellspacing=0 style="border-collapse:collapse;">
 <tr>
<td align="center">No</td>
<td align="center">Center</td>
<td align="center">Course</td>
<td align="center">No Of Certificates</td>
 </tr>';
$i=1;
 foreach($total as $t)
 {
    $html.='<tr>
    <td align="center">'.$i++.'</td>
    <td align="center">'.$t->OrgaName.'</td>
      <td align="center">'.$t->CourseName.'</td>
       <td align="center">'.$t->NoOfCertificates.'</td>
    </tr>';

    $update = NVQCertificateDeliver::where('id','=',$t->id)->update(array('PrintHandOverLetter' => 1));
 }



         $html.=' </table>
         <br/>
         <br/>
         <br/>
         <br/>
         <br/>
         ............................................
         <br/>
         <b>U.K.Nanda</b>
         <br/>
         Director (Testing & Evaluation)

         </div>
         </body>
         </html>';


         return $html;

  }

  public function GetCertificateOfficer()
  {
    $EPF = Input::get('EPF');
    $sql = "select employee.Initials,employee.LastName
           from employee
            where employee.EPFNo='$EPF'
            and employee.Deleted=0
            LIMIT 1";
    $emp = DB::select(DB::raw($sql));
    return json_encode($emp);
  }

  public function CreateCertificateDelivery()
  {
    $view = View::make('Assessor.CreateCertificateDelivery');
        $method=Request::getMethod();
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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

          //return 'zsdvg';
              $EPF = Input::get('EPF');
              $CourseListArray = Input::get('CourseList');
              $CenterListAyyay = Input::get('center');
              $NoOfCertificatesArray = Input::get('NoofCertifi');
              $getval =  Input::get('dale_ncc_id');
              $EmpId = Employee::where('EPFNo','=',$EPF)->where('Deleted','=',0)->pluck('id');
           
              $i = 0;
              for($i=0;$i<$getval;$i++)
              {

                $CST_ID = NVQCoursestartedTrans::where('CS_ID','=',$CourseListArray[$i])->where('Deleted','=',0)->pluck('id');
                $c = new NVQCertificateDeliver();
                $c->CS_ID = $CourseListArray[$i];
                $c->CST_ID = $CST_ID;
                $c->OrgaId = $CenterListAyyay[$i];
                $c->EPFNo = $EPF;
                $c->EmpId = $EmpId;
                $c->NoOfCertificates = $NoOfCertificatesArray[$i]; 
                $c->DateIssued = date("Y-m-d");
                $c->User = User::getSysUser()->userID; 
                $c->save();

                $updateCoursestartedtrans = NVQCoursestartedTrans::where('CS_ID','=',$CourseListArray[$i])->where('Deleted','=',0)->update(array('CertificateDeliver' => 1));

                
              }
         
              return Redirect::to('EnterCertificateDelivery');
        }
  }

  public function EnterCertificateDelivery()
  {
    $view = View::make('Assessor.ViewCertificateDelivery');
        $method=Request::getMethod();
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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
            $centerID = Input::get('center');
            $Course = Input::get('Course');

            $sql = "SELECT nvqcertificatedelivery.id,organisation.OrgaName,coursedetails.CourseName,employee.Initials,employee.LastName,nvqcertificatedelivery.NoOfCertificates,nvqcertificatedelivery.DateIssued,nvqcertificatedelivery.PrintHandOverLetter
  from nvqcertificatedelivery
  left join organisation
  on nvqcertificatedelivery.OrgaId=organisation.id
  left join coursestarted
  on nvqcertificatedelivery.CS_ID=coursestarted.CS_ID
  left join coursedetails
  on coursestarted.CourseListCode=coursedetails.CourseListCode
  left join employee
  on nvqcertificatedelivery.EmpId=employee.id
  where nvqcertificatedelivery.Deleted=0
  and nvqcertificatedelivery.OrgaId='$centerID'
  and nvqcertificatedelivery.CS_ID='$Course'";

                $total = DB::select(DB::raw($sql));
                $view->courses = $total;
                $view->CSID = $Course;
                $view->CenterID = $centerID;

                return $view;

        }
  }

  public function getFinalAssessedCourse()
  {
    $centerid = Input::get('center');
        $res = DB::select(DB::raw("select nvqcoursestartedtrans.CS_ID,coursestarted.CourseCode,coursedetails.CourseName
                                      from nvqcoursestartedtrans
                                      left join coursestarted
                                      on nvqcoursestartedtrans.CS_ID=coursestarted.CS_ID
                                      left join coursedetails
                                      on nvqcoursestartedtrans.CD_ID=coursedetails.CD_ID
                                      where nvqcoursestartedtrans.orgaId='$centerid'
                                      and nvqcoursestartedtrans.FinalAssessHeld='1'
                                      and nvqcoursestartedtrans.Deleted=0"));
         return json_encode($res);
  }

  public function ConfirmResultProvince()
  {
    $CS_ID = Input::get('CS_ID');
    $updatenvqcoursetrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)
    ->where('Deleted','=',0)
    ->where('TVECSend','=',1)
    ->update(array('ProvinceConfirmResult' => 1));

    return Redirect::to('ReturntoResultSheet?CSID='.$CS_ID);


  }

  public function ConfirmResultCenter()
  {
     $CS_ID = Input::get('CS_ID');
     $comS = Input::get('comS');
    $updatenvqcoursetrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)
    ->where('Deleted','=',0)
    ->where('TVECSend','=',1)
    ->update(array('CenterConfirmResult' => 1));

    return Redirect::to('returnToTraineeList?Course='.$CS_ID.'&&comS='.$comS);

  }

  public function ROANameList()
  {
        $view = View::make('Assessor.ROANameList');
        $method=Request::getMethod();
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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
          $center = Input::get('center');
          $Course = Input::get('Course');
          $CertificateType = Input::get('CertificateType');

          if($CertificateType == 'ROA')
          {
              if($Course == 'All')
              {
                  // ROA All course
                 $sql = "select nvqstudentmoduleroa.id,organisation.OrgaName,trainee.NameWithInitials,trainee.NIC,coursestarted.CourseCode,coursedetails.CourseName,nvqmodule.code,nvqmodule.name,nvqstudentmoduleroa.PrintCertificate
                  from nvqstudentmoduleroa
                  left join trainee 
                  on nvqstudentmoduleroa.T_ID=trainee.id
                  left join nvqmodule
                  on nvqstudentmoduleroa.UnitId=nvqmodule.id
                  left join coursestarted
                  on nvqstudentmoduleroa.CS_ID=coursestarted.CS_ID
                  left join coursedetails
                  on coursestarted.CourseListCode=coursedetails.CourseListCode
                  left join organisation
                  on nvqstudentmoduleroa.OrgaId=organisation.id
                  where nvqstudentmoduleroa.OrgaId='$center'
                  and nvqstudentmoduleroa.Deleted=0
                  and coursedetails.Deleted=0";

              }
              else
              {
                //ROA mentioned Course
                  $sql = "select nvqstudentmoduleroa.id,organisation.OrgaName,trainee.NameWithInitials,trainee.NIC,coursestarted.CourseCode,coursedetails.CourseName,nvqmodule.code,nvqmodule.name,nvqstudentmoduleroa.PrintCertificate
                  from nvqstudentmoduleroa
                  left join trainee 
                  on nvqstudentmoduleroa.T_ID=trainee.id
                  left join nvqmodule
                  on nvqstudentmoduleroa.UnitId=nvqmodule.id
                  left join coursestarted
                  on nvqstudentmoduleroa.CS_ID=coursestarted.CS_ID
                  left join coursedetails
                  on coursestarted.CourseListCode=coursedetails.CourseListCode
                  left join organisation
                  on nvqstudentmoduleroa.OrgaId=organisation.id
                  where nvqstudentmoduleroa.CS_ID='$Course'
                  and nvqstudentmoduleroa.OrgaId='$center'
                  and nvqstudentmoduleroa.Deleted=0
                  and coursedetails.Deleted=0";
              }

          }
          else
          {
            //certificate type NVQ
            if($Course == 'All')
              {
                  // NVQ All course
                  $sql = "select nvqstudentpackage.id,organisation.OrgaName,trainee.NameWithInitials,trainee.NIC,coursestarted.CourseCode,coursedetails.CourseName,nvqstudentpackage.PackageCode,nvqstudentpackage.PrintCertificate
                        FROM nvqstudentpackage
                        left join organisation
                        on nvqstudentpackage.OrgaId=organisation.id
                        left join trainee 
                        on nvqstudentpackage.T_ID=trainee.id
                        left join coursestarted
                        on nvqstudentpackage.CS_ID=coursestarted.CS_ID
                        left join coursedetails
                        on coursestarted.CourseListCode=coursedetails.CourseListCode
                        where  nvqstudentpackage.OrgaId='$center'";
              }
              else
              {
                  // NVQ Mentioned course
                   $sql = "select nvqstudentpackage.id,organisation.OrgaName,trainee.NameWithInitials,trainee.NIC,coursestarted.CourseCode,coursedetails.CourseName,nvqstudentpackage.PackageCode,nvqstudentpackage.PrintCertificate
                        FROM nvqstudentpackage
                        left join organisation
                        on nvqstudentpackage.OrgaId=organisation.id
                        left join trainee 
                        on nvqstudentpackage.T_ID=trainee.id
                        left join coursestarted
                        on nvqstudentpackage.CS_ID=coursestarted.CS_ID
                        left join coursedetails
                        on coursestarted.CourseListCode=coursedetails.CourseListCode
                        where nvqstudentpackage.CS_ID='$Course'
                        and nvqstudentpackage.OrgaId='$center'";
              }

          }

          $list = DB::select(DB::raw($sql));
          $view->trainees = $list;
          $view->CertificateType = $CertificateType;
          $view->CSID = $Course;
          return $view;


        }
  }

  public function ReturntoResultSheet()
  {
    $view = View::make('Assessor.EnterExamResult');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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

    $Course = Input::get('CSID');
          $sql = "select trainee.id,trainee.NameWithInitials,trainee.NIC
                  from nvqtraineetrans
                  left join trainee
                  on nvqtraineetrans.T_ID=trainee.id
                  where nvqtraineetrans.Deleted=0
                  and nvqtraineetrans.TVECSend=1
                  and nvqtraineetrans.CS_ID='$Course'
                  and nvqtraineetrans.FResultEntered=1";
          $total = DB::select(DB::raw($sql));
          $sql1 = "SELECT DISTINCT nvqmodule.id
                FROM nvqtraineetrans
                  LEFT JOIN trainee
                    ON nvqtraineetrans.T_ID = trainee.id
                  LEFT JOIN nvqstudentunitresult
                    ON nvqstudentunitresult.StudentId = nvqtraineetrans.T_ID
                  LEFT JOIN nvqmodule
                    ON nvqstudentunitresult.UnitId = nvqmodule.id
                where nvqtraineetrans.Deleted = 0
                AND nvqtraineetrans.TVECSend = 1
                AND nvqtraineetrans.CS_ID = '$Course'
                AND nvqtraineetrans.FResultEntered = 1
                AND nvqstudentunitresult.Deleted = 0";
                $module = DB::select(DB::raw($sql1));
        $CountModule = count($module);

          $view->trainees = $total;
          $view->modulelist = $module;
          $view->CSID = $Course;
          $view->ModuleCount = $CountModule;

           return $view;
  }

  public function SaveEditOriginalResultSheet()
  {
    $CS_ID = Input::get('CSID');
    $T_ID = Input::get('T_ID');
    $ModuleListarray = Input::get('ModuleList');
    $resultList = Input::get('ResultList');
    $getcountResultList = Count($resultList);
    $deleteNVQStudentUnitResult = DB::select(DB::raw("DELETE FROM nvqstudentunitresult
                                                      where nvqstudentunitresult.StudentId='$T_ID'
                                                      and nvqstudentunitresult.CSID='$CS_ID'"));
    $deleteNVQstudentPackage = DB::select(DB::raw("DELETE FROM nvqstudentpackage
                                                    where nvqstudentpackage.T_ID='$T_ID'
                                                    and nvqstudentpackage.CS_ID='$CS_ID'"));
    $deleteNVQstudentModuleROA = DB::select(DB::raw("DELETE FROM nvqstudentmoduleroa
                                                    where nvqstudentmoduleroa.T_ID='$T_ID'
                                                    and nvqstudentmoduleroa.CS_ID='$CS_ID'"));

    $getOrga = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
    $CSTID = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->pluck('id');
    $NTID = NVQTraineeTrans::where('T_ID','=',$T_ID)->where('Deleted','=',0)->pluck('id');
    $CresultArray = array();
    $packageIDArray = array();
    $i =0;
    for($i=0;$i<$getcountResultList;$i++)
    {
      if($resultList[$i] == 'C' || $resultList[$i] == 'N' || $resultList[$i] == 'A')
      {
        //return $resultList[$i];
      
        $v = new NVQStudentUnitResult();
        $v->StudentId = $T_ID;
        $v->UnitId = $ModuleListarray[$i];
        $v->result = $resultList[$i];
        $v->OrganisationId = $getOrga;
        $v->CSID = $CS_ID;
        $v->CSTID = $CSTID;
        $v->NTID = $NTID;
        $v->User =User::getSysUser()->userID; 
        $v->Save(); 
        if($resultList[$i] == 'C')
        {
          $CresultArray[] = $ModuleListarray[$i];
        }


      }
      
      
    }
   // return $CresultArray;
    $sqltemp = '0';

        $sql1 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$T_ID'
  and nvqstudentunitresult.result='C'";
  $ModuleidList = DB::select(DB::raw($sql1));
   foreach ($ModuleidList as $sm) {

            $sqltemp .= "," . $sm->id . "";
        }


    $sql = "select nvqqualificationpackage.packagecode,nvqqualificationpackage.id 
                    from nvqqualificationpackage
                    inner join nvqqualificationpackagemodule as a
                    on a.packageid=nvqqualificationpackage.id
                    and a.moduleid in ($sqltemp)
                    left join nvqqualificationpackagemodule as b
                    on b.packageid=nvqqualificationpackage.id and b.moduleid not in ($sqltemp)
                    where a.Deleted!='1'
                    and b.id is null
                    and nvqqualificationpackage.Deleted!='1'
                    group by nvqqualificationpackage.packagecode
                    ";
      $packages = DB::select(DB::raw($sql));

      //return  $packages;

      if(!empty($packages))
      {

        foreach ($packages as $p) {

          $packageIDArray = $p->id;

          $v = new NVQStudentPackage();
          $v->CS_ID = $CS_ID;
          $v->CST_ID = $CSTID;
          $v->NT_ID = $NTID;
          $v->T_ID = $T_ID;
          $v->PackageID = $p->id;
          $v->PackageCode = $p->packagecode;
          $v->User = User::getSysUser()->userID; 
          $v->OrgaId = $getOrga;
          $v->save();
         

        }

        //compare module list
         $sql2 = "select nvqmodule.id
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
                                                                  group by nvqqualificationpackage.packagecode))";

         $OriginalpackageModuleListROA = DB::select(DB::raw($sql2));

         if(count($OriginalpackageModuleListROA) != 0)
         {
            foreach($OriginalpackageModuleListROA as $a)
            {

              $c = new NVQStudentUnitROA();
              $c->CS_ID = $CS_ID;
              $c->CST_ID = $CSTID;
              $c->NT_ID = $NTID;
              $c->T_ID = $T_ID;
              $c->UnitId = $a->id;
              $c->OrgaId = $getOrga;
              $c->User = User::getSysUser()->userID; 
              $c->save();

            }

         }




      }
      else
      {

        //No any Packages available;
        $sql11 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$T_ID'
  and nvqstudentunitresult.result='C'";
  $ModuleidList = DB::select(DB::raw($sql11));
   foreach ($ModuleidList as $sm) {


              $c = new NVQStudentUnitROA();
              $c->CS_ID = $CS_ID;
              $c->CST_ID = $CSTID;
              $c->NT_ID = $NTID;
              $c->T_ID = $T_ID;
              $c->UnitId = $sm->id;
              $c->OrgaId = $getOrga;
              $c->User = User::getSysUser()->userID; 
              $c->save();
            
        }



      }

          

          
      
      

    $updateTraineeTrans = NVQTraineeTrans::where('id','=',$NTID)->update(array('FResultEntered' => 1));
    $updateCoursestartedtrans = NVQCoursestartedTrans::where('id','=',$CSTID)->update(array('FinalAssessHeld' => 1));

     return Redirect::to('ReturntoResultSheet?CSID='.$CS_ID);
  }

  public function EditOriginalResultSheet()
  {
     $T_ID = Input::get('asnid');
     $CS_ID = Input::get('CSID');

     $view = View::make('Assessor.EditStudentUnitResult');
   
  
    $sql = "SELECT DISTINCT nvqmodule.id,nvqmodule.code,nvqmodule.name
            FROM nvqtraineetrans
            LEFT JOIN trainee
            ON nvqtraineetrans.T_ID = trainee.id
            LEFT JOIN nvqstudentunitresult
            ON nvqstudentunitresult.StudentId = nvqtraineetrans.T_ID
            LEFT JOIN nvqmodule
            ON nvqstudentunitresult.UnitId = nvqmodule.id
            where nvqtraineetrans.Deleted = 0
            AND nvqtraineetrans.TVECSend = 1
            AND nvqtraineetrans.CS_ID = '$CS_ID'
            AND nvqtraineetrans.FResultEntered = 1
            AND nvqstudentunitresult.Deleted = 0";
    $total = DB::select(DB::raw($sql));
    $view->Module = $total;
    $view->CSID=$CS_ID;
    $view->T_ID=$T_ID;
    
    return $view;

  }

  public function ViewOriginalResultSheet()
  {
        $method=Request::getMethod();
        $view = View::make('Assessor.EnterExamResult');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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
          $center = Input::get('center');
          $Course = Input::get('Course');
          $sql = "select trainee.id,trainee.NameWithInitials,trainee.NIC
                  from nvqtraineetrans
                  left join trainee
                  on nvqtraineetrans.T_ID=trainee.id
                  where nvqtraineetrans.Deleted=0
                  and nvqtraineetrans.TVECSend=1
                  and nvqtraineetrans.CS_ID='$Course'
                  and nvqtraineetrans.FResultEntered=1";
          $total = DB::select(DB::raw($sql));
          $sql1 = "SELECT DISTINCT nvqmodule.id
                FROM nvqtraineetrans
                  LEFT JOIN trainee
                    ON nvqtraineetrans.T_ID = trainee.id
                  LEFT JOIN nvqstudentunitresult
                    ON nvqstudentunitresult.StudentId = nvqtraineetrans.T_ID
                  LEFT JOIN nvqmodule
                    ON nvqstudentunitresult.UnitId = nvqmodule.id
                where nvqtraineetrans.Deleted = 0
                AND nvqtraineetrans.TVECSend = 1
                AND nvqtraineetrans.CS_ID = '$Course'
                AND nvqtraineetrans.FResultEntered = 1
                AND nvqstudentunitresult.Deleted = 0";
                $module = DB::select(DB::raw($sql1));
        $CountModule = count($module);

          $view->trainees = $total;
          $view->modulelist = $module;
          $view->CSID = $Course;
          $view->ModuleCount = $CountModule;

           return $view;


        }
  }

  public function PrintPreAssessmentAttendence()
  {
    $CS_ID = Input::get('CS_ID');

    $getOrgaID = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
    $getOrganame = Organisation::where('id','=',$getOrgaID)->pluck('OrgaName');
    $CourseListCode = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
    $CourseName = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CourseName');
    $batch = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('batch');
    $courseCode = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseCode');
     $sql = "select trainee.id,trainee.NameWithInitials,trainee.NIC,trainee.training_no,trainee.Address,trainee.NIC
                  from nvqtraineetrans
                  left join trainee
                  on nvqtraineetrans.T_ID=trainee.id
                  where nvqtraineetrans.Deleted=0
                  and nvqtraineetrans.TVECSend=1
                  and nvqtraineetrans.CS_ID='$CS_ID'";
          $total = DB::select(DB::raw($sql));


    $html = '';

    $html.='<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:dt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<link rel=File-List href="preatt_files/filelist.xml">
<title>Page Title</title>
<style>
</style>
</head>
<body style="margin:0">

<div style="position:absolute;width:11.-2308in;height:1.1736in">
<center>
<table v:shapes="_x0000_s1029" cellpadding=0 cellspacing=0 width=517 height=61
 border=0 dir=ltr style="width:387.77pt;height:45.66pt;border-collapse:collapse;
 position:absolute;top:37.72pt;left:239.25pt;z-index:1">
 <tr>
  <td width=517 height=26 valign=Top style="width:387.7714pt;height:19.5587pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:12.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Vocational Training Authority of Sri Lanka - Training Division</span></p>
  </td>
 </tr>
 <tr>
  <td width=517 height=35 valign=Top style="width:387.7714pt;height:26.1pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:12.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">NVQ Pre Assessment - Attendance Sheet</span></p>
  </td>
 </tr>
</table>
</center>
<table v:shapes="_x0000_s1031" cellpadding=0 cellspacing=0 width=1019
 height=35 border=0 dir=ltr style="width:764.25pt;height:25.95pt;border-collapse:
 collapse;position:absolute;top:86.4pt;left:39.75pt;z-index:2">
 <tr>
  <td width=1019 height=35 valign=Top style="width:764.25pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="font-family:"Times New Roman";
  language:en-US">
  Center:  '.$getOrganame.'                Course: '.$CourseName.'('.$courseCode.')                                    Date:                                      Batch: '.$batch.'
  </span></p>
  </td>
 </tr>
</table>
<table v:shapes="_x0000_s1044" cellpadding=0 cellspacing=0 width=1012
 height=115 border=1 dir=ltr style="width:759.0pt;height:86.46pt;border-collapse:
 collapse;position:absolute;top:122.17pt;left:43.5pt;z-index:3">
 <tr>
  <td width=55 height=81 valign=Top style="width:41.516pt;height:60.5133pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="font-size:11.0pt;line-height:119%;
  font-family:"Times New Roman";language:en-US">No</span></p>
  </td>
  <td width=283 height=81 valign=Top style="width:211.8387pt;height:60.5133pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">NIC No</span></p>
  </td>
  <td width=207 height=81 valign=Top style="width:155.4193pt;height:60.5133pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Name of the Trainee</span></p>
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Name With initials(in English)</span></p>
  </td>
  <td width=194 height=81 valign=Top style="width:145.8387pt;height:60.5133pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Trainee </span></p>
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Registration </span></p>
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">No</span></p>
  </td>
  <td width=137 height=81 valign=Top style="width:102.1935pt;height:60.5133pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Trainee’s Address</span></p>
  </td>
  <td width=136 height=81 valign=Top style="width:102.1935pt;height:60.5133pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal style="text-align:center;text-align:center"><span
  lang=en-US style="font-size:11.0pt;line-height:119%;font-family:"Times New Roman";
  language:en-US">Signature</span></p>
  </td>

 </tr>';
$i = 1;
 foreach ($total as $t) {
   
  $html.='<tr>
  <td width=55 height=34 valign=Top style="width:41.516pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">'.$i.'</span></p>
  </td>

  <td width=283 height=34 valign=Top style="width:211.8387pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">'.$t->NIC.'</span></p>
  </td>

  <td width=207 height=34 valign=Top style="width:155.4193pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">'.$t->NameWithInitials.'</span></p>
  </td>

  <td width=194 height=34 valign=Top style="width:145.8387pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">'.$t->training_no.'</span></p>
  </td>
  <td width=137 height=34 valign=Top style="width:102.1935pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">'.$t->Address.'</span></p>
  </td>
  <td width=136 height=34 valign=Top style="width:102.1935pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="language:en-US">&nbsp;</span></p>
  </td>
 </tr>';

 $i++;
 }


 
$html.='</table>';

$html.='<table v:shapes="_x0000_s1073" cellpadding=0 cellspacing=0 width=1026
 height=37 border=0 dir=ltr style="width:769.13pt;height:27.6pt;border-collapse:
 collapse;position:absolute;top:503.4pt;left:37.5pt;z-index:4">
 <tr>
  <td width=1026 height=37 valign=Top style="width:769.1397pt;height:27.6pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="font-size:11.0pt;line-height:119%;
  font-family:"Times New Roman";language:en-US">N.B :- Certificates will be issued to the names mentioned above</span></p>
  </td>
 </tr>
</table>
<table v:shapes="_x0000_s1076" cellpadding=0 cellspacing=0 width=1027
 height=35 border=0 dir=ltr style="width:769.88pt;height:25.95pt;border-collapse:
 collapse;position:absolute;top:533.4pt;left:38.25pt;z-index:5">
 <tr>
  <td width=289 height=35 valign=Top style="width:216.75pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="font-family:"Times New Roman";
  language:en-US">Assessor Name:-</span></p>
  </td>
  <td width=416 height=35 valign=Top style="width:312.0pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="font-family:"Times New Roman";
  language:en-US">    Signature:-</span></p>
  </td>
  <td width=322 height=35 valign=Top style="width:241.1397pt;height:25.95pt;
  padding-left:2.88pt;padding-right:2.88pt;padding-top:2.88pt;padding-bottom:
  2.88pt">
  <p class=MsoNormal><span lang=en-US style="font-family:"Times New Roman";
  language:en-US">Reg No:-</span></p>
  </td>
 </tr>
</table>
</div>

</body>


</html>';

return $html;
  }

  public function SavePreAssessmentAttendence()
  {
     $CenterID = Input::get('Center');
     $CS_ID = Input::get('CSID');
     $traineeIds = Input::get('trainee_ids');

     $update = NVQTraineeTrans::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->update(array('PreAssessHeld' => 0));

     foreach ($traineeIds as $k) {

     // return $k;

      $updateTraineeTrans = NVQTraineeTrans::where('id','=',$k)->update(array('PreAssessHeld' => 1));
     
     }

     return Redirect::to('AssignTraineesToPreAssessment')->with("done", true);;
  }

 public function GetScheduledPreAssDates()
  {
     $CS_ID = Input::get('Course');
     $sql = "select assessmentschedule.id,assessmentschedule.DateScheduled
              from assessmentschedule
              where assessmentschedule.CS_ID='$CS_ID'
              and assessmentschedule.Type='Pre'
              order by assessmentschedule.DateScheduled
              and assessmentschedule.ActualHeldStatus=0
              and assessmentschedule.Deleted=0";
     $dates = DB::select(DB::raw($sql));
      return json_encode($dates);

  }

  public function AssignTraineesToPreAssessment()
  {
        $method=Request::getMethod();
        $view = View::make('Assessor.MarkAttendenceforPreAssessments');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
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
          $CenterID = Input::get('center');
          $CS_ID = Input::get('Course');
         // $preDate = Input::get('ScheduleDate');

          $sql = "select nvqtraineetrans.id,nvqtraineetrans.T_ID,trainee.NameWithInitials,trainee.NIC,nvqtraineetrans.PreAssessHeld,trainee.training_no
                  from nvqtraineetrans
                  left join trainee
                  on nvqtraineetrans.T_ID=trainee.id
                  where nvqtraineetrans.Deleted=0
                  and nvqtraineetrans.TVECSend=1
                  and nvqtraineetrans.CS_ID='$CS_ID'";
          $total = DB::select(DB::raw($sql));
          $view->Trainees = $total;
          $view->CSID = $CS_ID;
          $view->Center = $CenterID;
          return $view;

        }



  }

  public function returnToTraineeList()
  {

        $view = View::make('Assessor.EnterExamResult1');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
        $view->Type = $Type;

        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type', ['HO','DO'])
            ->OrderBy('OrgaName')
            ->get();   

        }
        else
        {
            $view->center = Organisation::where('Deleted', '!=', 1)->where('id','=',$orgaid)->OrderBy('OrgaName')->get();   
       
        }
         $center = Input::get('center');
          $CS_ID = Input::get('Course');
          $comS = Input::get('comS');

          $sql ="select nvqtraineetrans.T_ID,trainee.NameWithInitials,trainee.NIC,nvqtraineetrans.FResultEntered
  from nvqtraineetrans
  left join trainee
  on nvqtraineetrans.T_ID=trainee.id
  where nvqtraineetrans.Deleted=0
  and nvqtraineetrans.TVECSend=1
  and nvqtraineetrans.CS_ID='$CS_ID'";
  $total = DB::select(DB::raw($sql));
  $view->trainees = $total;
  $view->CSID = $CS_ID;
   $view->comS = $comS;
  

  return $view;
  }

  public function EULoadStudentExamResultEnter()
  {
     $view = View::make('Assessor.StudentUnitResult');
    $CS_ID = Input::get('CDID');
    $T_ID = Input::get('asnid');
    $comS = Input::get('comS');


    $sql = "select distinct nvqmodule.id,nvqmodule.code,nvqmodule.name
  from nvqqualificationpackage
  left join nvqqualificationpackagemodule
  on nvqqualificationpackage.id=nvqqualificationpackagemodule.packageid
  left join nvqmodule
  on nvqqualificationpackagemodule.moduleid=nvqmodule.id
  where nvqqualificationpackage.cscode='$comS'
  and nvqqualificationpackage.Deleted=0";
    $total = DB::select(DB::raw($sql));
    $view->Module = $total;
    $view->CSID=$CS_ID;
    $view->T_ID=$T_ID;
     $view->comS=$comS;
    return $view;
  }
  public function SaveModuleResult()
  {
    $CS_ID = Input::get('CSID');
    $comS = Input::get('comS');
    $T_ID = Input::get('T_ID');
    $ModuleListarray = Input::get('ModuleList');
    $resultList = Input::get('ResultList');
    $getcountResultList = Count($resultList);
    $getOrga = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
    $CSTID = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->pluck('id');
    $NTID = NVQTraineeTrans::where('T_ID','=',$T_ID)->where('Deleted','=',0)->pluck('id');
    $CresultArray = array();
    $packageIDArray = array();
     $deleteNVQStudentUnitResult = DB::select(DB::raw("DELETE FROM nvqstudentunitresult
                                                      where nvqstudentunitresult.StudentId='$T_ID'
                                                      and nvqstudentunitresult.CSID='$CS_ID'"));
    $deleteNVQstudentPackage = DB::select(DB::raw("DELETE FROM nvqstudentpackage
                                                    where nvqstudentpackage.T_ID='$T_ID'
                                                    and nvqstudentpackage.CS_ID='$CS_ID'"));
    $deleteNVQstudentModuleROA = DB::select(DB::raw("DELETE FROM nvqstudentmoduleroa
                                                    where nvqstudentmoduleroa.T_ID='$T_ID'
                                                    and nvqstudentmoduleroa.CS_ID='$CS_ID'"));
    $i =0;
    for($i=0;$i<$getcountResultList;$i++)
    {
      if($resultList[$i] == 'C' || $resultList[$i] == 'N' || $resultList[$i] == 'A')
      {
        //return $resultList[$i];
      
        $v = new NVQStudentUnitResult();
        $v->StudentId = $T_ID;
        $v->UnitId = $ModuleListarray[$i];
        $v->result = $resultList[$i];
        $v->OrganisationId = $getOrga;
        $v->CSID = $CS_ID;
        $v->CSTID = $CSTID;
        $v->NTID = $NTID;
        $v->User =User::getSysUser()->userID; 
        $v->Save(); 
        if($resultList[$i] == 'C')
        {
          $CresultArray[] = $ModuleListarray[$i];
        }


      }
      
      
    }
   // return $CresultArray;
    $sqltemp = '0';

        $sql1 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$T_ID'
  and nvqstudentunitresult.result='C'";
  $ModuleidList = DB::select(DB::raw($sql1));
   foreach ($ModuleidList as $sm) {

            $sqltemp .= "," . $sm->id . "";
        }


    $sql = "select nvqqualificationpackage.packagecode,nvqqualificationpackage.id 
                    from nvqqualificationpackage
                    inner join nvqqualificationpackagemodule as a
                    on a.packageid=nvqqualificationpackage.id
                    and a.moduleid in ($sqltemp)
                    left join nvqqualificationpackagemodule as b
                    on b.packageid=nvqqualificationpackage.id and b.moduleid not in ($sqltemp)
                    where a.Deleted!='1'
                    and b.id is null
                    and nvqqualificationpackage.Deleted!='1'
                    group by nvqqualificationpackage.packagecode
                    ";
      $packages = DB::select(DB::raw($sql));

      //return  $packages;

      if(!empty($packages))
      {

        foreach ($packages as $p) {

          $packageIDArray = $p->id;

          $v = new NVQStudentPackage();
          $v->CS_ID = $CS_ID;
          $v->CST_ID = $CSTID;
          $v->NT_ID = $NTID;
          $v->T_ID = $T_ID;
          $v->PackageID = $p->id;
          $v->PackageCode = $p->packagecode;
          $v->User = User::getSysUser()->userID; 
          $v->OrgaId = $getOrga;
          $v->save();
         

        }

        //compare module list
         $sql2 = "select nvqmodule.id
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
                                                                  group by nvqqualificationpackage.packagecode))";

         $OriginalpackageModuleListROA = DB::select(DB::raw($sql2));

         if(count($OriginalpackageModuleListROA) != 0)
         {
            foreach($OriginalpackageModuleListROA as $a)
            {

              $c = new NVQStudentUnitROA();
              $c->CS_ID = $CS_ID;
              $c->CST_ID = $CSTID;
              $c->NT_ID = $NTID;
              $c->T_ID = $T_ID;
              $c->UnitId = $a->id;
              $c->OrgaId = $getOrga;
              $c->User = User::getSysUser()->userID; 
              $c->save();

            }

         }




      }
      else
      {

        //No any Packages available;
        $sql11 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
  where nvqstudentunitresult.Deleted=0
  and nvqstudentunitresult.StudentId='$T_ID'
  and nvqstudentunitresult.result='C'";
  $ModuleidList = DB::select(DB::raw($sql11));
   foreach ($ModuleidList as $sm) {


              $c = new NVQStudentUnitROA();
              $c->CS_ID = $CS_ID;
              $c->CST_ID = $CSTID;
              $c->NT_ID = $NTID;
              $c->T_ID = $T_ID;
              $c->UnitId = $sm->id;
              $c->OrgaId = $getOrga;
              $c->User = User::getSysUser()->userID; 
              $c->save();
            
        }



      }

          

          
      
      

    $updateTraineeTrans = NVQTraineeTrans::where('id','=',$NTID)->update(array('FResultEntered' => 1));
    $updateCoursestartedtrans = NVQCoursestartedTrans::where('id','=',$CSTID)->update(array('FinalAssessHeld' => 1));

     return Redirect::to('returnToTraineeList?Course='.$CS_ID.'&&comS='.$comS);

  }

  public function EUExamResultEnter()
  {
    $method=Request::getMethod();
        $view = View::make('Assessor.EnterExamResult1');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Competency = NVQcompetencystandard::where('Deleted','=',0)->orderBy('code')->get();
        $view->Type = $Type;
        
        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type', ['HO','DO'])
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

            // return 'hsgdfy';
          $center = Input::get('center');
          $CS_ID = Input::get('Course');
          $comS = Input::get('comS');

          $sql ="select nvqtraineetrans.T_ID,trainee.NameWithInitials,trainee.NIC,nvqtraineetrans.FResultEntered
  from nvqtraineetrans
  left join trainee
  on nvqtraineetrans.T_ID=trainee.id
  where nvqtraineetrans.Deleted=0
  and nvqtraineetrans.TVECSend=1
  and nvqtraineetrans.CS_ID='$CS_ID'";
  $total = DB::select(DB::raw($sql));
  $view->trainees = $total;
  $view->CSID = $CS_ID;
   $view->comS = $comS;
  

  return $view;

        }
    
  }

   public function GETAjaxQualificationStudent() {

       $Traineeid = Input::get('ModuleList');
       $sqltemp = '0';

        $sql1 = "select nvqmodule.id
  from nvqstudentunitresult
  left join nvqmodule
  on nvqstudentunitresult.UnitId=nvqmodule.id
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
                    inner join nvqqualificationpackagemodule as a
                    on a.packageid=nvqqualificationpackage.id
                    and a.moduleid in ($sqltemp)
                    left join nvqqualificationpackagemodule as b
                    on b.packageid=nvqqualificationpackage.id and b.moduleid not in ($sqltemp)
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

  public function TEMPLoadTraineemodulelistwithresult()
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

  public function TempViewResult()
  {
       $method=Request::getMethod();
    $view = View::make('Assessor.TempViewResult');
    $view->district = District::orderBy('DistrictName')->get();
    //$view->Compstandard = NVQcompetencystandard::where('Deleted','=',0)->get();

    if($method == 'GET')
    {
      return $view;
    }
    if($method == 'POST')
    {
    }

  }

  public function TEMPgetUnits()
  {
    $CompstandardCode = Input::get('Compstandard');
    $CSID = Input::get('CSID');

    $getCLC = Coursestarted::where('CS_ID','=',$CSID)->pluck('CourseListCode');
    $gerLevel = Course::where('CourseListCode','=',$getCLC)->where('Deleted','=',0)->pluck('CourseLevel');
    $RealLevel = '';
    if($gerLevel == 1)
    {
      $RealLevel = 'L1';
    }
    elseif($gerLevel == 2)
    {
      $RealLevel = 'L2';
    }
    elseif($gerLevel == 3)
    {
      $RealLevel = 'L3';
    }
    elseif($gerLevel == 4)
    {
      $RealLevel = 'L4';
    }
    elseif($gerLevel == 5)
    {
      $RealLevel = 'L5';
    }
    elseif($gerLevel == 6)
    {
      $RealLevel = 'L6';
    }
    else
    {
      $RealLevel = '';
    }

     $res = DB::select(DB::raw("select nvqmodule.id,
  nvqmodule.name,nvqmodule.code
  from nvqqualificationpackage
  left join nvqqualificationpackagemodule
  on nvqqualificationpackage.id=nvqqualificationpackagemodule.packageid
  left join nvqmodule
  on nvqqualificationpackagemodule.moduleid=nvqmodule.id
  where nvqqualificationpackage.cscode='$CompstandardCode'
  and nvqqualificationpackage.level='$RealLevel'
  and nvqqualificationpackage.Deleted=0"));
            return json_encode($res);


  }

  public function TEMPLoadTraineeList()
  {
    $CS_ID = Input::get('CSID');
    $res = DB::select(DB::raw("select nvqtraineetrans.T_ID,trainee.FullName
  from nvqtraineetrans
  left join trainee
  on nvqtraineetrans.T_ID=trainee.id
  where nvqtraineetrans.Deleted=0
  and nvqtraineetrans.FResultEntered=1
  and nvqtraineetrans.CS_ID='$CS_ID'"));
            return json_encode($res);

  }

   public function TEMPEUGetOngoingCoursese()
    {
        $centerid = Input::get('CenterId');
        //return $centerid;
        $res = DB::select(DB::raw("select coursestarted.CS_ID,coursestarted.CourseCode,coursedetails.CourseName
                                  from coursestarted
                                  left join nvqcoursestartedtrans
                                  on coursestarted.CS_ID=nvqcoursestartedtrans.CS_ID
                                 left join coursedetails
                                  on coursestarted.CourseListCode=coursedetails.CourseListCode
                                  where coursestarted.TVECSend=1
                                  and coursestarted.Deleted=0
                                  and coursestarted.Completed!='YES'
                                  and coursestarted.OrgaId='$centerid'
                                  /*and nvqcoursestartedtrans.FinalAssessHeld=1*/
                                  and nvqcoursestartedtrans.AssessorNominated=1
                                   and nvqcoursestartedtrans.Deleted=0"));
            return json_encode($res);
        
    }

  public function TempEnterResult()
  {
    $method=Request::getMethod();
    $view = View::make('Assessor.TempEnterResult');
    $view->district = District::orderBy('DistrictName')->get();
    $view->Compstandard = NVQcompetencystandard::where('Deleted','=',0)->get();

    if($method == 'GET')
    {
      return $view;
    }
    if($method == 'POST')
    {
        $traineeID = Input::get('Traineeid');
        $CSID  = Input::get('CSID');
        $CenterId = Input::get('CenterId');
        $Unitid = Input::get('Unitid');
        $Result = Input::get('Result');
        $CSTID = NVQCoursestartedTrans::where('CS_ID','=',$CSID)->where('Deleted','=',0)->pluck('id');
       $NTID = NVQTraineeTrans::where('T_ID','=',$traineeID)->where('Deleted','=',0)->pluck('id');
      //  return NVQTraineeTrans::where('T_ID','=',$traineeID)->where('Deleted','=',0)->pluck('id');

      $v = new NVQStudentUnitResult();
      $v->StudentId = $traineeID;
      $v->UnitId = $Unitid;
      $v->result = $Result;
      $v->OrganisationId = $CenterId;
      $v->CSID = $CenterId;
      $v->CSTID = $CSTID;
      $v->NTID = $NTID;
      $v->User =User::getSysUser()->userID; 
      $v->Save();                                                                                                                

    }
     return Redirect::to('TempEnterResult')->with("done", true);;

  }

  public function ScheduleFinalAssessment()
  {
    $method=Request::getMethod();
        $view = View::make('Assessor.FinalAssessSchedule');
        $CS_ID = Input::get('CS_ID');
        $view->CSID = $CS_ID;

        $sql = "select assessmentschedule.DateScheduled,assessmentschedule.Type,assessmentschedule.ActualHeldStatus
                from assessmentschedule
                where assessmentschedule.Deleted=0
                and assessmentschedule.CS_ID='$CS_ID'
                and assessmentschedule.Type='Final'
                ORDER by DateScheduled";
        $datesss = DB::select(DB::raw($sql));
        //$POST = 'POST';
      $view->dates = $datesss;

        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
          $CS_ID = Input::get('CSID');
             $getDates = Input::get('ScheduleDates');
             $updateCoursestartedtrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->update(array('FinalAssessShedule' => 1));

             // must write save code
            $OrgaID = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
            $CSTID = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->pluck('id');
             
             foreach ($getDates as $c) {

              if(!empty($c))
              {
                $v = new NVQAssessmentSchedule();
                $v->OrgaId = $OrgaID;
                $v->CS_ID = $CS_ID;
                $v->CST_ID = $CSTID;
                $v->Type = 'Final';
                $v->DateScheduled = $c;
                $v->User =User::getSysUser()->userID; 
                $v->save();
               

              }
              
             }

            
            // return Redirect::to('ViewNPrintLettersForAssignedAssessors?Course=' . $CS_ID . '&method=' . $POST)->with("done", true);
              return Redirect::to('ViewNPrintLettersForAssignedAssessors');
        }
  }

  public function SchedulePreAssessment()
  {
        $method=Request::getMethod();
        $view = View::make('Assessor.PreAssessShedule');
        $CS_ID = Input::get('CS_ID');
        $view->CSID = $CS_ID;
        //$POST = 'POST';
        $sql = "select assessmentschedule.DateScheduled,assessmentschedule.Type,assessmentschedule.ActualHeldStatus
                from assessmentschedule
                where assessmentschedule.Deleted=0
                and assessmentschedule.CS_ID='$CS_ID'
                and assessmentschedule.Type='Pre'
                ORDER by DateScheduled";
        $datesss = DB::select(DB::raw($sql));
        //$POST = 'POST';
      $view->dates = $datesss;
      

        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
             $CS_ID = Input::get('CSID');
               $getDates = Input::get('ScheduleDates');
             $updateCoursestartedtrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->update(array('PreAssessSchedule' => 1));
             $OrgaID = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
             $CSTID = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->pluck('id');
             
             foreach ($getDates as $c) {

              if(!empty($c))
              {
                $v = new NVQAssessmentSchedule();
                $v->OrgaId = $OrgaID;
                $v->CS_ID = $CS_ID;
                $v->CST_ID = $CSTID;
                $v->Type = 'Pre';
                $v->DateScheduled = $c;
                $v->User =User::getSysUser()->userID; 
                $v->save();
               

              }
              
             }


            
            // return Redirect::to('ViewNPrintLettersForAssignedAssessors?Course=' . $CS_ID . '&method=' . $POST)->with("done", true);
              return Redirect::to('ViewNPrintLettersForAssignedAssessors');
        }

  }



  public function getAssessorCount()
  {
      $CSID = Input::get('CSID');
      $getCount = NVQAssessorNomination::where('CS_ID','=',$CSID)->where('Deleted','=',0)->where('AssessorActive','=',1)->count();
      return json_encode($getCount);

  }


  public function getAssessorTable()
  {
    $CSID = Input::get('CSID');
    $CLC = Coursestarted::where('CS_ID','=',$CSID)->pluck('CourseCode');
  


     $sql = "select assessor.Name,assessor.Mobile,assessornomination.AssessorStatus,assessornomination.AssessorActive
  from assessornomination
  left join assessor
  on assessornomination.AssessorId=assessor.id
  where assessornomination.CS_ID='$CSID'
  and assessornomination.Deleted=0";
       
        $test = DB::select(DB::raw($sql));
        if (!empty($test)) {
            $html = '<pre><h6><center>Assigned Assessors For: <b>'.$CLC.'</b></center></h6></pre>  
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
            <th class="center">Name</th>
                    <th>Mobile</th>                          
                    <th>Assessor Status</th>  
           </tr>
                    </thead>
                    <tbody>';
            foreach ($test as $e) {

                if($e->AssessorActive == 2)
                {
                  $html .='<tr>
                              <td class="center" ><font color="red">' . $e->Name . '</font></td>
                              <td><font color="red">' . $e->Mobile. '</font></td>
                              <td><font color="red">' . $e->AssessorStatus. '</font></td></tr>';

                }
                else
                {
                  $html .='<tr>
                              <td class="center" ><font color="blue">' . $e->Name . '</font></td>
                              <td><font color="blue">' . $e->Mobile. '</font></td>
                              <td><font color="blue">' . $e->AssessorStatus. '</font></td></tr>';
                }
              }

              $html.='</tbody>
                              </table>';
            }

          
        
        return $html; 

  }


  public function getRenominateCenters()
  {
    $centerid = Input::get('CenterId');
        //return $centerid;
        $res = DB::select(DB::raw("select coursestarted.CS_ID,coursestarted.CourseCode,coursedetails.CourseName
                                  from coursestarted
                                  left join nvqcoursestartedtrans
                                  on coursestarted.CS_ID=nvqcoursestartedtrans.CS_ID
                                 left join coursedetails
                                  on coursestarted.CourseListCode=coursedetails.CourseListCode
                                  where coursestarted.TVECSend=1
                                  and coursestarted.Deleted=0
                                  and coursestarted.Completed!='YES'
                                  and coursestarted.OrgaId='$centerid'
                                  and nvqcoursestartedtrans.FinalAssessHeld=0
                                  and nvqcoursestartedtrans.AssessorNominated=1
                                   and nvqcoursestartedtrans.Deleted=0"));
            return json_encode($res);

  }


  public function RenominateAssessor()
  {
    $method=Request::getMethod();
        $view = View::make('Assessor.Renominate');
        $view->district = District::orderBy('DistrictName')->get();
        $view->AssessorInstitute = NVQAssessorInstitute::where('Deleted','=',0)->orderBy('InstituteName')->get();
        
        
      

        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
            $CS_ID = Input::get('CSID');
            $Assessor1 = Input::get('Assessor1');
            $Assessor2 = Input::get('Assessor2');
            $CenterId = Input::get('CenterId');
            $getCourseListCode = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
            $getCD_ID = Course::where('CourseListCode','=',$getCourseListCode)->where('Deleted','=',0)->pluck('CD_ID');
            $getcourseTransID = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->pluck('id');

            if(!empty($Assessor1))
            {
            $v = new NVQAssessorNomination();
            $v->OrgaId = $CenterId;
            $v->CS_ID = $CS_ID;
            $v->CD_ID = $getCD_ID;
            $v->CSTransId = $getcourseTransID;
            $v->AssessorId = $Assessor1;
            $v->User =  User::getSysUser()->userID;
            $v->save();

            }
            if(!empty($Assessor2))
            {
            $c = new NVQAssessorNomination();
            $c->OrgaId = $CenterId;
            $c->CS_ID = $CS_ID;
            $c->CD_ID = $getCD_ID;
            $c->CSTransId = $getcourseTransID;
            $c->AssessorId = $Assessor2;
            $c->User = User::getSysUser()->userID;
            $c->save();

            }

            
             return Redirect::to('RenominateAssessor')->with("done", true);


        }
  }

  public function DORejectAssignedAssessor()
  {
    $AssessorNominationID = Input::get('id');

    $reason = Input::get('reason');
    
    $currentTimestamp = date('Y-m-d H:i:s');
    $updateassesornominatedRec = NVQAssessorNomination::where('id','=',$AssessorNominationID)
    ->update(array('AssessorActive' => '2','AssessorStatus' => 'Rejected', 'DateRejected' => $currentTimestamp,'RejectReason' => $reason));
     return Redirect::to('ViewNPrintLettersForAssignedAssessors');

  }


    public function PrintAssessorAssignedLetter()
    {
         $CS_ID = Input::get('CS_ID');
         $getOrgaID = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('OrgaId');
         $sqlgetallAssessors = DB::select(DB::raw("select assessor.Name, assessor.AssessorId,assessor.Mobile,assessor.id
                              from assessornomination
                              left join assessor
                              on assessornomination.AssessorId=assessor.id
                              where assessornomination.CS_ID='$CS_ID'
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
        
        
        
        $docode = Organisation::where('id', '=', $getOrgaID)->pluck('DistrictCode');
        $districtName = District::where('DistrictCode','=',$docode)->pluck('DistrictName');
        $year = date('Y');

        $orgaName = Organisation::where('id','=',$getOrgaID)->pluck('OrgaName');
        $orgaRegNo = Organisation::where('id','=',$getOrgaID)->pluck('RegistrationNo');
        $CourseListCode = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
        $NVQLevel = Course::where('CourseListCode','=',$CourseListCode)->where('Deleted','=',0)->pluck('CourseLevel');
        $courseStartDate = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('StartDate');
        $CourseEndDate = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('ExpectedCompleted');
        $traineeCount = NVQTraineeTrans::where('CS_ID','=',$CS_ID)->where('Deleted','=',0)->where('TVECSend','=',1)->count();

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


<table border="1px" width="700">
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
&nbsp;&nbsp;'.$courseStartDate.'
</td>
<td >
&nbsp;&nbsp;'.$CourseEndDate.'
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
<tr>
<td>
&nbsp;&nbsp;'.$assessorID1.'
</td>
<td >
&nbsp;&nbsp;'.$assessorName1.'
</td>
<td >
&nbsp;&nbsp;'.$assessorMobile1.'
</td>
</tr>
<tr>
<td>
&nbsp;&nbsp;'.$assessorID2.'
</td>
<td>
&nbsp;&nbsp;'.$assessorName2.'
</td>
<td>
&nbsp;&nbsp;'.$assessorMobile2.'
</td>
</tr>

</tbody>
</table>
<br/>
<br/>
U.K Nanda,<br/>
Director (Testing &amp; Evaluation)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; For Conduct The Assessment<br/>
<br/>
Copies &ndash;<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 *&nbsp;Please note strictly that the copy of &lsquo;PA form should be<br/>
01.&nbsp;&nbsp;'.$assessorName1.'&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sent to Tertiary and Vocational Education Commission<br/>
02.&nbsp;&nbsp;'.$assessorName2.'&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; within 03 days after assessment,having the Pre - assessment<br/><br/>
03. Director(Quality Assiarence & assessment Regulation)- kindly informed to you,<br/>assessors nomination done according to instructions given by TVEC.<br/>
<ol>
<li>Please be kind enough to conduct assessments for NVQ Level 04, after computer of on<br/>the job training.</li>
</ol>
<b><center>Please note that this approval is valid only up to month period of time</center></b>
</body>
</div>
</html>
';
 $updateletterprintass1 = NVQAssessorNomination::where('CS_ID','=',$CS_ID)->update(array('LetterPrintForAssessor' => 1));
 $updatenvqcoursetrans = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->update(array('AssNominatedLetterSendDO' => 1));
// $updateletterprintass2 = NVQAssessorNomination::where('id','=',$asseid2)->update(array('LetterPrintForAssessor' => 1));
echo $html;
    }

    public function GetNominatedCourses()
    {
        $centerid = Input::get('center');
        $res = DB::select(DB::raw("select nvqcoursestartedtrans.CS_ID,coursestarted.CourseCode,coursedetails.CourseName
                                      from nvqcoursestartedtrans
                                      left join coursestarted
                                      on nvqcoursestartedtrans.CS_ID=coursestarted.CS_ID
                                      left join coursedetails
                                      on nvqcoursestartedtrans.CD_ID=coursedetails.CD_ID
                                      where nvqcoursestartedtrans.orgaId='$centerid'
                                      and nvqcoursestartedtrans.AssessorNominated='1'
                                      and nvqcoursestartedtrans.Deleted=0
                                      /* and nvqcoursestartedtrans.FinalAssessHeld=0*/
                                    "));
         return json_encode($res);
    

    }



    public function ViewNPrintLettersForAssignedAssessors()
    {
        $method=Request::getMethod();
        $view = View::make('Assessor.ViewAssignedAssessors');
        $view->district = District::orderBy('DistrictName')->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        $view->Type = $Type;
        
        if ($Type == 'HO'){
                $view->center = Organisation::where('Deleted', '!=', 1)->whereNotIn('Type', ['HO','DO'])->OrderBy('OrgaName')->get();     
        }
        elseif($Type == 'DO')
        {
            $getdistrictCode = Organisation::where('id','=',$orgaid)->pluck('DistrictCode');
            $view->center = Organisation::where('Deleted', '!=', 1)
            ->where('DistrictCode','=',$getdistrictCode)
            ->whereNotIn('Type', ['HO','DO'])
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
           // return 'sdfvgg';
            $centerID = Input::get('center');
            $Course = Input::get('Course');

            $sql = "select assessornomination.id,
                  organisation.OrgaName,
                  coursestarted.CourseCode,
                  coursedetails.CourseName,
                  assessor.Name,
                  assessornomination.AssessorActive,
                  assessornomination.AssessorStatus,
                  assessornomination.DateNominated,
                  assessornomination.DateRejected,
                  assessornomination.DateRenominated,
                  assessornomination.LetterPrintForAssessor
                  from assessornomination
                  left join organisation
                  on assessornomination.OrgaId=organisation.id
                  left join coursestarted
                  on assessornomination.CS_ID=coursestarted.CS_ID
                  left join coursedetails
                  on assessornomination.CD_ID=coursedetails.CD_ID
                  left join assessor
                  on assessornomination.AssessorId=assessor.id
                  where assessornomination.CS_ID='$Course'
                  and assessornomination.Deleted=0";

                $total = DB::select(DB::raw($sql));
                $view->courses = $total;
                $view->CSID = $Course;

                return $view;
        }

        
    }

    public function LoadAssessors1()
    {
        $AssessorInstitute = Input::get('AssessorInstitute');
        $CSID = Input::get('CSID');
        //$getCourseListCode = Coursestarted::where('CS_ID','=',$CSID)->pluck('CourseListCode');
        //$getTradeId = Course::where('CourseListCode','=',$getCourseListCode)->where('Deleted','=',0)->pluck('TradeId');
        $res = DB::select(DB::raw("select assessor.id,assessor.AssessorId,assessor.Name,assessor.Type,nvqcompetencystandard.code,nvqcompetencystandard.name as csmname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessorinstitute
  on assessorworkingplace.InstituteId=assessorinstitute.id
  left join assessortrade
  on assessor.AssessorTradeId=assessortrade.id
   and assessortrade.Active='Yes'
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  where assessor.Deleted=0
  and assessorworkingplace.InstituteId='$AssessorInstitute'"));
        return json_encode($res);
    }

    public function LoadAssessors2()
    {
        $AssessorInstitute = Input::get('AssessorInstitute');
        $Assessor1 = Input::get('Assessor1');
         $res = DB::select(DB::raw("select assessor.id,assessor.AssessorId,assessor.Name,assessor.Type,nvqcompetencystandard.code,nvqcompetencystandard.name as csmname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessorinstitute
  on assessorworkingplace.InstituteId=assessorinstitute.id
  left join assessortrade
  on assessor.AssessorTradeId=assessortrade.id
   and assessortrade.Active='Yes'
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  where assessor.Deleted=0
  and assessorworkingplace.InstituteId='$AssessorInstitute' 
  and assessor.id != '$Assessor1'"));
        return json_encode($res);
    }

    public function EUGetOngoingCoursese()
    {
        $centerid = Input::get('CenterId');
        //return $centerid;
        $res = DB::select(DB::raw("select coursestarted.CS_ID,coursestarted.CourseCode,coursedetails.CourseName
                                  from coursestarted
                                  left join nvqcoursestartedtrans
                                  on coursestarted.CS_ID=nvqcoursestartedtrans.CS_ID
                                 left join coursedetails
                                  on coursestarted.CourseListCode=coursedetails.CourseListCode
                                  where coursestarted.TVECSend=1
                                  and coursestarted.Deleted=0
                                  and coursestarted.Completed!='YES'
                                  and coursestarted.OrgaId='$centerid'
                                  and nvqcoursestartedtrans.FinalAssessHeld=0
                                  and nvqcoursestartedtrans.AssessorNominated=0
                                   and nvqcoursestartedtrans.Deleted=0"));
            return json_encode($res);
        
    }

    public function GetNVTINDO()
    {
        $dis = Input::get('districtcode');
       // return $dis;

         $res = DB::select(DB::raw("select organisation.id,
  organisation.OrgaName,
  organisation.Type
  from organisation
  left join organisationtype
  on organisation.TypeId=organisationtype.OT_ID
  where organisation.Deleted='0'
  and organisation.Active='Yes'
  and organisation.DistrictCode='$dis'
  and organisationtype.Type NOT IN('DO','HO')
  order by organisation.Type"));
             return json_encode($res);
    }


    public function AssignAssessorForCourse()
    {
        $method=Request::getMethod();
        $view = View::make('Assessor.AssignCreate');
        $view->district = District::orderBy('DistrictName')->get();
        $view->AssessorInstitute = NVQAssessorInstitute::where('Deleted','=',0)->orderBy('InstituteName')->get();
        
        
      

        if($method == 'GET')
        {
            return $view;
        }
        if($method == 'POST')
        {
                //return 'sdfa';
            $CS_ID = Input::get('CSID');
            $Assessor1 = Input::get('Assessor1');
            $Assessor2 = Input::get('Assessor2');
            $CenterId = Input::get('CenterId');
            $getCourseListCode = Coursestarted::where('CS_ID','=',$CS_ID)->pluck('CourseListCode');
            $getCD_ID = Course::where('CourseListCode','=',$getCourseListCode)->where('Deleted','=',0)->pluck('CD_ID');
            $getcourseTransID = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->pluck('id');

            $v = new NVQAssessorNomination();
            $v->OrgaId = $CenterId;
            $v->CS_ID = $CS_ID;
            $v->CD_ID = $getCD_ID;
            $v->CSTransId = $getcourseTransID;
            $v->AssessorId = $Assessor1;
            $v->User =  User::getSysUser()->userID;
            $v->save();

            $c = new NVQAssessorNomination();
            $c->OrgaId = $CenterId;
            $c->CS_ID = $CS_ID;
            $c->CD_ID = $getCD_ID;
            $c->CSTransId = $getcourseTransID;
            $c->AssessorId = $Assessor2;
            $c->User = User::getSysUser()->userID;
            $c->save();

            $updateNVQCoursestartedAssessorNominated = NVQCoursestartedTrans::where('CS_ID','=',$CS_ID)->update(array('AssessorNominated' => 1));
           
             return Redirect::to('AssignAssessorForCourse')->with("done", true);

        }
    }


    public function DownloadExcelAssessorList()
    {
         $COMTradeID = Input::get('TradeID');
        $getCOMSCode = NVQcompetencystandard::where('id','=',$COMTradeID)->pluck('code');
        $getCONSname = NVQcompetencystandard::where('id','=',$COMTradeID)->pluck('name');

        if($COMTradeID == '0'){
    
            

  $sql = "SELECT assessor.AssessorId,
  assessor.Name,
  assessor.HomeAddress,
  assessor.HomeTel,
  assessor.Mobile,
  assessor.Designation,
  assessorworkingplace.Address,
  assessorworkingplace.ContactNo,
  assessor.Note,
   assessor.Type,
  nvqcompetencystandard.code,nvqcompetencystandard.name as Cname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessortrade
  on assessor.AssessorId=assessortrade.AssessorId
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  and assessortrade.Active='Yes'
  where assessor.Deleted=0
 
  
";

  } 
  else{
     $sql="SELECT assessor.AssessorId,
  assessor.Name,
  assessor.HomeAddress,
  assessor.HomeTel,
  assessor.Mobile,
  assessor.Designation,
  assessorworkingplace.Address,
  assessorworkingplace.ContactNo,
  assessor.Note,
   assessor.Type,
  nvqcompetencystandard.code,nvqcompetencystandard.name as Cname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessortrade
  on assessor.AssessorId=assessortrade.AssessorId
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  and assessortrade.Active='Yes'
  where assessor.Deleted=0
  and assessortrade.CompitancyStandardId='$COMTradeID'
  
 ";  
}
$applicant = DB::select(DB::raw($sql));


         $excel = new SimpleExcel('csv');      // make the output as CCSV

        $printablearray = array();  // prepare Main array 

        $headerArray = array('Competency Code','AssessorId', 'Name', 'HomeAddress', 'HomeTelephone', 'MobileNo', 'Designation', 'OfficeAddress', 'OfficeTelephone', 'Note','Type'); // prepare headers array

        array_push($printablearray, $headerArray);  // put header array inside the printable array

        foreach ($applicant as $applicant) {
            array_push($printablearray, array($applicant->code,$applicant->AssessorId , $applicant->Name, $applicant->HomeAddress, $applicant->HomeTel, $applicant->Mobile, $applicant->Designation, $applicant->Address, $applicant->ContactNo, $applicant->Note,$applicant->Type));
        }
        $excel->writer->setData($printablearray); // now all your data should be in printableArray
        $excel->writer->saveFile('D:\AssessorList'); // save it
        //return $ComepencystandardId;


    }

    public function PrintAssessorList()
    {
        $COMTradeID = Input::get('CS_ID');
        $getCOMSCode = NVQcompetencystandard::where('id','=',$COMTradeID)->pluck('code');
        $getCONSname = NVQcompetencystandard::where('id','=',$COMTradeID)->pluck('name');

          if($COMTradeID == '0'){
    
            

  $sql = "SELECT assessor.AssessorId,
  assessor.Name,
  assessor.HomeAddress,
  assessor.HomeTel,
  assessor.Mobile,
  assessor.Designation,
  assessorworkingplace.Address,
  assessorworkingplace.ContactNo,
  assessor.Note,
   assessor.Type,
  nvqcompetencystandard.code,nvqcompetencystandard.name as Cname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessortrade
  on assessor.AssessorId=assessortrade.AssessorId
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  and assessortrade.Active='Yes'
  where assessor.Deleted=0
 
  
";

  } 
  else{
     $sql="SELECT assessor.AssessorId,
  assessor.Name,
  assessor.HomeAddress,
  assessor.HomeTel,
  assessor.Mobile,
  assessor.Designation,
  assessorworkingplace.Address,
  assessorworkingplace.ContactNo,
  assessor.Note,
   assessor.Type,
  nvqcompetencystandard.code,nvqcompetencystandard.name as Cname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessortrade
  on assessor.AssessorId=assessortrade.AssessorId
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  and assessortrade.Active='Yes'
  where assessor.Deleted=0
  and assessortrade.CompitancyStandardId='$COMTradeID'
  
 ";  
}
$total = DB::select(DB::raw($sql));

 if($COMTradeID == '0'){
   $html = '<h4><center><b><u>Assessor List For All Trades</u></b></center></h3><br/>';
 }
 else
{
   $html = '<h4><center><b><u>Assessor List For '.$getCOMSCode.' - '.$getCONSname.' </u></b></center></h3><br/>';
 }
       
        $html .='<center> <table style = "font-size:12px" align="center" border=1 width="1000"  v:shapes="_x0000_s1029" cellpadding="2" cellspacing=0 style="border-collapse:collapse;"> <thead>
		<td width="71"><b>Competency Code</b></td>
		<td width="71"><b>Assess ID</b></td>
        <td ><b>Name</b></td>
        <td ><b>Home Address</b></td>
        <td ><b>Home Telephone</b></td>
        <td ><b>Mobile No</b></td>
        <td ><b>Designation</b></td>
        <td ><b>Office Address</b></td>
        <td ><b>Office TelephoneM</b></td>
        <td ><b>Note</b></td>
        <td ><b>Type</b></td>
        </thead>
        <tbody>';

        foreach ($total as $t) {

            if($t->Type == 'Probation')
            {
            $html.='<tr>
			 <td ><center><font color="blue">'.$t->code.'</center></td>
            <td ><center><font color="blue">'.$t->AssessorId.'</center></td>
            <td ><center><font color="blue">'.$t->Name.'</center></td>
            <td ><center><font color="blue">'.$t->HomeAddress.'</center></td>
            <td ><center><font color="blue">'.$t->HomeTel.'</center></td>
            <td ><center><font color="blue">'.$t->Mobile.'</center></td>
            <td ><center><font color="blue">'.$t->Designation.'</center></td>
            <td ><center><font color="blue">'.$t->Address.'</center></td>
            <td ><center><font color="blue">'.$t->ContactNo.'</center></td>
            <td ><center><font color="blue">'.$t->Note.'</center></td>
            <td ><center><font color="blue">'.$t->Type.'</center></td>
            </tr>';

            }
            elseif($t->Type == 'Licenced')
            {
                 $html.='<tr>
				  <td ><center><font color="blue">'.$t->code.'</center></td>
            <td ><center><font color="green">'.$t->AssessorId.'</center></td>
            <td ><center><font color="green">'.$t->Name.'</center></td>
            <td ><center><font color="green">'.$t->HomeAddress.'</center></td>
            <td ><center><font color="green">'.$t->HomeTel.'</center></td>
            <td ><center><font color="green">'.$t->Mobile.'</center></td>
            <td ><center><font color="green">'.$t->Designation.'</center></td>
            <td ><center><font color="green">'.$t->Address.'</center></td>
            <td ><center><font color="green">'.$t->ContactNo.'</center></td>
            <td ><center><font color="green">'.$t->Note.'</center></td>
             <td ><center><font color="green">'.$t->Type.'</center></td>
            </tr>';
            }
            else
            {$html.='<tr>
		 <td ><center><font color="blue">'.$t->code.'</center></td>
            <td ><center><font color="black">'.$t->AssessorId.'</center></td>
            <td ><center><font color="black">'.$t->Name.'</center></td>
            <td ><center><font color="black">'.$t->HomeAddress.'</center></td>
            <td ><center><font color="black">'.$t->HomeTel.'</center></td>
            <td ><center><font color="black">'.$t->Mobile.'</center></td>
            <td ><center><font color="black">'.$t->Designation.'</center></td>
            <td ><center><font color="black">'.$t->Address.'</center></td>
            <td ><center><font color="black">'.$t->ContactNo.'</center></td>
            <td ><center><font color="black">'.$t->Note.'</center></td>
             <td ><center><font color="black">'.$t->Type.'</center></td>
            </tr>';
            }

           
           
        }
$html.='</tbody></table><center><br/><p>Note :Assessors indicated in <font color="blue">*blue</font> are on probation. Assessors indicated in <font color="green">**green</font> are licenced assessors.Assessors indicated in <b>black</b> are registered assessors.</p>';

        
        echo $html;

    }

    public function ViewAndDownloadAssessor()
    {
        $method=Request::getMethod();
        $view = View::make('Assessor.View');
        $view->trade = NVQcompetencystandard::where('Deleted', '!=', 1)->get();
        $orgaid = User::getSysUser()->organisationId;
        $TypeId = Organisation::where('id', '=', $orgaid)->pluck('TypeId');
        $Type = OrganisationType::where('OT_ID', '=', $TypeId)->pluck('Type');
        
       /*f ($Type == 'HO'){
        $view->center = Organisation::where('Deleted', '!=', 1)->OrderBy('OrgaName')->get();     
        }
        //return $view;*/

    if($method == 'GET')
    {
        return $view;
    }
    if($method == 'POST')
    {
          $centerId = Input::get('center');//Competency started ID
          //return $centerId;
            if($centerId == '0'){
    
            

  $sql = "SELECT assessor.AssessorId,
  assessor.Name,
  assessor.HomeAddress,
  assessor.HomeTel,
  assessor.Mobile,
  assessor.Designation,
  assessorworkingplace.Address,
  assessorworkingplace.ContactNo,
  assessor.Note,
   assessor.Type,
  nvqcompetencystandard.code,nvqcompetencystandard.name as Cname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessortrade
  on assessor.AssessorId=assessortrade.AssessorId
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  and assessortrade.Active='Yes'
  where assessor.Deleted=0
 
  
";

  } 
  else{
     $sql="SELECT assessor.AssessorId,
  assessor.Name,
  assessor.HomeAddress,
  assessor.HomeTel,
  assessor.Mobile,
  assessor.Designation,
  assessorworkingplace.Address,
  assessorworkingplace.ContactNo,
  assessor.Note,
   assessor.Type,
  nvqcompetencystandard.code,nvqcompetencystandard.name as Cname
  from assessor
  left join assessorworkingplace
  on assessor.OfficeAddress=assessorworkingplace.id
  left join assessortrade
  on assessor.AssessorId=assessortrade.AssessorId
  left join nvqcompetencystandard
  on assessortrade.CompitancyStandardId=nvqcompetencystandard.id
  and assessortrade.Active='Yes'
  where assessor.Deleted=0
  and assessortrade.CompitancyStandardId='$centerId'
  
 ";  
}
$total = DB::select(DB::raw($sql));
$view->courses = $total;
$view->CSID = $centerId;
return $view;

    }

    }

    public function saveAssessorRecord()
    {

      //return 'dsfsd';

         $validator = NVQAssessor::validate(Input::all());
        if ($validator->passes()) {

        $AssessorID = Input::get('AssessorID');
        $Name = Input::get('Name');
        $HAddress = Input::get('HAddress');
        $HTelephone = Input::get('HTelephone');
        $Mobile = Input::get('Mobile');
        $Designation = Input::get('Designation');
        $OfficeInstitute = Input::get('M_Code');
        $WorkingPlace = Input::get('WorkingPlace');
        $Type = Input::get('Type');
        $OTelephone = Input::get('OTelephone');
        $Note = input::get('Note');
        //$TradeId = Input::get('TradeId');
		$TradeIds = [];
        $TradeIds = Input::get('TradeId');

		$assesorAvailability = NVQAssessor::where('Deleted','=',0)->where('AssessorId','=',$AssessorID)->get();
		
		if(count($assesorAvailability)==0)
		{
			 $v =  new NVQAssessor();
			$v->AssessorId =  $AssessorID;
			$v->Name = $Name;
			$v->HomeAddress = $HAddress;
			$v->HomeTel = $HTelephone;
			$v->Mobile =  $Mobile;
			$v->Designation = $Designation;
			$v->OfficeAddress = $WorkingPlace;// store Working place id because we can take institute id from that record.
			$v->OfficeTel = $OTelephone;
			$v->Type = $Type;
			$v->Note = $Note;
			$v->User = User::getSysUser()->userID;
			//$v->AssessorTradeId = $getNATCSID;
			$v->save();
		}
       
		$Counttrades = count($TradeIds);
		$Update = NVQAssessorTradeCompetencyStandard::
					where('AssessorId','=',$AssessorID)
					->update(array('Deleted' => 1));

			for($i=0;$i<$Counttrades;$i++)
			{
				$availability = NVQAssessorTradeCompetencyStandard::
					where('AssessorId','=',$AssessorID)->where('CompitancyStandardId','=',$TradeIds[$i])
					->get();
					if(count($availability)>0)
					{
						$update = NVQAssessorTradeCompetencyStandard::
						where('AssessorId','=',$AssessorID)->where('CompitancyStandardId','=',$TradeIds[$i])
						->update(array('Deleted' => 0));
					}
					else{
						$c = new NVQAssessorTradeCompetencyStandard();
					$c-> AssessorId = $AssessorID;
					$c-> CompitancyStandardId = $TradeIds[$i];
					$c-> User = User::getSysUser()->userID;
					$c->save();
					}
					
					
					
					
					
			}
			
			
			
		
        return Redirect::to('AssessorCreate')->with("done", true);


    }
    else// validator else
    {
         return Redirect::back()->withErrors($validator);
    }
   }

    public function AssessorCreate() {
        $view = View::make('Assessor.Create');
        $view->user = User::getSysUser();
        $view->NVQAssessorInstitute = NVQAssessorInstitute::where('Deleted', '=', 0)->get();
        $view->NVQcompetencystandard = NVQcompetencystandard::where('Deleted','0',0)->get();
        return $view;
    }

    public function getWorkingPlace()
    {
            
             $Instituteid=Input::get('ModuleCode');
            $res = DB::select(DB::raw("select assessorworkingplace.id,assessorworkingplace.Address,assessorworkingplace.Placename
  from assessorworkingplace
  where assessorworkingplace.InstituteId='$Instituteid'
  and assessorworkingplace.Deleted=0"));
             return json_encode($res);
    
    }

    public function saveAssessorWorkingPlace() {
        $validator = NVQAssessorWorkingPlace::validate(Input::all());
        $html = '';

        //return 'in function';
        if ($validator->passes()) {

            //return 'Inside method';

            $WorkingPlaceName = Input::get('WorkingPlaceName'); 
            $WorkingPlaceAddress = Input::get('WorkingPlaceAddress');
            $InstituteId = Input::get('InstituteId');
            $ContactNo = Input::get('ContactNo');

            $alreadyexist = NVQAssessorWorkingPlace::where('Placename','=',$WorkingPlaceName)->where('Address','=',$WorkingPlaceAddress)->where('Deleted','=',0)->where('InstituteId','=',$InstituteId)->get();
            if(count($alreadyexist) == 0)
            {
                $I = new NVQAssessorWorkingPlace();
                $I->InstituteId = $InstituteId;
                $I->Placename = $WorkingPlaceName;
                $I->Address = $WorkingPlaceAddress;
                $I->ContactNo = $ContactNo;
                $I->User = User::getSysUser()->userID;
                $I->save();
            }

            $InstituteList = NVQAssessorWorkingPlace::where('Deleted', '!=', 1)->where('InstituteId','=',$InstituteId)->orderBy('Placename')->get();
           
          
            $html.='<select name="WorkingPlace" id="WorkingPlace" ><option value="">--Select Working Place--</option>';
            foreach ($InstituteList as $cl) {
                if ($cl->Placename == $WorkingPlaceName && $cl->Address == $WorkingPlaceAddress && $cl->InstituteId == $InstituteId) {
                    $html.='<option value="' . $cl->id . '" selected>' . $cl->Placename . ' - '.$cl->Address.'</option>';
                } else {
                    $html.='<option value="' . $cl->id . '" >' . $cl->Placename . ' - '.$cl->Address.'</option>';
                }
            }
            $html.='</select><span style="margin-left:5px;"><input type="button"  value="New Working Place" name="NewModule" id="NewModule" onclick="addModule1()"></span>';


            $done = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                   Working Place Added Successfully!
                </strong>
                <br>
            </div>';
            $json = array("html" => $html, "done" => $done);
            return json_encode($json, 0);
        } else {
            $messages = $validator->messages();
            foreach ($messages->all() as $msg) {
                $html.='<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">'
                        . '<i class="icon-remove"></i>'
                        . '</button>'
                        . '<strong>'
                        . ' <i class="icon-remove"></i>'
                        . 'Error!'
                        . '</strong>' . $msg . '<br/></div>';
            }
            $json = array("html" => $html, "ModuleId" => 0);
            echo json_encode($json, 0);
        }
    }


     public function saveAssessorInstitute() {
        $validator = NVQAssessorInstitute::validate(Input::all());
        $html = '';

        //return 'in function';
        if ($validator->passes()) {

            //return 'Inside method';

            $InstituteName = Input::get('InstituteName'); 
            $InstituteAddress = Input::get('InstituteAddress');

            $alreadyexist = NVQAssessorInstitute::where('InstituteName','=',$InstituteName)->where('Address','=',$InstituteAddress)->where('Deleted','=',0)->get();
            if(count($alreadyexist) == 0)
            {
                $I = new NVQAssessorInstitute();
                $I->InstituteName = $InstituteName;
                $I->Address = $InstituteAddress;
                $I->User = User::getSysUser()->userID;
                $I->save();
            }

            $getLastInstituteID = NVQAssessorInstitute::where('Deleted', '!=', 1)->orderBy('id', 'desc')->first();
            $getAssesorworkingplace = NVQAssessorWorkingPlace::where('Deleted','=',0)->where('InstituteId','=',$getLastInstituteID->id)->orderBy('Placename')->get();
            $InstituteList = NVQAssessorInstitute::where('Deleted', '!=', 1)->orderBy('InstituteName')->get();
            $html.='<select name="M_Code" id="M_Code" ><option value="">--Select Working Institute--</option>';
            foreach ($InstituteList as $cl) {
                if ($cl->InstituteName == $InstituteName && $cl->Address == $InstituteAddress) {
                    $html.='<option value="' . $cl->id . '" selected>' . $cl->InstituteName . ' - '.$cl->Address.'</option>';
                } else {
                    $html.='<option value="' . $cl->id . '" >' . $cl->InstituteName . ' - '.$cl->Address.'</option>';
                }
            }
            $html.='</select><span style="margin-left:5px;"><input type="button"  value="New Working Institute" name="NewModule" id="NewModule" onclick="addModule()"></span>';


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
            $json = array("html" => $html, "InstituteAddress" => $getLastInstituteID, "done" => $done);
            return json_encode($json, 0);
        } else {
            $messages = $validator->messages();
            foreach ($messages->all() as $msg) {
                $html.='<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">'
                        . '<i class="icon-remove"></i>'
                        . '</button>'
                        . '<strong>'
                        . ' <i class="icon-remove"></i>'
                        . 'Error!'
                        . '</strong>' . $msg . '<br/></div>';
            }
            $json = array("html" => $html, "ModuleId" => 0);
            echo json_encode($json, 0);
        }
    }

    public function findModuleCourse() {
        $v = View::make('ModuleCourse.ViewModuleCourse');
        $v->user = User::getSysUser();
        $v->moduleCourse = ModuleCourse::where('CourseListCode', 'LIKE', Input::get('key') . '%')->where('Deleted', '=', 0)->get();
        $v->Issearch = true;
        return $v;
    }

    public function deleteModuleCourse() {
        $id = Input::get('id');
        $module = ModuleCourse::findOrFail($id); // if not found show 404 page
        $module->Deleted = 1;
		$module->Changed = 1;
        $module->User = User::getSysUser()->userID;
        $module->save();
        return Redirect::to('ViewModuleCourse');
    }

    public function CreateModuleCourse() {
        $method = Request::getMethod();
        $view = View::make('ModuleCourse.CreateModuleCourse')->with('user', User::getSysUser());
        $view->modules = Module::where('Deleted', '!=', 1)->orderBy('ModuleCode')->get();
        $view->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
        if ($method == "GET") {
            return $view;
        } 
        if ($method == "POST") {
            $validator = ModuleCourse::validateCreate(Input::all());
            if ($validator->passes()) {
                $mc = new ModuleCourse;
                $mc->fill(Input::all());
                $mc->InstituteId = User::getSysUser()->instituteId;
                $mc->User = User::getSysUser()->userID;
                //$mc->DateEntered = \Carbon\Carbon::now();
                $mc->save();
                return $view->with("done", true);
            } else {
                return Redirect::to('CreateModuleCourse')->withErrors($validator);
            }
        }
    }

    public function editModuleCourse() {
        switch (Request::getMethod()) {
            case 'GET':

                $v = View::make('ModuleCourse.EditModuleCourse');
                $v->modules = Module::where('Deleted', '!=', 1)->orderBy('ModuleCode')->get();
                $v->listCode = Course::where('Deleted', '!=', 1)->orderBy('CourseListCode')->get();
				//$v->courseName = Course::where('Deleted', '!=', 1)->orderBy('CourseName')->get();
                $v->moduleC = ModuleCourse::find(Input::get('id'));
                $m1 = ModuleCourse:: where('Deleted', '!=', 1)->where('MC_ID', '=', Input::get('id'))->pluck('M_Code');
                $m2 = Module::where('Deleted', '!=', 1)->where('ModuleCode', '=', $m1)->pluck('ModuleId');
                $v->m2 = $m2;
                $v->m3 = Module::where('Deleted', '!=', 1)->where('ModuleCode', '=', $m1)->pluck('ModuleCode');
                $v->m4 = Module::where('Deleted', '!=', 1)->where('ModuleCode', '=', $m1)->pluck('ModuleName');
                $v->user = User::getSysUser();
                return $v;
                break;

            case 'POST':
                $validator = ModuleCourse::validateEdit(Input::all());
                $id = Input::get('MC_ID');
                if ($validator->passes()) {
                    $m = ModuleCourse::find($id);
                    $m->fill(Input::all());
                    $m->Changed = 1;
                    if ($m->save()) {
                        return Redirect::to('ViewModuleCourse');
                    }
                } else {
                    return Redirect::back()->withErrors($validator);
                }

                break;
            default:
                break;
        }
    }

    public function moduleCourseexist() {
        $course = Input::get('CourseListCode');
        $k = User::getSysUser()->instituteId;
	    $duration = Course::where('Deleted', '!=', 1)->where('CourseListCode','=', $course)->pluck('Duration');
		$cname = Course::where('Deleted', '!=', 1)->where('CourseListCode','=', $course)->pluck('CourseName');
        $sql = "SELECT modulecourse.CourseListCode,modulecourse.Hours,modulecourse.Type,
                modulecourse.assessmentweight,modulecourse.finalmarkweight,module.ModuleName,modulecourse.CACutOff,modulecourse.FECutOff
		from modulecourse
		inner JOIN module
		on modulecourse.ModuleId=module.ModuleId
		where modulecourse.InstituteId='$k'
		and modulecourse.CourseListCode='$course'
		and modulecourse.Deleted!=1";
        $test = DB::select(DB::raw($sql));
        if (!empty($test)) {
            $html = "<pre><h6><center>Assigned Modules for this Course: <b>$course</b></center></h6></pre>  
	           <table id='sample-table-2' class='table table-striped table-bordered table-hover'>
                    <thead>
                    <tr>
		    <th class='center'>Course List Code</th>
                    <th>Module Name</th>							
                    <th>Type</th>
                    <th>Hours(Hours)</th>
                    <th>CA Weight </th>
                     <th>CA CutOff </th>
                    <th>Final Exam Weight</th>
                     <th>Final Exam cutOff</th>
		   </tr>
                    </thead>
                    <tbody>";
            foreach ($test as $e) {
                $html .='<tr>
                            <td class="center" >' . $e->CourseListCode . '</td>
                            <td>' . $e->ModuleName . '</td>							
                            <td>' . $e->Type . '</td>
                            <td>' . $e->Hours . '</td>
                            <td>' . $e->assessmentweight . '</td>
                            <td>' . $e->CACutOff . '</td>
                            <td>' . $e->finalmarkweight . '</td>
                            <td>' . $e->FECutOff . '</td></tr>';
            }

          return $html;
        } else {
            return '<b>Course : </b>' .$cname.  '<b>&nbsp Duration : </b>' .$duration.
			'<br>No any Modules Assigned';
        }
    }

  

    public function getInstitureNameAssessor() {
        $v = Input::get('ModuleCode');

        //return $v;
        $getModuleName = NVQAssessorInstitute::where('id','=',$v)->pluck('Address');
        //$getModuleID = Module::where('Deleted', "!=", 1)->where('ModuleCode', "=", $v)->pluck('ModuleId');
        echo $getModuleName;
    }

    public function getModuleIdAjax() {
        $v = Input::get('ModuleCode');
        $getModuleId = Module::where('Deleted', "!=", 1)->where('ModuleCode', "=", $v)->pluck('ModuleId');
        echo $getModuleId;
    }

    public function saveupdateModule() {
        $validator = Module::validateEdit(Input::all());
        $html = '';
        if ($validator->passes()) {
            $ModuleId = Input::get('ModuleId');
            $findModule = Module::find($ModuleId);
            $findModule->fill(Input::all());
            $findModule->Changed = 1;
            $findModule->save();
            $Modulelist = Module::where('Deleted', '!=', 1)->get();
            $html.='<select name="M_Code" id="M_Code" ><option value="">--Select Module--</option>';
            foreach ($Modulelist as $cl) {
                if ($cl->ModuleCode == $findModule->ModuleCode) {
                    $html.='<option value="' . $cl->ModuleCode . '" selected>' . $cl->ModuleCode . '</option>';
                } else {
                    $html.='<option value="' . $cl->ModuleCode . '">' . $cl->ModuleCode . '</option>';
                }
            }
            $html.='</select><span style="margin-left:5px;"><input type="button"  value="Edit Module Code" name="EditModule" id="EditModule" onclick="editModule()"></span>';
            $done = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                   Module  Added Successfully!
                </strong>
                <br>
            </div>';
            $json = array("html" => $html, "M_Code" => $findModule->ModuleCode, "done" => $done);
            return json_encode($json, 0);
        } else {
            $messages = $validator->messages();
            foreach ($messages->all() as $msg) {
                $html.='<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">'
                        . '<i class="icon-remove"></i>'
                        . '</button>'
                        . '<strong>'
                        . ' <i class="icon-remove"></i>'
                        . 'Error!'
                        . '</strong>' . $msg . '<br/></div>';
            }
            $json = array("html" => $html, "ModuleId" => 0);
            echo json_encode($json, 0);
        }
    }

}
