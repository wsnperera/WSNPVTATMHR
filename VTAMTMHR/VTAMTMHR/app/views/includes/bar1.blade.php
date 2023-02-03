<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>VTA Monitoring System</title>
	<link rel="shortcut icon" href="assets/vtaicon.ico" type="image/x-icon" />

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
                    <a href="#" class="brand">
                        <small>
                            <i class="icon-leaf"></i>
                            Welcome to the Monitoring System :-
                            {{$user->userName}}
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
                        <li class="light-orange">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
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

                  
                   <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text"> Course </span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('courses'))
                            <li>
                                <a href={{URL::action('CourseController@viewCourses')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Course Details
                                </a>
                            </li>
                            @endif
                             @if($user->hasPermission('viewCourseYearPlan'))
                            <li>
                                <a href='viewCourseYearPlan'>
                                    <i class="icon-double-angle-right"></i>
                                    Monitoring Course Year Plan
                                </a>
                            </li>
                            @endif
                            


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


                         </ul>
                    </li>

                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">  Actual Time Table</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">                                    
                                 @if($user->hasPermission('holiday'))
                                    <li>
                                        <a href={{URL::action('HolidayController@viewHoliday')}}>
                                           <i class="icon-double-angle-right"></i>
                                            Holidays
                                        </a>
                                    </li>
                                 @endif    

                                  @if($user->hasPermission('HolidayType')) 
                                    <li>
                                        <a href={{URL::action('HolidayTypeController@viewHolidayTypes')}}>
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
                                    
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Plan</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('CreateMOCenterMonitoringPlan'))
                                        <li>
                                            <a href='CreateMOCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                Create Center Monitoring Plan(TO)
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewTOMOCenterMonitoringPlan'))
                                        <li>
                                            <a href='ViewTOMOCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                View Center Monitoring Plan(TO)
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewDDADMOCenterMonitoringPlan'))
                                        <li>
                                            <a href='ViewDDADMOCenterMonitoringPlan'>
                                                <i class="icon-double-angle-right"></i>
                                                View Center Monitoring Plan(DD/AD)
                                            </a>
                                        </li>  
                                    @endif 
                                </ul>   
                            </li>
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Criteria</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('ViewCriteriaCategory'))
                                        <li>
                                            <a href='ViewCriteriaCategory'>
                                                <i class="icon-double-angle-right"></i>
                                                Criteria category
                                            </a>
                                        </li>  
                                    @endif 
                                    @if($user->hasPermission('ViewCriteriaEmpType'))
                                        <li>
                                            <a href='ViewCriteriaEmpType'>
                                                <i class="icon-double-angle-right"></i>
                                                Criteria Employee Type
                                            </a>
                                        </li>  
                                    @endif
                                    @if($user->hasPermission('ViewCriteriaClass'))
                                        <li>
                                            <a href='ViewCriteriaClass'>
                                                <i class="icon-double-angle-right"></i>
                                                Criteria Classes
                                            </a>
                                        </li>  
                                    @endif
                                    @if($user->hasPermission('ViewCriterias'))
                                        <li>
                                            <a href='ViewCriterias'>
                                                <i class="icon-double-angle-right"></i>
                                                 Sub Criterias
                                            </a>
                                        </li>  
                                    @endif
                                   
                                </ul>   
                            </li>
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
                                                Monitor
                                            </a>
                                        </li>  
                                    @endif 
                                    
                                </ul>   
                            </li>
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
                                    
                                   
                                </ul>   
                            </li>
                             <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">Reports</span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                    @if($user->hasPermission('ViewModuleTaskSeq'))
                                    <li>
                                        <a href='ViewModuleTaskSeq'>
                                            <i class="icon-double-angle-right"></i>
                                            Module Task Sequence Report
                                        </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('ViewActualTimeTable'))
                                    <li>
                                            <a href='ViewActualTimeTable'>
                                                <i class="icon-double-angle-right"></i>
                                                Actual Time Table
                                            </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('ViewWeekTimeTable'))
                                     <li>
                                            <a href='ViewWeekTimeTable'>
                                                <i class="icon-double-angle-right"></i>
                                                 Week Time Table
                                            </a>
                                    </li> 
                                    @endif
                                     @if($user->hasPermission('ViewCoursePlanReport'))
                                     <li>
                                            <a href='ViewCoursePlanReport'>
                                                <i class="icon-double-angle-right"></i>
                                                 Course Plan Report(Days Wise)
                                            </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('ViewCoursePlanReportW'))
                                     <li>
                                            <a href='ViewCoursePlanReportW'>
                                                <i class="icon-double-angle-right"></i>
                                                 Course Plan Report(Weeks Wise)
                                            </a>
                                    </li> 
                                    @endif
                                    @if($user->hasPermission('ViewDistrictWiseMonitoringProgress'))
                                     <li>
                                            <a href='ViewDistrictWiseMonitoringProgress'>
                                                <i class="icon-double-angle-right"></i>
                                                 District Wise Monitoring Progress
                                            </a>
                                    </li> 
                                    @endif
                                    
                                   
                                </ul>   
                            </li>
                            
                            
                        <!-- <li>
                                <a href="#" class="dropdown-toggle">
                                    <i class="icon-desktop"></i>
                                    <span class="menu-text">  Trades  </span>
                                    <b class="arrow icon-angle-down"></b>
                                </a>
                                <ul class="submenu">
                                   
                                    <li>
                                        <a href={{URL::action('Trade1Controller@viewTrades')}}>
                                           <i class="icon-double-angle-right"></i>
                                            Trades
                                        </a>
                                    </li>
                                  

                                    @if($user->hasPermission('ViewTradeCapacity'))
                                    <li>
                                        <a href={{URL::action('TradecapacityController@viewTradecapacity')}}>
                                           <i class="icon-double-angle-right"></i>
                                            Trade Capacity
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>-->
                             <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">  Employee  </span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('viewEmployee'))
                            <li>
                                <a href={{URL::action('EmployeeController@viewEmployees')}}>
                                   <i class="icon-double-angle-right"></i>
                                    View
                                </a>
                            </li>
                            @endif  
                             @if($user->hasPermission('searchEmployee'))
                            <li>
                                <a href={{URL::action('EmployeeController@actionSearch')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Search
                                </a>
                            </li>
                            @endif   
                            @if($user->hasPermission('createEmployee'))
                            <li>
                                <a href={{URL::action('EmployeeController@actionCreate')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Create
                                </a>
                            </li>
                            @endif
                           
                        </ul>
                       </li>
					
                <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">User</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>
                        <ul class="submenu">
                            @if($user->hasPermission('viewUserRoleAssign'))
                            <li>
                                <a href={{URL::action('UserRoleController@viewUserRoleAssign')}}>
                                   <i class="icon-double-angle-right"></i>
                                    User Role Assign
                                </a>
                            </li>  
                            @endif
                            @if($user->hasPermission('viewUsers'))
                            <li>
                                <a href={{URL::action('UserController@viewUsers')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Users
                                </a>
                            </li> 
                            @endif
                            @if($user->hasPermission('viewUserType'))
                            <li>
                                <a href={{URL::action('UserTypeController@viewUserType')}}>
                                   <i class="icon-double-angle-right"></i>
                                    User Type 
                                </a>
                            </li> 
                            @endif
                            @if($user->hasPermission('ViewUserTypeRole'))
                            <li>
                                <a href='ViewUserTypeRole'>
                                    <i class="icon-double-angle-right"></i>
                                    User Type Role
                                </a>
                            </li> 
                            @endif

                            @if($user->hasPermission('viewActivity'))
                            <li>
                                <a href={{URL::action('activityController@viewActivity')}}>
                                   <i class="icon-double-angle-right"></i>
                                    Activity
                                </a>
                            </li> 
                            @endif
                        </ul>
                    </li> 
                    
						
                       

                   
                         
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
                                <?php $cyp = CourseYearPlan::getNOConfirm(); ?>
                                <a href="ConfirmCourseYearPlan">
                                    <span class="infobox-data-number">{{$cyp}}</span>
                                    <div class="infobox-content">Course Year Plan</div>
                                </a>
                            </div>-->
                        </div>
                       
                        
                    
                    </div> -->
                </div>
                @endif 
