@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewKPISchedule')}}> << Back to KPI Schedules</a>
                <h1>KPI Schedule<small><i class="icon-double-angle-right"></i>Edit Schedule</small></h1>
            </div>

            <form class="form-horizontal"  action="" method="POST" id='NewModule'/>
            <div class="control-group">
                   
                    <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               KPI Schedule Edited Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
                <input type="hidden" name="id" id="id" value="{{$QID}}">
                @foreach($cc as $c)
				
				 <div class="control-group">
                    <label class="control-label">Year:</label>
                    <div class="controls">
                        <input id="Year" name="Year" type="text" required="true" value="{{$c->Year}}"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Quater:</label>
                    <div class="controls">
                       <select name="Quater" id="Quater" required="true">
						<option value="">--- Select Quater---</option>
						<option value="1" @if($c->Quater ==1) Selected="true" @endif>1</option>
						<option value="2" @if($c->Quater ==2) Selected="true" @endif>2</option>
						<option value="3" @if($c->Quater ==3) Selected="true" @endif>3</option>
						<option value="4" @if($c->Quater ==4) Selected="true" @endif>4</option>
						</select>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Description:</label>
                    <div class="controls">
                        <textarea id="Description" name="Description" required="true" >{{$c->Description}}</textarea>
                    </div>
                </div>
				 <div class="control-group">
                    <label class="control-label">Submission Date:</label>
                    <div class="controls">
                        <input id="SubmissionDate" name="SubmissionDate" type="date" required="true" value="{{$c->SubmissionDate}}"/>
                    </div>
                </div>
             
				
            <div class="control-group">
                <div class="controls">
                        <input type="submit" value="Edit"  class="btn btn-small btn-primary"/>
                    </div>
            </div> 
            @endforeach            

            </form>
            <!--Write your code here end-->
            <!--PAGE CONTENT ENDS-->
       
    
             </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script>

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif


  
        
    
       

   
    
   
   
    
   
  
</script>


