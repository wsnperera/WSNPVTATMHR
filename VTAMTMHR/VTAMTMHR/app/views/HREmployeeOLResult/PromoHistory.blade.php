@include('includes.bar')       
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" /> 
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeOLResults')}}"> << Back to HR - Employee O/L Results  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR - Employee O/L Results	
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
								<option value="EPF">Search using EPF</option>
								</select>
								<input type="text" name="NIC" id="NIC" placeholder="Type NIC/EPF Here....." required/> 
								<input type="submit"  value="Search Employee Training" class="btn btn-small btn-warning"/>
								</div>
					  </div>
					</td>
						
				   
							
				   
						
					</tr>
				</table>
			</form>
        
      
	  <hr/>
     @if(isset ($Employeerec))
	  <br/>
	   <div class="span3">   
        <center>
            <span class="profile-picture">
               
                <img id="avatar" class="editable" height="600" width="150" alt="Alex's Avatar" src="{{Url($Employeerec->Photograph)}}" />
              
            </span>

        </br></br>

        <div class="width-70 label label-info label-large arrowed-in arrowed-in-right">
            <div class="inline position-relative">
                <center><span class="white middle bigger-120">{{$Employeerec->Initials}} {{$Employeerec->LastName}}</span></center>
            </div>
        </div>
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
                       
                      
                        <th rowspan="2">NIC </th>
                        <th rowspan="2">EPF</th>
						<th rowspan="2">Attempt</th>
						<th rowspan="2">Medium</th>
						<th colspan="4" class="center">Exam Details</th>
						<th rowspan="2">View Results</th>
						<th rowspan="2" class="center">Exam Department Result Sheet</th>
						
                    </tr>
                    <tr>
						<th class="center">Year</th>
						<th class="center">Month</th>
						<th class="center">Centre No</th>
                        <th class="center">Index No</th>
						
                       
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($promotion as $eq)

                    <tr>
                       <td> <?php echo $i++ ?></td>
                     
                      
                        <td>@if($eq->NIC == $eq->OldNIC || $eq->OldNIC == ""){{$eq->NIC}} @else {{$eq->NIC}} [{{$eq->OldNIC}}]@endif</td>
						<td>{{$eq->EPFNo}}</td>
						<td>{{$eq->Attempt}}</td>
						<td>{{$eq->Medium}}</td>
						<td>{{$eq->Year}}</td>
						<td>{{$eq->Month}}</td>
						<td>{{$eq->CentreNo}}</td>
                        <td>{{$eq->IndexNo}}</td>
                        <td class='center'><font color="pink"><a class="pink"  id="{{$eq->id}}"> <i class="icon-eye-open bigger-200"></i></a> </font></td>
                        <td class='center'> <font color="DEEPPINK"><a class="DEEPPINK"  id="{{$eq->id}}"> <i class="icon-download-alt bigger-300"></i></a> </font></td>
                     
                       
                      
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
                                        {"bSortable": false}, {"bSortable": false}, {"bSortable": false},
                                         {"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},{"bSortable": false}
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
