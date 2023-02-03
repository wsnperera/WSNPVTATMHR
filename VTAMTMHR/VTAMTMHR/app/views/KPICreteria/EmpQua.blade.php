@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />

<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>KPI Employee Criteria List<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
        <form name='search' action="{{url('CreateHREmployeeKPICriterias')}}" method='get' class="form-horizontal">

            
             <button type="submit" id="submit" class="btn btn-primary">
                            Create KPI Criteria</button>
           
        </form>
        <hr/>
       

       
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                        <tr>
                            <th>No</th>
                            <th>EPF No</th>
							<th>Name With Initials</th>
							
							<th>Current Center</th>
							<th>Division</th>
							<th>Designation</th>
							<th>Employee Type</th>
							<th>View Criteria List</th>
                            <th>Remove</th>
                           
                        </tr>
                 </thead>
                 <tbody>
                    <?php
                        $i = 1;
                    ?>
                @if(isset($moduleTask))
                    @foreach($moduleTask as $mc)
                    <tr>
                        <!--<td><b><u><a href="{{url('editModuleCourse?id='.$mc->EmpId)}}">{{$mc->EmpId}}</a></u><b></td>-->
                       <td>{{$i++}}</td>
                       <td>{{$mc->EPFNo}}</td>
                       <td>{{$mc->Initials}} {{$mc->LastName}}</td>
                       <td>{{$mc->OrgaName}}</td>
                       
                       <td>{{$mc->DepartmentName}}</td>
                       <td>{{$mc->Designation}}</td>
					   <td>{{$mc->EmployeeType}}</td>
                       <td class='center'>
					   
					   <a href="{{url('ViewHREmployeeKPICriteriasList?id='.$mc->EmpId)}}"><i class="icon-edit icon-3x icon-only"></i></a>
					   </td>
                       <td class='center'>
					   @if($user->hasPermission('DeleteHREmployeeKPICriteria'))
					   <form id="deleteform"  action='DeleteHREmployeeKPICriteria' method="POST" onsubmit="return doConfirm('{{$mc->EPFNo}}',this)">
                                <input type="hidden" name='id' value="{{$mc->EmpId}}" />
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
             <div class="span4" id="ajaxerror">
            @if(Session::has('done'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-ok"></i>
                   
                    {{Session::get('done')}}
                </strong>
                <br>
            </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                
                <strong>{{Session::get('message')}}</strong><br>
            </div>
            @endif
            @if($errors->has())
            @foreach($errors->all() as $msg)
            <div class="alert alert-error" id="error">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Error!
                </strong>{{$msg}}
                <br>
            </div>
            @endforeach
            @endif

        </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer')
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
     

    function doConfirm(course,formobj)  {
        bootbox.confirm("Are you sure you want to remove "+course, function(result) 
        {
            if(result) 
            {
                formobj.submit();
            }
         });
         return false;  // by default do nothing hack :D
     }
     
      @if (isset($done))

            $.gritter.add({title: "", text: "Module Course Added Successfully", class_name: "gritter-info gritter-center"});

    @endif
$('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false}, 
            {"bSortable": true},
              {"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},{"bSortable": false},
             
             
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