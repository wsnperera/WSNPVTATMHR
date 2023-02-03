@include('includes.bar') 
<a href="{{url('ViewHRPromotion')}}"> << Back to HR Promotion </a> 
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
                        Create
                    </small>			
                </h1>
            </div><!--/.page-header-->
            <form class="form-horizontal" action="{{url('CreateHRPromotion')}}" method="POST" name="form1"  >
			<div class="control-group">
                   
                    <div class="controls">

                    @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                                Promotion Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
                   
                </div> 
                <h4 style="text-align: left"> <b style="color: red">*</b><b>Required/Mandatory Fields </b></h4>

               
                        <input type="hidden" name="InstituteId" id="InstituteId"  value="{{$InstituteID}}"/>
                     

                <div class="page-header position-relative"></div>
              {{---------------- des -------------------------------------}}

                <div class="control-group">
                    <label class="control-label" for="form-field-1">NIC</label>
                    <div class="controls">
                        <input type="text" name="NIC" id="NIC"  required/>  <b style="color: red">*</b>
						<button type="button" name="btn" id="btn" class="btn btn-purple">
                        <i class="icon-2x icon-user"></i>Check Promotion History</button>
                        <span id="ajax_img_PromoExist"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-2">Employee Reference No</label>
                    <div class="controls">
                       
						<select name="EPF" id="EPF" required>
						<option value="">---Select EPF No---</option>
						</select> <b style="color: red">*</b>

                    </div>
                </div>


              {{-------------- // des -------------------------------------}}

                <div class="controls" id='table'></div>

                <div class="control-group">
                    <!--                    <label class="control-label" for="form-field-1">Employee ID</label>-->
                    <div class="controls">
                        <input type="hidden" name="Emp_ID" id="Emp_ID" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-3">Effective Date</label>
                    <div class="controls">
                        <input type="date" name="StartDate" id="StartDate" required/><b style="color: red">*</b>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-4">Transfer Type</label>
                    <div class="controls">
                        <select name="TransferType" onchange="disable()" id="TransferType" required>
                            <option value="">--Select Transfer/Promotion Type--</option>
                            @foreach($transfertype as $tt)
                            <option value="{{$tt->T_ID}}">{{$tt->TransferType}}</option>
                            @endforeach
                        </select>
                        <b style="color: red">*</b><span id="ajax_img_TransferTypeName"></span>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="form-field-5">To Organisation</label>
                    <div class="controls" id='to_org'>
                        <select name="ToOrganisation" id="ToOrganisation" required>
                            <option value="">--Select Organisation--</option>
							@foreach($organisation as $o)
                        <option  value="{{$o->id}}">{{$o->OrgaName}}-{{$o->Type}}</option>
                        @endforeach
                        </select><b style="color: red">*</b>
                    </div>
                </div>

                <div class="control-group"  id='ViewDept'>
                    <label class="control-label" for="form-field-6">To Department</label>
                    <div class="controls" id='to_dept'>
                        <select name="ToDepartment" id="ToDepartment" >
                            <option value="">--- Select Department---</option>
                        @foreach($department as $d)
                        <option  value="{{$d->D_ID }}">{{$d->DepartmentName }}</option>
                        @endforeach
                        </select><b style="color: red"></b>
                    </div>
                </div>
  
                

                <div class="control-group">
                    <label class="control-label" for="form-field-7">New Designation</label>
                    <div class="controls" id="new_post" >
                        <select name="NewPost" id="NewPost"  required>
                            <option value="">--- Select Designation---</option>
                        @foreach($employmentcode as $ec)
                        <option  value="{{$ec->id }}">{{$ec->Designation }}</option>
                        @endforeach
                        </select>
                        <b style="color: red">*</b>
                        <span class="label label-xlg label-info label-white arrowed" id="emp_category"></span>
                    </div>
                </div>

                

                <div class="control-group">
                    <label class="control-label" for="form-field-8">Employee Type</label>
                    <div class="controls" id="emp_type" >
                        <select name="EmpType" id="EmpType" required>
                            <option value="">--- Select Employee Type---</option>
                        @foreach($employeetype as $et)
                        <option   value="{{$et->ET_ID }}">{{$et->EmployeeType}}</option>
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
                  <select name="SCYear" id='SCYear'>
				  <option value="">--- Select Category Year---</option>
                        @foreach($SCYears as $scy)
                        <option  value="{{$scy->Year}}">{{$scy->Year}}</option>
                        @endforeach
                    </select>
                    <b style="color: red"></b>
                </div>
              </div>
			<div class="control-group">
                <label class="control-label" for="form-field-10">Service Category</label>
                <div class="controls">
                  <select name="ServiceCategoryID" id='ServiceCategoryID'>
				  <option value="">---Select Service Category---</option>
				  @foreach($SCList as $scl)
				  <option  value="{{$scl->id}}">{{$scl->ServiceCategory}} - [{{$scl->SalaryCode}}] - {{$scl->SalaryScale}}</option>
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
				  <option value="{{$gl->id}}">{{$gl->Grade}}</option>
                        @endforeach 
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-11">Salary Scale</label>
                <div class="controls">
                    
                    <input type="text" name="SalaryScale" id='SalaryScale'  readonly />
                </div>
            </div>
			<div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Salary Step</label>
                <div class="controls">
                    <select name="SalaryStepAuto"  id='SalaryStepAuto' >
					
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
                        <option  value="{{$scy->Year}}">{{$scy->Year}}</option>
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
				  <option  value="{{$scl->id}}">{{$scl->ServiceCategory}} - [{{$scl->SalaryCode}}] - {{$scl->SalaryScale}}</option>
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
				  <option value="{{$gl->id}}">{{$gl->Grade}}</option>
                        @endforeach 
                    </select>
                    <b style="color: red"></b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-11">Salary Scale</label>
                <div class="controls">
                    
                    <input type="text" name="PSalaryScale" id='PSalaryScale'  readonly />
                </div>
            </div>
			<div class="control-group" id="SalaryStepAutoDiv" >
                <label class="control-label" for="form-field-12">Salary Step</label>
                <div class="controls">
                    <select name="PSalaryStepAuto"  id='PSalaryStepAuto' >
					
					</select><b style="color: red"></b>
                </div>
            </div>
			<hr/>
          <!--  <div class="control-group" hidden="true" id="SalaryStepManualDiv">
                <label class="control-label" for="form-field-12">Salary Step</label>
                <div class="controls">
                    <input type="text" name="SalaryStepManual"  id='SalaryStepManual'  /><b style="color: red"></b>
                </div>
            </div>-->
			
			<div class="control-group" hidden="true" id="GratuityAmountDiv">
                <label class="control-label" for="form-field-12">Gratuity Amount</label>
                <div class="controls">
                    <input type="text" name="GratuityAmount"  id='GratuityAmount' />
                </div>
            </div>
			<div class="control-group" hidden="true" id="ETFReleasedDateDiv">
                <label class="control-label" for="form-field-12">ETF Released Date</label>
                <div class="controls">
                    <input type="Date" name="ETFReleasedDate"  id='ETFReleasedDate' />
                </div>
            </div>
            <div class="control-group" hidden="true" id="EPFReleasedDateDiv">
                <label class="control-label" for="form-field-12">EPF Released Date</label>
                <div class="controls">
                    <input type="Date" name="EPFReleasedDate"  id='EPFReleasedDate' />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-13">Increment Day</label>
                <div class="controls">
                    
					<select name="IncrementDay"  id='IncrementDay' >
                        <option  value= "">--Select Increment Month--</option>
                        <option  value="1">1</option>
						<option  value="2">2</option>
						<option  value="3">3</option>
						<option  value="4">4</option>
						<option  value="5">5</option>
						<option  value="6">6</option>
						<option  value="7">7</option>
						<option  value="8">8</option>
						<option  value="9">9</option>
						<option  value="10">10</option>
						<option  value="11">11</option>
						<option  value="12">12</option>
						<option  value="13">13</option>
						<option  value="14">14</option>
						<option  value="15">15</option>
						<option  value="16">16</option>
						<option  value="17">17</option>
						<option  value="18">18</option>
						<option  value="19">19</option>
						<option  value="20">20</option>
						<option  value="21">21</option>
						<option  value="22">22</option>
						<option  value="23">23</option>
						<option  value="24">24</option>
						<option  value="25">25</option>
						<option  value="26">26</option>
						<option  value="27">27</option>
						<option  value="28">28</option>
						<option  value="29">29</option>
						<option  value="30">30</option>
						<option  value="31">31</option>
						
                        
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-14">Increment Month</label>
                <div class="controls">
                    <select name="IncrementMonth"  id='IncrementMonth' required>
                        <option  value= "">--Select Increment Month--</option>
                        <option  value="1">January</option>
                        <option  value="2">February</option>
                        <option  value="3">March</option>
                        <option  value="4">April</option>
                        <option  value="5">May</option>
                        <option  value="6">June</option>
                        <option  value="7">July</option>
                        <option  value="8">August</option>
                        <option  value="9">September</option>
                        <option  value="10">October</option>
                        <option  value="11">November</option>
                        <option  value="12">December</option>
                    </select>
                </div>
            </div>
			 <div class="control-group"  id="ConfirmationDateDiv">
                <label class="control-label" for="form-field-12">Confirmation Date</label>
                <div class="controls">
                    <input type="Date" name="ConfirmationDate"  id='ConfirmationDate' />
                </div>
            </div>

                <div class="control-group">
                    <div class="controls">
                        <input class="btn btn-small btn-primary" type="submit"   value="Save" />
                    </div>
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

  $("#NIC").blur(function() {
          
            var s_nic = document.getElementById('NIC').value;
			//alert(s_nic);
			$("#EPF").html('');
       var msg = '---Select EPF No---';
        $.ajax({
            type: "GET",
            url: "{{url::to('HEGetEPFList')}}",
            data: {NIC: s_nic},
            success: function(result) {
                $("#EPF").append("<option value=''>" + msg + "</option>");
			
                $.each(result, function(i, item)
                {



                   $("#EPF").append("<option value=" + item.EPFNo + ">" + item.EPFNo + "</option>");



                });

            }
        });
           

        });


    function disable() {
        var tt = document.getElementById("TransferType").value;
        if (tt === "2" || tt === "1" || tt === "8" || tt === "") {
            //document.getElementById("SCYear").required = true;
            //document.getElementById("ServiceCategoryID").required = true;
            //document.getElementById("Grade").required = true;
            //document.getElementById("SalaryScale").required = true;
			//document.getElementById("SalaryStep").required = true;
			document.getElementById("IncrementDay").required = true;
			document.getElementById("IncrementMonth").required = true;
			//document.getElementById("SalaryStepAuto").required = true;
			//document.getElementById("SalaryStepManual").required = true;
        } else if (tt === "5" || tt === "7") {
            document.getElementById("SCYear").required = false;
            document.getElementById("ServiceCategoryID").required = false;
            document.getElementById("Grade").required = false;
            document.getElementById("SalaryScale").required = false;
			document.getElementById("SalaryStep").required = false;
			document.getElementById("IncrementDay").required = false;
			document.getElementById("IncrementMonth").required = false;
			document.getElementById("SalaryStepAuto").required = false;
			//document.getElementById("SalaryStepManual").required = false;
        } else {
            document.getElementById("SCYear").required = false;
            document.getElementById("ServiceCategoryID").required = false;
            document.getElementById("Grade").required = false;
            document.getElementById("SalaryScale").required = false;
			document.getElementById("SalaryStep").required = false;
			document.getElementById("IncrementDay").required = false;
			document.getElementById("IncrementMonth").required = false;
			document.getElementById("SalaryStepAuto").required = false;
			//document.getElementById("SalaryStepManual").required = false;
        }
		
		
		

    }
    function che() {
        var n = document.getElementById("NIC").value.length;
        var t = document.getElementById("TransferType").value;
        if (n === 10 && t === "2") {
            alert("Congratulation for your success in your career");

        } else if (n === 10 && t === "1") {
            alert("WEL COME");
        }
    }

//----------------- des -------------------------------------
    $("#NIC").change(function() {

        var NIC = document.getElementById('NIC').value;

       $.ajax({
            url: "{{url::to('HEepfLoadajaxDes')}}",
            data: {NIC: NIC},
            success: function(re) {
                var a = re.split('/n/');
              
                document.getElementById('Emp_ID').value = a[0];
              //  document.getElementById("NIC").readOnly = true;

            }
        });
         $("#table").html('');
        $("#btn").click(function() {
            var NIC = $("#NIC").val();
            $.ajax({
                type: "GET",
                url: "{{url::to('HRpromotionExist')}}",
                data: {NIC: NIC},
                beforeSend: function() {
                    document.getElementById('ajax_img_PromoExist').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                },
                success: function(result) {

                    if (result === '1') {
                        var alert_html = '<img  src="assets/images/alert.jpg" width="60px" height="30px"/>'
                            alert_html+= '<h4>Currently No any Active Promotion Assigned for this Employee...!</h4>';
                        bootbox.alert(alert_html);
                    } else if (result === '2') {
                        document.getElementById('EPF').value = '';
                        var alert_html = '<img  src="assets/images/alert.jpg" width="60px" height="30px"/>';
                            alert_html+= '<h4>Mentioned NIC Holder is not an Employee of the VTA ...!</h4>';
                        bootbox.alert(alert_html);
                    } else {
                        $('#table').html(result);
                    }
                },
                complete: function() {
                    document.getElementById('ajax_img_PromoExist').innerHTML = "";
                }
            });
        });
    });

//    ------------------------ des----------------------------------

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
	
	//--------------------------
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
	//--------------------------
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
						document.getElementById('SalaryScale').value = result.done;
						var year  = $("#SCYear").val();
						
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
													
													
													$("#SalaryStepAutoDiv").show();
													//$("#SalaryStepManualDiv").hide();
													document.getElementById("SalaryStepAuto").required = true;
													
												}
															
															
												});
												
												
												
						
						
					}
					});
				
				//
				

            }
        });
    });
	
	//-------------------------------
		$("#PServiceCategoryID").change(function() 
	{
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
						var year  = $("#PSCYear").val();
						
												$.ajax({
												type: "GET",
												url: "{{url::to('LoadAjaxServiceCategorySteps')}}",
												data: {ServicecategoryID: cid,year:year},
												success: function(result) {
													$("#PSalaryStepAuto").html('');
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
													
													
													$("#PSalaryStepAutoDiv").show();
													//$("#PSalaryStepManualDiv").hide();
													document.getElementById("PSalaryStepAuto").required = true;
													
												}
															
															
												});
												
												
												
						
						
					}
					});
				
				//
				

            }
        });
    });
	//---------------------------

    $("#TransferType").change(function() {
        var transferType = $("#TransferType").val();
        var NIC_NO = document.getElementById('NIC').value;

        $.ajax({
            url: "{{url::to('HECheckTransferTypeName')}}",
            data: {TransferType: transferType},
            beforeSend: function() {
                document.getElementById('ajax_img_TransferTypeName').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
            },
            success: function(TransferTypeNameResults) {
                var TransferTypeName = TransferTypeNameResults;

                $.ajax({
                    url: "{{url::to('HEChecktransferType')}}",
                    data: {TransferType: transferType, NIC: NIC_NO},
                    success: function(results) {
                        if (TransferTypeName.match(/^FirstApp.*$/)) {
                            if (results === '1') {
                                bootbox.alert('This Employee already have the First Appointment');
                            }
                        }
								
                    }

                });
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
										
										
										
										
									}
								});
				
			}	,
            complete: function() {
                document.getElementById('ajax_img_TransferTypeName').innerHTML = "";
            }

               

      

 


//                $('#ToOrganisation').change(function() {
//
//                    if (document.getElementById('ToOrganisation').value === '304' ) {
//                        $('#ViewDept').show();
//                    } else {
//                        $('#ViewDept').hide();
//                    }
//                });

              
});
               
    });


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
                $("#emp_category").text($txt); // setting text

            },
            complete: function() {
//                document.getElementById('ajax_img_PromoExist').innerHTML = "";
            }
        });

    }



    $('#IncrementDay').blur(function() {
        var month = document.getElementById('IncrementMonth').value;
        var day = document.getElementById('IncrementDay').value;

        if (month === "January" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "February" && day > 29) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "March" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "April" && day > 30) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "May" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "June" && day > 30) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "July" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "August" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "September" && day > 30) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "October" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "November" && day > 30) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        } else if (month === "December" && day > 31) {
            alert('The date of ' + day + 'does not exist for the  Month of ' + month + '!...');
        }

    });

</script>
<script>

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

    $('#to_org').change(function() {

        if (document.getElementById('ToOrganisation').value === '304' ) {

            $('#ViewDept').show();
        } else {

            $("#ToDepartment :selected").remove();
            $('#ViewDept').hide();
        }
    });
</script>