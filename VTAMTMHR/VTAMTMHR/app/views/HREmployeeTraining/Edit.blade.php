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
<a href="{{url('ViewHREmployeeTraining')}}"> << Back to Employee Training(Local/Foreign)/Futher Education scholarships</a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee  Training(Local/Foreign)/Futher Education scholarships
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

            <form class="form-horizontal" action="{{url('EditHREmployeeTraining')}}" method="POST"/>
          <h5 style="text-align: left"><b style="color: red">* Required/Mandatory Fields </b></h5>
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
                <label class="control-label" for="form-field-7">Program Type</label>
                <div class="controls">
                    <select id="ProgramType" name="ProgramType" required>
					<option value="">---Select Type---</option>
					<option value="FutherEducationscholarships" @if($empqua->ProgramType == 'FutherEducationscholarships') selected="True" @endif>Futher Education scholarships</option>
					<option value="ShortTrainingprogram" @if($empqua->ProgramType == 'ShortTrainingprogram') selected="True" @endif>Short Training Program</option>
					</select>
                </div>
            </div>
          <div class="control-group">
                <label class="control-label" for="form-field-7">Training Type</label>
                <div class="controls">
                    <select id="TrainingType" name="TrainingType" required>
					<option value="">---Select Type---</option>
					<option value="Local" @if($empqua->TrainingType == 'Local') selected="True" @endif>Local</option>
					<option value="Foreign" @if($empqua->TrainingType == 'Foreign') selected="True" @endif>Foreign</option>
					</select>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Leave Type</label>
                <div class="controls">
                    <select id="PayStatus" name="PayStatus" required>
					<option value="">---Select Pay Type---</option>
					<option value="Pay" @if($empqua->PayStatus == 'Pay') selected="True" @endif>Pay Leave</option>
					<option value="NoPay" @if($empqua->PayStatus == 'NoPay') selected="True" @endif>No Pay Leave</option>
					</select>
                </div>
            </div>
			  <div class="control-group">
                <label class="control-label" for="form-field-4">Country</label>
                <div class="controls">
                    <select  class="chzn-select" name="CountryId" onload="" id="CountryId[]" required>
                        <option value="">--Select Country--</option>
                        @foreach ($country as $qo)
                        <option  value="{{$qo->id}}" @if($empqua->CountryId == $qo->id) selected="True" @endif>{{$qo->CountryName}}</option>
                        @endforeach
                    </select> <b style="color: red">* </b>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-4">Program Name</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" required>
                        <option value="">--Select Program--</option>
                        @foreach ($quaorg as $qo)
                        <option  value="{{$qo->id}}" @if($empqua->ProgramId == $qo->id) selected="True" @endif>{{$qo->NameOfTheProgram}}</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-6">Institute Name</label>
                <div class="controls" >
                    <select class="chzn-select" name="InstituteID" id="InstituteID" onload="" required>
                        <option value="">--Select Institute--</option>
                       @foreach ($Institutes as $qo)
                        <option  value="{{$qo->id}}" @if($empqua->TrainingInstituteId == $qo->id) selected="True" @endif>{{$qo->InstituteName}}</option>
                        @endforeach
                    </select><b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
            </div>
               <div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Date From : </label>

                        <div class="controls">
                            
                           
							<input  type="Date" name="date-range-picker-From" id="id-date-range-picker-1" value="{{$empqua->DurationFrom}}" required/><b style="color: red">*</b>
                        </div>
                    </div>
					<div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Date To : </label>

                        <div class="controls">
                            
                           
							<input  type="Date" name="date-range-picker-To" id="id-date-range-picker-2"  value="{{$empqua->DurationTo}}" required/><b style="color: red">*</b>
                        </div>
                    </div>


            <div class="control-group">
                <label class="control-label" for="form-field-7">Amount Paid By VTA</label>
                <div class="controls">
                    <input type="text"  name="AmountPaidByVTA" id="AmountPaidByVTA"  value="{{$empqua->AmountPaidByVTA}}" required><b style="color: red">* Eg: 200000.00</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Compulsory Period of Service</label>
                <div class="controls">
                    Years:<input type="text"  name="CompulsoryPeriodOfService" id="CompulsoryPeriodOfService" value="{{$empqua->CompulsoryPeriodOfService}}" style="width:45px;height: 20px" required> Months:<input type="text"  name="CompulsoryPeriodOfServiceMonth" id="CompulsoryPeriodOfServiceMonth" value="{{$empqua->CompulsoryPeriodOfServiceMonth}}" style="width:45px;height: 20px" required><b style="color: red">* No of Years & Months</b>
                </div>
            </div>
			  <div class="control-group">
                <label class="control-label" for="form-field-7">Amount of Surcharge</label>
                <div class="controls">
                    <input type="text"  name="AmountOfSurcharge" id="AmountOfSurcharge" value="{{$empqua->AmountOfSurcharge}}" required><b style="color: red">* Eg: 200000.00</b>
                </div>
            </div>
            <div class="control-group">
                        
                            <label class="control-label" for="Medium">Guarators(01 & 02)</label>
                                <div id="table_instructor22" class="controls">
								 <div id="table_instructor">
                                   <select id="Gaurators" name="Gaurators[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Two Guarantors..." >
								  
                                    @foreach($employees as $t)
									
                                    <option value="{{$t->id}}" @if($empqua->Guarantor1 == $t->id || $empqua->Guarantor2 == $t->id) selected="true" @endif>{{$t->EPFNo}} - {{$t->Initials}} {{$t->LastName}}</option>
								  
                                    @endforeach
                                    </select><b style="color: red">* Select Both(2) Guarantors</b>
									</div>
									
                            </div>
                </div>
				 <div class="control-group">
                <label class="control-label" for="form-field-7">Training Completed Date</label>
                <div class="controls">
                    <input type="date"  name="TrainingCompletedDate" id="TrainingCompletedDate" value="{{$empqua->TrainingCompletedDate}}" /><b style="color: red">* If Training Completed</b>
                </div>
            </div>
				<div class="control-group">
                <label class="control-label" for="form-field-7">Certificate Forwarded</label>
                <div class="controls">
                    <select id="CertificateForwarded" name="CertificateForwarded" required>
					<option value="">---Select Status---</option>
					<option value="1" @if($empqua->CertificateForwarded == 1) selected="True" @endif>Yes</option>
					<option value="0" @if($empqua->CertificateForwarded == 0) selected="True" @endif>No</option>
					</select><b style="color: red">* If 'Yes' Please Fill Certificate Forwarded Date</b>&nbsp&nbsp<input type="date" name="CertificateForwardedDate" id="CertificateForwardedDate" value="{{$empqua->CertificateForwadedDate}}"/>
                </div>
            </div>
				<div class="control-group">
                <label class="control-label" for="form-field-7">Other Comments</label>
                <div class="controls">
                   <textarea name="Other" id="Other" cols="5" >{{$empqua->Other}}</textarea><b style="color: red">*</b>
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
</script>