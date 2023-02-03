@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8" style="width: 100%">
                <div class="page-header position-relative">
                    <h1>
                        Activity    
                        <small>
                            <i class="icon-double-angle-right"></i>
                            View
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <div class="table-header">
                </div>
                <form name='search' action="{{url('searchActivity')}}" method='get'>
                    <a href={{url('createActivity')}}><button type="button" class="btn btn-warning">Create Activity</button></a>
                </form>
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Activity Name</th>
                            <th>Route Name</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset ($trades))
                            @foreach ($trades as $c)
                                <tr>
                                    <td>{{$c->activityname}}</td>  
                                    <td>{{$c->routename}}</td>
                                    <td>
                                        <a href="{{url('editactivity?cid='.$c->activityid)}}">
                                            <button class='btn btn-block btn-primary'/><i class='icon-edit'></i></button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->

@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(course,formobj)
    {
        bootbox.confirm("Are you sure you want to remove Course List Code : "+course, function(result) 
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
            null, 
            null, 
            null,
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