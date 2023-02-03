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
                <h1>User Type Role<small><i class="icon-double-angle-right"></i>View</small></h1>
            </div>
            <a href={{url('createUserTypeRole')}}><button type="button" class="btn btn-primary">Assign User Type Role</button></a>
            <br><br>
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>User Type</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset ($userTypeRole))
                        @foreach($userTypeRole as $a)
                            <tr>
                                <td>@if(isset($a->getUserType->UType)) {{$a->getUserType->UType}} @endif</th>
                                <td><b><u><a href="{{url('ViewUserTypeRoleOne?id='.$a->utypeid)}}">View</td>
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
    $('#sample-table-2').dataTable({
    "aoColumns": [
            null,{"bSortable": false},
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
      
           
               
               
               
      
        
        

    
