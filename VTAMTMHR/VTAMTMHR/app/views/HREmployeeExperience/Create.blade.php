@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployeeExperience')}}"> << Back to Employee Experience </a> 
<div class="page-content">
    <div class="row-fluid">
        <div >
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee Experience	
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeExperience')}}" method="POST" />
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
                               Employee Experience  Added Successfully 
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
                <label class="control-label" for="form-field-4">Organisation Name</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID" onload="" id="QO_ID" required>
                        <option value="">--Select Company--</option>
                        @foreach ($quaorg as $qo)
                        <option  value="{{$qo->id}}">{{$qo->CompanyName}}</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                </div>
            </div>
			
			<div class="control-group">
                <label class="control-label" for="form-field-6">Designation</label>
                <div class="controls" >
                    <select class="chzn-select" name="DesignationID" id="DesignationID" onload="" required>
                        <option value="">--Select Designation--</option>
                       @foreach ($Designation as $qo)
                        <option  value="{{$qo->id}}">{{$qo->Designation}}</option>
                        @endforeach
                    </select><b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-6"></label>
                <div class="controls" >
                   <b style="color: red">* Please Fill Date Joined & Date Resgned Details OR No Of Service Years & Months</b>
                        
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-6">Date Joined</label>
                <div class="controls" >
                    <input name="DateJoined" id="DateJoined" type="date" /><b style="color: red">*</b>
                        
                </div>
            </div>
				
            <div class="control-group">
                <label class="control-label" for="form-field-6">Date Resigned</label>
                <div class="controls" >
                    <input name="DateResigned" id="DateResigned" type="date" /><b style="color: red">*</b>
                        
                </div>
            </div>
	<hr/>
	
		  <div class="control-group">
                <label class="control-label" for="form-field-7">No Of Years</label>
                <div class="controls">
                    <input type="text" name="Years" id="Years"  value="0" style="width:45px;height: 20px" ><b style="color: red"></b>
                    <span>  & No Of Month
                          <input type="text" name="Months" id="Months" value="0" style="width:45px;height: 20px" ><b style="color: red"></b><b style="color: red"></b></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="form-field-7">Reason To Leave</label>
                <div class="controls">
                    <textarea type="text" rows="5" name="Reason"></textarea>
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
							
                            $("[id^='DesignationID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#DesignationID_chzn").find('input').val()).text($("#DesignationID_chzn").find('input').val());

                                $("#DesignationID.chzn-select").prepend(option);
                                $("#DesignationID.chzn-select").find(option).prop('selected', true);
                                $("#DesignationID.chzn-select").trigger("liszt:updated");
                            });


                          
							
                            
                            
                         
                           
</script>
