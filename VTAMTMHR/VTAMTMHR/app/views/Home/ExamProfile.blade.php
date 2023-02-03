@include('includes.bar')  
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<style type="text/css">
 body {
            background-image:url("assets/VTA.jpg");
            opacity: 0.9;
			background-repeat: no-repeat;
            background-size: 45%;
			background-position: center;  
}
</style>
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            
            <!--PAGE CONTENT BEGINS-->
			<body>
            <form class='form-horizontal'>
			 <div class="control-group">
                   
                    <div class="controls">
			
							<div class="col-sm-7 infobox-container">
										
									
									<!--	<div class="infobox infobox-red">
											<div class="infobox-icon">
											
												<img src="{{Url('assets/alertgif.gif')}}" height="80" width="80"/>
												
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"></span>
												<div class="infobox-content"><a href="{{url('InstantCenterApprovals')}}">Pending Center Approvals</a></div>
											</div>

											
										</div>

										<div class="infobox infobox-blue2">
											<div class="infobox-icon">
											<i class="icon-envelope"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"></span>
												<div class="infobox-content"><a href="{{url('ViewMyComments')}}">Comment Handling Request</a></div>
											</div>

											
										</div>
										
										<div class="infobox infobox-green">
											<div class="infobox-icon">
											
												<i class="icon-cloud-upload"></i>
												
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"></span>
												<div class="infobox-content"><a href="{{url('InstantAccreditationApplication')}}">Accreditation Application</a></div>
											</div>

											
										</div>
										
										<div class="infobox infobox-purple">
											<div class="infobox-icon">
											
												<i class="icon-flag"></i>
												
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"></span>
												<div class="infobox-content"><a href="{{url('InstantAccreditationRecordPending')}}">Pending Accredit Record</a></div>
											</div>

											
										</div>
										<div class="infobox infobox-orange">
											<div class="infobox-icon">
											
												<i class="icon-book"></i>
												
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"></span>
												<div class="infobox-content"><a href="{{url('InstantAccreditationAppliRecordPending')}}">Pending Application record</a></div>
											</div>

											
										</div>
										
										
										@if($user->hasPermission('CreateAccreditationPaymentNew'))
										<div class="infobox infobox-pink">
											<div class="infobox-icon">
											
												<i class="icon-usd"></i>
												
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"></span>
												<div class="infobox-content"><a href="{{url('InstantAccreditationPaymentPending')}}">Pending Accredit Payment</a></div>
											</div>

											
										</div>
										@endif
										

										<!--<div class="infobox infobox-pink">
											<div class="infobox-icon">
												<i class="icon-envelope"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">8</span>
												<div class="infobox-content">new orders</div>
											</div>
											<div class="stat stat-important">4%</div>
										</div>-->

										<!--<div class="infobox infobox-red">
											<div class="infobox-icon">
												<i class="icon-envelope"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">7</span>
												<div class="infobox-content">experiments</div>
											</div>
										</div>-->
										<!--<div class="infobox infobox-orange2">
											<div class="infobox-chart">
												<span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">6,251</span>
												<div class="infobox-content">pageviews</div>
											</div>

											<div class="badge badge-success">
												7.2%
												<i class="ace-icon fa fa-arrow-up"></i>
											</div>
										</div>-->

										
									<!--<div class="infobox infobox-blue2">
											<div class="infobox-progress">
												<div class="easy-pie-chart percentage" data-percent="42" data-size="46">
													<span class="percent">42</span>%
												</div>
											</div>

											<div class="infobox-data">
												<span class="infobox-text">traffic used</span>

												<div class="infobox-content">
													<span class="bigger-110">~</span>
													58GB remaining
												</div>
											</div>
										</div>-->

										

										

									

										
									<!--</div>-->
									
									 </div>
                
                </div> <!-- close alert div control group -->
				
            </form>
           </body>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(applicant, formobj)
    {
        bootbox.confirm("Are you sure you want to remove " + applicant, function(result)
        {
        if (result)
        {
        formobj.submit();
        }
        });
                return false;
    }
    
    $('#sample-table-2').dataTable({
    "aoColumns": [
             null,
            {"bSortable": false},
            {"bSortable": false},
             {"bSortable": false},

             {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
           {"bSortable": false},
           {"bSortable": false},
            
           
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
$("#District").change(function() 
	{
        var District = $("#District").val();
        $("#center").html('');
        //$("#CourseYearPlanID").html('');
        var msg = '--- Select Centre ---';
       
                          $.ajax({
                                        type: "GET",
                                        url: "{{url::to('loaddistrictcentersin')}}",
                                        data: {District: District},
                                        dataType: "json", 
                                        success: function(result) {
                                             $("#center").append("<option value=''>" + msg + "</option>");
                                                 $.each(result, function(i, item)
                                                {



                                                    $("#center").append("<option value=" + item.id + ">" +item.OrgaName + "(" + item.Type + ")</option>");



                                                });

                                        } 
                                });            

            
     
    });

  
    
/*$('#center').change(function(){

        //alert('dg');
       var center = document.getElementById('center').value; 
      
       var msg = '--- Select Course ---';
        $("#Course").html('');
       $.ajax  ({
                    url: "{{url::to('GetNominatedCourses')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Course").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Course").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });*/
  


    $('#upload').click(function()
    {
      
        var CS_ID = $("#CS_ID").val(); 
      // alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintAssessorAssignedLetter')}}",
                        data: {CS_ID: CS_ID},
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
    /*$('#reject').click(function()
    {
     
       var TID = document.getElementById('reject').value; 
       alert(TID);


      
          
        
    }
    );
    $('#reject1').click(function()
    {
     
       var TID = document.getElementById('reject1').value; 
       alert(TID);


      
          
        
    }
    );*/
     /* function addModule() {

        var TID = document.getElementById('reject').value; 
       alert(TID);

        /*$.ajax  ({
                    url: "{{url::to('')}}",
                    success: function(result) {
                        if ($('#addModule').is(':hidden')) {
                            $('#addModule').show();
                        } else {
                            $('#addModule').hide();
                        }
                    }
                });*/
 //   }
 $(".red").click(function(){

     var id = this.id;
     //alert(id);
bootbox.confirm("<form id='infos' action=''><div class='control-group'><div class='controls'>\
    Reason:<textarea cols='1000' rows='6' name='Reason' id='Reason'></textarea></div></div></form>", function(result) {
        if(result)
        {
            //$('#infos').submit();
           // alert(result);

         var reason = $("#Reason").val();
        // var g = $("#editComment").val();
         //alert(reason);


        doStuffWithResults(id,reason);
        }
});
  
});
    
function doStuffWithResults(id,reason) {

     $.ajax  ({
                    url: "{{url::to('DORejectAssignedAssessor')}}",
                    data: { id: id,reason: reason},
                    
                   success: function(result) {

                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });
   
}
    


</script>
