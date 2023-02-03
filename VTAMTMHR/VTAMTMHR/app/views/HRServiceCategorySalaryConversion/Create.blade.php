@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<!--ace styles-->

<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewHrServiceCategorySalaryConversion')}}> << Back to View</a>
                <h1>Service Category Wise Salary Conversions<small><i class="icon-double-angle-right"></i>Create Salary Conversions</small></h1>
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
                               Service Category Salary Conversion Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
           <div class="control-group">
                <label class="control-label" for="Year">Service Category Year : </label>
                <div class="controls">
                    <select name="SCYear" id="SCYear" required="true">
                        <option value="">--- Select Year ---</option>
						@foreach($Years as $y)
						 <option value="{{$y->Year}}">{{$y->Year}}</option>
						 @endforeach
                       
                    </select><b style="color: red">*</b>
			
                </div>
            </div> 
           <div class="control-group">
                <label class="control-label" for="form-field-10">Service Category</label>
                <div class="controls">
                  <select name="ServiceCategoryID" id='ServiceCategoryID' required="true">
				  <option value="">---Select Service Category---</option>
				  @foreach($SCList as $scl)
				  <option  value="{{$scl->id}}">{{$scl->ServiceCategory}} - [{{$scl->SalaryCode}}] - {{$scl->SalaryScale}}</option>
                  @endforeach
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-10">Grade</label>
                <div class="controls">
                    
					<select name="Grade" id='Grade' required="true" >
					 <option value="">---Select Grade---</option>
                       @foreach($GList as $gl)
				  <option value="{{$gl->id}}">{{$gl->Grade}}</option>
                        @endforeach 
                    </select>
                  <b style="color: red">*</b>
                </div>
            </div>
          
			<div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Salary Step</label>
                <div class="controls">
                    <select name="SalaryStepAuto"  id='SalaryStepAuto' required="true">
					
					</select><b style="color: red">*</b>
                </div>
            </div>
                  
          <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Salary Conversion Date</label>
                <div class="controls">
                    <input type="date" name="SalaryConversionDate"  id='SalaryConversionDate' required="true">
					
					<b style="color: red">*</b>
                </div>
           </div>
			  
           <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Basic Salary</label>
                <div class="controls">
                    <input type="text" name="BasicSalary"  id='BasicSalary' required="true"/>
					
					<b style="color: red">* </b><b style="color: green">Eg: 13260</b>
                </div>
           </div>
		   <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Gross Salary</label>
                <div class="controls">
                    <input type="text" name="GrossSalary"  id='GrossSalary' />
					
					<b style="color: red"> </b><b style="color: green">Eg: 29653</b>
                </div>
           </div>
		   <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Adjusment Allowence</label>
                <div class="controls">
                    <input type="text" name="Allowence"  id='Allowence' />
					
					<b style="color: green">Eg: 9630</b>
                </div>
           </div>
			  
			
            <div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                       
                        <select name="Active" id="Active" required="true">
						<option value="">--- Select Active Status---</option>
						<option value="1" selected>Yes</option>
						<option value="0">No</option>
						</select><b style="color: red">*</b>
                    </div>
            </div>
          
            

            <div class="control-group">
                <div class="controls">
                        <input type="button" value="Save"  id="saveme" class="btn btn-small btn-pink"/> <span id='img4'></span>
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
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">

    @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
	
	
 $("#SCYear").change(function() {
        var cid = $("#SCYear").val();
        var msg = '---Select Service Category---';
		//var All = 'All';
        $("#ServiceCategoryID").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadAjaxServiceCategoryYear')}}",
            data: {SCYear: cid},
            success: function(result) {
                $("#ServiceCategoryID").append("<option value=''>" + msg + "</option>");
			
                $.each(result, function(i, item)
                {



                   $("#ServiceCategoryID").append("<option value=" + item.id + ">" + item.ServiceCategory +  " [" + item.SalaryCode + "] -(" + item.SalaryScale+ ")</option>");



                });

            }
        });
    });
	
	$("#ServiceCategoryID").change(function() 
	{
        var cid = $("#ServiceCategoryID").val();
        var msg = '---Select Grade---';
		var msgstep = '---Select salary step---';
		//var All = 'All';
        $("#Grade").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadAjaxServiceCategoryGrade')}}",
            data: {SCYear: cid},
            success: function(result) {
                $("#Grade").append("<option value=''>" + msg + "</option>");
			
                $.each(result, function(i, item)
                {



                   $("#Grade").append("<option value=" + item.id + ">" + item.Grade +  "</option>");



                });
				
				//
					$.ajax({
					type: "GET",
					url: "{{url::to('getSalaryScaleValue')}}",
					data: {SCYear: cid},
					dataType: 'json',
					success: function(result) {
						
						var year  = $("#SCYear").val();
						$("#SalaryStepAuto").html('');
						
												$.ajax({
												type: "GET",
												url: "{{url::to('LoadAjaxServiceCategorySteps')}}",
												data: {ServicecategoryID: cid,year:year},
												success: function(result) {
													 $("#SalaryStepAuto").append("<option value=''>" + msgstep + "</option>");
			
													
													$.each(result, function(i, item)
													{


														if(item.EBAvailable == 1)
														{
															$("#SalaryStepAuto").append("<option value=" + item.id + ">" + item.StepNo + " - " + item.StepAmount+  "(EB Available)</option>");
														}
														else
														{
															$("#SalaryStepAuto").append("<option value=" + item.id + ">" + item.StepNo + " - " + item.StepAmount+ "</option>");
														}
													   



													});
													
													
													
													
													
												}
															
															
												});
												
												
												
						
						
					}
					});
				
				//
				

            }
        });
    });
	
    $('#saveme').click(function()
    {
        
        var Year = $("#SCYear").val();
		var ServiceCategory = $("#ServiceCategoryID").val();
		var Grade = $("#Grade").val();
		var SalaryStepAuto = $("#SalaryStepAuto").val();
		var SalaryConversionDate = $("#SalaryConversionDate").val();
		var BasicSalary = $("#BasicSalary").val();
		var Active = $("#Active").val();
		var Allowence = $("#Allowence").val();
		var GrossSalary = $("#GrossSalary").val();
		if(Year == '' || ServiceCategory == ''  || Grade == '' || SalaryStepAuto == '' || Active == '' || BasicSalary == '' || SalaryConversionDate == '')
		{
			bootbox.alert("Please Fill all the details required,Otherwise You can't enter this Service Category Salary Conversions.....!!!!!!!");
		}
		else
		{
			 $.ajax({
		   
		   beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
            type: "POST",
            url: "{{url::to('ServiceCategorySalaryConversionSaveAll')}}",
            data: {Year: Year,ServiceCategory : ServiceCategory,Grade: Grade,SalaryStepAuto: SalaryStepAuto,Active: Active,SalaryConversionDate: SalaryConversionDate,Allowence: Allowence,BasicSalary: BasicSalary,GrossSalary:GrossSalary},
            dataType: 'json',
            success: function(result) {

                //document.getElementById('SalaryStepAuto').value = '';
				document.getElementById('BasicSalary').value = '';
				document.getElementById('Allowence').value = '';
				document.getElementById('GrossSalary').value = '';
				$('#msg').html(result.done);
               },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
            });
		}
		
       //alert(CD_ID);
      
 
        
    });
     
      
        
    
       

   
    
   
   
    
   
  
</script>


