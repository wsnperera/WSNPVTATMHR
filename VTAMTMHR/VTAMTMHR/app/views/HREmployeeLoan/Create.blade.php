@include('includes.bar')       
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
<a href="{{url('ViewHREmployeeLoan')}}"> << Back to HR - Employee Loan  </a> 
<div class="page-content">
    <div class="row-fluid">
        <div >
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Loan
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeLoan')}}" method="POST" />
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
                               Employee Loan Record  Added Successfully 
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
                <label class="control-label" for="form-field-4">Loan Type</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" required>
                        <option value="">--Select Loan Type--</option>
                        @foreach ($quaorg as $qo)
                        <option  value="{{$qo->id}}">{{$qo->LoanType}}</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                </div>
            </div>
			
            <div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Date Issued: </label>

                        <div class="controls">
                            
                           
							<input  type="Date" name="IssuedDate" id="IssuedDate" /><b style="color: red"></b>
                        </div>
                    </div>
					

            <div class="control-group">
                <label class="control-label" for="form-field-7">Loan Amount</label>
                <div class="controls">
                    <input type="text"  name="LoanAmount" id="LoanAmount" required><b style="color: red">* Eg: 200000.00</b>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">No of Installments</label>
                <div class="controls">
                    <input type="text"  name="NoOFInstallment" id="NoOFInstallment" value="36" required><b style="color: red">* </b>
                </div>
            </div>
            <div class="control-group">
                        
                            <label class="control-label" for="Medium">Guarators(01 & 02)</label>
                                <div id="table_instructor22" class="controls">
								 <div id="table_instructor">
                                   <select id="Gaurators" name="Gaurators[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Two Guarantors..." >
								  
                                    @foreach($employees as $t)
									
                                    <option value="{{$t->id}}">{{$t->EPFNo}} - {{$t->Initials}} {{$t->LastName}}</option>
								  
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
					<option value="1">Completed</option>
					<option value="0" selected>Not Completed</option>
					</select><b style="color: red">*</b>
                </div>
            </div>
				

            <div class="control-group" >
                <div class="controls">
                    <input type="submit" class="btn btn-small btn-success"  value="Submit" />
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
 <script>
  
</script>
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
										var empidd = value = re[0];
										
											$.ajax({
													type: "GET",
													url: "{{url::to('LoadhrEmployeeGuarantorwithourOwner')}}",
													data: {id: empidd},
													//dataType: "json", 
													 success: function(result)
													{
													var html='<select id="Gaurators" name="Gaurators[]" multiple="multiple" class="chzn-select" data-placeholder="Choose Guarantors...>'+result+'</select>';
														
														 $("#table_instructor").html('');
														$("#table_instructor").append(html);
														$("#Gaurators.chzn-select").trigger("liszt:updated");
														$(".chzn-select").chosen(); 
														
													}
													});
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
							
                         


                          
							
                            
                            
                         
                           
</script>
