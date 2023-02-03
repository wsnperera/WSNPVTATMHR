@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('promotion')}}"> << Back to Promotion </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">

        <h1>
            Promotion		
            <small>
                <i class="icon-double-angle-right"></i>
                View
            </small>			
        </h1>

    </div><!--/.page-header-->
    <div class="row-fluid">

        <form name='search' action="{{url('findPromotion')}}" method='get'>
            @if($user->hasPermission('createPromotion') && $userOrgType === 'HO')
            <a href="{{url('createPromotion')}}"><input type="button" value="Create Promotion"/></a>
            <!--<a href="{{url('visitingEmpView')}}"><input type='button' value='View of Visiting Employee' /></a>-->
            @endif
            @if($user->hasPermission('createDOPromotion') && $userOrgType === 'DO')
            <a href="{{url('createDOPromotion')}}"><input type="button" value="Create Promotion"/></a>
            @endif
        </form>
     
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">#No#</th>
                        <th rowspan="2">Institute Name</th>
                        <th rowspan="2">Employee Reference No</th>
                        <th rowspan="2">Employee Name</th>
                        <th rowspan="2">N.I.C</th>
                        <th rowspan="2">Effective Date</th>
                        <th rowspan="2">District</th>
                        <th rowspan="2">To Center</th>
                        <th rowspan="2">DO Name(Belongs)</th>
                        <th rowspan="2">To Department</th>
                        <th rowspan="2">Transfer Type</th>
                        <th rowspan="2">New Post</th>
                        <th rowspan="2">Employee Type</th>
                        <th rowspan="2">Grade</th>
                        <th colspan="2" style="text-align: center;">Salary Details</th>
                        <th rowspan="2">Increment Month</th>
                        <th rowspan="2">Increment Day</th>
                        <th rowspan="2">@if($user->hasPermission('deletePromotion')) Remove @endif</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Salary Scale</th>
                        <th style="text-align: center;">Salary Step</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 0; ?>
                    @if(isset ($promotion))
                    @foreach ($promotion as $pr)
                    <tr>
                        <td><?php $i++;
                    echo$i; ?></td>
                        <td>@if(!is_null($pr->getInstitute)){{$pr->getInstitute->InstituteName}} @endif</td>
                        <td>@if($user->hasPermission('editPromotion')&& ($user->EmpId == $pr->Emp_ID || $userOrgType === 'HO'))
                            <a href="{{url('editPromotion?id='.$pr->P_ID)}}">{{$pr->EPF}}</a></td>
                        @elseif ($user->hasPermission('editPromotion') && $user->EmpId == $pr->Emp_ID && $userOrgType === 'DO')
                <a href="{{url('editPromotion?id='.$pr->P_ID)}}">{{$pr->EPF}}</a></td>
                @else
                {{$pr->EPF}}</a>
                @endif</td>
                <td>@if(!is_null($pr->getEmp)){{$pr->getEmp->Initials}}  {{$pr->getEmp->LastName}}@endif</td>
                <td>{{$pr->NIC}}</td>
                <td >{{$pr->StartDate}}</td>
                <td>@if(!is_null($pr->getOrga)){{$pr->getDistrictName($pr->ToOrganisation)}}@endif</td>
                <td>@if(!is_null($pr->getOrga)){{$pr->getOrga->OrgaName}}@endif</td>
                <td style="text-align: center;"><?php
                    $OrgaName = Organisation::where('id', '=', $pr->ToOrganisation)->pluck('OrgaName');
                    $EmpOrgTypeId = Organisation::where('id', '=', $pr->ToOrganisation)->pluck('TypeId');
                    $DOTypeID = OrganisationType::where('Type', '=', 'DO')->pluck('OT_ID');
                    $EmpOrgTypeName = OrganisationType::where('OT_ID', '=', $EmpOrgTypeId)->pluck('Type');
                    if ($EmpOrgTypeName !== 'DO' && $EmpOrgTypeName !== 'HO' && $EmpOrgTypeName !== 'NVTI') {
                        $EmpDOOrgTypeIdDistrictCode = Organisation::where('id', '=', $pr->ToOrganisation)->pluck('DistrictCode');
                        $EmpDOOrgaName = Organisation::where('DistrictCode', '=', $EmpDOOrgTypeIdDistrictCode)->where('TypeId', '=', $DOTypeID)->pluck('OrgaName');
                        echo $EmpDOOrgaName;
                    } else {
                        echo '-';
                    }
                    ?></td>
                <td>@if(!is_null($pr->getDepartment)){{$pr->getDepartment->DepartmentName}}@endif</td>
                <td>@if(!is_null($pr->getTransferType)){{$pr->getTransferType->TransferType}}@endif</td>
                <td>@if(!is_null($pr->getPost)){{$pr->getPost->Designation}}@endif</td>
                <td>{{$pr->EmpType}}</td>
                <td>{{$pr->Grade}}</td>
                <td>@if(!is_null($pr->getSalaryScale)){{$pr->getSalaryScale->SalaryScale}}@endif</td>
                <td>{{$pr->SalaryStep}}</td>
                <td>{{$pr->IncrementMonth}}</td>
                <td>{{$pr->IncrementDay}}</td>
                <td>@if($user->hasPermission('deletePromotion'))
                    <form id="deleteform"  action="{{url('deletePromotion')}}" method="POST" onsubmit="return doConfirm('{{$pr->NIC}}', this)">
                        <input type="hidden" name='pid' value="{{$pr->P_ID}}" />
                        <button type="submit" class="btn btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                    </form> @endif
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
                                {"bSortable": false}, {"bSortable": false}, null, {"bSortable": false}, null, null, null, null, null, null, null, null, null,
                                {"bSortable": false}, {"bSortable": false},{"bSortable": false}, {"bSortable": false}, {"bSortable": false}
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
