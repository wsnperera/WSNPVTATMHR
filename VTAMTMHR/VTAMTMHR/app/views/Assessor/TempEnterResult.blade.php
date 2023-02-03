@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('')}}> << </a>
                <h1>Result<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"  id='NewModule'/>
              <div class="control-group">
                <label class="control-label" >District : </label>
                <div class="controls" id="District">
                    <select name="districtcode" id="districtcode">
                         <option value="">--Select district--</option>
                        @foreach($district as $v)
                        <option value="{{$v->DistrictCode}}">{{$v->DistrictName}}</option>
                        @endforeach
                    </select>
                   
                </div>         
            </div>
              <div class="control-group">
                <label class="control-label" >Center : </label>
                <div class="controls" id="District">
                    <select name="CenterId" id="CenterId" required>
                         <option value="">--Select district--</option>
                       
                    </select>
                   
                </div>         
            </div>
              <div class="control-group">
                <label class="control-label" >Course : </label>
                <div class="controls" id="Course">
                    <select name="CSID" id="CSID" required>
                         <option value="">--Select Course--</option>
                       
                    </select>
                   
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
                <label class="control-label">Trade:</label>
                <div class="controls" id="ASSIns">
                    <select id="Compstandard" Name="Compstandard" >
                        <option value="">--Select Trade--</option>
                        @foreach($Compstandard as $v)
                        <option value="{{$v->code}}">{{$v->name}} - {{$v->code}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
             <div class="control-group">
                <label class="control-label" >Unit : </label>
                <div class="controls" id="Unitlist">
                    <select name="Unitid" id="Unitid" required>
                         <option value="">--Select Unit--</option>
                       
                    </select>
                   
                </div>         
            </div>
             <div class="control-group">
                <label class="control-label" >Result : </label>
                <div class="controls" id="Ass1">
                    <select name="Result" id="Result" required>
                         <option value="">--Select Result--</option>
                          <option value="N">N</option>
                           <option value="C">C</option>
                       
                    </select>
                   
                </div>         
            </div>

           
           

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-small btn-primary">Save</button>
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


