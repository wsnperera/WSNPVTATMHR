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
                        Course Details			
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
                <a href={{url('createCourseDetails')}}><input type='button' value='Create New' class="btn " /></a>
                <br><br>
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Edit</th>
                            <th>Institute</th>
                            <th>Course Name</th>
                            <th>Course Type</th>
                            <th>TVC Course Code</th>
                            <th>Course List Code</th>
                            <th>Trade</th>
                            <th>NVQ/NON-NVQ</th>
                            <th>Course Level</th>
                            <th>Duration</th>
                            <th>Program Type</th>
                            <th>Qualification</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset ($courseDetails))
                            @foreach($courseDetails as $c)
                                <tr>
                                    <td>
                                        <a class="green" href="{{'editCourseDetails?CD_ID='.$c['CD_ID']}}">
                                         <i class="icon-pencil bigger-130"></i>
                                         </a>
                                    </td>
                                    <td>{{ProjectN::getInstitute()->InstituteName}}</td>
                                    <td>{{$c['CourseName']}}</td>
                                    <td>{{$c['CourseType']}}</td>
                                    <td>{{$c['TVCCourseCodeID']}}</td>
                                    <td>{{$c['CourseListCode']}}</td>
                                    <td>{{$c['TradeName']}}</td>
                                    <td>{{$c['Nvq']}}</td>
                                    <td>
                                        @if($c['Nvq']=='NVQ')
                                            Level 
                                        @endif
                                        {{$c['CourseLevel']}}
                                    </td>
                                    <td>
                                        {{$c['Duration']}}
                                        @if($c['CourseType']=='Part')
                                            Hours
                                        @else
                                            Months
                                        @endif
                                    </td>
                                    <td>{{$c['ProgramType']}}</td>
                                    <td>{{$c['qualification']}}</td>
                                    <td>
                                        <form id="deleteform"  action='deleteCourseDetails' method="POST" onsubmit="return doConfirm(this)">
                                            <input type="hidden" name='CD_ID' value='{{$c['CD_ID']}}' />
                                            <button type="submit" class="btn btn-grey btn-small"><i class="icon-trash icon-2x icon-only"></i></button>
                                        </form>
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
    function doConfirm(formobj)
    {
        bootbox.confirm("Are you sure you want to remove this raw ? ", function(result) 
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
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            null,
            null,
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
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