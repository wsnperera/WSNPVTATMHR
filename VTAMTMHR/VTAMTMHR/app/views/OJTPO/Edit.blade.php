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
<div class="page-content">                              
<div class="row-fluid">
<div class="span8">

    <!--PAGE CONTENT BEGINS-->
    <!--/.page-header-->

<div class="page-header position-relative">
<a href={{url('ViewAssignPODSDivitions')}}> << Back to View</a> 
     <h1>
   PO Details		
        <small>
                <i class="icon-double-angle-right"></i>
                Edit Assigned DS Divisions
        </small>			
        </h1>
        </div><!--/.page-header-->


                
                
<form class="form-horizontal" action="{{url('EditAssignPODSDivitions')}}" method="POST"/>
			<input type="hidden"  name="QO_ID" value="{{Request::get('id')}}" />
				<div class="control-group">
                    <label class="control-label" >District : </label>
                        <div class="controls" id="Trade">
                            <input type="text" name="District" id="District" value="{{$DistrictName}}" readonly/>
                                 <span style="color:red"></span>
                           
                        </div>         
                 </div>
				 
				<div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <input type="text" name="centerID" id="centerID" value="{{$currentOrga}}" readonly />
                          
                    </div>
                </div>
			
			  <div class="control-group">
                    <label class="control-label" for="centers">PO Name</label>
                    <div class="controls">
                        <input type="text" name="EmpId" id="EmpId" value="{{$Initials}} {{$LastName}}" readonly />
                    </div>
                </div>
				
				 <div class="control-group">
                        
                            <label class="control-label" for="Medium">DS Divisions</label>
                                <div id="table_instructor" class="controls">
							<select id="NVQPackage" name="NVQPackage[]" multiple="multiple" class="chzn-select" data-placeholder="Choose DS Divisions..." required>
							@foreach($electorate as $d)
                                <option value="{{$d->ElectorateCode}}">{{$d->ElectorateName}}</option>
                            @endforeach
							@foreach($AddedDs as $e)
                                <option value="{{$e->ElectorateCode}}" selected="true">{{$e->ElectorateName}}</option>
                            @endforeach
							</select><span style="color:red">*</span>
                                
                            </div>
                 </div>
				
				
			
			<div class="control-group">
                <label class="control-label" for="CourseListCode">Active Status: </label>
                <div class="controls">
                    <select name="Active" id="Active" required="true">
                        <option value="">--Select Active Status--</option>
						<option @if($quorg->Active==1) selected="true" @endif value="1">Yes</option>
						<option @if($quorg->Active==0) selected="true" @endif value="0">No</option>
                       
                    </select><span style="color:red">*</span>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div> 
				<div class="control-group">
				 <div class="controls">
				<input class="btn btn-small btn-warning" type="submit"  value="Update" />
				 </div>
				</div>

</div>

</form>
<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<div class="span4">
     @if ($errors->has())
@foreach ($errors->all() as $error)
    <div class='bg-danger alert'>{{ $error }}</div>
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

    $("#DistrictCode").change(function() {

        var d_code = document.getElementById('DistrictCode').value;

        $.ajax({
            url: "{{url::to('disLoadajax')}}",
            data: {d_code: d_code},
            success: function(result) {
                document.getElementById('elec_code').innerHTML = result;

            }

        });

    });
	</script>