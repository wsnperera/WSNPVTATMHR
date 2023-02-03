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
                            View Courses (TVEC Document Receive)
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
                        <th class='center'>Mark Document Receive</th>
                        
                </tr>
                </thead>
                    <tbody>

                  <?php $SerialNo=1
                  ?>
                @if(isset($courses))
                @foreach($courses as $t)
                <tr>
                   
                     <td class="center">{{$SerialNo++}}</td>
                    <td class="center">{{$t->yearstart}}</td>
                    <td class="center">{{$t->oname}}</td> 
                    <td>{{$t->cname}}</td>
                    <td class="center">{{$t->ccode}}</td>
                    <td class="center">{{$t->Duration}}</td>
                    <td class="center">{{$t->batch}}</td>
                    <td class="center">{{$t->sdate}}</td>
                    <td class="center">{{$t->expectedcompleted}}</td>
                     @if($t->TVECSend == 0)
                    <td class='center'> <font color="Orange"><i class="icon-remove bigger-130"></i></font></td>
                    @else
                     <td class='center'> <font color="red"><i class="icon-ok bigger-130"></i></font></td>
                    @endif
                    @if($t->DocumentReceiveFromAssessor == 0)
                  <td class='center'><a class="green"  id="{{$t->id}}"> <i class="icon-thumbs-up bigger-130"></i></a></td>
                    @else
                     <td class='center'> <font color="red"><i class="icon-ok bigger-130"></i></font></td>
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

     $(".green").click(function(){

     var id = this.id;
     //alert(id);
      $.ajax  ({
                    url: "{{url::to('saveTVECDocReceive')}}",
                    data: { id: id},
                    
                   success: function(result) {

                        //alert(result);
                       location.reload();          
                        
                        }


                    
                });

});
  
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
