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
                    <h1>
                       Final Assesments      
                        <small>
                            <i class="icon-double-angle-right"></i>
                           Print Final-Assessment Attendence Sheet 
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
             <form action="" method='POST' class='form-horizontal'>

              

               
                      
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
                    <?php  $year = date("Y");
					$Yearss = DB::select(DB::raw("Select distinct courseyearplan.Year from courseyearplan  where courseyearplan.Year is not null order by courseyearplan.Year"));
					?>
                    <div class="controls">
                      <select name="Year" id="Year" required>
                            <option value="" required>--- Select Year ---</option>
							@foreach($Yearss as $yy)
							<option value="{{$yy->Year}}">{{$yy->Year}}</option>
							@endforeach
							
							
                           
                          
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
                <div class="control-group">
                    <label class="control-label" >Course: </label>
                        <div class="controls" id="Trade">
                            <select name="CourseYearPlanID" id="CourseYearPlanID" required>
                                 <option value="">--Select Course--</option>
                               
                            </select>
                           
                        </div>         
                 </div>
                
                 
                <br/> 
                <div class="control-group">
                    <div class="controls">
                        <button type="submit"  class="btn btn-primary"">
                                <i class="icon-eye-open bigger-200"></i>View</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    </div>
                </div>   
            </form>
            <div id="aaaa">
            @if(isset($Trainees))
            <table><tr><td><form> 
            <input type="hidden" value="{{$CourseYearPlanID}}" name="CS_ID" id="CS_ID"/>
                                <button type="button" id="upload" class="btn btn-yellow">
                                <i class="icon-print bigger-100"></i>Print Final Assessment Attendance Sheet</button>
                                <span id='img4'></span>
                            </form></td>
							

                            <td> <form> 
            <input type="hidden" value="{{$CourseYearPlanID}}" name="CS_ID" id="CS_ID"/>
                                <button type="button" id="upload1" class="btn btn-pink">
                                <i class="icon-print bigger-100"></i>Print AS01</button>
                                <span id='img4'></span>
                            </form></td></tr></table> 
             @endif
           <!-- <h5 style="color: #777777;">@if(isset($CourseCode))CourseCode:&nbsp;&nbsp;{{$CourseCode}}@endif</h5>
            <h5 style="color: #777777;">@if(isset($BatchCode))BatchCode:&nbsp;&nbsp;{{$BatchCode}}@endif</h5>-->
            
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class='center'>No</th>
                        <th class='center'>NIC</th>
                        <th class='center'>Name</th>
                        <th class='center'>MIS Number</th>
                        <th class='center'>Address</th>
                        
                        
                        
                </tr>
                </thead>
                    <tbody>

                  <?php 
                  $SerialNo=1;
                  ?>
                @if(isset($Trainees))
                @foreach($Trainees as $t)
                <tr>
                   
                     <td class="center">{{$SerialNo++}}</td>
                    <td class="center">{{$t->NIC}}</td>
                    <td class="center">{{$t->NameWithInitials}}</td> 
                    <td>{{$t->MISNumber}}</td>
                    <td >{{$t->Address}}</td>
                    

                   
                    
                </tr>
                @endforeach

               
                @endif
				
				@if(isset($TraineesRep))
                @foreach($TraineesRep as $t)
			 <tr>
                   
                    <td class="left"><font color="blue">{{$SerialNo++}}</font></td>
                    <td class="left"><font color="blue">{{$t->NameWithInitials}}</font></td>
                    <td class="left"><font color="blue">{{$t->NIC}}</font></td> 
                    <td><font color="blue">{{$t->MISNumber}}</font></td>
					   <td><font color="blue">{{$t->Address}}</font></td>
				

                   
                    
                </tr>
			@endforeach

               
                @endif
            </tbody>
            </table>
            <!--PAGE CONTENT ENDS-->
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(applicant, formobj)
    {
        bootbox.confirm("Are you sure you want to remove " + applicant, function(result)
        {
        if (result)
        {
        formobj.submit();
        }
        });
                return false;
    }
    
    $('#sample-table-2').dataTable({
		"bPaginate":false,
    "aoColumns": [
            {"bSortable": false},
            {"bSortable": false},
           null,
            null,
            
            {"bSortable": false},
           
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

$("#Batch").change(function() {
        var Batch = $("#Batch").val();
		var Year = $("#Year").val();
		var cid = $("#CenterID").val();
		        var dis = $("#District").val();

        //$("#table").html('');
        $("#CourseYearPlanID").html('');
        var msg = '--- Select Course ---';
			var all = 'All';
       
           
           
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('ExamGetCenterCourseListBatchwise')}}",
                                        data: {CourseListCode: cid,Year: Year,Batch: Batch,dis: dis},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CourseYearPlanID").append("<option value=''>" + msg + "</option>");
											//  $("#CourseYearPlanID").append("<option value='All'>" + all + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CourseYearPlanID").append("<option value=" + item.id + ">" +item.CourseName + "-"+ item.CourseListCode +  "[Year - " + item.Year + "][Batch - " + item.batch+"]Duration-("+ item.Duration+")-(" + item.RealstartDate + "-" + item.CourseType + "NVQ Level - " + item.CourseLevel +")</option>");



                                                });

                                        } 
                                });            

            
       
    });
  

  


    $('#upload').click(function()
    {
      
        var CS_ID = $("#CS_ID").val(); 
      // alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('ExamPrintAttendanceSheet2')}}",
                        data: {CS_ID: CS_ID},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    );
    
$('#upload1').click(function()
    {
      
        var CS_ID = $("#CS_ID").val(); 
      // alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('ExamPrintAttendanceSheet3')}}",
                        data: {CS_ID: CS_ID},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    );
    

</script>
