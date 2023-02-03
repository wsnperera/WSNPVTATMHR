@include('includes.bar')    
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployeeQualification')}}"> << Back to Employee Qualification </a>
<div class="page-content">                              
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Qualification		
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

            <form class="form-horizontal" action="{{url('EditHREmployeeQualification')}}" method="POST"/>
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
                <label class="control-label" for="form-field-3">University/Institute</label>
                <div class="controls">
                    <select name="QO_ID" class="chzn-select" id="QO_ID" required>
                        <option  value="">--Select University--</option>
                       @foreach ($quaorg as $qo)
                        <option  value="{{$qo->id}}" @if($qo->id == $empqua->UniversityID) selected="true" @endif>{{$qo->UniversityName}}</option>
                        @endforeach
                    </select><b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Qualification Type</label>
                <div class="controls">
                    <select name="QType" id="QType" required>
                        <option value="">--Select Type--</option>
                       @foreach ($quatype as $qo)
                        <option  value="{{$qo->id}}" @if($EmpQualificationTypeID == $qo->id) selected="true" @endif>{{$qo->Type}}</option>
                        @endforeach
                    </select>
					<b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-6">Qualification Category</label>
                <div class="controls" >
                    <select name="QCategory" id="QCategory" required>
                        <option value="">--Select Category--</option>
                       @foreach ($quacategory as $qo)
                        <option  value="{{$qo->id}}" @if($EmpQualificationCategoryID == $qo->id) selected="true" @endif>{{$qo->QCategory}}</option>
                        @endforeach
                    </select><b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Qualification </label>
                <div class="controls" id="q_code">
                    <select name="QCode" id="QCode" required >
                        <option  value="">--Select Qualification--</option>
						 @foreach ($qualification as $qq)
                        <option  value="{{$qq->id}}" @if($empqua->QualificationID == $qq->id) selected="true" @endif>{{$qq->Qualification}}</option>
                        @endforeach
                       
                    </select><b style="color: red">*</b></td><td><input type="button"  value="New Qualification Description" name="NewQualificationDescription" id="NewQualificationDescription" onclick="addQualificationDescription()" class="btn btn-small btn-primary"/></td></tr></table>
                </div>
            </div>

          
            
          <div class="control-group" hidden="" id="addQualificationDescription" style="padding-top: 10px;padding-bottom: 10px;margin-right: 200px;margin-left: 100px;margin-top:25px;margin-bottom:25px; border: 1px solid #009ceb;width:800px">

                <h6 align="center" style="font-family: arialblack;font-size: 12pt" ><b>Create New Qualification</b></h6>

                
                        <input id="QualificationType"  type="hidden" >
                    

                <div class="control-group">
                    <label class="control-label">Qualification</label>
                    <div class="controls">
                        <textarea id="QualificationDescription"  ></textarea><span class='label label-important arrowed-in'>Example : B.Sc in Computer Science/Bachelor in Arts</span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <input type="button" value="Create Qualification Description" onclick="fillQualificationDescription()" class="btn btn-small btn-primary"/>
                    </div>
                </div>  

            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">Course Type</label>
                <div class="controls">
                  <select name="CourseType" id="CourseType" required>
				  <option value="">---Select Type---</option>
				  <option value="Full" @if($empqua->CourseType == 'Full') selected="true" @endif>Full</option>
				  <option value="Part" @if($empqua->CourseType == 'Part') selected="true" @endif>Part</option>
				  </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-3">Main Subject / Specialized Area</label>
                <div class="controls">
                    <textarea type="text" rows="5" name="MainSubject" >{{$empqua->MainSubjects}}</textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Completed Year</label>
                <div class="controls">
                    <input type="text" name="Year" id="YearCheck" value="{{$empqua->Year}}"  style="width:45px;height: 20px"/><b style="color: red"></b>
               <span>& Month
                        <select name="Month" id="CheckMonth" style="width:105px;height: 30px" >
                            <option  value="">--Select Month--</option>
                            <option @if($empqua->Month == '1') selected @endif value="1" value="1">January</option>
                            <option @if($empqua->Month == '2') selected @endif value="2" value="2">February</option>
                            <option @if($empqua->Month == '3') selected @endif value="3" value="3">March</option>
                            <option @if($empqua->Month == '4') selected @endif value="4" value="4">April</option>
                            <option @if($empqua->Month == '5') selected @endif value="5" value="5">May</option>
                            <option @if($empqua->Month == '6') selected @endif value="6" value="6">June</option>
                            <option @if($empqua->Month == '7') selected @endif value="7" value="7">July</option>
                            <option @if($empqua->Month == '8') selected @endif value="8" value="8">August</option>
                            <option @if($empqua->Month == '9') selected @endif value="9" value="9">September</option>
                            <option @if($empqua->Month == '10') selected @endif value="10" value="10">October</option>
                            <option @if($empqua->Month == '11') selected @endif value="11" value="11">November</option>
                            <option @if($empqua->Month == '12') selected @endif value="12" value="12">December</option>
                        </select><b style="color: red"></b></span>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">UGC Approved Status</label>
                <div class="controls">
                  <select name="UGCApproveStatus" id="UGCApproveStatus" >
				  <option value="">---Select Type---</option>
				  <option value="Yes" @if($empqua->UGCApproveStatus == 'Yes') selected="true" @endif>Yes</option>
				  <option value="No" @if($empqua->UGCApproveStatus == 'No') selected="true" @endif>No</option>
				  </select><b style="color: red">*Required Only For Degrees</b>
                </div>
            </div>
<!--            <div class="control-group">
                <label class="control-label" for="form-field-3">Result</label>
                <div class="controls">
                    <input  required><b style="color: red">*</b>
                </div>
            </div>-->
            
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
<script type="text/javascript">
                            $(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
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