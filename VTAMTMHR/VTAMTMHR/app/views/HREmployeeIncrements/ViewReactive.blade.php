@include('includes.bar')  
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<!--ace styles-->
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.css" />
<link rel="stylesheet" href="assets/css/datepicker.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        HR - Employee Increments      
                        <small>
                            <i class="icon-double-angle-right"></i>
                            View (Reactivation)
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="" method='POST' class='form-horizontal'>
            
				<div class="control-group">
                <label class="control-label" for="form-field-4">Center</label>
                <div class="controls">
                    <select  class="chzn-select" name="QO_ID"  id="QO_ID" required>
                        <option value="">--Select Center--</option>
						 <option value="All">All</option>
                        @foreach ($Centers as $qo)
                        <option  value="{{$qo->id}}">{{$qo->OrgaName}} - ({{$qo->Type}})</option>
                        @endforeach
                    </select> <b style="color: red">*</b>
                </div>
            </div>
                
                <br/> 
                <div class="control-group">
                    <div class="controls">
                        <button type="submit"  class="btn btn-primary">
                                <i class="icon-eye-open bigger-200"></i>View</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    </div>
                </div>   
            </form>
            <div id="aaaa">
            @if(isset($courses))
         
	        
            @endif
     
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                        <th class='center'>No</th>
					    <th class='center'>Current Organisation</th>
                        <th class='center'>Employee Name</th>
                        <th class='center'>NIC</th>
						 <th class='center'>EPF No</th>
                        <th class='center'>Designation</th>
                        <th class='center'>Service Category</th>
                        <th class='center'>Step No</th>
                        <th class='center'>Increment Date</th>
						
                        <th class='center'>Approve Status</th>
                        <th class='center'>Reason To Reject</th>
						<th class='center'>Reactivated Date</th>
						<th class='center'>Temporary Hold Months</th>
						<th class='center'>Enter Reactive Details</th>
						<th class='center'>Download Certificate of Payment of Increment (A)</th>
						<th class='center'>Download Certificate of Payment of Increment (B)</th>
					    <th class='center'>Reactivate</th>
                      
                        
                       
                        
                </tr>
                </thead>
                    <tbody>

                  <?php 
                  $SerialNo=1;
				  $curdate = DB::select(DB::raw("select CURDATE() as curdateasa"));
				 
								$newdataaa =  json_decode(json_encode((array)$curdate),true);
								$curdateo = $newdataaa[0]["curdateasa"];
                  ?>
                @if(isset($quorga))
					
                @foreach($quorga as $t)

               
                
                        <tr>
                           <font color="red">
                            <td class="center">{{$SerialNo++}}</td>
							<td class="center">{{$t->OrgaName}}({{$t->Type}})</td>
                            <td>{{$t->Initials}} {{$t->LastName}}</td>
                            <td class="center">{{$t->NIC}}</td>
							<td class="center">{{$t->EPF}}</td>
                            <td class="center">{{$t->Designation}}</td>
                            <td class="center">{{$t->ServiceCategory}}</td>
							<td class="center">{{$t->StepNo}}</td>
                            <td class="center">{{$t->NextIncrementDate}}</td>
							
							<td class="center">
							@if($t->Approved == 1)
							Yes
							@elseif($t->Approved == 2)
							Temporary Hold
							@elseif($t->Approved == 3)
							Hold
							@elseif($t->Approved == 4)
							 Stop
							 @elseif($t->Approved == 5)
							 Reactive
							 @else
								Pending
							 @endif
								 
							</td>
							<td class="center">{{$t->ReasonForHold}}</td>
							<td>{{$t->ReactivatedDate}}</td>
							<td class="center">
							<?php
							$gettempholdmonths = HREmployeeIncrementHoldMonths::GetMonths($t->id);
							?>
							@foreach($gettempholdmonths as $an)
							@if($an->MonthNo == '1')
								January<br/>
							
							@elseif($an->MonthNo == '2')
							February<br/>
							@elseif($an->MonthNo == '3')
							March<br/>
							@elseif($an->MonthNo == '4')
							April<br/>
							@elseif($an->MonthNo == '5')
							May<br/>
							@elseif($an->MonthNo == '6')
							June<br/>
							@elseif($an->MonthNo == '7')
							July<br/>
							@elseif($an->MonthNo == '8')
							August<br/>
							@elseif($an->MonthNo == '9')
							September<br/>
							@elseif($an->MonthNo == '10')
							October<br/>
							@elseif($an->MonthNo == '11')
							November<br/>
							@elseif($an->MonthNo == '12')
							December<br/>
							@else
								@endif
							@endforeach
							</td>
							@if(empty($t->ReactivatedDate))
							<td class='center'> <font color="purple"><a class="purple"  id="{{$t->id}}"> <i class="icon-hand-right bigger-300"></i></a> </font>
						@else
							 <td class='center'></td>
							@endif
							 @if($t->Approved == 2)
								 @if(!empty($t->ReactivatedDate))
									  <td class='center'> <font color="orange"><a class="orange"  id="{{$t->id}}"> <i class="icon-download-alt bigger-300"></i></a> </font></td>
									  <td class='center'> <font color="red"><a class="red"  id="{{$t->id}}"> <i class="icon-download-alt bigger-300"></i></a> </font></td>
							    @else
									 <td class='center'></td>
							         <td class='center'></td>
								@endif
							  @else
							  <td class='center'></td>
							  <td class='center'></td>
							  @endif
							  @if(!empty($t->ReactivatedDate))
							<td class='center'> <font color="green"><a class="green"  id="{{$t->id}}"> <i class="icon-ok bigger-300"></i></a> </font>
                            <span id="img5"></span>
                            </td>
							@else
							 <td class='center'></td>
							@endif
								
                         </font>
                            
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
<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/date-time/moment.min.js"></script>
<script src="assets/js/date-time/daterangepicker.min.js"></script>
<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>




<script type="text/javascript">

 $(".chzn-select").chosen();
                            $("[id^='QO_ID']").find('input').on('change', function(e) {
                                var option = $("<option>").val($("#QO_ID_chzn").find('input').val()).text($("#QO_ID_chzn").find('input').val());

                                $("#QO_ID.chzn-select").prepend(option);
                                $("#QO_ID.chzn-select").find(option).prop('selected', true);
                                $("#QO_ID.chzn-select").trigger("liszt:updated");
                            });
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
		"bPaginate":false,
    "aaSorting":[],
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
<script type="text/javascript">
 $(document).ready(function() {				
 $(".red").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadAnnualIncrementPaymentFormBReactive')}}",
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
 
  $(".orange").click(function(){

     var id = this.id;
    // alert(id);
	////////////////////
	
						          $.ajax
										({
											
											type: "POST",
											url: "{{Url('DownloadAnnualIncrementPaymentFormReactive')}}",
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
 $(".green").click(function(){

      var id = this.id;
     //alert(id);
	 
	  var x = '<form id="infos" action="">'
					 
					  +'<div class="control-group"><div class="controls"><font color="red">'
			          +'* Do you wanna to  reactive & set this date as an Increment date for next years?<br/></font>'
					  +'</div></div>'
					  +'<div class="control-group">'
					  +'<div class="controls" id="Trade">'
                      +'<center><select name="NextY" id="NextY" required="true">'
                      +'<option value="">--- Select Option ---</option>';
					x +='<option value="Yes">Yes</option>';
					x +='<option value="No">No</option></select></center></div></div></form>';
					
       	 
						
					
	
   bootbox.confirm(x, function(result) {
        if(result)
        {
			    //$('#infos').submit();
			   // alert(result);

			
			  var NextY = $("#NextY").val();
			// var g = $("#editComment").val();
		    //alert(ReactiveDate);

			if(NextY == " ")
			{
				bootbox.alert("Please Select the Option !!!!!")
			}
			else
			{
				 doStuffWithResults4(id,NextY);
			}
        }
}); 

/* bootbox.prompt({
                message : "Select prompt", 
                title    : "Select prompt",
                inputType : 'radio',
                inputOptions : [
                    { text : 'yay', value: 'yay', name: 'yay_group'},
                    { text : 'nay', value: 'nay', name: 'yay_group'},
                ],
                callback : function(blah) {
                    console.log(blah)
                }
            }); */

}); 
 $(".purple").click(function(){

      var id = this.id;
     //alert(id);
	 
	  var x = '<form id="infos" action="">'
					  +'<div class="control-group"><div class="controls">'
					  +'Reactive Date: <input type="date"  name="ReactiveDate" id="ReactiveDate" />'
					  +'</div></div>'
					 
				
					x +='</form>';
					
       	 
						
					
	
   bootbox.confirm(x, function(result) {
        if(result)
        {
			    //$('#infos').submit();
			   // alert(result);

			 var ReactiveDate = $("#ReactiveDate").val();
			 // var NextY = $("#NextY").val();
			// var g = $("#editComment").val();
		    //alert(ReactiveDate);

			if(ReactiveDate == " ")
			{
				bootbox.alert("Please Enter Reactivate Date !!!!!")
				
			}
			
			else
			{
				 doStuffWithResults3(id,ReactiveDate);
			}
        }
}); 

/* bootbox.prompt({
                message : "Select prompt", 
                title    : "Select prompt",
                inputType : 'radio',
                inputOptions : [
                    { text : 'yay', value: 'yay', name: 'yay_group'},
                    { text : 'nay', value: 'nay', name: 'yay_group'},
                ],
                callback : function(blah) {
                    console.log(blah)
                }
            }); */

}); 

});
</script>
<script>

  
    
$('#center').change(function(){

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
        


       
    });
  


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
function doStuffWithResults4(id,NextY) {

      $.ajax  ({
                    url: "{{url::to('ActionIncrementReactiveDate')}}",
                    data: { id: id,NextY: NextY},
                    
                   success: function(result) {

                        //alert(result);
                      location.reload();          
                        
                        }


                    
                });
   
}





    
function doStuffWithResults3(id,ReactiveDate,NextY) {

      $.ajax  ({
                    url: "{{url::to('ActionIncrementReactive')}}",
                    data: { id: id,ReactiveDate: ReactiveDate},
                    
                   success: function(result) {

                        //alert(result);
                      location.reload();          
                        
                        }


                    
                });
   
}
    

 $(".DEEPPINK").click(function(){

     var id = this.id;
     //alert(id);
	////////////////////
	
					   
						          $.ajax
										({
											beforeSend: function()
											{
												
												document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
											},
											type: "POST",
											url: "{{Url('DownloadAnnualIncrementForm')}}",
											data: {id: id},
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


					
			
	
	//////////////

  
});

/*  $(".red").click(function(){

     var id = this.id;
     //alert(id);


     $.ajax  ({
                    url: "{{url::to('ActionIncrementReactive')}}",
                    data: { id: id},
                    
                   success: function(result) {


                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });
  
}); */

</script>
