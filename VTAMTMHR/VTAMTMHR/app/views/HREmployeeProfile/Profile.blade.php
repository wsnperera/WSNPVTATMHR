@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
<a href="{{url('ViewHREmployeeProfile')}}"> << Back to HR - Employee Profile </a> 
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        Employee Profile
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Profile
                        </small>            
                    </h1>
                </div>

            </div>
        </div><!--/.span-->

        <div class="span11" align="right">
            <form action="" method="POST">
                <input type="hidden" name="studentData" id="studentData" value="{{$EmpId}}">
                <button class="btn btn-primary" type="button" name="btn_studentData" id="btn_studentData" >
                    <i class="icon-download bigger-125"></i>
                        Print Profile
                </button>
            </form>
        </div>

    </div><!--/.row-fluid-->
	@foreach($trainee as $trainee)
    <div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Personal Details</font></b></div>
    </div>

    <div class="span3">   
        <center>
            <span class="profile-picture">
               
                <img id="avatar" class="editable" height="800" width="200" alt="Alex's Avatar" src="{{Url($trainee->Photograph)}}" />
              
            </span>

        </br></br>

        <div class="width-60 label label-info label-large arrowed-in arrowed-in-right">
            <div class="inline position-relative">
                <center><span class="white middle bigger-120">{{$trainee->Initials}} {{$trainee->LastName}}</span></center>
            </div>
        </div>
    </div>

    <div class="span10"> 

        <table style="width:100%">
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Name With Initials
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$trainee->Initials}} {{$trainee->LastName}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Names Represented by Initials
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$trainee->Name}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            NIC Number  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				@foreach($AllNIC as $NIC)
				@if($NIC->Active == 1)
				<font face="verdana" size="2" color="red">{{$NIC->NIC}}</font>&nbsp;&nbsp;&nbsp;
			 
				@else
					<font face="verdana" size="2" color="black">{{$NIC->NIC}}</font>&nbsp;&nbsp;&nbsp;
				@endif
				@endforeach
				</b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            EPF Number  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				@foreach($AllEPF as $EP)
				@if($EP->Active == 1)
				<font face="verdana" size="2" color="red">{{$EP->EPFNo}}</font>&nbsp;&nbsp;&nbsp;
			 
				@else
					<font face="verdana" size="2" color="black">{{$EP->EPFNo}}</font>&nbsp;&nbsp;&nbsp;
				@endif
				@endforeach
				</b></td>
            </tr>
            
            
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Date Of Birth
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->DOB)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->DOB;}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        Gender 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->Sex)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->Sex;}}</font></b></td>
            </tr>
			 <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        Civil Status 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->CivilStatus)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->CivilStatus;}}</font></b></td>
            </tr>
           
            
          
        </table>
    </div>

    <div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Residential Details</font></b></div>        
    </div>

    <div class="span10"> 
        <table style="width:100%">
		<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Permanent Postal Address
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->PAddress)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->PAddress;}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Contact No's
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>Residence:&nbsp;&nbsp;&nbsp;{{(empty($trainee->Contact)) ? '<font face="verdana" size="2" color="red">No Data Found&nbsp;&nbsp;&nbsp;' : '<font face="verdana" size="2" color="black">'.$trainee->Contact;}}&nbsp;&nbsp;&nbsp;</font></b>
				<b>Official:&nbsp;&nbsp;&nbsp;{{(empty($trainee->OMobile)) ? '<font face="verdana" size="2" color="red">No Data Found&nbsp;&nbsp;&nbsp;' : '<font face="verdana" size="2" color="black">'.$trainee->OMobile;}}&nbsp;&nbsp;&nbsp;</font></b>
				<b>Mobile:&nbsp;&nbsp;&nbsp;{{(empty($trainee->Mobile)) ? '<font face="verdana" size="2" color="red">No Data Found&nbsp;&nbsp;&nbsp;' : '<font face="verdana" size="2" color="black">'.$trainee->Mobile;}}&nbsp;&nbsp;&nbsp;</font></b></td>
            </tr>
             <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        Province 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->ProvinceName)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->ProvinceName;}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            District 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->DistrictName)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->DistrictName;}}</font></b></td>
            </tr>
			
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            DS Division 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($trainee->ElectorateName)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$trainee->ElectorateName;}}</font></b></td>
            </tr>
       
        </table>
    </div>
	@endforeach
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">GCE(O/L)(Two Sitting Only)</font></b></div>        
    </div>
	@if(!empty($OLResult))
		<div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach ($OLResult as $eq)
		 <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$eq->Year}}</td>
                        <td>{{$eq->IndexNo}}</td>
                        <td>{{$eq->Attempt}}</td>
                        <td>{{$eq->Subject}}</td>
						<td>{{$eq->Grade}}</td>
                        
		</tr>
		 @endforeach
          </tbody>   
        </table>
		
	</div>
		
	@else
	 <div class="span10"> 
       <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>	
	@endif

   
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">GCE(A/L)(Single Sitting Only)</font></b></div>        
    </div>

   @if(!empty($ALResult))
		<div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach ($ALResult as $eq)
		 <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$eq->Year}}</td>
                        <td>{{$eq->IndexNo}}</td>
                        <td>{{$eq->Attempt}}</td>
                        <td>{{$eq->Subject}}</td>
						<td>{{$eq->Grade}}</td>
                        
		</tr>
		 @endforeach
		 @if($GKMarks != '' || $GKMarks != 0)
			<tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$GKMarks->Year}}</td>
                        <td>{{$GKMarks->IndexNo}}</td>
                        <td>I</td>
                        <td>General Knowledge</td>
						<td>{{$GKMarks->GeneralKowledgeMark}}</td>
                        
		</tr>
		 @endif
          </tbody>   
        </table>
		
	</div>
		
	@else
	 <div class="span10"> 
       <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>	
	@endif

    <div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Education Qualifications</font></b></div>        
    </div>
@if(!empty($EQualification))
    <div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach ($EQualification as $eq)
		 <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$eq->Type}}</td>
                        <td>{{$eq->QCategory}}</td>
                        <td>{{$eq->Qualification}}</td>
                        <td>{{$eq->UniversityName}}</td>
						<td>{{$eq->CourseType}}</td>
                        <td>{{$eq->MainSubjects}}</td>
                        <td>{{$eq->Result}}</td>
						<td>{{$eq->Year}}</td>
                        <td>
						<?php
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                         ?>
						 {{$monthName}}
						 </td>
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
	@else
		 <div class="span10"> 
         <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
		@endif
		
		
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Professional Qualifications</font></b></div>        
    </div>
@if(!empty($PQualification))
    <div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach ($PQualification as $eq)
		 <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$eq->Type}}</td>
                        <td>{{$eq->QCategory}}</td>
                        <td>{{$eq->Qualification}}</td>
                        <td>{{$eq->UniversityName}}</td>
						<td>{{$eq->CourseType}}</td>
                        <td>{{$eq->MainSubjects}}</td>
                        <td>{{$eq->Result}}</td>
						<td>{{$eq->Year}}</td>
                        <td>
						<?php
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                         ?>
						 {{$monthName}}
						 </td>
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
	@else
		 <div class="span10"> 
         <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center>
		<br/>
    </div>
		@endif
<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Vocational Qualifications</font></b></div>        
    </div>
@if(!empty($VQualification))
    <div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach($VQualification as $eq)
		 <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>{{$eq->Type}}</td>
                        <td>{{$eq->QCategory}}</td>
                        <td>{{$eq->Qualification}}</td>
                        <td>{{$eq->UniversityName}}</td>
						<td>{{$eq->CourseType}}</td>
                        <td>{{$eq->MainSubjects}}</td>
                        <td>{{$eq->Result}}</td>
						<td>{{$eq->Year}}</td>
                        <td>
						<?php
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                         ?>
						 {{$monthName}}
						 </td>
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
@else
		 <div class="span10"> 
	 <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
		@endif
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Foreign/Local Training(With Pay Leave)</font></b></div>        
    </div>
	@if(!empty($PayTraining))
    <div class="span10"> 
	<font style="width:100%" face="verdana" size="2" color="black">
        <table  id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach($PayTraining as $eq)
		 <tr>
                   <td> <?php echo $i++ ?></td>
                     
                       
						<td>{{$eq->TrainingType}}</td>
						
						<td>{{$eq->CountryName}}</td>
                        <td>{{$eq->NameOfTheProgram}}</td>
                        <td>{{$eq->InstituteName}}</td>
                        <td>{{$eq->DurationFrom}}</td>
                       <td>{{$eq->DurationTo}}</td>
					 
                        <td>{{$eq->AmountPaidByVTA}}</td>
						 <td>{{$eq->CompulsoryPeriodOfService}}</td>
						  <td>{{$eq->CompulsoryPeriodOfServiceMonth}}</td>
						  <td>{{$eq->AmountOfSurcharge}}</td>
						   
							  <td>
							  @if($eq->CertificateForwarded == 1)
								  Yes 
							  @else 
								  No 
							  @endif</td>
							  
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
	@else
    <div class="span10"> 
         <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
	@endif
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Foreign/Local Training(No Pay Leave)</font></b></div>        
    </div>
	@if(!empty($NoPayTraining))
    <div class="span10"> 
	<font style="width:100%" face="verdana" size="2" color="black">
        <table  id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach($NoPayTraining as $eq)
		 <tr>
                   <td> <?php echo $i++ ?></td>
                     
                       
						<td>{{$eq->TrainingType}}</td>
						
						<td>{{$eq->CountryName}}</td>
                        <td>{{$eq->NameOfTheProgram}}</td>
                        <td>{{$eq->InstituteName}}</td>
                        <td>{{$eq->DurationFrom}}</td>
                       <td>{{$eq->DurationTo}}</td>
					 
                        <td>{{$eq->AmountPaidByVTA}}</td>
						 <td>{{$eq->CompulsoryPeriodOfService}}</td>
						  <td>{{$eq->CompulsoryPeriodOfServiceMonth}}</td>
						  <td>{{$eq->AmountOfSurcharge}}</td>
						   
							  <td>
							  @if($eq->CertificateForwarded == 1)
								  Yes 
							  @else 
								  No 
							  @endif</td>
							  
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
	@else
    <div class="span10"> 
         <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
	@endif
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Experience (Before Join to the VTA)</font></b></div>        
    </div>
@if(!empty($Experience))
    <div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach($Experience as $eq)
		 <tr>
                        <td> <?php echo $i++ ?></td>
                         <td>{{$eq->CompanyName}}</td>
                        <td>{{$eq->Designation}}</td>
                        <td>{{$eq->DateJoined}}</td>
                       <td>{{$eq->DateResigned}}</td>
					   <td>
					   <?php 
					   $sql = "Select
								TIMESTAMPDIFF( YEAR, '".$eq->DateJoined."','". $eq->DateResigned."' ) as _year
								,TIMESTAMPDIFF( MONTH,'".$eq->DateJoined."', '". $eq->DateResigned."' ) % 12 as _month
								,FLOOR( TIMESTAMPDIFF( DAY, '".$eq->DateJoined."', '". $eq->DateResigned."' ) % 30.4375 ) as _day";
								$res=DB::select(DB::raw($sql));
								$newdata =  json_decode(json_encode((array)$res),true);
								$year = $newdata[0]["_year"];
								$month = $newdata[0]["_month"];
								$day = $newdata[0]["_day"];
					   ?>
					   {{$year}} Years & {{$month}} Months
					   </td>
                        <td>{{$eq->ReasonToLeave}}</td>
                       
                     
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
@else
		 <div class="span10"> 
	 <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
		@endif
		
		<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Present Employment Details</font></b></div>        
        </div>
		 <div class="span10"> 
@foreach($CurrentPro as $CurrentPro)
        <table style="width:100%">
		<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Center/Institute
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$CurrentPro->OrgaName}} {{$CurrentPro->Type}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Department(Only For HO)
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$CurrentPro->DepartmentName}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Designation
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$CurrentPro->Designation}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Transfer Type(Promotion/First Appoinment/..)
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$CurrentPro->TransferType}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Type(Permenant/Contract/Casual/..)
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$CurrentPro->EmployeeType}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Trade(Academic Staff Only) 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
			
				
					<font face="verdana" size="2" color="black">{{$CurrentPro->TradeName}}</font>&nbsp;&nbsp;&nbsp;
				
				
				</b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Grade(I/II/III) 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
			
					<font face="verdana" size="2" color="black">{{$CurrentPro->Grade}}</font>&nbsp;&nbsp;&nbsp;
				
				</b></td>
            </tr>
            
            
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Date Of Appoinment
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->StartDate)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->StartDate;}}</font></b></td>
            </tr>
			  <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        Service Category 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->PServiceCategory)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->PServiceCategory;}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        Salary Code 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->PSalaryCode)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->PSalaryCode;}}</font></b></td>
            </tr>
			 <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        Salary Scale
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->PSalaryScale)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->PSalaryScale;}}</font></b></td>
            </tr>
           <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                        No of Increments Earned
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black"></font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       Present Salary Step
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->PStepAmount)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->PStepAmount;}}</font></b></td>
            </tr>
			 <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       Confirmation Date(Only For Permanent Staff)
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->ConfirmationDate)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->ConfirmationDate;}}</font></b></td>
            </tr>
			 <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       EB Qualified Dates(Only For Permanent Staff)
                    </h5>
                </td>
                <td>:-</td> 
				<?php 
					$grade1 = HREBQualification::where('EmpId','=',$EmpId)->where('GradeId','=',1)->where('Deleted','=',0)->pluck('QualifiedDate');
					$grade2 = HREBQualification::where('EmpId','=',$EmpId)->where('GradeId','=',2)->where('Deleted','=',0)->pluck('QualifiedDate');
					$grade3 = HREBQualification::where('EmpId','=',$EmpId)->where('GradeId','=',3)->where('Deleted','=',0)->pluck('QualifiedDate');
				?>
                <td><b>Grade III:&nbsp;&nbsp;&nbsp;{{(empty($grade3)) ? '<font face="verdana" size="2" color="red">No Data Found&nbsp;&nbsp;&nbsp;' : '<font face="verdana" size="2" color="black">'.$grade3;}}&nbsp;&nbsp;&nbsp;</font></b>
				<b>Grade II:&nbsp;&nbsp;&nbsp;{{(empty($grade2)) ? '<font face="verdana" size="2" color="red">No Data Found&nbsp;&nbsp;&nbsp;' : '<font face="verdana" size="2" color="black">'.$grade2;}}&nbsp;&nbsp;&nbsp;</font></b>
				<b>Grade I:&nbsp;&nbsp;&nbsp;{{(empty($grade1)) ? '<font face="verdana" size="2" color="red">No Data Found&nbsp;&nbsp;&nbsp;' : '<font face="verdana" size="2" color="black">'.$grade1;}}&nbsp;&nbsp;&nbsp;</font></b></td>
            </tr>
			 <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       Date Of Termination(Only For Terminations)
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				@if($CurrentPro->Available == 1)
				<font face="verdana" size="2" color="red">No Data Found</font>
			@else
				<font face="verdana" size="2" color="black">{{$CurrentPro->StartDate}}</font>
			@endif
			</b></td>
            </tr>
			 <tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       Gratuity Amount Rs.
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->GratuityAmount)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->GratuityAmount;}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       ETF Released Date
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->ETFReleasedDate)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->ETFReleasedDate;}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                    <i class=" icon-check"></i>&emsp;
                       EPF Released Date
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>{{(empty($CurrentPro->EPFReleasedDate)) ? '<font face="verdana" size="2" color="red">No Data Found' : '<font face="verdana" size="2" color="black">'.$CurrentPro->EPFReleasedDate;}}</font></b></td>
            </tr>
          
        </table>
		@endforeach
    </div>
   <div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Previous Employment Details</font></b></div>        
        </div>
		@if(!empty($ExPro))
    <div class="span10"> 
	<font face="verdana" size="2" color="black">
        <table style="width:100%" id="sample-table-2" class="table table-striped table-bordered table-hover" >
		<thead>
		<tr>
		
                       <th rowspan="2">No</th>
                       
						<th rowspan="2">To Center(Type)</th>
                        <th rowspan="2">To Department</th>
                        <th rowspan="2">Transfer Type</th>
                        <th rowspan="2">Designation</th>
                        <th rowspan="2">Employee Type</th>
						<th rowspan="2">Effective Date</th>
                        
                        <th colspan="4" style="text-align: center;">Salary Details</th>
						
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach($ExPro as $pr)
		 <tr>
                        <td>{{$i++}}</td>
                       
						
						<td>{{$pr->OrgaName}}({{$pr->Type}})</td>
						<td>{{$pr->DepartmentName}}</td>
						<td>{{$pr->TransferType}}</td>
						<td>{{$pr->Designation}}</td>
						<td>{{$pr->EmployeeType}}</td>
						<td>{{$pr->StartDate}}</td>
						@if($pr->PSalaryCode !='')
							
						<td>{{$pr->PSalaryCode}}</td>
						<td>{{$pr->PSalaryScale}}</td>
						
						<?php 
						if(!empty($pr->PSalaryStep) || $pr->PSalaryStep !=0)
						{
						 $salsteptransP = HRSalaryStepTrans::where('id','=',$pr->PSalaryStep)->first();
						}
						else
						{
							$salsteptransP="";
						}
						?>
						<td>
						@if($pr->PSalaryStep != '' || $pr->PSalaryStep != 0)
						No.{{$salsteptransP->StepNo}}-{{$salsteptransP->StepAmount}}/=
						@if($salsteptransP->EBAvailable == 1)
							(EB Available)
							@else
								@endif
						@else
					    @endif
						</td>
						<td>{{$pr->PGrade}}</td>
						@else
							<td>{{$pr->SalaryCode}}</td>
						<td>{{$pr->SalaryScale}}</td>
						
						
							
						
						<?php 
						 
						 
						 if(!empty($pr->SalaryStep))
						{
						 $salsteptrans = HRSalaryStepTrans::where('id','=',$pr->SalaryStep)->first();
						}
						else
						{
							$salsteptrans="";
						}
						?>
						<td>
						@if($pr->SalaryStep != '')
						No.{{$salsteptrans->StepNo}}-{{$salsteptrans->StepAmount}}/=
						@if($salsteptrans->EBAvailable == 1)
							(EB Available)
							@else
								@endif
							
						@else
								@endif
						</td>
							
						<td>{{$pr->Grade}}</td>
							@endif
						
						
						
						
						<td>{{$pr->IncrementMonth}}</td>
						<td>{{$pr->IncrementDay}}</td>
						
						
                       
                     
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
@else
		 <div class="span10"> 
	 <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
		@endif
		<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Loan Details</font></b></div>        
    </div>
	@if(!empty($LoanDetails))
    <div class="span10"> 
	<font style="width:100%" face="verdana" size="2" color="black">
        <table  id="sample-table-2" class="table table-striped table-bordered table-hover">
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
		 <tbody>
		 <?php $i = 1; ?>
		 @foreach($LoanDetails as $eq)
		 <tr>
                  <td> <?php echo $i++ ?></td>
                     
                        <td>{{$eq->Initials}} {{$eq->LastName}}</td>
                        <td>{{$eq->NIC}}</td>
						<td>{{$eq->EPFNo}}</td>
						<td>{{$eq->LoanType}}</td>
						<td>{{$eq->LoanAmount}}</td>
						<td>{{$eq->IssuedDate}}</td>
                        <td>{{$eq->CompletedDate}}</td>
					    <td>{{$eq->NoOFInstallment}}</td>
						
							  <td>
							  @if($eq->LoanClosed == 1)
								  Completed 
							  @else 
								  Not Completed 
							  @endif</td>
							  
		</tr>
		 @endforeach
          </tbody>   
        </table>
    </div>
	@else
    <div class="span10"> 
         <center>
        <b><font face="verdana" color="red">No Data Found</font></b>
		</center><br/>
    </div>
	@endif
	<div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Personal File Document List</font></b></div>        
    </div>
	<div class="span10"> 
	<table style="width:100%" border="0">
		<tr>
                <td style="width:35%">
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            File No
                    </h5>
                </td>
                <td style="width:5%">:-</td> 
                <td style="width:60%"><b><font face="verdana" size="2" color="black">{{$PFileNo}}</font></b></td>
            </tr>
			@foreach($quaorg as $g)
			<tr>
                <td style="width:35%">
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
						{{$g->DocumentName}}
                    </h5>
                </td>
                <td style="width:5%">:-</td> 
				<?php
						
						$result = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$PFileNoId)->where('DocumentId','=',$g->id)->pluck('Availability');
						$countres = count($result);
						?>
                <td style="width:60%"><b>
				@if($countres == 0)
							Not Available
						@else
							@if($result == 1)
								<font color="green"><i class="icon-ok bigger-130"></i></font>
								@else
									<font color="red"><i class="icon-remove bigger-130"></i></font>
									@endif
							
						@endif</b></td>
            </tr>
			@endforeach
		</table>
		</div>

    <div class="span10"> 
        <b><hr></b>
    </div>

    <!--
    <div class="span9" style="width: color: red; background-color: pink; border: 2px solid blue; padding: 5px;">
    </div>
    -->


</div><!--/.page-content-->



@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

<script type="text/javascript">

$(document).ready(function() {

    $('#btn_studentData').on('click',function() 
    {
        //alert("Plz");

        var studentData = $("#studentData").val();

        //alert(studentData);

        $.ajax
                ({
                    url: "{{url::to('PrintHREmployeeProfile')}}",
                    data: {studentData: studentData},
                    success: function(result)
                    {
                            response(result);
                    }
                });
    });
     function response(data)
    {
        var printWin = window.open("", "printSpecial");
        printWin.document.open();
        printWin.document.write(data);
        printWin.document.close();
        printWin.print();
    }
});

</script>