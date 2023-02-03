@include('includes.bar')   
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                Carder	
                <small>
                    <i class="icon-double-angle-right"></i>
                    View
                </small>			
            </h1>
        </div>
        <div class="row-fluid span12" style="margin: 0px" overflow="auto">
            <div class="table-header">
            </div>
            <a href={{url('createEmployment')}}><input type='button' value='Create Carder' /></a>
            <br><br>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Edit</th>
                        <th>Institute</th>
                        <th>Carder</th>	
                        <th>Academic</th>
                        <th>Designation</th>
                        <th>No Of Positions</th>
                        <th>Salary Code</th>
                        <th>Major or Minor</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset ($Event))
                        @foreach ($Event as $c)
                            <tr>
                                <td><a href="{{url('editEmployment?cid='.$c->id)}}">Edit</a></td>
                                <td>{{$c->getInstitution->InstituteName}}</td>
                                <td>{{$c->EmpCode}} </td>
                                <td>{{$c->Academic}} </td>
                                <td>{{$c->Designation}} </td> 
                                <td>{{$c->Positions}} </td>
                                <td>{{$c->SalaryCode}} </td>
                                <td>
                                    @if($c->MajorMinor=='0')
                                        Minor
                                    @else
                                        Major
                                    @endif
                                </td>
                                <td>
                                    <form id="deleteform"  action="{{url('deleteEmployment?EmpCode='.$c->EmpCode)}}" method="POST" onsubmit="return doConfirm('{{$c->EmpCode}}', this)">
                                        <input type="hidden" name='cid' value={{$c->id}} />
                                        <button type="submit" class="btn btn-grey btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(course,formobj)
    {
        bootbox.confirm("Are you sure you want to remove Course Year Plan with Carder : "+course, function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
     }
    $('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false},
            null, 
            {"bSortable": false}, 
            {"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false}, 
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
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