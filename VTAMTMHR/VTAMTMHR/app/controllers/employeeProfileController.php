<?php

class employeeProfileController extends BaseController{
    
     function viewDetails()
    {
        $empid = User::getSysUser()->EmpId;
        $employee = Employee::where('id', "=", $empid)->first();
        $qualifi = EmployeeQualification::where('EmpId', "=", $empid)->get();
        $alResult= DB::select("SELECT * FROM alresult WHERE `alresult`.`ApplicantNIC`=(SELECT `NIC` FROM `employee` WHERE `employee`.`id`='".$empid."')");
        $olResult= DB::select("SELECT * FROM olresultapplicant WHERE `olresultapplicant`.`ApplicantNIC`=(SELECT `NIC` FROM `employee` WHERE `employee`.`id`='".$empid."')");
        $subject= DB::select("SELECT * FROM olsubject WHERE `Deleted`=0"); 
        $subject1=DB::select("SELECT * FROM alsubject WHERE `Deleted`=0");
        $v = View::make('EmployeeProfile.viewProfile');
        $v->results=$alResult;
        $v->OLresults=$olResult;
        $v->OLSubject=$subject;
        $v->ALSubject=$subject1;
        $v->qualification= $qualifi;
        $v->Employee = $employee;
        $v->user = User::getSysUser();

       



        return $v;
    }
    function edit()
            {
        switch (Request::getMethod()) {
            case 'GET':
                $view = View::make('EmployeeProfile.Edit');
                $id = Input::get('cid');
                
                $view->Event = Employee::where('NIC', '=', $id)->first();
                $view->user = User::getSysUser();
                $ins = User::getSysUser()->instituteId;
                $view->institute = Institue::where('InstituteId', '=', $ins)->pluck('InstituteName');
                $org = User::getSysUser()->organisationId;
                $view->organization = Organisation::where('id', '=', $org)->pluck('OrgaName');
                $view->in_id = $ins;
                $view->og_id = $org;
                $view->holidaytypes = District::get();
                return $view;
                break;

            case 'POST':
             $empid = User::getSysUser()->EmpId;
                $validator = Employee::validate(Input::all());





                if ($validator->passes()) {
                    $id = Input::get('id');

                    $i = Employee::find($id);

                    $i->fill(Input::all());
                    $i->Changed = 1;


                    if ($i->save()) {
                        $qualifi = EmployeeQualification::where('EmpId', "=", $empid)->get();
                        $alResult= DB::select("SELECT * FROM alresult WHERE `alresult`.`ApplicantNIC`=(SELECT `NIC` FROM `employee` WHERE `employee`.`id`='".$empid."')");
                        $olResult= DB::select("SELECT * FROM olresultapplicant WHERE `olresultapplicant`.`ApplicantNIC`=(SELECT `NIC` FROM `employee` WHERE `employee`.`id`='".$empid."')");    
                        $subject= DB::select("SELECT * FROM olsubject WHERE `Deleted`=0"); 
                        $subject1=DB::select("SELECT * FROM alsubject WHERE `Deleted`=0");
                        $vi = View::make('EmployeeProfile.viewProfile');
                        $vi->OLSubject=$subject;
                        $vi->ALSubject=$subject1;
                        $vi->results=$alResult;
                        $vi->OLresults=$olResult;
                        $vi->Employee = Employee::where('id', "=", $empid)->first();
                        $vi->qualification = $qualifi;

                        return $vi;
                        //return Redirect::to('Event');
                    }
                } else {
                    return Redirect::to('editEmployee?cid=' . Input::get('NIC'))->withErrors($validator);
                }

                break;

            default:
        }  
                
                
                
            }
        public function EditQualification() {
        $view = View::make('EmployeeProfile.editQualification');

        $method = Request::getMethod();

        if ($method == "GET") {
            
            $empqua = EmployeeQualification::where('EmpId', "=", Input::get('id'))->first();
            $view->employment = EmploymentCode::where("Deleted", "!=", 1)->get();
            $view->user = User::getSysUser();
            $view->institutes = User::getSysUser()->Institute;
            $view->empqua = $empqua;
            $view->quaorg = QualificationOrganisation::where("Deleted", "!=", 1)->get();
            $view->qualification = Qualification::where("Deleted", "!=", 1)->get();
            return $view;
        }
        if ($method == "POST") {
//            echo json_encode(Input::all());
            $id= Input::get('EQ_ID');
            $validator = EmployeeQualification::validate(Input::all());
            if ($validator->passes()) {
                $array = Input::all();
echo json_encode(Input::all());
                $oq = EmployeeQualification::find($id);
                $oq->fill(Input::all());
                $oq->Changed = 1;
                $oq->save();
               if ($oq->save()) {
                   return Redirect::to('viewEmployeeDetails');
               }
            } else {
               
                return Redirect::to('editEmpQualifications')->withErrors($validator);
            }
        }
    }
    public function viewALResult() {

    $applicantnic = Input::get('aplicantnic');
    $nic = '';
    $name = '';
  
    $validator = Validator::make(array('applicantnic' => $applicantnic), array('applicantnic' => array('required')), array('applicantnic.required' => 'NIC field is Required'));
    if ($validator->passes()) {
            $person = DB::table('employee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->Initials . ' ' . $person->LastName;
            }
        if (empty($person)) {
            $person = DB::table('employee')->where('EPFNo', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->Initials . ' ' . $person->LastName;
            }
        }
        if (!empty($person)) {
//            if (Input::get('button') == 'view') {
                $aplicantAL = ALResult::where('ApplicantNIC', '=', $applicantnic)->where('Deleted', '!=', 1)->orderBy('Year')->orderBy('id')->get();
                return View::make('EmployeeProfile.viewALResult')
                ->with('nic', $nic)
                ->with('name', $name)
                ->with('currentdata', $aplicantAL);

        } else {
            return Redirect::back()->with('message', 'Enter a valid Applicant NIC');
        }
    } else {
        return Redirect::back()->withErrors($validator);
    }
}
    public function editALResult() {
        $method = Request::getMethod();
        if ($method == 'GET') {
            $applicantnic = Input::get('aplicantnic');
            $person = DB::table('applicant')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->NameWithInitials;
            }
            if (empty($person)) {
                $person = DB::table('trainee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
                if (!empty($person)) {
                    $nic = $person->NIC;
                    $name = $person->NameWithInitials;
                }
            }
            if (empty($person)) {
                $person = DB::table('trainee')->where('Training_No', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
                if (!empty($person)) {
                    $nic = $person->NIC;
                    $name = $person->NameWithInitials;
                }
            }
            if (empty($person)) {
                $person = DB::table('employee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
                if (!empty($person)) {
                    $nic = $person->NIC;
                    $name = $person->Initials . ' ' . $person->LastName;
                }
            }
            if (empty($person)) {
                $person = DB::table('employee')->where('EPFNo', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
                if (!empty($person)) {
                    $nic = $person->NIC;
                    $name = $person->Initials . ' ' . $person->LastName;
                }
            }
            $year = Input::get('year');
            $aplicantAL = ALResult::where('ApplicantNIC', '=', $nic)->where('Deleted', '=', 0)->where('Year', '=', $year)->get();
            $stream = $aplicantAL[0]->Stream;
            $English = ALSubject::where('SubjectName', '=', 'General English')->where('Deleted', '!=', 1)->first();
            $GIQ = ALSubject::where('SubjectName', '=', 'GIQ')->where('Deleted', '!=', 1)->first();
            $subjectlist = ALSubject::where('Stream', '=', $stream)->where('Deleted', '!=', 1)->get();
            return View::make('EmployeeProfile.addALResult')
                            ->with('nic', $nic)
                            ->with('name', $name)
                            ->with('year', $year)
                            ->with('English', $English)
                            ->with('GIQ', $GIQ)
                            ->with('subjectlist', $subjectlist)
                            ->with('currentdata', $aplicantAL)
                            ->with('user', User::getSysUser())
                            ->with('action', 'editEmployeeALResult')
                            ->with('button', 'Edit');
        }
        if ($method == 'POST') {
            $inputs = Input::all();
            if ($inputs['subject1'] == $inputs['subject2'] || $inputs['subject1'] == $inputs['subject3'] || $inputs['subject2'] == $inputs['subject3']) {
                return Redirect::back()
                                ->with('message', 'Subject Repetedly Entered');
            }
            $validator = Validator::make(array('ApplicantNIC' => $inputs['ApplicantNIC'],
                        'shy' => $inputs['shy'],
                        'IndexNo' => $inputs['IndexNo'],
                        'Year' => $inputs['Year'],
                        'subject1' => $inputs['subject1'],
                        'subject2' => $inputs['subject2'],
                        'subject3' => $inputs['subject3'],
                        'result1' => $inputs['result1'],
                        'result2' => $inputs['result2'],
                        'result3' => $inputs['result3'],
                        'result4' => $inputs['result4'],
                        'result5' => $inputs['result5']), array(
                        'ApplicantNIC' => array('Required'),
                        'shy' => array('Required'),
                        'IndexNo' => array('Required', 'numeric', 'min:9999999', 'max:100000000'),
                        'Year' => array('Required', 'numeric', 'min:999', 'max:10000'),
                        'subject1' => array('Required'),
                        'subject2' => array('Required'),
                        'subject3' => array('Required'),
                        'result1' => array('Required', 'min:1', 'max:1'),
                        'result2' => array('Required', 'min:1', 'max:1'),
                        'result3' => array('Required', 'min:1', 'max:1'),
                        'result4' => array('Required', 'min:1', 'max:1'),
                        'result5' => array('Required', 'numeric', 'min:0', 'max:100')));
            if ($validator->passes()) {
                $j = 0;
                for ($i = 0; $i < 5; $i++) {
                    $applicantnic = $inputs['ApplicantNIC'];
                 
                    $year = $inputs['Year'];
                    $indexno = $inputs['IndexNo'];
                    $subject = $inputs['subject' . ($i + 1)];
                    $result = $inputs['result' . ($i + 1)];
                    $shy = $inputs['shy'];
                    $stream = $inputs['stream'];
                    if ($subject != "" && $result != "") {
                        if (isset($inputs['alresid' . ($i + 1)])) {
                            $uniqueCheck = ALResult::uniqueCheck($subject, $applicantnic, $year);
                            if ($uniqueCheck == 1) {
                                $result = ALResult::where('SubjectId', ' = ', $subject)->where('ApplicantNIC', ' = ', $applicantnic)->where('Year', ' = ', $year)->first();
                                $alresult = ALResult::find($result->id);
                                $alresult->shy = $shy;
                                $alresult->IndexNo = $indexno;
                                $alresult->Year = $year;
                                $alresult->Stream = $stream;
                                $alresult->Deleted = 0;
                                $alresult->User = User::getSysUser()->userID;
                                $alresult->DateEntered = \Carbon\Carbon::now();
                                $alresult->save();
                                $alresult2 = ALResult::find($inputs['alresid' . ($i + 1)]);
                                $alresult2->Deleted = 1;
                                $alresult2->save();
                                $j++;
                            } elseif ($uniqueCheck == 2) {
                                $alresult = ALResult::find($inputs['alresid' . ($i + 1)]);
                                $alresult->ApplicantNIC = $applicantnic;
                                $alresult->SubjectId = $subject;
                                $alresult->Result = $result;
                                $alresult->Year = $year;
                                $alresult->Stream = $stream;
                                $alresult->shy = $shy;
                                $alresult->IndexNo = $indexno;
                                $alresult->Year = $year;
                                $alresult->Deleted = 0;
                                $alresult->User = User::getSysUser()->userID;
                                $alresult->DateEntered = \Carbon\Carbon::now();
                                $alresult->save();
                                $j++;
                            } elseif ($uniqueCheck == 3) {
                                $alresult = ALResult::find($inputs['alresid' . ($i + 1)]);
                                //$alresult->ApplicantID = $applicantid;
                                $alresult->ApplicantNIC = $applicantnic;
                                $alresult->SubjectId = $subject;
                                $alresult->Result = $result;
                                $alresult->Year = $year;
                                $alresult->Stream = $stream;
                                $alresult->shy = $shy;
                                $alresult->IndexNo = $indexno;
                                $alresult->Year = $year;
                                $alresult->Deleted = 0;
                                $alresult->User = User::getSysUser()->userID;
                                $alresult->DateEntered = \Carbon\Carbon::now();
                                $alresult->save();
                                $j++;
                            }
                        } else {
                            $uniqueCheck = ALResult::uniqueCheck($subject, $applicantnic, $year);
                            if ($uniqueCheck == 1) {
                                $result = ALResult::where('SubjectId', ' = ', $subject)->where('ApplicantNIC', ' = ', $applicantnic)->where('Year', ' = ', $year)->first();
                                $alresult = ALResult::find($result->id);
                                $alresult->shy = $shy;
                                $alresult->IndexNo = $indexno;
                                $alresult->Year = $year;
                                $alresult->Stream = $stream;
                                $alresult->Deleted = 0;
                                $alresult->User = User::getSysUser()->userID;
                                $alresult->DateEntered = \Carbon\Carbon::now();
                                $alresult->save();
                                $j++;
                            } elseif ($uniqueCheck == 3) {
                                $alresult = new ALResult;
                                $alresult->ApplicantNIC = $applicantnic;
                                $alresult->SubjectId = $subject;
                                $alresult->Result = $result;
                                $alresult->Year = $year;
                                $alresult->Stream = $stream;
                                $alresult->shy = $shy;
                                $alresult->IndexNo = $indexno;
                                $alresult->Year = $year;
                                $alresult->Deleted = 0;
                                $alresult->User = User::getSysUser()->userID;
                                $alresult->DateEntered = \Carbon\Carbon::now();
                                $alresult->save();
                                $j++;
                            }
                        }
                    }
                }
                if ($j > 0) {
                    return Redirect::to('EmployeeALResultHome?aplicantnic=' . $applicantnic . '&button=view')
                                    ->with('done', 'Edited Successfully');
                } else {
                    return Redirect::back()
                                    ->with('message', 'No Data to Add');
                }
            } else {
                return Redirect::back()->withErrors($validator);
            }
        }
    }

      public function addOLResult() {
        $inputs = Input::all();

        $validator = Validator::make(
            array('year' => $inputs['year'], 'indexno' => $inputs['indexno'], 'medium' => $inputs['medium'], 'result1' => $inputs['result1'],
                'result2' => $inputs['result2'], 'result3' => $inputs['result3'], 'result4' => $inputs['result4'], 'result5' => $inputs['result5'],
                'result6' => $inputs['result6']), array('year' => array('required', 'numeric', 'min:1990', 'max:2200'), 
                'indexno' => array('required', 'digits:8'),
                'medium' => array('required'), 'result1' => array('required', 'size:1'), 'result2' => array('required', 'size:1'), 
                'result3' => array('required', 'size:1'),
                'result4' => array('required', 'size:1'), 
                'result5' => array('required', 'size:1'), 
                'result6' => array('required', 'size:1')),
                 array('year.required' => 'Year is Required', 
                    'year.numeric' => 'Year Should be a Number',
                     'year.min' => 'Year Should be Between 1990 and 2200', 'year.max' => 'Year Should be Between 1990 and 2200',
                'indexno.required' => 'Index No is Required', 'indexno.digits' => 'Index No Should have 8 Digits',
                'result1.required' => 'Result Field 1 is Required', 'result1.size' => 'Result Should Be a Single English Letter',
                'result2.required' => 'Result Field 2 is Required', 'result2.size' => 'Result Should Be a Single English Letter',
                'result3.required' => 'Result Field 3 is Required', 'result3.size' => 'Result Should Be a Single English Letter',
                'result4.required' => 'Result Field 4 is Required', 'result4.size' => 'Result Should Be a Single English Letter',
                'result5.required' => 'Result Field 5 is Required', 'result5.size' => 'Result Should Be a Single English Letter',
                'result6.required' => 'Result Field 6 is Required', 'result6.size' => 'Result Should Be a Single English Letter')
);
if ($validator->passes()) {
    $abc = OLResult::where('ApplicantNIC', '=', $inputs['aplicantNIC'])->where('Year', '=', $inputs['year'])->first();
    if (empty($abc)) {
        $j = 0;
        for ($i = 0; $i < 10; $i++) {

            if ($inputs['subject' . ($i + 1)] != '' && $inputs['result' . ($i + 1)] != '') {
                $uniqueCheck = OLResult::uniqueCheck($inputs['subject' . ($i + 1)], $inputs['aplicantNIC'], $inputs['year']);

                if ($uniqueCheck == 1) {
                    $result = OLResult::where('SubjectID', '=', $inputs['subject' . ($i + 1)])->where('ApplicantNIC', '=', $inputs['aplicantNIC'])->where('Year', '=', $inputs['year'])->get();
                    $add = OLResult::find($result[0]->id);
                    $add->Medium = $inputs['medium'];
                    $add->Result = $inputs['result' . ($i + 1)];
                    $add->IndexNo = $inputs['indexno'];
                    $add->Year = $inputs['year'];
                    $add->Deleted = 0;
                    $add->User = User::getSysUser()->userID;
                    $add->DateEntered = \Carbon\Carbon::now();
                    $add->save();
                    $j++;
                } elseif ($uniqueCheck == 3) {
                    $add = new OLResult;
                    $add->SubjectId = $inputs['subject' . ($i + 1)];
                    $add->Medium = $inputs['medium'];
                    $add->ApplicantNIC = $inputs['aplicantNIC'];
                    $add->IndexNo = $inputs['indexno'];
                    $add->Year = $inputs['year'];
                    $add->Result = $inputs['result' . ($i + 1)];
                    $add->User = User::getSysUser()->userID;
                    $add->DateEntered = \Carbon\Carbon::now();
                    $add->save();
                    $j++;
                }
            }
        }
        if ($j > 0) {
            if($inputs['button']=='submitandapplicant'){
                return Redirect::to('createApplicant?NCC=' . $inputs['NCC'])
                ->with('done', 'Added Successfully');
            }elseif($inputs['button']=='submitanal'){
                return Redirect::to('viewALResult?aplicantnic=' . $inputs['aplicantNIC'].'&NCC='.$inputs['NCC'])
                ->with('done', 'Added Successfully');
            }else{
                return Redirect::to('viewEmployeeOLResult?aplicantnic=' . $inputs['aplicantNIC'] . '&button=view')
                ->with('done', 'Added Successfully');
            }
        } else {
            return Redirect::back()
            ->with('message', 'No Data to Add');
        }
    } else {
        if($inputs['button']=='submitandapplicant'){
                return Redirect::to('createApplicant?NCC=' . $inputs['NCC'])
                ->with('done', 'Added Successfully');
            }elseif($inputs['button']=='submitanal'){
                return Redirect::to('viewALResult?aplicantnic=' . $inputs['aplicantNIC'].'&NCC='.$inputs['NCC'])
                ->with('done', 'Added Successfully');
            }else{
                return Redirect::back()
        ->with('message', 'Already Added');
            }
        
    }
} else {
    return Redirect::back()->withErrors($validator);
}
}
    
public function editOLResult() {
    $method = Request::getMethod();
    if ($method == 'GET') {
        $applicantnic = Input::get('aplicantnic');
        $person = DB::table('applicant')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
        if (!empty($person)) {
            $nic = $person->NIC;
            $name = $person->NameWithInitials;
        }
        if (empty($person)) {
            $person = DB::table('trainee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->NameWithInitials;
            }
        }
        if (empty($person)) {
            $person = DB::table('trainee')->where('Training_No', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->NameWithInitials;
            }
        }
        if (empty($person)) {
            $person = DB::table('employee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->Initials . ' ' . $person->LastName;
            }
        }
        if (empty($person)) {
            $person = DB::table('employee')->where('EPFNo', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->Initials . ' ' . $person->LastName;
            }
        }
        $year = Input::get('year');
        $subjects = DB::table('olsubject')->where('type', '=', 'optional')->where('Deleted', '=', 0)->get();
        $language = DB::table('olsubject')->where('type', '=', 'language')->where('Deleted', '=', 0)->get();
        $relegion = DB::table('olsubject')->where('type', '=', 'relegion')->where('Deleted', '=', 0)->get();
        $english = DB::table('olsubject')->where('SubjectName', '=', 'English Language')->where('Deleted', '=', 0)->first();
        $maths = DB::table('olsubject')->where('SubjectName', '=', 'Mathematics')->where('Deleted', '=', 0)->first();
        if ($year < 2007) {
            $history = DB::table('olsubject')->where('SubjectName', '=', 'Social Studies')->where('Deleted', '=', 0)->first();
        } else {
            $history = DB::table('olsubject')->where('SubjectName', '=', 'History')->where('Deleted', '=', 0)->first();
        }
        $science = DB::table('olsubject')->where('SubjectName', '=', 'Science & Technology')->where('Deleted', '=', 0)->first();
        $aplicantOL = OLResult::where('ApplicantNIC', '=', $nic)->where('Year', '=', $year)->where('Deleted', '=', 0)->get();
        return View::make('EmployeeProfile.addOLResult')
        ->with('nic', $nic)
        ->with('name', $name)
        ->with('english', $english)
        ->with('maths', $maths)
        ->with('history', $history)
        ->with('scinece', $science)
        ->with('language', $language)
        ->with('religon', $relegion)
        ->with('olsubject', $subjects)
        ->with('currentdata', $aplicantOL)
        ->with('user', User::getSysUser())
        ->with('action', 'editEmployeeOLResult')
        ->with('button', 'Edit');
    }
    if ($method == 'POST') {
        $inputs = Input::all();
        $validator = Validator::make(
            array('year' => $inputs['year'], 'indexno' => $inputs['indexno'], 'medium' => $inputs['medium'], 'result1' => $inputs['result1'],
                'result2' => $inputs['result2'], 'result3' => $inputs['result3'], 'result4' => $inputs['result4'], 'result5' => $inputs['result5'],
                'result6' => $inputs['result6'],), array('year' => array('required', 'numeric', 'min:1990', 'max:2200'), 'indexno' => array('required', 'digits:8'),
                'medium' => array('required'), 'result1' => array('required', 'size:1'), 'result2' => array('required', 'size:1'), 'result3' => array('required', 'size:1'),
                'result4' => array('required', 'size:1'), 'result5' => array('required', 'size:1'), 'result6' => array('required', 'size:1')), array('year.required' => 'Year is Required', 'year.numeric' => 'Year Should be a Number', 'year.min' => 'Year Should be Between 1990 and 2200', 'year.max' => 'Year Should be Between 1990 and 2200',
                'indexno.required' => 'Index No is Required', 'indexno.digits' => 'Index No Should have 8 Digits',
                'result1.required' => 'Result Field 1 is Required', 'result1.size' => 'Result Should Be a Single English Letter',
                'result2.required' => 'Result Field 2 is Required', 'result2.size' => 'Result Should Be a Single English Letter',
                'result3.required' => 'Result Field 3 is Required', 'result3.size' => 'Result Should Be a Single English Letter',
                'result4.required' => 'Result Field 4 is Required', 'result4.size' => 'Result Should Be a Single English Letter',
                'result5.required' => 'Result Field 5 is Required', 'result5.size' => 'Result Should Be a Single English Letter',
                'result6.required' => 'Result Field 6 is Required', 'result6.size' => 'Result Should Be a Single English Letter')
);
if ($validator->passes()) {
    $j = 0;
    for ($i = 0; $i < 10; $i++) {

        if ($inputs['subject' . ($i + 1)] != '' && $inputs['result' . ($i + 1)] != '') {
            if (isset($inputs['olresid' . ($i + 1)])) {
                $add = OLResult::find($inputs['olresid' . ($i + 1)]);
                $add->SubjectId = $inputs['subject' . ($i + 1)];
                $add->Medium = $inputs['medium'];
                $add->ApplicantNIC = $inputs['aplicantNIC'];
                $add->IndexNo = $inputs['indexno'];
                $add->Year = $inputs['year'];
                $add->Result = $inputs['result' . ($i + 1)];
                $add->User = User::getSysUser()->userID;
                $add->DateEntered = \Carbon\Carbon::now();
                $add->save();
                $j++;
            } else {
                $add = new OLResult;
                $add->SubjectId = $inputs['subject' . ($i + 1)];
                $add->Medium = $inputs['medium'];
                $add->ApplicantNIC = $inputs['aplicantNIC'];
                $add->IndexNo = $inputs['indexno'];
                $add->Year = $inputs['year'];
                $add->Result = $inputs['result' . ($i + 1)];
                $add->User = User::getSysUser()->userID;
                $add->DateEntered = \Carbon\Carbon::now();
                $add->save();
                $j++;
            }
        } else {
            if (isset($inputs['olresid' . ($i + 1)])) {
                $add = OLResult::find($inputs['olresid' . ($i + 1)]);
                $add->Deleted = 1;
                $add->User = User::getSysUser()->userID;
                $add->DateEntered = \Carbon\Carbon::now();
                $add->save();
            }
        }
    }
    if ($j > 0) {
        return Redirect::to('viewEmployeeOLResult?aplicantnic=' . $inputs['aplicantNIC'] . '&button=view')
        ->with('done', 'Edited Successfully');
    } else {
        return Redirect::back()
        ->with('message', 'No Data to Add');
    }
} else {
    return Redirect::back()->withErrors($validator);
}
}
}    
 
public function viewOLResult() {
    $applicantnic = Input::get('aplicantnic');
   
    $nic = '';
    $name = '';
    $validator = Validator::make(array('applicantnic' => $applicantnic), array('applicantnic' => array('required')), array('applicantnic.required' => 'NIC field is Required'));
    if ($validator->passes()) {
        $person = DB::table('applicant')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
        if (!empty($person)) {
            $nic = $person->NIC;
            $name = $person->NameWithInitials;
        }
        if (empty($person)) {
            $person = DB::table('trainee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->NameWithInitials;
            }
        }
        if (empty($person)) {
            $person = DB::table('trainee')->where('Training_No', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->NameWithInitials;
            }
        }
        if (empty($person)) {
            $person = DB::table('employee')->where('NIC', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->Initials . ' ' . $person->LastName;
            }
        }
        if (empty($person)) {
            $person = DB::table('employee')->where('EPFNo', '=', $applicantnic)->where('Deleted', '!=', 1)->first();
            if (!empty($person)) {
                $nic = $person->NIC;
                $name = $person->Initials . ' ' . $person->LastName;
            }
        }
        if (!empty($person)) {
  //          if (Input::get('button') == 'view') {
                $aplicantOL = OLResult::where('ApplicantNIC', '=', $applicantnic)->where('Deleted', '=', 0)->orderBy('Year')->orderBy('id')->get();
                return View::make('EmployeeProfile.viewOLResult')
                ->with('nic', $nic)
                ->with('name', $name)
                ->with('currentdata', $aplicantOL);
 //           }

//             else {
//                $subjects = DB::table('olsubject')->where('type', '=', 'optional')->where('Deleted', '=', 0)->get();
//                $language = DB::table('olsubject')->where('type', '=', 'language')->where('Deleted', '=', 0)->get();
//                $relegion = DB::table('olsubject')->where('type', '=', 'relegion')->where('Deleted', '=', 0)->get();
//                $english = DB::table('olsubject')->where('SubjectName', '=', 'English Language')->where('Deleted', '=', 0)->first();
//                $maths = DB::table('olsubject')->where('SubjectName', '=', 'Mathematics')->where('Deleted', '=', 0)->first();
//                $socialstudies = DB::table('olsubject')->where('SubjectName', '=', 'Social Studies')->where('Deleted', '=', 0)->first();
//                $history = DB::table('olsubject')->where('SubjectName', '=', 'History')->where('Deleted', '=', 0)->first();
//                $science = DB::table('olsubject')->where('SubjectName', '=', 'Science & Technology')->where('Deleted', '=', 0)->first();
//                return View::make('EmployeeProfile.addOLResult')
//                ->with('nic', $nic)
//                ->with('name', $name)
//                ->with('english', $english)
//                ->with('maths', $maths)
//                ->with('socialstudies', $socialstudies)
//                ->with('history', $history)
//                ->with('scinece', $science)
//                ->with('language', $language)
//                ->with('religon', $relegion)
//                ->with('olsubject', $subjects)
//                ->with('user', User::getSysUser())
//                ->with('action', 'addOLResult')
//                ->with('button', 'Add')
//                ->with('NCC',Input::get('NCC'));
//            }
        } else {
            return Redirect::back()->with('message', 'Enter a valid Applicant NIC');
        }
    } else {
        return Redirect::back()->withErrors($validator);
    }
}
  
    
    
}