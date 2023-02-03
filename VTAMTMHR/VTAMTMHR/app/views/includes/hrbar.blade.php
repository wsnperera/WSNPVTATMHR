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
                    <a href="{{Url('dashboard')}}" class="brand">
                        <small>
                            <i class="icon-leaf"></i>
                            Welcome to the HRM System :-
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

               


					
							
							
							
						
                             
                                       
                                       
							
                            
                            
                       
							@if($user->hasPermission(array('viewEmployee','searchEmployee','createEmployee')))
                             <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-desktop"></i>
                            <span class="menu-text">  Employee  </span>
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
                             @if($user->hasPermission('searchEmployee'))
                            <li>
                                <a href='searchEmployee'>
                                   <i class="icon-double-angle-right"></i>
                                    Search
                                </a>
                            </li>
                            @endif   
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
