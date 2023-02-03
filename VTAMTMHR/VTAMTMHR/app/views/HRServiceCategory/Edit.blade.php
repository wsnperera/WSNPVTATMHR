@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewHrServiceCategory')}}> << Back to Service Category</a>
                <h1>Service Category<small><i class="icon-double-angle-right"></i>Edit Service Category</small></h1>
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
                               Service Category Edited Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
                <input type="hidden" name="id" id="id" value="{{$QID}}">
                @foreach($cc as $c)
            <div class="control-group">
                <label class="control-label" for="CourseListCode">Year : </label>
                <div class="controls">
				<input type="Text" name="Year" id="Year" required="true" value="{{$c->Year}}"/>
                   
                </div>
            </div> 
			<div class="control-group">
                    <label class="control-label" >Service Category: </label>
                        <div class="controls" id="Trade">
                            <textarea name="ServiceCategory" id="ServiceCategory" required="true">{{$c->ServiceCategory}}</textarea> 
                           
                        </div>         
            </div> 
            <div class="control-group">
                    <label class="control-label">Salary Code:</label>
                    <div class="controls">
                       
                        <textarea id="SalaryCode" name="SalaryCode" type="text" required>{{$c->SalaryCode}}</textarea>
                    </div>
            </div>
             <div class="control-group">
                    <label class="control-label">Salary Scale:</label>
                    <div class="controls">
                       
                        <textarea id="SalaryScale" name="SalaryScale" type="text" required>{{$c->SalaryScale}}</textarea>
                    </div>
            </div>
			 <div class="control-group">
                    <label class="control-label">Grades Available:</label>
                    <div class="controls">
                     <label>
                     @foreach($gradesList as $g)
					
					 <?php 
					$checked11 = HRSalaryScaleGrade::where('Deleted','=',0)->where('ServiceCategoryID','=',$c->id)->where('Active','=',1)->where('GradeID','=',$g->id)->count();				 
					 ?>
					  <input class="ids" name="ids[]" value="{{$g->id}}" type="checkbox" @if($checked11 != 0) checked="true"  @endif />
                        <span class="lbl">&nbsp;&nbsp;&nbsp;{{$g->Grade}}</span><br/>
					
					 @endforeach
                    </label>
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
        
    
       

   
    
   
   
    
   
  
</script>


