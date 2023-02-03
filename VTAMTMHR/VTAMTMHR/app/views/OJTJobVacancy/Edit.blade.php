@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewIRJOBPVacancy')}}> << Back to JOB Vacancy</a> 
<h1>
JOB Vacancy	
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditIRJOBPVacancy')}}" method="POST" id="myform"/>
			<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />
				
				
				<div class="control-group">
					<label class="control-label" >District:</label>
					<div class="controls">
						<select name="DistrictCode" id="DistrictCode" required>
							<option>--- Select District ---</option>
							@foreach ($district as $d)
							<option @if($discode==$d->DistrictCode) selected="true" @endif value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
							@endforeach
						</select><span style="color:red">*</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="form-field-7">Electorate:</label>
					<div class="controls"  id="elec_code">
						<select id="ElectorateCode" name="ElectorateCode" required>
							<option>--- Select Electorate ---</option>
							 @foreach ($electorate as $e)
							<option @if($elecode==$e->ElectorateCode) selected="true" @endif value="{{$e->ElectorateCode}}">{{$e->ElectorateName}}</option>
							@endforeach
						</select><span style="color:red">*</span>
					</div>
				</div>
				<div class="control-group">
                    <label class="control-label" >Company : </label>
                        <div class="controls" >
                            <select name="CompanyID" id="CompanyID" required>
							<option>--- Select Company ---</option>
							 @foreach ($company as $e)
							<option @if($quorg->CompanyID==$e->id) selected="true" @endif value="{{$e->id}}">{{$e->CompanyName}} ({{$e->Address}})</option>
							@endforeach
                                 
                            </select><span style="color:red">*</span>
                           
                        </div>         
                 </div>
				  <div class="control-group">
                <label class="control-label" for="CourseListCode">Trade : </label>
                <div class="controls">
                    <select name="Trade" id="Trade" required>
                        <option value="">--Select--</option>
                        @foreach($Trades as $t)
                        <option @if($quorg->TradeID==$t->TradeId) selected="true" @endif value="{{$t->TradeId}}">{{$t->TradeCode}} - {{$t->TradeName}}</option>
                        @endforeach
                    </select><span style="color:red">*</span><span id="img3"></span>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="CourseListCode">Course Occupation : </label>
                <div class="controls">
                    <select name="CourseOccupation" id="CourseOccupation" required>
                        <option value="">--Select--</option>
						@foreach($Occupation as $t)
                        <option @if($quorg->CourseOccupationID==$t->id) selected="true" @endif value="{{$t->id}}">{{$t->Category}}</option>
                        @endforeach
                       
                    </select><span style="color:red">*</span>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div>	
				
				<div class="control-group">
                    <label class="control-label">Training Area:</label>
                    <div class="controls">
                        <textarea id="TrainingArea" name="TrainingArea" type="text" required="true">{{$quorg->TrainingArea}}</textarea><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Vacancy Type:</label>
                    <div class="controls">
                        <select id="VacancyType" name="VacancyType" required="true">
						<option value="">--- Select Type---</option>
						<option value="GenderBased" @if($quorg->VacancyType == "GenderBased") selected="true" @endif>Gender Based Vacancies</option>
						<option value="NotGenderBased" @if($quorg->VacancyType == "NotGenderBased") selected="true" @endif>Common Vacancies</option>
						</select><span style="color:red">* </span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">No of Vacancies(Female/Common):</label>
                    <div class="controls">
                        <input id="VacancyFemale" name="VacancyFemale" type="number" required="true" min="0" value="{{$quorg->VacancyFemale}}"><span style="color:red">*<b>Enter Value for both vacancy Types</b></span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">No of Vacancies(Male):</label>
                    <div class="controls">
                        <input id="VacancyMale" name="VacancyMale" type="number" required="true" min="0" value="{{$quorg->VacancyMale}}"><span style="color:red">*</span>
                    </div>
                </div>
					<div class="control-group">
                <label class="control-label" for="CourseListCode">Salary Gap : </label>
                <div class="controls">
                    <select name="SalaryGap" id="SalaryGap" required>
                        <option value="">--Select Salary Gap--</option>
						<option @if($quorg->SalaryGap =='Below 10000') selected="true" @endif value="Below 10000">Below 10000</option>
						<option @if($quorg->SalaryGap =='Between 10000 - 25000') selected="true" @endif value="Between 10000 - 25000">Between 10000 - 25000</option>
						<option @if($quorg->SalaryGap =='Between 25000 - 50000') selected="true" @endif value="Between 25000 - 50000">Between 25000 - 50000</option>
						<option @if($quorg->SalaryGap =='Between 50000 - 100000') selected="true" @endif value="Between 50000 - 100000">Between 50000 - 100000</option>
						<option @if($quorg->SalaryGap =='Greater than 100000') selected="true" @endif value="Greater Than 100000">Greater than 100000</option>
                       
                    </select><span style="color:red">*</span>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div>
				<div class="control-group">
                <label class="control-label" for="CourseListCode">Active Status: </label>
                <div class="controls">
                    <select name="Active" id="Active" required="true">
                        <option value="">--Select Active Status--</option>
						<option @if($quorg->Active==1) selected="true" @endif value="1">Yes</option>
						<option @if($quorg->Active==0) selected="true" @endif value="0">No</option>
                       
                    </select><span style="color:red">*</span>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div> 
			
				<div class="control-group">
				 <div class="controls">
				<input class="btn btn-small btn-warning" type="button"  id="button" value="Update" />
				 </div>
				</div>

</div>

</form>
<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
     @if ($errors->has())
@foreach ($errors->all() as $error)
    <div class='bg-danger alert'>{{ $error }}</div>
@endforeach
@endif
</div>
</div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   

<script type="text/javascript">

$(document).ready(function(){
    $("#button").click(function(){ 

    //alert('application');	
	var VacancyFemale = $('#VacancyFemale').val();
    var VacancyMale = $('#VacancyMale').val();
	
	var total = VacancyFemale + VacancyMale;
	
	if(total == 0)
	{
		bootbox.alert('!!! You have to fill vacancy counts offering by the company,Because vacancy count cannot be 0.');
	}
	else
	{
		$("#myform").submit(); // Submit the form
	}
	
       
    });
});


    $("#DistrictCode").change(function() {

        var d_code = document.getElementById('DistrictCode').value;

        $.ajax({
            url: "{{url::to('disLoadajax')}}",
            data: {d_code: d_code},
            success: function(result) {
                document.getElementById('elec_code').innerHTML = result;

            }

        });

    });
	
				$("#elec_code").change(function() 
	{
        var District = $("#DistrictCode").val();
		var elec_code = $("#ElectorateCode").val();
        $("#CompanyID").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Company ---';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('LoadIRCompanyFromElectorate')}}",
                                        data: {District: District,Electorate: elec_code },
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CompanyID").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CompanyID").append("<option value=" + item.id + ">" +item.CompanyName + "(" + item.Address + ")</option>");



                                                });

                                        } 
                                });            

            
     
    });
	
		 $("#Trade").change(function() {
        var TradeId = $("#Trade").val();
        $("#CourseOccupation").html('');
        
        var msg = '--- Select Occupation ---';
      
            
                          $.ajax  ({
                     beforeSend: function()
                                        {
                                            
                                            document.getElementById('img3').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                        },
                    url: "{{url::to('LoadIRTradeOccupation')}}",
                    data: { TradeId: TradeId},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#CourseOccupation").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                           $("#CourseOccupation").append("<option value=" + item.id + ">" +item.Category +  "</option>");
                           // a = a +1;



                        });
                                        
                        
                        },
                                        complete: function() {
                                            document.getElementById('img3').innerHTML ="";

                                        }


                    
                });
              

            
       
    });
	</script>