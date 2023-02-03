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
                       Assessor   
                        <small>
                            <i class="icon-double-angle-right"></i>
                            View Assessor 
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="" method='POST' class='form-horizontal'>
             <div class="control-group">
                    <label class="control-label" for="centers">Tardes</label>
                    <div class="controls">
                        <select name="center" id="center">
                            <option value="0">All</option>
                            @foreach($trade as $cnt)
                            <option value="{{$cnt->id}}">{{$cnt->code}} - {{$cnt->name}}</option>
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
            <table><tr><td><form action="{{url('DownloadExcelAssessorList')}}" method='post'>
             <input type="hidden" value="{{$CSID}}" name="TradeID" id="TradeID"/>
             
             <input type="submit" value="Download Excel" class="btn btn-pink"/>
             </form></td>
             <td>
               <form>     
                      
                                <input type="hidden" value="{{$CSID}}" name="CS_ID" id="CS_ID"/>
                                <button type="button" id="upload" class="btn btn-yellow">
                                <i class="icon-eye-open bigger-200"></i>Print Assessor List</button>
                                <span id='img4'></span>

                 </form>              
                   
               </td></tr>
            

             
             @endif
           <!-- <h5 style="color: #777777;">@if(isset($CourseCode))CourseCode:&nbsp;&nbsp;{{$CourseCode}}@endif</h5>
            <h5 style="color: #777777;">@if(isset($BatchCode))BatchCode:&nbsp;&nbsp;{{$BatchCode}}@endif</h5>-->
            
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <th class='center'>No</th>
						
						<th class='center'>Competency Code</th>
                        <th class='center'>Assess ID</th>
                        <th class='center'>Name</th>
                        <th class='center'>Home Address</th>
                        <th class='center'>Home Telephone</th>
                        <th class='center'>Mobile No</th>
                        <th class='center'>Designation</th>
                        <th class='center'>Office Address</th>
                        <th class='center'>Office Telephone</th>
                        <th class='center'>Note</th>
                       
                </tr>
                </thead>
                    <tbody>

                  <?php $SerialNo=1
                  ?>
                @if(isset($courses))
                @foreach($courses as $t)
                <tr>
                    @if($t->Type == 'Probation')
                     <td class="center"><font color="blue">{{$SerialNo++}}</font></td>
				  <td class="center"><font color="blue">{{$t->code}}</font></td>
                    <td class="center"><font color="blue">{{$t->AssessorId}}</font></td>
                    <td class="center"><font color="blue">{{$t->Name}}</font></td> 
                    <td><font color="blue">{{$t->HomeAddress}}</font></td>
                    <td class="center"><font color="blue">{{$t->HomeTel}}</font></td>
                    <td class="center"><font color="blue">{{$t->Mobile}}</font></td>
                    <td class="center"><font color="blue">{{$t->Designation}}</font></td>
                    <td class="center"><font color="blue">{{$t->Address}}</font></td>
                    <td class="center"><font color="blue">{{$t->ContactNo}}</font></td>
                    <td class="center"><font color="blue">{{$t->Note}}</font></td>
                    

                     @elseif($t->Type == 'Licenced')
                     <td class="center"><font color="green">{{$SerialNo++}}</font></td>
					  <td class="center"><font color="blue">{{$t->code}}</font></td>
                    <td class="center"><font color="green">{{$t->AssessorId}}</font></td>
                    <td class="center"><font color="green">{{$t->Name}}</font></td> 
                    <td><font color="green">{{$t->HomeAddress}}</font></td>
                    <td class="center"><font color="green">{{$t->HomeTel}}</font></td>
                    <td class="center"><font color="green">{{$t->Mobile}}</font></td>
                    <td class="center"><font color="green">{{$t->Designation}}</font></td>
                    <td class="center"><font color="green">{{$t->Address}}</font></td>
                    <td class="center"><font color="green">{{$t->ContactNo}}</font></td>
                    <td class="center"><font color="green">{{$t->Note}}</font></td>
                    
                     @else
                     <td class="center"><font color="black">{{$SerialNo++}}</font></td>
				  <td class="center"><font color="blue">{{$t->code}}</font></td>
                    <td class="center"><font color="black">{{$t->AssessorId}}</font></td>
                    <td class="center"><font color="black">{{$t->Name}}</font></td> 
                    <td><font color="black">{{$t->HomeAddress}}</font></td>
                    <td class="center"><font color="black">{{$t->HomeTel}}</font></td>
                    <td class="center"><font color="black">{{$t->Mobile}}</font></td>
                    <td class="center"><font color="black">{{$t->Designation}}</font></td>
                    <td class="center"><font color="black">{{$t->Address}}</font></td>
                    <td class="center"><font color="black">{{$t->ContactNo}}</font></td>
                    <td class="center"><font color="black">{{$t->Note}}</font></td>
                    

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

    $('#upload').click(function()
    {
      
        var CS_ID = $("#CS_ID").val(); 
       alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintAssessorList')}}",
                        data: {CS_ID: CS_ID},
                        success:function response(responseText, statusText, xhr, $form)
                        {
       
                               var printWin = window.open("","printSpecial");
                                printWin.document.open();
                                printWin.document.write(responseText);
                                printWin.document.close();
                                printWin.print();
       
   
                         

                        },
                        complete: function() {
                            document.getElementById('img4').innerHTML ="";

                        }
                    });
        
    }
    );
    
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
            null,   null,
           
           
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
