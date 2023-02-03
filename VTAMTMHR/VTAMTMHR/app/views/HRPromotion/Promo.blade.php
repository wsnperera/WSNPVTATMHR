@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('ViewHRPromotion')}}"> << Back to HR - Promotion </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            HR - Promotion		
            <small>
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>

    </div><!--/.page-header-->
    <div class="row-fluid">

        <table><tr><td>
            @if($user->hasPermission('CreateHRPromotion'))
            <a href="{{url('CreateHRPromotion')}}"><button type="button" id="submit" class="btn btn-pink">
                <i class="icon-pencil bigger-100"></i>Create Promotion</button></a>
            @endif
			</td></tr></table>
        
      <br/>
	  <hr/>
     
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Edit</th>
                        <th rowspan="2">EPF No</th>
						<th rowspan="2">NIC[Old NIC]</th>
                        <th rowspan="2">Full Name</th>
						<th rowspan="2">Name with Initials</th>
                        <th rowspan="2">District</th>
						<th rowspan="2">To Center(Type)</th>
                        <th rowspan="2">To Department</th>
                        <th rowspan="2">Transfer/Promotion Type</th>
                        <th rowspan="2">New Post</th>
                        <th rowspan="2">Employee Type</th>
						<th rowspan="2">Effective Date</th>
                        
                        <th colspan="5" style="text-align: center;">Starting Salary Details</th>
						<th colspan="5" style="text-align: center;">Present Salary Details</th>
                        <th rowspan="2">Increment Month</th>
                        <th rowspan="2">Increment Day</th>
						<th rowspan="2">Confirmation Date</th>
						<th colspan="3" style="text-align: center;">Gratuity/EFT/EPF Details</th>
                        <th rowspan="2">@if($user->hasPermission('DeleteHRPromotion')) Remove @endif</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Service Category</th>
                        <th style="text-align: center;">Salary Code</th>
						<th style="text-align: center;">Salary Scale</th>
						<th style="text-align: center;">Salary Step</th>
						<th style="text-align: center;">Grade</th>
						
						 <th style="text-align: center;">Service Category</th>
                        <th style="text-align: center;">Salary Code</th>
						<th style="text-align: center;">Salary Scale</th>
						<th style="text-align: center;">Salary Step</th>
						<th style="text-align: center;">Grade</th>
						
						<th style="text-align: center;">Gratuity Amount</th>
						<th style="text-align: center;">ETF Released Date</th>
						<th style="text-align: center;">EPF Released Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 0; ?>
                    @if(isset ($promotion))
                    @foreach ($promotion as $pr)
                    <tr>
                        <td><?php $i++;?>{{$i}}</td>
                       
                        <td>
						@if($user->hasPermission('EditHRPromotion'))
                            <a href="{{url('EditHRPromotion?id='.$pr->P_ID)}}"><i class="icon-edit icon-2x icon-only"></i></a>
                        @endif
						</td>
						<td>{{$pr->EPF}}</td>
						<td>@if($pr->NIC != $pr->OldNIC)
						 {{$pr->NIC}} [{{$pr->OldNIC}}] 
						@else
						 {{$pr->NIC}}
						@endif</td>
						<td>{{$pr->Name}} {{$pr->LastName}}</td>
						<td>{{$pr->Initials}} {{$pr->LastName}}</td>
						<td>{{$pr->DistrictName}}</td>
						<td>{{$pr->OrgaName}}({{$pr->Type}})</td>
						<td>{{$pr->DepartmentName}}</td>
						<td>{{$pr->TransferType}}</td>
						<td>{{$pr->Designation}}</td>
						<td>{{$pr->EmployeeType}}</td>
						<td>{{$pr->StartDate}}</td>
						<td>{{$pr->ServiceCategory}}</td>
						<td>{{$pr->SalaryCode}}</td>
						<td>{{$pr->SalaryScale}}</td>
						
						<?php 
						if(!empty($pr->SalaryStep ))
						{
						 $salsteptrans = HRSalaryStepTrans::where('id','=',$pr->SalaryStep)->first();
						}
						else
						{
							$salsteptrans="";
						}
						?>
						<td>
						@if($pr->SalaryStep != '')
						No.{{$salsteptrans->StepNo}}-{{$salsteptrans->StepAmount}}/=
						@if($salsteptrans->EBAvailable == 1)
							(EB Available)
							@else
								@endif
							@else
								@endif
						</td>
						<td>{{$pr->Grade}}</td>
						
						<td>{{$pr->PServiceCategory}}</td>
						<td>{{$pr->PSalaryCode}}</td>
						<td>{{$pr->PSalaryScale}}</td>
						
						<?php 
						if(!empty($pr->PSalaryStep) || $pr->PSalaryStep != 0)
						{
						 $salsteptransP = HRSalaryStepTrans::where('id','=',$pr->PSalaryStep)->first();
						}
						else
						{
							$salsteptransP="";
						}
						?>
						<td>
						@if($pr->PSalaryStep != '' || $pr->PSalaryStep != 0)
						No.{{$salsteptransP->StepNo}}-{{$salsteptransP->StepAmount}}/=
						@if($salsteptransP->EBAvailable == 1)
							(EB Available)
							@else
								@endif
							@else
								@endif
						</td>
						<td>{{$pr->PGrade}}</td>
						
						
						<td>{{$pr->IncrementMonth}}</td>
						<td>{{$pr->IncrementDay}}</td>
						<td>{{$pr->ConfirmationDate}}</td>
						<td>{{$pr->GratuityAmount}}</td>
						<td>{{$pr->ETFReleasedDate}}</td>
						<td>{{$pr->EPFReleasedDate}}</td>
						
                <td>
				@if($user->hasPermission('DeleteHRPromotion'))
                    <form id="deleteform"  action="{{url('DeleteHRPromotion')}}" method="POST" onsubmit="return doConfirm('{{$pr->NIC}}', this)">
                        <input type="hidden" name='pid' value="{{$pr->P_ID}}" />
                        <button type="submit" class="btn btn-danger btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
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
                                {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},
                                {"bSortable": false},{"bSortable": false}, {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
                               {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false} ]});
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
