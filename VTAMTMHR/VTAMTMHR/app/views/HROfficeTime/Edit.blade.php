@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                 <a href={{url('ViewOfficeTimes')}}> << Back to Working Hours</a>
                <h1>Working Hours<small><i class="icon-double-angle-right"></i>Edit Cardre</small></h1>
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
                               Working Hours Edited Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
                <input type="hidden" name="id" id="id" value="{{$QID}}">
                @foreach($cc as $c)
             <div class="control-group">
                    <label class="control-label">Arrival Time:</label>
                    <div class="controls">
                        <input id="ArrivalTime" name="ArrivalTime" type="text" required="true" value="{{$c->ArrivalTime}}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Departure:</label>
                    <div class="controls">
                        <input id="Departute" name="Departute" placeholder="" type="text" required="true" value="{{$c->Departute}}"/>
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


