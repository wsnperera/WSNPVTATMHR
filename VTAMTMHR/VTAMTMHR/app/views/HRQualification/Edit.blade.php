@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewHRQualification')}}> << Back to Qualification  </a> 
<h1>

Qualification 		
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditHRQualification')}}" method="POST"/>
<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />

				
				<div class="control-group">
                    <label class="control-label">Qualification Type :</label>
                    <div class="controls">
                        <select id="QType" name="QType"  required="true">
						<option value="">---Select Type---</option>
						@foreach($Qtype as $t)
						<option value="{{$t->id}}" @if($t->id == $quorg->QualificationTypeID) selected="true" @endif>{{$t->Type}}</option>
						@endforeach
						</select>
                    </div>
                </div>
				 <div class="control-group">
                    <label class="control-label">Qualification Category :</label>
                    <div class="controls">
                        <select id="QCategory" name="QCategory"  required="true">
						<option value="">---Select Category---</option>
						@foreach($QCategory as $c)
						<option value="{{$c->id}}" @if($c->id == $quorg->QualificationCategoryID) selected="true" @endif>{{$c->QCategory}}</option>
						@endforeach
						</select>
                    </div>
                </div>
	 <div class="control-group">
                    <label class="control-label">Qualification:</label>
                    <div class="controls">
                        <textarea id="Qualification" name="Qualification"  required="true">{{$quorg->Qualification}}</textarea>
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