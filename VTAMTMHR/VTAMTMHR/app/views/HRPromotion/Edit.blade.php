@include('includes.bar')    
<a href="{{url('ViewHRPromotion')}}"> << Back to HR - Promotion </a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    HR - Promotion		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->

            @if ($errors->has())
            @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
            @endif


            <form class="form-horizontal" action="{{url('EditHRPromotion')}}" method="POST"/>
<h4 style="text-align: left"> <b style="color: red">*</b><b>Required/Mandatory Fields </b></h4>

           
                <div class="controls">
                    <input type="hidden" name="InstituteId" id="InstituteId"  value="{{$InstituteID}}"/>
                 

            <div class="page-header position-relative"></div>


           
                    <input type="hidden" style="color:red" name="P_ID" value="{{Request::get('id')}}" readonly="readonly"/>
               

            <div class="control-group">
                <label class="control-label" for="form-field-2">Current NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" id="NIC" value="{{$promotion->NIC}}" readonly="readonly" required/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Reference No</label>
                <div class="controls">
                   
					<select name="EPF" id="EPF" required>
						<option value="">---Select EPF No---</option>
						@foreach($GetHREPFlist as $e)
						<option @if($e->EPFNo == $promotion->EPF) selected="true" @endif value="{{$e->EPFNo}}">{{$e->EPFNo}}</option>
						@endforeach
						</select> <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
<!--                <label class="control-label" for="form-field-3">Employee ID</label>-->
                <div class="controls">
                    <input type="hidden" name="Emp_ID" id="Emp_ID" value="{{$promotion->Emp_ID}}" readonly="readonly"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-4">Effective Date</label>
                <div class="controls">
                    <input type="date" name="StartDate" id="StartDate" value="{{$promotion->StartDate}}" required/><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-5">Transfer/Promotion Type</label>
                <div class="controls">
                    <select name="TransferType"  onchange="readonly()" id="TransferType" required>
					<option value="">--- Select Transfer Type---</option>
                        @foreach($transfertype as $tt)
                        <option @if($tt->T_ID == $promotion->TransferType) selected   @endif value="{{$tt->T_ID}}">{{$tt->TransferType}}</option>
                       @endforeach     
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-6">To Organisation</label>
                <div class="controls">
                    <select name="ToOrganisation" id="ToOrganisation" required>
                       <option value="">--- Select Organisation---</option>
                        @foreach($organisation as $o)
                        <option @if($o->id == $promotion->ToOrganisation) selected   @endif value="{{$o->id}}">{{$o->OrgaName}}-{{$o->Type}}</option>
                        @endforeach
                        <!-- <option @if ($promotion->ToOrganisation=="Head Office") selected @endif value="Head Office">Head Office</option>-->
                        
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-7">To Department</label>
                <div class="controls">
                    <select name="ToDepartment" id="ToDepartment" >
                        <option value="">--- Select Department---</option>
                        @foreach($department as $d)
                        <option @if($d->D_ID == $promotion->ToDepartment) selected   @endif value="{{$d->D_ID }}">{{$d->DepartmentName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-8">New Designation</label>
                <div class="controls">
                    <select name="NewPost"  id='NewPost'  onchange="load_emp_category(this.value)" required>
					 <option value="">--- Select Designation---</option>
                        @foreach($employmentcode as $ec)
                        <option @if($ec->id == $promotion->NewPost) selected   @endif value="{{$ec->id }}">{{$ec->Designation }}</option>
                        @endforeach
                    </select>
                    <b style="color: red">*</b>
                    <span class="label label-xlg label-info label-white arrowed" id="emp_category">{{$ec-> SalaryCode}}</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-9">Employee Type</label>
                <div class="controls">
				 
                    <select name="EmpType" id='EmpType' required >
					<option value="">--- Select Employee Type---</option>
                        @foreach($employeetype as $et)
                        <option  @if($et->ET_ID == $promotion->EmpType) selected   @endif value="{{$et->ET_ID }}">{{$et->EmployeeType}}</option>
                        @endforeach
                    </select>
                    <b style="color: red">*</b>
                </div>
            </div>
			<hr/>
			<div class="control-group">
                    <label class="control-label" for="form-field-8"></label>
                    <div class="controls" >
                        <h6 style="text-align: left"> <b style="color: blue">-- Starting Service Category Details --</b></h6>
                    </div>
                </div>
	<div class="control-group">
                <label class="control-label" for="form-field-10">Service Category Year</label>
                <div class="controls">
                  <select name="SCYear" id='SCYear'  >
				  <option value="">--- Select Category Year---</option>
                        @foreach($SCYears as $scy)
                        <option @if($scy->Year == $promotion->SCYear) selected   @endif value="{{$scy->Year}}">{{$scy->Year}}</option>
                        @endforeach
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-10">Service Category</label>
                <div class="controls">
                  <select name="ServiceCategoryID" id='ServiceCategoryID' >
				  <option value="">---Select Service Category---</option>
				  @foreach($SCList as $scl)
				  <option @if($scl->id == $promotion->ServiceCategoryID) selected   @endif value="{{$scl->id}}">{{$scl->ServiceCategory}} - [{{$scl->SalaryCode}}] - {{$scl->SalaryScale}}</option>
                        @endforeach
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-10">Grade</label>
                <div class="controls">
                    
					<select name="Grade" id='Grade' >
					 <option value="">---Select Grade---</option>
                       @foreach($GList as $gl)
				  <option @if($gl->id == $promotion->GradeId) selected   @endif value="{{$gl->id}}">{{$gl->Grade}}</option>
                        @endforeach 
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-11">Salary Scale</label>
                <div class="controls">
                    
                    <input type="text" name="SalaryScale" id='SalaryScale' value="{{$promotion->SalaryScale}}"  readonly />
                </div>
            </div>
		
					
						<div class="control-group" id="SalaryStepAutoDiv">
							<label class="control-label" for="form-field-12">Salary Step</label>
							<div class="controls">
								<select name="SalaryStepAuto"  id='SalaryStepAuto'  >
								<option value="">--- Select Salary Step---</option>
								@foreach($salarystaptrans as $st)
								 <option @if($st->id == $promotion->SalaryStep) selected   @endif value="{{$st->id}}">{{$st->StepNo}}-{{$st->StepAmount}}@if($st->EBAvailable == 1)
										(EB Available)@endif</option>
								@endforeach
								</select><b style="color: red"></b>
							</div>
						</div>
			<hr/>			
            <div class="control-group">
                    <label class="control-label" for="form-field-8"></label>
                    <div class="controls" >
                        <h6 style="text-align: left"> <b style="color: green">-- Present Service Category Details --</b></h6>
                    </div>
                </div>
			<div class="control-group">
                <label class="control-label" for="form-field-10">Service Category Year</label>
                <div class="controls">
                  <select name="PSCYear" id='PSCYear'  >
				  <option value="">--- Select Category Year---</option>
                        @foreach($SCYears as $scy)
                        <option @if($scy->Year == $promotion->PSCYear) selected   @endif value="{{$scy->Year}}">{{$scy->Year}}</option>
                        @endforeach
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-10">Service Category</label>
                <div class="controls">
                  <select name="PServiceCategoryID" id='PServiceCategoryID' >
				  <option value="">---Select Service Category---</option>
				  @foreach($SCList as $scl)
				  <option @if($scl->id == $promotion->PServiceCategoryID) selected   @endif value="{{$scl->id}}">{{$scl->ServiceCategory}} - [{{$scl->SalaryCode}}] - {{$scl->SalaryScale}}</option>
                        @endforeach
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-10">Grade</label>
                <div class="controls">
                    
					<select name="PGrade" id='PGrade' >
					 <option value="">---Select Grade---</option>
                       @foreach($GList as $gl)
				  <option @if($gl->id == $promotion->PGradeId) selected   @endif value="{{$gl->id}}">{{$gl->Grade}}</option>
                        @endforeach 
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-11">Salary Scale</label>
                <div class="controls">
                    
                    <input type="text" name="PSalaryScale" id='PSalaryScale' value="{{$promotion->PSalaryScale}}"  readonly />
                </div>
            </div>
		
					
						<div class="control-group" id="SalaryStepAutoDiv">
							<label class="control-label" for="form-field-12">Salary Step</label>
							<div class="controls">
								<select name="PSalaryStepAuto"  id='PSalaryStepAuto'  >
								<option value="">--- Select Salary Step---</option>
								@foreach($Psalarystaptrans as $st)
								 <option @if($st->id == $promotion->PSalaryStep) selected   @endif value="{{$st->id}}">{{$st->StepNo}}-{{$st->StepAmount}}@if($st->EBAvailable == 1)
										(EB Available)@endif</option>
								@endforeach
								</select><b style="color: red"></b>
							</div>
						</div>
		<hr/>
			<?php
			
			$transAvailable = TransferType::where('T_ID','=',$promotion->TransferType)->pluck('Available');
			?>
			@if($transAvailable == 1)
			<div class="control-group" hidden="true" id="GratuityAmountDiv">
                <label class="control-label" for="form-field-12">Gratuity Amount</label>
                <div class="controls">
                    <input type="text" name="GratuityAmount"  id='GratuityAmount' value="{{$promotion->GratuityAmount}}"/>
                </div>
            </div>
			<div class="control-group" hidden="true" id="ETFReleasedDateDiv">
                <label class="control-label" for="form-field-12">ETF Released Date</label>
                <div class="controls">
                    <input type="Date" name="ETFReleasedDate"  id='ETFReleasedDate' value="{{$promotion->ETFReleasedDate}}"/>
                </div>
            </div>
            <div class="control-group" hidden="true" id="EPFReleasedDateDiv">
                <label class="control-label" for="form-field-12">EPF Released Date</label>
                <div class="controls">
                    <input type="Date" name="EPFReleasedDate"  id='EPFReleasedDate' value="{{$promotion->EPFReleasedDate}}"/>
                </div>
            </div>
			@else
				<div class="control-group" hidden="false" id="GratuityAmountDiv">
                <label class="control-label" for="form-field-12">Gratuity Amount</label>
                <div class="controls">
                    <input type="text" name="GratuityAmount"  id='GratuityAmount' value="{{$promotion->GratuityAmount}}"/>
                </div>
            </div>
			<div class="control-group" hidden="false" id="ETFReleasedDateDiv">
                <label class="control-label" for="form-field-12">ETF Released Date</label>
                <div class="controls">
                    <input type="Date" name="ETFReleasedDate"  id='ETFReleasedDate' value="{{$promotion->ETFReleasedDate}}"/>
                </div>
            </div>
            <div class="control-group" hidden="false" id="EPFReleasedDateDiv">
                <label class="control-label" for="form-field-12">EPF Released Date</label>
                <div class="controls">
                    <input type="Date" name="EPFReleasedDate"  id='EPFReleasedDate' value="{{$promotion->EPFReleasedDate}}"/>
                </div>
            </div>
				@endif
            <div class="control-group">
                <label class="control-label" for="form-field-13">Increment Day</label>
                <div class="controls">
                    
					<select name="IncrementDay"  id='IncrementDay' >
                        <option  value= "">--Select Increment Month--</option>
                        <option @if($promotion->IncrementDay =="1") selected @endif value="1">1</option>
						<option @if($promotion->IncrementDay =="2") selected @endif value="2">2</option>
						<option @if($promotion->IncrementDay =="3") selected @endif value="3">3</option>
						<option @if($promotion->IncrementDay =="4") selected @endif value="4">4</option>
						<option @if($promotion->IncrementDay =="5") selected @endif value="5">5</option>
						<option @if($promotion->IncrementDay =="6") selected @endif value="6">6</option>
						<option @if($promotion->IncrementDay =="7") selected @endif value="7">7</option>
						<option @if($promotion->IncrementDay =="8") selected @endif value="8">8</option>
						<option @if($promotion->IncrementDay =="9") selected @endif value="9">9</option>
						<option @if($promotion->IncrementDay =="10") selected @endif value="10">10</option>
						<option @if($promotion->IncrementDay =="11") selected @endif value="11">11</option>
						<option @if($promotion->IncrementDay =="12") selected @endif value="12">12</option>
						<option @if($promotion->IncrementDay =="13") selected @endif value="13">13</option>
						<option @if($promotion->IncrementDay =="14") selected @endif value="14">14</option>
						<option @if($promotion->IncrementDay =="15") selected @endif value="15">15</option>
						<option @if($promotion->IncrementDay =="16") selected @endif value="16">16</option>
						<option @if($promotion->IncrementDay =="17") selected @endif value="17">17</option>
						<option @if($promotion->IncrementDay =="18") selected @endif value="18">18</option>
						<option @if($promotion->IncrementDay =="19") selected @endif value="19">19</option>
						<option @if($promotion->IncrementDay =="20") selected @endif value="20">20</option>
						<option @if($promotion->IncrementDay =="21") selected @endif value="21">21</option>
						<option @if($promotion->IncrementDay =="22") selected @endif value="22">22</option>
						<option @if($promotion->IncrementDay =="23") selected @endif value="23">23</option>
						<option @if($promotion->IncrementDay =="24") selected @endif value="24">24</option>
						<option @if($promotion->IncrementDay =="25") selected @endif value="25">25</option>
						<option @if($promotion->IncrementDay =="26") selected @endif value="26">26</option>
						<option @if($promotion->IncrementDay =="27") selected @endif value="27">27</option>
						<option @if($promotion->IncrementDay =="28") selected @endif value="28">28</option>
						<option @if($promotion->IncrementDay =="29") selected @endif value="29">29</option>
						<option @if($promotion->IncrementDay =="30") selected @endif value="30">30</option>
						<option @if($promotion->IncrementDay =="31") selected @endif value="31">31</option>
						
                        
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-14">Increment Month</label>
                <div class="controls">
                    <select name="IncrementMonth"  id='IncrementMonth' >
                        <option  value= "">--Select Increment Month--</option>
                        <option @if($promotion->IncrementMonth =="1") selected @endif value="1">January</option>
                        <option @if($promotion->IncrementMonth =="2")selected @endif value="2">February</option>
                        <option @if($promotion->IncrementMonth =="3") selected @endif value="3">March</option>
                        <option @if($promotion->IncrementMonth =="4") selected @endif value="4">April</option>
                        <option @if($promotion->IncrementMonth =="5") selected @endif value="5">May</option>
                        <option @if($promotion->IncrementMonth =="6") selected @endif value="6">June</option>
                        <option @if($promotion->IncrementMonth =="7") selected @endif value="7">July</option>
                        <option @if($promotion->IncrementMonth =="8") selected @endif value="8">August</option>
                        <option @if($promotion->IncrementMonth =="9")selected @endif value="9">September</option>
                        <option @if($promotion->IncrementMonth =="10") selected @endif value="10">October</option>
                        <option @if($promotion->IncrementMonth =="11") selected @endif value="11">November</option>
                        <option @if($promotion->IncrementMonth =="12") selected @endif value="12">December</option>
                    </select>
                </div>
            </div>
			<div class="control-group"  id="ConfirmationDateDiv">
                <label class="control-label" for="form-field-12">Confirmation Date</label>
                <div class="controls">
                    <input type="Date" name="ConfirmationDate"  id='ConfirmationDate' value="{{$promotion->ConfirmationDate}}"/>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-small btn-primary" type="submit"  value="Update" />
                </div>
            </div>
            
            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script type="text/javascript">
/* $(document).ready(function() {
    
   var SCYear = $("#SCYear").val();
   //alert(SCYear);
   if(SCYear >= '2016')
   {
	   $("#SalaryStepAutoDiv").show();
	   document.getElementById("SalaryStepAuto").required = true;	
       $("#SalaryStepManualDiv").hide();
	   document.getElementById("SalaryStepManual").required = false;	   
   }
   else
   {
	   $("#SalaryStepManualDiv").show();
	   document.getElementById("SalaryStepManual").required = true;
	   $("#SalaryStepAutoDiv").hide();
	   document.getElementById("SalaryStepAuto").required = false;
   }
   
}); */

/* window.onload = function{
   alert("loaded");
} */
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
	
	$("#PSCYear").change(function() {
        var cid = $("#PSCYear").val();
        var msg = '---Select Service Category---';
		//var All = 'All';
        $("#PServiceCategoryID").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadAjaxServiceCategoryYear')}}",
            data: {SCYear: cid},
            success: function(result) {
                $("#PServiceCategoryID").append("<option value=''>" + msg + "</option>");
			
                $.each(result, function(i, item)
                {



                   $("#PServiceCategoryID").append("<option value=" + item.id + ">" + item.ServiceCategory +  " [" + item.SalaryCode + "] -(" + item.SalaryScale+ ")</option>");



                });

            }
        });
    });
	$("#ServiceCategoryID").change(function() {
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
						document.getElementById('SalaryScale').value = result.done;
						$("#SalaryStepAuto").html('');
						var year  = $("#SCYear").val();
						/* if(year >= '2016')
						{ */
							
							//alert('dsf');
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
													
												//	$("#SalaryStepAutoDiv").show();
												   // $("#SalaryStepManualDiv").hide();
													document.getElementById("SalaryStepAuto").required = true;
													//document.getElementById("SalaryStepManual").required = false;
													
													
												}
												  
															
															
												});
												
												
												
						/* } */
						
					}
					});
				
				//
				

            }
        });
    });
   

$("#PServiceCategoryID").change(function() {
        var cid = $("#PServiceCategoryID").val();
        var msg = '---Select Grade---';
		var msgstep = '---Select salary step---';
		//var All = 'All';
        $("#PGrade").html('');
       
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadAjaxServiceCategoryGrade')}}",
            data: {SCYear: cid},
            success: function(result) {
                $("#PGrade").append("<option value=''>" + msg + "</option>");
			
                $.each(result, function(i, item)
                {



                   $("#PGrade").append("<option value=" + item.id + ">" + item.Grade +  "</option>");



                });
				
				//
					$.ajax({
					type: "GET",
					url: "{{url::to('getSalaryScaleValue')}}",
					data: {SCYear: cid},
					dataType: 'json',
					success: function(result) {
						document.getElementById('PSalaryScale').value = result.done;
						$("#PSalaryStepAuto").html('');
						var year  = $("#PSCYear").val();
						/* if(year >= '2016')
						{ */
							
							//alert('dsf');
												$.ajax({
												type: "GET",
												url: "{{url::to('LoadAjaxServiceCategorySteps')}}",
												data: {ServicecategoryID: cid,year:year},
												success: function(result) {
													 $("#PSalaryStepAuto").append("<option value=''>" + msgstep + "</option>");
			
													
													$.each(result, function(i, item)
													{


														if(item.EBAvailable == 1)
														{
															$("#PSalaryStepAuto").append("<option value=" + item.id + ">" + item.StepNo + " - " + item.StepAmount+  "(EB Available)</option>");
														}
														else
														{
															$("#PSalaryStepAuto").append("<option value=" + item.id + ">" + item.StepNo + " - " + item.StepAmount+ "</option>");
														}
													   



													});
													
												//	$("#PSalaryStepAutoDiv").show();
												   // $("#PSalaryStepManualDiv").hide();
													document.getElementById("PSalaryStepAuto").required = true;
													//document.getElementById("PSalaryStepManual").required = false;
													
													
												}
												  
															
															
												});
												
												
												
						/* } */
						
					}
					});
				
				//
				

            }
        });
    });
       
 function readonly(){
     
     var tt = document.getElementById("TransferType").value;
         if (tt == "2" || tt == "1" || tt == "8" || tt == "") {
            //document.getElementById("SCYear").required = true;
           // document.getElementById("ServiceCategoryID").required = true;
           // document.getElementById("Grade").required = true;
           // document.getElementById("SalaryScale").required = true;
			//document.getElementById("SalaryStep").required = true;
			document.getElementById("IncrementDay").required = true;
			document.getElementById("IncrementMonth").required = true;
		
        } else if (tt == "5" || tt == "7") {
            document.getElementById("SCYear").required = false;
            document.getElementById("ServiceCategoryID").required = false;
            document.getElementById("Grade").required = false;
            document.getElementById("SalaryScale").required = false;
			document.getElementById("SalaryStep").required = false;
			document.getElementById("IncrementDay").required = false;
			document.getElementById("IncrementMonth").required = false;
			
        } else {
            document.getElementById("SCYear").required = false;
            document.getElementById("ServiceCategoryID").required = false;
            document.getElementById("Grade").required = false;
            document.getElementById("SalaryScale").required = false;
			document.getElementById("SalaryStep").required = false;
			document.getElementById("IncrementDay").required = false;
			document.getElementById("IncrementMonth").required = false;
			
        }
   
    }  
      $('#NewPost').change(function() {
                        var newPost = document.getElementById('NewPost').value;
                        $.ajax({
                            url: "{{url::to('designationSalaryScaleLoadajax')}}",
                            data: {NewPost: newPost},
                            success: function(re) {
                                var a = re.split('/n/');
                                document.getElementById('FullSalaryScale').value = a[0];
                                document.getElementById('SalaryScale').value = a[1];
                            }
                        });
                    });
                    $(document).ready(function() {
                        var newPost = document.getElementById('NewPost').value;
                        $.ajax({
                            url: "{{url::to('designationSalaryScaleLoadajax')}}",
                            data: {NewPost: newPost},
                            success: function(re) {
                                var a = re.split('/n/');
                                document.getElementById('FullSalaryScale').value = a[0];
                                document.getElementById('SalaryScale').value = a[1];
                            }
                        });
                    });
</script>
<script>

    function load_emp_category(emp_code_id) {

        $.ajax({
            type: "GET",
            url: "{{url::to('get_employee_category')}}",
            data: {emp_code_id: emp_code_id},
            beforeSend: function() {
                {{--document.getElementById('ajax_img_PromoExist').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";--}}
            },
            success: function(result) {
                $txt = "Employee Category : " + result;
                //$("#emp_category").text($txt); // setting text

            },
            complete: function() {
//                document.getElementById('ajax_img_PromoExist').innerHTML = "";
            }
        });

    }

    function check() {
//    alert("zxcvbnm");
        var emp = document.getElementById("Emp_ID").value;
        var type = document.getElementById("TransferType").value;
        var role = document.getElementById("NewPost").value;
        var org = document.getElementById('ToOrganisation').value;
        var sdate = document.getElementById('StartDate').value;
        if (type === '1' || type === '2' || type === 'Transfer' && role === 'A213' || role === 'A212') {
            $.ajax({
                url: "{{url::to('Org_inch')}}",
                data: {emp: emp, type: type, role: role, org: org},
                success: function(result) {
//               alert(result);
                    bootbox.dialog(result, [{
                            "label": "Yes",
                            "class": "btn-small btn-success",
                            "callback": function() {
                                $.ajax({
                                    url: "{{url::to('Org_inch_edit')}}",
                                    data: {org: org, sdate: sdate, emp: emp, type: type, role: role},
                                    success: function(result) {
//                                    alert(result);
                                        bootbox.dialog(result, [{
                                                "label": "oK",
                                                "class": "btn-small btn-primary",
                                            }]);

                                        $("#myform").submit();
                                    }
                                });
                            }
                        },
                        {
                            "label": "No",
                            "class": "btn-small btn-danger",
                            "callback": function() {
                                $("#myform").submit();
                            }
                        }]);

                }


            });
        }

    }

    $("#TransferType").change(function() {
        var transferType = $("#TransferType").val();
        var NIC_NO = document.getElementById('NIC').value;

        $.ajax({
            type: "GET",
			url: "{{url::to('GetTransferTypeAvailable')}}",
			data: {tt: transferType},
			dataType: 'json',
            success: function(result) {
                

										if(result.done == 1)
										{
											$("#GratuityAmountDiv").hide();
											$("#ETFReleasedDateDiv").hide();
											$("#EPFReleasedDateDiv").hide();
										}
										else{
											$("#GratuityAmountDiv").show();
											$("#ETFReleasedDateDiv").show();
											$("#EPFReleasedDateDiv").show();
										}
										
										
										
										
																	
				
			}	,
            complete: function() {
                document.getElementById('ajax_img_TransferTypeName').innerHTML = "";
            }

               

      

 



              
});
               
    });




</script>