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
<a href={{url('ViewAssignPODSDivitions')}}> << Back to View </a> 

<div class="page-content">

 <div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

    <div class="page-header position-relative">

        <h1>
   PO Details		
        <small>
                <i class="icon-double-angle-right"></i>
                Assign DS Divisions
        </small>			
        </h1>

</div><!--/.page-header-->
<form class="form-horizontal" action="{{url('CreateAssignPODSDivitions')}}" method="POST" />
   <div class="controls">

                @if(Session::has('done'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>
                                <i class="icon-ok"></i>
                               DS Divisions Assigned Successfully 
                            </strong>
                            <br>
                        </div>
                    @endif
                     </div>
    
				
				<div class="control-group">
                    <label class="control-label" >District : </label>
                        <div class="controls" id="Trade">
                            <select name="District" id="District" required>
                                 <option value="">--Select District--</option>
                                @foreach($Districts as $d)
                                <option value="{{$d->DistrictCode}}">{{$d->DistrictName}}</option>
                                @endforeach
                            </select><span style="color:red">*</span>
                           
                        </div>         
                 </div>
				 
				  <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="centerID" id="centerID" required="true">
                           
                        </select><span style="color:red">*</span>
                    </div>
                </div>
			
			    <div class="control-group">
                    <label class="control-label" for="centers">PO Name</label>
                    <div class="controls">
                        <select name="EmpId" id="EmpId" required="true">
                            
                        </select><span style="color:red">*</span>
                    </div>
                </div>
				 <div class="control-group">
                        
                            <label class="control-label" for="Medium">DS Divisions</label>
                                <div id="table_instructor" class="controls">
							<select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose DS Divisions..." required>
							@foreach($electorate as $d)
                                <option value="{{$d->ElectorateCode}}">{{$d->ElectorateName}}</option>
                            @endforeach
							</select><span style="color:red">*</span>
                                
                            </div>
                    </div>
				

				<div class="control-group">
                <label class="control-label" >Active Status:</label>
                <div class="controls">
                    <select name="Active" id="Active" required>
                        <option>--- Select Active Status ---</option>
                       
                        <option value="1">Yes</option>
						<option value="0">No</option>
						
                    </select><span style="color:red">*</span>
                </div>
            </div>
<div class="controls">
    <input type="submit" class="btn btn-small btn-primary"  value="Save" />
</div>
</form>
    <!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
    @if($errors->has())
        @foreach($errors->all() as $msg)
         <!-- Error Message -->

         <div class="alert alert-error">

         <button type="button" class="close" data-dismiss="alert">
          <i class="icon-remove"></i>
            </button>

             <strong> <i class="icon-remove"></i>{{$msg}}</strong>

              </div>

                 <!-- Error Message -->

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
   jQuery(document).ready(function() {
   
$(".chzn-select").trigger("liszt:activate");
$(".chzn-select").chosen(); 
});

    $("#courseCode").change(function()
    {
        if($("#courseCode").val()!='')
        {
            
            $("#placeHolder").html(html);
        }
        else
        {
            $("#placeHolder").html('');
        }
    });
    
</script>
<script type="text/javascript">

     $("#District").change(function() 
	{
        var District = $("#District").val();
        $("#centerID").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Centre ---';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('loaddistrictcentersin')}}",
                                        data: {District: District},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#centerID").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#centerID").append("<option value=" + item.id + ">" +item.OrgaName + "(" + item.Type + ")</option>");



                                                });

                                        } 
                                });            

            
     
    });
	
	$('#centerID').change(function(){

        //alert('dg');
       var center = document.getElementById('centerID').value; 
      
       var msg = '--- Select Name ---';
        $("#EmpId").html('');
       $.ajax  ({
                    url: "{{url::to('OJTGetEmpIdPO')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#EmpId").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#EmpId").append("<option value=" + item.id + ">" + item.Name + " "+item.LastName +" - (" + item.Designation + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
	</script>



