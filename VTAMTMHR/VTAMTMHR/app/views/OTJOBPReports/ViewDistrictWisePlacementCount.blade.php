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
        <div class="page-header position-relative">
            <h1>JOBP Reports<small><i class="icon-double-angle-right"></i>District Wise Job Placement Count Report</small></h1>
        </div>
        <form name='search' class="form-horizontal">

            

			 
				 <div class="control-group">
                    <label class="control-label" for="centers">Year</label>
                    <?php  $year = date("Y"); ?>
                    <div class="controls">
                      <select name="Year" id="Year" required>
                            <option value="" required>--- Select Year ---</option>
						@foreach($YearList as $yl)
								<option value="{{$yl}}">{{$yl}}</option>
								 @endforeach
                           
                          
                        </select> 
                    </div>
                </div>
				
				  <div class="control-group">
                    <label class="control-label" for="centers">Batch</label>
                 
                    <div class="controls">
                      <select name="Batch" id="Batch" required>
                            <option value="" required>--- Select Batch ---</option>
							<option value="All">All</option>
							 <option value="1">1</option>
                            <option value="1.2">1.2</option>
                            <option value="2">2</option>
                            <option value="2.2">2.2</option>

                        </select> 
                    </div>
                </div>
				
          
           
                
            <div class="control-group">
                <div class="controls">
                        <button type="button" class="btn btn-primary" onclick="getTable()"/>View</button>
                        <button type="button" class="btn btn-primary" onclick="downloadReport()">Download Report</button>
                    </div>
            </div> 
			 <center><span id='img5'></span></center>
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
 
   
                                function getTable() {
                                    var Batch = $("#Batch").val();
									var Year = $("#Year").val();
									

                                       

                                    //alert(dateRange);

                                    if (Year == "" || Batch == "") 
									{
                                        bootbox.alert("Please Enter All Details!!!");
                                    } 
									else 
									{

                                        $.ajax
                                                ({
													beforeSend: function()
													{
														document.getElementById('img5').innerHTML = "<img src=\"{{Url('assets/redballs.gif')}}\"/>";
													},
                                                    type: "GET",
                                                    url: "{{Url('LoadJOBPDistrictWiseCountReport')}}",
                                                    data: {Batch: Batch,Year: Year},
                                                    dataType: 'json',
                                                    success: function (result)
                                                    {

                                                        if (result.Count > 0) {
                                                            $('#table').html(''); 
                                                            $('#table').html(result.Table);
                                                        }
                                                        else {
                                                            $('#table').html(''); 
                                                            alert("data not found");
                                                        }

                                                    },
													complete: function() {
														document.getElementById('img5').innerHTML ="";

													}
                                                });
                                    }
                                }
 </script>
 <script type="text/javascript">
 function downloadReport() {
                                    var Batch = $("#Batch").val();
									var Year = $("#Year").val();
									

                                       

                                    //alert(dateRange);

                                    if (Batch == "" || Year == "") 
									{
                                        bootbox.alert("Please Enter All Details!!!");
                                    } 
									else 
									{
                                        window.location.replace("DownloadJOBPDistrictWiseCountReportExcel?Batch=" + Batch + "&Year=" + Year + "");
                                        bootbox.alert('Please wait few seconds');
                                    }

                                }
 </script>