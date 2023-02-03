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
@if(isset($Issearch))

@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>Report<small><i class="icon-double-angle-right"></i>Service Category Wise Staff Report</small></h1>
        </div>
        <form name='search' action="{{url('ViewCoursePlanReportW')}}" method='POST' class="form-horizontal">
<!--            Search Module Course By Course List Code : <input type='text' name="key"/>   <input type='submit' value='Search'/>-->
            <!--<a href="{{url('CreateModuleTask')}}"><input type='button' value='Create Module Task' /></a>-->
            

        <div class="control-group">
                <label class="control-label" for="CourseListCode">District : </label>
                <div class="controls">
                    <select name="District" id="District" required>
                        <option value="">--Select District--</option>
                        <option value="All" selected>All</option>
                        @foreach($District as $lc)
                        <option value="{{$lc->DistrictCode}}">{{$lc->DistrictName}}</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                <!--    Duration <input id="Duration" placeholder="" type="text"> -->
                </div>
            </div> 
			  <div class="control-group">
                <label class="control-label" for="form-field-10">Service Category Year</label>
                <div class="controls">
                  <select name="SCYear" id='SCYear'>
				  <option value="">--- Select Category Year---</option>
                        @foreach($SCYears as $scy)
                        <option  value="{{$scy->Year}}">{{$scy->Year}}</option>
                        @endforeach
                    </select>
                     <b style="color: red">*</b>
                </div>
              </div> 
			  <div class="control-group">
                <label class="control-label" for="form-field-10">Service Category</label>
                <div class="controls">
                  <select name="ServiceCategoryID" id='ServiceCategoryID' >
				  <option value="">---Select Service Category---</option>
				  
				  
                    </select>
                   <b style="color: red">*</b>
                </div>
            </div>
			 <div class="control-group">
                <label class="control-label" for="form-field-10">Age Limit Below/Equal</label>
                <div class="controls">
                  <input name="Age" id='Age' type="text" value="60"/>
				 
				  
				  
                  
                    <b style="color: red">*</b>
                </div>
            </div>
				  <!--<div class="control-group">
                    <label class="control-label" for="centers">Year</label>
                    <?php  $year = date("Y"); ?>
                    <div class="controls">
                      <select name="Year" id="Year" required>
                            <option value="" required>--- Select Year ---</option>
                            <option value="{{$year}}">{{$year}}</option>
                            <option value="{{$year+1}}">{{$year+1}}</option>
                            <option value="{{$year+2}}">{{$year+2}}</option>
                            <option value="{{$year+3}}">{{$year+3}}</option>
                           
                          
                        </select> 
                    </div>
                </div>-->
				<!-- <div class="control-group">
                    <label class="control-label" for="centers">Batch:</label>
                    <div class="controls">
                        <select name="Batch" id="Batch" required>
                            <option value="" >--- Select Batch ---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
							 <option value="1.2">1.2</option>
                            <option value="2.2">2.2</option>
							
                          
                        </select>
                        <span id='img4'></span>
                    </div>
                </div>-->
             <!--given date range-->
                   <!-- <div class="control-group">

                        <label class="control-label" for="id-date-range-picker-1">Select Date Range : </label>

                        <div class="controls">
                            
                            <input class="span4" type="text" name="date-range-picker" id="id-date-range-picker-1"/>
                        </div>
                    </div>-->
           <!--Report type-->
           
                
            <div class="control-group">
                <div class="controls">
                        <button type="button" class="btn btn-pink" onclick="getTable()"/>View</button>
                            <button type="button" class="btn btn-pink" onclick="downloadReport()">Download Report</button>
                    </div>
            </div> 
			<center> <span id='img5'></span></center>
        </form>
		
        <hr/>
       
        <div class="span12" id="table">
         
            <!--PAGE CONTENT ENDS-->
           
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
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
<script type="text/javascript">
     

    function doConfirm(course,formobj)  {
        bootbox.confirm("Are you sure you want to remove "+course, function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
     }
     
      @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
$('#sample-table-2').dataTable({
    "aoColumns": [
            
    ]});
            $('table th input:checkbox').on('click', function() {
    var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
            .each(function() {
            this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
            });
    });
            $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
            function tooltip_placement(context, source) {
            var $source = $(source);
                    var $parent = $source.closest('table')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();
                    var off2 = $source.offset();
                    var w2 = $source.width();
                    if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                    return 'right';
                    return 'left';
            }


  

 </script>
 <script>
    $('#id-date-range-picker-1').daterangepicker().prev().on(ace.click_event, function () {
        $(this).next().focus();
    });
		
</script>
 <script type="text/javascript">
  $("#SCYear").change(function() {
        var cid = $("#SCYear").val();
        var msg = '---Select Service Category---';
		var All = 'All';
        $("#ServiceCategoryID").html('');
      
        $.ajax({
            type: "GET",
            url: "{{url::to('LoadAjaxServiceCategoryYear')}}",
            data: {SCYear: cid},
            success: function(result) {
                $("#ServiceCategoryID").append("<option value=''>" + msg + "</option>");
				$("#ServiceCategoryID").append("<option value='All'>" + All + "</option>");
			
                $.each(result, function(i, item)
                {



                   $("#ServiceCategoryID").append("<option value=" + item.id + ">" + item.ServiceCategory +  " [" + item.SalaryCode + "] -(" + item.SalaryScale+ ")</option>");



                });

            }
        });
    });
/*  $("#District").change(function() 
	{
        var District = $("#District").val();
        $("#CenterID").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Centre ---';
		var all = 'All';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('loaddistrictcentersin')}}",
                                        data: {District: District},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#CenterID").append("<option value=''>" + msg + "</option>");
											 $("#CenterID").append("<option value='All'>" + all + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#CenterID").append("<option value=" + item.id + ">" +item.OrgaName + "(" + item.Type + ")</option>");



                                                });

                                        } 
                                });            

            
     
    }); */
   
                                function getTable() {
                                    var District = $("#District").val();
									var ServiceCategoryID = $("#ServiceCategoryID").val();
									var Age = $("#Age").val();
									var SCYear = $("#SCYear").val();
									//var Year = $("#Year").val();
									//var Batch = $("#Batch").val();
                                  //  var dateRange = $("#id-date-range-picker-1").val();

                                       

                                    //alert(dateRange);

                                   // if (dateRange == "") {
                                   //     bootbox.alert("Please Enter Date Range!!!");
                                    //} else {

                                        $.ajax
                                                ({
													beforeSend: function()
													{
														
														document.getElementById('img5').innerHTML = "<img src=\"{{Url('assets/redballs.gif')}}\"/>";
													},
                                                    type: "GET",
                                                    url: "{{Url('LoadDistrictAgeServiceStaffReport')}}",
                                                    data: {District: District,ServiceCategoryID: ServiceCategoryID,Age:Age,SCYear:SCYear},
                                                    dataType: 'json',
                                                    success: function (result)
                                                    {

                                                        if (result.Count > 0) {
                                                            $('#table').html(''); 
                                                            $('#table').html(result.Table);
                                                        }
                                                        else {
                                                            $('#table').html(''); 
                                                            //alert("data not found");
															bootbox.alert("Data not found For ");
                                                        }

                                                    },
													complete: function() {
														document.getElementById('img5').innerHTML ="";

													}
                                                });
                                   // }
                                }
 </script>
 <script type="text/javascript">
 function downloadReport() {
                                    var District = $("#District").val();
									var ServiceCategoryID = $("#ServiceCategoryID").val();
									var Age = $("#Age").val();
									var SCYear = $("#SCYear").val();
									//var Year = $("#Year").val();
									//var Batch = $("#Batch").val();
                                   // var dateRange = $('#id-date-range-picker-1').val();
                                    //dateRange =1;
                                   // if (!dateRange) {
                                     //   $('#table').html('');
                                     //   bootbox.alert('Please select date range');

                                   // } 
									//else {
                                        window.location.replace("DownloadDistrictAgeServiceStaffReport?District=" + District + "&ServiceCategoryID=" + ServiceCategoryID + "&Age=" + Age + "&SCYear=" + SCYear +"");
                                        bootbox.alert('Please wait few seconds');
                                    //}

                                }
 </script>