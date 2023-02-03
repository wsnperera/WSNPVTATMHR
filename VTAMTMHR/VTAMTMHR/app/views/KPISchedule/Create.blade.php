@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewKPISchedule')}}> << Back to KPI Schedules</a>
                <h1>KPI Schedule<small><i class="icon-double-angle-right"></i>Create </small></h1>
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
                               Schedule Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
             <div class="control-group">
                    <label class="control-label">Year:</label>
                    <div class="controls">
                        <input id="Year" name="Year" type="text" required="true">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Quater:</label>
                    <div class="controls">
                       <select name="Quater" id="Quater" required="true">
						<option value="">--- Select Quater---</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						</select>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Description:</label>
                    <div class="controls">
                        <textarea id="Description" name="Description" required="true"></textarea>
                    </div>
                </div>
				 <div class="control-group">
                    <label class="control-label">Submission Date:</label>
                    <div class="controls">
                        <input id="SubmissionDate" name="SubmissionDate" type="date" required="true">
                    </div>
                </div>
				
				

              

            <div class="control-group">
                <div class="controls">
                        <input type="button" value="Create Schedule"  onclick="fillModule()" class="btn btn-small btn-primary"/>
                    </div>
            </div>  
        <div class="control-group">
                <div class="controls" id="msg">
                       
                 </div>
            </div>  			

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

   
	
	 function fillModule() {
		 
        var Quater = document.getElementById('Quater').value;
        var Year = document.getElementById('Year').value;
		
		var Description = document.getElementById('Description').value;
		var SubmissionDate = document.getElementById('SubmissionDate').value;
		
		
     // alert('sdf');
	 
	 if(Quater == '' || Year == ''  || Description == '' || SubmissionDate == '')
		{
			bootbox.alert("Please Fill all the details required,Otherwise You can't Create the Schedule.....!!!!!!!");
		}
		else
		{
      
        $.ajax({    type: "GET",
                    url: "{{url::to('SaveAjaxKPISchedule')}}",
                    data: {Quater: Quater, Year: Year,Description:Description,SubmissionDate: SubmissionDate},
                    dataType: 'json',
                    success: function(result) {
						
						if(result == 1)
						{
						
						bootbox.alert("Schedule Added Successfully.....!!!!!!!");
						}
						else if(result == 2)
						{
						
						bootbox.alert("Untill You End the previous Schedules,you can't create the new schedules.....!!!!!!!");
						}
						else{
					    bootbox.alert("Schedule Already Available.....!!!!!!!");

						}
						
						document.getElementById('Year').value = '';
						document.getElementById('Quater').value = '';
						document.getElementById('Description').value = '';
						document.getElementById('SubmissionDate').value = '';
						
                       
                    }
                });
		}
    } 
     
      
        
    
       

   
    
   
   
    
   
  
</script>


