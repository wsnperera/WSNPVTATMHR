@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHREmployeePersonalFileDoc')}}"> << Back to HR - Employee Personal File Document List  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Employee Personal File Document List
            <small>
                
                
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
       @if($user->hasPermission('CreateHREmployeePersonalFileDoc'))
             <form name='search' action="{{url('CreateHREmployeePersonalFileDoc')}}" method='get'>
				<button type="submit" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Employee Personal File Document List</button>
			 </form>
	    @endif
		<form class="form-horizontal" action="{{url('ViewHREmployeePersonalFileDoc')}}" method="POST" name="form1" >
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
        <div class="span10">
            <!--PAGE CONTENT BEGINS-->
			@if(isset ($empqua))
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                       
                        <th rowspan="2">Employee Name</th>
						<th rowspan="2">Phptograph </th>
                        <th rowspan="2">NIC </th>
                        <th rowspan="2">EPF</th>
						<th rowspan="2">File No</th>
                        <th colspan="{{$countquaorg}}" class="center">Document List</th>
						<th rowspan="2">Active</th>
						
                        <th rowspan="2"> @if($user->hasPermission('EditHREmployeePersonalFileDoc')) Edit @endif</th>
                        <th rowspan="2">@if($user->hasPermission('DeleteHREmployeePersonalFileDoc')) Remove  @endif </th>
                    </tr>
                    <tr>
					@foreach($quaorg as $g)
						<th class="center">{{$g->DocumentName}}<br/>(Page No)</th>
                    @endforeach  
                       
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i = 1; ?>
                    @foreach ($empqua as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                     
                        <td>{{$eq->Initials}} {{$eq->LastName}}</td>
						<td><img src="{{Url($eq->Photograph)}}"  height="100" width="90"/></td>
                        <td>{{$eq->NIC}}</td>
						<td>{{$eq->EPFNo}}</td>
						<td>{{$eq->FileNo}}</td>
						
						@foreach($quaorg as $g)
						<td class="center">
						<?php
						
						$result = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$eq->id)->where('DocumentId','=',$g->id)->pluck('Availability');
						$PageNo = HREmployeePersonalFileDocTrans::where('Deleted','=',0)->where('hrEPFDId','=',$eq->id)->where('DocumentId','=',$g->id)->pluck('PageNo');
						$countres = count($result);
						?>
						@if($countres == 0)
							Not Available
						@else
							@if($result == 1)
								<font color="green"><i class="icon-ok bigger-130"></i></font><br/>
											@if(!empty($PageNo))
											<font color="blue">({{$PageNo}})</font>
											@else
											@endif
							@else
									<font color="red"><i class="icon-remove bigger-130"></i></font>
							@endif
							
						@endif
						</td>
						 @endforeach  
						
							  <td>
							  @if($eq->Active == 1)
								  Yes 
							  @else 
								  No 
							  @endif</td>
							    
                       
                     
                       
                       <td>
					   @if($user->hasPermission('EditHREmployeePersonalFileDoc'))
						   <form id="deleteform"  action='EditHREmployeePersonalFileDoc' method="GET">
                                <input type="hidden" name='id' value="{{$eq->id}}" />
                                <button type="submit" class="btn btn-success btn-small"><i class="icon-pencil icon-1x icon-only"></i></button>
                            </form>
							
					   @endif
						</td>
                        <td>
						@if($user->hasPermission('DeleteHREmployeePersonalFileDoc'))
							 <form id="deleteform"  action='DeleteHREmployeePersonalFileDoc' method="POST" onsubmit="return doConfirm('{{$eq->FileNo}}- {{$eq->NIC}}',this)">
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
										{"bSortable": false},
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
