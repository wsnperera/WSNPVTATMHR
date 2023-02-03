@include('includes.bar')       
<a href={{url('ViewHRQualification')}}> << Back to Qualification  </a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
   Qualification 	
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateHRQualification')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Qualification  Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    <div class="control-group">
                    <label class="control-label">Qualification Type :</label>
                    <div class="controls">
                        <select id="QType" name="QType"  required="true">
						<option value="">---Select Type---</option>
						@foreach($Qtype as $t)
						<option value="{{$t->id}}">{{$t->Type}}</option>
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
						<option value="{{$c->id}}">{{$c->QCategory}}</option>
						@endforeach
						</select>
                    </div>
                </div>
	 <div class="control-group">
                    <label class="control-label">Qualification:</label>
                    <div class="controls">
                        <textarea id="Qualification" name="Qualification"  required="true"></textarea>
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





