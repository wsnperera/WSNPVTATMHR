@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployeeQualification')}}"> << Back to Employee Qualification </a> 
<div class="page-content">
    <div class="row-fluid">
        <div >
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Qualification		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeQualification')}}" method="POST" />
            <h5 style="text-align: left"><b style="color: red">* Required/Mandatory Fields </b></h5>
			<hr/>
			 <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Employee Qualification  Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>

           

          

            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Reference No</label>
                <div class="controls">
                    <input type="text" name="EPF" id="EPF" required/><b style="color: red">*</b>
                    <input type="hidden" name="EmpId" id="EmpId" />
                    <span id="ajax_img1"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-3">Employee NIC</label>
                <div class="controls">
                    <input type="text" name="NIC" id="NIC" readonly required/>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Name</label>
                <div class="controls">
                   
					<textarea name="Ename" id="Ename" readonly></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-4">University/Institute</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" required>
                        <option value="">--Select University--</option>
                        @foreach ($quaorg as $qo)
                        <option  value="{{$qo->id}}">{{$qo->UniversityName}}</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-6">Qualification Type</label>
                <div class="controls" >
                    <select name="QType" id="QType" required>
                        <option value="">--Select Type--</option>
                       @foreach ($quatype as $qo)
                        <option  value="{{$qo->id}}">{{$qo->Type}}</option>
                        @endforeach
                    </select><b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
            </div>
				<div class="control-group">
                <label class="control-label" for="form-field-6">Qualification Category</label>
                <div class="controls" >
                    <select name="QCategory" id="QCategory" required>
                        <option value="">--Select Category--</option>
                       @foreach ($quacategory as $qo)
                        <option  value="{{$qo->id}}">{{$qo->QCategory}}</option>
                        @endforeach
                    </select><b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-5">Qualification </label>
                <div class="controls" id="q_code">
				<table><tr/><td>
                    <select name="QCode" id="QCode" required>
                        <option value="">--Select--</option>
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
				  <option value="Full">Full</option>
				  <option value="Part">Part</option>
				  </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-7">Main Subject / Specialized Area</label>
                <div class="controls">
                    <textarea type="text" rows="5" name="MainSubject"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-7">Completed Year</label>
                <div class="controls">
                    <input type="text" name="Year" id="YearCheck"  style="width:45px;height: 20px" ><b style="color: red"></b>
                    <span>& Month
                        <select name="Month" id="CheckMonth" style="width:105px;height: 30px" >
                            <option value="">--Select--</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select><b style="color: red"></b></span>
                </div>
            </div>

            <div class="control-group">
<!--                <label class="control-label" for="form-field-8">Result</label>-->
                <div class="controls">
                    <input name="Result" type="hidden" value="Completed" />
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">UGC Approved Status</label>
                <div class="controls">
                  <select name="UGCApproveStatus" id="UGCApproveStatus" >
				  <option value="">---Select Type---</option>
				  <option value="Yes" >Yes</option>
				  <option value="No" >No</option>
				  </select><b style="color: red">*Required Only For Degrees</b>
                </div>
            </div>

            <div class="control-group" >
                <div class="controls">
                    <input type="submit" class="btn btn-small btn-primary"  value="Submit" />
                </div>
            </div>

            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
        <div  id="ajaxerror">
           
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
                            $("#EPF").change(function() {
                                var epf = document.getElementById('EPF').value;

                                $.ajax({
                                    url: "{{url::to('HRnicAjax')}}",
                                    data: {epf: epf},
                                    beforeSend: function() {
                                        document.getElementById('ajax_img1').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                                    },
                                    success: function(result) {
                                        var re = result.split('/n/');
                                        document.getElementById('EmpId').value = re[0];
                                        document.getElementById('NIC').value = re[1];
										document.getElementById('Ename').value = re[2];
                                    },
                                    complete: function() {
                                        document.getElementById('ajax_img1').innerHTML = "";
                                    }
                                });
                            });

                            $(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });
                            $("[id^='Qualification']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#Qualification_chzn").find('input').val()).text($("#Qualification_chzn").find('input').val());

                                $("#Qualification.chzn-select").prepend(option);
                                $("#Qualification.chzn-select").find(option).prop('selected', true);
                                $("#Qualification.chzn-select").trigger("liszt:updated");
                            });


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
							
                            $("#q_code").change(function() {
                                var qcode = document.getElementById('QCode').value;
                                var qdescriptionspan = document.getElementById('QdesOther');
                                if (qcode === "Other") {
                                    toAppend = "<input type='text' name='QDescription'/><span class='label label-important arrowed-in'>Example : Bsc in Computer Science/Bachelor in Arts</span>";
                                    qdescriptionspan.innerHTML = toAppend;

                                } else {
                                    qdescriptionspan.innerHTML = "<input type='hidden'  value ='" + qcode + "'/>";
                                }
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
                                var d = new Date($("#YearCheck").val(),month -1 ,1);

                                if (isNaN(month) ||  d > CurrentDate ) {
                                    $(this).val('');
                                    bootbox.alert('<b>Completed Results can Only entered in to the System...!</b>');
                                } 
                            });
</script>
