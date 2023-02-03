@include('includes.bar')    
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewIRCompany')}}> << Back to Company List</a> 
<h1>
Company	
<small>
        <i class="icon-double-angle-right"></i>
        Edit
</small>			
</h1>

        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditIRCompany')}}" method="POST"/>
			<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />
				<div class="control-group">
                    <label class="control-label">Organisation Name:</label>
                    <div class="controls">
                       
						 <input id="OrgaName" name="OrgaName" type="text" required="true" value="{{$quorg->CompanyName}}"><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Address:</label>
                    <div class="controls">
                        <textarea id="Address" name="Address"  required="true">{{$quorg->Address}}</textarea><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
					<label class="control-label" >District:</label>
					<div class="controls">
						<select name="DistrictCode" id="DistrictCode" required>
							<option value="">--- Select District ---</option>
							@foreach ($district as $d)
							<option @if($quorg->DistrictCode==$d->DistrictCode) selected="true" @endif value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
							@endforeach
						</select><span style="color:red">*</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="form-field-7">Electorate:</label>
					<div class="controls"  id="TRDid">
						<select id="ElectorateCode" name="ElectorateCode" required>
							<option value="">--- Select Electorate ---</option>
							 @foreach ($electorate as $e)
							<option @if($quorg->DSDivision==$e->ElectorateCode) selected="true" @endif value="{{$e->ElectorateCode}}">{{$e->ElectorateName}}</option>
							@endforeach
						</select><span style="color:red">*</span>
					</div>
				</div>
				
				<div class="control-group">
                    <label class="control-label">Comapany Tel:</label>
                    <div class="controls">
                        <input id="Tel" name="Tel" type="text" required="true" value="{{$quorg->TelNo}}"/><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Comapany Email:</label>
                    <div class="controls">
                        <input id="Email" name="Email" type="email" value="{{$quorg->Email}}"/><span style="color:red"></span>
                    </div>
                </div>
				
				<div class="control-group">
                    <label class="control-label">Co-ordinator's Name:</label>
                    <div class="controls">
                        <input id="CoordinatorName" name="CoordinatorName" type="text" required="true" value="{{$quorg->CoordinationOfficerName}}"/><span style="color:red">* Use title before name eg: Mr.Bandara</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Co-ordinator's Tel:</label>
                    <div class="controls">
                        <input id="CTel" name="CTel" type="text" required="true" value="{{$quorg->COMobille}}"/><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                <label class="control-label" >Company Type:</label>
                <div class="controls">
                    <select name="CompanyType" id="CompanyType" required>
                        <option value="">--- Select Type ---</option>
                       
                        <option @if($quorg->CompanyType == "Both") selected="true" @endif value="Both">Both</option>
						<option @if($quorg->CompanyType == "Local") selected="true" @endif value="Local">Local</option>
						<option @if($quorg->CompanyType == "Foreign") selected="true" @endif value="Foreign">Foreign</option>
                        
                    </select><span style="color:red">*</span>
                </div>
            </div>
				<div class="control-group">
                <label class="control-label" >Ownership:</label>
                <div class="controls">
                    <select name="Ownership" id="Ownership" required>
                        <option value="">--- Select Ownership ---</option>
                       
                        <option @if($quorg->Ownership == "Government") selected="true" @endif value="Government">Government</option>
						<option @if($quorg->Ownership == "SemiGovernment") selected="true" @endif value="SemiGovernment">Semi Government</option>
						<option @if($quorg->Ownership == "Private") selected="true" @endif value="Private">Private</option>
						<option @if($quorg->Ownership == "NGO") selected="true" @endif value="NGO">NGO</option>
						<option @if($quorg->Ownership == "Self") selected="true" @endif value="Self">Self</option>
						<option @if($quorg->Ownership == "Other") selected="true" @endif value="Other">Other</option>
                        
                    </select><span style="color:red">*</span>
                </div>
            </div>
			<!-- <div class="control-group">
                <label class="control-label" for="CourseListCode">Trade of the Company: </label>
                <div class="controls">
                    <select name="Trade" id="Trade" required>
                        <option value="">--Select--</option>
                        @foreach($Trades as $t)
                        <option @if($quorg->CTradeId==$t->TradeId) selected="true" @endif value="{{$t->TradeId}}">{{$t->TradeCode}} - {{$t->TradeName}}</option>
                        @endforeach
                    </select><span style="color:red">*</span><span id="img3"></span>
                </div>
            </div>-->
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
				<input class="btn btn-small btn-warning" type="submit"  value="Update" />
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

   /*  $("#DistrictCode").change(function() {

        var d_code = document.getElementById('DistrictCode').value;

        $.ajax({
            url: "{{url::to('disLoadajax')}}",
            data: {d_code: d_code},
            success: function(result) {
                document.getElementById('elec_code').innerHTML = result;

            }

        });

    }); */
	
		$("#DistrictCode").change(function() 
	{
        var District = $("#DistrictCode").val();
        $("#ElectorateCode").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select DS Division ---';
		var all = 'All';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('IRloaddistricDSDivision')}}",
                                        data: {District: District},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#ElectorateCode").append("<option value=''>" + msg + "</option>");
											// $("#ElectorateCode").append("<option value='All'>" + all + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#ElectorateCode").append("<option value=" + item.ElectorateCode + ">" +item.ElectorateName + "</option>");



                                                });

                                        } 
                                });            

            
     
    });
	</script>