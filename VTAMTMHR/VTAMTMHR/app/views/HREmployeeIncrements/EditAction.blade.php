@include('includes.bar')    
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<a href="{{url('ViewHREmployeeIncrements')}}"> << Back to Employee Increments</a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Increments
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Edit
                    </small>			
                </h1>
            </div><!--/.page-header-->
<!--            @if ($errors->has())
            @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
            @endforeach
            @endif-->

            <form class="form-horizontal" action="" method="POST"/>
          <h5 style="text-align: left"><b style="color: red">* Required/Mandatory Fields</b></h5>
			<hr/>

            <div class="control-group">
                <!--                <label class="control-label" for="form-field-1">Employee Qualification ID</label>-->
                <div class="controls">
                    <input type="hidden" style="color:red" name="EQ_ID" value="{{Request::get('id')}}" readonly="readonly"/>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPF" value="{{$EPF}}" readonly /><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" value="{{$EmpNIC}}" readonly/>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Name</label>
                <div class="controls">
                   
					<textarea name="Ename" id="Ename" readonly>{{$EmpInitials}} {{$EmpLastName}}</textarea>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-3">Designation</label>
                <div class="controls">
                   
					<textarea name="Designation" id="Designation" readonly>{{$Designation}}</textarea>
                </div>
            </div>
	 
            <div class="control-group">
                <label class="control-label" for="form-field-4">Service Category</label>
                <div class="controls">
					@foreach ($quaorg as $qo)
                  
                       
                        <textarea name="ServiceCategory" id="ServiceCategory" readonly> {{$qo->ServiceCategory}} - {{$qo->SalaryCode}}({{$qo->SalaryScale}})</textarea>
                       
                      
					 @endforeach
                </div>
            </div>
			 <div class="control-group">
              <label class="control-label" for="form-field-4">Salary Step</label>
                <div class="controls">
					@foreach($salarysteps as $st)
					@if($st->EBAvailable == 1)
				    <input type="text" name="SalaryStepTransIDD" id="SalaryStepTransIDD" readonly value="{{$st->StepNo}} - {{$st->StepAmount}} (EB Available)"> 
					@else
					<input type="text" name="SalaryStepTransIDD" id="SalaryStepTransIDD" readonly value="{{$st->StepNo}} - {{$st->StepAmount}}"> 
					@endif						
					@endforeach
                </div>
            </div>
			
			
            <div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Increment Date: </label>

                        <div class="controls">
                            
                           
							<input  type="Date" name="NextIncrementDate" id="NextIncrementDate" value="{{$empqua->NextIncrementDate}}" readonly/>
                        </div>
                    </div>
					
					 <div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Approve Status: </label>

                        <div class="controls">
                            
                           
							<select name="Approve" id="Approve" required>
							<option value="">--- Select Approve Status---</option>
							@foreach($action as $a)
							<option value="{{$a->id}}">{{$a->Action}}</option>
							@endforeach
							
							</select><b style="color: red">*</b>
                        </div>
                    </div>
				<div class="control-group"  id="IncrementMonthDiv">
                <label class="control-label" for="form-field-14">Temporary Hold Months:</label>
                <div class="controls">
                    <select name="IncrementMonth[]"  id='IncrementMonth' multiple="multiple" class="chzn-select" data-placeholder="Choose Months..."  >
                        <option  value= "">--Select Month--</option>
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
				<div class="control-group"  id="ReasonDiv">
					<label class="control-label" for="form-field-12">Reason For Not Approved/Hold:</label>
						<div class="controls">
							<textarea name="Reason" id="Reason"></textarea>
						</div>
                 </div>
           <div class="control-group"  id="GrossSalaryDiv">
					<label class="control-label" for="form-field-12">Gross Salary:</label>
						<div class="controls">
							<input type="text" name="GrossSalary" id="GrossSalary" /><b style="color: red"></b>
						</div>
                 </div>
			
			
			
			
            
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-small btn-success" type="submit"  value="Update" />
                </div>
            </div>
            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
        <div class="span4" id="ajaxerror">
            @if(Session::has('done'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                    {{Session::get('done')}}
                </strong>
                <br>
            </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>{{Session::get('message')}}</strong><br>
            </div>
            @endif
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Error!
                </strong>{{$msg}}
                <br>
            </div>
            @endforeach
            @endif
        </div>
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script>
   jQuery(document).ready(function() {
   
$(".chzn-select").trigger("liszt:activate");
$(".chzn-select").chosen(); 
 $("#IncrementMonth.chzn-select").trigger("liszt:updated");
                                            $(".chzn-select").chosen();
});

    
    
</script>
<script type="text/javascript">
                            $(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });
							
                            $("[id^='InstituteID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#InstituteID_chzn").find('input').val()).text($("#InstituteID_chzn").find('input').val());

                                $("#InstituteID.chzn-select").prepend(option);
                                $("#InstituteID.chzn-select").find(option).prop('selected', true);
                                $("#InstituteID.chzn-select").trigger("liszt:updated");
                            });
							
							$("[id^='CountryId']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#CountryId_chzn").find('input').val()).text($("#CountryId_chzn").find('input').val());

                                $("#CountryId.chzn-select").prepend(option);
                                $("#CountryId.chzn-select").find(option).prop('selected', true);
                                $("#CountryId.chzn-select").trigger("liszt:updated");
                            });
                      /* $("#QType").change(function() {
                                var qualificationType = document.getElementById('QType').value;
                                $.ajax({
                                    url: "{{url::to('EmpQualificationTypeAjax')}}",
                                    data: {QualificationType: qualificationType},
                                    beforeSend: function() {
                                        document.getElementById('ajax_img2').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                    },
                                    success: function(result) {
                                        document.getElementById('q_code').innerHTML = result;
                                        $('#addQualificationDescription').hide();
                                        $('#editQualificationDescription').hide();
                                        document.getElementById('QualificationAdd').value = '';
                                        document.getElementById('QualificationDescriptionAdd').value = '';
                                    },
                                    complete: function() {
                                        document.getElementById('ajax_img2').innerHTML = "";
                                    }
                                });
                            }); */
							$("#QCategory").change(function() {
                                var QCategory = document.getElementById('QCategory').value;
								var QType = document.getElementById('QType').value;
                                $.ajax({
                                    url: "{{url::to('HREmpQualificationTypeAjax')}}",
                                    data: {QCategory: QCategory,QType:QType},
                                    beforeSend: function() {
                                        document.getElementById('ajax_img2').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                    },
                                    success: function(result) {
                                        document.getElementById('q_code').innerHTML = result;
                                        $('#addQualificationDescription').hide();
                                       // document.getElementById('Qualification').value = '';
                                        document.getElementById('QualificationDescription').value = '';
                                    },
                                    complete: function() {
                                        document.getElementById('ajax_img2').innerHTML = "";
                                    }
                                });
                            });
                          

                             function addQualificationDescription() {
                                $.ajax({
                                    url: "{{url::to('')}}",
                                    success: function(result) {
                                        if ($('#addQualificationDescription').is(':hidden')) {
                                            document.getElementById("QualificationType").value = document.getElementById('QType').value;
                                            $('#addQualificationDescription').show();
                                        } else {
                                            $('#addQualificationDescription').hide();
                                        }
                                    }
                                });
                            }
                            function fillQualificationDescription() {
                                var QualificationCat = document.getElementById('QCategory').value;
                                var QualificationType = document.getElementById('QType').value;
                                var QualificationDescription = document.getElementById('QualificationDescription').value;
                                $.ajax({
                                    url: "{{url::to('HRsaveQualificationDescription')}}",
                                    data: {QualificationCat: QualificationCat, QualificationType: QualificationType, QualificationDescription: QualificationDescription},
                                    dataType: 'json',
                                    success: function(result) {
                                        if (result.QCode !== 0) {
                                            $("#q_code").html(result.html);
                                            $('#addQualificationDescription').hide();
                                            $('#ajaxerror').html(result.done);
											document.getElementById('QualificationDescription').value = '';

                                        } else {
                                            $('#ajaxerror').html(result.html);
                                            window.scrollTo(0, 0);
                                        }
                                    }
                                });

                            }
                            function editQualificationDescription() {
                                $.ajax({
                                    url: "{{url::to('')}}",
                                    success: function(result){
                                        if ($('#editQualificationDescription').is(':hidden')) {
                                           // document.getElementById("QualificationType").value = document.getElementById('QType').value;
                                            $('#editQualificationDescription').show();
                                        } else {
                                            $('#editQualificationDescription').hide();
                                        }
                                    }
                                });
                            }

                            function UpdateQualificationDescription() {
                                var Qualification = document.getElementById('Qualification').value;
                                var QualificationType = document.getElementById('QType').value;
                                var QualificationDescription = document.getElementById('QualificationDescription').value;
                                var ccid = document.getElementById('QT_ID').value;
                                if (ccid !== '') {
                                    $.ajax({
                                        url: "{{url::to('UpdateQualificationDescription')}}",
                                        data: {Qualification: Qualification, QualificationType: QualificationType, QualificationDescription: QualificationDescription, QT_ID: ccid},
                                        dataType: 'json',
                                        success: function(result) {
                                            if (result.QCode !== 0) {
                                                $("#q_code").html(result.html);
                                                $('#editQualificationDescription').hide();
                                                $('#ajaxerror').html(result.done);
                                            } else {
                                                $('#ajaxerror').html(result.html);
                                                window.scrollTo(0, 0);
                                            }
                                        }
                                    });
                                } else {
                                    $.ajax({
                                        url: "{{url::to('UpdateQualificationDescription')}}",
                                        data: {Qualification: Qualification, QualificationType: QualificationType, QualificationDescription: QualificationDescription, QT_ID: ccid},
                                        dataType: 'json',
                                        success: function(result) {
                                            if (result.QCode !== 0) {
                                                $("#q_code").html(result.html);
                                                $('#editQualificationDescription').hide();
                                                $('#ajaxerror').html(result.done);
                                            } else {
                                                $('#ajaxerror').html(result.html);
                                                window.scrollTo(0, 0);
                                            }
                                        }
                                    });
                                }
                            }
                            $("#YearCheck").keyup(function() {
                                var CurrentDate = new Date();
                                var CurrentYear = CurrentDate.getFullYear();
                                var Year = $(this).val();
                                if (isNaN(Year) || Year > CurrentYear || Year.length > 4) {
                                    $(this).val('');
                                } 
                            });
                             $("#CheckMonth").change(function() {
                                var CurrentDate = new Date();
                                var CurrentMonth = CurrentDate.getMonth()+1;
                                var month = $(this).val();
                                if (isNaN(month) || month > CurrentMonth ) {
                                    $(this).val('');
                                    bootbox.alert('<b>Completed Results can Only entered in to the System...!</b>');
                                } 
                            });
							
							$("#QO_ID").change(function() 
	{
        var cid = $("#QO_ID").val();
		var year = '';
       
		var msgstep = '---Select Salary Step---';
		 $("#SalaryStepTransID").html('');
     
						
						
						
												$.ajax({
												type: "GET",
												url: "{{url::to('LoadAjaxServiceCategorySteps')}}",
												data: {ServicecategoryID: cid,year:year},
												success: function(result) {
													 $("#SalaryStepTransID").append("<option value=''>" + msgstep + "</option>");
			
													
													$.each(result, function(i, item)
													{


														if(item.EBAvailable == 1)
														{
															$("#SalaryStepTransID").append("<option value=" + item.id + ">" + item.StepNo + " - " + item.StepAmount+  "(EB Available)</option>");
														}
														else
														{
															$("#SalaryStepTransID").append("<option value=" + item.id + ">" + item.StepNo + " - " + item.StepAmount+ "</option>");
														}
													   



													});
													
													
												
													
													
												}
															
															
												});
			
    });
	
	
	 $('#Approve').change(function() {

                   if (document.getElementById('Approve').value == '2') {
                       $("#ReasonDiv").show();
					   document.getElementById("Reason").required = true;
					   $("#IncrementMonthDiv").show();

					   document.getElementById("IncrementMonth").required = true;
					   $("#GrossSalaryDiv").hide();
					   document.getElementById("GrossSalary").required = false;
                   } else if(document.getElementById('Approve').value == '3'){
                       $("#ReasonDiv").show();
					   document.getElementById("Reason").required = true;
					   $("#IncrementMonthDiv").show();
					   document.getElementById("IncrementMonth").required = true;
					   $("#GrossSalaryDiv").hide();
					   document.getElementById("GrossSalary").required = false;
                   }
				   else if(document.getElementById('Approve').value == '4')
				   {
                       $("#ReasonDiv").show();
					   document.getElementById("Reason").required = true;
					   $("#IncrementMonthDiv").hide();
					   document.getElementById("IncrementMonth").required = false;
					   $("#GrossSalaryDiv").hide();
					   document.getElementById("GrossSalary").required = false;
                   }
				   else if(document.getElementById('Approve').value == '0')
				   {
					   $("#ReasonDiv").hide();
					   document.getElementById("Reason").required = false;
					   $("#IncrementMonthDiv").hide();
					   document.getElementById("IncrementMonth").required = false;
					   $("#GrossSalaryDiv").hide();
					   document.getElementById("GrossSalary").required = false;
					    bootbox.alert('<b>Please change this pending status to another action...!</b>');
					   
				   }
				   else
				   {
					   $("#ReasonDiv").hide();
					   document.getElementById("Reason").required = false;
					   $("#IncrementMonthDiv").hide();
					   document.getElementById("IncrementMonth").required = false;
					   $("#GrossSalaryDiv").show();
					   document.getElementById("GrossSalary").required = false;
				   }
               }); 
</script>