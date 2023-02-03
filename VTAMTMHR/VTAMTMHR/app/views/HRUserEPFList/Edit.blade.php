@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewHRUserEPFList')}}> << Back to User EPF List</a> 
<h1>
   User EPF No List	
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditHRUserEPFList')}}" method="POST"/>
<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />

				
				<div class="control-group">
                    <label class="control-label">User :</label>
                    <div class="controls">
                       <select name="UserID" id="UserID" required >
					   <option value="">--- Select User ---</option>
					   @foreach($Users as $u)
					   <option @if($u->userID == $quorg->UserID) selected="true" @endif value="{{$u->userID}}">{{$u->userName}} - {{$u->Initials}} {{$u->LastName}}</option>
					   @endforeach
					   </select>
                    </div>
     </div>
	  <div class="control-group">
                    <label class="control-label">EPF No :</label>
                    <div class="controls">
                       <input type="text" name="EPFNo" id="EPFNo" value="{{$quorg->EPFNo}}" required/>
					   
                    </div>
     </div>
	  <div class="control-group">
                    <label class="control-label">Active :</label>
                    <div class="controls">
                       <select name="Active" id="Active" required/>
					   <option value="">--- Select ---</option>
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