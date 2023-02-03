@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('empqua')}}"> << Back to Employee Qualification  </a> 
@endif
<div class="page-content">
    <div class="page-header position-relative">
        <h1>
            Employee		
            <small>
                <i class="icon-double-angle-right"></i>
                Employee Qualification
                <i class="icon-double-angle-right"></i>
                View
            </small>
        </h1>
    </div><!--/.page-header-->
    <div class="row-fluid">
        <form name='search' action="{{url('findEmpqua')}}" method='get'> &nbsp;
            @if($user->hasPermission('createEmpqua'))
            <a href="{{url('createEmpqua')}}"><input class="btn btn-small btn-primary" type="button" value="Create Employee Qualification"/></a>
            @endif
        </form>
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Institute Name</th>
                        <th rowspan="2">Organisation Name</th>
                        <th rowspan="2">Employee Name</th>
                        <th rowspan="2">NIC No</th>
                        <th rowspan="2">EPF</th>
                        <th rowspan="2">Qualified University Name</th>
                        <th rowspan="2">Qualification Type</th>
                        <th rowspan="2">Qualification </th>
                        <th rowspan="2">Qualification Description</th>
                        <th rowspan="2">Main Subjects/Specialized Area</th>
                        <th colspan="2">Completed</th>
                        <th rowspan="2"> @if($user->hasPermission('editEmpqua')) Edit @endif</th>
                        <th rowspan="2">@if($user->hasPermission('deleteEmpqua')) Remove  @endif </th>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <th>Month</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset ($empqua))
                    <?php $i = 1; ?>
                    @foreach ($empqua as $eq)

                    <tr>
                        <td> <?php echo $i++ ?></td>
                        <td>@if(!is_null($eq->getInstitute)){{$eq->getInstitute->InstituteName}}@endif</td>
                        <td><?php $EmpProOrgId =Promotion::where('Emp_ID','=',$eq->EmpId)->pluck('ToOrganisation');
                                  $EmpProOrgName =Organisation::where('id','=',$EmpProOrgId)->pluck('OrgaName');
                                  echo $EmpProOrgName;  ?></td>
                        <td>@if(!is_null($eq->getEmployee)){{$eq->getEmployee->Initials}}.{{$eq->getEmployee->Name}}@endif</td>
                        <td>@if(!is_null($eq->getEmployee)){{$eq->getEmployee->NIC}}@endif</td>
                        <td>@if(!is_null($eq->getEmployee)){{$eq->getEmployee->EPFNo}}@endif</td>
                        <td>@if(!is_null($eq->getQualifiedUni)){{$eq->getQualifiedUni->OrgaName}}@endif</td>
                        <td>{{$eq->QType}}</td0>
                        <td> <?php $a= QualificationType::where('QT_ID','=',$eq->QCode)->pluck('Qualification');
                                   $b= Qualification::where('Qualification_ID','=',$a)->pluck('qualification');
                                   echo $b; ?></td>
                        <td>@if(!is_null($eq->getQualifiedType)){{$eq->getQualifiedType->QualificationDescription}}@endif</td>
                        <td>{{$eq->MainSubject}}</td>
                        <td>{{$eq->Year}}</td>
                        <td><?php $monthNum  = $eq->Month;
                                  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                   $monthName = $dateObj->format('F');
                        echo $monthName; ?></td>
                        @if($user->hasPermission('editEmpqua'))
                        <td><a href='{{url('editEmpqua?id='.$eq->EQ_ID)}}'>Edit</a> </td>
                        @endif
                        <td>
                             @if($user->hasPermission('deleteEmpqua'))
                            <form id="deleteform"  action="{{url('deleteEmpqua')}}" method="POST" onsubmit="return doConfirm(@if(!is_null($eq->getEmployee))'{{$eq->getEmployee->NIC}}' @endif, this)">
                                <input type="hidden" name='eqid' value="{{$eq->EQ_ID}}" />
                                <button type="submit" class="btn btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
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
                                        {"bSortable": false}, {"bSortable": false}, null,null, null, null, null,{"bSortable": false},
                                        null,null, null, null, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}
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
