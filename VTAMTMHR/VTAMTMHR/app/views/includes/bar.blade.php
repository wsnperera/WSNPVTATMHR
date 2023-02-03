<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>VTA Training Management and HR System</title>
	<link rel="shortcut icon" href="assets/logo2019l_O5h_icon.ico" type="image/x-icon" />

        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/css/chosen.css" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
        <link rel="stylesheet" href="assets/css/ace.min.css" />
        <link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="{{Url('dashboard')}}" class="brand">
                        <small>
                            <i class="icon-leaf"></i>
							Dashboard
                        </small>
						
                    </a>
					
					
					   
                       
							
                    
                   <!-- <a href="generatedNIC" class="brand">
                        <small>
                            <i class="icon-tasks"></i>
                            NIC Number Generator
                        </small>
                    </a>-->
                    <!--/.brand-->
					 
					
				
					<ul class="nav ace-nav pull-right">
					<!--<li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-envelope"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-envelope"></i>
									5 Messages
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-navbar navbar-pink">
										<li>
											<a href="#" >
												<img src="assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
												aaaaaaaaaaaaaaaaaaaaaaaaaaaaa
												
											</a>
										</li>
										
										<li>
											<a href="#" >
												<img src="assets/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
												aaaaaaaaaaaaaaaaaaaaaaaaaaaaa
												
											</a>
										</li>
									
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										See all messages
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>-->
						
			
                    
                        <li class="light-orange">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="assets/avatars/profile-pic.jpg" alt="Jason's Photo" />
                                <span class="user-info">
                                    <small>Welcome,</small>
                                    {{$user->userName}}
                                </span>
                                <i class="icon-caret-down"></i>
                            </a>
                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                               <!-- <li>
                                    <a href="{{Url('viewEmployeeDetails')}}">
                                        <i class="icon-user"></i>
                                        Profile
                                    </a>
                                </li>-->
                                <li>
                                    <a href="{{Url('changePassword')}}">
                                        <i class="icon-lock"></i>
                                        Change Password
                                    </a>
                                </li>
                                <li>
                                    <a href="{{Url('logout')}}">
                                        <i class="icon-off"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!--/.ace-nav-->
                </div><!--/.container-fluid-->
            </div><!--/.navbar-inner-->
        </div>
        <div class="main-container container-fluid">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>
            <div class="sidebar" id="sidebar">
                <ul class="nav nav-list"> 
                    @if($user->hasPermission(array('institute','organisation')))
                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text"> Organization </span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('institute'))
                            <li>
                                <a href={{URL::action('InstituteController@viewInstitute')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Institute
                                </a>
                            </li>
                            @endif

                            @if($user->hasPermission('organisation'))
                            <li>
                                <a href={{URL::action('OrganisationController@viewOrganisation')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Center
                                </a>
                            </li>
                            @endif

                            
                        </ul>
                    </li>
                    @endif

                  @if($user->hasPermission(array('viewUnits','NVQPackageUnit','courses','viewCourseYearPlan','viewTrades','AssignQPackageModules','ViewTrainingPlanReportCheck','ViewTrainingPlanUpdateDisNVTIDOTO','CreateVTCDailyTask','viewCourseCatogory')))
                   <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text"> Course </span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                                @if($user->hasPermission(array('viewTrades')))
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">  Trades  </span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('viewTrades'))
                                    <li>
                                        <a href={{URL::action('Trade1Controller@viewTrades')}}>
                                           <i class="icon-double-angle-right"></i>
                                            Trades
                                        </a>
                                    </li>
                                    @endif

                                    
                                </ul>
                            </li>
                            @endif  
							 <!-- @if($user->hasPermission(array('CreateVTCDailyTask')))
                           <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Daily Time Table  </span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                   @if($user->hasPermission('CreateVTCDailyTask'))
									<li>
										<a href='CreateVTCDailyTask'>
											<i class="icon-double-angle-right"></i>
											Update Daily Time Table Completion
										</a>
									</li>
									@endif

                                    
                                </ul>
                            </li>
                            @endif -->
                            @if($user->hasPermission('courses'))
                            <li>
                                <a href={{URL::action('CourseController@viewCourses')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Course Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('viewCourseCatogory'))
                            <li>
                                <a href='viewCourseCatogory'>
                                    <i class="icon-double-angle-right"></i>
                                   View Course Occupations
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewCompetemcyStandard'))
                            <li>
                                <a href='ViewCompetemcyStandard'>
                                   <i class="icon-double-angle-right"></i>
                                    View Competency Standards
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewNVQQualificationPackages'))
                            <li>
                                <a href='ViewNVQQualificationPackages'>
                                   <i class="icon-double-angle-right"></i>
                                    View NVQ Qualification Packages
                                </a>
                            </li>
                            @endif
                            <!-- @if($user->hasPermission('AssignQPackageModules'))
                            <li>
                                <a href='AssignQPackageModules'>
                                   <i class="icon-double-angle-right"></i>
                                    Assign Qualification Package Modules
                                </a>
                            </li>
                            @endif-->
							@if($user->hasPermission('viewUnits'))
                            <li>
                                <a href='viewUnits'>
                                    <i class="icon-double-angle-right"></i>
                                   View NVQ Units
                                </a>
                            </li>
                            @endif
							 @if($user->hasPermission('NVQPackageUnit'))
                            <li>
                                <a href='NVQPackageUnit'>
                                   <i class="icon-double-angle-right"></i>
                                    Assign Qualification Package Units
                                </a>
                            </li>
                            @endif
							
                             @if($user->hasPermission('viewCourseYearPlan'))
                            <li>
                                <a href='viewCourseYearPlan'>
                                    <i class="icon-double-angle-right"></i>
                                    View Training Plan(HO)
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewTrainingPlanUpdateDisNVTIDOTO'))
                            <li>
                                <a href='ViewTrainingPlanUpdateDisNVTIDOTO'>
                                    <i class="icon-double-angle-right"></i>
                                    View & Update Training Plan(Dsitrict/NVTI)
                                </a>
                            </li>
                            @endif
							
							<!--@if($user->hasPermission('ViewTrainingPlanReportCheck'))
                            <li>
                                <a href='ViewTrainingPlanReportCheck'>
                                    <i class="icon-double-angle-right"></i>
                                    View & Download Training Plan Report
                                </a>
                            </li>
                            @endif-->
                            


                         <!--   @if($user->hasPermission('ViewAccreditRequest'))
                            <li>
                                <a href='ViewAccreditRequest'>
                                    <i class="icon-double-angle-right"></i>
                                    Course Accreditation
                                </a>
                            </li>
                            @endif


                           
                            @if($user->hasPermission('ConfirmCourseYearPlanFirstPage'))
                            <li>
                                <a href="ConfirmCourseYearPlanFirstPage" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    Assigned Course Year Plan
                                    <br><span class="badge badge-primary">{{CourseYearPlan::getNOConfirm()}}</span>
                                </a>
                            </li>
                            @endif

                            @if($user->hasPermission('searchEntry'))    
                            <li>
                                <a href={{Url('searchEntry')}}>
                                    <i class="icon-double-angle-right"></i>
                                    Entry Qualifications
                                </a>
                            </li>
                            @endif

                            @if($user->hasPermission('viewCourseStarted'))
                            <li>
                                <a href="{{url('viewCourseStarted')}}">
                                    <i class="icon-double-angle-right"></i>
                                    Course Started View
                                </a>
                            </li>
                            @endif-->

						</ul>
						</li> 
						@endif


				<!--		@if($user->hasPermission(array('ViewModule','ViewModuleCourse','ViewModuleTask','ViewModuleTaskSeq','ViewTask')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text"> Module Course & Task Details</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewModule'))
                            <li>
                                <a href='ViewModule'>
                                    <i class="icon-double-angle-right"></i>
                                    Module
                                </a>
                            </li>
                            @endif
                             @if($user->hasPermission('ViewModuleCourse'))
                         <li>
                                <a href='ViewModuleCourse'>
                                    <i class="icon-double-angle-right"></i>
                                    Module Courses
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewModuleTask'))
                             <li>
                                <a href='CreateModuleTask'>
                                    <i class="icon-double-angle-right"></i>
                                    Create Module Task
                                </a>
                            </li> 
                             @endif 
                            @if($user->hasPermission('ViewModuleTask'))
                             <li>
                                <a href='ViewModuleTask'>
                                    <i class="icon-double-angle-right"></i>
                                    Module Task
                                </a>
                            </li> 
                             @endif 
                             @if($user->hasPermission('ViewModuleTaskSeq'))
                            <li>
                                <a href='ViewModuleTaskSeq'>
                                    <i class="icon-double-angle-right"></i>
                                    Module Task Sequence
                                </a>
                            </li> 
                            @endif  
                            @if($user->hasPermission('ViewTask'))
                             <li>
                                <a href='ViewTask'>
                                    <i class="icon-double-angle-right"></i>
                                     Task 
                                </a>
                             </li>  
                             @endif  
							 	@if($user->hasPermission('HistoryViewModuleTaskSeq'))
                            <li>
                                <a href='HistoryViewModuleTaskSeq'>
                                    <i class="icon-double-angle-right"></i>
                                    History Module Task Sequence
                                </a>
                            </li> 
                            @endif 


                         </ul>
                    </li>
					@endif-->
				<!--	 @if($user->hasPermission(array('holiday','HolidayType','CreateActualTimeTable','GenarateActualTimeTable','ViewActualTimeTable','ViewWeekTimeTable','ViewYearwiseTimeTableIssuingReport')))
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Actual Time Table-F</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">                                    
                                 @if($user->hasPermission('holiday'))
                                    <li>
                                        <a href='holiday'>
                                           <i class="icon-double-angle-right"></i>
                                            Holidays
                                        </a>
                                    </li>
                                 @endif    

                                  @if($user->hasPermission('HolidayType')) 
                                    <li>
                                         <a href='HolidayType'>
                                           <i class="icon-double-angle-right"></i>
                                            Holiday Types
                                        </a>
                                    </li>
                                     @endif
                                     @if($user->hasPermission('CreateActualTimeTable'))    
                                    <li>
                                            <a href='CreateActualTimeTable'>
                                                <i class="icon-double-angle-right"></i>
                                                Create Batch Calender
                                            </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('GenarateActualTimeTable'))   
                                    <li>
                                            <a href='GenarateActualTimeTable'>
                                                <i class="icon-double-angle-right"></i>
                                                Generate Actual TimeTable
                                            </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('ViewActualTimeTable'))
                                    <li>
                                            <a href='ViewActualTimeTable'>
                                                <i class="icon-double-angle-right"></i>
                                                View Actual TimeTable
                                            </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('ViewWeekTimeTable'))
                                     <li>
                                            <a href='ViewWeekTimeTable'>
                                                <i class="icon-double-angle-right"></i>
                                                View Week TimeTable
                                            </a>
                                    </li> 
                                    @endif
									@if($user->hasPermission('ViewYearwiseTimeTableIssuingReport'))
                                    <li>
                                            <a href='ViewYearwiseTimeTableIssuingReport'>
                                                <i class="icon-double-angle-right"></i>
                                                View Time Table Issued Courses
                                            </a>
                                    </li> 
                                    @endif
                                    
                                </ul>
                            </li>
							@endif-->
						<!--	@if($user->hasPermission(array('CreateMOCenterMonitoringPlan','ViewTOMOCenterMonitoringPlan','ViewDDADMOCenterMonitoringPlan')))
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Plan-Course Monitoring</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('CreateMOCenterMonitoringPlan'))
                                        <li>
                                            <a href='CreateMOCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                Create Course Monitoring Plan(TO/AD/DD)
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewTOMOCenterMonitoringPlan'))
                                        <li>
                                            <a href='ViewTOMOCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                View Course Monitoring Plan(TO/AD/DD)
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewDDADMOCenterMonitoringPlan'))
                                        <li>
                                            <a href='ViewDDADMOCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                View & Approve Course Monitoring Plan(DD/AD)
                                            </a>
                                        </li>  
                                    @endif 
                                </ul>   
                            </li>
							@endif -->
						<!--	@if($user->hasPermission(array('CreateMOCenterNewMonitoringPlan','ViewTOMONewCenterMonitoringPlan','ViewDDADMONewCenterMonitoringPlan')))
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Plan-Center Monitoring</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('CreateMOCenterNewMonitoringPlan'))
                                        <li>
                                            <a href='CreateMOCenterNewMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                Create Center Monitoring Plan(TO/AD/DD)
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewTOMONewCenterMonitoringPlan'))
                                        <li>
                                            <a href='ViewTOMONewCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                View Center Monitoring Plan(TO/AD/DD)
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewDDADMONewCenterMonitoringPlan'))
                                        <li>
                                            <a href='ViewDDADMONewCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                View & Approve Center Monitoring Plan(DD/AD)
                                            </a>
                                        </li>  
                                    @endif 
                                </ul>   
                            </li>
							@endif -->
							<!--@if($user->hasPermission(array('ViewCriteriaCategory','ViewCriteriaEmpType','ViewCriteriaClass','ViewCriterias','ViewCourseMonitoringVersion')))
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Course Criteria</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                   
                                    @if($user->hasPermission('ViewCriteriaEmpType'))
                                        <li>
                                            <a href='ViewCriteriaEmpType'>
                                                <i class="icon-double-angle-right"></i>
                                                Course Criteria Employee Type
                                            </a>
                                        </li>  
                                    @endif
                                    @if($user->hasPermission('ViewCriteriaClass'))
                                        <li>
                                            <a href='ViewCriteriaClass'>
                                                <i class="icon-double-angle-right"></i>
                                                Course Criteria Classes
                                            </a>
                                        </li>  
                                    @endif
									 @if($user->hasPermission('ViewCriteriaCategory'))
                                        <li>
                                            <a href='ViewCriteriaCategory'>
                                                <i class="icon-double-angle-right"></i>
                                                Course Criteria category
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewCriterias'))
                                        <li>
                                            <a href='ViewCriterias'>
                                                <i class="icon-double-angle-right"></i>
                                                 Sub Course Criterias
                                            </a>
                                        </li>  
                                    @endif
									 @if($user->hasPermission('ViewCourseMonitoringVersion'))
                                        <li>
                                            <a href='ViewCourseMonitoringVersion'>
                                                <i class="icon-double-angle-right"></i>
                                                 View Course Monitoring Versions
                                            </a>
                                        </li>  
                                    @endif
                                   
                                </ul>   
                            </li>
							@endif-->
							<!-- Center Criteris -->
							<!--@if($user->hasPermission(array('ViewCenterCriteriaClass','ViewCenterCriteriaEmpType','ViewCenterCriteriaCategory','ViewCenterCriterias')))
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Center Criteria</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    
                                    @if($user->hasPermission('ViewCenterCriteriaEmpType'))
                                        <li>
                                            <a href='ViewCenterCriteriaEmpType'>
                                                <i class="icon-double-angle-right"></i>
                                               Center Criteria Employee Type
                                            </a>
                                        </li>  
                                    @endif
                                    @if($user->hasPermission('ViewCenterCriteriaClass'))
                                        <li>
                                            <a href='ViewCenterCriteriaClass'>
                                                <i class="icon-double-angle-right"></i>
                                                Center Criteria Classes
                                            </a>
                                        </li>  
                                    @endif
									@if($user->hasPermission('ViewCenterCriteriaCategory'))
                                        <li>
                                            <a href='ViewCenterCriteriaCategory'>
                                                <i class="icon-double-angle-right"></i>
                                                Center Criteria category
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewCenterCriterias'))
                                        <li>
                                            <a href='ViewCenterCriterias'>
                                                <i class="icon-double-angle-right"></i>
                                                 Center Sub Criterias
                                            </a>
                                        </li>  
                                    @endif
                                   
                                </ul>   
                            </li>
							@endif-->
							<!-- Center Criteris -->
						<!--	@if($user->hasPermission(array('DoMonitor','DoNewCenterMonitor')))
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Monitoring</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('DoMonitor'))
                                        <li>
                                            <a href='DoMonitor'>
                                                <i class="icon-double-angle-right"></i>
                                                Course Monitor
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('DoNewCenterMonitor'))
                                        <li>
                                            <a href='DoNewCenterMonitor'>
                                                <i class="icon-double-angle-right"></i>
                                                Center Monitor
                                            </a>
                                        </li>  
                                    @endif 
                                    
                                </ul>   
                            </li>
							@endif-->
							<!--@if($user->hasPermission(array('ViewHOCenterMonitoringGrade','ViewHOCenterMonitoringGradewiseReport','ViewHOCenterMonitoringQuestionAnswerType','ViewHOCenterMonitoringQuestion','CreateHOCenterMonitoringForms','ViewHOCenterMonitoringQuestionAnswers','ViewHOCenterMonitoringForms')))
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Centre Grading</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                   
									@if($user->hasPermission('ViewHOCenterMonitoringGrade'))
                                        <li>
                                            <a href='ViewHOCenterMonitoringGrade'>
                                                <i class="icon-double-angle-right"></i>
                                                Center Grades
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewHOCenterMonitoringQuestionAnswerType'))
                                        <li>
                                            <a href='ViewHOCenterMonitoringQuestionAnswerType'>
                                                <i class="icon-double-angle-right"></i>
                                                HO Centre Monitoring Answer Types
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewHOCenterMonitoringQuestion'))
                                        <li>
                                            <a href='ViewHOCenterMonitoringQuestion'>
                                                <i class="icon-double-angle-right"></i>
                                                HO Centre Monitoring Question
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewHOCenterMonitoringQuestionAnswers'))
                                        <li>
                                            <a href='ViewHOCenterMonitoringQuestionAnswers'>
                                                <i class="icon-double-angle-right"></i>
                                                HO Centre Monitoring Question Answers
                                            </a>
                                        </li>  
										
									@endif 
									@if($user->hasPermission('ViewHOCenterMonitoringForms'))
                                        <li>
                                            <a href='ViewHOCenterMonitoringForms'>
                                                <i class="icon-double-angle-right"></i>
                                                View HO Centre Monitoring Form
												</a>
                                        </li>  
                                    @endif
									@if($user->hasPermission('CreateHOCenterMonitoringForms'))
                                        <li>
                                            <a href='CreateHOCenterMonitoringForms'>
                                                <i class="icon-double-angle-right"></i>
                                                Create HO Centre Monitoring Form
												</a>
                                        </li>  
                                    @endif
									<li>
										<a href="#" class="dropdown-toggle">
											<i class="icon-desktop"></i>
											<span class="menu-text">Centre Grading Reports</span>
											<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											@if($user->hasPermission('ViewHOCenterMonitoringGradewiseReport'))
											<li>
												<a href='ViewHOCenterMonitoringGradewiseReport'>
													<i class="icon-double-angle-right"></i>
													District Wise Centre Grading Count Report
													</a>
											</li>  
											@endif
											@if($user->hasPermission('ViewHOCenterMonitoringGradewiseFullDetailsReport'))
											<li>
												<a href='ViewHOCenterMonitoringGradewiseFullDetailsReport'>
													<i class="icon-double-angle-right"></i>
													District Wise Centre Grading Detail Report
													</a>
											</li>  
											@endif
											
										</ul>
									</li>
                                    
                                </ul>   
                            </li>
							@endif-->
							<!--@if($user->hasPermission(array('ViewInstructorQuestionType','ViewInstructorCriteriaCategory','ViewInstructorCriteriaCategoryQuestion','ViewInstructorCriteriaCategoryAnswers','CreateInstructorCriteriaForms','ViewInstructorCriteriaForms','ViewInstructorCriteriaFormsReportI')))
								   <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Instructor Grading</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                   
									@if($user->hasPermission('ViewInstructorQuestionType'))
                                        <li>
                                            <a href='ViewInstructorQuestionType'>
                                                <i class="icon-double-angle-right"></i>
                                               Instructor Criteria Types
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewInstructorCriteriaCategory'))
                                        <li>
                                            <a href='ViewInstructorCriteriaCategory'>
                                                <i class="icon-double-angle-right"></i>
                                               Instructor Criteria Category
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewInstructorCriteriaCategoryQuestion'))
                                        <li>
                                            <a href='ViewInstructorCriteriaCategoryQuestion'>
                                                <i class="icon-double-angle-right"></i>
                                               Instructor Criteria Category Questions
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewInstructorCriteriaCategoryAnswers'))
                                        <li>
                                            <a href='ViewInstructorCriteriaCategoryAnswers'>
                                                <i class="icon-double-angle-right"></i>
                                               Instructor Criteria Category Question Answers
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('CreateInstructorCriteriaForms'))
                                        <li>
                                            <a href='CreateInstructorCriteriaForms'>
                                                <i class="icon-double-angle-right"></i>
                                               Create Instructor Criteria Form
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewInstructorCriteriaForms'))
                                        <li>
                                            <a href='ViewInstructorCriteriaForms'>
                                                <i class="icon-double-angle-right"></i>
                                               View Instructor Criteria Forms
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewInstructorCriteriaFormsReportI'))
                                        <li>
                                            <a href='ViewInstructorCriteriaFormsReportI'>
                                                <i class="icon-double-angle-right"></i>
                                               View Instructor Ranking Report With Grade
                                            </a>
                                        </li>  
                                    @endif
									@if($user->hasPermission('ViewHOInstructorGradingFullDetailsReport','ViewInstructorGradingInstructorCountReport'))
									<li>
										<a href="#" class="dropdown-toggle">
											<i class="icon-desktop"></i>
											<span class="menu-text">Instructor Grading Reports</span>
											<b class="arrow icon-angle-down"></b>
										</a>
										<ul class="submenu">
											
											@if($user->hasPermission('ViewHOInstructorGradingFullDetailsReport'))
											<li>
												<a href='ViewHOInstructorGradingFullDetailsReport'>
													<i class="icon-double-angle-right"></i>
													District Wise Instructor Grading Detail Report
												</a>
											</li>  
											@endif
											@if($user->hasPermission('ViewInstructorGradingInstructorCountReport'))
											<li>
												<a href='ViewInstructorGradingInstructorCountReport'>
													<i class="icon-double-angle-right"></i>
													Year Wise Instructor Count Report
												</a>
											</li>  
											@endif
											
										</ul>
									</li>
									@endif
                                </ul>   
                            </li>
							@endif-->
							<!--@if($user->hasPermission(array('ViewCriteriaTOADEmpType','ViewInstructorCriteriaTOADCategory','ViewTOADQuestionAnswerType','ViewTOADCriteriaCategoryQuestion','ViewTOADCriteriaQuestionAnswers','CreateTOCriteriaForms','ViewTOCriteriaForms','CreateADDDCriteriaForms','ViewADDDCriteriaForms')))
								   <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">TO/AD Grading</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                   
									@if($user->hasPermission('ViewCriteriaTOADEmpType'))
                                        <li>
                                            <a href='ViewCriteriaTOADEmpType'>
                                                <i class="icon-double-angle-right"></i>
                                               TO/AD Grading Employee types
                                            </a>
                                        </li>  
                                    @endif
									@if($user->hasPermission('ViewTOADQuestionAnswerType'))
                                        <li>
                                            <a href='ViewTOADQuestionAnswerType'>
                                                <i class="icon-double-angle-right"></i>
                                               TO/AD Grading Answer types
                                            </a>
                                        </li>  
                                    @endif									
									@if($user->hasPermission('ViewInstructorCriteriaTOADCategory'))
                                        <li>
                                            <a href='ViewInstructorCriteriaTOADCategory'>
                                                <i class="icon-double-angle-right"></i>
                                               TO/AD Grading Category
                                            </a>
                                        </li>  
                                    @endif 
								    @if($user->hasPermission('ViewTOADCriteriaCategoryQuestion'))
                                        <li>
                                            <a href='ViewTOADCriteriaCategoryQuestion'>
                                                <i class="icon-double-angle-right"></i>
                                               TO/AD Grading Questions
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewTOADCriteriaQuestionAnswers'))
                                        <li>
                                            <a href='ViewTOADCriteriaQuestionAnswers'>
                                                <i class="icon-double-angle-right"></i>
                                               TO/AD Grading Question Answers
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('CreateTOCriteriaForms'))
                                        <li>
                                            <a href='CreateTOCriteriaForms'>
                                                <i class="icon-double-angle-right"></i>
                                               Create TO Criteria Form
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewTOCriteriaForms'))
                                        <li>
                                            <a href='ViewTOCriteriaForms'>
                                                <i class="icon-double-angle-right"></i>
                                               View TO Criteria Forms
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('CreateADDDCriteriaForms'))
                                        <li>
                                            <a href='CreateADDDCriteriaForms'>
                                                <i class="icon-double-angle-right"></i>
                                               Create AD/DD Criteria Form
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewADDDCriteriaForms'))
                                        <li>
                                            <a href='ViewADDDCriteriaForms'>
                                                <i class="icon-double-angle-right"></i>
                                               View AD/DD Criteria Forms
                                            </a>
                                        </li>  
                                    @endif 
									
                                </ul>   
                            </li>
							@endif-->
							<!--@if($user->hasPermission(array('ViewComments','ViewMyComments')))
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Comment Handling</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('ViewComments'))
                                        <li>
                                            <a href='ViewComments'>
                                                <i class="icon-double-angle-right"></i>
                                                View Monitoring Comments
												<img  src="assets/new.gif" alt="Jason's Photo" style="width:50%;height:50%" class="img-rounded"/>
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('ViewMyComments'))
                                        <li>
                                            <a href='ViewMyComments'>
                                                <i class="icon-double-angle-right"></i>
                                                View My Monitoring Comments
												<img  src="assets/new.gif" alt="Jason's Photo" style="width:50%;height:50%" class="img-rounded"/>
                                            </a>
                                        </li>  
                                    @endif 
									 
                                    
                                </ul>   
                            </li>
							@endif-->
						<!--	@if($user->hasPermission(array('ViewQuestions','CreateQuestions')))
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Question Bank</span>
                                    <b class="arrow icon-angle-down"></b>

                                 </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('ViewQuestions'))
                                        <li>
                                            <a href='ViewQuestions'>
                                                <i class="icon-double-angle-right"></i>
                                                View Questions
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('CreateQuestions'))
                                        <li>
                                            <a href='CreateQuestions'>
                                                <i class="icon-double-angle-right"></i>
                                                Create Questions
                                            </a>
                                        </li>  
                                    @endif 
									@if($user->hasPermission('DownloadRandomQuestionPaper'))
                                        <li>
                                            <a href='DownloadRandomQuestionPaper'>
                                                <i class="icon-double-angle-right"></i>
                                                Download Question Paper
                                            </a>
                                        </li>  
                                    @endif 
                                    
                                   
                                </ul>   
                            </li>
							@endif-->
						
                            
							
                            
                            
                       
							@if($user->hasPermission(array('viewEmployee','searchEmployee','createEmployee')))
                             <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">  User's Details  </span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('viewEmployee'))
                            <li>
                                <a href='viewEmployee'>
                                   <i class="icon-double-angle-right"></i>
                                    View
                                </a>
                            </li>
                            @endif  
                            <!-- @if($user->hasPermission('searchEmployee'))
                            <li>
                                <a href='searchEmployee'>
                                   <i class="icon-double-angle-right"></i>
                                    Search
                                </a>
                            </li>
                            @endif  --> 
                            @if($user->hasPermission('createEmployee'))
                            <li>
                                <a href='createEmployee'>
                                   <i class="icon-double-angle-right"></i>
                                    Create
                                </a>
                            </li>
                            @endif
                           
                        </ul>
                       </li>
					 @endif
					 @if($user->hasPermission(array('viewUserRoleAssign','viewUsers','viewUserType','ViewUserTypeRole','viewActivity')))
                <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Users</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('viewUserRoleAssign'))
                            <li>
                                
								<a href='viewUserRoleAssign'>
                                   <i class="icon-double-angle-right"></i>
                                    Assign User Permissions
                                </a>
                            </li>  
                            @endif
                            @if($user->hasPermission('viewUsers'))
                            <li>
                                <a href='viewUsers'>
                                   <i class="icon-double-angle-right"></i>
                                    User List
                                </a>
                            </li> 
                            @endif
                            @if($user->hasPermission('viewUserType'))
                            <li>
                               <a href='viewUserType'>
                                   <i class="icon-double-angle-right"></i>
                                    User Types
                                </a>
                            </li> 
                            @endif
                            @if($user->hasPermission('ViewUserTypeRole'))
                            <li>
                                <a href='ViewUserTypeRole'>
                                    <i class="icon-double-angle-right"></i>
                                    User Type Permissions
                                </a>
                            </li> 
                            @endif

                            @if($user->hasPermission('viewActivity'))
                            <li>
                               <a href='viewActivity'>
                                   <i class="icon-double-angle-right"></i>
                                    Functionalities
                                </a>
                            </li> 
                            @endif
                        </ul>
                    </li> 
                   @endif 
				   @if($user->hasPermission(array('ExamAssesorAssigningView')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Exam Related Dates & Others</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ExamAssesorAssigningView'))
                            <li>
                                <a href='ExamAssesorAssigningView'>
                                    <i class="icon-double-angle-right"></i>
                                    Update Exam Dates Details
                                </a>
                            </li>
                            @endif
                             
                          
						
                             
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('AssessorCreate','ViewAndDownloadAssessor','ExamViewNPrintLettersForAssignedAssessors')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Assesor Details</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                           
                             @if($user->hasPermission('AssessorCreate'))
                            <li>
                                    <a href="{{url('AssessorCreate')}}">
                                    <i class="icon-double-angle-right"></i>
                                             Create Assessor
                                    </a>
                            </li> 
                            @endif 
                            @if($user->hasPermission('ViewAndDownloadAssessor'))                    
                            <li>
                                    <a href="{{url('ViewAndDownloadAssessor')}}">
                                    <i class="icon-double-angle-right"></i>
                                             View Assessor
                                    </a>
                            </li>
                            @endif 
							@if($user->hasPermission('ExamViewNPrintLettersForAssignedAssessors'))                    
                            <li>
                                    <a href="{{url('ExamViewNPrintLettersForAssignedAssessors')}}">
                                    <i class="icon-double-angle-right"></i>
                                             View Assessor Assigning Details
                                    </a>
                            </li>
                            @endif 
							
                             
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ExamAddRepeatersToAssessment')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Repeaters Assessments</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ExamAddRepeatersToAssessment'))
                            <li>
                                <a href='ExamAddRepeatersToAssessment'>
                                    <i class="icon-double-angle-right"></i>
                                  Add Repeaters to the Assessments
                                </a>
                            </li>
                            @endif
                             
                          
						
                             
                         </ul>
                    </li>
					@endif
					 @if($user->hasPermission(array('ExamAssignTraineesToPreAssessment')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Pre Assesments</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ExamAssignTraineesToPreAssessment'))
                            <li>
                                <a href='ExamAssignTraineesToPreAssessment'>
                                    <i class="icon-double-angle-right"></i>
                                  Print Pre-Assessment Attendence Sheet & Mark Attendence For Pre-Assessment
                                </a>
                            </li>
                            @endif
                             
                          
						
                             
                         </ul>
                    </li>
					@endif
					 @if($user->hasPermission(array('ExamViewandprintFinaAttendance','ExamPrintNVQAddmissionCard')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Final Assesments</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ExamViewandprintFinaAttendance'))
                            <li>
                                <a href='ExamViewandprintFinaAttendance'>
                                    <i class="icon-double-angle-right"></i>
                                  Print Final-Assessment Attendence Sheet
                                </a>
                            </li>
                            @endif
                       
						   
                           <!-- @if($user->hasPermission('ExamPrintNVQAddmissionCard'))
                            <li>
                                <a href='ExamPrintNVQAddmissionCard'>
                                    <i class="icon-double-angle-right"></i>
                                  Print Final-Assessment Addmission Cards
                                </a>
                            </li>
                            @endif-->
                           </ul>
                    </li>
					@endif
					 @if($user->hasPermission(array('ExamNewEUExamResultEnter','ExamTempViewResult')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">NVQ 1-4 Unit Results</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ExamNewEUExamResultEnter'))
                            <li>
                                <a href='ExamNewEUExamResultEnter'>
                                    <i class="icon-double-angle-right"></i>
                                  Enter Trainee Unit Results
                                </a>
                            </li>
                            @endif
                          @if($user->hasPermission('ExamTempViewResult'))
                            <li>
                                <a href='ExamTempViewResult'>
                                    <i class="icon-double-angle-right"></i>
                                  View Results & Get Qualification Packages
                                </a>
                            </li>
                            @endif
                       
						   
                           <!-- @if($user->hasPermission('ExamPrintNVQAddmissionCard'))
                            <li>
                                <a href='ExamPrintNVQAddmissionCard'>
                                    <i class="icon-double-angle-right"></i>
                                  Print Final-Assessment Addmission Cards
                                </a>
                            </li>
                            @endif-->
                           </ul>
                    </li>
					@endif
					<!--@if($user->hasPermission(array('ViewTrainingPlanUpdateIROJT')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">IR Division</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewTrainingPlanUpdateIROJT'))
                            <li>
                                <a href='ViewTrainingPlanUpdateIROJT'>
                                    <i class="icon-double-angle-right"></i>
                                    Update OJT & JOB Placement Details(Count)
                                </a>
                            </li>
                            @endif    
                         </ul>
                    </li>
					@endif-->
					@if($user->hasPermission(array('ViewIRCompany','CreateIRCompany')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Company Details</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewIRCompany'))
                            <li>
                                <a href='ViewIRCompany'>
                                    <i class="icon-double-angle-right"></i>
                                    View Company Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateIRCompany'))
                            <li>
                                <a href='CreateIRCompany'>
                                    <i class="icon-double-angle-right"></i>
                                    Create Company Details
                                </a>
                            </li>
                            @endif
						
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewIROJTVacancy','CreateIROJTVacancy')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">OJT Vacancy</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                           
							@if($user->hasPermission('ViewIROJTVacancy'))
                            <li>
                                <a href='ViewIROJTVacancy'>
                                    <i class="icon-double-angle-right"></i>
                                    View OJT Vacancy Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateIROJTVacancy'))
                            <li>
                                <a href='CreateIROJTVacancy'>
                                    <i class="icon-double-angle-right"></i>
                                    Create OJT Vacancy Details
                                </a>
                            </li>
                            @endif
						
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewIRJOBPVacancy','CreateIRJOBPVacancy')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">JOB Vacancy </span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                           
							@if($user->hasPermission('ViewIRJOBPVacancy'))
                            <li>
                                <a href='ViewIRJOBPVacancy'>
                                    <i class="icon-double-angle-right"></i>
                                    View JOB placement Vacancy Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateIRJOBPVacancy'))
                            <li>
                                <a href='CreateIRJOBPVacancy'>
                                    <i class="icon-double-angle-right"></i>
                                    Create JOB placement Vacancy Details
                                </a>
                            </li>
                            @endif
						
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewOJTStudents','ViewOJTStudentHistory','CreateIRTrainee','ViewOJTPlacedStudents','ViewOJTStudentsDocumentList')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">OJT Student Details</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                          @if($user->hasPermission('CreateIRTrainee'))
                            <li>
                                <a href='CreateIRTrainee'>
                                    <i class="icon-double-angle-right"></i>
                                   Cretae Trainee
                                </a>
                            </li>
                            @endif
						    @if($user->hasPermission('ViewOJTStudents'))
                            <li>
                                <a href='ViewOJTStudents'>
                                    <i class="icon-double-angle-right"></i>
                                    View & Update OJT Students
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewOJTStudentHistory'))
                            <li>
                                <a href='ViewOJTStudentHistory'>
                                    <i class="icon-double-angle-right"></i>
                                    View OJT Students History
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewOJTPlacedStudents'))
                            <li>
                                <a href='ViewOJTPlacedStudents'>
                                    <i class="icon-double-angle-right"></i>
                                    View OJT Placed Students(Mark Completion)
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewOJTStudentsDocumentList'))
                            <li>
                                <a href='ViewOJTStudentsDoc'>
                                    <i class="icon-double-angle-right"></i>
                                    View OJT Placed Students Documents
                                </a>
                            </li>
                            @endif
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewJOBPStudents','ViewJOBPStudentHistory')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">JOBP Student Details</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                         
						@if($user->hasPermission('ViewJOBPStudents'))
                            <li>
                                <a href='ViewJOBPStudents'>
                                    <i class="icon-double-angle-right"></i>
                                    View JOB Placement Students
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewJOBPStudentHistory'))
                            <li>
                                <a href='ViewJOBPStudentHistory'>
                                    <i class="icon-double-angle-right"></i>
                                    View JOBP Students History
                                </a>
                            </li>
                            @endif
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewAssignPODSDivitions','ViewMyOJTStudents','ViewOJTStudentPOMonitoringHistory')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">PO Details</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                           
							@if($user->hasPermission('ViewAssignPODSDivitions'))
                            <li>
                                <a href='ViewAssignPODSDivitions'>
                                    <i class="icon-double-angle-right"></i>
                                    View & Assign PO DS Divisions
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewMyOJTStudents'))
                            <li>
                                <a href='ViewMyOJTStudents'>
                                    <i class="icon-double-angle-right"></i>
                                    View My OJT Students
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewOJTStudentPOMonitoringHistory'))
                            <li>
                                <a href='ViewOJTStudentPOMonitoringHistory'>
                                    <i class="icon-double-angle-right"></i>
                                    View My Monitoring Dates
                                </a>
                            </li>
                            @endif
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewOJTCourseWiseCountReport')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">OJT Reports</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                           
							@if($user->hasPermission('ViewOJTCourseWiseCountReport'))
                            <li>
                                <a href='ViewOJTCourseWiseCountReport'>
                                    <i class="icon-double-angle-right"></i>
                                    View Course Wise OJT Count Report
                                </a>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                            </li>
                            @endif
							@if($user->hasPermission('ViewOJTDistrictWiseCountReport'))
                            <li>
                                <a href='ViewOJTDistrictWiseCountReport'>
                                    <i class="icon-double-angle-right"></i>
                                    View District Wise OJT Count Report
                                </a>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                            </li>
                            @endif
							
							
                         </ul>
                        </li>
					@endif
					@if($user->hasPermission(array('ViewJOBPCourseWiseCountReport','ViewJOBPDistrictWiseCountReport')))
                       <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">JOBP Reports</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                           
							@if($user->hasPermission('ViewJOBPCourseWiseCountReport'))
                            <li>
                                <a href='ViewJOBPCourseWiseCountReport'>
                                    <i class="icon-double-angle-right"></i>
                                    View Course Wise JOBP Count Report
                                </a>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                            </li>
                            @endif
							@if($user->hasPermission('ViewJOBPDistrictWiseCountReport'))
                            <li>
                                <a href='ViewJOBPDistrictWiseCountReport'>
                                    <i class="icon-double-angle-right"></i>
                                    View District Wise OJT Count Report
                                </a>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                            </li>
                            @endif
							
							
                         </ul>
                    </li>
					@endif
					
				<!--	@if($user->hasPermission(array('ViewAccreditationNew','CreateAccreditationNew')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Accreditation</span>
							
							
							
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewAccreditationNew'))
                            <li>
                                <a href='ViewAccreditationNew'>
                                    <i class="icon-double-angle-right"></i>
                                    View Accreditation Details
                                </a>
                            </li>
                            @endif
							 @if($user->hasPermission('CreateAccreditationNew'))
                            <li>
                                <a href='CreateAccreditationNew'>
                                    <i class="icon-double-angle-right"></i>
                                    Enter Accreditation Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewAccreditationPaymentNew'))
                             <li>
                                <a href='ViewAccreditationPaymentNew'>
                                    <i class="icon-double-angle-right"></i>
                                    View Application & payment details
                                </a>
                            </li>
							 @endif
							 @if($user->hasPermission('CreateAccreditationPaymentNew'))
							<li>
                                <a href='CreateAccreditationPaymentNew'>
                                    <i class="icon-double-angle-right"></i>
                                    Enter Application & payment details
                                </a>
                            </li>
							@endif
                         </ul>
                    </li>
					@endif-->
					<!--@if($user->hasPermission(array('ViewTrainingPlanUpdateTestingEvaOld')))
                   <!-- <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">2016/2017 Data</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewTrainingPlanUpdateTestingEvaOld'))
                            <li>
                                <a href='ViewTrainingPlanUpdateTestingEvaOld'>
                                    <i class="icon-double-angle-right"></i>
                                    Update 2016/2017 Details 
                                </a>
                            </li>
                            @endif
							
                             
                         </ul>
                    </li>
					@endif-->
					@if($user->hasPermission(array('ViewHrServiceCategory','ViewHrEmploymentCode','ViewCardreDetails','ViewOfficeTimes','ViewHrServiceCategorySalaryConversion')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Service Category</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewHrServiceCategory'))
                            <li>
                                <a href='ViewHrServiceCategory'>
                                    <i class="icon-double-angle-right"></i>
                                    Sevice Category Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHrServiceCategorySalaryConversion'))
                            <li>
                                <a href='ViewHrServiceCategorySalaryConversion'>
                                    <i class="icon-double-angle-right"></i>
                                    Sevice Category wise Salary Conversion Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHrEmploymentCode'))
                            <li>
                                <a href='ViewHrEmploymentCode'>
                                    <i class="icon-double-angle-right"></i>
                                    Employment Code Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewCardreDetails'))
                            <li>
                                <a href='ViewCardreDetails'>
                                    <i class="icon-double-angle-right"></i>
                                    Cardre Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewOfficeTimes'))
                            <li>
                                <a href='ViewOfficeTimes'>
                                    <i class="icon-double-angle-right"></i>
                                    Working Hours Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHRUserEPFList'))
                            <li>
                                <a href='ViewHRUserEPFList'>
                                    <i class="icon-double-angle-right"></i>
                                    User EPF List
                                </a>
                            </li>
                            @endif
                             
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployee','CreateHREmployee')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Employee</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewHREmployee'))
                            <li>
                                <a href='ViewHREmployee'>
                                    <i class="icon-double-angle-right"></i>
                                    View Employee Details
                                </a>
                            </li>
                            @endif
							 @if($user->hasPermission('CreateHREmployee'))
                            <li>
                                <a href='CreateHREmployee'>
                                    <i class="icon-double-angle-right"></i>
                                    Create Employee Details
                                </a>
                            </li>
                            @endif
							
							
                             
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHRPromotion','CreateHRPromotion','ViewHRPromotionHistory','ViewHRTransferType','ViewHREmployeeType','ViewHRDepartment')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Promotion</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewHRTransferType'))
                            <li>
                                <a href='ViewHRTransferType'>
                                    <i class="icon-double-angle-right"></i>
                                    View Transfer Types
                                </a>
                            </li>
                            @endif
							 @if($user->hasPermission('ViewHREmployeeType'))
                            <li>
                                <a href='ViewHREmployeeType'>
                                    <i class="icon-double-angle-right"></i>
                                    View Employee Types
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHRDepartment'))
                            <li>
                                <a href='ViewHRDepartment'>
                                    <i class="icon-double-angle-right"></i>
                                    View Departments
                                </a>
                            </li>
                            @endif
                            @if($user->hasPermission('ViewHRPromotion'))
                            <li>
                                <a href='ViewHRPromotion'>
                                    <i class="icon-double-angle-right"></i>
                                    View Promotion Details(Currently Available)
                                </a>
                            </li>
                            @endif
							 @if($user->hasPermission('CreateHRPromotion'))
                            <li>
                                <a href='CreateHRPromotion'>
                                    <i class="icon-double-angle-right"></i>
                                    Create Promotion Details
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHRPromotionHistory'))
                            <li>
                                <a href='ViewHRPromotionHistory'>
                                    <i class="icon-double-angle-right"></i>
                                    View Employee Promotion History
                                </a>
                            </li>
                            @endif
							
							
                             
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHRUniversity','ViewHRQualificationType','ViewHRQualificationCategory','CreateHREmployeeQualification','ViewHRQualification','ViewHREmployeeQualification','ViewHREmployeeQualificationHistory')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Qualification</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('ViewHRUniversity'))
                            <li>
                                <a href='ViewHRUniversity'>
                                    <i class="icon-double-angle-right"></i>
                                    View Universities
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHRQualificationType'))
                            <li>
                                <a href='ViewHRQualificationType'>
                                    <i class="icon-double-angle-right"></i>
                                    View Qualification Type
                                </a>
                            </li>
                            @endif
						  @if($user->hasPermission('ViewHRQualificationCategory'))
                            <li>
                                <a href='ViewHRQualificationCategory'>
                                    <i class="icon-double-angle-right"></i>
                                    View Qualification Category
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHRQualification'))
                            <li>
                                <a href='ViewHRQualification'>
                                    <i class="icon-double-angle-right"></i>
                                    View Qualification
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHREmployeeQualification'))
                            <li>
                                <a href='ViewHREmployeeQualification'>
                                    <i class="icon-double-angle-right"></i>
                                    View Employee Qualification
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateHREmployeeQualification'))
                            <li>
                                <a href='CreateHREmployeeQualification'>
                                    <i class="icon-double-angle-right"></i>
                                    Create Employee Qualification
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHREmployeeQualificationHistory'))
                            <li>
                                <a href='ViewHREmployeeQualificationHistory'>
                                    <i class="icon-double-angle-right"></i>
                                    View Employee Qualification History
                                </a>
                            </li>
                            @endif
						  
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeExperience','CreateHREmployeeExperience','ViewHREmployeeExperienceHistory','ViewHRExperienceCompany','ViewHRExperienceDesignation')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Experience</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewHRExperienceCompany'))
                            <li>
                                <a href='ViewHRExperienceCompany'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Experience Organisation
                                </a>
                            </li>
                            @endif
							 @if($user->hasPermission('ViewHRExperienceDesignation'))
                            <li>
                                <a href='ViewHRExperienceDesignation'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Experience Designation
                                </a>
                            </li>
                            @endif
                            @if($user->hasPermission('ViewHREmployeeExperience'))
                            <li>
                                <a href='ViewHREmployeeExperience'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Work Experience
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateHREmployeeExperience'))
                            <li>
                                <a href='CreateHREmployeeExperience'>
                                    <i class="icon-double-angle-right"></i>
                                   Create Employee Work Experience
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHREmployeeExperienceHistory'))
                            <li>
                                <a href='ViewHREmployeeExperienceHistory'>
                                    <i class="icon-double-angle-right"></i>
                                  View Employee Work Experience History
                                </a>
                            </li>
                            @endif
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeProfile')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Profile</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewHREmployeeProfile'))
                            <li>
                                <a href='ViewHREmployeeProfile'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Profile
                                </a>
                            </li>
                            @endif
							
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeEBQualification','CreateHREmployeeEBQualification','ViewHREmployeeEBQualificationHistory')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) -EB Qualification</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewHREmployeeEBQualification'))
                            <li>
                                <a href='ViewHREmployeeEBQualification'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee EB Qualification
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateHREmployeeEBQualification'))
                            <li>
                                <a href='CreateHREmployeeEBQualification'>
                                    <i class="icon-double-angle-right"></i>
                                   Create Employee EB Qualification
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHREmployeeEBQualificationHistory'))
                            <li>
                                <a href='ViewHREmployeeEBQualificationHistory'>
                                    <i class="icon-double-angle-right"></i>
                                   View Individual Employee EB Qualification
                                </a>
                            </li>
                            @endif
							
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeTraining','CreateHREmployeeTraining','ViewHREmployeeTrainingHistory','ViewHRTrainingInstitute','ViewHRTrainingProgram')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) -Training(L/F)</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						@if($user->hasPermission('ViewHRTrainingInstitute'))
                            <li>
                                <a href='ViewHRTrainingInstitute'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Training Institutes
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHRTrainingProgram'))
                            <li>
                                <a href='ViewHRTrainingProgram'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Training Programmes
                                </a>
                            </li>
                            @endif
						 @if($user->hasPermission('ViewHREmployeeTraining'))
                            <li>
                                <a href='ViewHREmployeeTraining'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Training(Local/Foreign)
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('CreateHREmployeeTraining'))
                            <li>
                                <a href='CreateHREmployeeTraining'>
                                    <i class="icon-double-angle-right"></i>
                                   Create Employee Training(Local/Foreign)
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHREmployeeTrainingHistory'))
                            <li>
                                <a href='ViewHREmployeeTrainingHistory'>
                                    <i class="icon-double-angle-right"></i>
                                   View Individual Employee Training(Local/Foreign)
                                </a>
                            </li>
                            @endif
							
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeLoan','CreateHREmployeeLoan','ViewHREmployeeLoanHistory','ViewHRLoanType')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) -Loan</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						@if($user->hasPermission('ViewHRLoanType'))
                            <li>
                                <a href='ViewHRLoanType'>
                                    <i class="icon-double-angle-right"></i>
                                   View Loan Types
                                </a>
                            </li>
                            @endif
						 @if($user->hasPermission('ViewHREmployeeLoan'))
                            <li>
                                <a href='ViewHREmployeeLoan'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Loan
                                </a>
                            </li>
                            @endif
							
							@if($user->hasPermission('CreateHREmployeeLoan'))
                            <li>
                                <a href='CreateHREmployeeLoan'>
                                    <i class="icon-double-angle-right"></i>
                                   Create Employee Loan
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewHREmployeeLoanHistory'))
                            <li>
                                <a href='ViewHREmployeeLoanHistory'>
                                    <i class="icon-double-angle-right"></i>
                                   View Individual Employee Loan
                                </a>
                            </li>
                            @endif
							
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeIncrements','ViewHREmployeeIncrementsReactive','HREmployeeIncrementsEditMode','ViewIncrementHistory')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Increments</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						@if($user->hasPermission('ViewHREmployeeIncrements'))
                            <li>
                                <a href='ViewHREmployeeIncrements'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Increments(Pending)
                                </a>
                            </li>
                            @endif
						@if($user->hasPermission('ViewHREmployeeIncrementsReactive'))
                            <li>
                                <a href='ViewHREmployeeIncrementsReactive'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Increments(Reactivate)
                                </a>
                            </li>
                            @endif
							
						@if($user->hasPermission('HREmployeeIncrementsEditMode'))
                            <li>
                                <a href='HREmployeeIncrementsEditMode'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Increments(Edit Mode)
                                </a>
                            </li>
                           @endif
						   @if($user->hasPermission('ViewIncrementHistory'))
                            <li>
                                <a href='ViewIncrementHistory'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Increments(History)
                                </a>
                            </li>
                           @endif
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHRPersonalFileDoc','CreateHREmployeePersonalFileDoc','ViewHREmployeePersonalFileDoc','ViewHREmployeePersonalFileDocHistory')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR)- Personal File</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewHRPersonalFileDoc'))
                            <li>
                                <a href='ViewHRPersonalFileDoc'>
                                    <i class="icon-double-angle-right"></i>
                                   View Personal File Document
                                </a>
                            </li>
                        @endif
						@if($user->hasPermission('ViewHREmployeePersonalFileDoc'))
                            <li>
                                <a href='ViewHREmployeePersonalFileDoc'>
                                    <i class="icon-double-angle-right"></i>
                                   View Employee Personal File Document List
                                </a>
                            </li>
                        @endif
						@if($user->hasPermission('CreateHREmployeePersonalFileDoc'))
                            <li>
                                <a href='CreateHREmployeePersonalFileDoc'>
                                    <i class="icon-double-angle-right"></i>
                                   Create Employee Personal File Document List
                                </a>
                            </li>
                        @endif	
						@if($user->hasPermission('ViewHREmployeePersonalFileDocHistory'))
                            <li>
                                <a href='ViewHREmployeePersonalFileDocHistory'>
                                    <i class="icon-double-angle-right"></i>
                                   View Individual Employee Personal File Document List
                                </a>
                            </li>
                        @endif	
							
                         </ul>
                    </li>
					@endif
					
					@if($user->hasPermission(array('ViewHROLAttempt','ViewHROLSubject','ViewHROLMedium','ViewHROLGrades','ViewHREmployeeOLResults','CreateHREmployeeOLResults')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR)- G.C.E Results</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						
						@if($user->hasPermission('ViewHROLMedium'))
                            <li>
                                <a href='ViewHROLMedium'>
                                    <i class="icon-double-angle-right"></i>
                                   View O/L & A/L Medium
                                </a>
                            </li>
                        @endif
						@if($user->hasPermission('ViewHROLGrades'))
                            <li>
                                <a href='ViewHROLGrades'>
                                    <i class="icon-double-angle-right"></i>
                                   View O/L & A/L Grades
                                </a>
                            </li>
                        @endif
						@if($user->hasPermission(array('ViewHROLAttempt','ViewHROLSubject','ViewHREmployeeOLResults','CreateHREmployeeOLResults','ViewHREmployeeOLResultsSheetHistory')))
						 <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text">(HR)- O/L Results</span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								 @if($user->hasPermission('ViewHROLAttempt'))
									<li>
										<a href='ViewHROLAttempt'>
											<i class="icon-double-angle-right"></i>
										   View O/L Attempts
										</a>
									</li>
								@endif
								
								@if($user->hasPermission('ViewHROLSubject'))
									<li>
										<a href='ViewHROLSubject'>
											<i class="icon-double-angle-right"></i>
										   View O/L Subjects
										</a>
									</li>
								@endif
								@if($user->hasPermission('ViewHREmployeeOLResults'))
									<li>
										<a href='ViewHREmployeeOLResults'>
											<i class="icon-double-angle-right"></i>
										   View Employee O/L Results
										</a>
									</li>
								@endif
								@if($user->hasPermission('CreateHREmployeeOLResults'))
									<li>
										<a href='CreateHREmployeeOLResults'>
											<i class="icon-double-angle-right"></i>
										   Create Employee O/L Results
										</a>
									</li>
								@endif
							    @if($user->hasPermission('ViewHREmployeeOLResultsSheetHistory'))
									<li>
										<a href='ViewHREmployeeOLResultsSheetHistory'>
											<i class="icon-double-angle-right"></i>
										   View Employee O/L Results History
										</a>
									</li>
								@endif
							</ul>
						</li>
						@endif
						@if($user->hasPermission(array('ViewHRALAttempt','ViewHRALStream','ViewHRALSubject','ViewHREmployeeALResults','CreateHREmployeeALResults','ViewHREmployeeALResultsSheetHistory')))
						 <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text">(HR)- A/L Results</span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								 @if($user->hasPermission('ViewHRALAttempt'))
									<li>
										<a href='ViewHRALAttempt'>
											<i class="icon-double-angle-right"></i>
										   View A/L Attempts
										</a>
									</li>
								@endif
								@if($user->hasPermission('ViewHRALStream'))
									<li>
										<a href='ViewHRALStream'>
											<i class="icon-double-angle-right"></i>
										   View A/L Stream
										</a>
									</li>
								@endif
								@if($user->hasPermission('ViewHRALSubject'))
									<li>
										<a href='ViewHRALSubject'>
											<i class="icon-double-angle-right"></i>
										   View A/L Subjects
										</a>
									</li>
								@endif
								@if($user->hasPermission('ViewHREmployeeALResults'))
									<li>
										<a href='ViewHREmployeeALResults'>
											<i class="icon-double-angle-right"></i>
										   View Employee A/L Results
										</a>
									</li>
								@endif
								@if($user->hasPermission('CreateHREmployeeALResults'))
									<li>
										<a href='CreateHREmployeeALResults'>
											<i class="icon-double-angle-right"></i>
										   Create Employee A/L Results
										</a>
									</li>
								@endif
							    @if($user->hasPermission('ViewHREmployeeALResultsSheetHistory'))
									<li>
										<a href='ViewHREmployeeALResultsSheetHistory'>
											<i class="icon-double-angle-right"></i>
										   View Employee A/L Results History
										</a>
									</li>
								@endif
							</ul>
						</li>
						@endif
						
						
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewHREmployeeServiceLettersIssued','CreateHREmployeeServiceLetters')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR)- Service Letters</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewHREmployeeServiceLettersIssued'))
                            <li>
                                <a href='ViewHREmployeeServiceLettersIssued'>
                                    <i class="icon-double-angle-right"></i>
                                   View Service Letters Issued
                                </a>
                            </li>
                        @endif
						@if($user->hasPermission('CreateHREmployeeServiceLetters'))
                            <li>
                                <a href='CreateHREmployeeServiceLetters'>
                                    <i class="icon-double-angle-right"></i>
                                   Create Service Letters
                                </a>
                            </li>
                        @endif
							
                         </ul>
                    </li>
					@endif
					@if($user->hasPermission(array('ViewDistrictStaffReport','ViewDistrictAgeServiceStaffReport','ViewDistrictRetirementStaffReport','ViewDistrictInstructorNotTrainingStaffReport')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - Reports</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						 @if($user->hasPermission('ViewDistrictStaffReport'))
                            <li>
                                <a href='ViewDistrictStaffReport'>
                                    <i class="icon-double-angle-right"></i>
                                   View District Wise Staff Report
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewDistrictAgeServiceStaffReport'))
                            <li>
                                <a href='ViewDistrictAgeServiceStaffReport'>
                                    <i class="icon-double-angle-right"></i>
                                   View Service Category Wise Staff Report
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewDistrictRetirementStaffReport'))
                            <li>
                                <a href='ViewDistrictRetirementStaffReport'>
                                    <i class="icon-double-angle-right"></i>
                                   View District Wise Retirement Staff Report
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewDistrictInstructorNotTrainingStaffReport'))
                            <li>
                                <a href='ViewDistrictInstructorNotTrainingStaffReport'>
                                    <i class="icon-double-angle-right"></i>
                                   View District Wise Instructors(Local/Foreign Training) Report
                                </a>
                            </li>
                            @endif
							
                         </ul>
                    </li>
					@endif
				<!--	@if($user->hasPermission(array('ViewTMTaskList','ViewTMProcessSchedule','ViewTrainingPlanUpdateDisNVTIDOTOTM','ViewTrainingMaterialProcessWiseSummeryReport')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">Training Material</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						   
							@if($user->hasPermission('ViewTMTaskList'))
                            <li>
                                <a href='ViewTMTaskList'>
                                    <i class="icon-double-angle-right"></i>
                                   View TM Process List
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewTMProcessSchedule'))
                            <li>
                                <a href='ViewTMProcessSchedule'>
                                    <i class="icon-double-angle-right"></i>
                                   View TM Process Schedule
                                </a>
                            </li>
                            @endif
							
							@if($user->hasPermission('ViewTrainingPlanUpdateDisNVTIDOTOTM'))
                            <li>
                                <a href='ViewTrainingPlanUpdateDisNVTIDOTOTM'>
                                    <i class="icon-double-angle-right"></i>
                                    View & Update Training Material(Dsitrict/NVTI)
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewTrainingMaterialProcessWiseSummeryReport'))
                            <li>
                                <a href="#" class="dropdown-toggle">
									<i class="icon-desktop"></i>
									<span class="menu-text">TM - Reports</span>
									<b class="arrow icon-angle-down"></b>
									</a>
								<ul class="submenu">
							@if($user->hasPermission('ViewTrainingMaterialProcessWiseSummeryReport'))
                            <li>
                                <a href='ViewTrainingMaterialProcessWiseSummeryReport'>
                                    <i class="icon-double-angle-right"></i>
                                  I) Process Wise Report
                                </a>
                            </li>
                            @endif
								</ul>
                            </li>
                            @endif
								</ul>
                            </li>
                    @endif-->
					@if($user->hasPermission(array('CreateHREmployeeKPICriterias','ViewHREmployeeKPICriterias','ViewKPISchedule','ViewKPIForms','ViewKPISuperviseForms')))
                        <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">(HR) - KPI</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
						    <!--@if($user->hasPermission('CreateHREmployeeKPICriterias'))
                            <li>
                                <a href='CreateHREmployeeKPICriterias'>
                                    <i class="icon-double-angle-right"></i>
                                   Create KPI Criterias
                                </a>
                            </li>
                            @endif-->
							@if($user->hasPermission('ViewHREmployeeKPICriterias'))
                            <li>
                                <a href='ViewHREmployeeKPICriterias'>
                                    <i class="icon-double-angle-right"></i>
                                   View KPI Criterias
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewKPISchedule'))
                            <li>
                                <a href='ViewKPISchedule'>
                                    <i class="icon-double-angle-right"></i>
                                   Schedule the KPI
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewKPIForms'))
                            <li>
                                <a href='ViewKPIForms'>
                                    <i class="icon-double-angle-right"></i>
                                   Enter KPI Forms
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewKPISuperviseForms'))
                            <li>
                                <a href='ViewKPISuperviseForms'>
                                    <i class="icon-double-angle-right"></i>
                                   Supervise KPI Forms
                                </a>
                            </li>
                            @endif
							@if($user->hasPermission('ViewEmpLPISummeryReport'))
								<li>
									<a href="#" class="dropdown-toggle">
										<i class="icon-desktop"></i>
										<span class="menu-text">KPI - Reports</span>
										<b class="arrow icon-angle-down"></b>
										</a>
									<ul class="submenu">
								@if($user->hasPermission('ViewEmpLPISummeryReport'))
								<li>
									<a href='ViewEmpLPISummeryReport'>
										<i class="icon-double-angle-right"></i>
									  I) Emplyees KPI Summery Report
									</a>
								</li>
								@endif
									</ul>
								</li>
                            @endif
							
						
					
					
							
							
                   	
                         </ul>
                    </li>
					@endif     
					
					
                       

                   
                         
                </ul><!--/.nav-list-->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="icon-double-angle-left"></i>
                </div>
            </div>
            <div class="main-content">    
                <div class="breadcrumbs" id="breadcrumbs">
				
                </div>
                @if(URL::full() == Url('authuser'))
                <div style="margin-right: auto;margin-top: 0px; margin-bottom: 0px;" class="row-fluid">
                  <!--  <div class="span7 infobox-container">
                        <div class="infobox infobox-grey  ">
                            <div class="infobox-icon">
                                <i class="icon-tasks"></i>
                            </div>
                          <!--  <div class="infobox-data">
                                <?php /* $cyp = CourseYearPlan::getNOConfirm(); */ ?>
                                <a href="ConfirmCourseYearPlan">
                                    <span class="infobox-data-number"></span>
                                    <div class="infobox-content">Course Year Plan</div>
                                </a>
                            </div>-->
                       <!-- </div>
                       
                        
                    
                    </div> -->
                </div>
                @endif 
