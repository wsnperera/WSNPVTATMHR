@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeLoan')}}"> << Back to HR - Employee Loan  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Employee Loan
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeeLoan'))
             <form name='search' action="{{url('CreateHREmployeeLoan')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Employee Loan</button>
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
						 <th rowspan="2">Loan Type</th>
						 
						
                        <th rowspan="2">Loan Amount</th>
                       
                        <th colspan="3" class="center">Duration</th>
						
						<th colspan="2" class="center">Guarantor 01</th>
						<th colspan="2" class="center">Guarantor 02</th>
						<th rowspan="2">Loan Status</th>
					
                        <th rowspan="2"> @if($user->hasPermission('EditHREmployeeLoan')) Edit @endif</th>
                        <th rowspan="2">@if($user->hasPermission('DeleteHREmployeeLoan')) Remove  @endif </th>
                    </tr>
                    <tr>
						<th class="center">Date Issued </th>
                        <th class="center">Date Complete</th>
						 <th class="center">No of Installments</th>
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
						<td>{{$eq->LoanType}}</td>
						<td>{{$eq->LoanAmount}}</td>
						<td>{{$eq->IssuedDate}}</td>
                        <td>{{$eq->CompletedDate}}</td>
					    <td>{{$eq->NoOFInstallment}}</td>
						<td>{{$eq->guaini1}} {{$eq->gualname1}}</td>
						<td>{{$eq->guarepf1}}</td>
							 <td>{{$eq->guaini2}} {{$eq->gualname2}}</td>
						    <td>{{$eq->guarepf2}}</td>
							  <td>
							  @if($eq->LoanClosed == 1)
								  Completed 
							  @else 
								  Not Completed 
							  @endif</td>
							  
                       
                     
                       
                       <td>
					   @if($user->hasPermission('EditHREmployeeLoan'))
						   <form id="deleteform"  action='EditHREmployeeLoan' method="GET">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
							
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteHREmployeeLoan'))
							 <form id="deleteform"  action='DeleteHREmployeeLoan' method="POST" onsubmit="return doConfirm('{{$eq->LoanType}}- {{$eq->IssuedDate}}- {{$eq->NIC}}',this)">
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
                                        {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false}, {"bSortable": false}, 
                                        {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},
										{"bSortable": false},
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

    
</script>
