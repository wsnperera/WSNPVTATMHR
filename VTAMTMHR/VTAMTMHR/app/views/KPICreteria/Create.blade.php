@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<a href="{{url('ViewHREmployeeKPICriterias')}}"> << Back to KPI Criteria </a> 
<div class="page-content">
    <div class="row-fluid">
        <div >
            <!--PAGE CONTENT BEGINS-->
            <!--/.page-header-->
            <div class="page-header position-relative">
                <h1>
                    KPI Creteria
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Create
                    </small>			
                </h1>

            </div><!--/.page-header-->

            <form class="form-horizontal" action="{{url('CreateHREmployeeKPICriterias')}}" method="POST" />
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
                               Criteria  Added Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>

           <?php 
		   
		   $userTypeID = User::getSysUser()->userType;
		   $UserTypeName = UserType::where('id','=',$userTypeID)->pluck('UType');
			?>
          
			
			
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
                <label class="control-label" for="form-field-10">Criteria In English</label>
                <div class="controls">
                    <textarea type="text" rows="3" name="Criteria" id="Criteria"></textarea>
                </div>
            </div>
			<div class="control-group">
                    <label class="control-label" >Weight for the Criteria: </label>
                        <div class="controls" id="Trade">
                            <input type="text" name="Fweight" id="Fweight" required="true">
                           
                        </div>         
                 </div>

           


            <div class="control-group" >
                <div class="controls">
                    <input type="button" class="btn btn-small btn-success"  onclick="saveAll()" value="Save" />
                </div>
            </div>

            </form>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
        
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   
<script src="assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
                           



                          
							
                            
                            
                         
          function saveAll(){
        var EmpId = document.getElementById('EmpId').value;
        var Criteria = document.getElementById('Criteria').value;
        var Fweight = document.getElementById('Fweight').value;
		
		
		  if(EmpId == '' || Criteria == '' || Fweight == '')
		  {
			  bootbox.alert('Please Fill all the details required!!!!');
		  }
		  else if(Fweight == 0)
		  {
			  bootbox.alert('Weight must be greater than 0 !!!!');
		  }
       else
	   {
        
        $.ajax({
            type: "POST",
            url: "{{url::to('KPICriteriasaveAll')}}",
            data: {EmpId: EmpId,Criteria: Criteria,Fweight: Fweight},
            dataType: 'json',
            success: function(result) {

                //$('#ajaxerror').html(result.done);
				bootbox.alert(result.done);
				document.getElementById('Criteria').value = "";
				document.getElementById('Fweight').value = "";
				
              

            }
            });
			
	   }

    }                     
</script>
