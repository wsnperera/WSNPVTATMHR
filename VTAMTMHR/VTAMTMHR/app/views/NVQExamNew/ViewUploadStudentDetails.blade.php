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
                        NVQ Exams        
                        <small>
                            <i class="icon-double-angle-right"></i>
                            View Courses 
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="" method='POST' class='form-horizontal'>
             <div class="control-group">
                    <label class="control-label" for="centers">Centers</label>
                    <div class="controls">
                        <select name="center" id="center">
                            <option value="0">All</option>
                            @foreach($center as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->OrgaName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br/> 
                <div class="control-group">
                    <div class="controls">
                        <button type="submit"  class="btn btn-primary"">
                                <i class="icon-eye-open bigger-200"></i>View</button>
                                <span id='upld' hidden>
                                
                              
                                </span>
                    </div>
                </div>   
            </form>
            <div id="aaaa">
            @if(isset($courses))
            <!-- <form action="{{url('downloadExcelTraineeKal')}}" method='post'>
             <input type="hidden" value="" name="CCode">
             <input type="hidden" value="" name="years">
             <input type="submit" value="Download" class="btn"/>
             </form>-->
             @endif
           <!-- <h5 style="color: #777777;">@if(isset($CourseCode))CourseCode:&nbsp;&nbsp;{{$CourseCode}}@endif</h5>
            <h5 style="color: #777777;">@if(isset($BatchCode))BatchCode:&nbsp;&nbsp;{{$BatchCode}}@endif</h5>-->
            
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <th class='center'>No</th>
                        <th class='center'>Year</th>
                        <th class='center'>Center</th>
                        <th class='center'>Course Name</th>
                        <th class='center'>Course Code</th>
                        <th class='center'>Duration</th>
                        <th class='center'>Batch</th>
                        <th class='center'>Start Date</th>
                        <th class='center'>Expected Complete</th>
                        <th class='center'>TVEC Send</th>
                        <th class='center'>View Students</th>
                </tr>
                </thead>
                    <tbody>

                  <?php $SerialNo=1
                  ?>
                @if(isset($courses))
                @foreach($courses as $t)
                <tr>
                    @if($t->TVECSend == 0)
                     <td class="center"><font color="red">{{$SerialNo++}}</font></td>
                    <td class="center"><font color="red">{{$t->yearstart}}</font></td>
                    <td class="center"><font color="red">{{$t->oname}}</font></td> 
                    <td><font color="red">{{$t->cname}}</font></td>
                    <td class="center"><font color="red">{{$t->ccode}}</font></td>
                    <td class="center"><font color="red">{{$t->Duration}}</font></td>
                    <td class="center"><font color="red">{{$t->batch}}</font></td>
                    <td class="center"><font color="red">{{$t->sdate}}</font></td>
                    <td class="center"><font color="red">{{$t->expectedcompleted}}</font></td>
                    <td class="center"><font color="red">{{$t->TVECSend}}</font></td>
                     <td><a class="green" href="{{url('EUviewNVQnewStudentDetails?cid='.$t->ccode)}}"> <i class="icon-pencil bigger-130"></i></a></td>

                     @else
                     <td class="center"><font color="green">{{$SerialNo++}}</font></td>
                    <td class="center"><font color="green">{{$t->yearstart}}</font></td>
                    <td class="center"><font color="green">{{$t->oname}}</font></td> 
                    <td><font color="green">{{$t->cname}}</font></td>
                    <td class="center"><font color="green">{{$t->ccode}}</font></td>
                    <td class="center"><font color="green">{{$t->Duration}}</font></td>
                    <td class="center"><font color="green">{{$t->batch}}</font></td>
                    <td class="center"><font color="green">{{$t->sdate}}</font></td>
                    <td class="center"><font color="green">{{$t->expectedcompleted}}</font></td>
                    <td class="center"><font color="green">{{$t->TVECSend}}</font></td>
                     <td><a class="green" href="{{url('EUviewNVQnewStudentDetails?cid='.$t->ccode)}}"> <i class="icon-pencil bigger-130"></i></a></td>

                     @endif
                    
                </tr>
                @endforeach

               
                @endif
            </tbody>
            </table>
            <!--PAGE CONTENT ENDS-->
            </div>
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->
@include('includes.footer') 
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
    function doConfirm(applicant, formobj)
    {
        bootbox.confirm("Are you sure you want to remove " + applicant, function(result)
        {
        if (result)
        {
        formobj.submit();
        }
        });
                return false;
    }
    
    $('#sample-table-2').dataTable({
    "aoColumns": [
            {"bSortable": false},
            {"bSortable": false},
           null,
            null,
            null,
           null,
            null,
           null,
            null,
            null,
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

<script>
//Create by amila 
$("#years").on("change",function(){
    $("#sample-table-2").html('');
    $("#aaaa").html('');
    var y=this.value;
    if(y!='0'){
        
        //$("#CourseList").show();
        $.ajax({
            url:"{{url::to('loadCourseList')}}",
            data:{year:y},
            success: function(result){
                $("#CourseList").html(result);
            },
            error : function(res){
                alert(res.responseText);
            }
        });
    }else{
        alert("Error");
    }
});


//Create by amila end
</script>
