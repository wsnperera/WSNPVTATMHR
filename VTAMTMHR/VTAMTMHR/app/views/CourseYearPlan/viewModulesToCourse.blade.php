@include('includes.bar')
<div class="page-content">
    <div class="row-fluid">
        <div class="span8">
            <div class="page-header position-relative">
                <h1>Assign Course Year Plan<small><i class="icon-double-angle-right"></i>Assign Modules</small></h1>
                <a href={{url('ConfirmCourseYearPlanFirstPage')}}> << Back to View </a>
            </div>
            <form class="form-horizontal" action='editModulesToCourse' method="GET">
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Course Name : </label>
                        <div class="controls">
                            <span class="lbl" >{{Course::getCourseName($courseYearPlan->CourseListCode)}}</span>
                        </div>
                </div>
             
               
               
            
                <div class="control-group">
                    <label class="control-label" for="CourseListCode">Instructor : </label>
                    <div class="controls">
                        <table >
                            <tr>
                                <td>
                                    <table id="my_table" >
                                        <tr>
                                            <td>
                                                @foreach($Instructor as $i)
												{{$i['Initials']}} {{$i['LastName']}}
                                                @endforeach
                                            </td>
                                        </tr>
                                        
                                    </table>
                                    <br>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="table">
                            <tr>
                                <th>Module Code</th>
                                <th>Module Name</th>
                            </tr>
                            <tr>
                            @foreach($module as $m)
                                <tr>
                                    <td><span class="lbl">{{$m['modulecode']}}</span></td>
                                    <td><span class="lbl">{{$m['modulename']}}</span></td>
                                </tr>
                            @endforeach
                       
                        </table>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="hidden" name="yearPalnID" value="{{$courseYearPlan->id}}" />
                        <input type="submit" class="btn btn-small btn-primary" value="Edit"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="span4">
            @if($errors->has())
                @foreach($errors->all() as $msg)
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <strong> <i class="icon-remove"></i>{{$msg}}</strong>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@include('includes.footer')
<script>
    $('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false},
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
      
           
               
               
               
      
        
        

    
