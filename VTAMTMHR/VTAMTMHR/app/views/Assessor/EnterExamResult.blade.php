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
                            Enter Trainee Result Sheet
                        </small>            
                    </h1>
                </div>
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="ViewOriginalResultSheet" method='POST' class='form-horizontal'>
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
                 <div class="control-group">
                    <label class="control-label" for="centers">Course:</label>
                    <div class="controls">
                        <select name="Course" id="Course">
                            <option value="0">--- Select Course ---</option>
                          
                        </select>
                    </div>
                </div>
                 <!--<div class="control-group">
                    <label class="control-label" for="centers">Competency Standard</label>
                    <div class="controls">
                        <select name="comS" id="comS" required>
                             @foreach($Competency as $cs)
                            <option value="{{$cs->code}}">{{$cs->name}} - {{$cs->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>-->
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
            @if(isset($trainees))
           
            <input type="hidden" id="CSID" name="CSID" value="{{$CSID}}" />

        
             <table>
                <tr>
                    <td>
                    <?php
                     $getConfirmProvince = NVQCoursestartedTrans::ProvinceConfirmResult($CSID);
                     $getConfirmCenter = NVQCoursestartedTrans::CenterConfirmResult($CSID);

                     ?>
                     @if($getConfirmProvince == 0 && $getConfirmCenter == 1)
                        <form action="ConfirmResultProvince" method='GET' > 
                            <input type="hidden" value="{{$CSID}}" name="CS_ID" id="CS_ID"/>
                            <button type="submit"  class="btn btn-danger">
                            <i class="icon-ok bigger-200"></i>Confirm Result(Province)</button>
                            <span id='img4'></span>
                        </form> 

                     @elseif($getConfirmProvince == 1 && $getConfirmCenter == 1)
                         <button type="button"  class="btn btn-success">
                            <i class="icon-ok bigger-200"></i>Already Confirmed By Province</button>

                     @elseif($getConfirmCenter == 0 && $getConfirmProvince == 0)
                         <button type="button"  class="btn btn-success">
                            <i class="icon-ok bigger-200"></i>Not Confirmed By Center</button>
                    @else

                    @endif
                       

                    </td>
                    
                    
                </tr>
            </table>
            @endif
            
             
            

           
           <!-- <h5 style="color: #777777;">@if(isset($CourseCode))CourseCode:&nbsp;&nbsp;{{$CourseCode}}@endif</h5>
            <h5 style="color: #777777;">@if(isset($BatchCode))BatchCode:&nbsp;&nbsp;{{$BatchCode}}@endif</h5>-->
             @if(isset($trainees))
            
            <table id='sample-table-2' class='table table-striped table-bordered table-hover' align='center'>
                <thead>
                <tr align='center'>
                     <th rowspan='2'>No</th>
                     <th rowspan='2'>Edit Result</th>
                     <th colspan='2' class='center'>Candidates</th>
                     <th colspan='{{$ModuleCount}}' class='center'>National Skills Standards Unit Number</th>
                     <th rowspan='2' class='center'>Packages Available</th>

                       
                        
                </tr>
                 <?php $HeaderNo=1
                  ?>
                <tr>
                     <th class='center'>Name</th>
                     <th class='center'>Idntification Number</th>
                     @foreach($modulelist as $m)
                      <th class='center'>{{$HeaderNo++}}</th>
                    @endforeach
                      
                </tr>
                 <?php $SerialNo=1
                  ?>
               
                @foreach($trainees as $t)
                <tr>
                     <td>{{$SerialNo++}}</td>
                      @if($getConfirmProvince == 0)
                      <td class='center'><font color="blue"><a class="blue" href="{{url('EditOriginalResultSheet?asnid='.$t->id.'&&CSID='.$CSID)}}" > <i class="icon-pencil bigger-130"></i></a></font></td>
                      @else
                     <td class='center'> <font color="red"><i class="icon-warning-sign bigger-130"></i></font></td>
                      @endif
                     <td>{{$t->NameWithInitials}}</td>
                     <td>{{$t->NIC}}</td>
                     @foreach($modulelist as $m)
                      <?php
                      $unitResult = NVQStudentUnitResult::GetUnitResult($t->id,$m->id,$CSID);

                      ?>
                      <td class='center'>{{$unitResult}}</td>
                     @endforeach
                     <?php

                     $packagesAvailable = NVQStudentUnitResult::GetPackageAvailable($t->id,$CSID);
                     $countP = count($packagesAvailable);

                     ?>
                     <td class='center'>
                      @if($countP != 0)
                        @foreach($packagesAvailable as $n)
                         <font color='green'> {{$n->PackageCode}},</font>
                        @endforeach
                     @else
                     <font color='red'>No Package Available</font>
                     @endif
                   </td>
                </tr>
                @endforeach
               
                </thead>
                <tbody>

                 
               
            </tbody>
            </table>
             @endif
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
            {"bSortable": false},
             {"bSortable": false},
             {"bSortable": false},
               {"bSortable": false},
                 {"bSortable": false},
                   {"bSortable": false},
                     {"bSortable": false},
                       {"bSortable": false},
                         {"bSortable": false},
                           {"bSortable": false},
                             {"bSortable": false},
                               {"bSortable": false},
                                 {"bSortable": false},
                                   {"bSortable": false},
                                     {"bSortable": false},
                                       {"bSortable": false},
                                         {"bSortable": false},
                                           {"bSortable": false},
                                             {"bSortable": false},
                                               {"bSortable": false},
                                                 {"bSortable": false},
                                                   {"bSortable": false},
                                                     {"bSortable": false},
                                                       {"bSortable": false},
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

<script>
$('#center').change(function(){

        //alert('dg');
       var center = document.getElementById('center').value; 
      
       var msg = '--- Select Course ---';
        $("#Course").html('');
       $.ajax  ({
                    url: "{{url::to('GetNominatedCourses')}}",
                    data: { center: center},
                    dataType: "json", 
                    success: function(result) {

                        //alert(result);
                        $("#Course").append("<option value=''>" + msg + "</option>");
                         $.each(result, function(i, item)
                        {



                            $("#Course").append("<option value=" + item.CS_ID + ">" + item.CourseCode + " (" + item.CourseName + ")</option>");



                        });
                                        
                        
                        }


                    
                });
        


       
    });
  


    $('#upload').click(function()
    {
      
        var CS_ID = $("#CS_ID").val(); 
      // alert(CS_ID);
      
            $.ajax
                    ({
                        beforeSend: function()
                        {
                            
                            document.getElementById('img4').innerHTML = "<img src=\"{{Url('assets/images/abc.gif')}}\"/>";
                        },
                        type: "POST",
                        url: "{{Url('PrintAssessorAssignedLetter')}}",
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
    


</script>
