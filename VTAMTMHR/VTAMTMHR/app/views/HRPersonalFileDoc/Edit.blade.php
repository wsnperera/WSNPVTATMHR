@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewHRPersonalFileDoc')}}> << Back to HR - Personal File Document</a> 
<h1>
 Personal File Document	
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditHRPersonalFileDoc')}}" method="POST"/>
<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />

				
				<div class="control-group">
                    <label class="control-label">Document Name:</label>
                    <div class="controls">
                        <input id="DocumentName" name="DocumentName" value="{{$quorg->DocumentName}}" type="text" required="true">
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                        <select id="Active" name="Active"  required="true">
						<option value="">---Select Active Status---</option>
						<option value="1" @if($quorg->Active == 1) selected="true" @endif>Yes</option>
						<option value="0" @if($quorg->Active == 0) selected="true" @endif>No</option>
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