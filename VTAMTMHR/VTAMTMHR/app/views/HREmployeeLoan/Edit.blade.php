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
<a href="{{url('ViewHREmployeeLoan')}}"> << Back to Employee Loan</a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Loan
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

            <form class="form-horizontal" action="{{url('EditHREmployeeLoan')}}" method="POST"/>
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
                <label class="control-label" for="form-field-4">Loan Type</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" required>
                        <option value="">--Select Loan Type--</option>
                        @foreach ($quaorg as $qo)
                        <option  value="{{$qo->id}}" @if($empqua->LoanTypeId == $qo->id) selected="true" @endif>{{$qo->LoanType}}</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                </div>
            </div>
			
            <div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Date Issued: </label>

                        <div class="controls">
                            
                           
							<input  type="Date" name="IssuedDate" id="IssuedDate" value="{{$empqua->IssuedDate}}" /><b style="color: red"></b>
                        </div>
                    </div>
					

            <div class="control-group">
                <label class="control-label" for="form-field-7">Loan Amount</label>
                <div class="controls">
                    <input type="text"  name="LoanAmount" id="LoanAmount" value="{{$empqua->LoanAmount}}" required><b style="color: red">* Eg: 200000.00</b>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">No of Installments</label>
                <div class="controls">
                    <input type="text"  name="NoOFInstallment" id="NoOFInstallment" value="{{$empqua->NoOFInstallment}}" required><b style="color: red">* </b>
                </div>
            </div>
            <div class="control-group">
                        
                            <label class="control-label" for="Medium">Guarators(01 & 02)</label>
                                <div id="table_instructor22" class="controls">
								 <div id="table_instructor">
                                   <select id="Gaurators" name="Gaurators[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Two Guarantors..." >
								  
                                    @foreach($employees as $t)
									
                                    <option value="{{$t->id}}" @if($empqua->Assure1 == $t->id || $empqua->Assure2 == $t->id) selected="true" @endif>{{$t->EPFNo}} - {{$t->Initials}} {{$t->LastName}}</option>
								  
                                    @endforeach
                                    </select><b style="color: red">* Select Both(2) Guarantors</b>
									</div>
									
                            </div>
                </div>
				<div class="control-group">
                <label class="control-label" for="form-field-7">Loan Completed</label>
                <div class="controls">
                    <select id="LoanClosed" name="LoanClosed" >
					<option value="">---Select status---</option>
					<option value="1" @if($empqua->LoanClosed == 1) selected="true" @endif>Completed</option>
					<option value="0" @if($empqua->LoanClosed == 0) selected="true" @endif>Not Completed</option>
					</select><b style="color: red">*</b>
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