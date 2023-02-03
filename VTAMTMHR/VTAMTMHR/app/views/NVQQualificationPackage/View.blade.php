@include('includes.bar')       
@if(isset($Issearch))
<a href={{url('ViewModule')}}> << Back to Module </a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>NVQ Qualification Packages<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
        <form name='search' action="{{url('CreateNVQQualificationPackages')}}" method='get'>
           
           <!-- <a href={{url('CreateModule')}}><input type='button' value='Create Module' /></a>-->
            <button type="submit" id="submit" class="btn btn-primary">
                            Create Qualification Packages</button>
        </form>
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
				<th>No</th>
				<th>Edit</th>
                   
					  <th>Competency Standard Code</th>
                      <th>Package Code</th>
					   <th>NVQ Level</th>
					  <th>Remove</th>
                </tr>
            </thead>
            <tbody>
			<?php $i = 1; ?>
                @if(isset ($NVQcompetencystandard))
                    @foreach($NVQcompetencystandard as $m)
                    <tr>
					<td>{{$i++}}</td>
					<td><form id="editform"  action='editNVQQualificationPackages' method="GET" >
                                    <input type="hidden" name='id' value='{{$m->id}}' />
                                    <button type="Submit" class="btn btn-success btn-mini"><i class="icon-edit icon-2x icon-only"></i></button>
                                </form></td>
                       
						<td>{{$m->cscode}}</td>
						<td>{{$m->packagecode}}</td>
						<td>{{$m->level}}</td>
                        <td>
                            <form id="deleteform"  action='deleteNVQQualificationPackages' method="POST" onsubmit="return doConfirm('{{$m->packagecode}}',this)">
                                <input type="hidden" name='id' value="{{$m->id}}" />
                                <button type="submit" class="btn btn-danger btn-mini"><i class="icon-trash icon-2x icon-only"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($NVQcompetencystandard=='[]')
                        </table><center>Data Not Found</center>
                    @endif
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
    function doConfirm(course,formobj)
    {
        bootbox.confirm("Are you sure you want to remove "+course, function(result) 
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
			{"bSortable": false},			
            null, 
             null,
null,	
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