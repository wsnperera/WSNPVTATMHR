@include('includes.bar')      
<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" href="assets/css/chosen.css" />
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
@if(isset($Issearch))
<a href={{url('ViewSalaryScale')}}> << Back to Salary Scale</a> 
@endif
<div class="page-content">
    <div class="row-fluid">
        <div class="page-header position-relative">
            <h1>Salary Scale<small><i class="icon-double-angle-right"></i>View</small></h1>
        </div>
<!--        <form name='search' action="{{url('findSalaryScale')}}" method='get'>
            Search Module Course By Course List Code : <input type='text' name="key"/>   <input type='submit' value='Search'/>
            <a href={{url('CreateSalaryScale')}}><input type='button' value='Create Module Course' /></a>
        </form>-->
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->
             <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                 <thead>
                <tr>
                    <th>Salary Scale ID</th>
                    <th>Salary Scale</th>
                    <th>Maximum Salary</th>
                    <th>Minimum Salary</th>
                    <th>Remove </th>
                </tr>
                 </thead>
                 <tbody>
                @if(isset ($salaryScale))
                    @foreach($salaryScale as $sc)
                    <tr>
                        <td>{{$sc->SS_ID}}</td>
                        <th>{{$sc->SalaryScale}}</th>
                        <td>{{$sc->MaxSalary}}</td>
                        <td>{{$sc->MinSalary}}</td>
                        <td>
                            <form id="deleteform"  action='deleteSalaryScale' method="POST" onsubmit="return doConfirm('{{$sc->SalaryScale}}',this)">
                                <input type="hidden" name='id' value="{{$sc->SS_ID}}" />
                                <button type="submit" class="btn btn-grey btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($salaryScale=='[]')
                        </table><center>Data Not Found</center>
                    @endif
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
     

    function doConfirm(salaryScale,formobj)  {
        bootbox.confirm("Are you sure you want to remove "+salaryScale, function(result) 
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