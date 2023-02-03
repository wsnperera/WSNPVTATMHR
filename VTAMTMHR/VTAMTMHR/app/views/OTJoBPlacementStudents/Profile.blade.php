@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
<a href="{{url('ViewJOBPStudentHistory')}}"> << Back to Job Placement History</a> 
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        Trainee Job Placement Profile
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Profile
                        </small>            
                    </h1>
                </div>

            </div>
        </div><!--/.span-->


    </div><!--/.row-fluid-->
@if(isset ($Employeerec))
	  <br/>
	      <div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Trainee Details</font></b></div>
    </div>

    <?php
	$CourseYearPlan = CourseYearPlan::where('id','=',$Employeerec->CourseYearPlanID)->first();
	$districtcode = Organisation::where('id','=',$CourseYearPlan->OrgId)->pluck('DistrictCode');
	$districtName = District::where('DistrictCode','=',$districtcode)->pluck('DistrictName');
	$OrgaName = Organisation::where('id','=',$CourseYearPlan->OrgId)->pluck('OrgaName');
	$CDID = CourseYearPlan::where('id','=',$Employeerec->CourseYearPlanID)->pluck('CD_ID');
	$Course = Course::where('CD_ID','=',$CDID)->first();
	$Trade = Trade::where('TradeId','=',$Course->TradeId)->first();
	
	
	?>

    <div class="span10"> 

        <table style="width:100%">
		            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            District
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$districtName}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Centre
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$OrgaName}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Year & Batch
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$CourseYearPlan->Year}} - {{$CourseYearPlan->batch}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Trade
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$Trade->TradeName}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Course Details
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$Course->CourseName}} ({{$Course->CourseType}}) Duration:{{$Course->Duration}} NVQ Level- {{$Course->CourseLevel}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Name With Initials
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$Employeerec->NameWithInitials}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Names Represented by Initials
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$Employeerec->FullName}}</font></b></td>
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
				
				<font face="verdana" size="2" color="black">{{$Employeerec->NIC}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            MIS Number  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->MISNumber}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
            
            
           <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Mobile  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->Mobile}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Address 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->Address}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Gender 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->Gender}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
           
            
          
        </table>
		<br/><br/>
    </div>
    @endif
    
         <div class="span12">
            <!--PAGE CONTENT BEGINS-->
			 @if(isset ($promotion))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                        <th rowspan="2">No</th>
						<th rowspan="2">Mark As Dropout During the OJT</th>
                        <th colspan="5" class="center">Course Details</th>
                        <th colspan="6" class="center">Company Details</th>
                        <th rowspan="2">Active Status</th>
						<th colspan="3">Student's Current Status</th>
						
						<th rowspan="2">Monitoring Details During the Job</th>
						<th rowspan="2" class="center">JOB Placement Result Sheet</th>
						<th rowspan="2" class="center">Remove</th>
						
                    </tr>
                    <tr>
					    <th class="center">District</th>
                        <th class="center">Center</th>
						<th class="center">Year</th>
						<th class="center">Batch</th>
						<th class="center">Course</th>
						
						<th class="center">Company Name</th>
						<th class="center">Address</th>
						<th class="center">Job Category</th>
						<th class="center">Start Date</th>
						<th class="center">End Date</th>
						<th class="center">Allowence Per Month</th>
                       
                       <th class="center">Job Placed</th>
						<th class="center">Dropout from Job Places</th>
					
						<th class="center">Reason For Dropout</th>
						
						
						
                       
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($promotion as $eq)

                    <tr>
                       <td> <?php echo $i++ ?></td>
                     
                      <td class="center">
					  @if($user->hasPermission('editOJTStudentsHistory'))
                                <!-- <form id="editform"  action='editOJTStudentsHistory' method="GET" >
                                    <input type="hidden" name='edit_id' value='{{$eq->id}}' />
									<input type="hidden" value="{{$eq->TraineeId}}" name="TraineeID" id="TraineeID"/>
                                    <button type="Submit" class="btn btn-pink btn-mini"><i class="icon-edit icon-2x icon-only"></i></button>
                                </form> -->
							@if($eq->Dropout != 1)
								 <font color="green"><a class="green"  id="{{$eq->id}}"> <i class="icon-remove bigger-200"></i></a> </font>
							@endif
						@endif	
					   </td>
                        <td>{{$eq->DistrictName}}</td>
						<td>{{$eq->OrgaName}}</td>
						<td>{{$eq->Year}}</td>
						<td>{{$eq->batch}}</td>
						<td>{{$eq->CourseName}}</td>
						<td>{{$eq->CompanyName}}</td>
						<td>{{$eq->Address}}</td>
                        <td>{{$eq->Category}}</td>
						<td>{{$eq->StartingDate}}</td>
						<td>{{$eq->EndDate}}</td>
						<td>{{$eq->Salary}}</td>
						<td>@if($eq->Active == 1)<font color="green"><i class="icon-ok bigger-130"></i></font> @else <font color="red"><i class="icon-remove bigger-130"></i></font> @endif</td>
						<td>@if($eq->JobPlaced == 1)<font color="green"><i class="icon-ok bigger-130"></i></font> @else <font color="red"><i class="icon-remove bigger-130"></i></font> @endif</td>
				        <td>@if($eq->Dropout == 1)<font color="green"><i class="icon-ok bigger-130"></i></font> @else <font color="red"><i class="icon-remove bigger-130"></i></font> @endif</td>
						<td>{{$eq->ReasonForDropoutOJT}}</td>
                        <td class='center'><font color="pink"><a class="pink1"  id="{{$eq->id}}"> <i class="icon-eye-open bigger-200"></i></a> </font></td>
                        <td class='center'> <font color="DEEPPINK"><a class="DEEPPINK1"  id="{{$eq->id}}"> <i class="icon-download-alt bigger-300"></i></a> </font></td>
                     <td>
						@if($user->hasPermission('DeleteJOBPStudentsPlacement'))
							 <form id="deleteform"  action='DeleteJOBPStudentsPlacement' method="POST" onsubmit="return doConfirm('{{$eq->Category}}',this)">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                            </form>
						@endif
					</td>
                       
                      
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
			 @endif


	

	

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