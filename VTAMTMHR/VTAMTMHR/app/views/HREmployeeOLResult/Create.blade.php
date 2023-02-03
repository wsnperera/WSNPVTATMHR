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
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeOLResults')}}" method="POST" />
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
                               Employee O/L Results  Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
					@if(Session::has('Exist'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Employee O/L Results  Already Exist For Mentioned Year & the Attempt or You didn't mentioned any Subjects and Results!!!!!! 
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
                    <input type="text" name="NIC" id="NIC" readonly required/><b style="color: red">*</b>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-3">Employee Name</label>
                <div class="controls">
                   
					<textarea name="Ename" id="Ename" readonly></textarea>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Attempt</label>
                <div class="controls">
                    <select id="AttemptId" name="AttemptId"  required>
					<option value="">---Select Attempt---</option>
					@foreach($Attempt as $a)
					<option value="{{$a->id}}">{{$a->Attempt}}</option>
					@endforeach
					</select><b style="color: red">*</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Year</label>
                <div class="controls">
                    <input type="text" id="Year" name="Year" required /><b style="color: red">*</b>
					
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-7">Month</label>
                <div class="controls">
                    <Select id="Month" name="Month" required >
					<option value="">--- Select month ---</option>
					<option value="August">August</option>
					<option value="December">December</option>
					</select>
					<b style="color: red">*</b>
					
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-7">Centre No</label>
                <div class="controls">
                    <input type="text" id="CentreNo" name="CentreNo" /><b style="color: red"></b>
					
                </div>
            </div>
			  <div class="control-group">
                <label class="control-label" for="form-field-7">Index No</label>
                <div class="controls">
                    <input type="text" id="Index" name="Index" required /><b style="color: red">*</b>
					
                </div>
            </div>
			
			<div class="control-group">
                <label class="control-label" for="form-field-7">Medium</label>
                <div class="controls">
                    <select id="MediumId" name="MediumId" required>
					<option value="">---Select Medium---</option>
					@foreach($Mediums as $m)
					<option value="{{$m->id}}">{{$m->Medium}}</option>
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
				<tr>
				<td>1</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
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
				<tr>
				<td>2</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
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
				<tr>
				<td>3</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
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
				<tr>
				<td>4</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
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
				<tr>
				<td>5</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
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
				<tr>
				<td>6</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
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
				<tr>
				<td>7</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
								@endforeach
							</select> <b style="color: red"></b>
						
					
				</td>
				<td class="center">
					
					
							<select class="chzn-select" style="width: 100px" name="Result[]" id="Result[]" >
								<option value="">--Result--</option>
							   @foreach ($grades as $g)
								<option  value="{{$g->id}}">{{$g->Grade}}</option>
								@endforeach
							</select><b style="color: red"></b><span id="ajax_img2"></span>
						
					
           
				</td>
				</tr>
				<tr>
				<td>8</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
								@endforeach
							</select> <b style="color: red"></b>
						
					
				</td>
				<td class="center">
					
					
							<select class="chzn-select" style="width: 100px" name="Result[]" id="Result[]" >
								<option value="">--Result--</option>
							   @foreach ($grades as $g)
								<option  value="{{$g->id}}">{{$g->Grade}}</option>
								@endforeach
							</select><b style="color: red"></b><span id="ajax_img2"></span>
						
					
           
				</td>
				</tr>
				<tr>
				<td>9</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
								@endforeach
							</select> <b style="color: red"></b>
						
					
				</td>
				<td class="center">
					
					
							<select class="chzn-select" style="width: 100px" name="Result[]" id="Result[]" >
								<option value="">--Result--</option>
							   @foreach ($grades as $g)
								<option  value="{{$g->id}}">{{$g->Grade}}</option>
								@endforeach
							</select><b style="color: red"></b><span id="ajax_img2"></span>
						
					
           
				</td>
				</tr>
				<tr>
				<td>10</td>
				<td>
					
				     <select  class="chzn-select" name="QO_ID[]"  id="QO_ID" >
								<option value="">--Select Subject--</option>
								@foreach ($subjects as $qo)
								<option  value="{{$qo->id}}">{{$qo->Subject}}</option>
								@endforeach
							</select> <b style="color: red"></b>
						
					
				</td>
				<td class="center">
					
					
							<select class="chzn-select" style="width: 100px" name="Result[]" id="Result[]" >
								<option value="">--Result--</option>
							   @foreach ($grades as $g)
								<option  value="{{$g->id}}">{{$g->Grade}}</option>
								@endforeach
							</select><b style="color: red"></b><span id="ajax_img2"></span>
						
					
           
				</td>
				</tr>
				</tbody>
				</table>
			   </div>
			</div>
            
			
				

           
           
		

            <div class="control-group" >
                <div class="controls" >
				
                    <input type="submit" class="btn btn-block btn-pink"  value="Save" />
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
										var empidd = re[0];
										$("#AttemptId").html('');
										var msg = '---Select Attempt---';
										$.ajax({
													type: "GET",
													url: "{{url::to('HREmployeeOLResultsCheckAttept')}}",
													data: {id: empidd},
													//dataType: "json", 
													 success: function(result)
													{
														 $("#AttemptId").append("<option value=''>" + msg + "</option>");
			
														$.each(result, function(i, item)
														{



														   $("#AttemptId").append("<option value=" + item.id + ">" + item.Attempt + "</option>");



														});
														
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
                                //$("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });
							
                            $("[id^='Result']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#Result_chzn").find('input').val()).text($("#Result_chzn").find('input').val());

                                $("#Result.chzn-select").prepend(option);
                                $("#Result.chzn-select").find(option).prop('selected', true);
                                $("#Result.chzn-select").trigger("liszt:updated");
                            });
							
							


                          
							
                            
                            
                         
                           
</script>
