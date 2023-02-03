@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('')}}> << Back to Assessor View</a>
                <h1>Assessor<small><i class="icon-double-angle-right"></i>Assign</small></h1>
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

            <div id="assessorTable" class="controls">

            </div>
          
             <div class="control-group" id="DivAssessorInstitute">
                <label class="control-label">Assessor Institute:</label>
                <div class="controls" id="ASSIns">
                    <select id="AssessorInstitute" Name="AssessorInstitute">
                        <option value="">--Select Assessor Institute--</option>
                        @foreach($AssessorInstitute as $v)
                        <option value="{{$v->id}}">{{$v->InstituteName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
             <div class="control-group" id="DivAssessor1">
                <label class="control-label" >Assessor 1 : </label>
                <div class="controls" id="Ass1">
                    <select name="Assessor1" id="Assessor1">
                         <option value="">--Select Assessor 1--</option>
                       
                    </select>
                   
                </div>         
            </div>

             <div class="control-group" id="DivAssessor2">
                <label class="control-label" >Assessor 2 : </label>
                <div class="controls" id="Ass2">
                    <select name="Assessor2" id="Assessor2" >
                         <option value="">--Select Assessor 2--</option>
                       
                    </select>
                   
                </div>         
            </div>
           

            <div class="control-group" id="savebtn">
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

            $.gritter.add({title: "", text: "Assessor Renominated Successfully", class_name: "gritter-info gritter-center"});

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
                    url: "{{url::to('getRenominateCenters')}}",
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
$('#Assessor1').change(function(){

        //alert('dg');
       var Assessor1 = document.getElementById('Assessor1').value; 
       var AssessorInstitute = document.getElementById('AssessorInstitute').value; 
       var msg = '--- Select Assessor 2 ---';
        $("#Assessor2").html('');
       $.ajax  ({
                    url: "{{url::to('LoadAssessors2')}}",
                    data: { AssessorInstitute: AssessorInstitute,Assessor1: Assessor1},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Assessor2").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Assessor2").append("<option value=" + item.id + ">" + item.Name +  "," + item.Type + " - " +item.code +" (" + item.csmname + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });

$('#CSID').change(function(){

        //alert('dg');
       var CSID = document.getElementById('CSID').value; 
       
      

    $("#assessorTable").html('');
     $.ajax  ({
                    url: "{{url::to('getAssessorTable')}}",
                    data: { CSID: CSID},
                 
                    success: function(result) {
                    $('#assessorTable').html(result);

                    $.ajax  ({
                    url: "{{url::to('getAssessorCount')}}",
                    data: { CSID: CSID},
                    dataType: "json", 
                    success: function(result) {

                     //alert(result);
                     if(result == 0)
                     {
                        $("#DivAssessorInstitute").show();
                        $("#DivAssessor1").show();
                        $("#DivAssessor2").show();
                        $("#savebtn").show();
                     }
                     else if(result == 1)
                     {
                         $("#DivAssessorInstitute").show();
                        $("#DivAssessor1").show();
                        $("#DivAssessor2").hide();
                        $("#savebtn").show();
                     }
                     else if(result == 2)
                     {
                        $("#DivAssessorInstitute").hide();
                        $("#DivAssessor1").hide();
                        $("#DivAssessor2").hide();
                        $("#savebtn").hide();
                     }
                     else
                     {
                        $("#DivAssessorInstitute").hide();
                        $("#DivAssessor1").hide();
                        $("#DivAssessor2").hide();
                         $("#savebtn").hide();
                     }
                                        
                        
                        }


                    
                });
                        


                    }


                    
                });

        


       
    });
  
    </script>


