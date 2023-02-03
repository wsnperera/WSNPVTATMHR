@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewHrEmploymentCode')}}> << Back to Employment Code</a>
                <h1>Employment Code<small><i class="icon-double-angle-right"></i>Edit</small></h1>
            </div>

            <form class="form-horizontal"  action="" method="POST" id='NewModule'/>
            <div class="control-group">
                   
                    <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Employment Code Edited Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
                <input type="hidden" name="id" id="id" value="{{$QID}}">
                @foreach($cc as $c)
           <div class="control-group">
                <label class="control-label" for="CourseListCode">Designation : </label>
                <div class="controls">
                   <select id="Designation" name="Designation" required="true">
				   <option value="">---Select Designation---</option>
				   @foreach($Designations as $d)
				   <option  value="{{$d->id}}" @if($d->id == $c->HREmpcodeID) selected="true" @endif>{{$d->Designation}}</option>
				   @endforeach
				   </select>
				 <input type="button"  value="Add New Designation" class="btn btn-small btn-warning" name="NewModule" id="NewModule" onclick="addModule()" />
                </div>
            </div> 
			<div class="control-group" hidden="" id="addModule" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:460px">

                <div class="control-group">
                    <label class="control-label">Designation:</label>
                    <div class="controls">
                        <input id="DesignationName" name="DesignationName" type="text">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Designation Code:</label>
                    <div class="controls">
                        <input id="DesignationCode" name="DesignationCode" placeholder="" type="text" />
                    </div>
                </div>
				  <div class="control-group">
                    <label class="control-label">Maximum No Of Possions:</label>
                    <div class="controls">
                        <input id="maxpossition" name="maxpossition" placeholder="" type="number" />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Academic Status:</label>
                    <div class="controls">
                       
                        <select name="AcademicStatus" id="AcademicStatus">
						<option value="">--- Select Academic Status---</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
						</select>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                       
                        <select name="DesignationActive" id="DesignationActive">
						<option value="">--- Select Active Status---</option>
						<option value="1">Yes</option>
						<option value="0">No</option>
						</select>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Office Time Slot:</label>
                    <div class="controls">
                       
                        <select name="DesignationTimeslot" id="DesignationTimeslot">
						<option value="">--- Select Office Time Slot---</option>
						@foreach($OfficeTime as $o)
						<option value="{{$o->id}}">{{$o->ArrivalTime}} - {{$o->Departute}}</option>
						@endforeach
						</select>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Create Designation"  onclick="fillModule()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>
			   <div class="control-group">
                    <label class="control-label" >Service Category Year: </label>
                        <div class="controls" id="Trade">
                          <select name="SCYear" id="SCYear" required="true">
                        <option value="">--- Select Year ---</option>
						@foreach($Years as $y)
						 <option value="{{$y->Year}}" @if($y->Year == $c->SCYear) selected="true" @endif>{{$y->Year}}</option>
						 @endforeach
                       
                    </select>
                           
                        </div>         
            </div> 
            <div class="control-group">
                    <label class="control-label">Service Category:</label>
                    <div class="controls">
                       
                        <select name="ServiceCategoryID" id="ServiceCategoryID" required="true">
                        <option value="">--- Select Service Category ---</option>
						@foreach($SrviceCategoryList as $sc)
						 <option value="{{$sc->id}}" @if($sc->id == $c->HRSalaryScaleID) selected="true" @endif>{{$sc->ServiceCategory}} - [{{$sc->SalaryCode}}] - ({{$sc->SalaryScale}})</option>
						 @endforeach
						
                       
                    </select>
                    </div>
            </div>
           
            <div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                       
                        <select name="Active" id="Active" required="true">
						<option value="">--- Select Active Status---</option>
						<option value="1" @if($c->Active==1) selected="true" @endif>Yes</option>
						<option value="0" @if($c->Active==0) selected="true" @endif>No</option>
						</select>
                    </div>
            </div>
           
             
            
            

            <div class="control-group">
                <div class="controls">
                        <input type="submit" value="Save"  class="btn btn-small btn-primary"/>
                    </div>
            </div> 
            @endforeach            

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
    
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


       $("#CourseListCode").change(function() {
        var cid = $("#CourseListCode").val();
        var msg = '---Select Module---';
        $("#ModuleID").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadQuestionModuleCourse')}}",
            data: {CourseListCode: cid},
            success: function(result) {
                $("#ModuleID").append("<option value=''>" + msg + "</option>");
                $.each(result, function(i, item)
                {



                    $("#ModuleID").append("<option value=" + item.ModuleId + ">" + item.ModuleCode +  "-" + item.ModuleName + "</option>");



                });

            }
        });
    });
       $("#ModuleID").change(function() {

        var mid = $("#ModuleID").val();
       // alert(mid);
        var cid = $("#CourseListCode").val();
        var msg = '---Select Task---';
        $("#T_Code").html('');
        
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadQuestionModuleTask')}}",
            data: {ModuleId: mid,CD_ID: cid},
            dataType: 'json',
            success: function(result) {
                $("#T_Code").append("<option value=''>" + msg + "</option>");
                $.each(result, function(i, item)
                {



                    $("#T_Code").append("<option value=" + item.id + ">" + item.TaskCode +  "-" + item.TaskName + "</option>");



                });

            }
        });
    });
        
    
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
    
     function fillModule() {
		 
        var DesignationName = document.getElementById('DesignationName').value;
        var DesignationCode = document.getElementById('DesignationCode').value;
		var AcademicStatus = document.getElementById('AcademicStatus').value;
		var DesignationActive = document.getElementById('DesignationActive').value;
		var DesignationTimeslot = document.getElementById('DesignationTimeslot').value;
		var maxpossition = document.getElementById('maxpossition').value;
		
       var msg = '--- Select Designation ---';
       $("#Designation").html('');
		//$("#InstructorList1").html('');
        $.ajax({    type: "GET",
                    url: "{{url::to('SaveAjaxHrEmploymentCode')}}",
                    data: {DesignationName: DesignationName, DesignationCode: DesignationCode,AcademicStatus:AcademicStatus,DesignationActive:DesignationActive,DesignationTimeslot:DesignationTimeslot,maxpossition:maxpossition},
                    dataType: 'json',
                    success: function(result) {
						
						 $("#Designation").append("<option value=''>" + msg + "</option>");
				        
                         $.each(result, function(i, item)
                        {

                              $("#Designation").append("<option value=" + item.id + ">" + item.Designation + "</option>");

                        });
						$('#addModule').hide();
						bootbox.alert("Designation Added Successfully.....!!!!!!!");
                       
                    }
                });
    }   

   
    
   $("#SCYear").change(function() {
        var SCYear = $("#SCYear").val();
        var msg = '---Select Service Category---';
		//var All = 'All';
        $("#ServiceCategoryID").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadAjaxServiceCategoryYear')}}",
            data: {SCYear: SCYear},
            success: function(result) {
                $("#ServiceCategoryID").append("<option value=''>" + msg + "</option>");
				
                $.each(result, function(i, item)
                {



                    $("#ServiceCategoryID").append("<option value=" + item.id + ">" + item.ServiceCategory +  " [" + item.SalaryCode + "] -(" + item.SalaryScale+ ")</option>");



                });

            }
        });
    });   

   
    
   
   
    
   
  
</script>


