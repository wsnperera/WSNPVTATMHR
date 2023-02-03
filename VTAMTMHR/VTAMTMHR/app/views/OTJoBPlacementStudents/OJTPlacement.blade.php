@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />


<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewJOBPStudents')}}> << Back to View </a>
                <h1>JOBP Student<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <input type="hidden" name="edit_id" id="edit_id" value="{{$IRTrainee->id}}" />
				<input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
				<input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
				<input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
				<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
				<table>
				<tr>
				<td><div class="control-group">
                    <label class="control-label" for="centers">Year</label>
                    <?php  $year = date("Y"); ?>
                    <div class="controls">
                      <input type="text" name="Year" id="Year" value="{{$CourseYearPlan->Year}}" readonly />
                            
                    </div>
                </div>
				</td>
				<td><div class="control-group">
                    <label class="control-label" for="centers">Batch:</label>
                    <div class="controls">
                        <input type="text" name="Batch" id="Batch" value="{{$CourseYearPlan->Year}}" readonly />
                           
                        
                    </div>
                </div>
				</td>
				</tr>
				<tr>
				<td> <div class="control-group">
                    <label class="control-label" >District : </label>
                        <div class="controls" id="Trade">
						 <input type="text" name="District" id="District" value="{{$DistrictName}}" readonly />
                           
                           
                        </div>         
                 </div></td>
				<td> <div class="control-group">
                    <label class="control-label" >Centre : </label>
                        <div class="controls" id="Trade">
						<input type="text" name="CenterID" id="CenterID" value="{{$OrganisationName}}" readonly />
                           
                           
                        </div>         
                 </div></td>
				</tr>
				<tr>
				<td> <div class="control-group">
                    <label class="control-label" >Course : </label>
                        <div class="controls" id="Trade">
						<textarea  name="CourseYearPlanID" id="CourseYearPlanID" readonly>{{$CourseName}}</textarea>
                           
                           
                        </div>         
                 </div></td>
				<td><div class="control-group">
                    <label class="control-label" for="centers">Name With Initials :</label>
                    <div class="controls">
                       <textarea name="NameWithInitials" id="NameWithInitials" readonly>{{$IRTrainee->NameWithInitials}} </textarea>
                    </div>
                </div>
                </td>
				</tr>
				<tr>
				<td><div class="control-group">
                    <label class="control-label" for="CourseListCode">Full Name : </label>
                    <div class="controls">
					<textarea name="FullName" id="FullName" readonly>{{$IRTrainee->FullName}}</textarea>
                  
                    </div>
                </div></td>
				<td><div class="control-group">
                    <label class="control-label" for="CourseListCode">NIC : </label>
                    <div class="controls">
					<input type="text" name="NIC" id="NIC" value="{{$IRTrainee->NIC}}" readonly/>
                  
                    </div>
                </div></td>
				</tr>
				<tr>
				<td>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">MIS Number : </label>
                    <div class="controls">
					<input type="text" name="MISNumber" id="MISNumber" value="{{$IRTrainee->MISNumber}}" readonly/>
                  
                    </div>
                </div></td>
				<td>	<div class="control-group">
                    <label class="control-label" for="CourseListCode">Mobile Number : </label>
                    <div class="controls">
					<input type="text" name="Mobile" id="Mobile" value="{{$IRTrainee->Mobile}}" readonly/>
                  
                    </div>
                </div></td>
				</tr>
				<tr>
				<td><div class="control-group">
                    <label class="control-label" for="CourseListCode">Address : </label>
                    <div class="controls">
					<textarea type="text" name="Address" id="Address" readonly>{{$IRTrainee->Address}}</textarea>
                  
                    </div>
                </div></td>
				<td><div class="control-group">
                    <label class="control-label" for="CourseListCode">Gender : </label>
                    <div class="controls">
					<input  type="text" name="Gender" id="Gender" value="{{$IRTrainee->Gender}}" readonly>
					
                    </div>
					  </div>
					
                </div>
				</td>
				</tr>
				
				</table>
					
			
             
				<center><hr/></center>
				<h5><b><font color="red">JOB Placement Details</font></b></h5>
				<div class="control-group">
                <label class="control-label" >Company District:</label>
                <div class="controls">
                    <select name="DistrictCode" id="DistrictCode" required>
                        <option>--- Select District ---</option>
                        @foreach ($district as $d)
                        <option value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                        @endforeach
                    </select><span style="color:red">*</span>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">DS Division::</label>
                <div class="controls"  id="elec_code">
                    <select id="ElectorateCode" name="ElectorateCode" required>
                        <option>--- Select DS Division ---</option>
                    </select><span style="color:red">*</span>
                </div>
				</div>
			<!--<div class="control-group">
                    <label class="control-label" >Company : </label>
                        <div class="controls" >
                            <select name="CompanyID" id="CompanyID" required>
                                 
                            </select><span style="color:red">*</span>
                           
                        </div>         
                 </div>	-->
				 <div class="control-group">
                <label class="control-label" for="form-field-7">Vacancy:</label>
                <div class="controls"  id="VacancyId">
                    <select id="VacancyCode" name="VacancyCode" required="true">
                        <option>--- Select Vacancy ---</option>
                    </select><span style="color:red">*</span>
                </div>
				</div>
				 <div class="controls" id='table'>
                </div> 
				<div class="control-group">
                    <label class="control-label" >Starting Date : </label>
                        <div class="controls" >
                            <input type="date" name="StartDate" id="StartDate" required />
                           <span style="color:red">*</span>
                           
                        </div>         
                 </div>	
				 <div class="control-group">
                    <label class="control-label" >Ending Date : </label>
                        <div class="controls" >
                            <input type="date" name="EndDate" id="EndDate" required />
                           <span style="color:red">*</span>
                           
                        </div>         
                 </div>	
				 <div class="control-group">
                    <label class="control-label" >Allowence : </label>
                        <div class="controls" >
                            <input type="text" name="Salary" id="Salary"  />
                           <span style="color:red">* Eg 10000.00</span>
                           
                        </div>         
                 </div>	
               <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-block btn-success" value="Save"/>
                    </div>
                </div>
                   
            </form>
        </div>
        <div class="span4">
            @if($errors->has())
                @foreach($errors->all() as $msg)
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('includes.footer')
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>

<script>
   jQuery(document).ready(function() {
   
$(".chzn-select").trigger("liszt:activate");
$(".chzn-select").chosen(); 
});

    $("#courseCode").change(function()
    {
        if($("#courseCode").val()!='')
        {
            
            $("#placeHolder").html(html);
        }
        else
        {
            $("#placeHolder").html('');
        }
    });
    
</script>
<script type="text/javascript">

 /*  $("#CompanyID").change(function() {
        var cid = $("#CompanyID").val();
		var traineeid = $("#edit_id").val();
        $("#table").html('');
       
       
        $.ajax({
            type: "GET",
            url: "{{url::to('GetJOBpAvailableVacancy')}}",
            data: {CourseListCode: cid,traineeid: traineeid},
            success: function(result) {
                $('#table').html(result);

            }
        });
    });
 */
 
 $("#elec_code").change(function() {
       var District = $("#DistrictCode").val();
		var elec_code = $("#ElectorateCode").val();
        //$("#VacancyId").html('');
        var msg = '--- Select Vacancy ---';
		var traineeid = $("#edit_id").val();
       
       
        $.ajax({
            type: "GET",
            url: "{{url::to('GetJOBpAvailableVacancy')}}",
            data: {District: District,Electorate: elec_code,traineeid: traineeid },
            dataType: "json", 
            success: function(result) {
				
				if(result.Count == 0)
				{
					bootbox.alert('Matched vacancies are not available for the student course trade.Therefore please try another DS Division....');
					document.getElementById('VacancyId').innerHTML = result.Table;
				}
				else
				{
					document.getElementById('VacancyId').innerHTML = result.Table;

				}
            }
        });
    });
    $("#DistrictCode").change(function() {

        var d_code = document.getElementById('DistrictCode').value;

        $.ajax({
            url: "{{url::to('IRdisLoadajax')}}",
            data: {d_code: d_code},
            success: function(result) {
                document.getElementById('elec_code').innerHTML = result;

            }

        });

    });
	
		
	/* $("#elec_code").change(function() 
	{
        var District = $("#DistrictCode").val();
		var elec_code = $("#ElectorateCode").val();
        $("#CompanyID").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Company ---';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('LoadIRCompanyFromElectorate')}}",
                                        data: {District: District,Electorate: elec_code },
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CompanyID").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CompanyID").append("<option value=" + item.id + ">" +item.CompanyName + "(" + item.Address + ")</option>");



                                                });

                                        } 
                                });            

            
     
    }); */
	</script>
      
  <script type="text/javascript">
  
       $("#CenterID").change(function() {
		   
		   
        var cid = $("#CenterID").val();
	    var Year = $("#Year").val();
		var Batch = $("#Batch").val();
		var District = $("#District").val();
		
        
        $("#CourseYearPlanID").html('');
        var msg = '--- Select Course ---';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('OJTCourseFilter')}}",
                                        data: {CourseListCode: cid,Year: Year,Batch: Batch,District: District},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CourseYearPlanID").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                   $("#CourseYearPlanID").append("<option value=" + item.id + ">" +item.Year + "- Batch("+ item.batch +  ") " + item.CourseName + " - " + item.Nvq+"-("+ item.CourseLevel+")- Duration (" + item.Duration + ") Type - " + item.CourseType +")</option>");

//alert('df');

                                                });

                                        } 
                                });           

            
        });
    
  
   /*  $("#StartedStatus").change(function() {
        //var ComStand = $("#ComStand").val();
        //$("#table_instructor").html('');
        
        var msg = '--- Select Instructors ---';
      
            
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('LoadNVQCourseComPackage')}}",
                                       // data: {ComStand: ComStand},
                                        //dataType: "json", 
                                         success: function(result)
                                        {
                                        var html='<select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Qualification Packages..." required="true">'+result+'</select>';
                                            
                                            
                                            $("#table_instructor").append(html);
                                            $("#NVQPackage.chzn-select").trigger("liszt:updated");
                                            $(".chzn-select").chosen(); 
                                            
                                        }
                                });            

            
       
    });    
 */
 


   


								
								$("#District").change(function() 
	{
        var District = $("#District").val();
        $("#CenterID").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Centre ---';
		var all = 'All';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('loaddistrictcentersin')}}",
                                        data: {District: District},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CenterID").append("<option value=''>" + msg + "</option>");
											 $("#CenterID").append("<option value='All'>" + all + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CenterID").append("<option value=" + item.id + ">" +item.OrgaName + "(" + item.Type + ")</option>");



                                                });

                                        } 
                                });            

            
     
    });
</script> 
       
               
               
               
      
        
        

    
