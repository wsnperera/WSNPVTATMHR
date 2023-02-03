@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(!isset($secondPage))
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewUserTypeRole')}}> << Back to View User Role Type </a>
                <h1>User Type Role<small><i class="icon-double-angle-right"></i>Search</small></h1>
            </div>
            <form class="form-horizontal" action='' method="POST"/>
            <div class="control-group">
                <label class="control-label" for="CourseListCode">User Type : </label>
                <div class="controls">
                    <select name='utypeid' >
                        @foreach($userType as $ut)
                        <option value='{{$ut->id}}'>{{$ut->UType}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="Search" class="btn btn-small btn-primary">< Search ></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@else
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewUserTypeRole')}}> << Back</a>
                <h1>User Type Role<small><i class="icon-double-angle-right"></i>Create</small></h1>
            </div>
            <form class="form-horizontal" action='saveUserTypeRole' method="POST">
            <h2><u><center>Add Privilege for User Type : {{$userType->UType}}</center></u></h2>
            <input type="hidden" name='utypeid' value="{{$userType->id}}" />
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><input type='checkbox'/>
                            <span class="lbl"></span>Check-Un-check</th>
                        <th>Activity Name</th>
                        <th>Route</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset ($activity))
                    @foreach($activity as $a)
                    <tr>
                        <td>{{$a->activityid}}</th>
                        <td>
                            <input type='checkbox' name='activityid[]' value='{{$a->activityid}}' />
                            <span class="lbl"></span>
                        </td>
                        <td>{{$a->activityname}}</td>
                        <td>{{$a->routename}}</td>
                    </tr> 
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="control-group">
                <br>
                <div style="margin-left: 650px;" class="controls">
                    <button type="submit" class="btn btn-small btn-primary">< Save ></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endif
@include('includes.footer')
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
$('#sample-table-2').dataTable({
    "bPaginate":false,
    "aoColumns": [
        {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}
    ]});
$('table th input:checkbox').on('click', function() {
    var that = this;
    $(this).closest('table').find('tr > td:nth-child(2) input:checkbox')
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

@if (isset($done))

        $.gritter.add({title: "", text: "User Type Role Added Successfully", class_name: "gritter-info gritter-center"});

@endif

</script>










