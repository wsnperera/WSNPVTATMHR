@include('includes.bar')       
<a href={{url('ViewHROLMedium')}}> << Back to O/L & A/L Medium</a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
 O/L & A/L Medium	
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateHROLMedium')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Medium Added Successfully 
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
                               Medium Already Exist!!!!!! 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    
	 <div class="control-group">
                    <label class="control-label">Medium:</label>
                    <div class="controls">
                        <input id="Medium" name="Medium" type="text" required="true">
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





