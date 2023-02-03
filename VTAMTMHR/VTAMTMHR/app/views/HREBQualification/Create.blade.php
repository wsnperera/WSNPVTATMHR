@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployeeEBQualification')}}"> << Back to Employee EB Qualification </a> 
<div class="page-content">
    <div class="row-fluid">
        <div >
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    Employee EB Qualification		
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeEBQualification')}}" method="POST" />
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
                               Employee EB Qualification  Added Successfully 
                            </strong>
                            <br>
                        </div>
						
                    @endif
					@if(Session::has('Exit'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               Already Exist Employee EB Qualification :(   
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
                <label class="control-label" for="form-field-6">Grade</label>
                <div class="controls" >
                    <select name="GradeID" id="GradeID" required>
                        <option value="">--Select Grade--</option>
                       @foreach ($grades as $qo)
                        <option  value="{{$qo->id}}">{{$qo->Grade}}</option>
                        @endforeach
                    </select><b style="color: red">*</b><span id="ajax_img2"></span>
                </div>
				</div>
          
           

           
			
            <div class="control-group">
                <label class="control-label" for="form-field-7">Date Qualified</label>
                <div class="controls">
                    <input type="Date"  name="DateQualified" id="DateQualified" required /><b style="color: red">*</b>
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

                            

                          
							
                   
</script>
