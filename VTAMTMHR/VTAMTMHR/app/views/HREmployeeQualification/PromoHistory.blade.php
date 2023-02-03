@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeQualificationHistory')}}"> << Back to HR - Employee Qualification </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR - Employee Qualification History		
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
								<input type="submit"  value="Search Employee Qualifications" class="btn btn-small btn-warning"/>
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
                       
                       
                        <th rowspan="2">NIC[Old NIC] </th>
                        <th rowspan="2">EPF</th>
                        <th rowspan="2">Qualified Type</th>
                        <th rowspan="2">Qualification Category</th>
                        <th rowspan="2">Qualification</th>
						<th rowspan="2">UGC Approved Status</th>
                        <th rowspan="2">University/Institute</th>
                        <th rowspan="2">Main Subjects/Specialized Area</th>
                        <th colspan="3" class="center">Result</th>
                        
                    </tr>
                    <tr>
						<th>Status</th>
                        <th>Year</th>
                        <th>Month</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                   
                    @foreach ($promotion as $eq)
                      <tr>
                        <td> <?php echo $i++ ?></td>
                     
                       
                        <td>
						@if($eq->NIC != $eq->OldNIC)
						 {{$eq->NIC}} [{{$eq->OldNIC}}] 
						@else
						 {{$eq->NIC}}
						@endif
						</td>
						 <td>{{$eq->EPFNo}}</td>
                         <td>{{$eq->Type}}</td>
                        <td>{{$eq->QCategory}}</td>
                        <td>{{$eq->Qualification}}</td>
						<td>{{$eq->UGCApproveStatus}}</td>
                       <td>{{$eq->UniversityName}}</td>
                        <td>{{$eq->MainSubjects}}</td>
                        <td>{{$eq->Result}}</td>
						<td>{{$eq->Year}}</td>
                        <td>
						<?php
                            $monthNum  = $eq->Month;
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F'); // March
//                                    
                         ?>
						 {{$monthName}}
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
                        "bPaginate":false,
                                "aaSorting":[],
                                "aoColumns": [
                                {"bSortable": false},  {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},
                              
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
