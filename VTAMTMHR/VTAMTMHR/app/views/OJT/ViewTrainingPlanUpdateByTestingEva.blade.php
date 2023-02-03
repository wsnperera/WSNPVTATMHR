@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
	<div class="span12">
       <div class="span8" style="width: 100%">
            <div class="page-header position-relative">
                <!--<a href={{url('ViewAndDownloadAssessor')}}> << Back to Assessor View</a>-->
                <h1>OJT and JOB Placement (IR Division)<small><i class="icon-double-angle-right"></i>View</small></h1>
            </div>
		 </div>	
            <form class="form-horizontal" action='{{url("ViewTrainingPlanUpdateIROJT")}}' method="POST"  id='NewModule'>
                  
                 
				@if($OrgaType == 'HO' || $OrgaType == 'PO')
				<div class="control-group">
                    <label class="control-label" >District : </label>
                        <div class="controls" id="Trade">
                            <select name="District" id="District">
                                 <option value="">--Select District--</option>
								  <option value="All">All</option>
                                @foreach($Districts as $d)
                                <option value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                                @endforeach
                            </select>
                           
                        </div>         
                 </div>
				 @endif
                <div class="control-group">
                    <label class="control-label" >Centre : </label>
                        <div class="controls" id="Trade">
                            <select name="CenterID" id="CenterID" required>
                                 <option value="">--Select Centre--</option>
								 @if($OrgaType == 'HO' || $OrgaType == 'PO' || $OrgaType == 'DO' || $OrgaType == 'NVTI')
								  <option value="All">All</option>
							     @endif
                                @foreach($Centers as $v)
                                <option value="{{$v->id}}">{{$v->OrgaName}} - {{$v->Type}}</option>
                                @endforeach
                            </select>
                           
                        </div>         
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
                            <option value="" >--- Select Batch ---</option>
							 <option value="All">All</option>
                            <option value="1">1</option>
                            <option value="2">2</option>]
							 <option value="1.2">1.2</option>
							  <option value="2.2">2.2</option>
                          
                        </select>
                        <span id='img4'></span>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <label class="control-label" >Course Year Plan : </label>
                        <div class="controls" id="Trade">
                            <select name="CourseYearPlanID" id="CourseYearPlanID" required>
                                 <option value="">--Select Course--</option>
                               
                            </select>
                           
                        </div>         
                 </div> 
                 <div class="control-group">
                    <label class="control-label" >Date : </label>
                        <div class="controls" id="Trade">
                           <input type="date" name="DatePlanned" id="DatePlanned" required>
                           
                           
                        </div>         
                 </div>  
                 <div class="controls" id='table1'>
                            </div>
							
							-->
               
         <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Search</button>
                </div>
            </div>             

            </form>
			 @if(isset($trplans))
        
    <table>
    <tr>@if($user->hasPermission('PrintPDFTrainingPlanReportByTestingEva'))
        <td>
          
            <form> 
                            <input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
                            <input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
                            <input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
							<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
                            <button type="button" id="upload" class="btn btn-info">
                            <i class="icon-print bigger-100"></i>Print PDF (Full Details)</button>
                           
            </form> 
                       
        </td>
		@endif
		@if($user->hasPermission('PrintExcelTrainingPlanReportByTestingEva'))
        <td>
            <form name='search' action="{{url('PrintExcelTrainingPlanReportByTestingEva')}}" method='POST' class="form-horizontal">
                <input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
                <input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
                <input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
				<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
                <button type="submit" id="search" class="btn btn-success">
                <i class="icon-download-alt bigger-100"></i>Download Excel (Full Details)</button>
               
            </form> 
        </td>
		@endif
		 <td>
          
            <form> 
                            <input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
                            <input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
                            <input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
							<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
                            <button type="button" id="upload1" class="btn btn-pink">
                            <i class="icon-print bigger-100"></i>Print PDF (Exam Details)</button>
                           
            </form> 
                       
        </td>
		<td>
            <form name='search' action="{{url('PrintExcelTrainingPlanReportByTestingEva1')}}" method='POST' class="form-horizontal">
                <input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
                <input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
                <input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
				<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
                <button type="submit" id="search" class="btn btn-warning">
                <i class="icon-download-alt bigger-100"></i>Download Excel (Exam Details)</button>
               
            </form> 
        </td>
		<td>
		 <span id='img7'></span>
		</td>
    </tr>
    </table>
        

        @endif
		
		 <div class="span12">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
						<th class="center">No</th>
						<th class="center">Edit</th>
						<th class="center">District</th>
						<th class="center">Centre</th>
                        <th class="center">Year</th>
                        <th class="center">Batch</th>
                        <th class="center">Course</th>
						<!-- <th class="center">CourseListCode</th>-->
						
                        <th class="center">CourseType</th>
                        <th class="center">NVQ/NON-NVQ</th>
                        <th class="center">NVQ Level</th>
                        <th class="center">Duration</th>
						<th class="center">Enrollment Capacity</th>
                        <th class="center">Medium</th>
						<th class="center">Start Date</th>
						<th class="center">End Date</th>
						<th class="center">Actual Start Date</th>
						<th class="center">Actual End Date</th>
                        <!--<th class="center">Packages Included</th>-->
						<th class="center">Instructors</th>
						
						<th class="center">No of Trainees Registered</th>
						<th class="center">No of Trainees Dropout</th>
						
						<th class="center">Course Started Status</th>
						
						<th class="center">Accredation Ststus</th>
						<th class="center">Accredation Recommended Date</th>
						<th class="center">Accredation Date</th>
						<th class="center">Accredation Valid Date</th>
						
						
						
                </tr>
                 </thead>
                 <?php $tt=1; ?>
                 <tbody>
                @if(isset($trplans))
                    @foreach($trplans as $mm)
                    <tr>
                     
                       <td class="center">{{$tt++}}</td>
					   <td class="center">@if($user->hasPermission('editCourseYearPlanOJT'))
                                <form id="editform"  action='editCourseYearPlanOJT' method="GET" >
                                    <input type="hidden" name='edit_id' value='{{$mm->id}}' />
									<input type="hidden" value="{{$CenterIDD}}" name="CenterIDD" id="CenterIDD"/>
									<input type="hidden" value="{{$YearD}}" name="YearD" id="YearD"/>
									<input type="hidden" value="{{$BatchD}}" name="BatchD" id="BatchD"/>
									<input type="hidden" value="{{$districtD}}" name="districtD" id="districtD"/>
                                    <button type="Submit" class="btn btn-info btn-mini">{{$mm->id}} <i class="icon-edit icon-2x icon-only"></i></button>
                                </form>
                                @endif</td>
					    <td class="center">{{$mm->DistrictName}}</td>
						<td class="center">{{$mm->OrgaName}}-({{$mm->Type}})</td>
                        <td class="center">{{$mm->Year}}</td>
                        <td class="center">{{$mm->batch}}</td>
                        <td class="center">{{$mm->CourseName}}</td>
						<!--<td class="center">{{$mm->CourseListCode}}</td>-->
                        <td class="center">{{$mm->CourseType}}</td>
                        <td class="center">{{$mm->Nvq}}</td>
                        <td class="center">{{$mm->CourseLevel}}</td>
                        <td class="center">{{$mm->Duration}}</td>
						<td class="center">{{$mm->maxCapacity}}</td>
                        <td class="center">{{$mm->Medium}}</td>
						<td class="center">{{$mm->RealstartDate}}</td>
						<?php
						$endDate = MOCenterMonitoringPlan::getEndDate($mm->RealstartDate,$mm->Duration);
						$Packages = MOCenterMonitoringPlan::getPackages($mm->CD_ID);
						$monitoringDate = MOCenterMonitoringPlan::getMonitoringDates($mm->id);
						
						$ppp = "select moinstructor.id,moinstructor.Name,moinstructor.EPFNo
						  from moinstructorcourse
						  left join moinstructor
						  on moinstructorcourse.InstructorID=moinstructor.id
						  where moinstructorcourse.CourseYearPlanID='".$mm->id."'
						  and moinstructorcourse.Active='Yes'";
                          $Ins=DB::select(DB::raw($ppp));
						?>
						
						<td class="center">{{$endDate}}</td>
						<td class="center">{{$mm->ExActualStartDate}}</td>
						<td class="center">{{$mm->ExActualEndDate}}</td>
						<!--<td class="center">
						@foreach($Packages as $p)
						<span>{{$p->packagecode}}</br></span>
						@endforeach
						</td>-->
					<td class="left">
						@foreach($Ins as $i)
						<span>{{$i->Name}}({{$i->EPFNo}})</br></span>
						@endforeach
						</td>
					
						<td class="center">{{$mm->NoOfTrainees}}</td>
						<td class="center">{{$mm->Dropout}}</td>
						
						<td class="center">
						@if($mm->StartedStatus == 0)
							<font color="red"><i class="icon-remove bigger-130"></i></font>
						@elseif($mm->StartedStatus == 1)
						<font color="green"><i class="icon-ok bigger-130"></i></font>
						@else
							<font color="blue"><i class="icon-legal bigger-130"></i></font>
						@endif
						</td>
						 <?php
						   
						   $getAccredit = AccreditationDetails::getAccreditation($mm->OrgId,$mm->CD_ID);
						   $AccCount = count($getAccredit);
						   ?>
						   @if($AccCount == 0)
                            <td class="center">Data Not Available</td>
							<td class="center">Data Not Available</td>
                            <td class="center">Data Not Available</td>
							<td class="center">Data Not Available</td>
							@else
								@foreach($getAccredit as $a)
									@if($a->Accredit == 'Yes')
									<td class="center">{{$a->Accredit}}</td>
									<td class="center">{{$a->AccreditRecommandedDate}}</td>
									<td class="center">{{$a->AccreditDate}}</td>
									<td class="center">{{$a->AccreditationValidDate}}</td>
									@elseif($a->Accredit == 'Recommended')
									<td class="center">{{$a->Accredit}}</td>
									<td class="center">{{$a->AccreditRecommandedDate}}</td>
									<td class="center">****</td>
									<td class="center">****</td>
									@elseif($a->Accredit == 'Expired')
									<td class="center">{{$a->Accredit}}</td>
									<td class="center">****</td>
									<td class="center">****</td>
									<td class="center">{{$a->AccreditationValidDate}}</td>
									@else
									<td class="center">{{$a->Accredit}}</td>
									<td class="center">****</td>
									<td class="center">****</td>
									<td class="center">****</td>
									@endif
								@endforeach
							@endif
							
							
                        
                        
                   </tr>
                        @endforeach
                    @if($trplans=='[]')
                        <center>Data Not Found</center>
                    @endif
                @endif
        </tbody>
            </table>
             
        </div><!--/.span-->
		
		</div>
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
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
									null,
									null,
                                            null,
											null,
									
											null,
												//null,
                                            null,
                                    {"bSortable": false},
                                            null,
                                   // {"bSortable": false},
                                     null,
                                        null,
                                    {"bSortable": false},
                                    {"bSortable": false},
									//{"bSortable": false},
									null,
									null,
									
									null,
									null,
									null,
									null,
									null,
									null,
									null,
									null,
									null,
									
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

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
	
	


       $("#CenterID").change(function() {
        var cid = $("#CenterID").val();
        $("#table").html('');
        $("#CourseYearPlanID").html('');
        var msg = '--- Select Course ---';
        $.ajax({
            type: "GET",
            url: "{{url::to('FilterCourseYearPlans')}}",
            data: {CourseListCode: cid},
            success: function(result) {
                $('#table').html(result);

            },
            complete: function() {
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('FilterCourseYearPlans1')}}",
                                        data: {CourseListCode: cid},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CourseYearPlanID").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CourseYearPlanID").append("<option value=" + item.id + ">" +item.CourseName + "-"+ item.CourseListCode +  "[Year - " + item.Year + "][Batch - " + item.batch+"]Duration-("+ item.Duration+")-(" + item.RealstartDate + ")</option>");



                                                });

                                        } 
                                });            

            }
        });
    });

    
  
    
    $('#DatePlanned').change(function(){

        //alert('dg');
       var DatePlanned = document.getElementById('DatePlanned').value;
       var CenterID = document.getElementById('CenterID').value;
       var CourseYearPlanID = document.getElementById('CourseYearPlanID').value; 
      // var msg = '--- Select Working Place ---';
        //$("#WorkingPlace").html('');
       $.ajax  ({
                    url: "{{url::to('MOCMCheckPlanneddate')}}",
                    data: {DatePlanned: DatePlanned,CenterID: CenterID,CourseYearPlanID: CourseYearPlanID},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        if(result.module == 1)
                        {
                             document.getElementById('DatePlanned').value = "";
                             $('#table1').html(result.html);
                             
                        }
                        else
                        {
                             $("#table1").html('');
                        }
                       
                        
                                        
                        
                        }


                    
                });
        


       
    });

    function fillModule1() {

        //alert('dfhgftrghy');
        var WorkingPlaceName = document.getElementById('WorkingPlaceName').value;
        var WorkingPlaceAddress = document.getElementById('WorkingPlaceAddress').value;
        var InstituteId = document.getElementById('M_Code').value;
        var ContactNo = document.getElementById('ContactNo').value;
        $.ajax({
                    url: "{{url::to('saveAssessorWorkingPlace')}}",
                    data: {WorkingPlaceName: WorkingPlaceName, WorkingPlaceAddress: WorkingPlaceAddress, InstituteId: InstituteId,ContactNo: ContactNo},
                    dataType: 'json',
                    success: function(result) {
                        if (result.ModuleId !== 0) {
                            $("#ModuleDiv1").html(result.html);
                            $('#addModule1').hide();
                            $('#ajaxerror').html(result.done);
                            
                           //var InstititeId = result.InstituteAddress;
                           // $("#WorkingPlace").html('');
                              /*  $.ajax({
                                            url: "{{url::to('getModuleId')}}",
                                            data: {ModuleCode: ModuleCode},
                                            success: function(re) {
                                                  document.getElementById("AjaxModuleId").value = re;
                                                               }
                                       });*/

                        /* $.ajax  ({
                                    url: "{{url::to('getWorkingPlace')}}",
                                    data: { InstititeId: InstititeId},
                                    dataType: "json", 
                                    success: function(result) {

                                        //alert(result);
                                        $("#WorkingPlace").append("<option value=''>" + msg + "</option>");
                                         $.each(result, function(i, item)
                                        {



                                            $("#WorkingPlace").append("<option value=" + item.id + ">" + item.Placename + "  (" + item.Address + ")</option>");



                                        });
                                                        
                                        
                                        }


                                    
                                });*/

                        } else {
                            $('#ajaxerror').html(result.html);
                            window.scrollTo(0, 0);
                        }
                    }
                });
    }
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
	
	$('#upload').click(function()
    {
      
        var CenterIDD = $("#CenterIDD").val(); 
		 var YearD = $("#YearD").val(); 
		  var BatchD = $("#BatchD").val(); 
		   var districtD = $("#districtD").val(); 
       
      //alert(CD_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img7').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintPDFTrainingPlanReportByTestingEva')}}",
                        data: {CenterIDD: CenterIDD,YearD:YearD,BatchD:BatchD,districtD:districtD},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img7').innerHTML ="";

                        }
                    });
        
    }
    );
$('#upload1').click(function()
    {
      
        var CenterIDD = $("#CenterIDD").val(); 
		 var YearD = $("#YearD").val(); 
		  var BatchD = $("#BatchD").val(); 
		   var districtD = $("#districtD").val(); 
       
      //alert(CD_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img7').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintPDFTrainingPlanReportByTestingEva1')}}",
                        data: {CenterIDD: CenterIDD,YearD:YearD,BatchD:BatchD,districtD:districtD},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img7').innerHTML ="";

                        }
                    });
        
    }
    );
    </script>


