@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewHREmployeeType')}}> << Back to Employee Types</a> 
<h1>
 Employee Types	
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditHREmployeeType')}}" method="POST"/>
<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />
 <div class="control-group">
                    <label class="control-label">Employee Type:</label>
                    <div class="controls">
                        <textarea id="OrgaName" name="OrgaName" required="true" >{{$quorg->EmployeeType}} </textarea>
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