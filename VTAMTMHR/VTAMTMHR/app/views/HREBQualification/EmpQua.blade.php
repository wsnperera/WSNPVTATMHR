@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeEBQualification')}}"> << Back to HR - Employee EB Qualification  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Employee EB Qualification		
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeeEBQualification'))
             <form name='search' action="{{url('CreateHREmployeeEBQualification')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create EB Employee Qualification </button>
			 </form>
	    @endif
		
		 <hr/>
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
			@if(isset ($empqua))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                        <th rowspan="2" class="center">Employee Name</th>
                        <th rowspan="2" class="center">NIC </th>
                        <th rowspan="2" class="center">EPF</th>
                        <th colspan="2" class="center">Qualification</th>
                        <th rowspan="2" class="center"> @if($user->hasPermission('EditHREmployeeEBQualification')) Edit @endif</th>
                        <th rowspan="2" class="center">@if($user->hasPermission('DeleteHREmployeeEBQualification')) Remove  @endif </th>
                    </tr>
                    <tr>
						<th class="center">Grade</th>
                        <th class="center">Date Qualified</th>
                       
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
                        
                        <td class="center">{{$eq->Grade}}</td>
						<td class="center">{{$eq->QualifiedDate}}</td>
                      
                       
                       <td class="center">
					   @if($user->hasPermission('EditHREmployeeEBQualification'))
						   <form id="deleteform"  action='EditHREmployeeEBQualification' method="GET">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
					   @endif
						</td>
                        <td class="center">
						@if($user->hasPermission('DeleteHREmployeeEBQualification'))
							 <form id="deleteform"  action='DeleteHREmployeeEBQualification' method="POST" onsubmit="return doConfirm('{{$eq->Grade}} - {{$eq->NIC}}',this)">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-1x icon-only"></i></button>
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
