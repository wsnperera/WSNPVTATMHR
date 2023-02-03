@include('includes.bar')       
<a href={{url('ViewIRCompany')}}> << Back to Company </a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
   Company		
        <small>
                <i class="icon-double-angle-right"></i>
                Create
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateIRCompany')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Company Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    
				<div class="control-group">
                    <label class="control-label">Comapany Name:</label>
                    <div class="controls">
                        <input id="OrgaName" name="OrgaName" type="text" required="true"><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Address:</label>
                    <div class="controls">
                        <textarea id="Address" name="Address"  required="true"></textarea><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                <label class="control-label" >District:</label>
                <div class="controls">
                    <select name="DistrictCode" id="DistrictCode" required="true">
                        <option value="">--- Select District ---</option>
                        @foreach ($district as $d)
                        <option value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                        @endforeach
                    </select><span style="color:red">*</span>
                </div>
            </div>
			
			<div class="control-group">
                <label class="control-label" for="form-field-7">Electorate:</label>
                <div class="controls"  id="TRDid">
                    <select id="ElectorateCode" name="ElectorateCode" required="true">
                        <option value="">--- Select DS Division ---</option>
                    </select><span style="color:red">*</span>
                </div>
				</div>
				<div class="control-group">
                    <label class="control-label">Comapany Tel:</label>
                    <div class="controls">
                        <input id="Tel" name="Tel" type="text" required="true" ><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Comapany Email:</label>
                    <div class="controls">
                        <input id="Email" name="Email" type="email" /><span style="color:red"></span>
                    </div>
                </div>
				
				<div class="control-group">
                    <label class="control-label">Co-ordinator's Name:</label>
                    <div class="controls">
                        <input id="CoordinatorName" name="CoordinatorName" type="text" required="true"/><span style="color:red">* Use title before name eg: Mr.Bandara</span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Co-ordinator's Tel:</label>
                    <div class="controls">
                        <input id="CTel" name="CTel" type="text" required="true" ><span style="color:red">*</span>
                    </div>
                </div>
				<div class="control-group">
                <label class="control-label" >Company Type:</label>
                <div class="controls">
                    <select name="CompanyType" id="CompanyType" required>
                        <option value="" >--- Select Type ---</option>
                       
                        <option value="Both">Both</option>
						<option value="Local">Local</option>
						<option value="Foreign">Foreign</option>
                        
                    </select><span style="color:red">*</span>
                </div>
            </div>
				<div class="control-group">
                <label class="control-label" >Ownership:</label>
                <div class="controls">
                    <select name="Ownership" id="Ownership" required>
                        <option value="">--- Select Ownership ---</option>
                       
                        <option value="Government">Government</option>
						<option value="SemiGovernment">Semi Government</option>
						<option value="Private">Private</option>
						<option value="NGO">NGO</option>
						<option value="Self">Self</option>
						<option value="Other">Other</option>
                        
                    </select><span style="color:red">*</span>
                </div>
            </div>
			<!--<div class="control-group">
                <label class="control-label" for="CourseListCode">Trade of the Company : </label>
                <div class="controls">
                    <select name="Trade" id="Trade" required>
                        <option value="">--Select--</option>
                        @foreach($Trades as $t)
                        <option value="{{$t->TradeId}}">{{$t->TradeCode}} - {{$t->TradeName}}</option>
                        @endforeach
                    </select><span style="color:red">*</span><span id="img3"></span>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
               <!-- </div>
            </div>-->
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

<script type="text/javascript">
/* 
    $("#DistrictCode").change(function() {

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



