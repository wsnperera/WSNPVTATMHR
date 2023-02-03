<?php

class HomeController extends BaseController {

    public function __construct() {
        
    }
	
	

    public function login() {
        $myview = View::make("Home.login");
        return $myview;
    }
	public function RefreshIncrement() {
		//return 'clicked';
		//hr get all permenant staff where personal file completed
					 $spromobasic = DB::select(DB::raw("select hrpromotion.*
													  from hrpromotion
													  left join hremployee
													  on hrpromotion.Emp_ID=hremployee.id
													  left join employeetype
													  on hrpromotion.EmpType=employeetype.ET_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  where hrpromotion.Deleted=0
													  and hrpromotion.CurrentRecord='Yes'
													  and hrpromotion.Priority=1
													  and hremployee.Deleted=0
													  and hremployee.PersonalFileCompleted=1
													  and employeetype.EmployeeType in('Permanent')
													  and transfertype.Available=1"));
					// get current Date
					 $CURDate = date("Y-m-d");
					 $CURDate = date('Y-m-d', strtotime($CURDate));
					foreach($spromobasic as $sp)
					{
						//read all sfatt query
						// check particular employee record available in increment table
						$checkAvailability = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->get();
						
						if(count($checkAvailability) == 0)
						{
							//if not available particular employee in increment table enter old record to the system
							$spp = new HREmployeeSalaryStepData();
							$spp->EmpID = $sp->Emp_ID;
							$spp->PromotionID = $sp->P_ID;
							$spp->SalaryStepTransID = $sp->PSalaryStep;
							$spp->ServiceCategoryID = $sp->PServiceCategoryID;
							$spp->Active = 1;
							$spp->Approved = 1;
							$currentY = date("Y");
							$dash = '-';
							$currentyearIncrementDate = $currentY.$dash.$sp->IncrementMonth.$dash.$sp->IncrementDay;
							$currentyearIncrementDate = date('Y-m-d', strtotime($currentyearIncrementDate));
							//return $currentyearIncrementDate;
							/* if($sp->P_ID =='194')
							{
								return $currentyearIncrementDate;
							} */
							if($currentyearIncrementDate >= $CURDate)
							{
								//if cudate less than currentdate
								//$currentY = date("Y")+1;
								//$currentyearIncrementDate =$currentY.$dash.$sp->IncrementMonth.$dash.$sp->IncrementDay;
								
							    $currentY = date("Y")-1;
								$currentyearIncrementDate =$currentY.$dash.$sp->IncrementMonth.$dash.$sp->IncrementDay;
								$currentyearIncrementDate = date('Y-m-d', strtotime($currentyearIncrementDate));
								$spp->NextIncrementDate = $currentyearIncrementDate;
								
								
							}
							else
							{	
								$spp->NextIncrementDate = $currentyearIncrementDate;
							}
							
							$spp->User = User::getSysUser()->userID;
							$spp->save();
							
							$updatehrpromotion = HRPromotion::where('P_ID','=',$sp->P_ID)->update(array('AutoLoadToSalaryStep' => 1));
							$currentY = date("Y");
							$currentyearIncrementDate = '';
						}
						else
						{
							// if particular employee alredy in increment table
							
							// anthimata approve yes or reactive karapu line eke max increment date eka ganna
							$checkwithPID = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->whereNotIn('Approved',[0])->max('NextIncrementDate');
							$ApprovemethodID = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->whereNotIn('Approved',[0])->where('NextIncrementDate','=',$checkwithPID)->pluck('id');
							$ApproveMeth = HREmployeeSalaryStepData::where('id','=',$ApprovemethodID)->pluck('Approved');
							if($ApproveMeth == 5)
							{
								//Approved Yes
								$checkwithPID =  HREmployeeSalaryStepData::where('id','=',$ApprovemethodID)->pluck('ReactivatedDate');
								
							}
							
							if(!empty($checkwithPID))
							{
								// max increment date eka thiyenawanam? e date ekata one year add karala next increment date eka hadanna
							$sqladdyear = DB::select(DB::raw("select DATE_ADD('".$checkwithPID."', INTERVAL 1 YEAR) as newdate"));
							$newdata3 =  json_decode(json_encode((array)$sqladdyear),true);
							$expectedcomstep = $newdata3[0]["newdate"];
							
							
							//check karanna ilagata denna thiyena dineta record ekak available da kiyala
						 	$cheavilb9 = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('Approved','=',0)->where('NextIncrementDate','=',$expectedcomstep)->get();
							// hadanna orne
							if(count($cheavilb9) == 0)
								{
									// available naththan 
									$spp = new HREmployeeSalaryStepData();
									$spp->EmpID = $sp->Emp_ID;
									$spp->PromotionID = $sp->P_ID;
									
									 $getcountserviceC = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->get();
									if(count($getcountserviceC) == 0)
									{//service cat not available
										$spp->SalaryStepTransID = $sp->PSalaryStep;
										$spp->ServiceCategoryID = $sp->PServiceCategoryID;
										$spp->Approved = 1;
										$spp->NextIncrementDate = $checkwithPID;
									}
									else
									{
										//service cat  available
										$getmaxdatarec = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('id','=',$ApprovemethodID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->pluck('SalaryStepTransID');
										$salsettrans = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->first();
										$getsalarurealstepno = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('StepNo');
										$getsalarurealservicecatid = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('SalaryScaleID');
										$gg = $getsalarurealstepno+1;
										$getnextrealstepnoID = HRSalaryStepTrans::where('StepNo','=',$gg)->where('SalaryScaleID','=',$getsalarurealservicecatid)->pluck('id');
										$spp->SalaryStepTransID = $getnextrealstepnoID;
										$spp->ServiceCategoryID = $getsalarurealservicecatid;
										$spp->Approved = 0;
										$spp->NextIncrementDate = $expectedcomstep;
									}
									
									$spp->Active = 1;
									
									
									
									
									
									$spp->User = User::getSysUser()->userID;
									$spp->save();
									
									$updatehrpromotion = HRPromotion::where('P_ID','=',$sp->P_ID)->update(array('AutoLoadToSalaryStep' => 1));
									
								}
								else
								{
									$getlatestold = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('Approved','=',0)->where('NextIncrementDate','=',$expectedcomstep)->pluck('id');
									$dpd =  HREmployeeSalaryStepData::findOrFail($getlatestold); 
									
									$dpd->PromotionID = $sp->P_ID;
									
									$getcountserviceC = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->get();
									if(count($getcountserviceC) == 0)
									{   //service cat not available
										$dpd->SalaryStepTransID = $sp->PSalaryStep;
										$dpd->ServiceCategoryID = $sp->PServiceCategoryID;
										$dpd->Approved = 1;
										$dpd->NextIncrementDate = $checkwithPID;
									}
									else
									{	//service cat  available
								//return $sp->Emp_ID;
										  $getmaxdatarec = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('id','=',$ApprovemethodID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->pluck('SalaryStepTransID');
										  $salsettrans = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->where('Deleted','=',0)->get();
										 $getsalarurealstepno = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('StepNo');
										 $getsalarurealservicecatid = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('SalaryScaleID');
										$gg = $getsalarurealstepno+1;
										 $getnextrealstepnoID = HRSalaryStepTrans::where('StepNo','=',$gg)->where('SalaryScaleID','=',$getsalarurealservicecatid)->pluck('id');
										$dpd->SalaryStepTransID = $getnextrealstepnoID;
										$dpd->ServiceCategoryID = $getsalarurealservicecatid;
										$dpd->Approved = 0;
										
									}
									//return 'new';
									$dpd->Active = 1;
									
									$dpd->User = User::getSysUser()->userID;
									$dpd->save();
									$updatehrpromotion = HRPromotion::where('P_ID','=',$sp->P_ID)->update(array('AutoLoadToSalaryStep' => 1));
									
								}
							}
							
							
							
						}
						
												
																		
					}
					//hr
					 $updatehrpromotion = HRPromotion::where('PSalaryStep','=',0)->update(array('PSalaryStep' => NULL));
					$updatehrpromotion1 = HRPromotion::where('PServiceCategoryID','=',0)->update(array('PServiceCategoryID' => NULL));
					$updatehrpromotion2 = HRPromotion::where('PGradeId','=',0)->update(array('PGradeId' => NULL));
					// $view->USERTYPE = $userType;
					
					return 1;
	}

    public function authuser() {
        $uname = Input::get('username');
        $pwd = Input::get('password');
		
        $user = User::where('userName', '=', $uname)->where("active", "=", 1)->first();
        if ($user == null) {
            Session::flash("error", "Invalid Login");
            return Redirect::to('/');
        }
        if ($user != null) {
            if (!Hash::check($pwd, $user->passWord)) {
                Session::flash("error", "Invalid Password");
                return Redirect::to('/');
            } else {
                Session::put("currentUser", $user);
				$UserDivision = $user->UserDivision;
				if($UserDivision == 'Admin')
				{
					$view = View::make("Home.HRprofile");
				    User::setCache();
					$userOrgId = User::getSysUser()->organisationId;
					$userType = User::getSysUser()->userType;
					$userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
					$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
					$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
					$userEMPID = User::getSysUser()->EmpId;
					$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
					$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
					
					$Admintype = $user->userType;
					$usertypeaa = UserType::where('id','=',$Admintype)->pluck('UType');
					$view->usertypeaa = $usertypeaa;
					
				if($usertypeaa === 'HR-Admin')
				{
				
				//hr get all permenant staff where personal file completed
					 $spromobasic = DB::select(DB::raw("select hrpromotion.*
													  from hrpromotion
													  left join hremployee
													  on hrpromotion.Emp_ID=hremployee.id
													  left join employeetype
													  on hrpromotion.EmpType=employeetype.ET_ID
													  left join transfertype
													  on hrpromotion.TransferType=transfertype.T_ID
													  where hrpromotion.Deleted=0
													  and hrpromotion.CurrentRecord='Yes'
													  and hrpromotion.Priority=1
													  and hremployee.Deleted=0
													  and hremployee.PersonalFileCompleted=1
													  and employeetype.EmployeeType in('Permanent')
													  and transfertype.Available=1"));
					// get current Date
					 $CURDate = date("Y-m-d");
					 $CURDate = date('Y-m-d', strtotime($CURDate));
					foreach($spromobasic as $sp)
					{
						//read all sfatt query
						// check particular employee record available in increment table
						$checkAvailability = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->get();
						
						if(count($checkAvailability) == 0)
						{
							//if not available particular employee in increment table enter old record to the system
							$spp = new HREmployeeSalaryStepData();
							$spp->EmpID = $sp->Emp_ID;
							$spp->PromotionID = $sp->P_ID;
							$spp->SalaryStepTransID = $sp->PSalaryStep;
							$spp->ServiceCategoryID = $sp->PServiceCategoryID;
							$spp->Active = 1;
							$spp->Approved = 1;
							$currentY = date("Y");
							$dash = '-';
							$currentyearIncrementDate = $currentY.$dash.$sp->IncrementMonth.$dash.$sp->IncrementDay;
							$currentyearIncrementDate = date('Y-m-d', strtotime($currentyearIncrementDate));
							//return $currentyearIncrementDate;
							/* if($sp->P_ID =='194')
							{
								return $currentyearIncrementDate;
							} */
							if($currentyearIncrementDate >= $CURDate)
							{
								//if cudate less than currentdate
								//$currentY = date("Y")+1;
								//$currentyearIncrementDate =$currentY.$dash.$sp->IncrementMonth.$dash.$sp->IncrementDay;
								
							    $currentY = date("Y")-1;
								$currentyearIncrementDate =$currentY.$dash.$sp->IncrementMonth.$dash.$sp->IncrementDay;
								$currentyearIncrementDate = date('Y-m-d', strtotime($currentyearIncrementDate));
								$spp->NextIncrementDate = $currentyearIncrementDate;
								
								
							}
							else
							{	
								$spp->NextIncrementDate = $currentyearIncrementDate;
							}
							
							$spp->User = User::getSysUser()->userID;
							$spp->save();
							
							$updatehrpromotion = HRPromotion::where('P_ID','=',$sp->P_ID)->update(array('AutoLoadToSalaryStep' => 1));
							$currentY = date("Y");
							$currentyearIncrementDate = '';
						}
						else
						{
							// if particular employee alredy in increment table
							
							// anthimata approve yes or reactive karapu line eke max increment date eka ganna
							$checkwithPID = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->whereNotIn('Approved',[0])->max('NextIncrementDate');
							$ApprovemethodID = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->whereNotIn('Approved',[0])->where('NextIncrementDate','=',$checkwithPID)->pluck('id');
							$ApproveMeth = HREmployeeSalaryStepData::where('id','=',$ApprovemethodID)->pluck('Approved');
							if($ApproveMeth == 5)
							{
								//Approved Yes
								$checkwithPID =  HREmployeeSalaryStepData::where('id','=',$ApprovemethodID)->pluck('ReactivatedDate');
								
							}
							
							if(!empty($checkwithPID))
							{
								// max increment date eka thiyenawanam? e date ekata one year add karala next increment date eka hadanna
							$sqladdyear = DB::select(DB::raw("select DATE_ADD('".$checkwithPID."', INTERVAL 1 YEAR) as newdate"));
							$newdata3 =  json_decode(json_encode((array)$sqladdyear),true);
							$expectedcomstep = $newdata3[0]["newdate"];
							
							
							//check karanna ilagata denna thiyena dineta record ekak available da kiyala
						 	$cheavilb9 = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('Approved','=',0)->where('NextIncrementDate','=',$expectedcomstep)->get();
							// hadanna orne
							if(count($cheavilb9) == 0)
								{
									// available naththan 
									$spp = new HREmployeeSalaryStepData();
									$spp->EmpID = $sp->Emp_ID;
									$spp->PromotionID = $sp->P_ID;
									
									 $getcountserviceC = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->get();
									if(count($getcountserviceC) == 0)
									{//service cat not available
										$spp->SalaryStepTransID = $sp->PSalaryStep;
										$spp->ServiceCategoryID = $sp->PServiceCategoryID;
										$spp->Approved = 1;
										$spp->NextIncrementDate = $checkwithPID;
									}
									else
									{
										//service cat  available
										$getmaxdatarec = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('id','=',$ApprovemethodID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->pluck('SalaryStepTransID');
										$salsettrans = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->first();
										$getsalarurealstepno = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('StepNo');
										$getsalarurealservicecatid = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('SalaryScaleID');
										$gg = $getsalarurealstepno+1;
										$getnextrealstepnoID = HRSalaryStepTrans::where('StepNo','=',$gg)->where('SalaryScaleID','=',$getsalarurealservicecatid)->pluck('id');
										$spp->SalaryStepTransID = $getnextrealstepnoID;
										$spp->ServiceCategoryID = $getsalarurealservicecatid;
										$spp->Approved = 0;
										$spp->NextIncrementDate = $expectedcomstep;
									}
									
									$spp->Active = 1;
									
									
									
									
									
									$spp->User = User::getSysUser()->userID;
									$spp->save();
									
									$updatehrpromotion = HRPromotion::where('P_ID','=',$sp->P_ID)->update(array('AutoLoadToSalaryStep' => 1));
									
								}
								else
								{
									$getlatestold = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('Approved','=',0)->where('NextIncrementDate','=',$expectedcomstep)->pluck('id');
									$dpd =  HREmployeeSalaryStepData::findOrFail($getlatestold); 
									
									$dpd->PromotionID = $sp->P_ID;
									
									$getcountserviceC = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->get();
									if(count($getcountserviceC) == 0)
									{   //service cat not available
										$dpd->SalaryStepTransID = $sp->PSalaryStep;
										$dpd->ServiceCategoryID = $sp->PServiceCategoryID;
										$dpd->Approved = 1;
										$dpd->NextIncrementDate = $checkwithPID;
									}
									else
									{	//service cat  available
								//return $sp->Emp_ID;
										  $getmaxdatarec = HREmployeeSalaryStepData::where('Deleted','=',0)->where('EmpID','=',$sp->Emp_ID)->where('id','=',$ApprovemethodID)->where('ServiceCategoryID','=',$sp->PServiceCategoryID)->pluck('SalaryStepTransID');
										  $salsettrans = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->where('Deleted','=',0)->get();
										 $getsalarurealstepno = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('StepNo');
										 $getsalarurealservicecatid = HRSalaryStepTrans::where('id','=',$getmaxdatarec)->pluck('SalaryScaleID');
										$gg = $getsalarurealstepno+1;
										 $getnextrealstepnoID = HRSalaryStepTrans::where('StepNo','=',$gg)->where('SalaryScaleID','=',$getsalarurealservicecatid)->pluck('id');
										$dpd->SalaryStepTransID = $getnextrealstepnoID;
										$dpd->ServiceCategoryID = $getsalarurealservicecatid;
										$dpd->Approved = 0;
										
									}
									//return 'new';
									$dpd->Active = 1;
									
									$dpd->User = User::getSysUser()->userID;
									$dpd->save();
									$updatehrpromotion = HRPromotion::where('P_ID','=',$sp->P_ID)->update(array('AutoLoadToSalaryStep' => 1));
									
								}
							}
							
							
							
						}
						
												
																		
					}
					//hr
					 $updatehrpromotion = HRPromotion::where('PSalaryStep','=',0)->update(array('PSalaryStep' => NULL));
					$updatehrpromotion1 = HRPromotion::where('PServiceCategoryID','=',0)->update(array('PServiceCategoryID' => NULL));
					$updatehrpromotion2 = HRPromotion::where('PGradeId','=',0)->update(array('PGradeId' => NULL));
					 $view->USERTYPE = $userType;
				}
				
				//hrDashboard
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
					$CountIncrementList = count($sqlIncrementList);
					$view->CountIncrementList = $CountIncrementList;
					$view->sqlIncrementList = $sqlIncrementList;
					
					//retired List
					$sqlHrRetired = "select hrpromotion.P_ID,hremployee.NIC,
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
									  and hrpromotion.CurrentRecord='Yes'
									  and transfertype.Available!=0
								      and YEAR(DATE_ADD(CURDATE(), INTERVAL 6 MONTH)) - YEAR(hremployee.DOB) - (RIGHT(DATE_ADD(CURDATE(), INTERVAL 6 MONTH), 5) < RIGHT(hremployee.DOB, 5)) >=60 
									  order by hremploymentcode.Designation,transfertype.Available";
					$sqlHrRetiredList = DB::select(DB::raw($sqlHrRetired));
					$CountsqlHrRetiredListList = count($sqlHrRetiredList);
					$view->CountsqlHrRetiredListList = $CountsqlHrRetiredListList;
					$view->sqlHrRetiredList = $sqlHrRetiredList;
					
				}
				elseif($UserDivision == 'Monitoring')
				{
					  $view = View::make("Home.profile");
				User::setCache();
              //Dashboard   
				
				//CourseMonitoring Plan Approve
				$userOrgId = User::getSysUser()->organisationId;
				$userType = User::getSysUser()->userType;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
			
			
					
							  
				
					
					
					
					
					
				
				}
				elseif($UserDivision == 'IR')
				{
					  $view = View::make("Home.IRProfile");
					  User::setCache();
				
				}
				
				
				else
				{
					//exam
					$view = View::make("Home.ExamProfile");
				    User::setCache();
				}
              
                
                $view->user = $user;
                return $view;
            }
        }
    }

    public function dashboard() {
		
		$UserDivision = User::getSysUser()->UserDivision;
		if($UserDivision == 'Admin')
		{
				$view = View::make("Home.HRprofile");
				$UserIDD = User::getSysUser()->userID;
				$user = User::where('userID', '=', $UserIDD)->first();
				$userOrgId = User::getSysUser()->organisationId;
                $userOrgType = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('Type');
				$UserDistrictCode = Organisation::where('Deleted','!=',1)->where('id','=',$userOrgId)->pluck('DistrictCode');
				$UserProvinceCode = District::where('DistrictCode','=',$UserDistrictCode)->pluck('ProvinceCode');
				$userEMPID = User::getSysUser()->EmpId;
				$CurrentdesID = Employee::where('id','=',$userEMPID)->pluck('CurrentDesignation');
				$Designation = EmploymentCode::where('id','=',$CurrentdesID)->pluck('Designation');
				
				//hrDashboard
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
					$CountIncrementList = count($sqlIncrementList);
					$view->CountIncrementList = $CountIncrementList;
					$view->sqlIncrementList = $sqlIncrementList;
					
						//retired List
					$sqlHrRetired = "select hrpromotion.P_ID,hremployee.NIC,
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
									  and hrpromotion.CurrentRecord='Yes'
									  and transfertype.Available!=0
								      and YEAR(DATE_ADD(CURDATE(), INTERVAL 3 MONTH)) - YEAR(hremployee.DOB) - (RIGHT(DATE_ADD(CURDATE(), INTERVAL 3 MONTH), 5) < RIGHT(hremployee.DOB, 5)) >=60 
									  order by hremploymentcode.Designation,transfertype.Available";
					$sqlHrRetiredList = DB::select(DB::raw($sqlHrRetired));
					$CountsqlHrRetiredListList = count($sqlHrRetiredList);
					$view->CountsqlHrRetiredListList = $CountsqlHrRetiredListList;
					$view->sqlHrRetiredList = $sqlHrRetiredList;
		}
		elseif($UserDivision == 'IR')
				{
					  $view = View::make("Home.IRProfile");
					  User::setCache();
					  $UserIDD = User::getSysUser()->userID;
					  $user = User::where('userID', '=', $UserIDD)->first();
				
				}
		else{
			
			$view = View::make("Home.profile");
		    $UserIDD = User::getSysUser()->userID;
            $user = User::where('userID', '=', $UserIDD)->first();
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
							  coursedetails.CourseLevel
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
					
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
					$sqlaccrediationAppTobeUpgrade = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppListTobeUpgrade = DB::select(DB::raw($sqlaccrediationAppTobeUpgrade));
					$CountACAppTobeUpgrade = count($sqlaccrediationAppListTobeUpgrade);
					
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
							  coursedetails.CourseLevel
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
							  coursedetails.CourseLevel
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
							  and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Assistant Director','Deputy Director')";
							  
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
							  coursedetails.CourseLevel
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
							   and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Training Officer')";
							  
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
							   and province.ProvinceCode=$UserProvinceCode
							  and employmentcode.Designation in('Training Officer')";
					}
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
					
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
					$sqlaccrediationAppTobeUpgrade = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppListTobeUpgrade = DB::select(DB::raw($sqlaccrediationAppTobeUpgrade));
					$CountACAppTobeUpgrade = count($sqlaccrediationAppListTobeUpgrade);
					
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
								   and province.ProvinceCode='$UserProvinceCode'
								  order by district.DistrictName,organisation.OrgaName"));
					$CountWillExpire = count($sqlwillexpire);
					
					
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
							  coursedetails.CourseLevel
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
						$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
					
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
					$sqlaccrediationAppTobeUpgrade = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppListTobeUpgrade = DB::select(DB::raw($sqlaccrediationAppTobeUpgrade));
					$CountACAppTobeUpgrade = count($sqlaccrediationAppListTobeUpgrade);
					
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
					$sql="select mocentremonitoringplan.*,
							  organisation.OrgaName,
							  organisation.Type,
							  employee.Initials,
							  employee.LastName,
							  O2.OrgaName as MOrgaName,
							  O2.Type as MType,
							  coursedetails.CourseName,
							  coursedetails.Duration,
							  coursedetails.CourseLevel
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
					$DD = DB::select(DB::raw($sql));
					$CountCMP = count($DD);
					$FF = DB::select(DB::raw($sql1));
					$CountCCMP = count($FF);
					
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppList = DB::select(DB::raw($sqlaccrediationApp));
					$CountACApp = count($sqlaccrediationAppList);
					
					$sqlaccrediationAppTobeUpgrade = "select accreditationapplication.id,province.ProvinceName,district.DistrictName,
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
										  and accreditationapplication.ApplicationReciievedStatus in('No')";
					$sqlaccrediationAppListTobeUpgrade = DB::select(DB::raw($sqlaccrediationAppTobeUpgrade));
					$CountACAppTobeUpgrade = count($sqlaccrediationAppListTobeUpgrade);
					
					
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
				//Mo My Comment List satrt
				$LoggedUserEMPId = User::getSysUser()->EmpId;
				$sql = "select mocentremonitoringplan.id,trade.TradeName,
					  district.DistrictName,organisation.OrgaName,
					  coursedetails.CourseName,coursedetails.CourseListCode,
					  courseyearplan.Year,
					  courseyearplan.batch,
					  mocentremonitoringplan.DatePlanned,
					  employee.Initials,
					  employee.LastName,
					  o2.OrgaName as eorganame,o2.Type,
					  momonitoringresult.Dreason,
					  momonitoringresult.DreasonIgnored,
					   momonitoringresult.DreasonClosed
					  from mocentremonitoringplan
					  left join courseyearplan
					  on mocentremonitoringplan.CourseYearPlanID=courseyearplan.id
					  left join organisation
					  on courseyearplan.OrgId=organisation.id
					  left join coursedetails
					  on courseyearplan.CD_ID=coursedetails.CD_ID
					  left join district
					  on organisation.DistrictCode=district.DistrictCode
					  left JOIN momonitoringresult
					  on mocentremonitoringplan.id=momonitoringresult.CMPlanID
					  left join mocomment
                      on mocentremonitoringplan.id=mocomment.CMPlanID
                      and momonitoringresult.id=mocomment.MomresultID
					  left join trade
					  on coursedetails.TradeId=trade.TradeId
					  left join employee
					  on mocentremonitoringplan.EmpId=employee.id
					  left join organisation as o2
					  on employee.CurrentOrgaID=o2.id
					  where mocentremonitoringplan.Deleted=0
					  and mocentremonitoringplan.Visited=1
					  and courseyearplan.Deleted=0
					  and organisation.Deleted=0
					  and momonitoringresult.DreasonIgnored=0
					  and momonitoringresult.DreasonClosed=0
					  and mocomment.Active=1
					  and mocomment.CommentAssigndEmpId='".$LoggedUserEMPId."'
					  and coursedetails.Deleted=0
					  and employee.Deleted=0
					  and momonitoringresult.Dreason !=''
					  order by district.DistrictName,organisation.OrgaName,coursedetails.CourseName,courseyearplan.Year,courseyearplan.batch,mocentremonitoringplan.DatePlanned";
					  $MycommentList = DB::select(DB::raw($sql));
			    $view->MycommentList = count($MycommentList);
				//Mo My Comment List End
				
				$Admintype = User::getSysUser()->userType;
				$usertypeaa = UserType::where('id','=',$Admintype)->pluck('UType');
				$view->usertypeaa = $usertypeaa;
				//Accreditation Pending Records start
				
				if($usertypeaa == 'Admin' || $userOrgType='HO')
				{
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
					 $view->sqlAccreditationTableListCount = count($sqlAccreditationTableList);
					 
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
					 $view->sqlAccreditationAppliTableListCount = count($sqlAccreditationAppliTableList);
					 
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
					$view->sqlaccrediationPayListCount = count($sqlaccrediationPayList);
				}
				
				//Accreditation Pending Records end
				 $view->AproveCMP = $CountCMP;
				 $view->AproveCMPList = $DD;
				 $view->ApproveCCMP = $CountCCMP;
				 $view->AproveCCMPList = $FF;
				 $view->ApproveACApp = $CountACApp;
				 $view->ApproveACAppTobeUpgrade = $CountACAppTobeUpgrade;
				 $view->ApproveACAppList = $sqlaccrediationAppList;
				 $view->CountWillExpire = $CountWillExpire;
				//CourseMonitoring Plan Approve 
		}
        
				 
        $view->user = $user;
        return $view;
    }

    public function logOut() {
		$user= User::getSysUser();

        Session::flush("currentUser", $user);
		 //Session::flush();
        return Redirect::to('/');
    }

    public function test() {
        $institue = Institue::find(1);
        foreach ($institue->Courses as $c) {
            echo $c->CourseName;
        }
    }
}
