@include('includes.bar')       
<a href={{url('ViewHRUserEPFList')}}> << Back to User EPF List</a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
   User EPF No List		
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateHRUserEPFList')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               User EPF Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    
	 <div class="control-group">
                    <label class="control-label">User :</label>
                    <div class="controls">
                       <select name="UserID" id="UserID" required >
					   <option value="">--- Select User ---</option>
					   @foreach($Users as $u)
					   <option value="{{$u->userID}}">{{$u->userName}} - {{$u->Initials}} {{$u->LastName}}</option>
					   @endforeach
					   </select>
                    </div>
     </div>
	  <div class="control-group">
                    <label class="control-label">EPF No :</label>
                    <div class="controls">
                       <input type="text" name="EPFNo" id="EPFNo" required />
					   
                    </div>
     </div>
	  <div class="control-group">
                    <label class="control-label">Active :</label>
                    <div class="controls">
                       <select name="Active" id="Active" required/>
					   <option value="">--- Select ---</option>
					   <option value="1">Yes</option>
					    <option value="0">No</option>
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





