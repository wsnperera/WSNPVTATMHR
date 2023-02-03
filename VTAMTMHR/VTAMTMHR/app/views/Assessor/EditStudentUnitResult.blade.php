@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
              <!--  <a href={{url('')}}> << </a>-->
                <h1>Result<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>
            <form class="form-horizontal" action='SaveEditOriginalResultSheet' method="POST"  id='NewModule'/>
            @if(isset($Module))
            <input type="hidden" id="CSID" name="CSID" value="{{$CSID}}" />
           
            <input type="hidden" id="T_ID" name="T_ID" value="{{$T_ID}}" />

            @endif

            <div class="control-group">
                    <div class="controls">
              <center><table  id='sample-table-2' class='table table-striped table-bordered table-hover' align='center'>
                <thead>
                <tr>
               <!-- <th>Unit ID</th>-->
                <th>Unit Code</th>
                <th>Unit Name</th>
                <th>Enter Result</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($Module))
            @foreach($Module as $m)
            <tr>
                <input type="hidden" name="ModuleList[]" id="ModuleList[]" value="{{$m->id}}" readonly />
                <td>{{$m->code}}</td>
                <td class='center'>{{$m->name}}</td>
                <td>
                    <?php

                    $resultModule =  NVQStudentUnitResult::GetUnitResult($T_ID,$m->id,$CSID);

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
            @endif
        </tbody>
        </table>
         </center>
              
            
          
           
          </div>
      </div>
           
           

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Edit</button>
                </div>
            </div>             

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


