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
                        NVQ 1 - 4 Exams        
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Enter Trainee Results
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="" method='POST' class='form-horizontal'>
             <div class="control-group">
                <label class="control-label" >Assesment No : </label>
                <div class="controls" id="District">
                    <select name="AssessmentNo" id="AssessmentNo"  class="chzn-select" required>
					<option value="">--- Select Assessment No ---</option>
					@foreach($Assnumbers as $a)
					<option value="{{$a->id}}">{{$a->AssessmentNo}}</option>
					@endforeach
					</select><span><font color="red"><b>*</b></font></span>
                    
                </div>         
            </div> 
                
                
                <br/> 
                <div class="control-group">
                    <div class="controls">
                        <button type="submit"  class="btn btn-primary"">
                                <i class="icon-eye-open bigger-100"></i>Search</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    </div>
                </div>   
            </form>
            <div id="aaaa">
            @if(isset($Trainees))
            
         <input type="hidden" id="CourseYearPlanID" name="CourseYearPlanID" value="{{$CourseYearPlanID}}" />
        <input type="hidden" id="AssesmentNo" name="AssesmentNo" value="{{$AssesmentNo}}" />
            <table>
                <tr>
                    <td>
                    <?php
                     $getConfirmCenter = CourseYearPlan::where('id','=',$CourseYearPlanID)->pluck('CenterConfirmResult');

                     ?>
                     @if($getConfirmCenter == 0)
                        <form action="ExamConfirmResultCenter" method='GET' > 
                            <input type="hidden" value="{{$CourseYearPlanID}}" name="CS_ID" id="CS_ID"/>
                            <button type="submit"  class="btn btn-danger">
                            <i class="icon-ok bigger-200"></i>Confirm Result</button>
                            <span id='img4'></span>
                        </form> 
						

                     @else
                         <button type="button"  class="btn btn-success">
                            <i class="icon-ok bigger-200"></i>Already Confirmed</button>
                     @endif
                       

                    </td>
                    
                    
                </tr>
            </table>
            <br/>	
             
            

             @endif
           <!-- <h5 style="color: #777777;">@if(isset($CourseCode))CourseCode:&nbsp;&nbsp;{{$CourseCode}}@endif</h5>
            <h5 style="color: #777777;">@if(isset($BatchCode))BatchCode:&nbsp;&nbsp;{{$BatchCode}}@endif</h5>-->
            
            <table id='sample-table-2' class='table table-striped table-bordered table-hover' align='center'>
                <thead>
                <tr align='center'>
                   <th class='center'>No</th>
                        <th class='center'>NIC</th>
                        <th class='center'>Name</th>
                        <th class='center'>MIS Number</th>
                    
                     <th class='center' >Enter</th>

                       
                        
                </tr>
               </thead>
                <tbody>
                 <?php $SerialNo=1
                  ?>
                @if(isset($Trainees))
                @foreach($Trainees as $t)
                <tr>
                     <td>{{$SerialNo++}}</td>
                     <td>{{$t->NameWithInitials}}</td>
                     <td>{{$t->NIC}}</td>
					 <td>{{$t->MISNumber}}</td>
                    

                    @if($getConfirmCenter == 0)
						@if($t->FResultEntered == 0)
						<td class='center'><font color="blue"><a class="blue" href="{{url('ExamNewEULoadStudentExamResultEnterOriginal?asnid='.$t->id.'&&CDID='.$CourseYearPlanID)}}" > <i class="icon-edit bigger-130"></i></a></font></td>
						@else
						<td class='center'> <font color="green"><a class="green" href="{{url('ExamNewEULoadStudentExamResultEnterOriginal?asnid='.$t->id.'&&CDID='.$CourseYearPlanID)}}" ><i class="icon-ok bigger-130"></i> Entered</a></font></td>
						@endif
                    @else
                    <td class='center'> <font color="red"><i class="icon-ok bigger-130"></i> Comfirmed & Cannot Changed</font></td>
                    @endif

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
                    

                     @if($getConfirmCenter == 0)
                     @if($t->FResultEntered == 0)
                     <td class='center'><font color="blue"><a class="blue" href="{{url('ExamNewEULoadStudentExamResultEnterOriginal?asnid='.$t->id.'&&CDID='.$CourseYearPlanID)}}" > <i class="icon-edit bigger-130"></i></a></font></td>
                      @else
                      <td class='center'> <font color="green"><a class="green" href="{{url('ExamNewEULoadStudentExamResultEnterOriginal?asnid='.$t->id.'&&CDID='.$CourseYearPlanID)}}" ><i class="icon-ok bigger-130"></i> Entered</a></font></td>
                      @endif
                    @else
                    <td class='center'> <font color="red"><i class="icon-ok bigger-130"></i> Comfirmed & Cannot Changed</font></td>
                    @endif

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
<script src="assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(".chzn-select").chosen();
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
    
 /*    $('#sample-table-2').dataTable({
		 "bPaginate":false,
    "aoColumns": [
            {"bSortable": false},
            null,
          null,
          null,
             {"bSortable": false},
            
           
    ]}); */

        $('#sample-table-2 th input:checkbox').on('click', function() {
                                var a = this;
                                $(this).closest('table').find('tr td:nth-child(5) input:checkbox')
                                        .each(function() {
                                            this.checked = a.checked;
                                            //$(this).closest('tr').troggleClass('selected');
                                        });

                            });
      

</script>
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
          {"bSortable": false},
           {"bSortable": false},  {"bSortable": false},
            
           
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
$('#center').change(function(){

        //alert('dg');
       var center = document.getElementById('center').value; 
      
       var msg = '--- Select Course ---';
        $("#Course").html('');
       $.ajax  ({
                    url: "{{url::to('GetNominatedCourses')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Course").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Course").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");



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
                        url: "{{Url('PrintAssessorAssignedLetter')}}",
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
