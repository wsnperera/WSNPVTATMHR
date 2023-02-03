@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewHrServiceCategory')}}> << Back to Service Category</a>
                <h1>Cardre<small><i class="icon-double-angle-right"></i>Edit Cardre</small></h1>
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
                               Cardre Edited Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
                <input type="hidden" name="id" id="id" value="{{$QID}}">
                @foreach($cc as $c)
             <div class="control-group">
                    <label class="control-label">Designation:</label>
                    <div class="controls">
                        <input id="DesignationName" name="DesignationName" type="text" value="{{$c->Designation}}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Designation Code:</label>
                    <div class="controls">
                        <input id="DesignationCode" name="DesignationCode" placeholder="" type="text" value="{{$c->DesignationCode}}"/>
                    </div>
                </div>
				  <div class="control-group">
                    <label class="control-label">Maximum No Of Possions:</label>
                    <div class="controls">
                        <input id="maxpossition" name="maxpossition" placeholder="" type="number" value="{{$c->MaxNoOPossitions}}"/>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Academic Status:</label>
                    <div class="controls">
                       
                        <select name="AcademicStatus" id="AcademicStatus">
						<option value="">--- Select Academic Status---</option>
						<option value="Yes" @if($c->Academic=='Yes') selected="true" @endif>Yes</option>
						<option value="No" @if($c->Academic=='No') selected="true" @endif>No</option>
						</select>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                       
                        <select name="DesignationActive" id="DesignationActive">
						
						<option value="">--- Select Active Status---</option>
						<option value="1" @if($c->Active==1) selected="true" @endif>Yes</option>
						<option value="0" @if($c->Active==0) selected="true" @endif>No</option>
						</select>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Office Time Slot:</label>
                    <div class="controls">
                       
                        <select name="DesignationTimeslot" id="DesignationTimeslot">
						<option value="">--- Select Office Time Slot---</option>
						@foreach($OfficeTime as $o)
						<option value="{{$o->id}}" @if($c->HROfficeTimeID== $o->id) selected="true" @endif>{{$o->ArrivalTime}} - {{$o->Departute}}</option>
						@endforeach
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
        
    
       

   
    
   
   
    
   
  
</script>


