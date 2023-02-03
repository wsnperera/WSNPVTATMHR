@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewHrServiceCategorySalaryConversion')}}> << Back to View</a>
            <h1>Service Category Wise Salary Conversions<small><i class="icon-double-angle-right"></i>Edit Salary Conversions</small></h1>
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
                               Service Category Edited Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div>
                <input type="hidden" name="id" id="id" value="{{$QID}}">
              
				
            <div class="control-group">
                <label class="control-label" for="Year">Service Category Year : </label>
                <div class="controls">
                    <select name="SCYear" id="SCYear" required="true">
                        <option value="">--- Select Year ---</option>
						@foreach($Years as $y)
						 <option value="{{$y->Year}}" @if($y->Year == $cc->SCYear) selected="true" @endif>{{$y->Year}}</option>
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
				  <option  value="{{$scl->id}}" @if($scl->id == $cc->ServiceCategoryID) selected="true" @endif>{{$scl->ServiceCategory}} - [{{$scl->SalaryCode}}] - {{$scl->SalaryScale}}</option>
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
				  <option value="{{$gl->id}}" @if($gl->id == $cc->GradeId) selected="true" @endif>{{$gl->Grade}}</option>
                        @endforeach 
                    </select>
                  <b style="color: red">*</b>
                </div>
            </div>
          
			<div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Salary Step</label>
                <div class="controls">
                    <select name="SalaryStepAuto"  id='SalaryStepAuto' required="true">
					<option value="">---Select Step---</option>
                       @foreach($SalStep as $sl)
				  <option value="{{$sl->id}}" @if($sl->id == $cc->StepTransID) selected="true" @endif>{{$sl->StepNo}} - {{$sl->StepAmount}}</option>
                        @endforeach 
					</select><b style="color: red">*</b>
                </div>
            </div>
                  
          <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Salary Conversion Date</label>
                <div class="controls">
                    <input type="date" name="SalaryConversionDate"  id='SalaryConversionDate' value="{{$cc->SalaryConversionDate}}" required="true">
					
					<b style="color: red">*</b>
                </div>
           </div>
			  
           <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Basic Salary</label>
                <div class="controls">
                    <input type="text" name="BasicSalary"  value="{{$cc->BasicSalary}}" id='BasicSalary' required="true" />
					
					<b style="color: red">* </b><b style="color: green">Eg: 13260</b>
                </div>
           </div>
		    <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Gross Salary</label>
                <div class="controls">
                    <input type="text" name="GrossSalary"  value="{{$cc->GrossSalary}}" id='GrossSalary' />
					
					<b style="color: red">* </b><b style="color: green">Eg: 29653</b>
                </div>
           </div>
		   <div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Adjusment Allowence</label>
                <div class="controls">
                    <input type="text" name="Allowence"  id='Allowence' value="{{$cc->AdjusmentAllowence}}" />
					
					<b style="color: green">Eg: 9630</b>
                </div>
           </div>
            <div class="control-group">
                    <label class="control-label">Active Status:</label>
                    <div class="controls">
                       
                        <select name="Active" id="Active" required="true">
						<option value="">--- Select Active Status---</option>
						<option value="1" @if($cc->Active==1) selected="true" @endif>Yes</option>
						<option value="0" @if($cc->Active==0) selected="true" @endif>No</option>
						</select>
                    </div>
            </div>
           
             
            
            

            <div class="control-group">
                <div class="controls">
                        <input type="submit" value="Update"  class="btn btn-small btn-primary"/>
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
       

   
    
   
   
    
   
  
</script>


