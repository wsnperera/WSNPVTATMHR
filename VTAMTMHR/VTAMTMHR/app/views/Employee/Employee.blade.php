@include('includes.bar')       
@if(isset($Issearch))
<a href="{{url('viewEmployee')}}"> << Back to Employee </a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>
                Employee		
                <small>
                    <i class="icon-double-angle-right"></i>
                    View
                </small>			
            </h1>
        </div>

        <form name='search' action="{{url('searchEmployee')}}" method='get'>
            
			 @if($user->hasPermission('createEmployee'))
			 <a href="{{url('createEmployee')}}"><button type="button" id="submit" class="btn btn-pink">
             <i class="icon-pencil bigger-100"></i>Create Monitoring Employee</button></a>
				 @endif
        </form>

        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>

                    <th>#No#</th>
                    <th>Active Status</th>
                    <th>Organisation Name</th>
					<th>Designation</th>
                    <th>Employee Reference No</th>
                    <th>Initials</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>NIC</th>	
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>@if($user->hasPermission('deleteEmployee')) Remove @endif</th>	
                </tr>
              
           
                 </thead>
                 
                 <tbody>
<?php $i = 0; ?>
                @if(isset ($Employee))
                @foreach ($Employee as $e)
                <tr>
                    <td><?php $i++;echo $i; ?></td>
                    <td>@if($e->Active == 1) Yes @else No @endif</td>
                    <td>{{$e->OrgaName}}({{$e->Type}})</td>
                    <td>{{$e->Designation}}</td>
                    <td>
					@if($user->hasPermission('editEmployee') && ($e->id === $user->EmpId || $userOrgType === 'HO'))
                        <a href="{{url('editEmployee?cid='.$e->id)}}">{{$e->EPFNo}}</a>
                    @elseif ($user->hasPermission('editEmployee') && $e->id === $user->EmpId && $userOrgType !== 'HO')
                        <a href="{{url('editEmployee?cid='.$e->id)}}">{{$e->EPFNo}}</a>
                    @else
                        {{$e->EPFNo}}
                    @endif
					</td>
                    <td>{{$e->Initials}} </td>  
                    <td>{{$e->Name}} </td> 
                    <td>{{$e->LastName}} </td> 
                    <td>{{$e->NIC}}</td>  
                    <td>{{$e->DOB}} </td>
                    <td>{{$e->Sex}} </td>   
                   
                  
                    <td>
					    @if($user->hasPermission('deleteEmployee'))
                        <form id="deleteform"  action="{{url('deleteEmployee?id='.$e->id)}}" method="POST" onsubmit="return doConfirm('{{$e->NIC}}', this)">
                            <input type="hidden" name='cid' value="{{$e->id}}" />
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

            function doConfirm(Employee, formobj)  {
            bootbox.confirm("Are you sure you want to remove " + Employee, function(result)  {
            if (result){
            formobj.submit();
            }
            });
                    return false; // by default do nothing hack :D
            }
$('#sample-table-2').dataTable({
  //  "bPaginate":true,
   // "aaSorting":[],
    "aoColumns": [
            {"bSortable": false}, {"bSortable": false},  {"bSortable": false},  {"bSortable": false},  {"bSortable": false},  {"bSortable": false},  {"bSortable": false},  {"bSortable": false}, 
			 {"bSortable": false},  {"bSortable": false},  {"bSortable": false},  {"bSortable": false}, 
			
			
          
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