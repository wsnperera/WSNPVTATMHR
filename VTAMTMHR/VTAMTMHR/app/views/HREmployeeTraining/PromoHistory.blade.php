@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeTraining')}}"> << Back to HR - Employee Training(Local/Foreign)</a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR - Employee Training(Local/Foreign) /Futher Education scholarships History		
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
						<th rowspan="2">Program Type</th>
						<th rowspan="2">Training Type</th>
						<th rowspan="2">Leave Type</th>
						<th rowspan="2">Country</th>
                        <th rowspan="2">Name of the Program</th>
                        <th rowspan="2">Institute/University</th>
                        <th colspan="2" class="center">Duration</th>
						<th rowspan="2">Amount Paid By VTA</th>
						<th colspan="2" class="center">Compulsory Period of Service</th>
						<th rowspan="2">Amount of Surcharge</th>
						<th colspan="2" class="center">Guarantor 01</th>
						<th colspan="2" class="center">Guarantor 02</th>
						<th rowspan="2">Training Completed Date</th>
						<th rowspan="2">Cerfiticate Forwarded</th>
						<th rowspan="2">Cerfiticate Forwarded Date</th>
						<th rowspan="2">Other Comments</th>
                      
                    </tr>
                    <tr>
						<th class="center">From</th>
                        <th class="center">To</th>
						<th class="center">Years</th>
                        <th class="center">Months</th>
						 <th class="center">Name</th>
						  <th class="center">EPF</th>
						  <th class="center">Name</th>
						  <th class="center">EPF</th>
                       
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($promotion as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                     
                       
                        <td>{{$eq->NIC}}</td>
						<td>{{$eq->EPFNo}}</td>
					<td>
						@if($eq->ProgramType == 'FutherEducationscholarships')
								  Futher Education scholarships
						@elseif($eq->ProgramType == 'ShortTrainingprogram') 
								Short Training Program
						@else
							
					    @endif
							  </td>
						<td>{{$eq->TrainingType}}</td>
						<td>{{$eq->PayStatus}}</td>
						<td>{{$eq->CountryName}}</td>
                        <td>{{$eq->NameOfTheProgram}}</td>
                        <td>{{$eq->InstituteName}}</td>
                        <td>{{$eq->DurationFrom}}</td>
                       <td>{{$eq->DurationTo}}</td>
					 
                        <td>{{$eq->AmountPaidByVTA}}</td>
						 <td>{{$eq->CompulsoryPeriodOfService}}</td>
						  <td>{{$eq->CompulsoryPeriodOfServiceMonth}}</td>
						  <td>{{$eq->AmountOfSurcharge}}</td>
						   <td>{{$eq->guaini1}} {{$eq->gualname1}}</td>
						    <td>{{$eq->guarepf1}}</td>
							 <td>{{$eq->guaini2}} {{$eq->gualname2}}</td>
						    <td>{{$eq->guarepf2}}</td>
							 <td>{{$eq->TrainingCompletedDate}}</td>
							  <td>
							  @if($eq->CertificateForwarded == 1)
								  Yes 
							  @else 
								  No 
							  @endif</td>
							   <td>{{$eq->CertificateForwadedDate}}</td>
							    <td>{{$eq->Other}}</td>
                       
                     
                       
                      
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
                                        {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},
                                        {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},	{"bSortable": false},{"bSortable": false},{"bSortable": false},
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
