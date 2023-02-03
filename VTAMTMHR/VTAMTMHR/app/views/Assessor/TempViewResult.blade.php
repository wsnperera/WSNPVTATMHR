@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('')}}> </a>
                <h1>Result<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"  id='NewModule'/>
              
           
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
            <div class="control-group">
                <label class="control-label" >Trainee : </label>
                <div class="controls" id="TraineeList">
                    <select name="Traineeid" id="Traineeid" required>
                         <option value="">--Select Trainee--</option>
                       
                    </select>
                   
                </div>         
            </div>

          
             <div class="control-group">
                <div id="table1">
                </div>
               
            </div>
             
             <div class="control-group" >
                <div class="controls">
                    <input type="hidden" value="" name="ModuleList" id="ModuleList"/>
                     <button type="button"  id="GetQulification" class="btn btn-small btn-success">Get Qualification</button>
                </div>
               
            </div>


             <div class="control-group">
                <div id="table2">
                </div>
               
            </div>
           
           

            <!--<div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
                </div>
            </div>     -->        

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
        <div class="span4" id="ajaxerror">
            @if(Session::has('done'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                    {{Session::get('done')}}
                </strong>
                <br>
            </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>{{Session::get('message')}}</strong><br>
            </div>
            @endif
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Error!
                </strong>{{$msg}}
                <br>
            </div>
            @endforeach
            @endif

        </div>
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script>
$(".chzn-select").chosen();

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


 $('#GetQulification').click(function()
    {
      
        var ModuleList = $("#Traineeid").val(); 
      //alert(ModuleList);
      
           $("#ModuleList").html('');
                $.ajax  ({
                    url: "{{url::to('ExamGETAjaxQualificationStudent')}}",
                    data: { ModuleList: ModuleList},
                 
                   success: function(result) {
                $('#table2').html(result);
                  

            }


                    
                });
        


       
    });
    
      
$('#districtcode').change(function(){

        //alert('dg');
       var districtcode = document.getElementById('districtcode').value; 
       var msg = '--- Select Center ---';
        $("#CenterId").html('');
       $.ajax  ({
                    url: "{{url::to('GetNVTINDO')}}",
                    data: { districtcode: districtcode},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CenterId").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#CenterId").append("<option value=" + item.id + ">" + item.OrgaName + "  (" + item.Type + ")</option>");



                        });
						
                                        
                        
                        }


                    
                });
        


       
    });

$('#CenterId').change(function(){

        //alert('dg');
       var CenterId = document.getElementById('CenterId').value; 
       var msg = '--- Select Course ---';
        $("#CSID").html('');
       $.ajax  ({
                    url: "{{url::to('TEMPEUGetOngoingCoursese')}}",
                    data: { CenterId: CenterId},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CSID").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#CSID").append("<option value=" + item.CS_ID + ">" + item.CourseCode + "  (" + item.CourseName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });



$('#AssessmentNo').change(function(){

       // alert('dg');
       var AssessmentNo = document.getElementById('AssessmentNo').value; 
       
       var msg = '--- Select Trainee  ---';
        $("#Traineeid").html('');

       $.ajax  ({
                    url: "{{url::to('ExamTEMPLoadTraineeList')}}",
                    data: { AssessmentNo: AssessmentNo},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Traineeid").append("<option value=''>" + msg + "</option>");
                         $.each(result.Trainee, function(i, item)
                        {



                            $("#Traineeid").append("<option value=" + item.id + ">" + item.NIC + "-" +item.FullName+ "- MIS No -" +item.MISNumber+  ")</option>");



                        });
                          $.each(result.Repeaters, function(i, item)
                        {



                            $("#Traineeid").append("<option value=" + item.id + ">" + item.NIC + "-" +item.FullName+ "- MIS No -" +item.MISNumber+  ")</option>");



                        });               
                        
                        }


                    
                });
        


       
    });
$('#Traineeid').change(function()
{

        // alert('dg');
        var Traineeid = document.getElementById('Traineeid').value; 
       
        // var msg = '--- Select Trainee  ---';
        $("#table1").html('');
        $("#table2").html('');
       $.ajax  ({
                    url: "{{url::to('ExamTEMPLoadTraineemodulelistwithresult')}}",
                    data: { Traineeid: Traineeid},
                    dataType: "json", 
                    success: function(result) 
					{
						$('#table1').html(result.html);
						document.getElementById('ModuleList').value = result.module;

					}


                    
                });
        


       
});
  
  
 
    </script>


