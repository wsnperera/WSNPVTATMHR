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
<a href="{{url('ViewHREmployeeOLResults')}}"> << Back to HR - Employee O/L Results  </a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span10">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                   HR - Employee O/L Results
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

            <form class="form-horizontal" action="{{url('EditHREmployeeOLResults')}}" method="POST"/>
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
                    <input type="text" name="EPF" value="{{$EPF}}" readonly />
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
                <label class="control-label" for="form-field-7">Attempt</label>
                <div class="controls">
                    <input id="AttemptId" name="AttemptId" type="text" @if($quorg->AttemptId == 1) value="I" @else value="II" @endif readonly>
					
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Year</label>
                <div class="controls">
                    <input type="text" id="Year" name="Year" required value="{{$quorg->Year}}"/><b style="color: red">*</b>
					
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Month</label>
                <div class="controls">
                    <Select id="Month" name="Month" required >
					<option value="">--- Select month ---</option>
					<option value="August" @if($quorg->Month == 'August') selected="true" @endif>August</option>
					<option value="December" @if($quorg->Month == 'December') selected="true" @endif>December</option>
					</select>
					<b style="color: red">*</b>
					
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">Centre No</label>
                <div class="controls">
                    <input type="text" id="CentreNo" name="CentreNo" value="{{$quorg->CentreNo}}"/><b style="color: red"></b>
					
                </div>
            </div>
			  <div class="control-group">
                <label class="control-label" for="form-field-7">Index No</label>
                <div class="controls">
                    <input type="text" id="Index" name="Index" required value="{{$quorg->IndexNo}}"/><b style="color: red">*</b>
					
                </div>
            </div>
			
			<div class="control-group">
                <label class="control-label" for="form-field-7">Medium</label>
                <div class="controls">
                    <select id="MediumId" name="MediumId" required>
					<option value="">---Select Medium---</option>
					@foreach($Mediums as $m)
					<option value="{{$m->id}}" @if($quorg->MediumId == $m->id) selected="true" @endif>{{$m->Medium}}</option>
					@endforeach
					</select><b style="color: red">*</b>
                </div>
            </div>
             <div class="controls">
                <pre bgcolor="REBECCAPURPLE"><center><h5><b><font color="REBECCAPURPLE">Ordinary Level Result Sheet</font><font color="RED"><h6>Note:-  First six(6) subjects & results required for Attempt 1 and At least one(1) subject & result required for Attempt 2</h6></font></b></h5></center>
				</pre>
				</div>
				
				<div class="control-group">
               <div class="controls" class="span6">
			   <?php $i=1;?>
			   <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
					<th>No</th>
                    <th class="center">Subject</th>
					<th class="center">Result</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=1;
					$aa=0;?>
				@foreach($enteredsubjects as $cc)
				<tr>
				<td>{{$i++}}</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}" @if($cc->SubjectId == $qo->id) selected="true" @endif>{{$qo->Subject}}</option>
								@endforeach
							</select> <b style="color: red">*</b>
						
					
				</td>
				<td class="center">
					
					
							<select class="chzn-select" style="width: 100px" name="Result[]" id="Result[]"  >
								<option value="">--Result--</option>
							   @foreach ($grades as $g)
								<option  value="{{$g->id}}" @if($cc->GradeId == $g->id) selected="true" @endif>{{$g->Grade}}</option>
								@endforeach
							</select><b style="color: red">*</b><span id="ajax_img2"></span>
						
					
           
				</td>
				</tr>
				<?php $aa = $aa+1; ?>
				@endforeach
				@if($aa != 10)
					
				<?php  $hh = 10-$aa; 
				$ee= 1;?>
				@while($ee <= $hh)
					<tr>
				<td>{{$i++}}</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}" >{{$qo->Subject}}</option>
								@endforeach
							</select> <b style="color: red">*</b>
						
					
				</td>
				<td class="center">
					
					
							<select class="chzn-select" style="width: 100px" name="Result[]" id="Result[]"  >
								<option value="">--Result--</option>
							   @foreach ($grades as $g)
								<option  value="{{$g->id}}">{{$g->Grade}}</option>
								@endforeach
							</select><b style="color: red">*</b><span id="ajax_img2"></span>
						
					
           
				</td>
				</tr>	
				
				<?php  $ee = $ee+1; ?>	
				@endwhile
				@endif	
				</tbody>
				</table>
				</div>
				</div>
            <div class="control-group">
                <div class="controls">
                    <input class="btn btn-block btn-primary" type="submit"  value="Update" />
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