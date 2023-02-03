@include('includes.bar')  
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        Accreditation System Record 
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Accreditation System Record  Pending List
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            
            <div id="aaaa">
           
            <p><b>* පහත දක්වා ඇති පාඨමාලා සඳහා දැනට පවතින ප්‍රතීතන තත්වය  මෘදුකාංගයට ඇතුලත් කරන්න.</b></p>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
				<tr>
                        <th class='center'>No</th>
						<th class='center'>District</th>
						<th class='center'>Center</th>
						<th class='center'>Registration No</th>
						<th class='center'>Course</th>
                        <th class='center'>CourseListCode</th>
                        <th class='center'>Duration</th>
                        <th class='center'> NVQ Level</th>
                        <th class='center'>Accredit Status</th>
                       
                        
                        
                       
                        
                </tr>
                </thead>
                    <tbody>

                  <?php 
                  $SerialNo=1;
                  ?>
                @if(isset($sqlAccreditationTableListCount))
                
                
				@foreach($sqlAccreditationTableListCount as $t)

						
                        <tr>
                           
                            <td class="center"><font color="green">{{$SerialNo++}}</font></td>
							<td class="center"><font color="green">{{$t->DistrictName}}</font></td>
							<td class="center"><font color="green">{{$t->OrgaName}}({{$t->Type}})</font></td>
							<td class="center"><font color="green">{{$t->RegistrationNo}}</font></td>
							<td class="center"><font color="green">{{$t->CourseName}}</font></td>
							<td class="center"><font color="green">{{$t->CourseListCode}}</font></td>
							<td class="center"><font color="green">{{$t->Duration}}</font></td>
							<td class="center"><font color="green">{{$t->CourseLevel}}</font></td>
                            <td class="center"><font color="green">{{$t->Accredit}}</font></td>
						
                             
                          
                       </tr>
						

                
                    
               
               
                @endforeach
              
                

                

               
                @endif
            </tbody>
            </table>
            <!--PAGE CONTENT ENDS-->
            </div>
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
             {"bSortable": false},
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

 $(document).ready(function() { 
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
                    url: "{{url::to('GetEmpIdFromCenterMO')}}",
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
  });
</script>
<script type="text/javascript">


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

 $(".green").click(function(){

     var id = this.id;
     //alert(id);


     $.ajax  ({
                    url: "{{url::to('DDADConfirmMONewCenterMOnitoringPlan')}}",
                    data: { id: id},
                    
                   success: function(result) {

                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });
  
});
    
function doStuffWithResults(id,reason) {

     $.ajax  ({
                    url: "{{url::to('DDADRejectMONewCenterMOnitoringPlan')}}",
                    data: { id: id,reason: reason},
                    
                   success: function(result) {

                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });
   
}
    


</script>
