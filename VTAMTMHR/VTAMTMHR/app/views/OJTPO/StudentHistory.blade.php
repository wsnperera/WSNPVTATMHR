@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" /> 
@if(isset($Issearch))
<a href="{{url('ViewMyOJTStudents')}}"> << Back to OJT Student History</a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            IR PO - OJT Student History	
            <small>
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>

    </div><!--/.page-header-->
    <div class="row-fluid">
			<form class="form-horizontal" action="" method="POST" name="form1"  >
				<table>
					<tr>
					<td>
					  <div class="control-group">
							<label class="control-label" for="form-field-1"></label>
								<div class="controls">
								<select id="SType" name="SType" required>
								<option value="">---Select Type---</option>
								<option value="NIC">Search using NIC</option>
								<option value="MIS">Search using MIS No</option>
								</select>
								<input type="text" name="NIC" id="NIC" placeholder="Type NIC/MIS No Here....." required/> 
								<input type="submit"  value="Search OJT Student" class="btn btn-small btn-warning"/>
								</div>
					  </div>
					</td>
						
				   
							
				   
						
					</tr>
				</table>
			</form>
        
      
	  <hr/>
     @if(isset ($Employeerec))
	  <br/>
	      <div class="span10">
        <div class="well well-small"><b><font face="verdana" color="green">Trainee Details</font></b></div>
    </div>

    

    <div class="span10"> 

        <table style="width:100%">
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Name With Initials
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$Employeerec->NameWithInitials}}</font></b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Names Represented by Initials
                    </h5>
                </td>
                <td>:-</td> 
                <td><b><font face="verdana" size="2" color="black">{{$Employeerec->FullName}}</font></b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            NIC Number  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->NIC}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            MIS Number  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->MISNumber}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
            
            
           <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Mobile  
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->Mobile}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
            <tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Address 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->Address}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
			<tr>
                <td>
                    <h5 class="blue smaller">
                        <i class=" icon-check"></i>&emsp;
                            Gender 
                    </h5>
                </td>
                <td>:-</td> 
                <td><b>
				
				<font face="verdana" size="2" color="black">{{$Employeerec->Gender}}</font>&nbsp;&nbsp;&nbsp;
			 
				
				</b></td>
            </tr>
           
            
          
        </table>
		<br/><br/>
    </div>
    @endif
    
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
			 @if(isset ($promotion))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                        <th rowspan="2">No</th>
						
                        <th colspan="5" class="center">Course Details</th>
                        <th colspan="6" class="center">Company Details</th>
                        <th rowspan="2">Active Status</th>
						<th colspan="4">Student's Current Status</th>
						
						<th colspan="4">Monitoring Details During OJT</th>
					
						<th rowspan="2" class="center">Remove</th>
						
                    </tr>
                    <tr>
					    <th class="center">District</th>
                        <th class="center">Center</th>
						<th class="center">Year</th>
						<th class="center">Batch</th>
						<th class="center">Course</th>
						
						<th class="center">Company Name</th>
						<th class="center">Address</th>
						<th class="center">Job Category</th>
						<th class="center">Start Date</th>
						<th class="center">End Date</th>
						<th class="center">Allowence Per Month</th>
                       
                       <th class="center">OJT Placed</th>
						<th class="center">OJT Completed</th>
						<th class="center">OJT Dropout</th>
						<th class="center">Reason For Dropout</th>
						
						 <th class="center">Date Monitored</th>
						<th class="center">Trainee Attendence</th>
						<th class="center">Trainee Satisfaction</th>
						<th class="center">Monitored By</th>
						
						
						
                       
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($promotion as $eq)

                    <tr>
                       <td> <?php echo $i++ ?></td>
                     
                   
                        <td>{{$eq->DistrictName}}</td>
						<td>{{$eq->OrgaName}}</td>
						<td>{{$eq->Year}}</td>
						<td>{{$eq->batch}}</td>
						<td>{{$eq->CourseName}}</td>
						<td>{{$eq->CompanyName}}</td>
						<td>{{$eq->Address}}</td>
                        <td>{{$eq->Category}}</td>
						<td>{{$eq->StartingDate}}</td>
						<td>{{$eq->EndDate}}</td>
						<td>{{$eq->Salary}}</td>
						<td>@if($eq->Active == 1)<font color="green"><i class="icon-ok bigger-130"></i></font> @else <font color="red"><i class="icon-remove bigger-130"></i></font> @endif</td>
						<td>@if($eq->OJTPlaced == 1)<font color="green"><i class="icon-ok bigger-130"></i></font> @else <font color="red"><i class="icon-remove bigger-130"></i></font> @endif</td>
				        <td>@if($eq->OJTCompleted == 0) <font color="red"><i class="icon-remove bigger-130"></i></font> @else <font color="green"><i class="icon-ok bigger-130"></i></font> @endif</td>
						<td>@if($eq->Dropout == 1)<font color="green"><i class="icon-ok bigger-130"></i></font> @else <font color="red"><i class="icon-remove bigger-130"></i></font> @endif</td>
						<td>{{$eq->ReasonForDropoutOJT}}</td>
						
						<td>{{$eq->DateVisited}}</td>
						<td>@if($eq->TraineeAttendence == 0) Absent @else Present @endif</td>
						<td>@if($eq->TraineeSatisfaction == 1) Very Satisfied 
						    @elseif($eq->TraineeSatisfaction == 2) Satisfied
							@elseif($eq->TraineeSatisfaction == 3) Neutral
							@elseif($eq->TraineeSatisfaction == 4) Dissatisfied
							@elseif($eq->TraineeSatisfaction == 5) Very Dissatisfied
							@else None
							@endif
						</td>
						<td>{{$eq->Initials}} {{$eq->LastName}}({{$eq->porga}})</td>
						
						
                  
                       
						
                     <td>
						@if($user->hasPermission('DeleteOJTStudentsPOMonitoringHistory'))
							 <form id="deleteform"  action='DeleteOJTStudentsPOMonitoringHistory' method="POST" onsubmit="return doConfirm('{{$eq->DateVisited}}',this)">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                            </form>
						@endif
						</td>
                       
                      
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
			 @endif
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer')   
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">

                                function doConfirm(promotion, formobj) {
                                bootbox.confirm("Are you sure you want to remove promotion record of" + promotion, function(result){
                                if (result){
                                formobj.submit();
                                }
                                });
                                        return false; // by default do nothing hack :D
                                }

                       $('#sample-table-2').dataTable({
                                        "aoColumns": [
                                         {"bSortable": false}, {"bSortable": false},
                                         {"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false}
                                        ,{"bSortable": false} ,{"bSortable": false} ,{"bSortable": false} ,{"bSortable": false}
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

$("#EmpSearch").click(function() {
    var EPFNo =$('#EPFNo').val();
    alert(EPFNo);
                   
                      // var id=document.getElementById('sid').value;
                       //var ccode=document.getElementById('CourseCode').value;
                      // var form =$("#please").serializeArray();
                
                //alert('dghsg');   
                     $.ajax({
                        url: "{{url('pleaseSubmitForm')}}",
                        type: "POST",
                        data: form,

                       
                                success: function(result) {
                                 response(result.print);
                             window.location.replace("{{url('viewFees')}}");
                             
                                
                                }
                               
                          
                    });
                 
                });

</script>
<script type="text/javascript">
 $(document).ready(function() {
	 
	 $(".green").click(function(){

     var id = this.id;
     //alert(id);
	 
	  var x = '<form id="infos" action="" style="border-style: solid;border-color: green green green green;border-width: thick;">'
      + '<table'
      + 'boder="2" cellspacing="2"><div class="control-group"><div  class="controls"><tr>'
      + '<td cellspacing="2"><br/>&nbsp&nbspComment:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea cols="4000" rows="6" name="Reason" id="Reason" placeholder="Please Type In English"></textarea></td></tr></div></div><table></form>';
	  
	  
 bootbox.confirm(x, function(result) {
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
	
	//alert(id);

     $.ajax  ({
                    url: "{{url::to('AddOJTStudentDropout')}}",
                    data: { id: id,reason: reason},
                    
                   success: function(result) {

                        //alert(result);
						 
                       //location.reload();  
					   bootbox.alert('OJT Dropout Added Successfully!!!');
					   location.reload();
					  
                        
                        }


                    
                });
   
}
$(".pink").click(function(){

     var id = this.id;
    // alert(id);
	 
     $.ajax({
                    url: "{{url::to('HREmployeeOLResultsSheet')}}",
                    data: {id: id},
                     dataType: "json", 
                   success: function(result) {
					   var c=1;
						var x = '<form id="infos" action=""><div class="control-group">'
						  + '<div  class="controls"><table '
						  + 'class="table table-striped table-bordered table-hover" style="width:100%" style="border-style: solid;border-color: green green green green;border-width: thick;;"><thead><tr>'
						  + '<th>No</th>'
						  +'<th>Subject</th>'
						  +'<th>Result</th>'
						  +'</tr></thead><tbody>';
                         $.each(result, function(i, item)
                        {

							x +='<tr><td>'+ c +'</td>'
							+'<td>'+item.Subject+'</td>'
							+'<td>'+item.Grade+'</td></tr>';
							

							c = c +1;


                        });   
						x+='</tbody</table</div></div></form>';
                        bootbox.alert(x,'Close');
                        }

                         
                    
                });

   }); 
   
    $(".DEEPPINK").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadExamDepartmentResultSheetOL')}}",
											data: {id: id},
											success:function response(responseText, statusText, xhr, $form)
											{
						   
												   var printWin = window.open("","printSpecial");
													printWin.document.open();
													printWin.document.write(responseText);
													printWin.document.close();
													printWin.print();
						   
					   
											 

											}
										});


					
			
	
	//////////////

  
});

});
</script>
