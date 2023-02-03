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
                        Retirements For Next 3 Months
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Retirements List
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            
            <div id="aaaa">
           
            <p><b></b></p>
			 <div class="control-group">
                <div class="controls">
                       
                        <button type="button" class="btn btn-pink" onclick="downloadReport()">Download Retirement List</button>
                    </div>
            </div>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
               <thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                        <th rowspan="2">EPF No</th>
						<th rowspan="2">NIC[Old NIC]</th>
                        <th rowspan="2">Full Name</th>
						<th rowspan="2">Name with Initials</th>
                        <th rowspan="2">District</th>
						<th rowspan="2">To Center(Type)</th>
                        <th rowspan="2">To Department</th>
                        <th rowspan="2">Transfer Type</th>
                        <th rowspan="2">New Post</th>
                        <th rowspan="2">Employee Type</th>
						<th rowspan="2">Effective Date</th>
                        
                        <th colspan="5" style="text-align: center;">Starting Salary Details</th>
						<th colspan="5" style="text-align: center;">Present Salary Details</th>
                        <th rowspan="2">Increment Month</th>
                        <th rowspan="2">Increment Day</th>
						<th rowspan="2">Confirmation Date</th>
						<th colspan="3" style="text-align: center;">Gratuity/EFT/EPF Details</th>
                        <th rowspan="2">Date Of Retirement</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Service Category</th>
                        <th style="text-align: center;">Salary Code</th>
						<th style="text-align: center;">Salary Scale</th>
						<th style="text-align: center;">Salary Step</th>
						<th style="text-align: center;">Grade</th>
						
						 <th style="text-align: center;">Service Category</th>
                        <th style="text-align: center;">Salary Code</th>
						<th style="text-align: center;">Salary Scale</th>
						<th style="text-align: center;">Salary Step</th>
						<th style="text-align: center;">Grade</th>
						
						<th style="text-align: center;">Gratuity Amount</th>
						<th style="text-align: center;">ETF Released Date</th>
						<th style="text-align: center;">EPF Released Date</th>
                    </tr>
                </thead>
                    <tbody>

                  <?php 
                  $SerialNo=1;
                  ?>
                @if(isset($sqlIncrementList))
                
               
				@foreach($sqlIncrementList as $pr)

						
                        <tr>
                             <td class="center">{{$SerialNo++}}</td>
                            
						<td>{{$pr->EPF}}</td>
						<td>@if($pr->NIC != $pr->OldNIC)
						 {{$pr->NIC}} [{{$pr->OldNIC}}] 
						@else
						 {{$pr->NIC}}
						@endif</td>
						<td>{{$pr->Name}} {{$pr->LastName}}</td>
						<td>{{$pr->Initials}} {{$pr->LastName}}</td>
						<td>{{$pr->DistrictName}}</td>
						<td>{{$pr->OrgaName}}({{$pr->Type}})</td>
						<td>{{$pr->DepartmentName}}</td>
						<td>{{$pr->TransferType}}</td>
						<td>{{$pr->Designation}}</td>
						<td>{{$pr->EmployeeType}}</td>
						<td>{{$pr->StartDate}}</td>
						<td>{{$pr->ServiceCategory}}</td>
						<td>{{$pr->SalaryCode}}</td>
						<td>{{$pr->SalaryScale}}</td>
						
						<?php 
						if(!empty($pr->SalaryStep ))
						{
						 $salsteptrans = HRSalaryStepTrans::where('id','=',$pr->SalaryStep)->first();
						}
						else
						{
							$salsteptrans="";
						}
						?>
						<td>
						@if($pr->SalaryStep != '')
						No.{{$salsteptrans->StepNo}}-{{$salsteptrans->StepAmount}}/=
						@if($salsteptrans->EBAvailable == 1)
							(EB Available)
							@else
								@endif
							@else
								@endif
						</td>
						<td>{{$pr->Grade}}</td>
						
						<td>{{$pr->PServiceCategory}}</td>
						<td>{{$pr->PSalaryCode}}</td>
						<td>{{$pr->PSalaryScale}}</td>
						
						<?php 
						if(!empty($pr->PSalaryStep) || $pr->PSalaryStep != 0)
						{
						 $salsteptransP = HRSalaryStepTrans::where('id','=',$pr->PSalaryStep)->first();
						}
						else
						{
							$salsteptransP="";
						}
						?>
						<td>
						@if($pr->PSalaryStep != '' || $pr->PSalaryStep != 0)
						No.{{$salsteptransP->StepNo}}-{{$salsteptransP->StepAmount}}/=
						@if($salsteptransP->EBAvailable == 1)
							(EB Available)
							@else
								@endif
							@else
								@endif
						</td>
						<td>{{$pr->PGrade}}</td>
						
						
						<td>{{$pr->IncrementMonth}}</td>
						<td>{{$pr->IncrementDay}}</td>
						<td>{{$pr->ConfirmationDate}}</td>
						<td>{{$pr->GratuityAmount}}</td>
						<td>{{$pr->ETFReleasedDate}}</td>
						<td>{{$pr->EPFReleasedDate}}</td>
						<td>{{$pr->retdate}}</td>
						
               
                          
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

function downloadReport() 
 {
   
 
        window.location.replace("DownloadRetirementList");
        bootbox.alert('Please wait few seconds');
    

}
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
            {"bSortable": false},  {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},
                                {"bSortable": false},{"bSortable": false}, {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
                               {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false}
            
           
    ]});
 
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
