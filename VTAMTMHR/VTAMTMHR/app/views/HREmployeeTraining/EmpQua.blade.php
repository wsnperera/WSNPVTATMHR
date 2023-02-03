@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeTraining')}}"> << Back to HR - Employee Training(Local/Foreign)  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Employee Training(Local/Foreign)/Futher Education scholarships	
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeeTraining'))
             <form name='search' action="{{url('CreateHREmployeeTraining')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Employee Training /Futher Education scholarships</button>
			 </form>
	    @endif
		
		 <hr/>
        <div class="span10">
            <!--PAGE CONTENT BEGINS-->
			@if(isset ($empqua))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                        <th rowspan="2">Employee Name</th>
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
                        <th rowspan="2"> @if($user->hasPermission('EditHREmployeeTraining')) Edit @endif</th>
                        <th rowspan="2">@if($user->hasPermission('DeleteHREmployeeTraining')) Remove  @endif </th>
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
                    @foreach ($empqua as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                     
                        <td>{{$eq->Initials}} {{$eq->LastName}}</td>
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
                       
                     
                       
                       <td>
					   @if($user->hasPermission('EditHREmployeeTraining'))
						   <form id="deleteform"  action='EditHREmployeeTraining' method="GET">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
							
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteHREmployeeTraining'))
							 <form id="deleteform"  action='DeleteHREmployeeTraining' method="POST" onsubmit="return doConfirm('{{$eq->InstituteName}}- {{$eq->NameOfTheProgram}}- {{$eq->NIC}}',this)">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-1x icon-only"></i></button>
                            </form>
						@endif
						</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
                                                function doConfirm(empqua, formobj) {
                                                bootbox.confirm("Are you sure you want to remove Qualifiction for the Employee " + empqua, function(result) {
                                                if (result) {
                                                formobj.submit();
                                                }
                                                });
                                                        return false; // by default do nothing hack :D
                                                }

                                        $('#sample-table-2').dataTable({
                                        "aoColumns": [
                                        {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},
                                        {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false},
										{"bSortable": false},{"bSortable": false}
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
