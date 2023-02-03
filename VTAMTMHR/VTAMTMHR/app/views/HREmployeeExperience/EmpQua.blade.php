@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeeExperience')}}"> << Back to HR - Employee Qualification  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Employee Experience		
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeeExperience'))
             <form name='search' action="{{url('CreateHREmployeeExperience')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Employee Work Experience </button>
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
                       
                        <th rowspan="2">Employee Name</th>
                        <th rowspan="2">NIC </th>
                        <th rowspan="2">EPF</th>
                        <th rowspan="2">Organisation Name</th>
                        <th rowspan="2">Designation</th>
                        <th colspan="3" class="center">Duration</th>
						<th rowspan="2">Reason To Leave</th>
                        <th rowspan="2"> @if($user->hasPermission('EditHREmployeeExperience')) Edit @endif</th>
                        <th rowspan="2">@if($user->hasPermission('DeleteHREmployeeExperience')) Remove  @endif </th>
                    </tr>
                    <tr>
						<th>Date Joined</th>
                        <th>Date Resigned</th>
                        <th>Period</th>
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
                        <td>{{$eq->CompanyName}}</td>
                        <td>{{$eq->Designation}}</td>
                        <td>{{$eq->DateJoined}}</td>
                       <td>{{$eq->DateResigned}}</td>
					   <td>
					   @if(!empty($eq->DateJoined) && !empty($eq->DateResigned || $eq->DateJoined !='0000-00-00' && $eq->DateResigned !='0000-00-00'))
					   <?php 
					   $sql = "Select
								TIMESTAMPDIFF( YEAR, '".$eq->DateJoined."','". $eq->DateResigned."' ) as _year
								,TIMESTAMPDIFF( MONTH,'".$eq->DateJoined."', '". $eq->DateResigned."' ) % 12 as _month
								,FLOOR( TIMESTAMPDIFF( DAY, '".$eq->DateJoined."', '". $eq->DateResigned."' ) % 30.4375 ) as _day";
								$res=DB::select(DB::raw($sql));
								$newdata =  json_decode(json_encode((array)$res),true);
								$year = $newdata[0]["_year"];
								$month = $newdata[0]["_month"];
								$day = $newdata[0]["_day"];
					   ?>
					   {{$year}} Years & {{$month}} Months
					   @else
						 {{$eq->Years}} Years & {{$eq->Months}} Months  
					   @endif
					   </td>
                        <td>{{$eq->ReasonToLeave}}</td>
                       
                     
                       
                       <td>
					   @if($user->hasPermission('EditHREmployeeExperience'))
						   <form id="deleteform"  action='EditHREmployeeExperience' method="GET">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteHREmployeeExperience'))
							 <form id="deleteform"  action='DeleteHREmployeeExperience' method="POST" onsubmit="return doConfirm('{{$eq->CompanyName}}- {{$eq->Designation}}- {{$eq->NIC}}',this)">
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
                                        {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}
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
