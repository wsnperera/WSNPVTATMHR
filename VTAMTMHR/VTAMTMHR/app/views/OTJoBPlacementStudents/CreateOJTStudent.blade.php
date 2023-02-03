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
                <a href={{url('ViewOJTStudents')}}> << Back to View </a>
                <h1>OJT Student<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST">
                
				<div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Trainee Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
					<div class="control-group">
                    <label class="control-label" for="centers">Year</label>
                    <?php  $year = date("Y"); ?>
                    <div class="controls">
                      <select name="Year" id="Year" required>
                            <option value="" required>--- Select Year ---</option>
							<option value="{{$year-2}}">{{$year-2}}</option>
							<option value="{{$year-1}}">{{$year-1}}</option>
                            <option value="{{$year}}">{{$year}}</option>
                            <option value="{{$year+1}}">{{$year+1}}</option>
                            <option value="{{$year+2}}">{{$year+2}}</option>
                            <option value="{{$year+3}}">{{$year+3}}</option>
                           
                          
                        </select> 
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="centers">Batch:</label>
                    <div class="controls">
                        <select name="Batch" id="Batch" required>
                            <option  value="" >--- Select Batch ---</option>
                            <option  value="1">1</option>
                            <option  value="2">2</option>
                            <option  value="1.2">1.2</option>
							<option  value="2.2">2.2</option>
                        </select>
                        <span id='img4'></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" >District : </label>
                        <div class="controls" id="Trade">
                            <select name="District" id="District" required>
							
                                 <option value="">--Select District--</option>
								 
                                @foreach($Districts as $d)
                                <option  value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                                @endforeach
                            </select>
                           
                        </div>         
                 </div>
                 <div class="control-group">
                    <label class="control-label" >Centre : </label>
                        <div class="controls" id="Trade">
                            <select name="CenterID" id="CenterID" required>
                                 <option value="">--Select Centre--</option>
								
                            </select>
                           
                        </div>         
                 </div> 
			
				 <div class="control-group">
                    <label class="control-label" >Course : </label>
                        <div class="controls" id="Trade">
                            <select name="CourseYearPlanID" id="CourseYearPlanID" required>
                                 <option value="">--Select Course--</option>
								
                            </select>
                           
                        </div>         
                 </div>
				<div class="control-group">
                    <label class="control-label" for="centers">Name With Initials :</label>
                    <div class="controls">
                       <textarea name="NameWithInitials" id="NameWithInitials" required> </textarea>
                    </div>
                </div>
                
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">Full Name : </label>
                    <div class="controls">
					<textarea name="FullName" id="FullName" required></textarea>
                  
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">NIC : </label>
                    <div class="controls">
					<input type="text" name="NIC" id="NIC" required/>
                  
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">MIS Number : </label>
                    <div class="controls">
					<input type="text" name="MISNumber" id="MISNumber"  required/>
                  
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">Mobile Number : </label>
                    <div class="controls">
					<input type="text" name="Mobile" id="Mobile"  required/>
                  
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">Address : </label>
                    <div class="controls">
					<textarea type="text" name="Address" id="Address" required></textarea>
                  
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="CourseListCode">Gender : </label>
                    <div class="controls">
					<select  name="Gender" id="Gender" required>
					<option value="">--- Select Gender ---</option>
					<option  value="Male">Male</option>
					<option  value="Female">Female</option>
					
					</select>
                  
                    </div>
					  </div>
					<div class="control-group">
                    <label class="control-label" for="CourseListCode">Dropout Status : </label>
                    <div class="controls">
					<select  name="Dropout" id="Dropout" required>
					<option value="">--- Select Dropout ---</option>
					<option value="0">No</option>
					<option value="1">Yes</option>
					
					</select>
                  
                    </div>
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
 function addModule() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule').is(':hidden')) {
                            $('#addModule').show();
                        } else {
                            $('#addModule').hide();
                        }
                    }
                });
    }
	function addModule1() {
        $.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule1').is(':hidden')) {
                            $('#addModule1').show();
                        } else {
                            $('#addModule1').hide();
                        }
                    }
                });
    }
    function fillModule() {
        var Name = document.getElementById('Name').value;
        var EPF = document.getElementById('EPF').value;
		var id = document.getElementById('id').value;
       // var msg = '--- Select Instructor---';
       // $("#InstructorList").html('');
		//$("#InstructorList1").html('');
		if(Name == '' || EPF == '' || EPF == 0)
		{
			bootbox.alert('Please Enter Instructor Name & Valid and Correct EPF Number!!!!!');
		}
		else
		{
        $.ajax({
                    url: "{{url::to('SaveMOInstructor')}}",
                    data: {Name: Name, EPF: EPF},
                    dataType: 'json',
                    success: function(result) {
                      
                            
                            $('#addModule').hide();
                            $('#ajaxerror').html(result.done);
                         
							$.ajax({
                                        type: "GET",
                                        url: "{{url::to('LoadMoinstructorListDis')}}",
                                        data: {id: id},
                                        //dataType: "json", 
                                         success: function(result)
                                        {
                                        var html='<select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Instructors..." required="true">'+result+'</select>';
                                            
                                             $("#table_instructor").html('');
                                            $("#table_instructor").append(html);
                                            $("#NVQPackage.chzn-select").trigger("liszt:updated");
                                            $(".chzn-select").chosen(); 
                                            
                                        }
                                });            

                                                        
                                   

                        
                        }
                    
                });
		}
    }
	 /*  function fillModule1() {
        var Name = document.getElementById('Name1').value;
        var EPF = document.getElementById('EPF1').value;
        var msg = '--- Select Instructor---';
        $("#InstructorList1").html('');
        $.ajax({
                    url: "{{url::to('SaveMOInstructor')}}",
                    data: {Name: Name, EPF: EPF},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            
                            $('#addModule1').hide();
                           $('#ajaxerror').html(result.done);
                            $("#InstructorList1").append("<option value=''>" + msg + "</option>");
                            $.each(result.list, function(i, item)
                            {



                                $("#InstructorList1").append("<option value=" + item.EPFNo + ">" + item.Name + "  (" + item.EPFNo + ")</option>");



                            });
                                                        
                                   

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
    } */
    $('#Accredit').click(function() {
                                    var s = $('#Accredit').val();
                                    //alert(s);
                                    if(s == 'Yes')
                                    {
                                      document.getElementById('xyz').style.visibility = 'visible';
									  document.getElementById('xyz1').style.visibility = 'visible';
                                      
                                    }
                                    else
                                    {
                                        document.getElementById('xyz').style.visibility = 'hidden';
										document.getElementById('xyz1').style.visibility = 'hidden';
                                    }
                                    
                                    
                                    
                                  
                                });
$("#attachedCenter").change(function() {
        //alert('1');
                                    var attachedCenter = $('#attachedCenter').val();
                               
                                    if (attachedCenter != 'No') {
                                        $.ajax
                                                ({
                                                    beforeSend: function()
                                                    {
                                                      //  $("body").css("cursor", "progress");
                                                       // $("body input").css("cursor", "progress");
                                                        //$("#loding").html('<br><br><img height="50%" width="25%" src=\"{{Url("assets/images/ajax-loader.gif")}}\"/>');
                                                    },
                                                    type: "POST",
                                                    url: 'ajaxGetattachedCenter',
                                                    data: {attachedCenter: attachedCenter},
                                                    //dataType: 'json',
                                                    success: function(result)
                                                    {
                                                       $("#abc").html(result);
                                                    },
                                                    complete: function() {
                                                        //$("#loding").html('');
                                                      //  $("body").css("cursor", "default");
                                                       // $("body input").css("cursor", "default");                                                       
                                                    }

                                                });
                                    } else {
                                        $("#abc").html("");
                                        //bootbox.alert('Please select Institute !');
                                    }
                                });
$("#CourseListCode").on("change", function() {
                                    var CourseListCode = $('#CourseListCode').val();
                                    if (CourseListCode != '') {
                                        $.ajax
                                                ({
                                                    beforeSend: function()
                                                    {
                                                        $("body").css("cursor", "progress");
                                                        $("body input").css("cursor", "progress");
                                                        //$("#loding").html('<br><br><img height="50%" width="25%" src=\"{{Url("assets/images/ajax-loader.gif")}}\"/>');
                                                    },
                                                    type: "POST",
                                                    url: 'ajaxGetNvqLevelCourse',
                                                    data: {CourseListCode: CourseListCode},
                                                    //dataType: 'json',
                                                    success: function(result)
                                                    {
                                                       $("#CourseLevel").html(result);
                                                    },
                                                    complete: function() {
                                                        //$("#loding").html('');
                                                        $("body").css("cursor", "default");
                                                        $("body input").css("cursor", "default");                                                       
                                                    }

                                                });
                                    } else {
                                        //bootbox.alert('Please select Institute !');
                                    }
                                });
								
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
       
               
               
               
      
        
        

    
