@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewCardreDetails')}}> << Back to Cardre</a>
                <h1>Cardre<small><i class="icon-double-angle-right"></i>Create </small></h1>
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
                               Cardre Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
             <div class="control-group">
                    <label class="control-label">Designation:</label>
                    <div class="controls">
                        <input id="DesignationName" name="DesignationName" type="text">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Designation Code:</label>
                    <div class="controls">
                        <input id="DesignationCode" name="DesignationCode" placeholder="" type="text" />
                    </div>
                </div>
				  <div class="control-group">
                    <label class="control-label">Maximum No Of Possions:</label>
                    <div class="controls">
                        <input id="maxpossition" name="maxpossition" placeholder="" type="number" />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Academic Status:</label>
                    <div class="controls">
                       
                        <select name="AcademicStatus" id="AcademicStatus">
						<option value="">--- Select Academic Status---</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
						</select>
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
                    <label class="control-label">Office Time Slot:</label>
                    <div class="controls">
                       
                        <select name="DesignationTimeslot" id="DesignationTimeslot">
						<option value="">--- Select Office Time Slot---</option>
						@foreach($OfficeTime as $o)
						<option value="{{$o->id}}">{{$o->ArrivalTime}} - {{$o->Departute}}</option>
						@endforeach
						</select>
                    </div>
                </div>

              

            <div class="control-group">
                <div class="controls">
                        <input type="button" value="Create Designation"  onclick="fillModule()" class="btn btn-small btn-primary"/>
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
		 
        var DesignationName = document.getElementById('DesignationName').value;
        var DesignationCode = document.getElementById('DesignationCode').value;
		var AcademicStatus = document.getElementById('AcademicStatus').value;
		var DesignationActive = document.getElementById('DesignationActive').value;
		var DesignationTimeslot = document.getElementById('DesignationTimeslot').value;
		var maxpossition = document.getElementById('maxpossition').value;
		
     // alert('sdf');
	 
	 if(DesignationName == '' || DesignationCode == ''  || AcademicStatus == '' || DesignationActive == '' || DesignationTimeslot == ''  || maxpossition == '')
		{
			bootbox.alert("Please Fill all the details required,Otherwise You can't enter this Cardre.....!!!!!!!");
		}
		else
		{
      
        $.ajax({    type: "GET",
                    url: "{{url::to('SaveAjaxHrEmploymentCode')}}",
                    data: {DesignationName: DesignationName, DesignationCode: DesignationCode,AcademicStatus:AcademicStatus,DesignationActive:DesignationActive,DesignationTimeslot:DesignationTimeslot,maxpossition:maxpossition},
                    dataType: 'json',
                    success: function(result) {
						
						
						bootbox.alert("Cardre Added Successfully.....!!!!!!!");
                       
                    }
                });
		}
    } 
     
      
        
    
       

   
    
   
   
    
   
  
</script>


