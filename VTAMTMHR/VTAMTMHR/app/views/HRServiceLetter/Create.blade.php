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
<a href="{{url('ViewHREmployeeServiceLettersIssued')}}"> << Back to HR - Employee Service Letters  </a> 
<div class="page-content">
    <div class="row-fluid">
        <div class="span10">
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    HR - Employee Service Letters
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeServiceLetters')}}" method="POST" />
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
                               SErvice Letter  Added Successfully 
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
                              Error Occured!!!!!!
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
                <label class="control-label" for="form-field-3">Date Issued</label>
                <div class="controls">
                    <input type="date" name="DateIssued" id="DateIssued" required /><b style="color: red">*</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-3">Address Line 1</label>
                <div class="controls">
                   <textarea name="AddressLine1" id="AddressLine1" ></textarea><b style="color: red">*</b>
                </div>
            </div> 
			<div class="control-group">
                <label class="control-label" for="form-field-3">Address Line 2</label>
                <div class="controls">
                   <textarea name="AddressLine2" id="AddressLine2" ></textarea><b style="color: red">*</b>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="form-field-3">Address Line 3</label>
                <div class="controls">
                   <textarea name="AddressLine3" id="AddressLine3" ></textarea><b style="color: red">*</b>
                </div>
            </div>	
             <div class="control-group">
                <label class="control-label" for="form-field-3">Address Line 4</label>
                <div class="controls">
                   <textarea name="AddressLine4" id="AddressLine4" ></textarea><b style="color: red">*</b>
                </div>
            </div>				
			 <div class="control-group">
                <label class="control-label" for="form-field-3">Address Line 5</label>
                <div class="controls">
                   <textarea name="AddressLine5" id="AddressLine5" ></textarea><b style="color: red">*</b>
                </div>
            </div>	
				<div class="control-group">
                <label class="control-label" for="form-field-3">Address Line 6</label>
                <div class="controls">
                   <textarea name="AddressLine6" id="AddressLine6" ></textarea><b style="color: red">*</b>
                </div>
            </div>	
			<div class="control-group">
                <label class="control-label" for="form-field-3">Signature</label>
                <div class="controls">
                   <select name="Signature" id="Signature" required="true">
				   <option value="">--- Select Signature ---</option>
				   <option value="1">Mr.G.V.P.N.Perera(Director Admin)</option>
				   <option value="2">Mr.S.Rathnayaka(Deputy Director Admin)</option>
				   <option value="3">Mrs.W.M.A.S.L.Wijenayake(Deputy Director Admin)</option>
				   </select><b style="color: red">*</b>
                </div>
            </div>			
			

            <div class="control-group">
                <div class="controls">
                       <button type="button" id="upload" class="btn btn-pink">
						<i class="icon-print bigger-200"></i>Print MCQ Paper</button>
						<span id='img4'></span>
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
 $(document).ready(function() {

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
										
                                    },
                                    complete: function() {
                                        document.getElementById('ajax_img1').innerHTML = "";
                                    }
                                });
                            });


$('#upload').click(function()
    {
      
      
		
		
		var EmpId = $("#EmpId").val(); 
		var DateIssued = $("#DateIssued").val();
	    var AddressLine1 = $("#AddressLine1").val();
	
	    var AddressLine2 = $("#AddressLine2").val();
	     var AddressLine3 = $("#AddressLine3").val();
		 var AddressLine4 = $("#AddressLine4").val();
		 var AddressLine5 = $("#AddressLine5").val();
		 var AddressLine6 = $("#AddressLine6").val();
		var Signature = $("#Signature").val();
   //   alert(EmpId); 
   
   
   
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('DownloadHREmployeeServiceLetter')}}",
                        data: {EmpId: EmpId,DateIssued: DateIssued,AddressLine1: AddressLine1,AddressLine2: AddressLine2,AddressLine3: AddressLine3,AddressLine4,AddressLine5,AddressLine6,Signature: Signature},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    ); 


                          
							
                            
 });                           
                         
                           
</script>
<script type="text/javascript">





</script>
