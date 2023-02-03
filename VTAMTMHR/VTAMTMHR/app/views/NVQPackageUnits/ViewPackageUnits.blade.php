@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('NVQPackageUnit')}}> << Back to View NVQ Package Unit</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>NVQ Package Unit<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
        <form name='search' action="{{url('CreateNVQUnits')}}" method='get'>
           
           <!-- <a href={{url('#')}}><input type='button' value='Create Module' /></a>-->
            <button type="submit" id="submit" class="btn btn-primary">
                            Assign NVQ Packages Units</button>
        </form>
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
        <div class="span12">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
                            <th>No</th>
                            <th>Edit</th>
                            <th>Trade</th>
                            <th>Competency Standard Code</th>
                            <th>Competency Standard Name</th>
                            <th>Qualification Package Code</th>
                            <th>Unit Code</th>
                            <th>Unit Name</th>
							  <th>Unit Version</th>
                            <th>Unit Status</th>
                            <th>Active</th>
                            <th>Delete</th>
                </tr>
                 </thead>
                 <tbody>
                        <?php $i = 1; ?>
                            @if(isset ($NVQUNITS))
                                @foreach($NVQUNITS as $m)
                                <tr>
                                <td>{{$i++}}</td>
                                <td><form id="editform"  action="{{url('EditNVQUnits')}}" method="GET" >
                                                <input type="hidden" name='id' value='{{$m->id}}' />
                                                <button type="Submit" class="btn btn-success btn-mini"><i class="icon-edit icon-2x icon-only"></i></button>
                                            </form></td>
                                    <td>{{$m->TradeName}}</td>
                                    <td>{{$m->code}}</td>
                                    <td>{{$m->name}}</td>
                                    <td>{{$m->packagecode}}</td>
                                    <td>{{$m->UnitCode}}</td>
                                    <td>{{$m->UnitName}}</td>
									<td>{{$m->UnitVersion}}</td>
                                    <td>
                                    
                                         @if($m->UnitStatus == "C")
                                         Compulsory
                                         @else
                                         Optional
                                         @endif 
                                     
							 
							    
                                    </td>
                                    
                                    <td>
                                        @if($m->Active == "1")
                                    <font color="green"><i class="icon-ok bigger-130"></i></font>
                                        @endif
                                        @if($m->Active == "0")
                                        <font color="red"><i class="icon-remove bigger-130"></i></font>
                                        @endif
                                    </td>

                                    <td>
                                        <form id="deleteform"  action='DeletePackage' method="POST" onsubmit="return doConfirm('{{$m->UnitName}}',this)">
                                            <input type="hidden" name='id' value="{{$m->id}}" />
                                            <button type="submit" class="btn btn-danger btn-mini"><i class="icon-trash icon-2x icon-only"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @if($NVQUNITS=='[]')
                                    </table><center>Data Not Found</center>
                                @endif
                            @endif
                    </tbody>
            </table>
            <!--PAGE CONTENT ENDS-->
        <div class="span4" id="ajaxerror">
            
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
            null, 
              null,
             null, 
			 null,  null,  null,  null, null,null,null,null,
             
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