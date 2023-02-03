@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-header position-relative">
              <!--  <a href={{url('')}}> << </a>-->
			   <a href="{{url('ExamreturnToTraineeList?AssessmentNo='.$CYPID)}}"> << Back to Enter Trainee Results View </a>
                <h1>  NVQ 1 - 4 Exams  Unit Results<small><i class="icon-double-angle-right"></i>Enter</small></h1>
            </div>
          
            <form action="" method='POST' class='form-horizontal'>
            <input type="hidden" id="CYPID" name="CYPID" value="{{$CYPID}}" />
            <input type="hidden" id="T_ID" name="T_ID" value="{{$T_ID}}" />
            <input type="hidden" id="CDID" name="CDID" value="{{$CDID}}" />
			<input type="hidden" id="COMTCode" name="COMTCode" value="{{$COMTCode}}" />
			 <div class="control-group">
                <label class="control-label" >Version No : </label>
                <div class="controls" id="District">
                    <select name="Version" id="Version"   required>
					<option value="">--- Select Version No ---</option>
					@foreach($Verions as $a)
					<option value="{{$a->UnitVersion}}" @if($a->UnitVersion == $VersionNo) selected="true" @endif>{{$a->UnitVersion}}</option>
					@endforeach
					</select><span><font color="red"><b>*</b></font></span>
                    
                </div>         
            </div>
			
			  
                <div class="control-group">
                    <div class="controls">
                        <button type="submit"  class="btn btn-primary">
                                Show Unit List</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    </div>
                </div>   

           
			</form>
			
			@if(isset($Module))
	    <form class="form-horizontal" action='ExamSaveModuleResult' method="POST"  id='NewModule'/>
			  
			<input type="hidden" id="CYPID" name="CYPID" value="{{$CYPID}}" />
            <input type="hidden" id="T_ID" name="T_ID" value="{{$T_ID}}" />
            <input type="hidden" id="CDID" name="CDID" value="{{$CDID}}" />
			<input type="hidden" id="COMTCode" name="COMTCode" value="{{$COMTCode}}" />
			<input type="hidden" id="VersionNo" name="VersionNo" value="{{$VersionNo}}" />
			
			  
          <?php  
		  $i=1;
		  $FinalExamAssessmentNo = CourseYearPlan::where('id','=',$CYPID)->pluck('AssessmentNo');
		  ?>
            <div class="control-group">
                    <div class="controls">
            <table  id='sample-table-2' class='table table-striped table-bordered table-hover' align='center'>
                <thead>
                <tr>
               <!-- <th>Unit ID</th>-->
			    <th>No</th>
                <th>Unit Code</th>
                <th>Unit Name</th>
                <th>Enter Result</th>
            </tr>
        </thead>
        <tbody>
              @foreach($Module as $m)
            <tr>
                <input type="hidden" name="ModuleList[]" id="ModuleList[]" value="{{$m->UID}}" readonly />
				 <td>{{$i++}}</td>
                <td >{{$m->UnitCode}}</td>
                <td class='left'>{{$m->UnitName}}</td>
                <td>
                         <?php

                    $resultModule =  NVQStudentUnitResult::GetUnitResult($T_ID,$m->UID,$FinalExamAssessmentNo);

                    ?>
                    <select name="ResultList[]" id="ResultList[]" required>
                <!-- <option value="0">--Select Result--</option>-->
                @if($resultModule == 'C')
                    <option value="C" selected>C</option>
                    <option value="N">N</option>
                    <option value="A">A</option>
                @elseif($resultModule == 'N')
                    <option value="C">C</option>
                    <option value="N" selected>N</option>
                    <option value="A">A</option>

                @elseif($resultModule == 'A')
                    <option value="C">C</option>
                    <option value="N">N</option>
                    <option value="A" selected>A</option>
                
                @else
                    <option value="">--- Select Result ---</option>
                    <option value="C">C</option>
                    <option value="N">N</option>
                    <option value="A">A</option>
                @endif
                </select>

                </td>
            </tr>
            @endforeach
            
        </tbody>
        </table>
		</div>
      </div>
         
           <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-block btn-success">Save Results</button>
                </div>
            </div> 
            
         @endif 
           
         
           
           

                       

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
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


      
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

$('#AssessorInstitute').change(function(){

        //alert('dg');
       var AssessorInstitute = document.getElementById('AssessorInstitute').value; 
       var CSID = document.getElementById('CSID').value; 
       var msg = '--- Select Assessor 1 ---';
        $("#Assessor1").html('');
       $.ajax  ({
                    url: "{{url::to('LoadAssessors1')}}",
                    data: { AssessorInstitute: AssessorInstitute,CSID: CSID},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Assessor1").append("<option value=''>" + msg + "</option>");
                         $("#Assessor2").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Assessor1").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");
                            $("#Assessor2").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");




                        });
                                        
                        
                        }


                    
                });
        


       
    });

$('#CSID').change(function(){

       // alert('dg');
       var CSID = document.getElementById('CSID').value; 
       
       var msg = '--- Select Trainee  ---';
        $("#Traineeid").html('');
       $.ajax  ({
                    url: "{{url::to('TEMPLoadTraineeList')}}",
                    data: { CSID: CSID},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Traineeid").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Traineeid").append("<option value=" + item.T_ID + ">" + item.FullName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
  
  $('#Compstandard').change(function(){

       // alert('dg');
       var Compstandard = document.getElementById('Compstandard').value; 
        var CSID = document.getElementById('CSID').value; 
       
       var msg = '--- Select Unit  ---';
        $("#Unitid").html('');
       $.ajax  ({
                    url: "{{url::to('TEMPgetUnits')}}",
                    data: { Compstandard: Compstandard,CSID: CSID},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Unitid").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Unitid").append("<option value=" + item.id + ">" + item.name + "(" +item.code+ ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
    </script>


