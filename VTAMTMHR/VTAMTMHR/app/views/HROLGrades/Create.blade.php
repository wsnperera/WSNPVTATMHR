@include('includes.bar')       
<a href={{url('ViewHROLGrades')}}> << Back to O/L & A/L Grades</a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
 O/L & A/L Grades	
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateHROLGrades')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Grades Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
					 @if(Session::has('Exist'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Grades Already Exist!!!!!! 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    
				<div class="control-group">
                    <label class="control-label">Grade:</label>
                    <div class="controls">
                        <input id="Grade" name="Grade" type="text" required="true">
                    </div>
                </div>
					<div class="control-group">
                    <label class="control-label">Grade Name:</label>
                    <div class="controls">
                        <input id="GradeName" name="GradeName" type="text" required="true">
                    </div>
                </div>
				
				 <div class="control-group">
                    <label class="control-label">Pass/Fail Status:</label>
                    <div class="controls">
                        <select id="PassStatus" name="PassStatus"  required="true">
						<option value="">---Select Status---</option>
						<option value="1">Pass</option>
						<option value="0">Fail</option>
						</select>
                    </div>
                </div>
     
  
<div class="controls">
    <input type="submit" class="btn btn-small btn-primary"  value="Save" />
</div>
</form>
    <!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
    @if($errors->has())
        @foreach($errors->all() as $msg)
         <!-- Error Message -->

         <div class="alert alert-error">

         <button type="button" class="close" data-dismiss="alert">
          <i class="icon-remove"></i>
            </button>

             <strong> <i class="icon-remove"></i>{{$msg}}</strong>

              </div>

                 <!-- Error Message -->

          @endforeach

           @endif
</div>
</div><!--/.row-fluid-->
</div><!--/.page-content-->


@include('includes.footer')   





