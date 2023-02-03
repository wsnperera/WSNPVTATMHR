@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewHROLGrades')}}> << Back to O/L & A/L Grades</a> 
<h1>
O/L & A/L Grades		
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditHROLGrades')}}" method="POST"/>
<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />
 <div class="control-group">
                    <label class="control-label">Grade:</label>
                    <div class="controls">
                        <textarea id="Grade" name="Grade" required="true" >{{$quorg->Grade}} </textarea>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Grade Name:</label>
                    <div class="controls">
                        <input id="GradeName" name="GradeName" type="text" value="{{$quorg->GradeName}}" required="true">
                    </div>
                </div>
				 <div class="control-group">
                    <label class="control-label">Pass/Fail Status:</label>
                    <div class="controls">
                        <select id="PassStatus" name="PassStatus"  required="true">
						<option value="">---Select Status---</option>
						<option value="1" @if($quorg->PassStatus == 1) selected="true" @endif>Pass</option>
						<option value="0" @if($quorg->PassStatus == 0) selected="true" @endif>Fail</option>
						</select>
                    </div>
                </div>
     
				<div class="control-group">
				 <div class="controls">
				<input class="btn btn-small btn-warning" type="submit"  value="Update" />
				 </div>
				</div>

</div>

</form>
<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
     @if ($errors->has())
@foreach ($errors->all() as $error)
    <div class='bg-danger alert'>{{ $error }}</div>
@endforeach
@endif
</div>
</div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script type="text/javascript">
    
  

    
</script>