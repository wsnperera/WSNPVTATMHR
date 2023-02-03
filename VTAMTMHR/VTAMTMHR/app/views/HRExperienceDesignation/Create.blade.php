@include('includes.bar')       
<a href={{url('ViewHRExperienceDesignation')}}> << Back to Experience Designation </a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
   Designation		
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateHRExperienceDesignation')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Designation Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    
	 <div class="control-group">
                    <label class="control-label">Company Name:</label>
                    <div class="controls">
                        <input id="Designation" name="Designation" type="text" required="true">
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





