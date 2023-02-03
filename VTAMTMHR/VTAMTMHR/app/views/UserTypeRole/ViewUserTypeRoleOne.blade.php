@include('includes.bar')
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <a href={{url('ViewUserTypeRole')}}> << Back </a>
                <h1>User Type Role<small><i class="icon-double-angle-right"></i>Permissions</small></h1>
            </div>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>User Type</th>
                        <th>Permission</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset ($userTypeRole))
                        @foreach($userTypeRole as $a)
                            <tr>
                                <td>{{$a->getUserType->UType}}</th>
                                <td>{{$a->getActivityType->activityname}}</td>
                                <td>
                                    <form id="deleteform"  action='deleteUserTypeRole' method="POST" onsubmit="return doConfirm('{{$a->getActivityType->activityname}}',this)">
                                        <input type="hidden" name='id' value={{$a->id}} />
                                        <button type="submit" class="btn btn-grey btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                                    </form>
                                </td>
                            </tr> 
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('includes.footer')
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(course,formobj)
    {
        bootbox.confirm("Are you sure you want to Permission : "+course, function(result) 
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
            null,null,{"bSortable": false},
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
    
    @if(isset($done))
        
    $.gritter.add({ title: "", text: "User Type Role Added Successfully", class_name: "gritter-info gritter-center" });

    @endif
    
</script>
      
           
               
               
               
      
        
        

    
