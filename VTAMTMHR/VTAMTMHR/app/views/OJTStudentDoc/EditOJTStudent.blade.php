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
                <a href={{url('ViewOJTStudentsDoc')}}> << Back to View </a>
                <h1>OJT Student<small><i class="icon-double-angle-right"></i>Document List</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST">
                <input type='hidden' name='id' id='id' value='{{$IRTrainee->id}}' />
				<input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
				<input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
				<input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
				<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
				
					 <div class="span12">
							<table id="sample-table-2" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="center">No</th>
										<th class="center">Document Name</th>
										<th class="center">Download</th>
									</tr>
								</thead>
								 <?php $tt=1; ?>
								 <tbody>
									<tr>
										<td class="center">{{$tt++}}</td>
										<td class="left">Monthly Attendence Sheet</td>
									    <td class='center'> <a class="DEEPPINK"  id="{{$IRTrainee->id}}"> <font color="BLUE"><i class="icon-download-alt bigger-300"></i></a> </font>
									</tr>
									<tr>
										<td class="center">{{$tt++}}</td>
										<td class="left"> OJT Placement Letter</td>
										<td class='center'> <a class="GREEN"  id="{{$IRTrainee->id}}"> <font color="DEEPPINK"><i class="icon-download-alt bigger-300"></i></font></a> 
									</tr>
								 <tr>
										<td class="center">{{$tt++}}</td>
										<td class="left">OJT Placement Agreement</td>
										 <td class='center'> <a class="BLACK"  id="{{$IRTrainee->id}}"> <font color="PURPLE"><i class="icon-download-alt bigger-300"></i></font></a> 
									</tr>
								   <tr>
										<td class="center">{{$tt++}}</td>
										<td class="left">OJT Placement Verification Form</td>
									    <td class='center'> <a class="RED"  id="{{$IRTrainee->id}}"><font color="GREEN"> <i class="icon-download-alt bigger-300"></i></font></a> 
									</tr>
									<tr>
										<td class="center">{{$tt++}}</td>
										<td class="left">OJT Completion Letter</td>
										<td class='center'> <a class="ORANGE"  id="{{$IRTrainee->id}}"> <font color="RED"><i class="icon-download-alt bigger-300"></i></font></a> 
									</tr>
									<tr>
										<td class="center">{{$tt++}}</td>
										<td class="left">OJT Monitoring Form(For PO)</td>
										<td class='center'> <a class="PURPLE"  id="{{$IRTrainee->id}}"> <font color="ORANGE"><i class="icon-download-alt bigger-300"></i></font></a> 
									</tr>
									
								 </tbody>
							</table>
               
			
				
			            
            </form>
        </div>
				
				
				
           
			  

        
             
				
				

_        
       
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
<script type="text/javascript">
                                            function doConfirm(course, formobj)
                                            {
                                            bootbox.confirm("Are you sure you want to remove Course Year Plan with Course List Code : " + course, function(result)
                                            {
                                            if (result)
                                            {
                                            formobj.submit();
                                            }
                                            });
                                                    return false; // by default do nothing hack :D
                                            }

                                    $('#sample-table-2').dataTable({
                                    "aoColumns": [
                                          
                                    {"bSortable": false},
                                    {"bSortable": false},
                                    {"bSortable": false}
									
                                 
                                   
                                   
                                   
                                    ]});
                                            $('table th input:checkbox').on('click', function() {
                                    var that = this;
                                            $(this).closest('table').find('tr > td:first-child input:checkbox')
                                            .each(function() {
                                            this.checked = that.checked;
                                                    $(this).closest('tr').toggleClass('selected');
                                            });
                                    });
                                            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                                            function tooltip_placement(context, source) {
                                            var $source = $(source);
                                                    var $parent = $source.closest('table')
                                                    var off1 = $parent.offset();
                                                    var w1 = $parent.width();
                                                    var off2 = $source.offset();
                                                    var w2 = $source.width();
                                                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                                                    return 'right';
                                                    return 'left';
                                            }


</script>
<script>
   jQuery(document).ready(function() {
	   
	    $(".BLACK").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadOJTAgreementEngForm')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});

     $(".PURPLE").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadOJTPOMonitoringForm')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});
	   
	     $(".ORANGE").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadOJTCompletionForm')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});
	   
	   $(".RED").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadOJTVerificationForm')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});
	   
$(".GREEN").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadOJTPlacementLetter')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});
	   
	   $(".DEEPPINK").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadOJTAttendeceSheet')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});
   
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
       
               
               
               
      
        
        

    
