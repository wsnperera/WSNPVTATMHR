@include('includes.bar') 
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />      
@if(isset($Issearch))
<a href={{url('viewUsers')}}> << Back to Users </a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                User 			
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Users
                </small>			
            </h1>
        </div>  
        <div class="span12">
		<form>
            <!--PAGE CONTENT BEGINS-->
           
          
            <a href={{url('createUser')}}><input type='button' value='Create User' class="btn btn-primary btn-large"/></a>
            
               
            </form> 
			
            <?php $i = 0; ?>
            <div class="row-fluid span12" style="margin: 0px" overflow="auto">
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th></th>
                          
                            <th>Edit</th>
							<th>User Name</th>
                            <th>User Type</th>
							<th>Center</th>
							<th>Division</th>
							<th>Employee</th>
                            <th>Active</th>
                            <th>Deactivate</th>
                            <th class="center">Reset Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset ($users))
                        @foreach ($users as $c)
                        <tr>
                            <td>{{++$i}}</td>
                           
                            <td class="center"><a href="{{url('editUsers?cid='.$c->userID)}}"><input type='button' value='Edit' class="btn btn-small btn-info" /></a></td>
                             <td>{{$c->userName}}</td>
							<td>{{$c->UType}}</td>
							<td>{{$c->OrgaName}}</td>
							<td>{{$c->UserDivision}}</td>
							<td>{{$c->Initials}} {{$c->LastName}}</td>
                            <td>
                                @if($c->active == 1)
                                {{"Yes"}}
                                @else 
                                {{"No"}}
                                @endif
                            </td>
                            <td> 
                                @if($c->active == 1)
                                <a href="{{url('deactivateUsers?cid='.$c->userID.'&select=deactivate')}}"><input type='button' value='Deactivate' class="btn btn-small btn-danger" /></a>
                                @else
                                <a href="{{url('deactivateUsers?cid='.$c->userID.'&select=activate')}}"><input type='button' value='Activate' class="btn btn-small btn-success" /></a>
                                @endif
                            </td>
                            <td class="center">
                                <a href="{{url('resetPassword?cid='.$c->userID)}}"><input type='button' value='Reset' class="btn btn-small btn-warning" /></a>
                            </td>
                        </tr>                    
                        @endforeach
                        @endif                    
                    </tbody>
                </table>
            </div>
            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')   


<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">


$('#sample-table-2').dataTable({
    "aoColumns": [
             null,null, null,null,null,null, null, null,null, {bSortable:false}
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
