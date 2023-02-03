@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewOfficeTimes')}}> << Back to Working Hours</a>
                <h1>Working Hours<small><i class="icon-double-angle-right"></i>Create </small></h1>
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
                               Working Hours Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
             <div class="control-group">
                    <label class="control-label">Arrival Time:</label>
                    <div class="controls">
                        <input id="ArrivalTime" name="ArrivalTime" type="text" required="true">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Departure:</label>
                    <div class="controls">
                        <input id="Departute" name="Departute" placeholder="" type="text" required="true"/>
                    </div>
                </div>
				 
				<div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                       
                        <select name="DesignationActive" id="DesignationActive">
						<option value="">--- Select Active Status---</option>
						<option value="1">Yes</option>
						<option value="0">No</option>
						</select>
                    </div>
                </div>
				

              

            <div class="control-group">
                <div class="controls">
                        <input type="button" value="Create Working Hours"  onclick="fillModule()" class="btn btn-small btn-primary"/>
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

    $('#saveme').click(function()
    {
      
        var Year = $("#Year").val();
		var ServiceCategory = $("#ServiceCategory").val();
		var SalaryCode = $("#SalaryCode").val();
		var SalaryScale = $("#SalaryScale").val();
		var Active = $("#Active").val();
		
		
		if(Year == '' || ServiceCategory == ''  || SalaryCode == '' || SalaryScale == '' || Active == '')
		{
			bootbox.alert("Please Fill all the details required,Otherwise You can't enter this Service Category.....!!!!!!!");
		}
		else
		{
			 $.ajax({
		   
		   beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
            type: "POST",
            url: "{{url::to('ServiceCategorySaveAll')}}",
            data: {Year: Year,ServiceCategory: ServiceCategory,SalaryCode: SalaryCode,SalaryScale: SalaryScale,Active: Active},
            dataType: 'json',
            success: function(result) {

                
				document.getElementById('ServiceCategory').value = '';
				document.getElementById('SalaryCode').value = '';
				document.getElementById('SalaryScale').value = '';
				
				
				$('#msg').html(result.done);
               

            },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
            });
		}
		
       //alert(CD_ID);
      
 
        
    });
	
	 function fillModule() {
		 
        var ArrivalTime = document.getElementById('ArrivalTime').value;
        var Departute = document.getElementById('Departute').value;
		
		var DesignationActive = document.getElementById('DesignationActive').value;
		
		
     // alert('sdf');
	 
	 if(ArrivalTime == '' || Departute == ''  || DesignationActive == '' )
		{
			bootbox.alert("Please Fill all the details required,Otherwise You can't enter this Working Hours.....!!!!!!!");
		}
		else
		{
      
        $.ajax({    type: "GET",
                    url: "{{url::to('SaveAjaxtOfficeTimes')}}",
                    data: {ArrivalTime: ArrivalTime, Departute: Departute,DesignationActive:DesignationActive},
                    dataType: 'json',
                    success: function(result) {
						
						
						bootbox.alert("Working Hours Added Successfully.....!!!!!!!");
                       
                    }
                });
		}
    } 
     
      
        
    
       

   
    
   
   
    
   
  
</script>


